@extends('layouts.app')

@section('page-title')
    {{ $PageTitle ?? __('Instrument Registration (New Registration)') }}
@endsection

 

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/lucide@latest"></script>

<!-- Inline script to make sure critical functions are defined early -->
<script>
    // Define critical functions in the global scope first
    function openBatchRegisterModal() {
        console.log("Opening batch registration modal from inline script");
        // The rest will be handled by the main JS file
        if (typeof window.openBatchRegisterModalImplementation === 'function') {
            window.openBatchRegisterModalImplementation();
        } else {
            // Fallback implementation if main JS hasn't loaded yet
            document.getElementById('batchRegisterModal').style.display = 'block';
            // We'll reload the page after a slight delay to ensure JS is properly loaded
            setTimeout(() => {
                location.reload();
            }, 500);
        }
    }
</script>
@include('instrument_registration.partials.css')

<div class="flex-1 overflow-auto">
    <!-- Header -->
    @include($headerPartial ?? 'admin.header')
    
    <!-- Main Content -->
    <div class="container mx-auto py-6 space-y-6 px-4">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <h1 class="text-2xl font-bold">Instrument Registration</h1>
            <div>
                <a href="#" onclick="openBatchRegisterModal()" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg flex items-center gap-2">
                    <i class="fas fa-layer-group"></i> Batch Registration
                </a>
            </div>
        </div>
    
        <!-- Stats Cards -->
        @include('instrument_registration.partials.statistic_card')
    
        <!-- Main Content Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <!-- Table tabs & controls -->
            <div class="px-4 py-5 border-b sm:px-6 bg-white flex justify-between items-center flex-wrap gap-4">
                <!-- Tabs -->
                <div class="flex space-x-4 overflow-x-auto pb-1">
                    <button class="px-3 py-2 tab-active" id="main-tab-pending" onclick="switchTab('pending', this)">Pending</button>
                    <button class="px-3 py-2 text-gray-500" onclick="switchTab('registered', this)">Registered</button>
                    <button class="px-3 py-2 text-gray-500" onclick="switchTab('rejected', this)">Rejected</button>
                    <button class="px-3 py-2 text-gray-500" onclick="switchTab('all', this)">All</button>
                </div>
                <!-- Search -->
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    <input id="searchInput" type="search" placeholder="Search by File No" class="border rounded-md pl-9 pr-3 py-2 text-sm w-64">
                </div>
            </div>
            <!-- Sub-tabs for Pending -->
           <div id="pendingSubTabs" class="flex justify-center gap-2 py-3 transition-all duration-200" style="display: none;">
              <button class="pending-subtab-btn flex flex-col items-center focus:outline-none transition-all duration-150" id="subtab-other" onclick="switchPendingSubTab('other')">
                <span class="text-base font-semibold">Other Instruments</span>
              </button>
              <a href="{{route('st_transfer.index')}}" class="pending-subtab-btn flex flex-col items-center focus:outline-none transition-all duration-150" id="subtab-st" onclick="switchPendingSubTab('st')">
                <span class="text-base font-semibold">ST Assignment</span>
                <span class="text-xs font-normal text-gray-400">(Transfer of Title)</span>
              </a>
              <button class="pending-subtab-btn flex flex-col items-center focus:outline-none transition-all duration-150" id="subtab-regular" onclick="switchPendingSubTab('regular')">
                <span class="text-base font-semibold">Regular CofO</span>
              </button>
              <a href="{{route('st_registration.index')}}" class="pending-subtab-btn flex flex-col items-center focus:outline-none transition-all duration-150" id="subtab-sectional" onclick="switchPendingSubTab('sectional')">
                <span class="text-base font-semibold">Sectional Titling CofO</span>
              </a>
              <a  href="{{route('sltrdeedsreg.index')}}" class="pending-subtab-btn flex flex-col items-center focus:outline-none transition-all duration-150" id="subtab-sltr" onclick="switchPendingSubTab('sltr')">
                <span class="text-base font-semibold">SLTR CofO</span>
              </a>
            </div>
            <style>
              .pending-subtab-btn {
                @apply px-5 py-3 rounded-lg border border-gray-300 bg-white text-gray-700 font-medium shadow-sm transition-all duration-150 hover:bg-blue-50 hover:border-blue-500 hover:text-blue-700 focus:ring-2 focus:ring-blue-200;
                margin-right: 0.25rem;
                min-width: 160px;
                transition: all 0.2s ease;
                cursor: pointer;
              }
              .pending-subtab-btn.active {
                @apply bg-blue-600 text-white border-blue-600 shadow-md;
                transform: translateY(-2px);
              }
              .pending-subtab-btn:hover:not(.active) {
                @apply bg-blue-100 border-blue-400 shadow-md;
              }
              .pending-subtab-btn span:first-child {
                @apply mb-1;
              }
            </style>
            <style>
                .pending-subtab-btn {
                    @apply px-4 py-2 rounded-lg border border-gray-200 bg-gray-50 text-gray-700 font-medium shadow-sm transition-all duration-150;
                    margin-right: 0.25rem;
                }
                .pending-subtab-btn.active,
                .pending-subtab-btn:focus,
                .pending-subtab-btn:hover {
                    @apply bg-blue-600 text-white border-blue-600 shadow;
                }
            </style>
            <script>
                // Show/hide sub-tabs based on main tab selection
                function switchTab(tab, btn) {
                    // ...existing code for tab switching...
                    document.querySelectorAll('.tab-active').forEach(el => el.classList.remove('tab-active'));
                    btn.classList.add('tab-active');
                    // Show sub-tabs only for Pending
                    document.getElementById('pendingSubTabs').style.display = (tab === 'pending') ? 'flex' : 'none';
                    // Optionally, reset subtab highlight when switching main tab
                    if (tab === 'pending') {
                        switchPendingSubTab('other');
                    }
                }
                // Highlight sub-tabs (basic logic)
                function switchPendingSubTab(subtab) {
                    ['subtab-other', 'subtab-st', 'subtab-regular', 'subtab-sectional', 'subtab-sltr'].forEach(id => {
                        document.getElementById(id).classList.remove('active');
                    });
                    const active = {
                        'other': 'subtab-other',
                        'st': 'subtab-st',
                        'regular': 'subtab-regular',
                        'sectional': 'subtab-sectional',
                        'sltr': 'subtab-sltr'
                    }[subtab];
                    if (active) {
                        document.getElementById(active).classList.add('active');
                    }
                    // Add logic to filter table if needed
                }
                // On page load, show sub-tabs only if Pending is active
                document.addEventListener('DOMContentLoaded', function() {
                    // Detect which main tab is active
                    let activeTab = document.querySelector('.tab-active');
                    if (activeTab && activeTab.textContent.trim() === 'Pending') {
                        document.getElementById('pendingSubTabs').style.display = 'flex';
                        switchPendingSubTab('other');
                    } else {
                        document.getElementById('pendingSubTabs').style.display = 'none';
                    }
                });
            </script>
            <!-- End Sub-tabs -->
        
            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <input type="checkbox" class="rounded" id="selectAll" onchange="toggleSelectAll(this)">
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Reg. Number
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                File No
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Grantor
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Grantee
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Instrument Type
                            </th>
                           
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                LGA
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                District
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Plot Number
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Plot Size
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="cofoTableBody">
                        @forelse($approvedApplications as $app)
                        <tr class="cofo-row" data-status="{{ $app->status }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="checkbox" class="rounded">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $app->Deeds_Serial_No ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $app->fileno ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $app->Grantor ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $app->Grantee ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $app->instrument_type ?? 'N/A' }}</td>
                           
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $app->lga ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $app->district ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $app->plotNumber ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $app->size ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $app->deeds_date ? date('Y-m-d', strtotime($app->deeds_date)) : 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                              <span class="badge badge-{{ $app->status }}">{{ ucfirst($app->status) }}</span>
                            </td>
                           <td class="px-6 py-4 whitespace-nowrap text-right text-sm relative" x-data="{ 
                      open: false,
                      updatePosition() {
                        if (this.open) {
                          const button = this.$refs.actionButton;
                          const menu = this.$refs.actionMenu;
                          const rect = button.getBoundingClientRect();
                          menu.style.top = `${rect.bottom + 5}px`;
                          menu.style.left = `${rect.right - menu.offsetWidth}px`;
                        }
                      },
                      toggle() {
                        this.open = !this.open;
                        if (this.open) {
                          this.$nextTick(() => {
                            this.updatePosition();
                            // Add scroll event listener when menu is opened
                            window.addEventListener('scroll', () => this.updatePosition(), { passive: true });
                          });
                        } else {
                          // Remove scroll event listener when menu is closed
                          window.removeEventListener('scroll', () => this.updatePosition());
                        }
                      },
                      // Ensure we clean up event listeners when component is destroyed
                      init() {
                        this.$watch('open', value => {
                          if (!value) {
                            window.removeEventListener('scroll', () => this.updatePosition());
                          }
                        });
                      }
                    }">
                                
                                 

                                                          <button 
                        x-ref="actionButton"
                        @click="toggle()" 
                        class="text-gray-500 hover:text-gray-700">
                        <i data-lucide="more-vertical"></i>
                      </button>


                                     @include('instrument_registration.partials.action', ['app' => $app])
                               
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="14" class="px-6 py-10 text-center text-gray-500">
                                No instrument registrations available.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Include Modals -->
    @include('instrument_registration.partials.singleregistermodal')
    @include('instrument_registration.partials.batchregistermodal')
    
    <!-- Page Footer -->
    @include($footerPartial ?? 'admin.footer')
