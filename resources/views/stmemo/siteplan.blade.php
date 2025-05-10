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
             <div class="mb-6">
                 <div class="border-b border-gray-200">
                     <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                         <button type="button" class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm border-blue-500 text-blue-600 active" data-tab="all">
                             All Applications
                             <span class="bg-gray-100 text-gray-600 ml-2 py-0.5 px-2.5 rounded-full">{{ count($PrimaryApplications) }}</span>
                         </button>
                         <button type="button" class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="uploaded">
                             Uploaded Site Plans
                             <span class="bg-green-100 text-green-600 ml-2 py-0.5 px-2.5 rounded-full">{{ count($PrimaryApplications->where('site_plan_status', 'Uploaded')) }}</span>
                         </button>
                         <button type="button" class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="not-uploaded">
                             Pending Site Plans
                             <span class="bg-red-100 text-red-600 ml-2 py-0.5 px-2.5 rounded-full">{{ count($PrimaryApplications->where('site_plan_status', '!=', 'Uploaded')) }}</span>
                         </button>
                     </nav>
                 </div>
             </div>

             <!-- Primary Applications Table -->
             <div class="bg-white rounded-md shadow-sm border border-gray-200 p-6">
                 <div class="flex justify-between items-center mb-6">
                     <h2 class="text-xl font-bold">Primary Applications</h2>
                     @if (isset($useFilter) && !$useFilter)
                         <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-2 rounded">
                             <p class="text-sm">
                                 <i data-lucide="alert-triangle" class="w-4 h-4 inline mr-1"></i>
                                 Showing all applications with sub-units because no applications matched the sectional
                                 titling filter.
                                 <a href="{{ route('stmemo.stmemo', ['filter' => true]) }}" class="underline">Apply
                                     filter</a>
                             </p>
                         </div>
                     @endif
                     {{-- <a href="{{ route('other_departments.survey_secondary') }}"
                         class="flex items-center space-x-2 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                         <i data-lucide="clipboard-list" class="w-4 h-4"></i>
                         <span>View Secondary Applications</span>
                     </a> --}}
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
                                 <th class="table-header text-green-500">Status</th>

                                 <th class="table-header text-green-500">Actions</th>
                             </tr>
                         </thead>
                         <tbody class="bg-white divide-y divide-gray-200">
                             @foreach ($PrimaryApplications as $PrimaryApplication)
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
                                         @if ($PrimaryApplication->site_plan_status == 'Uploaded')
                                             <span class="inline-block px-2 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded">Uploaded</span>
                                         @else
                                             <span class="inline-block px-2 py-1 text-xs font-semibold bg-red-100 text-red-700 rounded">Not Uploaded</span>
                                         @endif
                                     </td>

                                     <td class="table-cell overflow-visible relative">
                                         <button
                                             class="flex items-center px-2 py-1 text-xs border border-gray-200 rounded-md bg-white hover:bg-gray-50"
                                             onclick="toggleDropdown(event)">
                                             <i data-lucide="more-horizontal" class="w-4 h-4"></i>
                                         </button>
                                         <div
                                             class="dropdown-menu hidden absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-md z-10">
                                             <ul class="py-2">
                                                 <li>
                                                     <a href="{{ route('sectionaltitling.viewrecorddetail') }}?id={{ $PrimaryApplication->id }}"
                                                         class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                         <i data-lucide="eye" class="w-4 h-4 text-blue-500"></i>
                                                         View Application
                                                     </a>
                                                 </li>

                                                 <li>
                                                     <a href="{{ route('stmemo.uploadSitePlan', $PrimaryApplication->id) }}"
                                                         class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                         <i data-lucide="upload" class="w-4 h-4 text-green-500"></i>
                                                         Upload Site Plan
                                                     </a>
                                                 </li>

                                                 <li>
                                                     <a href="{{ route('stmemo.viewSitePlan', $PrimaryApplication->id) }}"
                                                         class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                         <i data-lucide="eye" class="w-4 h-4 text-blue-500"></i>
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
             if (dropdownMenu) {
                 dropdownMenu.classList.toggle('hidden');
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
                 title: 'Generate ST Memo',
                 text: 'Are you sure you want to generate a Sectional Titling Memo for this application?',
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

         // New Tab functionality
         document.addEventListener('DOMContentLoaded', function() {
             const tabButtons = document.querySelectorAll('.tab-button');
             const applicationRows = document.querySelectorAll('.application-row');
             
             // Function to filter rows based on selected tab
             function filterRows(tabId) {
                 applicationRows.forEach(row => {
                     if (tabId === 'all') {
                         row.classList.remove('hidden');
                     } else if (tabId === 'uploaded') {
                         if (row.dataset.status === 'uploaded') {
                             row.classList.remove('hidden');
                         } else {
                             row.classList.add('hidden');
                         }
                     } else if (tabId === 'not-uploaded') {
                         if (row.dataset.status === 'not-uploaded') {
                             row.classList.remove('hidden');
                         } else {
                             row.classList.add('hidden');
                         }
                     }
                 });
             }
             
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
                     
                     // Filter rows based on selected tab
                     filterRows(this.dataset.tab);
                 });
             });
         });
     </script>
 @endsection
