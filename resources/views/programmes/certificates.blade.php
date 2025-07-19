@extends('layouts.app')

@section('page-title')
    {{ $PageTitle ?? __('KLAES') }}
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
    }

    /* Dropdown menu styles */
    .dropdown {
      position: relative;
      display: inline-block;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      right: 0;
      background-color: #f9f9f9;
      min-width: 200px;
      box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
      z-index: 1000;
      border-radius: 4px;
      border: 1px solid #ddd;
    }

    .dropdown-content a {
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
      border-bottom: 1px solid #eee;
    }

    .dropdown-content a:hover {
      background-color: #f1f1f1;
    }

    .dropdown-content a:last-child {
      border-bottom: none;
    }

    .dropdown.show .dropdown-content {
      display: block;
    }

    .dropdown-toggle {
      background: none;
      border: none;
      cursor: pointer;
      padding: 8px;
      border-radius: 4px;
    }

    .dropdown-toggle:hover {
      background-color: #f5f5f5;
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

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-gray-500 text-sm font-medium">Total Eligible Applications</h3>
                        <span class="text-blue-500 bg-blue-100 p-2 rounded-full">
                            <i data-lucide="file-text" class="w-5 h-5"></i>
                        </span>
                    </div>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ collect($approvedUnitApplications)->where('planning_recommendation_status', 'Approved')->where('application_status', 'Approved')->count() }}</p>
                </div>
                
                <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-gray-500 text-sm font-medium">Generated Certificates</h3>
                        <span class="text-green-500 bg-green-100 p-2 rounded-full">
                            <i data-lucide="check-circle" class="w-5 h-5"></i>
                        </span>
                    </div>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ collect($approvedUnitApplications)->where('certificate_issued', true)->count() }}</p>
                </div>
                
                <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-gray-500 text-sm font-medium">Not Generated</h3>
                        <span class="text-yellow-500 bg-yellow-100 p-2 rounded-full">
                            <i data-lucide="clock" class="w-5 h-5"></i>
                        </span>
                    </div>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ collect($approvedUnitApplications)->where('certificate_issued', '!=', true)->count() }}</p>
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
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="text-xs">
                                <th class="table-header">File No</th>
                                <th class="table-header">Scheme No</th>
                                <th class="table-header">Unit Owner</th>
                                <th class="table-header">LGA</th>
                                <th class="table-header">Block/Floor/Unit</th>
                                <th class="table-header">Land Use</th>
                                <th class="table-header">Reg Particulars</th>
                                <th class="table-header">Prerequisites</th>
                                <th class="table-header">Status</th>
                                <th class="table-header">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php $notGeneratedCount = 0; @endphp
                            @foreach($approvedUnitApplications as $application)
                                @if(!$application->certificate_issued)
                                    @php 
                                        $notGeneratedCount++;
                                        
                                        // Check prerequisites
                                        $hasSTMemo = \DB::connection('sqlsrv')->table('memos')
                                            ->where('application_id', $application->main_application_id ?? $application->id)
                                            ->exists();
                                            
                                        $hasRofo = \DB::connection('sqlsrv')->table('rofo')
                                            ->where('sub_application_id', $application->id)
                                            ->where('active', 1)
                                            ->exists();

                                        // Check ST CofO and Reg Particulars
                                        $instrument = \DB::connection('sqlsrv')->table('registered_instruments')
                                            ->where('StFileNo', $application->fileno)
                                            ->where('instrument_type', 'Sectional Titling CofO')
                                            ->first();
                                        $hasSTCofO = !empty($instrument);
                                        $regParticulars = $instrument->particularsRegistrationNumber ?? 'N/A';

                                        $canGenerate = $hasSTMemo && $hasRofo && $hasSTCofO;
                                        $missingItems = [];
                                        if (!$hasSTMemo) $missingItems[] = 'ST Memo';
                                        if (!$hasRofo) $missingItems[] = 'RofO';
                                        if (!$hasSTCofO) $missingItems[] = 'ST CofO';
                                    @endphp
                                    <tr class="text-sm text-gray-700">
                                        <td class="table-cell">{{ $application->fileno }}</td>
                                        <td class="table-cell">{{ $application->scheme_no }}</td>
                                        <td class="table-cell">{{ $application->owner_name }}</td>
                                        <td class="table-cell">{{ $application->property_lga }}</td>
                                        <td class="table-cell">
                                          {{ $application->block_number ?? 'N/A' }}-{{ $application->floor_number ?? 'N/A' }}-{{ $application->unit_number ?? 'N/A' }}
                                        </td>
                                        <td class="table-cell">{{ $application->land_use }}</td>
                                        <td class="table-cell">{{ $regParticulars }}</td>
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
                                                <span class="badge {{ $hasSTCofO ? 'badge-approved' : 'badge-pending' }}">
                                                    <i data-lucide="{{ $hasSTCofO ? 'check' : 'x' }}" class="w-3 h-3 mr-1"></i>
                                                    ST CofO
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
                                            <div class="dropdown">
                                                <button class="dropdown-toggle" onclick="toggleDropdown(this)">
                                                    <i data-lucide="more-horizontal" class="w-5 h-5"></i>
                                                </button>
                                                <div class="dropdown-content">
                                                    <a href="{{ route('sectionaltitling.viewrecorddetail_sub', $application->id) }}">
                                                        <i data-lucide="eye" class="w-4 h-4 mr-2 inline"></i>
                                                        View Application
                                                    </a>
                                                    @if($canGenerate)
                                                        <a href="{{route('programmes.generate_cofo', $application->id)}}">
                                                            <i data-lucide="file-text" class="w-4 h-4 mr-2 inline"></i>
                                                            Generate CofO
                                                        </a>
                                                    @else
                                                        <a href="#" onclick="showPrerequisiteError({{ json_encode($missingItems) }}); return false;" style="color: #dc2626;">
                                                            <i data-lucide="alert-circle" class="w-4 h-4 mr-2 inline"></i>
                                                            Cannot Generate CofO
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            @if($notGeneratedCount == 0)
                                <tr>
                                    <td colspan="10" class="table-cell text-center py-4">No applications pending certificate generation</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                
                <!-- Generated Certificates Table -->
                <div id="content-generated" class="tab-content hidden overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
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
                                @if($application->certificate_issued)
                                    @php $generatedCount++; @endphp
                                    <tr class="text-sm text-gray-700">
                                        <td class="table-cell">{{ $application->fileno }}</td> 
                                        <td class="table-cell">{{ $application->certificate_number ?? 'N/A' }}</td>
                                        <td class="table-cell">{{ $application->Deeds_Serial_No ?? 'N/A' }}</td>
                                        <td class="table-cell">{{ $application->scheme_no }}</td>
                                        <td class="table-cell">{{ $application->owner_name }}</td>
                                        <td class="table-cell">{{ $application->property_lga }}</td>
                                        <td class="table-cell">
                                          {{ $application->block_number ?? 'N/A' }}-{{ $application->floor_number ?? 'N/A' }}-{{ $application->unit_number ?? 'N/A' }}
                                        </td>
                                        <td class="table-cell">{{ $application->land_use }}</td>
                                        <td class="table-cell">
                                            <span class="badge badge-issued">Generated</span>
                                        </td>
                                        <td class="table-cell">
                                            <div class="dropdown">
                                                <button class="dropdown-toggle" onclick="toggleDropdown(this)">
                                                    <i data-lucide="more-horizontal" class="w-5 h-5"></i>
                                                </button>
                                                <div class="dropdown-content">
                                                    <a href="{{ route('sectionaltitling.viewrecorddetail_sub', $application->id) }}">
                                                        <i data-lucide="eye" class="w-4 h-4 mr-2 inline"></i>
                                                        View Application
                                                    </a>
                                                    <a href="{{route('programmes.view_cofo', $application->id)}}">
                                                        <i data-lucide="file-text" class="w-4 h-4 mr-2 inline"></i>
                                                        View Certificate
                                                    </a>
                                                    <a href="{{ route('programmes.view_cofo', $application->id) }}">
                                                        <i data-lucide="printer" class="w-4 h-4 mr-2 inline"></i>
                                                        Print Certificate
                                                    </a>
                                                </div>
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
    // Simple dropdown toggle function
    function toggleDropdown(button) {
        // Close all other dropdowns
        document.querySelectorAll('.dropdown').forEach(dropdown => {
            if (dropdown !== button.parentElement) {
                dropdown.classList.remove('show');
            }
        });
        
        // Toggle current dropdown
        button.parentElement.classList.toggle('show');
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.dropdown')) {
            document.querySelectorAll('.dropdown').forEach(dropdown => {
                dropdown.classList.remove('show');
            });
        }
    });

    // Tab switching functionality
    document.addEventListener('DOMContentLoaded', function() {
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');
        
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                tabButtons.forEach(btn => {
                    btn.classList.remove('border-blue-500', 'text-blue-600');
                    btn.classList.add('border-transparent', 'text-gray-500');
                });
                
                // Add active class to clicked button
                this.classList.add('border-blue-500', 'text-blue-600');
                this.classList.remove('border-transparent', 'text-gray-500');
                
                // Hide all tab contents
                tabContents.forEach(content => {
                    content.classList.add('hidden');
                });
                
                // Show the selected tab content
                const tabKey = this.getAttribute('data-tab');
                document.getElementById('content-' + tabKey).classList.remove('hidden');
            });
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
@endsection