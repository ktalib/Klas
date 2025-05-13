@extends('layouts.app')
@section('page-title')
    {{ __('Attributions') }}
@endsection


@include('sectionaltitling.partials.assets.css')
@section('content')
<div class="flex-1 overflow-auto">
    <!-- Header -->
   @include('admin.header')
    <!-- Dashboard Content -->
    <div class="p-6">
      <!-- Stats Cards -->
        
      
      <!-- Secondary Applications Table - Screenshot 135 -->
      <div class="bg-white rounded-md shadow-sm border border-gray-200 p-6">
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-xl font-bold">Survey Record</h2>
          
          <div class="flex items-center space-x-4">
            <button   class="flex items-center space-x-2 px-4 py-2 bg-green-700 text-white rounded-md hover:bg-green-800">
              <i data-lucide="plus" class="w-4 h-4"></i>
              <span>Create New Survey</span>
            </button>
            <button class="flex items-center space-x-2 px-4 py-2 border border-gray-200 rounded-md">
              <i data-lucide="download" class="w-4 h-4 text-gray-600"></i>
              <span>Export</span>
            </button>
          </div>
        </div>
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead>
              <tr class="text-xs">
                <th class="px-4 py-2 text-left text-sm font-medium text-green-500">File No</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-green-500">Plot No</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-green-500">Block No</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-green-500">Approved Plan No</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-green-500">TP Plan No</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-green-500">Control Beacon Name</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-green-500">Control Beacon X</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-green-500">Control Beacon Y</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-green-500">Metric Sheet Index</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-green-500">Metric Sheet No</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-green-500">Imperial Sheet</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-green-500">Imperial Sheet No</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-green-500">Layout Name</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-green-500">District Name</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-green-500">LGA Name</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-green-500">Survey By</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-green-500">Survey Date</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-green-500">Drawn By</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-green-500">Drawn Date</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-green-500">Checked By</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-green-500">Checked Date</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-green-500">Approved By</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-green-500">Approved Date</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-green-500">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($surveys as $survey)
              <tr class="text-xs">
                <td class="px-4 py-2 text-sm text-gray-700">{{ $survey->fileno }}</td>
                <td class="px-4 py-2 text-sm text-gray-700">{{ $survey->plot_no }}</td>
                <td class="px-4 py-2 text-sm text-gray-700">{{ $survey->block_no }}</td>
                <td class="px-4 py-2 text-sm text-gray-700">{{ $survey->approved_plan_no }}</td>
                <td class="px-4 py-2 text-sm text-gray-700">{{ $survey->tp_plan_no }}</td>
                <td class="px-4 py-2 text-sm text-gray-700">{{ $survey->beacon_control_name }}</td>
                <td class="px-4 py-2 text-sm text-gray-700">{{ $survey->Control_Beacon_Coordinate_X }}</td>
                <td class="px-4 py-2 text-sm text-gray-700">{{ $survey->Control_Beacon_Coordinate_Y }}</td>
                <td class="px-4 py-2 text-sm text-gray-700">{{ $survey->Metric_Sheet_Index }}</td>
                <td class="px-4 py-2 text-sm text-gray-700">{{ $survey->Metric_Sheet_No }}</td>
                <td class="px-4 py-2 text-sm text-gray-700">{{ $survey->Imperial_Sheet }}</td>
                <td class="px-4 py-2 text-sm text-gray-700">{{ $survey->Imperial_Sheet_No }}</td>
                <td class="px-4 py-2 text-sm text-gray-700">{{ $survey->layout_name }}</td>
                <td class="px-4 py-2 text-sm text-gray-700">{{ $survey->district_name }}</td>
                <td class="px-4 py-2 text-sm text-gray-700">{{ $survey->lga_name }}</td>
                <td class="px-4 py-2 text-sm text-gray-700">{{ $survey->survey_by }}</td>
                <td class="px-4 py-2 text-sm text-gray-700">{{ $survey->survey_by_date }}</td>
                <td class="px-4 py-2 text-sm text-gray-700">{{ $survey->drawn_by }}</td>
                <td class="px-4 py-2 text-sm text-gray-700">{{ $survey->drawn_by_date }}</td>
                <td class="px-4 py-2 text-sm text-gray-700">{{ $survey->checked_by }}</td>
                <td class="px-4 py-2 text-sm text-gray-700">{{ $survey->checked_by_date }}</td>
                <td class="px-4 py-2 text-sm text-gray-700">{{ $survey->approved_by }}</td>
                <td class="px-4 py-2 text-sm text-gray-700">{{ $survey->approved_by_date }}</td>
                <td class="px-4 py-2 text-sm text-gray-700">
                <a href="{{ url('attribution/update-survey/' . $survey->ID) }}" class="flex items-center px-3 py-1 text-xs bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    <i data-lucide="edit" class="w-4 h-4 mr-1"></i> Update
                </a>
                </td>

                 
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="flex justify-between items-center mt-6 text-sm">
          <div class="text-green-500">Showing 5 of 180 applications</div>
          <div class="flex items-center space-x-2">
            <button class="px-3 py-1 border border-gray-200 rounded-md flex items-center">
              <i data-lucide="chevron-left" class="w-4 h-4 mr-1"></i>
              <span>Previous</span>
            </button>
            <button class="px-3 py-1 border border-gray-200 rounded-md flex items-center">
              <span>Next</span>
              <i data-lucide="chevron-right" class="w-4 h-4 ml-1"></i>
            </button>
          </div>
        </div>
      </div>
    
    </div>
    <!-- Footer -->
    @include('admin.footer')
  </div>
 
@endsection

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
window.showFullNames = function(owners) {
  if (!Array.isArray(owners)) {
    owners = [];
  }
  if (owners.length > 0) {
    Swal.fire({
      title: 'Full Names of Multiple Owners',
      html: '<ul>' + owners.map(name => `<li>${name}</li>`).join('') + '</ul>',
      icon: 'info',
      confirmButtonText: 'Close'
    });
  } else {
    Swal.fire({
      title: 'Full Names of Multiple Owners',
      text: 'No owners available',
      icon: 'info',
      confirmButtonText: 'Close'
    });
  }
}

document.addEventListener('DOMContentLoaded', function () {
  document.getElementById('create-new-survey').addEventListener('click', function () {
    window.location.href = '{{ route("survey_records.index") }}';
  });

  document.querySelectorAll('.update-survey-btn').forEach(button => {
    button.addEventListener('click', function () {
      const surveyId = this.getAttribute('data-id');
      window.location.href = `{{ route('survey.get', '') }}/${surveyId}`;
    });
  });
});
</script>
