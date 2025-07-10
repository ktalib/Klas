@extends('layouts.app')
@section('page-title')
    {{ __('COROI Debug - Data Inspection') }}
@endsection

@section('content')
    <div class="flex-1 overflow-auto">
        <!-- Header -->
        @include('admin.header')
        
        <!-- Debug Content -->
        <div class="p-6">
            <div class="max-w-4xl mx-auto">
                <h1 class="text-2xl font-bold mb-6">COROI Debug - Data Inspection</h1>
                
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold mb-4">Raw Data Dump</h2>
                    
                    @if(isset($data))
                        <div class="bg-gray-100 p-4 rounded mb-4">
                            <h3 class="font-medium mb-2">Data Object:</h3>
                            <pre class="text-sm">{{ print_r($data, true) }}</pre>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-blue-50 p-4 rounded">
                                <h3 class="font-medium mb-2">Key Fields Check:</h3>
                                <ul class="text-sm space-y-1">
                                    <li><strong>Applicant_Name:</strong> 
                                        @if(isset($data->Applicant_Name))
                                            <span class="text-green-600">✓ {{ $data->Applicant_Name }}</span>
                                        @else
                                            <span class="text-red-600">✗ Not set</span>
                                        @endif
                                    </li>
                                    <li><strong>instrument_type:</strong> 
                                        @if(isset($data->instrument_type))
                                            <span class="text-green-600">✓ {{ $data->instrument_type }}</span>
                                        @else
                                            <span class="text-red-600">✗ Not set</span>
                                        @endif
                                    </li>
                                    <li><strong>volume_no:</strong> 
                                        @if(isset($data->volume_no))
                                            <span class="text-green-600">✓ {{ $data->volume_no }}</span>
                                        @else
                                            <span class="text-red-600">✗ Not set</span>
                                        @endif
                                    </li>
                                    <li><strong>page_no:</strong> 
                                        @if(isset($data->page_no))
                                            <span class="text-green-600">✓ {{ $data->page_no }}</span>
                                        @else
                                            <span class="text-red-600">✗ Not set</span>
                                        @endif
                                    </li>
                                    <li><strong>serial_no:</strong> 
                                        @if(isset($data->serial_no))
                                            <span class="text-green-600">✓ {{ $data->serial_no }}</span>
                                        @else
                                            <span class="text-red-600">✗ Not set</span>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                            
                            <div class="bg-green-50 p-4 rounded">
                                <h3 class="font-medium mb-2">Time Fields Check:</h3>
                                <ul class="text-sm space-y-1">
                                    <li><strong>hour_part:</strong> 
                                        @if(isset($data->hour_part))
                                            <span class="text-green-600">✓ {{ $data->hour_part }}</span>
                                        @else
                                            <span class="text-red-600">✗ Not set</span>
                                        @endif
                                    </li>
                                    <li><strong>time_part:</strong> 
                                        @if(isset($data->time_part))
                                            <span class="text-green-600">✓ {{ $data->time_part }}</span>
                                        @else
                                            <span class="text-red-600">✗ Not set</span>
                                        @endif
                                    </li>
                                    <li><strong>formatted_date:</strong> 
                                        @if(isset($data->formatted_date))
                                            <span class="text-green-600">✓ {{ $data->formatted_date }}</span>
                                        @else
                                            <span class="text-red-600">✗ Not set</span>
                                        @endif
                                    </li>
                                    <li><strong>deeds_date:</strong> 
                                        @if(isset($data->deeds_date))
                                            <span class="text-green-600">✓ {{ $data->deeds_date }}</span>
                                        @else
                                            <span class="text-red-600">✗ Not set</span>
                                        @endif
                                    </li>
                                    <li><strong>deeds_time:</strong> 
                                        @if(isset($data->deeds_time))
                                            <span class="text-green-600">✓ {{ $data->deeds_time }}</span>
                                        @else
                                            <span class="text-red-600">✗ Not set</span>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="mt-6 bg-yellow-50 p-4 rounded">
                            <h3 class="font-medium mb-2">Template Output Test:</h3>
                            <div class="text-sm space-y-2">
                                <p><strong>Applicant Name Output:</strong> 
                                    "{{ isset($data) && isset($data->Applicant_Name) ? strtoupper($data->Applicant_Name) : 'APPLICANT NAME' }}"
                                </p>
                                <p><strong>Time Output:</strong> 
                                    "AT {{ isset($data) && isset($data->hour_part) ? $data->hour_part : '12' }} O'CLOCK IN THE {{ isset($data) && isset($data->time_part) ? $data->time_part : 'AFTERNOON' }}"
                                </p>
                                <p><strong>Volume/Page/Serial Output:</strong> 
                                    "NO {{ isset($data) && isset($data->serial_no) ? $data->serial_no : '1' }} AT PAGE {{ isset($data) && isset($data->page_no) ? $data->page_no : '1' }} IN VOLUME {{ isset($data) && isset($data->volume_no) ? $data->volume_no : '1' }}"
                                </p>
                            </div>
                        </div>
                        
                    @else
                        <div class="bg-red-100 p-4 rounded">
                            <p class="text-red-600 font-medium">No data object found!</p>
                        </div>
                    @endif
                    
                    <div class="mt-6">
                        <a href="{{ route('coroi.index') }}?url=registered_instruments&fileno=ST-COM-2025-01" 
                           class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Test with ST-COM-2025-01
                        </a>
                        <a href="{{ route('coroi.index') }}" 
                           class="ml-2 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                            Back to COROI
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        @include('admin.footer')
    </div>
@endsection