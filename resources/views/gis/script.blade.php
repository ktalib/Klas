<script>
    // Immediately check and disable fields if on secondary GIS page
    (function() {
        const urlParams = new URLSearchParams(window.location.search);
        const isSecondary = urlParams.get('is') === 'secondary';
        console.log('URL Check - Is Secondary:', isSecondary);
        
        if (isSecondary) {
            console.log('Secondary GIS mode detected - fields should be disabled');
            // Run after a small delay to ensure DOM is fully loaded
            setTimeout(function() {
                disablePrimaryGISFields();
                // Add notice at the top of the form
                addFormNotice();
            }, 100);
        }
    })();

    // Function to add a notice at the top of the form
    function addFormNotice() {
        const formElement = document.querySelector('form');
        const headerElement = document.querySelector('form .bg-gray-50');
        
        // Remove any existing notice first
        const existingNotice = document.querySelector('form .bg-blue-50');
        if (existingNotice) {
            existingNotice.remove();
        }
        
        if (headerElement && formElement) {
            const noticeDiv = document.createElement('div');
            noticeDiv.className = 'bg-blue-50 text-blue-700 p-3 rounded-md mb-4';
            noticeDiv.innerHTML = '<p class="text-sm"><strong>Note:</strong> Primary GIS fields are read-only. Only Unit-specific information can be edited.</p>';
            formElement.insertBefore(noticeDiv, headerElement);
            console.log('Notice added to form');
        } else {
            console.warn('Could not find form header element to add notice');
        }
    }

    // Show the reason for change field only when change of ownership is Yes
    document.addEventListener('DOMContentLoaded', function() {
        const changeOfOwnershipSelect = document.getElementById('changeOfOwnership');
        const reasonForChangeField = document.getElementById('reasonForChange').parentNode;
        
        function toggleReasonField() {
            if (changeOfOwnershipSelect.value === 'Yes') {
                reasonForChangeField.style.display = 'block';
            } else {
                reasonForChangeField.style.display = 'none';
            }
        }
        
        // Initialize on page load
        toggleReasonField();
        
        // Listen for changes
        changeOfOwnershipSelect.addEventListener('change', toggleReasonField);

        // Also check and disable fields again to be sure
        const urlParams = new URLSearchParams(window.location.search);
        const isSecondary = urlParams.get('is') === 'secondary';
        if (isSecondary) {
            console.log('DOMContentLoaded: Disabling primary fields for secondary GIS');
            disablePrimaryGISFields();
            addFormNotice();
        }
    });

    // Debug form data
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const debug = document.getElementById('formDebug');
        
        form.addEventListener('submit', function(e) {
            const formData = new FormData(form);
            let debugText = '';
            
            for (let [key, value] of formData.entries()) {
                if (value instanceof File) {
                    debugText += `${key}: [File: ${value.name}]\n`;
                } else {
                    debugText += `${key}: ${value}\n`;
                }
            }
            
            debug.textContent = debugText;
            console.log(debugText);
            // Uncomment to stop form submission for debugging
            // e.preventDefault();
        });
    });

    // Automatically disable primary fields on Unit GIS page
    document.addEventListener('DOMContentLoaded', function() {
        // Check if we're on the unit GIS page (is=secondary in URL)
        const urlParams = new URLSearchParams(window.location.search);
        const isSecondary = urlParams.get('is') === 'secondary';
        
        if (isSecondary) {
            // Add notice at the top of the form
            const formElement = document.querySelector('form');
            const headerElement = document.querySelector('form .bg-gray-50');
            
            if (headerElement && formElement) {
                const noticeDiv = document.createElement('div');
                noticeDiv.className = 'bg-blue-50 text-blue-700 p-3 rounded-md mb-4';
                noticeDiv.innerHTML = '<p class="text-sm"><strong>Note:</strong> Primary GIS fields are read-only. Only Unit-specific information can be edited.</p>';
                formElement.insertBefore(noticeDiv, headerElement);
            }
            
            // Disable all primary GIS fields
            disablePrimaryGISFields();
        }
    });

    // Primary file select functionality for unit GIS
    document.addEventListener('DOMContentLoaded', function() {
        // Only run this code on unit GIS form pages
        const primaryFileSelect = document.getElementById('primary_file_select');
        if (!primaryFileSelect) return;

        // Initialize Select2
        $(primaryFileSelect).select2({
            placeholder: 'Select Primary GIS FileNo here',
            minimumInputLength: 0, // Allow searching without any input
            ajax: {
                url: '{{ route('gis.search-files') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term || '', // Send empty string for initial load
                        initial: params.term ? false : true // Flag for initial load
                    };
                },
                processResults: function(data) {
                    return {
                        results: data.map(function(item) {
                            // Display file number in dropdown (without labels)
                            let displayText = '';
                            
                            if (item.mlsfNo) displayText = item.mlsfNo;
                            else if (item.kangisFileNo) displayText = item.kangisFileNo;
                            else if (item.NewKANGISFileno) displayText = item.NewKANGISFileno;
                            else displayText = 'File #' + item.id;
                            
                            return {
                                id: item.id,
                                text: displayText,
                                data: item
                            };
                        })
                    };
                },
                cache: true
            },
            // Ensure the selected value text is properly displayed
            templateSelection: function(data) {
                if (!data.id) return data.text; // For placeholder
                return data.text || 'Selected Primary GIS FileNo';
            }
        });

        // Trigger initial load of the dropdown options
        $.ajax({
            url: '{{ route('gis.search-files') }}',
            dataType: 'json',
            data: { initial: true },
            success: function(data) {
                // Process the data to the format Select2 needs
                const processedData = data.map(function(item) {
                    let displayText = '';
                    
                    if (item.mlsfNo) displayText = item.mlsfNo;
                    else if (item.kangisFileNo) displayText = item.kangisFileNo;
                    else if (item.NewKANGISFileno) displayText = item.NewKANGISFileno;
                    else displayText = 'File #' + item.id;
                    
                    return {
                        id: item.id,
                        text: displayText,
                        data: item
                    };
                });
                
                // Add the options to the select element
                if (processedData.length > 0) {
                    // Create a placeholder option
                    const placeholderOption = new Option('Select Primary GIS FileNo here', '', true, true);
                    $(primaryFileSelect).append(placeholderOption);
                    
                    // Add the file options
                    processedData.forEach(function(item) {
                        const option = new Option(item.text, item.id, false, false);
                        $(option).data('data', item.data);
                        $(primaryFileSelect).append(option);
                    });
                    
                    // Trigger change to update Select2
                    $(primaryFileSelect).trigger('change');
                }
            }
        });

        // Handle file selection
        $(primaryFileSelect).on('select2:select', function(e) {
            const data = e.params.data.data;
            
            // Set primary GIS ID
            document.getElementById('PrimaryGISID').value = data.id;
            
            // Get the selected text
            const selectedText = e.params.data.text || 'File #' + data.id;
            
            // Clear existing options and add the selected one to ensure it shows properly
            $(primaryFileSelect).empty();
            
            // Create and add the selected option
            const newOption = new Option(selectedText, data.id, true, true);
            $(primaryFileSelect).append(newOption);
            
            // This forces Select2 to use our option as the visible selection
            $(primaryFileSelect).val(data.id).trigger('change');
            
            // Update the summary header for primary file
            updatePrimaryFileSummary(data);
            
            // Populate form fields with primary data
            populateFormWithPrimaryData(data);
            
            // Show toast notification
            // showToast('Primary GIS data loaded successfully');

                Swal.fire({
                                title: 'Primary GIS Selected',
                                text: 'Primary GIS data loaded successfully.',
                                icon: 'success',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true
                            });
        });

        // Function to update the summary header for primary file
        function updatePrimaryFileSummary(data) {
            // Show the container
            const summaryContainer = document.getElementById('file-summary-container');
            if (summaryContainer) summaryContainer.classList.remove('hidden');
            
            // Update title
            const summaryTitle = document.getElementById('summary-title');
            if (summaryTitle) summaryTitle.textContent = 'Summary';
            
            // Show primary section, hide others
            const primarySection = document.getElementById('search-primary-file-summary');
            const motherSection = document.getElementById('mother-app-summary');
            const unitSection = document.getElementById('unit-file-summary');
            
            if (primarySection) primarySection.classList.remove('hidden');
            if (motherSection) motherSection.classList.add('hidden');
            if (unitSection) unitSection.classList.add('hidden');
            
            // Update primary file details
            if (document.getElementById('summary-primaryFileNo')) {
                let displayFileNo = '';
                if (data.mlsfNo) displayFileNo = data.mlsfNo;
                else if (data.kangisFileNo) displayFileNo = data.kangisFileNo;
                else if (data.NewKANGISFileno) displayFileNo = data.NewKANGISFileno;
                else displayFileNo = 'File #' + data.id;
                
                document.getElementById('summary-primaryFileNo').textContent = displayFileNo;
            }
            
            if (document.getElementById('summary-primaryId')) 
                document.getElementById('summary-primaryId').textContent = data.id || '-';
            
            // Update note
            if (document.getElementById('summary-note'))
                document.getElementById('summary-note').textContent = 'Primary file data has been loaded into the form below.';
        }

        // Function to populate form with primary data
        function populateFormWithPrimaryData(data) {
            // Store the primary GIS ID in the designated field
            if (document.getElementById('PrimaryGISID')) {
                document.getElementById('PrimaryGISID').value = data.id;
            }
            
            // Plot Information (main form)
            if (data.plotNo && document.getElementById('plotNo')) {
                const plotField = document.getElementById('plotNo');
                plotField.value = data.plotNo;
                plotField.readOnly = true;
                plotField.classList.add('bg-gray-100');
            }
            if (data.blockNo && document.getElementById('blockNo')) {
                const blockField = document.getElementById('blockNo');
                blockField.value = data.blockNo;
                blockField.readOnly = true;
                blockField.classList.add('bg-gray-100');
            }
            if (data.approvedPlanNo && document.getElementById('approvedPlanNo')) {
                const planField = document.getElementById('approvedPlanNo');
                planField.value = data.approvedPlanNo;
                planField.readOnly = true;
                planField.classList.add('bg-gray-100');
            }
            if (data.tpPlanNo && document.getElementById('tpPlanNo')) {
                const tpField = document.getElementById('tpPlanNo');
                tpField.value = data.tpPlanNo;
                tpField.readOnly = true;
                tpField.classList.add('bg-gray-100');
            }
            if (data.areaInHectares && document.getElementById('areaInHectares')) {
                const areaField = document.getElementById('areaInHectares');
                areaField.value = data.areaInHectares;
                areaField.readOnly = true;
                areaField.classList.add('bg-gray-100');
            }
            if (data.landUse && document.getElementById('landUse')) {
                const landUseField = document.getElementById('landUse');
                landUseField.value = data.landUse;
                landUseField.disabled = true;
                landUseField.classList.add('bg-gray-100');
            }
            if (data.specifically && document.getElementById('specifically')) {
                const specField = document.getElementById('specifically');
                specField.value = data.specifically;
                specField.readOnly = true;
                specField.classList.add('bg-gray-100');
            }
            
            // Location Information (main form)
            if (data.layoutName && document.getElementById('layoutName')) {
                const layoutField = document.getElementById('layoutName');
                layoutField.value = data.layoutName;
                layoutField.readOnly = true;
                layoutField.classList.add('bg-gray-100');
            }
            if (data.districtName && document.getElementById('districtName')) {
                const districtField = document.getElementById('districtName');
                districtField.value = data.districtName;
                districtField.readOnly = true;
                districtField.classList.add('bg-gray-100');
            }
            if (data.StateName && document.getElementById('StateName')) {
                const stateField = document.getElementById('StateName');
                stateField.value = data.StateName;
                stateField.readOnly = true;
                stateField.classList.add('bg-gray-100');
            }
            if (data.streetName && document.getElementById('streetName')) {
                const streetField = document.getElementById('streetName');
                streetField.value = data.streetName;
                streetField.readOnly = true;
                streetField.classList.add('bg-gray-100');
            }
            if (data.houseNo && document.getElementById('houseNo')) {
                const houseNoField = document.getElementById('houseNo');
                houseNoField.value = data.houseNo;
                houseNoField.readOnly = true;
                houseNoField.classList.add('bg-gray-100');
            }
            if (data.houseType && document.getElementById('houseType')) {
                const houseTypeField = document.getElementById('houseType');
                houseTypeField.value = data.houseType;
                houseTypeField.readOnly = true;
                houseTypeField.classList.add('bg-gray-100');
            }
            if (data.tenancy && document.getElementById('tenancy')) {
                const tenancyField = document.getElementById('tenancy');
                tenancyField.value = data.tenancy;
                tenancyField.readOnly = true;
                tenancyField.classList.add('bg-gray-100');
            }
            
            // LGA selection
            if (data.lgaName) {
                const lgaSelectElement = document.getElementById('lgaName');
                if (lgaSelectElement) {
                    for (let i = 0; i < lgaSelectElement.options.length; i++) {
                        if (lgaSelectElement.options[i].value === data.lgaName) {
                            lgaSelectElement.selectedIndex = i;
                            break;
                        }
                    }
                    lgaSelectElement.disabled = true;
                    lgaSelectElement.classList.add('bg-gray-100');
                }
            }
            
            // Title Information (main form)
            if (data.oldTitleSerialNo && document.getElementById('oldTitleSerialNo')) {
                const serialField = document.getElementById('oldTitleSerialNo');
                serialField.value = data.oldTitleSerialNo;
                serialField.readOnly = true;
                serialField.classList.add('bg-gray-100');
            }
            if (data.oldTitlePageNo && document.getElementById('oldTitlePageNo')) {
                const pageField = document.getElementById('oldTitlePageNo');
                pageField.value = data.oldTitlePageNo;
                pageField.readOnly = true;
                pageField.classList.add('bg-gray-100');
            }
            if (data.oldTitleVolumeNo && document.getElementById('oldTitleVolumeNo')) {
                const volumeField = document.getElementById('oldTitleVolumeNo');
                volumeField.value = data.oldTitleVolumeNo;
                volumeField.readOnly = true;
                volumeField.classList.add('bg-gray-100');
            }
            if (data.deedsDate && document.getElementById('deedsDate')) {
                const deedsDateField = document.getElementById('deedsDate');
                deedsDateField.value = data.deedsDate;
                deedsDateField.readOnly = true;
                deedsDateField.classList.add('bg-gray-100');
            }
            if (data.deedsTime && document.getElementById('deedsTime')) {
                const deedsTimeField = document.getElementById('deedsTime');
                deedsTimeField.value = data.deedsTime;
                deedsTimeField.readOnly = true;
                deedsTimeField.classList.add('bg-gray-100');
            }
            if (data.certificateDate && document.getElementById('certificateDate')) {
                const certDateField = document.getElementById('certificateDate');
                certDateField.value = data.certificateDate;
                certDateField.readOnly = true;
                certDateField.classList.add('bg-gray-100');
            }
            if (data.CofOSerialNo && document.getElementById('CofOSerialNo')) {
                const cofOField = document.getElementById('CofOSerialNo');
                cofOField.value = data.CofOSerialNo;
                cofOField.readOnly = true;
                cofOField.classList.add('bg-gray-100');
            }
            if (data.titleIssuedYear && document.getElementById('titleIssuedYear')) {
                const yearField = document.getElementById('titleIssuedYear');
                yearField.value = data.titleIssuedYear;
                yearField.readOnly = true;
                yearField.classList.add('bg-gray-100');
            }
            
            // Owner Information (main form)
            if (data.originalAllottee && document.getElementById('originalAllottee')) {
                const originalField = document.getElementById('originalAllottee');
                originalField.value = data.originalAllottee;
                originalField.readOnly = true;
                originalField.classList.add('bg-gray-100');
            }
            if (data.addressOfOriginalAllottee && document.getElementById('addressOfOriginalAllottee')) {
                const addressField = document.getElementById('addressOfOriginalAllottee');
                addressField.value = data.addressOfOriginalAllottee;
                addressField.readOnly = true;
                addressField.classList.add('bg-gray-100');
            }
            if (data.changeOfOwnership && document.getElementById('changeOfOwnership')) {
                const changeField = document.getElementById('changeOfOwnership');
                changeField.value = data.changeOfOwnership;
                changeField.disabled = true;
                changeField.classList.add('bg-gray-100');
            }
            if (data.reasonForChange && document.getElementById('reasonForChange')) {
                const reasonField = document.getElementById('reasonForChange');
                reasonField.value = data.reasonForChange;
                reasonField.readOnly = true;
                reasonField.classList.add('bg-gray-100');
            }
            if (data.currentAllottee && document.getElementById('currentAllottee')) {
                const currentField = document.getElementById('currentAllottee');
                currentField.value = data.currentAllottee;
                currentField.readOnly = true;
                currentField.classList.add('bg-gray-100');
            }
            if (data.addressOfCurrentAllottee && document.getElementById('addressOfCurrentAllottee')) {
                const currentAddressField = document.getElementById('addressOfCurrentAllottee');
                currentAddressField.value = data.addressOfCurrentAllottee;
                currentAddressField.readOnly = true;
                currentAddressField.classList.add('bg-gray-100');
            }
            if (data.titleOfCurrentAllottee && document.getElementById('titleOfCurrentAllottee')) {
                const titleField = document.getElementById('titleOfCurrentAllottee');
                titleField.value = data.titleOfCurrentAllottee;
                titleField.readOnly = true;
                titleField.classList.add('bg-gray-100');
            }
            if (data.phoneNo && document.getElementById('phoneNo')) {
                const phoneField = document.getElementById('phoneNo');
                phoneField.value = data.phoneNo;
                phoneField.readOnly = true;
                phoneField.classList.add('bg-gray-100');
            }
            if (data.emailAddress && document.getElementById('emailAddress')) {
                const emailField = document.getElementById('emailAddress');
                emailField.value = data.emailAddress;
                emailField.readOnly = true;
                emailField.classList.add('bg-gray-100');
            }
            if (data.occupation && document.getElementById('occupation')) {
                const occupationField = document.getElementById('occupation');
                occupationField.value = data.occupation;
                occupationField.readOnly = true;
                occupationField.classList.add('bg-gray-100');
            }
            if (data.nationality && document.getElementById('nationality')) {
                const nationalityField = document.getElementById('nationality');
                nationalityField.value = data.nationality;
                nationalityField.readOnly = true;
                nationalityField.classList.add('bg-gray-100');
            }
            if (data.CompanyRCNo && document.getElementById('CompanyRCNo')) {
                const rcNoField = document.getElementById('CompanyRCNo');
                rcNoField.value = data.CompanyRCNo;
                rcNoField.readOnly = true;
                rcNoField.classList.add('bg-gray-100');
            }
            
            // Show the reason for change field if Change of Ownership is "Yes"
            if (data.changeOfOwnership === 'Yes' && document.getElementById('reasonForChange')) {
                const reasonForChangeField = document.getElementById('reasonForChange').parentNode;
                reasonForChangeField.style.display = 'block';
            }
            
            // Add a notice at the top of the form that primary data is read-only
            const formElement = document.querySelector('form');
            const noticeDiv = document.createElement('div');
            noticeDiv.className = 'bg-blue-50 text-blue-700 p-3 rounded-md mb-4';
            noticeDiv.innerHTML = '<p class="text-sm"><strong>Note:</strong> Fields populated from Primary GIS data are read-only. Only Unit-specific information can be edited.</p>';
            
            // Insert the notice after the form header but before the first section
            const headerElement = document.querySelector('form .bg-gray-50');
            if (headerElement && formElement) {
                formElement.insertBefore(noticeDiv, headerElement);
            }
        }
    });

    // Function to disable all primary GIS fields
    function disablePrimaryGISFields() {
        console.log('Running disablePrimaryGISFields()');
        // Plot Information fields
        const primaryFields = [
            'plotNo', 'blockNo', 'approvedPlanNo', 'tpPlanNo', 'areaInHectares', 
            'landUse', 'specifically', 
            'layoutName', 'districtName', 'lgaName', 'StateName', 'streetName', 
            'houseNo', 'houseType', 'tenancy', 
            'oldTitleSerialNo', 'oldTitlePageNo', 'oldTitleVolumeNo', 'deedsDate', 
            'deedsTime', 'certificateDate', 'CofOSerialNo', 'titleIssuedYear', 
            'originalAllottee', 'addressOfOriginalAllottee', 'changeOfOwnership', 
            'reasonForChange', 'currentAllottee', 'addressOfCurrentAllottee', 
            'titleOfCurrentAllottee', 'phoneNo', 'emailAddress', 'occupation', 
            'nationality', 'CompanyRCNo'
        ];
        
        let fieldsDisabled = 0;
        primaryFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field) {
                if (field.tagName === 'SELECT') {
                    field.disabled = true;
                } else {
                    field.readOnly = true;
                }
                field.classList.add('bg-gray-100');
                fieldsDisabled++;
            }
        });
        
        console.log(`Fields disabled: ${fieldsDisabled} of ${primaryFields.length}`);
        
        // Hide the reason for change field regardless of changeOfOwnership value
        const reasonForChangeField = document.getElementById('reasonForChange');
        if (reasonForChangeField) {
            reasonForChangeField.parentNode.style.display = 'none';
        }
    }
</script>

<script>
    // Run one final check after page is fully loaded
    window.onload = function() {
        const urlParams = new URLSearchParams(window.location.search);
        const isSecondary = urlParams.get('is') === 'secondary';
        if (isSecondary) {
            console.log('Window onload: Final check for disabling primary fields');
            disablePrimaryGISFields();
            addFormNotice();
            
            // Also check if fields were properly disabled
            setTimeout(function() {
                const plotField = document.getElementById('plotNo');
                if (plotField && !plotField.readOnly) {
                    console.warn('Fields were not properly disabled - trying again');
                    disablePrimaryGISFields();
                }
            }, 500);
        }
    };
</script>

<!-- Include required libraries for Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>