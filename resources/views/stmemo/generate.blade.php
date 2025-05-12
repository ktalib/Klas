@extends('layouts.app')

@section('page-title')
    {{$PageTitle}}
@endsection

@include('sectionaltitling.partials.assets.css')

@section('content')
<!-- Main Content -->
<div class="flex-1 overflow-auto bg-gray-100 min-h-screen py-8">
     <!-- Header -->
     @include('admin.header')
     
     <!-- Main Content -->
     <div class="max-w-6xl mx-auto bg-white shadow-lg rounded-lg p-8 border border-gray-200 mb-8">
          <div class="flex justify-between items-center mb-6 border-b pb-4">
               <h2 class="text-2xl font-bold text-gray-800">Generate Sectional Titling Memo</h2>
               <a href="{{ route('stmemo.stmemo') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md flex items-center gap-2">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Back to List
               </a>
          </div>
          
          <form id="stMemoForm" action="{{ route('stmemo.save') }}" method="POST" class="space-y-6">
               @csrf
               <input type="hidden" name="application_id" value="{{ $application->id }}">
               <input type="hidden" name="is_primary" value="{{ isset($isPrimary) && $isPrimary ? '1' : '0' }}">
               
               <!-- Application Details Section -->
               <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="space-y-4">
                         <div class="flex items-center">
                              <span class="text-gray-600 font-medium w-40">File No: {{ isset($isPrimary) && $isPrimary ? $application->fileno : $application->primary_fileno }}</span>
                               
                         </div>
                         @if(!isset($isPrimary) || !$isPrimary)
                         <div class="flex items-center">
                              <span class="text-gray-600 font-medium w-40">ST File No: {{ $application->fileno ?? 'N/A' }}</span>
                              
                         </div>
                         <div class="flex items-center">
                              <span class="text-gray-600 font-medium w-40">Scheme No:</span>
                              <span class="text-gray-800">{{ $application->scheme_no ?? 'N/A' }}</span>
                         </div>
                         <div class="flex items-center">
                              <span class="text-gray-600 font-medium w-40">Unit Number:</span>
                              <span class="text-gray-800">{{ $application->unit_number ?? 'N/A' }}</span>
                         </div>
                         @endif
                    </div>
                    
                    <div class="space-y-4">
                            <div class="flex items-center">
                                      <span class="text-gray-600 font-medium w-40">Owner:</span>
                                      <span class="text-gray-400 bg-gray-100 rounded px-2 py-1 select-none">
                                               @php
                                                    // Get primary owner name
                                                    $primaryName = '';
                                                    if(isset($isPrimary) && $isPrimary) {
                                                         if(!empty($application->applicant_title) || !empty($application->first_name) || !empty($application->surname)) {
                                                              $primaryName = trim(($application->applicant_title ?? '') . ' ' . ($application->first_name ?? '') . ' ' . ($application->surname ?? ''));
                                                         } elseif(!empty($application->corporate_name)) {
                                                              $primaryName = $application->corporate_name;
                                                         }
                                                    } else {
                                                         if(!empty($application->primary_applicant_title) || !empty($application->primary_first_name) || !empty($application->primary_surname)) {
                                                              $primaryName = trim(($application->primary_applicant_title ?? '') . ' ' . ($application->primary_first_name ?? '') . ' ' . ($application->primary_surname ?? ''));
                                                         } elseif(!empty($application->mother_corporate_name)) {
                                                              $primaryName = $application->mother_corporate_name;
                                                         }
                                                    }
                                                    
                                                    // Get multiple owners
                                                    $multipleOwners = [];
                                                    if(!empty($application->multiple_owners_names)) {
                                                         if(is_string($application->multiple_owners_names)) {
                                                              $multipleOwners = json_decode($application->multiple_owners_names, true);
                                                         } else {
                                                              $multipleOwners = $application->multiple_owners_names;
                                                         }
                                                    }
                                                    
                                                    // Combine names
                                                    $ownersList = $primaryName;
                                                    if(!empty($multipleOwners)) {
                                                         if(!empty($primaryName)) {
                                                              $ownersList .= ', ' . implode(', ', $multipleOwners);
                                                         } else {
                                                              $ownersList = implode(', ', $multipleOwners);
                                                         }
                                                    }
                                                    
                                                    echo !empty($ownersList) ? $ownersList : 'N/A';
                                               @endphp
                                      </span>
                            </div>
                            
                            @if(!isset($isPrimary) || !$isPrimary)
                            <div class="flex items-center">
                                      <span class="text-gray-600 font-medium w-40">Unit Owner:</span>
                                      <span class="text-gray-400 bg-gray-100 rounded px-2 py-1 select-none">
                                               @if(!empty($application->applicant_title) || !empty($application->first_name) || !empty($application->surname))
                                                          {{ $application->applicant_title ?? '' }} {{ $application->first_name ?? '' }} {{ $application->surname ?? '' }}
                                               @elseif(!empty($application->corporate_name))
                                                          {{ $application->corporate_name }}
                                               @else
                                                          N/A
                                               @endif
                                      </span>
                            </div>
                            @endif
                            
                            <div class="flex items-center">
                                      <span class="text-gray-600 font-medium w-
                           
                           <div class="flex items-center">
                                   <span class="text-gray-600 font-medium w-
                                <span class="text-gray-800">{{ $application->land_use ?? 'N/A' }}</span>
                          </div>
                          <div class="flex items-center">
                                <span class="text-gray-600 font-medium w-40">Property Address:</span>
                                <span class="text-gray-800">
                                      {{ $application->property_house_no ?? '' }} 
                                      {{ $application->property_plot_no ?? '' }}, 
                                      {{ $application->property_street_name ?? '' }}, 
                                      {{ $application->property_lga ?? '' }}
                                </span>
                                <input type="hidden" name="property_location" value="{{ $application->property_house_no ?? '' }} {{ $application->property_plot_no ?? '' }}, {{ $application->property_street_name ?? '' }}, {{ $application->property_lga ?? '' }}">
                          </div>
                           <div class="flex items-center">
                                   <span class="text-gray-600 font-medium w-40">Applicant Name:</span>
                                      @php
                                           // Determine the primary applicant name
                                           // Initialize variables
                                           $primaryName = '';
                                           $multipleOwners = [];
                                           
                                           // Get primary applicant name
                                           if(isset($isPrimary) && $isPrimary) {
                                                  if(!empty($application->applicant_title) || !empty($application->first_name) || !empty($application->surname)) {
                                                        $primaryName = trim(($application->applicant_title ?? '') . ' ' . ($application->first_name ?? '') . ' ' . ($application->surname ?? ''));
                                                  } elseif(!empty($application->corporate_name)) {
                                                        $primaryName = $application->corporate_name;
                                                  }
                                           } else {
                                                  if(!empty($application->applicant_title) || !empty($application->first_name) || !empty($application->surname)) {
                                                        $primaryName = trim(($application->applicant_title ?? '') . ' ' . ($application->first_name ?? '') . ' ' . ($application->surname ?? ''));
                                                  } elseif(!empty($application->corporate_name)) {
                                                        $primaryName = $application->corporate_name;
                                                  }
                                           }
                                           
                                           // Get multiple owners if they exist
                                           if(!empty($application->multiple_owners_names)) {
                                                  if(is_string($application->multiple_owners_names)) {
                                                        $multipleOwners = json_decode($application->multiple_owners_names, true);
                                                  } else {
                                                        $multipleOwners = $application->multiple_owners_names;
                                                  }
                                           }
                                           
                                           // Combine names
                                           $applicantName = $primaryName;
                                           if(!empty($multipleOwners)) {
                                                  if(!empty($primaryName)) {
                                                        $applicantName .= ', ' . implode(', ', $multipleOwners);
                                                  } else {
                                                        $applicantName = implode(', ', $multipleOwners);
                                                  }
                                           }
                                           
                                           // If no names found at all, use N/A
                                           if(empty($applicantName)) {
                                                  $applicantName = 'N/A';
                                           }
                                     @endphp
                                     <input type="text" name="applicant_name" 
                                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-100 text-gray-500 cursor-not-allowed focus:outline-none focus:ring-0 focus:border-gray-300 sm:text-sm" 
                                                value="{{ $applicantName }}"
                                                disabled
                                   >
                           </div>
                    </div>
             </div>
             
               <!-- Rest of the form remains the same -->
               
               <!-- Tabs -->
               <div class="border-b border-gray-200 mb-6">
                    <nav class="-mb-px flex space-x-8">
                         <button type="button" class="tab-btn active border-b-2 border-blue-500 py-3 px-1 text-sm font-medium text-blue-600" data-tab="measurements">
                              Unit Measurements
                         </button>
                         <button type="button" class="tab-btn border-b-2 border-transparent py-3 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="buyers">
                              Buyer List
                         </button>
                    </nav>
               </div>
               
               <!-- Tab Contents -->
               <div class="tab-content" id="measurements-tab">
                    <div class="mb-6">
                         <label class="block text-sm font-medium text-gray-700 mb-2">Shared Facilities</label>
                         @php
                              // Decode the shared_areas JSON if present, else use old input or empty array
                              $sharedAreas = [];
                              if (old('shared_facilities')) {
                                   // If user submitted, use the old value (as plain text)
                                   $sharedAreasText = old('shared_facilities');
                              } elseif (!empty($application->shared_areas)) {
                                   // If from DB, decode JSON and format as readable list
                                   $decoded = json_decode($application->shared_areas, true);
                                   if (is_array($decoded)) {
                                        $sharedAreas = $decoded;
                                        $sharedAreasText = implode(", ", $sharedAreas);
                                   } else {
                                        $sharedAreasText = $application->shared_areas;
                                   }
                              } else {
                                   $sharedAreasText = '';
                              }
                         @endphp
                         <textarea name="shared_facilities" rows="3" class="w-full border border-gray-500 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ $sharedAreasText }}</textarea>
                    </div>
                    <div class="mb-4">
                         <div class="flex justify-between items-center mb-2">
                              <label class="block text-sm font-medium text-gray-700">Unit Measurements</label>
                              <button type="button" id="addMeasurement" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                   <i data-lucide="plus" class="w-4 h-4 mr-1"></i>
                                   Add Measurement
                              </button>
                         </div>
                         
                         <div id="measurements-container" class="space-y-4">
                              <!-- This will be filled dynamically based on conveyance data -->
                              @if(count($conveyanceData) > 0)
                                   @foreach($conveyanceData as $index => $buyer)
                                   <div class="measurement-row grid grid-cols-1 md:grid-cols-3 gap-4 p-4 border rounded-md bg-gray-50">
                                        <div>
                                             <label class="block text-sm font-medium text-gray-700 mb-1">Section/Unit No</label>
                                             <input type="text" name="sections[]" value="{{ $buyer['sectionNo'] ?? '' }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        </div>
                                        <div>
                                             <label class="block text-sm font-medium text-gray-700 mb-1">Measurement (sqm)</label>
                                             <input type="text" name="measurements[]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        </div>
                                        <div class="flex items-end">
                                             <button type="button" class="remove-measurement inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                  <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i>
                                                  Remove
                                             </button>
                                        </div>
                                   </div>
                                   @endforeach
                              @else
                                   <div class="measurement-row grid grid-cols-1 md:grid-cols-3 gap-4 p-4 border rounded-md bg-gray-50">
                                        <div>
                                             <label class="block text-sm font-medium text-gray-700 mb-1">Section/Unit No</label>
                                             <input type="text" name="sections[]" value="{{ isset($isPrimary) && $isPrimary ? '' : ($application->unit_number ?? '') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        </div>
                                        <div>
                                             <label class="block text-sm font-medium text-gray-700 mb-1">Measurement (sqm)</label>
                                             <input type="text" name="measurements[]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        </div>
                                        <div class="flex items-end">
                                             <button type="button" class="remove-measurement inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                  <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i>
                                                  Remove
                                             </button>
                                        </div>
                                   </div>
                              @endif
                         </div>
                    </div>
               </div>
               
               <div class="tab-content hidden" id="buyers-tab">
                    <div class="overflow-x-auto">
                         <table class="min-w-full divide-y divide-gray-200">
                              <thead class="bg-gray-50">
                                   <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Buyer Title</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Buyer Name</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Section/Unit No</th>
                                   </tr>
                              </thead>
                              <tbody class="bg-white divide-y divide-gray-200">
                                   @if(count($conveyanceData) > 0)
                                        @foreach($conveyanceData as $buyer)
                                        <tr>
                                             <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $buyer['buyerTitle'] ?? 'N/A' }}</td>
                                             <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $buyer['buyerName'] ?? 'N/A' }}</td>
                                             <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $buyer['sectionNo'] ?? 'N/A' }}</td>
                                        </tr>
                                        @endforeach
                                   @else
                                        <tr>
                                             <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">No buyers found in conveyance data</td>
                                        </tr>
                                   @endif
                              </tbody>
                         </table>
                    </div>
               </div>
               
               <!-- Submit Button -->
               <div class="flex items-center justify-end space-x-3 pt-5 border-t">
                    <a href="{{ route('stmemo.stmemo') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                         Cancel
                    </a>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                         Generate ST Memo
                    </button>
               </div>
          </form>
     </div>
     
     <!-- Footer -->
     @include('admin.footer')
