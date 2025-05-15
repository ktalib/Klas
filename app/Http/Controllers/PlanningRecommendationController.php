<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PlanningRecommendationController extends Controller
{
    public function getSitePlanDimensions($applicationId)
    {
        $dimensions = DB::connection('sqlsrv')
            ->table('site_plan_dimensions')
            ->where('application_id', $applicationId)
            ->orderBy('order')
            ->get();
        
        return response()->json($dimensions);
    }
    
    public function getSharedUtilities($applicationId)
    {
        // For debugging - log input
        \Log::info("Fetching shared utilities for application: {$applicationId}");
        
        // First get existing shared utilities from the database
        $existingUtilities = DB::connection('sqlsrv')
            ->table('shared_utilities')
            ->where('application_id', $applicationId)
            ->orderBy('order')
            ->get();
        
        \Log::info("Existing utilities count: " . count($existingUtilities));
        
        // Get shared areas from mother_applications
        $application = DB::connection('sqlsrv')
            ->table('mother_applications')
            ->where('id', $applicationId)
            ->first();
        
        if (!$application) {
            \Log::warning("Application not found: {$applicationId}");
            return response()->json([]);
        }
        
        $sharedAreasJson = $application->shared_areas;
        \Log::info("Raw shared_areas from DB: " . json_encode($sharedAreasJson));
        
        $sharedAreas = [];
        if (!empty($sharedAreasJson)) {
            if (is_string($sharedAreasJson)) {
                // Try to decode JSON string
                $sharedAreas = json_decode($sharedAreasJson, true);
                \Log::info("Decoded shared areas: " . json_encode($sharedAreas));
            } elseif (is_array($sharedAreasJson)) {
                // Already an array
                $sharedAreas = $sharedAreasJson;
            }
            
            // If not array (could be a string or null), convert to array 
            if (!is_array($sharedAreas)) {
                \Log::warning("shared_areas is not an array, type: " . gettype($sharedAreas));
                // Try to convert comma-separated string to array if needed
                if (is_string($sharedAreasJson) && strpos($sharedAreasJson, ',') !== false) {
                    $sharedAreas = array_map('trim', explode(',', $sharedAreasJson));
                } else {
                    $sharedAreas = [];
                }
            }
        }
        
        \Log::info("Final shared areas array: " . json_encode($sharedAreas));
        
        // Get physical planning data
        $physicalPlanningData = DB::connection('sqlsrv')
            ->table('physicalPlanning')
            ->where('application_id', $applicationId)
            ->get();
        
        \Log::info("Physical planning data count: " . count($physicalPlanningData));
        
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
                \Log::info("Area already exists in utilities: {$area}");
                continue;
            }
            
            \Log::info("Adding new utility from shared_area: {$area}");
            
            // Create new utility entry from shared_area
            $newUtility = (object)[
                'id' => null,
                'application_id' => $applicationId,
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
                \Log::info("Found matching physical planning data for: {$area}");
            }
            
            $result->push($newUtility);
        }
        
        // If we still have no utilities, create at least one with common default
        if ($result->isEmpty() && !empty($sharedAreas)) {
            \Log::info("No utilities found, creating a default entry");
            $result->push((object)[
                'id' => null,
                'application_id' => $applicationId,
                'utility_type' => $sharedAreas[0] ?? 'Common Area',
                'dimension' => 0,
                'count' => 1,
                'order' => 1
            ]);
        }
        
        \Log::info("Final utilities result count: " . $result->count());
        return response()->json($result->values());
    }
    
    public function saveSitePlanDimension(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'application_id' => 'required|integer',
            'description' => 'required|string|max:255',
            'dimension' => 'required|numeric',
            'order' => 'nullable|integer'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        $id = $request->input('id');
        $data = [
            'application_id' => $request->input('application_id'),
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
            'application_id' => 'required|integer',
            'utility_type' => 'required|string|max:255',
            'dimension' => 'required|numeric',
            'count' => 'required|integer',
            'order' => 'nullable|integer'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        $id = $request->input('id');
        $applicationId = $request->input('application_id');
        $utilityType = $request->input('utility_type');
        $dimension = $request->input('dimension');
        $count = $request->input('count');
        $order = $request->input('order', 0);
        
        $data = [
            'application_id' => $applicationId,
            'utility_type' => $utilityType,
            'dimension' => $dimension,
            'count' => $count,
            'order' => $order
        ];
        
        // First, let's capture what is changing for logging
        if ($id) {
            $existingUtility = DB::connection('sqlsrv')
                ->table('shared_utilities')
                ->where('id', $id)
                ->first();
            
            \Log::info("Updating utility: ID {$id}, from {$existingUtility->utility_type} to {$utilityType}, dimension from {$existingUtility->dimension} to {$dimension}, count from {$existingUtility->count} to {$count}");
        } else {
            \Log::info("Creating new utility: {$utilityType}, dimension {$dimension}, count {$count}");
        }
        
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
                ->where('application_id', $applicationId)
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
                
                \Log::info("Updated physicalPlanning: ID {$existingPP->id}, utility {$utilityType}");
            } else {
                // Create new record in physicalPlanning
                $ppId = DB::connection('sqlsrv')
                    ->table('physicalPlanning')
                    ->insertGetId([
                        'application_id' => $applicationId,
                        'Shared_Utilities_List' => $utilityType,
                        'Recommended_Size' => $dimension,
                        'count' => $count,
                        'Area_Under_Application' => 'Auto-generated from planning recommendation'
                    ]);
                
                \Log::info("Created physicalPlanning: ID {$ppId}, utility {$utilityType}");
            }
        } catch (\Exception $e) {
            \Log::error("Error updating physicalPlanning: " . $e->getMessage());
            // We'll continue rather than fail the whole operation
        }
        
        return response()->json(['success' => true, 'utility' => $utility]);
    }
    
    /**
     * Batch update utilities and sync with physicalPlanning table
     */
    public function batchUpdateUtilities(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'application_id' => 'required|integer',
            'utilities' => 'required|array',
            'utilities.*.utility_type' => 'required|string|max:255',
            'utilities.*.dimension' => 'required|numeric',
            'utilities.*.count' => 'required|integer',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        $applicationId = $request->input('application_id');
        $utilities = $request->input('utilities');
        $updatedUtilities = [];
        
        \Log::info("Starting batch utility update for application {$applicationId} with " . count($utilities) . " utilities");
        
        foreach ($utilities as $utilityData) {
            $id = $utilityData['id'] ?? null;
            $utilityType = $utilityData['utility_type'];
            $dimension = $utilityData['dimension'];
            $count = $utilityData['count'];
            
            $data = [
                'application_id' => $applicationId,
                'utility_type' => $utilityType,
                'dimension' => $dimension,
                'count' => $count,
                'order' => $utilityData['order'] ?? 0
            ];
            
            // Update or create in shared_utilities table
            if ($id) {
                DB::connection('sqlsrv')
                    ->table('shared_utilities')
                    ->where('id', $id)
                    ->update($data);
                    
                $utility = DB::connection('sqlsrv')
                    ->table('shared_utilities')
                    ->where('id', $id)
                    ->first();
                    
                \Log::info("Updated utility ID {$id}: {$utilityType}, dimension: {$dimension}, count: {$count}");
            } else {
                $id = DB::connection('sqlsrv')
                    ->table('shared_utilities')
                    ->insertGetId($data);
                    
                $utility = DB::connection('sqlsrv')
                    ->table('shared_utilities')
                    ->where('id', $id)
                    ->first();
                    
                \Log::info("Created new utility: {$utilityType}, dimension: {$dimension}, count: {$count}, ID: {$id}");
            }
            
            // Update or create in physicalPlanning table
            try {
                $existingPP = DB::connection('sqlsrv')
                    ->table('physicalPlanning')
                    ->where('application_id', $applicationId)
                    ->where('Shared_Utilities_List', $utilityType)
                    ->first();
                    
                if ($existingPP) {
                    DB::connection('sqlsrv')
                        ->table('physicalPlanning')
                        ->where('id', $existingPP->id)
                        ->update([
                            'Recommended_Size' => $dimension,
                            'count' => $count,
                        ]);
                        
                    \Log::info("Updated physicalPlanning ID {$existingPP->id} for utility {$utilityType}");
                } else {
                    $ppId = DB::connection('sqlsrv')
                        ->table('physicalPlanning')
                        ->insertGetId([
                            'application_id' => $applicationId,
                            'Shared_Utilities_List' => $utilityType,
                            'Recommended_Size' => $dimension,
                            'count' => $count,
                            'Area_Under_Application' => 'Auto-generated from batch update'
                        ]);
                        
                    \Log::info("Created physicalPlanning record ID {$ppId} for utility {$utilityType}");
                }
            } catch (\Exception $e) {
                \Log::error("Error updating physicalPlanning for {$utilityType}: " . $e->getMessage());
            }
            
            $updatedUtilities[] = $utility;
        }
        
        \Log::info("Completed batch utility update with " . count($updatedUtilities) . " utilities updated");
        
        return response()->json([
            'success' => true,
            'message' => 'All utilities updated successfully',
            'utilities' => $updatedUtilities
        ]);
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
     * Debug endpoint to view raw shared areas data
     */
    public function debugSharedAreas($applicationId)
    {
        // Get application data
        $application = DB::connection('sqlsrv')
            ->table('mother_applications')
            ->where('id', $applicationId)
            ->first();
            
        if (!$application) {
            return response()->json([
                'error' => 'Application not found',
                'application_id' => $applicationId
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
            ->where('application_id', $applicationId)
            ->get();
            
        // Get physical planning data
        $physicalPlanning = DB::connection('sqlsrv')
            ->table('physicalPlanning')
            ->where('application_id', $applicationId)
            ->get();
        
        return response()->json([
            'application_id' => $applicationId,
            'shared_areas_raw' => $sharedAreasRaw,
            'shared_areas_parsed' => $sharedAreasParsed,
            'utilities_count' => count($utilities),
            'utilities' => $utilities,
            'physical_planning_count' => count($physicalPlanning),
            'physical_planning' => $physicalPlanning
        ]);
    }
}
