@extends('layouts.app')
@section('page-title')
Property Records Assistant
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item" aria-current="page"> {{ __('Property Records Assistant') }} </li>
@endsection
 @section('content')
    <script src="{{ asset('assets/js/plugins/ckeditor/classic/ckeditor.js') }}"></script>
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
 
<style>
    .modal {
        transition: opacity 0.25s ease;
    }

    body {
        font-family: Arial, sans-serif;
    }

    .header-cell {
        cursor: pointer;
    }

    .header-cell:hover {
        background-color: #f3f4f6;
    }
    
    

    label {
       color: #000000;
       font-weight: bold;
    }

    /* fields case sensitive */
    input[type="text"] {
        text-transform: uppercase;
    }


</style>


    <div class="container mx-auto mt-4 p-4">

        
        <div >
      
            
            <div class="modal-container bg-white w-11/12 md:max-w-4xl mx-auto rounded-md shadow-lg z-50 overflow-y-auto">
                <!-- Modal Header -->
                <div class="bg-gray-100 p-3 border-b flex justify-between items-center"> 
                    <div class="flex items-center space-x-2">
                        <button id="firstButton" class="p-1 text-gray-600 hover:text-blue-600" title="First Record">
                            <i data-lucide="chevrons-left"></i>
                        </button>
                        <button id="previousButton" class="p-1 text-gray-600 hover:text-blue-600" title="Previous">
                            <i data-lucide="chevron-left"></i>
                        </button>
                        <p id="recordCounter" class="text-lg font-semibold text-gray-700">{{ isset($result) ? $result->id : '' }} of {{$recordCount}}</p>
                        <button id="nextButton" class="p-1 text-gray-600 hover:text-blue-600" title="Next">
                            <i data-lucide="chevron-right"></i>
                        </button>
                        <button id="lastButton" class="p-1 text-gray-600 hover:text-blue-600" title="Last Record">
                            <i data-lucide="chevrons-right"></i>
                        </button>
                    </div>
                    <div class="flex space-x-2">
                        <button class="p-1 bg-red-600 text-white hover:bg-red-700" title="Delete">
                            <i data-lucide="trash-2"></i>
                        </button>
                        <button class="p-1 bg-green-600 text-white hover:bg-green-700" title="Add" onclick="window.location.href='{{ route('propertycard.create') }}'" >
                            <i data-lucide="plus"></i>
                        </button>
                        <button class="p-1 bg-blue-600 text-white hover:bg-blue-700" title="Edit">
                            <i data-lucide="edit"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Modal Content with Alpine.js -->
                <div class="p-2" x-data="propertyRecordForm()">
                    <form method="POST" action="{{ route('propertycard.saveRecord') }}" id="propertyCardForm">
                        @csrf
                        <input type="hidden" id="currentRecordId" name="currentRecordId" value="{{ isset($result) ? $result->id : '' }}">
                        <input type="hidden" name="data_source" value="property_records">
                        <div class="grid grid-cols-3 gap-2">
                            <!-- Left Section -->
                            <div class="col-span-2">
                                <div class="mb-2">
                                    <div class="mb-1 font-bold text-red-600 text-sm uppercase">Property Records Assistant</div>

                                </div>

                                <div class="grid grid-cols-3 gap-2 mb-6">
                                    <div>
                                        <label for="fileNoPrefix" class="block text-sm font-medium text-gray-700 mb-1">File No Prefix</label>
                                        <select id="fileNoPrefix" name="fileNoPrefix" class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" style="color: black;">
                                            <option value="">Select File Prefix</option>
                                            @foreach(['KNML', 'MNKL', 'KN', 'CON-COM', 'CON-RES', 'RES', 'MLKN', 'CON-AG', 'KNGP', 'CON-IND'] as $prefix)
                                                <option value="{{ $prefix }}" {{ (isset($result) && isset($result->fileNoPrefix) && $result->fileNoPrefix == $prefix) ? 'selected' : '' }}>
                                                    {{ $prefix }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label for="fileNumber" class="block text-sm font-medium text-gray-700 mb-1">Number</label>
                                        <input type="text" id="fileNumber" name="fileNumber" class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" value="{{ isset($result) ? ($result->fileNumber ?: 'N/A') : 'N/A' }}" style="color: black;">
                                    </div>
                                    <div>
                                        <label for="Previewflenumber" class="block text-sm font-medium text-gray-700 mb-1">Full File Number</label>
                                        <input type="text" id="Previewflenumber" name="Previewflenumber" class="w-full p-2 border border-gray-300 bg-gray-100 font-medium rounded-md" value="{{ isset($result) ? ($result->kangisFileNo ?: 'N/A') : 'N/A' }}" readonly style="color: black;">
                                    </div>
                                </div>

                                <div class="grid grid-cols-6 gap-2 mb-2">
                                    <div class="col-span-2">
                                        <label for="oldTitleSerialNo" class="block text-xs text-gray-600 mb-1">Serial No</label>
                                        <input type="text" id="oldTitleSerialNo" name="oldTitleSerialNo" class="w-full border rounded p-1 text-xs" value="{{ isset($result) ? ($result->oldTitleSerialNo ?: 'N/A') : 'N/A' }}" />
                                    </div>
                                    <div class="col-span-2">
                                        <label for="oldTitlePageNo" class="block text-xs text-gray-600 mb-1">Page</label>
                                        <input type="text" id="oldTitlePageNo" name="oldTitlePageNo" class="w-full border rounded p-1 text-xs" value="{{ isset($result) ? ($result->oldTitlePageNo ?: 'N/A') : 'N/A' }}" />
                                    </div>
                                    <div class="col-span-2">
                                        <label for="oldTitleVolumeNo" class="block text-xs text-gray-600 mb-1">Vol</label>
                                        <input type="text" id="oldTitleVolumeNo" name="oldTitleVolumeNo" class="w-full border rounded p-1 text-xs" value="{{ isset($result) ? ($result->oldTitleVolumeNo ?: 'N/A') : 'N/A' }}" />
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <label for="description" class="block text-xs text-gray-600 mb-1">Description</label>
                                    <input type="text" id="description" name="description" class="w-full border rounded p-1 text-xs" value="{{ isset($result) ? ($result->description ?: 'N/A') : 'N/A' }}"  />
                                </div>

                                <div class="grid grid-cols-6 gap-2 mb-2">
                                    <div class="col-span-3">
                                        <label for="lgaName" class="block text-xs text-gray-600 mb-1">Lgsa Or City</label>
                                        <input type="text" id="lgaName" name="lgaName" class="w-full border rounded p-1 text-xs" value="{{ isset($result) ? ($result->lgaName ?: 'N/A') : 'N/A' }}" />
                                    </div>
                                    <div class="col-span-3">
                                        <label for="plotNo" class="block text-xs text-gray-600 mb-1">Plot No</label>
                                        <input type="text" id="plotNo" name="plotNo" class="w-full border rounded p-1 text-xs" value="{{ isset($result) ? ($result->plotNo ?: 'N/A') : 'N/A' }}" />
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-2 mb-2">
                                    <div>
                                        <label for="originalAllottee" class="block text-xs text-gray-600 mb-1" x-text="partyLabels.firstParty"></label>
                                        <input type="text" id="originalAllottee" name="originalAllottee" class="w-full border rounded p-1 text-xs" value="{{ isset($result) ? ($result->originalAllottee ?: 'N/A') : 'N/A' }}" :placeholder="`Enter ${partyLabels.firstParty.toLowerCase()}'s name`" />
                                    </div>
                                    <div>
                                        <label for="currentAllottee" class="block text-xs text-gray-600 mb-1" x-text="partyLabels.secondParty"></label>
                                        <input type="text" id="currentAllottee" name="currentAllottee" class="w-full border rounded p-1 text-xs" value="{{ isset($result) ? ($result->currentAllottee ?: 'N/A') : 'N/A' }}" :placeholder="`Enter ${partyLabels.secondParty.toLowerCase()}'s name`" />
                                    </div>
                                </div>

                                <div class="grid grid-cols-3 gap-2 mb-2">
                                    <div>
                                        <label for="instrument" class="block text-xs text-gray-600 mb-1">Instrument</label>
                                        <div class="relative">
                                            <select id="instrument" name="instrument" x-model="selectedInstrument" class="w-full border rounded p-1 pr-6 appearance-none text-xs">
                                                <option value="">Select Transaction Type</option>
                                                <option value="power-of-attorney">Power of Attorney</option>
                                                <option value="irrevocable-power-of-attorney">Irrevocable Power of Attorney</option>
                                                <option value="deed-of-mortgage">Deed of Mortgage</option>
                                                <option value="tripartite-mortgage">Tripartite Mortgage</option>
                                                <option value="deed-of-assignment">Deed of Assignment</option>
                                                <option value="deed-of-lease">Deed of Lease</option>
                                                <option value="deed-of-sub-lease">Deed of Sub-Lease</option>
                                                <option value="deed-of-sub-under-lease">Deed of Sub-Under-Lease</option>
                                                <option value="deed-of-sub-division">Deed of Sub-Division</option>
                                                <option value="deed-of-merger">Deed of Merger</option>
                                                <option value="deed-of-surrender">Deed of Surrender</option>
                                                <option value="deed-of-variation">Deed of Variation</option>
                                                <option value="deed-of-assent">Deed of Assent</option>
                                                <option value="deed-of-release">Deed of Release</option>
                                                <option value="right-of-occupancy">Right of Occupancy (R of O)</option>
                                                <option value="certificate-of-occupancy">Certificate of Occupancy (C of O)</option>
                                                <option value="sectional-titling-c-of-o">Sectional Titling Certificate of Occupancy</option>
                                                <option value="sltr-c-of-o">Systematic Land Titling and Registration (SLTR) Certificate of Occupancy</option>
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-1 text-gray-700">
                                                <svg class="h-3 w-3" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="layoutName" class="block text-xs text-gray-600 mb-1 ">Layout</label>
                                        <div class="relative">
                                            <select id="layoutName" name="layout" class="w-full border rounded p-1 pr-6 appearance-none text-xs">
                                                <option value="">{{ isset($result) ? ($result->layoutName ?: 'N/A') : 'N/A' }}</option>
                                               
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-1 text-gray-700">
                                                <svg class="h-3 w-3" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="schedule" class="block text-xs text-gray-600 mb-1 ">Schedule</label>
                                        <div class="relative">
                                            <select id="schedule" class="w-full border rounded p-1 pr-6 appearance-none text-xs" disabled>
                                                <option></option>
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-1 text-gray-700">
                                                <svg class="h-3 w-3" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Section -->
                            <div class="col-span-1">
                                <span class="text-right">Quick Search / Filter</span>
                                <div class="border rounded">
                                    <div class="mb-1">
                                        <input type="checkbox" id="scheduleFilter" class="mr-1 schedule-checkbox" />
                                        <label for="scheduleFilter" class="text-xs">Schedule</label>
                                        <div class="relative mt-1">
                                            <select class="w-full border rounded p-1 pr-6 appearance-none text-xs schedule-input" disabled>
                                                <option></option>
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-1 text-gray-700">
                                                <svg class="h-3 w-3" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-1">
                                        <input type="checkbox" id="lgsa" class="mr-1 lgsa-checkbox" />
                                        <label for="lgsa" class="text-xs">Lgsa</label>
                                        <div class="relative mt-1">
                                            <input type="text" id="lgaName" name="lgaName" class="w-full border rounded p-1 text-xs lgsa-input" value="{{ request('lgaName') }}" disabled />
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-1 text-gray-700">
                                                <svg class="h-3 w-3" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-1">
                                        <input type="checkbox" id="grantor" x-model="grantorEnabled" class="mr-1 grantor-checkbox" />
                                        <label for="grantor" class="text-xs" x-text="partyLabels.firstParty"></label>
                                        <input type="text" id="Assignor" name="originalAllottee" 
                                               class="w-full border rounded p-1 mt-1 text-xs grantor-input" 
                                               value="{{ request('originalAllottee') }}" 
                                               :disabled="!grantorEnabled"
                                               :placeholder="`Enter ${partyLabels.firstParty.toLowerCase()}'s name`"
                                               :class="grantorEnabled ? 'bg-white border-green-500 border-2 shadow-sm' : 'bg-gray-100 border-gray-300'" />
                                    </div>

                                    <div class="mb-1">
                                        <input type="checkbox" id="grantee" x-model="granteeEnabled" class="mr-1 grantee-checkbox" />
                                        <label for="grantee" class="text-xs" x-text="partyLabels.secondParty"></label>
                                        <input type="text" id="Assignee" name="currentAllottee" 
                                               class="w-full border rounded p-1 mt-1 text-xs grantee-input" 
                                               value="{{ request('currentAllottee') }}" 
                                               :disabled="!granteeEnabled"
                                               :placeholder="`Enter ${partyLabels.secondParty.toLowerCase()}'s name`"
                                               :class="granteeEnabled ? 'bg-white border-green-500 border-2 shadow-sm' : 'bg-gray-100 border-gray-300'" />
                                    </div>

                                    <div class="mb-2">
                                        <input type="checkbox" id="mlsfNoCheckbox" class="mr-1" />
                                        <label for="mlsfNoCheckbox" class="text-xs">Enable MLS File #</label>
                                        <div class="relative mt-1">
                                            <input type="text" id="mlsfNo" name="mlsfNo" class="w-full border rounded p-1 text-xs" value="{{ request('mlsfNo') }}" disabled />
                                        </div>
                                    </div>

                                    <div class="mb-1">
                                        <input type="checkbox" id="kangisFileNoCheckbox" class="mr-1" />
                                        <label for="kangisFileNoCheckbox" class="text-xs">Enable Kangis File #</label>
                                        <input type="text" id="kangisFileNo" name="kangisFileNo" class="w-full border rounded p-1 text-xs" value="{{ request('kangisFileNo') }}" disabled />
                                    </div>
                                    <div class="flex justify-between">
                                        <button type="submit" id="findButton" formaction="{{ route('propertycard.search') }}" class="p-0.5 border rounded flex items-center space-x-1 w-20 bg-green-600 text-white justify-center">
                                            <span class="text-[10px]">Find</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                        </button>

                                        <button type="button" id="saveButton" class="p-0.5 border rounded flex items-center space-x-1 w-20 bg-blue-600 text-white justify-center">
                                            <span class="text-[10px]">Save</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 3H7a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2V5a2 2 0 00-2-2zM12 19l-4-4h3V9h2v6h3l-4 4z" />
                                            </svg>
                                        </button>

                                        <button type="button" id="refreshButton" class="p-0.5 border rounded flex items-center space-x-1 w-20 bg-teal-900 text-white justify-center">
                                            <span class="text-[10px]">Refresh</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v6h6M20 20v-6h-6M20 4l-8 8M12 12l-8 8" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script>
// Alpine.js component for Property Record Form
function propertyRecordForm() {
    return {
        selectedInstrument: '',
        grantorEnabled: false,
        granteeEnabled: false,
        
        // Define instrument types with their corresponding party labels
        instrumentTypes: {
            'power-of-attorney': { firstParty: 'Grantor', secondParty: 'Grantee' },
            'irrevocable-power-of-attorney': { firstParty: 'Grantor', secondParty: 'Grantee' },
            'deed-of-mortgage': { firstParty: 'Mortgagor', secondParty: 'Mortgagee' },
            'tripartite-mortgage': { firstParty: 'Mortgagor', secondParty: 'Mortgagee' },
            'deed-of-assignment': { firstParty: 'Assignor', secondParty: 'Assignee' },
            'deed-of-lease': { firstParty: 'Lessor', secondParty: 'Lessee' },
            'deed-of-sub-lease': { firstParty: 'Sub-Lessor', secondParty: 'Sub-Lessee' },
            'deed-of-sub-under-lease': { firstParty: 'Sub-Under-Lessor', secondParty: 'Sub-Under-Lessee' },
            'deed-of-sub-division': { firstParty: 'Subdivider', secondParty: 'Beneficiary' },
            'deed-of-merger': { firstParty: 'Merging Party', secondParty: 'Receiving Party' },
            'deed-of-surrender': { firstParty: 'Surrenderer', secondParty: 'Recipient' },
            'deed-of-variation': { firstParty: 'Party', secondParty: 'Counterparty' },
            'deed-of-assent': { firstParty: 'Executor/Administrator', secondParty: 'Beneficiary' },
            'deed-of-release': { firstParty: 'Releasor', secondParty: 'Releasee' },
            'right-of-occupancy': { firstParty: 'Holder', secondParty: 'Authority' },
            'certificate-of-occupancy': { firstParty: 'Holder', secondParty: 'Authority' },
            'sectional-titling-c-of-o': { firstParty: 'Unit Owner', secondParty: 'Authority' },
            'sltr-c-of-o': { firstParty: 'Holder', secondParty: 'Authority' }
        },
        
        // Computed property for party labels
        get partyLabels() {
            if (this.selectedInstrument && this.instrumentTypes[this.selectedInstrument]) {
                return this.instrumentTypes[this.selectedInstrument];
            }
            return { firstParty: 'Assignor', secondParty: 'Assignee' };
        },
        
        // Watch for changes in selectedInstrument
        init() {
            console.log('🚀 Alpine.js Property Record Form initialized');
            
            // Watch for changes in selectedInstrument
            this.$watch('selectedInstrument', (value) => {
                console.log('📝 Instrument changed to:', value);
                
                if (value && value !== '') {
                    console.log('✅ Enabling grantor and grantee fields');
                    this.grantorEnabled = true;
                    this.granteeEnabled = true;
                } else {
                    console.log('🔄 Disabling grantor and grantee fields');
                    this.grantorEnabled = false;
                    this.granteeEnabled = false;
                }
                
                console.log('🏷️ Party labels updated to:', this.partyLabels);
            });
        }
    }
}

console.log('🎉 Alpine.js Property Record Form script loaded');
</script>
@endsection