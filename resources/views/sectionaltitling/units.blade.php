@extends('layouts.app')
@section('page-title')
    {{ __('Unit Applications') }}
@endsection


@include('sectionaltitling.partials.assets.css')
@section('content')
<div class="flex-1 overflow-auto">
    <!-- Header -->
   @include('admin.header')
    <!-- Dashboard Content -->
    <div class="p-6">
      <!-- Stats Cards -->
      
     {{-- @include('sectionaltitling.partials.statistic.statistic_card') --}}
      <!-- SecondaryApplications Overview  -->
      @include('sectionaltitling.partials.statistic.SecondaryApplications')
      <!-- Secondary Applications Table - Screenshot 135 -->
      <div class="bg-white rounded-md shadow-sm border border-gray-200 p-6">
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-xl font-bold">Unit Applications</h2>
          
          <div class="flex items-center space-x-4">
       
                      <div class="relative">
    <select id="statusFilter"
        class="pl-4 pr-8 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none">
        <option value="All...">All...</option>
        <option value="Approved">Approved</option>
        <option value="Pending">Pending</option>
        <option value="Declined">Declined</option>
    </select>
    <i data-lucide="chevron-down"
        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-4 h-4"></i>
</div>
            
           
            
            <button class="flex items-center space-x-2 px-4 py-2 border border-gray-200 rounded-md">
              <i data-lucide="download" class="w-4 h-4 text-gray-600"></i>
              <span>Export</span>
            </button>
            
            
          </div>
        </div>
        
        <div class="w-full">
          <table class="w-full table-auto divide-y divide-gray-200">
            <thead>
              <tr class="text-xs">
            <th class="table-header text-green-500">PrimaryID</th>
            <th class="table-header text-green-500">Scheme No</th>
            <th class="table-header text-green-500">Mother FileNo</th>
            <th class="table-header text-green-500">STFileNo</th> 
            <th class="table-header text-green-500">Land Use</th>
            <th class="table-header text-green-500">Original Owner</th>
            <th class="table-header text-green-500">Unit Owner</th>
            <th class="table-header text-green-500">UnitNo</th>
            <th class="table-header text-green-500">Phone Number</th>
            <th class="table-header text-green-500">Actions</th> 
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @foreach($SecondaryApplications as $app)
              <tr class="text-xs">
            <td class="table-cell px-1 py-1 truncate">{{ $app->main_application_id ?? 'N/A' }}</td>
            <td class="table-cell px-1 py-1 truncate">{{ $app->scheme_no ?? 'N/A' }}</td>
            <td class="table-cell px-1 py-1 truncate">{{ $app->mother_fileno ?? 'N/A' }}</td>
            <td class="table-cell px-1 py-1 truncate">{{ $app->fileno ?? 'N/A' }}</td>
          
            <td class="table-cell px-1 py-1 truncate">{{ $app->land_use ?? 'N/A' }}</td>
            <td class="table-cell px-1 py-1">
              <div class="flex items-center">
                <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center mr-2">
                  @if(!empty($app->mother_passport))
                    <img src="{{ asset('storage/app/public/' . $app->mother_passport) }}" 
                         alt="Original Owner Passport" 
                         class="w-full h-full rounded-full object-cover cursor-pointer"
                         onclick="showPassportPreview('{{ asset('storage/app/public/' . $app->mother_passport) }}', 'Original Owner Passport')">
                  @elseif(!empty($app->mother_multiple_owners_passport))
                    @php
                      $passports = is_array($app->mother_multiple_owners_passport) ? 
                        $app->mother_multiple_owners_passport : 
                        json_decode($app->mother_multiple_owners_passport, true);
                      $firstPassport = !empty($passports) && isset($passports[0]) ? $passports[0] : null;
                    @endphp
                    @if($firstPassport)
                      <img src="{{ asset('storage/app/public/' . $firstPassport) }}" 
                           alt="Original Owner Passport" 
                           class="w-full h-full rounded-full object-cover cursor-pointer"
                           onclick="showMultipleOwners(
                             @json(is_array($app->mother_multiple_owners_names) ? $app->mother_multiple_owners_names : json_decode($app->mother_multiple_owners_names, true)), 
                             @json($passports)
                           )">
                    @else
                      <i data-lucide="{{ !empty($app->mother_corporate_name) ? 'building' : (!empty($app->mother_multiple_owners_names) ? 'users' : 'user') }}" class="w-3 h-3 text-gray-500"></i>
                    @endif
                  @else
                    <i data-lucide="{{ !empty($app->mother_corporate_name) ? 'building' : (!empty($app->mother_multiple_owners_names) ? 'users' : 'user') }}" class="w-3 h-3 text-gray-500"></i>
                  @endif
                </div>
                <div>
                  @if(!empty($app->mother_corporate_name))
                    <span>{{ $app->mother_corporate_name }}</span>
                  @elseif(!empty($app->mother_multiple_owners_names))
                    @php
                      $names = $app->mother_multiple_owners_names;
                      $decoded = [];
                      if (!empty($names)) {
                        $decoded = is_array($names) ? $names : json_decode($names, true);
                        if (!is_array($decoded)) $decoded = [];
                      }
                    @endphp
                    <span>{{ !empty($decoded) && isset($decoded[0]) ? $decoded[0] : '' }}</span>
                    @if(!empty($decoded))
                      <span class="ml-1 cursor-pointer text-blue-500"
                            onclick="showMultipleOwners(
                              @json($decoded), 
                              @json(is_array($app->mother_multiple_owners_passport) ? $app->mother_multiple_owners_passport : json_decode($app->mother_multiple_owners_passport, true))
                            )">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                      </span>
                    @endif
                  @else
                    <span>{{ $app->mother_applicant_title ?? '' }} {{ $app->mother_first_name ?? '' }} {{ $app->mother_surname ?? '' }}</span>
                  @endif
                </div>
              </div>
            </td>
            <td class="table-cell px-1 py-1">
              <div class="flex items-center">
                <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center mr-2">
                  @if(!empty($app->passport))
                    <img src="{{ asset('storage/app/public/' . $app->passport) }}" 
                         alt="Unit Owner Passport" 
                         class="w-full h-full rounded-full object-cover cursor-pointer"
                         onclick="showPassportPreview('{{ asset('storage/app/public/' . $app->passport) }}', 'Unit Owner Passport')">
                  @elseif(!empty($app->multiple_owners_passport))
                    @php
                      $passports = is_array($app->multiple_owners_passport) ? 
                        $app->multiple_owners_passport : 
                        json_decode($app->multiple_owners_passport, true);
                      $firstPassport = !empty($passports) && isset($passports[0]) ? $passports[0] : null;
                    @endphp
                    @if($firstPassport)
                      <img src="{{ asset('storage/app/public/' . $firstPassport) }}" 
                           alt="Unit Owner Passport" 
                           class="w-full h-full rounded-full object-cover cursor-pointer"
                           onclick="showMultipleOwners(
                             @json(is_array($app->multiple_owners_names) ? $app->multiple_owners_names : json_decode($app->multiple_owners_names, true)), 
                             @json($passports)
                           )">
                    @else
                      <i data-lucide="{{ !empty($app->corporate_name) ? 'building' : (!empty($app->multiple_owners_names) ? 'users' : 'user') }}" class="w-3 h-3 text-gray-500"></i>
                    @endif
                  @else
                    <i data-lucide="{{ !empty($app->corporate_name) ? 'building' : (!empty($app->multiple_owners_names) ? 'users' : 'user') }}" class="w-3 h-3 text-gray-500"></i>
                  @endif
                </div>
                <div>
                  @if(!empty($app->corporate_name))
                    <span>{{ $app->corporate_name }}</span>
                  @elseif(!empty($app->multiple_owners_names))
                    @php
                      $names = $app->multiple_owners_names;
                      $decoded = [];
                      if (!empty($names)) {
                        if (is_array($names)) {
                          $decoded = $names;
                        } else {
                          $tryJson = json_decode($names, true);
                          if (is_array($tryJson)) {
                            $decoded = $tryJson;
                          } else {
                            $decoded = array_map('trim', str_getcsv($names));
                          }
                        }
                      }
                    @endphp
                    <span>{{ !empty($decoded) && isset($decoded[0]) ? $decoded[0] : '' }}</span>
                    @if(!empty($decoded))
                      <span class="ml-1 cursor-pointer text-blue-500"
                            onclick="showMultipleOwners(
                              @json($decoded), 
                              @json(is_array($app->multiple_owners_passport) ? $app->multiple_owners_passport : json_decode($app->multiple_owners_passport, true))
                            )">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                      </span>
                    @endif
                  @else
                    <span>{{ $app->applicant_title ?? '' }} {{ $app->first_name ?? '' }} {{ $app->surname ?? '' }}</span>
                  @endif
                </div>
              </div>
            </td>
            <td class="table-cell px-1 py-1 truncate">{{ $app->unit_number ?? 'N/A' }}</td>
            <td class="table-cell px-1 py-1 truncate">
              @if(!empty($app->phone_number) && str_contains($app->phone_number, ','))
                @php
                  $phones = array_map('trim', explode(',', $app->phone_number));
                  $firstPhone = $phones[0];
                  $allPhones = implode('<br>', $phones);
                @endphp
                <div class="relative group">
                  <span>{{ $firstPhone }}</span>
                  <i data-lucide="more-horizontal" class="inline-block w-3 h-3 text-gray-500 ml-1"></i>
                  <div class="absolute hidden group-hover:block bg-white border border-gray-200 shadow-lg rounded-md p-2 z-10 text-xs">
                    {!! $allPhones !!}
                  </div>
                </div>
              @else
                {{ $app->phone_number ?? 'N/A' }}
              @endif
            </td>
      
            <td class="table-cell px-1 py-1">
              @include('sectionaltitling.action_menu.unit_actions', ['app' => $app])
            </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="flex justify-between items-center mt-6 text-sm">
          <div class="text-gray-500" id="showingCount">Showing 0 of 0 applications</div>
          <div class="flex items-center space-x-2">
            <button id="prevPageBtn" class="px-3 py-1 border border-gray-200 rounded-md flex items-center" disabled>
              <i data-lucide="chevron-left" class="w-4 h-4 mr-1"></i>
              <span>Previous</span>
            </button>
            <button id="nextPageBtn" class="px-3 py-1 border border-gray-200 rounded-md flex items-center" disabled>
              <span>Next</span>
              <i data-lucide="chevron-right" class="w-4 h-4 ml-1"></i>
            </button>
          </div>
        </div>
      </div>
    
    </div>
    <!-- Footer -->
    @include('admin.footer')
  </div>
  @include('sectionaltitling.sub_action_modals.payment_modal')
  @include('sectionaltitling.sub_action_modals.other_departments')
  @include('sectionaltitling.sub_action_modals.eRegistry_modal')
  @include('sectionaltitling.sub_action_modals.recommendation')
  @include('sectionaltitling.sub_action_modals.directorApproval')
 
