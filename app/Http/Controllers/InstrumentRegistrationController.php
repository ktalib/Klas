<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class InstrumentRegistrationController extends Controller
{
    private function getApplication($id)
    {
        $application = DB::connection('sqlsrv')->table('mother_applications')
            ->where('id', $id)
            ->first();

        if (!$application) {
            return response()->json(['error' => 'Application not found'], 404);
        }

        return $application;
    }
    
    private function generateSTMReference()
    {
        $year = date('Y');
        $latestRef = DB::connection('sqlsrv')->table('registered_instruments')
            ->where('STM_Ref', 'like', "STM-$year-%")
            ->orderBy('id', 'desc')
            ->value('STM_Ref');
        
        if ($latestRef) {
            $matches = [];
            if (preg_match('/STM-\\d{4}-(\\d{4})/', $latestRef, $matches)) {
                $sequence = (int)$matches[1] + 1;
            } else {
                $sequence = 1;
            }
        } else {
            $sequence = 1;
        }
        
        return "STM-{$year}-" . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    public function InstrumentRegistration()
    {
        $PageTitle = 'Instrument Registration ';
        $PageDescription = '';

        try {
            // Initialize default completion status for subapplications that don't have it set
            $this->initializeDefaultCompletionStatus();
            
            // Get approved subapplications and create both ST Assignment and Sectional Titling records for each
            // Note: We now show ALL approved subapplications regardless of deeds_status because we track 
            // individual instrument status in the deeds_completion_status JSON field
            $approvedSubapplications = DB::connection('sqlsrv')->table('subapplications as s')
                ->leftJoin('mother_applications as m', 's.main_application_id', '=', 'm.id')
                ->leftJoin('users', 's.created_by', '=', 'users.id')
                ->where('s.planning_recommendation_status', 'Approved')
                ->where('s.application_status', 'Approved')
                ->select(
                    's.id',
                    's.fileno',
                    's.deeds_completion_status',
                    DB::raw("CONCAT(COALESCE(s.applicant_title,''), ' ', COALESCE(s.first_name,''), ' ', COALESCE(s.middle_name,''), ' ', COALESCE(s.surname,''), COALESCE(s.corporate_name,''), COALESCE(s.rc_number,''), COALESCE(s.multiple_owners_names,'')) as sub_applicant"),
                    DB::raw("CONCAT(COALESCE(m.applicant_title,''), ' ', COALESCE(m.first_name,''), ' ', COALESCE(m.middle_name,''), ' ', COALESCE(m.surname,''), COALESCE(m.corporate_name,''), COALESCE(m.rc_number,''), COALESCE(m.multiple_owners_names,'')) as mother_applicant"),
                    'm.property_lga as lga',
                    'm.property_district as district',
                    'm.plot_size as size',
                    'm.property_plot_no as plotNumber',
                    's.created_by as reg_created_by',
                    's.created_at',
                    DB::raw("CONCAT(COALESCE(users.first_name, ''), ' ', COALESCE(users.last_name, '')) as reg_creator_name")
                )
                ->get();

            // Create collection for all instruments
            $allInstruments = collect();

            // For each approved subapplication, create both ST Assignment and Sectional Titling records
            foreach ($approvedSubapplications as $subApp) {
                // Parse completion status to determine current status of each instrument
                $completionStatus = null;
                $stAssignmentStatus = 'pending';
                $sectionalTitlingStatus = 'pending';
                $stAssignmentSerialNo = null;
                $sectionalTitlingSerialNo = null;
                $stAssignmentSTMRef = null;
                $sectionalTitlingSTMRef = null;
                $stAssignmentDate = null;
                $sectionalTitlingDate = null;
                
                if (!empty($subApp->deeds_completion_status)) {
                    $completionStatus = json_decode($subApp->deeds_completion_status, true);
                    if ($completionStatus && isset($completionStatus['instruments'])) {
                        foreach ($completionStatus['instruments'] as $instrument) {
                            if ($instrument['name'] === 'ST Assignment (Transfer of Title)') {
                                $stAssignmentStatus = strtolower($instrument['status']) === 'registered' ? 'registered' : 'pending';
                            } elseif ($instrument['name'] === 'Sectional Titling CofO') {
                                $sectionalTitlingStatus = strtolower($instrument['status']) === 'registered' ? 'registered' : 'pending';
                            }
                        }
                    }
                }

                // If status is registered, get the registration details from registered_instruments table
                if ($stAssignmentStatus === 'registered') {
                    $stRegistration = DB::connection('sqlsrv')->table('registered_instruments')
                        ->where('StFileNo', $subApp->fileno)
                        ->where('instrument_type', 'ST Assignment (Transfer of Title)')
                        ->where('status', 'registered')
                        ->first();
                    
                    if ($stRegistration) {
                        $stAssignmentSerialNo = $stRegistration->particularsRegistrationNumber;
                        $stAssignmentSTMRef = $stRegistration->STM_Ref;
                        $stAssignmentDate = $stRegistration->instrumentDate;
                    }
                }

                if ($sectionalTitlingStatus === 'registered') {
                    $sectionalRegistration = DB::connection('sqlsrv')->table('registered_instruments')
                        ->where('StFileNo', $subApp->fileno)
                        ->where('instrument_type', 'Sectional Titling CofO')
                        ->where('status', 'registered')
                        ->first();
                    
                    if ($sectionalRegistration) {
                        $sectionalTitlingSerialNo = $sectionalRegistration->particularsRegistrationNumber;
                        $sectionalTitlingSTMRef = $sectionalRegistration->STM_Ref;
                        $sectionalTitlingDate = $sectionalRegistration->instrumentDate;
                    }
                }

                // Create ST Assignment (Transfer of Title) record
                $stAssignmentRecord = (object)[
                    'id' => $subApp->id . '_st_assignment',
                    'fileno' => $subApp->fileno,
                    'Deeds_Serial_No' => $stAssignmentSerialNo,
                    'instrument_type' => 'ST Assignment (Transfer of Title)',
                    'Grantor' => $subApp->mother_applicant,
                    'Grantee' => $subApp->sub_applicant,
                    'GrantorAddress' => '',
                    'GranteeAddress' => '',
                    'duration' => '',
                    'leasePeriod' => '',
                    'propertyDescription' => '',
                    'lga' => $subApp->lga,
                    'district' => $subApp->district,
                    'size' => $subApp->size,
                    'plotNumber' => $subApp->plotNumber,
                    'deeds_date' => $stAssignmentDate,
                    'solicitorName' => '',
                    'solicitorAddress' => '',
                    'status' => $stAssignmentStatus,
                    'land_use' => '',
                    'reg_created_by' => $subApp->reg_created_by,
                    'created_at' => $subApp->created_at,
                    'reg_creator_name' => $subApp->reg_creator_name,
                    'instrument_category' => 'ST Assignment',
                    'STM_Ref' => $stAssignmentSTMRef,
                    'original_subapp_id' => $subApp->id
                ];

                // Create Sectional Titling CofO record
                $sectionalRecord = (object)[
                    'id' => $subApp->id . '_sectional_cofo',
                    'fileno' => $subApp->fileno,
                    'Deeds_Serial_No' => $sectionalTitlingSerialNo,
                    'instrument_type' => 'Sectional Titling CofO',
                    'Grantor' => $subApp->mother_applicant,
                    'Grantee' => $subApp->sub_applicant,
                    'GrantorAddress' => '',
                    'GranteeAddress' => '',
                    'duration' => '',
                    'leasePeriod' => '',
                    'propertyDescription' => '',
                    'lga' => $subApp->lga,
                    'district' => $subApp->district,
                    'size' => $subApp->size,
                    'plotNumber' => $subApp->plotNumber,
                    'deeds_date' => $sectionalTitlingDate,
                    'solicitorName' => '',
                    'solicitorAddress' => '',
                    'status' => $sectionalTitlingStatus,
                    'land_use' => '',
                    'reg_created_by' => $subApp->reg_created_by,
                    'created_at' => $subApp->created_at,
                    'reg_creator_name' => $subApp->reg_creator_name,
                    'instrument_category' => 'Sectional Titling',
                    'STM_Ref' => $sectionalTitlingSTMRef,
                    'original_subapp_id' => $subApp->id
                ];

                $allInstruments->push($stAssignmentRecord);
                $allInstruments->push($sectionalRecord);
            }

            Log::info('Instrument Registration data loaded', [
                'approved_subapplications' => $approvedSubapplications->count(),
                'total_instruments' => $allInstruments->count(),
                'st_assignment_count' => $allInstruments->where('instrument_type', 'ST Assignment (Transfer of Title)')->count(),
                'sectional_titling_count' => $allInstruments->where('instrument_type', 'Sectional Titling CofO')->count()
            ]);

            // Count statuses
            $pendingCount = $allInstruments->where('status', 'pending')->count();
            $registeredCount = $allInstruments->where('status', 'registered')->count();
            $rejectedCount = 0; // No rejected status in this context
            $totalCount = $allInstruments->count();

            // Process property descriptions and durations
            foreach ($allInstruments as $application) {
                if (empty($application->propertyDescription)) {
                    $application->property_description = 
                        (!empty($application->district) ? $application->district . ', ' : '') .
                        (!empty($application->lga) ? $application->lga . ', ' : '') .
                        (!empty($application->state) ? $application->state : '');
                } else {
                    $application->property_description = $application->propertyDescription;
                }
                
                $application->duration = $application->duration ?? $application->leasePeriod ?? 'N/A';
            }

            Log::info('Final instrument counts', [
                'total_count' => $totalCount,
                'pending_count' => $pendingCount,
                'registered_count' => $registeredCount,
                'rejected_count' => $rejectedCount,
            ]);

            $approvedApplications = $allInstruments;
            
            return view('instrument_registration.index', compact(
                'approvedApplications',
                'PageTitle',
                'PageDescription',
                'pendingCount',
                'registeredCount',
                'rejectedCount',
                'totalCount'
            ));
            
        } catch (\Exception $e) {
            Log::error('Error in InstrumentRegistration method', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            $approvedApplications = collect();
            $pendingCount = $registeredCount = $rejectedCount = $totalCount = 0;
            
            return view('instrument_registration.index', compact(
                'approvedApplications',
                'PageTitle',
                'PageDescription',
                'pendingCount',
                'registeredCount',
                'rejectedCount',
                'totalCount'
            ))->with('error', 'Error loading instrument data: ' . $e->getMessage());
        }
    }

    public function view($id)
    {
        $PageTitle = 'View Instrument Registration';
        $PageDescription = '';
        
        try {
            $application = null;
            
            // Handle composite IDs for ST Assignment and Sectional Titling
            if (strpos($id, '_st_assignment') !== false || strpos($id, '_sectional_cofo') !== false) {
                $originalId = str_replace(['_st_assignment', '_sectional_cofo'], '', $id);
                $instrumentType = strpos($id, '_st_assignment') !== false ? 'ST Assignment (Transfer of Title)' : 'Sectional Titling CofO';
                
                // Get the subapplication details
                $subApplication = DB::connection('sqlsrv')->table('subapplications as s')
                    ->leftJoin('mother_applications as m', 's.main_application_id', '=', 'm.id')
                    ->leftJoin('users', 's.created_by', '=', 'users.id')
                    ->where('s.id', $originalId)
                    ->select(
                        's.*',
                        DB::raw("CONCAT(COALESCE(s.applicant_title,''), ' ', COALESCE(s.first_name,''), ' ', COALESCE(s.surname,''), COALESCE(s.corporate_name,''), COALESCE(s.multiple_owners_names,'')) as sub_applicant"),
                        'm.property_lga as lga',
                        'm.property_district as district',
                        'm.plot_size as size',
                        'm.property_plot_no as plotNumber',
                        DB::raw("CONCAT(COALESCE(users.first_name, ''), ' ', COALESCE(users.last_name, '')) as reg_creator_name")
                    )
                    ->first();
                
                if (!$subApplication) {
                    Log::error('Subapplication not found', ['id' => $originalId]);
                    return redirect()->route('instrument_registration.index')->with('error', 'Instrument not found');
                }
                
                // Check if this instrument is registered and get registration details
                $registeredInstrument = DB::connection('sqlsrv')->table('registered_instruments')
                    ->leftJoin('users', 'registered_instruments.created_by', '=', 'users.id')
                    ->where('registered_instruments.StFileNo', $subApplication->fileno)
                    ->where('registered_instruments.instrument_type', $instrumentType)
                    ->where('registered_instruments.status', 'registered')
                    ->select(
                        'registered_instruments.*',
                        DB::raw("CONCAT(COALESCE(users.first_name, ''), ' ', COALESCE(users.last_name, '')) as reg_creator_name")
                    )
                    ->first();
                
                // Create a combined application object
                $application = (object)[
                    'id' => $id,
                    'fileno' => $subApplication->fileno,
                    'instrument_type' => $instrumentType,
                    'Grantor' => $subApplication->sub_applicant,
                    'Grantee' => $subApplication->sub_applicant,
                    'Applicant_Name' => $subApplication->sub_applicant,
                    'lga' => $subApplication->lga,
                    'district' => $subApplication->district,
                    'size' => $subApplication->size,
                    'plotNumber' => $subApplication->plotNumber,
                    'reg_creator_name' => $subApplication->reg_creator_name,
                    'created_at' => $subApplication->created_at,
                    'updated_at' => $subApplication->updated_at ?? $subApplication->created_at,
                    'source_type' => 'subapplication',
                    // Registration details if available
                    'particularsRegistrationNumber' => $registeredInstrument->particularsRegistrationNumber ?? null,
                    'Deeds_Serial_No' => $registeredInstrument->particularsRegistrationNumber ?? null,
                    'STM_Ref' => $registeredInstrument->STM_Ref ?? null,
                    'instrumentDate' => $registeredInstrument->instrumentDate ?? null,
                    'deeds_date' => $registeredInstrument->deeds_date ?? $registeredInstrument->instrumentDate ?? null,
                    'deeds_time' => $registeredInstrument->deeds_time ?? null,
                    'status' => $registeredInstrument ? 'registered' : 'pending',
                    'reg_status' => $registeredInstrument ? 'registered' : 'pending',
                    'propertyDescription' => $registeredInstrument->propertyDescription ?? '',
                    'GrantorAddress' => $registeredInstrument->GrantorAddress ?? '',
                    'GranteeAddress' => $registeredInstrument->GranteeAddress ?? '',
                    'duration' => $registeredInstrument->duration ?? '',
                    'solicitorName' => $registeredInstrument->solicitorName ?? '',
                    'solicitorAddress' => $registeredInstrument->solicitorAddress ?? '',
                    // Additional properties that might be referenced in the view
                    'Tenure_Period' => $registeredInstrument->Tenure_Period ?? null,
                    'serial_no' => $registeredInstrument->serial_no ?? null,
                    'page_no' => $registeredInstrument->page_no ?? null,
                    'reg_page_no' => $registeredInstrument->page_no ?? null,
                    'volume_no' => $registeredInstrument->volume_no ?? null,
                    'Occupation' => $subApplication->occupation ?? null,
                    'NoOfUnits' => null,
                    'NoOfBlocks' => null,
                    'NoOfSections' => null,
                    'property_street_name' => null,
                    'property_district' => $subApplication->district,
                    'property_lga' => $subApplication->lga,
                    'land_use' => null,
                    'commercial_type' => null,
                    'industrial_type' => null,
                    'residential_type' => null
                ];
                
            } else {
                // Regular registered instrument ID
                $application = DB::connection('sqlsrv')
                    ->table('registered_instruments')
                    ->leftJoin('users', 'registered_instruments.created_by', '=', 'users.id')
                    ->select(
                        'registered_instruments.*',
                        DB::raw("CONCAT(COALESCE(users.first_name, ''), ' ', COALESCE(users.last_name, '')) as reg_creator_name")
                    )
                    ->where('registered_instruments.id', $id)
                    ->first();
                
                if ($application) {
                    $application->source_type = 'registered_instruments';
                    $application->fileno = $application->MLSFileNo ?? $application->KAGISFileNO ?? $application->NewKANGISFileNo ?? $application->StFileNo;
                    // Ensure all required properties exist
                    $application->Deeds_Serial_No = $application->particularsRegistrationNumber ?? null;
                    $application->reg_status = $application->status ?? 'pending';
                    $application->Applicant_Name = $application->Grantor ?? $application->Grantee ?? 'N/A';
                    $application->reg_page_no = $application->page_no ?? null;
                    $application->property_district = $application->district ?? null;
                    $application->property_lga = $application->lga ?? null;
                    // Set default values for properties that might not exist
                    $application->Tenure_Period = $application->Tenure_Period ?? null;
                    $application->Occupation = $application->Occupation ?? null;
                    $application->NoOfUnits = $application->NoOfUnits ?? null;
                    $application->NoOfBlocks = $application->NoOfBlocks ?? null;
                    $application->NoOfSections = $application->NoOfSections ?? null;
                    $application->property_street_name = $application->property_street_name ?? null;
                    $application->land_use = $application->land_use ?? null;
                    $application->commercial_type = $application->commercial_type ?? null;
                    $application->industrial_type = $application->industrial_type ?? null;
                    $application->residential_type = $application->residential_type ?? null;
                }
            }

            if (!$application) {
                Log::error('Instrument not found', ['id' => $id]);
                return redirect()->route('instrument_registration.index')->with('error', 'Instrument not found');
            }

            return view('instrument_registration.view', compact('application', 'PageTitle', 'PageDescription'));
        } catch (\Exception $e) {
            Log::error('Error in view method', [
                'id' => $id, 
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('instrument_registration.index')
                ->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    /**
     * Check registration status for ST Assignment and Sectional Titling CofO for a given file number
     */
    public function checkRegistrationStatus(Request $request)
    {
        try {
            $fileNo = $request->query('file_no');
            
            if (empty($fileNo)) {
                return response()->json([
                    'success' => false,
                    'error' => 'File number is required'
                ], 400);
            }

            $registrations = DB::connection('sqlsrv')->table('registered_instruments')
                ->where('StFileNo', $fileNo)
                ->whereIn('instrument_type', ['ST Assignment (Transfer of Title)', 'Sectional Titling CofO'])
                ->select('instrument_type', 'status', 'particularsRegistrationNumber', 'STM_Ref', 'created_at')
                ->get();

            $stAssignment = $registrations->firstWhere('instrument_type', 'ST Assignment (Transfer of Title)');
            $sectionalTitling = $registrations->firstWhere('instrument_type', 'Sectional Titling CofO');

            $response = [
                'success' => true,
                'file_no' => $fileNo,
                'st_assignment' => [
                    'registered' => !is_null($stAssignment),
                    'status' => $stAssignment->status ?? null,
                    'registration_number' => $stAssignment->particularsRegistrationNumber ?? null,
                    'stm_ref' => $stAssignment->STM_Ref ?? null,
                    'registered_date' => $stAssignment->created_at ?? null
                ],
                'sectional_titling' => [
                    'registered' => !is_null($sectionalTitling),
                    'status' => $sectionalTitling->status ?? null,
                    'registration_number' => $sectionalTitling->particularsRegistrationNumber ?? null,
                    'stm_ref' => $sectionalTitling->STM_Ref ?? null,
                    'registered_date' => $sectionalTitling->created_at ?? null
                ],
                'both_registered' => !is_null($stAssignment) && !is_null($sectionalTitling),
                'total_registrations' => $registrations->count()
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('Error checking registration status', [
                'file_no' => $request->query('file_no'),
                'exception' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Failed to check registration status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getNextSerialNumber()
    {
        try {
            $latest = DB::connection('sqlsrv')->table('registered_instruments')
                ->select('volume_no', 'page_no', 'serial_no')
                ->orderBy('volume_no', 'desc')
                ->orderBy('page_no', 'desc')
                ->first();
            
            if (!$latest) {
                return response()->json([
                    'serial_no' => 1,
                    'page_no' => 1,
                    'volume_no' => 1,
                    'deeds_serial_no' => '1/1/1'
                ]);
            }
            
            $volumeNo = $latest->volume_no; 
            $pageNo = $latest->page_no;
            $serialNo = $latest->serial_no;
            
            if ($pageNo >= 100) {
                $volumeNo++;
                $pageNo = 1;
                $serialNo = 1;
            } else {
                $pageNo++;
                $serialNo++;
            }
            
            $deedsSerialNo = "$serialNo/$pageNo/$volumeNo";
            
            return response()->json([
                'serial_no' => $serialNo,
                'page_no' => $pageNo,
                'volume_no' => $volumeNo,
                'deeds_serial_no' => $deedsSerialNo
            ]);
        } catch (\Exception $e) {
            Log::error('Error generating next serial number', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'error' => 'Failed to generate serial number: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getBatchData(Request $request)
    {
        try {
            $filter = $request->query('filter', 'batch');
            $data = collect();
            
            switch ($filter) {
                case 'other':
                    // Keep other instruments available for registration modals
                    $data = DB::connection('sqlsrv')->table('instrument_registration')
                        ->where(function ($q) {
                            $q->where('status', '!=', 'registered')
                              ->orWhereNull('status');
                        })
                        ->select(
                            'id', 
                            DB::raw("COALESCE(MLSFileNo, KAGISFileNO, NewKANGISFileNo) as fileno"), 
                            'instrument_type', 
                            'Grantor as grantor', 
                            'Grantee as grantee', 
                            'lga', 
                            'district', 
                            'size', 
                            'plotNumber', 
                            'created_at',
                            DB::raw("COALESCE(status, 'pending') as status"),
                            DB::raw("'Other Instruments' as source_type")
                        )
                        ->get();
                    break;
                    
                case 'stAssignment':
                    // ST Assignment from subapplications where both statuses are approved
                    // Only show PENDING ST Assignment instruments
                    $approvedSubapplications = DB::connection('sqlsrv')->table('subapplications as s')
                        ->leftJoin('mother_applications as m', 's.main_application_id', '=', 'm.id')
                        ->where('s.planning_recommendation_status', 'Approved')
                        ->where('s.application_status', 'Approved')
                        ->select(
                            's.id',
                            's.fileno',
                            's.deeds_completion_status',
                            DB::raw("CONCAT(COALESCE(s.applicant_title,''), ' ', COALESCE(s.first_name,''), ' ', COALESCE(s.surname,''), COALESCE(s.corporate_name,''), COALESCE(s.multiple_owners_names,'')) as sub_applicant"),
                            DB::raw("CONCAT(COALESCE(m.applicant_title,''), ' ', COALESCE(m.first_name,''), ' ', COALESCE(m.surname,''), COALESCE(m.corporate_name,''), COALESCE(m.multiple_owners_names,'')) as mother_applicant"),
                            'm.property_lga as lga', 
                            'm.property_district as district', 
                            'm.plot_size as size', 
                            'm.property_plot_no as plotNumber', 
                            's.created_at'
                        )
                        ->get();
                    
                    // Create ST Assignment records for each subapplication, but only if it's PENDING
                    $data = collect();
                    foreach ($approvedSubapplications as $subApp) {
                        // Check if ST Assignment is pending
                        $stAssignmentStatus = 'pending';
                        if (!empty($subApp->deeds_completion_status)) {
                            $completionStatus = json_decode($subApp->deeds_completion_status, true);
                            if ($completionStatus && isset($completionStatus['instruments'])) {
                                foreach ($completionStatus['instruments'] as $instrument) {
                                    if ($instrument['name'] === 'ST Assignment (Transfer of Title)') {
                                        $stAssignmentStatus = strtolower($instrument['status']) === 'registered' ? 'registered' : 'pending';
                                        break;
                                    }
                                }
                            }
                        }
                        
                        // Only add if it's pending
                        if ($stAssignmentStatus === 'pending') {
                            $data->push((object)[
                                'id' => $subApp->id . '_st_assignment',
                                'fileno' => $subApp->fileno,
                                'instrument_type' => 'ST Assignment (Transfer of Title)',
                                'grantor' => $subApp->mother_applicant,
                                'grantee' => $subApp->sub_applicant,
                                'lga' => $subApp->lga,
                                'district' => $subApp->district,
                                'size' => $subApp->size,
                                'plotNumber' => $subApp->plotNumber,
                                'created_at' => $subApp->created_at,
                                'status' => 'pending',
                                'source_type' => 'ST Assignment',
                                'original_subapp_id' => $subApp->id
                            ]);
                        }
                    }
                    break;
                    
                case 'regular':
                case 'sltr':
                    // Keep these available for other instrument types in modals
                    $data = collect([
                        (object)[
                            'id' => null,
                            'fileno' => 'No Record',
                            'grantor' => 'No Record',
                            'grantee' => 'No Record',
                            'lga' => 'No Record',
                            'district' => 'No Record',
                            'size' => 'No Record',
                            'plotNumber' => 'No Record',
                            'created_at' => null,
                            'status' => 'unavailable'
                        ]
                    ]);
                    break;
                    
                case 'sectional':
                    // Sectional Titling from subapplications where both statuses are approved
                    // Only show PENDING Sectional Titling instruments
                    $approvedSubapplications = DB::connection('sqlsrv')->table('subapplications as s')
                        ->leftJoin('mother_applications as m', 's.main_application_id', '=', 'm.id')
                        ->where('s.planning_recommendation_status', 'Approved')
                        ->where('s.application_status', 'Approved')
                        ->select(
                            's.id',
                            's.fileno',
                            's.deeds_completion_status',
                            DB::raw("CONCAT(COALESCE(s.applicant_title,''), ' ', COALESCE(s.first_name,''), ' ', COALESCE(s.surname,''), COALESCE(s.corporate_name,''), COALESCE(s.multiple_owners_names,'')) as sub_applicant"),
                            DB::raw("CONCAT(COALESCE(m.applicant_title,''), ' ', COALESCE(m.first_name,''), ' ', COALESCE(m.surname,''), COALESCE(m.corporate_name,''), COALESCE(m.multiple_owners_names,'')) as mother_applicant"),
                            'm.property_lga as lga', 
                            'm.property_district as district', 
                            'm.plot_size as size', 
                            'm.property_plot_no as plotNumber', 
                            's.created_at'
                        )
                        ->get();
                    
                    // Create Sectional Titling records for each subapplication, but only if it's PENDING
                    $data = collect();
                    foreach ($approvedSubapplications as $subApp) {
                        // Check if Sectional Titling is pending
                        $sectionalTitlingStatus = 'pending';
                        if (!empty($subApp->deeds_completion_status)) {
                            $completionStatus = json_decode($subApp->deeds_completion_status, true);
                            if ($completionStatus && isset($completionStatus['instruments'])) {
                                foreach ($completionStatus['instruments'] as $instrument) {
                                    if ($instrument['name'] === 'Sectional Titling CofO') {
                                        $sectionalTitlingStatus = strtolower($instrument['status']) === 'registered' ? 'registered' : 'pending';
                                        break;
                                    }
                                }
                            }
                        }
                        
                        // Only add if it's pending
                        if ($sectionalTitlingStatus === 'pending') {
                            $data->push((object)[
                                'id' => $subApp->id . '_sectional_cofo',
                                'fileno' => $subApp->fileno,
                                'instrument_type' => 'Sectional Titling CofO',
                                'grantor' => $subApp->mother_applicant,
                                'grantee' => $subApp->sub_applicant,
                                'lga' => $subApp->lga,
                                'district' => $subApp->district,
                                'size' => $subApp->size,
                                'plotNumber' => $subApp->plotNumber,
                                'created_at' => $subApp->created_at,
                                'status' => 'pending',
                                'source_type' => 'Sectional Titling',
                                'original_subapp_id' => $subApp->id
                            ]);
                        }
                    }
                    break;
                    
                case 'batch':
                default:
                    // For batch registration, include other instruments plus the two main types from subapplications
                    $instrumentData = DB::connection('sqlsrv')->table('instrument_registration')
                        ->where(function ($q) {
                            $q->where('status', '!=', 'registered')
                              ->orWhereNull('status');
                        })
                        ->select('id', DB::raw("COALESCE(MLSFileNo, KAGISFileNO, NewKANGISFileNo) as fileno"), 'instrument_type', 'Grantor as grantor', 'Grantee as grantee', 'lga', 'district', 'size', 'plotNumber', 'created_at', DB::raw("COALESCE(status, 'pending') as status"), DB::raw("'Other Instruments' as source_type"))->get();
                    
                    // Get approved subapplications
                    $approvedSubapplications = DB::connection('sqlsrv')->table('subapplications as s')
                        ->leftJoin('mother_applications as m', 's.main_application_id', '=', 'm.id')
                        ->where('s.planning_recommendation_status', 'Approved')
                        ->where('s.application_status', 'Approved')
                        ->select(
                            's.id',
                            's.fileno',
                            's.deeds_completion_status',
                            DB::raw("CONCAT(COALESCE(s.applicant_title,''), ' ', COALESCE(s.first_name,''), ' ', COALESCE(s.surname,''), COALESCE(s.corporate_name,''), COALESCE(s.multiple_owners_names,'')) as sub_applicant"),
                            DB::raw("CONCAT(COALESCE(m.applicant_title,''), ' ', COALESCE(m.first_name,''), ' ', COALESCE(m.surname,''), COALESCE(m.corporate_name,''), COALESCE(m.multiple_owners_names,'')) as mother_applicant"),
                            'm.property_lga as lga', 
                            'm.property_district as district', 
                            'm.plot_size as size', 
                            'm.property_plot_no as plotNumber', 
                            's.created_at'
                        )
                        ->get();
                    
                    // Create both ST Assignment and Sectional Titling records for each subapplication
                    // But only include PENDING instruments in the batch modal
                    $stAssignmentData = collect();
                    $subData = collect();
                    
                    foreach ($approvedSubapplications as $subApp) {
                        // Check completion status for both instruments
                        $stAssignmentStatus = 'pending';
                        $sectionalTitlingStatus = 'pending';
                        
                        if (!empty($subApp->deeds_completion_status)) {
                            $completionStatus = json_decode($subApp->deeds_completion_status, true);
                            if ($completionStatus && isset($completionStatus['instruments'])) {
                                foreach ($completionStatus['instruments'] as $instrument) {
                                    if ($instrument['name'] === 'ST Assignment (Transfer of Title)') {
                                        $stAssignmentStatus = strtolower($instrument['status']) === 'registered' ? 'registered' : 'pending';
                                    } elseif ($instrument['name'] === 'Sectional Titling CofO') {
                                        $sectionalTitlingStatus = strtolower($instrument['status']) === 'registered' ? 'registered' : 'pending';
                                    }
                                }
                            }
                        }
                        
                        // Only add ST Assignment if it's pending
                        if ($stAssignmentStatus === 'pending') {
                            $stAssignmentData->push((object)[
                                'id' => $subApp->id . '_st_assignment',
                                'fileno' => $subApp->fileno,
                                'instrument_type' => 'ST Assignment (Transfer of Title)',
                                'grantor' => $subApp->mother_applicant,
                                'grantee' => $subApp->sub_applicant,
                                'lga' => $subApp->lga,
                                'district' => $subApp->district,
                                'size' => $subApp->size,
                                'plotNumber' => $subApp->plotNumber,
                                'created_at' => $subApp->created_at,
                                'status' => 'pending',
                                'source_type' => 'ST Assignment',
                                'original_subapp_id' => $subApp->id
                            ]);
                        }
                        
                        // Only add Sectional Titling if it's pending
                        if ($sectionalTitlingStatus === 'pending') {
                            $subData->push((object)[
                                'id' => $subApp->id . '_sectional_cofo',
                                'fileno' => $subApp->fileno,
                                'instrument_type' => 'Sectional Titling CofO',
                                'grantor' => $subApp->mother_applicant,
                                'grantee' => $subApp->sub_applicant,
                                'lga' => $subApp->lga,
                                'district' => $subApp->district,
                                'size' => $subApp->size,
                                'plotNumber' => $subApp->plotNumber,
                                'created_at' => $subApp->created_at,
                                'status' => 'pending',
                                'source_type' => 'Sectional Titling',
                                'original_subapp_id' => $subApp->id
                            ]);
                        }
                    }
                    
                    $data = $instrumentData->merge($stAssignmentData)->merge($subData);
                    break;
            }
            
            return response()->json($data->values()->toArray());
            
        } catch (\Exception $e) {
            Log::error('Error in getBatchData', ['filter' => $request->query('filter'), 'exception' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Failed to fetch batch data: ' . $e->getMessage()], 500);
        }
    }

    public function registerSingle(Request $request)
    {
        try {
            // Validate ST Assignment and Sectional Titling CofO requirements
            $instrumentType = $request->instrument_type;
            if (in_array($instrumentType, ['ST Assignment (Transfer of Title)', 'Sectional Titling CofO'])) {
                // For these instrument types, we need to ensure both StFileNo and instrument type are properly validated
                $request->validate([
                    'instrument_type' => 'required|string',
                    'file_no' => 'required|string', // This will be used as StFileNo
                ], [
                    'instrument_type.required' => 'Instrument type is required for ST Assignment and Sectional Titling CofO',
                    'file_no.required' => 'File number (StFileNo) is required for ST Assignment and Sectional Titling CofO',
                ]);
                
                // Additional validation to ensure both types are registered for each application
                $fileNo = $request->file_no;
                $existingRegistrations = DB::connection('sqlsrv')->table('registered_instruments')
                    ->where('StFileNo', $fileNo)
                    ->whereIn('instrument_type', ['ST Assignment (Transfer of Title)', 'Sectional Titling CofO'])
                    ->pluck('instrument_type')
                    ->toArray();
                
                // Check if we're trying to register the same type twice for the same file
                if (in_array($instrumentType, $existingRegistrations)) {
                    return response()->json([
                        'success' => false, 
                        'error' => "A {$instrumentType} registration already exists for file number {$fileNo}"
                    ], 422);
                }
                
                // Log the registration attempt for tracking
                Log::info('ST/Sectional Titling registration attempt', [
                    'file_no' => $fileNo,
                    'instrument_type' => $instrumentType,
                    'existing_registrations' => $existingRegistrations
                ]);
            }
            
            $applicationId = $request->mother_application_id;
            $sourceRecord = null;
            $sourceTable = null;
            
            // Handle composite IDs for ST Assignment and Sectional Titling
            if (strpos($applicationId, '_st_assignment') !== false || strpos($applicationId, '_sectional_cofo') !== false) {
                $originalId = str_replace(['_st_assignment', '_sectional_cofo'], '', $applicationId);
                $sourceRecord = DB::connection('sqlsrv')->table('subapplications')->where('id', $originalId)->first();
                if ($sourceRecord) {
                    $sourceTable = 'subapplications';
                    // Add the original ID for proper status update
                    $sourceRecord->original_id = $originalId;
                }
            } else {
                $sourceRecord = DB::connection('sqlsrv')->table('subapplications')->where('id', $applicationId)->first();
                if ($sourceRecord) {
                    $sourceTable = 'subapplications';
                } else {
                    $sourceRecord = DB::connection('sqlsrv')->table('instrument_registration')->where('id', $applicationId)->first();
                    if ($sourceRecord) {
                        $sourceTable = 'instrument_registration';
                    } else {
                        $sourceRecord = DB::connection('sqlsrv')->table('mother_applications')->where('id', $applicationId)->first();
                        if ($sourceRecord) {
                            $sourceTable = 'mother_applications';
                        }
                    }
                }
            }
                
            if (!$sourceRecord) {
                return response()->json(['success' => false, 'error' => 'Source record not found in any table'], 404);
            }
            
            $serialData = $this->getNextSerialNumber()->getData(true);
            $stmReference = $this->generateSTMReference();
            $dataToInsert = $this->prepareRegistrationData($sourceRecord, $sourceTable, $request, $serialData, $stmReference);
            
            $newId = DB::connection('sqlsrv')->table('registered_instruments')->insertGetId($dataToInsert);
            
            // Update status using original ID if it's a composite ID
            $updateId = isset($sourceRecord->original_id) ? $sourceRecord->original_id : $applicationId;
            $this->updateSourceRecordStatus($updateId, $sourceTable);
            
            // Update instrument completion status for ST Assignment and Sectional Titling
            if (in_array($instrumentType, ['ST Assignment (Transfer of Title)', 'Sectional Titling CofO']) && $sourceTable === 'subapplications') {
                $this->updateInstrumentCompletionStatus($updateId, $instrumentType, 'Registered');
            }
            
            // Check if both ST Assignment and Sectional Titling are now registered for this file
            if (in_array($instrumentType, ['ST Assignment (Transfer of Title)', 'Sectional Titling CofO'])) {
                $this->checkBothTypesRegistered($request->file_no ?? $sourceRecord->fileno);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Instrument registered successfully',
                'serial_data' => $serialData,
                'stm_ref' => $stmReference,
                'record_id' => $newId,
                'source_table' => $sourceTable
            ]);
        } catch (\Exception $e) {
            Log::error('Error in registerSingle', ['exception' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['success' => false, 'error' => 'Failed to register: ' . $e->getMessage()], 500);
        }
    }

    public function registerBatch(Request $request)
    {
        try {
            $request->validate([
                'batch_entries' => 'required|array',
                'deeds_time' => 'required|string',
                'deeds_date' => 'required|date'
            ]);
            
            // Pre-validate ST Assignment and Sectional Titling entries
            $stFileValidation = [];
            foreach ($request->batch_entries as $entry) {
                $instrumentType = $entry['instrument_type'] ?? '';
                if (in_array($instrumentType, ['ST Assignment (Transfer of Title)', 'Sectional Titling CofO'])) {
                    $fileNo = $entry['file_no'] ?? '';
                    if (empty($fileNo)) {
                        return response()->json([
                            'success' => false, 
                            'error' => "File number (StFileNo) is required for {$instrumentType}"
                        ], 422);
                    }
                    
                    // Track what we're trying to register for each file
                    if (!isset($stFileValidation[$fileNo])) {
                        $stFileValidation[$fileNo] = [];
                    }
                    $stFileValidation[$fileNo][] = $instrumentType;
                }
            }
            
            // Check for existing registrations and duplicates within the batch
            foreach ($stFileValidation as $fileNo => $types) {
                // Check for duplicates within the batch
                if (count($types) !== count(array_unique($types))) {
                    return response()->json([
                        'success' => false, 
                        'error' => "Duplicate instrument types found in batch for file number {$fileNo}"
                    ], 422);
                }
                
                // Check existing registrations in database
                $existingRegistrations = DB::connection('sqlsrv')->table('registered_instruments')
                    ->where('StFileNo', $fileNo)
                    ->whereIn('instrument_type', ['ST Assignment (Transfer of Title)', 'Sectional Titling CofO'])
                    ->pluck('instrument_type')
                    ->toArray();
                
                foreach ($types as $type) {
                    if (in_array($type, $existingRegistrations)) {
                        return response()->json([
                            'success' => false, 
                            'error' => "A {$type} registration already exists for file number {$fileNo}"
                        ], 422);
                    }
                }
            }
            
            $serialData = $this->getNextSerialNumber()->getData(true);
            $results = [];
            $processedRecords = [];
            $registeredFiles = []; // Track files for final validation
            
            DB::connection('sqlsrv')->beginTransaction();
            
            foreach ($request->batch_entries as $index => $entry) {
                if ($index > 0) {
                    if (++$serialData['page_no'] > 100) {
                        $serialData['volume_no']++;
                        $serialData['page_no'] = 1;
                        $serialData['serial_no'] = 1;
                    } else {
                        $serialData['serial_no']++;
                    }
                    $serialData['deeds_serial_no'] = "{$serialData['serial_no']}/{$serialData['page_no']}/{$serialData['volume_no']}";
                }
                
                $applicationId = $entry['application_id'];
                $sourceRecord = null;
                $sourceTable = null;
                
                // Handle composite IDs for ST Assignment and Sectional Titling
                if (strpos($applicationId, '_st_assignment') !== false || strpos($applicationId, '_sectional_cofo') !== false) {
                    $originalId = str_replace(['_st_assignment', '_sectional_cofo'], '', $applicationId);
                    $sourceRecord = DB::connection('sqlsrv')->table('subapplications')->where('id', $originalId)->first();
                    if ($sourceRecord) {
                        $sourceTable = 'subapplications';
                        $sourceRecord->original_id = $originalId;
                    }
                } else {
                    $sourceRecord = DB::connection('sqlsrv')->table('subapplications')->where('id', $applicationId)->first();
                    if ($sourceRecord) {
                        $sourceTable = 'subapplications';
                    } else {
                        $sourceRecord = DB::connection('sqlsrv')->table('instrument_registration')->where('id', $applicationId)->first();
                        if ($sourceRecord) {
                            $sourceTable = 'instrument_registration';
                        } else {
                            $sourceRecord = DB::connection('sqlsrv')->table('mother_applications')->where('id', $applicationId)->first();
                            if ($sourceRecord) {
                                $sourceTable = 'mother_applications';
                            }
                        }
                    }
                }
                    
                if (!$sourceRecord) {
                    Log::warning('Source record not found for batch entry', ['application_id' => $applicationId]);
                    continue;
                }
                
                $updateId = isset($sourceRecord->original_id) ? $sourceRecord->original_id : $applicationId;
                $processedRecords[] = ['id' => $updateId, 'table' => $sourceTable];
                $stmReference = $this->generateSTMReference();
                
                $entryRequest = new \Illuminate\Http\Request();
                $entryRequest->merge([
                    'instrument_type' => $entry['instrument_type'] ?? '',
                    'Grantor' => $entry['grantor'] ?? '',
                    'Grantee' => $entry['grantee'] ?? '',
                    'duration' => $entry['duration'] ?? '',
                    'propertyDescription' => $entry['propertyDescription'] ?? '',
                    'lga' => $entry['lga'] ?? '',
                    'district' => $entry['district'] ?? '',
                    'plotSize' => $entry['size'] ?? '',
                    'plotNumber' => $entry['plotNumber'] ?? '',
                    'deeds_date' => $request->deeds_date,
                    'deeds_time' => $request->deeds_time,
                    'file_no' => $entry['file_no'] ?? ''
                ]);
                
                $dataToInsert = $this->prepareRegistrationData($sourceRecord, $sourceTable, $entryRequest, $serialData, $stmReference);
                $newId = DB::connection('sqlsrv')->table('registered_instruments')->insertGetId($dataToInsert);
                
                // Update instrument completion status for ST Assignment and Sectional Titling
                $instrumentType = $entry['instrument_type'] ?? '';
                if (in_array($instrumentType, ['ST Assignment (Transfer of Title)', 'Sectional Titling CofO']) && $sourceTable === 'subapplications') {
                    $this->updateInstrumentCompletionStatus($updateId, $instrumentType, 'Registered');
                }
                
                // Track registered files for final validation
                if (in_array($instrumentType, ['ST Assignment (Transfer of Title)', 'Sectional Titling CofO'])) {
                    $fileNo = $entry['file_no'] ?? $sourceRecord->fileno;
                    $registeredFiles[] = $fileNo;
                }
                
                $results[] = [
                    'application_id' => $applicationId,
                    'new_id' => $newId,
                    'deeds_serial_no' => $serialData['deeds_serial_no'],
                    'stm_ref' => $stmReference,
                    'source_table' => $sourceTable
                ];
            }
            
            foreach ($processedRecords as $record) {
                $this->updateSourceRecordStatus($record['id'], $record['table']);
            }
            
            // Check if both types are registered for each file
            foreach (array_unique($registeredFiles) as $fileNo) {
                $this->checkBothTypesRegistered($fileNo);
            }
            
            DB::connection('sqlsrv')->commit();
            
            return response()->json(['success' => true, 'message' => count($results) . ' instruments registered successfully', 'results' => $results]);
        } catch (\Exception $e) {
            DB::connection('sqlsrv')->rollBack();
            Log::error('Error in registerBatch', ['exception' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['success' => false, 'error' => 'Failed to register batch: ' . $e->getMessage()], 500);
        }
    }

    private function prepareRegistrationData($sourceRecord, $sourceTable, $request, $serialData, $stmReference)
    {
         // Convert array inputs to comma-separated strings
         if (is_array($request->instrument_type)) {
             $request->instrument_type = implode(',', $request->instrument_type);
         }
         if (is_array($request->Grantor)) {
            $request->Grantor = implode(',', $request->Grantor);
         }
         if (is_array($request->Grantee)) {
             $request->Grantee = implode(',', $request->Grantee);
         }
        
        // Determine StFileNo based on instrument type and source
        $stFileNo = null;
        if (in_array($request->instrument_type, ['ST Assignment (Transfer of Title)', 'Sectional Titling CofO'])) {
            $stFileNo = $request->file_no ?? $sourceRecord->fileno ?? null;
        }
        
        $baseData = [
            'particularsRegistrationNumber' => $serialData['deeds_serial_no'],
            'STM_Ref' => $stmReference,
            'instrument_type' => $request->instrument_type,
            'Grantor' => $request->Grantor,
            'Grantee' => $request->Grantee,
            'instrumentDate' => $request->deeds_date,
            'deeds_date' => $request->deeds_date,
            'deeds_time' => $request->deeds_time,
            'serial_no' => $serialData['serial_no'],
            'page_no' => $serialData['page_no'],
            'volume_no' => $serialData['volume_no'],
            'status' => 'registered',
            'StFileNo' => $stFileNo, // Add StFileNo field
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
            'created_at' => now(),
            'updated_at' => now()
        ];

        switch ($sourceTable) {
            case 'instrument_registration':
                return array_merge($baseData, [
                    'MLSFileNo' => $sourceRecord->MLSFileNo ?? $request->file_no,
                    'KAGISFileNO' => $sourceRecord->KAGISFileNO ?? null,
                    'NewKANGISFileNo' => $sourceRecord->NewKANGISFileNo ?? null,
                    'rootRegistrationNumber' => $sourceRecord->rootRegistrationNumber ?? null,
                    'GrantorAddress' => $request->GrantorAddress ?? $sourceRecord->GrantorAddress ?? '',
                    'GranteeAddress' => $request->GranteeAddress ?? $sourceRecord->GranteeAddress ?? '',
                    'mortgagor' => $sourceRecord->mortgagor ?? null,
                    'mortgagorAddress' => $sourceRecord->mortgagorAddress ?? null,
                    'mortgagee' => $sourceRecord->mortgagee ?? null,
                    'mortgageeAddress' => $sourceRecord->mortgageeAddress ?? null,
                    'loanAmount' => $sourceRecord->loanAmount ?? null,
                    'interestRate' => $sourceRecord->interestRate ?? null,
                    'duration' => $request->duration ?? $sourceRecord->duration ?? null,
                    'assignor' => $sourceRecord->assignor ?? null,
                    'assignorAddress' => $sourceRecord->assignorAddress ?? null,
                    'assignee' => $sourceRecord->assignee ?? null,
                    'assigneeAddress' => $sourceRecord->assigneeAddress ?? null,
                    'lessor' => $sourceRecord->lessor ?? null,
                    'lessorAddress' => $sourceRecord->lessorAddress ?? null,
                    'lessee' => $sourceRecord->lessee ?? null,
                    'lesseeAddress' => $sourceRecord->lesseeAddress ?? null,
                    'leasePeriod' => $sourceRecord->leasePeriod ?? null,
                    'leaseTerms' => $sourceRecord->leaseTerms ?? null,
                    'propertyDescription' => $request->propertyDescription ?? $sourceRecord->propertyDescription ?? '',
                    'propertyAddress' => $sourceRecord->propertyAddress ?? null,
                    'lga' => $request->lga ?? $sourceRecord->lga ?? '',
                    'district' => $request->district ?? $sourceRecord->district ?? '',
                    'size' => $request->plotSize ?? $sourceRecord->size ?? '',
                    'plotNumber' => $request->plotNumber ?? $sourceRecord->plotNumber ?? '',
                    'landUseType' => $sourceRecord->landUseType ?? null,
                    'solicitorName' => $sourceRecord->solicitorName ?? null,
                    'solicitorAddress' => $sourceRecord->solicitorAddress ?? null,
                ]);

            case 'mother_applications':
                return array_merge($baseData, [
                    'MLSFileNo' => $sourceRecord->fileno ?? $request->file_no,
                    'lga' => $sourceRecord->property_lga ?? '',
                    'district' => $sourceRecord->property_district ?? '',
                    'size' => $sourceRecord->plot_size ?? '',
                    'plotNumber' => $sourceRecord->property_plot_no ?? '',
                ]);

            case 'subapplications':
                $motherApp = DB::connection('sqlsrv')->table('mother_applications')->where('id', $sourceRecord->main_application_id)->first();
                return array_merge($baseData, [
                    'MLSFileNo' => $sourceRecord->fileno ?? $request->file_no,
                    'lga' => $motherApp->property_lga ?? '',
                    'district' => $motherApp->property_district ?? '',
                    'size' => $motherApp->plot_size ?? '',
                    'plotNumber' => $motherApp->property_plot_no ?? '',
                ]);

            default:
                return $baseData;
        }
    }

    private function updateSourceRecordStatus($id, $sourceTable)
    {
        $updateData = [
            'updated_by' => Auth::id(),
            'updated_at' => now()
        ];

        switch ($sourceTable) {
            case 'instrument_registration':
                $updateData['status'] = 'registered';
                DB::connection('sqlsrv')->table('instrument_registration')->where('id', $id)->update($updateData);
                break;

            case 'mother_applications':
                $updateData['deeds_status'] = 'registered';
                DB::connection('sqlsrv')->table('mother_applications')->where('id', $id)->update($updateData);
                break;

            case 'subapplications':
                $updateData['deeds_status'] = 'registered';
                DB::connection('sqlsrv')->table('subapplications')->where('id', $id)->update($updateData);
                break;
        }
    }

    /**
     * Initialize the default deeds_completion_status for subapplications that don't have it set
     */
    private function initializeDefaultCompletionStatus()
    {
        try {
            // Get all approved subapplications that don't have completion status set
            $subapplicationsToUpdate = DB::connection('sqlsrv')->table('subapplications')
                ->where('planning_recommendation_status', 'Approved')
                ->where('application_status', 'Approved')
                ->where(function($query) {
                    $query->whereNull('deeds_completion_status')
                          ->orWhere('deeds_completion_status', '')
                          ->orWhere('deeds_completion_status', '{}');
                })
                ->select('id')
                ->get();

            $defaultStatus = json_encode([
                'instruments' => [
                    [
                        'name' => 'ST Assignment (Transfer of Title)',
                        'status' => 'Pending'
                    ],
                    [
                        'name' => 'Sectional Titling CofO',
                        'status' => 'Pending'
                    ]
                ]
            ]);

            foreach ($subapplicationsToUpdate as $subapp) {
                DB::connection('sqlsrv')->table('subapplications')
                    ->where('id', $subapp->id)
                    ->update([
                        'deeds_completion_status' => $defaultStatus,
                        'updated_at' => now()
                    ]);
            }

            Log::info('Initialized default completion status', [
                'updated_count' => $subapplicationsToUpdate->count()
            ]);

        } catch (\Exception $e) {
            Log::error('Error initializing default completion status', [
                'exception' => $e->getMessage()
            ]);
        }
    }

    /**
     * Update the deeds_completion_status JSON field for a specific instrument type
     */
    private function updateInstrumentCompletionStatus($subApplicationId, $instrumentType, $status = 'Registered')
    {
        try {
            // Get current completion status
            $currentRecord = DB::connection('sqlsrv')->table('subapplications')
                ->where('id', $subApplicationId)
                ->select('deeds_completion_status')
                ->first();

            // Initialize or parse existing JSON
            $completionStatus = [
                'instruments' => [
                    [
                        'name' => 'ST Assignment (Transfer of Title)',
                        'status' => 'Pending'
                    ],
                    [
                        'name' => 'Sectional Titling CofO',
                        'status' => 'Pending'
                    ]
                ]
            ];

            if ($currentRecord && !empty($currentRecord->deeds_completion_status)) {
                $existingStatus = json_decode($currentRecord->deeds_completion_status, true);
                if ($existingStatus && isset($existingStatus['instruments'])) {
                    $completionStatus = $existingStatus;
                }
            }

            // Update the specific instrument status
            foreach ($completionStatus['instruments'] as &$instrument) {
                if ($instrument['name'] === $instrumentType) {
                    $instrument['status'] = $status;
                    break;
                }
            }

            // Update the database
            DB::connection('sqlsrv')->table('subapplications')
                ->where('id', $subApplicationId)
                ->update([
                    'deeds_completion_status' => json_encode($completionStatus),
                    'updated_at' => now(),
                    'updated_by' => Auth::id()
                ]);

            Log::info('Updated instrument completion status', [
                'subapplication_id' => $subApplicationId,
                'instrument_type' => $instrumentType,
                'status' => $status,
                'completion_status' => $completionStatus
            ]);

            return $completionStatus;

        } catch (\Exception $e) {
            Log::error('Error updating instrument completion status', [
                'subapplication_id' => $subApplicationId,
                'instrument_type' => $instrumentType,
                'exception' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Check if both ST Assignment and Sectional Titling CofO are registered for a given file number
     * and log the completion status. Also check overall completion for all related applications.
     */
    private function checkBothTypesRegistered($fileNo)
    {
        try {
            $registeredTypes = DB::connection('sqlsrv')->table('registered_instruments')
                ->where('StFileNo', $fileNo)
                ->whereIn('instrument_type', ['ST Assignment (Transfer of Title)', 'Sectional Titling CofO'])
                ->where('status', 'registered')
                ->pluck('instrument_type')
                ->toArray();

            $hasStAssignment = in_array('ST Assignment (Transfer of Title)', $registeredTypes);
            $hasSectionalTitling = in_array('Sectional Titling CofO', $registeredTypes);

            if ($hasStAssignment && $hasSectionalTitling) {
                Log::info('Both instrument types registered for file', [
                    'file_no' => $fileNo,
                    'status' => 'complete',
                    'registered_types' => $registeredTypes
                ]);
                
                // Update individual application completion status
                $this->updateApplicationCompletionStatus($fileNo);
                
                // Check if ALL applications in the batch are now complete
                $this->checkAllApplicationsCompletion($fileNo);
            } else {
                Log::info('Partial registration for file', [
                    'file_no' => $fileNo,
                    'status' => 'partial',
                    'registered_types' => $registeredTypes,
                    'missing_types' => array_diff(['ST Assignment (Transfer of Title)', 'Sectional Titling CofO'], $registeredTypes)
                ]);
            }

            return [
                'complete' => $hasStAssignment && $hasSectionalTitling,
                'registered_types' => $registeredTypes
            ];
        } catch (\Exception $e) {
            Log::error('Error checking both types registered', [
                'file_no' => $fileNo,
                'exception' => $e->getMessage()
            ]);
            return ['complete' => false, 'registered_types' => []];
        }
    }

    /**
     * Update the completion status for applications when both instrument types are registered
     */
    private function updateApplicationCompletionStatus($fileNo)
    {
        try {
            // Get the current subapplication record
            $subApplication = DB::connection('sqlsrv')->table('subapplications')
                ->where('fileno', $fileNo)
                ->select('id', 'deeds_completion_status')
                ->first();

            if (!$subApplication) {
                Log::warning('Subapplication not found for completion status update', ['file_no' => $fileNo]);
                return;
            }

            // Parse existing completion status
            $completionStatus = [
                'instruments' => [
                    [
                        'name' => 'ST Assignment (Transfer of Title)',
                        'status' => 'Registered'
                    ],
                    [
                        'name' => 'Sectional Titling CofO',
                        'status' => 'Registered'
                    ]
                ]
            ];

            if (!empty($subApplication->deeds_completion_status)) {
                $existingStatus = json_decode($subApplication->deeds_completion_status, true);
                if ($existingStatus && isset($existingStatus['instruments'])) {
                    // Update existing JSON structure - mark both as registered
                    foreach ($existingStatus['instruments'] as &$instrument) {
                        if (in_array($instrument['name'], ['ST Assignment (Transfer of Title)', 'Sectional Titling CofO'])) {
                            $instrument['status'] = 'Registered';
                        }
                    }
                    $completionStatus = $existingStatus;
                }
            }

            // Add completion metadata
            $completionStatus['both_types_registered'] = true;
            $completionStatus['completion_date'] = now()->toISOString();

            // Update subapplications with the proper JSON structure
            DB::connection('sqlsrv')->table('subapplications')
                ->where('id', $subApplication->id)
                ->update([
                    'deeds_completion_status' => json_encode($completionStatus),
                    'deeds_completion_date' => now(),
                    'updated_at' => now(),
                    'updated_by' => Auth::id()
                ]);

            Log::info('Updated application completion status', [
                'file_no' => $fileNo,
                'subapplication_id' => $subApplication->id,
                'completion_status' => $completionStatus
            ]);
        } catch (\Exception $e) {
            Log::warning('Could not update completion status', [
                'file_no' => $fileNo,
                'exception' => $e->getMessage()
            ]);
        }
    }

    /**
     * Check if ALL applications in the same batch/group are complete
     * This ensures that all applicants have both instrument types registered
     */
    private function checkAllApplicationsCompletion($fileNo)
    {
        try {
            // Get the main application ID for this subapplication
            $subApplication = DB::connection('sqlsrv')->table('subapplications')
                ->where('fileno', $fileNo)
                ->first();

            if (!$subApplication) {
                Log::warning('Subapplication not found for file', ['file_no' => $fileNo]);
                return;
            }

            $mainApplicationId = $subApplication->main_application_id;

            // Get all approved subapplications for this main application
            $allSubApplications = DB::connection('sqlsrv')->table('subapplications')
                ->where('main_application_id', $mainApplicationId)
                ->where('planning_recommendation_status', 'Approved')
                ->where('application_status', 'Approved')
                ->select('id', 'fileno')
                ->get();

            $totalExpectedRegistrations = $allSubApplications->count() * 2; // 2 instrument types per applicant
            $completedApplications = 0;
            $totalRegistrations = 0;

            // Check completion status for each subapplication
            foreach ($allSubApplications as $subApp) {
                $registeredTypes = DB::connection('sqlsrv')->table('registered_instruments')
                    ->where('StFileNo', $subApp->fileno)
                    ->whereIn('instrument_type', ['ST Assignment (Transfer of Title)', 'Sectional Titling CofO'])
                    ->where('status', 'registered')
                    ->pluck('instrument_type')
                    ->toArray();

                $registrationCount = count($registeredTypes);
                $totalRegistrations += $registrationCount;

                $hasStAssignment = in_array('ST Assignment (Transfer of Title)', $registeredTypes);
                $hasSectionalTitling = in_array('Sectional Titling CofO', $registeredTypes);

                if ($hasStAssignment && $hasSectionalTitling) {
                    $completedApplications++;
                }
            }

            $allComplete = ($completedApplications === $allSubApplications->count());
            $completionPercentage = ($totalRegistrations / $totalExpectedRegistrations) * 100;

            Log::info('Overall completion status check', [
                'main_application_id' => $mainApplicationId,
                'total_subapplications' => $allSubApplications->count(),
                'completed_applications' => $completedApplications,
                'total_registrations' => $totalRegistrations,
                'expected_registrations' => $totalExpectedRegistrations,
                'completion_percentage' => round($completionPercentage, 2),
                'all_complete' => $allComplete,
                'triggered_by_file' => $fileNo
            ]);

            // Update the main application with overall completion status
            $this->updateMainApplicationCompletionStatus($mainApplicationId, $allComplete, $completionPercentage, $totalRegistrations, $totalExpectedRegistrations);

            if ($allComplete) {
                Log::info('🎉 ALL APPLICATIONS COMPLETE! All applicants have both instrument types registered', [
                    'main_application_id' => $mainApplicationId,
                    'total_applicants' => $allSubApplications->count(),
                    'total_registrations' => $totalRegistrations
                ]);

                // Trigger any additional completion actions here
                $this->onAllApplicationsComplete($mainApplicationId, $allSubApplications);
            }

        } catch (\Exception $e) {
            Log::error('Error checking all applications completion', [
                'file_no' => $fileNo,
                'exception' => $e->getMessage()
            ]);
        }
    }

    /**
     * Update the main application with overall completion status
     */
    private function updateMainApplicationCompletionStatus($mainApplicationId, $allComplete, $completionPercentage, $totalRegistrations, $expectedRegistrations)
    {
        try {
            $status = $allComplete ? 'all_complete' : 'partial';
            
            // Check if mother_applications table exists and has the required columns
            $tableExists = DB::connection('sqlsrv')->select("
                SELECT COLUMN_NAME 
                FROM INFORMATION_SCHEMA.COLUMNS 
                WHERE TABLE_NAME = 'mother_applications' 
                AND COLUMN_NAME = 'deeds_overall_status'
            ");

            if (!empty($tableExists)) {
                DB::connection('sqlsrv')->table('mother_applications')
                    ->where('id', $mainApplicationId)
                    ->update([
                        'deeds_overall_status' => $status,
                        'deeds_completion_percentage' => round($completionPercentage, 2),
                        'deeds_total_registrations' => $totalRegistrations,
                        'deeds_expected_registrations' => $expectedRegistrations,
                        'deeds_all_complete_date' => $allComplete ? now() : null,
                        'updated_at' => now(),
                        'updated_by' => Auth::id()
                    ]);

                Log::info('Updated main application completion status', [
                    'main_application_id' => $mainApplicationId,
                    'status' => $status,
                    'completion_percentage' => round($completionPercentage, 2)
                ]);
            } else {
                Log::info('Mother applications table or columns not found, skipping main application status update', [
                    'main_application_id' => $mainApplicationId
                ]);
            }
        } catch (\Exception $e) {
            Log::warning('Could not update main application completion status', [
                'main_application_id' => $mainApplicationId,
                'exception' => $e->getMessage()
            ]);
        }
    }

    /**
     * Actions to perform when all applications are complete
     */
    private function onAllApplicationsComplete($mainApplicationId, $allSubApplications)
    {
        try {
            // Log detailed completion information
            Log::info('All applications completion details', [
                'main_application_id' => $mainApplicationId,
                'completed_at' => now(),
                'total_applicants' => $allSubApplications->count(),
                'applicant_files' => $allSubApplications->pluck('fileno')->toArray()
            ]);

            // You can add additional actions here such as:
            // - Send notifications
            // - Generate completion reports
            // - Update external systems
            // - Trigger workflow processes

        } catch (\Exception $e) {
            Log::error('Error in completion actions', [
                'main_application_id' => $mainApplicationId,
                'exception' => $e->getMessage()
            ]);
        }
    }

    /**
     * Get completion status for a specific file number
     */
    public function getFileCompletionStatus(Request $request)
    {
        try {
            $fileNo = $request->query('file_no');
            
            if (empty($fileNo)) {
                return response()->json([
                    'success' => false,
                    'error' => 'File number is required'
                ], 400);
            }

            // Get the subapplication for this file
            $subApplication = DB::connection('sqlsrv')->table('subapplications')
                ->where('fileno', $fileNo)
                ->select('id', 'fileno', 'deeds_completion_status')
                ->first();

            if (!$subApplication) {
                return response()->json([
                    'success' => false,
                    'error' => 'Subapplication not found for file number: ' . $fileNo
                ], 404);
            }

            // Parse completion status
            $completionStatus = [
                'instruments' => [
                    [
                        'name' => 'ST Assignment (Transfer of Title)',
                        'status' => 'Pending'
                    ],
                    [
                        'name' => 'Sectional Titling CofO',
                        'status' => 'Pending'
                    ]
                ]
            ];

            if (!empty($subApplication->deeds_completion_status)) {
                $existingStatus = json_decode($subApplication->deeds_completion_status, true);
                if ($existingStatus && isset($existingStatus['instruments'])) {
                    $completionStatus = $existingStatus;
                }
            }

            // Check actual registrations to verify status
            $registeredInstruments = DB::connection('sqlsrv')->table('registered_instruments')
                ->where('StFileNo', $fileNo)
                ->whereIn('instrument_type', ['ST Assignment (Transfer of Title)', 'Sectional Titling CofO'])
                ->where('status', 'registered')
                ->select('instrument_type', 'particularsRegistrationNumber', 'STM_Ref', 'created_at')
                ->get();

            // Update status based on actual registrations
            foreach ($completionStatus['instruments'] as &$instrument) {
                $registration = $registeredInstruments->firstWhere('instrument_type', $instrument['name']);
                if ($registration) {
                    $instrument['status'] = 'Registered';
                    $instrument['registration_number'] = $registration->particularsRegistrationNumber;
                    $instrument['stm_ref'] = $registration->STM_Ref;
                    $instrument['registered_date'] = $registration->created_at;
                }
            }

            return response()->json([
                'success' => true,
                'file_no' => $fileNo,
                'subapplication_id' => $subApplication->id,
                'completion_status' => $completionStatus
            ]);

        } catch (\Exception $e) {
            Log::error('Error getting file completion status', [
                'file_no' => $request->query('file_no'),
                'exception' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Failed to get completion status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get overall completion status for all applications
     */
    public function getOverallCompletionStatus(Request $request)
    {
        try {
            $mainApplicationId = $request->query('main_application_id');
            
            if (empty($mainApplicationId)) {
                return response()->json([
                    'success' => false,
                    'error' => 'Main application ID is required'
                ], 400);
            }

            // Get all subapplications for this main application
            $allSubApplications = DB::connection('sqlsrv')->table('subapplications')
                ->where('main_application_id', $mainApplicationId)
                ->where('planning_recommendation_status', 'Approved')
                ->where('application_status', 'Approved')
                ->select('id', 'fileno', 'first_name', 'surname', 'corporate_name')
                ->get();

            $applicantStatus = [];
            $totalRegistrations = 0;
            $completedApplicants = 0;

            foreach ($allSubApplications as $subApp) {
                $registeredTypes = DB::connection('sqlsrv')->table('registered_instruments')
                    ->where('StFileNo', $subApp->fileno)
                    ->whereIn('instrument_type', ['ST Assignment (Transfer of Title)', 'Sectional Titling CofO'])
                    ->where('status', 'registered')
                    ->select('instrument_type', 'particularsRegistrationNumber', 'STM_Ref', 'created_at')
                    ->get();

                $hasStAssignment = $registeredTypes->firstWhere('instrument_type', 'ST Assignment (Transfer of Title)');
                $hasSectionalTitling = $registeredTypes->firstWhere('instrument_type', 'Sectional Titling CofO');

                $isComplete = !is_null($hasStAssignment) && !is_null($hasSectionalTitling);
                if ($isComplete) {
                    $completedApplicants++;
                }

                $totalRegistrations += $registeredTypes->count();

                $applicantName = trim(($subApp->first_name ?? '') . ' ' . ($subApp->surname ?? '')) ?: $subApp->corporate_name ?? 'Unknown';

                $applicantStatus[] = [
                    'applicant_id' => $subApp->id,
                    'applicant_name' => $applicantName,
                    'file_no' => $subApp->fileno,
                    'st_assignment' => [
                        'registered' => !is_null($hasStAssignment),
                        'registration_number' => $hasStAssignment->particularsRegistrationNumber ?? null,
                        'stm_ref' => $hasStAssignment->STM_Ref ?? null,
                        'registered_date' => $hasStAssignment->created_at ?? null
                    ],
                    'sectional_titling' => [
                        'registered' => !is_null($hasSectionalTitling),
                        'registration_number' => $hasSectionalTitling->particularsRegistrationNumber ?? null,
                        'stm_ref' => $hasSectionalTitling->STM_Ref ?? null,
                        'registered_date' => $hasSectionalTitling->created_at ?? null
                    ],
                    'both_complete' => $isComplete,
                    'completion_percentage' => ($registeredTypes->count() / 2) * 100
                ];
            }

            $totalExpected = $allSubApplications->count() * 2;
            $overallPercentage = $totalExpected > 0 ? ($totalRegistrations / $totalExpected) * 100 : 0;
            $allComplete = ($completedApplicants === $allSubApplications->count());

            return response()->json([
                'success' => true,
                'main_application_id' => $mainApplicationId,
                'overall_status' => [
                    'all_complete' => $allComplete,
                    'completion_percentage' => round($overallPercentage, 2),
                    'total_applicants' => $allSubApplications->count(),
                    'completed_applicants' => $completedApplicants,
                    'total_registrations' => $totalRegistrations,
                    'expected_registrations' => $totalExpected
                ],
                'applicants' => $applicantStatus
            ]);

        } catch (\Exception $e) {
            Log::error('Error getting overall completion status', [
                'main_application_id' => $request->query('main_application_id'),
                'exception' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Failed to get completion status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified instrument
     */
    public function edit($id)
    {
        $PageTitle = 'Edit Instrument Registration';
        $PageDescription = '';
        
        try {
            // Handle composite IDs for ST Assignment and Sectional Titling
            $originalId = $id;
            $sourceTable = null;
            $sourceRecord = null;
            
            if (strpos($id, '_st_assignment') !== false || strpos($id, '_sectional_cofo') !== false) {
                $originalId = str_replace(['_st_assignment', '_sectional_cofo'], '', $id);
                $sourceRecord = DB::connection('sqlsrv')->table('subapplications as s')
                    ->leftJoin('mother_applications as m', 's.main_application_id', '=', 'm.id')
                    ->leftJoin('users', 's.created_by', '=', 'users.id')
                    ->where('s.id', $originalId)
                    ->select(
                        's.*',
                        DB::raw("CONCAT(COALESCE(s.applicant_title,''), ' ', COALESCE(s.first_name,''), ' ', COALESCE(s.surname,''), COALESCE(s.corporate_name,''), COALESCE(s.multiple_owners_names,'')) as sub_applicant"),
                        'm.property_lga as lga',
                        'm.property_district as district',
                        'm.plot_size as size',
                        'm.property_plot_no as plotNumber',
                        DB::raw("CONCAT(COALESCE(users.first_name, ''), ' ', COALESCE(users.last_name, '')) as reg_creator_name")
                    )
                    ->first();
                $sourceTable = 'subapplications';
            } else {
                // Try to find in registered_instruments first
                $sourceRecord = DB::connection('sqlsrv')->table('registered_instruments')
                    ->leftJoin('users', 'registered_instruments.created_by', '=', 'users.id')
                    ->where('registered_instruments.id', $id)
                    ->select(
                        'registered_instruments.*',
                        DB::raw("CONCAT(COALESCE(users.first_name, ''), ' ', COALESCE(users.last_name, '')) as reg_creator_name")
                    )
                    ->first();
                $sourceTable = 'registered_instruments';
            }

            if (!$sourceRecord) {
                Log::error('Instrument not found for editing', ['id' => $id]);
                return redirect()->route('instrument_registration.index')->with('error', 'Instrument not found');
            }

            return view('instrument_registration.edit', compact('sourceRecord', 'sourceTable', 'PageTitle', 'PageDescription', 'id'));
        } catch (\Exception $e) {
            Log::error('Error in edit method', [
                'id' => $id, 
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('instrument_registration.index')
                ->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified instrument in storage
     */
    public function update(Request $request, $id)
    {
        try {
            // Handle composite IDs for ST Assignment and Sectional Titling
            $originalId = $id;
            $sourceTable = null;
            
            if (strpos($id, '_st_assignment') !== false || strpos($id, '_sectional_cofo') !== false) {
                $originalId = str_replace(['_st_assignment', '_sectional_cofo'], '', $id);
                $sourceTable = 'subapplications';
            } else {
                $sourceTable = 'registered_instruments';
            }

            $updateData = [
                'updated_by' => Auth::id(),
                'updated_at' => now()
            ];

            // Add specific fields based on the request
            if ($request->has('Grantor')) {
                $updateData['Grantor'] = $request->Grantor;
            }
            if ($request->has('Grantee')) {
                $updateData['Grantee'] = $request->Grantee;
            }
            if ($request->has('instrument_type')) {
                $updateData['instrument_type'] = $request->instrument_type;
            }
            if ($request->has('propertyDescription')) {
                $updateData['propertyDescription'] = $request->propertyDescription;
            }

            if ($sourceTable === 'registered_instruments') {
                DB::connection('sqlsrv')->table('registered_instruments')->where('id', $id)->update($updateData);
            } else {
                // For subapplications, update the relevant fields
                $subUpdateData = [
                    'updated_by' => Auth::id(),
                    'updated_at' => now()
                ];
                
                if ($request->has('first_name')) {
                    $subUpdateData['first_name'] = $request->first_name;
                }
                if ($request->has('surname')) {
                    $subUpdateData['surname'] = $request->surname;
                }
                if ($request->has('corporate_name')) {
                    $subUpdateData['corporate_name'] = $request->corporate_name;
                }
                
                DB::connection('sqlsrv')->table('subapplications')->where('id', $originalId)->update($subUpdateData);
            }

            return redirect()->route('instrument_registration.index')
                ->with('success', 'Instrument updated successfully');

        } catch (\Exception $e) {
            Log::error('Error updating instrument', [
                'id' => $id,
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->with('error', 'Failed to update instrument: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified instrument from storage
     */
    public function destroy($id)
    {
        try {
            // Handle composite IDs for ST Assignment and Sectional Titling
            $originalId = $id;
            $sourceTable = null;
            
            if (strpos($id, '_st_assignment') !== false || strpos($id, '_sectional_cofo') !== false) {
                $originalId = str_replace(['_st_assignment', '_sectional_cofo'], '', $id);
                $sourceTable = 'subapplications';
                
                // For ST Assignment and Sectional Titling, we don't actually delete the subapplication
                // Instead, we reset the completion status for the specific instrument type
                $instrumentType = strpos($id, '_st_assignment') !== false ? 'ST Assignment (Transfer of Title)' : 'Sectional Titling CofO';
                
                // Get current completion status
                $currentRecord = DB::connection('sqlsrv')->table('subapplications')
                    ->where('id', $originalId)
                    ->select('deeds_completion_status')
                    ->first();

                if ($currentRecord && !empty($currentRecord->deeds_completion_status)) {
                    $completionStatus = json_decode($currentRecord->deeds_completion_status, true);
                    if ($completionStatus && isset($completionStatus['instruments'])) {
                        // Reset the specific instrument status to pending
                        foreach ($completionStatus['instruments'] as &$instrument) {
                            if ($instrument['name'] === $instrumentType) {
                                $instrument['status'] = 'Pending';
                                break;
                            }
                        }
                        
                        // Update the database
                        DB::connection('sqlsrv')->table('subapplications')
                            ->where('id', $originalId)
                            ->update([
                                'deeds_completion_status' => json_encode($completionStatus),
                                'updated_at' => now(),
                                'updated_by' => Auth::id()
                            ]);
                    }
                }
                
                return response()->json([
                    'success' => true,
                    'message' => 'Instrument status reset to pending successfully'
                ]);
                
            } else {
                // For registered instruments, actually delete the record
                $deleted = DB::connection('sqlsrv')->table('registered_instruments')->where('id', $id)->delete();
                
                if ($deleted) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Instrument deleted successfully'
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'error' => 'Instrument not found'
                    ], 404);
                }
            }

        } catch (\Exception $e) {
            Log::error('Error deleting instrument', [
                'id' => $id,
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Failed to delete instrument: ' . $e->getMessage()
            ], 500);
        }
    }
}
