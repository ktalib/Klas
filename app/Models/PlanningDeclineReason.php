<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PlanningDeclineReason extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'planning_decline_reasons';
    
    protected $fillable = [
        'application_id',
        'submitted_by',
        'approval_date'
    ];

    /**
     * Save a complete decline reason form with all its details
     * 
     * @param int $applicationId Application ID
     * @param int $userId User who submitted the form
     * @param string $approvalDate Approval date
     * @param array $declineData Array of decline reasons and details
     * @return int|bool ID of the created record or false on failure
     */
    public static function saveDeclineReasons($applicationId, $userId, $approvalDate, $declineData)
    {
        try {
            DB::connection('sqlsrv')->beginTransaction();
            
            // Create main record
            $declineId = DB::connection('sqlsrv')->table('planning_decline_reasons')->insertGetId([
                'application_id' => $applicationId,
                'submitted_by' => $userId,
                'approval_date' => $approvalDate,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            // Process main reasons
            $reasonTypes = ['accessibility', 'land_use', 'utility', 'road_reservation'];
            foreach ($reasonTypes as $reasonType) {
                $isSelected = isset($declineData[$reasonType]) && $declineData[$reasonType];
                
                $mainReasonId = DB::connection('sqlsrv')->table('planning_decline_main_reasons')->insertGetId([
                    'decline_id' => $declineId,
                    'reason_type' => $reasonType,
                    'is_selected' => $isSelected ? 1 : 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                
                // Only process sub-reasons if main reason is selected
                if ($isSelected) {
                    self::processSubReasons($mainReasonId, $reasonType, $declineData);
                }
            }
            
            DB::connection('sqlsrv')->commit();
            return $declineId;
        } catch (\Exception $e) {
            DB::connection('sqlsrv')->rollBack();
            \Log::error('Error saving decline reasons: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Process sub-reasons for a main reason
     */
    private static function processSubReasons($mainReasonId, $reasonType, $declineData)
    {
        $subReasonMap = [
            'accessibility' => ['access_road', 'pedestrian'],
            'land_use' => ['zoning', 'density'],
            'utility' => ['overhead', 'underground'],
            'road_reservation' => ['right_of_way', 'road_width']
        ];
        
        $fieldMap = [
            'access_road' => ['location', 'type', 'measurement', 'details'],
            'pedestrian' => ['location', 'issue_type', 'measurement', 'details'],
            'zoning' => ['current_zoning', 'proposed_use', 'details'],
            'density' => ['allowed_density', 'proposed_density', 'details'],
            'overhead' => ['utility_type', 'distance', 'details'],
            'underground' => ['utility_type', 'depth', 'details'],
            'right_of_way' => ['required_setback', 'actual_setback', 'details'],
            'road_width' => ['required_width', 'actual_width', 'details']
        ];
        
        if (!isset($subReasonMap[$reasonType])) return;
        
        foreach ($subReasonMap[$reasonType] as $subReasonType) {
            $isSelected = isset($declineData[$subReasonType]) && $declineData[$subReasonType];
            
            $subReasonId = DB::connection('sqlsrv')->table('planning_decline_sub_reasons')->insertGetId([
                'main_reason_id' => $mainReasonId,
                'sub_reason_type' => $subReasonType,
                'is_selected' => $isSelected ? 1 : 0,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            // Only save field values if sub-reason is selected
            if ($isSelected && isset($fieldMap[$subReasonType])) {
                foreach ($fieldMap[$subReasonType] as $fieldName) {
                    $formField = $subReasonType . '_' . $fieldName;
                    if (isset($declineData[$formField])) {
                        DB::connection('sqlsrv')->table('planning_decline_field_values')->insert([
                            'sub_reason_id' => $subReasonId,
                            'field_name' => $fieldName,
                            'field_value' => $declineData[$formField],
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    }
                }
            }
        }
    }
    
    /**
     * Get formatted decline reasons for an application
     */
    public static function getFormattedDeclineReasons($applicationId)
    {
        $decline = DB::connection('sqlsrv')
            ->table('planning_decline_reasons')
            ->where('application_id', $applicationId)
            ->orderBy('created_at', 'desc')
            ->first();
            
        if (!$decline) return null;
        
        $result = [
            'id' => $decline->id,
            'application_id' => $decline->application_id,
            'approval_date' => $decline->approval_date,
            'reasons' => []
        ];
        
        // Get main reasons
        $mainReasons = DB::connection('sqlsrv')
            ->table('planning_decline_main_reasons')
            ->where('decline_id', $decline->id)
            ->where('is_selected', 1)
            ->get();
            
        foreach ($mainReasons as $mainReason) {
            $reasonData = [
                'type' => $mainReason->reason_type,
                'sub_reasons' => []
            ];
            
            // Get sub-reasons
            $subReasons = DB::connection('sqlsrv')
                ->table('planning_decline_sub_reasons')
                ->where('main_reason_id', $mainReason->id)
                ->where('is_selected', 1)
                ->get();
                
            foreach ($subReasons as $subReason) {
                $subReasonData = [
                    'type' => $subReason->sub_reason_type,
                    'fields' => []
                ];
                
                // Get field values
                $fieldValues = DB::connection('sqlsrv')
                    ->table('planning_decline_field_values')
                    ->where('sub_reason_id', $subReason->id)
                    ->get();
                    
                foreach ($fieldValues as $field) {
                    $subReasonData['fields'][$field->field_name] = $field->field_value;
                }
                
                $reasonData['sub_reasons'][] = $subReasonData;
            }
            
            $result['reasons'][] = $reasonData;
        }
        
        return $result;
    }
}
