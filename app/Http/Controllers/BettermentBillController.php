<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use NumberFormatter;

class BettermentBillController extends Controller
{
    /**
     * Calculate betterment charges without saving
     */
    public function calculate(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'property_value' => 'required|numeric',
            'betterment_rate' => 'required|numeric',
            'land_size' => 'nullable|numeric',
            'land_size_factor' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Parse values and calculate betterment charges
            $propertyValue = $request->input('property_value');
            $bettermentRate = $request->input('betterment_rate') / 100; // Convert percentage to decimal
            $landSizeFactor = $request->input('land_size_factor', 1.0); // Default to 1.0 if not provided
            
            // Calculate betterment charges using the new formula
            $bettermentCharges = $propertyValue * $bettermentRate * $landSizeFactor;
            
            return response()->json([
                'success' => true,
                'betterment_charges' => number_format($bettermentCharges, 2),
                'betterment_charges_raw' => $bettermentCharges,
                'land_size_factor' => $landSizeFactor
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error calculating betterment charges: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'application_id' => 'nullable',
            'property_value' => 'required|numeric',
            'betterment_rate' => 'required|numeric',
            'ref_id' => 'required',
            'Sectional_Title_File_No' => 'required',
            'sub_application_id' => 'nullable'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Parse values and calculate betterment charges
            $propertyValue = $request->input('property_value');
            $bettermentRate = $request->input('betterment_rate') / 100; // Convert percentage to decimal
            $landSize = $request->input('land_size');
            
            // Calculate land size factor
            $landSizeFactor = $this->calculateLandSizeFactor($landSize);
            
            // Calculate betterment charges with the new formula
            $bettermentCharges = $propertyValue * $bettermentRate * $landSizeFactor;
            
            // Check if a betterment bill already exists for this application
            $existingBill = DB::connection('sqlsrv')
                ->table('billing')
                ->where('application_id', $request->input('application_id'))
                ->orWhere('sub_application_id', $request->input('sub_application_id'))
                ->first();
                
            if ($existingBill) {
                // Update existing bill
                DB::connection('sqlsrv')
                    ->table('billing')
                    ->where('application_id', $request->input('application_id'))
                    ->orWhere('sub_application_id', $request->input('sub_application_id'))
                    ->update([
                        'property_value' => $propertyValue,
                        'betterment_rate' => $request->input('betterment_rate'),
                        'Betterment_Charges' => $bettermentCharges,
                        'ref_id' => $request->input('ref_id'),
                        'Sectional_Title_File_No' => $request->input('Sectional_Title_File_No'),
                        'sub_application_id' => $request->input('sub_application_id'),
                        'updated_at' => now()
                    ]);
                
                $message = 'Betterment bill updated successfully';
            } else {
                // Insert new bill
                DB::connection('sqlsrv')
                    ->table('billing')
                    ->insert([
                        'application_id' => $request->input('application_id'),
                        'property_value' => $propertyValue,
                        'betterment_rate' => $request->input('betterment_rate'),
                        'Betterment_Charges' => $bettermentCharges,
                        'ref_id' => $request->input('ref_id'),
                        'Sectional_Title_File_No' => $request->input('Sectional_Title_File_No'),
                        'sub_application_id' => $request->input('sub_application_id'),
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                
                $message = 'Betterment bill created successfully';
            }
            
            return response()->json([
                'success' => true,
                'message' => $message,
                'betterment_charges' => number_format($bettermentCharges, 2),
                'ref_id' => $request->input('ref_id')
            ]);
        } catch (\Exception $e) {
            \Log::error('Error calculating betterment bill: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error processing betterment bill: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Calculate land size factor based on the land size
     */
    private function calculateLandSizeFactor($landSize)
    {
        // This should match the JavaScript calculation for consistency
        $size = floatval($landSize);
        
        if ($size <= 500) return 0.8;       // Small land plots
        else if ($size <= 1000) return 1.0; // Medium land plots
        else if ($size <= 2000) return 1.2; // Large land plots
        else return 1.5;                    // Very large land plots
    }

    public function show($id)
    {
        try {
            $bettermentBill = DB::connection('sqlsrv')
                ->table('billing')
                ->where('application_id', $id)
                ->orWhere('sub_application_id', $id)
                ->first();
                
            if (!$bettermentBill) {
                return response()->json([
                    'success' => false,
                    'message' => 'Betterment bill not found'
                ], 404);
            }
            
            // Get application details for the receipt
            $application = DB::connection('sqlsrv')
                ->table('mother_applications')
                ->where('id', $id)
                ->first();
                
            // If not found in mother_applications, check in subapplications
            if (!$application) {
                $application = DB::connection('sqlsrv')
                    ->table('subapplications')
                    ->where('id', $id)
                    ->first();
            }
                
            return response()->json([
                'success' => true,
                'bill' => $bettermentBill,
                'application' => $application
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving betterment bill: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate a printable receipt for the betterment bill
     */
    public function printReceipt($id)
    {
        try {
            // Get the application
            // Check in mother_applications first
            $application = DB::connection('sqlsrv')
                ->table('mother_applications')
                ->where('id', $id)
                ->first();
                
            // If not found in mother_applications, check in subapplications
            if (!$application) {
                $application = DB::connection('sqlsrv')
                    ->table('subapplications as s')
                    ->leftJoin('mother_applications as m', 's.main_application_id', '=', 'm.id')
                    ->where('s.id', $id)
                    ->select(
                        's.*',
                        'm.property_house_no',
                        'm.property_plot_no',
                        'm.property_street_name',
                        'm.property_district',
                        'm.property_lga',
                        'm.property_state'
                    )
                    ->first();
            }
               
            if (!$application) {
                return response()->json([
                    'success' => false,
                    'message' => 'Application not found'
                ], 404);
            }
            
            // Get the betterment bill
            $bill = DB::connection('sqlsrv')
                ->table('billing')
                ->where('application_id', $id)
                ->orWhere('sub_application_id', $id)
                ->first();
                
            if (!$bill) {
                return redirect()->back()->with('error', 'Betterment bill not found');
            }
            
            // Return the print view
            return view('components.print_betterment', compact('application', 'bill'));
        } catch (\Exception $e) {
            \Log::error('Error printing betterment bill: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error generating print view');
        }
    }
}
