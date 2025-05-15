<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kano State Ministry Document</title>

  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Add Alpine.js -->
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
 
    /* Updated modal styles for Alpine.js compatibility */
    [x-cloak] { display: none !important; }
    
    .alpine-modal {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      z-index: 9999;
      background-color: rgba(0, 0, 0, 0.5);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1rem;
    }
    
    .alpine-modal-content {
      background-color: white;
      border-radius: 0.5rem;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 500px;
      padding: 1.5rem;
      position: relative;
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
<body class="min-h-screen p-8 mx-auto max-w-3xl" data-planning-content data-application-id="{{ $application->id }}" {{ request()->query('url') == 'print' ? 'data-print-page="true"' : '' }}
  x-data="{
    applicationId: '{{ $application->id }}',
    showDimensionModal: false,
    showUtilityModal: false,
    dimensions: [],
    utilities: [],
    currentDimension: { id: '', description: '', dimension: '', order: '' },
    currentUtility: { id: '', utility_type: '', dimension: '', count: '', order: '' },
    editMode: false,
    
    loadDimensions() {
      axios.get(`{{ url('planning-tables/dimensions') }}/${this.applicationId}`)
        .then(response => {
          this.dimensions = response.data;
        })
        .catch(error => {
          console.error('Error loading dimensions:', error);
        });
    },
    
    loadUtilities() {
      const url = `{{ url('planning-tables/utilities') }}/${this.applicationId}`;
      console.log('Loading utilities from:', url);
      
      axios.get(url)
        .then(response => {
          console.log('Received utilities data:', response.data);
          // Explicitly set as a new array to trigger reactivity
          this.utilities = [...response.data];
          console.log('Utilities array after update:', this.utilities);
        })
        .catch(error => {
          console.error('Error loading utilities:', error);
        });
    },
    
    openDimensionModal(dimension = null) {
      if (dimension) {
        this.currentDimension = { ...dimension };
      } else {
        this.currentDimension = { id: '', description: '', dimension: '', order: '' };
      }
      this.showDimensionModal = true;
    },
    
    openUtilityModal(utility = null) {
      if (utility) {
        this.currentUtility = { ...utility };
      } else {
        this.currentUtility = { id: '', utility_type: '', dimension: '', count: '', order: '' };
      }
      this.showUtilityModal = true;
    },
    
    saveDimension() {
      const data = {
        ...this.currentDimension,
        application_id: this.applicationId
      };
      
      axios.post('{{ route('planning-tables.save-dimension') }}', data)
        .then(response => {
          this.showDimensionModal = false;
          this.loadDimensions();
        })
        .catch(error => {
          console.error('Error saving dimension:', error);
          alert('Failed to save dimension. Please try again.');
        });
    },
    
    saveUtility() {
      const data = {
        ...this.currentUtility,
        application_id: this.applicationId
      };
      
      axios.post('{{ route('planning-tables.save-utility') }}', data)
        .then(response => {
          this.showUtilityModal = false;
          this.loadUtilities();
        })
        .catch(error => {
          console.error('Error saving utility:', error);
          alert('Failed to save utility. Please try again.');
        });
    },
    
    deleteDimension(id) {
      if (confirm('Are you sure you want to delete this dimension?')) {
        axios.delete('{{ route('planning-tables.delete-dimension') }}', {
          data: { id }
        })
          .then(response => {
            this.loadDimensions();
          })
          .catch(error => {
            console.error('Error deleting dimension:', error);
            alert('Failed to delete dimension. Please try again.');
          });
      }
    },
    
    deleteUtility(id) {
      if (confirm('Are you sure you want to delete this utility?')) {
        axios.delete('{{ route('planning-tables.delete-utility') }}', {
          data: { id }
        })
          .then(response => {
            this.loadUtilities();
          })
          .catch(error => {
            console.error('Error deleting utility:', error);
            alert('Failed to delete utility. Please try again.');
          });
      }
    },
    
    debugSharedAreas() {
      const url = `{{ url('planning-tables/debug-shared-areas') }}/${this.applicationId}`;
      axios.get(url)
        .then(response => {
          console.log('Shared areas debug data:', response.data);
          alert(`Shared Areas Data:\n\n${JSON.stringify(response.data, null, 2)}`);
        })
        .catch(error => {
          console.error('Error fetching debug data:', error);
          alert('Error fetching shared areas debug data. See console for details.');
        });
    }
  }"
  x-init="() => {
    console.log('Alpine init starting');
    loadDimensions();
    loadUtilities();
    
    // Force a second load of utilities after a delay to ensure they're loaded
    setTimeout(() => {
      console.log('Forced reload of utilities');
      loadUtilities();
    }, 1000);
  }"
