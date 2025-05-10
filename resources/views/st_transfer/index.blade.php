@extends('layouts.app')

@section('page-title')
    {{ $PageTitle ?? __('KLAS') }}
@endsection

@section('header-scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/lucide@latest"></script>
@endsection

@section('content')
@include('st_registration.partials.css')

<div class="flex-1 overflow-auto">
    <!-- Header -->
    @include($headerPartial ?? 'admin.header')
    
    <!-- Main Content -->
    <div class="container mx-auto py-6 space-y-6 px-4">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
          <div>
           
            
          </div>
          <div class="dropdown">
            <button onclick="toggleDropdown()" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg flex items-center gap-2">
              Register CofO <i class="fas fa-chevron-down text-xs"></i>
            </button>
            <div id="registerDropdown" class="dropdown-content">
              <a href="#" onclick="openSingleRegisterModal()" class="whitespace-nowrap"><i class="fas fa-file-alt mr-2"></i> Register Single CofO</a>
              <a href="#" onclick="openBatchRegisterModal()" class="whitespace-nowrap"><i class="fas fa-upload mr-2"></i> Batch Register CofOs</a>
            </div>
          </div>
        </div>
    
        <!-- Stats Cards -->
        @include('st_transfer.partials.statistic_card')
    
        <!-- Main Content Card -->
        <div class="bg-white rounded-lg shadow">
          <div class="p-4 border-b">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
              <h2 class="text-lg font-semibold">Sectional Title Certificates of Occupancy</h2>
              <div class="flex flex-col sm:flex-row gap-2 sm:items-center">
                <div class="flex gap-2">
                  <div class="relative w-full sm:w-64">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400 text-sm"></i>
                    <input type="search" placeholder="Search FileNO..." class="w-full pl-8 pr-3 py-2 border rounded-md" id="searchInput">
                  </div>
                  <!-- Removed filter dropdown as we're only searching by ST FileNO -->
                </div>
                <button class="flex items-center gap-1 whitespace-nowrap border rounded-md px-3 py-2 hover:bg-gray-50">
                  <i class="fas fa-download text-sm"></i> Export
                </button>
              </div>
            </div>
          </div>
          <div class="p-4">
            <!-- Tabs -->
            <div class="border-b mb-6">
              <ul class="flex flex-wrap -mb-px text-sm font-medium text-center">
                <li class="mr-2">
                  <a href="#"
                     onclick="switchTab('pending', this)"
                     class="group inline-flex items-center px-4 py-3 border-b-2 rounded-t-lg transition-all duration-200 ease-in-out hover:text-blue-600 hover:border-blue-300 text-gray-600 border-transparent tab-item">
                     <span class="flex items-center">Pending</span>
                     <span class="ml-2 bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                       {{ $pendingCount }}
                     </span>
                  </a>
                </li>
                <li class="mr-2">
                  <a href="#"
                     onclick="switchTab('registered', this)"
                     class="group inline-flex items-center px-4 py-3 border-b-2 rounded-t-lg transition-all duration-200 ease-in-out hover:text-green-600 hover:border-green-300 text-gray-600 border-transparent tab-item">
                     <span class="flex items-center">Registered</span>
                     <span class="ml-2 bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                       {{ $registeredCount }}
                     </span>
                  </a>
                </li>
                <li class="mr-2">
                  <a href="#"
                     onclick="switchTab('rejected', this)"
                     class="group inline-flex items-center px-4 py-3 border-b-2 rounded-t-lg transition-all duration-200 ease-in-out hover:text-red-600 hover:border-red-300 text-gray-600 border-transparent tab-item">
                     <span class="flex items-center">Rejected</span>
                     <span class="ml-2 bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                       {{ $rejectedCount }}
                     </span>
                  </a>
                </li>
                <li class="mr-2">
                  <a href="#"
                     onclick="switchTab('all', this)"
                     class="group inline-flex items-center px-4 py-3 border-b-2 rounded-t-lg transition-all duration-200 ease-in-out hover:text-indigo-600 hover:border-indigo-300 text-gray-600 border-transparent tab-item">
                     <span class="flex items-center">All CofOs</span>
                  </a>
                </li>
              </ul>
            </div>
    
            <!-- Table -->
            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500  tracking-wider">
                      <input type="checkbox" class="rounded" onchange="toggleSelectAll(this)">
                    </th>
                     
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500  tracking-wider">
                      File No
                    </th>
                    
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500  tracking-wider">
                      Units
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500  tracking-wider">
                      Blocks
                    </th> 
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500  tracking-wider">
                      Sections
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500  tracking-wider">
                      Owner
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500  tracking-wider">
                      Property Description
                    </th>

                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500  tracking-wider">
                      Reg.No
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500  tracking-wider">
                      Reg. Time
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500  tracking-wider">
                      Reg. Date
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500  tracking-wider">
                      Reg.By
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500  tracking-wider">
                      Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500  tracking-wider">
                      Actions
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="cofoTableBody">
                  @foreach($approvedApplications as $app)
                  <tr class="cofo-row" data-status="{{ $app->status }}">
                    <td class="px-6 py-4 whitespace-nowrap">
                      <input type="checkbox" class="rounded">
                    </td>
                    
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{ $app->fileno }}</td>
                    
                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $app->NoOfUnits }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $app->NoOfBlocks ?: 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $app->NoOfSections ?: 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $app->owner_name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $app->property_description }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ !empty($app->Deeds_Serial_No) ? $app->Deeds_Serial_No : 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ !empty($app->deeds_time) ? $app->deeds_time : 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $app->deeds_date ? date('Y-m-d', strtotime($app->deeds_date)) : 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                      @if($app->status === 'pending')
                        N/A
                      @else
                        {{ !empty($app->reg_creator_name) ? $app->reg_creator_name : 'System' }}
                      @endif
                    </td>
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
                    
                      @include('st_transfer.partials.action')
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            
            <!-- Pagination -->
            <div class="flex items-center justify-between border-t border-gray-200 px-4 py-3 sm:px-6 mt-4">
              <div class="flex-1 flex justify-between sm:hidden">
                <button class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                  Previous
                </button>
                <button class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                  Next
                </button>
              </div>
              <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                  <p class="text-sm text-gray-700">
                    Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span class="font-medium">42</span> results
                  </p>
                </div>
                <div>
                  <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                    <button class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                      <span class="sr-only">Previous</span>
                      <i class="fas fa-chevron-left text-xs"></i>
                    </button>
                    <button class="bg-blue-50 border-blue-500 text-blue-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                      1
                    </button>
                    <button class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                      2
                    </button>
                    <button class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 hidden md:inline-flex relative items-center px-4 py-2 border text-sm font-medium">
                      3
                    </button>
                    <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                      ...
                    </span>
                    <button class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                      5
                    </button>
                    <button class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                      <span class="sr-only">Next</span>
                      <i class="fas fa-chevron-right text-xs"></i>
                    </button>
                  </nav>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    
    
     {{-- Include Modals --}}
        @include('st_transfer.partials.singleregistermodal')
        @include('st_transfer.partials.batchregistermodal')
    <!-- Page Footer -->
    @include($footerPartial ?? 'admin.footer')
