<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PrimaryActionsController extends Controller
{
    // Fetch application by ID (for payment modal)
    public function show($id)
    {
        // Use the DB facade to query the 'mother_applications' table (adjust table name if needed)
        $application = DB::connection('sqlsrv')->table('mother_applications')
            ->where('id', $id)
            ->first();

        if (!$application) {
            return response()->json(['error' => 'Application not found'], 404);
        }
        return response()->json($application);
    }


    public function store(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'application_id' => 'required|integer',
                'fileno' => 'required|string|max:255',
                // Survey personnel information
                'survey_by' => 'required|string|max:255',
                'survey_by_date' => 'required|date',
                'drawn_by' => 'required|string|max:255',
                'drawn_by_date' => 'required|date',
                'checked_by' => 'required|string|max:255',
                'checked_by_date' => 'required|date',
                'approved_by' => 'required|string|max:255',
                'approved_by_date' => 'required|date',
                // Property Identification
                'plot_no' => 'nullable|string|max:255',
                'block_no' => 'nullable|string|max:255',
                'approved_plan_no' => 'nullable|string|max:255',
                'tp_plan_no' => 'nullable|string|max:255',
                // Beacon Control Information
                'beacon_control_name' => 'nullable|string|max:255',
                'Control_Beacon_Coordinate_X' => 'nullable|string|max:255',
                'Control_Beacon_Coordinate_Y' => 'nullable|string|max:255',
                // Sheet Information
                'Metric_Sheet_Index' => 'nullable|string|max:255',
                'Metric_Sheet_No' => 'nullable|string|max:255',
                'Imperial_Sheet' => 'nullable|string|max:255',
                'Imperial_Sheet_No' => 'nullable|string|max:255',
                // Location Information
                'layout_name' => 'nullable|string|max:255',
                'district_name' => 'nullable|string|max:255',
                'lga_name' => 'nullable|string|max:255',
            ]);

            // Insert the data into the database
            DB::connection('sqlsrv')->table('surveyCadastralRecord')->insert($validatedData);

            // Return JSON response for AJAX
            return response()->json([
                'success' => true,
                'message' => 'Survey submitted successfully!'
            ]);
        } catch (\Exception $e) {
            // Return JSON error response
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 422);
        }
    }

    public function storeDeeds(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'application_id' => 'required|integer',
                'serial_no' => 'required|string|max:255',
                'page_no' => 'required|string|max:255',
                'volume_no' => 'required|string|max:255',
                'deeds_time' => 'required',
                'deeds_date' => 'required|date',
            ]);

            // Get the owner_fullname from mother_applications table
            $motherApplication = DB::connection('sqlsrv')->table('mother_applications')
                ->where('id', $request->application_id)
                ->first();

            if (!$motherApplication) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mother application not found!'
                ], 404);
            }

            // Add the Applicant_Name from mother_applications
            $validatedData['Applicant_Name'] = $motherApplication->owner_fullname;

            // Insert the data into the database
            DB::connection('sqlsrv')->table('landAdministration')->insert($validatedData);

            // Return JSON response for AJAX
            return response()->json([
                'success' => true,
                'message' => 'Deeds submitted successfully!'
            ]);
        } catch (\Exception $e) {
            // Return JSON error response
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 422);
        }
    }

    /**
     * Update planning recommendation status for a mother application
     */
    public function updatePlanningRecommendation(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'application_id' => 'required|integer',
            'status' => 'required|string|in:approve,decline',
            'approval_date' => 'required|date',
            'comments' => 'nullable|string',
        ]);

        try {
            // Map 'approve/decline' to database values
            $status = ($validatedData['status'] === 'approve') ? 'Approved' : 'Declined';

            // Update the mother application record
            $updated = DB::connection('sqlsrv')->table('mother_applications')
                ->where('id', $validatedData['application_id'])
                ->update([
                    'planning_recommendation_status' => $status,
                    'planning_approval_date' => $validatedData['approval_date'],
                    'recomm_comments' => $validatedData['comments'] ?? null,
                    'updated_at' => now()
                ]);

            if ($updated) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'message' => 'Failed to update record or record not found']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update director's approval status for a mother application
     */
    public function updateDirectorApproval(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'application_id' => 'required|integer',
            'status' => 'required|string|in:approve,decline',
            'approval_date' => 'required|date',
            'comments' => 'nullable|string',
        ]);

        try {
            // Map 'approve/decline' to database values
            $status = ($validatedData['status'] === 'approve') ? 'Approved' : 'Declined';

            // Update the mother application record
            $updated = DB::connection('sqlsrv')->table('mother_applications')
                ->where('id', $validatedData['application_id'])
                ->update([
                    'application_status' => $status,
                    'approval_date' => $validatedData['approval_date'],
                    'director_comments' => $validatedData['comments'] ?? null,
                    'updated_at' => now()
                ]);

            if ($updated) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'message' => 'Failed to update record or record not found']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Get conveyance data for an application
     */
    public function getConveyance($applicationId)
    {
        try {
            // Query the buyer_list table instead of relying on the JSON field
            $records = DB::connection('sqlsrv')
                ->table('buyer_list')
                ->where('application_id', $applicationId)
                ->select('id', 'buyer_title', 'buyer_name', 'unit_no', 'unit_measurement_id')
                ->get()
                ->toArray();

            return response()->json([
                'success' => true,
                'records' => $records
            ]);
        } catch (\Exception $e) {
            Log::error('Error retrieving buyers: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update conveyance data for an application
     */
    public function updateConveyance(Request $request)
    {
        try {
            $validated = $request->validate([
                'application_id'       => 'required|integer',
                'records'              => 'required|array',
                'records.*.buyerName'  => 'required|string',
                'records.*.sectionNo'  => 'required|string',
                'records.*.buyerTitle' => 'nullable|string',
            ]);

            $applicationId = $validated['application_id'];

            // Process each record
            foreach ($validated['records'] as $record) {
                // Check if this buyer already exists (by buyer name and unit no)
                $existing = DB::connection('sqlsrv')
                    ->table('buyer_list')
                    ->where('application_id', $applicationId)
                    ->where('buyer_name', $record['buyerName'])
                    ->where('unit_no', $record['sectionNo'])
                    ->first();

                if (!$existing) {
                    // Insert new record
                    DB::connection('sqlsrv')->table('buyer_list')->insert([
                        'application_id' => $applicationId,
                        'buyer_title' => $record['buyerTitle'] ?? '',
                        'buyer_name' => $record['buyerName'],
                        'unit_no' => $record['sectionNo'],
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }

            // Get updated records list for response
            $updatedRecords = DB::connection('sqlsrv')
                ->table('buyer_list')
                ->where('application_id', $applicationId)
                ->select('id', 'buyer_title', 'buyer_name', 'unit_no', 'unit_measurement_id')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Conveyance data updated successfully',
                'records' => $updatedRecords
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating buyers: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add a single buyer to the conveyance data
     */
    public function addBuyer(Request $request)
    {
        try {
            $validated = $request->validate([
                'application_id' => 'required|integer',
                'records' => 'required|array|min:1',
                'records.*.buyerName' => 'required|string',
                'records.*.sectionNo' => 'required|string',
                'records.*.buyerTitle' => 'nullable|string',
            ]);

            $applicationId = $validated['application_id'];
            $insertedCount = 0;

            // Process each buyer
            foreach ($validated['records'] as $record) {
                // Check if this buyer already exists
                $exists = DB::connection('sqlsrv')
                    ->table('buyer_list')
                    ->where('application_id', $applicationId)
                    ->where('buyer_name', $record['buyerName'])
                    ->where('unit_no', $record['sectionNo'])
                    ->exists();

                if (!$exists) {
                    // Insert the new buyer
                    DB::connection('sqlsrv')->table('buyer_list')->insert([
                        'application_id' => $applicationId,
                        'buyer_title' => $record['buyerTitle'] ?? '',
                        'buyer_name' => $record['buyerName'],
                        'unit_no' => $record['sectionNo'],
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                    
                    $insertedCount++;
                }
            }

            // Get all records for the response
            $allRecords = DB::connection('sqlsrv')
                ->table('buyer_list')
                ->where('application_id', $applicationId)
                ->select('id', 'buyer_title', 'buyer_name', 'unit_no', 'unit_measurement_id')
                ->get();

            return response()->json([
                'success' => true,
                'message' => "Buyers added successfully ($insertedCount new, " . 
                             (count($validated['records']) - $insertedCount) . " duplicates skipped)",
                'records' => $allRecords
            ]);
        } catch (\Exception $e) {
            Log::error('Error adding buyers: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a buyer from the conveyance data
     */
    public function deleteBuyer(Request $request)
    {
        try {
            $validated = $request->validate([
                'application_id' => 'required|integer',
                'buyer_id'       => 'required|integer',
            ]);

            // Delete the buyer record
            $deleted = DB::connection('sqlsrv')
                ->table('buyer_list')
                ->where('id', $validated['buyer_id'])
                ->where('application_id', $validated['application_id'])
                ->delete();

            if (!$deleted) {
                return response()->json([
                    'success' => false,
                    'message' => 'Buyer not found'
                ], 404);
            }

            // Get remaining records
            $records = DB::connection('sqlsrv')
                ->table('buyer_list')
                ->where('application_id', $validated['application_id'])
                ->select('id', 'buyer_title', 'buyer_name', 'unit_no', 'unit_measurement_id')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Buyer deleted successfully',
                'records' => $records
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting buyer: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Finalize the conveyance agreement for an application
     */
    public function finalizeConveyance(Request $request)
    {
        try {
            $validated = $request->validate([
                'application_id' => 'required|integer',
                'status' => 'required|string|in:completed,pending',
            ]);

            // Check if the application has buyers
            $buyersCount = DB::connection('sqlsrv')
                ->table('buyer_list')
                ->where('application_id', $validated['application_id'])
                ->count();

            if ($buyersCount === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please add at least one buyer before finalizing the conveyance agreement'
                ]);
            }

            // Update the application status
            $updated = DB::connection('sqlsrv')
                ->table('mother_applications')
                ->where('id', $validated['application_id'])
                ->update([
                    'conveyance_status' => $validated['status'],
                    'conveyance_date' => now(),
                    'updated_at' => now()
                ]);

            if ($updated) {
                return response()->json([
                    'success' => true,
                    'message' => 'Final Conveyance Agreement submitted successfully'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to update record or record not found'
            ]);
        } catch (\Exception $e) {
            Log::error('Error finalizing conveyance: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the final conveyance view for an application
     */
    public function finalConveyance($id)
    {
        $application = DB::connection('sqlsrv')->table('mother_applications')
            ->where('id', $id)
            ->first();

        if (!$application) {
            return redirect()->back()->with('error', 'Application not found');
        }

        return view('actions.final_conveyance', [
            'application' => $application
        ]);
    }


    public function BuyersList($id)
    {
        $application = DB::connection('sqlsrv')->table('mother_applications')
            ->where('id', $id)
            ->first();

        if (!$application) {
            return redirect()->back()->with('error', 'Application not found');
        }

        return view('actions.buyers_list', [
            'application' => $application
        ]);
    }

    /**
     * Render the buyers list template with provided data
     */
    public function renderBuyersList(Request $request)
    {
        $data = $request->validate([
            'PrimaryApplication' => 'required|array',
            'conveyanceData' => 'present|array'
        ]);

        // Create a proper object from the array
        $primaryApplication = (object)$data['PrimaryApplication'];

        // Convert the conveyance data to the format expected by the template
        if (isset($data['conveyanceData']) && !empty($data['conveyanceData'])) {
            $primaryApplication->conveyance = json_encode(['records' => $data['conveyanceData']]);
        }

        return view('sectionaltitling.action_modals.buyers_list', [
            'PrimaryApplication' => $primaryApplication
        ])->render();
    }

    /**
     * Get survey data for an application
     */
    public function getSurvey($applicationId)
    {
        try {
            $survey = DB::connection('sqlsrv')
                ->table('surveyCadastralRecord')
                ->where(function ($query) use ($applicationId) {
                    $query->where('application_id', $applicationId)
                        ->orWhere('sub_application_id', $applicationId);
                })
                ->first();

            if (!$survey) {
                return response()->json([
                    'success' => false,
                    'message' => 'No survey record found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'survey' => $survey
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update an existing survey record
     */
    public function updateSurvey(Request $request)
    {
        try {
            // Validate the request data - same validation as in store method

            // Check if the URL contains 'sub-actions' and adjust the application_id accordingly
            $applicationIdField = $request->is('*/sub-actions/*') ? 'sub_application_id' : 'application_id';

            // Validate the request data
            $validatedData = $request->validate([
                $applicationIdField => 'nullable',
                'fileno' => 'required|string|max:255',
                // Survey personnel information
                'survey_by' => 'required|string|max:255',
                'survey_by_date' => 'required|date',
                'drawn_by' => 'required|string|max:255',
                'drawn_by_date' => 'required|date',
                'checked_by' => 'required|string|max:255',
                'checked_by_date' => 'required|date',
                'approved_by' => 'required|string|max:255',
                'approved_by_date' => 'required|date',
                // Property Identification
                'plot_no' => 'nullable|string|max:255',
                'block_no' => 'nullable|string|max:255',
                'approved_plan_no' => 'nullable|string|max:255',
                'tp_plan_no' => 'nullable|string|max:255',
                // Beacon Control Information
                'beacon_control_name' => 'nullable|string|max:255',
                'Control_Beacon_Coordinate_X' => 'nullable|string|max:255',
                'Control_Beacon_Coordinate_Y' => 'nullable|string|max:255',
                // Sheet Information
                'Metric_Sheet_Index' => 'nullable|string|max:255',
                'Metric_Sheet_No' => 'nullable|string|max:255',
                'Imperial_Sheet' => 'nullable|string|max:255',
                'Imperial_Sheet_No' => 'nullable|string|max:255',
                // Location Information
                'layout_name' => 'nullable|string|max:255',
                'district_name' => 'nullable|string|max:255',
                'lga_name' => 'nullable|string|max:255',
            ]);

            // Update the record in the database
            $updated = DB::connection('sqlsrv')
                ->table('surveyCadastralRecord')
                ->where(function ($query) use ($validatedData) {
                    $query->where('application_id', $validatedData['application_id'] ?? null)
                        ->orWhere('sub_application_id', $validatedData['sub_application_id'] ?? null);
                })
                ->update($validatedData);

            if (!$updated) {
                return response()->json([
                    'success' => false,
                    'message' => 'Survey record not found or no changes made'
                ], 404);
            }

            // Return JSON response for AJAX
            return response()->json([
                'success' => true,
                'message' => 'Survey updated successfully!'
            ]);
        } catch (\Exception $e) {
            // Log the error message
            \Log::error('Survey update error: ' . $e->getMessage());

            // Return JSON error response
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 422);
        }
    }

    /**
     * Update a single buyer
     */
    public function updateSingleBuyer(Request $request)
    {
        try {
            $validated = $request->validate([
                'application_id' => 'required|integer',
                'buyer_id'       => 'required|integer',
                'buyer_title'    => 'nullable|string',
                'buyer_name'     => 'required|string',
                'unit_no'        => 'required|string',
            ]);

            // Update the buyer record
            $updated = DB::connection('sqlsrv')
                ->table('buyer_list')
                ->where('id', $validated['buyer_id'])
                ->where('application_id', $validated['application_id'])
                ->update([
                    'buyer_title' => $validated['buyer_title'],
                    'buyer_name'  => $validated['buyer_name'],
                    'unit_no'     => $validated['unit_no'],
                    'updated_at'  => now()
                ]);

            if (!$updated) {
                return response()->json([
                    'success' => false,
                    'message' => 'Buyer not found or no changes made'
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Buyer information updated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating buyer: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
