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
</style>

<!-- Add the script at the beginning of the content section to ensure it's loaded before the buttons -->
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
  
  // Add dropdown toggle functionality
  function customToggleDropdown(button, event) {
    event.stopPropagation();
    
    // Close all other open dropdowns first
    const allMenus = document.querySelectorAll('.action-menu');
    allMenus.forEach(menu => {
      if (menu !== button.nextElementSibling && !menu.classList.contains('hidden')) {
        menu.classList.add('hidden');
      }
    });
    
    // Toggle the clicked dropdown
    const menu = button.nextElementSibling;
    menu.classList.toggle('hidden');
    
    // Position the dropdown near the button
    if (!menu.classList.contains('hidden')) {
      const rect = button.getBoundingClientRect();
      menu.style.top = rect.bottom + 'px';
      menu.style.left = (rect.left - menu.offsetWidth + rect.width) + 'px';
    }
  }
  
  // Close dropdowns when clicking outside
  document.addEventListener('click', function(event) {
    const allMenus = document.querySelectorAll('.action-menu');
    allMenus.forEach(menu => {
      menu.classList.add('hidden');
    });
  });
</script>

<div class="flex-1 overflow-auto">
    <!-- Header -->
    @include($headerPartial ?? 'admin.header')
    
    <!-- Main Content -->
    <div class="p-6">
 
  
      <!-- Primary Application Surveys -->
    <div class="bg-white rounded-md shadow-sm border border-gray-200 p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold">eRegistry</h2>
        </div>
        
        <!-- Search Filters -->
        <!-- Toggle Button for Filters -->
        <div class="mb-4">
            <button id="toggle-search-filters-btn" class="flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
          </svg>
          <span id="toggle-search-filters-text">Show Filters</span>
            </button>
        </div>

        <!-- Filter Section (Initially Hidden) -->
        <div id="search-filters-section" class="mb-6 bg-white p-5 rounded-lg border border-gray-200 shadow-sm hidden">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
              </svg>
              Smart Search
            </h3>
            <div id="results-counter" class="text-sm text-gray-500 hidden">
              <span id="count">0</span> results found
            </div>
          </div>
          
          <!-- Main search bar -->
          <div class="relative mb-4">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
            </div>
            <input type="text" id="global-search" class="w-full pl-10 pr-10 py-3 text-base rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50 transition" placeholder="Search across all fields...">
            <button type="button" id="clear-search" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 hidden">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
          
          <!-- Advanced filters toggle -->
          <div class="mb-3">
            <button id="toggle-filters" class="text-sm text-green-600 hover:text-green-800 focus:outline-none flex items-center">
              <svg id="chevron-down" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
              <svg id="chevron-up" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-width="2" d="M5 15l7-7 7 7" />
              </svg>
              Advanced Filters
            </button>
          </div>
          
          <!-- Advanced filters section -->
          <div id="advanced-filters" class="hidden transition-all duration-300">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-4">
              <div class="relative">
          <label for="date-filter" class="block text-sm font-medium text-gray-700 mb-1">Commissioning Date</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
            </div>
            <input type="date" id="date-filter" class="w-full pl-10 pr-10 py-2 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50 transition">
          </div>
              </div>
              
              <div class="relative">
          <label for="office-filter" class="block text-sm font-medium text-gray-700 mb-1">Current Office</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
              </svg>
            </div>
            <input type="text" id="office-filter" class="w-full pl-10 pr-10 py-2 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50 transition" placeholder="Search by office">
          </div>
              </div>
              
              <div class="relative">
          <label for="return-date-filter" class="block text-sm font-medium text-gray-700 mb-1">Expected Return Date</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
            </div>
            <input type="date" id="return-date-filter" class="w-full pl-10 pr-10 py-2 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50 transition">
          </div>
              </div>
            </div>
          </div>
          
          <!-- Active filters -->
          <div id="active-filters" class="flex flex-wrap gap-2 mt-3 hidden"></div>
          
          <!-- Action buttons -->
          <div class="mt-4 flex justify-end space-x-3">
            <button id="reset-filters" class="flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
              </svg>
              Reset
            </button>
            <button id="apply-filters" class="flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
              Apply Filters
            </button>
          </div>
        </div>

        <script>
          document.addEventListener('DOMContentLoaded', function() {
            const globalSearch = document.getElementById('global-search');
            const clearSearch = document.getElementById('clear-search');
            const toggleFilters = document.getElementById('toggle-filters');
            const advancedFilters = document.getElementById('advanced-filters');
            const chevronDown = document.getElementById('chevron-down');
            const chevronUp = document.getElementById('chevron-up');
            const dateFilter = document.getElementById('date-filter');
            const officeFilter = document.getElementById('office-filter');
            const returnDateFilter = document.getElementById('return-date-filter');
            const resetBtn = document.getElementById('reset-filters');
            const applyBtn = document.getElementById('apply-filters');
            const activeFilters = document.getElementById('active-filters');
            const resultsCounter = document.getElementById('results-counter');
            const countDisplay = document.getElementById('count');
            const table = document.getElementById('eRegistry-table');
            const toggleSearchFiltersBtn = document.getElementById('toggle-search-filters-btn');
            const toggleSearchFiltersText = document.getElementById('toggle-search-filters-text');
            const searchFiltersSection = document.getElementById('search-filters-section');

            // Toggle main search filters section
            toggleSearchFiltersBtn.addEventListener('click', function() {
                const isHidden = searchFiltersSection.classList.toggle('hidden');
                toggleSearchFiltersText.textContent = isHidden ? 'Show Filters' : 'Hide Filters';
            });
            
            // Toggle advanced filters
            toggleFilters.addEventListener('click', function() {
              advancedFilters.classList.toggle('hidden');
              chevronDown.classList.toggle('hidden');
              chevronUp.classList.toggle('hidden');
            });
            
            // Show/hide clear button and trigger live search
            globalSearch.addEventListener('input', function() {
              if (this.value) {
                clearSearch.classList.remove('hidden');
              } else {
                clearSearch.classList.add('hidden');
              }
              filterTable();
            });
            
            // Clear main search
            clearSearch.addEventListener('click', function() {
              globalSearch.value = '';
              this.classList.add('hidden');
              filterTable();
            });
            
            // Apply filters button
            applyBtn.addEventListener('click', filterTable);
            
            // Reset all filters
            resetBtn.addEventListener('click', function() {
              globalSearch.value = '';
              dateFilter.value = '';
              officeFilter.value = '';
              returnDateFilter.value = '';
              clearSearch.classList.add('hidden');
              activeFilters.innerHTML = '';
              activeFilters.classList.add('hidden');
              resultsCounter.classList.add('hidden');
              filterTable();
            });
            
            // Live filtering for all inputs
            [dateFilter, officeFilter, returnDateFilter].forEach(input => {
              input.addEventListener('change', filterTable);
              input.addEventListener('input', filterTable);
            });
            
            // Filter table function
            function filterTable() {
              const searchTerm = globalSearch.value.toLowerCase();
              const date = dateFilter.value;
              const office = officeFilter.value.toLowerCase();
              const returnDate = returnDateFilter.value;
              
              const rows = table.querySelectorAll('tbody tr');
              let visibleCount = 0;
              
              // Update active filters
              updateActiveFilters();
              
              rows.forEach(row => {
                const allText = Array.from(row.cells).map(cell => 
                  cell.textContent.toLowerCase()).join(' ');
                const commissionDate = formatDate(row.cells[0].textContent);
                const officeCell = row.cells[3].textContent.toLowerCase();
                const expectedReturnDate = formatDate(row.cells[2].textContent);
                
                const matchesSearch = !searchTerm || allText.includes(searchTerm);
                const matchesDate = !date || commissionDate === date;
                const matchesOffice = !office || officeCell.includes(office);
                const matchesReturn = !returnDate || expectedReturnDate === returnDate;
                
                if (matchesSearch && matchesDate && matchesOffice && matchesReturn) {
                  row.style.display = '';
                  visibleCount++;
                } else {
                  row.style.display = 'none';
                }
              });
              
              // Update results counter
              if (searchTerm || date || office || returnDate) {
                countDisplay.textContent = visibleCount;
                resultsCounter.classList.remove('hidden');
              } else {
                resultsCounter.classList.add('hidden');
              }
            }
            
            // Update active filters display
            function updateActiveFilters() {
              activeFilters.innerHTML = '';
              let hasFilters = false;
              
              if (globalSearch.value) addFilter('Search: ' + globalSearch.value);
              if (dateFilter.value) addFilter('Date: ' + formatDisplayDate(dateFilter.value));
              if (officeFilter.value) addFilter('Office: ' + officeFilter.value);
              if (returnDateFilter.value) addFilter('Return: ' + formatDisplayDate(returnDateFilter.value));
              
              function addFilter(text) {
                hasFilters = true;
                const chip = document.createElement('div');
                chip.className = 'bg-green-100 text-green-800 text-xs rounded-full px-3 py-1 flex items-center';
                chip.innerHTML = `<span>${text}</span>`;
                activeFilters.appendChild(chip);
              }
              
              activeFilters.classList.toggle('hidden', !hasFilters);
            }
            
            // Helper: Format date from text to YYYY-MM-DD
            function formatDate(dateText) {
              if (dateText === 'N/A' || dateText === 'n/a') return '';
              try {
                const date = new Date(dateText);
                return date.toISOString().split('T')[0];
              } catch {
                return '';
              }
            }
            
            // Helper: Format date for display
            function formatDisplayDate(dateString) {
              const date = new Date(dateString);
              return date.toLocaleDateString();
            }
          });
        </script>
        <div class="overflow-x-auto">
            <table id="eRegistry-table" class="min-w-full divide-y divide-gray-200">
                <thead>
                     <tr class="text-xs">
                  
                        <th class="table-header">Commissioning Date</th>
                        <th class="table-header">Decommissioning Date</th>
                        <th class="table-header">Expected Return Date</th>
                        <th class="table-header">Current Office</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @if(count($eRegistry) > 0)
                        @foreach($eRegistry as $land)
                             <tr class="text-xs">
 
                                <td class="table-cell">{{ $land->Commissioning_Date ?? 'N/A' }}</td>
                                <td class="table-cell">{{ $land->Decommissioning_Date ?? 'N/A' }}</td>
                               
                         
                                <td class="table-cell">{{ $land->Expected_Return_Date ?? 'N/A' }}</td>
                                <td class="table-cell">{{ $land->Current_Office ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                    @else
                         <tr class="text-xs">
                            <td colspan="10" class="table-cell text-center py-4">No eRegistry data available</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <!-- Page Footer -->
    @include($footerPartial ?? 'admin.footer')
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const table = document.getElementById('eRegistry-table');
        const mlsFilter = document.getElementById('mls-filter');
        const kangisFilter = document.getElementById('kangis-filter');
        const stFilter = document.getElementById('st-filter');
        const applyFiltersBtn = document.getElementById('apply-filters');
        const resetFiltersBtn = document.getElementById('reset-filters');
        
        // Function to filter the table
        function filterTable() {
            const mlsValue = mlsFilter.value.toLowerCase();
            const kangisValue = kangisFilter.value.toLowerCase();
            const stValue = stFilter.value.toLowerCase();
            
            const rows = table.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const mlsCell = row.cells[0].textContent.toLowerCase();
                const kangisCell = row.cells[1].textContent.toLowerCase();
                const stCell = row.cells[3].textContent.toLowerCase();
                
                const matchesMls = mlsValue === '' || mlsCell.includes(mlsValue);
                const matchesKangis = kangisValue === '' || kangisCell.includes(kangisValue);
                const matchesSt = stValue === '' || stCell.includes(stValue);
                
                if (matchesMls && matchesKangis && matchesSt) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
        
        // Apply filters when the button is clicked
        applyFiltersBtn.addEventListener('click', filterTable);
        
        // Reset filters when the reset button is clicked
        resetFiltersBtn.addEventListener('click', function() {
            mlsFilter.value = '';
            kangisFilter.value = '';
            stFilter.value = '';
            
            // Show all rows
            const rows = table.querySelectorAll('tbody tr');
            rows.forEach(row => {
                row.style.display = '';
            });
        });
        
        // Also filter when pressing Enter in the input fields
        [mlsFilter, kangisFilter, stFilter].forEach(input => {
            input.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    filterTable();
                }
            });
        });
    });
</script>
@endsection


