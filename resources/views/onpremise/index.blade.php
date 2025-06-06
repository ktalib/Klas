@extends('layouts.app')
@section('page-title')
    {{ __('Legal Search - On-Premise Official
') }}
@endsection

 
@section('content')

    <!-- Main Content -->
    <div class="flex-1 overflow-auto">
        <!-- Header -->
        @include('admin.header')
        <!-- Dashboard Content -->
        <div class="p-6">
             
  
  <style>
    /* Base styles */
    body {
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
      color: #111827;
      background-color: #f9fafb;
    }
    
    /* Custom components */
    .badge {
      display: inline-flex;
      align-items: center;
      border-radius: 9999px;
      padding: 0.25rem 0.75rem;
      font-size: 0.75rem;
      font-weight: 500;
      line-height: 1;
    }
    
    .badge-outline {
      background-color: transparent;
      border: 1px solid #e5e7eb;
    }
    
    .badge-destructive {
      background-color: #ef4444;
      color: white;
    }
    
    /* Modal styles */
    .modal-overlay {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: rgba(0, 0, 0, 0.5);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 50;
    }
    
    .modal-content {
      background-color: white;
      border-radius: 0.5rem;
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
      width: 95%;
      max-width: 95%;
      max-height: 90vh;
      overflow: hidden;
      display: flex;
      flex-direction: column;
    }
    
    .modal-header {
      padding: 1.5rem;
      border-bottom: 1px solid #e5e7eb;
    }
    
    .modal-title {
      font-size: 1.25rem;
      font-weight: 600;
    }
    
    .search-section {
      padding: 1rem 1.5rem;
      border-bottom: 1px solid #e5e7eb;
    }
    
    .results-section {
      flex-grow: 1;
      overflow: auto;
      padding: 1.5rem;
    }
    
    /* Loading spinner */
    .spinner {
      border: 4px solid rgba(0, 0, 0, 0.1);
      width: 36px;
      height: 36px;
      border-radius: 50%;
      border-left-color: #000;
      animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }
      100% {
        transform: rotate(360deg);
      }
    }
    
    /* Tab styles */
    .tabs {
      display: flex;
      border-bottom: 1px solid #e5e7eb;
    }
    
    .tab {
      padding: 0.75rem 1rem;
      font-size: 0.875rem;
      font-weight: 500;
      cursor: pointer;
      border-bottom: 2px solid transparent;
      color: #6b7280;
    }
    
    .tab.active {
      border-bottom-color: #000;
      color: #000;
      font-weight: 600;
    }
    
    .tab-content {
      display: none;
    }
    
    .tab-content.active {
      display: block;
    }
    
    /* Table styles */
    table {
      width: 100%;
      border-collapse: collapse;
    }
    
    th {
      text-align: left;
      padding: 0.75rem 1rem;
      font-size: 0.75rem;
      font-weight: 500;
      color: #6b7280;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      background-color: #f9fafb;
      border-bottom: 1px solid #e5e7eb;
    }
    
    td {
      padding: 0.75rem 1rem;
      font-size: 0.875rem;
      border-bottom: 1px solid #e5e7eb;
    }
    
    tr:hover {
      background-color: #f9fafb;
    }
    
    /* Select dropdown fix */
    .select-wrapper {
      position: relative;
      width: 100%;
    }
    
    .select {
      appearance: none;
      width: 100%;
      padding: 0.5rem 2.5rem 0.5rem 0.75rem;
      font-size: 0.875rem;
      line-height: 1.25rem;
      border: 1px solid #e5e7eb;
      border-radius: 0.375rem;
      background-color: white;
    }
    
    .select-icon {
      position: absolute;
      right: 0.75rem;
      top: 50%;
      transform: translateY(-50%);
      pointer-events: none;
    }
    
    /* Form field styles */
    .form-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 0.75rem;
    }
    
    .form-label {
      font-size: 0.875rem;
      color: #6b7280;
      width: 40%;
      padding-top: 0.25rem;
    }
    
    .form-value {
      font-size: 0.875rem;
      font-weight: 500;
      width: 60%;
      text-align: right;
    }
    
    /* Status indicator */
    .status-indicator {
      display: inline-block;
      width: 0.75rem;
      height: 0.75rem;
      border-radius: 50%;
      margin-right: 0.5rem;
    }
    
    /* Hide elements */
    .hidden {
      display: none;
    }
  </style>


  <!-- Main Content -->
  <main class="flex-1 p-6">
    <div id="dashboard-view" class="space-y-6">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card 1: Official Search -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
          <div class="p-6">
            <div class="flex items-center gap-2 mb-1">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
              <h3 class="text-lg font-semibold">Official Search</h3>
            </div>
            <p class="text-sm text-gray-500 mb-4">Find legal records for Official purposes</p>
            <p class="text-sm text-gray-500 mb-4">
              Conduct legal searches for Official purposes with extended access to records.
            </p>
            <button id="search-records-btn" class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-black hover:bg-black/90">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v11m0 5l4.879-4.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242z" />
              </svg>
              Search Records
            </button>
          </div>
        </div>

        <!-- Card 2: Recent Searches -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
          <div class="p-6">
            <div class="flex items-center gap-2 mb-1">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <h3 class="text-lg font-semibold">Recent Searches</h3>
            </div>
            <p class="text-sm text-gray-500 mb-4">View your recent legal searches</p>
            <p class="text-sm text-gray-500 mb-4">
              Access your recent legal searches to quickly return to previously viewed records.
            </p>
            <button id="view-reports-btn" class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              View Reports
            </button>
          </div>
        </div>

        <!-- Card 3: Online Portal -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
          <div class="p-6">
            <div class="flex items-center gap-2 mb-1">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
              </svg>
              <h3 class="text-lg font-semibold">Online Portal</h3>
            </div>
            <p class="text-sm text-gray-500 mb-4">Access the online legal search portal</p>
            <p class="text-sm text-gray-500 mb-4">
              Switch to the online portal for remote access to legal search services.
            </p>
            <a href="http://search.klas.com.ng/" class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50" target="_blank">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
              </svg>
              Go to Online Portal
            </a>
          </div>
        </div>
      </div>

      <!-- Monthly Trends Chart -->
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6">
          <div class="flex items-center gap-2 mb-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
            </svg>
            <h3 class="text-lg font-semibold">Search Trends</h3>
          </div>
          <p class="text-sm text-gray-500 mb-4">Official search volume over the past 12 months</p>
          <div class="h-[350px]">
            <canvas id="searchTrendsChart"></canvas>
          </div>
        </div>
      </div>

      <!-- Additional statistics for Official Search -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Search Statistics -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
          <div class="p-6">
            <h3 class="text-lg font-semibold mb-1">Search Statistics</h3>
            <p class="text-sm text-gray-500 mb-4">Key metrics for official searches</p>
            <div class="space-y-4">
              <div class="flex justify-between items-center">
                <span class="text-sm font-medium">Total Searches (This Month)</span>
                <span class="font-bold">24</span>
              </div>
              <div class="flex justify-between items-center">
                <span class="text-sm font-medium">Average Search Time</span>
                <span class="font-bold">3.2 minutes</span>
              </div>
              <div class="flex justify-between items-center">
                <span class="text-sm font-medium">Success Rate</span>
                <span class="font-bold">92%</span>
              </div>
              <div class="flex justify-between items-center">
                <span class="text-sm font-medium">Most Common Search Type</span>
                <span class="font-bold">File Number</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
          <div class="p-6">
            <h3 class="text-lg font-semibold mb-1">Recent Activity</h3>
            <p class="text-sm text-gray-500 mb-4">Latest official search activities</p>
            <div class="space-y-4">
              <div class="flex justify-between items-center border-b pb-2">
                <div>
                  <p class="font-medium">File Search #2024</p>
                  <p class="text-sm text-gray-500">Just now</p>
                </div>
                <span class="px-2 py-1 text-xs rounded-full bg-gray-100">Completed</span>
              </div>
              <div class="flex justify-between items-center border-b pb-2">
                <div>
                  <p class="font-medium">File Search #2025</p>
                  <p class="text-sm text-gray-500">2 hours ago</p>
                </div>
                <span class="px-2 py-1 text-xs rounded-full bg-gray-100">Completed</span>
              </div>
              <div class="flex justify-between items-center border-b pb-2">
                <div>
                  <p class="font-medium">File Search #2026</p>
                  <p class="text-sm text-gray-500">Yesterday</p>
                </div>
                <span class="px-2 py-1 text-xs rounded-full bg-gray-100">Completed</span>
              </div>
              <div class="flex justify-between items-center">
                <div>
                  <p class="font-medium">File Search #2027</p>
                  <p class="text-sm text-gray-500">3 days ago</p>
                </div>
                <span class="px-2 py-1 text-xs rounded-full bg-gray-100">Completed</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- File History View (initially hidden) -->
    <div id="file-history-view" class="hidden">
      <div class="mb-6">
        <div class="flex items-center justify-between">
          <div>
            <h2 class="text-2xl font-bold">File Details</h2>
            <p class="text-gray-500" id="file-details-subtitle">Viewing legal search results for file <span id="file-reference"></span></p>
          </div>
          <div class="flex items-center gap-2">
            <button id="back-to-dashboard-btn" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
              </svg>
              Back to Dashboard
            </button>
            <button id="new-search-from-details-btn" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-black hover:bg-black/90">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
              New Search
            </button>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - File Information -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden p-6">
          <h3 class="text-lg font-semibold mb-4">File Information</h3>
          <p class="text-sm text-gray-500 mb-4">Details about the selected file</p>
          
          <div class="space-y-4">
            <div class="form-row">
              <span class="form-label">File Number (MLSF):</span>
              <span class="form-value" id="file-number-value"></span>
            </div>
            <div class="form-row">
              <span class="form-label">KANGIS File Number:</span>
              <span class="form-value" id="kangis-file-number-value"></span>
            </div>
            <div class="form-row">
              <span class="form-label">New KANGIS File Number:</span>
              <span class="form-value" id="new-kangis-file-number-value"></span>
            </div>
            
            <div class="form-row">
              <span class="form-label">Current Guarantor:</span>
              <span class="form-value" id="current-guarantor-value"></span>
            </div>
            <div class="form-row">
              <span class="form-label">Current Guarantee:</span>
              <span class="form-value" id="current-guarantee-value"></span>
            </div>
            
            <div class="form-row">
              <span class="form-label">LGA:</span>
              <span class="form-value" id="lga-value"></span>
            </div>
            <div class="form-row">
              <span class="form-label">District:</span>
              <span class="form-value" id="district-value"></span>
            </div>
            <div class="form-row">
              <span class="form-label">Property Type:</span>
              <span class="form-value" id="property-type-value"></span>
            </div>
            
            <div class="form-row">
              <span class="form-label">Last Transaction:</span>
              <span class="form-value" id="last-transaction-value"></span>
            </div>
            <div class="form-row">
              <span class="form-label">Status:</span>
              <span class="form-value flex justify-end items-center" id="status-value">
                <span class="status-indicator bg-green-500"></span>
                Active
              </span>
            </div>
          </div>
        </div>

        <!-- Right Column - Transaction History -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden lg:col-span-2">
          <div class="p-6">
            <h3 class="text-lg font-semibold mb-2">Transaction History</h3>
            <p class="text-sm text-gray-500 mb-4">Historical transactions associated with this file</p>
            
            <div class="tabs border-b mb-6">
              <button class="tab active" data-tab="property-transactions">Property Transactions</button>
              <button class="tab" data-tab="property-history">Property History</button>
              {{-- <button class="tab" data-tab="instrument-registration">Instrument Registration</button>  {{-- <button class="tab" data-tab="instrument-registration">Instrument Registration</button> --}}
              <button class="tab" data-tab="cofo">CofO</button>
            </div>

            <div id="property-transactions-tab" class="tab-content active">
              <div class="overflow-x-auto">
                <table class="w-full">
                  <thead>
                    <tr>
                      <th>Date</th>
                      <th>Transaction Type</th>
                      <th>Guarantor</th>
                      <th>Guarantee</th>
                      <th>Caveat</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody id="property-transactions-table">
                    <!-- Will be populated dynamically -->
                  </tbody>
                </table>
              </div>
              <div class="mt-6 flex justify-center">
                <button id="view-detailed-records-btn" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                  </svg>
                  View Detailed Records
                </button>
              </div>
            </div>

            <div id="property-history-tab" class="tab-content">
              <div class="overflow-x-auto">
                <table class="w-full">
                  <thead>
                    <tr>
                      <th>Date</th>
                      <th>Event</th>
                      <th>Authority</th>
                      <th>Recipient</th>
                      <th>Document No.</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody id="property-history-table">
                    <!-- Will be populated dynamically -->
                  </tbody>
                </table>
              </div>
            </div>

            <div id="instrument-registration-tab" class="tab-content">
              <div class="overflow-x-auto">
                <table class="w-full">
                  <thead>
                    <tr>
                      <th>Registration Date</th>
                      <th>Instrument Type</th>
                      <th>Registration No.</th>
                      <th>Parties</th>
                      <th>Registered By</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody id="instrument-registration-table">
                    <!-- Will be populated dynamically -->
                  </tbody>
                </table>
              </div>
            </div>

            <div id="cofo-tab" class="tab-content">
              <div class="overflow-x-auto">
                <table class="w-full">
                  <thead>
                    <tr>
                      <th>CofO Number</th>
                      <th>Issue Date</th>
                      <th>Holder Name</th>
                      <th>Land Use</th>
                      <th>Term</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody id="cofo-table">
                    <!-- Will be populated dynamically -->
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Legal Search Report View (initially hidden) -->
    <div id="legal-search-report-view" class="hidden">
      <div class="mb-6">
        <div class="flex items-center justify-between">
          <div>
            <h2 class="text-2xl font-bold">Legal Search Report</h2>
            <p class="text-gray-500" id="report-subtitle">Official search report for file <span id="report-file-reference"></span></p>
          </div>
          <div class="flex items-center gap-2">
            <button id="back-to-file-details-btn" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
              </svg>
              Back to File Details
            </button>
            <button id="print-report-btn" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50" disabled>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
              </svg>
              Print Report
            </button>
          </div>
        </div>

        <div class="space-y-6">
          <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-6">
              <!-- Report Header -->
                <div class="flex items-center justify-between mb-6 border-b pb-4">
                <img src="https://i.ibb.co/prw0q9jx/Whats-App-Image-2025-02-28-at-4-01-36-PM.jpg" alt="Kano State Logo" class="h-16 w-16">
                <div class="text-center mx-4 flex-1">
                  <h3 class="text-xl font-bold text-blue-700">KANO STATE GEOGRAPHIC INFORMATION SYSTEM</h3>
                  <h4 class="text-lg font-semibold">MINISTRY OF LAND AND PHYSICAL PLANNING</h4>
                  <h5 class="text-md font-medium mt-1">LEGAL SEARCH REPORT</h5>
                </div>
                <img src="https://i.ibb.co/60m0yNx7/Whats-App-Image-2025-02-28-at-4-01-36-PM-1.jpg" alt="GIS Logo" class="h-16 w-16">
                <div class="absolute right-6 top-6">
                  <p class="text-sm" id="report-date"></p>
                </div>
                </div>
              <!-- Property Details Section -->
              <div class="mb-6">
                <div class="inline-block border border-black px-2 py-1 bg-gray-100 text-sm font-bold mb-2">
                  Property Details
                </div>
                <div class="border-t border-black pt-3 space-y-2 text-sm">
                  <div class="flex">
                    <div class="w-36 font-bold">File Number:</div>
                    <div id="report-file-numbers"></div>
                  </div>
                  <div class="flex">
                    <div class="w-36 font-bold">Schedule:</div>
                    <div>Kano</div>
                  </div>
                  <div class="flex">
                    <div class="w-36 font-bold">Plot Number:</div>
                    <div id="report-plot-number"></div>
                  </div>
                  <div class="flex">
                    <div class="w-36 font-bold">Plan Number:</div>
                    <div id="report-plan-number"></div>
                  </div>
                  <div class="flex">
                    <div class="w-36 font-bold">Plot Description:</div>
                    <div id="report-plot-description"></div>
                  </div>
                </div>
              </div>

              <!-- Transaction History Section -->
              <div class="mb-6">
                <div class="inline-block border border-black px-2 py-1 bg-gray-100 text-sm font-bold mb-2">
                  Transaction History
                </div>
                <div class="border-t border-black pt-3">
                  <div class="overflow-x-auto">
                    <table class="w-full text-sm border-collapse">
                      <thead>
                        <tr>
                          <th class="border border-gray-300 px-3 py-2 text-left font-bold bg-gray-200">S/N</th>
                          <th class="border border-gray-300 px-3 py-2 text-left font-bold bg-gray-200">Grantor</th>
                          <th class="border border-gray-300 px-3 py-2 text-left font-bold bg-gray-200">Grantee</th>
                          <th class="border border-gray-300 px-3 py-2 text-left font-bold bg-gray-200">Instrument Type</th>
                          <th class="border border-gray-300 px-3 py-2 text-left font-bold bg-gray-200">Date</th>
                          <th class="border border-gray-300 px-3 py-2 text-left font-bold bg-gray-200">Reg. No.</th>
                          <th class="border border-gray-300 px-3 py-2 text-left font-bold bg-gray-200">Size</th>
                          <th class="border border-gray-300 px-3 py-2 text-left font-bold bg-gray-200">Caveat</th>
                          <th class="border border-gray-300 px-3 py-2 text-left font-bold bg-gray-200">Comments</th>
                        </tr>
                      </thead>
                      <tbody id="report-transactions-table">
                        <!-- Will be populated dynamically -->
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

              <!-- Report Footer -->
              <div class="mt-8 text-sm">
                <p class="font-bold" id="report-timestamp"></p>

                <div class="mt-6 flex justify-between items-start">
                  <div>
                    <p class="font-medium">Yours Faithfully,</p>
                    <div class="h-12 mt-2 border-2 border-blue-900 p-1 w-48 transform -rotate-12">
                      <svg width="200" height="45" viewBox="0 0 200 45" xmlns="http://www.w3.org/2000/svg">
                        <path
                          d="M10,35 C30,5 50,40 70,15 C90,30 110,10 130,25 C150,15 170,30 190,20"
                          stroke="#000080"
                          fill="none"
                          stroke-width="2"
                        />
                      </svg>
                    </div>
                    <p>.......Director Deeds.........</p>
                    <p class="mt-2">Printed by: jennifer.c</p>
                  </div>

                  <div class="text-right">
                    <!-- QR Code -->
                    <img id="report-qr-code" src="/placeholder.svg" alt="QR Code with File Details" width="150" height="150">
                    <div class="text-center text-xs mt-1">Scan for file verification</div>
                  </div>
                </div>

                <div class="mt-8 border-t pt-4 text-center">
                  <p class="text-xs text-muted-foreground">
                    Disclaimer: This Search Report does not represent consent to any transaction and is without prejudice to subsequent disclosures.
                  </p>
                  <p class="text-xs text-muted-foreground mt-2">For enquiries, please call +234 (0) 8023456789</p>
                  <p class="text-xs text-muted-foreground mt-1">
                    KANO STATE GEOGRAPHIC INFORMATION SYSTEM, Plot P/123, Secretariat Kano, Kano State
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    <!-- Reports View (initially hidden) -->
    <div id="reports-view" class="hidden space-y-6">
      <!-- Will be populated dynamically -->
    </div>
  </main>

  <!-- Search Modal (initially hidden) -->
  <div id="search-modal" class="hidden modal-overlay">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title">Search Land Records</h2>
      </div>

      <div class="flex flex-col h-full overflow-hidden">
        <!-- Search Section -->
        <div class="search-section">
          <div class="flex justify-between items-center mb-2">
            <h3 class="text-sm font-medium">Search Filters</h3>
            <button id="toggle-filters-btn" class="px-3 py-1 text-sm bg-white border border-gray-300 rounded-md">
              Collapse Filters
            </button>
          </div>

          <div id="filters-container" class="flex flex-wrap items-center gap-2 mb-4">
            <!-- File Number Filter -->
            <div class="flex items-center gap-2 mb-2">
              <span class="badge badge-outline">File Number</span>
              <input type="text" id="fileNumber" placeholder="Enter file number" class="flex-grow px-3 py-2 border border-gray-300 rounded-md">
              <button class="h-8 w-8 rounded-full flex items-center justify-center text-gray-500 hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>

            <!-- KANGIS File No. Filter -->
            <div class="flex items-center gap-2 mb-2">
              <span class="badge badge-outline">KANGIS File No.</span>
              <input type="text" id="kangisFileNo" placeholder="Enter KANGIS file number" class="flex-grow px-3 py-2 border border-gray-300 rounded-md">
              <button class="h-8 w-8 rounded-full flex items-center justify-center text-gray-500 hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>

            <!-- Add Filter Button -->
            <div class="relative" id="filter-dropdown-container">
              <button id="add-filter-btn" class="inline-flex items-center gap-1 px-3 py-1 text-sm bg-white border border-gray-300 rounded-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Filter
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </button>

              <!-- Filter Dropdown (initially hidden) -->
              <div id="filter-dropdown" class="hidden absolute top-full left-0 mt-1 z-50 w-64 bg-white rounded-md shadow-lg border border-gray-200">
                <div class="p-2 max-h-[200px] overflow-y-auto">
                  <button class="w-full text-left px-3 py-1 text-sm hover:bg-gray-100 rounded-md" data-filter="newKangisFileNo">New KANGIS File No.</button>
                  <button class="w-full text-left px-3 py-1 text-sm hover:bg-gray-100 rounded-md" data-filter="guarantorName">Guarantor Name</button>
                  <button class="w-full text-left px-3 py-1 text-sm hover:bg-gray-100 rounded-md" data-filter="guaranteeName">Guarantee Name</button>
                  <button class="w-full text-left px-3 py-1 text-sm hover:bg-gray-100 rounded-md" data-filter="lga">LGA</button>
                  <button class="w-full text-left px-3 py-1 text-sm hover:bg-gray-100 rounded-md" data-filter="district">District</button>
                  <button class="w-full text-left px-3 py-1 text-sm hover:bg-gray-100 rounded-md" data-filter="location">Location</button>
                  <button class="w-full text-left px-3 py-1 text-sm hover:bg-gray-100 rounded-md" data-filter="plotNumber">Plot Number</button>
                  <button class="w-full text-left px-3 py-1 text-sm hover:bg-gray-100 rounded-md" data-filter="planNumber">Plan Number</button>
                  <button class="w-full text-left px-3 py-1 text-sm hover:bg-gray-100 rounded-md" data-filter="size">Size</button>
                  <button class="w-full text-left px-3 py-1 text-sm hover:bg-gray-100 rounded-md" data-filter="caveat">Caveat</button>
                </div>
              </div>
            </div>

            <!-- Reset Button -->
            <button id="reset-search-btn" class="ml-auto inline-flex items-center gap-1 px-3 py-1 text-sm bg-white border border-gray-300 rounded-md">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
              </svg>
              Reset
            </button>
          </div>

          <!-- Collapsed Filters (initially hidden) -->
          <div id="collapsed-filters" class="hidden flex items-center gap-2 mb-2">
            <div class="text-sm text-gray-500">
              Filtered by: <span id="active-filters-summary">File Number, KANGIS File No.</span>
            </div>
            <button id="reset-search-collapsed-btn" class="ml-auto inline-flex items-center gap-1 px-3 py-1 text-sm bg-white border border-gray-300 rounded-md">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
              </svg>
              Reset
            </button>
          </div>

          <!-- View mode toggle -->
          <div class="flex justify-between items-center">
            <div class="text-sm text-gray-500"><span id="results-count">0</span> results found</div>
            <div class="tabs">
              <button class="tab active" data-view="table">Table View</button>
              <button class="tab" data-view="cards">Card View</button>
            </div>
          </div>
        </div>

        <!-- Results Section -->
        <div class="results-section">
          <!-- Loading Spinner (initially hidden) -->
          <div id="search-loading" class="hidden flex justify-center items-center py-8">
            <div class="spinner"></div>
          </div>

          <!-- No Results Message (initially hidden) -->
          <div id="no-results-message" class="hidden text-center py-8">
            <p class="text-gray-500">No results found. Please try a different search.</p>
          </div>

          <!-- Table View Results (initially hidden) -->
          <div id="table-results" class="hidden border rounded-md overflow-hidden">
            <div class="overflow-x-auto">
              <table class="w-full min-w-[1000px]">
                <thead class="bg-gray-100">
                  <tr>
                    <th>File Number</th>
                    <th>KANGIS File No.</th>
                    <th>New KANGIS</th>
                    <th>Guarantor</th>
                    <th>Guarantee</th>
                    <th>LGA</th>
                    <th>Location</th>
                    <th>Plot No</th>
                    <th>Registration Particulars</th>
                    <th>Size</th>
                    <th>Caveat</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody id="table-results-body">
                  <!-- Will be populated dynamically -->
                </tbody>
              </table>
            </div>
          </div>

          <!-- Card View Results (initially hidden) -->
          <div id="card-results" class="hidden grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Will be populated dynamically -->
          </div>

          <!-- File Details View (initially hidden) -->
          <div id="file-details-view" class="hidden space-y-6">
            <!-- Will be populated dynamically -->
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Delete Confirmation Dialog (initially hidden) -->
  <div id="delete-confirm-dialog" class="hidden modal-overlay">
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full">
      <h3 class="text-lg font-semibold mb-2">Confirm Deletion</h3>
      <p class="text-gray-500 mb-4">Are you sure you want to delete this record? This action cannot be undone.</p>
      <div class="flex justify-end gap-2">
        <button id="cancel-delete-btn" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium">Cancel</button>
        <button id="confirm-delete-btn" class="px-4 py-2 bg-red-600 text-white rounded-md text-sm font-medium hover:bg-red-700">Delete</button>
      </div>
    </div>
  </div>

  <!-- JavaScript -->
  <script>
    // Mock data for the application
    const monthlyData = [
      { month: "Jan", searches: 18, revenue: 270000 },
      { month: "Feb", searches: 22, revenue: 330000 },
      { month: "Mar", searches: 25, revenue: 375000 },
      { month: "Apr", searches: 20, revenue: 300000 },
      { month: "May", searches: 28, revenue: 420000 },
      { month: "Jun", searches: 32, revenue: 480000 },
      { month: "Jul", searches: 35, revenue: 525000 },
      { month: "Aug", searches: 30, revenue: 450000 },
      { month: "Sep", searches: 26, revenue: 390000 },
      { month: "Oct", searches: 22, revenue: 330000 },
      { month: "Nov", searches: 20, revenue: 300000 },
      { month: "Dec", searches: 24, revenue: 360000 }
    ];

    // Sample land records data
    const landRecords = [
      {
        id: 1,
        fileNumber: "COM-RES-2021-078",
        kangisFileNo: "KNML 12453",
        newKangisFileNo: "KN0004",
        guarantor: "Kano Market Development Authority",
        guarantee: "Suleiman Abubakar Trading Co.",
        lga: "Kano Municipal",
        district: "Sabon Gari Market",
        location: "Sabon Gari",
        propertyType: "Commercial",
        registrationParticulars: "Lease Agreement dated 05/04/2021",
        lastTransaction: "Lease Agreement",
        caveat: "No",
        size: "1000 sqm",
        plotNumber: "Plot 123",
        planNumber: "KN/PL/2021/123",
        history: [
          {
            id: 1,
            date: "2021-04-05",
            time: "10:30 AM",
            transactionType: "Lease Agreement",
            guarantor: "Kano Market Development Authority",
            guarantee: "Suleiman Abubakar Trading Co.",
            amount: "₦5,000,000",
            caveat: "No",
            size: "1000 sqm",
            comments: "Initial market stall lease"
          }
        ],
        propertyHistory: [
          {
            id: 1,
            date: "2021-04-05",
            time: "10:30 AM",
            event: "Initial Registration",
            authority: "Kano Land Registry",
            recipient: "Suleiman Abubakar Trading Co.",
            documentNo: "DOC/2021/001",
            size: "1000 sqm",
            comments: "First registration of property"
          }
        ],
        instrumentRegistrations: [
          {
            id: 1,
            registrationDate: "2021-04-10",
            registrationTime: "11:45 AM",
            instrumentType: "Lease Agreement",
            registrationNumber: "REG/2021/001",
            parties: "Kano Market Development Authority and Suleiman Abubakar Trading Co.",
            propertyDescription: "Commercial stall at Sabon Gari Market",
            registeredBy: "Land Registry Officer",
            caveat: "No"
          }
        ],
        cofoRecords: [
          {
            id: 1,
            cofoNumber: "C of O/KN/2021/001",
            issueDate: "2021-05-01",
            holderName: "Suleiman Abubakar Trading Co.",
            propertyDescription: "Commercial stall at Sabon Gari Market",
            landUse: "Commercial",
            term: "25 years",
            commencementDate: "2021-04-05",
            annualRent: "₦200,000",
            caveat: "No"
          }
        ]
      },
      {
        id: 2,
        fileNumber: "MLSF/KN/2023/002",
        kangisFileNo: "KG-002-2023",
        newKangisFileNo: "KNG-2023-002",
        guarantor: "Michael Johnson",
        guarantee: "Sarah Williams",
        lga: "Fagge",
        district: "North",
        location: "Fagge",
        propertyType: "Residential",
        registrationParticulars: "Deed of Assignment dated 20/06/2023",
        lastTransaction: "Lease",
        caveat: "Yes",
        size: "750 sqm",
        plotNumber: "Plot 456",
        planNumber: "KN/PL/2023/456",
        history: [
          {
            id: 2,
            date: "2023-06-20",
            time: "02:15 PM",
            transactionType: "Lease",
            guarantor: "Michael Johnson",
            guarantee: "Sarah Williams",
            amount: "₦3,500,000",
            caveat: "Yes",
            size: "750 sqm",
            comments: "Property leased for 25 years"
          },
          {
            id: 3,
            date: "2023-08-15",
            time: "11:30 AM",
            transactionType: "Deed of Assignment",
            guarantor: "Sarah Williams",
            guarantee: "Ahmed Abdullahi",
            amount: "₦4,200,000",
            caveat: "No",
            size: "750 sqm",
            comments: "Transfer of ownership rights"
          },
          {
            id: 4,
            date: "2023-10-10",
            time: "09:45 AM",
            transactionType: "Power of Attorney",
            guarantor: "Ahmed Abdullahi",
            guarantee: "Fatima Hassan",
            amount: "₦500,000",
            caveat: "No",
            size: "750 sqm",
            comments: "Legal representation granted"
          },
          {
            id: 5,
            date: "2023-12-05",
            time: "03:20 PM",
            transactionType: "Deed of Mortgage",
            guarantor: "Fatima Hassan",
            guarantee: "First Bank of Nigeria",
            amount: "₦8,000,000",
            caveat: "Yes",
            size: "750 sqm",
            comments: "Property mortgaged for loan facility"
          },
          {
            id: 6,
            date: "2024-02-18",
            time: "01:15 PM",
            transactionType: "Deed of Mortgage",
            guarantor: "Fatima Hassan",
            guarantee: "Musa Ibrahim Kano",
            amount: "₦12,500,000",
            caveat: "No",
            size: "750 sqm",
            comments: "Property sold with building plan approval"
          },
          {
            id: 7,
            date: "2024-05-22",
            time: "10:00 AM",
            transactionType: "Transfer of Title",
            guarantor: "Musa Ibrahim Kano",
            guarantee: "Aisha Bello Muhammad",
            amount: "₦15,000,000",
            caveat: "No",
            size: "750 sqm",
            comments: "Final transfer of ownership completed"
          }
        ],
        propertyHistory: [
          {
            id: 2,
            date: "2023-06-25",
            time: "02:30 PM",
            event: "Lease Registration",
            authority: "Kano Land Registry",
            recipient: "Sarah Williams",
            documentNo: "DOC/2023/002",
            size: "750 sqm",
            comments: "Lease agreement registered"
          },
          {
            id: 3,
            date: "2023-08-20",
            time: "12:00 PM",
            event: "Ownership Transfer",
            authority: "Kano Land Registry",
            recipient: "Ahmed Abdullahi",
            documentNo: "DOC/2023/003",
            size: "750 sqm",
            comments: "Deed of assignment registered"
          },
          {
            id: 4,
            date: "2024-02-25",
            time: "02:45 PM",
            event: "Sale Agreement Filing",
            authority: "Kano Land Registry",
            recipient: "Musa Ibrahim Kano",
            documentNo: "DOC/2024/001",
            size: "750 sqm",
            comments: "Deed of Mortgage filed and approved"
          }
        ],
        instrumentRegistrations: [
          {
            id: 2,
            registrationDate: "2023-06-25",
            registrationTime: "02:45 PM",
            instrumentType: "Lease Agreement",
            registrationNumber: "REG/2023/002",
            parties: "Michael Johnson and Sarah Williams",
            propertyDescription: "Residential property at Fagge North District",
            registeredBy: "Land Registry Officer",
            caveat: "Yes"
          },
          {
            id: 3,
            registrationDate: "2023-08-25",
            registrationTime: "01:30 PM",
            instrumentType: "Deed of Assignment",
            registrationNumber: "REG/2023/003",
            parties: "Sarah Williams and Ahmed Abdullahi",
            propertyDescription: "Residential property at Fagge North District",
            registeredBy: "Senior Registry Officer",
            caveat: "No"
          },
          {
            id: 4,
            registrationDate: "2024-05-27",
            registrationTime: "11:15 AM",
            instrumentType: "Transfer of Title",
            registrationNumber: "REG/2024/001",
            parties: "Musa Ibrahim Kano and Aisha Bello Muhammad",
            propertyDescription: "Residential property at Fagge North District",
            registeredBy: "Chief Registry Officer",
            caveat: "No"
          }
        ],
        cofoRecords: [
          {
            id: 2,
            cofoNumber: "C of O/KN/2024/001",
            issueDate: "2023-07-01",
            holderName: "Sarah Williams",
            propertyDescription: "Residential property at Fagge North District",
            landUse: "Residential",
            term: "99 years",
            commencementDate: "2023-06-20",
            annualRent: "₦150,000",
            caveat: "Yes"
          },
          {
            id: 3,
            cofoNumber: "C of O/KN/2024/001",
            issueDate: "2024-06-15",
            holderName: "Aisha Bello Muhammad",
            propertyDescription: "Residential property at Fagge North District",
            landUse: "Residential",
            term: "99 years",
            commencementDate: "2024-05-22",
            annualRent: "₦180,000",
            caveat: "No"
          }
        ]
      }
    ];

    // DOM Elements
    const searchModal = document.getElementById('search-modal');
    const searchRecordsBtn = document.getElementById('search-records-btn');
    const toggleFiltersBtn = document.getElementById('toggle-filters-btn');
    const filtersContainer = document.getElementById('filters-container');
    const collapsedFilters = document.getElementById('collapsed-filters');
    const resetSearchBtn = document.getElementById('reset-search-btn');
    const resetSearchCollapsedBtn = document.getElementById('reset-search-collapsed-btn');
    const addFilterBtn = document.getElementById('add-filter-btn');
    const filterDropdown = document.getElementById('filter-dropdown');
    const searchLoading = document.getElementById('search-loading');
    const noResultsMessage = document.getElementById('no-results-message');
    const tableResults = document.getElementById('table-results');
    const tableResultsBody = document.getElementById('table-results-body');
    const cardResults = document.getElementById('card-results');
    const fileDetailsView = document.getElementById('file-details-view');
    const resultsCount = document.getElementById('results-count');
    const viewTabs = document.querySelectorAll('.tab');
    const dashboardView = document.getElementById('dashboard-view');
    const fileHistoryView = document.getElementById('file-history-view');
    const reportsView = document.getElementById('reports-view');
    const viewReportsBtn = document.getElementById('view-reports-btn');
    const deleteConfirmDialog = document.getElementById('delete-confirm-dialog');
    const cancelDeleteBtn = document.getElementById('cancel-delete-btn');
    const confirmDeleteBtn = document.getElementById('confirm-delete-btn');
    const newSearchFromDetailsBtn = document.getElementById('new-search-from-details-btn');
    const legalSearchReportView = document.getElementById('legal-search-report-view');
    const backToFileDetailsBtn = document.getElementById('back-to-file-details-btn');
    const printReportBtn = document.getElementById('print-report-btn');

    // Debug statements
    console.log("Search modal element:", searchModal);
    console.log("Search records button:", searchRecordsBtn);

    // State variables
    let currentView = 'table';
    let selectedFile = null;
    let transactionToDelete = null;
    let searchResults = [];
    let filtersCollapsed = false;

    // Initialize the search trends chart
    const initializeChart = () => {
      const ctx = document.getElementById('searchTrendsChart').getContext('2d');
      new Chart(ctx, {
        type: 'line',
        data: {
          labels: monthlyData.map(d => d.month),
          datasets: [{
            label: 'Searches',
            data: monthlyData.map(d => d.searches),
            borderColor: '#3B82F6',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            tension: 0.4,
            fill: true
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: 'top',
            },
            title: {
              display: true,
              text: 'Monthly Search Volume'
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              title: {
                display: true,
                text: 'Number of Searches'
              }
            },
            x: {
              title: {
                display: true,
                text: 'Month'
              }
            }
          }
        }
      });
    };

    // Initialize the chart when the page loads
    document.addEventListener('DOMContentLoaded', initializeChart);

    // Event Listeners
    // Fix for the newSearchBtn reference - it doesn't exist, remove it
    // Instead, make sure searchRecordsBtn works properly
    if (searchRecordsBtn) {
      searchRecordsBtn.addEventListener('click', () => {
        console.log("Search records button clicked");
        searchModal.classList.remove('hidden');
      });
    } else {
      console.error("Search records button not found");
    }

    if (newSearchFromDetailsBtn) {
      newSearchFromDetailsBtn.addEventListener('click', () => {
        console.log("New search from details button clicked");
        searchModal.classList.remove('hidden');
      });
    }

    // Close modal when clicking outside
    searchModal.addEventListener('click', (e) => {
      if (e.target === searchModal) {
        searchModal.classList.add('hidden');
      }
    });

    // Toggle filters
    toggleFiltersBtn.addEventListener('click', () => {
      filtersCollapsed = !filtersCollapsed;
      if (filtersCollapsed) {
        filtersContainer.classList.add('hidden');
        collapsedFilters.classList.remove('hidden');
        toggleFiltersBtn.textContent = 'Expand Filters';
      } else {
        filtersContainer.classList.remove('hidden');
        collapsedFilters.classList.add('hidden');
        toggleFiltersBtn.textContent = 'Collapse Filters';
      }
    });

    // Reset search
    const resetSearch = () => {
      document.getElementById('fileNumber').value = '';
      document.getElementById('kangisFileNo').value = '';
      
      // Reset any other filters that might be added
      const additionalFilters = document.querySelectorAll('.additional-filter');
      additionalFilters.forEach(filter => {
        filter.remove();
      });
      
      // Reset results
      searchResults = [];
      resultsCount.textContent = '0';
      tableResultsBody.innerHTML = '';
      cardResults.innerHTML = '';
      
      // Hide results views
      tableResults.classList.add('hidden');
      cardResults.classList.add('hidden');
      fileDetailsView.classList.add('hidden');
      noResultsMessage.classList.add('hidden');
      
      // Reset selected file
      selectedFile = null;
    };

    resetSearchBtn.addEventListener('click', resetSearch);
    resetSearchCollapsedBtn.addEventListener('click', resetSearch);

    // Toggle filter dropdown
    addFilterBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      filterDropdown.classList.toggle('hidden');
    });

    // Close filter dropdown when clicking outside
    document.addEventListener('click', (e) => {
      if (!addFilterBtn.contains(e.target) && !filterDropdown.contains(e.target)) {
        filterDropdown.classList.add('hidden');
      }
    });

    // Add filter when clicking on dropdown item
    filterDropdown.addEventListener('click', (e) => {
      if (e.target.hasAttribute('data-filter')) {
        const filterId = e.target.getAttribute('data-filter');
        addFilter(filterId);
        filterDropdown.classList.add('hidden');
      }
    });

    // Add a new filter to the filters container
    const addFilter = (filterId) => {
      // Check if filter already exists
      if (document.getElementById(filterId)) {
        return;
      }

      const filterLabels = {
        newKangisFileNo: 'New KANGIS File No.',
        guarantorName: 'Guarantor Name',
        guaranteeName: 'Guarantee Name',
        lga: 'LGA',
        district: 'District',
        location: 'Location',
        plotNumber: 'Plot Number',
        planNumber: 'Plan Number',
        size: 'Size',
        caveat: 'Caveat'
      };

      const filterDiv = document.createElement('div');
      filterDiv.className = 'flex items-center gap-2 mb-2 additional-filter';
      filterDiv.id = filterId + '-filter';

      if (filterId === 'lga' || filterId === 'caveat') {
        // Create select for LGA or Caveat
        const options = filterId === 'lga' 
          ? ['Dala', 'Fagge', 'Gwale', 'Kano Municipal', 'Nassarawa', 'Tarauni', 'Ungogo']
          : ['Yes', 'No'];
        
        filterDiv.innerHTML = `
          <span class="badge badge-outline">${filterLabels[filterId]}</span>
          <div class="select-wrapper flex-grow">
            <select id="${filterId}" class="select">
              <option value="">Select ${filterLabels[filterId]}</option>
              ${options.map(opt => `<option value="${opt}">${opt}</option>`).join('')}
            </select>
            <div class="select-icon">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </div>
          </div>
        `;
      } else {
        // Create input for other filters
        filterDiv.innerHTML = `
          <span class="badge badge-outline">${filterLabels[filterId]}</span>
          <input type="text" id="${filterId}" placeholder="Enter ${filterLabels[filterId].toLowerCase()}" class="flex-grow px-3 py-2 border border-gray-300 rounded-md">
        `;
      }

      // Add remove button
      const removeBtn = document.createElement('button');
      removeBtn.className = 'h-8 w-8 rounded-full flex items-center justify-center text-gray-500 hover:bg-gray-100';
      removeBtn.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      `;
      removeBtn.addEventListener('click', () => {
        filterDiv.remove();
        performSearch();
      });

      filterDiv.appendChild(removeBtn);
      filtersContainer.insertBefore(filterDiv, addFilterBtn.parentNode);

      // Add event listener to the new input/select
      const input = document.getElementById(filterId);
      if (input.tagName === 'SELECT') {
        input.addEventListener('change', performSearch);
      } else {
        input.addEventListener('input', performSearch);
      }
    };

    // Perform search based on filter values
    const performSearch = () => {
      // Get all filter values
      const filters = {
        fileNumber: document.getElementById('fileNumber').value,
        kangisFileNo: document.getElementById('kangisFileNo').value
      };

      // Add any additional filters
      const additionalFilters = document.querySelectorAll('.additional-filter');
      additionalFilters.forEach(filter => {
        const input = filter.querySelector('input, select');
        if (input && input.value) {
          filters[input.id] = input.value;
        }
      });

      // Check if any filter has a value
      const hasFilters = Object.values(filters).some(value => value);
      if (!hasFilters) {
        searchResults = [];
        resultsCount.textContent = '0';
        tableResults.classList.add('hidden');
        cardResults.classList.add('hidden');
        noResultsMessage.classList.add('hidden');
        return;
      }

      // Show loading
      searchLoading.classList.remove('hidden');
      tableResults.classList.add('hidden');
      cardResults.classList.add('hidden');
      noResultsMessage.classList.add('hidden');
      fileDetailsView.classList.add('hidden');

      // Simulate API call with timeout
      setTimeout(() => {
        // Filter land records based on filters
        searchResults = landRecords.filter(record => {
          return Object.entries(filters).every(([key, value]) => {
            if (!value) return true; // Skip empty filters
            
            const searchValue = value.toLowerCase();
            
            switch(key) {
              case 'fileNumber':
                return record.fileNumber.toLowerCase().includes(searchValue);
              case 'kangisFileNo':
                return record.kangisFileNo.toLowerCase().includes(searchValue);
              case 'newKangisFileNo':
                return record.newKangisFileNo.toLowerCase().includes(searchValue);
              case 'guarantorName':
                return record.guarantor.toLowerCase().includes(searchValue);
              case 'guaranteeName':
                return record.guarantee.toLowerCase().includes(searchValue);
              case 'lga':
                return record.lga === value;
              case 'district':
                return record.district.toLowerCase().includes(searchValue);
              case 'location':
                return record.location.toLowerCase().includes(searchValue);
              case 'plotNumber':
                return record.plotNumber.toLowerCase().includes(searchValue);
              case 'planNumber':
                return record.planNumber.toLowerCase().includes(searchValue);
              case 'size':
                return record.size.toLowerCase().includes(searchValue);
              case 'caveat':
                return record.caveat === value;
              default:
                return true;
            }
          });
        });

        // Update results count
        resultsCount.textContent = searchResults.length;

        // Hide loading
        searchLoading.classList.add('hidden');

        // Show appropriate view
        if (searchResults.length === 0) {
          noResultsMessage.classList.remove('hidden');
        } else {
          // Automatically collapse filters when results are found
          if (searchResults.length > 0 && !filtersCollapsed) {
            filtersCollapsed = true;
            filtersContainer.classList.add('hidden');
            collapsedFilters.classList.remove('hidden');
            toggleFiltersBtn.textContent = 'Expand Filters';
            
            // Update active filters summary
            const activeFilters = Object.entries(filters)
              .filter(([_, value]) => value)
              .map(([key, value]) => {
                const filterLabels = {
                  fileNumber: 'File Number',
                  kangisFileNo: 'KANGIS File No.',
                  newKangisFileNo: 'New KANGIS File No.',
                  guarantorName: 'Guarantor Name',
                  guaranteeName: 'Guarantee Name',
                  lga: 'LGA',
                  district: 'District',
                  location: 'Location',
                  plotNumber: 'Plot Number',
                  planNumber: 'Plan Number',
                  size: 'Size',
                  caveat: 'Caveat'
                };
                return `${filterLabels[key]}: ${value}`;
              })
              .join(', ');
            
            document.getElementById('active-filters-summary').textContent = activeFilters;
          }
          
          renderSearchResults();
        }
      }, 500);
    };

    // Render search results based on current view
    const renderSearchResults = () => {
      if (currentView === 'table') {
        renderTableResults();
        tableResults.classList.remove('hidden');
        cardResults.classList.add('hidden');
      } else {
        renderCardResults();
        cardResults.classList.remove('hidden');
        tableResults.classList.add('hidden');
      }
    };

    // Render table results
    const renderTableResults = () => {
      tableResultsBody.innerHTML = '';
      
      searchResults.forEach(file => {
        const row = document.createElement('tr');
        row.className = 'hover:bg-gray-50 transition-colors';
        row.innerHTML = `
          <td class="p-2 text-sm">${file.fileNumber}</td>
          <td class="p-2 text-sm">${file.kangisFileNo}</td>
          <td class="p-2 text-sm">${file.newKangisFileNo}</td>
          <td class="p-2 text-sm">${file.guarantor}</td>
          <td class="p-2 text-sm">${file.guarantee}</td>
          <td class="p-2 text-sm">${file.lga}</td>
          <td class="p-2 text-sm">${file.location}</td>
          <td class="p-2 text-sm">${file.plotNumber}</td>
          <td class="p-2 text-sm">${file.registrationParticulars}</td>
          <td class="p-2 text-sm">${file.size}</td>
          <td class="p-2 text-sm font-medium ${file.caveat === 'Yes' ? 'text-red-600' : ''}">${file.caveat}</td>
          <td class="p-2 text-sm">
            <button class="view-file-btn inline-flex items-center px-2 py-1 text-sm bg-white border border-gray-300 rounded-md hover:bg-gray-50" data-id="${file.id}">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v11m0  5l4.879-4.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242z" />
              </svg>
              View Records
            </button>
          </td>
        `;
        
        tableResultsBody.appendChild(row);
      });
      
      // Add event listeners to view buttons
      document.querySelectorAll('.view-file-btn').forEach(btn => {
        btn.addEventListener('click', () => {
          const fileId = parseInt(btn.getAttribute('data-id'));
          selectedFile = searchResults.find(file => file.id === fileId);
          
          // Close search modal
          searchModal.classList.add('hidden');
          
          // Show file history view directly instead of file details
          dashboardView.classList.add('hidden');
          fileHistoryView.classList.remove('hidden');
          
          // Populate file details
          renderFileHistory();
        });
      });
    };

    // Render card results
    const renderCardResults = () => {
      cardResults.innerHTML = '';
      
      searchResults.forEach(file => {
        const card = document.createElement('div');
        card.className = 'bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow cursor-pointer';
        card.innerHTML = `
          <div class="p-4">
            <div class="flex justify-between items-start mb-3">
              <div>
                <div class="font-medium flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v11m0 5l4.879-4.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242z" />
                  </svg>
                  ${file.fileNumber}
                </div>
                <div class="text-sm text-gray-500 mt-1">
                  KANGIS: ${file.kangisFileNo} | New KANGIS: ${file.newKangisFileNo}
                </div>
              </div>
              <div>
                <span class="text-gray-500">Guarantee:</span> ${file.guarantee}
              </div>
              <div>
                <span class="text-gray-500">LGA:</span> ${file.lga}
              </div>
              <div>
                <span class="text-gray-500">Location:</span> ${file.location}
              </div>
              <div>
                <span class="text-gray-500">Plot No:</span> ${file.plotNumber}
              </div>
              <div>
                <span class="text-gray-500">Size:</span> ${file.size}
              </div>
              <div class="col-span-2">
                <span class="text-gray-500">Registration Particulars:</span> ${file.registrationParticulars}
              </div>
            </div>
          </div>
        `;
        
        card.addEventListener('click', () => {
          selectedFile = file;
          
          // Close search modal
          searchModal.classList.add('hidden');
          
          // Show file history view directly
          dashboardView.classList.add('hidden');
          fileHistoryView.classList.remove('hidden');
          
          // Populate file details
          renderFileHistory();
        });
        
        cardResults.appendChild(card);
      });
    };
    
    // Render file history (the side-by-side layout shown in the screenshot)
    const renderFileHistory = () => {
      if (!selectedFile) return;
      
      // Update file reference in subtitle
      document.getElementById('file-reference').textContent = selectedFile.fileNumber;
      
      // Update file information fields
      document.getElementById('file-number-value').textContent = selectedFile.fileNumber;
      document.getElementById('kangis-file-number-value').textContent = selectedFile.kangisFileNo;
      document.getElementById('new-kangis-file-number-value').textContent = selectedFile.newKangisFileNo;
      document.getElementById('current-guarantor-value').textContent = selectedFile.guarantor;
      document.getElementById('current-guarantee-value').textContent = selectedFile.guarantee;
      document.getElementById('lga-value').textContent = selectedFile.lga;
      document.getElementById('district-value').textContent = selectedFile.district;
      document.getElementById('property-type-value').textContent = selectedFile.propertyType || 'N/A';
      document.getElementById('last-transaction-value').textContent = selectedFile.lastTransaction;
      
      // Render the transactions tables
      renderTransactionTables();
      
      // Set up tab switching
      document.querySelectorAll('.tab').forEach(tab => {
        tab.addEventListener('click', () => {
          const tabName = tab.getAttribute('data-tab');
          switchTab(tabName);
        });
      });
      
      // Default to property transactions tab
      switchTab('property-transactions');
    };
    
    // Render all transaction tables
    const renderTransactionTables = () => {
      // Property Transactions
      const propertyTransactionsTable = document.getElementById('property-transactions-table');
      propertyTransactionsTable.innerHTML = '';
      
      if (selectedFile.history && selectedFile.history.length > 0) {
        selectedFile.history.forEach(transaction => {
          const row = document.createElement('tr');
          row.innerHTML = `
            <td>${transaction.date}</td>
            <td>${transaction.transactionType}</td>
            <td>${transaction.guarantor}</td>
            <td>${transaction.guarantee}</td>
            <td class="${transaction.caveat === 'Yes' ? 'text-red-600 font-medium' : ''}">${transaction.caveat}</td>
            <td>
              <div class="flex space-x-2">
                <button class="edit-action">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                  </svg>
                </button>
                <button class="delete-action">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 6h18"></path>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"></path>
                    <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                  </svg>
                </button>
              </div>
            </td>
          `;
          propertyTransactionsTable.appendChild(row);
        });
      } else {
        propertyTransactionsTable.innerHTML = `
          <tr>
            <td colspan="6" class="text-center py-4 text-gray-500">No property transactions found.</td>
          </tr>
        `;
      }
      
      // Property History
      const propertyHistoryTable = document.getElementById('property-history-table');
      propertyHistoryTable.innerHTML = '';
      
      if (selectedFile.propertyHistory && selectedFile.propertyHistory.length > 0) {
        selectedFile.propertyHistory.forEach(history => {
          const row = document.createElement('tr');
          row.innerHTML = `
            <td>${history.date}</td>
            <td>${history.event}</td>
            <td>${history.authority}</td>
            <td>${history.recipient}</td>
            <td>${history.documentNo}</td>
            <td>
              <div class="flex space-x-2">
                <button class="edit-action">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                  </svg>
                </button>
                <button class="delete-action">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 6h18"></path>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"></path>
                    <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                  </svg>
                </button>
              </div>
            </td>
          `;
          propertyHistoryTable.appendChild(row);
        });
      } else {
        propertyHistoryTable.innerHTML = `
          <tr>
            <td colspan="6" class="text-center py-4 text-gray-500">No property history records found.</td>
          </tr>
        `;
      }
      
      // Instrument Registration
      const instrumentRegistrationTable = document.getElementById('instrument-registration-table');
      instrumentRegistrationTable.innerHTML = '';
      
      if (selectedFile.instrumentRegistrations && selectedFile.instrumentRegistrations.length > 0) {
        selectedFile.instrumentRegistrations.forEach(registration => {
          const row = document.createElement('tr');
          row.innerHTML = `
            <td>${registration.registrationDate}</td>
            <td>${registration.instrumentType}</td>
            <td>${registration.registrationNumber}</td>
            <td>${registration.parties}</td>
            <td>${registration.registeredBy}</td>
            <td>
              <div class="flex space-x-2">
                <button class="edit-action">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                  </svg>
                </button>
                <button class="delete-action">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 6h18"></path>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"></path>
                    <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                  </svg>
                </button>
              </div>
            </td>
          `;
          instrumentRegistrationTable.appendChild(row);
        });
      } else {
        instrumentRegistrationTable.innerHTML = `
          <tr>
            <td colspan="6" class="text-center py-4 text-gray-500">No instrument registration records found.</td>
          </tr>
        `;
      }
      
      // Certificate of Occupancy
      const cofoTable = document.getElementById('cofo-table');
      cofoTable.innerHTML = '';
      
      if (selectedFile.cofoRecords && selectedFile.cofoRecords.length > 0) {
        selectedFile.cofoRecords.forEach(cofo => {
          const row = document.createElement('tr');
          row.innerHTML = `
            <td>${cofo.cofoNumber}</td>
            <td>${cofo.issueDate}</td>
            <td>${cofo.holderName}</td>
            <td>${cofo.landUse}</td>
            <td>${cofo.term}</td>
            <td>
              <div class="flex space-x-2">
                <button class="edit-action">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                  </svg>
                </button>
                <button class="delete-action">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 6h18"></path>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"></path>
                    <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                  </svg>
                </button>
              </div>
            </td>
          `;
          cofoTable.appendChild(row);
        });
      } else {
        cofoTable.innerHTML = `
          <tr>
            <td colspan="6" class="text-center py-4 text-gray-500">No Certificate of Occupancy records found.</td>
          </tr>
        `;
      }
    };
    
    // Switch between tabs in the file details view
    const switchTab = (tabName) => {
      // Update active tab
      document.querySelectorAll('.tab').forEach(t => {
        if (t.getAttribute('data-tab') === tabName) {
          t.classList.add('active');
        } else {
          t.classList.remove('active');
        }
      });
      
      // Update visible content
      document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.remove('active');
      });
      document.getElementById(`${tabName}-tab`).classList.add('active');
    };

    // Back to dashboard from file history view
    document.getElementById('back-to-dashboard-btn').addEventListener('click', () => {
      fileHistoryView.classList.add('hidden');
      dashboardView.classList.remove('hidden');
    });
    
    // Switch between table and card view
    document.querySelectorAll('[data-view]').forEach(tab => {
      tab.addEventListener('click', () => {
        // Remove active class from all tabs
        document.querySelectorAll('[data-view]').forEach(t => t.classList.remove('active'));
        // Add active class to clicked tab
        tab.classList.add('active');
        
        // Update current view
        currentView = tab.getAttribute('data-view');
        
        // Render search results
        renderSearchResults();
      });
    });

    // Show reports view
    viewReportsBtn.addEventListener('click', () => {
      dashboardView.classList.add('hidden');
      fileHistoryView.classList.add('hidden');
      reportsView.classList.remove('hidden');
      
      // Render reports view
      reportsView.innerHTML = `
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden mb-6">
          <div class="p-6">
            <div class="flex items-center justify-between mb-4">
              <div>
                <h2 class="text-xl font-bold">Official Search Reports</h2>
                <p class="text-sm text-gray-500">Overview of official legal search activities</p>
              </div>
              <button id="back-to-dashboard-from-reports-btn" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                Back to Dashboard
              </button>
            </div>

            <div class="tabs mb-6">
              <button class="tab active" data-report-tab="summary">Summary</button>
              <button class="tab" data-report-tab="detailed">Detailed Reports</button>
            </div>

            <div class="tab-content active" id="summary-tab">
              <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                  <div class="p-4">
                    <h3 class="text-lg font-semibold">Total Searches</h3>
                    <p class="text-3xl font-bold mt-2">267</p>
                    <p class="text-sm text-gray-500 mt-1">Last 30 days</p>
                  </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                  <div class="p-4">
                    <h3 class="text-lg font-semibold">Success Rate</h3>
                    <p class="text-3xl font-bold mt-2">92%</p>
                    <p class="text-sm text-gray-500 mt-1">Records found</p>
                  </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                  <div class="p-4">
                    <h3 class="text-lg font-semibold">Average Time</h3>
                    <p class="text-3xl font-bold mt-2">3.2 min</p>
                    <p class="text-sm text-gray-500 mt-1">Per search</p>
                  </div>
                </div>
              </div>

              <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden mb-6">
                <div class="p-6">
                  <h3 class="text-lg font-semibold mb-4">Monthly Search Volume</h3>
                  <div class="h-[350px]">
                    <canvas id="reportsChart"></canvas>
                  </div>
                </div>
              </div>
            </div>

            <div class="tab-content" id="detailed-tab">
              <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6">
                  <h3 class="text-lg font-semibold mb-4">Recent Search Reports</h3>
                  <div class="overflow-x-auto">
                    <table class="w-full">
                      <thead>
                        <tr>
                          <th>Date</th>
                          <th>Search Type</th>
                          <th>Parameter</th>
                          <th>Value</th>
                          <th>Result</th>
                          <th>Staff</th>
                          <th>LGA</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>2023-07-15</td>
                          <td>File Number</td>
                          <td>MLSF/KN/2023/001</td>
                          <td>MLSF/KN/2023/001</td>
                          <td>Found</td>
                          <td>John Doe</td>
                          <td>Kano Municipal</td>
                        </tr>
                        <tr>
                          <td>2023-07-14</td>
                          <td>KANGIS File No.</td>
                          <td>KG-002-2023</td>
                          <td>KG-002-2023</td>
                          <td>Found</td>
                          <td>Jane Smith</td>
                          <td>Fagge</td>
                        </tr>
                        <tr>
                          <td>2023-07-14</td>
                          <td>Plot Number</td>
                          <td>Plot 789</td>
                          <td>Plot 789</td>
                          <td>Not Found</td>
                          <td>Michael Johnson</td>
                          <td>Gwale</td>
                        </tr>
                        <tr>
                          <td>2023-07-13</td>
                          <td>Guarantor Name</td>
                          <td>Sarah Williams</td>
                          <td>Sarah Williams</td>
                          <td>Found</td>
                          <td>Robert Brown</td>
                          <td>Nassarawa</td>
                        </tr>
                        <tr>
                          <td>2023-07-12</td>
                          <td>File Number</td>
                          <td>MLSF/KN/2023/003</td>
                          <td>MLSF/KN/2023/003</td>
                          <td>Found</td>
                          <td>Emily Davis</td>
                          <td>Tarauni</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      `;

      // Initialize reports chart
      const reportsCtx = document.getElementById('reportsChart').getContext('2d');
      new Chart(reportsCtx, {
        type: 'line',
        data: {
          labels: monthlyData.map(d => d.month),
          datasets: [{
            label: 'Searches',
            data: monthlyData.map(d => d.searches),
            borderColor: '#3B82F6',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            tension: 0.4,
            fill: true
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: 'top',
            },
            title: {
              display: true,
              text: 'Monthly Search Volume'
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              title: {
                display: true,
                text: 'Number of Searches'
              }
            },
            x: {
              title: {
                display: true,
                text: 'Month'
              }
            }
          }
        }
      });

      // Add event listeners to report tabs
      document.querySelectorAll('[data-report-tab]').forEach(tab => {
        tab.addEventListener('click', () => {
          // Remove active class from all tabs
          document.querySelectorAll('[data-report-tab]').forEach(t => t.classList.remove('active'));
          // Add active class to clicked tab
          tab.classList.add('active');
          
          // Hide all tab content
          document.querySelectorAll('#summary-tab, #detailed-tab').forEach(content => content.classList.remove('active'));
          // Show content for clicked tab
          const tabId = tab.getAttribute('data-report-tab');
          document.getElementById(`${tabId}-tab`).classList.add('active');
        });
      });

      // Add event listener to back button
      document.getElementById('back-to-dashboard-from-reports-btn').addEventListener('click', () => {
        reportsView.classList.add('hidden');
        dashboardView.classList.remove('hidden');
      });
    });

    // Add event delegation for delete action buttons
    document.addEventListener('click', (e) => {
      if (e.target.closest('.delete-action')) {
        // In a real app, you would show a confirmation dialog
        alert('Delete functionality would be implemented here.');
      }
      
      if (e.target.closest('.edit-action')) {
        // In a real app, you would open an edit form
        alert('Edit functionality would be implemented here.');
      }
      
      if (e.target.closest('#view-detailed-records-btn')) {
        // Show legal search report view
        fileHistoryView.classList.add('hidden');
        legalSearchReportView.classList.remove('hidden');
        
        // Render the legal search report
        renderLegalSearchReport();
      }
    });

    // Back to file details from legal search report view
    backToFileDetailsBtn.addEventListener('click', () => {
      legalSearchReportView.classList.add('hidden');
      fileHistoryView.classList.remove('hidden');
    });

    // Print report
    printReportBtn.addEventListener('click', () => {
      window.print();
    });

    // Render legal search report
    const renderLegalSearchReport = () => {
      if (!selectedFile) return;
      
      // Set current date and time
      const currentDate = new Date().toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      });
      
      const currentTime = new Date().toLocaleTimeString('en-US', {
        hour: '2-digit',
        minute: '2-digit',
        hour12: true
      });
      
      // Update report header
      document.getElementById('report-file-reference').textContent = selectedFile.fileNumber;
      document.getElementById('report-date').textContent = `Date: ${currentDate}`;
      document.getElementById('report-timestamp').textContent = `These details are as at ${currentDate} ${currentTime}`;
      
      // Update property details
      document.getElementById('report-file-numbers').textContent = `mlsfNo: ${selectedFile.fileNumber} | kangisFileNo: ${selectedFile.kangisFileNo} | NewKANGISFileNo: ${selectedFile.newKangisFileNo}`;
      document.getElementById('report-plot-number').textContent = selectedFile.plotNumber || "GP No. 1067/1 & 1067/2";
      document.getElementById('report-plan-number').textContent = selectedFile.planNumber || "LKN/RES/2021/3006";
      document.getElementById('report-plot-description').textContent = `${selectedFile.district || "Niger Street Nassarawa District"}, ${selectedFile.lga || "Nassarawa"} LGA`;
      
      // Generate QR code URL
      const qrCodeData = `File Number: MLSF: ${selectedFile.fileNumber} | KANGIS: ${selectedFile.kangisFileNo} | New KANGIS: ${selectedFile.newKangisFileNo}`;
      const qrCodeUrl = `https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=${encodeURIComponent(qrCodeData)}`;
      document.getElementById('report-qr-code').src = qrCodeUrl;
      
      // Render transaction history table
      const transactionsTable = document.getElementById('report-transactions-table');
      transactionsTable.innerHTML = '';
      
      if (selectedFile.history && selectedFile.history.length > 0) {
        selectedFile.history.forEach((transaction, index) => {
          const row = document.createElement('tr');
          row.innerHTML = `
            <td class="border border-gray-300 px-3 py-2">${index + 1}</td>
            <td class="border border-gray-300 px-3 py-2">${transaction.guarantor}</td>
            <td class="border border-gray-300 px-3 py-2">${transaction.guarantee}</td>
            <td class="border border-gray-300 px-3 py-2">${transaction.transactionType}</td>
            <td class="border border-gray-300 px-3 py-2">${transaction.date}</td>
            <td class="border border-gray-300 px-3 py-2">${index + 1}/${index + 1}/1</td>
            <td class="border border-gray-300 px-3 py-2">${transaction.size || "0.0192ha"}</td>
            <td class="border border-gray-300 px-3 py-2 ${transaction.caveat === 'Yes' ? 'text-red-600' : ''}">${transaction.caveat}</td>
            <td class="border border-gray-300 px-3 py-2">${transaction.comments || "Transfer registered"}</td>
          `;
          transactionsTable.appendChild(row);
        });
      } else {
        const row = document.createElement('tr');
        row.innerHTML = `
          <td colspan="9" class="border border-gray-300 px-3 py-2 text-center">No transaction history found</td>
        `;
        transactionsTable.appendChild(row);
      }
    };

    // Add input event listeners for search fields
    document.getElementById('fileNumber').addEventListener('input', performSearch);
    document.getElementById('kangisFileNo').addEventListener('input', performSearch);

    // Close modal when pressing Escape key
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        searchModal.classList.add('hidden');
        deleteConfirmDialog.classList.add('hidden');
      }
    });
  </script>
 


        </div>

        <!-- Footer -->
        @include('admin.footer')
    </div>
   

@endsection
