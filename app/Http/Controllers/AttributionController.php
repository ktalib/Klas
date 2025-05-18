<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class  AttributionController extends Controller
{
    public function Attributions()
    {
        $PageTitle = 'Attributions  (Survey)';
        $PageDescription = '';
        $surveys = DB::connection('sqlsrv')->table('surveyCadastralRecord')->get(); // Fetch survey records

        return view('attribution.index', compact(
           'PageTitle',
            'PageDescription',
            'surveys' // Pass surveys to the view
        ));
    }

    public function create()
    {
        $PageTitle = 'Create Survey';
        $PageDescription = 'Create a new survey record';

        return view('attribution.create', compact(
            'PageTitle',
            'PageDescription'
        ));
    }


    public function editSurvey($id)
    {
        $PageTitle = 'Update Survey';
        $PageDescription = 'Edit survey details';
        $survey = DB::connection('sqlsrv')->table('surveyCadastralRecord')->where('ID', $id)->first(); // Fetch survey record by ID

        if (!$survey) {
            abort(404, 'Survey record not found');
        }

        return view('attribution.update_survey', compact(
            'PageTitle',
            'PageDescription',
            'survey' // Pass survey data to the view
        ));
    }
      public function store(Request $request)
    {
        $validatedData = $request->validate([
            'application_id' => 'nullable',
            'sub_application_id' => 'nullable',
            'plot_no' => 'required|string|max:255',
            'block_no' => 'required|string|max:255',
            'approved_plan_no' => 'required|string|max:255',
            'tp_plan_no' => 'required|string|max:255',
            'beacon_control_name' => 'required|string|max:255',
            'Control_Beacon_Coordinate_X' => 'required|string|max:255',
            'Control_Beacon_Coordinate_Y' => 'required|string|max:255',
            'Metric_Sheet_Index' => 'required|string|max:255',
            'Metric_Sheet_No' => 'required|string|max:255',
            'Imperial_Sheet' => 'required|string|max:255',
            'Imperial_Sheet_No' => 'required|string|max:255',
            'layout_name' => 'required|string|max:255',
            'district_name' => 'required|string|max:255',
            'lga_name' => 'required|string|max:255',
            'survey_by' => 'required|string|max:255',
            'survey_by_date' => 'nullable|date',
            'drawn_by' => 'nullable|string|max:255',
            'drawn_by_date' => 'nullable|date',
            'checked_by' => 'nullable|string|max:255',
            'checked_by_date' => 'nullable|date',
            'approved_by' => 'nullable|string|max:255',
            'approved_by_date' => 'nullable|date',
        ]);

        DB::connection('sqlsrv')->table('surveyCadastralRecord')->insert($validatedData);

        return redirect()->route('attribution.index')->with('success', __('Survey created successfully.'));
    }

    /**
     * Update the survey record.
  
     */
    public function updateSurvey(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|integer',
            'plot_no' => 'nullable|string|max:255',
            'block_no' => 'nullable|string|max:255',
            'approved_plan_no' => 'nullable|string|max:255',
            'tp_plan_no' => 'nullable|string|max:255',
            'beacon_control_name' => 'nullable|string|max:255',
            'Control_Beacon_Coordinate_X' => 'nullable|string|max:255',
            'Control_Beacon_Coordinate_Y' => 'nullable|string|max:255',
            'Metric_Sheet_Index' => 'nullable|string|max:255',
            'Metric_Sheet_No' => 'nullable|string|max:255',
            'Imperial_Sheet' => 'nullable|string|max:255',
            'Imperial_Sheet_No' => 'nullable|string|max:255',
            'layout_name' => 'nullable|string|max:255',
            'district_name' => 'nullable|string|max:255',
            'lga_name' => 'nullable|string|max:255',
            'survey_by' => 'nullable|string|max:255',
            'survey_by_date' => 'nullable|date',
            'drawn_by' => 'nullable|string|max:255',
            'drawn_by_date' => 'nullable|date',
            'checked_by' => 'nullable|string|max:255',
            'checked_by_date' => 'nullable|date',
            'approved_by' => 'nullable|string|max:255',
            'approved_by_date' => 'nullable|date',
        ]);

        $updated = DB::connection('sqlsrv')
            ->table('surveyCadastralRecord')
            ->where('ID', $validatedData['id'])
            ->update(Arr::except($validatedData, ['id']));

        if ($updated) {
            return redirect()->route('attribution.index')->with('success', 'Survey updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to update survey. Please try again.');
        }
    }
    
    /**
     * Search for application by file number
     */
    public function searchFileNo(Request $request)
    {
        $fileNo = $request->input('fileno');
        $type = $request->input('type', 'primary'); // default to primary
        $isInitial = $request->input('initial', false); // Flag for initial load
        $page = $request->input('page', 1); // For pagination
        $limit = 20; // Number of records per page
        $offset = ($page - 1) * $limit;
        
        if ($type === 'primary') {
            // Search in mother_applications
            $query = DB::connection('sqlsrv')->table('mother_applications')
                ->select('id', 'applicant_title', 'first_name', 'surname', 'fileno', 
                         'corporate_name', 'multiple_owners_names', 'land_use', 'applicant_type');
            
            // Apply search filter or get initial records
            if (!empty($fileNo)) {
                $query->where('fileno', 'LIKE', '%' . $fileNo . '%');
            } else if ($isInitial) {
                // For initial load, order by most recent
                $query->orderBy('id', 'desc');
            }
            
            // Get total count for pagination
            $total = $query->count();
            
            // Apply pagination
            $applications = $query->skip($offset)->take($limit)->get();
                
            if ($applications && count($applications) > 0) {
                return response()->json([
                    'success' => true,
                    'applications' => $applications,
                    'pagination' => [
                        'more' => ($offset + $limit) < $total
                    ],
                    'message' => 'Applications found'
                ]);
            }
        } else {
            // Search in subapplications
            $query = DB::connection('sqlsrv')->table('subapplications')
                ->select('subapplications.id', 'subapplications.applicant_title', 'subapplications.first_name', 
                         'subapplications.surname', 'subapplications.fileno', 'subapplications.corporate_name', 
                         'subapplications.multiple_owners_names', 'subapplications.land_use', 
                         'subapplications.main_application_id', 'subapplications.applicant_type',
                         'mother_applications.fileno as primary_fileno', 'subapplications.scheme_no')
                ->leftJoin('mother_applications', 'subapplications.main_application_id', '=', 'mother_applications.id');
            
            // Apply search filter or get initial records
            if (!empty($fileNo)) {
                $query->where('subapplications.fileno', 'LIKE', '%' . $fileNo . '%');
            } else if ($isInitial) {
                // For initial load, order by most recent
                $query->orderBy('subapplications.id', 'desc');
            }
            
            // Get total count for pagination
            $total = $query->count();
            
            // Apply pagination
            $applications = $query->skip($offset)->take($limit)->get();
                
            if ($applications && count($applications) > 0) {
                return response()->json([
                    'success' => true,
                    'applications' => $applications,
                    'pagination' => [
                        'more' => ($offset + $limit) < $total
                    ],
                    'message' => 'Applications found'
                ]);
            }
        }
        
        return response()->json([
            'success' => false,
            'message' => $isInitial ? 'No file numbers available' : 'No application found with the given file number'
        ]);
    }
}