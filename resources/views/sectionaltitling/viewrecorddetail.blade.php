@extends('layouts.app')
@section('page-title')
{{ __('SECTIONAL TITLING  MODULE') }}
@endsection


@include('sectionaltitling.partials.assets.css')
@section('content')
<!-- Main Content -->
<div class="flex-1 overflow-auto">
<!-- Header -->
@include('admin.header')
<!-- Dashboard Content -->
<div class="p-6">
<!-- Stats Cards -->



<!-- Primary Applications Overview - Screenshot 129 -->

<!-- Primary Applications Table -->
<div class="bg-white rounded-md shadow-sm border border-gray-200 p-6">
<div class="container mx-auto mt-4 p-4">
<div class="card shadow-lg border-0">
<div class="card-header bg-gray-50 border-b border-gray-200 py-3 px-4">
<div class="flex justify-between items-center">
    <h2 class="text-xl font-bold text-gray-800">Record Details</h2>
    <div class="flex items-center gap-2">
        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
            Application Status {{ $application->application_status ?? 'Pending' }}
        </span>
        <span
            class="bg-{{ $application->planning_recommendation_status == 'Approved' ? 'green' : ($application->planning_recommendation_status == 'Rejected' ? 'red' : 'yellow') }}-100 
                text-{{ $application->planning_recommendation_status == 'Approved' ? 'green' : ($application->planning_recommendation_status == 'Rejected' ? 'red' : 'yellow') }}-800 
                text-xs font-medium px-2.5 py-0.5 rounded-full">
            Planning Recommendation:
            {{ $application->planning_recommendation_status ?? 'Pending' }}
        </span>
    </div>
