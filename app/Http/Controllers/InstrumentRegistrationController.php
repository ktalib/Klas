<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
 
    public function InstrumentRegistration()
    {
        $PageTitle = 'Instrument Registration ';
        $PageDescription = '';

        // Get pending and rejected instruments from instrument_registration table
        $pendingInstruments = DB::connection('sqlsrv')->table('instrument_registration')
            ->leftJoin('users', 'instrument_registration.created_by', '=', 'users.id')
            ->select(
                'instrument_registration.*',
                'instrument_registration.id',
                'instrument_registration.MLSFileNo as fileno',
                'instrument_registration.rootRegistrationNumber as Deeds_Serial_No',
                'instrument_registration.instrument_type',
                'instrument_registration.Grantor',
                'instrument_registration.Grantee',
                'instrument_registration.GrantorAddress',
                'instrument_registration.GranteeAddress',
                'instrument_registration.duration',
                'instrument_registration.leasePeriod',
                'instrument_registration.propertyDescription',
                'instrument_registration.lga',
                'instrument_registration.district',
                'instrument_registration.size',
                'instrument_registration.plotNumber',
                'instrument_registration.instrumentDate as deeds_date',
                'instrument_registration.solicitorName',
                'instrument_registration.solicitorAddress',
                'instrument_registration.status',
                'instrument_registration.landUseType as land_use',
                'instrument_registration.created_by as reg_created_by',
                DB::raw("CONCAT(users.first_name, ' ', users.last_name) as reg_creator_name"),
                DB::raw("'instrument_registration' as source_table")
            )
            ->whereIn('instrument_registration.status', ['pending', 'rejected', null]);

    // Get registered instruments from registered_instruments table
    $registeredInstruments = DB::connection('sqlsrv')->table('registered_instruments')
        ->leftJoin('users', 'registered_instruments.created_by', '=', 'users.id')
        ->select(
            'registered_instruments.*',
            'registered_instruments.id',
            'registered_instruments.MLSFileNo as fileno',
            'registered_instruments.particularsRegistrationNumber as Deeds_Serial_No',
            'registered_instruments.instrument_type',
            'registered_instruments.Grantor',
            'registered_instruments.Grantee',
            'registered_instruments.GrantorAddress',
            'registered_instruments.GranteeAddress',
            'registered_instruments.duration',
            'registered_instruments.leasePeriod',
            'registered_instruments.propertyDescription',
            'registered_instruments.lga',
            'registered_instruments.district',
            'registered_instruments.size',
            'registered_instruments.plotNumber',
            'registered_instruments.instrumentDate as deeds_date',
            'registered_instruments.solicitorName',
            'registered_instruments.solicitorAddress',
            'registered_instruments.status',
            'registered_instruments.landUseType as land_use',
            'registered_instruments.created_by as reg_created_by',
            DB::raw("CONCAT(users.first_name, ' ', users.last_name) as reg_creator_name"),
            DB::raw("'registered_instruments' as source_table")
        )
        ->where('registered_instruments.status', 'registered');

    // Combine both collections
    $pendingCollection = $pendingInstruments->get();
    $registeredCollection = $registeredInstruments->get();
    $approvedApplications = $pendingCollection->merge($registeredCollection);

    // Count statistics for the statistics cards
    $pendingCount = 0;
    $registeredCount = 0;
    $rejectedCount = 0;
    $totalCount = $approvedApplications->count();

    // Process data and determine status
    foreach ($approvedApplications as $application) {
        // Set status for each record
        if (empty($application->status) || strtolower($application->status) === 'pending') {
            $application->status = 'pending';
            $pendingCount++;
        } else if (strtolower($application->status) === 'registered') {
            $registeredCount++;
        } else if (strtolower($application->status) === 'rejected') {
            $rejectedCount++;
        } else {
            $application->status = 'pending';
            $pendingCount++;
        }
        
        // Add debug output to verify data
        \Log::debug('Instrument record:', [
            'id' => $application->id,
            'status' => $application->status,
            'fileno' => $application->fileno,
            'Grantor' => $application->Grantor,
        ]); 
            
        // Format property description if not already set
        if (empty($application->propertyDescription)) {
            $application->property_description = 
                (!empty($application->district) ? $application->district . ', ' : '') .
                (!empty($application->lga) ? $application->lga . ', ' : '') .
                (!empty($application->state) ? $application->state : '');
        } else {
            $application->property_description = $application->propertyDescription;
        }
        
        // Make sure we have a duration value
        $application->duration = $application->duration ?? $application->leasePeriod ?? 'N/A';
    }

    return view('instrument_registration.index', compact(
        'approvedApplications',
        'PageTitle',
        'PageDescription',
        'pendingCount',
        'registeredCount',
        'rejectedCount',
        'totalCount'
    ));
}


    public function view($id)
    {
        $PageTitle = 'View Instrument Registration';
        $PageDescription = '';
        
        try {
            $application = DB::connection('sqlsrv')
                ->table('registered_instruments')
                ->leftJoin('users', 'registered_instruments.created_by', '=', 'users.id')
                ->select(
                    'registered_instruments.*',
                    DB::raw("CONCAT(users.first_name, ' ', users.last_name) as reg_creator_name")
                )
                ->where('registered_instruments.id', $id)
                ->first();

            if (!$application) {
                \Log::error('Instrument not found', ['id' => $id]);
                return redirect()->route('instrument_registration.index')->with('error', 'Instrument not found');
            }

            return view('instrument_registration.view', compact('application', 'PageTitle', 'PageDescription'));
        } catch (\Exception $e) {
            \Log::error('Error in view method', [
                'id' => $id, 
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('instrument_registration.index')
                ->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function getNextSerialNumber()
    {
        try {
            // Get the latest serial numbers from registered_instruments
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
            
            // Check if we need to start a new volume
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
            \Log::error('Error generating next serial number', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'error' => 'Failed to generate serial number: ' . $e->getMessage()
            ], 500);
        }
    }

    public function registerSingle(Request $request)
    {
        try {
            $request->validate([
                'mother_application_id' => 'required',
                'instrument_type' => 'required|string',
                'Grantor' => 'required|string',
                'Grantee' => 'required|string',
                'deeds_date' => 'required|date',
                'deeds_time' => 'required|string',
            ]);
            
            // Get the source record from instrument_registration
            $sourceRecord = DB::connection('sqlsrv')
                ->table('instrument_registration')
                ->where('id', $request->mother_application_id)
                ->first();
                
            if (!$sourceRecord) {
                return response()->json([
                    'success' => false,
                    'error' => 'Source instrument record not found'
                ], 404);
            }
            
            $serialData = $this->getNextSerialNumber()->getData(true);
            
            // Prepare data to insert by combining source record with new registration info
            $dataToInsert = [
                // Copy fields from source record
                'MLSFileNo' => $sourceRecord->MLSFileNo ?? $request->file_no,
                'KAGISFileNO' => $sourceRecord->KAGISFileNO ?? null,
                'NewKANGISFileNo' => $sourceRecord->NewKANGISFileNo ?? null,
                'rootRegistrationNumber' => $sourceRecord->rootRegistrationNumber ?? null,
                
                // Add new registration details
                'particularsRegistrationNumber' => $serialData['deeds_serial_no'],
                'instrument_type' => $request->instrument_type,
                'Grantor' => $request->Grantor,
                'GrantorAddress' => $request->GrantorAddress ?? $sourceRecord->GrantorAddress ?? '',
                'Grantee' => $request->Grantee,
                'GranteeAddress' => $request->GranteeAddress ?? $sourceRecord->GranteeAddress ?? '',
                
                // Copy more fields from source as needed
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
                
                // Set registration details
                'instrumentDate' => $request->deeds_date,
                'deeds_date' => $request->deeds_date,
                'deeds_time' => $request->deeds_time,
                'serial_no' => $serialData['serial_no'],
                'page_no' => $serialData['page_no'],
                'volume_no' => $serialData['volume_no'],
                'status' => 'registered',
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
                'created_at' => now(),
                'updated_at' => now()
            ];
            
            // Insert the new record
            $newId = DB::connection('sqlsrv')->table('registered_instruments')->insertGetId($dataToInsert);
            
            // Update original record status
            DB::connection('sqlsrv')->table('instrument_registration')
                ->where('id', $request->mother_application_id)
                ->update([
                    'status' => 'registered',
                    'updated_by' => Auth::id(),
                    'updated_at' => now()
                ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Instrument registered successfully',
                'serial_data' => $serialData,
                'record_id' => $newId
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in registerSingle', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Failed to register: ' . $e->getMessage()
            ], 500);
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
            
            $serialData = $this->getNextSerialNumber()->getData(true);
            $results = [];
            $registeredIds = [];
            
            DB::connection('sqlsrv')->beginTransaction();
            
            foreach ($request->batch_entries as $index => $entry) {
                // Update serial numbers for subsequent entries
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
                
                // Get source record
                $sourceRecord = DB::connection('sqlsrv')
                    ->table('instrument_registration')
                    ->where('id', $entry['application_id'])
                    ->first();
                    
                if (!$sourceRecord) {
                    continue; // Skip this record if source not found
                }
                
                $registeredIds[] = $entry['application_id'];
                
                // Prepare data for insertion
                $dataToInsert = [
                    // Copy fields from source record
                    'MLSFileNo' => $sourceRecord->MLSFileNo ?? $entry['file_no'] ?? null,
                    'KAGISFileNO' => $sourceRecord->KAGISFileNO ?? null,
                    'NewKANGISFileNo' => $sourceRecord->NewKANGISFileNo ?? null,
                    'rootRegistrationNumber' => $sourceRecord->rootRegistrationNumber ?? null,
                    
                    // Add new registration details
                    'particularsRegistrationNumber' => $serialData['deeds_serial_no'],
                    'instrument_type' => $entry['instrument_type'] ?? $sourceRecord->instrument_type,
                                        'Grantor' => $entry['grantor'] ?? $sourceRecord->Grantor,
                                        'GrantorAddress' => $entry['grantorAddress'] ?? $sourceRecord->GrantorAddress ?? '',
                                        'Grantee' => $entry['grantee'] ?? $sourceRecord->Grantee,
                                        'GranteeAddress' => $entry['granteeAddress'] ?? $sourceRecord->GranteeAddress ?? '',
                                        
                                        // Copy more fields from source record
                                        'mortgagor' => $sourceRecord->mortgagor ?? null,
                                        'mortgagorAddress' => $sourceRecord->mortgagorAddress ?? null,
                                        'mortgagee' => $sourceRecord->mortgagee ?? null,
                                        'mortgageeAddress' => $sourceRecord->mortgageeAddress ?? null,
                                        'loanAmount' => $sourceRecord->loanAmount ?? null,
                                        'interestRate' => $sourceRecord->interestRate ?? null,
                                        'duration' => $entry['duration'] ?? $sourceRecord->duration ?? null,
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
                                        'propertyDescription' => $entry['propertyDescription'] ?? $sourceRecord->propertyDescription ?? '',
                                        'propertyAddress' => $sourceRecord->propertyAddress ?? null,
                                        'lga' => $entry['lga'] ?? $sourceRecord->lga ?? '',
                                        'district' => $entry['district'] ?? $sourceRecord->district ?? '',
                                        'size' => $entry['size'] ?? $sourceRecord->size ?? '',
                                        'plotNumber' => $entry['plotNumber'] ?? $sourceRecord->plotNumber ?? '',
                                        'landUseType' => $sourceRecord->landUseType ?? null,
                                        'solicitorName' => $sourceRecord->solicitorName ?? null,
                                        'solicitorAddress' => $sourceRecord->solicitorAddress ?? null,
                                        
                                        // Set registration details
                                        'instrumentDate' => $request->deeds_date,
                                        'deeds_date' => $request->deeds_date,
                                        'deeds_time' => $request->deeds_time,
                                        'serial_no' => $serialData['serial_no'],
                                        'page_no' => $serialData['page_no'],
                                        'volume_no' => $serialData['volume_no'],
                                        'status' => 'registered',
                                        'created_by' => Auth::id(),
                                        'updated_by' => Auth::id(),
                                        'created_at' => now(),
                                        'updated_at' => now()
                                    ];
                                    
                                    // Insert the new record
                                    $newId = DB::connection('sqlsrv')->table('registered_instruments')->insertGetId($dataToInsert);
                                    
                                    // Save result
                                    $results[] = [
                                        'application_id' => $entry['application_id'],
                                        'new_id' => $newId,
                                        'deeds_serial_no' => $serialData['deeds_serial_no']
                                    ];
                                }
                                
                                // Update all processed records to registered status
                                if (!empty($registeredIds)) {
                                    DB::connection('sqlsrv')->table('instrument_registration')
                                        ->whereIn('id', $registeredIds)
                                        ->update([
                                            'status' => 'registered',
                                            'updated_by' => Auth::id(),
                                            'updated_at' => now()
                                        ]);
                                }
                                
                                DB::connection('sqlsrv')->commit();
                                
                                return response()->json([
                                    'success' => true,
                                    'message' => count($results) . ' instruments registered successfully',
                                    'results' => $results
                                ]);
                            } catch (\Exception $e) {
                                DB::connection('sqlsrv')->rollBack();
                                
                                \Log::error('Error in registerBatch', [
                                    'exception' => $e->getMessage(),
                                    'trace' => $e->getTraceAsString()
                                ]);
                                
                                return response()->json([
                                    'success' => false,
                                    'error' => 'Failed to register batch: ' . $e->getMessage()
                                ], 500);
                            }
                        }
                    }
