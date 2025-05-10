@extends('layouts.app')
@section('page-title')
    {{ __('SURVEY MODULE') }}
@endsection

 
@section('content')
    <!-- Main Content -->
    <div class="flex-1 overflow-auto">
        <!-- Header -->
        @include('admin.header')
        <!-- Dashboard Content -->
        <div class="p-6">
            <style>
                body {
                  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
                  color: #111827;
                  background-color: #f9fafb;
                }
                
                .card {
                  background-color: white;
                  border-radius: 0.5rem;
                  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                  padding: 1.25rem;
                }
                
                .search-input {
                  width: 100%;
                  padding: 0.5rem 1rem;
                  font-size: 0.875rem;
                  line-height: 1.25rem;
                  border: 1px solid #e5e7eb;
                  border-radius: 0.375rem;
                  background-color: white;
                }
                
                .search-icon {
                  position: absolute;
                  left: 0.75rem;
                  top: 50%;
                  transform: translateY(-50%);
                  color: #9ca3af;
                }
                
                .table-container {
                  background-color: white;
                  border-radius: 0.5rem;
                  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                  overflow: hidden;
                }
                
                table {
                  width: 100%;
                  border-collapse: collapse;
                }
                
                th {
                  text-align: left;
                  padding: 0.75rem 1rem;
                  font-size: 0.875rem;
                  font-weight: 500;
                  color: #4b5563;
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
                
                .btn {
                  display: inline-flex;
                  align-items: center;
                  justify-content: center;
                  padding: 0.5rem 1rem;
                  font-size: 0.875rem;
                  font-weight: 500;
                  border-radius: 0.375rem;
                  cursor: pointer;
                }
                
                .btn-primary {
                  background-color: #111827;
                  color: white;
                }
                
                .btn-outline {
                  border: 1px solid #e5e7eb;
                  background-color: white;
                  color: #4b5563;
                }
                
                .badge {
                  display: inline-flex;
                  align-items: center;
                  padding: 0.25rem 0.5rem;
                  font-size: 0.75rem;
                  font-weight: 500;
                  border-radius: 9999px;
                }
                
                .form-input {
                  width: 100%;
                  padding: 0.5rem 0.75rem;
                  font-size: 0.875rem;
                  line-height: 1.25rem;
                  border: 1px solid #e5e7eb;
                  border-radius: 0.375rem;
                  background-color: white;
                }
                
                .form-label {
                  display: block;
                  font-size: 0.875rem;
                  font-weight: 500;
                  margin-bottom: 0.5rem;
                }
                
                .form-section {
                  padding: 1.5rem;
                  border-bottom: 1px solid #e5e7eb;
                }
                
                .form-section-title {
                  font-size: 1.125rem;
                  font-weight: 600;
                  margin-bottom: 1rem;
                }
                
                .form-group {
                  margin-bottom: 1rem;
                }
                
                .form-hint {
                  font-size: 0.75rem;
                  color: #6b7280;
                  margin-top: 0.25rem;
                }
                
                .tab-active {
                  background-color: #f9fafb;
                  border-color: #111827;
                  color: #111827;
                }
              </style>
  <main class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
      <!-- Total Instruments -->
      <div class="card">
        <div class="flex justify-between items-start">
          <div>
            <p class="text-sm text-gray-500 mb-1">Total Instruments</p>
            <h2 class="text-3xl font-bold">1,284</h2>
            <p class="text-sm text-green-600 flex items-center mt-1">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
              </svg>
              12% increase
            </p>
          </div>
          <div class="h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
          </div>
        </div>
      </div>
      
      <!-- Verified -->
      <div class="card">
        <div class="flex justify-between items-start">
          <div>
            <p class="text-sm text-gray-500 mb-1">Verified</p>
            <h2 class="text-3xl font-bold">968</h2>
            <p class="text-sm text-gray-500 mt-1">75% of total</p>
          </div>
          <div class="h-10 w-10 bg-green-100 rounded-full flex items-center justify-center text-green-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
          </div>
        </div>
      </div>
      
      <!-- Pending -->
      <div class="card">
        <div class="flex justify-between items-start">
          <div>
            <p class="text-sm text-gray-500 mb-1">Pending</p>
            <h2 class="text-3xl font-bold">316</h2>
            <p class="text-sm text-gray-500 mt-1">25% of total</p>
          </div>
          <div class="h-10 w-10 bg-yellow-100 rounded-full flex items-center justify-center text-yellow-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
        </div>
      </div>
      
      <!-- This Month -->
      <div class="card">
        <div class="flex justify-between items-start">
          <div>
            <p class="text-sm text-gray-500 mb-1">This Month</p>
            <h2 class="text-3xl font-bold">87</h2>
            <p class="text-sm text-green-600 flex items-center mt-1">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
              </svg>
              8% increase
            </p>
          </div>
          <div class="h-10 w-10 bg-purple-100 rounded-full flex items-center justify-center text-purple-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Global Search -->
    <div class="relative">
      <div class="search-icon">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
      </div>
      <input type="text" placeholder="Search instruments..." class="search-input pl-10">
    </div>
    
    <!-- Instruments Table -->
    <div class="table-container">
      <div class="p-4 border-b border-gray-200">
        <div class="flex justify-between items-center">
          <h2 class="text-lg font-semibold">Instrument Capture</h2>
          <div class="flex items-center gap-2">
            <div class="relative">
              <div class="search-icon">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
              </div>
              <input type="text" placeholder="Search instruments..." class="search-input pl-10 w-64">
            </div>
            
            <div class="relative">
              <select class="search-input appearance-none pr-8">
                <option>10 per page</option>
                <option>25 per page</option>
                <option>50 per page</option>
                <option>100 per page</option>
              </select>
              <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </div>
            </div>
            
            <button class="btn btn-outline">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
              </svg>
              Export
            </button>
            
            <button class="btn btn-primary">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
              </svg>
              Capture New Instrument
            </button>
          </div>
        </div>
      </div>
      
      <table>
        <thead>
          <tr>
            <th>File No</th>
            <th>Grantor</th>
            <th>Grantee</th>
            <th>Transaction</th>
            <th>Entry Date</th>
            <th>Plot Description</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>RES-2020-1234</td>
            <td>Ali Musa</td>
            <td>Aisha Bala</td>
            <td>
              <span class="badge bg-blue-100 text-blue-800">Deed of Assignment</span>
            </td>
            <td>2024-01-16</td>
            <td>Plot 15, Kano GRA</td>
            <td>
              <button class="text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                </svg>
              </button>
            </td>
          </tr>
          <tr>
            <td>COM-2019-5678</td>
            <td>Kano Traders</td>
            <td>Umar Sani</td>
            <td>
              <span class="badge bg-green-100 text-green-800">Lease Agreement</span>
            </td>
            <td>2024-02-23</td>
            <td>Shop 22, Kwari Market</td>
            <td>
              <button class="text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                </svg>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
      
      <div class="p-4 border-t border-gray-200 flex justify-between items-center">
        <div class="text-sm text-gray-500">
          Showing 1 to 2 of 1,284 results
        </div>
        <div class="flex items-center gap-2">
          <button class="btn btn-outline px-3 py-1" disabled>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
          </button>
          <button class="btn btn-outline px-3 py-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
          </button>
        </div>
      </div>
    </div>
  </main>

  <!-- Instrument Type Selection Modal -->
  <div id="instrument-type-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl max-h-[90vh] overflow-y-auto">
      <div class="p-6">
        <div class="flex justify-between items-center mb-2">
          <h2 class="text-xl font-bold">Select Instrument Type</h2>
          <button id="close-modal-btn" class="text-gray-500 hover:text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        <p class="text-gray-500 mb-6">Choose the type of instrument you want to register from the options below.</p>
        
        <div class="space-y-4">
          <!-- Power of Attorney -->
          <div class="border rounded-lg p-4 hover:bg-gray-50 cursor-pointer instrument-option">
            <div class="flex items-start gap-4">
              <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
              </div>
              <div>
                <h3 class="font-medium">Power of Attorney</h3>
                <p class="text-sm text-gray-500">Legal authorization to act on someone else's behalf in specified matters</p>
              </div>
            </div>
          </div>
          
          <!-- Irrevocable Power of Attorney -->
          <div class="border rounded-lg p-4 hover:bg-gray-50 cursor-pointer instrument-option">
            <div class="flex items-start gap-4">
              <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
              </div>
              <div>
                <h3 class="font-medium">Irrevocable Power of Attorney</h3>
                <p class="text-sm text-gray-500">Power of attorney that cannot be revoked by the grantor until a specified condition is met</p>
              </div>
            </div>
          </div>
          
          <!-- Deed of Mortgage -->
          <div class="border rounded-lg p-4 hover:bg-gray-50 cursor-pointer instrument-option">
            <div class="flex items-start gap-4">
              <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
              </div>
              <div>
                <h3 class="font-medium">Deed of Mortgage</h3>
                <p class="text-sm text-gray-500">Legal document that pledges property as security for a loan between two parties</p>
              </div>
            </div>
          </div>
          
          <!-- Tripartite Mortgage -->
          <div class="border rounded-lg p-4 hover:bg-gray-50 cursor-pointer instrument-option">
            <div class="flex items-start gap-4">
              <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
              </div>
              <div>
                <h3 class="font-medium">Tripartite Mortgage</h3>
                <p class="text-sm text-gray-500">Mortgage agreement involving three parties: borrower, lender, and a third party</p>
              </div>
            </div>
          </div>
          
          <!-- Deed of Assignment -->
          <div class="border rounded-lg p-4 hover:bg-gray-50 cursor-pointer instrument-option">
            <div class="flex items-start gap-4">
              <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                </svg>
              </div>
              <div>
                <h3 class="font-medium">Deed of Assignment</h3>
                <p class="text-sm text-gray-500">Legal document that transfers ownership rights from one party to another</p>
              </div>
            </div>
          </div>
          
          <!-- Deed of Lease -->
          <div class="border rounded-lg p-4 hover:bg-gray-50 cursor-pointer instrument-option">
            <div class="flex items-start gap-4">
              <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div>
                <h3 class="font-medium">Deed of Lease</h3>
                <p class="text-sm text-gray-500">Legal document that grants a tenant exclusive possession of property for a fixed period</p>
              </div>
            </div>
          </div>
          
          <!-- Deed of Sub-under Lease -->
          <div class="border rounded-lg p-4 hover:bg-gray-50 cursor-pointer instrument-option">
            <div class="flex items-start gap-4">
              <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
              </div>
              <div>
                <h3 class="font-medium">Deed of Sub-under Lease</h3>
                <p class="text-sm text-gray-500">Legal document for leasing property that is already subject to a sub-lease</p>
              </div>
            </div>
          </div>
          
          <!-- Deed of Sub-division -->
          <div class="border rounded-lg p-4 hover:bg-gray-50 cursor-pointer instrument-option">
            <div class="flex items-start gap-4">
              <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
        </svg>
      </div>
      <div>
        <h3 class="font-medium">Deed of Sub-division</h3>
        <p class="text-sm text-gray-500">Legal document that divides a single property into multiple separate properties</p>
      </div>
    </div>
  </div>
  
  <!-- Deed of Merger -->
  <div class="border rounded-lg p-4 hover:bg-gray-50 cursor-pointer instrument-option">
    <div class="flex items-start gap-4">
      <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
        </svg>
      </div>
      <div>
        <h3 class="font-medium">Deed of Merger</h3>
        <p class="text-sm text-gray-500">Legal document that combines multiple properties into a single property</p>
      </div>
    </div>
  </div>
  
  <!-- Deed of Surrender -->
  <div class="border rounded-lg p-4 hover:bg-gray-50 cursor-pointer instrument-option">
    <div class="flex items-start gap-4">
      <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
        </svg>
      </div>
      <div>
        <h3 class="font-medium">Deed of Surrender</h3>
        <p class="text-sm text-gray-500">Legal document where a tenant gives up their lease before the end of the term</p>
      </div>
    </div>
  </div>
  
  <!-- Deed of Assent -->
  <div class="border rounded-lg p-4 hover:bg-gray-50 cursor-pointer instrument-option">
    <div class="flex items-start gap-4">
      <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
      </div>
      <div>
        <h3 class="font-medium">Deed of Assent</h3>
        <p class="text-sm text-gray-500">Legal document that transfers property from a deceased person's estate to beneficiaries</p>
      </div>
    </div>
  </div>
  
  <!-- Deed of Release -->
  <div class="border rounded-lg p-4 hover:bg-gray-50 cursor-pointer instrument-option">
    <div class="flex items-start gap-4">
      <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
        </svg>
      </div>
      <div>
        <h3 class="font-medium">Deed of Release</h3>
        <p class="text-sm text-gray-500">Legal document that releases a party from obligations or claims</p>
      </div>
    </div>
  </div>
</div>
        
        <div class="flex justify-end mt-6 gap-2">
          <button id="cancel-btn" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
            Cancel
          </button>
          <button id="continue-btn" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-500 hover:bg-gray-600" disabled>
            Continue
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Power of Attorney Registration Form Modal -->
  <div id="poa-form-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
  <div class="bg-white rounded-lg shadow-lg w-full max-w-4xl max-h-[90vh] overflow-y-auto">
    <div class="p-6">
      <div class="flex justify-between items-center mb-2">
        <div>
          <h2 class="text-xl font-bold">Register Power of Attorney</h2>
          <p class="text-gray-500">Enter the details for the new instrument</p>
        </div>
        <button id="close-poa-form-btn" class="text-gray-500 hover:text-gray-700">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
      
      <form id="poa-form" class="space-y-6 mt-6">
        <!-- File Number Section -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
          <div class="p-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold">File Number</h3>
          </div>
          <div class="p-4">
            <div class="mb-4">
              <label class="inline-flex items-center">
                <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600">
                <span class="ml-2 text-sm">This application has no Extant File Number (Use Temporary File Number)</span>
              </label>
            </div>
            
            <div class="bg-green-50 border border-green-100 rounded-lg p-4 mb-4">
              <div class="flex items-center gap-2 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h4 class="font-medium">File Number Information</h4>
              </div>
              <p class="text-sm text-gray-600 mb-4">Select file number type and enter the details</p>
              
              <div class="grid grid-cols-3 gap-4 mb-4">
                <div class="bg-white border border-gray-200 rounded-md p-2 text-center cursor-pointer tab-active">
                  MLS
                </div>
                <div class="bg-white border border-gray-200 rounded-md p-2 text-center cursor-pointer">
                  KANGIS
                </div>
                <div class="bg-white border border-gray-200 rounded-md p-2 text-center cursor-pointer">
                  New KANGIS
                </div>
              </div>
              
              <div class="mb-4">
                <label class="form-label">Legacy File Number (MLS)</label>
              </div>
              
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="form-label">File Prefix</label>
                  <div class="relative">
                    <select class="form-input appearance-none pr-8">
                      <option>Select prefix</option>
                      <option>COM</option>
                      <option>RES</option>
                      <option>IND</option>
                    </select>
                    <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                      </svg>
                    </div>
                  </div>
                </div>
                <div>
                  <label class="form-label">Serial Number</label>
                  <input type="text" class="form-input" placeholder="e.g. 2019-296 or 91-249">
                </div>
              </div>
              <p class="text-xs text-gray-500 mt-2">Format example: COM-COM-2019-296, RES-2015-4859, COM-91-249</p>
            </div>
          </div>
        </div>
        
        <!-- Registration Details Section -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
          <div class="p-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold">Registration Details</h3>
          </div>
          <div class="p-4">
            <div class="mb-4">
              <label class="form-label">Registration Number (ROOT TITLE)</label>
              <input type="text" class="form-input bg-gray-100" value="0/0/0" readonly>
              <p class="text-xs text-gray-500 mt-1">Customary Titles are registered as ROOT TITLES with Registration Number 0/0/0 by default.</p>
            </div>
            
            <div class="mb-4">
              <label class="form-label">Root Registration Number</label>
              <input type="text" class="form-input" placeholder="Enter root registration number">
            </div>
          </div>
        </div>
        
        <!-- Grantor Information Section -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
          <div class="p-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold">Grantor Information</h3>
          </div>
          <div class="p-4">
            <div class="mb-4">
              <label class="form-label">Grantor Name</label>
              <input type="text" class="form-input" placeholder="Enter grantor's full name">
            </div>
            
            <div class="mb-4">
              <h4 class="text-md font-medium mb-2">Grantor Address</h4>
              <div class="space-y-4">
                <div>
                  <label class="form-label">Street Address</label>
                  <input type="text" class="form-input" placeholder="Enter street address">
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label class="form-label">City</label>
                    <input type="text" class="form-input" placeholder="Enter city">
                  </div>
                  <div>
                    <label class="form-label">State</label>
                    <input type="text" class="form-input" placeholder="Enter state">
                  </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label class="form-label">Postal Code</label>
                    <input type="text" class="form-input" placeholder="Enter postal code">
                  </div>
                  <div>
                    <label class="form-label">Country</label>
                    <input type="text" class="form-input" placeholder="Enter country">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Grantee Information Section -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
          <div class="p-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold">Grantee Information</h3>
          </div>
          <div class="p-4">
            <div class="mb-4">
              <label class="form-label">Grantee Name</label>
              <input type="text" class="form-input" placeholder="Enter grantee's full name">
            </div>
            
            <div class="mb-4">
              <h4 class="text-md font-medium mb-2">Grantee Address</h4>
              <div class="space-y-4">
                <div>
                  <label class="form-label">Street Address</label>
                  <input type="text" class="form-input" placeholder="Enter street address">
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label class="form-label">City</label>
                    <input type="text" class="form-input" placeholder="Enter city">
                  </div>
                  <div>
                    <label class="form-label">State</label>
                    <input type="text" class="form-input" placeholder="Enter state">
                  </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label class="form-label">Postal Code</label>
                    <input type="text" class="form-input" placeholder="Enter postal code">
                  </div>
                  <div>
                    <label class="form-label">Country</label>
                    <input type="text" class="form-input" placeholder="Enter country">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Solicitor Information Section -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
          <div class="p-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold">Solicitor Information</h3>
          </div>
          <div class="p-4">
            <div class="mb-4">
              <label class="form-label">Solicitor Name</label>
              <input type="text" class="form-input" placeholder="Enter solicitor's full name">
            </div>
            
            <div class="mb-4">
              <label class="form-label">Solicitor Address</label>
              <textarea class="form-input" rows="3" placeholder="Enter solicitor's complete address"></textarea>
            </div>
          </div>
        </div>
        
        <!-- Property Details Section -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
          <div class="p-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold">Property Details</h3>
          </div>
          <div class="p-4">
            <div class="mb-4">
              <label class="form-label">Plot Description</label>
              <textarea class="form-input" rows="3" placeholder="Enter plot description"></textarea>
            </div>
            
            <div class="mb-4">
              <label class="form-label">Plot Size</label>
              <input type="text" class="form-input" placeholder="Enter plot size (e.g., 100 × 50 meters)">
            </div>
            
            <div class="mb-4">
              <label class="inline-flex items-center">
                <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600">
                <span class="ml-2 text-sm">Include Survey Information</span>
              </label>
            </div>
          </div>
        </div>
        
        <!-- Additional Details Section -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
          <div class="p-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold">Additional Details</h3>
          </div>
          <div class="p-4">
            <div class="mb-4">
              <label class="form-label">Duration</label>
              <input type="text" class="form-input" placeholder="Enter duration (e.g., 5 years)">
            </div>
          </div>
        </div>
        
        <!-- Registration Dates Section -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
          <div class="p-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold">Registration Dates</h3>
          </div>
          <div class="p-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="form-label">Registration Date</label>
                <div class="relative">
                  <input type="text" class="form-input" value="May 7th, 2025" readonly>
                  <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                  </div>
                </div>
              </div>
              <div>
                <label class="form-label">Entry Date</label>
                <div class="relative">
                  <input type="text" class="form-input" value="May 7th, 2025" readonly>
                  <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Form Actions -->
        <div class="flex justify-end gap-2">
          <button type="button" id="cancel-form-btn" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
            Cancel
          </button>
          <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-black hover:bg-black/90">
            Submit
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

  <!-- JavaScript -->
  <script>
    // DOM Elements
    const searchInputs = document.querySelectorAll('input[placeholder="Search instruments..."]');
    const captureNewBtn = document.querySelector('.btn-primary');
    const exportBtn = document.querySelector('.btn-outline');
    const actionBtns = document.querySelectorAll('td button');
    const paginationBtns = document.querySelectorAll('.p-4.border-t button');

    // Modal Elements
    const instrumentTypeModal = document.getElementById('instrument-type-modal');
    const closeModalBtn = document.getElementById('close-modal-btn');
    const cancelBtn = document.getElementById('cancel-btn');
    const continueBtn = document.getElementById('continue-btn');
    const instrumentOptions = document.querySelectorAll('.instrument-option');
    
    // Power of Attorney Form Modal Elements
    const poaFormModal = document.getElementById('poa-form-modal');
    const closePoaFormBtn = document.getElementById('close-poa-form-btn');
    const cancelFormBtn = document.getElementById('cancel-form-btn');
    const poaForm = document.getElementById('poa-form');

    // State variables
    let selectedInstrumentType = null;

    // Event Listeners
    searchInputs.forEach(input => {
      input.addEventListener('input', (e) => {
        console.log('Searching for:', e.target.value);
        // In a real app, you would filter the table based on the search term
      });
    });

    captureNewBtn.addEventListener('click', () => {
      console.log('Capture New Instrument clicked');
      // Show the instrument type selection modal
      instrumentTypeModal.classList.remove('hidden');
    });

    exportBtn.addEventListener('click', () => {
      console.log('Export clicked');
      // In a real app, you would export the data to CSV or Excel
    });

    actionBtns.forEach(btn => {
      btn.addEventListener('click', (e) => {
        const row = e.target.closest('tr');
        const fileNo = row.querySelector('td').textContent;
        console.log('Actions for:', fileNo);
        // In a real app, you would show a dropdown menu with actions
      });
    });

    paginationBtns.forEach(btn => {
      btn.addEventListener('click', (e) => {
        if (!btn.disabled) {
          console.log('Pagination clicked');
          // In a real app, you would navigate to the next/previous page
        }
      });
    });

    // Modal Event Listeners
    closeModalBtn.addEventListener('click', () => {
      instrumentTypeModal.classList.add('hidden');
      resetModalSelection();
    });

    cancelBtn.addEventListener('click', () => {
      instrumentTypeModal.classList.add('hidden');
      resetModalSelection();
    });

    // Close modal when clicking outside
    instrumentTypeModal.addEventListener('click', (e) => {
      if (e.target === instrumentTypeModal) {
        instrumentTypeModal.classList.add('hidden');
        resetModalSelection();
      }
    });

    // Handle instrument type selection
    instrumentOptions.forEach(option => {
      option.addEventListener('click', () => {
        // Remove selected class from all options
        instrumentOptions.forEach(opt => {
          opt.classList.remove('bg-blue-50', 'border-blue-300');
        });
        
        // Add selected class to clicked option
        option.classList.add('bg-blue-50', 'border-blue-300');
        
        // Get the instrument type
        const instrumentType = option.querySelector('h3').textContent;
        selectedInstrumentType = instrumentType;
        
        // Enable the continue button
        continueBtn.classList.remove('bg-gray-500', 'hover:bg-gray-600');
        continueBtn.classList.add('bg-black', 'hover:bg-black/90');
        continueBtn.disabled = false;
      });
    });

    // Handle continue button click
    continueBtn.addEventListener('click', () => {
      if (selectedInstrumentType) {
        console.log('Selected instrument type:', selectedInstrumentType);
        instrumentTypeModal.classList.add('hidden');
        
        // If Power of Attorney or Irrevocable Power of Attorney is selected, show the Power of Attorney form
        if (selectedInstrumentType === 'Power of Attorney' || selectedInstrumentType === 'Irrevocable Power of Attorney') {
          poaFormModal.classList.remove('hidden');
          
          // Update the form title based on the selected instrument type
          const formTitle = document.querySelector('#poa-form-modal h2');
          formTitle.textContent = `Register ${selectedInstrumentType}`;
        } else {
          // For other instrument types, show an alert (in a real app, you would show the appropriate form)
          alert(`You selected: ${selectedInstrumentType}. In a real app, this would proceed to the instrument details form.`);
        }
        
        resetModalSelection();
      }
    });

    // Power of Attorney Form Event Listeners
    closePoaFormBtn.addEventListener('click', () => {
      poaFormModal.classList.add('hidden');
    });

    cancelFormBtn.addEventListener('click', () => {
      poaFormModal.classList.add('hidden');
    });

    // Close form modal when clicking outside
    poaFormModal.addEventListener('click', (e) => {
      if (e.target === poaFormModal) {
        poaFormModal.classList.add('hidden');
      }
    });

    // Handle form submission
    poaForm.addEventListener('submit', (e) => {
      e.preventDefault();
      alert('Power of Attorney registration submitted successfully!');
      poaFormModal.classList.add('hidden');
    });

    // Reset modal selection
    function resetModalSelection() {
      selectedInstrumentType = null;
      instrumentOptions.forEach(opt => {
        opt.classList.remove('bg-blue-50', 'border-blue-300');
      });
      continueBtn.classList.remove('bg-black', 'hover:bg-black/90');
      continueBtn.classList.add('bg-gray-500', 'hover:bg-gray-600');
      continueBtn.disabled = true;
    }
  </script>
        </div>

        <!-- Footer -->
        @include('admin.footer')
    </div>
   
 
    
@endsection
