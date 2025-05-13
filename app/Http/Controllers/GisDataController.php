<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;

class GisDataController extends Controller
{
    public function index()
    {
        $PageTitle = 'GIS Data Capture';
        $PageDescription = '';
        
        // Get GIS data list for display using SQL Server connection
        $gisData = DB::connection('sqlsrv')->table('gisDataCapture')->orderBy('created_at', 'desc')->get();
        
        return view('gis.index', compact('PageTitle', 'PageDescription', 'gisData'));
    }  
    
    public function create()
    {
        $PageTitle = 'Capture GIS Data';
        $PageDescription = '';

        return view('gis.create', compact('PageTitle', 'PageDescription'));
    } 
    
    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'mlsfNo' => 'nullable|string',
            'kangisFileNo' => 'nullable|string',
            'NewKANGISFileno' => 'nullable|string',
            'plotNo' => 'nullable|string',
            'blockNo' => 'nullable|string',
            'approvedPlanNo' => 'nullable|string',
            'tpPlanNo' => 'nullable|string',
            'surveyedBy' => 'nullable|string',
            'drawnBy' => 'nullable|string',
            'checkedBy' => 'nullable|string',
            'passedBy' => 'nullable|string',
            'beaconControlName' => 'nullable|string',
            'beaconControlX' => 'nullable|string',
            'beaconControlY' => 'nullable|string',
            'metricSheetIndex' => 'nullable|string',
            'metricSheetNo' => 'nullable|string',
            'imperialSheet' => 'nullable|string',
            'imperialSheetNo' => 'nullable|string',
            'layoutName' => 'nullable|string',
            'districtName' => 'nullable|string',
            'lgaName' => 'nullable|string',
            'StateName' => 'nullable|string',
            'oldTitleSerialNo' => 'nullable|string',
            'oldTitlePageNo' => 'nullable|string',
            'oldTitleVolumeNo' => 'nullable|string',
            'deedsDate' => 'nullable|date',
            'deedsTime' => 'nullable',
            'certificateDate' => 'nullable|date',
            'originalAllottee' => 'nullable|string',
            'addressOfOriginalAllottee' => 'nullable|string',
            'titleIssuedYear' => 'nullable|integer',
            'changeOfOwnership' => 'nullable|string',
            'reasonForChange' => 'nullable|string',
            'currentAllottee' => 'nullable|string',
            'addressOfCurrentAllottee' => 'nullable|string',
            'titleOfCurrentAllottee' => 'nullable|string',
            'phoneNo' => 'nullable|string',
            'emailAddress' => 'nullable|email',
            'occupation' => 'nullable|string',
            'nationality' => 'nullable|string',
            'landUse' => 'nullable|string',
            'specifically' => 'nullable|string',
            'streetName' => 'nullable|string',
            'houseNo' => 'nullable|string',
            'houseType' => 'nullable|string',
            'tenancy' => 'nullable|string',
            'areaInHectares' => 'nullable|numeric',
            'SurveyorGeneralSignatureDate' => 'nullable|date',
            'CofOSerialNo' => 'nullable|string',
            'CompanyRCNo' => 'nullable|string',
        ]);
        
        // Handle file uploads
        $files = [];
        $fileFields = [
            'transactionDocument', 'passportPhoto', 'nationalId', 'internationalPassport',
            'businessRegCert', 'formCO7AndCO4', 'certOfIncorporation', 'memorandumAndArticle',
            'letterOfAdmin', 'courtAffidavit', 'policeReport', 'newspaperAdvert', 'picture', 'SurveyPlan'
        ];
        
        foreach ($fileFields as $field) {
            if ($request->hasFile($field) && $request->file($field)->isValid()) {
                $path = $request->file($field)->store('gis_documents', 'public');
                $files[$field] = $path;
            }
        }
        
        try {
            // Merge all data for storage
            $data = array_merge($validated, ['files' => json_encode($files)]);
            
            // Add metadata
            $data['created_by'] = Auth::id();
            $data['created_at'] = now();
            $data['updated_at'] = now();
            
            // Store in database using SQL Server connection and correct table name
            $id = DB::connection('sqlsrv')->table('gisDataCapture')->insertGetId($data);
            
            return redirect()->route('gis.view', $id)->with('success', 'GIS data saved successfully!');
            
        } catch (\Exception $e) {
            Log::error('GIS Data Save Error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to save GIS data. Please try again.');
        }
    }
    public function show($id)
    {
        $PageTitle = 'View Captured GIS Data';
        $PageDescription = '';
        
        // Get the GIS data record using SQL Server connection
        $gisData = DB::connection('sqlsrv')->table('gisDataCapture')->where('id', $id)->first();
        
        if (!$gisData) {
            return redirect()->route('gis.index')->with('error', 'GIS data record not found.');
        }
        
        return view('gis.view', compact('PageTitle', 'PageDescription', 'gisData'));
    }
}
