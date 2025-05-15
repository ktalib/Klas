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
                    <button type="button" id="search-file-btn" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 flex items-center">
                        <i data-lucide="search" class="w-4 h-4 mr-2"></i>
                        Search File No
                    </button>
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

<!-- Search Modal -->
<div id="search-modal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
    <div class="fixed inset-0 bg-black bg-opacity-50"></div>
    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md relative z-10">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium">Search for File Number</h3>
            <button type="button" id="close-modal" class="text-gray-400 hover:text-gray-500">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <div class="mb-4">
            <label for="fileno-search" class="block text-sm font-medium text-gray-700 mb-2">Enter File Number</label>
            <div class="flex">
                <input type="text" id="fileno-search" class="flex-1 p-2.5 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="e.g., ST-COM-2025-005">
                <button type="button" id="search-fileno-btn" class="px-4 py-2.5 bg-blue-600 text-white rounded-r-md hover:bg-blue-700">
                    Search
                </button>
            </div>
        </div>
        
        <div id="search-results" class="mt-4 hidden">
            <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                <h4 class="font-medium text-green-700 mb-2" id="result-title"></h4>
                <div id="result-details" class="text-sm space-y-2"></div>
            </div>
            
            <div class="mt-4 flex justify-end">
                <button type="button" id="select-application-btn" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                    Select This Application
                </button>
            </div>
        </div>
        
        <div id="search-loading" class="text-center py-4 hidden">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-blue-500"></div>
            <p class="mt-2 text-gray-600">Searching...</p>
        </div>
        
        <div id="search-not-found" class="mt-4 text-center py-4 hidden">
            <svg class="mx-auto h-12 w-12 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="mt-2 text-gray-600" id="not-found-message">No application found with this file number.</p>
        </div>
    </div>
</div>
 
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get all form inputs and disable them initially
    const formInputs = document.querySelectorAll('#update-survey-form input:not([type="hidden"]):not([type="submit"])');
    
    // Search modal elements
    const searchModal = document.getElementById('search-modal');
    const searchFileBtn = document.getElementById('search-file-btn');
    const closeModalBtn = document.getElementById('close-modal');
    const searchFilenoBtn = document.getElementById('search-fileno-btn');
    const filenoSearch = document.getElementById('fileno-search');
    const searchResults = document.getElementById('search-results');
    const searchLoading = document.getElementById('search-loading');
    const searchNotFound = document.getElementById('search-not-found');
    const resultTitle = document.getElementById('result-title');
    const resultDetails = document.getElementById('result-details');
    const selectApplicationBtn = document.getElementById('select-application-btn');
    const saveSurveyBtn = document.getElementById('save-survey-btn');
    const applicationInfo = document.getElementById('application-info');
    
    let selectedApplication = null;
    const isSecondary = '{{ request()->query('is') }}' === 'secondary';
    
    // Disable all form inputs initially
    formInputs.forEach(input => {
        input.disabled = true;
    });
    
    // Open search modal
    searchFileBtn.addEventListener('click', function(e) {
        e.preventDefault();
        searchModal.classList.remove('hidden');
        filenoSearch.focus();
    });
    
    // Close search modal
    closeModalBtn.addEventListener('click', function() {
        searchModal.classList.add('hidden');
        resetSearchForm();
    });
    
    // Close modal when clicking outside
    searchModal.querySelector('.fixed.inset-0').addEventListener('click', function() {
        searchModal.classList.add('hidden');
        resetSearchForm();
    });
    
    // Handle search button click
    searchFilenoBtn.addEventListener('click', performSearch);
    
    // Handle enter key in search input
    filenoSearch.addEventListener('keyup', function(e) {
        if (e.key === 'Enter') {
            performSearch();
        }
    });
    
    // Select application button click
    selectApplicationBtn.addEventListener('click', function() {
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
            
            // Render application header
            renderApplicationHeader(selectedApplication);
            
            // Close modal
            searchModal.classList.add('hidden');
            resetSearchForm();
            
            // Show success message
            Swal.fire({
                title: 'Application Selected',
                text: 'The form has been unlocked. You can now enter survey details.',
                icon: 'success',
                confirmButtonText: 'Continue'
            });
        }
    });
    
    function performSearch() {
        const fileno = filenoSearch.value.trim();
        
        if (!fileno) {
            Swal.fire({
                title: 'Error',
                text: 'Please enter a file number',
                icon: 'error'
            });
            return;
        }
        
        // Hide previous results and show loading
        searchResults.classList.add('hidden');
        searchNotFound.classList.add('hidden');
        searchLoading.classList.remove('hidden');
        
        // Perform AJAX request
        fetch('{{ route('attribution.search-fileno') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                fileno: fileno,
                type: isSecondary ? 'secondary' : 'primary'
            })
        })
        .then(response => response.json())
        .then(data => {
            searchLoading.classList.add('hidden');
            
            if (data.success) {
                selectedApplication = data.application;
                displaySearchResults(data.application);
            } else {
                searchNotFound.classList.remove('hidden');
                document.getElementById('not-found-message').textContent = data.message;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            searchLoading.classList.add('hidden');
            Swal.fire({
                title: 'Error',
                text: 'An error occurred while searching. Please try again.',
                icon: 'error'
            });
        });
    }
    
    function displaySearchResults(application) {
        let detailsHTML = '';
        
        // Handle different applicant types
        if (application.applicant_type === 'individual') {
            resultTitle.textContent = `${application.applicant_title} ${application.first_name} ${application.surname}`;
            detailsHTML += `<p><strong>Name:</strong> ${application.applicant_title} ${application.first_name} ${application.surname}</p>`;
        } else if (application.applicant_type === 'corporate') {
            resultTitle.textContent = application.corporate_name;
            detailsHTML += `<p><strong>Company:</strong> ${application.corporate_name}</p>`;
        } else if (application.applicant_type === 'multiple') {
            let owners = [];
            try {
                owners = JSON.parse(application.multiple_owners_names);
                resultTitle.textContent = owners[0] + (owners.length > 1 ? ` + ${owners.length - 1} others` : '');
            } catch (e) {
                resultTitle.textContent = 'Multiple Owners';
            }
            detailsHTML += `<p><strong>Owners:</strong> ${resultTitle.textContent}</p>`;
        }
        
        detailsHTML += `<p><strong>File No:</strong> ${application.fileno}</p>`;
        detailsHTML += `<p><strong>Land Use:</strong> ${application.land_use}</p>`;
        
        if (isSecondary && application.primary_fileno) {
            detailsHTML += `<p><strong>Mother File No:</strong> ${application.primary_fileno}</p>`;
        }
        
        resultDetails.innerHTML = detailsHTML;
        searchResults.classList.remove('hidden');
    }
    
    function resetSearchForm() {
        filenoSearch.value = '';
        searchResults.classList.add('hidden');
        searchNotFound.classList.add('hidden');
        searchLoading.classList.add('hidden');
        selectedApplication = null;
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
