<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SubPlanningRecommendationController extends Controller
{
    public function getSitePlanDimensions($subApplicationId)
    {
        $dimensions = DB::connection('sqlsrv')
            ->table('site_plan_dimensions')
            ->where('sub_application_id', $subApplicationId)
            ->orderBy('order')
            ->get();
        
        return response()->json($dimensions);
    }
    
    public function getSharedUtilities($subApplicationId)
    {
        // First get existing shared utilities from the database
        $existingUtilities = DB::connection('sqlsrv')
            ->table('shared_utilities')
            ->where('sub_application_id', $subApplicationId)
            ->orderBy('order')
            ->get();
        
        // Get shared areas from subapplications
        $application = DB::connection('sqlsrv')
            ->table('subapplications')
            ->where('id', $subApplicationId)
            ->first();
        
        if (!$application) {
            return response()->json([]);
        }
        
        $sharedAreasJson = $application->shared_areas;
        
        $sharedAreas = [];
        if (!empty($sharedAreasJson)) {
            if (is_string($sharedAreasJson)) {
                // Try to decode JSON string
                $sharedAreas = json_decode($sharedAreasJson, true);
            } elseif (is_array($sharedAreasJson)) {
                // Already an array
                $sharedAreas = $sharedAreasJson;
            }
            
            // If not array (could be a string or null), convert to array 
            if (!is_array($sharedAreas)) {
                // Try to convert comma-separated string to array if needed
                if (is_string($sharedAreasJson) && strpos($sharedAreasJson, ',') !== false) {
                    $sharedAreas = array_map('trim', explode(',', $sharedAreasJson));
                } else {
                    $sharedAreas = [];
                }
            }
        }
        
        // Get physical planning data
        $physicalPlanningData = DB::connection('sqlsrv')
            ->table('physicalPlanning')
            ->where('sub_application_id', $subApplicationId)
            ->get();
        
        // Convert to collection and key by utility type
        $physicalPlanningDataKeyed = collect($physicalPlanningData)->keyBy('Shared_Utilities_List');
        
        // Prepare result - start with existing utilities
        $result = collect($existingUtilities);
        
        // Add entries from shared_areas that don't exist in utilities yet
        foreach ($sharedAreas as $area) {
            if (empty($area)) continue; // Skip empty entries
            
            // Skip if already exists in the result
            $exists = $result->where('utility_type', $area)->first();
            if ($exists) {
                continue;
            }
            
            // Create new utility entry from shared_area
            $newUtility = (object)[
                'id' => null,
                'sub_application_id' => $subApplicationId,
                'utility_type' => $area,
                'dimension' => 0,
                'count' => 1,  // Default to 1 count
                'order' => $result->count() + 1
            ];
            
            // Check if we have data in physicalPlanning
            if ($physicalPlanningDataKeyed->has($area)) {
                $ppData = $physicalPlanningDataKeyed[$area];
                $newUtility->dimension = $ppData->Recommended_Size ?? 0;
                $newUtility->count = $ppData->count ?? 1;
            }
            
            $result->push($newUtility);
        }
        
        // If we still have no utilities, create at least one with common default
        if ($result->isEmpty() && !empty($sharedAreas)) {
            $result->push((object)[
                'id' => null,
                'sub_application_id' => $subApplicationId,
                'utility_type' => $sharedAreas[0] ?? 'Common Area',
                'dimension' => 0,
                'count' => 1,
                'order' => 1
            ]);
        }
        
        return response()->json($result->values());
    }
    
    public function saveSitePlanDimension(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sub_application_id' => 'required|integer',
            'description' => 'required|string|max:255',
            'dimension' => 'required|numeric',
            'order' => 'nullable|integer'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        $id = $request->input('id');
        $data = [
            'sub_application_id' => $request->input('sub_application_id'),
            'description' => $request->input('description'),
            'dimension' => $request->input('dimension'),
            'order' => $request->input('order', 0)
        ];
        
        if ($id) {
            // Update existing record
            DB::connection('sqlsrv')
                ->table('site_plan_dimensions')
                ->where('id', $id)
                ->update($data);
                
            $dimension = DB::connection('sqlsrv')
                ->table('site_plan_dimensions')
                ->where('id', $id)
                ->first();
        } else {
            // Create new record
            $id = DB::connection('sqlsrv')
                ->table('site_plan_dimensions')
                ->insertGetId($data);
                
            $dimension = DB::connection('sqlsrv')
                ->table('site_plan_dimensions')
                ->where('id', $id)
                ->first();
        }
        
        return response()->json(['success' => true, 'dimension' => $dimension]);
    }
    
    public function saveSharedUtility(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sub_application_id' => 'required|integer',
            'utility_type' => 'required|string|max:255',
            'dimension' => 'required|numeric',
            'count' => 'required|integer',
            'order' => 'nullable|integer'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        $id = $request->input('id');
        $subApplicationId = $request->input('sub_application_id');
        $utilityType = $request->input('utility_type');
        $dimension = $request->input('dimension');
        $count = $request->input('count');
        $order = $request->input('order', 0);
        
        $data = [
            'sub_application_id' => $subApplicationId,
            'utility_type' => $utilityType,
            'dimension' => $dimension,
            'count' => $count,
            'order' => $order
        ];
        
        // Update or create in shared_utilities table
        if ($id) {
            // Update existing record
            DB::connection('sqlsrv')
                ->table('shared_utilities')
                ->where('id', $id)
                ->update($data);
                
            $utility = DB::connection('sqlsrv')
                ->table('shared_utilities')
                ->where('id', $id)
                ->first();
        } else {
            // Create new record
            $id = DB::connection('sqlsrv')
                ->table('shared_utilities')
                ->insertGetId($data);
                
            $utility = DB::connection('sqlsrv')
                ->table('shared_utilities')
                ->where('id', $id)
                ->first();
        }
        
        // Now also update or create in physicalPlanning table - with improved error handling
        try {
            $existingPP = DB::connection('sqlsrv')
                ->table('physicalPlanning')
                ->where('sub_application_id', $subApplicationId)
                ->where('Shared_Utilities_List', $utilityType)
                ->first();
                
            $ppData = [
                'Recommended_Size' => $dimension,
                'count' => $count,
            ];
            
            if ($existingPP) {
                // Update existing record
                DB::connection('sqlsrv')
                    ->table('physicalPlanning')
                    ->where('id', $existingPP->id)
                    ->update($ppData);
            } else {
                // Create new record in physicalPlanning
                DB::connection('sqlsrv')
                    ->table('physicalPlanning')
                    ->insertGetId([
                        'sub_application_id' => $subApplicationId,
                        'Shared_Utilities_List' => $utilityType,
                        'Recommended_Size' => $dimension,
                        'count' => $count,
                        'Area_Under_Application' => 'Auto-generated from planning recommendation'
                    ]);
            }
        } catch (\Exception $e) {
            // Continue without failing the whole operation
        }
        
        return response()->json(['success' => true, 'utility' => $utility]);
    }
    
    public function deleteSitePlanDimension(Request $request)
    {
        $id = $request->input('id');
        
        DB::connection('sqlsrv')
            ->table('site_plan_dimensions')
            ->where('id', $id)
            ->delete();
        
        return response()->json(['success' => true]);
    }
    
    public function deleteSharedUtility(Request $request)
    {
        $id = $request->input('id');
        
        DB::connection('sqlsrv')
            ->table('shared_utilities')
            ->where('id', $id)
            ->delete();
        
        return response()->json(['success' => true]);
    }
    
    /**
     * Debug endpoint to view shared areas data
     */
    public function debugSharedAreas($subApplicationId)
    {
        // Get application data
        $application = DB::connection('sqlsrv')
            ->table('subapplications')
            ->where('id', $subApplicationId)
            ->first();
            
        if (!$application) {
            return response()->json([
                'error' => 'Sub application not found',
                'sub_application_id' => $subApplicationId
            ]);
        }
        
        // Get shared areas
        $sharedAreasRaw = $application->shared_areas;
        $sharedAreasParsed = null;
        
        if (is_string($sharedAreasRaw)) {
            // Try to parse as JSON
            $sharedAreasParsed = json_decode($sharedAreasRaw, true);
        }
        
        // Get all utilities for this application
        $utilities = DB::connection('sqlsrv')
            ->table('shared_utilities')
            ->where('sub_application_id', $subApplicationId)
            ->get();
            
        // Get physical planning data
        $physicalPlanning = DB::connection('sqlsrv')
            ->table('physicalPlanning')
            ->where('sub_application_id', $subApplicationId)
            ->get();
        
        return response()->json([
            'sub_application_id' => $subApplicationId,
            'shared_areas_raw' => $sharedAreasRaw,
            'shared_areas_parsed' => $sharedAreasParsed,
            'utilities_count' => count($utilities),
            'utilities' => $utilities,
            'physical_planning_count' => count($physicalPlanning),
            'physical_planning' => $physicalPlanning
        ]);
    }
}
