     <div id="instrument-type-modal"
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl max-h-[90vh] overflow-y-auto">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-2">
                            <h2 class="text-xl font-bold">Select Instrument Type</h2>
                            <button id="close-modal-btn" class="text-gray-500 hover:text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <p class="text-gray-500 mb-6">Choose the type of instrument you want to register from the options
                            below.</p>

                        <div class="space-y-4">
                            <!-- Power of Attorney -->
                            <div class="border rounded-lg p-4 hover:bg-gray-50 cursor-pointer instrument-option">
                                <div class="flex items-start gap-4">
                                    <div
                                        class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-medium">Power of Attorney</h3>
                                        <p class="text-sm text-gray-500">Legal authorization to act on someone else's
                                            behalf in specified matters</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Irrevocable Power of Attorney -->
                            <div class="border rounded-lg p-4 hover:bg-gray-50 cursor-pointer instrument-option">
                                <div class="flex items-start gap-4">
                                    <div
                                        class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-medium">Irrevocable Power of Attorney</h3>
                                        <p class="text-sm text-gray-500">Power of attorney that cannot be revoked by the
                                            grantor until a specified condition is met</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Deed of Mortgage -->
                            <div class="border rounded-lg p-4 hover:bg-gray-50 cursor-pointer instrument-option">
                                <div class="flex items-start gap-4">
                                    <div
                                        class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-medium">Deed of Mortgage</h3>
                                        <p class="text-sm text-gray-500">Legal document that pledges property as security
                                            for a loan between two parties</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Tripartite Mortgage -->
                            <div class="border rounded-lg p-4 hover:bg-gray-50 cursor-pointer instrument-option">
                                <div class="flex items-start gap-4">
                                    <div
                                        class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-medium">Tripartite Mortgage</h3>
                                        <p class="text-sm text-gray-500">Mortgage agreement involving three parties:
                                            borrower, lender, and a third party</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Deed of Assignment -->
                            <div class="border rounded-lg p-4 hover:bg-gray-50 cursor-pointer instrument-option">
                                <div class="flex items-start gap-4">
                                    <div
                                        class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-medium">Deed of Assignment</h3>
                                        <p class="text-sm text-gray-500">Legal document that transfers ownership rights
                                            from one party to another</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Deed of Lease -->
                            <div class="border rounded-lg p-4 hover:bg-gray-50 cursor-pointer instrument-option">
                                <div class="flex items-start gap-4">
                                    <div
                                        class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-medium">Deed of Lease</h3>
                                        <p class="text-sm text-gray-500">Legal document that grants a tenant exclusive
                                            possession of property for a fixed period</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Deed of Sub-under Lease -->
                            <div class="border rounded-lg p-4 hover:bg-gray-50 cursor-pointer instrument-option">
                                <div class="flex items-start gap-4">
                                    <div
                                        class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-medium">Deed of Sub-under Lease</h3>
                                        <p class="text-sm text-gray-500">Legal document for leasing property that is
                                            already subject to a sub-lease</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Deed of Sub-division -->
                            <div class="border rounded-lg p-4 hover:bg-gray-50 cursor-pointer instrument-option">
                                <div class="flex items-start gap-4">
                                    <div
                                        class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-medium">Deed of Sub-division</h3>
                                        <p class="text-sm text-gray-500">Legal document that divides a single property into
                                            multiple separate properties</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Deed of Merger -->
                            <div class="border rounded-lg p-4 hover:bg-gray-50 cursor-pointer instrument-option">
                                <div class="flex items-start gap-4">
                                    <div
                                        class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-medium">Deed of Merger</h3>
                                        <p class="text-sm text-gray-500">Legal document that combines multiple properties
                                            into a single property</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Deed of Surrender -->
                            <div class="border rounded-lg p-4 hover:bg-gray-50 cursor-pointer instrument-option">
                                <div class="flex items-start gap-4">
                                    <div
                                        class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-medium">Deed of Surrender</h3>
                                        <p class="text-sm text-gray-500">Legal document where a tenant gives up their lease
                                            before the end of the term</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Deed of Assent -->
                            <div class="border rounded-lg p-4 hover:bg-gray-50 cursor-pointer instrument-option">
                                <div class="flex items-start gap-4">
                                    <div
                                        class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-medium">Deed of Assent</h3>
                                        <p class="text-sm text-gray-500">Legal document that transfers property from a
                                            deceased person's estate to beneficiaries</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Deed of Release -->
                            <div class="border rounded-lg p-4 hover:bg-gray-50 cursor-pointer instrument-option">
                                <div class="flex items-start gap-4">
                                    <div
                                        class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-medium">Deed of Release</h3>
                                        <p class="text-sm text-gray-500">Legal document that releases a party from
                                            obligations or claims</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end mt-6 gap-2">
                            <button id="cancel-btn"
                                class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                Cancel
                            </button>
                            <button id="continue-btn"
                                class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-500 hover:bg-gray-600"
                                disabled>
                                Continue
                            </button>
                        </div>
                    </div>
                </div>
            </div>