>
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

  <!-- Admin Controls - Removed editing controls -->

  <!-- Applicant Information Section -->
  <div class="mb-6">
    <p class="text-sm mb-1">NAME OF APPLICANT:  {{ strtoupper($application->applicant_title ?? 'N/A') }} {{ strtoupper($application->first_name ?? 'N/A') }} {{ strtoupper($application->surname ?? 'N/A') }}</p>
    <p class="text-sm mb-4">ADDRESS:  {{ strtoupper($application->address ?? 'N/A') }}</p>
  </div>

  <!-- RE: Application Section -->
  <div class="mb-6">
    <p class="text-sm font-bold">RE: APPLICATION FOR SECTIONAL TITLE OVER LKN NO {{ strtoupper($surveyRecord->tp_plan_no ?? 'N/A') }}  WITH SECTIONAL TITLE APPLICATION NO:{{ strtoupper($application->fileno ?? 'N/A') }} AT {{ strtoupper($application->property_house_no ?? 'N/A') }} {{ strtoupper($application->property_plot_no ?? 'N/A') }} {{ strtoupper($application->property_street_name ?? 'N/A') }} {{ strtoupper($application->property_lga ?? 'N/A') }}  PART OF {{ strtoupper($surveyRecord->approved_plan_no ?? 'N/A') }} WITH TP NO: {{($surveyRecord->tp_plan_no ?? 'N/A') }} AND SCHEME PLAN NO {{ strtoupper($application->scheme_no ?? 'N/A') }}</p>
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
    </div>
    <table class="w-full mb-4" id="dimensions-table">
      <thead>
        <tr class="bg-gray-200">
          <th class="w-1/6">SN</th>
          <th class="w-1/3">DESCRIPTION</th>
          <th class="w-1/2">DIMENSION (m)</th>
        </tr>
      </thead>
      <tbody>
        <template x-if="dimensions.length === 0">
          <tr>
            <td colspan="3" class="text-center py-4">No dimensions added yet.</td>
          </tr>
        </template>
        <template x-for="(dimension, index) in dimensions" :key="dimension.id">
          <tr>
            <td x-text="index + 1"></td>
            <td x-text="dimension.description"></td>
            <td x-text="parseFloat(dimension.dimension).toFixed(2)"></td>
          </tr>
        </template>
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

  <!-- Dimension Modal - Completely rebuilt -->
  <div x-cloak x-show="showDimensionModal" class="alpine-modal" x-transition>
    <div class="alpine-modal-content" @click.outside="showDimensionModal = false">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-bold">Add/Edit Site Plan Dimension</h2>
        <button @click="showDimensionModal = false" class="text-gray-500 hover:text-gray-700">&times;</button>
      </div>
      
      <form @submit.prevent="saveDimension()">
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-1">Description:</label>
          <input type="text" x-model="currentDimension.description" class="w-full p-2 border border-gray-300 rounded">
        </div>
        
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-1">Dimension (m):</label>
          <input type="number" x-model="currentDimension.dimension" step="0.01" class="w-full p-2 border border-gray-300 rounded">
        </div>
        
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-1">Display Order:</label>
          <input type="number" x-model="currentDimension.order" class="w-full p-2 border border-gray-300 rounded">
        </div>
        
        <div class="flex justify-end space-x-2">
          <button type="button" @click="showDimensionModal = false" class="px-4 py-2 bg-gray-200 text-gray-700 rounded">Cancel</button>
          <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">Save</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Utility Modal - Completely rebuilt -->
  <div x-cloak x-show="showUtilityModal" class="alpine-modal" x-transition>
    <div class="alpine-modal-content" @click.outside="showUtilityModal = false">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-bold">Add/Edit Shared Utility</h2>
        <button @click="showUtilityModal = false" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
      </div>
      
      <form @submit.prevent="saveUtility()">
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-1">Utility Type:</label>
          <input type="text" x-model="currentUtility.utility_type" class="w-full p-2 border border-gray-300 rounded">
        </div>
        
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-1">Dimension (m²):</label>
          <input type="number" x-model="currentUtility.dimension" step="0.001" class="w-full p-2 border border-gray-300 rounded">
        </div>
        
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-1">Count:</label>
          <input type="number" x-model="currentUtility.count" class="w-full p-2 border border-gray-300 rounded">
        </div>
        
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-1">Display Order:</label>
          <input type="number" x-model="currentUtility.order" class="w-full p-2 border border-gray-300 rounded">
        </div>
        
        <div class="flex justify-end space-x-2">
          <button type="button" @click="showUtilityModal = false" class="px-4 py-2 bg-gray-200 text-gray-700 rounded">Cancel</button>
          <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">Save</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Table B Section (Display-only version) -->
  <div class="mb-8">
    <div class="flex justify-between items-center mb-2">
      <p class="text-sm font-bold">TABLE B: ARC DESIGN SHARED UTILITIES</p>
    </div>
    
    <!-- Fallback server-rendered utilities table -->
    @php
    $serverUtilities = [];
    try {
      // Get existing utilities from the database
      $dbUtilities = DB::connection('sqlsrv')
          ->table('shared_utilities')
          ->where('application_id', $application->id)
          ->orderBy('order')
          ->get();
      
      // Get shared areas from mother_applications
      $sharedAreas = [];
      $sharedAreasJson = DB::connection('sqlsrv')
          ->table('mother_applications')
          ->where('id', $application->id)
          ->value('shared_areas');
      
      if (!empty($sharedAreasJson) && is_string($sharedAreasJson)) {
          $sharedAreas = json_decode($sharedAreasJson, true) ?: [];
      }
      
      // Combine existing utilities with shared areas
      $serverUtilities = $dbUtilities->toArray();
      
      // Create temporary objects for shared areas not in the DB
      foreach ($sharedAreas as $area) {
          $exists = false;
          foreach ($serverUtilities as $util) {
              if ($util->utility_type == $area) {
                  $exists = true;
                  break;
              }
          }
          
          if (!$exists) {
              $serverUtilities[] = (object)[
                  'id' => null,
                  'application_id' => $application->id,
                  'utility_type' => $area,
                  'dimension' => 0,
                  'count' => 1,
                  'order' => count($serverUtilities) + 1
              ];
          }
      }
    } catch (\Exception $e) {
      // Log the error but continue
      \Log::error("Error loading utilities for fallback table: " . $e->getMessage());
    }
    @endphp
    
    <!-- Simplified display-only table -->
    <table class="w-full" id="utilities-table">
      <thead>
        <tr class="bg-gray-200">
          <th class="w-1/6">SN</th>
          <th class="w-1/3">UTILITY TYPE</th>
          <th class="w-1/4">DIMENSION (m²)</th>
          <th class="w-1/4">COUNT</th>
        </tr>
      </thead>
      <tbody>
        @if(count($serverUtilities) > 0)
          @foreach($serverUtilities as $index => $utility)
          <tr class="utility-row">
            <td>{{ $index + 1 }}</td>
            <td>{{ $utility->utility_type }}</td>
            <td>{{ number_format((float)$utility->dimension, 3) }}</td>
            <td>{{ $utility->count }}</td>
          </tr>
          @endforeach
        @else
          <tr>
            <td colspan="4" class="text-center py-4">No utilities added yet.</td>
          </tr>
        @endif
      </tbody>
    </table>
  </div>

  <script>
    // Auto-print if this is opened as a print page
    if (window.location.search.includes('url=print')) {
      console.log('Auto-print triggered');
      setTimeout(function() {
        window.print();
      }, 500);
    }
    
    // Debug helper to ensure Alpine is working
    document.addEventListener('alpine:init', () => {
      console.log('Alpine.js initialized successfully');
      
      // Add a custom route for debugging shared areas
      Alpine.addRoutes({
        'planning-tables/debug-shared-areas/:id': {
          get({ params }) {
            return fetch(`{{ url('planning-tables/utilities') }}/${params.id}`)
              .then(response => response.json());
          }
        }
      });
    });
    
    // Setup an observer to watch for table updates
    document.addEventListener('DOMContentLoaded', function() {
      console.log('DOM loaded, setting up observer');
      
      const tableObserver = new MutationObserver((mutations) => {
        console.log('Table mutation detected');
        for(let mutation of mutations) {
          console.log('Table updated:', mutation);
        }
      });
      
      const utilitiesTable = document.getElementById('utilities-table');
      if (utilitiesTable) {
        tableObserver.observe(utilitiesTable.querySelector('tbody'), {
          childList: true,
          subtree: true
        });
      }
    });
  </script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Add debug method to Alpine data
    document.addEventListener('alpine:init', () => {
      Alpine.data('utilityData', () => ({
        debugSharedAreas() {
          // Fetch raw shared_areas from mother_applications for the current application
          fetch(`/planning-tables/debug-shared-areas/${this.applicationId}`)
            .then(response => response.json())
            .then(data => {
              console.log('Shared areas debug data:', data);
              alert(`Shared Areas Data:\n\n${JSON.stringify(data, null, 2)}`);
            })
            .catch(error => {
              console.error('Error fetching debug data:', error);
              alert('Error fetching shared areas debug data. See console for details.');
            });
        }
      }));
    });
  });
</script>
</body>
</html>