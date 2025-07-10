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
    /* Custom DataTables styling */
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
    .badge-issued {
      background-color: #dbeafe;
      color: #2563eb;
    }
    .badge-blocked {
      background-color: #fecaca;
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
      position: relative;
      overflow: visible !important;
    }

    /* Enhanced Dropdown menu styles */
    .dropdown-container {
      position: relative;
    }

    .action-menu {
      position: fixed;
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
      list-style: none;
      margin: 0;
      padding: 0;
    }

    .action-menu.show {
      opacity: 1;
      visibility: visible;
      transform: translateY(0);
    }

    .action-menu li {
      border-bottom: 1px solid #f3f4f6;
      margin: 0;
      padding: 0;
    }

    .action-menu li:last-child {
      border-bottom: none;
    }

    .action-menu a,
    .action-menu button {
      display: flex;
      align-items: center;
      padding: 0.75rem 1rem;
      color: #374151;
      text-decoration: none;
      transition: background-color 0.15s ease;
      width: 100%;
      border: none;
      background: none;
      text-align: left;
      cursor: pointer;
      font-size: 0.875rem;
    }

    .action-menu a:hover,
    .action-menu button:hover {
      background-color: #f9fafb;
    }

    .action-menu a.disabled,
    .action-menu button.disabled {
      color: #9ca3af;
      cursor: not-allowed;
      background-color: #f9fafb;
    }

    .action-menu i {
      margin-right: 0.5rem;
      flex-shrink: 0;
    }

    .dropdown-toggle {
      position: relative;
      z-index: 1;
    }

    .table-cell {
      position: relative;
      overflow: visible !important;
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

    /* Validation message styles */
    .validation-message {
        background-color: #fef2f2;
        border: 1px solid #fecaca;
        color: #dc2626;
        padding: 0.75rem;
        border-radius: 0.375rem;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }

    .validation-message ul {
        margin: 0;
        padding-left: 1.25rem;
    }

    .validation-message li {
        margin-bottom: 0.25rem;
    }

    /* Responsive improvements */
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
        <div class="bg-white rounded-md shadow-sm p-6">
            <h2 class="text-xl font-bold mb-6">ST Certificate of Occupancy Management</h2>
            
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i data-lucide="info" class="w-5 h-5 text-blue-500"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            This dashboard shows all approved applications that are eligible for ST Certificate of Occupancy issuance.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Advanced Filter Controls - Moved here -->
            <div class="bg-white rounded-md shadow-sm border border-gray-200 p-4 mb-6">
                <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
                    <h3 class="text-lg font-medium">Filter Certificates</h3>
                    <div class="flex items-center space-x-2">
                        <div class="relative">
                            <input type="text" id="search-certificates" placeholder="Search..." class="border border-gray-300 rounded-md py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <i data-lucide="search" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-4 h-4"></i>
                        </div>
                        <button type="button" id="show-advanced-filters" class="border border-gray-300 rounded-md py-2 px-4 flex items-center space-x-2 hover:bg-gray-50">
                            <i data-lucide="filter" class="w-4 h-4 text-gray-500"></i>
                            <span>Advanced Filters</span>
                        </button>
                    </div>
                </div>
                
                <!-- Advanced Filter Section - Initially Hidden -->
                <div id="advanced-filter-section" class="hidden border-t border-gray-200 pt-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Date Range Filter -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">Date Range</label>
                            <div class="flex items-center space-x-2">
                                <div class="relative flex-1">
                                    <input type="date" id="date-from" class="border border-gray-300 rounded-md py-2 px-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <span class="text-xs text-gray-500 mt-1 block">From</span>
                                </div>
                                <div class="relative flex-1">
                                    <input type="date" id="date-to" class="border border-gray-300 rounded-md py-2 px-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <span class="text-xs text-gray-500 mt-1 block">To</span>
                                </div>
                            </div>
                        </div>
                        
                       <div></div>
                        
                        <!-- Land Use Filter -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">Land Use</label>
                            <div class="relative">
                                <select id="filter-land-use" class="border border-gray-300 rounded-md py-2 px-4 pr-8 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none">
                                    <option value="">All Land Uses</option>
                                    <option value="Residential">Residential</option>
                                    <option value="Commercial">Commercial</option>
                                    <option value="Industrial">Industrial</option>
                                    <option value="Mixed Use">Mixed Use</option>
                                   
                                </select>
                                <i data-lucide="chevron-down" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-4 h-4"></i>
                            </div>
                        </div>
                        
                        <!-- Certificate Status Filter -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">Certificate Generation</label>
                            <div class="relative">
                                <select id="filter-generation" class="border border-gray-300 rounded-md py-2 px-4 pr-8 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none">
                                    <option value="">All</option>
                                    <option value="Generated">Generated</option>
                                    <option value="Not Generated">Not Generated</option>
                                </select>
                                <i data-lucide="chevron-down" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-4 h-4"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Filter Actions -->
                    <div class="flex justify-end mt-4 space-x-2">
                        <button type="button" id="reset-filters" class="border border-gray-300 rounded-md py-2 px-4 text-sm text-gray-700 hover:bg-gray-50">
                            Reset Filters
                        </button>
                        <button type="button" id="apply-filters" class="bg-blue-600 border border-transparent rounded-md py-2 px-4 text-sm text-white hover:bg-blue-700">
                            Apply Filters
                        </button>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-gray-500 text-sm font-medium">Total Eligible Applications</h3>
                        <span class="text-blue-500 bg-blue-100 p-2 rounded-full">
                            <i data-lucide="file-text" class="w-5 h-5"></i>
                        </span>
                    </div>
                    <p class="text-3xl font-bold text-gray-800 mt-2" id="total-count">{{ collect($approvedUnitApplications)->where('planning_recommendation_status', 'Approved')->where('application_status', 'Approved')->count() }}</p>
                </div>
                
                <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-gray-500 text-sm font-medium">Generated Certificates</h3>
                        <span class="text-green-500 bg-green-100 p-2 rounded-full">
                            <i data-lucide="check-circle" class="w-5 h-5"></i>
                        </span>
                    </div>
                    <p class="text-3xl font-bold text-gray-800 mt-2" id="generated-count">{{ collect($approvedUnitApplications)->where('certificate_issued', true)->count() }}</p>
                </div>
                
                <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-gray-500 text-sm font-medium">Not Generated</h3>
                        <span class="text-yellow-500 bg-yellow-100 p-2 rounded-full">
                            <i data-lucide="clock" class="w-5 h-5"></i>
                        </span>
                    </div>
                    <p class="text-3xl font-bold text-gray-800 mt-2" id="not-generated-count">{{ collect($approvedUnitApplications)->where('certificate_issued', '!=', true)->count() }}</p>
                </div>
            </div>

            <!-- Applications Table -->
            <div class="bg-white rounded-md shadow-sm border border-gray-200 overflow-hidden">
                <div class="flex justify-between items-center p-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium">Approved Applications Eligible for Certificate</h3>
                </div>
                
                <!-- Tabs Navigation -->
                <div class="border-b border-gray-200">
                    <nav class="flex -mb-px">
                        <button id="tab-not-generated" class="tab-button active py-4 px-6 text-center border-b-2 border-blue-500 font-medium text-blue-600 flex-1" data-tab="not-generated">
                            Not Generated <span class="ml-2 bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs">{{ collect($approvedUnitApplications)->where('certificate_issued', '!=', true)->count() }}</span>
                        </button>
                        <button id="tab-generated" class="tab-button py-4 px-6 text-center border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium flex-1" data-tab="generated">
                            Generated <span class="ml-2 bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">{{ collect($approvedUnitApplications)->where('certificate_issued', true)->count() }}</span>
                        </button>
                    </nav>
                </div>
                
                <!-- Not Generated Certificates Table -->
                <div id="content-not-generated" class="tab-content overflow-x-auto">
                    <table id="not-generated-table" class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="text-xs">
                                <th class="table-header">File No</th>
                                <th class="table-header">Scheme No</th>
                                <th class="table-header">Unit Owner</th>
                                <th class="table-header">LGA</th>
                                <th class="table-header">Block/Floor/Unit</th>
                                <th class="table-header">Land Use</th>
                                <th class="table-header">Prerequisites</th>
                                <th class="table-header">Status</th>
                                <th class="table-header">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php $notGeneratedCount = 0; @endphp
                            @foreach($approvedUnitApplications as $application)
                                @if(!isset($application->certificate_issued) || !$application->certificate_issued)
                                    @php 
                                        $notGeneratedCount++;
                                        
                                        // Check prerequisites
                                        // ST Memo is linked to the main application (mother application)
                                        $hasSTMemo = \DB::connection('sqlsrv')->table('memos')
                                            ->where('application_id', $application->main_application_id ?? $application->id)
                                            ->exists();
                                            
                                        // RofO is linked to the sub application
                                        $hasRofo = \DB::connection('sqlsrv')->table('rofo')
                                            ->where('sub_application_id', $application->id)
                                            ->where('active', 1)
                                            ->exists();
                                            
                                        $canGenerate = $hasSTMemo && $hasRofo;
                                        $missingItems = [];
                                        if (!$hasSTMemo) $missingItems[] = 'ST Memo';
                                        if (!$hasRofo) $missingItems[] = 'RofO';
                                    @endphp
                                    <tr class="text-sm text-gray-700">
                                        <td class="table-cell">{{ $application->fileno }}</td>
                                        <td class="table-cell">{{ $application->scheme_no }}</td>
                                        <td class="table-cell">{{ $application->owner_name }}</td>
                                        <td class="table-cell">{{ $application->property_lga }}</td>
                                        <td class="table-cell">
                                          {{ $application->block_number ?? 'N/A' }}/{{ $application->floor_number ?? 'N/A' }}/{{ $application->unit_number ?? 'N/A' }}
                                        </td>
                                        <td class="table-cell">{{ $application->land_use }}</td>
                                        <td class="table-cell">
                                            <div class="flex flex-wrap gap-1">
                                                <span class="badge {{ $hasSTMemo ? 'badge-approved' : 'badge-pending' }}">
                                                    <i data-lucide="{{ $hasSTMemo ? 'check' : 'x' }}" class="w-3 h-3 mr-1"></i>
                                                    ST Memo
                                                </span>
                                                <span class="badge {{ $hasRofo ? 'badge-approved' : 'badge-pending' }}">
                                                    <i data-lucide="{{ $hasRofo ? 'check' : 'x' }}" class="w-3 h-3 mr-1"></i>
                                                    RofO
                                                </span>
                                            </div>
                                        </td>
                                        <td class="table-cell">
                                            @if($canGenerate)
                                                <span class="badge badge-approved">Ready to Generate</span>
                                            @else
                                                <span class="badge badge-blocked">Pending</span>
                                            @endif
                                        </td>
                                        <td class="table-cell">
                                            <div class="relative dropdown-container">
                                                <!-- Dropdown Toggle Button -->
                                                <button type="button" class="dropdown-toggle p-2 hover:bg-gray-100 focus:outline-none rounded-full" onclick="customToggleDropdown(this, event)">
                                                    <i data-lucide="more-horizontal" class="w-5 h-5"></i>
                                                </button>
                                                <!-- Dropdown Menu -->
                                                <ul class="fixed action-menu z-50 bg-white border rounded-lg shadow-lg hidden w-56">
                                                    <li>
                                                        <a href="{{ route('sectionaltitling.viewrecorddetail_sub', $application->id) }}" class="w-full text-left px-4 py-2 hover:bg-gray-100 flex items-center space-x-2">
                                                            <i data-lucide="eye" class="w-4 h-4 text-blue-600"></i>
                                                            <span>View Application</span>
                                                        </a>
                                                    </li>
                                                    {{-- <li>
                                                        <a href="#" class="w-full text-left px-4 py-2 flex items-center space-x-2 text-gray-400 cursor-not-allowed pointer-events-none bg-gray-50">
                                                            <i data-lucide="edit" class="w-4 h-4 text-gray-300"></i>
                                                            <span>Update Record</span>
                                                        </a>
                                                    </li> --}}
                                                    @if($canGenerate)
                                                        <li>
                                                            <a href="{{route('programmes.generate_cofo', $application->id)}}" class="w-full text-left px-4 py-2 hover:bg-gray-100 flex items-center space-x-2">
                                                                <i data-lucide="file-text" class="w-4 h-4 text-green-500"></i>
                                                                <span>Generate CofO</span>
                                                            </a>
                                                        </li>
                                                    @else
                                                        <li>
                                                            <button type="button" onclick="showPrerequisiteError({{ json_encode($missingItems) }})" class="w-full text-left px-4 py-2 flex items-center space-x-2 text-red-600 hover:bg-red-50">
                                                                <i data-lucide="alert-circle" class="w-4 h-4 text-red-500"></i>
                                                                <span>Cannot Generate CofO</span>
                                                            </button>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            @if($notGeneratedCount == 0)
                                <tr>
                                    <td colspan="9" class="table-cell text-center py-4">No applications pending certificate generation</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                
                <!-- Generated Certificates Table -->
                <div id="content-generated" class="tab-content hidden overflow-x-auto">
                    <table id="generated-table" class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="text-xs">
                                <th class="table-header">File No</th>
                                <th class="table-header">CofONo</th> 
                                <th class="table-header">RegNo</th>
                                <th class="table-header">Scheme No</th>
                                <th class="table-header">Unit Owner</th>
                                <th class="table-header">LGA</th>
                                <th class="table-header">Block/Floor/Unit</th>
                                <th class="table-header">Land Use</th>
                                <th class="table-header">Status</th>
                                <th class="table-header">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php $generatedCount = 0; @endphp
                            @foreach($approvedUnitApplications as $application)
                                @if(isset($application->certificate_issued) && $application->certificate_issued)
                                    @php $generatedCount++; @endphp
                                    <tr class="text-sm text-gray-700">
                                        <td class="table-cell">{{ $application->fileno }}</td> 
                                        <td class="table-cell">{{ $application->certificate_number ?? 'N/A' }}</td>
                                        <td class="table-cell">{{ $application->Deeds_Serial_No ?? 'N/A' }}</td>
                                        <td class="table-cell">{{ $application->scheme_no }}</td>
                                        <td class="table-cell">{{ $application->owner_name }}</td>
                                        <td class="table-cell">{{ $application->property_lga }}</td>
                                        <td class="table-cell">
                                          {{ $application->block_number ?? 'N/A' }}/{{ $application->floor_number ?? 'N/A' }}/{{ $application->unit_number ?? 'N/A' }}
                                        </td>
                                        <td class="table-cell">{{ $application->land_use }}</td>
                                        <td class="table-cell">
                                            <span class="badge badge-issued">Generated</span>
                                        </td>
                                        <td class="table-cell">
                                            <div class="relative dropdown-container">
                                                <!-- Dropdown Toggle Button -->
                                                <button type="button" class="dropdown-toggle p-2 hover:bg-gray-100 focus:outline-none rounded-full" onclick="customToggleDropdown(this, event)">
                                                    <i data-lucide="more-horizontal" class="w-5 h-5"></i>
                                                </button>
                                                <!-- Dropdown Menu -->
                                                <ul class="fixed action-menu z-50 bg-white border rounded-lg shadow-lg hidden w-56">
                                                    <li>
                                                        <a href="#" class="w-full text-left px-4 py-2 hover:bg-gray-100 flex items-center space-x-2">
                                                            <i data-lucide="eye" class="w-4 h-4 text-blue-600"></i>
                                                            <span>View Application</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{route('programmes.view_cofo', $application->id)}}" class="w-full text-left px-4 py-2 hover:bg-gray-100 flex items-center space-x-2">
                                                            <i data-lucide="file-text" class="w-4 h-4 text-blue-500"></i>
                                                            <span>View Certificate</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('programmes.view_cofo', $application->id) }}" class="w-full text-left px-4 py-2 hover:bg-gray-100 flex items-center space-x-2">
                                                            <i data-lucide="printer" class="w-4 h-4 text-green-500"></i>
                                                            <span>Print Certificate</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            @if($generatedCount == 0)
                                <tr>
                                    <td colspan="10" class="table-cell text-center py-4">No generated certificates found</td>
                                </tr>
                            @endif
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
    function toggleDropdown(event) {
        event.stopPropagation();
        const dropdownMenu = event.currentTarget.nextElementSibling;
        if (dropdownMenu) {
            dropdownMenu.classList.toggle('hidden');
        }
    }

    document.addEventListener('click', () => {
        const dropdownMenus = document.querySelectorAll('.dropdown-menu');
        dropdownMenus.forEach(menu => menu.classList.add('hidden'));
    });

    // Toggle advanced filter section
    document.getElementById('show-advanced-filters').addEventListener('click', function() {
        const filterSection = document.getElementById('advanced-filter-section');
        filterSection.classList.toggle('hidden');
    });
    
    // Reset filters
    document.getElementById('reset-filters').addEventListener('click', function() {
        document.getElementById('date-from').value = '';
        document.getElementById('date-to').value = '';
        document.getElementById('filter-land-use').selectedIndex = 0;
        document.getElementById('filter-generation').selectedIndex = 0;
        document.getElementById('search-certificates').value = '';
        
        // Reset both tables to show all rows
        const notGeneratedRows = document.querySelectorAll('#not-generated-table tbody tr');
        const generatedRows = document.querySelectorAll('#generated-table tbody tr');
        
        notGeneratedRows.forEach(row => {
            row.style.display = '';
        });
        
        generatedRows.forEach(row => {
            row.style.display = '';
        });
        
        // Reset stats to original counts
        document.getElementById('total-count').textContent = '{{ collect($approvedUnitApplications)->where('planning_recommendation_status', 'Approved')->where('application_status', 'Approved')->count() }}';
        document.getElementById('generated-count').textContent = '{{ collect($approvedUnitApplications)->where('certificate_issued', true)->count() }}';
        document.getElementById('not-generated-count').textContent = '{{ collect($approvedUnitApplications)->where('certificate_issued', '!=', true)->count() }}';
    });
    
    // Apply filters
    document.getElementById('apply-filters').addEventListener('click', function() {
        const dateFrom = document.getElementById('date-from').value;
        const dateTo = document.getElementById('date-to').value;
        const landUse = document.getElementById('filter-land-use').value;
        const generation = document.getElementById('filter-generation').value;
        const searchText = document.getElementById('search-certificates').value.toLowerCase();
        
        // Get active tab
        const activeTabId = document.querySelector('.tab-button.border-blue-500').id;
        let tableId = activeTabId === 'tab-generated' ? '#generated-table' : '#not-generated-table';
        
        // Get rows from the active table
        const rows = document.querySelectorAll(tableId + ' tbody tr');
        
        // Filter rows based on criteria
        let visibleCount = 0;
        
        rows.forEach(row => {
            // Adjust column indices based on the table (generated has more columns)
            const landUseColIndex = tableId === '#generated-table' ? 7 : 5;
            const statusColIndex = tableId === '#generated-table' ? 8 : 6;
            
            const landUseCell = row.querySelector(`td:nth-child(${landUseColIndex})`);
            const statusCell = row.querySelector(`td:nth-child(${statusColIndex})`);
            
            if (!landUseCell || !statusCell) return;
            
            const landUseText = landUseCell.textContent.trim();
            const statusText = statusCell.textContent.trim();
            const rowText = row.textContent.toLowerCase();
            
            // Hide row by default, then check if it meets filter criteria
            let showRow = true;
            
            // Apply land use filter
            if (landUse && landUseText !== landUse) {
                showRow = false;
            }
            
            // Apply generation filter if not filtered by tab already
            if (generation) {
                const isGenerated = statusText.includes('Generated');
                if ((generation === 'Generated' && !isGenerated) || 
                    (generation === 'Not Generated' && isGenerated)) {
                    showRow = false;
                }
            }
            
            // Apply search filter
            if (searchText && !rowText.includes(searchText)) {
                showRow = false;
            }
            
            // Show or hide row based on filter results
            row.style.display = showRow ? '' : 'none';
            
            // Count visible rows for stats
            if (showRow) {
                visibleCount++;
            }
        });
        
        // Update the relevant statistic count based on active tab
        if (activeTabId === 'tab-generated') {
            document.getElementById('generated-count').textContent = visibleCount;
        } else {
            document.getElementById('not-generated-count').textContent = visibleCount;
        }
        
        // Update total count
        const generatedCount = parseInt(document.getElementById('generated-count').textContent);
        const notGeneratedCount = parseInt(document.getElementById('not-generated-count').textContent);
        document.getElementById('total-count').textContent = generatedCount + notGeneratedCount;
    });
    
    // Connect the search box to filter as you type
    document.getElementById('search-certificates').addEventListener('input', function() {
        const searchText = this.value.toLowerCase();
        
        // Get active tab
        const activeTabId = document.querySelector('.tab-button.border-blue-500').id;
        let tableId = activeTabId === 'tab-generated' ? '#generated-table' : '#not-generated-table';
        
        // Get rows from the active table
        const rows = document.querySelectorAll(tableId + ' tbody tr');
        
        let visibleCount = 0;
        
        rows.forEach(row => {
            const rowText = row.textContent.toLowerCase();
            const isVisible = rowText.includes(searchText);
            
            row.style.display = isVisible ? '' : 'none';
            
            // Count visible rows for stats
            if (isVisible) {
                visibleCount++;
            }
        });
        
        // Update the relevant statistic count based on active tab
        if (activeTabId === 'tab-generated') {
            document.getElementById('generated-count').textContent = visibleCount;
        } else {
            document.getElementById('not-generated-count').textContent = visibleCount;
        }
        
        // Update total count
        const generatedCount = parseInt(document.getElementById('generated-count').textContent);
        const notGeneratedCount = parseInt(document.getElementById('not-generated-count').textContent);
        document.getElementById('total-count').textContent = generatedCount + notGeneratedCount;
    });

    // Add tab switching functionality
    document.addEventListener('DOMContentLoaded', function() {
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');
        
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class and highlight from all buttons
                tabButtons.forEach(btn => {
                    btn.classList.remove('active', 'border-blue-500', 'text-blue-600');
                    btn.classList.add('border-transparent', 'text-gray-500');
                });
                
                // Add active class and highlight to clicked button
                this.classList.add('active', 'border-blue-500', 'text-blue-600');
                this.classList.remove('border-transparent', 'text-gray-500');
                
                // Hide all tab contents
                tabContents.forEach(content => {
                    content.classList.add('hidden');
                });
                
                // Show the selected tab content
                const tabKey = this.getAttribute('data-tab');
                document.getElementById('content-' + tabKey).classList.remove('hidden');
                
                // Apply any active filters to the newly shown tab
                if (document.getElementById('search-certificates').value !== '') {
                    document.getElementById('search-certificates').dispatchEvent(new Event('input'));
                }
            });
        });
    });

    function customToggleDropdown(button, event) {
        event.stopPropagation();
        
        // Close all other dropdowns first
        document.querySelectorAll('.action-menu').forEach(menu => {
            if (menu !== button.nextElementSibling) {
                menu.classList.add('hidden');
                menu.classList.remove('show');
            }
        });
        
        const dropdown = button.nextElementSibling;
        
        if (!dropdown) {
            console.error('Dropdown menu not found');
            return;
        }
        
        // Toggle visibility
        if (dropdown.classList.contains('hidden')) {
            dropdown.classList.remove('hidden');
            
            // Position dropdown
            positionDropdown(dropdown, button);
            
            // Add show class for animation
            setTimeout(() => {
                dropdown.classList.add('show');
            }, 10);
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
        const dropdownHeight = 200; // Approximate height
        const dropdownWidth = 200;
        
        // Reset positioning
        dropdown.style.position = 'fixed';
        dropdown.style.top = '';
        dropdown.style.bottom = '';
        dropdown.style.left = '';
        dropdown.style.right = '';
        dropdown.style.transform = '';
        
        if (viewportWidth <= 768) {
            // Mobile positioning - center at bottom
            dropdown.style.left = '50%';
            dropdown.style.bottom = '80px';
            dropdown.style.transform = 'translateX(-50%)';
            dropdown.style.width = '90%';
            dropdown.style.maxWidth = '320px';
        } else {
            // Desktop positioning
            let top = rect.bottom + 5;
            let left = rect.right - dropdownWidth;
            
            // Check if dropdown would go off the bottom of the screen
            if (top + dropdownHeight > viewportHeight) {
                top = rect.top - dropdownHeight - 5;
            }
            
            // Check if dropdown would go off the left of the screen
            if (left < 10) {
                left = rect.left;
            }
            
            // Check if dropdown would go off the right of the screen
            if (left + dropdownWidth > viewportWidth - 10) {
                left = viewportWidth - dropdownWidth - 10;
            }
            
            dropdown.style.top = Math.max(10, top) + 'px';
            dropdown.style.left = Math.max(10, left) + 'px';
            dropdown.style.width = dropdownWidth + 'px';
        }
    }
     
    // Close dropdown when clicking outside
    document.addEventListener('click', function (event) {
        const dropdowns = document.querySelectorAll('.action-menu');
        dropdowns.forEach(dropdown => {
            if (!dropdown.contains(event.target) && 
                !dropdown.previousElementSibling?.contains(event.target)) {
                dropdown.classList.remove('show');
                dropdown.classList.add('hidden');
            }
        });
    });

    // Handle window resize for dropdown repositioning
    window.addEventListener('resize', function() {
        document.querySelectorAll('.action-menu:not(.hidden)').forEach(menu => {
            const button = menu.previousElementSibling;
            if (button) {
                positionDropdown(menu, button);
            }
        });
    });

     // Function to show prerequisite error
     function showPrerequisiteError(missingItems) {
        let message = 'Cannot generate Certificate of Occupancy. The following prerequisites are missing:\n\n';
        missingItems.forEach(item => {
            message += '• ' + item + '\n';
        });
        message += '\nPlease ensure all prerequisites are completed before generating the CofO.';
        
        alert(message);
     }
</script>

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

// Document ready function
$(document).ready(function() {
    // Initialize DataTables
    initializeNotGeneratedTable();
    initializeGeneratedTable();
    
    // Show not-generated tab by default
    showTab('not-generated');
});

function initializeNotGeneratedTable() {
    if ($.fn.DataTable.isDataTable('#not-generated-table')) {
        $('#not-generated-table').DataTable().destroy();
    }
    
    notGeneratedTable = $('#not-generated-table').DataTable({
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
    if ($.fn.DataTable.isDataTable('#generated-table')) {
        $('#generated-table').DataTable().destroy();
    }
    
    generatedTable = $('#generated-table').DataTable({
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

function showTab(tabId) {
    currentActiveTab = tabId;
    
    // Hide all tab contents
    document.getElementById('content-generated').classList.add('hidden');
    document.getElementById('content-not-generated').classList.add('hidden');
    
    // Reset all tab buttons
    document.getElementById('tab-generated').classList.remove('border-blue-500', 'text-blue-600');
    document.getElementById('tab-generated').classList.add('border-transparent', 'text-gray-500');
    document.getElementById('tab-not-generated').classList.remove('border-blue-500', 'text-blue-600');
    document.getElementById('tab-not-generated').classList.add('border-transparent', 'text-gray-500');
    
    // Show selected tab content
    document.getElementById('content-' + tabId).classList.remove('hidden');
    
    // Highlight active tab button
    document.getElementById('tab-' + tabId).classList.remove('border-transparent', 'text-gray-500');
    document.getElementById('tab-' + tabId).classList.add('border-blue-500', 'text-blue-600');
    
    // Refresh the current table
    refreshCurrentTable();
}

function refreshCurrentTable() {
    if (currentActiveTab === 'not-generated' && notGeneratedTable) {
        notGeneratedTable.draw();
    } else if (currentActiveTab === 'generated' && generatedTable) {
        generatedTable.draw();
    }
}

// Connect custom search to DataTables
document.getElementById('search-certificates').addEventListener('input', function() {
    const searchTerm = this.value;
    if (currentActiveTab === 'not-generated' && notGeneratedTable) {
        notGeneratedTable.search(searchTerm).draw();
    } else if (currentActiveTab === 'generated' && generatedTable) {
        generatedTable.search(searchTerm).draw();
    }
});
</script>
@endsection



