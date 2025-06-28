<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ProgrammeController extends Controller
{
    // ...existing code...

    public function printBuyerList(Request $request)
    {
        $unit = $request->query('unit');
        $unit_id = $request->query('unit_id');
        $applicationId = null;

        // Extract application ID from URL
        // Use url()->current() to get the full base URL with path
        $currentUrl = url()->current();

        // Extract application ID from the current URL if present
        if (preg_match('/print_buyer_list\/(\d+)/', $currentUrl, $matches)) {
            $applicationId = $matches[1];
        } else {
            // Extract application ID from the referring URL
            $referer = $request->headers->get('referer');
            if ($referer && preg_match('/view_memo_primary\/(\d+)/', $referer, $matches)) {
            $applicationId = $matches[1];
            }
        }

        $buyers = [];

        // If specific unit and unit_id are provided in URL
        if (!empty($unit) && !empty($unit_id)) {
            // Get buyer information directly from subapplications using the unit_id
            $buyerInfo = DB::connection('sqlsrv')
                ->table('subapplications')
                ->where('id', $unit_id)
                ->first();

            // Improved measurement query for specific unit
            $unitMeasurement = DB::connection('sqlsrv')
                ->table('st_unit_measurements')
                ->where('unit_no', $unit)
                ->where('application_id', $applicationId)
                ->first();

            // Get measurement value
            $measurementValue = 'N/A';
            if ($unitMeasurement) {
                $measurementValue = $unitMeasurement->measurement ?? 'N/A';
            }

            if ($buyerInfo) {
                // Format buyer name based on applicant type
                $buyerName = 'N/A'; // Default value

                // First check if owner_name is available
                if (!empty($buyerInfo->owner_name)) {
                    $buyerName = $buyerInfo->owner_name;
                }
                // Check applicant type
                elseif ($buyerInfo->applicant_type == 'individual') {
                    $firstName = $buyerInfo->first_name ?? '';
                    $surname = $buyerInfo->surname ?? '';
                    $title = $buyerInfo->applicant_title ?? '';

                    if (!empty($firstName) || !empty($surname)) {
                        $buyerName = trim("$title $firstName $surname");
                    }
                } elseif ($buyerInfo->applicant_type == 'corporate') {
                    if (!empty($buyerInfo->corporate_name)) {
                        $buyerName = trim($buyerInfo->corporate_name);
                        if (!empty($buyerInfo->rc_number)) {
                            $buyerName .= " (RC: {$buyerInfo->rc_number})";
                        }
                    }
                } elseif ($buyerInfo->applicant_type == 'multiple' && !empty($buyerInfo->multiple_owners_names)) {
                    $owners = json_decode($buyerInfo->multiple_owners_names, true);
                    if (is_array($owners) && count($owners) > 0) {
                        $buyerName = implode(', ', $owners);
                    } else {
                        $buyerName = 'Multiple Owners';
                    }
                }

                $buyers[] = [
                    'name' => $buyerName,
                    'unit' => $unit,
                    'measurement' => $measurementValue
                ];
            } else {
                $buyers[] = [
                    'name' => "No buyer data found",
                    'unit' => $unit,
                    'measurement' => $measurementValue
                ];
            }
        } else {
            // No specific unit requested, get all buyers from buyer_list

            // Use DISTINCT to avoid duplicates and GROUP BY
            $buyersList = DB::connection('sqlsrv')
                ->table('buyer_list as bl')
                ->select(DB::raw('DISTINCT bl.buyer_title, bl.buyer_name, bl.unit_no, MAX(sum.measurement) as measurement'))
                ->leftJoin('st_unit_measurements as sum', function ($join) use ($applicationId) {
                    $join->on('bl.unit_no', '=', 'sum.unit_no')
                        ->where('sum.application_id', '=', $applicationId);
                })
                ->where('bl.application_id', $applicationId)
                // If there's a unit number but no unit_id, filter by unit number only
                ->when(!empty($unit), function ($query) use ($unit) {
                    return $query->where('bl.unit_no', $unit);
                })
                ->groupBy('bl.buyer_title', 'bl.buyer_name', 'bl.unit_no')
                ->get();

            // Process distinct buyers
            $processedBuyers = [];
            if (count($buyersList) > 0) {
                foreach ($buyersList as $buyer) {
                    $buyerName = $buyer->buyer_name ?? 'N/A';
                    if (!empty($buyer->buyer_title)) {
                        $buyerName = $buyer->buyer_title . ' ' . $buyerName;
                    }

                    $key = $buyerName . '-' . $buyer->unit_no;
                    if (!isset($processedBuyers[$key])) {
                        $processedBuyers[$key] = true; // Mark as processed
                        $buyers[] = [
                            'name' => $buyerName,
                            'unit' => $buyer->unit_no ?? 'N/A',
                            'measurement' => $buyer->measurement ?? 'N/A'
                        ];
                    }
                }
            } else {
                // Fallback: Try a different approach to get buyers

                // Try with a simpler join
                $buyersList = DB::connection('sqlsrv')
                    ->table('buyer_list as bl')
                    ->leftJoin('st_unit_measurements as sum', 'bl.unit_measurement_id', '=', 'sum.id')
                    ->where('sum.application_id', $applicationId)
                    ->select('bl.buyer_title', 'bl.buyer_name', 'bl.unit_no', 'sum.measurement')
                    ->get();

                if (count($buyersList) > 0) {
                    foreach ($buyersList as $buyer) {
                        $buyerName = $buyer->buyer_name ?? 'N/A';
                        if (!empty($buyer->buyer_title)) {
                            $buyerName = $buyer->buyer_title . ' ' . $buyerName;
                        }

                        $buyers[] = [
                            'name' => $buyerName,
                            'unit' => $buyer->unit_no ?? 'N/A',
                            'measurement' => $buyer->measurement ?? 'N/A'
                        ];
                    }
                } else {
                    // Fallback: If no buyers found in buyer_list, try alternative queries

                    // Try querying directly from st_unit_measurements
                    $unitMeasurements = DB::connection('sqlsrv')
                        ->table('st_unit_measurements as sum')
                        ->leftJoin('subapplications as sub', function ($join) {
                            $join->on('sum.application_id', '=', 'sub.main_application_id')
                                ->on('sum.unit_no', '=', 'sub.unit_number');
                        })
                        ->where('sum.application_id', $applicationId)
                        ->select(
                            'sum.unit_no',
                            'sum.measurement',
                            'sub.id',
                            'sub.applicant_type',
                            'sub.applicant_title',
                            'sub.first_name',
                            'sub.surname',
                            'sub.corporate_name',
                            'sub.rc_number',
                            'sub.multiple_owners_names'
                        )
                        ->get();

                    // Process unit measurements results
                    foreach ($unitMeasurements as $measurement) {
                        // Format buyer name based on applicant type (if available)
                        $buyerName = 'Owner Pending';

                        if ($measurement->id) {
                            if ($measurement->applicant_type == 'individual') {
                                $buyerName = trim(
                                    ($measurement->applicant_title ?? '') . ' ' .
                                        ($measurement->first_name ?? '') . ' ' .
                                        ($measurement->surname ?? '')
                                );
                            } elseif ($measurement->applicant_type == 'corporate') {
                                $buyerName = trim(
                                    ($measurement->corporate_name ?? '') .
                                        (($measurement->rc_number) ? ' (RC: ' . $measurement->rc_number . ')' : '')
                                );
                            } elseif ($measurement->applicant_type == 'multiple' && !empty($measurement->multiple_owners_names)) {
                                $owners = json_decode($measurement->multiple_owners_names);
                                $buyerName = is_array($owners) && count($owners) > 0 ? $owners[0] . ' et al.' : 'Multiple Owners';
                            } else {
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
        }

        // If still no buyers, show default
        if (count($buyers) == 0) {
            $buyers[] = [
                'name' => 'No buyer information available',
                'unit' => 'N/A',
                'measurement' => 'N/A'
            ];
        }

        $data = ['buyers' => $buyers];

        $pdf = PDF::loadView('programmes.buyer_list', $data);
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('buyer_list.pdf');
    }
}