</div>

 
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching
    const tabs = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            // Remove active class from all tabs
            tabs.forEach(t => t.classList.remove('active', 'border-blue-500', 'text-blue-600'));
            tabs.forEach(t => t.classList.add('border-transparent', 'text-gray-500'));
            
            // Add active class to clicked tab
            tab.classList.add('active', 'border-blue-500', 'text-blue-600');
            tab.classList.remove('border-transparent', 'text-gray-500');
            
            // Hide all tab contents
            tabContents.forEach(content => content.classList.add('hidden'));
            
            // Show the corresponding tab content
            const tabId = tab.dataset.tab;
            document.getElementById(`${tabId}-tab`).classList.remove('hidden');
        });
    });
    
    // Add measurement row
    document.getElementById('addMeasurement').addEventListener('click', function() {
        const container = document.getElementById('measurements-container');
        const newRow = document.createElement('div');
        newRow.className = 'measurement-row grid grid-cols-1 md:grid-cols-3 gap-4 p-4 border rounded-md bg-gray-50';
        newRow.innerHTML = `
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Section/Unit No</label>
                <input type="text" name="sections[]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Measurement (sqm)</label>
                <input type="text" name="measurements[]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div class="flex items-end">
                <button type="button" class="remove-measurement inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i>
                    Remove
                </button>
            </div>
        `;
        container.appendChild(newRow);
        
        // Initialize Lucide icons
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
        
        // Add event listener to the new remove button
        attachRemoveEventListeners();
    });
    
    // Function to attach remove event listeners
    function attachRemoveEventListeners() {
        document.querySelectorAll('.remove-measurement').forEach(button => {
            button.addEventListener('click', function() {
                const container = document.getElementById('measurements-container');
                const row = this.closest('.measurement-row');
                
                // Only remove if there's more than one measurement row
                if (container.querySelectorAll('.measurement-row').length > 1) {
                    container.removeChild(row);
                } else {
                    // Clear the inputs instead of removing
                    row.querySelectorAll('input').forEach(input => {
                        input.value = '';
                    });
                }
            });
        });
    }
    
    // Initial attachment of remove event listeners
    attachRemoveEventListeners();
    
    // Form validation
    document.getElementById('stMemoForm').addEventListener('submit', function(e) {
        const sections = document.querySelectorAll('input[name="sections[]"]');
        const measurements = document.querySelectorAll('input[name="measurements[]"]');
        const sharedFacilities = document.querySelector('textarea[name="shared_facilities"]');
        
        let valid = true;
        let errorMessage = '';
        
        if (!sharedFacilities.value.trim()) {
            valid = false;
            errorMessage = 'Please enter shared facilities';
            sharedFacilities.classList.add('border-red-500');
        } else {
            sharedFacilities.classList.remove('border-red-500');
        }
        
        sections.forEach((section, index) => {
            if (!section.value.trim()) {
                valid = false;
                errorMessage = 'Please enter all section/unit numbers';
                section.classList.add('border-red-500');
            } else {
                section.classList.remove('border-red-500');
            }
            
            if (!measurements[index].value.trim()) {
                valid = false;
                errorMessage = 'Please enter all measurements';
                measurements[index].classList.add('border-red-500');
            } else {
                measurements[index].classList.remove('border-red-500');
            }
        });
        
        if (!valid) {
            e.preventDefault();
            Swal.fire({
                title: 'Validation Error',
                text: errorMessage,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });
});
</script>
@endsection
