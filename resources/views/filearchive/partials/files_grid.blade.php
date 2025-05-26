<div id="files-container" class="card">
    <div class="p-6 border-b flex flex-row items-center justify-between">
        <div>
            <h2 class="text-lg font-semibold">Archived Files</h2>
            <p class="text-sm text-muted-foreground">
                Recently archived digital files
            </p>
        </div>
        <div class="flex gap-2">
            <button id="filter-button" class="btn btn-outline btn-sm gap-1">
                <i data-lucide="filter" class="h-3.5 w-3.5"></i>
                Filter
            </button>
            <button id="sort-button" class="btn btn-outline btn-sm gap-1">
                <i data-lucide="sort-asc" class="h-3.5 w-3.5"></i>
                Sort
            </button>
        </div>
    </div>

    <div class="p-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
           

            <!-- File Card 3 - with real image -->
            <div class="border rounded-lg overflow-hidden hover:shadow-md transition-shadow cursor-pointer file-card" data-id="FILE-2023-003">
                <div class="aspect-[3/4] bg-gray-100 relative">
                    <!-- Document thumbnail with real image -->
                    <div class="absolute inset-0 flex items-center justify-center bg-gray-50">
                        <div class="w-full h-full relative">
                            <img src="{{ asset('storage/upload/dummy/1.jpg') }}" alt="Kano Traders Association" class="w-full h-full object-cover" />
                            <div class="absolute bottom-1 right-1">
                                <svg class="w-8 h-8 text-blue-500 drop-shadow-lg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19.826 21.214H4.174A2.174 2.174 0 0 1 2 19.04V4.96c0-1.2.974-2.174 2.174-2.174h15.652A2.174 2.174 0 0 1 22 4.96v14.08a2.174 2.174 0 0 1-2.174 2.174M4.174 4.13a.83.83 0 0 0-.83.83v14.08c0 .458.372.83.83.83h15.652a.83.83 0 0 0 .83-.83V4.96a.83.83 0 0 0-.83-.83H4.174z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- File type badge -->
                    <div class="absolute top-2 right-2">
                        <span class="badge badge-secondary text-xs font-medium">
                            JPG
                        </span>
                    </div>
                </div>

                <div class="p-3">
                    <h3 class="font-medium text-sm line-clamp-1" title="Kano Traders Association">
                        Kano Traders Association
                    </h3>
                    <div class="mt-1 flex items-center text-xs text-muted-foreground">
                        <span class="line-clamp-1" title="COM-91-249">
                            COM-91-249
                        </span>
                    </div>
                    <div class="mt-2 flex items-center justify-between">
                        <span class="text-xs text-muted-foreground">1.2 MB</span>
                        <span class="badge badge-secondary text-xs">
                            Archived
                        </span>
                    </div>
                </div>
                <div class="p-2 pt-0 flex flex-wrap gap-1">
                    <span class="badge badge-secondary text-xs">Commercial</span>
                    <span class="badge badge-secondary text-xs">Sabon Gari</span>
                </div>
            </div>

            <!-- File Card 4 - with real image -->
            <div class="border rounded-lg overflow-hidden hover:shadow-md transition-shadow cursor-pointer file-card" data-id="FILE-2023-004">
                <div class="aspect-[3/4] bg-gray-100 relative">
                    <!-- Document thumbnail with real image -->
                    <div class="absolute inset-0 flex items-center justify-center bg-gray-50">
                        <div class="w-full h-full relative">
                            <img src="{{ asset('storage/upload/dummy/3.jpg') }}" alt="Musa Usman Bayero" class="w-full h-full object-cover" />
                            <div class="absolute bottom-1 right-1">
                                <svg class="w-8 h-8 text-blue-500 drop-shadow-lg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19.826 21.214H4.174A2.174 2.174 0 0 1 2 19.04V4.96c0-1.2.974-2.174 2.174-2.174h15.652A2.174 2.174 0 0 1 22 4.96v14.08a2.174 2.174 0 0 1-2.174 2.174M4.174 4.13a.83.83 0 0 0-.83.83v14.08c0 .458.372.83.83.83h15.652a.83.83 0 0 0 .83-.83V4.96a.83.83 0 0 0-.83-.83H4.174z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- File type badge -->
                    <div class="absolute top-2 right-2">
                        <span class="badge badge-secondary text-xs font-medium">
                            JPG
                        </span>
                    </div>
                </div>

                <div class="p-3">
                    <h3 class="font-medium text-sm line-clamp-1" title="Musa Usman Bayero">
                        Musa Usman Bayero
                    </h3>
                    <div class="mt-1 flex items-center text-xs text-muted-foreground">
                        <span class="line-clamp-1" title="RES-2000-1904">
                            RES-2000-1904
                        </span>
                    </div>
                    <div class="mt-2 flex items-center justify-between">
                        <span class="text-xs text-muted-foreground">3.1 MB</span>
                        <span class="badge badge-outline text-xs">
                            Active
                        </span>
                    </div>
                </div>
                <div class="p-2 pt-0 flex flex-wrap gap-1">
                    <span class="badge badge-secondary text-xs">Residential</span>
                    <span class="badge badge-secondary text-xs">Right of Occupancy</span>
                </div>
            </div>

            <!-- File Card 5 - with real image -->
            <div class="border rounded-lg overflow-hidden hover:shadow-md transition-shadow cursor-pointer file-card" data-id="FILE-2023-005">
                <div class="aspect-[3/4] bg-gray-100 relative">
                    <!-- Document thumbnail with real image -->
                    <div class="absolute inset-0 flex items-center justify-center bg-gray-50">
                        <div class="w-full h-full relative">
                            <img src="{{ asset('storage/upload/dummy/5.jpg') }}" alt="Hajiya Fatima Mohammed" class="w-full h-full object-cover" />
                            <div class="absolute bottom-1 right-1">
                                <svg class="w-8 h-8 text-blue-500 drop-shadow-lg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19.826 21.214H4.174A2.174 2.174 0 0 1 2 19.04V4.96c0-1.2.974-2.174 2.174-2.174h15.652A2.174 2.174 0 0 1 22 4.96v14.08a2.174 2.174 0 0 1-2.174 2.174M4.174 4.13a.83.83 0 0 0-.83.83v14.08c0 .458.372.83.83.83h15.652a.83.83 0 0 0 .83-.83V4.96a.83.83 0 0 0-.83-.83H4.174z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- File type badge -->
                    <div class="absolute top-2 right-2">
                        <span class="badge badge-secondary text-xs font-medium">
                            JPG
                        </span>
                    </div>
                </div>

                <div class="p-3">
                    <h3 class="font-medium text-sm line-clamp-1" title="Hajiya Fatima Mohammed">
                        Hajiya Fatima Mohammed
                    </h3>
                    <div class="mt-1 flex items-center text-xs text-muted-foreground">
                        <span class="line-clamp-1" title="CON-IND-2021-37">
                            CON-IND-2021-37
                        </span>
                    </div>
                    <div class="mt-2 flex items-center justify-between">
                        <span class="text-xs text-muted-foreground">4.5 MB</span>
                        <span class="badge badge-destructive text-xs">
                            Inactive
                        </span>
                    </div>
                </div>
                <div class="p-2 pt-0 flex flex-wrap gap-1">
                    <span class="badge badge-secondary text-xs">Industrial</span>
                    <span class="badge badge-secondary text-xs">Deed</span>
                </div>
            </div>

            <!-- File Card 6 - with real image -->
            <div class="border rounded-lg overflow-hidden hover:shadow-md transition-shadow cursor-pointer file-card" data-id="FILE-2023-006">
                <div class="aspect-[3/4] bg-gray-100 relative">
                    <!-- Document thumbnail with real image -->
                    <div class="absolute inset-0 flex items-center justify-center bg-gray-50">
                        <div class="w-full h-full relative">
                            <img src="{{ asset('storage/upload/dummy/7.jpg') }}" alt="Nasarawa Development Plan" class="w-full h-full object-cover" />
                            <div class="absolute bottom-1 right-1">
                                <svg class="w-8 h-8 text-blue-500 drop-shadow-lg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19.826 21.214H4.174A2.174 2.174 0 0 1 2 19.04V4.96c0-1.2.974-2.174 2.174-2.174h15.652A2.174 2.174 0 0 1 22 4.96v14.08a2.174 2.174 0 0 1-2.174 2.174M4.174 4.13a.83.83 0 0 0-.83.83v14.08c0 .458.372.83.83.83h15.652a.83.83 0 0 0 .83-.83V4.96a.83.83 0 0 0-.83-.83H4.174z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- File type badge -->
                    <div class="absolute top-2 right-2">
                        <span class="badge badge-secondary text-xs font-medium">
                            JPG
                        </span>
                    </div>
                </div>

                <div class="p-3">
                    <h3 class="font-medium text-sm line-clamp-1" title="Nasarawa Development Plan">
                        Nasarawa Development Plan
                    </h3>
                    <div class="mt-1 flex items-center text-xs text-muted-foreground">
                        <span class="line-clamp-1" title="RES-2019-746">
                            RES-2019-746
                        </span>
                    </div>
                    <div class="mt-2 flex items-center justify-between">
                        <span class="text-xs text-muted-foreground">8.7 MB</span>
                        <span class="badge badge-outline text-xs">
                            Active
                        </span>
                    </div>
                </div>
                <div class="p-2 pt-0 flex flex-wrap gap-1">
                    <span class="badge badge-secondary text-xs">Residential</span>
                    <span class="badge badge-secondary text-xs">Development Plan</span>
                    <span class="badge badge-secondary text-xs">Nasarawa</span>
                </div>
            </div>
        </div>
    </div>

    <div class="flex justify-center border-t pt-4 p-6">
        <button class="btn btn-outline">View All Archives</button>
    </div>
</div>
