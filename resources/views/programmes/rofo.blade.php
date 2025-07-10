@extends('layouts.app')

@section('page-title')
    {{ $PageTitle ?? __('KLAES') }}
@endsection

@section('styles')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
@endsection

@section('content')
<style>
    /* Custom DataTables styling to match design */
    .dataTables_wrapper {
        font-family: inherit;
        margin-top: 1rem;
    }

    .dataTables_length select,
    .dataTables_filter input {
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        padding: 0.5rem;
        font-size: 0.875rem;
    }

    .dataTables_length select:focus,
    .dataTables_filter input:focus {
        outline: none;
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }

    .dataTables_info {
        color: #6b7280;
        font-size: 0.875rem;
    }

    .dataTables_paginate .paginate_button {
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        padding: 0.5rem 0.75rem;
        margin: 0 0.125rem;
        background: white;
        color: #374151;
        text-decoration: none;
    }

    .dataTables_paginate .paginate_button:hover {
        background-color: #f3f4f6;
        border-color: #9ca3af;
        color: #374151;
    }

    .dataTables_paginate .paginate_button.current {
        background-color: #10b981;
        border-color: #10b981;
        color: white;
    }

    .dataTables_paginate .paginate_button.disabled {
        color: #9ca3af;
        cursor: not-allowed;
    }

    .dataTables_paginate .paginate_button.disabled:hover {
        background-color: transparent;
        border-color: #d1d5db;
        color: #9ca3af;
    }

    /* Hide default DataTables search and length controls */
    .dataTables_filter,
    .dataTables_length {
        display: none;
    }

    .badge {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 0.25rem 0.5rem;
      border-radius: 0.25rem;
      font-size: 0.75rem;
      font-weight: 500;
    }
    .badge-approved {
      background-color: #d1fae5;
      color: #059669;
    }
    .badge-pending {
      background-color: #fef3c7;
      color: #d97706;
    }
    .badge-declined {
      background-color: #fee2e2;
      color: #dc2626;
    }
    .table-header {
      background-color: #f9fafb;
      font-weight: 500;
      color: rgb(13, 136, 13);
      text-align: left;
      padding: 0.75rem 1rem;
      border-bottom: 1px solid #e5e7eb;
    }
    .table-cell {
      padding: 0.75rem 1rem;
      border-bottom: 1px solid #e5e7eb;
    }
    /* Tooltip/popup styles */
    .tooltip {
      position: relative;
      display: inline-block;
      cursor: pointer;
    }
    
    .tooltip .tooltip-content {
      visibility: hidden;
      width: 220px;
      background-color: #fff;
      color: #333;
      text-align: left;
      border-radius: 6px;
      padding: 10px;
      position: absolute;
      z-index: 1000;
      bottom: 125%;
      left: 50%;
      margin-left: -110px;
      opacity: 0;
      transition: opacity 0.3s;
      box-shadow: 0 2px 8px rgba(0,0,0,0.15);
      border: 1px solid #e5e7eb;
    }
    
    .tooltip .tooltip-content::after {
      content: "";
      position: absolute;
      top: 100%;
      left: 50%;
      margin-left: -5px;
      border-width: 5px;
      border-style: solid;
      border-color: #fff transparent transparent transparent;
    }
    
    .tooltip:hover .tooltip-content {
      visibility: visible;
      opacity: 1;
    }
    
    .info-icon {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      height: 16px;
      width: 16px;
      background-color: #e5e7eb;
      color: #4b5563;
      border-radius: 50%;
      font-size: 10px;
      margin-left: 4px;
      cursor: pointer;
    }

    /* Enhanced Dropdown menu styles with better responsiveness */
    .action-menu {
      position: fixed;
      top: 100%;
      right: 0;
      z-index: 9999;
      min-width: 200px;
      max-width: 280px;
      background: white;
      border-radius: 0.5rem;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
      border: 1px solid #e5e7eb;
      overflow: hidden;
      transform: translateY(5px);
      opacity: 0;
      visibility: hidden;
      transition: all 0.2s ease-in-out;
    }

    .action-menu.show {
      opacity: 1;
      visibility: visible;
      transform: translateY(0);
    }

    .action-menu li {
      border-bottom: 1px solid #f3f4f6;
    }

    .action-menu li:last-child {
      border-bottom: none;
    }

    .action-menu a {
      display: flex;
      align-items: center;
      padding: 0.75rem 1rem;
      color: #374151;
      text-decoration: none;
      transition: background-color 0.15s ease;
    }

    .action-menu a:hover {
      background-color: #f9fafb;
    }

    .action-menu i {
      margin-right: 0.5rem;
      flex-shrink: 0;
    }

    .table-cell.relative {
      position: relative;
    }

    /* Responsive dropdown positioning */
    @media (max-width: 768px) {
      .action-menu {
        position: fixed;
        left: 50%;
        transform: translateX(-50%) translateY(5px);
        top: auto;
        bottom: 80px;
        right: auto;
        width: 90%;
        max-width: 320px;
      }

      .action-menu.show {
        transform: translateX(-50%) translateY(0);
      }
    }

    @media (max-width: 480px) {
      .action-menu {
        width: 95%;
        bottom: 60px;
      }
    }

    /* Dropdown button hover effect */
    .dropdown-toggle {
      transition: all 0.15s ease;
    }

    .dropdown-toggle:hover {
      background-color: #f3f4f6;
      transform: scale(1.05);
    }

    /* Filter toggle styles */
    .filter-container {
        display: none;
        transition: all 0.3s ease;
        overflow: hidden;
        margin-bottom: 1rem;
    }

    .filter-container.show {
        display: block;
    }

    /* Table responsive improvements */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    @media (max-width: 768px) {
        .table-cell {
            padding: 0.5rem;
            font-size: 0.875rem;
        }
        
        .table-header {
            padding: 0.5rem;
            font-size: 0.875rem;
        }
    }
