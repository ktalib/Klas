@extends('layouts.app')
@section('page-title')
    {{ __('View GIS Data') }}
@endsection

@include('sectionaltitling.partials.assets.css')
@section('content')
<div class="flex-1 overflow-auto">
    <!-- Header -->
    @include('admin.header')
    <!-- Dashboard Content -->
    <div class="p-6">
        <!-- Main Content Container -->
        <div class="bg-white rounded-md shadow-sm border border-gray-200 p-6">
            <!-- Header with actions -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold">View GIS Data</h2>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('gis.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to List
                    </a>
                    <a href="#" onclick="window.print()" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        Print
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <!-- Content in card sections -->
            <div class="space-y-6">
                <!-- File Information Section -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-gray-700 border-b pb-2">File Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">MLSF Number</p>
                            <p class="text-sm font-semibold">{{ $gisData->mlsfNo ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">KANGIS File Number</p>
                            <p class="text-sm font-semibold">{{ $gisData->kangisFileNo ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">New KANGIS File Number</p>
                            <p class="text-sm font-semibold">{{ $gisData->NewKANGISFileno ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Plot Information Section -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-gray-700 border-b pb-2">Plot Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Plot Number</p>
                            <p class="text-sm font-semibold">{{ $gisData->plotNo ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Block Number</p>
                            <p class="text-sm font-semibold">{{ $gisData->blockNo ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Approved Plan Number</p>
                            <p class="text-sm font-semibold">{{ $gisData->approvedPlanNo ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">TP Plan Number</p>
                            <p class="text-sm font-semibold">{{ $gisData->tpPlanNo ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Area (in Hectares)</p>
                            <p class="text-sm font-semibold">{{ $gisData->areaInHectares ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Land Use</p>
                            <p class="text-sm font-semibold">{{ $gisData->landUse ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Specific Use</p>
                            <p class="text-sm font-semibold">{{ $gisData->specifically ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Location Information Section -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-gray-700 border-b pb-2">Location Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Layout Name</p>
                            <p class="text-sm font-semibold">{{ $gisData->layoutName ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">District Name</p>
                            <p class="text-sm font-semibold">{{ $gisData->districtName ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">LGA Name</p>
                            <p class="text-sm font-semibold">{{ $gisData->lgaName ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">State Name</p>
                            <p class="text-sm font-semibold">{{ $gisData->StateName ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Street Name</p>
                            <p class="text-sm font-semibold">{{ $gisData->streetName ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">House Number</p>
                            <p class="text-sm font-semibold">{{ $gisData->houseNo ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">House Type</p>
                            <p class="text-sm font-semibold">{{ $gisData->houseType ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Tenancy</p>
                            <p class="text-sm font-semibold">{{ $gisData->tenancy ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Survey Information Section -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-gray-700 border-b pb-2">Survey Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Surveyed By</p>
                            <p class="text-sm font-semibold">{{ $gisData->surveyedBy ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Drawn By</p>
                            <p class="text-sm font-semibold">{{ $gisData->drawnBy ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Checked By</p>
                            <p class="text-sm font-semibold">{{ $gisData->checkedBy ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Passed By</p>
                            <p class="text-sm font-semibold">{{ $gisData->passedBy ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Beacon Control Name</p>
                            <p class="text-sm font-semibold">{{ $gisData->beaconControlName ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Beacon Control X</p>
                            <p class="text-sm font-semibold">{{ $gisData->beaconControlX ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Beacon Control Y</p>
                            <p class="text-sm font-semibold">{{ $gisData->beaconControlY ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Metric Sheet Index</p>
                            <p class="text-sm font-semibold">{{ $gisData->metricSheetIndex ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Metric Sheet Number</p>
                            <p class="text-sm font-semibold">{{ $gisData->metricSheetNo ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Imperial Sheet</p>
                            <p class="text-sm font-semibold">{{ $gisData->imperialSheet ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Imperial Sheet Number</p>
                            <p class="text-sm font-semibold">{{ $gisData->imperialSheetNo ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Surveyor General Signature Date</p>
                            <p class="text-sm font-semibold">{{ $gisData->SurveyorGeneralSignatureDate ? date('d M, Y', strtotime($gisData->SurveyorGeneralSignatureDate)) : 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Title Information Section -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-gray-700 border-b pb-2">Title Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Old Title Serial No</p>
                            <p class="text-sm font-semibold">{{ $gisData->oldTitleSerialNo ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Old Title Page No</p>
                            <p class="text-sm font-semibold">{{ $gisData->oldTitlePageNo ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Old Title Volume No</p>
                            <p class="text-sm font-semibold">{{ $gisData->oldTitleVolumeNo ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Deeds Date</p>
                            <p class="text-sm font-semibold">{{ $gisData->deedsDate ? date('d M, Y', strtotime($gisData->deedsDate)) : 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Deeds Time</p>
                            <p class="text-sm font-semibold">{{ $gisData->deedsTime ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Certificate Date</p>
                            <p class="text-sm font-semibold">{{ $gisData->certificateDate ? date('d M, Y', strtotime($gisData->certificateDate)) : 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">CofO Serial No</p>
                            <p class="text-sm font-semibold">{{ $gisData->CofOSerialNo ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Title Issued Year</p>
                            <p class="text-sm font-semibold">{{ $gisData->titleIssuedYear ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Owner Information Section -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-gray-700 border-b pb-2">Owner Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Original Allottee</p>
                            <p class="text-sm font-semibold">{{ $gisData->originalAllottee ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Address of Original Allottee</p>
                            <p class="text-sm font-semibold">{{ $gisData->addressOfOriginalAllottee ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Change of Ownership</p>
                            <p class="text-sm font-semibold">{{ $gisData->changeOfOwnership ?? 'No' }}</p>
                        </div>
                        
                        @if($gisData->changeOfOwnership == 'Yes')
                        <div>
                            <p class="text-sm font-medium text-gray-500">Reason for Change</p>
                            <p class="text-sm font-semibold">{{ $gisData->reasonForChange ?? 'N/A' }}</p>
                        </div>
                        @endif
                        
                        <div>
                            <p class="text-sm font-medium text-gray-500">Current Allottee</p>
                            <p class="text-sm font-semibold">{{ $gisData->currentAllottee ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Address of Current Allottee</p>
                            <p class="text-sm font-semibold">{{ $gisData->addressOfCurrentAllottee ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Title of Current Allottee</p>
                            <p class="text-sm font-semibold">{{ $gisData->titleOfCurrentAllottee ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Phone Number</p>
                            <p class="text-sm font-semibold">{{ $gisData->phoneNo ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Email Address</p>
                            <p class="text-sm font-semibold">{{ $gisData->emailAddress ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Occupation</p>
                            <p class="text-sm font-semibold">{{ $gisData->occupation ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Nationality</p>
                            <p class="text-sm font-semibold">{{ $gisData->nationality ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Company RC Number</p>
                            <p class="text-sm font-semibold">{{ $gisData->CompanyRCNo ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Document Attachments Section -->
                @if(isset($gisData->files) && $gisData->files)
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-gray-700 border-b pb-2">Document Attachments</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @php
                            $files = json_decode($gisData->files, true);
                        @endphp
                        
                        @if(is_array($files) && count($files) > 0)
                            @foreach($files as $fileType => $filePath)
                                <div>
                                    <p class="text-sm font-medium text-gray-500">{{ ucwords(str_replace(['_', 'And'], [' ', '&'], $fileType)) }}</p>
                                    <p class="text-sm font-semibold">
                                        <a href="{{ asset('storage/'.$filePath) }}" target="_blank" class="text-blue-600 hover:underline flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            View Document
                                        </a>
                                    </p>
                                </div>
                            @endforeach
                        @else
                            <div class="col-span-2">
                                <p class="text-sm text-gray-500">No documents attached.</p>
                            </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    <!-- Footer -->
    @include('admin.footer')
</div>
@endsection

@section('scripts')
<script>
    // Add any JavaScript needed for the view page
</script>
@endsection
