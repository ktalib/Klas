@extends('layouts.app')
@section('page-title')
    {{ __('create New Survey') }}
@endsection

@section('content')
<div class="flex-1 overflow-auto">
    <!-- Header -->
    @include('admin.header')
    <!-- Update Survey Form -->
    <div class="p-6">
        <form id="update-survey-form" method="POST" action="{{ route('attribution.store') }}">
            @csrf
            <input type="hidden" name="application_id" id="application_id" value="">
            <input type="hidden" name="sub_application_id" id="sub_application_id" value="">
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 space-y-6">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium">
                        Create A {{ request()->query('is') == 'secondary' ? 'Unit' : 'Primary' }} Survey
                    </h3>
                    <div class="w-80">
                        <label for="fileno-select" class="block text-sm font-medium text-gray-700 mb-1">Select File Number</label>
                        <select id="fileno-select" class="w-full p-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Select File Number --</option>
                        </select>
                    </div>
                </div>

                <div id="application-info" class="hidden">
                    <!-- Application header will be rendered dynamically -->
                </div>
                
                <!-- Property Identification -->
                <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                    <h4 class="text-sm font-medium mb-3">Property Identification</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="plot_no" class="block text-sm font-medium text-gray-700">Plot No</label>
                            <input id="plot_no" name="plot_no" type="text" value="{{ old('plot_no') }}" class="w-full p-2 border border-gray-300 rounded-md text-sm" disabled>
                        </div>
                        <div>
                            <label for="block_no" class="block text-sm font-medium text-gray-700">Block No</label>
                            <input id="block_no" name="block_no" type="text" value="{{ old('block_no') }}" class="w-full p-2 border border-gray-300 rounded-md text-sm" disabled>
                        </div>
                    </div>
                    @if(request()->query('is') == 'secondary')
                    <div class="grid grid-cols-1 gap-4 mt-3" style="display: none;">
                        <div>
                            <label for="scheme_no" class="block text-sm font-medium text-gray-700">Scheme No</label>
                            <input id="scheme_no" name="scheme_no" type="text" value="{{ old('scheme_no') }}" class="w-full p-2 border border-gray-300 rounded-md text-sm" disabled>
                        </div>
                    </div>
                    @endif
                    <div class="grid grid-cols-2 gap-4 mt-3">
                        <div>
                            <label for="approved_plan_no" class="block text-sm font-medium text-gray-700">Approved Plan No</label>
                            <input id="approved_plan_no" name="approved_plan_no" type="text" value="{{ old('approved_plan_no') }}" class="w-full p-2 border border-gray-300 rounded-md text-sm">
                        </div>
                        <div>
                            <label for="tp_plan_no" class="block text-sm font-medium text-gray-700">TP Plan No</label>
                            <input id="tp_plan_no" name="tp_plan_no" type="text" value="{{ old('tp_plan_no') }}" class="w-full p-2 border border-gray-300 rounded-md text-sm">
                        </div>
                    </div>
                </div>

                <!-- Control Beacon Information -->
                <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                    <h4 class="text-sm font-medium mb-3">{{ request()->query('is') == 'secondary' ? 'Unit Control Information' : 'Control Beacon Information' }}</h4>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label for="beacon_control_name" class="block text-sm font-medium text-gray-700">{{ request()->query('is') == 'secondary' ? 'Unit Control Name' : 'Control Beacon Name' }}</label>
                            <input id="beacon_control_name" name="beacon_control_name" type="text" value="{{ old('beacon_control_name') }}" class="w-full p-2 border border-gray-300 rounded-md text-sm">
                        </div>
                        <div>
                            <label for="Control_Beacon_Coordinate_X" class="block text-sm font-medium text-gray-700">{{ request()->query('is') == 'secondary' ? 'Unit Control X' : 'Control Beacon X' }}</label>
                            <input id="Control_Beacon_Coordinate_X" name="Control_Beacon_Coordinate_X" type="text" value="{{ old('Control_Beacon_Coordinate_X') }}" class="w-full p-2 border border-gray-300 rounded-md text-sm">
                        </div>
                        <div>
                            <label for="Control_Beacon_Coordinate_Y" class="block text-sm font-medium text-gray-700">{{ request()->query('is') == 'secondary' ? 'Unit Control Y' : 'Control Beacon Y' }}</label>
                            <input id="Control_Beacon_Coordinate_Y" name="Control_Beacon_Coordinate_Y" type="text" value="{{ old('Control_Beacon_Coordinate_Y') }}" class="w-full p-2 border border-gray-300 rounded-md text-sm">
                        </div>
                    </div>
                </div>

                <!-- Sheet Information -->
                <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                    <h4 class="text-sm font-medium mb-3">Sheet Information</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="Metric_Sheet_Index" class="block text-sm font-medium text-gray-700">Metric Sheet Index</label>
                            <input id="Metric_Sheet_Index" name="Metric_Sheet_Index" type="text" value="{{ old('Metric_Sheet_Index') }}" class="w-full p-2 border border-gray-300 rounded-md text-sm">
                        </div>
                        <div>
                            <label for="Metric_Sheet_No" class="block text-sm font-medium text-gray-700">Metric Sheet No</label>
                            <input id="Metric_Sheet_No" name="Metric_Sheet_No" type="text" value="{{ old('Metric_Sheet_No') }}" class="w-full p-2 border border-gray-300 rounded-md text-sm">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mt-3">
                        <div>
                            <label for="Imperial_Sheet" class="block text-sm font-medium text-gray-700">Imperial Sheet</label>
                            <input id="Imperial_Sheet" name="Imperial_Sheet" type="text" value="{{ old('Imperial_Sheet') }}" class="w-full p-2 border border-gray-300 rounded-md text-sm">
                        </div>
                        <div>
                            <label for="Imperial_Sheet_No" class="block text-sm font-medium text-gray-700">Imperial Sheet No</label>
                            <input id="Imperial_Sheet_No" name="Imperial_Sheet_No" type="text" value="{{ old('Imperial_Sheet_No') }}" class="w-full p-2 border border-gray-300 rounded-md text-sm">
                        </div>
                    </div>
                </div>

                <!-- Location Information -->
                <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                    <h4 class="text-sm font-medium mb-3">Location Information</h4>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label for="layout_name" class="block text-sm font-medium text-gray-700">Layout Name</label>
                            <input id="layout_name" name="layout_name" type="text" value="{{ old('layout_name') }}" class="w-full p-2 border border-gray-300 rounded-md text-sm">
                        </div>
                        <div>
                            <label for="district_name" class="block text-sm font-medium text-gray-700">District Name</label>
                            <input id="district_name" name="district_name" type="text" value="{{ old('district_name') }}" class="w-full p-2 border border-gray-300 rounded-md text-sm">
                        </div>
                        <div>
                            <label for="lga_name" class="block text-sm font-medium text-gray-700">LGA Name</label>
                            <input id="lga_name" name="lga_name" type="text" value="{{ old('lga_name') }}" class="w-full p-2 border border-gray-300 rounded-md text-sm">
                        </div>
                    </div>
                </div>

                <!-- Personnel Information -->
                <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                    <h4 class="text-sm font-medium mb-3">Personnel Information</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="survey_by" class="block text-sm font-medium text-gray-700">Survey By</label>
                            <input id="survey_by" name="survey_by" type="text" value="{{ old('survey_by') }}" class="w-full p-2 border border-gray-300 rounded-md text-sm">
                        </div>
                        <div>
                            <label for="survey_by_date" class="block text-sm font-medium text-gray-700">Survey Date</label>
                            <input id="survey_by_date" name="survey_by_date" type="date" value="{{ old('survey_by_date') }}" class="w-full p-2 border border-gray-300 rounded-md text-sm">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mt-3">
                        <div>
                            <label for="drawn_by" class="block text-sm font-medium text-gray-700">Drawn By</label>
                            <input id="drawn_by" name="drawn_by" type="text" value="{{ old('drawn_by') }}" class="w-full p-2 border border-gray-300 rounded-md text-sm">
                        </div>
                        <div>
                            <label for="drawn_by_date" class="block text-sm font-medium text-gray-700">Drawn Date</label>
                            <input id="drawn_by_date" name="drawn_by_date" type="date" value="{{ old('drawn_by_date') }}" class="w-full p-2 border border-gray-300 rounded-md text-sm">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mt-3">
                        <div>
                            <label for="checked_by" class="block text-sm font-medium text-gray-700">Checked By</label>
                            <input id="checked_by" name="checked_by" type="text" value="{{ old('checked_by') }}" class="w-full p-2 border border-gray-300 rounded-md text-sm">
                        </div>
                        <div>
                            <label for="checked_by_date" class="block text-sm font-medium text-gray-700">Checked Date</label>
                            <input id="checked_by_date" name="checked_by_date" type="date" value="{{ old('checked_by_date') }}" class="w-full p-2 border border-gray-300 rounded-md text-sm">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mt-3">
                        <div>
                            <label for="approved_by" class="block text-sm font-medium text-gray-700">Approved By</label>
                            <input id="approved_by" name="approved_by" type="text" value="{{ old('approved_by') }}" class="w-full p-2 border border-gray-300 rounded-md text-sm">
                        </div>
                        <div>
                            <label for="approved_by_date" class="block text-sm font-medium text-gray-700">Approved Date</label>
                            <input id="approved_by_date" name="approved_by_date" type="date" value="{{ old('approved_by_date') }}" class="w-full p-2 border border-gray-300 rounded-md text-sm">
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" id="save-survey-btn" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700" disabled>
                        Save Survey
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Include Select2 CSS and JS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
 
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get all form inputs and disable them initially
    const formInputs = document.querySelectorAll('#update-survey-form input:not([type="hidden"]):not([type="submit"])');
    
    const filenoSelect = document.getElementById('fileno-select');
    const saveSurveyBtn = document.getElementById('save-survey-btn');
    const applicationInfo = document.getElementById('application-info');
    
    let selectedApplication = null;
    const isSecondary = '{{ request()->query('is') }}' === 'secondary';
    
    // Disable all form inputs initially
    formInputs.forEach(input => {
        input.disabled = true;
    });

    // Initialize Select2
    $(filenoSelect).select2({
        placeholder: "Search for a file number...",
        allowClear: true,
        minimumInputLength: 0, // Changed from 2 to 0 to allow initial data load
        ajax: {
            url: '{{ route('attribution.search-fileno') }}',
            dataType: 'json',
            delay: 250,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: function(params) {
                return {
                    fileno: params.term || '', // Handle empty term for initial load
                    type: isSecondary ? 'secondary' : 'primary',
                    initial: params.term ? false : true // Flag for initial load
                };
            },
            processResults: function(data, params) {
                // Transform the data into Select2 format
                let results = [];
                
                if (data.success && data.application) {
                    // Single application result
                    results.push({
                        id: data.application.id,
                        text: data.application.fileno,
                        application: data.application
                    });
                } else if (data.success && data.applications) {
                    // Multiple applications result
                    results = data.applications.map(app => {
                        return {
                            id: app.id,
                            text: app.fileno + (app.applicant_type === 'individual' ? 
                                   ' - ' + app.first_name + ' ' + app.surname : 
                                   app.applicant_type === 'corporate' ? 
                                   ' - ' + app.corporate_name : ''),
                            application: app
                        };
                    });
                }
                
                return {
                    results: results,
                    pagination: {
                        more: data.pagination && data.pagination.more
                    }
                };
            },
            cache: true
        }
    });

    // Trigger initial data load when dropdown is opened for the first time
    $(filenoSelect).on('select2:open', function() {
        // Only load data if the dropdown is empty
        if (!$(filenoSelect).data('initial-load-done')) {
            const $search = $('.select2-search__field');
            $search.val(''); // Ensure empty search
            $search.trigger('input'); // Trigger search with empty string
            $(filenoSelect).data('initial-load-done', true); // Mark as done
        }
    });

    // Handle select change
    $(filenoSelect).on('select2:select', function(e) {
        const data = e.params.data;
        selectedApplication = data.application;
        
        if (selectedApplication) {
            // Populate hidden fields based on survey type
            if (isSecondary) {
                // For secondary survey, use the sub_application_id only
                document.getElementById('sub_application_id').value = selectedApplication.id;
                document.getElementById('application_id').value = '';
                selectedApplication.isSecondary = true;
            } else {
                // For primary survey, use the application_id only
                document.getElementById('application_id').value = selectedApplication.id;
                document.getElementById('sub_application_id').value = '';
                selectedApplication.isSecondary = false;
            }
            
            // Enable all form inputs
            formInputs.forEach(input => {
                input.disabled = false;
            });
            
            // Enable save button
            saveSurveyBtn.disabled = false;
            
            // Populate the scheme_no field for secondary surveys if available
            if (isSecondary && selectedApplication.scheme_no) {
                const schemeNoInput = document.getElementById('scheme_no');
                if (schemeNoInput) {
                    schemeNoInput.value = selectedApplication.scheme_no;
                }
            }
            
            // Render application header
            renderApplicationHeader(selectedApplication);
            
            // Show success message
            Swal.fire({
                title: 'Application Selected',
                text: 'The form has been unlocked. You can now enter survey details.',
                icon: 'success',
                confirmButtonText: 'Continue'
            });
        }
    });

    // Handle clear event
    $(filenoSelect).on('select2:clear', function() {
        // Disable all form inputs
        formInputs.forEach(input => {
            input.disabled = true;
        });
        
        // Disable save button
        saveSurveyBtn.disabled = true;
        
        // Hide application info
        applicationInfo.classList.add('hidden');
        
        // Clear hidden fields
        document.getElementById('application_id').value = '';
        document.getElementById('sub_application_id').value = '';
        
        selectedApplication = null;
    });
    
    function renderApplicationHeader(application) {
        // Create the header HTML
        let headerHTML = `
        <div class="flex flex-col md:flex-row items-center justify-between mb-6 bg-gray-50 border border-gray-200 rounded-lg p-4 shadow-sm">
            <div class="flex-1 mb-4 md:mb-0">
                <h3 class="text-base font-semibold text-gray-800 flex items-center gap-2">
                    <i data-lucide="home" class="w-5 h-5 text-blue-500"></i>
                    ${application.land_use} Property
                </h3>
                <div class="flex flex-wrap gap-2 mt-2 text-xs text-gray-500">
                    <span class="inline-flex items-center gap-1">
                        <i data-lucide="hash" class="w-4 h-4"></i>
                        <span class="font-medium text-gray-700">
                            ${application.isSecondary ? 'Mother FileNo: ' + (application.primary_fileno || 'N/A') : ''}
                        </span>
                    </span>
                    <span class="inline-flex items-center gap-1">
                        <i data-lucide="folder" class="w-4 h-4"></i>
                        <span class="font-medium text-gray-700">
                            ${application.isSecondary ? 'ST FileNo: ' + (application.fileno || 'N/A') : 'FileNo: ' + (application.fileno || 'N/A')}
                        </span>
                    </span>
                    ${application.isSecondary && application.scheme_no ? `
                    <span class="inline-flex items-center gap-1">
                        <i data-lucide="layout" class="w-4 h-4"></i>
                        <span class="font-medium text-gray-700">
                            Scheme No: ${application.scheme_no}
                        </span>
                    </span>
                    ` : ''}
                </div>
            </div>
            <div class="flex-1 text-right">
                <h3 class="text-base font-semibold text-gray-800">
                    ${getApplicantName(application)}
                </h3>
                <span class="inline-flex items-center px-3 py-1 mt-2 rounded-full text-xs font-semibold bg-green-100 text-green-700 border border-green-200">
                    <i data-lucide="map-pin" class="w-4 h-4 mr-1"></i>
                    ${application.land_use}
                </span>
            </div>
        </div>`;
        
        // Set the HTML to the application info div
        applicationInfo.innerHTML = headerHTML;
        applicationInfo.classList.remove('hidden');
        
        // Initialize any SVG icons
        if (window.lucide) {
            lucide.createIcons();
        }
    }
    
    function getApplicantName(application) {
        if (application.applicant_type === 'individual') {
            return `${application.applicant_title} ${application.first_name} ${application.surname}`;
        } else if (application.applicant_type === 'corporate') {
            return application.corporate_name;
        } else if (application.applicant_type === 'multiple') {
            let owners = [];
            try {
                owners = JSON.parse(application.multiple_owners_names);
                return owners[0] + (owners.length > 1 ? 
                    ` <span onclick="showAllOwners(${JSON.stringify(owners)})" class="cursor-pointer text-blue-600 hover:underline">+ ${owners.length - 1} others</span>` : 
                    '');
            } catch (e) {
                return 'Multiple Owners';
            }
        }
        return 'Applicant';
    }
});

// Function to show all owners in a modal (accessible globally)
function showAllOwners(owners) {
    let ownersList = '';
    owners.forEach((owner, index) => {
        ownersList += `<div class="py-2 px-4 ${index % 2 === 0 ? 'bg-gray-50' : 'bg-white'} rounded">
                          <div class="flex items-center">
                              <span class="font-medium text-gray-700">${index + 1}.</span>
                              <span class="ml-2">${owner}</span>
                          </div>
                       </div>`;
    });

    Swal.fire({
        title: 'All Property Owners',
        html: `<div class="max-h-60 overflow-y-auto mt-4 divide-y divide-gray-200">${ownersList}</div>`,
        width: '500px',
        showCloseButton: true,
        showConfirmButton: false,
        focusConfirm: false
    });
}
</script>
@endsection
