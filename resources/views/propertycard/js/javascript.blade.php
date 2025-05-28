<script>
        // Initialize the file number component for property form
        function initFileNumberComponent(prefix) {
            console.log("Initializing file number component with prefix:", prefix);
            
            try {
                // Ensure the DOM elements are actually available
                const activeFileTab = document.getElementById(prefix + 'activeFileTab');
                if (!activeFileTab) {
                    console.error("Active file tab element not found for prefix:", prefix);
                    return;
                }
                
                // Initialize file number previews
                updateMlsFileNumberPreview(prefix);
                updateKangisFileNumberPreview(prefix);
                updateNewKangisFileNumberPreview(prefix);

                // Add event listeners for file number preview updates
                const mlsPrefix = document.getElementById(prefix + 'mlsFileNoPrefix');
                const mlsNumber = document.getElementById(prefix + 'mlsFileNumber');
                const kangisPrefix = document.getElementById(prefix + 'kangisFileNoPrefix');
                const kangisNumber = document.getElementById(prefix + 'kangisFileNumber');
                const newKangisPrefix = document.getElementById(prefix + 'newKangisFileNoPrefix');
                const newKangisNumber = document.getElementById(prefix + 'newKangisFileNumber');

                if (mlsPrefix) mlsPrefix.addEventListener('change', function() { updateMlsFileNumberPreview(prefix); });
                if (mlsNumber) mlsNumber.addEventListener('input', function() { updateMlsFileNumberPreview(prefix); });
                if (kangisPrefix) kangisPrefix.addEventListener('change', function() { updateKangisFileNumberPreview(prefix); });
                if (kangisNumber) kangisNumber.addEventListener('input', function() { updateKangisFileNumberPreview(prefix); });
                if (newKangisPrefix) newKangisPrefix.addEventListener('change', function() { updateNewKangisFileNumberPreview(prefix); });
                if (newKangisNumber) newKangisNumber.addEventListener('input', function() { updateNewKangisFileNumberPreview(prefix); });
                    
                // Make sure the active tab is properly displayed on page load
                var activeTabName = document.getElementById(prefix + 'activeFileTab').value;
                var tabToShow = prefix + "mlsFNoTab"; // Default
                
                if (activeTabName === "kangisFileNo") {
                    tabToShow = prefix + "kangisFileNoTab";
                } else if (activeTabName === "NewKANGISFileno") {
                    tabToShow = prefix + "NewKANGISFilenoTab";
                }
                
                // Simulate a click on the appropriate tab button
                var tabButtons = document.getElementsByClassName(prefix + "tablinks");
                
                for (var i = 0; i < tabButtons.length; i++) {
                    var buttonOnclick = tabButtons[i].getAttribute("onclick") || "";
                    if (buttonOnclick.includes(tabToShow)) {
                        var fakeEvent = { currentTarget: tabButtons[i] };
                        // Add a slight delay to ensure DOM is fully rendered
                        setTimeout(function() {
                            openFileTab(prefix, fakeEvent, tabToShow);
                        }, 50);
                        break;
                    }
                }
            } catch (error) {
                console.error("Error initializing file number component:", error);
            }
        }

        // Format MLS file number preview with prefix
        function updateMlsFileNumberPreview(prefix) {
            const prefixEl = document.getElementById(prefix + 'mlsFileNoPrefix');
            const numberEl = document.getElementById(prefix + 'mlsFileNumber');
            const previewEl = document.getElementById(prefix + 'mlsPreviewFileNumber');
            const dbFieldEl = document.getElementById(prefix + 'mlsFNo');

            if (!prefixEl || !numberEl || !previewEl || !dbFieldEl) return;

            const selectedPrefix = prefixEl.value;
            let number = numberEl.value.trim();

            if (selectedPrefix && number) {
                const formatted = selectedPrefix + '-' + number;
                previewEl.value = formatted;
                dbFieldEl.value = formatted; // Set the database field
            } else if (selectedPrefix) {
                previewEl.value = selectedPrefix;
                dbFieldEl.value = selectedPrefix;
            } else if (number) {
                previewEl.value = number;
                dbFieldEl.value = number;
            } else {
                previewEl.value = '';
                dbFieldEl.value = '';
            }
        }

        // Format KANGIS file number preview with prefix
        function updateKangisFileNumberPreview(prefix) {
            const prefixEl = document.getElementById(prefix + 'kangisFileNoPrefix');
            const numberEl = document.getElementById(prefix + 'kangisFileNumber');
            const previewEl = document.getElementById(prefix + 'kangisPreviewFileNumber');
            const dbFieldEl = document.getElementById(prefix + 'kangisFileNo');

            if (!prefixEl || !numberEl || !previewEl || !dbFieldEl) return;

            const selectedPrefix = prefixEl.value;
            let number = numberEl.value.trim();

            if (selectedPrefix && number) {
                // Pad to 5 digits
                number = number.padStart(5, '0');
                numberEl.value = number;
                const formatted = selectedPrefix + ' ' + number;
                previewEl.value = formatted;
                dbFieldEl.value = formatted; // Set the database field
            } else if (selectedPrefix) {
                previewEl.value = selectedPrefix;
                dbFieldEl.value = selectedPrefix;
            } else if (number) {
                previewEl.value = number;
                dbFieldEl.value = number;
            } else {
                previewEl.value = '';
                dbFieldEl.value = '';
            }
        }

        // Format New KANGIS file number preview with prefix
        function updateNewKangisFileNumberPreview(prefix) {
            const prefixEl = document.getElementById(prefix + 'newKangisFileNoPrefix');
            const numberEl = document.getElementById(prefix + 'newKangisFileNumber');
            const previewEl = document.getElementById(prefix + 'newKangisPreviewFileNumber');
            const dbFieldEl = document.getElementById(prefix + 'NewKANGISFileno');

            if (!prefixEl || !numberEl || !previewEl || !dbFieldEl) return;

            const selectedPrefix = prefixEl.value;
            let number = numberEl.value.trim();

            if (selectedPrefix && number) {
                const formatted = selectedPrefix + number;
                previewEl.value = formatted;
                dbFieldEl.value = formatted; // Set the database field
            } else if (selectedPrefix) {
                previewEl.value = selectedPrefix;
                dbFieldEl.value = selectedPrefix;
            } else if (number) {
                previewEl.value = number;
                dbFieldEl.value = number;
            } else {
                previewEl.value = '';
                dbFieldEl.value = '';
            }
        }

        // Updates the form data for submission based on prefix
        function updateFormFileData(prefix) {
            // Ensure all file numbers are properly set in hidden fields
            updateMlsFileNumberPreview(prefix);
            updateKangisFileNumberPreview(prefix);
            updateNewKangisFileNumberPreview(prefix);
            
            // Get the active tab
            const activeTab = document.getElementById(prefix + 'activeFileTab').value;
            
            // Set the active file number based on the active tab
            if (activeTab === "mlsFNo") {
                document.getElementById(prefix + 'mlsFNo').value = document.getElementById(prefix + 'mlsPreviewFileNumber').value;
            } else if (activeTab === "kangisFileNo") {
                document.getElementById(prefix + 'kangisFileNo').value = document.getElementById(prefix + 'kangisPreviewFileNumber').value;
            } else if (activeTab === "NewKANGISFileno") {
                document.getElementById(prefix + 'NewKANGISFileno').value = document.getElementById(prefix + 'newKangisPreviewFileNumber').value;
            }
            
            return true;
        }

        // Updated function to maintain values across tabs and support multiple instances
        function openFileTab(prefix, evt, tabName) {
            console.log("Opening tab:", tabName);
            
            // Save current values before switching tabs
            if (document.getElementById(prefix + 'activeFileTab').value === "mlsFNo") {
                updateMlsFileNumberPreview(prefix);
            } else if (document.getElementById(prefix + 'activeFileTab').value === "kangisFileNo") {
                updateKangisFileNumberPreview(prefix);
            } else if (document.getElementById(prefix + 'activeFileTab').value === "NewKANGISFileno") {
                updateNewKangisFileNumberPreview(prefix);
            }
            
            // Hide all tab content for this form instance
            var tabcontent = document.querySelectorAll("[id^='" + prefix + "'][class*='tabcontent']");
            for (var i = 0; i < tabcontent.length; i++) {
                tabcontent[i].classList.remove("active");
                tabcontent[i].style.display = "none";
            }

            // Remove active class from all tab buttons for this form instance
            var tablinks = document.getElementsByClassName(prefix + "tablinks");
            for (var i = 0; i < tablinks.length; i++) {
                tablinks[i].classList.remove("active");
            }

            // Show the current tab and add active class to the button
            var currentTab = document.getElementById(tabName);
            if (currentTab) {
                currentTab.classList.add("active");
                currentTab.style.display = "block";
            } else {
                console.error("Tab not found:", tabName);
            }
            
            evt.currentTarget.classList.add("active");
            
            // Set the active tab value based on the database field names
            if (tabName === prefix + "mlsFNoTab") {
                document.getElementById(prefix + 'activeFileTab').value = "mlsFNo";
            } else if (tabName === prefix + "kangisFileNoTab") {
                document.getElementById(prefix + 'activeFileTab').value = "kangisFileNo";
            } else if (tabName === prefix + "NewKANGISFilenoTab") {
                document.getElementById(prefix + 'activeFileTab').value = "NewKANGISFileno";
            }
        }

        // DOMContentLoaded event handler
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM fully loaded');
            
            // Property Record Form transaction fields handling
            initializeTransactionForm(
                'property-record-form',
                'transactionType-record',
                'transaction-specific-fields-record',
                'assignment-fields-record',
                'mortgage-fields-record',
                'surrender-fields-record',
                'lease-fields-record',
                'default-fields-record'
            );
            
            // Shared function to handle transaction form fields
            function initializeTransactionForm(
                formId, 
                transactionTypeId, 
                specificFieldsId, 
                assignmentFieldsId,
                mortgageFieldsId,
                surrenderFieldsId,
                leaseFieldsId,
                defaultFieldsId
            ) {
                const form = document.getElementById(formId);
                if (!form) return;
                
                const transactionTypeSelect = document.getElementById(transactionTypeId);
                const transactionSpecificFields = document.getElementById(specificFieldsId);
                
                // Get references to all transaction field containers for this form
                const assignmentFields = document.getElementById(assignmentFieldsId);
                const mortgageFields = document.getElementById(mortgageFieldsId);
                const surrenderFields = document.getElementById(surrenderFieldsId);
                const leaseFields = document.getElementById(leaseFieldsId);
                const defaultFields = document.getElementById(defaultFieldsId);
                
                // Initially hide the transaction details section and all field sets
                if (transactionSpecificFields) transactionSpecificFields.classList.add('hidden');
                
                // Hide all transaction field sets
                if (assignmentFields) assignmentFields.classList.add('hidden');
                if (mortgageFields) mortgageFields.classList.add('hidden');
                if (surrenderFields) surrenderFields.classList.add('hidden');
                if (leaseFields) leaseFields.classList.add('hidden');
                if (defaultFields) defaultFields.classList.add('hidden');
                
                // Handle transaction type selection for this form
                if (transactionTypeSelect) {
                    transactionTypeSelect.addEventListener('change', function() {
                        const selectedType = this.value;
                        
                        // Hide all field sets first
                        if (assignmentFields) assignmentFields.classList.add('hidden');
                        if (mortgageFields) mortgageFields.classList.add('hidden');
                        if (surrenderFields) surrenderFields.classList.add('hidden');
                        if (leaseFields) leaseFields.classList.add('hidden');
                        if (defaultFields) defaultFields.classList.add('hidden');
                        
                        // Handle "Other" transaction type
                        const otherTransactionDiv = document.getElementById('other-transaction-type');
                        const otherTransactionInput = document.getElementById('otherTransactionType');
                        
                        if (selectedType === 'Other') {
                            if (otherTransactionDiv) {
                                otherTransactionDiv.classList.remove('hidden');
                                if (otherTransactionInput) {
                                    otherTransactionInput.required = true;
                                }
                            }
                        } else {
                            if (otherTransactionDiv) {
                                otherTransactionDiv.classList.add('hidden');
                                if (otherTransactionInput) {
                                    otherTransactionInput.required = false;
                                    otherTransactionInput.value = '';
                                }
                            }
                        }
                        
                        // Auto-fill Grantor for government transactions
                        const grantorField = document.getElementById('grantor-record');
                        if (selectedType === 'Certificate of Occupancy' || selectedType === 'Right Of Occupancy') {
                            if (grantorField) {
                                grantorField.value = 'KANO STATE GOVERNMENT';
                                grantorField.readOnly = true;
                                grantorField.classList.add('bg-gray-100');
                            }
                        } else {
                            if (grantorField) {
                                grantorField.value = '';
                                grantorField.readOnly = false;
                                grantorField.classList.remove('bg-gray-100');
                            }
                        }
                        
                        // If no transaction type selected, hide the entire section
                        if (!selectedType) {
                            if (transactionSpecificFields) transactionSpecificFields.classList.add('hidden');
                            return;
                        }
                        
                        // Show the transaction details section
                        if (transactionSpecificFields) transactionSpecificFields.classList.remove('hidden');
                        
                        // Show the appropriate field set based on transaction type
                        if (selectedType === 'Assignment' && assignmentFields) {
                            assignmentFields.classList.remove('hidden');
                        } 
                        else if (selectedType === 'Mortgage' && mortgageFields) {
                            mortgageFields.classList.remove('hidden');
                        }
                        else if (selectedType === 'Surrender' && surrenderFields) {
                            surrenderFields.classList.remove('hidden');
                        }
                        else if (['Sub-Lease', 'lease', 'sub-under-lease'].includes(selectedType) && leaseFields) {
                            leaseFields.classList.remove('hidden');
                        }
                        else if (selectedType === 'Other') {
                            // For "Other" transaction type, don't show any specific fields initially
                            // Default fields will be shown/hidden based on custom type input
                        }
                        else if (defaultFields) {
                            // For Certificate of Occupancy, Right Of Occupancy, and other transaction types, show the default fields
                            defaultFields.classList.remove('hidden');
                        }
                    });
                }
                
                // Add event listener for "Other" transaction type input
                const otherTransactionInput = document.getElementById('otherTransactionType');
                if (otherTransactionInput) {
                    otherTransactionInput.addEventListener('input', function() {
                        const customType = this.value.trim();
                        const defaultFields = document.getElementById(defaultFieldsId);
                        
                        if (customType && defaultFields) {
                            // Hide Grantor and Grantee fields when custom type is specified
                            defaultFields.classList.add('hidden');
                        } else if (defaultFields) {
                            // Show Grantor and Grantee fields when custom type is cleared
                            defaultFields.classList.remove('hidden');
                        }
                    });
                }
            }

            // Property form dialog setup
            setupPropertyFormDialog();

            // Setup the property form dialog
            function setupPropertyFormDialog() {
                const button = document.getElementById('add-property-btn');
                const dialog = document.getElementById('property-form-dialog');
                const closeButton = document.getElementById('close-property-form');
                const cancelButton = document.getElementById('cancel-property-form');
                
                if (!button || !dialog) {
                    console.error("Property form dialog setup failed - Button or dialog not found");
                    return;
                }
                
                function showDialog() {
                    dialog.classList.remove('hidden');
                    
                    // Initialize file number component when dialog opens
                    setTimeout(() => {
                        initFileNumberComponent('property_');
                    }, 100);
                }
                
                function hideDialog() {
                    dialog.classList.add('hidden');
                }
                
                // Add event listeners
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    showDialog();
                });
                
                if(closeButton) closeButton.addEventListener('click', hideDialog);
                if(cancelButton) cancelButton.addEventListener('click', hideDialog);
                
                // Remove conflicting event handler for submit button
                // Let the form's own submit handler deal with submission
                
                // Bind add property card to the same action as the add property button
                const addPropertyCard = document.getElementById('add-property-card');
                if (addPropertyCard) {
                    addPropertyCard.addEventListener('click', function() {
                        showDialog();
                    });
                }
            }

            // Setup property action buttons
            setupPropertyActions();

            function setupPropertyActions() {
                // View property details
                document.querySelectorAll('.view-property, .view-property-details').forEach(button => {
                    button.addEventListener('click', function() {
                        const propertyId = this.getAttribute('data-id');
                        viewPropertyDetails(propertyId);
                    });
                });

                // Edit property
                document.querySelectorAll('.edit-property').forEach(button => {
                    button.addEventListener('click', function() {
                        const propertyId = this.getAttribute('data-id');
                        editProperty(propertyId);
                    });
                });

                // Delete property
                document.querySelectorAll('.delete-property').forEach(button => {
                    button.addEventListener('click', function() {
                        const propertyId = this.getAttribute('data-id');
                        deleteProperty(propertyId);
                    });
                });

                // Property options menu
                document.querySelectorAll('.property-options').forEach(button => {
                    button.addEventListener('click', function() {
                        const propertyId = this.getAttribute('data-id');
                        showPropertyOptions(propertyId, this);
                    });
                });
            }

            function viewPropertyDetails(propertyId) {
                // Show loading
                Swal.fire({
                    title: 'Loading...',
                    text: 'Fetching property details',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Fetch property data
                fetch(`{{ url('/property-records') }}/${propertyId}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to fetch property data');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.status === 'success' && data.data) {
                        displayPropertyDetails(data.data);
                        // Close loading indicator
                        Swal.close();
                        // Show view dialog
                        document.getElementById('property-view-dialog').classList.remove('hidden');
                    } else {
                        throw new Error(data.message || 'Failed to load property data');
                    }
                })
                .catch(error => {
                    console.error('Error loading property details:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to load property details: ' + error.message
                    });
                });
            }
            
            // Edit property - Updated function
            function editProperty(propertyId) {
                // Show loading
                Swal.fire({
                    title: 'Loading...',
                    text: 'Fetching property data',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Fetch property data
                fetch(`{{ url('/property-records') }}/${propertyId}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        if (response.status === 422) {
                            return response.json().then(errorData => {
                                throw new Error(`Validation failed`);
                            });
                        }
                        throw new Error('Failed to fetch property data');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.status === 'success' && data.data) {
                        const property = data.data;
                        loadPropertyForEditing(property);
                        // Close loading indicator
                        Swal.close();
                        // Show edit form
                        document.getElementById('property-edit-dialog').classList.remove('hidden');
                        // Initialize file number component
                        setTimeout(() => {
                            initFileNumberComponent('edit_property_');
                        }, 100);
                    } else {
                        throw new Error(data.message || 'Failed to load property data');
                    }
                })
                .catch(error => {
                    console.error('Error loading property:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message || 'Validation failed'
                    });
                });
            }
            
            // Function to populate edit form with property data
            function loadPropertyForEditing(property) {
                // Set form action
                const form = document.getElementById('property-edit-form');
                form.action = "{{ url('/property-records') }}/" + property.id;
                
                // Set property ID
                document.getElementById('edit_property_id').value = property.id;
                
                // Set title type
                if (property.title_type === 'Customary') {
                    document.getElementById('edit_customary').checked = true;
                } else {
                    document.getElementById('edit_statutory').checked = true;
                }
                
                // Set file numbers - populate both hidden and display fields
                fillAndDisableFileNumber('edit_property_mlsFNo', property.mlsFNo || '');
                fillAndDisableFileNumber('edit_property_kangisFileNo', property.kangisFileNo || '');
                fillAndDisableFileNumber('edit_property_NewKANGISFileno', property.NewKANGISFileno || '');
                
                // Debug output to verify file numbers
                console.log('File numbers being loaded:', {
                    mlsFNo: property.mlsFNo,
                    kangisFileNo: property.kangisFileNo,
                    NewKANGISFileno: property.NewKANGISFileno
                });
                
                // Ensure all file number fields are visible but disabled
                const fileNumberTabs = ['mlsFNoTab', 'kangisFileNoTab', 'NewKANGISFilenoTab'];
                fileNumberTabs.forEach(tab => {
                    const tabElement = document.getElementById('edit_property_' + tab);
                    if (tabElement) {
                        tabElement.style.display = 'block';
                        tabElement.classList.add('disabled-tab');
                    }
                });
                
                // Set property details
                document.getElementById('edit_property_description').value = property.property_description || '';
                document.getElementById('edit_lgsaOrCity').value = property.lgsaOrCity || '';
                document.getElementById('edit_plotNo').value = property.plot_no || '';
                
                if (property.layout) {
                    document.getElementById('edit_layout').value = property.layout;
                }
                
                if (property.schedule) {
                    document.getElementById('edit_schedule').value = property.schedule;
                }
                
                // Set transaction details
                if (property.transaction_type) {
                    document.getElementById('edit_transactionType').value = property.transaction_type;
                }
                
                if (property.transaction_date) {
                    document.getElementById('edit_transactionDate').value = property.transaction_date.split('T')[0];
                }
                
                // Set registration number components
                document.getElementById('edit_serialNo').value = property.serialNo || '';
                document.getElementById('edit_pageNo').value = property.pageNo || '';
                document.getElementById('edit_volumeNo').value = property.volumeNo || '';
                
                // Update registration number preview
                const regNoDisplay = document.getElementById('edit_regNo');
                if (regNoDisplay) {
                    regNoDisplay.textContent = property.regNo || '';
                    document.getElementById('edit_regNoPreview').classList.remove('hidden');
                }
                
                // Set instrument type and period
                if (property.instrument_type) {
                    document.getElementById('edit_instrumentType').value = property.instrument_type;
                }
                
                document.getElementById('edit_period').value = property.period || '';
                
                if (property.period_unit) {
                    document.getElementById('edit_periodUnit').value = property.period_unit;
                }
                
                // Load party information fields based on transaction type
                loadPartyFields(property);
                
                // Create transaction-specific fields if not already present
                createEditTransactionFields();
                
                // Show the transaction-specific section based on the transaction type
                showEditTransactionFields(property.transaction_type.toLowerCase());
            }

            // New helper function to fill and disable file number inputs
            function fillAndDisableFileNumber(elementId, value) {
                // Fill the hidden input field
                const element = document.getElementById(elementId);
                if (element) {
                    element.value = value;
                    element.disabled = true;
                    element.classList.add('bg-gray-100');
                }
                
                // Also fill the display field
                const displayId = `${elementId}_display`;
                const displayElement = document.getElementById(displayId);
                if (displayElement) {
                    displayElement.value = value;
                    displayElement.disabled = true;
                    displayElement.classList.add('bg-gray-100');
                } else {
                    console.warn(`Display element not found: ${displayId}`);
                }
            }

            // Function to load party information fields
            function loadPartyFields(property) {
                // Create inputs if they don't exist yet
                createPartyFieldsIfNeeded('edit_transaction_specific_fields');
                
                // Load the data
                switch (property.transaction_type.toLowerCase()) {
                    case 'assignment':
                        document.getElementById('edit_trans-assignor-record').value = property.Assignor || '';
                        document.getElementById('edit_trans-assignee-record').value = property.Assignee || '';
                        break;
                    case 'mortgage':
                        document.getElementById('edit_mortgagor-record').value = property.Mortgagor || '';
                        document.getElementById('edit_mortgagee-record').value = property.Mortgagee || '';
                        break;
                    case 'surrender':
                        document.getElementById('edit_surrenderor-record').value = property.Surrenderor || '';
                        document.getElementById('edit_surrenderee-record').value = property.Surrenderee || '';
                        break;
                    case 'lease':
                    case 'sub-lease':
                        document.getElementById('edit_lessor-record').value = property.Lessor || '';
                        document.getElementById('edit_lessee-record').value = property.Lessee || '';
                        break;
                    default:
                        document.getElementById('edit_grantor-record').value = property.Grantor || '';
                        document.getElementById('edit_grantee-record').value = property.Grantee || '';
                        break;
                }
            }

            // Create party fields for edit form
            function createPartyFieldsIfNeeded(containerId) {
                const container = document.getElementById(containerId);
                if (!container) return;
                
                // Check if we need to create assignment fields
                if (!document.getElementById('edit_assignment-fields-record')) {
                    container.innerHTML += `
                        <div id="edit_assignment-fields-record" class="transaction-fields hidden">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div class="space-y-1">
                                    <label for="edit_trans-assignor-record" class="text-sm">Assignor</label>
                                    <input id="edit_trans-assignor-record" name="Assignor" class="form-input text-sm" placeholder="Enter assignor name">
                                </div>
                                <div class="space-y-1">
                                    <label for="edit_trans-assignee-record" class="text-sm">Assignee</label>
                                    <input id="edit_trans-assignee-record" name="Assignee" class="form-input text-sm" placeholder="Enter assignee name">
                                </div>
                            </div>
                        </div>
                    `;
                }
                
                // Check if we need to create mortgage fields
                if (!document.getElementById('edit_mortgage-fields-record')) {
                    container.innerHTML += `
                        <div id="edit_mortgage-fields-record" class="transaction-fields hidden">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div class="space-y-1">
                                    <label for="edit_mortgagor-record" class="text-sm">Mortgagor</label>
                                    <input id="edit_mortgagor-record" name="Mortgagor" class="form-input text-sm" placeholder="Enter mortgagor name">
                                </div>
                                <div class="space-y-1">
                                    <label for="edit_mortgagee-record" class="text-sm">Mortgagee</label>
                                    <input id="edit_mortgagee-record" name="Mortgagee" class="form-input text-sm" placeholder="Enter mortgagee name">
                                </div>
                            </div>
                        </div>
                    `;
                }
                
                // Check if we need to create surrender fields
                if (!document.getElementById('edit_surrender-fields-record')) {
                    container.innerHTML += `
                        <div id="edit_surrender-fields-record" class="transaction-fields hidden">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div class="space-y-1">
                                    <label for="edit_surrenderor-record" class="text-sm">Surrenderor</label>
                                    <input id="edit_surrenderor-record" name="Surrenderor" class="form-input text-sm" placeholder="Enter surrenderor name">
                                </div>
                                <div class="space-y-1">
                                    <label for="edit_surrenderee-record" class="text-sm">Surrenderee</label>
                                    <input id="edit_surrenderee-record" name="Surrenderee" class="form-input text-sm" placeholder="Enter surrenderee name">
                                </div>
                            </div>
                        </div>
                    `;
                }
                
                // Check if we need to create lease fields
                if (!document.getElementById('edit_lease-fields-record')) {
                    container.innerHTML += `
                        <div id="edit_lease-fields-record" class="transaction-fields hidden">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div class="space-y-1">
                                    <label for="edit_lessor-record" class="text-sm">Lessor</label>
                                    <input id="edit_lessor-record" name="Lessor" class="form-input text-sm" placeholder="Enter lessor name">
                                </div>
                                <div class="space-y-1">
                                    <label for="edit_lessee-record" class="text-sm">Lessee</label>
                                    <input id="edit_lessee-record" name="Lessee" class="form-input text-sm" placeholder="Enter lessee name">
                                </div>
                            </div>
                        </div>
                    `;
                }
                
                // Check if we need to create default/grant fields
                if (!document.getElementById('edit_default-fields-record')) {
                    container.innerHTML += `
                        <div id="edit_default-fields-record" class="transaction-fields hidden">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div class="space-y-1">
                                    <label for="edit_grantor-record" class="text-sm">Grantor</label>
                                    <input id="edit_grantor-record" name="Grantor" class="form-input text-sm" placeholder="Enter grantor name">
                                </div>
                                <div class="space-y-1">
                                    <label for="edit_grantee-record" class="text-sm">Grantee</label>
                                    <input id="edit_grantee-record" name="Grantee" class="form-input text-sm" placeholder="Enter grantee name">
                                </div>
                            </div>
                        </div>
                    `;
                }
            }

            // Create all edit transaction fields at once
            function createEditTransactionFields() {
                createPartyFieldsIfNeeded('edit_transaction_specific_fields');
            }

            // Show specific transaction fields in edit form
            function showEditTransactionFields(transactionType) {
                // Hide all fields first
                const transactionFields = document.querySelectorAll('#edit_transaction_specific_fields .transaction-fields');
                transactionFields.forEach(field => field.classList.add('hidden'));
                
                // Get the container
                const container = document.getElementById('edit_transaction_specific_fields');
                if (container) {
                    container.classList.remove('hidden');
                }
                
                // Show the appropriate fields
                let fieldId = '';
                switch(transactionType) {
                    case 'assignment':
                        fieldId = 'edit_assignment-fields-record';
                        break;
                    case 'mortgage':
                        fieldId = 'edit_mortgage-fields-record';
                        break;
                    case 'surrender':
                        fieldId = 'edit_surrender-fields-record';
                        break;
                    case 'sub-lease':
                    case 'sublease':
                    case 'lease':
                        fieldId = 'edit_lease-fields-record';
                        break;
                    default:
                        fieldId = 'edit_default-fields-record';
                        break;
                }
                
                const fieldElement = document.getElementById(fieldId);
                if (fieldElement) {
                    fieldElement.classList.remove('hidden');
                }
            }

            // Create View Property Dialog
            let viewPropertyDialog = document.getElementById('property-view-dialog');
            if (!viewPropertyDialog) {
                // Create the view dialog if it doesn't exist
                viewPropertyDialog = document.createElement('div');
                viewPropertyDialog.id = 'property-view-dialog';
                viewPropertyDialog.className = 'dialog-overlay hidden';
                viewPropertyDialog.innerHTML = `
                    <div class="dialog-content property-form-content">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-bold">Property Record Details</h2>
                            <button id="close-property-view" class="text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                            </button>
                        </div>
                        
                        <div id="property-view-content" class="space-y-6 max-h-[75vh] overflow-y-auto">
                            <!-- Content will be dynamically populated -->
                        </div>
                        
                        <div class="flex justify-end space-x-3 pt-4 border-t mt-4">
                            <button id="edit-from-view" data-property-id="" class="btn btn-secondary">Edit</button>
                            <button id="close-view" class="btn btn-primary">Close</button>
                        </div>
                    </div>
                `;
                document.body.appendChild(viewPropertyDialog);
                
                // Add event listeners for the new view dialog
                document.getElementById('close-property-view').addEventListener('click', function() {
                    viewPropertyDialog.classList.add('hidden');
                });
                
                document.getElementById('close-view').addEventListener('click', function() {
                    viewPropertyDialog.classList.add('hidden');
                });
                
                document.getElementById('edit-from-view').addEventListener('click', function() {
                    const propertyId = this.getAttribute('data-property-id');
                    viewPropertyDialog.classList.add('hidden');
                    editProperty(propertyId);
                });
            }

            // Function to handle deletion of property records
            function deleteProperty(propertyId) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this! The property record will be permanently deleted.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Send DELETE request to server
                        fetch(`{{ url('/property-records') }}/${propertyId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then((data) => {
                            if (data.status === 'success') {
                                Swal.fire(
                                    'Deleted!',
                                    'Property record has been deleted.',
                                    'success'
                                ).then(() => {
                                    // Reload the page to refresh the property list
                                    window.location.reload();
                                });
                            } else {
                                throw new Error(data.message || 'Failed to delete property record');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire(
                                'Error!',
                                'Failed to delete property record: ' + error.message,
                                'error'
                            );
                        });
                    }
                });
            }

            // Function to show property options menu
            function showPropertyOptions(propertyId, buttonElement) {
                const rect = buttonElement.getBoundingClientRect();
                
                Swal.fire({
                    title: 'Property Options',
                    html: `
                        <div class="flex flex-col space-y-2">
                            <button type="button" class="btn btn-secondary w-full" id="view-option">View Details</button>
                            <button type="button" class="btn btn-secondary w-full" id="edit-option">Edit Record</button>
                            <button type="button" class="btn btn-danger w-full" id="delete-option">Delete Record</button>
                        </div>
                    `,
                    showConfirmButton: false,
                    showCancelButton: true,
                    cancelButtonText: 'Close',
                    customClass: {
                        container: 'property-options-menu'
                    },
                    didOpen: () => {
                        // Add click event listeners to the option buttons
                        document.getElementById('view-option').addEventListener('click', function() {
                            Swal.close();
                            viewPropertyDetails(propertyId);
                        });
                        
                        document.getElementById('edit-option').addEventListener('click', function() {
                            Swal.close();
                            editProperty(propertyId);
                        });
                        
                        document.getElementById('delete-option').addEventListener('click', function() {
                            Swal.close();
                            deleteProperty(propertyId);
                        });
                    }
                });
            }
            
            // Initialize property search functionality
            const propertySearch = document.getElementById('property-search');
            if (propertySearch) {
                propertySearch.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    
                    // Filter property cards
                    document.querySelectorAll('.grid .border:not(#add-property-card)').forEach(card => {
                        const fileNumber = card.querySelector('h3')?.textContent.toLowerCase() || '';
                        const description = card.querySelector('.text-sm.truncate')?.textContent.toLowerCase() || '';
                        const location = card.querySelector('.flex.justify-between:has(.text-gray-500:contains("Location"))')?.textContent.toLowerCase() || '';
                        
                        if (fileNumber.includes(searchTerm) || description.includes(searchTerm) || location.includes(searchTerm)) {
                            card.style.display = '';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                    
                    // Filter property table rows
                    document.querySelectorAll('.table tbody tr').forEach(row => {
                        const cells = row.querySelectorAll('td');
                        if (cells.length <= 1) return; // Skip header or empty rows
                        
                        const fileNumber = cells[0].textContent.toLowerCase();
                        const description = cells[1].textContent.toLowerCase();
                        const location = cells[2].textContent.toLowerCase();
                        
                        if (fileNumber.includes(searchTerm) || description.includes(searchTerm) || location.includes(searchTerm)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            }

            console.log('JavaScript initialization complete');
        });

    </script>