</div>

<!-- Add this near the top of your script section -->
<script>
  // Error handling function
  function handleFetchError(response) {
    if (!response.ok) {
      console.error(`HTTP error ${response.status}`);
      return response.text().then(text => {
        try {
          // Try to parse as JSON first
          const json = JSON.parse(text);
          throw new Error(json.error || `HTTP error ${response.status}`);
        } catch (e) {
          // If it's not JSON, it's probably an HTML error page
          console.error('Response was not JSON:', text);
          throw new Error(`Server error: HTTP ${response.status}. Check console for details.`);
        }
      });
    }
    return response.json();
  }

  // Pass PHP data to JavaScript with error checking
  const serverCofoData = @json($approvedApplications ?? []);
</script>

<!-- Include SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Include the external JavaScript file -->
<script src="{{ asset('js/st_transfer.js') }}?v={{ time() }}"></script>

<!-- Debug information in dev mode -->
@if(config('app.debug'))
<div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4" role="alert">
  <p class="font-bold">Debug Mode</p>
  <p>Laravel debug mode is enabled. Check logs for detailed error information.</p>
  <p>Laravel Version: {{ app()->version() }}</p>
  <p>PHP Version: {{ phpversion() }}</p>
</div>
@endif

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

@section('footer-scripts')
<script>
  // Initialize Lucide icons after page load
  document.addEventListener('DOMContentLoaded', function() {
    lucide.createIcons();
  });
</script>
@endsection

@endsection



