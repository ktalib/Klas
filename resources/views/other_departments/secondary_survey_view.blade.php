@extends('layouts.app')
@section('page-title')
   {{$PageTitle}}
@endsection

<style>

   
    .tab-content {
      display: none;
    }
    .tab-content.active {
      display: block;
    }
    .tab-button {
      position: relative;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 0.75rem;
      padding: 0.5rem 1rem;
      border-radius: 0.25rem;
      cursor: pointer;
      transition: background-color 0.2s;
    }
    .tab-button.active {
      background-color: #f3f4f6;
      font-weight: 500;
    }
    .tab-button:hover:not(.active) {
      background-color: #f9fafb;
    }
  </style>
@include('sectionaltitling.partials.assets.css')
@section('content')
   @php
    use Illuminate\Support\Facades\DB;
    $deeds = DB::connection('sqlsrv')->table('landAdministration')->where('application_id', $application->id)->first();  
     @endphp
    <div class="flex-1 overflow-auto">
        <!-- Header -->
        @include('admin.header')
        <!-- Dashboard Content -->
        <div class="p-6">
           
          
            <div class="bg-white rounded-md shadow-sm border border-gray-200 p-6">
              

                <div class="modal-content p-6">
                    <div class="flex justify-between items-center mb-4">
                      <h2 class="text-lg font-medium">ST Survey </h2>
                      <button  type="button"  class="text-gray-500 hover:text-gray-700" onclick="window.history.back()">
                        <i data-lucide="x" class="w-5 h-5"></i>
                      </button>
                    </div>
                    
                    <div class="py-2">
              
                    <div class="py-2">
                      <div class="bg-green-900 border border-gray-200 rounded-lg p-4 mb-4">
                        <!-- Primary Application Info (First, as requested) -->
                        <div class="flex items-center mb-3">
                          <div class="bg-blue-100 text-blue-800 rounded-full p-1 mr-2">
                            <i data-lucide="file-check" class="w-4 h-4"></i>
                          </div>
                          <div>
                            <h3 class="text-sm font-medium text-white">Oringal Owner</h3>
                            <p class="text-xs text-white">
                              {{ $application->primary_applicant_title ?? '' }} {{ $application->primary_first_name ?? '' }} {{ $application->primary_surname ?? '' }}
                              <span class="inline-flex items-center px-2 py-0.5 ml-1 rounded text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                <i data-lucide="link" class="w-3 h-3 mr-1"></i>File No: {{ $application->primary_fileno ?? 'N/A' }}
                              </span>
                            </p>
                          </div>
                        </div>
                        
                        <!-- Current Application Info -->
                        <div class="flex justify-between items-center border-t border-gray-200 pt-3">
                          <div>
                            <h3 class="text-sm  text-white font-medium">{{ $application->land_use ?? 'Property' }}</h3>
                            <p class="text-xs text-white mt-1">
                              File No: <span class="font-medium">{{ $application->fileno ?? 'N/A' }}</span>
                            </p>
                          </div>
                          <div class="text-right">
                            <h3 class="text-sm  text-white font-medium">{{ $application->applicant_title ?? '' }} {{ $application->surname ?? '' }} {{ $application->first_name ?? '' }}</h3>
                            <p class="text-xs text-white mt-1">Applicant</p>
                          </div>
                        </div>
                      </div>
                
                      <!-- Tabs Navigation -->
                      
                      @php
                        // Determine which tab should be active based on URL parameters
                        $activeTab = 'initial'; // Default to Survey tab
                        
                        if(request()->has('deeds')) {
                            $activeTab = 'detterment';
                        } elseif(request()->has('lands')) {
                            $activeTab = 'final';
                        } elseif(request()->has('survey')) {
                            $activeTab = 'initial';
                        }
                      @endphp

            
                      <!-- Survey Tab -->
                      @include('other_departments.partials.sec_survey')
                      <!-- Deeds Tab -->
                    </div>
                  </div>

                <!-- Footer -->
                @include('admin.footer')
            </div>
            
          
          @include('other_departments.partials.js')
    
        @endsection



        