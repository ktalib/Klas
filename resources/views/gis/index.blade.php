@extends('layouts.app')
@section('page-title')
    {{ __('GIS Data Management') }}
@endsection

@include('sectionaltitling.partials.assets.css')
@section('content')
<style>
    /* Required for proper z-index stacking and overflow */
    .dropdown-wrapper { position: relative; }
    .dropdown-menu { z-index: 1000; }
    /* Ensure overflow is visible */
    .overflow-x-auto { overflow-y: visible !important; }
    /* Tab styling */
    .tab-nav { border-bottom: 1px solid #e5e7eb; }
    .tab-nav button { padding: 0.75rem 1.5rem; margin-right: 0.5rem; border-bottom: 2px solid transparent; }
    .tab-nav button.active { border-bottom-color: #10b981; color: #10b981; font-weight: 600; }
    .tab-content > div { display: none; }
    .tab-content > div.active { display: block; }
</style>
<div class="flex-1 overflow-auto">
    <!-- Header -->
    @include('admin.header')
    <!-- Dashboard Content -->
    <div class="p-6">
        <!-- Main Content Container -->
        <div class="bg-white rounded-md shadow-sm border border-gray-200 p-6">
            <!-- Header with actions -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold">GIS Data Records</h2>
               <div class="relative inline-block text-left">
              <button id="survey-dropdown-button" class="flex items-center space-x-2 px-4 py-2 bg-green-700 text-white rounded-md hover:bg-green-800">
              <i data-lucide="plus" class="w-4 h-4"></i>
              <span>Add New Record</span>
              <i data-lucide="chevron-down" class="w-4 h-4"></i>
              </button>
              <div id="survey-dropdown-menu" class="hidden absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10">
              <div class="py-1">
              <a href="{{ route('gis.create', ['is' => 'primary']) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <i data-lucide="file-plus" class="w-4 h-4 mr-2"></i>
                Create Primary GIS
              </a>
              <a href="{{ route('gis.create', ['is' => 'secondary']) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <i data-lucide="layers" class="w-4 h-4 mr-2"></i>
                Create Unit GIS
              </a>
              </div>
              </div>
            </div>
            <script>
              document.addEventListener('DOMContentLoaded', function() {
              const dropdownButton = document.getElementById('survey-dropdown-button');
              const dropdownMenu = document.getElementById('survey-dropdown-menu');
              
              dropdownButton.addEventListener('click', function() {
              dropdownMenu.classList.toggle('hidden');
              });
              
              document.addEventListener('click', function(event) {
              if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
              dropdownMenu.classList.add('hidden');
              }
              });
              });
            </script>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <!-- Tab Navigation -->
            <div class="tab-nav flex mb-4">
                <button class="tab-button active" data-tab="primary-gis">Primary GIS</button>
                <button class="tab-button" data-tab="unit-gis">Unit GIS</button>
            </div>

            <!-- Tab Content -->
            <div class="tab-content">
                <!-- Primary GIS Tab -->
                <div id="primary-gis" class="active">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr class="text-xs">
                                    <th class="table-header text-green-500">MLSF No</th>
                                    <th class="table-header text-green-500">KANGIS File No</th>
                                    <th class="table-header text-green-500">New KANGIS File No</th>
                                    <th class="table-header text-green-500">Plot No</th>
                                    <th class="table-header text-green-500">Block No</th>
                                    <th class="table-header text-green-500">Approved Plan No</th>
                                    <th class="table-header text-green-500">TP Plan No</th>
                                    <th class="table-header text-green-500">Old Title Serial No</th>
                                    <th class="table-header text-green-500">Old Title Page No</th>
                                    <th class="table-header text-green-500">Old Title Volume No</th>
                                    <th class="table-header text-green-500">Created At</th>
                                    <th class="table-header text-green-500">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($primaryGisData as $data)
                                <tr class="text-xs">
                                    <td class="table-cell px-1 py-1 truncate">{{ $data->mlsfNo ?? 'N/A' }}</td>
                                    <td class="table-cell px-1 py-1 truncate">{{ $data->kangisFileNo ?? 'N/A' }}</td>
                                    <td class="table-cell px-1 py-1 truncate">{{ $data->NewKANGISFileno ?? 'N/A' }}</td>
                                    <td class="table-cell px-1 py-1 truncate">{{ $data->plotNo ?? 'N/A' }}</td>
                                    <td class="table-cell px-1 py-1 truncate">{{ $data->blockNo ?? 'N/A' }}</td>
                                    <td class="table-cell px-1 py-1 truncate">{{ $data->approvedPlanNo ?? 'N/A' }}</td>
                                    <td class="table-cell px-1 py-1 truncate">{{ $data->tpPlanNo ?? 'N/A' }}</td>
                                    <td class="table-cell px-1 py-1 truncate">{{ $data->oldTitleSerialNo ?? 'N/A' }}</td>
                                    <td class="table-cell px-1 py-1 truncate">{{ $data->oldTitlePageNo ?? 'N/A' }}</td>
                                    <td class="table-cell px-1 py-1 truncate">{{ $data->oldTitleVolumeNo ?? 'N/A' }}</td>
                                    <td class="table-cell px-1 py-1 truncate">{{ $data->created_at ? date('d M, Y', strtotime($data->created_at)) : 'N/A' }}</td>
                                    <td class="table-cell px-1 py-1 truncate">
                                        <div class="dropdown-wrapper" x-data="{ open: false, toggle() { this.open = !this.open; } }">
                                            <button x-ref="button" @click.prevent="toggle()" class="text-gray-600 hover:text-blue-600 p-1 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 ml-auto block">
                                                <i data-lucide="more-vertical" class="h-5 w-5"></i>
                                            </button>
                                            
                                            <div x-ref="dropdown" x-show="open" @click.away="open = false" x-transition
                                                class="dropdown-menu w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5"
                                                style="display: none; z-index: 9999;">
                                                <div class="py-1">
                                                    <a href="{{ route('gis.view', $data->id) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                        <i data-lucide="eye" class="h-4 w-4 mr-2 text-gray-500"></i>
                                                        View
                                                    </a>
                                                    <a href="{{ route('gis.edit', $data->id) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                        <i data-lucide="edit" class="h-4 w-4 mr-2 text-gray-500"></i>
                                                        Edit
                                                    </a>
                                                    <form action="{{ route('gis.destroy', $data->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" onclick="return confirm('Are you sure you want to delete this record?')" 
                                                            class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                                            <i data-lucide="trash" class="h-4 w-4 mr-2 text-red-500"></i>
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Unit GIS Tab -->
                <div id="unit-gis">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr class="text-xs">
                                    <th class="table-header text-green-500">ST File No</th>
                                    <th class="table-header text-green-500">Primary GIS ID</th>
                                    <th class="table-header text-green-500">Scheme No</th>
                                    <th class="table-header text-green-500">Section No</th>
                                    <th class="table-header text-green-500">Block No</th>
                                    <th class="table-header text-green-500">Unit No</th>
                                    <th class="table-header text-green-500">Land Use</th>
                                    <th class="table-header text-green-500">Unit Size</th>
                                    <th class="table-header text-green-500">Plot No</th>
                                    <th class="table-header text-green-500">Created At</th>
                                    <th class="table-header text-green-500">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($unitGisData as $data)
                                <tr class="text-xs">
                                    <td class="table-cell px-1 py-1 truncate">{{ $data->STFileNo ?? 'N/A' }}</td>
                                    <td class="table-cell px-1 py-1 truncate">{{ $data->PrimaryGISID ?? 'N/A' }}</td>
                                    <td class="table-cell px-1 py-1 truncate">{{ $data->scheme_no ?? 'N/A' }}</td>
                                    <td class="table-cell px-1 py-1 truncate">{{ $data->section_no ?? 'N/A' }}</td>
                                    <td class="table-cell px-1 py-1 truncate">{{ $data->block_no ?? 'N/A' }}</td>
                                    <td class="table-cell px-1 py-1 truncate">{{ $data->unit_no ?? 'N/A' }}</td>
                                    <td class="table-cell px-1 py-1 truncate">{{ $data->landuse ?? 'N/A' }}</td>
                                    <td class="table-cell px-1 py-1 truncate">{{ $data->UnitSize ?? 'N/A' }}</td>
                                    <td class="table-cell px-1 py-1 truncate">{{ $data->plotNo ?? 'N/A' }}</td>
                                    <td class="table-cell px-1 py-1 truncate">{{ $data->created_at ? date('d M, Y', strtotime($data->created_at)) : 'N/A' }}</td>
                                    <td class="table-cell px-1 py-1 truncate">
                                        <div class="dropdown-wrapper" x-data="{ open: false, toggle() { this.open = !this.open; } }">
                                            <button x-ref="button" @click.prevent="toggle()" class="text-gray-600 hover:text-blue-600 p-1 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 ml-auto block">
                                                <i data-lucide="more-vertical" class="h-5 w-5"></i>
                                            </button>
                                            
                                            <div x-ref="dropdown" x-show="open" @click.away="open = false" x-transition
                                                class="dropdown-menu w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5"
                                                style="display: none; z-index: 9999;">
                                                <div class="py-1">
                                                    <a href="{{ route('gis.view', $data->id) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                        <i data-lucide="eye" class="h-4 w-4 mr-2 text-gray-500"></i>
                                                        View
                                                    </a>
                                                    <a href="{{ route('gis.edit', $data->id) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                        <i data-lucide="edit" class="h-4 w-4 mr-2 text-gray-500"></i>
                                                        Edit
                                                    </a>
                                                    <form action="{{ route('gis.destroy', $data->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" onclick="return confirm('Are you sure you want to delete this record?')" 
                                                            class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                                            <i data-lucide="trash" class="h-4 w-4 mr-2 text-red-500"></i>
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
    @include('admin.footer')
</div>
 
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
        
        // Tab functionality
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content > div');
        
        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                const tabId = button.getAttribute('data-tab');
                
                // Remove active class from all buttons and content
                tabButtons.forEach(btn => btn.classList.remove('active'));
                tabContents.forEach(content => content.classList.remove('active'));
                
                // Add active class to current button and content
                button.classList.add('active');
                document.getElementById(tabId).classList.add('active');
            });
        });
    });
</script>
@endsection
