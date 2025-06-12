<script>
    // Initialize Lucide icons
    lucide.createIcons();

    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded - initializing form handling');

        // Step navigation
        const nextStep1 = document.getElementById('nextStep1');
        const nextStep2 = document.getElementById('nextStep2');
        const nextStep3 = document.getElementById('nextStep3');
        const nextStep4 = document.getElementById('nextStep4');
        const backStep2 = document.getElementById('backStep2');
        const backStep3 = document.getElementById('backStep3');
        const backStep4 = document.getElementById('backStep4');
        const backStep5 = document.getElementById('backStep5');

        // Form sections
        const step1 = document.getElementById('step1');
        const step2 = document.getElementById('step2');
        const step3 = document.getElementById('step3');
        const step4 = document.getElementById('step4');
        const step5 = document.getElementById('step5');

        if (nextStep1) {
            nextStep1.addEventListener('click', function(e) {
                e.preventDefault();
                step1.classList.remove('active');
                step2.classList.add('active');
            });
        }

        if (nextStep2) {
            nextStep2.addEventListener('click', function(e) {
                e.preventDefault();
                step2.classList.remove('active');
                step3.classList.add('active');
            });
        }

        if (nextStep3) {
            nextStep3.addEventListener('click', function(e) {
                e.preventDefault();
                step3.classList.remove('active');
                step4.classList.add('active');
                // Update summary when moving to final step
                if (typeof updateApplicationSummary === 'function') {
                    updateApplicationSummary();
                }
            });
        }

        if (nextStep4) {
            nextStep4.addEventListener('click', function(e) {
                e.preventDefault();
                step4.classList.remove('active');
                step5.classList.add('active');
                updateApplicationSummary(); // Make sure summary is updated
            });
        }

        if (backStep2) {
            backStep2.addEventListener('click', function(e) {
                e.preventDefault();
                step2.classList.remove('active');
                step1.classList.add('active');
            });
        }

        if (backStep3) {
            backStep3.addEventListener('click', function(e) {
                e.preventDefault();
                step3.classList.remove('active');
                step2.classList.add('active');
            });
        }

        if (backStep4) {
            backStep4.addEventListener('click', function(e) {
                e.preventDefault();
                step4.classList.remove('active');
                step3.classList.add('active');
            });
        }

        if (backStep5) {
            backStep5.addEventListener('click', function(e) {
                e.preventDefault();
                step5.classList.remove('active');
                step4.classList.add('active');
            });
        }

        // Update the IDs for the summary step (now step 5)
        document.getElementById('backStep5').addEventListener('click', function() {
            document.getElementById('step5').classList.remove('active');
            document.getElementById('step4').classList.add('active');
        });

        // Close modal buttons
        document.getElementById('closeModal').addEventListener('click', function() {
            // In a real application, this would close the modal
            alert('Application process canceled');
        });

        document.getElementById('closeModal2').addEventListener('click', function() {
            // In a real application, this would close the modal
            alert('Application process canceled');
        });

        document.getElementById('closeModal3').addEventListener('click', function() {
            // In a real application, this would close the modal
            alert('Application process canceled');
        });

        document.getElementById('closeModal4').addEventListener('click', function() {
            // In a real application, this would close the modal
            alert('Application process canceled');
        });

        // Improved contact address update functionality
        function initializeAddressUpdate() {
            console.log('Initializing address update functionality');
            
            // Get all address input fields
            const ownerHouseNo = document.getElementById('ownerHouseNo');
            const ownerStreetName = document.getElementById('ownerStreetName');
            const ownerDistrict = document.getElementById('ownerDistrict');
            const ownerLga = document.getElementById('ownerLga');
            const ownerState = document.getElementById('ownerState');
            
            // Get display elements
            const fullContactAddress = document.getElementById('fullContactAddress');
            const contactAddressDisplay = document.getElementById('contactAddressDisplay');
            
            if (!fullContactAddress || !contactAddressDisplay) {
                console.error('Address display elements not found!', {
                    fullContactAddress: !!fullContactAddress,
                    contactAddressDisplay: !!contactAddressDisplay
                });
                return;
            }
            
            // Function to update the address display
            function updateAddress() {
                const houseNo = ownerHouseNo ? ownerHouseNo.value.trim() : '';
                const streetName = ownerStreetName ? ownerStreetName.value.trim() : '';
                const district = ownerDistrict ? ownerDistrict.value.trim() : '';
                const lga = ownerLga ? ownerLga.value.trim() : '';
                const state = ownerState ? ownerState.value.trim() : '';
                
                // Build address parts array, filter out empty values
                const addressParts = [];
                if (houseNo) addressParts.push(houseNo);
                if (streetName) addressParts.push(streetName);
                if (district) addressParts.push(district);
                if (lga) addressParts.push(lga);
                if (state) addressParts.push(state);
                
                // Join with commas
                const fullAddress = addressParts.join(', ');
                
                // Update display elements
                fullContactAddress.textContent = fullAddress;
                contactAddressDisplay.value = fullAddress;
                
                console.log('Address updated:', fullAddress);
            }
            
            // Add input event listeners to all address fields
            const attachListener = (element) => {
                if (element) {
                    console.log('Attaching listener to:', element.id);
                    element.addEventListener('input', updateAddress);
                }
            };
            
            attachListener(ownerHouseNo);
            attachListener(ownerStreetName);
            attachListener(ownerDistrict);
            attachListener(ownerLga);
            attachListener(ownerState);
            
            // Initial update
            updateAddress();
            console.log('Address update initialization complete');
        }
        
        // Call the initialization function
        initializeAddressUpdate();

        // Form submission handling
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                // Log the form data before submission for debugging
                console.log('Form submission - preparing to submit form');
                
                // Check for file inputs and log them
                const fileInputs = form.querySelectorAll('input[type="file"]');
                fileInputs.forEach(input => {
                    if (input.files && input.files.length > 0) {
                        console.log(`File input ${input.name} has ${input.files.length} file(s)`, {
                            name: input.files[0].name,
                            type: input.files[0].type,
                            size: input.files[0].size
                        });
                    }
                });
            });
        }

        // Enhance document file upload handling
        function enhanceFileUploads() {
            const fileInputs = document.querySelectorAll('input[type="file"]');
            fileInputs.forEach(input => {
                input.addEventListener('change', function() {
                    if (this.files && this.files.length > 0) {
                        const fileInfo = {
                            name: this.files[0].name,
                            type: this.files[0].type,
                            size: this.files[0].size
                        };
                        console.log(`File selected for ${this.name}:`, fileInfo);
                        
                        // Also update any related UI elements
                        const nameElement = document.getElementById(`${this.id}_name`);
                        if (nameElement) {
                            nameElement.textContent = this.files[0].name;
                        }
                    }
                });
            });
        }
        
        // Initialize enhanced file uploads
        enhanceFileUploads();
    });

    // Function to update file name display
    function updateFileName(input, labelId) {
        const fileName = input.files[0]?.name;
        if (fileName) {
            document.getElementById(input.id + '_name').textContent = fileName;
            document.getElementById(labelId).innerHTML = '<span>Change Document</span>';
            
            // Log for debugging
            console.log(`File selected for ${input.name}:`, {
                name: fileName,
                type: input.files[0].type,
                size: input.files[0].size
            });
        }
    }
</script>
