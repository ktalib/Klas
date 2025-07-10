@extends('layouts.app')
@section('page-title')
    {{ __('COROI Test - Quick Links') }}
@endsection

@section('content')
    <div class="flex-1 overflow-auto">
        <!-- Header -->
        @include('admin.header')
        
        <!-- Test Content -->
        <div class="p-6">
            <div class="max-w-4xl mx-auto">
                <h1 class="text-2xl font-bold mb-6">COROI Test - Quick Links</h1>
                
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold mb-4">Test Links for File Number Search</h2>
                    
                    <div class="space-y-4">
                        <div class="border-l-4 border-blue-500 pl-4">
                            <h3 class="font-medium text-blue-700">Correct URL Format:</h3>
                            <a href="{{ route('coroi.index') }}?url=registered_instruments&fileno=ST-COM-2025-01" 
                               class="text-blue-600 hover:underline block mt-1">
                                {{ route('coroi.index') }}?url=registered_instruments&fileno=ST-COM-2025-01
                            </a>
                            <p class="text-sm text-gray-600 mt-1">This uses proper URL parameter syntax with &amp; separator</p>
                        </div>
                        
                        <div class="border-l-4 border-red-500 pl-4">
                            <h3 class="font-medium text-red-700">Incorrect URL Format (your original):</h3>
                            <span class="text-red-600 block mt-1">
                                {{ route('coroi.index') }}?url=registered_instruments?fileno=ST-COM-2025-01
                            </span>
                            <p class="text-sm text-gray-600 mt-1">This has two question marks which is invalid URL syntax</p>
                        </div>
                        
                        <div class="border-l-4 border-green-500 pl-4">
                            <h3 class="font-medium text-green-700">Alternative Test Files:</h3>
                            <div class="space-y-1 mt-1">
                                <a href="{{ route('coroi.index') }}?url=registered_instruments&fileno=MLS-2024-001" 
                                   class="text-green-600 hover:underline block">
                                    Test with MLS-2024-001
                                </a>
                                <a href="{{ route('coroi.index') }}?url=registered_instruments&fileno=KAGIS-2024-100" 
                                   class="text-green-600 hover:underline block">
                                    Test with KAGIS-2024-100
                                </a>
                                <a href="{{ route('coroi.index') }}?url=registered_instruments&fileno=ST-RES-2025-05" 
                                   class="text-green-600 hover:underline block">
                                    Test with ST-RES-2025-05
                                </a>
                            </div>
                        </div>
                        
                        <div class="border-l-4 border-purple-500 pl-4">
                            <h3 class="font-medium text-purple-700">Debug Tools:</h3>
                            <div class="space-y-1 mt-1">
                                <a href="{{ route('coroi.debug') }}?fileno=ST-COM-2025-01" 
                                   class="text-purple-600 hover:underline block">
                                    Debug View for ST-COM-2025-01
                                </a>
                                <a href="{{ route('coroi.demo') }}" 
                                   class="text-purple-600 hover:underline block">
                                    Interactive Demo Page
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-8 bg-yellow-50 p-4 rounded">
                        <h3 class="font-medium text-yellow-800 mb-2">Quick Fix for Your Issue:</h3>
                        <p class="text-sm text-yellow-700">
                            Change your URL from:<br>
                            <code class="bg-yellow-100 px-1 rounded">?url=registered_instruments?fileno=ST-COM-2025-01</code><br>
                            to:<br>
                            <code class="bg-yellow-100 px-1 rounded">?url=registered_instruments&fileno=ST-COM-2025-01</code>
                        </p>
                    </div>
                    
                    <div class="mt-6">
                        <h3 class="font-medium mb-2">Manual Test Form:</h3>
                        <form action="{{ route('coroi.index') }}" method="GET" class="flex gap-2">
                            <input type="hidden" name="url" value="registered_instruments">
                            <input type="text" name="fileno" placeholder="Enter file number" 
                                   value="ST-COM-2025-01" 
                                   class="border border-gray-300 rounded px-3 py-2 flex-1">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                Test Search
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        @include('admin.footer')
    </div>
@endsection