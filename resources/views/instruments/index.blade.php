@extends('layouts.app')
@section('page-title')
    {{ __('Instrument Capture') }}
@endsection


@section('content')
    @include('instruments.partial.css')
    <!-- Main Content -->
    <div class="flex-1 overflow-auto">
        <!-- Header -->
        @include('admin.header')
        <!-- Dashboard Content -->
        <div class="p-6">

            <main class="space-y-6">
                <!-- Stats Cards -->
              @include('instruments.partial.stats_cards')

                <!-- Global Search -->
                <div class="relative">
                    <div class="search-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
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
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <input type="text" placeholder="Search instruments..."
                                        class="search-input pl-10 w-64">
                                </div>

                                <div class="relative">
                                    <select class="search-input appearance-none pr-8">
                                        <option>10 per page</option>
                                        <option>25 per page</option>
                                        <option>50 per page</option>
                                        <option>100 per page</option>
                                    </select>
                                    <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>

                                <button class="btn btn-outline">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    Export
                                </button>

                                <a  class="btn btn-primary"  href="{{ route('instruments.create') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    Capture New Instrument
                                </a>
                            </div>
                        </div>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <th>Reg. Number</th>
                                <th>File No</th>
                                <th>Grantor</th>
                                <th>Grantee</th>
                                <th>Instrument Type</th>
                                <th>Date</th>
                                <th>Property Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($instruments as $instrument)
                            <tr>
                                <td>{{ $instrument->particularsRegistrationNumber }}</td>
                                <td>{{ $instrument->MLSFileNo ?: $instrument->KAGISFileNO ?: $instrument->NewKANGISFileNo }}</td>
                                <td>{{ $instrument->Grantor }}</td>
                                <td>{{ $instrument->Grantee }}</td>
                                <td>
                                    <span class="badge bg-blue-100 text-blue-800">{{ $instrument->instrument_type }}</span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($instrument->instrumentDate)->format('Y-m-d') }}</td>
                                <td>{{ Str::limit($instrument->propertyDescription, 30) }}</td>
                                <td>
                                    <button class="text-gray-500 hover:text-gray-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">No instruments found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="p-4 border-t border-gray-200 flex justify-between items-center">
                        <div class="text-sm text-gray-500">
                            Showing {{ count($instruments) }} results
                        </div>
                        <div class="flex items-center gap-2">
                            <button class="btn btn-outline px-3 py-1" disabled>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                            <button class="btn btn-outline px-3 py-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </main>

       

            <!-- JavaScript -->
            @include('instruments.partial.js')
        </div>

        <!-- Footer -->
        @include('admin.footer')
    </div>
@endsection