</div>

<!-- Debug section -->
<div id="debugInfo" class="fixed bottom-0 right-0 bg-black bg-opacity-75 text-white p-4 rounded-tl-lg max-w-lg max-h-48 overflow-auto hidden">
  <h3 class="font-bold">Debug Information</h3>
  <div id="debugContent" class="text-xs font-mono"></div>
  <button onclick="document.getElementById('debugInfo').classList.add('hidden')" class="text-xs bg-red-500 text-white px-2 py-1 rounded mt-2">Close</button>
</div>

<script>
  // Pass PHP data to JavaScript
  const serverCofoData = @json($approvedApplications);
  console.log("Server data loaded:", serverCofoData.length, "records");
  
  // Add error tracking
  window.addEventListener('error', function(e) {
    // Log to console
    console.error("JavaScript error:", e.message, "at", e.filename, "line", e.lineno);
    
    // Add to debug info if available
    const debugContent = document.getElementById('debugContent');
    if (debugContent) {
      const errorMsg = `${e.message} at ${e.filename}:${e.lineno}`;
      debugContent.innerHTML += `<div class="text-red-400">${errorMsg}</div>`;
      document.getElementById('debugInfo').classList.remove('hidden');
    }
  });
  
  // Show debug panel with Ctrl+D
  document.addEventListener('keydown', function(e) {
    if (e.ctrlKey && e.key === 'd') {
      e.preventDefault();
      const debugInfo = document.getElementById('debugInfo');
      debugInfo.classList.toggle('hidden');
      
      // Add some debug info
      const debugContent = document.getElementById('debugContent');
      if (!debugContent.hasChildNodes()) {
        try {
          debugContent.innerHTML = `
            <div>Records from server: ${serverCofoData.length}</div>
            <div>Processed records: ${cofoData ? cofoData.length : '(cofoData not defined)'}</div>
            <div>populateAvailablePropertiesTable defined: ${typeof window.populateAvailablePropertiesTable === 'function' ? 'Yes' : 'No'}</div>
            <div>First record sample: ${JSON.stringify(serverCofoData[0], null, 2).substring(0, 300)}...</div>
          `;
        } catch (err) {
          debugContent.innerHTML = `<div class="text-red-400">Error generating debug info: ${err.message}</div>`;
        }
      }
    }
  });
</script>

<!-- Include SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Include the external JavaScript file -->
<script src="{{ asset('js/instrument_registration.js') }}?v={{ time() }}"></script>

@if(session('success'))
<script>
    Swal.fire({
        title: 'Success!',
        text: "{{ session('success') }}",
        icon: 'success',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        title: 'Error!',
        text: "{{ session('error') }}",
        icon: 'error',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
</script>
@endif

@endsection



