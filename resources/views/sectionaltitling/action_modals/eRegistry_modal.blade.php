<div id="eRegistryModal" class="fixed inset-0 z-[1000] hidden bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg">
        <div class="flex items-center justify-between px-4 py-2 border-b">
            <h5 class="text-base font-semibold">eRegistry</h5>
            <button type="button" class="text-gray-400 hover:text-gray-600" onclick="closeERegistryModal()">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        
        <style>
            .disabled-input {
                opacity: 0.6;
                cursor: not-allowed;
                background-color: #f1f1f1;
            }
        </style>
        
        <div class="px-4 py-4">
            <form id="eRegistryForm">
                @csrf
                <input type="hidden" >
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">eRegistry ID</label>
                        <input type="text"  class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 disabled-input"  id="eRegistryApplicationId" name="application_id" value="" disabled>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">File Name</label>
                        <input type="text"  class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 disabled-input" id="eRegistryApplicantName" name="eRegistryApplicantName" disabled>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">File Number</label>
                        <input type="text"  class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 disabled-input" id="eRegistryFileNo" name="eRegistryFileNo"  disabled>
                    </div>
                   
                    <div>
                        <label class="block text-sm font-medium text-gray-700">File Location</label>
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" id="eRegistryFileLocation" name="eRegistryFileLocation">
                            <option value="">Select Location</option>
                            <option value="DG">DG</option>
                            <option value="Commissional">Commissioner's Officeg</option>
                            <option value="Lands Registry">Lands Registry</option>
                            <option value="KANGIS Registry">KANGIS Registry</option>
                            <option value="Deeds Registry">Deeds Registry</option>
                            <option value="Survey Registry">Survey Registry</option>
                            <option value="Cadastral Registry">Cadastral Registry</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">File Commissioning Date</label>
                        <input type="date"  class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" id="eRegistryCommissionDate" name="eRegistryCommissionDate">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Decommissioning Date</label>
                        <input type="date"  class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" id="eRegistryDecommissionDate" name="eRegistryDecommissionDate">
                    </div>
                </div>
                <div class="flex justify-between items-center bg-gray-100 mt-4 px-4 py-3 rounded-b">
            
                    <button type="button" id="editERegistryBtn" class="flex items-center space-x-2 px-4 py-2 bg-gray-500 text-white rounded-md shadow hover:bg-gray-600">
                        <i data-lucide="edit" class="w-4 h-4"></i>
                        <span>Edit</span>
                    </button>
                    <button type="button" class="flex items-center space-x-2 px-4 py-2 bg-blue-500 text-white rounded-md shadow hover:bg-blue-600">
                        <i data-lucide="folder" class="w-4 h-4"></i>
                        <span>EDMS</span>
                    </button>
                    <button type="button" id="submitERegistry" class="flex items-center space-x-2 px-4 py-2 bg-green-500 text-white rounded-md shadow hover:bg-green-600">
                        <i data-lucide="send" class="w-4 h-4"></i>
                        <span>Submit</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Lands Modal -->


 <script>
    // Add class to all disabled inputs on page load
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.getElementById('eRegistryForm').querySelectorAll('input');
        inputs.forEach(input => {
            if (input.disabled) {
                input.classList.add('disabled-input');
            }
        });
    });

    // eRegistry Modal logic
    function openERegistryModal(applicationId, fileNo, applicantType, applicantData) {
        // Set the application id to the hidden input
        document.getElementById('eRegistryApplicationId').value = applicationId;
        document.getElementById('eRegistryFileNo').value = fileNo;
        
        // Process applicant name based on type
        let applicantName = '';
        
        if(applicantType === 'individual' && applicantData) {
            const { applicant_title, first_name, surname } = applicantData;
            applicantName = [applicant_title, first_name, surname].filter(Boolean).join(' ');
        } 
        else if(applicantType === 'corporate' && applicantData) {
            applicantName = applicantData.corporate_name || '';
        }
        else if(applicantType === 'multiple' && applicantData) {
            try {
                // Handle array of names or JSON string
                if(typeof applicantData === 'string') {
                    const namesArray = JSON.parse(applicantData);
                    applicantName = Array.isArray(namesArray) ? namesArray.join(', ') : applicantData;
                } else if(Array.isArray(applicantData)) {
                    applicantName = applicantData.join(', ');
                }
            } catch(e) {
                applicantName = applicantData.toString();
            }
        }
        
        // Set applicant name if element exists
        const applicantNameField = document.getElementById('eRegistryApplicantName');
        if (applicantNameField) {
            applicantNameField.value = applicantName;
        }
        
        // Show the modal
        document.getElementById('eRegistryModal').classList.remove('hidden');
    }
    function closeERegistryModal() {
        document.getElementById('eRegistryModal').classList.add('hidden');
        document.getElementById('eRegistryApplicationId').value = '';
    }
    // Close modal when clicking outside the modal content
    document.addEventListener('mousedown', function(event) {
        const modal = document.getElementById('eRegistryModal');
        if (!modal.classList.contains('hidden')) {
            const modalContent = modal.querySelector('div.bg-white');
            if (modal && !modalContent.contains(event.target)) {
                closeERegistryModal();
            }
        }
    });

    // Enable editing of form fields when Edit button is clicked
    document.getElementById('editERegistryBtn').addEventListener('click', function() {
        // Get all input elements in the form
        const inputs = document.getElementById('eRegistryForm').querySelectorAll('input');
        
        // Loop through all inputs and enable them, except for eRegistryFileNo
        inputs.forEach(input => {
            if (input.id !== 'eRegistryFileNo') {
                input.disabled = false;
                input.classList.remove('disabled-input');
            }
        });
    });
     



    //Ajax api to call the eRegistry API
       
 </script>