<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kano State Ministry Document</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    body {
      background-color: #c6e4f9;
      font-family: Arial, sans-serif;
    }

    table {
      border-collapse: collapse;
      width: 100%;
    }
    th, td {
      border: 1px solid #718096;
      padding: 8px;
      text-align: center;
    }
    th {
      background-color: #cbd5e0;
    } 
 
    .modal {
      display: none;
      position: fixed;
      z-index: 100;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0,0,0,0.4);
    }
    .modal-content {
      background-color: #f7fafc;
      margin: 5% auto;
      padding: 20px;
      border: 1px solid #ddd;
      width: 500px; /* Fixed width instead of percentage */
      max-width: 90%; /* Responsive limit for small screens */
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
      cursor: pointer;
    }
    .close:hover {
      color: black;
    }
    .btn {
      padding: 8px 16px;
      border-radius: 4px;
      cursor: pointer;
      font-weight: 500;
    }
    .btn-primary {
      background-color: #4299e1;
      color: white;
    }
    .btn-danger {
      background-color: #f56565;
      color: white;
    }
    .btn-success {
      background-color: #48bb78;
      color: white;
    }
    .edit-mode .admin-controls {
      display: block;
    }
    .view-mode .admin-controls {
      display: none;
    }

    /* Print-specific styles */
    @media print {
      /* Set A4 size - 210mm x 297mm */
      @page {
        size: A4 portrait;
        margin: 1cm;
      }
      
      /* Reset body styles for print */
      body {
        background-color: white !important;
        padding: 0 !important;
        margin: 0 !important;
        width: 100% !important;
        max-width: 100% !important;
      }
      
      /* Fix container width to A4 printable area */
      .min-h-screen {
        min-height: auto !important;
        max-width: 100% !important;
        padding: 0.5cm !important;
        margin: 0 !important;
      }
      
      /* Hide all admin/control elements */
      .admin-controls, #toggle-edit-mode, button, .btn, 
      th.admin-controls, td.admin-controls {
        display: none !important;
      }
      
      /* Ensure tables print properly and don't get split across pages */
      table {
        page-break-inside: avoid;
        width: 100%;
      }
      
      /* Slightly reduce font size to ensure fit */
      body, p, td, th {
        font-size: 11pt !important;
      }
      
      /* Ensure proper space between sections */
      .mb-6 {
        margin-bottom: 16pt !important;
      }
    }
  </style>