</div>
</div>
<div class="card-body p-0">
<div class="bg-white p-6">
    <!-- File Info and Status -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="col-span-2">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <strong class="block font-medium text-gray-700 mb-1">File Number:</strong>
                    <span
                        class="text-gray-900 text-lg">{{ $application->fileno ?? 'N/A' }}</span>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <strong class="block font-medium text-gray-700 mb-1">Application
                        Type:</strong>
                    <span
                        class="text-gray-900 text-lg">{{ ucfirst($application->applicant_type ?? 'N/A') }}</span>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <strong class="block font-medium text-gray-700 mb-1">Application
                        Date:</strong>
                    <span
                        class="text-gray-900">{{ $application->created_at ? date('d M Y', strtotime($application->created_at)) : 'N/A' }}</span>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <strong class="block font-medium text-gray-700 mb-1">Approval Date:</strong>
                    <span
                        class="text-gray-900">{{ $application->approval_date ? date('d M Y', strtotime($application->approval_date)) : 'Pending' }}</span>
                </div>
            </div>
        </div>
        <div class="flex justify-center items-center">
            <!-- Passport Photo Section -->
            <div class="text-center">
                <div
                    class="mb-2 border border-gray-300 rounded-lg overflow-hidden inline-block">
                    @if (isset($application->passport) && !empty($application->passport))
                        <img src="{{ asset('storage/app/public/' . $application->passport) }}"
                            alt="Applicant Photo" class="w-36 h-36 object-cover">
                    @else
                        <div class="w-36 h-36 bg-gray-200 flex items-center justify-center">
                            <span class="text-gray-500 text-sm">No Photo Available</span>
                        </div>
                    @endif
                </div>
                <p class="text-sm text-gray-600">Applicant Photo</p>
            </div>
        </div>
    </div>

    <!-- Applicant Information -->
    <div class="mb-8">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">Applicant Information
        </h3>

        @if ($application->applicant_type == 'individual')
            <!-- Individual Applicant(s) -->
            <div class="bg-gray-50 p-4 rounded-lg mb-4">
                <strong class="block font-medium text-gray-700 mb-2">Primary Applicant:</strong>
                <div class="flex items-center">
                    <div class="mr-4">
                        @if (isset($application->passport) && !empty($application->passport))
                            <img src="{{ asset('storage/app/public/' . $application->passport) }}"
                                alt="Primary Applicant"
                                class="w-16 h-16 object-cover rounded-full border border-gray-300">
                        @else
                            <div
                                class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center">
                                <span class="text-gray-500 text-xs">No Photo</span>
                            </div>
                        @endif
                    </div>
                    <div>
                        <p class="text-gray-900 font-medium">
                            {{ $application->applicant_title ?? '' }}
                            {{ $application->first_name ?? '' }}
                            {{ $application->middle_name ?? '' }}
                            {{ $application->surname ?? '' }}</p>
                        <p class="text-gray-600 text-sm">{{ $application->email ?? 'N/A' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Co-Applicants (if any) -->
            @if (isset($application->co_applicants) && !empty($application->co_applicants))
                <strong class="block font-medium text-gray-700 mb-2">Co-Applicants:</strong>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($application->co_applicants as $co_applicant)
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex items-center">
                                <div class="mr-4">
                                    @if (isset($co_applicant->passport_photo) && !empty($co_applicant->passport_photo))
                                        <img src="{{ asset('storage/' . $co_applicant->passport_photo) }}"
                                            alt="Co-Applicant"
                                            class="w-12 h-12 object-cover rounded-full border border-gray-300">
                                    @else
                                        <div
                                            class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                                            <span class="text-gray-500 text-xs">No Photo</span>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-gray-900">{{ $co_applicant->title ?? '' }}
                                        {{ $co_applicant->name ?? 'N/A' }}</p>
                                    <p class="text-gray-600 text-sm">
                                        {{ $co_applicant->email ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @elseif($application->applicant_type == 'corporate')
            <!-- Corporate Applicant -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <strong class="block font-medium text-gray-700 mb-1">Corporate
                        Name:</strong>
                    <span
                        class="text-gray-900">{{ $application->corporate_name ?? 'N/A' }}</span>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <strong class="block font-medium text-gray-700 mb-1">RC Number:</strong>
                    <span class="text-gray-900">{{ $application->rc_number ?? 'N/A' }}</span>
                </div>
            </div>

            <!-- Corporate Representatives (if any) -->
            @if (isset($application->representatives) && !empty($application->representatives))
                <div class="mt-4">
                    <strong class="block font-medium text-gray-700 mb-2">Corporate
                        Representatives:</strong>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($application->representatives as $rep)
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex items-center">
                                    <div class="mr-4">
                                        @if (isset($rep->passport_photo) && !empty($rep->passport_photo))
                                            <img src="{{ asset('storage/' . $rep->passport_photo) }}"
                                                alt="Representative"
                                                class="w-12 h-12 object-cover rounded-full border border-gray-300">
                                        @else
                                            <div
                                                class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                                                <span class="text-gray-500 text-xs">No
                                                    Photo</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-gray-900">{{ $rep->name ?? 'N/A' }}</p>
                                        <p class="text-gray-600 text-sm">
                                            {{ $rep->position ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif

        <div class="mt-4 bg-gray-50 p-4 rounded-lg">
            <strong class="block font-medium text-gray-700 mb-1">Contact Information:</strong>
            <div class="text-gray-900">
                <div>{{ $application->address ?? 'N/A' }}</div>
                <div>
                    Phone:
                    @if (isset($application->phone_number))
                        @php
                            $phoneNumbers = explode(',', $application->phone_number);
                        @endphp
                        @if (count($phoneNumbers) > 1)
                            @foreach ($phoneNumbers as $phoneNumber)
                                {{ trim($phoneNumber) }}@if (!$loop->last)
                                    ,
                                @endif
                            @endforeach
                        @else
                            {{ $application->phone_number ?? 'N/A' }}
                        @endif
                    @else
                        N/A
                    @endif
                </div>
                <div>Email: {{ $application->email ?? 'N/A' }}</div>
            </div>
        </div>

        <!-- Multiple Owners Section -->
        @if (isset($application->multiple_owners_names) && !empty($application->multiple_owners_names))
            <div class="mt-4">
                <strong class="block font-medium text-gray-700 mb-2">Multiple Owners:</strong>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @php
                        $ownerNames = is_array($application->multiple_owners_names)
                            ? $application->multiple_owners_names
                            : json_decode($application->multiple_owners_names, true);

                        $ownerPassports = is_array($application->multiple_owners_passport)
                            ? $application->multiple_owners_passport
                            : json_decode($application->multiple_owners_passport, true);
                    @endphp

                    @foreach ($ownerNames as $key => $ownerName)
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex items-center">
                                <div class="mr-4">
                                    @if (isset($ownerPassports[$key]) && !empty($ownerPassports[$key]))
                                        <img src="{{ asset('storage/app/public/' . $ownerPassports[$key]) }}"
                                            alt="Owner Photo"
                                            class="w-16 h-16 object-cover rounded-full border border-gray-300">
                                    @else
                                        <div
                                            class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center">
                                            <span class="text-gray-500 text-xs">No Photo</span>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-gray-900 font-medium">{{ $ownerName }}
                                    </p>
                                    <p class="text-gray-600 text-sm">Owner {{ $key + 1 }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- Property Information -->
    <div class="mb-8">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">Property Information
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-gray-50 p-4 rounded-lg">
                <strong class="block font-medium text-gray-700 mb-1">Land Use:</strong>
                <span
                    class="text-gray-900">{{ ucfirst($application->land_use ?? 'N/A') }}</span>
            </div>

            @if (!empty($application->residential_type))
                <div class="bg-gray-50 p-4 rounded-lg">
                    <strong class="block font-medium text-gray-700 mb-1">Residential
                        Type:</strong>
                    <span
                        class="text-gray-900">{{ ucfirst($application->residential_type) }}</span>
                </div>
            @endif

            @if (!empty($application->industrial_type))
                <div class="bg-gray-50 p-4 rounded-lg">
                    <strong class="block font-medium text-gray-700 mb-1">Industrial
                        Type:</strong>
                    <span
                        class="text-gray-900">{{ ucfirst($application->industrial_type) }}</span>
                </div>
            @endif

            @if (!empty($application->commercial_type))
                <div class="bg-gray-50 p-4 rounded-lg">
                    <strong class="block font-medium text-gray-700 mb-1">Commercial
                        Type:</strong>
                    <span
                        class="text-gray-900">{{ ucfirst($application->commercial_type) }}</span>
                </div>
            @endif

            <div class="bg-gray-50 p-4 rounded-lg">
                <strong class="block font-medium text-gray-700 mb-1">Plot Size:</strong>
                <span class="text-gray-900">{{ $application->plot_size ?? 'N/A' }} sqm</span>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <strong class="block font-medium text-gray-700 mb-1">Number of Units:</strong>
                <span class="text-gray-900">{{ $application->NoOfUnits ?? 'N/A' }}</span>
            </div>
        </div>

        <div class="mt-4 bg-gray-50 p-4 rounded-lg">
            <strong class="block font-medium text-gray-700 mb-1">Property Location:</strong>
            <span class="block text-gray-900">
                Plot No: {{ $application->property_house_no ?? '' }}
                {{ $application->property_plot_no ?? '' }}
            </span>
            <span class="block text-gray-900">
                Street Name: {{ $application->property_street_name ?? '' }}
            </span>
            <span class="block text-gray-900">
                District: {{ $application->property_district ?? '' }}
            </span>
            <span class="block text-gray-900">
                LGA: {{ $application->property_lga ?? '' }}
            </span>
            <span class="block text-gray-900">
                State: {{ $application->property_state ?? '' }}
            </span>
        </div>
    </div>

    <!-- Financial Information -->
    <div class="mb-8">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">Initial Bill</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-gray-50 p-4 rounded-lg">
                <strong class="block font-medium text-gray-700 mb-1">Application Fee:</strong>
                <span
                    class="text-gray-900">₦{{ number_format($application->application_fee ?? 0, 2) }}</span>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <strong class="block font-medium text-gray-700 mb-1">Processing Fee:</strong>
                <span
                    class="text-gray-900">₦{{ number_format($application->processing_fee ?? 0, 2) }}</span>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <strong class="block font-medium text-gray-700 mb-1">Site Plan Fee:</strong>
                <span
                    class="text-gray-900">₦{{ number_format($application->site_plan_fee ?? 0, 2) }}</span>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <strong class="block font-medium text-gray-700 mb-1">Receipt Number:</strong>
                <span class="text-gray-900">{{ $application->receipt_number ?? 'N/A' }}</span>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <strong class="block font-medium text-gray-700 mb-1">Payment Date:</strong>
                <span
                    class="text-gray-900">{{ $application->payment_date ? date('d M Y', strtotime($application->payment_date)) : 'N/A' }}</span>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <strong class="block font-medium text-gray-700 mb-1">Total Fees:</strong>
                <span
                    class="text-gray-900 font-bold">₦{{ number_format(
                        ($application->application_fee ?? 0) + ($application->processing_fee ?? 0) + ($application->site_plan_fee ?? 0),
                        2,
                    ) }}</span>
            </div>
        </div>
    </div>

    @if ($application->comments)
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">Comments</h3>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-gray-700">
                    {{ $application->comments }}
                </p>
            </div>
        </div>
    @endif

    <div class="mt-6 flex gap-3">
        <a href="{{ route('sectionaltitling.primary') }}"
            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-md transition duration-150 ease-in-out flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd"
                    d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z"
                    clip-rule="evenodd" />
            </svg>
            Back to List
        </a>

        <button onclick="openDocumentsModal()" class="ml-auto bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 text-sm rounded-md flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            View Documents
        </button>

       <!-- Documents Modal -->
       <div id="documentsModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
            <div class="bg-gray-100 p-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-semibold">Application Documents</h3>
                <button onclick="closeDocumentsModal()" class="text-gray-600 hover:text-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="p-6 overflow-y-auto max-h-[calc(90vh-120px)]">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @php
                        $documents = !empty($application->documents) 
                            ? (is_string($application->documents) ? json_decode($application->documents, true) : $application->documents) 
                            : [];
                        
                        if (json_last_error() !== JSON_ERROR_NONE || !is_array($documents)) {
                            $documents = [];
                        }
                    @endphp
                    
                    @foreach($documents as $key => $document)
                        @if(is_array($document) && isset($document['path']))
                            <div class="bg-gray-50 rounded-lg border border-gray-200 p-4">
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0 w-16 h-16 bg-gray-100 rounded flex items-center justify-center">
                                        @php
                                            $type = $document['type'] ?? 'unknown';
                                            $icon = 'document-text';
                                            
                                            if (in_array($type, ['jpg', 'jpeg', 'png', 'gif'])) {
                                                $icon = 'photograph';
                                            } elseif (in_array($type, ['pdf'])) {
                                                $icon = 'document';
                                            } elseif (in_array($type, ['doc', 'docx'])) {
                                                $icon = 'document-text';
                                            }
                                        @endphp
                                        
                                        @if(in_array($type, ['jpg', 'jpeg', 'png', 'gif']))
                                            <img src="{{ asset('storage/app/public/' . $document['path']) }}" 
                                                alt="Document" 
                                                class="w-14 h-14 object-cover rounded">
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 capitalize">
                                            {{ str_replace('_', ' ', $key) }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            Uploaded: {{ isset($document['uploaded_at']) ? \Carbon\Carbon::parse($document['uploaded_at'])->format('M d, Y') : 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="mt-3 flex justify-end">
                                    <button onclick="viewDocument('{{ asset('storage/app/public/' . $document['path']) }}', '{{ $type }}')" 
                                       class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-3 py-1 rounded">
                                        View Document
                                    </button>
                                </div>
                            </div>
                        @endif
                    @endforeach
                    
                    @if(count($documents) == 0)
                        <div class="col-span-2 text-center py-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="text-gray-500">No documents available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Document Viewer Modal -->
    <div id="documentViewerModal" class="fixed inset-0 bg-black bg-opacity-80 z-50 hidden flex items-center justify-center">
        <div class="max-w-5xl w-full h-[34vh] bg-white rounded-lg shadow-xl overflow-hidden flex flex-col" style="max-height: 90vh;">
            <div class="bg-gray-100 p-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-semibold">Document Viewer</h3>
                <button onclick="closeDocumentViewer()" class="text-gray-600 hover:text-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="flex-1 p-4 overflow-auto bg-gray-800 flex items-center justify-center" id="documentContent">
                <!-- Document will be loaded here -->
            </div>
        </div>
    </div>

    <script>
        function openDocumentsModal() {
            document.getElementById('documentsModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        
        function closeDocumentsModal() {
            document.getElementById('documentsModal').classList.add('hidden');
            document.body.style.overflow = '';
        }
        
        function viewDocument(url, type) {
            const viewer = document.getElementById('documentViewerModal');
            const content = document.getElementById('documentContent');
            
            // Clear previous content
            content.innerHTML = '';
            
            // Add appropriate content based on document type
            if (['jpg', 'jpeg', 'png', 'gif'].includes(type)) {
                const img = document.createElement('img');
                img.src = url;
                img.className = 'max-w-full max-h-full object-contain';
                content.appendChild(img);
            } else if (type === 'pdf') {
                const iframe = document.createElement('iframe');
                iframe.src = url;
                iframe.className = 'w-full h-full';
                content.appendChild(iframe);
            } else {
                const iframe = document.createElement('iframe');
                iframe.src = url;
                iframe.className = 'w-full h-full';
                content.appendChild(iframe);
            }
            
            // Show the viewer modal
            viewer.classList.remove('hidden');
        }
        
        function closeDocumentViewer() {
            document.getElementById('documentViewerModal').classList.add('hidden');
        }
    </script>
    </div>
</div>
</div>
</div>
</div>
</div>

<!-- Footer -->
@include('admin.footer')
</div>
@endsection
