    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // State management
        let currentInstrumentType = null;
        let tempFileCounter = 1;

        // Complete instrument type definitions for all 12 types
        const instrumentTypes = {
            'power-of-attorney': {
                id: 'power-of-attorney',
                name: 'Power of Attorney',
                firstParty: 'Grantor',
                secondParty: 'Grantee'
            },
            'irrevocable-power-of-attorney': {
                id: 'irrevocable-power-of-attorney',
                name: 'Irrevocable Power of Attorney',
                firstParty: 'Grantor',
                secondParty: 'Grantee'
            },
            'deed-of-mortgage': {
                id: 'deed-of-mortgage',
                name: 'Deed of Mortgage',
                firstParty: 'Mortgagor',
                secondParty: 'Mortgagee'
            },
            'tripartite-mortgage': {
                id: 'tripartite-mortgage',
                name: 'Tripartite Mortgage',
                firstParty: 'Mortgagor',
                secondParty: 'Mortgagee'
            },
            'deed-of-assignment': {
                id: 'deed-of-assignment',
                name: 'Deed of Assignment',
                firstParty: 'Assignor',
                secondParty: 'Assignee'
            },
            'deed-of-lease': {
                id: 'deed-of-lease',
                name: 'Deed of Lease',
                firstParty: 'Lessor',
                secondParty: 'Lessee'
            },
            'deed-of-sub-lease': {
                id: 'deed-of-sub-lease',
                name: 'Deed of Sub-Lease',
                firstParty: 'Sub-Lessor',
                secondParty: 'Sub-Lessee'
            },
            'deed-of-sub-under-lease': {
                id: 'deed-of-sub-under-lease',
                name: 'Deed of Sub-Under-Lease',
                firstParty: 'Sub-Under-Lessor',
                secondParty: 'Sub-Under-Lessee'
            },
            'deed-of-sub-division': {
                id: 'deed-of-sub-division',
                name: 'Deed of Sub-Division',
                firstParty: 'Subdivider',
                secondParty: 'Beneficiary'
            },
            'deed-of-merger': {
                id: 'deed-of-merger',
                name: 'Deed of Merger',
                firstParty: 'Merging Party',
                secondParty: 'Receiving Party'
            },
            'deed-of-surrender': {
                id: 'deed-of-surrender',
                name: 'Deed of Surrender',
                firstParty: 'Surrenderer',
                secondParty: 'Recipient'
            },
            'deed-of-assent': {
                id: 'deed-of-assent',
                name: 'Deed of Assent',
                firstParty: 'Executor/Administrator',
                secondParty: 'Beneficiary'
            },
            'deed-of-release': {
                id: 'deed-of-release',
                name: 'Deed of Release',
                firstParty: 'Releasor',
                secondParty: 'Releasee'
            }
        };

        // DOM elements
        const elements = {
            registrationDialog: document.getElementById('registration-dialog'),
            dialogTitle: document.getElementById('dialog-title'),
            registrationForm: document.getElementById('registration-form'),
            cancelBtn: document.getElementById('cancel-btn'),
            submitBtn: document.getElementById('submit-btn'),
            isTemporaryFileNo: document.getElementById('isTemporaryFileNo'),
            temporaryFileSection: document.getElementById('temporary-file-section'),
            regularFileSection: document.getElementById('regular-file-section'),
            temporaryFileNo: document.getElementById('temporaryFileNo'),
            regenerateTempBtn: document.getElementById('regenerate-temp-btn'),
            fileNumberType: document.getElementById('fileNumberType'),
            filePrefix: document.getElementById('filePrefix'),
            fileSerialNo: document.getElementById('fileSerialNo'),
            fileNo: document.getElementById('fileNo'),
            regNoSection: document.getElementById('reg-no-section'),
            firstPartyTitle: document.getElementById('first-party-title'),
            firstPartyLabel: document.getElementById('first-party-label'),
            secondPartyTitle: document.getElementById('second-party-title'),
            secondPartyLabel: document.getElementById('second-party-label'),
            surveyInfo: document.getElementById('surveyInfo'),
            surveyInfoSection: document.getElementById('survey-info-section'),
            instrumentFields: document.getElementById('instrument-fields')
        };

        // Helper functions
        function generateTemporaryFileNo() {
            const paddedCounter = String(tempFileCounter).padStart(4, '0');
            tempFileCounter++;
            return `TEMP-${paddedCounter}`;
        }

        function formatFileNumber(type, prefix, serialNo) {
            if (!prefix || !serialNo) return '';
            
            switch (type) {
                case 'mlsFileNo':
                    return `${prefix}-${serialNo}`;
                case 'kangisFileNo':
                    return `${prefix} ${serialNo}`;
                case 'newKangisFileNo':
                    return `${prefix}${serialNo}`;
                default:
                    return `${prefix}-${serialNo}`;
            }
        }

        function updatePartyLabels(instrumentType) {
            const type = instrumentTypes[instrumentType];
            if (!type) return;

            elements.firstPartyTitle.textContent = `${type.firstParty} Information`;
            elements.firstPartyLabel.textContent = `${type.firstParty} Name`;
            elements.secondPartyTitle.textContent = `${type.secondParty} Information`;
            elements.secondPartyLabel.textContent = `${type.secondParty} Name`;

            // Update placeholders
            document.getElementById('firstPartyName').placeholder = `Enter ${type.firstParty.toLowerCase()}'s full name`;
            document.getElementById('secondPartyName').placeholder = `Enter ${type.secondParty.toLowerCase()}'s full name`;
        }

        function renderInstrumentSpecificFields(instrumentType) {
            const fieldsContainer = elements.instrumentFields;
            fieldsContainer.innerHTML = '';

            switch (instrumentType) {
                case 'power-of-attorney':
                case 'irrevocable-power-of-attorney':
                    fieldsContainer.innerHTML = `
                        <div class="space-y-2">
                            <label for="duration" class="label">Duration</label>
                            <input id="duration" name="duration" class="input" placeholder="Enter duration (e.g., 5 years)">
                        </div>
                    `;
                    break;
                case 'deed-of-mortgage':
                case 'tripartite-mortgage':
                    fieldsContainer.innerHTML = `
                        <div class="space-y-2">
                            <label for="bankName" class="label">Bank Name</label>
                            <input id="bankName" name="bankName" class="input" placeholder="Enter bank name">
                        </div>
                        <div class="space-y-2">
                            <label for="mortgageDate" class="label">Mortgage Date</label>
                            <input id="mortgageDate" name="mortgageDate" type="date" class="input">
                        </div>
                        <div class="space-y-2">
                            <label for="governorSignDate" class="label">Governor Sign Date</label>
                            <input id="governorSignDate" name="governorSignDate" type="date" class="input">
                        </div>
                    `;
                    break;
                case 'deed-of-assignment':
                    fieldsContainer.innerHTML = `
                        <div class="space-y-2">
                            <label for="assignmentTerm" class="label">Assignment Term</label>
                            <input id="assignmentTerm" name="assignmentTerm" class="input" placeholder="Enter assignment term">
                        </div>
                        <div class="space-y-2">
                            <label for="cofoDate" class="label">CofO Date</label>
                            <input id="cofoDate" name="cofoDate" type="date" class="input">
                        </div>
                        <div class="space-y-2">
                            <label for="cofoRegParticulars" class="label">CofO Reg Particulars</label>
                            <input id="cofoRegParticulars" name="cofoRegParticulars" class="input" placeholder="Enter CofO registration particulars">
                        </div>
                        <div class="space-y-2">
                            <label for="cofoTerm" class="label">CofO Term</label>
                            <input id="cofoTerm" name="cofoTerm" class="input" placeholder="Enter CofO term">
                        </div>
                        <div class="space-y-2">
                            <label for="cofoTermStartDate" class="label">CofO Term Start Date</label>
                            <input id="cofoTermStartDate" name="cofoTermStartDate" type="date" class="input">
                        </div>
                    `;
                    break;
                case 'deed-of-lease':
                    fieldsContainer.innerHTML = `
                        <div class="space-y-2">
                            <label for="leaseTerm" class="label">Lease Term</label>
                            <input id="leaseTerm" name="leaseTerm" class="input" placeholder="Enter lease term (e.g., 99 years)">
                        </div>
                        <div class="space-y-2">
                            <label for="annualRent" class="label">Annual Rent</label>
                            <input id="annualRent" name="annualRent" class="input" placeholder="Enter annual rent">
                        </div>
                        <div class="space-y-2">
                            <label for="chiefMagistrateSignDate" class="label">Chief Magistrate Sign Date</label>
                            <input id="chiefMagistrateSignDate" name="chiefMagistrateSignDate" type="date" class="input">
                        </div>
                    `;
                    break;
                case 'deed-of-sub-lease':
                    fieldsContainer.innerHTML = `
                        <div class="space-y-2">
                            <label for="leaseTerm" class="label">Lease Term</label>
                            <input id="leaseTerm" name="leaseTerm" class="input" placeholder="Enter lease term (e.g., 99 years)">
                        </div>
                        <div class="space-y-2">
                            <label for="subLeaseAmount" class="label">Sub-Lease Amount</label>
                            <input id="subLeaseAmount" name="subLeaseAmount" class="input" placeholder="Enter sub-lease amount">
                        </div>
                        <div class="space-y-2">
                            <label for="assignmentTerm" class="label">Assignment Term</label>
                            <input id="assignmentTerm" name="assignmentTerm" class="input" placeholder="Enter assignment term">
                        </div>
                        <div class="space-y-2">
                            <label for="cofoDate" class="label">CofO Date</label>
                            <input id="cofoDate" name="cofoDate" type="date" class="input">
                        </div>
                        <div class="space-y-2">
                            <label for="cofoRegParticulars" class="label">CofO Reg Particulars</label>
                            <input id="cofoRegParticulars" name="cofoRegParticulars" class="input" placeholder="Enter CofO registration particulars">
                        </div>
                        <div class="space-y-2">
                            <label for="cofoTerm" class="label">CofO Term</label>
                            <input id="cofoTerm" name="cofoTerm" class="input" placeholder="Enter CofO term">
                        </div>
                        <div class="space-y-2">
                            <label for="cofoTermStartDate" class="label">CofO Term Start Date</label>
                            <input id="cofoTermStartDate" name="cofoTermStartDate" type="date" class="input">
                        </div>
                    `;
                    break;
                case 'deed-of-sub-under-lease':
                    fieldsContainer.innerHTML = `
                        <div class="space-y-2">
                            <label for="leaseTerm" class="label">Lease Term</label>
                            <input id="leaseTerm" name="leaseTerm" class="input" placeholder="Enter lease term (e.g., 99 years)">
                        </div>
                        <div class="space-y-2">
                            <label for="leaseAmount" class="label">Lease Amount</label>
                            <input id="leaseAmount" name="leaseAmount" class="input" placeholder="Enter lease amount">
                        </div>
                    `;
                    break;
                case 'deed-of-sub-division':
                    fieldsContainer.innerHTML = `
                        <div class="space-y-2">
                            <label for="numberOfPlots" class="label">Number of Plots</label>
                            <input id="numberOfPlots" name="numberOfPlots" type="number" class="input" placeholder="Enter number of plots">
                        </div>
                        <div class="space-y-2">
                            <label for="originalPlotSize" class="label">Original Plot Size</label>
                            <input id="originalPlotSize" name="originalPlotSize" class="input" placeholder="Enter original plot size">
                        </div>
                    `;
                    break;
                case 'deed-of-merger':
                    fieldsContainer.innerHTML = `
                        <div class="space-y-2">
                            <label for="mergingProperties" class="label">Merging Properties</label>
                            <input id="mergingProperties" name="mergingProperties" class="input" placeholder="Enter merging properties">
                        </div>
                        <div class="space-y-2">
                            <label for="resultingProperty" class="label">Resulting Property</label>
                            <input id="resultingProperty" name="resultingProperty" class="input" placeholder="Enter resulting property">
                        </div>
                    `;
                    break;
                case 'deed-of-surrender':
                    fieldsContainer.innerHTML = `
                        <div class="space-y-2">
                            <label for="surrenderReason" class="label">Reason for Surrender</label>
                            <input id="surrenderReason" name="surrenderReason" class="input" placeholder="Enter reason for surrender">
                        </div>
                        <div class="space-y-2">
                            <label for="compensationAmount" class="label">Compensation Amount</label>
                            <input id="compensationAmount" name="compensationAmount" class="input" placeholder="Enter compensation amount (if any)">
                        </div>
                    `;
                    break;
                case 'deed-of-assent':
                    fieldsContainer.innerHTML = `
                        <div class="space-y-2">
                            <label for="deceasedName" class="label">Deceased Name</label>
                            <input id="deceasedName" name="deceasedName" class="input" placeholder="Enter deceased's full name">
                        </div>
                        <div class="space-y-2">
                            <label for="dateOfDeath" class="label">Date of Death</label>
                            <input id="dateOfDeath" name="dateOfDeath" type="date" class="input">
                        </div>
                        <div class="space-y-2">
                            <label for="willReference" class="label">Will Reference</label>
                            <input id="willReference" name="willReference" class="input" placeholder="Enter will reference number">
                        </div>
                    `;
                    break;
                case 'deed-of-release':
                    fieldsContainer.innerHTML = `
                        <div class="space-y-2">
                            <label for="bankName" class="label">Bank Name</label>
                            <input id="bankName" name="bankName" class="input" placeholder="Enter bank name">
                        </div>
                        <div class="space-y-2">
                            <label for="releaseRegParticulars" class="label">Release Reg Particulars</label>
                            <input id="releaseRegParticulars" name="releaseRegParticulars" class="input" placeholder="Enter release registration particulars">
                        </div>
                        <div class="space-y-2">
                            <label for="originalInstrumentRegParticulars" class="label">Original Instrument Reg Particulars</label>
                            <input id="originalInstrumentRegParticulars" name="originalInstrumentRegParticulars" class="input" placeholder="Enter original instrument registration particulars">
                        </div>
                        <div class="space-y-2">
                            <label for="releaseAmount" class="label">Release Amount</label>
                            <input id="releaseAmount" name="releaseAmount" class="input" placeholder="Enter release amount (if applicable)">
                        </div>
                    `;
                    break;
            }
        }

        function openRegistrationDialog(instrumentType) {
            currentInstrumentType = instrumentType;
            const type = instrumentTypes[instrumentType];
            
            elements.dialogTitle.textContent = `Register ${type.name}`;
            updatePartyLabels(instrumentType);
            renderInstrumentSpecificFields(instrumentType);
            
            // Show/hide registration number section for power of attorney types
            if (instrumentType === 'power-of-attorney' || instrumentType === 'irrevocable-power-of-attorney') {
                elements.regNoSection.classList.remove('hidden');
            } else {
                elements.regNoSection.classList.add('hidden');
            }
            
            elements.registrationDialog.classList.remove('hidden');
        }

        function closeRegistrationDialog() {
            elements.registrationDialog.classList.add('hidden');
            currentInstrumentType = null;
            elements.registrationForm.reset();
        }

        function handleTemporaryFileNoChange() {
            const isChecked = elements.isTemporaryFileNo.checked;
            
            if (isChecked) {
                elements.temporaryFileSection.classList.remove('hidden');
                elements.regularFileSection.classList.add('hidden');
                elements.temporaryFileNo.value = generateTemporaryFileNo();
            } else {
                elements.temporaryFileSection.classList.add('hidden');
                elements.regularFileSection.classList.remove('hidden');
                elements.temporaryFileNo.value = '';
            }
        }

        function updateFileNumber() {
            const type = elements.fileNumberType.value;
            const prefix = elements.filePrefix.value;
            const serialNo = elements.fileSerialNo.value;
            
            elements.fileNo.value = formatFileNumber(type, prefix, serialNo);
        }

        function handleSurveyInfoChange() {
            const isChecked = elements.surveyInfo.checked;
            
            if (isChecked) {
                elements.surveyInfoSection.classList.remove('hidden');
            } else {
                elements.surveyInfoSection.classList.add('hidden');
                // Clear survey fields
                document.getElementById('lga').value = '';
                document.getElementById('district').value = '';
                document.getElementById('plotNumber').value = '';
            }
        }

        function collectFormData() {
            const formData = new FormData(elements.registrationForm);
            const data = {};
            
            for (let [key, value] of formData.entries()) {
                data[key] = value;
            }
            
            // Add instrument type
            data.instrumentType = currentInstrumentType;
            
            // Add final file number
            data.finalFileNo = elements.isTemporaryFileNo.checked ? 
                elements.temporaryFileNo.value : 
                elements.fileNo.value;
            
            return data;
        }

        function handleSubmit() {
            const formData = collectFormData();
            console.log('Form submitted:', formData);
            
            // Here you would typically send the data to a server
            alert('Instrument registration submitted successfully!');
            closeRegistrationDialog();
        }

        // Event listeners
        document.querySelectorAll('.instrument-type-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const type = btn.getAttribute('data-type');
                openRegistrationDialog(type);
            });
        });

        elements.cancelBtn.addEventListener('click', closeRegistrationDialog);
        elements.submitBtn.addEventListener('click', handleSubmit);

        elements.isTemporaryFileNo.addEventListener('change', handleTemporaryFileNoChange);
        elements.regenerateTempBtn.addEventListener('click', () => {
            elements.temporaryFileNo.value = generateTemporaryFileNo();
        });

        elements.fileNumberType.addEventListener('change', updateFileNumber);
        elements.filePrefix.addEventListener('input', updateFileNumber);
        elements.fileSerialNo.addEventListener('input', updateFileNumber);

        elements.surveyInfo.addEventListener('change', handleSurveyInfoChange);

        // Close dialog when clicking outside
        elements.registrationDialog.addEventListener('click', (e) => {
            if (e.target === elements.registrationDialog) {
                closeRegistrationDialog();
            }
        });

        // Set default dates to today
        function setDefaultDates() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('registrationDate').value = today;
            document.getElementById('entryDate').value = today;
        }

        // Initialize the page
        function init() {
            setDefaultDates();
            lucide.createIcons();
        }

        // Initialize when DOM is loaded
        document.addEventListener('DOMContentLoaded', init);
    </script>
 