</style>
<div class="flex-1 overflow-auto">
    <!-- Header -->
    @include($headerPartial ?? 'admin.header')
    
    <!-- Main Content -->
    <div class="p-6">
    
     
        
      <!-- Unit Application  -->
    <div >
       
      <div  class="bg-white rounded-md shadow-sm border border-gray-200 p-6">
        <!-- Filter Toggle and Export Buttons -->
        <div class="flex justify-between items-center mb-4">
            <div class="flex items-center space-x-2">
                <button id="toggleFilters" class="flex items-center space-x-2 px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                    <i data-lucide="filter" class="w-4 h-4"></i>
                    <span>Filters</span>
                </button>
                
                <!-- Add search bar that's always visible -->
                <div class="relative">
                    <input 
                        type="text" 
                        id="searchInput" 
                        placeholder="Search records..." 
                        class="pl-10 pr-4 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 w-64"
                    >
                    <i data-lucide="search" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-4 h-4"></i>
                </div>
            </div>
            
            {{-- <button class="flex items-center space-x-2 px-4 py-2 border border-gray-200 rounded-md">
                <i data-lucide="download" class="w-4 h-4 text-gray-600"></i>
                <span>Export</span>
            </button> --}}
        </div>
        
        <!-- Filters Container (Hidden by Default) -->
        <div id="filterContainer" class="filter-container mb-6">
            <div class="flex flex-wrap items-center gap-4 w-full">
                <!-- Land Use Filter -->
                <div class="relative min-w-[160px]">
                    <label for="landUseFilter" class="block text-xs font-medium text-gray-700 mb-1">Land Use</label>
                    <select id="landUseFilter" class="pl-4 pr-8 py-2 w-full border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 appearance-none">
                        <option value="">All</option>
                        <option value="Residential">Residential</option>
                        <option value="Commercial">Commercial</option>
                        <option value="Industrial">Industrial</option>
                        <option value="Mixed Use">Mixed Use</option>
                    </select>
                    <i data-lucide="chevron-down" class="absolute right-3 top-[60%] transform -translate-y-1/2 text-gray-400 w-4 h-4"></i>
                </div>
                
                <!-- Date Range Filter -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <div>
                        <label for="dateFrom" class="block text-xs font-medium text-gray-700 mb-1">Date From</label>
                        <input type="date" id="dateFrom" class="pl-4 pr-2 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div>
                        <label for="dateTo" class="block text-xs font-medium text-gray-700 mb-1">Date To</label>
                        <input type="date" id="dateTo" class="pl-4 pr-2 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                </div>
                
                <!-- Apply and Reset Buttons -->
                <div class="flex items-end space-x-2">
                    <button id="applyFilter" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md">
                        Apply Filters
                    </button>
                    <button id="resetFilter" class="border border-gray-300 hover:bg-gray-100 text-gray-700 px-4 py-2 rounded-md">
                        Reset
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Tab Navigation -->
        <div class="mb-4 border-b border-gray-200">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center">
                <li class="mr-2">
                    <button id="not-generated-tab" onclick="showRofoTab('not-generated')" class="inline-block p-4 border-b-2 border-green-600 rounded-t-lg active text-green-600">
                        Not Generated RoFO
                    </button>
                </li>
                <li class="mr-2">
                    <button id="generated-tab" onclick="showRofoTab('generated')" class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300">
                        Generated RoFO
                    </button>
                </li>
            </ul>
        </div>
        
        <!-- Not Generated RoFO Table -->
        <div id="not-generated-table" >
          <table id="notGeneratedRofoTable" class="min-w-full divide-y divide-gray-200">
            <thead>
              <tr class="text-xs">
                <th class="table-header">ST FileNo</th>
                <th class="table-header">SchemeNo</th>
                <th class="table-header">Unit Owner</th>
                <th class="table-header">LGA</th>
                <th class="table-header">Block/Floor/Unit</th>
                <th class="table-header">Land Use</th>
                <th class="table-header">Date Created</th>
                <th class="table-header">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @forelse($subapplications->filter(function($app) { return empty($app->rofo_no); }) as $unitApplication)
              <tr data-land-use="{{ strtolower($unitApplication->land_use ?? '') }}" data-date="{{ $unitApplication->created_at ? date('Y-m-d', strtotime($unitApplication->created_at)) : '' }}" class="text-xs">
                <td class="table-cell">{{ $unitApplication->fileno ?? 'N/A' }}</td>
                <td class="table-cell">{{ $unitApplication->scheme_no ?? 'N/A' }}</td>
                <td class="table-cell">
                      @if(!empty($unitApplication->multiple_owners_names) && json_decode($unitApplication->multiple_owners_names))
                          @php
                              $owners = json_decode($unitApplication->multiple_owners_names);
                              $firstOwner = isset($owners[0]) ? $owners[0] : 'N/A';
                              $allOwners = json_encode($owners);
                          @endphp
                          {{ $firstOwner }}
                          <span class="info-icon" onclick="showOwners({{ $allOwners }})">i</span>
                      @else
                          {{ $unitApplication->owner_name ?? 'N/A' }}
                      @endif
                </td>
                <td class="table-cell">{{ $unitApplication->property_lga ?? 'N/A' }}</td>
                <td class="table-cell">{{ $unitApplication->block_number ?? '' }}/{{ $unitApplication->floor_number ?? '' }}/{{ $unitApplication->unit_number ?? '' }}</td>
                <td class="table-cell">{{ $unitApplication->land_use ?? 'N/A' }}</td>
                <td class="table-cell">{{ $unitApplication->created_at ? date('d-m-Y', strtotime($unitApplication->created_at)) : 'N/A' }}</td>
                <td class="table-cell relative">
                    <!-- Dropdown Toggle Button -->
                    <button type="button" class="p-2 hover:bg-gray-100 focus:outline-none rounded-full" onclick="customToggleDropdown(this, event)">
                      <i data-lucide="more-horizontal" class="w-5 h-5"></i>
                    </button>
                    
                    <!-- Dropdown Menu for Not Generated RoFO -->
                    <ul class="action-menu">
                      <li>
                        <a href="{{ route('sectionaltitling.viewrecorddetail_sub', $unitApplication->id) }}" class="block w-full text-left px-4 py-2 hover:bg-gray-100 flex items-center space-x-2">
                          <i data-lucide="eye" class="w-4 h-4 text-blue-600"></i>
                          <span>View Record</span>
                        </a>
                      </li>
                      {{-- <li>
                        <a href="#" class="block w-full text-left px-4 py-2 hover:bg-gray-100 flex items-center space-x-2">
                          <i data-lucide="edit" class="w-4 h-4 text-green-600"></i>
                          <span>Edit Record</span>
                        </a>
                      </li> --}}
                      <li>
                        <a href="{{ route('programmes.generate_rofo', $unitApplication->id) }}" class="block w-full text-left px-4 py-2 hover:bg-gray-100 flex items-center space-x-2">
                          <i data-lucide="file-plus" class="w-4 h-4 text-indigo-600"></i>
                          <span>Generate RoFO</span>
                        </a>
                      </li>
                    </ul>
                </td>
              </tr>
              @empty
              <tr id="noRecordsNotGeneratedRow" class="hidden">
                <td colspan="8" class="table-cell text-center py-4 text-gray-500">No matching records found</td>
              </tr>
              <tr id="emptyNotGeneratedRow">
                <td colspan="8" class="table-cell text-center py-4 text-gray-500">No records pending RoFO generation</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <!-- Generated RoFO Table -->
        <div id="generated-table" class="table-responsive hidden">
          <table id="generatedRofoTable" class="min-w-full divide-y divide-gray-200">
            <thead>
              <tr class="text-xs">
                <th class="table-header">ST FileNo</th>
                <th class="table-header">RoFO No</th>
                <th class="table-header">SchemeNo</th>
                <th class="table-header">Unit Owner</th>
                <th class="table-header">LGA</th>
                <th class="table-header">Block/Floor/Unit</th>
                <th class="table-header">Land Use</th>
                <th class="table-header">Date Created</th>
                <th class="table-header">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @forelse($subapplications->filter(function($app) { return !empty($app->rofo_no); }) as $unitApplication)
              <tr data-land-use="{{ strtolower($unitApplication->land_use ?? '') }}" data-date="{{ $unitApplication->created_at ? date('Y-m-d', strtotime($unitApplication->created_at)) : '' }}" class="text-xs">
                <td class="table-cell">{{ $unitApplication->fileno ?? 'N/A' }}</td>
                <td class="table-cell">{{ $unitApplication->rofo_no ?? 'N/A' }}</td>
                <td class="table-cell">{{ $unitApplication->scheme_no ?? 'N/A' }}</td>
                <td class="table-cell">
                      @if(!empty($unitApplication->multiple_owners_names) && json_decode($unitApplication->multiple_owners_names))
                          @php
                              $owners = json_decode($unitApplication->multiple_owners_names);
                              $firstOwner = isset($owners[0]) ? $owners[0] : 'N/A';
                              $allOwners = json_encode($owners);
                          @endphp
                          {{ $firstOwner }}
                          <span class="info-icon" onclick="showOwners({{ $allOwners }})">i</span>
                      @else
                          {{ $unitApplication->owner_name ?? 'N/A' }}
                      @endif
                </td>
                <td class="table-cell">{{ $unitApplication->property_lga ?? 'N/A' }}</td>
                <td class="table-cell">{{ $unitApplication->block_number ?? '' }}/{{ $unitApplication->floor_number ?? '' }}/{{ $unitApplication->unit_number ?? '' }}</td>
                <td class="table-cell">{{ $unitApplication->land_use ?? 'N/A' }}</td>
                <td class="table-cell">{{ $unitApplication->created_at ? date('d-m-Y', strtotime($unitApplication->created_at)) : 'N/A' }}</td>
                <td class="table-cell relative">
                    <!-- Dropdown Toggle Button -->
                    <button type="button" class="p-2 hover:bg-gray-100 focus:outline-none rounded-full" onclick="customToggleDropdown(this, event)">
                      <i data-lucide="more-horizontal" class="w-5 h-5"></i>
                    </button>
                    
                    <!-- Dropdown Menu For Generated RoFO -->
                    <ul class="action-menu">
                      <li>
                        <a href="{{ route('sectionaltitling.viewrecorddetail_sub', $unitApplication->id) }}" class="block w-full text-left px-4 py-2 hover:bg-gray-100 flex items-center space-x-2">
                          <i data-lucide="eye" class="w-4 h-4 text-blue-600"></i>
                          <span>View Application</span>
                        </a>
                      </li>
                      {{-- <li>
                        <a href="#" class="block w-full text-left px-4 py-2 hover:bg-gray-100 flex items-center space-x-2">
                          <i data-lucide="edit" class="w-4 h-4 text-green-600"></i>
                          <span>Edit Record</span>
                        </a>
                      </li> --}}
                      <li>
                        <a href="{{ route('programmes.view_rofo', $unitApplication->id) }}" class="block w-full text-left px-4 py-2 hover:bg-gray-100 flex items-center space-x-2">
                          <i data-lucide="clipboard" class="w-4 h-4 text-amber-600"></i>
                          <span>View RoFO</span>
                        </a>
                      </li>
                      {{-- <li>
                        <a href="{{ route('programmes.generate_rofo', $unitApplication->id) }}?edit=yes" class="block w-full text-left px-4 py-2 hover:bg-gray-100 flex items-center space-x-2">
                          <i data-lucide="edit-3" class="w-4 h-4 text-purple-600"></i>
                          <span>Edit RoFO</span>
                        </a>
                      </li> --}}
                    </ul>
                </td>
              </tr>
              @empty
              <tr id="noRecordsGeneratedRow" class="hidden">
                <td colspan="9" class="table-cell text-center py-4 text-gray-500">No matching records found</td>
              </tr>
              <tr id="emptyGeneratedRow">
                <td colspan="9" class="table-cell text-center py-4 text-gray-500">No generated RoFO applications found</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
      </div>
    </div>
    
    <!-- Page Footer -->
    @include($footerPartial ?? 'admin.footer')
  </div>
  <!-- DataTables JS -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

  <script>
  // Global variables for DataTables
  let notGeneratedTable, generatedTable;
  let currentActiveTab = 'not-generated';

  function showOwners(owners) {
    let ownersList = '';
    owners.forEach(owner => {
      ownersList += `<li>${owner}</li>`;
    });
    
    Swal.fire({
      title: 'All Owners',
      html: `<ul class="text-left list-disc list-inside">${ownersList}</ul>`,
      icon: 'info',
      confirmButtonText: 'Close',
      confirmButtonColor: '#10B981'
    });
  }
  
  // Enhanced dropdown functionality with better responsiveness
  function customToggleDropdown(button, event) {
    event.stopPropagation();
    
    // Close all other dropdowns first
    document.querySelectorAll('.action-menu').forEach(menu => {
      menu.classList.remove('show');
      menu.classList.add('hidden');
    });
    
    // Get the dropdown menu
    const dropdown = button.nextElementSibling;
    
    // Toggle visibility
    if (dropdown.classList.contains('hidden')) {
      dropdown.classList.remove('hidden');
      
      // Add show class for animation
      setTimeout(() => {
        dropdown.classList.add('show');
      }, 10);
      
      // Position dropdown responsively
      positionDropdown(dropdown, button);
    } else {
      dropdown.classList.remove('show');
      setTimeout(() => {
        dropdown.classList.add('hidden');
      }, 200);
    }
  }

  function positionDropdown(dropdown, button) {
    const rect = button.getBoundingClientRect();
    const viewportHeight = window.innerHeight;
    const viewportWidth = window.innerWidth;
    
    // Reset positioning
    dropdown.style.position = 'fixed';
    dropdown.style.top = '';
    dropdown.style.bottom = '';
    dropdown.style.left = '';
    dropdown.style.right = '';
    dropdown.style.transform = '';
    dropdown.style.width = '';
    dropdown.style.maxWidth = '';
    
    if (viewportWidth <= 768) {
      // Mobile positioning - center at bottom
      dropdown.style.left = '50%';
      dropdown.style.bottom = '80px';
      dropdown.style.transform = 'translateX(-50%)';
      dropdown.style.width = '90%';
      dropdown.style.maxWidth = '320px';
    } else {
      // Desktop positioning - always use fixed positioning to avoid overflow issues
      const dropdownHeight = 200; // Approximate height of dropdown
      
      // Position horizontally - align to the right of the button
      const rightSpace = viewportWidth - rect.right;
      if (rightSpace >= 200) {
        // Enough space on the right
        dropdown.style.left = rect.right - 200 + 'px';
      } else {
        // Not enough space on the right, align to the left of the button
        dropdown.style.left = Math.max(10, rect.left - 200) + 'px';
      }
      
      // Position vertically
      if (rect.bottom + dropdownHeight > viewportHeight - 20) {
        // Position above button
        dropdown.style.top = Math.max(10, rect.top - dropdownHeight) + 'px';
      } else {
        // Position below button
        dropdown.style.top = rect.bottom + 5 + 'px';
      }
      
      dropdown.style.width = '200px';
    }
  }
  
  // Close dropdowns when clicking elsewhere
  document.addEventListener('click', function() {
    document.querySelectorAll('.action-menu').forEach(menu => {
      menu.classList.remove('show');
      setTimeout(() => {
        menu.classList.add('hidden');
      }, 200);
    });
  });

  // Handle window resize for dropdown repositioning
  window.addEventListener('resize', function() {
    document.querySelectorAll('.action-menu:not(.hidden)').forEach(menu => {
      const button = menu.previousElementSibling;
      positionDropdown(menu, button);
    });
  });

  function showRofoTab(tabId) {
    currentActiveTab = tabId;
    
    // Hide all tab contents
    document.getElementById('generated-table').classList.add('hidden');
    document.getElementById('not-generated-table').classList.add('hidden');
    
    // Reset all tab buttons
    document.getElementById('generated-tab').classList.remove('border-green-600', 'text-green-600');
    document.getElementById('generated-tab').classList.add('border-transparent');
    document.getElementById('not-generated-tab').classList.remove('border-green-600', 'text-green-600');
    document.getElementById('not-generated-tab').classList.add('border-transparent');
    
    // Show selected tab content
    document.getElementById(tabId + '-table').classList.remove('hidden');
    
    // Highlight active tab button
    document.getElementById(tabId + '-tab').classList.remove('border-transparent');
    document.getElementById(tabId + '-tab').classList.add('border-green-600', 'text-green-600');
    
    // Initialize DataTable for the visible table if not already initialized
    if (tabId === 'not-generated' && !notGeneratedTable) {
      initializeNotGeneratedTable();
    } else if (tabId === 'generated' && !generatedTable) {
      initializeGeneratedTable();
    }
    
    // Refresh the current table
    refreshCurrentTable();
  }

  function initializeNotGeneratedTable() {
    if ($.fn.DataTable.isDataTable('#notGeneratedRofoTable')) {
      $('#notGeneratedRofoTable').DataTable().destroy();
    }
    
    notGeneratedTable = $('#notGeneratedRofoTable').DataTable({
      responsive: true,
      pageLength: 10,
      lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
      dom: 'Bfrtip',
      buttons: [
        {
          extend: 'excel',
          text: 'Export Excel',
          className: 'btn btn-success btn-sm'
        },
        {
          extend: 'pdf',
          text: 'Export PDF',
          className: 'btn btn-danger btn-sm'
        }
      ],
      columnDefs: [
        { orderable: false, targets: -1 }, // Disable sorting on Actions column
        { className: 'text-center', targets: -1 }
      ],
      language: {
        search: "",
        searchPlaceholder: "Search records...",
        lengthMenu: "Show _MENU_ entries",
        info: "Showing _START_ to _END_ of _TOTAL_ entries",
        infoEmpty: "Showing 0 to 0 of 0 entries",
        infoFiltered: "(filtered from _MAX_ total entries)",
        paginate: {
          first: "First",
          last: "Last",
          next: "Next",
          previous: "Previous"
        }
      },
      initComplete: function() {
        // Hide default search box since we have custom search
        $('.dataTables_filter').hide();
      }
    });
  }

  function initializeGeneratedTable() {
    if ($.fn.DataTable.isDataTable('#generatedRofoTable')) {
      $('#generatedRofoTable').DataTable().destroy();
    }
    
    generatedTable = $('#generatedRofoTable').DataTable({
      responsive: true,
      pageLength: 10,
      lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
      dom: 'Bfrtip',
      buttons: [
        {
          extend: 'excel',
          text: 'Export Excel',
          className: 'btn btn-success btn-sm'
        },
        {
          extend: 'pdf',
          text: 'Export PDF',
          className: 'btn btn-danger btn-sm'
        }
      ],
      columnDefs: [
        { orderable: false, targets: -1 }, // Disable sorting on Actions column
        { className: 'text-center', targets: -1 }
      ],
      language: {
        search: "",
        searchPlaceholder: "Search records...",
        lengthMenu: "Show _MENU_ entries",
        info: "Showing _START_ to _END_ of _TOTAL_ entries",
        infoEmpty: "Showing 0 to 0 of 0 entries",
        infoFiltered: "(filtered from _MAX_ total entries)",
        paginate: {
          first: "First",
          last: "Last",
          next: "Next",
          previous: "Previous"
        }
      },
      initComplete: function() {
        // Hide default search box since we have custom search
        $('.dataTables_filter').hide();
      }
    });
  }

  function refreshCurrentTable() {
    if (currentActiveTab === 'not-generated' && notGeneratedTable) {
      notGeneratedTable.draw();
    } else if (currentActiveTab === 'generated' && generatedTable) {
      generatedTable.draw();
    }
  }

  function applyFilters() {
    const searchTerm = document.getElementById('searchInput').value;
    const landUse = document.getElementById('landUseFilter').value;
    const dateFrom = document.getElementById('dateFrom').value;
    const dateTo = document.getElementById('dateTo').value;
    
    // Apply search to current DataTable
    if (currentActiveTab === 'not-generated' && notGeneratedTable) {
      notGeneratedTable.search(searchTerm).draw();
    } else if (currentActiveTab === 'generated' && generatedTable) {
      generatedTable.search(searchTerm).draw();
    }
    
    // Apply custom filters (land use, date range)
    applyCustomFilters(landUse, dateFrom, dateTo);
  }

  function applyCustomFilters(landUse, dateFrom, dateTo) {
    // Custom filtering logic for land use and date range
    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
      // Only apply to our tables
      if (settings.nTable.id !== 'notGeneratedRofoTable' && settings.nTable.id !== 'generatedRofoTable') {
        return true;
      }
      
      // Land use filter (column index 5 for both tables)
      const landUseColumn = data[5] || '';
      if (landUse && landUseColumn.toLowerCase().indexOf(landUse.toLowerCase()) === -1) {
        return false;
      }
      
      // Date filter (column index 6 for not-generated, 7 for generated)
      const dateColumnIndex = settings.nTable.id === 'generatedRofoTable' ? 7 : 6;
      const dateColumn = data[dateColumnIndex] || '';
      
      if (dateFrom || dateTo) {
        // Parse date from DD-MM-YYYY format
        const dateParts = dateColumn.split('-');
        if (dateParts.length === 3) {
          const rowDate = new Date(dateParts[2], dateParts[1] - 1, dateParts[0]);
          
          if (dateFrom) {
            const fromDate = new Date(dateFrom);
            if (rowDate < fromDate) return false;
          }
          
          if (dateTo) {
            const toDate = new Date(dateTo);
            if (rowDate > toDate) return false;
          }
        }
      }
      
      return true;
    });
    
    // Redraw the current table
    refreshCurrentTable();
  }

  // Document ready function
  $(document).ready(function() {
    // Initialize the first tab
    showRofoTab('not-generated');
    
    // Filter functionality
    const toggleFiltersBtn = document.getElementById('toggleFilters');
    const filterContainer = document.getElementById('filterContainer');
    const applyFilterBtn = document.getElementById('applyFilter');
    const resetFilterBtn = document.getElementById('resetFilter');
    const searchInput = document.getElementById('searchInput');
    
    // Toggle filters visibility
    toggleFiltersBtn.addEventListener('click', function() {
      filterContainer.classList.toggle('show');
    });
    
    // Apply filters when button is clicked
    applyFilterBtn.addEventListener('click', function() {
      applyFilters();
    });
    
    // Reset filters
    resetFilterBtn.addEventListener('click', function() {
      document.getElementById('landUseFilter').value = '';
      document.getElementById('dateFrom').value = '';
      document.getElementById('dateTo').value = '';
      document.getElementById('searchInput').value = '';
      
      // Clear custom filters
      $.fn.dataTable.ext.search.pop();
      
      // Clear search and redraw
      if (currentActiveTab === 'not-generated' && notGeneratedTable) {
        notGeneratedTable.search('').draw();
      } else if (currentActiveTab === 'generated' && generatedTable) {
        generatedTable.search('').draw();
      }
    });
    
    // Real-time search
    let searchTimeout;
    searchInput.addEventListener('input', function() {
      clearTimeout(searchTimeout);
      searchTimeout = setTimeout(function() {
        const searchTerm = searchInput.value;
        if (currentActiveTab === 'not-generated' && notGeneratedTable) {
          notGeneratedTable.search(searchTerm).draw();
        } else if (currentActiveTab === 'generated' && generatedTable) {
          generatedTable.search(searchTerm).draw();
        }
      }, 300);
    });
  });
  </script>
@endsection



