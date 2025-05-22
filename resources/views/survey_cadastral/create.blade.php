@extends('layouts.app')
@section('page-title')
    {{ __('create New cadastral') }}
@endsection

@section('content')
<div class="flex-1 overflow-auto">
    <!-- Header -->
    @include('admin.header')
    <!-- Update Survey Form -->
    <div class="p-6">
        <form id="update-survey-form" method="POST" action="{{ route('survey_cadastral.store') }}">
            @csrf
            <input type="hidden" name="application_id" id="application_id" value="">
            <input type="hidden" name="sub_application_id" id="sub_application_id" value="">
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 space-y-6">
                <div id="application-info" class="hidden">
                    <!-- Application header will be rendered dynamically -->
                </div>
                
                
                <div>
                    <h3 class="text-lg font-medium mb-4">
                        Create A {{ request()->query('is') == 'secondary' ? 'Unit' : 'Cadastral' }} Survey
                    </h3>
                    
                    <!-- Selection Grid - 2x2 layout -->
                    <div class="border border-gray-200 rounded-lg p-4 bg-gray-50 mb-4">
                        <div class="grid grid-cols-2 gap-4">
                        
                            <!-- Primary Survey Selection (only for unit surveys) -->
                            @if(request()->query('is') == 'secondary')
                            <div>
                                <label for="primary-survey-select" class="block text-sm font-medium text-gray-700 mb-1">Select Primary Survey</label>
                                <select id="primary-survey-select" class="w-full p-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">-- Select Primary Survey FileNo --</option>
                                </select>
                            </div>
                            @endif


                                <!-- File Number Selection -->
                            <div>
                                <label for="fileno-select" class="block text-sm font-medium text-gray-700 mb-1">Select File Number</label>
                                <select id="fileno-select" class="w-full p-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">-- Select File Number --</option>
                                </select>
                            </div>
                            
                        </div>
                    </div>
                </div>

                
            @include('survey_cadastral.unit_form')
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
                    <h4 class="text-sm font-medium mb-3">
                        Control Beacon Information
                    </h4>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label for="beacon_control_name" class="block text-sm font-medium text-gray-700">
                               Control Beacon Name
                            </label>
                            <input id="beacon_control_name" name="beacon_control_name" type="text" value="{{ old('beacon_control_name') }}" class="w-full p-2 border border-gray-300 rounded-md text-sm">
                        </div>
                        <div>
                            <label for="Control_Beacon_Coordinate_X" class="block text-sm font-medium text-gray-700">
                               Control Beacon X
                            </label>
                            <input id="Control_Beacon_Coordinate_X" name="Control_Beacon_Coordinate_X" type="text" value="{{ old('Control_Beacon_Coordinate_X') }}" class="w-full p-2 border border-gray-300 rounded-md text-sm">
                        </div>
                        <div>
                            <label for="Control_Beacon_Coordinate_Y" class="block text-sm font-medium text-gray-700">
                               Control Beacon Y
                            </label>
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
            url: '{{ route('survey_cadastral.search-fileno') }}',
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
                
                // Auto-populate unit information fields
                populateUnitInformation(selectedApplication);
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
    
    // Function to populate unit information fields
    function populateUnitInformation(application) {
        // Populate scheme number
        if (application.scheme_no) {
            const schemeNoInput = document.getElementById('scheme_no');
            if (schemeNoInput) {
                schemeNoInput.value = application.scheme_no;
            }
        }
        
        // Populate floor/section number
        if (application.floor_number) {
            const floorInput = document.getElementById('floor_number');
            if (floorInput) {
                floorInput.value = application.floor_number;
            }
        }
        
     
        
        // Populate unit number
        if (application.unit_number) {
            const unitNoInput = document.getElementById('unit_number');
            if (unitNoInput) {
                unitNoInput.value = application.unit_number;
            }
        }
        
        // Populate land use
        if (application.land_use) {
            const landUseInput = document.getElementById('landuse');
            if (landUseInput) {
                landUseInput.value = application.land_use;
            }
        }
        
        // Populate app_id (application ID)
        if (application.app_id) {
            const appIdInput = document.getElementById('app_id');
            if (appIdInput) {
                appIdInput.value = application.app_id;
            }
        }
        
        // Populate unit_id
        if (application.unit_id) {
            const unitIdInput = document.getElementById('unit_id');
            if (unitIdInput) {
                unitIdInput.value = application.unit_id;
            }
        }
        
        // Populate PrimarysurveyId
        if (application.primary_fileno) {
            const primarySurveyInput = document.getElementById('PrimarysurveyId');
            if (primarySurveyInput) {
                primarySurveyInput.value = application.primary_fileno;
            }
        }
        
        // Populate STFileNo
        if (application.fileno) {
            const stFileNoInput = document.getElementById('STFileNo');
            if (stFileNoInput) {
                stFileNoInput.value = application.fileno;
            }
        }
    }
    
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

    // Initialize Primary Survey Select2 (only for secondary/unit surveys)
    if (isSecondary) {
        const primarySurveySelect = document.getElementById('primary-survey-select');
        
        if (primarySurveySelect) {
            $(primarySurveySelect).select2({
                placeholder: "Search for a Primary Survey FileNo...",
                allowClear: true,
                minimumInputLength: 0,
                ajax: {
                    url: '{{ route('survey_cadastral.fetch-primary-surveys') }}',
                    dataType: 'json',
                    delay: 250,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: function(params) {
                        return {
                            search: params.term || '',
                            initial: params.term ? false : true
                        };
                    },
                    processResults: function(data, params) {
                        let results = [];
                        
                        // Debug logging
                        console.log('Primary Survey Data:', data);
                        
                        if (data.success && data.surveys && data.surveys.length > 0) {
                            results = data.surveys.map(survey => {
                                // Create a more descriptive text for each survey option
                                let displayText = survey.fileno || 'No File No';
                                
                                // Add survey type if available
                                if (survey.survey_type) {
                                    displayText += ' | ' + survey.survey_type;
                                }
                                
                                // Add layout and location if available
                                if (survey.layout_name) {
                                    displayText += ' | ' + survey.layout_name;
                                }
                                
                                // Add plot and block info
                                displayText += ' | Plot: ' + (survey.plot_no || 'N/A');
                                displayText += ' | Block: ' + (survey.block_no || 'N/A');
                                
                                return {
                                    id: survey.ID,
                                    text: displayText,
                                    survey: survey
                                };
                            });
                        } else {
                            console.warn('No primary surveys found or data structure issue:', data);
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
            
            // Trigger initial data load when dropdown is opened
            $(primarySurveySelect).on('select2:open', function() {
                if (!$(primarySurveySelect).data('initial-load-done')) {
                    const $search = $('.select2-search__field');
                    $search.val('');
                    $search.trigger('input');
                    $(primarySurveySelect).data('initial-load-done', true);
                }
            });
            
            // Handle Primary Survey selection
            $(primarySurveySelect).on('select2:select', function(e) {
                const data = e.params.data;
                const surveyId = data.id;
                
                // Fetch detailed survey data
                fetch(`{{ url('survey_cadastral/primary-survey-details') }}/${surveyId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.survey) {
                            // Auto-populate form fields from Primary Survey
                            populateFromPrimarySurvey(data.survey);
                            
                            // Show success message as a toast notification
                            Swal.fire({
                                title: 'Primary Survey Selected',
                                text: 'Form fields have been populated based on the selected Primary Survey.',
                                icon: 'success',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching survey details:', error);
                    });
            });
            
            // Handle Primary Survey clear
            $(primarySurveySelect).on('select2:clear', function() {
                // Clear Primary Survey related fields
                clearPrimarySurveyFields();
            });
        }
    }

    // Function to populate form fields from Primary Survey
    function populateFromPrimarySurvey(survey) {
        // Set Primary Survey ID
        const primarySurveyIdInput = document.getElementById('PrimarysurveyId');
        if (primarySurveyIdInput) {
            primarySurveyIdInput.value = survey.fileno || '';
        }
        
        // Populate common fields
        if (survey.scheme_no) {
            const schemeNoInput = document.getElementById('scheme_no');
            if (schemeNoInput) {
                schemeNoInput.value = survey.scheme_no;
            }
        }
        
        // Populate control beacon information
        if (survey.beacon_control_name) {
            const beaconControlNameInput = document.getElementById('beacon_control_name');
            if (beaconControlNameInput) {
                beaconControlNameInput.value = survey.beacon_control_name;
            }
        }
        
        if (survey.Control_Beacon_Coordinate_X) {
            const beaconXInput = document.getElementById('Control_Beacon_Coordinate_X');
            if (beaconXInput) {
                beaconXInput.value = survey.Control_Beacon_Coordinate_X;
            }
        }
        
        if (survey.Control_Beacon_Coordinate_Y) {
            const beaconYInput = document.getElementById('Control_Beacon_Coordinate_Y');
            if (beaconYInput) {
                beaconYInput.value = survey.Control_Beacon_Coordinate_Y;
            }
        }
        
        // Populate sheet information
        if (survey.Metric_Sheet_Index) {
            const metricSheetIndexInput = document.getElementById('Metric_Sheet_Index');
            if (metricSheetIndexInput) {
                metricSheetIndexInput.value = survey.Metric_Sheet_Index;
            }
        }
        
        if (survey.Metric_Sheet_No) {
            const metricSheetNoInput = document.getElementById('Metric_Sheet_No');
            if (metricSheetNoInput) {
                metricSheetNoInput.value = survey.Metric_Sheet_No;
            }
        }
        
        if (survey.Imperial_Sheet) {
            const imperialSheetInput = document.getElementById('Imperial_Sheet');
            if (imperialSheetInput) {
                imperialSheetInput.value = survey.Imperial_Sheet;
            }
        }
        
        if (survey.Imperial_Sheet_No) {
            const imperialSheetNoInput = document.getElementById('Imperial_Sheet_No');
            if (imperialSheetNoInput) {
                imperialSheetNoInput.value = survey.Imperial_Sheet_No;
            }
        }
        
        // Populate location information
        if (survey.layout_name) {
            const layoutNameInput = document.getElementById('layout_name');
            if (layoutNameInput) {
                layoutNameInput.value = survey.layout_name;
            }
        }
        
        if (survey.district_name) {
            const districtNameInput = document.getElementById('district_name');
            if (districtNameInput) {
                districtNameInput.value = survey.district_name;
            }
        }
        
        if (survey.lga_name) {
            const lgaNameInput = document.getElementById('lga_name');
            if (lgaNameInput) {
                lgaNameInput.value = survey.lga_name;
            }
        }
        
        // Also populate the property identification fields
        if (survey.plot_no) {
            const plotNoInput = document.getElementById('plot_no');
            if (plotNoInput) {
                plotNoInput.value = survey.plot_no;
                plotNoInput.disabled = false;
            }
        }
        
        if (survey.block_no) {
            const blockNoInput = document.getElementById('block_no');
            if (blockNoInput) {
                blockNoInput.value = survey.block_no;
                blockNoInput.disabled = false;
            }
        }
        
        // Populate Personnel Information
        if (survey.survey_by) {
            const surveyByInput = document.getElementById('survey_by');
            if (surveyByInput) {
                surveyByInput.value = survey.survey_by;
            }
        }
        
        if (survey.survey_by_date) {
            const surveyByDateInput = document.getElementById('survey_by_date');
            if (surveyByDateInput) {
                surveyByDateInput.value = survey.survey_by_date;
            }
        }
        
        if (survey.drawn_by) {
            const drawnByInput = document.getElementById('drawn_by');
            if (drawnByInput) {
                drawnByInput.value = survey.drawn_by;
            }
        }
        
        if (survey.drawn_by_date) {
            const drawnByDateInput = document.getElementById('drawn_by_date');
            if (drawnByDateInput) {
                drawnByDateInput.value = survey.drawn_by_date;
            }
        }
        
        if (survey.checked_by) {
            const checkedByInput = document.getElementById('checked_by');
            if (checkedByInput) {
                checkedByInput.value = survey.checked_by;
            }
        }
        
        if (survey.checked_by_date) {
            const checkedByDateInput = document.getElementById('checked_by_date');
            if (checkedByDateInput) {
                checkedByDateInput.value = survey.checked_by_date;
            }
        }
        
        if (survey.approved_by) {
            const approvedByInput = document.getElementById('approved_by');
            if (approvedByInput) {
                approvedByInput.value = survey.approved_by;
            }
        }
        
        if (survey.approved_by_date) {
            const approvedByDateInput = document.getElementById('approved_by_date');
            if (approvedByDateInput) {
                approvedByDateInput.value = survey.approved_by_date;
            }
        }

        // Populate Approved Plan No
        if (survey.approved_plan_no) {
            const approvedPlanNoInput = document.getElementById('approved_plan_no');
            if (approvedPlanNoInput) {
                approvedPlanNoInput.value = survey.approved_plan_no;
            }
        }
        
        // Populate TP Plan No
        if (survey.tp_plan_no) {
            const tpPlanNoInput = document.getElementById('tp_plan_no');
            if (tpPlanNoInput) {
                tpPlanNoInput.value = survey.tp_plan_no;
            }
        }
    }
    
    // Function to clear Primary Survey related fields
    function clearPrimarySurveyFields() {
        const primarySurveyIdInput = document.getElementById('PrimarysurveyId');
        if (primarySurveyIdInput) {
            primarySurveyIdInput.value = '';
        }
        
        // Note: We're not clearing all fields here to avoid overriding data that might have been
        // entered by the user or populated from other sources like the subapplication
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
