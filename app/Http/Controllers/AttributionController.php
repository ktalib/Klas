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
        $PageTitle = 'Attributions';
        $PageDescription = '';
        $surveys = DB::connection('sqlsrv')->table('surveyCadastralRecord')->get(); // Fetch survey records

        return view('attribution.index', compact(
           'PageTitle',
            'PageDescription',
            'surveys' // Pass surveys to the view
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
}