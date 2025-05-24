@extends('layouts.app')
@section('page-title')
    {{ __('Property Record Assistant') }}
@endsection

 
@section('content')
<style>
    /* Custom styles */
    .dialog-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 50;
    }
    
    .dialog-content {
        background-color: white;
        border-radius: 0.5rem;
        padding: 1.5rem;
        max-width: 600px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
    }
    
    .hidden {
        display: none;
    }
    
    .tab-content {
        display: none;
    }
    
    .tab-content.active {
        display: block;
    }
    
    .badge {
        display: inline-flex;
        align-items: center;
        border-radius: 9999px;
        padding: 0.25rem 0.75rem;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .badge-green {
        background-color: #10b981;
        color: white;
    }
    
    .badge-outline {
        background-color: transparent;
        border: 1px solid #e5e7eb;
    }

    /* Project-specific styles */
    .tabs-container {
        display: flex;
        justify-content: center;
        border-bottom: 1px solid #e5e7eb;
        margin-bottom: 1rem;
    }

    .tab-button {
        padding: 0.75rem 1.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        border-bottom: 2px solid transparent;
        transition: all 0.2s;
    }

    .tab-button.active {
        border-bottom-color: #2563eb;
        color: #2563eb;
    }

    .form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: #374151;
    }

    .form-input {
        width: 100%;
        padding: 0.5rem 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        font-size: 0.875rem;
    }

    .form-select {
        width: 100%;
        padding: 0.5rem 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        background-color: white;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        font-weight: 500;
        border-radius: 0.375rem;
        transition: all 0.2s;
    }

    .btn-primary {
        background-color: #2563eb;
        color: white;
    }

    .btn-primary:hover {
        background-color: #1d4ed8;
    }

    .btn-secondary {
        background-color: white;
        color: #374151;
        border: 1px solid #d1d5db;
    }

    .btn-secondary:hover {
        background-color: #f9fafb;
    }

    .card {
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        overflow: hidden;
    }

    .card-header {
        padding: 1rem;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .card-body {
        padding: 1rem;
    }

    .table-container {
        overflow-x: auto;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th {
        background-color: #f9fafb;
        padding: 0.75rem 1rem;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 500;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 1px solid #e5e7eb;
    }

    .table td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #e5e7eb;
        font-size: 0.875rem;
        color: #374151;
    }

    .form-section {
        background-color: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 0.375rem;
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .form-section-title {
        font-size: 0.875rem;
        font-weight: 500;
        color: #374151;
        margin-bottom: 0.75rem;
    }
</style>
    <!-- Main Content -->
    <div class="flex-1 overflow-auto">
        <!-- Header -->
        @include('admin.header')
        <!-- Dashboard Content -->
        <div class="p-6">
            <div class="container mx-auto py-6 space-y-6">
                <!-- Page Header -->
                <div class="flex flex-col space-y-2">
                    <h1 class="text-3xl font-bold tracking-tight">Property Record Assistant</h1>
                    <p class="text-gray-500">Capture and manage property records and transactions</p>
                </div>
        
                <!-- Tabs - Centered with project colors -->
                <div class="tabs-container">
                    <button id="tab-property-details" class="tab-button active">Property Record</button>
                    <button id="tab-property-transactions" class="tab-button">Property Transactions</button>
                    <button id="tab-property-files" class="tab-button">CofO Records</button>
                </div>
        
                <!-- Property Details Tab Content -->
                <div id="property-details-content" class="tab-content active">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="text-lg font-medium">Property Records</h2>
                            <div class="flex items-center gap-2">
                                <input type="text" id="property-search" class="form-input w-64" placeholder="Search properties...">
                                <button id="add-property-btn" class="btn btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 mr-2">
                                        <path d="M12 5v14M5 12h14"></path>
                                    </svg>
                                    Add New Property
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Property Cards -->
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                                <!-- Add New Property Card -->
                                <div class="border rounded-lg shadow-sm cursor-pointer hover:bg-blue-50 transition-colors" id="add-property-card">
                                    <div class="flex flex-col items-center justify-center p-6">
                                        <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center mb-3">
                                            <span class="text-blue-600 text-xl">+</span>
                                        </div>
                                        <h3 class="text-lg font-medium text-center">Add New Property</h3>
                                        <p class="text-sm text-gray-500 text-center mt-1">Create a new property record</p>
                                    </div>
                                </div>
        
                                <!-- Sample Property Card -->
                                <div class="border rounded-lg shadow-sm overflow-hidden">
                                    <div class="bg-gray-50 p-4 border-b">
                                        <div class="flex justify-between items-center">
                                            <span class="bg-blue-100 text-blue-700 border-blue-200 px-2 py-1 rounded-full text-xs">Residential</span>
                                            <button class="text-gray-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                                    <circle cx="12" cy="12" r="1"></circle>
                                                    <circle cx="12" cy="5" r="1"></circle>
                                                    <circle cx="12" cy="19" r="1"></circle>
                                                </svg>
                                            </button>
                                        </div>
                                        <h3 class="mt-2 font-bold">KNML 09846</h3>
                                    </div>
                                    <div class="p-4">
                                        <div class="space-y-3">
                                            <div class="text-sm truncate">3 Bedroom Apartment in Kano City</div>
                                            <div class="space-y-1">
                                                <div class="flex justify-between text-xs">
                                                    <span class="text-gray-500">Location:</span>
                                                    <span>KANO</span>
                                                </div>
                                                <div class="flex justify-between text-xs">
                                                    <span class="text-gray-500">Plot No:</span>
                                                    <span>A123</span>
                                                </div>
                                                <div class="flex justify-between text-xs">
                                                    <span class="text-gray-500">Reg No:</span>
                                                    <span>1/1/2</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-4 pt-0 flex justify-between border-t">
                                        <div class="text-xs text-gray-500">
                                            <div>From: John Doe</div>
                                            <div>To: Jane Smith</div>
                                        </div>
                                        <button class="px-2 py-1 border rounded-md text-sm flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 mr-1">
                                                <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                                                <circle cx="12" cy="12" r="3"></circle>
                                            </svg>
                                            Details
                                        </button>
                                    </div>
                                </div>
        
                                <!-- Sample Property Card 2 -->
                                <div class="border rounded-lg shadow-sm overflow-hidden">
                                    <div class="bg-gray-50 p-4 border-b">
                                        <div class="flex justify-between items-center">
                                            <span class="bg-blue-100 text-blue-700 border-blue-200 px-2 py-1 rounded-full text-xs">Commercial</span>
                                            <button class="text-gray-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                                    <circle cx="12" cy="12" r="1"></circle>
                                                    <circle cx="12" cy="5" r="1"></circle>
                                                    <circle cx="12" cy="19" r="1"></circle>
                                                </svg>
                                            </button>
                                        </div>
                                        <h3 class="mt-2 font-bold">KNGP 00338</h3>
                                    </div>
                                    <div class="p-4">
                                        <div class="space-y-3">
                                            <div class="text-sm truncate">Commercial Building in Fagge</div>
                                            <div class="space-y-1">
                                                <div class="flex justify-between text-xs">
                                                    <span class="text-gray-500">Location:</span>
                                                    <span>FAGGE</span>
                                                </div>
                                                <div class="flex justify-between text-xs">
                                                    <span class="text-gray-500">Plot No:</span>
                                                    <span>B456</span>
                                                </div>
                                                <div class="flex justify-between text-xs">
                                                    <span class="text-gray-500">Reg No:</span>
                                                    <span>1/1/5</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-4 pt-0 flex justify-between border-t">
                                        <div class="text-xs text-gray-500">
                                            <div>From: ABC Corporation</div>
                                            <div>To: XYZ Limited</div>
                                        </div>
                                        <button class="px-2 py-1 border rounded-md text-sm flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 mr-1">
                                                <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                                                <circle cx="12" cy="12" r="3"></circle>
                                            </svg>
                                            Details
                                        </button>
                                    </div>
                                </div>
                            </div>
        
                            <!-- Property Table -->
                            <div class="table-container">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>File Number</th>
                                            <th>Description</th>
                                            <th>Location</th>
                                            <th>Reg No</th>
                                            <th>Assignor</th>
                                            <th>Assignee</th>
                                            <th>Instrument</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="font-medium">KNML 09846</td>
                                            <td>3 Bedroom Apartment in Kano City</td>
                                            <td>KANO</td>
                                            <td>1/1/2</td>
                                            <td>John Doe</td>
                                            <td>Jane Smith</td>
                                            <td>Certificate of Occupancy</td>
                                            <td>
                                                <div class="flex items-center gap-2">
                                                    <button class="text-gray-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                                            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                                                            <circle cx="12" cy="12" r="3"></circle>
                                                        </svg>
                                                    </button>
                                                    <button class="text-gray-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                                            <path d="M17 3a2.85 2.85 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path>
                                                            <path d="m15 5 4 4"></path>
                                                        </svg>
                                                    </button>
                                                    <button class="text-gray-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                                            <path d="M3 6h18"></path>
                                                            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                                            <line x1="10" x2="10" y1="11" y2="17"></line>
                                                            <line x1="14" x2="14" y1="11" y2="17"></line>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-medium">KNGP 00338</td>
                                            <td>Commercial Building in Fagge</td>
                                            <td>FAGGE</td>
                                            <td>1/1/5</td>
                                            <td>ABC Corporation</td>
                                            <td>XYZ Limited</td>
                                            <td>Deed of Assignment</td>
                                            <td>
                                                <div class="flex items-center gap-2">
                                                    <button class="text-gray-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                                            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                                                            <circle cx="12" cy="12" r="3"></circle>
                                                        </svg>
                                                    </button>
                                                    <button class="text-gray-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                                            <path d="M17 3a2.85 2.85 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path>
                                                            <path d="m15 5 4 4"></path>
                                                        </svg>
                                                    </button>
                                                    <button class="text-gray-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                                            <path d="M3 6h18"></path>
                                                            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                                            <line x1="10" x2="10" y1="11" y2="17"></line>
                                                            <line x1="14" x2="14" y1="11" y2="17"></line>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
        
                <!-- Property Transactions Tab Content -->
                <div id="property-transactions-content" class="tab-content">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="text-lg font-medium">Property Transactions</h2>
                            <div class="flex space-x-2">
                                <button class="btn btn-secondary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 mr-2">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                        <polyline points="7 10 12 15 17 10"></polyline>
                                        <line x1="12" x2="12" y1="15" y2="3"></line>
                                    </svg>
                                    Export
                                </button>
                                <button class="btn btn-secondary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 mr-2">
                                        <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                        <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                                        <rect width="12" height="8" x="6" y="14"></rect>
                                    </svg>
                                    Print
                                </button>
                                <button id="add-transaction-btn" class="btn btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 mr-2">
                                        <path d="M5 12h14"></path>
                                        <path d="M12 5v14"></path>
                                    </svg>
                                    Add Transaction
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="flex items-center space-x-4 mb-6">
                                <div class="flex-1">
                                    <input type="text" id="transaction-search" class="form-input" placeholder="Search by file number, parties, or instrument type...">
                                </div>
                                <div class="w-[200px]">
                                    <select id="transaction-filter" class="form-select">
                                        <option value="all">All Transaction Types</option>
                                        <option value="assignment">Assignment</option>
                                        <option value="mortgage">Mortgage</option>
                                        <option value="surrender">Surrender</option>
                                        <option value="sub-lease">Sub-Lease</option>
                                        <option value="release">Release</option>
                                        <option value="devolution order">Devolution Order</option>
                                        <option value="court order">Court Order</option>
                                        <option value="revocation">Revocation</option>
                                        <option value="certificate of occupancy">Certificate of Occupancy</option>
                                        <option value="power of attorney">Power of Attorney</option>
                                    </select>
                                </div>
                            </div>
        
                            <div class="table-container">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Transaction Type</th>
                                            <th>File Number</th>
                                            <th>From Party</th>
                                            <th>To Party</th>
                                            <th>Instrument Type</th>
                                            <th>Registration No</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>2023-05-15</td>
                                            <td>Assignment</td>
                                            <td>KNML 39762</td>
                                            <td>John Doe</td>
                                            <td>Jane Smith</td>
                                            <td>Deed of Assignment</td>
                                            <td>1/1/2</td>
                                            <td>
                                                <span class="badge badge-green">Completed</span>
                                            </td>
                                            <td>
                                                <button class="text-gray-500 view-transaction-details" data-id="1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                                        <polyline points="14 2 14 8 20 8"></polyline>
                                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                                        <polyline points="10 9 9 9 8 9"></polyline>
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2023-06-22</td>
                                            <td>Mortgage</td>
                                            <td>KNML 39762</td>
                                            <td>Jane Smith</td>
                                            <td>First Bank Nigeria</td>
                                            <td>Deed of Mortgage</td>
                                            <td>1/1/5</td>
                                            <td>
                                                <span class="badge badge-green">Completed</span>
                                            </td>
                                            <td>
                                                <button class="text-gray-500 view-transaction-details" data-id="2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                                        <polyline points="14 2 14 8 20 8"></polyline>
                                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                                        <polyline points="10 9 9 9 8 9"></polyline>
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2023-08-10</td>
                                            <td>Surrender</td>
                                            <td>KNML 39762</td>
                                            <td>First Bank Nigeria</td>
                                            <td>Jane Smith</td>
                                            <td>Deed of Surrender</td>
                                            <td>1/1/8</td>
                                            <td>
                                                <span class="badge badge-outline">Pending</span>
                                            </td>
                                            <td>
                                                <button class="text-gray-500 view-transaction-details" data-id="3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                                        <polyline points="14 2 14 8 20 8"></polyline>
                                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                                        <polyline points="10 9 9 9 8 9"></polyline>
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
        
                <!-- CofO Records Tab Content -->
                <div id="property-files-content" class="tab-content">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="text-lg font-medium">CofO Records Table</h2>
                            <div class="flex space-x-2">
                                <button class="btn btn-secondary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 mr-2">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                        <polyline points="7 10 12 15 17 10"></polyline>
                                        <line x1="12" x2="12" y1="15" y2="3"></line>
                                    </svg>
                                    Export
                                </button>
                                <button class="btn btn-secondary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 mr-2">
                                        <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                        <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                                        <rect width="12" height="8" x="6" y="14"></rect>
                                    </svg>
                                    Print
                                </button>
                                <button id="capture-cofo-btn" class="btn btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 mr-2">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                        <polyline points="10 9 9 9 8 9"></polyline>
                                    </svg>
                                    Capture CofO
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="flex items-center space-x-4 mb-6">
                                <div class="flex-1">
                                    <input type="text" id="cofo-search" class="form-input" placeholder="Search files...">
                                </div>
                                <div class="w-[200px]">
                                    <select id="cofo-filter" class="form-select">
                                        <option value="all">All File Types</option>
                                        <option value="Certificate">Certificate</option>
                                        <option value="Legal Document">Legal Document</option>
                                        <option value="Plan">Plan</option>
                                    </select>
                                </div>
                                <div class="w-[300px] border rounded-md overflow-hidden">
                                    <div class="flex">
                                        <button class="flex-1 py-2 bg-blue-600 text-white">All</button>
                                        <button class="flex-1 py-2 bg-gray-100">Active</button>
                                        <button class="flex-1 py-2 bg-gray-100">Archived</button>
                                    </div>
                                </div>
                            </div>
        
                            <div class="table-container">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>File No.</th>
                                            <th>Reg Number</th>
                                            <th>Land Use</th>
                                            <th>Plot Description</th>
                                            <th>Ground Rent</th>
                                            <th>Lease Period</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="font-medium">KNML 39762</td>
                                            <td>1/1/2</td>
                                            <td>Residential</td>
                                            <td>Plot 45, Block B, Kaduna North</td>
                                            <td>₦50,000</td>
                                            <td>99 years</td>
                                            <td>
                                                <div class="flex space-x-2">
                                                    <button class="text-gray-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                                            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                                                            <circle cx="12" cy="12" r="3"></circle>
                                                        </svg>
                                                    </button>
                                                    <button class="text-gray-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                            <polyline points="7 10 12 15 17 10"></polyline>
                                                            <line x1="12" x2="12" y1="15" y2="3"></line>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-medium">KNML 42851</td>
                                            <td>1/1/3</td>
                                            <td>Commercial</td>
                                            <td>Plot 12, Block C, Kaduna South</td>
                                            <td>₦75,000</td>
                                            <td>99 years</td>
                                            <td>
                                                <div class="flex space-x-2">
                                                    <button class="text-gray-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                                            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                                                            <circle cx="12" cy="12" r="3"></circle>
                                                        </svg>
                                                    </button>
                                                    <button class="text-gray-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                            <polyline points="7 10 12 15 17 10"></polyline>
                                                            <line x1="12" x2="12" y1="15" y2="3"></line>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
            <!-- Property Form Dialog -->
            <div id="property-form-dialog" class="dialog-overlay hidden">
                <div class="dialog-content">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold">Add New Property</h2>
                        <button id="close-property-form" class="text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </div>
                    <form id="property-form" class="space-y-6">
                        <!-- File Information - Full Width -->
                        <div class="form-section w-full">
                            <h4 class="form-section-title">File Information</h4>
                            <div class="space-y-3">
                                <div>
                                    <label class="text-xs text-gray-600">File Number Type</label>
                                    <div class="border-b">
                                        <div class="flex">
                                            <button type="button" class="file-type-btn px-4 py-2 border-b-2 border-blue-500 font-medium text-blue-600" data-type="mlsFileNo">MLS</button>
                                            <button type="button" class="file-type-btn px-4 py-2 border-b-2 border-transparent font-medium text-gray-500" data-type="kangisFileNo">KANGIS</button>
                                            <button type="button" class="file-type-btn px-4 py-2 border-b-2 border-transparent font-medium text-gray-500" data-type="newKangisFileNo">New KANGIS</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="space-y-1.5">
                                        <label for="filePrefix" class="text-xs">File Prefix</label>
                                        <select id="filePrefix" class="form-select text-sm">
                                            <option value="">Select prefix</option>
                                            <option value="RES">RES</option>
                                            <option value="COM">COM</option>
                                            <option value="CON-COM">CON-COM</option>
                                            <option value="IND">IND</option>
                                        </select>
                                    </div>
                                    <div class="space-y-1.5">
                                        <label for="fileSerialNo" class="text-xs">Serial Number</label>
                                        <input id="fileSerialNo" type="text" class="form-input text-sm" placeholder="e.g. 2019-296 or 91-249">
                                    </div>
                                </div>
                                <div id="fileNoPreview" class="mt-2 p-2 bg-green-50 border border-green-100 rounded-md hidden">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-green-800">Complete File Number:</span>
                                        <span id="completeFileNo" class="text-sm font-medium text-green-800"></span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-3 gap-3">
                                    <div>
                                        <label for="serialNo" class="text-xs text-gray-600">Serial No.</label>
                                        <input id="serialNo" type="text" class="form-input text-sm" placeholder="e.g. 1">
                                    </div>
                                    <div>
                                        <label for="page" class="text-xs text-gray-600">Page</label>
                                        <input id="page" type="text" class="form-input text-sm" placeholder="e.g. 1">
                                    </div>
                                    <div>
                                        <label for="vol" class="text-xs text-gray-600">Volume</label>
                                        <input id="vol" type="text" class="form-input text-sm" placeholder="e.g. 2">
                                    </div>
                                </div>
                                <div id="regNoPreview" class="mt-2 p-2 bg-green-50 border border-green-100 rounded-md hidden">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-green-700">REG NO:</span>
                                        <span id="completeRegNo" class="text-sm font-medium text-green-800"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
        
                        <!-- Ownership Information - Full Width -->
                        <div class="form-section w-full">
                            <h4 class="form-section-title">Ownership Information</h4>
                            <div class="space-y-3">
                                <div>
                                    <label for="assignor" class="text-xs text-gray-600">Assignor</label>
                                    <input id="assignor" type="text" class="form-input text-sm">
                                </div>
                                <div>
                                    <label for="assignee" class="text-xs text-gray-600">Assignee</label>
                                    <input id="assignee" type="text" class="form-input text-sm">
                                </div>
                            </div>
                        </div>
        
                        <!-- Two Column Layout for Property Details and Classification -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="form-section">
                                <h4 class="form-section-title">Property Details</h4>
                                <div class="space-y-3">
                                    <div>
                                        <label for="description" class="text-xs text-gray-600">Description</label>
                                        <textarea id="description" class="form-input text-sm" rows="2"></textarea>
                                    </div>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label for="lgsaOrCity" class="text-xs text-gray-600">LGA/City</label>
                                            <input id="lgsaOrCity" type="text" class="form-input text-sm">
                                        </div>
                                        <div>
                                            <label for="plotNo" class="text-xs text-gray-600">Plot No.</label>
                                            <input id="plotNo" type="text" class="form-input text-sm">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-section">
                                <h4 class="form-section-title">Classification</h4>
                                <div class="space-y-3">
                                    <div>
                                        <label for="instrument" class="text-xs text-gray-600">Instrument</label>
                                        <select id="instrument" class="form-select text-sm">
                                            <option value="">Select Instrument</option>
                                            <option value="Certificate of Occupancy">Certificate of Occupancy</option>
                                            <option value="Right of Occupancy">Right of Occupancy</option>
                                            <option value="Deed of Assignment">Deed of Assignment</option>
                                            <option value="Deed of Mortgage">Deed of Mortgage</option>
                                        </select>
                                    </div>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label for="layout" class="text-xs text-gray-600">Layout</label>
                                            <select id="layout" class="form-select text-sm">
                                                <option value="">Select Layout</option>
                                                <option value="Residential">Residential</option>
                                                <option value="Commercial">Commercial</option>
                                                <option value="Industrial">Industrial</option>
                                                <option value="Agricultural">Agricultural</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="schedule" class="text-xs text-gray-600">Schedule</label>
                                            <select id="schedule" class="form-select text-sm">
                                                <option value="">Select Schedule</option>
                                                <option value="Regular">Regular</option>
                                                <option value="Sectional">Sectional</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
        
                        <!-- System References - Full Width -->
                        <div class="form-section w-full">
                            <h4 class="form-section-title">System References</h4>
                            <div class="space-y-3">
                                <div>
                                    <label for="mlsFileNo" class="text-xs text-gray-600">Legacy File Number (MLS)</label>
                                    <input id="mlsFileNo" type="text" class="form-input text-sm" placeholder="e.g. CON-COM-2019-296, RES-2015-4859">
                                </div>
                                <div>
                                    <label for="kangisFileNo" class="text-xs text-gray-600">KANGIS File Number</label>
                                    <input id="kangisFileNo" type="text" class="form-input text-sm" placeholder="e.g. KNML 09846, KNGP 00338">
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-end space-x-3 pt-4 border-t">
                            <button type="button" id="cancel-property-form" class="btn btn-secondary">Cancel</button>
                            <button type="submit" class="btn btn-primary">Create Record</button>
                        </div>
                    </form>
                </div>
            </div>
        
            <!-- Transaction Details Dialog -->
            <div id="transaction-details-dialog" class="dialog-overlay hidden">
                <div class="dialog-content">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold">Transaction Details</h2>
                        <button id="close-transaction-details" class="text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </div>
                    <div class="grid grid-cols-2 gap-4 py-4">
                        <div class="space-y-1">
                            <p class="text-sm font-medium text-gray-500">Transaction Type</p>
                            <p id="transaction-type" class="font-medium">Assignment</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-sm font-medium text-gray-500">Date</p>
                            <p id="transaction-date" class="font-medium">2023-05-15</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-sm font-medium text-gray-500">File Number</p>
                            <p id="transaction-file-number" class="font-medium">KNML 39762</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-sm font-medium text-gray-500">Registration Number</p>
                            <p id="transaction-reg-number" class="font-medium">1/1/2</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-sm font-medium text-gray-500">From Party</p>
                            <p id="transaction-from-party" class="font-medium">John Doe</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-sm font-medium text-gray-500">To Party</p>
                            <p id="transaction-to-party" class="font-medium">Jane Smith</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-sm font-medium text-gray-500">Instrument Type</p>
                            <p id="transaction-instrument-type" class="font-medium">Deed of Assignment</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-sm font-medium text-gray-500">Status</p>
                            <span id="transaction-status" class="badge badge-green">Completed</span>
                        </div>
                        <div class="col-span-2 space-y-1">
                            <p class="text-sm font-medium text-gray-500">Additional Notes</p>
                            <p id="transaction-notes" class="text-sm">No additional notes available for this transaction.</p>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3 pt-4 border-t">
                        <button id="close-transaction-details-btn" class="btn btn-secondary">Close</button>
                        <button class="btn btn-primary">Edit Transaction</button>
                    </div>
                </div>
            </div>
        
            <!-- Add Transaction Dialog -->
            <div id="add-transaction-dialog" class="dialog-overlay hidden">
                <div class="dialog-content">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold">Add Property Transaction</h2>
                        <button id="close-add-transaction" class="text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </div>
                    <div class="space-y-4 py-2 max-h-[70vh] overflow-y-auto pr-1">
                        <!-- Title Type Selection -->
                        <div class="form-section">
                            <h4 class="form-section-title">Transaction Type</h4>
                            <div class="space-y-3">
                                <div class="space-y-1">
                                    <label class="text-sm">Title Type</label>
                                    <div class="flex space-x-4">
                                        <div class="flex items-center space-x-1">
                                            <input type="radio" id="customary" name="titleType" value="customary" checked>
                                            <label for="customary" class="text-sm">Customary</label>
                                        </div>
                                        <div class="flex items-center space-x-1">
                                            <input type="radio" id="statutory" name="titleType" value="statutory">
                                            <label for="statutory" class="text-sm">Statutory</label>
                                        </div>
                                    </div>
                                </div>
        
                                <!-- File Number -->
                                <div class="space-y-1">
                                    <label class="text-sm">File Number</label>
                                    <div class="border-b">
                                        <div class="flex">
                                            <button type="button" class="file-type-btn px-4 py-2 border-b-2 border-blue-500 font-medium text-blue-600" data-type="mlsFileNo">MLS</button>
                                            <button type="button" class="file-type-btn px-4 py-2 border-b-2 border-transparent font-medium text-gray-500" data-type="kangisFileNo">KANGIS</button>
                                            <button type="button" class="file-type-btn px-4 py-2 border-b-2 border-transparent font-medium text-gray-500" data-type="newKangisFileNo">New KANGIS</button>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-3 mt-2">
                                        <div class="space-y-1.5">
                                            <label for="transFilePrefix" class="text-xs">File Prefix</label>
                                            <select id="transFilePrefix" class="form-select text-sm">
                                                <option value="">Select prefix</option>
                                                <option value="KNML">KNML</option>
                                                <option value="KNGP">KNGP</option>
                                                <option value="MLKN">MLKN</option>
                                            </select>
                                        </div>
                                        <div class="space-y-1.5">
                                            <label for="transFileSerialNo" class="text-xs">Serial Number</label>
                                            <input id="transFileSerialNo" class="form-input text-sm" placeholder="e.g. 39762">
                                        </div>
                                    </div>
                                    <div id="transFileNoPreview" class="mt-1 p-1.5 bg-green-50 border border-green-100 rounded-md hidden">
                                        <div class="flex items-center justify-between">
                                            <span class="text-xs text-green-800">Complete File Number:</span>
                                            <span id="transCompleteFileNo" class="text-sm font-medium text-green-800"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
        
                        <div class="form-section">
                            <h4 class="form-section-title">Transaction Details</h4>
                            <div class="space-y-3">
                                <!-- Transaction Type and Date -->
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="space-y-1">
                                        <label for="transactionType" class="text-sm">Transaction Type</label>
                                        <select id="transactionType" class="form-select text-sm">
                                            <option value="">Select type</option>
                                            <option value="assignment">Assignment</option>
                                            <option value="mortgage">Mortgage</option>
                                            <option value="surrender">Surrender</option>
                                            <option value="sublease">Sub-Lease</option>
                                            <option value="release">Release</option>
                                            <option value="devolution-order">Devolution Order</option>
                                            <option value="court-order">Court Order</option>
                                            <option value="revocation">Revocation</option>
                                            <option value="certificate-of-occupancy">Certificate of Occupancy</option>
                                            <option value="power-of-attorney">Power of Attorney</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    <div class="space-y-1">
                                        <label for="transactionDate" class="text-sm">Transaction Date</label>
                                        <input type="date" id="transactionDate" class="form-input text-sm">
                                    </div>
                                </div>
        
                                <!-- Registration Number Components -->
                                <div class="space-y-1">
                                    <label class="text-sm">Registration Number Components</label>
                                    <div class="grid grid-cols-3 gap-2">
                                        <div>
                                            <label for="transSerialNo" class="text-xs">Serial No.</label>
                                            <input id="transSerialNo" class="form-input text-sm" placeholder="e.g. 1">
                                        </div>
                                        <div>
                                            <label for="transPage" class="text-xs">Page</label>
                                            <input id="transPage" class="form-input text-sm" placeholder="e.g. 1">
                                        </div>
                                        <div>
                                            <label for="transVol" class="text-xs">Volume</label>
                                            <input id="transVol" class="form-input text-sm" placeholder="e.g. 2">
                                        </div>
                                    </div>
                                    <div id="transRegNoPreview" class="mt-1 p-1.5 bg-green-50 border border-green-100 rounded-md hidden">
                                        <div class="flex items-center justify-between">
                                            <span class="text-xs text-green-700">REG NO:</span>
                                            <span id="transCompleteRegNo" class="text-sm font-medium text-green-800"></span>
                                        </div>
                                        <div class="text-xs text-green-600 text-right">Format: 1/1/2</div>
                                    </div>
                                </div>
        
                                <!-- Instrument Type and Period -->
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="space-y-1">
                                        <label for="instrumentType" class="text-sm">Instrument Type</label>
                                        <select id="instrumentType" class="form-select text-sm" disabled>
                                            <option value="">Select transaction first</option>
                                        </select>
                                    </div>
                                    <div class="space-y-1">
                                        <label for="period" class="text-sm">Period</label>
                                        <div class="flex space-x-1">
                                            <input id="period" type="number" class="form-input text-sm" placeholder="Period">
                                            <select id="periodUnit" class="form-select text-sm w-[90px]">
                                                <option value="days">Days</option>
                                                <option value="months">Months</option>
                                                <option value="years" selected>Years</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
        
                        <!-- Transaction-specific fields (will be shown/hidden based on transaction type) -->
                        <div id="transaction-specific-fields" class="form-section hidden">
                            <h3 class="form-section-title">Transaction Details</h3>
                            <!-- Assignment fields -->
                            <div id="assignment-fields" class="transaction-fields hidden">
                                <div class="grid grid-cols-1 gap-3">
                                    <div class="space-y-1">
                                        <label for="trans-assignor" class="text-sm">Assignor</label>
                                        <input id="trans-assignor" class="form-input text-sm" placeholder="Enter assignor name">
                                    </div>
                                    <div class="space-y-1">
                                        <label for="trans-assignee" class="text-sm">Assignee</label>
                                        <input id="trans-assignee" class="form-input text-sm" placeholder="Enter assignee name">
                                    </div>
                                </div>
                            </div>
                            <!-- Mortgage fields -->
                            <div id="mortgage-fields" class="transaction-fields hidden">
                                <div class="grid grid-cols-1 gap-3">
                                    <div class="space-y-1">
                                        <label for="mortgagor" class="text-sm">Mortgagor</label>
                                        <input id="mortgagor" class="form-input text-sm" placeholder="Enter mortgagor name">
                                    </div>
                                    <div class="space-y-1">
                                        <label for="mortgagee" class="text-sm">Mortgagee</label>
                                        <input id="mortgagee" class="form-input text-sm" placeholder="Enter mortgagee name">
                                    </div>
                                </div>
                            </div>
                            <!-- Other transaction type fields would be added here -->
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3 pt-2 border-t mt-4">
                        <button id="cancel-add-transaction" class="btn btn-secondary">Cancel</button>
                        <button id="submit-transaction" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        
            <!-- Capture CofO Dialog -->
            <div id="capture-cofo-dialog" class="dialog-overlay hidden">
                <div class="dialog-content">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold">Certificate of Occupancy</h2>
                        <button id="close-capture-cofo" class="text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </div>
                    <div class="grid gap-4 py-4">
                        <div class="form-section">
                            <div class="flex items-center gap-2 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 text-green-600">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                    <polyline points="10 9 9 9 8 9"></polyline>
                                </svg>
                                <h3 class="text-sm font-medium">File Number Information</h3>
                            </div>
                            <p class="text-xs mb-3">Select file number type and enter the details</p>
                            <div class="border-b">
                                <div class="flex">
                                    <button type="button" class="cofo-file-type-btn px-4 py-2 border-b-2 border-blue-500 font-medium text-blue-600 text-xs" data-type="mlsFileNo">MLS</button>
                                    <button type="button" class="cofo-file-type-btn px-4 py-2 border-b-2 border-transparent font-medium text-gray-500 text-xs" data-type="kangisFileNo">KANGIS</button>
                                    <button type="button" class="cofo-file-type-btn px-4 py-2 border-b-2 border-transparent font-medium text-gray-500 text-xs" data-type="newKangisFileNo">New KANGIS</button>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-3 mt-3">
                                <div class="space-y-1.5">
                                    <label for="cofoFilePrefix" class="text-xs">File Prefix</label>
                                    <select id="cofoFilePrefix" class="form-select text-xs">
                                        <option value="">Select prefix</option>
                                        <option value="KNML">KNML</option>
                                        <option value="KNGP">KNGP</option>
                                        <option value="MLKN">MLKN</option>
                                    </select>
                                </div>
                                <div class="space-y-1.5">
                                    <label for="cofoFileSerialNo" class="text-xs">Serial Number</label>
                                    <input id="cofoFileSerialNo" class="form-input text-xs" placeholder="e.g. 39762">
                                </div>
                            </div>
                        </div>
        
                        <div class="form-section">
                            <h4 class="form-section-title">Certificate Details</h4>
                            <div class="space-y-3">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <label for="regNumber" class="form-label">Reg Number:</label>
                                        <input id="regNumber" type="text" class="form-input">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="form-label">Title:</label>
                                        <div class="flex space-x-4">
                                            <div class="flex items-center space-x-2">
                                                <input type="radio" id="old" name="titleType" value="old" checked>
                                                <label for="old">Old</label>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <input type="radio" id="new" name="titleType" value="new">
                                                <label for="new">New</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
        
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <label for="regPage" class="form-label">Reg Page:</label>
                                        <input id="regPage" type="text" class="form-input">
                                    </div>
                                    <div class="space-y-2">
                                        <label for="landUseType" class="form-label">Land Use Type:</label>
                                        <select id="landUseType" class="form-select">
                                            <option value="">Select land use type</option>
                                            <option value="residential">Residential</option>
                                            <option value="commercial">Commercial</option>
                                            <option value="industrial">Industrial</option>
                                            <option value="agricultural">Agricultural</option>
                                            <option value="mixed-use">Mixed Use</option>
                                            <option value="institutional">Institutional</option>
                                        </select>
                                    </div>
                                </div>
        
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <label for="regVolume" class="form-label">Reg Volume:</label>
                                        <input id="regVolume" type="text" class="form-input">
                                    </div>
                                    <div class="space-y-2">
                                        <label for="plotDescription" class="form-label">Plot Description:</label>
                                        <input id="plotDescription" type="text" class="form-input">
                                    </div>
                                </div>
        
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <label for="groundRent" class="form-label">Ground Rent:</label>
                                        <input id="groundRent" type="text" class="form-input">
                                    </div>
                                    <div class="space-y-2">
                                        <label for="regDate" class="form-label">Reg Date:</label>
                                        <select id="regDate" class="form-select">
                                            <option value="">Select year</option>
                                            <!-- Years would be dynamically populated -->
                                            <option value="2023">2023</option>
                                            <option value="2022">2022</option>
                                            <option value="2021">2021</option>
                                            <option value="2020">2020</option>
                                        </select>
                                    </div>
                                </div>
        
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <label for="leasePeriod" class="form-label">Lease Period:</label>
                                        <div class="flex items-center space-x-2">
                                            <input id="leasePeriod" type="number" class="form-input" value="99">
                                            <span>year(s)</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3 pt-4 border-t">
                        <button id="cancel-capture-cofo" class="btn btn-secondary">Cancel</button>
                        <button id="save-cofo" class="btn btn-primary">Save Certificate of Occupancy</button>
                    </div>
                </div>
            </div>
        
        </div>

        <!-- Footer -->
        @include('admin.footer')
    </div>
   

    <script>
        // Tab switching functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Tab switching
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    // Remove active class from all buttons and contents
                    tabButtons.forEach(btn => {
                        btn.classList.remove('active');
                    });
                    tabContents.forEach(content => {
                        content.classList.remove('active');
                    });

                    // Add active class to clicked button and corresponding content
                    button.classList.add('active');
                    const tabId = button.id.replace('tab-', '');
                    document.getElementById(`${tabId}-content`).classList.add('active');
                });
            });

            // Property Form Dialog
            const propertyFormDialog = document.getElementById('property-form-dialog');
            const addPropertyBtn = document.getElementById('add-property-btn');
            const addPropertyCard = document.getElementById('add-property-card');
            const closePropertyForm = document.getElementById('close-property-form');
            const cancelPropertyForm = document.getElementById('cancel-property-form');
            const propertyForm = document.getElementById('property-form');

            function showPropertyForm() {
                propertyFormDialog.classList.remove('hidden');
            }

            function hidePropertyForm() {
                propertyFormDialog.classList.add('hidden');
            }

            addPropertyBtn.addEventListener('click', showPropertyForm);
            addPropertyCard.addEventListener('click', showPropertyForm);
            closePropertyForm.addEventListener('click', hidePropertyForm);
            cancelPropertyForm.addEventListener('click', hidePropertyForm);

            propertyForm.addEventListener('submit', function(e) {
                e.preventDefault();
                // Handle form submission
                hidePropertyForm();
            });

            // File Number Preview
            const filePrefix = document.getElementById('filePrefix');
            const fileSerialNo = document.getElementById('fileSerialNo');
            const fileNoPreview = document.getElementById('fileNoPreview');
            const completeFileNo = document.getElementById('completeFileNo');

            function updateFileNoPreview() {
                if (filePrefix.value && fileSerialNo.value) {
                    const prefix = filePrefix.value;
                    const serialNo = fileSerialNo.value;
                    completeFileNo.textContent = `${prefix}-${serialNo}`;
                    fileNoPreview.classList.remove('hidden');
                } else {
                    fileNoPreview.classList.add('hidden');
                }
            }

            filePrefix.addEventListener('change', updateFileNoPreview);
            fileSerialNo.addEventListener('input', updateFileNoPreview);

            // Registration Number Preview
            const serialNo = document.getElementById('serialNo');
            const page = document.getElementById('page');
            const vol = document.getElementById('vol');
            const regNoPreview = document.getElementById('regNoPreview');
            const completeRegNo = document.getElementById('completeRegNo');

            function updateRegNoPreview() {
                if (serialNo.value || page.value || vol.value) {
                    const serial = serialNo.value || '-';
                    const pg = page.value || '-';
                    const volume = vol.value || '-';
                    completeRegNo.textContent = `${serial}/${pg}/${volume}`;
                    regNoPreview.classList.remove('hidden');
                } else {
                    regNoPreview.classList.add('hidden');
                }
            }

            serialNo.addEventListener('input', updateRegNoPreview);
            page.addEventListener('input', updateRegNoPreview);
            vol.addEventListener('input', updateRegNoPreview);

            // Transaction Details Dialog
            const transactionDetailsDialog = document.getElementById('transaction-details-dialog');
            const viewTransactionButtons = document.querySelectorAll('.view-transaction-details');
            const closeTransactionDetails = document.getElementById('close-transaction-details');
            const closeTransactionDetailsBtn = document.getElementById('close-transaction-details-btn');

            function showTransactionDetails(transactionId) {
                // In a real app, you would fetch transaction details by ID
                // For now, we'll just show the dialog with sample data
                transactionDetailsDialog.classList.remove('hidden');
            }

            function hideTransactionDetails() {
                transactionDetailsDialog.classList.add('hidden');
            }

            viewTransactionButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const transactionId = button.getAttribute('data-id');
                    showTransactionDetails(transactionId);
                });
            });

            closeTransactionDetails.addEventListener('click', hideTransactionDetails);
            closeTransactionDetailsBtn.addEventListener('click', hideTransactionDetails);

            // Add Transaction Dialog
            const addTransactionDialog = document.getElementById('add-transaction-dialog');
            const addTransactionBtn = document.getElementById('add-transaction-btn');
            const closeAddTransaction = document.getElementById('close-add-transaction');
            const cancelAddTransaction = document.getElementById('cancel-add-transaction');
            const submitTransaction = document.getElementById('submit-transaction');
            const transactionType = document.getElementById('transactionType');
            const instrumentType = document.getElementById('instrumentType');
            const transactionSpecificFields = document.getElementById('transaction-specific-fields');
            const allTransactionFields = document.querySelectorAll('.transaction-fields');

            function showAddTransaction() {
                addTransactionDialog.classList.remove('hidden');
            }

            function hideAddTransaction() {
                addTransactionDialog.classList.add('hidden');
            }

            addTransactionBtn.addEventListener('click', showAddTransaction);
            closeAddTransaction.addEventListener('click', hideAddTransaction);
            cancelAddTransaction.addEventListener('click', hideAddTransaction);

            submitTransaction.addEventListener('click', function() {
                // Handle transaction submission
                hideAddTransaction();
            });

            transactionType.addEventListener('change', function() {
                const selectedType = this.value;
                
                // Enable instrument type dropdown
                instrumentType.disabled = !selectedType;
                
                // Clear instrument type options
                instrumentType.innerHTML = '';
                
                // Show transaction-specific fields
                if (selectedType) {
                    transactionSpecificFields.classList.remove('hidden');
                    
                    // Hide all transaction fields first
                    allTransactionFields.forEach(field => {
                        field.classList.add('hidden');
                    });
                    
                    // Show fields specific to the selected transaction type
                    const specificField = document.getElementById(`${selectedType}-fields`);
                    if (specificField) {
                        specificField.classList.remove('hidden');
                    }
                    
                    // Populate instrument type options based on transaction type
                    const option = document.createElement('option');
                    option.value = '';
                    option.textContent = 'Select instrument type';
                    instrumentType.appendChild(option);
                    
                    // In a real app, you would populate this with actual options
                    if (selectedType === 'assignment') {
                        addInstrumentOption('deed-of-assignment', 'Deed of Assignment');
                        addInstrumentOption('deed-of-assent', 'Deed of Assent');
                    } else if (selectedType === 'mortgage') {
                        addInstrumentOption('deed-of-mortgage', 'Deed of Mortgage');
                        addInstrumentOption('tripartite-mortgage', 'Tripartite Mortgage');
                    }
                    // Add more conditions for other transaction types
                } else {
                    transactionSpecificFields.classList.add('hidden');
                    
                    // Add default option
                    const option = document.createElement('option');
                    option.value = '';
                    option.textContent = 'Select transaction first';
                    instrumentType.appendChild(option);
                }
            });

            function addInstrumentOption(value, text) {
                const option = document.createElement('option');
                option.value = value;
                option.textContent = text;
                instrumentType.appendChild(option);
            }

            // Capture CofO Dialog
            const captureCofoDialog = document.getElementById('capture-cofo-dialog');
            const captureCofoBtn = document.getElementById('capture-cofo-btn');
            const closeCaptureCofo = document.getElementById('close-capture-cofo');
            const cancelCaptureCofo = document.getElementById('cancel-capture-cofo');
            const saveCofo = document.getElementById('save-cofo');

            function showCaptureCofo() {
                captureCofoDialog.classList.remove('hidden');
            }

            function hideCaptureCofo() {
                captureCofoDialog.classList.add('hidden');
            }

            captureCofoBtn.addEventListener('click', showCaptureCofo);
            closeCaptureCofo.addEventListener('click', hideCaptureCofo);
            cancelCaptureCofo.addEventListener('click', hideCaptureCofo);

            saveCofo.addEventListener('click', function() {
                // Handle CofO submission
                hideCaptureCofo();
            });

            // File type buttons for all dialogs
            const fileTypeButtons = document.querySelectorAll('.file-type-btn, .cofo-file-type-btn');
            fileTypeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const parent = this.closest('.border-b');
                    const buttons = parent.querySelectorAll('.file-type-btn, .cofo-file-type-btn');
                    
                    buttons.forEach(btn => {
                        btn.classList.remove('border-blue-500', 'text-blue-600');
                        btn.classList.add('border-transparent', 'text-gray-500');
                    });
                    
                    this.classList.add('border-blue-500', 'text-blue-600');
                    this.classList.remove('border-transparent', 'text-gray-500');
                });
            });

            // Initialize the page with default values
            updateFileNoPreview();
            updateRegNoPreview();
        });
    </script>
    
@endsection