</head>
<body class="min-h-screen p-8 mx-auto max-w-3xl" data-planning-content data-application-id="{{ $application->id }}" {{ request()->query('url') == 'print' ? 'data-print-page="true"' : '' }}>
  <!-- Header with Logo -->
  <div class="flex flex-col items-center mb-6">
    <img src="{{ asset('assets/logo/logo3.jpeg') }}" alt="Kano State Coat of Arms" class="w-16 h-16 object-contain mb-2">
    <div class="text-center">
      <p class="font-bold text-sm uppercase">KANO STATE MINISTRY OF LAND AND PHYSICAL PLANNING</p>
      <p class="text-sm">NO 2 DR BALA MUHAMMAD ROAD</p>
      <p class="text-sm">PHYSICAL PLANNING DEPARTMENT.</p>
    </div>
  </div>

  <!-- Reference and Date Section -->
  <div class="flex justify-between mb-8">
    <div>
      <p class="text-sm">REF............./............./.............</p>
    </div>
    <div>
      <p class="text-sm">DATE {{$application->planning_approval_date }}</p>
    </div>
  </div>

  <!-- Admin Controls -->
  <div class="admin-controls mb-4">
    <button id="toggle-edit-mode" class="btn btn-primary">Toggle Edit Mode</button>
  </div>

  <!-- Applicant Information Section -->
  <div class="mb-6">
    <p class="text-sm mb-1">NAME OF APPLICANT:  {{ strtoupper($application->applicant_title ?? 'N/A') }} {{ strtoupper($application->first_name ?? 'N/A') }} {{ strtoupper($application->surname ?? 'N/A') }}</p>
    <p class="text-sm mb-4">ADDRESS:  {{ strtoupper($application->address ?? 'N/A') }}</p>
  </div>

  <!-- RE: Application Section -->
  <div class="mb-6">
    <p class="text-sm font-bold underline">RE: APPLICATION FOR SECTIONAL TITLE OVER LKN NO {{ strtoupper($surveyRecord->tp_plan_no ?? 'N/A') }}  WITH SECTIONAL TITLE APPLICATION NO:{{ strtoupper($application->fileno ?? 'N/A') }} AT {{ strtoupper($application->property_house_no ?? 'N/A') }} {{ strtoupper($application->property_plot_no ?? 'N/A') }} {{ strtoupper($application->property_street_name ?? 'N/A') }} {{ strtoupper($application->property_lga ?? 'N/A') }}  PART OF {{ strtoupper($surveyRecord->approved_plan_no ?? 'N/A') }} WITH TP NO: {{($surveyRecord->tp_plan_no ?? 'N/A') }} AND SCHEME PLAN NO {{ strtoupper($application->scheme_no ?? 'N/A') }}</p>
    <p class="text-sm text-justify mt-2">
      Reference to your letter dated {{$application->planning_approval_date ?? 'N/A' }} related to the above subject I am directed to convey the Approval for fragmentation of
      LKN {{ $surveyRecord->tp_plan_no ?? 'N/A' }}  in to multiple units/sections as described in table A, with approved shared compound of @php
        $utilities = DB::connection('sqlsrv')->table('shared_utilities')
        ->where('application_id', $application->id)
        ->get();
        
        $utilityTypes = [];
        foreach($utilities as $utility) {
        $utilityTypes[] = $utility->utility_type;
        }
        
        echo !empty($utilityTypes) ? implode(', ', $utilityTypes) : 'N/A';
      @endphp and utilities
      described in table B. The scheme and its fragmentation are suitable for environment where it is located.
    </p> 
  </div>

  <!-- Table A Section -->  
  <div class="mb-6">
    <div class="flex justify-between items-center mb-2">
      <p class="text-sm font-bold">TABLE A: APPROVED SITE PLAN DIMENSIONS</p>
      {{-- @if(request()->query('url') == 'recommendation')
      <button type="button" class="btn btn-primary admin-controls" id="add-dimension">Add Dimension</button>
      @endif --}}
    </div>
    <table class="w-full mb-4" id="dimensions-table">
      <thead>
        <tr class="bg-gray-200">
          <th class="w-1/6">SN</th>
          <th class="w-1/3">DESCRIPTION</th>
          <th class="w-1/2">DIMENSION (m)</th>
            @if(request()->query('url') == 'recommendation')
            <th class="admin-controls">ACTIONS</th>
            @endif  
        </tr>
      </thead>
      <tbody id="dimensions-tbody">
        <!-- Dimensions will be loaded here dynamically -->
        <tr class="loading-row">
          <td colspan="4" class="text-center py-4">Loading dimensions...</td>
        </tr>
      </tbody>
    </table>
  </div>

  <!-- Table B Section -->
  <div class="mb-8">
    <div class="flex justify-between items-center mb-2">
      <p class="text-sm font-bold">TABLE B: ARC DESIGN SHARED UTILITIES</p>
      {{-- @if(request()->query('url') == 'recommendation')
      <button type="button" class="btn btn-primary admin-controls" id="add-utility">Add Utility</button>
      @endif --}}
    </div>
    <table class="w-full" id="utilities-table">
      <thead>
        <tr class="bg-gray-200">
          <th class="w-1/6">SN</th>
          <th class="w-1/3">UTILITY TYPE</th>
          <th class="w-1/4">DIMENSION (m²)</th>
          <th class="w-1/4">COUNT</th>
          @if(request()->query('url') == 'recommendation')
                <th class="admin-controls">ACTIONS</th>
          @endif
        </tr>
      </thead>
      <tbody id="utilities-tbody">
        <!-- Utilities will be loaded here dynamically -->
        <tr class="loading-row">
          <td colspan="5" class="text-center py-4">Loading utilities...</td>
        </tr>
      </tbody>
    </table>
  </div>

  <!-- Signature Section -->
  <div class="mt-8">
    <div class="border-t border-gray-500 w-48"></div>
    <p class="text-sm mt-1">Abdullahi Usman Adam</p>
    <p class="text-sm">(ACTPP)</p>
    <p class="text-sm">For Director</p>
  </div>

  <!-- Dimension Modal -->
  <div id="dimension-modal" class="modal">
    <div class="modal-content">
      <span class="close" id="close-dimension-modal">&times;</span>
      <h2 class="text-lg font-bold mb-4">Add/Edit Site Plan Dimension</h2>
      <form id="dimension-form">
        <input type="hidden" id="dimension-id" name="id">
        <input type="hidden" id="dimension-application-id" name="application_id" value="{{ $application->id }}">
        
        <div class="mb-4">
          <label for="dimension-description" class="block text-sm font-medium text-gray-700">Description:</label>
          <input type="text" id="dimension-description" name="description" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
        </div>
        
        <div class="mb-4">
          <label for="dimension-value" class="block text-sm font-medium text-gray-700">Dimension (m):</label>
          <input type="number" id="dimension-value" name="dimension" step="0.01" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
        </div>
        
        <div class="mb-4">
          <label for="dimension-order" class="block text-sm font-medium text-gray-700">Display Order:</label>
          <input type="number" id="dimension-order" name="order" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
        </div>
        
        <div class="flex justify-end">
          <button type="button" id="cancel-dimension" class="btn bg-gray-300 text-gray-700 mr-2">Cancel</button>
          <button type="submit" class="btn btn-success">Save</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Utility Modal -->
  <div id="utility-modal" class="modal">
    <div class="modal-content">
      <span class="close" id="close-utility-modal">&times;</span>
      <h2 class="text-lg font-bold mb-4">Add/Edit Shared Utility</h2>
      <form id="utility-form">
        <input type="hidden" id="utility-id" name="id">
        <input type="hidden" id="utility-application-id" name="application_id" value="{{ $application->id }}">
        
        <div class="mb-4">
          <label for="utility-type" class="block text-sm font-medium text-gray-700">Utility Type:</label>
          <input type="text" id="utility-type" name="utility_type" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
        </div>
        
        <div class="mb-4">
          <label for="utility-dimension" class="block text-sm font-medium text-gray-700">Dimension (m²):</label>
          <input type="number" id="utility-dimension" name="dimension" step="0.001" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
        </div>
        
        <div class="mb-4">
          <label for="utility-count" class="block text-sm font-medium text-gray-700">Count:</label>
          <input type="number" id="utility-count" name="count" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
        </div>
        
        <div class="mb-4">
          <label for="utility-order" class="block text-sm font-medium text-gray-700">Display Order:</label>
          <input type="number" id="utility-order" name="order" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
        </div>
        
        <div class="flex justify-end">
          <button type="button" id="cancel-utility" class="btn bg-gray-300 text-gray-700 mr-2">Cancel</button>
          <button type="submit" class="btn btn-success">Save</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const applicationId = document.querySelector('[data-planning-content]').dataset.applicationId;
      const isAdmin = {{ auth()->check() && auth()->user()->can('manage-planning-tables') ? 'true' : 'false' }};
      
      // Toggle edit mode
      const toggleEditModeBtn = document.getElementById('toggle-edit-mode');
      if (toggleEditModeBtn && isAdmin) {
        toggleEditModeBtn.addEventListener('click', function() {
          const body = document.body;
          if (body.classList.contains('view-mode')) {
            body.classList.remove('view-mode');
            body.classList.add('edit-mode');
            this.textContent = 'View Mode';
          } else {
            body.classList.remove('edit-mode');
            body.classList.add('view-mode');
            this.textContent = 'Edit Mode';
          }
        });
      } else if (toggleEditModeBtn) {
        toggleEditModeBtn.style.display = 'none';
      }
      
      // Load data for both tables
      loadDimensions();
      loadUtilities();
      
      // Setup event listeners for dimensions table
      const dimensionModal = document.getElementById('dimension-modal');
      const dimensionForm = document.getElementById('dimension-form');
      const addDimensionBtn = document.getElementById('add-dimension');
      const closeDimensionModal = document.getElementById('close-dimension-modal');
      const cancelDimensionBtn = document.getElementById('cancel-dimension');
      
      addDimensionBtn.addEventListener('click', function() {
        document.getElementById('dimension-id').value = '';
        document.getElementById('dimension-description').value = '';
        document.getElementById('dimension-value').value = '';
        document.getElementById('dimension-order').value = '';
        dimensionModal.style.display = 'block';
      });
      
      closeDimensionModal.addEventListener('click', function() {
        dimensionModal.style.display = 'none';
      });
      
      cancelDimensionBtn.addEventListener('click', function() {
        dimensionModal.style.display = 'none';
      });
      
      dimensionForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(dimensionForm);
        const data = Object.fromEntries(formData.entries());
        
        axios.post('{{ route("planning-tables.save-dimension") }}', data)
          .then(response => {
            dimensionModal.style.display = 'none';
            loadDimensions();
          })
          .catch(error => {
            console.error('Error saving dimension:', error);
            alert('Failed to save dimension. Please try again.');
          });
      });
      
      // Setup event listeners for utilities table
      const utilityModal = document.getElementById('utility-modal');
      const utilityForm = document.getElementById('utility-form');
      const addUtilityBtn = document.getElementById('add-utility');
      const closeUtilityModal = document.getElementById('close-utility-modal');
      const cancelUtilityBtn = document.getElementById('cancel-utility');
      
      addUtilityBtn.addEventListener('click', function() {
        document.getElementById('utility-id').value = '';
        document.getElementById('utility-type').value = '';
        document.getElementById('utility-dimension').value = '';
        document.getElementById('utility-count').value = '';
        document.getElementById('utility-order').value = '';
        utilityModal.style.display = 'block';
      });
      
      closeUtilityModal.addEventListener('click', function() {
        utilityModal.style.display = 'none';
      });
      
      cancelUtilityBtn.addEventListener('click', function() {
        utilityModal.style.display = 'none';
      });
      
      utilityForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(utilityForm);
        const data = Object.fromEntries(formData.entries());
        
        axios.post('{{ route("planning-tables.save-utility") }}', data)
          .then(response => {
            utilityModal.style.display = 'none';
            loadUtilities();
          })
          .catch(error => {
            console.error('Error saving utility:', error);
            alert('Failed to save utility. Please try again.');
          });
      });
      
      // Function to load dimensions data
      function loadDimensions() {
        const tbody = document.getElementById('dimensions-tbody');
        
        axios.get(`{{ url('planning-tables/dimensions') }}/${applicationId}`)
          .then(response => {
            const dimensions = response.data;
            tbody.innerHTML = '';
            
            if (dimensions.length === 0) {
              tbody.innerHTML = `
                <tr>
                  <td colspan="4" class="text-center py-4">No dimensions added yet.</td>
                </tr>
              `;
              return;
            }
            
            dimensions.forEach((dimension, index) => {
              const row = document.createElement('tr');
                row.innerHTML = `
                <td>${index + 1}</td>
                <td>${dimension.description}</td>
                <td>${parseFloat(dimension.dimension).toFixed(2)}</td>
                ${new URLSearchParams(window.location.search).get('url') == 'recommendation' ? `
                <td class="admin-controls">
                  <div class="flex space-x-2">
                  <button type="button" class="p-1.5 rounded-md text-blue-700 hover:bg-blue-100 transition-colors edit-dimension" data-id="${dimension.id}" title="Edit">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil"><path d="M17 3a2.85 2.85 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                  </button>
                  <button type="button" class="p-1.5 rounded-md text-red-700 hover:bg-red-100 transition-colors delete-dimension" data-id="${dimension.id}" title="Delete">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                  </button>
                  </div>
                </td>
                ` : ``}
              `;
              tbody.appendChild(row);
            });
            
            // Add event listeners to the newly created buttons
            document.querySelectorAll('.edit-dimension').forEach(button => {
              button.addEventListener('click', function() {
                const id = this.dataset.id;
                const dimension = dimensions.find(d => d.id == id);
                
                document.getElementById('dimension-id').value = dimension.id;
                document.getElementById('dimension-description').value = dimension.description;
                document.getElementById('dimension-value').value = dimension.dimension;
                document.getElementById('dimension-order').value = dimension.order;
                
                dimensionModal.style.display = 'block';
              });
            });
            
            document.querySelectorAll('.delete-dimension').forEach(button => {
              button.addEventListener('click', function() {
                if (confirm('Are you sure you want to delete this dimension?')) {
                  const id = this.dataset.id;
                  
                  axios.delete('{{ route("planning-tables.delete-dimension") }}', {
                    data: { id }
                  })
                    .then(response => {
                      loadDimensions();
                    })
                    .catch(error => {
                      console.error('Error deleting dimension:', error);
                      alert('Failed to delete dimension. Please try again.');
                    });
                }
              });
            });
          })
          .catch(error => {
            console.error('Error loading dimensions:', error);
            tbody.innerHTML = `
              <tr>
                <td colspan="4" class="text-center py-4">Failed to load dimensions. Please refresh the page.</td>
              </tr>
            `;
          });
      }
      
      // Function to load utilities data
      function loadUtilities() {
        const tbody = document.getElementById('utilities-tbody');
        
        axios.get(`{{ url('planning-tables/utilities') }}/${applicationId}`)
          .then(response => {
            const utilities = response.data;
            tbody.innerHTML = '';
            
            if (utilities.length === 0) {
              tbody.innerHTML = `
                <tr>
                  <td colspan="5" class="text-center py-4">No utilities added yet.</td>
                </tr>
              `;
              return;
            }
            
            utilities.forEach((utility, index) => {
              const row = document.createElement('tr');
              row.innerHTML = `
                <td>${index + 1}</td>
                <td>${utility.utility_type}</td>
                <td>${parseFloat(utility.dimension).toFixed(3)}</td>
                <td>${utility.count}</td>
                ${new URLSearchParams(window.location.search).get('url') == 'recommendation' ? `
                <td class="admin-controls">
                  <div class="flex space-x-2">
                  <button type="button" class="p-1.5 rounded-md text-blue-700 hover:bg-blue-100 transition-colors edit-utility" data-id="${utility.id}" title="Edit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil"><path d="M17 3a2.85 2.85 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                  </button>
                  <button type="button" class="p-1.5 rounded-md text-red-700 hover:bg-red-100 transition-colors delete-utility" data-id="${utility.id}" title="Delete">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                  </button>
                  </div>
                </td>
                ` : ``}
              `;
              tbody.appendChild(row);
            });
            
            // Add event listeners to the newly created buttons
            document.querySelectorAll('.edit-utility').forEach(button => {
              button.addEventListener('click', function() {
                const id = this.dataset.id;
                const utility = utilities.find(u => u.id == id);
                
                document.getElementById('utility-id').value = utility.id;
                document.getElementById('utility-type').value = utility.utility_type;
                document.getElementById('utility-dimension').value = utility.dimension;
                document.getElementById('utility-count').value = utility.count;
                document.getElementById('utility-order').value = utility.order;
                
                utilityModal.style.display = 'block';
              });
            });
            
            document.querySelectorAll('.delete-utility').forEach(button => {
              button.addEventListener('click', function() {
                if (confirm('Are you sure you want to delete this utility?')) {
                  const id = this.dataset.id;
                  
                  axios.delete('{{ route("planning-tables.delete-utility") }}', {
                    data: { id }
                  })
                    .then(response => {
                      loadUtilities();
                    })
                    .catch(error => {
                      console.error('Error deleting utility:', error);
                      alert('Failed to delete utility. Please try again.');
                    });
                }
              });
            });
          })
          .catch(error => {
            console.error('Error loading utilities:', error);
            tbody.innerHTML = `
              <tr>
                <td colspan="5" class="text-center py-4">Failed to load utilities. Please refresh the page.</td>
              </tr>
            `;
          });
      }
      
      // Close modals when clicking outside of them
      window.addEventListener('click', function(event) {
        if (event.target === dimensionModal) {
          dimensionModal.style.display = 'none';
        }
        if (event.target === utilityModal) {
          utilityModal.style.display = 'none';
        }
      });
      
      // Auto-print if this is opened as a print page
      if (window.location.search.includes('url=print')) {
        console.log('Auto-print triggered');
        setTimeout(function() {
          window.print();
        }, 500);
      }

      // Auto-print if this is opened directly as a print page
      if (window.location.search.includes('url=print')) {
        console.log('Auto-print ready on planning_recomm page');
        document.body.classList.add('print-ready');
        
        // Remove buttons and controls for print view
        document.querySelectorAll('.admin-controls, #toggle-edit-mode, button:not([data-print-safe])').forEach(el => {
          el.style.display = 'none';
        });
      }
    });
  </script>
</body>
</html>