@endsection

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add ID to the filter select if it doesn't have one
    const filterSelect = document.querySelector('select');
    if (filterSelect && !filterSelect.id) {
        filterSelect.id = 'statusFilter';
    }
    
    // Pagination variables
    window.unitTablePagination = {
        currentPage: 1,
        rowsPerPage: 10,
        filteredRows: [],
        allRows: []
    };

    function paginateTable(page = 1) {
        const { rowsPerPage, filteredRows } = window.unitTablePagination;
        const totalRows = filteredRows.length;
        const startIdx = (page - 1) * rowsPerPage;
        const endIdx = Math.min(startIdx + rowsPerPage, totalRows);

        // Hide all rows first
        filteredRows.forEach(row => {
            row.style.display = 'none';
        });

        // Show only the rows for current page
        for (let i = startIdx; i < endIdx; i++) {
            if (filteredRows[i]) {
                filteredRows[i].style.display = '';
            }
        }

        // Update showing count
        const showingCount = document.getElementById('showingCount');
        const showing = Math.min(rowsPerPage, totalRows - startIdx);
        showingCount.textContent = `Showing ${showing} of ${totalRows} applications`;

        // Enable/disable buttons
        document.getElementById('prevPageBtn').disabled = page === 1;
        document.getElementById('nextPageBtn').disabled = endIdx >= totalRows;

        window.unitTablePagination.currentPage = page;
    }

    function filterTable(selectedStatus) {
        const allRows = window.unitTablePagination.allRows;
        let filteredRows = [];

        allRows.forEach(row => {
            let showRow = false;
            if (selectedStatus === 'All...') {
                showRow = true;
            } else {
                // No badge columns in this table, so just show all for now or implement your own logic
                // If you add status badges, update this logic accordingly
                // Example: const statusBadge = row.querySelector('td:nth-child(9) .badge');
                // if (statusBadge && statusBadge.textContent.trim() === selectedStatus) showRow = true;
                // For now, fallback to always show
                showRow = row.innerText.includes(selectedStatus);
            }
            row.style.display = showRow ? '' : 'none';
            if (showRow) filteredRows.push(row);
        });

        window.unitTablePagination.filteredRows = filteredRows;
        paginateTable(1);
    }

    // Initial setup - only count actual data rows, not empty or template rows
    window.unitTablePagination.allRows = Array.from(document.querySelectorAll('tbody tr')).filter(row => {
        // Filter out empty rows or rows without actual data
        const cells = row.querySelectorAll('td');
        return cells.length > 0 && row.textContent.trim() !== '';
    });
    window.unitTablePagination.filteredRows = window.unitTablePagination.allRows;
    
    // Debug: Log the actual count
    console.log('Total rows found:', window.unitTablePagination.allRows.length);
    console.log('Filtered rows:', window.unitTablePagination.filteredRows.length);
    
    paginateTable(1);

    // Filter event
    const statusFilter = document.getElementById('statusFilter');
    if (statusFilter) {
        statusFilter.addEventListener('change', function() {
            filterTable(this.value);
        });
    }

    // Pagination events
    document.getElementById('prevPageBtn').addEventListener('click', function() {
        const { currentPage } = window.unitTablePagination;
        if (currentPage > 1) paginateTable(currentPage - 1);
    });
    document.getElementById('nextPageBtn').addEventListener('click', function() {
        const { currentPage, filteredRows, rowsPerPage } = window.unitTablePagination;
        if (currentPage * rowsPerPage < filteredRows.length) paginateTable(currentPage + 1);
    });

    // Export to CSV
    document.querySelector('button.flex.items-center.space-x-2.px-4.py-2.border.border-gray-200.rounded-md').addEventListener('click', function() {
        exportVisibleTableToCSV();
    });

    function exportVisibleTableToCSV() {
        const table = document.querySelector('table');
        const headers = Array.from(table.querySelectorAll('thead th')).map(th => th.innerText.trim());
        const { filteredRows, currentPage, rowsPerPage } = window.unitTablePagination;
        const startIdx = (currentPage - 1) * rowsPerPage;
        const endIdx = startIdx + rowsPerPage;
        const visibleRows = filteredRows.slice(startIdx, endIdx);

        let csvContent = '';
        csvContent += headers.join(',') + '\n';

        visibleRows.forEach(row => {
            const cells = Array.from(row.querySelectorAll('td')).map(td => {
                return '"' + td.innerText.replace(/"/g, '""').replace(/\n/g, ' ').replace(/,/g, ' ') + '"';
            });
            csvContent += cells.join(',') + '\n';
        });

        // Download CSV
        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'unit_applications.csv';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    }

    // Re-filter and paginate on load
    filterTable(statusFilter ? statusFilter.value : 'All...');
});

window.showFullNames = function(owners) {
  if (!Array.isArray(owners)) {
    owners = [];
  }
  if (owners.length > 0) {
    Swal.fire({
      title: 'Full Names of Multiple Owners',
      html: '<ul>' + owners.map(name => `<li>${name}</li>`).join('') + '</ul>',
      icon: 'info',
      confirmButtonText: 'Close'
    });
  } else {
    Swal.fire({
      title: 'Full Names of Multiple Owners',
      text: 'No owners available',
      icon: 'info',
      confirmButtonText: 'Close'
    });
  }
}
</script>
