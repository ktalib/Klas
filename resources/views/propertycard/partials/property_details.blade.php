<div id="property-details-content" class="tab-content active" style="display: block;">
    <div class="card">
        <div class="card-header">
            <h2 class="text-lg font-medium">Property Records</h2>
            <div class="flex items-center gap-2">
                <input type="text" id="property-search" class="form-input w-64" placeholder="Search properties...">
                <button id="add-property-btn" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 mr-2">
                        <path d="M12 5v14M5 12h14"></path>
                    </svg>
                    Add New Property
                </button>
            </div>
        </div>
        <div class="card-body">
            <!-- Property Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                <!-- Add New Property Card -->
                <div class="border rounded-lg shadow-sm cursor-pointer hover:bg-blue-50 transition-colors" id="add-property-card">
                    <div class="flex flex-col items-center justify-center p-6">
                        <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center mb-3">
                            <span class="text-blue-600 text-xl">+</span>
                        </div>
                        <h3 class="text-lg font-medium text-center">Add New Property</h3>
                        <p class="text-sm text-gray-500 text-center mt-1">Create a new property record</p>
                    </div>
                </div>
                
                <!-- Dynamic Property Cards -->
                @forelse($Property_records->take(2) as $property)
                <div class="border rounded-lg shadow-sm overflow-hidden">
                    <div class="bg-gray-50 p-4 border-b">
                        <div class="flex justify-between items-center">
                            <span class="bg-blue-100 text-blue-700 border-blue-200 px-2 py-1 rounded-full text-xs">{{ $property->title_type }}</span>
                            <button class="text-gray-500 property-options" data-id="{{ $property->id }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                    <circle cx="12" cy="12" r="1"></circle>
                                    <circle cx="12" cy="5" r="1"></circle>
                                    <circle cx="12" cy="19" r="1"></circle>
                                </svg>
                            </button>
                        </div>
                        <h3 class="mt-2 font-bold">
                            @if($property->kangisFileNo)
                                {{ $property->kangisFileNo }}
                            @elseif($property->mlsFNo)
                                {{ $property->mlsFNo }}
                            @elseif($property->NewKANGISFileno)
                                {{ $property->NewKANGISFileno }}
                            @else
                                No File Number
                            @endif
                        </h3>
                    </div>
                    <div class="p-4">
                        <div class="space-y-3">
                            <div class="text-sm truncate">{{ $property->property_description ?: 'No description available' }}</div>
                            <div class="space-y-1">
                                <!-- Display new fields -->
                                <div class="flex justify-between text-xs">
                                    <span class="text-gray-500">LGA/City:</span>
                                    <span>{{ $property->lgsaOrCity ?: 'N/A' }}</span>
                                </div>
                                <div class="flex justify-between text-xs">
                                    <span class="text-gray-500">Plot Number:</span>
                                    <span>{{ $property->plot_no ?: 'N/A' }}</span>
                                </div>
                                <div class="flex justify-between text-xs">
                                    <span class="text-gray-500">Layout:</span>
                                    <span>{{ $property->layout ?: 'N/A' }}</span>
                                </div>
                                <div class="flex justify-between text-xs">
                                    <span class="text-gray-500">Schedule:</span>
                                    <span>{{ $property->schedule ?: 'N/A' }}</span>
                                </div>
                                <div class="flex justify-between text-xs">
                                    <span class="text-gray-500">Location:</span>
                                    <span>{{ $property->location ?: 'N/A' }}</span>
                                </div>
                                <div class="flex justify-between text-xs">
                                    <span class="text-gray-500">Reg No:</span>
                                    <span>{{ $property->regNo ?: 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 pt-0 flex justify-between border-t">
                        <div class="text-xs text-gray-500">
                            @if($property->Assignor || $property->Grantor || $property->Mortgagor || $property->Surrenderor || $property->Lessor)
                                <div>From: 
                                    {{ $property->Assignor ?: 
                                       ($property->Grantor ?: 
                                        ($property->Mortgagor ?: 
                                         ($property->Surrenderor ?: 
                                          ($property->Lessor ?: 'N/A')))) }}
                                </div>
                            @endif
                            @if($property->Assignee || $property->Grantee || $property->Mortgagee || $property->Surrenderee || $property->Lessee)
                                <div>To: 
                                    {{ $property->Assignee ?: 
                                       ($property->Grantee ?: 
                                        ($property->Mortgagee ?: 
                                         ($property->Surrenderee ?: 
                                          ($property->Lessee ?: 'N/A')))) }}
                                </div>
                            @endif
                        </div>
                        <button class="px-2 py-1 border rounded-md text-sm flex items-center view-property-details" data-id="{{ $property->id }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 mr-1">
                                <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                            Details
                        </button>
                    </div>
                </div>
                @empty
                <div class="border rounded-lg shadow-sm p-6 text-center col-span-3">
                    <p class="text-gray-500">No property records found. Click "Add New Property" to create one.</p>
                </div>
                @endforelse
            </div>

            <!-- Property Table -->
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>File Number</th>
                            <th>Description</th>
                            <th>Location</th>
                            <th>Reg No</th>
                            <th>Transaction Type</th>
                            <th>Instrument Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($Property_records as $property)
                        <tr>
                            <td class="font-medium">
                                @if($property->kangisFileNo)
                                    {{ $property->kangisFileNo }}
                                @elseif($property->mlsFNo)
                                    {{ $property->mlsFNo }}
                                @elseif($property->NewKANGISFileno)
                                    {{ $property->NewKANGISFileno }}
                                @else
                                    No File Number
                                @endif
                            </td>
                            <td>{{ Str::limit($property->property_description, 30) ?: 'No description' }}</td>
                            <td>{{ $property->location ?: 'N/A' }}</td>
                            <td>{{ $property->regNo ?: 'N/A' }}</td>
                            <td>{{ $property->transaction_type ?: 'N/A' }}</td>
                            <td>{{ $property->instrument_type ?: 'N/A' }}</td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <button class="text-blue-500 hover:text-blue-700 transition-colors view-property" data-id="{{ $property->id }}">
                                        <i data-lucide="eye" class="h-4 w-4 text-blue-500"></i>
                                    </button>
                                    <button class="text-green-500 hover:text-green-700 transition-colors edit-property" data-id="{{ $property->id }}">
                                        <i data-lucide="pencil" class="h-4 w-4 text-green-500"></i>
                                    </button>
                                    <button class="text-red-500 hover:text-red-700 transition-colors delete-property" data-id="{{ $property->id }}">
                                        <i data-lucide="trash-2" class="h-4 w-4 text-red-500"></i>
                                    </button>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-gray-500">No property records found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
