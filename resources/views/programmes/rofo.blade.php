@extends('layouts.app')

@section('page-title')
    {{ $PageTitle ?? __('KLAS') }}
@endsection

@section('styles')

@endsection

@section('content')
<style>

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

    /* Dropdown menu styles */
    .action-menu {
      position: absolute;
      top: 100%;
      right: 0;
      z-index: 50;
      min-width: 200px;
      max-width: 100%;
      background: white;
      border-radius: 0.375rem;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
      border: 1px solid #e5e7eb;
    }

    .table-cell.relative {
      position: relative;
    }

    @media (max-width: 640px) {
      .action-menu {
        position: fixed;
        left: 50%;
        transform: translateX(-50%);
        top: auto;
        bottom: 20px;
        right: auto;
        width: 90%;
      }
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
            
            <button class="flex items-center space-x-2 px-4 py-2 border border-gray-200 rounded-md">
                <i data-lucide="download" class="w-4 h-4 text-gray-600"></i>
                <span>Export</span>
            </button>
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
                    <ul class="action-menu z-50 bg-white border rounded-lg shadow-lg hidden w-56">
                      <li>
                        <a href="{{ route('sectionaltitling.viewrecorddetail_sub', $unitApplication->id) }}" class="block w-full text-left px-4 py-2 hover:bg-gray-100 flex items-center space-x-2">
                          <i data-lucide="eye" class="w-4 h-4 text-blue-600"></i>
                          <span>View Record</span>
                        </a>
                      </li>
                      <li>
                        <a href="#" class="block w-full text-left px-4 py-2 hover:bg-gray-100 flex items-center space-x-2">
                          <i data-lucide="edit" class="w-4 h-4 text-green-600"></i>
                          <span>Edit Record</span>
                        </a>
                      </li>
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
        <div id="generated-table" class="overflow-x-auto hidden">
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
                    <ul class="action-menu z-50 bg-white border rounded-lg shadow-lg hidden w-56">
                      <li>
                        <a href="{{ route('sectionaltitling.viewrecorddetail_sub', $unitApplication->id) }}" class="block w-full text-left px-4 py-2 hover:bg-gray-100 flex items-center space-x-2">
                          <i data-lucide="eye" class="w-4 h-4 text-blue-600"></i>
                          <span>View Record</span>
                        </a>
                      </li>
                      <li>
                        <a href="#" class="block w-full text-left px-4 py-2 hover:bg-gray-100 flex items-center space-x-2">
                          <i data-lucide="edit" class="w-4 h-4 text-green-600"></i>
                          <span>Edit Record</span>
                        </a>
                      </li>
                      <li>
                        <a href="{{ route('programmes.view_rofo', $unitApplication->id) }}" class="block w-full text-left px-4 py-2 hover:bg-gray-100 flex items-center space-x-2">
                          <i data-lucide="clipboard" class="w-4 h-4 text-amber-600"></i>
                          <span>View RoFO</span>
                        </a>
                      </li>
                      <li>
                        <a href="{{ route('programmes.generate_rofo', $unitApplication->id) }}?edit=yes" class="block w-full text-left px-4 py-2 hover:bg-gray-100 flex items-center space-x-2">
                          <i data-lucide="edit-3" class="w-4 h-4 text-purple-600"></i>
                          <span>Edit RoFO</span>
                        </a>
                      </li>
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
  <script>
      function showTab(tabId) {
    // Hide all tab contents
    document.getElementById('primary-survey').classList.add('hidden');
    document.getElementById('unit-survey').classList.add('hidden');
    
    // Reset all tab buttons
    document.getElementById('primary-survey-tab').classList.remove('bg-green-600', 'text-white');
    document.getElementById('primary-survey-tab').classList.add('bg-white', 'text-gray-700', 'border', 'border-gray-200');
    document.getElementById('unit-survey-tab').classList.remove('bg-green-600', 'text-white');
    document.getElementById('unit-survey-tab').classList.add('bg-white', 'text-gray-700', 'border', 'border-gray-200');
    
    // Show selected tab content
    document.getElementById(tabId).classList.remove('hidden');
    
    // Highlight active tab button
    document.getElementById(tabId + '-tab').classList.remove('bg-white', 'text-gray-700', 'border', 'border-gray-200');
    document.getElementById(tabId + '-tab').classList.add('bg-green-600', 'text-white');
  }
  
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
  
  // Existing customToggleDropdown function (if it exists)
  function customToggleDropdown(button, event) {
    // Prevent the click from propagating to the document
    event.stopPropagation();
    
    // Close all other dropdowns first
    document.querySelectorAll('.action-menu').forEach(menu => {
      menu.classList.add('hidden');
    });
    
    // Toggle the visibility of the dropdown menu
    const dropdown = button.nextElementSibling;
    dropdown.classList.toggle('hidden');
    
    // Ensure correct positioning for all screen sizes
    if (window.innerWidth <= 640) {
      // Mobile view - bottom centered
      dropdown.style.position = 'fixed';
      dropdown.style.left = '50%';
      dropdown.style.transform = 'translateX(-50%)';
      dropdown.style.bottom = '20px';
      dropdown.style.top = 'auto'; 
      dropdown.style.right = 'auto';
    } else {
      // Desktop view - position relative to button
      dropdown.style.position = 'absolute';
      dropdown.style.top = '100%';
      dropdown.style.right = '0';
      dropdown.style.left = 'auto';
      dropdown.style.transform = 'none';
    }
  }
  
  // Close dropdowns when clicking elsewhere
  document.addEventListener('click', function() {
    document.querySelectorAll('.action-menu').forEach(menu => {
      menu.classList.add('hidden');
    });
  });

  // Table filtering functionality
  document.addEventListener('DOMContentLoaded', function() {
    const toggleFiltersBtn = document.getElementById('toggleFilters');
    const filterContainer = document.getElementById('filterContainer');
    const applyFilterBtn = document.getElementById('applyFilter');
    const resetFilterBtn = document.getElementById('resetFilter');
    const landUseFilter = document.getElementById('landUseFilter');
    const dateFromFilter = document.getElementById('dateFrom');
    const dateToFilter = document.getElementById('dateTo');
    const searchInput = document.getElementById('searchInput');
    const tableRows = document.querySelectorAll('#unitApplicationTable tbody tr:not(#noRecordsRow):not(#emptyRow)');
    const noRecordsRow = document.getElementById('noRecordsRow');
    const emptyRow = document.getElementById('emptyRow');
    
    // Toggle filters visibility
    toggleFiltersBtn.addEventListener('click', function() {
        filterContainer.classList.toggle('show');
    });
    
    // Apply filters when button is clicked
    applyFilterBtn.addEventListener('click', function() {
      applyFilters();
    });
    
    // Reset filters when reset button is clicked
    resetFilterBtn.addEventListener('click', function() {
      landUseFilter.value = '';
      dateFromFilter.value = '';
      dateToFilter.value = '';
      applyFilters();
    });
    
    // Apply search on typing with small delay
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            applyFilters();
        }, 300);
    });
    
    function applyFilters() {
      const landUse = landUseFilter.value.toLowerCase();
      const dateFrom = dateFromFilter.value ? new Date(dateFromFilter.value) : null;
      const dateTo = dateToFilter.value ? new Date(dateToFilter.value) : null;
      const searchTerm = searchInput.value.toLowerCase().trim();
      
      let visibleRowCount = 0;
      
      tableRows.forEach(row => {
        const rowLandUse = row.getAttribute('data-land-use');
        const rowDate = row.getAttribute('data-date') ? new Date(row.getAttribute('data-date')) : null;
        const rowText = row.textContent.toLowerCase();
        
        let showRow = true;
        
        // Apply search filter if specified
        if (searchTerm && !rowText.includes(searchTerm)) {
            showRow = false;
        }
        
        // Apply land use filter if specified
        if (showRow && landUse && rowLandUse && !rowLandUse.includes(landUse)) {
          showRow = false;
        }
        
        // Apply date from filter if specified
        if (showRow && dateFrom && rowDate && rowDate < dateFrom) {
          showRow = false;
        }
        
        // Apply date to filter if specified
        if (showRow && dateTo && rowDate && rowDate > dateTo) {
          showRow = false;
        }
        
        // Show or hide row based on filters
        row.style.display = showRow ? '' : 'none';
        
        if (showRow) {
          visibleRowCount++;
        }
      });
      
      // Show "no records" message if no rows match the filters
      if (visibleRowCount === 0 && tableRows.length > 0) {
        noRecordsRow.style.display = '';
        emptyRow.style.display = 'none';
      } else {
        noRecordsRow.style.display = 'none';
        emptyRow.style.display = tableRows.length === 0 ? '' : 'none';
      }
    }
  });

  function showRofoTab(tabId) {
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
    
    // Initialize or refresh filters for the visible table
    applyFilters();
  }
  
  // Update applyFilters function to handle both tables
  function applyFilters() {
    const landUse = landUseFilter.value.toLowerCase();
    const dateFrom = dateFromFilter.value ? new Date(dateFromFilter.value) : null;
    const dateTo = dateToFilter.value ? new Date(dateToFilter.value) : null;
    const searchTerm = searchInput.value.toLowerCase().trim();
    
    // Determine which table is currently visible
    const isGeneratedVisible = !document.getElementById('generated-table').classList.contains('hidden');
    
    // Get rows from the currently visible table
    const tableRows = isGeneratedVisible 
      ? document.querySelectorAll('#generatedRofoTable tbody tr:not(#noRecordsGeneratedRow):not(#emptyGeneratedRow)')
      : document.querySelectorAll('#notGeneratedRofoTable tbody tr:not(#noRecordsNotGeneratedRow):not(#emptyNotGeneratedRow)');
    
    const noRecordsRow = isGeneratedVisible 
      ? document.getElementById('noRecordsGeneratedRow')
      : document.getElementById('noRecordsNotGeneratedRow');
    
    const emptyRow = isGeneratedVisible 
      ? document.getElementById('emptyGeneratedRow')
      : document.getElementById('emptyNotGeneratedRow');
    
    let visibleRowCount = 0;
    
    // Apply filters to the visible table
    tableRows.forEach(row => {
      const rowLandUse = row.getAttribute('data-land-use');
      const rowDate = row.getAttribute('data-date') ? new Date(row.getAttribute('data-date')) : null;
      const rowText = row.textContent.toLowerCase();
      
      let showRow = true;
      
      // Apply search filter if specified
      if (searchTerm && !rowText.includes(searchTerm)) {
          showRow = false;
      }
      
      // Apply land use filter if specified
      if (showRow && landUse && rowLandUse && !rowLandUse.includes(landUse)) {
        showRow = false;
      }
      
      // Apply date from filter if specified
      if (showRow && dateFrom && rowDate && rowDate < dateFrom) {
        showRow = false;
      }
      
      // Apply date to filter if specified
      if (showRow && dateTo && rowDate && rowDate > dateTo) {
        showRow = false;
      }
      
      // Show or hide row based on filters
      row.style.display = showRow ? '' : 'none';
      
      if (showRow) {
        visibleRowCount++;
      }
    });
    
    // Show "no records" message if no rows match the filters
    if (visibleRowCount === 0 && tableRows.length > 0) {
      noRecordsRow.style.display = '';
      emptyRow.style.display = 'none';
    } else {
      noRecordsRow.style.display = 'none';
      emptyRow.style.display = tableRows.length === 0 ? '' : 'none';
    }
  }

  // Initialize the tab system with the default tab
  document.addEventListener('DOMContentLoaded', function() {
    // ...existing DOMContentLoaded code...
    
    // Ensure the tab buttons and filter functionality are properly initialized
    showRofoTab('not-generated');
  });
  </script>
@endsection



