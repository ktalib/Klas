<div>
    <div class="flex flex-col">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Buyer Name
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Unit
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Measurement
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php
                                // Get request parameters
                                $unitNumber = request()->query('unit');
                                $unitId = request()->query('unit_id');
                                
                                $buyers = [];
                                
                                // If specific unit and unit_id are provided in URL
                                if (!empty($unitNumber) && !empty($unitId)) {
                                    // Get measurement for specific unit
                                    $unitMeasurement = DB::connection('sqlsrv')
                                        ->table('st_unit_measurements')
                                        ->where('application_id', $memo->application_id ?? null)
                                        ->where('unit_no', $unitNumber)
                                        ->first();
                                        
                                    // Get buyer information from subapplications
                                    $buyerInfo = DB::connection('sqlsrv')
                                        ->table('subapplications')
                                        ->where('id', $unitId)
                                        ->first();
                                        
                                    if ($unitMeasurement && $buyerInfo) {
                                        // Format buyer name based on applicant type
                                        $buyerName = null;
                                        
                                        // First check if owner_name is available and not empty
                                        if (!empty($buyerInfo->owner_name)) {
                                            $buyerName = $buyerInfo->owner_name;
                                        }
                                        // If owner_name isn't available, check applicant type
                                        else if ($buyerInfo->applicant_type == 'individual') {
                                            $firstName = $buyerInfo->first_name ?? '';
                                            $surname = $buyerInfo->surname ?? '';
                                            $title = $buyerInfo->applicant_title ?? '';
                                            
                                            if (!empty($firstName) || !empty($surname)) {
                                                $buyerName = trim($title . ' ' . $firstName . ' ' . $surname);
                                            }
                                        } 
                                        elseif ($buyerInfo->applicant_type == 'corporate') {
                                            if (!empty($buyerInfo->corporate_name)) {
                                                $buyerName = trim($buyerInfo->corporate_name);
                                                if (!empty($buyerInfo->rc_number)) {
                                                    $buyerName .= ' (RC: ' . $buyerInfo->rc_number . ')';
                                                }
                                            }
                                        }
                                        elseif ($buyerInfo->applicant_type == 'multiple' && !empty($buyerInfo->multiple_owners_names)) {
                                            $owners = json_decode($buyerInfo->multiple_owners_names);
                                            if (is_array($owners) && count($owners) > 0) {
                                                $buyerName = implode(', ', $owners);
                                            } else {
                                                $buyerName = 'Multiple Owners';
                                            }
                                        }
                                        
                                        // If all else fails, use 'N/A'
                                        if (empty($buyerName)) {
                                            $buyerName = 'N/A';
                                        }
                                        
                                        $buyers[] = [
                                            'name' => $buyerName,
                                            'unit' => $unitNumber,
                                            'measurement' => $unitMeasurement->measurement ?? 'N/A'
                                        ];
                                    }
                                } else {
                                    // Get all measurements and buyers for this application
                                    $unitMeasurements = DB::connection('sqlsrv')
                                        ->table('st_unit_measurements as sum')
                                        ->leftJoin('buyer_list as bl', 'sum.id', '=', 'bl.unit_measurement_id')
                                        ->where('sum.application_id', $memo->application_id ?? null)
                                        ->select('bl.buyer_name', 'bl.buyer_title', 'sum.unit_no', 'sum.measurement', 'bl.id as buyer_id')
                                        ->get();
                                        
                                    foreach ($unitMeasurements as $measurement) {
                                        $buyerName = $measurement->buyer_name ?? 'N/A';
                                        if (!empty($measurement->buyer_title)) {
                                            $buyerName = $measurement->buyer_title . ' ' . $buyerName;
                                        }
                                        
                                        $buyers[] = [
                                            'name' => $buyerName,
                                            'unit' => $measurement->unit_no ?? 'N/A',
                                            'measurement' => $measurement->measurement ?? 'N/A'
                                        ];
                                    }
                                    
                                    // If no buyers found in buyer_list, try getting from unit measurements directly
                                    if (empty($buyers)) {
                                        $unitMeasurements = DB::connection('sqlsrv')
                                            ->table('st_unit_measurements as sum')
                                            ->leftJoin('subapplications as sub', function($join) {
                                                $join->on('sum.application_id', '=', 'sub.main_application_id')
                                                    ->on('sum.unit_no', '=', 'sub.unit_number');
                                            })
                                            ->where('sum.application_id', $memo->application_id ?? null)
                                            ->select('sum.unit_no', 'sum.measurement', 'sub.id', 
                                                'sub.applicant_type', 'sub.applicant_title', 'sub.first_name', 
                                                'sub.surname', 'sub.corporate_name', 'sub.rc_number', 
                                                'sub.multiple_owners_names', 'sub.owner_name')
                                            ->get();
                                            
                                        foreach ($unitMeasurements as $measurement) {
                                            // Format buyer name based on applicant type (if available)
                                            $buyerName = 'Owner Pending';
                                            
                                            if ($measurement->id) {
                                                if ($measurement->applicant_type == 'individual') {
                                                    $buyerName = trim(($measurement->applicant_title ?? '') . ' ' . 
                                                        ($measurement->first_name ?? '') . ' ' . 
                                                        ($measurement->surname ?? ''));
                                                } 
                                                elseif ($measurement->applicant_type == 'corporate') {
                                                    $buyerName = trim(($measurement->corporate_name ?? '') . 
                                                        (($measurement->rc_number) ? ' (RC: ' . $measurement->rc_number . ')' : ''));
                                                }
                                                elseif ($measurement->applicant_type == 'multiple' && !empty($measurement->multiple_owners_names)) {
                                                    $owners = json_decode($measurement->multiple_owners_names);
                                                    $buyerName = is_array($owners) && count($owners) > 0 ? $owners[0] . ' et al.' : 'Multiple Owners';
                                                }
                                                else {
                                                    $buyerName = $measurement->owner_name ?? 'N/A';
                                                }
                                            }
                                            
                                            $buyers[] = [
                                                'name' => $buyerName,
                                                'unit' => $measurement->unit_no ?? 'N/A',
                                                'measurement' => $measurement->measurement ?? 'N/A'
                                            ];
                                        }
                                    }
                                }
                                
                                // If still no buyers, show default
                                if (empty($buyers)) {
                                    $buyers[] = [
                                        'name' => 'No buyer information available',
                                        'unit' => 'N/A',
                                        'measurement' => 'N/A'
                                    ];
                                }
                            @endphp
                            
                            @foreach($buyers as $buyer)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $buyer['name'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $buyer['unit'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $buyer['measurement'] }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>