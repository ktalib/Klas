<div id="property-form-dialog" class="dialog-overlay hidden" >
                <div class="dialog-content property-form-content">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold">Add New Property</h2>
                        <button id="close-property-form" class="text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </div>
                   <form id="property-record-form" action="{{ route('property-records.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="property_id" id="property_id" value="">
                        <input type="hidden" name="action" id="action" value="add">
                    <div class="space-y-4 py-2 max-h-[75vh] overflow-y-auto pr-1">
                        <!-- Top section with two columns -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Left column - Title Type Section -->
                            <div class="form-section">
                                <h4 class="form-section-title">Property Type Information</h4>
                                <div class="space-y-3">
                                    <div class="space-y-1">
                                        <label class="text-sm">Title Type</label>
                                        <div class="flex space-x-4">
                                            <div class="flex items-center space-x-1">
                                                <input type="radio" id="customary" name="titleType" value="Customary" checked>
                                                <label for="customary" class="text-sm">Customary</label>
                                            </div>
                                            <div class="flex items-center space-x-1">
                                                <input type="radio" id="statutory" name="titleType" value="Statutory">
                                                <label for="statutory" class="text-sm">Statutory</label>
                                            </div>
                                        </div>
                                    </div>
            
                                    <!-- File Number -->
                                   <div class="space-y-1">
                                      @include('propertycard.partials.fileno', ['prefix' => 'property_'])
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Right column - Property Description -->
                            <div class="form-section">
                                <h4 class="form-section-title">Property Description</h4>
                                <div class="space-y-3">
                                    <div class="space-y-1">
                                        <label for="property-description" class="text-sm">Description</label>
                                        <textarea id="property-description" name="property_description" rows="4" class="form-input text-sm" placeholder="Enter property description"></textarea>
                                    </div>
                                    
                                    <!-- LGA/City and Plot No. -->
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label for="lgsaOrCity" class="text-xs text-gray-600">LGA/City</label>
                                            <input id="lgsaOrCity" name="lgsaOrCity" type="text" class="form-input text-sm">
                                        </div>
                                        <div>
                                            <label for="plotNo" class="text-xs text-gray-600">Plot No.</label>
                                            <input id="plotNo" name="plot_no" type="text" class="form-input text-sm" placeholder="Enter plot number">
                                        </div>
                                    </div>
                                    
                                    <!-- Layout and Schedule -->
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label for="layout" class="text-xs text-gray-600">Layout</label>
                                            <select id="layout" name="layout" class="form-select text-sm">
                                                <option value="">Select Layout</option>
                                                <option value="Residential">Residential</option>
                                                <option value="Commercial">Commercial</option>
                                                <option value="Industrial">Industrial</option>
                                                <option value="Agricultural">Agricultural</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="schedule" class="text-xs text-gray-600">Schedule</label>
                                            <select id="schedule" name="schedule" class="form-select text-sm">
                                                <option value="">Select Schedule</option>
                                                <option value="Regular">Regular</option>
                                                <option value="Sectional">Sectional</option>
                                            </select>
                                        </div>
                                    </div>
                                  
                                </div>
                            </div>
                        </div>
        
                        <!-- Transaction Details Section -->
                        <div class="form-section">
                            <h4 class="form-section-title">Transaction Details</h4>
                            <div class="space-y-3">
                                <!-- Transaction Type and Date -->
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="space-y-1">
                                        <label for="transactionType-record" class="text-sm">Transaction Type</label>
                                        <select id="transactionType-record" class="form-select text-sm transaction-type-select">
                                            <option value="">Select type</option>
                                            <option value="Assignment">Assignment</option>
                                            <option value="Mortgage">Mortgage</option>
                                            <option value="Surrender">Surrender</option>
                                            <option value="Sub-Lease">Sub-Lease</option>
                                            <option value="Release">Release</option>
                                            <option value="Devolution Order">Devolution Order</option>
                                            <option value="Court Order">Court Order</option>
                                            <option value="Revocation">Revocation</option>
                                            <option value="Certificate of Occupancy">Certificate of Occupancy</option>
                                            <option value="Power of Attorney">Power of Attorney</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                    <div class="space-y-1">
                                        <label for="transactionDate" class="text-sm">Transaction Date</label>
                                        <input type="date" id="transactionDate" class="form-input text-sm">
                                    </div>
                                </div>
        
                                <!-- Registration Number Components -->
                                <div class="space-y-1">
                                    <label class="text-sm">Registration Number Components</label>
                                    <div class="grid grid-cols-3 gap-2">
                                        <div>
                                            <label for="serialNo" class="text-xs">Serial No.</label>
                                            <input id="serialNo" name="serialNo" class="form-input text-sm" placeholder="e.g. 1">
                                        </div>
                                        <div>
                                            <label for="pageNo" class="text-xs">Page No.</label>
                                            <input id="pageNo" name="pageNo" class="form-input text-sm" placeholder="e.g. 1">
                                        </div>
                                        <div>
                                            <label for="volumeNo" class="text-xs">Volume No.</label>
                                            <input id="volumeNo" name="volumeNo" class="form-input text-sm" placeholder="e.g. 2">
                                        </div>
                                    </div>
                                    <div id="regNoPreview" class="mt-1 p-1.5 bg-green-50 border border-green-100 rounded-md hidden">
                                        <div class="flex items-center justify-between">
                                            <span class="text-xs text-green-700">REG NO:</span>
                                            <span id="regNo" class="text-sm font-medium text-green-800"></span>
                                        </div>
                                        <div class="text-xs text-green-600 text-right">Format: 1/1/2</div>
                                    </div>
                                </div>
        
                                <!-- Instrument Type and Period -->
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="space-y-1">
                                        <label for="instrumentType" class="text-sm">Instrument Type</label>
                                        <select id="instrumentType" class="form-select text-sm">
                                            <option value="">Select instrument</option>
                                            <option value="Deed of Assignment">Deed of Assignment</option>
                                            <option value="Certificate of Occupancy">Certificate of Occupancy</option>
                                            <option value="Deed of Mortgage">Deed of Mortgage</option>
                                            <option value="Deed of Lease">Deed of Lease</option>
                                            <option value="Deed of Release">Deed of Release</option>
                                            <option value="Court Order">Court Order</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                    <div class="space-y-1">
                                        <label for="period" class="text-sm">Period</label>
                                        <div class="flex space-x-1">
                                            <input id="period" type="number" class="form-input text-sm" placeholder="Period">
                                            <select id="periodUnit" class="form-select text-sm w-[90px]">
                                                <option value="Days">Days</option>
                                                <option value="Months">Months</option>
                                                <option value="Years" selected>Years</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
        
                        <!-- Transaction-specific fields (will be shown/hidden based on transaction type) -->
                        <div id="transaction-specific-fields-record" class="form-section hidden">
                            <h3 class="form-section-title">Transaction Details</h3>
                            <!-- Assignment fields -->
                            <div id="assignment-fields-record" class="transaction-fields hidden">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div class="space-y-1">
                                        <label for="trans-assignor-record" class="text-sm">Assignor</label>
                                        <input id="trans-assignor-record" class="form-input text-sm" placeholder="Enter assignor name">
                                    </div>
                                    <div class="space-y-1">
                                        <label for="trans-assignee-record" class="text-sm">Assignee</label>
                                        <input id="trans-assignee-record" class="form-input text-sm" placeholder="Enter assignee name">
                                    </div>
                                </div>
                            </div>
                            <!-- Mortgage fields -->
                            <div id="mortgage-fields-record" class="transaction-fields hidden">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div class="space-y-1">
                                        <label for="mortgagor-record" class="text-sm">Mortgagor</label>
                                        <input id="mortgagor-record" class="form-input text-sm" placeholder="Enter mortgagor name">
                                    </div>
                                    <div class="space-y-1">
                                        <label for="mortgagee-record" class="text-sm">Mortgagee</label>
                                        <input id="mortgagee-record" class="form-input text-sm" placeholder="Enter mortgagee name">
                                    </div>
                                </div>
                            </div>
                            <!-- Surrender fields -->
                            <div id="surrender-fields-record" class="transaction-fields hidden">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div class="space-y-1">
                                        <label for="surrenderor-record" class="text-sm">Surrenderor</label>
                                        <input id="surrenderor-record" class="form-input text-sm" placeholder="Enter surrenderor name">
                                    </div>
                                    <div class="space-y-1">
                                        <label for="surrenderee-record" class="text-sm">Surrenderee</label>
                                        <input id="surrenderee-record" class="form-input text-sm" placeholder="Enter surrenderee name">
                                    </div>
                                </div>
                            </div>
                            <!-- Lease fields -->
                            <div id="lease-fields-record" class="transaction-fields hidden">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div class="space-y-1">
                                        <label for="lessor-record" class="text-sm">Lessor</label>
                                        <input id="lessor-record" class="form-input text-sm" placeholder="Enter lessor name">
                                    </div>
                                    <div class="space-y-1">
                                        <label for="lessee-record" class="text-sm">Lessee</label>
                                        <input id="lessee-record" class="form-input text-sm" placeholder="Enter lessee name">
                                    </div>
                                </div>
                            </div>
                            <!-- Default/Grant fields -->
                            <div id="default-fields-record" class="transaction-fields hidden">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div class="space-y-1">
                                        <label for="grantor-record" class="text-sm">Grantor</label>
                                        <input id="grantor-record" class="form-input text-sm" placeholder="Enter grantor name">
                                    </div>
                                    <div class="space-y-1">
                                        <label for="grantee-record" class="text-sm">Grantee</label>
                                        <input id="grantee-record" class="form-input text-sm" placeholder="Enter grantee name">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3 pt-2 border-t mt-4">
                        
                        <button  type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
                </div>
            </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form submission handler
    const propertyForm = document.getElementById('property-record-form');
    if (propertyForm) {
        propertyForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Update all file numbers in hidden fields
            updateFormFileData('property_');
            
            // Update registration number preview and hidden field
            const serialNo = document.getElementById('serialNo').value || '';
            const pageNo = document.getElementById('pageNo').value || '';
            const volumeNo = document.getElementById('volumeNo').value || '';
            
            if (document.getElementById('regNo')) {
                document.getElementById('regNo').textContent = `${serialNo}/${pageNo}/${volumeNo}`;
            }
            
            // Create a hidden input for the reg number if it doesn't exist
            if (!document.getElementById('regNoField')) {
                const regNoInput = document.createElement('input');
                regNoInput.type = 'hidden';
                regNoInput.id = 'regNoField';
                regNoInput.name = 'regNo';
                regNoInput.value = `${serialNo}/${pageNo}/${volumeNo}`;
                propertyForm.appendChild(regNoInput);
            } else {
                document.getElementById('regNoField').value = `${serialNo}/${pageNo}/${volumeNo}`;
            }
            
            // Get transaction-specific fields based on the active transaction type
            const transactionType = document.getElementById('transactionType-record').value;
            if (transactionType) {
                // Update party field names based on transaction type
                updatePartyFields(transactionType);
            }
            
            // Now actually submit the form
            console.log('Submitting form...');
            
            // Show loading state
            Swal.fire({
                title: 'Processing...',
                text: 'Saving property record',
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Get the form action URL as a string
            const actionUrl = propertyForm.getAttribute('action');
            
            // Use fetch API for AJAX submission
            fetch(actionUrl, {
                method: 'POST',
                body: new FormData(propertyForm),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            })
            .then(response => {
                if (!response.ok) {
                    // Handle validation errors specifically
                    if (response.status === 422) {
                        return response.json().then(data => {
                            throw new Error('Validation failed');
                        });
                    }
                    throw new Error('Network response was not ok: ' + response.statusText);
                }
                return response.json();
            })
            .catch(error => {
                console.error('Error:', error);
                // Show error message with SweetAlert
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Validation failed',
                    confirmButtonColor: '#3085d6'
                });
            });
        });
    }
    
    // Function to update party fields based on transaction type
    function updatePartyFields(transactionType) {
        // Check which fields are visible based on transaction type
        switch(transactionType) {
            case 'assignment':
                if (document.getElementById('trans-assignor-record')) {
                    const assignorField = document.createElement('input');
                    assignorField.type = 'hidden';
                    assignorField.name = 'Assignor';
                    assignorField.value = document.getElementById('trans-assignor-record').value;
                    propertyForm.appendChild(assignorField);
                    
                    const assigneeField = document.createElement('input');
                    assigneeField.type = 'hidden';
                    assigneeField.name = 'Assignee';
                    assigneeField.value = document.getElementById('trans-assignee-record').value;
                    propertyForm.appendChild(assigneeField);
                }
                break;
            case 'mortgage':
                if (document.getElementById('mortgagor-record')) {
                    const mortgagorField = document.createElement('input');
                    mortgagorField.type = 'hidden';
                    mortgagorField.name = 'Mortgagor';
                    mortgagorField.value = document.getElementById('mortgagor-record').value;
                    propertyForm.appendChild(mortgagorField);
                    
                    const mortgageeField = document.createElement('input');
                    mortgageeField.type = 'hidden';
                    mortgageeField.name = 'Mortgagee';
                    mortgageeField.value = document.getElementById('mortgagee-record').value;
                    propertyForm.appendChild(mortgageeField);
                }
                break;
                // Add other transaction types as needed
        }
    }
    
    // Initialize registration number preview
    const serialNo = document.getElementById('serialNo');
    const pageNo = document.getElementById('pageNo');
    const volumeNo = document.getElementById('volumeNo');
    const regNoPreview = document.getElementById('regNoPreview');
    const regNoDisplay = document.getElementById('regNo');
    
    function updateRegNoPreview() {
        if ((serialNo && serialNo.value) || (pageNo && pageNo.value) || (volumeNo && volumeNo.value)) {
            const serial = serialNo ? (serialNo.value || '-') : '-';
            const page = pageNo ? (pageNo.value || '-') : '-';
            const volume = volumeNo ? (volumeNo.value || '-') : '-';
            if (regNoDisplay) regNoDisplay.textContent = `${serial}/${page}/${volume}`;
            if (regNoPreview) regNoPreview.classList.remove('hidden');
        } else if (regNoPreview) {
            regNoPreview.classList.add('hidden');
        }
    }
    
    if (serialNo) serialNo.addEventListener('input', updateRegNoPreview);
    if (pageNo) pageNo.addEventListener('input', updateRegNoPreview);
    if (volumeNo) volumeNo.addEventListener('input', updateRegNoPreview);
    
    // Fix name of transaction type field to match controller expected name
    const transactionTypeField = document.getElementById('transactionType-record');
    if (transactionTypeField) {
        transactionTypeField.name = 'transactionType';
    }
    
    // Fix other field names to match expected controller names
    const instrumentTypeField = document.getElementById('instrumentType');
    if (instrumentTypeField) {
        instrumentTypeField.name = 'instrumentType';
    }
    
    const periodField = document.getElementById('period');
    if (periodField) {
        periodField.name = 'period';
    }
    
    const periodUnitField = document.getElementById('periodUnit');
    if (periodUnitField) {
        periodUnitField.name = 'periodUnit';
    }
    
    const propertyDescriptionField = document.getElementById('property-description');
    if (propertyDescriptionField) {
        propertyDescriptionField.name = 'property_description';
    }
    
    const locationField = document.getElementById('property-location');
    if (locationField) {
        locationField.name = 'location';
    }
    
    const plotNoField = document.getElementById('plotNo');
    if (plotNoField) {
        plotNoField.name = 'plotNo';
    }
    
    // Also fix date field name
    const transactionDateField = document.getElementById('transactionDate');
    if (transactionDateField) {
        transactionDateField.name = 'transactionDate';
    }
});
</script>