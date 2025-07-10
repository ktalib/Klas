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
            <button id="exportBtn" class="flex items-center space-x-2 px-4 py-2 border border-gray-200 rounded-md">
              <i data-lucide="download" class="w-4 h-4 text-gray-600"></i>
              <span>Export</span>
            </button>
          </div>
        </div>
        
        <div class="w-full">
          <table id="unitsTable" class="w-full table-auto divide-y divide-gray-200">
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
            <th class="table-header text-green-500">Application Date</th>
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
             
             
             
<td class="table-cell px-1 py-1 truncate">
    {{ $app->created_at ? \Carbon\Carbon::parse($app->created_at)->format('M d, Y') : 'N/A' }}
</td>
</qodoArtifact>
            <td class="table-cell px-1 py-1">
              @include('sectionaltitling.action_menu.unit_actions', ['app' => $app])
            </td>
              </tr>
              @endforeach
            </tbody>
          </table>
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

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

<!-- jQuery and DataTables JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Initialize DataTable
    var table = $('#unitsTable').DataTable({
        "pageLength": 10,
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "order": [[0, "desc"]],
        "columnDefs": [
            {
                "targets": [9], // Actions column
                "orderable": false,
                "searchable": false
            }
        ],
        "dom": '<"top"lf>rt<"bottom"ip><"clear">',
        "language": {
            "info": "Showing _START_ to _END_ of _TOTAL_ applications",
            "infoEmpty": "Showing 0 to 0 of 0 applications",
            "infoFiltered": "(filtered from _MAX_ total applications)",
            "lengthMenu": "Show _MENU_ applications per page",
            "search": "Search applications:",
            "paginate": {
                "first": "First",
                "last": "Last",
                "next": "Next",
                "previous": "Previous"
            }
        },
        "responsive": true,
        "processing": true,
        "autoWidth": false,
        "buttons": [
            {
                extend: 'excel',
                text: 'Export to Excel',
                className: 'btn btn-success',
                exportOptions: {
                    columns: ':not(:last-child)' // Exclude actions column
                }
            },
            {
                extend: 'csv',
                text: 'Export to CSV',
                className: 'btn btn-info',
                exportOptions: {
                    columns: ':not(:last-child)' // Exclude actions column
                }
            },
            {
                extend: 'pdf',
                text: 'Export to PDF',
                className: 'btn btn-danger',
                exportOptions: {
                    columns: ':not(:last-child)' // Exclude actions column
                },
                orientation: 'landscape',
                pageSize: 'A4'
            }
        ]
    });

    // Custom export button functionality
    $('#exportBtn').on('click', function() {
        // Show export options
        var exportMenu = `
            <div class="export-menu" style="position: absolute; background: white; border: 1px solid #ccc; border-radius: 4px; padding: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); z-index: 1000;">
                <button onclick="exportToExcel()" class="block w-full text-left px-3 py-2 hover:bg-gray-100">Export to Excel</button>
                <button onclick="exportToCSV()" class="block w-full text-left px-3 py-2 hover:bg-gray-100">Export to CSV</button>
                <button onclick="exportToPDF()" class="block w-full text-left px-3 py-2 hover:bg-gray-100">Export to PDF</button>
            </div>
        `;
        
        // Remove existing menu
        $('.export-menu').remove();
        
        // Add menu
        $(this).after(exportMenu);
        
        // Position menu
        var menu = $('.export-menu');
        var button = $(this);
        menu.css({
            'top': button.offset().top + button.outerHeight(),
            'left': button.offset().left
        });
        
        // Close menu when clicking outside
        $(document).on('click.exportMenu', function(e) {
            if (!$(e.target).closest('.export-menu, #exportBtn').length) {
                $('.export-menu').remove();
                $(document).off('click.exportMenu');
            }
        });
    });

    // Export functions
    window.exportToExcel = function() {
        table.button('.buttons-excel').trigger();
        $('.export-menu').remove();
    };

    window.exportToCSV = function() {
        table.button('.buttons-csv').trigger();
        $('.export-menu').remove();
    };

    window.exportToPDF = function() {
        table.button('.buttons-pdf').trigger();
        $('.export-menu').remove();
    };
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

window.showMultipleOwners = function(names, passports) {
    if (!Array.isArray(names)) {
        names = [];
    }
    if (!Array.isArray(passports)) {
        passports = [];
    }
    
    let html = '<div class="space-y-2">';
    names.forEach((name, index) => {
        html += `<div class="flex items-center space-x-2">`;
        if (passports[index]) {
            html += `<img src="{{ asset('storage/app/public/') }}/${passports[index]}" alt="Passport" class="w-8 h-8 rounded-full object-cover">`;
        }
        html += `<span>${name}</span></div>`;
    });
    html += '</div>';
    
    Swal.fire({
        title: 'Multiple Owners',
        html: html,
        icon: 'info',
        confirmButtonText: 'Close',
        width: '500px'
    });
}

window.showPassportPreview = function(imageSrc, title) {
    Swal.fire({
        title: title,
        imageUrl: imageSrc,
        imageWidth: 300,
        imageHeight: 400,
        imageAlt: title,
        confirmButtonText: 'Close'
    });
}
</script>

<style>
/* Custom DataTables styling to match your design */
.dataTables_wrapper {
    font-family: inherit;
}

.dataTables_length select,
.dataTables_filter input {
    border: 1px solid #d1d5db;
    border-radius: 0.375rem;
    padding: 0.5rem;
    font-size: 0.875rem;
}

.dataTables_info {
    color: #6b7280;
    font-size: 0.875rem;
}

.dataTables_paginate .paginate_button {
    border: 1px solid #d1d5db;
    border-radius: 0.375rem;
    padding: 0.25rem 0.75rem;
    margin: 0 0.125rem;
    color: #374151;
    text-decoration: none;
}

.dataTables_paginate .paginate_button:hover {
    background-color: #f3f4f6;
    border-color: #9ca3af;
}

.dataTables_paginate .paginate_button.current {
    background-color: #3b82f6;
    border-color: #3b82f6;
    color: white;
}

.dataTables_paginate .paginate_button.disabled {
    color: #9ca3af;
    cursor: not-allowed;
}

.dataTables_paginate .paginate_button.disabled:hover {
    background-color: transparent;
    border-color: #d1d5db;
}

/* Hide default buttons container */
.dt-buttons {
    display: none;
}

.export-menu button {
    border: none;
    background: none;
    cursor: pointer;
    border-radius: 4px;
}
</style>