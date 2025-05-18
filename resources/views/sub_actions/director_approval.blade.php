@extends('layouts.app')
@section('page-title')
    {{ __('Directors Approval') }}
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
    <div class="flex-1 overflow-auto">
        <!-- Header -->
        @include('admin.header')

        @php
            $is_view = request()->query('url') === 'view' ? 'none' : 'no';
        
            $statusClass = match (strtolower($application->application_status ?? '')) {
                'approve' => 'bg-green-100 text-green-800',
                'approved' => 'bg-green-100 text-green-800',
                'pending' => 'bg-yellow-100 text-yellow-800',
                'decline' => 'bg-red-100 text-red-800',
                'declined' => 'bg-red-100 text-red-800',
                default => 'bg-gray-100 text-gray-800',
            };

            $statusIcon = match (strtolower($application->application_status ?? '')) {
                'approve' => 'check-circle',
                'approved' => 'check-circle',
                'pending' => 'clock',
                'decline' => 'x-circle',
                'declined' => 'x-circle',
                default => 'help-circle',
            };
        @endphp
        <div class="p-6">

            <div class="bg-white rounded-md shadow-sm border border-gray-200 p-6">


                <div class="modal-content p-6">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h2 class="text-lg font-medium">
                                {{ $PageTitle }}
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $statusClass }}">
                                    <i data-lucide="{{ $statusIcon }}" class="w-3 h-3 mr-1"></i>
                                    {{ $application->application_status }}
                                </span>
                            </h2>
                            <p class="text-xs text-gray-500 mt-1">
                                Approval Date:
                                {{ $application->approval_date ? \Carbon\Carbon::parse($application->approval_date)->format('Y-m-d') : '' }}
                            </p>
                        </div>
                    </div>

                    <div class="py-2">
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-4">
                            <!-- Primary Application Info (First, as requested) -->
                            <div class="flex items-center mb-3">
                                <div class="bg-blue-100 text-blue-800 rounded-full p-1 mr-2">
                                    <i data-lucide="file-check" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-blue-800">Original Owner</h3>
                                    <p class="text-xs text-gray-700">

                                        @if ($application->primary_applicant_type == 'individual')
                                            {{ $application->applicant_title }} {{ $application->primary_first_name }}
                                            {{ $application->primary_surname }}
                                        @elseif($application->primary_applicant_type == 'corporate')
                                            {{ $application->primary_rc_number }}
                                            {{ $application->primary_corporate_name }}
                                        @elseif($application->primary_applicant_type == 'multiple')
                                            @php
                                                $names = @json_decode(
                                                    $application->primary_multiple_owners_names,
                                                    true,
                                                );
                                                if (is_array($names) && count($names) > 0) {
                                                    echo implode(', ', $names);
                                                } else {
                                                    echo $application->primary_multiple_owners_names;
                                                }
                                            @endphp
                                        @endif
 

                                        <span
                                            class="inline-flex items-center px-2 py-0.5 ml-1 rounded text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                            <i data-lucide="link" class="w-3 h-3 mr-1"></i>File No:
                                            {{ $application->primary_fileno ?? 'N/A' }}
                                        </span>
                                    </p>
                                </div>
                            </div>

                            <!-- Current Application Info -->
                            <div class="flex justify-between items-center border-t border-gray-200 pt-3">
                                <div>
                                    <h3 class="text-sm font-medium">{{ $application->land_use ?? 'Property' }}</h3>
                                    <p class="text-xs text-gray-600 mt-1">
                                        File No: <span class="font-medium">{{ $application->fileno ?? 'N/A' }}</span>
                                    </p>
                                </div>
                                <div class="text-right">
                                    <h3 class="text-sm font-medium">
                                        @if ($application->applicant_type == 'individual')
                                            {{ $application->applicant_title }} {{ $application->first_name }}
                                            {{ $application->surname }}
                                        @elseif($application->applicant_type == 'corporate')
                                            {{ $application->rc_number }} {{ $application->corporate_name }}
                                        @elseif($application->applicant_type == 'multiple')
                                            @php
                                                $names = @json_decode($application->multiple_owners_names, true);
                                                if (is_array($names) && count($names) > 0) {
                                                    echo implode(', ', $names);
                                                } else {
                                                    echo $application->multiple_owners_names;
                                                }
                                            @endphp
                                        @endif
                                    </h3>
                                    <p class="text-xs text-gray-600 mt-1">Applicant</p>
                                </div>
                            </div>
                        </div>

                        <!-- Tabs Navigation -->

                        <div style="display:{{ $is_view }}">

                            <div class="grid grid-cols-3 gap-2 mb-4">

                                

                                <button class="tab-button active" data-tab="detterment">
                                    <i data-lucide="calculator" class="w-3.5 h-3.5 mr-1.5"></i>
                                    DOCUMENTS
                                </button>

                                <button class="tab-button" data-tab="initial">
                                    <i data-lucide="banknote" class="w-3.5 h-3.5 mr-1.5"></i>
                                    APPROVAL
                                </button>
                                <button class="tab-button" data-tab="summary">
                                    <i data-lucide="user" class="w-3.5 h-3.5 mr-1.5"></i>
                                    SUMMARY
                                </button>
                                {{-- <button class="tab-button" data-tab="final">
                        <i data-lucide="file-check" class="w-3.5 h-3.5 mr-1.5"></i>
                        FINAL BILL
                      </button> --}}
                            </div>

                            <!-- Summary Tab -->
                            <div id="summary-tab" class="tab-content">
                                <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                                    <div class="p-4 border-b">
                                        <h3 class="text-sm font-medium">Application Summary</h3>
                                        <p class="text-xs text-gray-500">Unit application overview and details</p>
                                    </div>
                                    <div class="p-4 space-y-4">
                                        <!-- Original Owner Information -->
                                        <div class="mb-6">
                                            <h4 class="text-sm font-semibold text-gray-800 mb-3 pb-2 border-b">Original Owner Information</h4>
                                            <div class="bg-gray-50 p-4 rounded-lg mb-4">
                                                <div class="flex items-center">
                                                    <div class="mr-4">
                                                        @if(isset($application->primary_passport) && !empty($application->primary_passport))
                                                            <img src="{{ asset('storage/app/public/' . $application->primary_passport) }}"
                                                                alt="Primary Owner" class="w-16 h-16 object-cover rounded-full border border-gray-300">
                                                        @else
                                                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                                                                <i data-lucide="user" class="w-8 h-8 text-blue-500"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <p class="text-gray-900 font-medium">
                                                            @if($application->primary_applicant_type == 'individual')
                                                                {{ $application->primary_applicant_title ?? '' }} 
                                                                {{ $application->primary_first_name ?? '' }} 
                                                                {{ $application->primary_middle_name ?? '' }} 
                                                                {{ $application->primary_surname ?? '' }}
                                                            @elseif($application->primary_applicant_type == 'corporate')
                                                                {{ $application->primary_corporate_name ?? 'N/A' }}
                                                                <span class="text-sm text-gray-600">(RC: {{ $application->primary_rc_number ?? 'N/A' }})</span>
                                                            @elseif($application->primary_applicant_type == 'multiple')
                                                                @php
                                                                    $names = is_array($application->primary_multiple_owners_names) 
                                                                        ? $application->primary_multiple_owners_names 
                                                                        : (is_string($application->primary_multiple_owners_names) 
                                                                            ? json_decode($application->primary_multiple_owners_names, true) 
                                                                            : []);
                                                                    
                                                                    if (json_last_error() !== JSON_ERROR_NONE) {
                                                                        $names = [];
                                                                    }
                                                                @endphp
                                                                Multiple Owners
                                                            @endif
                                                        </p>
                                                        <p class="text-gray-600 text-sm">
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                                Original Owner
                                                            </span>
                                                            <span class="ml-2">File No: {{ $application->primary_fileno ?? 'N/A' }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Unit Owner Information -->
                                        <div class="mb-6">
                                            <h4 class="text-sm font-semibold text-gray-800 mb-3 pb-2 border-b">Unit Owner Information</h4>
                                            
                                            @if($application->applicant_type == 'individual')
                                                <!-- Individual Applicant -->
                                                <div class="bg-gray-50 p-4 rounded-lg mb-4">
                                                    <div class="flex items-center">
                                                        <div class="mr-4">
                                                            @if(isset($application->passport) && !empty($application->passport))
                                                                <img src="{{ asset('storage/app/public/' . $application->passport) }}"
                                                                    alt="Applicant" class="w-16 h-16 object-cover rounded-full border border-gray-300">
                                                            @else
                                                                <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center">
                                                                    <i data-lucide="user" class="w-8 h-8 text-gray-400"></i>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div>
                                                            <p class="text-gray-900 font-medium">
                                                                {{ $application->applicant_title ?? '' }}
                                                                {{ $application->first_name ?? '' }}
                                                                {{ $application->middle_name ?? '' }}
                                                                {{ $application->surname ?? '' }}
                                                            </p>
                                                            <p class="text-gray-600 text-sm">{{ $application->email ?? 'N/A' }}</p>
                                                            <p class="text-gray-600 text-sm">{{ $application->phone_number ?? 'N/A' }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @elseif($application->applicant_type == 'corporate')
                                                <!-- Corporate Applicant -->
                                                <div class="bg-gray-50 p-4 rounded-lg mb-4">
                                                    <div class="flex items-center">
                                                        <div class="mr-4">
                                                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                                                                <i data-lucide="building-2" class="w-8 h-8 text-blue-500"></i>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <p class="text-gray-900 font-medium">{{ $application->corporate_name ?? 'N/A' }}</p>
                                                            <p class="text-gray-600 text-sm">RC Number: {{ $application->rc_number ?? 'N/A' }}</p>
                                                            <p class="text-gray-600 text-sm">{{ $application->email ?? 'N/A' }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @elseif($application->applicant_type == 'multiple')
                                                <!-- Multiple Owners -->
                                                <div class="bg-gray-50 p-4 rounded-lg mb-4">
                                                    <h5 class="text-sm font-medium mb-3">Multiple Owners</h5>
                                                    <div class="space-y-2">
                                                        @php
                                                            $ownerNames = is_array($application->multiple_owners_names)
                                                                ? $application->multiple_owners_names
                                                                : (is_string($application->multiple_owners_names) 
                                                                    ? json_decode($application->multiple_owners_names, true) 
                                                                    : []);
                                                            
                                                            if (json_last_error() !== JSON_ERROR_NONE) {
                                                                $ownerNames = [];
                                                            }
                                                        @endphp
                                                        
                                                        @foreach(array_slice($ownerNames, 0, 3) as $index => $ownerName)
                                                            <div class="flex items-center">
                                                                <div class="mr-2 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-700 text-sm font-medium">
                                                                    {{ $index + 1 }}
                                                                </div>
                                                                <span>{{ $ownerName }}</span>
                                                            </div>
                                                        @endforeach
                                                        
                                                        @if(count($ownerNames) > 3)
                                                            <div class="pl-10 text-blue-600 text-sm">
                                                                + {{ count($ownerNames) - 3 }} more owners
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                            
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3">
                                                <div class="bg-gray-50 p-3 rounded-lg">
                                                    <p class="text-xs text-gray-600 font-medium">Address:</p>
                                                    <p class="text-sm">{{ $application->address ?? 'N/A' }}</p>
                                                </div>
                                                <div class="bg-gray-50 p-3 rounded-lg">
                                                    <p class="text-xs text-gray-600 font-medium">Contact:</p>
                                                    <p class="text-sm">
                                                        {{ $application->phone_number ?? 'N/A' }}
                                                        @if(isset($application->email) && !empty($application->email))
                                                            <br>{{ $application->email }}
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Unit Information -->
                                        <div class="mb-6">
                                            <h4 class="text-sm font-semibold text-gray-800 mb-3 pb-2 border-b">Unit Information</h4>
                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                                <div class="bg-gray-50 p-3 rounded-lg">
                                                    <p class="text-xs text-gray-600 font-medium">File Number:</p>
                                                    <p class="text-sm font-medium">{{ $application->fileno ?? 'N/A' }}</p>
                                                </div>
                                                <div class="bg-gray-50 p-3 rounded-lg">
                                                    <p class="text-xs text-gray-600 font-medium">Land Use:</p>
                                                    <p class="text-sm">{{ ucfirst($application->land_use ?? 'N/A') }}</p>
                                                </div>
                                                <div class="bg-gray-50 p-3 rounded-lg">
                                                    <p class="text-xs text-gray-600 font-medium">Scheme Number:</p>
                                                    <p class="text-sm">{{ $application->scheme_no ?? 'N/A' }}</p>
                                                </div>
                                            </div>
                                            
                                            <!-- Unit Specific Details -->
                                            <div class="p-3 bg-blue-50 border-l-4 border-blue-400 rounded-lg">
                                                <h5 class="text-sm font-medium text-blue-800 mb-2">Unit Details</h5>
                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                    <div>
                                                        <p class="text-xs text-gray-600 font-medium">Block Number:</p>
                                                        <p class="text-sm">{{ $application->block_number ?? 'N/A' }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="text-xs text-gray-600 font-medium">Floor Number:</p>
                                                        <p class="text-sm">{{ $application->floor_number ?? 'N/A' }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="text-xs text-gray-600 font-medium">Unit Number:</p>
                                                        <p class="text-sm">{{ $application->unit_number ?? 'N/A' }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Shared Areas Section -->
                                            @if(isset($application->shared_areas) && !empty($application->shared_areas))
                                                <div class="mt-3">
                                                    <p class="text-xs text-gray-600 font-medium mb-1">Shared Areas:</p>
                                                    <div class="flex flex-wrap gap-1">
                                                        @php
                                                            $sharedAreas = is_string($application->shared_areas) 
                                                                ? json_decode($application->shared_areas, true) 
                                                                : (is_array($application->shared_areas) ? $application->shared_areas : []);
                                                            
                                                            if (json_last_error() !== JSON_ERROR_NONE) {
                                                                $sharedAreas = [];
                                                            }
                                                        @endphp
                                                        
                                                        @foreach($sharedAreas as $area)
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                                {{ ucfirst($area) }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <!-- Application Status -->
                                        <div class="mb-6">
                                            <h4 class="text-sm font-semibold text-gray-800 mb-3 pb-2 border-b">Application Status</h4>
                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                <div class="bg-gray-50 p-3 rounded-lg">
                                                    <p class="text-xs text-gray-600 font-medium">Application Status:</p>
                                                    <p class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                        {{ $statusClass }}">
                                                        <i data-lucide="{{ $statusIcon }}" class="w-3 h-3 mr-1"></i>
                                                        {{ $application->application_status ?? 'Pending' }}
                                                    </p>
                                                </div>
                                                
                                                <div class="bg-gray-50 p-3 rounded-lg">
                                                    <p class="text-xs text-gray-600 font-medium">Planning Recommendation:</p>
                                                    <p class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                        {{ $application->planning_recommendation_status == 'Approved' ? 'bg-green-100 text-green-800' : 
                                                        ($application->planning_recommendation_status == 'Declined' || $application->planning_recommendation_status == 'Rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                                        {{ $application->planning_recommendation_status ?? 'Pending' }}
                                                    </p>
                                                </div>
                                                
                                                <div class="bg-gray-50 p-3 rounded-lg">
                                                    <p class="text-xs text-gray-600 font-medium">Approval Date:</p>
                                                    <p class="text-sm">{{ $application->approval_date ? \Carbon\Carbon::parse($application->approval_date)->format('Y-m-d') : 'Pending' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Financial Information -->
                                        <div>
                                            <h4 class="text-sm font-semibold text-gray-800 mb-3 pb-2 border-b">Financial Information</h4>
                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                <div class="bg-gray-50 p-3 rounded-lg">
                                                    <p class="text-xs text-gray-600 font-medium">Application Fee:</p>
                                                    <p class="text-sm">₦{{ number_format($application->application_fee ?? 0, 2) }}</p>
                                                </div>
                                                <div class="bg-gray-50 p-3 rounded-lg">
                                                    <p class="text-xs text-gray-600 font-medium">Processing Fee:</p>
                                                    <p class="text-sm">₦{{ number_format($application->processing_fee ?? 0, 2) }}</p>
                                                </div>
                                                <div class="bg-gray-50 p-3 rounded-lg">
                                                    <p class="text-xs text-gray-600 font-medium">Site Plan Fee:</p>
                                                    <p class="text-sm">₦{{ number_format($application->site_plan_fee ?? 0, 2) }}</p>
                                                </div>
                                            </div>
                                            
                                            <div class="mt-3 p-3 bg-green-50 rounded-lg">
                                                <div class="flex justify-between items-center">
                                                    <p class="text-sm font-medium text-gray-600">Total Initial Bill:</p>
                                                    <p class="text-lg font-bold text-green-700">
                                                        ₦{{ number_format(($application->application_fee ?? 0) + ($application->processing_fee ?? 0) + ($application->site_plan_fee ?? 0), 2) }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Action Buttons -->
                                        <div class="flex justify-between items-center pt-4 mt-6 border-t border-gray-200">
                                            <button type="button" onclick="window.history.back()" class="flex items-center px-3 py-1 text-xs border border-gray-300 rounded-md bg-white hover:bg-gray-50">
                                                <i data-lucide="undo-2" class="w-3.5 h-3.5 mr-1.5"></i>
                                                Back
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Survey Tab -->
                            <!-- Detterment Bill Tab -->
                             
                                <div id="detterment-tab" class="tab-content active">
                                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                                        <div class="p-4 border-b">
                                            <h3 class="text-sm font-medium">Documents</h3>
                                            <p class="text-xs text-gray-500"> </p>
                                        </div>
                                        <input type="hidden" id="application_id" value="{{ $application->id }}">
                                        <input type="hidden" name="fileno" value="{{ $application->fileno }}">
                                        <div class="p-4 space-y-4">
                                            <div class="grid grid-cols-2 gap-4">
                                                @php
                                                    // Ensure documents is decoded from JSON if needed
                                                    $documents = is_string($application->documents)
                                                        ? json_decode($application->documents, true)
                                                        : $application->documents;
                                                @endphp

                                                <!-- Application Letter -->
                                                @if (isset($documents['application_letter']))
                                                    <div
                                                        class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                                                        <div class="h-48 bg-gray-100 relative">
                                                            <img src="{{ asset('storage/app/public/' . $documents['application_letter']['path']) }}"
                                                                alt="Application Letter" class="w-full h-full object-cover">
                                                            <div class="absolute top-2 right-2">
                                                                <button
                                                                    class="p-1 bg-white rounded-full shadow-sm hover:bg-gray-100"
                                                                    onclick="previewDocument('{{ asset('storage/app/public/' . $documents['application_letter']['path']) }}', 'Application Letter')">
                                                                    <i data-lucide="maximize-2"
                                                                        class="w-4 h-4 text-gray-700"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="p-3">
                                                            <h5 class="text-sm font-medium">Application Letter</h5>
                                                            <p class="text-xs text-gray-500 mt-1">Uploaded on:
                                                                {{ isset($documents['application_letter']['uploaded_at']) ? \Carbon\Carbon::parse($documents['application_letter']['uploaded_at'])->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d') }}
                                                            </p>
                                                            <div class="flex mt-2 gap-2">
                                                                <a href="{{ asset('storage/app/public/' . $documents['application_letter']['path']) }}"
                                                                    download
                                                                    class="text-xs px-2 py-1 bg-blue-50 text-blue-600 rounded-md flex items-center">
                                                                    <i data-lucide="download" class="w-3 h-3 mr-1"></i>
                                                                    Download
                                                                </a>
                                                                <button
                                                                    class="text-xs px-2 py-1 bg-gray-50 text-gray-600 rounded-md flex items-center"
                                                                    onclick="previewDocument('{{ asset('storage/app/public/' . $documents['application_letter']['path']) }}', 'Application Letter')">
                                                                    <i data-lucide="eye" class="w-3 h-3 mr-1"></i> View
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div
                                                        class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden p-4 flex flex-col items-center justify-center">
                                                        <div class="text-gray-400 mb-2">
                                                            <i data-lucide="file-question" class="w-10 h-10"></i>
                                                        </div>
                                                        <p class="text-sm text-gray-500">No application letter uploaded yet
                                                        </p>
                                                    </div>
                                                @endif

                                                <!-- Building Plan -->
                                                @if (isset($documents['building_plan']))
                                                    <div
                                                        class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                                                        <div class="h-48 bg-gray-100 relative">
                                                            <img src="{{ asset('storage/app/public/' . $documents['building_plan']['path']) }}"
                                                                alt="Building Plan" class="w-full h-full object-cover">
                                                            <div class="absolute top-2 right-2">
                                                                <button
                                                                    class="p-1 bg-white rounded-full shadow-sm hover:bg-gray-100"
                                                                    onclick="previewDocument('{{ asset('storage/app/public/' . $documents['building_plan']['path']) }}', 'Building Plan')">
                                                                    <i data-lucide="maximize-2"
                                                                        class="w-4 h-4 text-gray-700"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="p-3">
                                                            <h5 class="text-sm font-medium">Building Plan</h5>
                                                            <p class="text-xs text-gray-500 mt-1">Uploaded on:
                                                                {{ isset($documents['building_plan']['uploaded_at']) ? \Carbon\Carbon::parse($documents['building_plan']['uploaded_at'])->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d') }}
                                                            </p>
                                                            <div class="flex mt-2 gap-2">
                                                                <a href="{{ asset('storage/app/public/' . $documents['building_plan']['path']) }}"
                                                                    download
                                                                    class="text-xs px-2 py-1 bg-blue-50 text-blue-600 rounded-md flex items-center">
                                                                    <i data-lucide="download" class="w-3 h-3 mr-1"></i>
                                                                    Download
                                                                </a>
                                                                <button
                                                                    class="text-xs px-2 py-1 bg-gray-50 text-gray-600 rounded-md flex items-center"
                                                                    onclick="previewDocument('{{ asset('storage/app/public/' . $documents['building_plan']['path']) }}', 'Building Plan')">
                                                                    <i data-lucide="eye" class="w-3 h-3 mr-1"></i> View
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div
                                                        class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden p-4 flex flex-col items-center justify-center">
                                                        <div class="text-gray-400 mb-2">
                                                            <i data-lucide="file-question" class="w-10 h-10"></i>
                                                        </div>
                                                        <p class="text-sm text-gray-500">No building plan uploaded yet</p>
                                                    </div>
                                                @endif

                                                <!-- Architectural Design -->
                                                @if (isset($documents['architectural_design']))
                                                    <div
                                                        class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                                                        <div class="h-48 bg-gray-100 relative">
                                                            <img src="{{ asset('storage/app/public/' . $documents['architectural_design']['path']) }}"
                                                                alt="Architectural Design"
                                                                class="w-full h-full object-cover">
                                                            <div class="absolute top-2 right-2">
                                                                <button
                                                                    class="p-1 bg-white rounded-full shadow-sm hover:bg-gray-100"
                                                                    onclick="previewDocument('{{ asset('storage/app/public/' . $documents['architectural_design']['path']) }}', 'Architectural Design')">
                                                                    <i data-lucide="maximize-2"
                                                                        class="w-4 h-4 text-gray-700"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="p-3">
                                                            <h5 class="text-sm font-medium">Architectural Design</h5>
                                                            <p class="text-xs text-gray-500 mt-1">Uploaded on:
                                                                {{ isset($documents['architectural_design']['uploaded_at']) ? \Carbon\Carbon::parse($documents['architectural_design']['uploaded_at'])->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d') }}
                                                            </p>
                                                            <div class="flex mt-2 gap-2">
                                                                <a href="{{ asset('storage/app/public/' . $documents['architectural_design']['path']) }}"
                                                                    download
                                                                    class="text-xs px-2 py-1 bg-blue-50 text-blue-600 rounded-md flex items-center">
                                                                    <i data-lucide="download" class="w-3 h-3 mr-1"></i>
                                                                    Download
                                                                </a>
                                                                <button
                                                                    class="text-xs px-2 py-1 bg-gray-50 text-gray-600 rounded-md flex items-center"
                                                                    onclick="previewDocument('{{ asset('storage/app/public/' . $documents['architectural_design']['path']) }}', 'Architectural Design')">
                                                                    <i data-lucide="eye" class="w-3 h-3 mr-1"></i> View
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div
                                                        class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden p-4 flex flex-col items-center justify-center">
                                                        <div class="text-gray-400 mb-2">
                                                            <i data-lucide="file-question" class="w-10 h-10"></i>
                                                        </div>
                                                        <p class="text-sm text-gray-500">No architectural design uploaded
                                                            yet</p>
                                                    </div>
                                                @endif

                                                <!-- Ownership Document -->
                                                @if (isset($documents['ownership_document']))
                                                    <div
                                                        class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                                                        <div class="h-48 bg-gray-100 relative">
                                                            <img src="{{ asset('storage/app/public/' . $documents['ownership_document']['path']) }}"
                                                                alt="Ownership Document"
                                                                class="w-full h-full object-cover">
                                                            <div class="absolute top-2 right-2">
                                                                <button
                                                                    class="p-1 bg-white rounded-full shadow-sm hover:bg-gray-100"
                                                                    onclick="previewDocument('{{ asset('storage/app/public/' . $documents['ownership_document']['path']) }}', 'Ownership Document')">
                                                                    <i data-lucide="maximize-2"
                                                                        class="w-4 h-4 text-gray-700"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="p-3">
                                                            <h5 class="text-sm font-medium">Ownership Document</h5>
                                                            <p class="text-xs text-gray-500 mt-1">Uploaded on:
                                                                {{ isset($documents['ownership_document']['uploaded_at']) ? \Carbon\Carbon::parse($documents['ownership_document']['uploaded_at'])->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d') }}
                                                            </p>
                                                            <div class="flex mt-2 gap-2">
                                                                <a href="{{ asset('storage/app/public/' . $documents['ownership_document']['path']) }}"
                                                                    download
                                                                    class="text-xs px-2 py-1 bg-blue-50 text-blue-600 rounded-md flex items-center">
                                                                    <i data-lucide="download" class="w-3 h-3 mr-1"></i>
                                                                    Download
                                                                </a>
                                                                <button
                                                                    class="text-xs px-2 py-1 bg-gray-50 text-gray-600 rounded-md flex items-center"
                                                                    onclick="previewDocument('{{ asset('storage/app/public/' . $documents['ownership_document']['path']) }}', 'Ownership Document')">
                                                                    <i data-lucide="eye" class="w-3 h-3 mr-1"></i> View
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div
                                                        class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden p-4 flex flex-col items-center justify-center">
                                                        <div class="text-gray-400 mb-2">
                                                            <i data-lucide="file-question" class="w-10 h-10"></i>
                                                        </div>
                                                        <p class="text-sm text-gray-500">No ownership document uploaded yet
                                                        </p>
                                                    </div>
                                                @endif
                                            </div>

                                            <hr class="my-4">

                                            <div class="flex justify-between items-center">
                                                <div class="flex gap-2">
                                                    <button type="button" onclick="window.history.back();"
                                                        class="flex items-center px-3 py-1 text-xs bg-white text-black p-2 border border-gray-500 rounded-md hover:bg-gray-800">
                                                        <i data-lucide="undo-2" class="w-3.5 h-3.5 mr-1.5"></i>
                                                        Back
                                                    </button>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div id="initial-tab" class="tab-content">
                                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                                        <div class="p-4 border-b">
                                            <h3 class="text-sm font-medium">Director's Approval</h3>
                                            <p class="text-xs text-gray-500"></p>
                                        </div>
                                        <form id="directorApprovalForm">
                                            <input type="hidden" name="application_id"
                                                id="directorApprovalApplicationId" value="">
                                            <!-- CSRF token for Laravel -->
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <div class="p-4 space-y-4">
                                                <input type="hidden" id="application_id"
                                                    value="{{ $application->id }}">

                                                <div class="mb-4">
                                                    <label class="block text-sm font-medium text-gray-700">Decision</label>
                                                    <div class="mt-2 flex items-center space-x-4">
                                                        <label class="inline-flex items-center">
                                                            <input type="radio" name="decision" value="approve"
                                                                class="form-radio" checked>
                                                            <span class="ml-2">Approve</span>
                                                        </label>
                                                        <label class="inline-flex items-center">
                                                            <input type="radio" name="decision" value="decline"
                                                                class="form-radio">
                                                            <span class="ml-2">Decline</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="grid grid-cols-2 gap-4 mb-4">
                                                    <div>
                                                        <label for="approval_date"
                                                            class="block text-gray-700 mb-2">Approval/Decline Date</label>
                                                        <input type="date" class="w-full border rounded px-3 py-2"
                                                            id="approval_date" name="approval_date" required>
                                                    </div>
                                                </div>
                                                <div id="reasonForDeclineContainer" class="mb-4 hidden">
                                                    <label for="reasonForDecline"
                                                        class="block text-sm font-medium text-gray-700">Reason For
                                                        Decline</label>
                                                    <textarea id="reasonForDecline" name="comments" rows="3"
                                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50"></textarea>
                                                </div>

                                                <hr class="my-4">
                                                <div class="flex justify-between items-center">

                                                    <div class="flex gap-2">
                                                        <button type="button" onclick="window.history.back();"
                                                            class="flex items-center px-3 py-1 text-xs bg-white text-black p-2 border border-gray-500 rounded-md hover:bg-gray-800">
                                                            <i data-lucide="undo-2" class="w-3.5 h-3.5 mr-1.5"></i>
                                                            Back
                                                        </button>
                                                        <button type="submit"
                                                            class="flex items-center px-3 py-1 text-xs bg-green-700 text-white rounded-md hover:bg-gray-800">
                                                            <i data-lucide="send-horizontal"
                                                                class="w-3.5 h-3.5 mr-1.5"></i>
                                                            Submit
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Final Bill Tab -->
                            <div id="final-tab" class="tab-content">
                                @include('actions.final_bill')
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                @include('admin.footer')
            </div>

            <script>
                // Initialize Lucide icons
                lucide.createIcons();

                // Document preview function
                function previewDesign(fileUrl) {
                    // Create modal overlay
                    const previewModal = document.createElement('div');
                    previewModal.className = 'fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50';

                    // Create content container
                    const contentContainer = document.createElement('div');
                    contentContainer.className = 'bg-white rounded-lg max-w-4xl max-h-[90vh] overflow-auto relative';

                    // Close button
                    const closeButton = document.createElement('button');
                    closeButton.className = 'absolute top-2 right-2 p-1 bg-white rounded-full shadow-sm hover:bg-gray-100';
                    closeButton.innerHTML = '<i data-lucide="x" class="w-5 h-5 text-gray-700"></i>';
                    closeButton.onclick = () => previewModal.remove();

                    // File preview (image)
                    const filePreview = document.createElement('img');
                    filePreview.src = fileUrl;
                    filePreview.className = 'w-full h-auto';
                    filePreview.style.maxHeight = '80vh';

                    // Append elements
                    contentContainer.appendChild(closeButton);
                    contentContainer.appendChild(filePreview);
                    previewModal.appendChild(contentContainer);
                    document.body.appendChild(previewModal);

                    // Initialize Lucide icons for the new elements
                    lucide.createIcons();
                }

                // Tab switching functionality
                document.addEventListener('DOMContentLoaded', function() {
                    const tabButtons = document.querySelectorAll('.tab-button');
                    const tabContents = document.querySelectorAll('.tab-content');

                    tabButtons.forEach(button => {
                        button.addEventListener('click', function() {
                            const tabId = this.getAttribute('data-tab');

                            // Deactivate all tabs
                            tabButtons.forEach(btn => btn.classList.remove('active'));
                            tabContents.forEach(content => content.classList.remove('active'));

                            // Activate selected tab
                            this.classList.add('active');
                            document.getElementById(`${tabId}-tab`).classList.add('active');
                        });
                    });

                    // Close modal button
                    document.getElementById('closeModal').addEventListener('click', function() {
                        // In a real application, this would close the modal
                        alert('Modal closed');
                    });
                });

                document.addEventListener('DOMContentLoaded', function() {
                    const decisionRadios = document.querySelectorAll('input[name="decision"]');
                    const reasonForDeclineContainer = document.getElementById('reasonForDeclineContainer');

                    decisionRadios.forEach(radio => {
                        radio.addEventListener('change', function() {
                            if (this.value === 'decline') {
                                reasonForDeclineContainer.classList.remove('hidden');
                            } else {
                                reasonForDeclineContainer.classList.add('hidden');
                            }
                        });
                    });
                });

                // Enhanced document preview function
                function previewDocument(fileUrl, documentTitle) {
                    // Create modal overlay
                    const previewModal = document.createElement('div');
                    previewModal.className = 'fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50';
                    previewModal.style.backdropFilter = 'blur(5px)';

                    // Create content container
                    const contentContainer = document.createElement('div');
                    contentContainer.className =
                    'bg-white rounded-lg w-11/12 md:w-4/5 lg:w-3/4 xl:w-2/3 max-h-[90vh] flex flex-col';

                    // Modal header
                    const modalHeader = document.createElement('div');
                    modalHeader.className = 'flex justify-between items-center p-4 border-b';

                    const modalTitle = document.createElement('h3');
                    modalTitle.className = 'text-lg font-medium';
                    modalTitle.textContent = documentTitle || 'Document Preview';

                    const closeButton = document.createElement('button');
                    closeButton.className = 'p-1 rounded-full hover:bg-gray-100 transition-colors';
                    closeButton.innerHTML = '<i data-lucide="x" class="w-5 h-5"></i>';
                    closeButton.onclick = () => previewModal.remove();

                    modalHeader.appendChild(modalTitle);
                    modalHeader.appendChild(closeButton);

                    // Modal body - Document viewer
                    const modalBody = document.createElement('div');
                    modalBody.className = 'flex-1 overflow-hidden relative';

                    const documentViewer = document.createElement('div');
                    documentViewer.className = 'w-full h-full flex items-center justify-center bg-gray-100 overflow-auto';
                    documentViewer.style.minHeight = '50vh';

                    // Check file type
                    const fileExtension = fileUrl.split('.').pop().toLowerCase();
                    const isPdf = fileExtension === 'pdf';

                    if (isPdf) {
                        const embedElement = document.createElement('embed');
                        embedElement.src = fileUrl;
                        embedElement.type = 'application/pdf';
                        embedElement.className = 'w-full h-full';
                        documentViewer.appendChild(embedElement);
                    } else {
                        // Assume it's an image
                        const imageElement = document.createElement('img');
                        imageElement.src = fileUrl;
                        imageElement.className = 'max-w-full max-h-full object-contain';
                        imageElement.style.maxHeight = '70vh';
                        documentViewer.appendChild(imageElement);
                    }

                    modalBody.appendChild(documentViewer);

                    // Modal footer
                    const modalFooter = document.createElement('div');
                    modalFooter.className = 'p-4 border-t flex justify-between';

                    const downloadButton = document.createElement('a');
                    downloadButton.href = fileUrl;
                    downloadButton.download = documentTitle || 'document';
                    downloadButton.className = 'px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 flex items-center';
                    downloadButton.innerHTML = '<i data-lucide="download" class="w-4 h-4 mr-2"></i> Download';

                    const closeTextButton = document.createElement('button');
                    closeTextButton.className = 'px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-100 flex items-center';
                    closeTextButton.innerHTML = '<i data-lucide="x" class="w-4 h-4 mr-2"></i> Close';
                    closeTextButton.onclick = () => previewModal.remove();

                    modalFooter.appendChild(downloadButton);
                    modalFooter.appendChild(closeTextButton);

                    // Assemble modal
                    contentContainer.appendChild(modalHeader);
                    contentContainer.appendChild(modalBody);
                    contentContainer.appendChild(modalFooter);
                    previewModal.appendChild(contentContainer);

                    // Add to document and initialize Lucide icons
                    document.body.appendChild(previewModal);
                    lucide.createIcons();

                    // Add keyboard event to close on Escape
                    document.addEventListener('keydown', function(e) {
                        if (e.key === 'Escape' && document.body.contains(previewModal)) {
                            previewModal.remove();
                        }
                    });
                }


                // Add form submission via AJAX
                const form = document.getElementById('directorApprovalForm');
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const applicationId = document.getElementById('application_id').value;
                    const decision = document.querySelector('input[name="decision"]:checked').value;
                    const approvalDate = document.getElementById('approval_date').value;
                    let comments = '';

                    if (decision === 'decline') {
                        comments = document.getElementById('reasonForDecline').value;
                    }

                    // Show preloader with SweetAlert
                    Swal.fire({
                        title: 'Processing...',
                        html: 'Submitting director\'s approval',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // AJAX request
                    fetch('{{ url('/sub-actions/director-approval/update') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                application_id: applicationId,
                                status: decision,
                                approval_date: approvalDate,
                                comments: comments
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Show success message
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: 'Director\'s approval updated successfully!'
                                }).then(() => {
                                    // Simply reload the page
                                    location.reload();
                                });
                            } else {
                                // Show error message
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: data.message || 'Failed to update approval'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'An error occurred while updating director\'s approval.'
                            });
                        });
                });
            </script>
        @endsection
