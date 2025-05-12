<div id="detterment-tab" class="tab-content active">
    <form id="deeds-form" method="POST" action="{{ route('primary-applications.storeDeeds') }}">
        @csrf
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
            <div class="p-4 border-b">
                <h3 class="text-sm font-medium">Deeds</h3>
                <p class="text-xs text-gray-500">{{ isset($isSecondary) && $isSecondary ? 'Secondary Application' : 'Primary Application' }}</p>
            </div>
            <input type="hidden" name="application_id" value="{{ $application->id }}">
            <input type="hidden" name="fileno" value="{{ $application->fileno }}">
            @if(isset($isSecondary) && $isSecondary)
                <input type="hidden" name="sub_application_id" value="{{ $application->id }}">
            @endif
            
            <!-- Debug output to check what data is available -->
            @if(app()->environment('local') && isset($isSecondary) && $isSecondary)
            <div class="p-2 bg-gray-100 text-xs">
                <details>
                    <summary>Debug Info</summary>
                    <pre>{{ print_r($deeds, true) }}</pre>
                </details>
            </div>
            @endif
            
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
                <hr class="my-4">

                <div class="flex justify-between items-center">
                    <div class="flex gap-2">
                        <a
                            href="{{ isset($isSecondary) && $isSecondary ? route('other_departments.survey_secondary') : route('other_departments.deeds_primary') }}"
                            class="flex items-center px-3 py-1 text-xs bg-white text-black p-2 border border-gray-500 rounded-md hover:bg-gray-800"
                        >
                            <i data-lucide="undo-2" class="w-3.5 h-3.5 mr-1.5"></i>
                            Back
                        </a>
                    </div>
                    
                    <!-- Edit and Submit Buttons - ensure data-lucide icons are initialized -->
                    <div class="flex gap-2">
                        <button
                            type="button"
                            id="edit-deeds"
                            class="flex items-center px-3 py-1 text-xs bg-blue-600 text-white p-2 border border-blue-600 rounded-md hover:bg-blue-700"
                            onclick="enableDeedsEditing()"
                        >
                            <i data-lucide="edit-3" class="w-3.5 h-3.5 mr-1.5"></i>
                            Edit Deeds
                        </button>
                        
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

                <!-- Inline script for critical functionality -->
                <script>
                    function enableDeedsEditing() {
                        console.log('Enable deeds editing function called');
                        // Enable all deed fields
                        const deedFields = document.querySelectorAll('.deed-field');
                        deedFields.forEach(field => {
                            field.disabled = false;
                            field.classList.remove('bg-gray-100', 'text-gray-500', 'cursor-not-allowed');
                            field.classList.add('bg-white');
                        });
                        
                        // Show the submit button
                        document.getElementById('submit-deeds').classList.remove('hidden');
                        
                        // Hide the edit button
                        document.getElementById('edit-deeds').classList.add('hidden');
                    }
                    
                    function submitDeedsForm() {
                        console.log('Submit deeds form function called');
                        
                        // Show loading message
                        Swal.fire({
                            title: 'Processing...',
                            text: 'Submitting deeds information',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        
                        // Get the form data directly
                        const form = document.getElementById('deeds-form');
                        const formData = new FormData(form);
                        
                        // Log the form data for debugging
                        console.log('Form elements:', form.elements);
                        for (let pair of formData.entries()) {
                            console.log(pair[0] + ': ' + pair[1]);
                        }
                        
                        // Send AJAX request directly
                        fetch('{{ route('primary-applications.storeDeeds') }}', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => {
                            console.log('Response status:', response.status);
                            if (!response.ok) {
                                return response.text().then(text => {
                                    throw new Error('Server error: ' + text);
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('Success data:', data);
                            // Show success message
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: data.message || 'Deeds information submitted successfully',
                                confirmButtonColor: '#3085d6'
                            }).then(() => {
                                // After successful submission, disable the fields again
                                const deedFields = document.querySelectorAll('.deed-field');
                                deedFields.forEach(field => {
                                    field.disabled = true;
                                    field.classList.add('bg-gray-100', 'text-gray-500', 'cursor-not-allowed');
                                });
                                
                                // Hide the submit button and show the edit button
                                document.getElementById('submit-deeds').classList.add('hidden');
                                document.getElementById('edit-deeds').classList.remove('hidden');
                            });
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Submission Failed',
                                text: 'There was an error submitting the deeds information. Please try again.',
                                confirmButtonColor: '#3085d6'
                            });
                        });
                    }
                </script>
            </div>
        </div>
    </form>
</div>