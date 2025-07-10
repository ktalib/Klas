@extends('layouts.app')
@section('page-title')
    {{ __('Search Registered Instruments') }}
@endsection

@section('content')
    <div class="flex-1 overflow-auto">
        <!-- Header -->
        @include('admin.header')
        
        <!-- Search Form -->
        <div class="p-6">
            <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold mb-4">Search Registered Instruments</h2>
                
                <form action="{{ route('coroi.index') }}" method="GET" class="space-y-4">
                    <div>
                        <label for="search_type" class="block text-sm font-medium text-gray-700 mb-2">Search By:</label>
                        <select name="search_type" id="search_type" class="w-full border border-gray-300 rounded-md px-3 py-2">
                            <option value="fileno">File Number</option>
                            <option value="stm_ref">STM Reference</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="search_value" class="block text-sm font-medium text-gray-700 mb-2">Search Value:</label>
                        <input type="text" name="search_value" id="search_value" 
                               class="w-full border border-gray-300 rounded-md px-3 py-2" 
                               placeholder="Enter file number or STM reference"
                               required>
                    </div>
                    
                    <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
                        Search & Generate Certificate
                    </button>
                </form>
                
                <div class="mt-6 text-sm text-gray-600">
                    <h3 class="font-medium mb-2">Supported File Number Types:</h3>
                    <ul class="list-disc list-inside space-y-1">
                        <li>MLS File Number (MLSFileNo)</li>
                        <li>KAGIS File Number (KAGISFileNO)</li>
                        <li>New KANGIS File Number (NewKANGISFileNo)</li>
                        <li>ST File Number (StFileNo)</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        @include('admin.footer')
    </div>

    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const searchType = document.getElementById('search_type').value;
            const searchValue = document.getElementById('search_value').value;
            
            if (!searchValue.trim()) {
                alert('Please enter a search value');
                return;
            }
            
            let url = '{{ route("coroi.index") }}';
            
            if (searchType === 'fileno') {
                url += `?url=registered_instruments&fileno=${encodeURIComponent(searchValue)}`;
            } else {
                url += `?url=registered_instruments&STM_Ref=${encodeURIComponent(searchValue)}`;
            }
            
            window.location.href = url;
        });
    </script>
@endsection