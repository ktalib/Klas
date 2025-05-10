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
        $utilities = DB::connection('sqlsrv')
            ->table('shared_utilities')
            ->where('application_id', $applicationId)
            ->orderBy('order')
            ->get();
        
        return response()->json($utilities);
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
        $data = [
            'application_id' => $request->input('application_id'),
            'utility_type' => $request->input('utility_type'),
            'dimension' => $request->input('dimension'),
            'count' => $request->input('count'),
            'order' => $request->input('order', 0)
        ];
        
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
}
