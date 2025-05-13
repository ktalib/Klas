@extends('layouts.app')
@section('page-title')
    {{ $PageTitle }}
@endsection

@include('sectionaltitling.partials.assets.css')
@section('content')
    <!-- Main Content -->
    <div class="flex-1 overflow-auto">
        <!-- Header -->
        @include('admin.header')
        <!-- Dashboard Content -->
        <div class="p-6">
            <!-- Tab Navigation -->


            <!-- Primary Applications Table -->
            <div class="bg-white rounded-md shadow-sm border border-gray-200 p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold">Primary Applications</h2>


                    <!-- Smart Search Input -->
                    <div class="relative flex-grow mx-4">
                        <div class="flex items-center space-x-2">
                            <!-- Search Icon Button -->
                            <button id="show-search-btn" type="button"
                                class="flex items-center justify-center w-10 h-10 rounded-full border border-gray-300 bg-white hover:bg-gray-100 focus:outline-none">
                                <i data-lucide="search" class="h-5 w-5 text-gray-500"></i>
                            </button>
                            <!-- Search Input (hidden by default) -->
                            <div id="search-input-container" class="relative hidden flex-grow">
                                <input type="text" id="smart-search" placeholder="Search applications..."
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i data-lucide="search" class="h-5 w-5 text-gray-400"></i>
                                </div>
                                <button id="clear-search"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 hidden">
                                    <i data-lucide="x" class="h-4 w-4"></i>
                                </button>
                                <div id="search-info" class="absolute mt-1 text-xs text-gray-500 hidden">
                                    Found <span id="search-count">0</span> results
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const showSearchBtn = document.getElementById('show-search-btn');
                            const searchInputContainer = document.getElementById('search-input-container');
                            const smartSearch = document.getElementById('smart-search');
                            // Show search input when icon is clicked
                            showSearchBtn.addEventListener('click', function() {
                                searchInputContainer.classList.remove('hidden');
                                smartSearch.focus();
                                showSearchBtn.classList.add('hidden');
                            });
                            // Hide search input when input loses focus and is empty
                            smartSearch.addEventListener('blur', function() {
                                setTimeout(function() {
                                    if (smartSearch.value.trim() === '') {
                                        searchInputContainer.classList.add('hidden');
                                        showSearchBtn.classList.remove('hidden');
                                    }
                                }, 150);
                            });
                        });
                    </script>

                    <div class="flex items-center space-x-4">

                        <div class="relative">
                            <select
                                class="pl-4 pr-8 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none">
                                <option>All...</option>
                                <option>Approved</option>
                                <option>Pending</option>
                                <option>Declined</option>
                            </select>
                            <i data-lucide="chevron-down"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-4 h-4"></i>
                        </div>

                        <style>
                            button:hover {
                                background-color: #fed7aa;
                            }
                        </style>

                        <button class="flex items-center space-x-2 px-4 py-2 border border-gray-200 rounded-md">
                            <i data-lucide="download" class="w-4 h-4 text-gray-600"></i>
                            <span>Export</span>
                        </button>


                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table id="applications-table" class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="text-xs">
                                <th class="table-header text-green-500">ID</th>
                                <th class="table-header text-green-500">File No</th>
                                <th class="table-header text-green-500">Property</th>
                                <th class="table-header text-green-500">Type</th>
                                <th class="table-header text-green-500">Land Use</th>
                                <th class="table-header text-green-500">Owner</th>
                                <th class="table-header text-green-500">Units</th>
                                <th class="table-header text-green-500">ST Memo Status</th>
                                <th class="table-header text-green-500">Site Plan Status</th>
                                <th class="table-header text-green-500">Approval Status</th>
                                <th class="table-header text-green-500">Planning Recommendation Status</th>
                                <th class="table-header text-green-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($PrimaryApplications as $PrimaryApplication)
                                @php
                                    $sitePlanDimensionExists = DB::connection('sqlsrv')
                                        ->table('site_plan_dimensions')
                                        ->where('application_id', $PrimaryApplication->id)
                                        ->exists();

                                    $memoStatus = DB::connection('sqlsrv')
                                        ->table('memos')
                                        ->where('application_id', $PrimaryApplication->id)
                                        ->where('memo_status', 'GENERATED')
                                        ->where('memo_type', 'st_memo')
                                        ->exists();

                                    $approvalStatus = strtolower($PrimaryApplication->planning_recommendation_status) === 'approved';
                                    $sitePlanUploaded = $PrimaryApplication->site_plan_status == 'Uploaded';
                                    $stMemoGenerated = $memoStatus;
                                @endphp
                                <tr class="text-xs application-row"
                                    data-status="{{ $PrimaryApplication->site_plan_status == 'Uploaded' ? 'uploaded' : 'not-uploaded' }}">
                                    <td class="table-cell">ST-2025-0{{ $PrimaryApplication->id }}</td>
                                    <td class="table-cell">{{ $PrimaryApplication->fileno }}</td>
                                    <td class="table-cell">
                                        <div class="truncate max-w-[150px]"
                                            title="{{ $PrimaryApplication->property_plot_no }} {{ $PrimaryApplication->property_street_name }}, {{ $PrimaryApplication->property_lga }}">
                                            {{ $PrimaryApplication->property_plot_no }}
                                            {{ $PrimaryApplication->property_street_name }},
                                            {{ $PrimaryApplication->property_lga }}
                                        </div>
                                    </td>
                                    <td class="table-cell">
                                        @if ($PrimaryApplication->commercial_type)
                                            {{ $PrimaryApplication->commercial_type }}
                                        @elseif ($PrimaryApplication->industrial_type)
                                            {{ $PrimaryApplication->industrial_type }}
                                        @elseif ($PrimaryApplication->mixed_type)
                                            {{ $PrimaryApplication->mixed_type }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="table-cell">{{ $PrimaryApplication->land_use }}</td>
                                    <td class="table-cell">
                                        <div class="flex items-center">
                                            <div
                                                class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center mr-2">
                                                @if ($PrimaryApplication->passport)
                                                    <img src="{{ asset('storage/app/public/' . $PrimaryApplication->passport) }}"
                                                        alt="Passport"
                                                        class="w-full h-full rounded-full object-cover cursor-pointer"
                                                        onclick="showPassportPreview('{{ asset('storage/app/public/' . $PrimaryApplication->passport) }}', 'Owner Passport')">
                                                @elseif ($PrimaryApplication->multiple_owners_passport)
                                                    @php
                                                        $passports = json_decode(
                                                            $PrimaryApplication->multiple_owners_passport,
                                                            true,
                                                        );
                                                        $firstPassport = $passports[0] ?? null;
                                                    @endphp
                                                    @if ($firstPassport)
                                                        <img src="{{ asset('storage/app/public/' . $firstPassport) }}"
                                                            alt="Passport"
                                                            class="w-full h-full rounded-full object-cover cursor-pointer"
                                                            onclick="showMultipleOwners({{ $PrimaryApplication->multiple_owners_names }}, {{ $PrimaryApplication->multiple_owners_passport }})">
                                                    @endif
                                                @endif
                                            </div>
                                            <span class="truncate max-w-[120px]">
                                                @if ($PrimaryApplication->corporate_name)
                                                    {{ $PrimaryApplication->corporate_name }}
                                                @elseif($PrimaryApplication->multiple_owners_names)
                                                    @php
                                                        $ownerNames = json_decode(
                                                            $PrimaryApplication->multiple_owners_names,
                                                            true,
                                                        );
                                                        $firstOwner = $ownerNames[0] ?? 'Unknown Owner';
                                                    @endphp
                                                    {{ $firstOwner }}
                                                    <span class="ml-1 cursor-pointer text-blue-500"
                                                        onclick="showMultipleOwners({{ $PrimaryApplication->multiple_owners_names }}, {{ $PrimaryApplication->multiple_owners_passport }})">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </span>
                                                @elseif($PrimaryApplication->first_name || $PrimaryApplication->surname)
                                                    {{ $PrimaryApplication->first_name }}
                                                    {{ $PrimaryApplication->surname }}
                                                @else
                                                    Unknown Owner
                                                @endif
                                            </span>
                                        </div>
                                    </td>
                                    <td class="table-cell">{{ $PrimaryApplication->NoOfUnits }}</td>
                                    <td class="table-cell">
                                        @if($memoStatus)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <svg class="mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                                                    <circle cx="4" cy="4" r="3" />
                                                </svg>
                                                Generated
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                <svg class="mr-1.5 h-2 w-2 text-gray-400" fill="currentColor" viewBox="0 0 8 8">
                                                    <circle cx="4" cy="4" r="3" />
                                                </svg>
                                                Not Generated
                                            </span>
                                        @endif
                                    </td>
                                    <td class="table-cell">
                                        @if ($PrimaryApplication->site_plan_status == 'Uploaded')
                                            <span
                                                class="inline-block px-2 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded">Uploaded</span>
                                        @else
                                            <span
                                                class="inline-block px-2 py-1 text-xs font-semibold bg-red-100 text-red-700 rounded">Not
                                                Uploaded</span>
                                        @endif
                                    </td>
                                    <td class="table-cell">
                                        <div class="flex items-center">
                                            <span class="badge badge-{{ strtolower($PrimaryApplication->planning_recommendation_status) }}">
                                                {{ $PrimaryApplication->planning_recommendation_status }}
                                            </span>
                                            @if($PrimaryApplication->planning_recommendation_status == 'Declined')
                                                <i data-lucide="info" class="w-4 h-4 ml-1 text-blue-500 cursor-pointer" 
                                                   onclick="showDeclinedInfo(event, 'Planning Recommendation', {{ json_encode($PrimaryApplication->recomm_comments) }}, {{ json_encode($PrimaryApplication->director_comments) }})"></i>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="table-cell">
                                        @if($sitePlanDimensionExists)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <svg class="mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                                                    <circle cx="4" cy="4" r="3" />
                                                </svg>
                                               Approved
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                <svg class="mr-1.5 h-2 w-2 text-gray-400" fill="currentColor" viewBox="0 0 8 8">
                                                    <circle cx="4" cy="4" r="3" />
                                                </svg>
                                               Pending
                                            </span>
                                        @endif
                                    </td>
                                    <td class="table-cell overflow-visible relative">
                                        <button
                                            class="flex items-center px-2 py-1 text-xs border border-gray-200 rounded-md bg-white hover:bg-gray-50"
                                            onclick="toggleDropdown(event)">
                                            <i data-lucide="more-horizontal" class="w-4 h-4"></i>
                                        </button>
                                        <div
                                            class="dropdown-menu hidden absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-md z-50">
                                            <ul class="py-2">
                                                <li>
                                                    <a href="{{ route('sectionaltitling.viewrecorddetail') }}?id={{ $PrimaryApplication->id }}"
                                                        class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                        <i data-lucide="eye" class="w-4 h-4 text-blue-500"></i>
                                                        View Application
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('actions.recommendation' , ['id' => $PrimaryApplication->id]) }}?url=phy_planning"
                                                        class="flex items-center gap-2 px-4 py-2 text-sm {{ $approvalStatus ? 'text-gray-400 cursor-not-allowed bg-gray-50' : 'text-gray-700 hover:bg-gray-100' }}"
                                                        @if($approvalStatus) tabindex="-1" aria-disabled="true" onclick="return false;" @endif>
                                                        <i data-lucide="check-circle" class="w-4 h-4 {{ $approvalStatus ? 'text-gray-400' : 'text-green-500' }}"></i>
                                                        Approval
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('actions.recommendation' , ['id' => $PrimaryApplication->id]) }}?url=recommendation"
                                                        class="flex items-center gap-2 px-4 py-2 text-"
                                                      >
                                                        <i data-lucide="file-text" class="w-4 h-4 text-yellow-500"></i>
                                                        Planning Recommendation
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)"
                                                        onclick="if(!{{ $stMemoGenerated ? 'true' : 'false' }}) generateSTMemo({{ $PrimaryApplication->id }})"
                                                        class="flex items-center gap-2 px-4 py-2 text-sm {{ $stMemoGenerated ? 'text-gray-400 cursor-not-allowed bg-gray-50' : 'text-gray-700 hover:bg-gray-100' }}"
                                                        @if($stMemoGenerated) tabindex="-1" aria-disabled="true" @endif>
                                                        <i data-lucide="check" class="w-4 h-4 {{ $stMemoGenerated ? 'text-gray-400' : 'text-red-500' }}"></i>
                                                        Generate ST Memo
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('stmemo.view', $PrimaryApplication->id) }}"
                                                        class="flex items-center gap-2 px-4 py-2 text-sm {{ $stMemoGenerated ? 'text-gray-700 hover:bg-gray-100' : 'text-gray-400 cursor-not-allowed bg-gray-50' }}"
                                                        @if(!$stMemoGenerated) tabindex="-1" aria-disabled="true" onclick="return false;" @endif>
                                                        <i data-lucide="eye" class="w-4 h-4 {{ $stMemoGenerated ? 'text-blue-500' : 'text-gray-400' }}"></i>
                                                        View ST Memo
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('stmemo.uploadSitePlan', $PrimaryApplication->id) }}"
                                                        class="flex items-center gap-2 px-4 py-2 text-sm {{ $sitePlanUploaded ? 'text-gray-400 cursor-not-allowed bg-gray-50' : 'text-gray-700 hover:bg-gray-100' }}"
                                                        @if($sitePlanUploaded) tabindex="-1" aria-disabled="true" onclick="return false;" @endif>
                                                        <i data-lucide="upload" class="w-4 h-4 {{ $sitePlanUploaded ? 'text-gray-400' : 'text-green-500' }}"></i>
                                                        Upload Site Plan
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('stmemo.viewSitePlan', $PrimaryApplication->id) }}"
                                                        class="flex items-center gap-2 px-4 py-2 text-sm {{ $sitePlanUploaded ? 'text-gray-700 hover:bg-gray-100' : 'text-gray-400 cursor-not-allowed bg-gray-50' }}"
                                                        @if(!$sitePlanUploaded) tabindex="-1" aria-disabled="true" onclick="return false;" @endif>
                                                        <i data-lucide="eye" class="w-4 h-4 {{ $sitePlanUploaded ? 'text-blue-500' : 'text-gray-400' }}"></i>
                                                        View Site Plan
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- No Results Message -->
                <div id="no-results-message" class="hidden py-8 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                        <i data-lucide="search-x" class="h-8 w-8 text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">No matching applications found</h3>
                    <p class="text-gray-500">Try adjusting your search or filter criteria</p>
                </div>

                <div class="flex justify-between items-center mt-6 text-sm">
                    <div class="text-gray-500">Showing 5 of 68 applications</div>
                    <div class="flex items-center space-x-2">
                        <button class="px-3 py-1 border border-gray-200 rounded-md flex items-center">
                            <i data-lucide="chevron-left" class="w-4 h-4 mr-1"></i>
                            <span>Previous</span>
                        </button>
                        <button class="px-3 py-1 border border-gray-200 rounded-md flex items-center">
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

    @include('sectionaltitling.action_modals.eRegistry_modal')

    <script>
        function toggleDropdown(event) {
            event.stopPropagation();
            const dropdownMenu = event.currentTarget.nextElementSibling;
            
            // Hide all other dropdowns first
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                if (menu !== dropdownMenu) menu.classList.add('hidden');
            });
            
            if (dropdownMenu) {
                // Toggle visibility
                const isHidden = dropdownMenu.classList.toggle('hidden');
                
                if (!isHidden) {
                    // Check if dropdown would go off-screen
                    const buttonRect = event.currentTarget.getBoundingClientRect();
                    const tableBottom = document.querySelector('.overflow-x-auto').getBoundingClientRect().bottom;
                    const dropdownHeight = dropdownMenu.offsetHeight;
                    
                    // Position dropdown above or below based on available space
                    if (buttonRect.bottom + dropdownHeight > tableBottom) {
                        dropdownMenu.style.bottom = "100%";
                        dropdownMenu.style.top = "auto";
                        dropdownMenu.style.marginTop = "0";
                        dropdownMenu.style.marginBottom = "0.5rem";
                    } else {
                        dropdownMenu.style.top = "100%";
                        dropdownMenu.style.bottom = "auto";
                        dropdownMenu.style.marginTop = "0.5rem";
                        dropdownMenu.style.marginBottom = "0";
                    }
                }
            }
        }

        document.addEventListener('click', () => {
            const dropdownMenus = document.querySelectorAll('.dropdown-menu');
            dropdownMenus.forEach(menu => menu.classList.add('hidden'));
        });

        function showPassportPreview(imageSrc, title) {
            Swal.fire({
                title: title,
                html: `<img src="${imageSrc}" class="img-fluid" style="max-height: 400px;">`,
                width: 'auto',
                showCloseButton: true,
                showConfirmButton: false
            });
        }

        function showMultipleOwners(owners, passports) {
            if (Array.isArray(owners) && owners.length > 0) {
                let htmlContent = '<div class="grid grid-cols-3 gap-4" style="max-width: 600px;">';

                owners.forEach((name, index) => {
                    const passport = Array.isArray(passports) && passports[index] ?
                        `<img src="{{ asset('storage/app/public/') }}/${passports[index]}" 
                                      class="w-24 h-32 object-cover mx-auto border-2 border-gray-300" 
                                      style="object-position: center top;">` :
                        '<div class="w-24 h-32 bg-gray-300 mx-auto flex items-center justify-center"><span>No Image</span></div>';

                    htmlContent += `
                                <div class="flex flex-col items-center">
                                     <div class="passport-container bg-blue-50 p-2 rounded">
                                          ${passport}
                                          <p class="text-center text-sm font-medium mt-1">${name}</p>
                                     </div>
                                </div>
                          `;
                });

                htmlContent += '</div>';

                Swal.fire({
                    title: 'Multiple Owners',
                    html: htmlContent,
                    width: 'auto',
                    showCloseButton: true,
                    showConfirmButton: false
                });
            } else {
                Swal.fire({
                    title: 'Multiple Owners',
                    text: 'No owners available',
                    icon: 'info',
                    confirmButtonText: 'Close'
                });
            }
        }

        function showDeclinedInfo(event, title, recommComments, directorComments) {
            event.stopPropagation();

            let htmlContent = '<div class="text-left">';
            if (recommComments) {
                htmlContent += `
                          <div class="mb-3">
                                <h3 class="font-bold text-gray-700">Recommendation Comments:</h3>
                                <p class="text-gray-600 mt-1 p-2 bg-gray-100 rounded">${recommComments}</p>
                          </div>
                     `;
            }

            if (directorComments) {
                htmlContent += `
                          <div>
                                <h3 class="font-bold text-gray-700">Director Comments:</h3>
                                <p class="text-gray-600 mt-1 p-2 bg-gray-100 rounded">${directorComments}</p>
                          </div>
                     `;
            }

            if (!recommComments && !directorComments) {
                htmlContent += '<p>No comments available.</p>';
            }

            htmlContent += '</div>';

            Swal.fire({
                title: `Declined: ${title}`,
                html: htmlContent,
                icon: 'info',
                width: 'auto',
                showCloseButton: true,
                showConfirmButton: true,
                confirmButtonText: 'Close'
            });
        }

        // New function to handle "Generate ST Memo" action
        function generateSTMemo(applicationId) {
            Swal.fire({
                title: 'Generate Physical Planning Memo',
                text: 'Are you sure you want to physical planning memo for this application?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, generate it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ url('/stmemo/generate') }}/" + applicationId;
                }
            });
        }

        // New Tab and Search functionality
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-button');
            const applicationRows = document.querySelectorAll('.application-row');
            const searchInput = document.getElementById('smart-search');
            const clearSearchBtn = document.getElementById('clear-search');
            const searchInfo = document.getElementById('search-info');
            const searchCount = document.getElementById('search-count');
            const noResultsMessage = document.getElementById('no-results-message');
            const table = document.getElementById('applications-table');

            let currentTab = 'all';

            // Function to filter rows based on selected tab and search input
            function filterRows() {
                const searchTerm = searchInput.value.toLowerCase().trim();
                let visibleCount = 0;
                let totalRowsInTab = 0;

                applicationRows.forEach(row => {
                    // First filter by tab
                    const matchesTab = (currentTab === 'all') ||
                        (currentTab === 'uploaded' && row.dataset.status === 'uploaded') ||
                        (currentTab === 'not-uploaded' && row.dataset.status === 'not-uploaded');

                    if (matchesTab) {
                        totalRowsInTab++;

                        // Then filter by search term if one exists
                        if (searchTerm === '') {
                            row.classList.remove('hidden');
                            visibleCount++;
                        } else {
                            const rowText = row.textContent.toLowerCase();
                            if (rowText.includes(searchTerm)) {
                                row.classList.remove('hidden');
                                visibleCount++;
                            } else {
                                row.classList.add('hidden');
                            }
                        }
                    } else {
                        row.classList.add('hidden');
                    }
                });

                // Update search info
                if (searchTerm === '') {
                    searchInfo.classList.add('hidden');
                    clearSearchBtn.classList.add('hidden');
                } else {
                    searchCount.textContent = visibleCount;
                    searchInfo.classList.remove('hidden');
                    clearSearchBtn.classList.remove('hidden');
                }

                // Show/hide no results message
                if (visibleCount === 0 && totalRowsInTab > 0) {
                    table.classList.add('hidden');
                    noResultsMessage.classList.remove('hidden');
                } else {
                    table.classList.remove('hidden');
                    noResultsMessage.classList.add('hidden');
                }
            }

            // Add search input event listener
            searchInput.addEventListener('input', filterRows);

            // Add clear search button event listener
            clearSearchBtn.addEventListener('click', function() {
                searchInput.value = '';
                filterRows();
                searchInput.focus();
            });

            // Add click event listeners to tab buttons
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    tabButtons.forEach(btn => {
                        btn.classList.remove('active', 'border-blue-500', 'text-blue-600');
                        btn.classList.add('border-transparent', 'text-gray-500');
                    });

                    // Add active class to clicked button
                    this.classList.add('active', 'border-blue-500', 'text-blue-600');
                    this.classList.remove('border-transparent', 'text-gray-500');

                    // Update current tab
                    currentTab = this.dataset.tab;

                    // Filter rows based on selected tab and current search
                    filterRows();
                });
            });

            // Initialize
            filterRows();
        });
    </script>
@endsection
