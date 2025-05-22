<div id="detterment-tab" class="tab-content active">
    <form id="deeds-form" method="POST" action="{{ route('primary-applications.storeDeeds') }}">
        @csrf
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
            <div class="p-4 border-b">
                <h3 class="text-sm font-medium">Deeds</h3>
                <p class="text-xs text-gray-500">
                    {{ isset($isSecondary) && $isSecondary ? 'Secondary Application' : 'Primary Application' }}</p>
            </div>
            <input type="hidden" name="application_id" value="{{ $application->id }}">
            <input type="hidden" name="fileno" value="{{ $application->fileno }}">
            @if(isset($isSecondary) && $isSecondary)
                <input type="hidden" name="sub_application_id" value="{{ $application->id }}">
            @endif
            
            <!-- Debug output to check what data is available -->
            @if(app()->environment('local') && isset($isSecondary) && $isSecondary)
            {{-- <div class="p-2 bg-gray-100 text-xs">
                <details>
                    <summary>Debug Info</summary>
                    <pre>{{ print_r($deeds, true) }}</pre>
                </details>
            </div> --}}
            @endif
            
            <!-- Nested Tab Navigation -->
            <div class="flex border-b px-4 pt-2">
                <button type="button" class="nested-tab-button active px-4 py-2 text-xs font-medium border-b-2 border-blue-500" data-nested-tab="assignment-content">
                    Assignment Reg Particulars
                </button>
                <button type="button" class="nested-tab-button px-4 py-2 text-xs font-medium border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300" data-nested-tab="cofo-content">
                    CofO Reg Particular
                </button>
            </div>
            <br>
            <!-- Assignment Reg Particulars Tab Content -->
            <div id="assignment-content" class="nested-tab-content active">
                <div class="p-4 space-y-4">
                    @php
                    $assignment = DB::connection('sqlsrv')
                        ->table('Sectional_title_transfer')
                        ->where('application_id', $application->primary_id ?? $application->main_application_id ?? $application->id)
                        ->first();
                    @endphp
                    
                    <div class="grid grid-cols-3 gap-4">
                        <div class="space-y-2">
                            <label for="assignment-serial-no" class="text-xs font-medium block">
                                Serial No
                            </label>
                            <input
                                id="assignment-serial-no"
                                name="assignment_serial_no"
                                type="text"
                                value="{{ $assignment->serial_no ?? '' }}"
                                class="w-full p-2 border border-gray-300 rounded-md text-sm deed-field"
                                disabled
                            >
                        </div>
                        <div class="space-y-2">
                            <label for="assignment-page-no" class="text-xs font-medium block">
                                Page No
                            </label>
                            <input
                                id="assignment-page-no"
                                name="assignment_page_no"
                                type="text"
                                value="{{ $assignment->page_no ?? '' }}"
                                class="w-full p-2 border border-gray-300 rounded-md text-sm deed-field"
                                disabled
                            >
                        </div>
                        <div class="space-y-2">
                            <label for="assignment-volume-no" class="text-xs font-medium block">
                                Volume No
                            </label>
                            <input
                                id="assignment-volume-no"
                                name="assignment_volume_no"
                                type="text"
                                value="{{ $assignment->volume_no ?? '' }}"
                                class="w-full p-2 border border-gray-300 rounded-md text-sm deed-field"
                                disabled
                            >
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                       
                        <div class="space-y-2">
                            <label for="assignment-time" class="text-xs font-medium block">
                                Registration Time
                            </label>
                            <input
                                id="assignment-time"
                                name="assignment_time"
                                type="text"
                                value="{{ $assignment->deeds_time ?? '' }}"
                                class="w-full p-2 border border-gray-300 rounded-md text-sm deed-field"
                                disabled
                            >
                        </div>

                         <div class="space-y-2">
                            <label for="assignment-date" class="text-xs font-medium block">
                                Registration Date
                            </label>
                            <input
                                id="assignment-date"
                                name="assignment_date"
                                type="date"
                                value="{{ $assignment->registration_date ?? '' }}"
                                class="w-full p-2 border border-gray-300 rounded-md text-sm deed-field"
                                disabled
                            >
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- CofO Reg Particular Tab Content -->
            <div id="cofo-content" class="nested-tab-content hidden">
                <div class="p-4 space-y-4">
                    <div class="grid grid-cols-3 gap-4">
                        <div class="space-y-2">
                            <label for="serial-no" class="text-xs font-medium block">
                                Serial No
                            </label>
                            <input
                                id="serial-no"
                                name="serial_no"
                                type="text"
                                value="{{ $deeds->serial_no ?? '' }}"
                                class="w-full p-2 border border-gray-300 rounded-md text-sm deed-field"
                                disabled
                            >
                        </div>
                        <div class="space-y-2">
                            <label for="page-no" class="text-xs font-medium block">
                                Page No
                            </label>
                            <input
                                id="page-no"
                                name="page_no"
                                type="text"
                                value="{{ $deeds->page_no ?? '' }}"
                                class="w-full p-2 border border-gray-300 rounded-md text-sm deed-field"
                                disabled
                            >
                        </div>
                        <div class="space-y-2">
                            <label for="volume-no" class="text-xs font-medium block">
                                Volume No
                            </label>
                            <input
                                id="volume-no"
                                name="volume_no"
                                type="text"
                                value="{{ $deeds->volume_no ?? '' }}"
                                class="w-full p-2 border border-gray-300 rounded-md text-sm deed-field"
                                disabled
                            >
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label for="deeds-time" class="text-xs font-medium block">
                                Deeds Time
                            </label>
                            <input
                                id="deeds-time"
                                name="deeds_time"
                                type="text"
                                value="{{ $deeds->deeds_time ?? '' }}"
                                class="w-full p-2 border border-gray-300 rounded-md text-sm deed-field"
                                disabled
                            >
                        </div>
                        <div class="space-y-2">
                            <label for="deeds-date" class="text-xs font-medium block">
                                Deeds Date
                            </label>
                            <input
                                id="deeds-date"
                                name="deeds_date"
                                type="text"
                                value="{{ $deeds->deeds_date ?? '' }}"
                                class="w-full p-2 border border-gray-300 rounded-md text-sm deed-field"
                                disabled
                            >
                        </div>
                    </div>
                </div>
            </div>
            
            <hr class="my-4">

            <div class="p-4">
                <div class="flex gap-2">
                    <a
                        href="javascript:void(0);"
                        onclick="window.history.back()"
                        class="flex items-center px-3 py-1 text-xs bg-white text-black p-2 border border-gray-500 rounded-md hover:bg-gray-800"
                    >
                        <i data-lucide="undo-2" class="w-3.5 h-3.5 mr-1.5"></i>
                        Back
                    </a>
                      
                    @if(!request()->has('is') || request()->get('is') !== 'secondary')
                        {{-- <button
                            type="button"
                            id="edit-deeds"
                            class="flex items-center px-3 py-1 text-xs bg-blue-600 text-white p-2 border border-blue-600 rounded-md hover:bg-blue-700"
                            onclick="enableDeedsEditing()"
                        >
                            <i data-lucide="edit-3" class="w-3.5 h-3.5 mr-1.5"></i>
                            Edit Deeds
                        </button> --}}
                    @endif
                    <button
                        type="button"
                        id="submit-deeds"
                        onclick="submitDeedsForm()"
                        class="flex items-center px-3 py-1 text-xs bg-green-600 text-white p-2 border border-green-600 rounded-md hover:bg-green-700 hidden"
                    >
                        <i data-lucide="save" class="w-3.5 h-3.5 mr-1.5"></i>
                        Save Changes
                    </button>
                </div>
            </div>

            <!-- CSS for nested tabs -->
            <style>
                .nested-tab-content {
                    display: none;
                }
                .nested-tab-content.active {
                    display: block;
                }
                .nested-tab-button {
                    position: relative;
                    cursor: pointer;
                    transition: background-color 0.2s;
                }
                .nested-tab-button.active {
                    color: #1d4ed8;
                    font-weight: 500;
                }
                .nested-tab-button:hover:not(.active) {
                    color: #4b5563;
                }
            </style>

            <!-- JavaScript for nested tabs -->
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Add nested tab functionality
                    const nestedTabButtons = document.querySelectorAll('.nested-tab-button');
                    const nestedTabContents = document.querySelectorAll('.nested-tab-content');
                    
                    nestedTabButtons.forEach(button => {
                        button.addEventListener('click', function() {
                            const tabId = this.getAttribute('data-nested-tab');
                            
                            // Deactivate all nested tabs
                            nestedTabButtons.forEach(btn => {
                                btn.classList.remove('active');
                                btn.classList.remove('border-blue-500');
                                btn.classList.add('border-transparent');
                            });
                            nestedTabContents.forEach(content => {
                                content.classList.remove('active');
                                content.classList.add('hidden');
                            });
                            
                            // Activate selected nested tab
                            this.classList.add('active', 'border-blue-500');
                            this.classList.remove('border-transparent');
                            const tabContent = document.getElementById(tabId);
                            if (tabContent) {
                                tabContent.classList.add('active');
                                tabContent.classList.remove('hidden');
                            }
                        });
                    });

                    // ...existing code for form submission...
                });

                // ...existing enableDeedsEditing and submitDeedsForm functions...
            </script>
        </div>
    </form>
</div>