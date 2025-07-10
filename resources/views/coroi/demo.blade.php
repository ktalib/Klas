@extends('layouts.app')
@section('page-title')
    {{ __('COROI Demo - Registered Instruments Search') }}
@endsection

@section('content')
    <div class="flex-1 overflow-auto">
        <!-- Header -->
        @include('admin.header')
        
        <!-- Demo Content -->
        <div class="p-6">
            <div class="max-w-4xl mx-auto">
                <h1 class="text-2xl font-bold mb-6">COROI - Registered Instruments Search Demo</h1>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Search by File Number -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-lg font-semibold mb-4">Search by File Number</h2>
                        <p class="text-gray-600 mb-4">Search the registered_instruments table using any of the following file number columns:</p>
                        <ul class="list-disc list-inside text-sm text-gray-600 mb-4">
                            <li>MLSFileNo</li>
                            <li>KAGISFileNO</li>
                            <li>NewKANGISFileNo</li>
                            <li>StFileNo</li>
                        </ul>
                        
                        <div class="space-y-3">
                            <h3 class="font-medium">Example URLs:</h3>
                            <div class="space-y-2 text-sm">
                                <a href="{{ route('coroi.index') }}?url=registered_instruments&fileno=ST-COM-2025-03" 
                                   class="block bg-blue-50 p-2 rounded border text-blue-600 hover:bg-blue-100">
                                    Search for file: ST-COM-2025-03
                                </a>
                                <a href="{{ route('coroi.index') }}?url=registered_instruments&fileno=MLS-2024-001" 
                                   class="block bg-blue-50 p-2 rounded border text-blue-600 hover:bg-blue-100">
                                    Search for file: MLS-2024-001
                                </a>
                                <a href="{{ route('coroi.index') }}?url=registered_instruments&fileno=KAGIS-2024-100" 
                                   class="block bg-blue-50 p-2 rounded border text-blue-600 hover:bg-blue-100">
                                    Search for file: KAGIS-2024-100
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Search by STM Reference -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-lg font-semibold mb-4">Search by STM Reference</h2>
                        <p class="text-gray-600 mb-4">Search using the STM_Ref column (existing functionality):</p>
                        
                        <div class="space-y-3">
                            <h3 class="font-medium">Example URLs:</h3>
                            <div class="space-y-2 text-sm">
                                <a href="{{ route('coroi.index') }}?url=registered_instruments&STM_Ref=STM-2025-001" 
                                   class="block bg-green-50 p-2 rounded border text-green-600 hover:bg-green-100">
                                    Search for STM: STM-2025-001
                                </a>
                                <a href="{{ route('coroi.index') }}?url=registered_instruments&STM_Ref=STM-2024-500" 
                                   class="block bg-green-50 p-2 rounded border text-green-600 hover:bg-green-100">
                                    Search for STM: STM-2024-500
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Interactive Search Form -->
                <div class="mt-8 bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold mb-4">Interactive Search</h2>
                    
                    <form id="searchForm" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="searchType" class="block text-sm font-medium text-gray-700 mb-2">Search Type:</label>
                                <select id="searchType" class="w-full border border-gray-300 rounded-md px-3 py-2">
                                    <option value="fileno">File Number</option>
                                    <option value="STM_Ref">STM Reference</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="searchValue" class="block text-sm font-medium text-gray-700 mb-2">Search Value:</label>
                                <input type="text" id="searchValue" 
                                       class="w-full border border-gray-300 rounded-md px-3 py-2" 
                                       placeholder="Enter search value">
                            </div>
                            
                            <div class="flex items-end">
                                <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
                                    Search & Generate Certificate
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                
                <!-- Technical Information -->
                <div class="mt-8 bg-gray-50 rounded-lg p-6">
                    <h2 class="text-lg font-semibold mb-4">Technical Implementation</h2>
                    <div class="text-sm text-gray-700 space-y-2">
                        <p><strong>Controller:</strong> CoroiController@index and CoroiController@findRecordByFileno</p>
                        <p><strong>Database:</strong> registered_instruments table with SQL Server connection</p>
                        <p><strong>Search Logic:</strong> Exact match first, then LIKE pattern matching</p>
                        <p><strong>File Number Columns:</strong> MLSFileNo, KAGISFileNO, NewKANGISFileNo, StFileNo</p>
                        <p><strong>Fallback:</strong> Mock data if no records found</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        @include('admin.footer')
    </div>

    <script>
        document.getElementById('searchForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const searchType = document.getElementById('searchType').value;
            const searchValue = document.getElementById('searchValue').value;
            
            if (!searchValue.trim()) {
                alert('Please enter a search value');
                return;
            }
            
            const url = `{{ route('coroi.index') }}?url=registered_instruments&${searchType}=${encodeURIComponent(searchValue)}`;
            window.location.href = url;
        });
    </script>
@endsection