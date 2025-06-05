@extends('layouts.app')
@section('page-title')
    {{ __('SLTR APPLICATION FORM: RESIDENTIAL') }}
@endsection

@section('content')
 <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: {
                        DEFAULT: '#3b82f6',
                        50: '#eff6ff',
                        100: '#dbeafe',
                        500: '#3b82f6',
                        600: '#2563eb',
                        700: '#1d4ed8'
                    },
                    muted: {
                        DEFAULT: '#f3f4f6',
                        foreground: '#6b7280'
                    },
                    border: '#e5e7eb',
                    success: '#10b981',
                    warning: '#f59e0b',
                    destructive: '#ef4444'
                },
                animation: {
                    'spin': 'spin 1s linear infinite',
                }
            }
        }
    }
</script>
<style>
    /* Minimal custom styles that can't be replicated with Tailwind */
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    
    /* Hide scrollbar for modal */
    .modal-content::-webkit-scrollbar {
        display: none;
    }
    .modal-content {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    
    /* Radio and checkbox custom styling */
    input[type="radio"]:checked {
        background-color: #3b82f6;
        border-color: #3b82f6;
        background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3ccircle cx='8' cy='8' r='3'/%3e%3c/svg%3e");
    }
    
    input[type="checkbox"]:checked {
        background-color: #3b82f6;
        border-color: #3b82f6;
        background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='m5.707 7.293-2.414-2.414a1 1 0 0 0-1.414 1.414l3 3a1 1 0 0 0 1.414 0l7-7A1 1 0 0 0 11.879 .879L5.707 7.293z'/%3e%3c/svg%3e");
    }
</style>
 
    <div class="flex-1 overflow-auto">
        <!-- Header -->
        @include('admin.header')
        <!-- Dashboard Content -->
        <div class="p-6">
            
 



<div class="max-w-4xl mx-auto p-6">
    <!-- Main Form Card -->
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
        <!-- Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h1 class="text-xl font-bold">SLTR APPLICATION FORM: <span id="applicant-type-display" class="text-primary-600">RESIDENTIAL</span></h1>
                <div class="text-xs text-muted-foreground space-y-1">
                    <div>CODE: SLTR FORM - 01</div>
                    <div>Parcel ID: <span id="parcel-id" class="font-mono">SLTR-123456</span></div>
                </div>
            </div>

            <!-- Step Indicator -->
            <div class="flex justify-between items-center mt-4">
                <div class="flex items-center">
                    <div class="step-number flex items-center justify-center h-8 w-8 rounded-full text-sm font-medium transition-all duration-200 bg-green-700 text-white" data-step="1">1</div>
                </div>
                <div class="step-connector h-1 w-12 mx-2 bg-gray-200" data-connector="1"></div>
                <div class="flex items-center">
                    <div class="step-number flex items-center justify-center h-8 w-8 rounded-full text-sm font-medium transition-all duration-200 bg-gray-200 text-gray-600" data-step="2">2</div>
                </div>
                <div class="step-connector h-1 w-12 mx-2 bg-gray-200" data-connector="2"></div>
                <div class="flex items-center">
                    <div class="step-number flex items-center justify-center h-8 w-8 rounded-full text-sm font-medium transition-all duration-200 bg-gray-200 text-gray-600" data-step="3">3</div>
                </div>
                <div class="step-connector h-1 w-12 mx-2 bg-gray-200" data-connector="3"></div>
                <div class="flex items-center">
                    <div class="step-number flex items-center justify-center h-8 w-8 rounded-full text-sm font-medium transition-all duration-200 bg-gray-200 text-gray-600" data-step="4">4</div>
                </div>
            </div>
        </div>

        <!-- Form Content -->
        <div class="p-6">
            <!-- Step 1: Applicant Information -->
            <div id="step-1" class="step-content">
                <div class="space-y-4">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium">Applicant Information</h3>
                        <div id="passport-photo-container" class="border-2 border-dashed border-gray-300 rounded-md p-4 text-center w-32 h-40 flex flex-col items-center justify-center cursor-pointer hover:border-primary-500 hover:bg-primary-50 transition-colors">
                            <div id="passport-placeholder" class="text-center">
                                <p class="text-xs text-gray-500">ATTACH RECENT PASSPORT PHOTOGRAPH</p>
                                <div class="mt-2 cursor-pointer">
                                    <div class="flex items-center justify-center bg-gray-100 rounded-md p-2">
                                        <i data-lucide="upload" class="h-4 w-4 text-gray-500"></i>
                                    </div>
                                </div>
                                <input type="file" id="passport-upload" accept="image/*" class="hidden">
                            </div>
                            <div id="passport-uploaded" class="text-center hidden">
                                <p class="text-xs text-green-600 font-medium">Photo uploaded</p>
                                <p id="passport-filename" class="text-xs text-gray-500 mt-1"></p>
                            </div>
                        </div>
                    </div>

                    <!-- File Number Section -->
                    <div class="p-3 bg-gray-50 rounded-md">
                        <div class="flex justify-between items-center">
                            <label class="block text-sm font-medium text-gray-700 mb-2">SLTR File Number:</label>
                            <button type="button" id="regenerate-file-btn" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                                <i data-lucide="refresh-cw" class="h-4 w-4 mr-1"></i>
                                Regenerate
                            </button>
                        </div>
                        <div class="flex items-center mt-2">
                            <input type="text" id="file-number" class="block w-full rounded-md border border-gray-300 px-3 py-2 text-sm bg-gray-100 font-mono" readonly>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">
                            Auto-generated file number following format: SLTR-RES-2024-serialno
                        </p>
                    </div>

                    <!-- Applicant Category Tabs -->
                    <div class="mb-6">
                        <label class="block text-base font-medium text-gray-700 mb-2">Applicant Category</label>
                        <div class="grid grid-cols-3 bg-gray-100 rounded-md p-1 mb-4">
                            <button type="button" class="tab-trigger flex items-center justify-center px-4 py-2 rounded text-sm font-medium transition-all duration-200 bg-white text-primary-600 shadow-sm" data-tab="individual">
                                <i data-lucide="user" class="h-4 w-4 mr-2"></i>
                                Individual
                            </button>
                            <button type="button" class="tab-trigger flex items-center justify-center px-4 py-2 rounded text-sm font-medium transition-all duration-200 text-gray-600 hover:text-gray-900" data-tab="corporate">
                                <i data-lucide="building" class="h-4 w-4 mr-2"></i>
                                Corporate Body
                            </button>
                            <button type="button" class="tab-trigger flex items-center justify-center px-4 py-2 rounded text-sm font-medium transition-all duration-200 text-gray-600 hover:text-gray-900" data-tab="multiple">
                                <i data-lucide="users" class="h-4 w-4 mr-2"></i>
                                Multiple Owners
                            </button>
                        </div>

                        <!-- Individual Tab -->
                        <div id="individual-tab" class="tab-content">
                            <div class="space-y-4 pt-4">
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700" for="applicant-name">1. Name of Applicant</label>
                                    <input type="text" id="applicant-name" class="block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500 focus:ring-opacity-20 outline-none transition-colors" placeholder="Enter full name">
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700" for="nin">2. National Identity Number (NIN)</label>
                                    <div class="flex space-x-2">
                                        <input type="text" id="nin" class="block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500 focus:ring-opacity-20 outline-none transition-colors" placeholder="Enter your 11-digit NIN" maxlength="11">
                                        <button type="button" id="verify-nin-btn" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors whitespace-nowrap disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                                            <span id="nin-verify-text">Verify NIN</span>
                                            <i id="nin-verify-icon" data-lucide="check-circle" class="h-4 w-4 ml-2 hidden text-green-500"></i>
                                            <i id="nin-loading-icon" data-lucide="loader" class="h-4 w-4 ml-2 hidden animate-spin"></i>
                                        </button>
                                    </div>
                                    <p id="nin-success-message" class="text-xs text-green-600 hidden">
                                        NIN verified successfully. Some fields have been auto-filled.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Corporate Tab -->
                        <div id="corporate-tab" class="tab-content hidden">
                            <div class="space-y-4 pt-4">
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700" for="company-name">1. Company Name</label>
                                    <input type="text" id="company-name" class="block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500 focus:ring-opacity-20 outline-none transition-colors" placeholder="Enter company name">
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700" for="rc-number">2. RC Number</label>
                                    <div class="flex space-x-2">
                                        <input type="text" id="rc-number" class="block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500 focus:ring-opacity-20 outline-none transition-colors" placeholder="Enter RC Number">
                                        <button type="button" id="verify-rc-btn" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors whitespace-nowrap disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                                            <span id="rc-verify-text">Verify RC</span>
                                            <i id="rc-verify-icon" data-lucide="check-circle" class="h-4 w-4 ml-2 hidden text-green-500"></i>
                                            <i id="rc-loading-icon" data-lucide="loader" class="h-4 w-4 ml-2 hidden animate-spin"></i>
                                        </button>
                                    </div>
                                    <p id="rc-success-message" class="text-xs text-green-600 hidden">
                                        RC Number verified successfully. Company details have been auto-filled.
                                    </p>
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700" for="tin">3. Tax Identification Number (TIN)</label>
                                    <div class="flex space-x-2">
                                        <input type="text" id="tin" class="block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500 focus:ring-opacity-20 outline-none transition-colors" placeholder="Enter TIN">
                                        <button type="button" id="verify-tin-btn" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors whitespace-nowrap disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                                            <span id="tin-verify-text">Verify TIN</span>
                                            <i id="tin-verify-icon" data-lucide="check-circle" class="h-4 w-4 ml-2 hidden text-green-500"></i>
                                            <i id="tin-loading-icon" data-lucide="loader" class="h-4 w-4 ml-2 hidden animate-spin"></i>
                                        </button>
                                    </div>
                                    <p id="tin-success-message" class="text-xs text-green-600 hidden">
                                        Tax Identification Number verified successfully.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Multiple Owners Tab -->
                        <div id="multiple-tab" class="tab-content hidden">
                            <div class="space-y-4 pt-4">
                                <div class="flex justify-between items-center">
                                    <h3 class="text-lg font-medium">Multiple Owners</h3>
                                    <button type="button" id="add-owner-btn" class="inline-flex items-center justify-center rounded-md bg-green-700 px-4 py-2 text-sm font-medium text-white hover:bg-primary-600 transition-colors">
                                        <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                                        Add Owner
                                    </button>
                                </div>
                                <div id="owners-list" class="space-y-4">
                                    <!-- Owners will be added dynamically -->
                                </div>
                                
                                <!-- Ownership Distribution Summary -->
                                <div id="ownership-summary" class="bg-gray-50 p-4 rounded-md hidden transition-all duration-200">
                                    <h4 class="font-medium mb-2">Ownership Summary</h4>
                                    <div id="ownership-breakdown" class="space-y-2 text-sm">
                                        <!-- Will be populated by JavaScript -->
                                    </div>
                                    <div class="border-t border-gray-200 pt-2 mt-2">
                                        <div class="flex justify-between font-medium">
                                            <span>Total Ownership:</span>
                                            <span id="total-ownership" class="transition-colors duration-200">0%</span>
                                        </div>
                                    </div>
                                    <div id="ownership-warning" class="text-red-600 text-sm mt-2 hidden">
                                        Warning: Total ownership must equal 100%
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Common Fields -->
                    <div class="space-y-4">
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700" for="address">Address</label>
                            <textarea id="address" class="block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500 focus:ring-opacity-20 outline-none transition-colors resize-vertical min-h-[80px]" placeholder="Enter address"></textarea>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700" for="phone">Phone Number</label>
                            <input type="tel" id="phone" class="block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500 focus:ring-opacity-20 outline-none transition-colors" placeholder="Enter phone number">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700" for="email">Email Address</label>
                            <input type="email" id="email" class="block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500 focus:ring-opacity-20 outline-none transition-colors" placeholder="Enter email address">
                        </div>

                        <!-- Ownership Type -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">Type Ownership Document(s) attached:</label>
                            <div class="space-y-2">
                                <div class="flex items-center gap-2">
                                    <input type="radio" name="ownership-type" value="inheritance" id="inheritance" class="w-4 h-4 border border-gray-300 rounded-full bg-white cursor-pointer">
                                    <label for="inheritance" class="text-sm text-gray-700">A. Inheritance</label>
                                </div>
                                <div class="flex items-center gap-2">
                                    <input type="radio" name="ownership-type" value="purchase" id="purchase" class="w-4 h-4 border border-gray-300 rounded-full bg-white cursor-pointer">
                                    <label for="purchase" class="text-sm text-gray-700">B. Purchase</label>
                                </div>
                                <div class="flex items-center gap-2">
                                    <input type="radio" name="ownership-type" value="gift" id="gift" class="w-4 h-4 border border-gray-300 rounded-full bg-white cursor-pointer">
                                    <label for="gift" class="text-sm text-gray-700">C. Gift</label>
                                </div>
                                <div class="flex items-center gap-2">
                                    <input type="radio" name="ownership-type" value="directLGA" id="directLGA" class="w-4 h-4 border border-gray-300 rounded-full bg-white cursor-pointer">
                                    <label for="directLGA" class="text-sm text-gray-700">D. Direct Local Government Allocation</label>
                                </div>
                                <div class="flex items-center gap-2">
                                    <input type="radio" name="ownership-type" value="others" id="othersOwnership" class="w-4 h-4 border border-gray-300 rounded-full bg-white cursor-pointer">
                                    <label for="othersOwnership" class="text-sm text-gray-700">E. Others (Specify)</label>
                                </div>
                            </div>
                            <input type="text" id="other-ownership-type" class="block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500 focus:ring-opacity-20 outline-none transition-colors mt-2 hidden" placeholder="Specify other ownership type">
                        </div>

                        <!-- Location -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700" for="location">Location of the parcel</label>
                                <input type="text" id="location" class="block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500 focus:ring-opacity-20 outline-none transition-colors" placeholder="Enter location">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700" for="lga">L.G.A</label>
                                <input type="text" id="lga" class="block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500 focus:ring-opacity-20 outline-none transition-colors" placeholder="Enter LGA">
                            </div>
                        </div>

                        <!-- Plot Details -->
                        <div class="space-y-4 mt-6">
                            <h4 class="font-medium">Plot Details</h4>
                            <div class="bg-gray-50 p-3 rounded-md">
                                <p class="text-sm text-gray-600 mb-2">
                                    Please provide the physical location details of the property.
                                </p>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700" for="plot-number">Plot Number</label>
                                        <input type="text" id="plot-number" class="block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500 focus:ring-opacity-20 outline-none transition-colors" placeholder="Enter plot number">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700" for="block-number">Block Number</label>
                                        <input type="text" id="block-number" class="block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500 focus:ring-opacity-20 outline-none transition-colors" placeholder="Enter block number">
                                    </div>
                                </div>
                                <div class="space-y-2 mt-4">
                                    <label class="block text-sm font-medium text-gray-700" for="street-name">Street Name</label>
                                    <input type="text" id="street-name" class="block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500 focus:ring-opacity-20 outline-none transition-colors" placeholder="Enter street name">
                                </div>
                            </div>
                        </div>

                        <!-- ARN Section -->
                        <div class="p-3 bg-gray-50 rounded-md mt-4">
                            <div class="flex justify-between items-center">
                                <label class="block text-sm font-medium text-gray-700">Application Reference Number (ARN):</label>
                                <button type="button" id="regenerate-arn-btn" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                                    <i data-lucide="refresh-cw" class="h-4 w-4 mr-1"></i>
                                    Regenerate
                                </button>
                            </div>
                            <div class="flex items-center mt-2">
                                <input type="text" id="arn" class="block w-full rounded-md border border-gray-300 px-3 py-2 text-sm bg-gray-100 font-mono" readonly>
                                <button type="button" id="copy-arn-btn" class="ml-2 inline-flex items-center justify-center rounded-md bg-transparent px-2 py-2 text-gray-700 hover:bg-gray-100 transition-colors">
                                    <i data-lucide="copy" class="h-4 w-4"></i>
                                </button>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">
                                Unique reference number linked to your file number for tracking your application
                            </p>
                        </div>

                        <!-- Commercial Purpose (if applicable) -->
                        <div id="commercial-purpose-section" class="space-y-2 hidden">
                            <label class="block text-sm font-medium text-gray-700" for="commercial-purpose">Commercial Purpose (Specify)</label>
                            <input type="text" id="commercial-purpose" class="block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500 focus:ring-opacity-20 outline-none transition-colors" placeholder="Specify commercial purpose">
                        </div>

                        <!-- Official Use Section -->
                        <div class="bg-gray-50 p-4 rounded-md mt-6">
                            <h4 class="font-bold text-center mb-4">FOR OFFICIAL USE ONLY</h4>
                            <div class="space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700" for="application-fee">Application fee</label>
                                        <input type="text" id="application-fee" class="block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500 focus:ring-opacity-20 outline-none transition-colors" placeholder="Enter fee amount">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700" for="payment-date">Payment date</label>
                                        <input type="date" id="payment-date" class="block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500 focus:ring-opacity-20 outline-none transition-colors">
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700" for="receipt-no">Receipt No.</label>
                                    <input type="text" id="receipt-no" class="block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500 focus:ring-opacity-20 outline-none transition-colors" placeholder="Enter receipt number">
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700" for="accountant-name">Revenue Accountant</label>
                                        <input type="text" id="accountant-name" class="block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500 focus:ring-opacity-20 outline-none transition-colors" placeholder="Enter accountant name">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700" for="official-date">Date</label>
                                        <input type="date" id="official-date" class="block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500 focus:ring-opacity-20 outline-none transition-colors">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 2: Fees and Documents -->
            <div id="step-2" class="step-content hidden">
                <div class="space-y-6">
                    <h3 class="text-lg font-medium">Fees and Charges</h3>

                    <!-- Fees Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr>
                                    <th class="w-12 p-3 text-left border-b border-gray-200 font-medium text-gray-600 text-sm bg-gray-50">No.</th>
                                    <th class="p-3 text-left border-b border-gray-200 font-medium text-gray-600 text-sm bg-gray-50">Description</th>
                                    <th class="p-3 text-right border-b border-gray-200 font-medium text-gray-600 text-sm bg-gray-50">Amount (₦)</th>
                                </tr>
                            </thead>
                            <tbody id="fees-table-body" class="divide-y divide-gray-200">
                                <!-- Fees will be populated by JavaScript -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Notes -->
                    <div class="bg-gray-50 p-4 rounded-md">
                        <h4 class="font-medium mb-2">NOTE:</h4>
                        <ul class="list-disc list-inside text-sm space-y-1">
                            <li>It is dangerous to attach forged documents.</li>
                            <li id="cac-note" class="hidden">Attach Photocopy of Ownership Document and CAC in case of Company.</li>
                        </ul>
                    </div>

                    <!-- Document Upload Section -->
                    <div class="space-y-4">
                        <h4 class="font-medium">Upload Required Documents</h4>
                        <div class="bg-gray-50 p-3 rounded-md">
                            <p class="text-sm text-gray-600">
                                Please upload the following required documents. All documents should be clear, legible, and in PDF, JPG, or PNG format.
                            </p>
                        </div>

                        <!-- Document Upload Areas -->
                        <div id="document-upload-container" class="space-y-4">
                            <!-- Documents will be populated by JavaScript -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 3: Payment -->
            <div id="step-3" class="step-content hidden">
                <div class="space-y-6">
                    <h3 class="text-lg font-medium">Payment</h3>
                    
                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                        <div class="p-6">
                            <div class="flex items-center gap-2 mb-4">
                                <i data-lucide="file-text" class="h-5 w-5"></i>
                                <h4 class="text-lg font-medium">Payment for SLTR Application</h4>
                            </div>
                            
                            <div class="flex flex-col md:flex-row gap-6">
                                <div class="flex-1 space-y-4">
                                    <div class="bg-gray-50 p-4 rounded-md">
                                        <h3 class="font-medium mb-2">Application Details</h3>
                                        <div class="space-y-2">
                                            <div class="flex items-center gap-2">
                                                <div id="property-type-icon" class="flex items-center justify-center">
                                                    <i data-lucide="home" class="h-6 w-6 text-blue-500"></i>
                                                </div>
                                                <div>
                                                    <p class="font-medium capitalize" id="payment-property-display">Residential Property</p>
                                                    <p class="text-sm text-gray-500">File Number: <span id="payment-file-display"></span></p>
                                                </div>
                                            </div>

                                            <div class="pt-2">
                                                <p class="text-sm">
                                                    <span class="font-medium">Applicant:</span> <span id="payment-applicant-display"></span>
                                                </p>
                                                <p class="text-sm">
                                                    <span class="font-medium">Applicant Type:</span> <span id="payment-type-display"></span>
                                                </p>
                                                <p class="text-sm">
                                                    <span class="font-medium">Application ID:</span> <span id="payment-app-id-display"></span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="bg-gray-50 p-4 rounded-md">
                                        <h3 class="font-medium mb-2">Payment Status</h3>
                                        <div id="payment-status-pending" class="flex items-center gap-2 text-amber-600">
                                            <div class="rounded-full bg-amber-100 p-1">
                                                <i data-lucide="credit-card" class="h-4 w-4"></i>
                                            </div>
                                            <span>Payment required to proceed</span>
                                        </div>
                                        <div id="payment-status-completed" class="flex items-center gap-2 text-green-600 hidden">
                                            <div class="rounded-full bg-green-100 p-1">
                                                <i data-lucide="check" class="h-4 w-4"></i>
                                            </div>
                                            <span>Payment completed successfully</span>
                                        </div>
                                    </div>

                                    <!-- Payment Summary -->
                                    <div class="bg-white p-4 rounded-md border border-gray-200">
                                        <h4 class="font-medium mb-3">Payment Summary</h4>
                                        <div id="payment-breakdown" class="space-y-2 text-sm">
                                            <!-- Payment breakdown will be populated by JavaScript -->
                                        </div>
                                        <div class="border-t border-gray-200 pt-2 mt-3">
                                            <div class="flex justify-between font-medium text-lg">
                                                <span>Total Amount:</span>
                                                <span id="payment-total-display" class="text-blue-600">₦0.00</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="md:w-80 space-y-4">
                                    <div class="bg-gray-50 p-4 rounded-md">
                                        <h3 class="font-medium mb-2">Next Steps</h3>
                                        <ul class="space-y-2">
                                            <li class="flex items-center gap-2">
                                                <div class="rounded-full bg-blue-100 p-1 flex-shrink-0">
                                                    <i data-lucide="credit-card" class="h-4 w-4 text-blue-600"></i>
                                                </div>
                                                <span class="text-sm">Complete payment for your application</span>
                                            </li>
                                            <li class="flex items-center gap-2">
                                                <div class="rounded-full bg-gray-100 p-1 flex-shrink-0">
                                                    <i data-lucide="file-text" class="h-4 w-4 text-gray-600"></i>
                                                </div>
                                                <span class="text-sm">Receive payment receipt</span>
                                            </li>
                                            <li class="flex items-center gap-2">
                                                <div class="rounded-full bg-gray-100 p-1 flex-shrink-0">
                                                    <i data-lucide="building" class="h-4 w-4 text-gray-600"></i>
                                                </div>
                                                <span class="text-sm">Application processing begins</span>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="bg-blue-50 p-4 rounded-md">
                                        <h3 class="font-medium text-blue-700 mb-2">Need Help?</h3>
                                        <p class="text-sm text-blue-600 mb-2">
                                            If you have any questions about the payment process, please contact our support team.
                                        </p>
                                        <p class="text-sm text-blue-600">
                                            <span class="font-medium">Phone:</span> 0800-SLTR-HELP
                                        </p>
                                        <p class="text-sm text-blue-600">
                                            <span class="font-medium">Email:</span> support@sltr.gov.ng
                                        </p>
                                    </div>

                                    <!-- Payment Methods -->
                                    <div class="bg-white p-4 rounded-md border border-gray-200">
                                        <h4 class="font-medium mb-3">Accepted Payment Methods</h4>
                                        <div class="grid grid-cols-2 gap-2">
                                            <div class="flex items-center gap-2 p-2 border border-gray-200 rounded">
                                                <i data-lucide="credit-card" class="h-4 w-4 text-blue-500"></i>
                                                <span class="text-xs">Card</span>
                                            </div>
                                            <div class="flex items-center gap-2 p-2 border border-gray-200 rounded">
                                                <i data-lucide="smartphone" class="h-4 w-4 text-green-500"></i>
                                                <span class="text-xs">Transfer</span>
                                            </div>
                                            <div class="flex items-center gap-2 p-2 border border-gray-200 rounded">
                                                <i data-lucide="building-2" class="h-4 w-4 text-purple-500"></i>
                                                <span class="text-xs">Bank</span>
                                            </div>
                                            <div class="flex items-center gap-2 p-2 border border-gray-200 rounded">
                                                <i data-lucide="wallet" class="h-4 w-4 text-orange-500"></i>
                                                <span class="text-xs">Wallet</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Action Buttons -->
                            <div class="flex justify-between pt-6 border-t border-gray-200">
                                <button type="button" id="payment-back-btn" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                                    <i data-lucide="arrow-left" class="h-4 w-4 mr-2"></i>
                                    Back
                                </button>

                                <div class="space-x-2">
                                    <button type="button" id="proceed-payment-btn" class="inline-flex items-center justify-center rounded-md bg-green-700 px-4 py-2 text-sm font-medium text-white hover:bg-primary-600 transition-colors">
                                        <i data-lucide="credit-card" class="h-4 w-4 mr-2"></i>
                                        Proceed to Payment
                                    </button>
                                    <button type="button" id="continue-after-payment-btn" class="inline-flex items-center justify-center rounded-md bg-green-700 px-4 py-2 text-sm font-medium text-white hover:bg-primary-600 transition-colors hidden">
                                        Continue
                                        <i data-lucide="arrow-right" class="h-4 w-4 ml-2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Modal -->
            <div id="payment-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 hidden z-50">
                <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto modal-content">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium">Complete Payment</h3>
                            <button type="button" id="close-payment-modal" class="inline-flex items-center justify-center rounded-md bg-transparent p-2 text-gray-700 hover:bg-gray-100 transition-colors">
                                <i data-lucide="x" class="h-4 w-4"></i>
                            </button>
                        </div>

                        <div class="space-y-6">
                            <!-- Payment Summary in Modal -->
                            <div class="bg-gray-50 p-4 rounded-md">
                                <h4 class="font-medium mb-3">Payment Summary</h4>
                                <div id="modal-payment-breakdown" class="space-y-2 text-sm">
                                    <!-- Will be populated by JavaScript -->
                                </div>
                                <div class="border-t border-gray-200 pt-2 mt-3">
                                    <div class="flex justify-between font-medium text-lg">
                                        <span>Total Amount:</span>
                                        <span id="modal-payment-total" class="text-blue-600">₦0.00</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Method Selection -->
                            <div class="space-y-4">
                                <h4 class="font-medium">Select Payment Method</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <button type="button" class="payment-method-btn p-4 border border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-colors" data-method="card">
                                        <div class="flex items-center gap-3">
                                            <i data-lucide="credit-card" class="h-6 w-6 text-blue-500"></i>
                                            <div class="text-left">
                                                <p class="font-medium">Debit/Credit Card</p>
                                                <p class="text-sm text-gray-500">Visa, Mastercard, Verve</p>
                                            </div>
                                        </div>
                                    </button>
                                    <button type="button" class="payment-method-btn p-4 border border-gray-200 rounded-lg hover:border-green-500 hover:bg-green-50 transition-colors" data-method="transfer">
                                        <div class="flex items-center gap-3">
                                            <i data-lucide="smartphone" class="h-6 w-6 text-green-500"></i>
                                            <div class="text-left">
                                                <p class="font-medium">Bank Transfer</p>
                                                <p class="text-sm text-gray-500">Direct bank transfer</p>
                                            </div>
                                        </div>
                                    </button>
                                    <button type="button" class="payment-method-btn p-4 border border-gray-200 rounded-lg hover:border-purple-500 hover:bg-purple-50 transition-colors" data-method="ussd">
                                        <div class="flex items-center gap-3">
                                            <i data-lucide="phone" class="h-6 w-6 text-purple-500"></i>
                                            <div class="text-left">
                                                <p class="font-medium">USSD</p>
                                                <p class="text-sm text-gray-500">*737# and others</p>
                                            </div>
                                        </div>
                                    </button>
                                    <button type="button" class="payment-method-btn p-4 border border-gray-200 rounded-lg hover:border-orange-500 hover:bg-orange-50 transition-colors" data-method="wallet">
                                        <div class="flex items-center gap-3">
                                            <i data-lucide="wallet" class="h-6 w-6 text-orange-500"></i>
                                            <div class="text-left">
                                                <p class="font-medium">Digital Wallet</p>
                                                <p class="text-sm text-gray-500">Paystack, Flutterwave</p>
                                            </div>
                                        </div>
                                    </button>
                                </div>
                            </div>

                            <!-- Payment Processing -->
                            <div id="payment-processing" class="hidden text-center py-8">
                                <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-blue-100">
                                    <i data-lucide="loader" class="h-6 w-6 text-blue-600 animate-spin"></i>
                                </div>
                                <h4 class="font-medium mb-2">Processing Payment</h4>
                                <p class="text-sm text-gray-600">Please wait while we process your payment...</p>
                            </div>

                            <!-- Payment Success -->
                            <div id="payment-success-modal" class="hidden text-center py-8">
                                <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-green-100">
                                    <i data-lucide="check" class="h-6 w-6 text-green-600"></i>
                                </div>
                                <h4 class="font-medium mb-2">Payment Successful!</h4>
                                <p class="text-sm text-gray-600 mb-4">Your payment has been processed successfully.</p>
                                <div class="bg-gray-50 p-4 rounded-md">
                                    <p class="text-sm"><span class="font-medium">Transaction ID:</span> <span id="transaction-id"></span></p>
                                    <p class="text-sm"><span class="font-medium">Receipt Number:</span> <span id="receipt-number"></span></p>
                                </div>
                            </div>

                            <!-- Modal Actions -->
                            <div class="flex justify-between pt-4 border-t border-gray-200">
                                <button type="button" id="modal-cancel-btn" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">Cancel</button>
                                <button type="button" id="process-payment-btn" class="inline-flex items-center justify-center rounded-md bg-green-700 px-4 py-2 text-sm font-medium text-white hover:bg-primary-600 transition-colors hidden">
                                    <span id="process-payment-text">Process Payment</span>
                                    <i id="process-payment-loading" data-lucide="loader" class="h-4 w-4 ml-2 hidden animate-spin"></i>
                                </button>
                                <button type="button" id="modal-continue-btn" class="inline-flex items-center justify-center rounded-md bg-green-700 px-4 py-2 text-sm font-medium text-white hover:bg-primary-600 transition-colors hidden">Continue</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 4: Review and Submit -->
            <div id="step-4" class="step-content hidden">
                <div class="space-y-6">
                    <h3 class="text-lg font-medium">Review and Submit</h3>

                    <div id="review-content" class="space-y-4">
                        <!-- Review content will be populated by JavaScript -->
                    </div>

                    <div class="flex items-center space-x-2">
                        <input type="checkbox" id="terms-checkbox" class="w-4 h-4 border border-gray-300 rounded bg-white cursor-pointer">
                        <label for="terms-checkbox" class="block text-sm font-medium text-gray-700">I agree to the terms and conditions</label>
                    </div>
                </div>
            </div>

            <!-- Success Screen -->
            <div id="success-screen" class="step-content hidden">
                <div class="flex flex-col items-center justify-center min-h-[300px]">
                    <div class="rounded-full bg-green-100 p-3 mb-4">
                        <i data-lucide="check" class="h-8 w-8 text-green-600"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-center mb-2">Application Submitted Successfully!</h2>
                    <p class="text-gray-500 text-center mb-6">
                        Your SLTR <span id="success-applicant-type">RESIDENTIAL</span> application has been submitted and is now being processed.
                    </p>
                    <p class="text-gray-700 font-medium mb-6">
                        File Number: <span id="success-file-number" class="font-mono"></span>
                    </p>
                    <button type="button" id="return-to-applications-btn" class="inline-flex items-center justify-center rounded-md bg-green-700 px-4 py-2 text-sm font-medium text-white hover:bg-primary-600 transition-colors">Return to Applications</button>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="p-6 border-t border-gray-200 flex justify-between">
            <button type="button" id="cancel-btn" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">Cancel</button>
            <div class="flex gap-2">
                <button type="button" id="previous-btn" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors hidden">
                    <i data-lucide="arrow-left" class="h-4 w-4 mr-2"></i>
                    Previous
                </button>
                <button type="button" id="next-btn" class="inline-flex items-center justify-center rounded-md bg-green-700 px-4 py-2 text-sm font-medium text-white hover:bg-primary-600 transition-colors">
                    Next
                    <i data-lucide="arrow-right" class="h-4 w-4 ml-2"></i>
                </button>
                <button type="button" id="submit-btn" class="inline-flex items-center justify-center rounded-md bg-green-700 px-4 py-2 text-sm font-medium text-white hover:bg-primary-600 transition-colors hidden">
                    <span id="submit-text">Submit Application</span>
                    <i id="submit-loading" data-lucide="loader" class="h-4 w-4 ml-2 hidden animate-spin"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Initialize Lucide icons
    lucide.createIcons();

    // State management
    let currentStep = 1;
    let applicantCategory = 'individual';
    let applicantType = 'residential';
    let owners = [];
    let ownerCounter = 0;
    let uploadedDocuments = {};
    let serialCounter = 1;
    let isSubmitting = false;
    let paymentCompleted = false;

    // Fee structures
    const feeStructures = {
        residential: {
            applicationForm: 2000,
            sitePlan: 5000,
            processingFee: 20000,
            bettermentFee: 18000,
            billBalance: 10000,
            feesP_D: 15000,
            surveyFee: 14000,
            squareMeterFee: 1,
            beaconFee: 2000
        },
        commercial: {
            applicationForm: 5000,
            sitePlan: 10000,
            processingFee: 50000,
            bettermentFee: 25000,
            billBalance: 20000,
            feesP_D: 29250,
            surveyFee: 14000,
            squareMeterFee: 1,
            beaconFee: 2000
        },
        warehouse: {
            applicationForm: 10000,
            sitePlan: 10000,
            processingFee: 100000,
            bettermentFee: 35000,
            billBalance: 20000,
            feesP_D: 22500,
            surveyFee: 14000,
            squareMeterFee: 1,
            beaconFee: 2000
        },
        agriculture: {
            applicationForm: 5000,
            sitePlan: 5000,
            processingFee: 50000,
            bettermentFee: 18000,
            billBalance: 10000,
            feesP_D: 25000,
            surveyFee: 14000,
            squareMeterFee: 1,
            beaconFee: 2000
        }
    };

    // DOM elements
    const elements = {
        applicantTypeDisplay: document.getElementById('applicant-type-display'),
        parcelId: document.getElementById('parcel-id'),
        fileNumber: document.getElementById('file-number'),
        arn: document.getElementById('arn'),
        stepNumbers: document.querySelectorAll('[data-step]'),
        stepConnectors: document.querySelectorAll('[data-connector]'),
        stepContents: document.querySelectorAll('.step-content'),
        tabTriggers: document.querySelectorAll('.tab-trigger'),
        tabContents: document.querySelectorAll('.tab-content'),
        previousBtn: document.getElementById('previous-btn'),
        nextBtn: document.getElementById('next-btn'),
        submitBtn: document.getElementById('submit-btn'),
        cancelBtn: document.getElementById('cancel-btn'),
        feesTableBody: document.getElementById('fees-table-body'),
        documentUploadContainer: document.getElementById('document-upload-container'),
        reviewContent: document.getElementById('review-content'),
        successScreen: document.getElementById('success-screen'),
        successApplicantType: document.getElementById('success-applicant-type'),
        successFileNumber: document.getElementById('success-file-number'),
        returnToApplicationsBtn: document.getElementById('return-to-applications-btn')
    };

    // Helper functions
    function generateParcelId() {
        const randomSixDigits = Math.floor(100000 + Math.random() * 900000);
        return `SLTR-${randomSixDigits}`;
    }

    function getLanduseCode() {
        const codes = {
            residential: 'RES',
            commercial: 'COM',
            warehouse: 'WAR',
            agriculture: 'AGR'
        };
        return codes[applicantType] || 'RES';
    }

    function generateFileNumber() {
        const currentYear = new Date().getFullYear().toString();
        const landuseCode = getLanduseCode();
        const serialNo = serialCounter.toString().padStart(2, '0');
        serialCounter++;
        return `SLTR-${landuseCode}-${currentYear}-${serialNo}`;
    }

    function generateARN() {
        const currentYear = new Date().getFullYear().toString();
        const landuseCode = getLanduseCode();
        const timestamp = Date.now().toString().slice(-6);
        const fileNumber = elements.fileNumber.value;
        
        let serialPart = '01';
        if (fileNumber) {
            const parts = fileNumber.split('-');
            if (parts.length === 4) {
                serialPart = parts[3];
            }
        }
        
        return `ARN-${landuseCode}-${currentYear}-${serialPart}-${timestamp}`;
    }

    function updateStepIndicator(step) {
        elements.stepNumbers.forEach((stepElement) => {
            const stepNumber = parseInt(stepElement.dataset.step);
            stepElement.classList.remove('bg-green-700', 'text-white', 'bg-green-500', 'bg-gray-200', 'text-gray-600');
            
            if (stepNumber === step) {
                stepElement.classList.add('bg-green-700', 'text-white');
            } else if (stepNumber < step) {
                stepElement.classList.add('bg-green-500', 'text-white');
                stepElement.innerHTML = '<i data-lucide="check" class="h-4 w-4"></i>';
            } else {
                stepElement.classList.add('bg-gray-200', 'text-gray-600');
                stepElement.textContent = stepNumber;
            }
        });

        elements.stepConnectors.forEach((connector) => {
            const connectorNumber = parseInt(connector.dataset.connector);
            connector.classList.remove('bg-green-500', 'bg-gray-200');
            
            if (connectorNumber < step) {
                connector.classList.add('bg-green-500');
            } else {
                connector.classList.add('bg-gray-200');
            }
        });

        // Re-initialize Lucide icons
        lucide.createIcons();
    }

    function showStep(step) {
        elements.stepContents.forEach((content, index) => {
            content.classList.add('hidden');
            if (index + 1 === step) {
                content.classList.remove('hidden');
            }
        });

        updateStepIndicator(step);
        currentStep = step;

        // Update navigation buttons
        elements.previousBtn.classList.toggle('hidden', step === 1);
        elements.nextBtn.classList.toggle('hidden', step === 4);
        elements.submitBtn.classList.toggle('hidden', step !== 4);

        // Update next button text based on step
        if (step === 3) {
            elements.nextBtn.innerHTML = 'Continue to Review <i data-lucide="arrow-right" class="h-4 w-4 ml-2"></i>';
        } else {
            elements.nextBtn.innerHTML = 'Next <i data-lucide="arrow-right" class="h-4 w-4 ml-2"></i>';
        }

        lucide.createIcons();
    }

    function switchTab(tabName) {
        applicantCategory = tabName;
        
        elements.tabTriggers.forEach(trigger => {
            trigger.classList.remove('bg-white', 'text-primary-600', 'shadow-sm');
            trigger.classList.add('text-gray-600', 'hover:text-gray-900');
            if (trigger.dataset.tab === tabName) {
                trigger.classList.remove('text-gray-600', 'hover:text-gray-900');
                trigger.classList.add('bg-white', 'text-primary-600', 'shadow-sm');
            }
        });

        elements.tabContents.forEach(content => {
            content.classList.add('hidden');
            if (content.id === `${tabName}-tab`) {
                content.classList.remove('hidden');
            }
        });

        // Show/hide passport photo container based on category
        const passportContainer = document.getElementById('passport-photo-container');
        passportContainer.style.display = tabName === 'individual' ? 'flex' : 'none';

        updateDocumentUploadSection();
    }

    function populateFeesTable() {
        const fees = feeStructures[applicantType];
        const tbody = elements.feesTableBody;
        tbody.innerHTML = '';

        const feeItems = [
            { name: 'Application Form', amount: fees.applicationForm },
            { name: 'Site plan', amount: fees.sitePlan },
            { name: 'Processing Fee', amount: fees.processingFee },
            { name: 'Betterment Fee', amount: fees.bettermentFee },
            { name: 'Bill Balance', amount: fees.billBalance },
            { name: 'Fees P & D', amount: fees.feesP_D },
            { name: 'Survey Fee', amount: fees.surveyFee }
        ];

        feeItems.forEach((item, index) => {
            const row = document.createElement('tr');
            row.className = 'hover:bg-gray-50 transition-colors';
            row.innerHTML = `
                <td class="p-3 border-b border-gray-200">${index + 1}</td>
                <td class="p-3 border-b border-gray-200">${item.name}</td>
                <td class="p-3 border-b border-gray-200 text-right">${item.amount.toLocaleString()}.00k</td>
            `;
            tbody.appendChild(row);
        });

        // Add additional fee notes
        const additionalRow1 = document.createElement('tr');
        additionalRow1.className = 'hover:bg-gray-50 transition-colors';
        additionalRow1.innerHTML = `
            <td class="p-3 border-b border-gray-200"></td>
            <td class="p-3 border-b border-gray-200">+ ₦${fees.squareMeterFee} per Square Meter</td>
            <td class="p-3 border-b border-gray-200 text-right"></td>
        `;
        tbody.appendChild(additionalRow1);

        const additionalRow2 = document.createElement('tr');
        additionalRow2.className = 'hover:bg-gray-50 transition-colors';
        additionalRow2.innerHTML = `
            <td class="p-3 border-b border-gray-200"></td>
            <td class="p-3 border-b border-gray-200">+ ₦${fees.beaconFee} per Beacon</td>
            <td class="p-3 border-b border-gray-200 text-right"></td>
        `;
        tbody.appendChild(additionalRow2);

        // Show CAC note for corporate/commercial
        const cacNote = document.getElementById('cac-note');
        if (applicantType === 'commercial' || applicantType === 'warehouse' || applicantCategory === 'corporate') {
            cacNote.classList.remove('hidden');
        } else {
            cacNote.classList.add('hidden');
        }
    }

    function updateDocumentUploadSection() {
        const container = elements.documentUploadContainer;
        container.innerHTML = '';

        const documents = [];

        // Add documents based on applicant category
        if (applicantCategory === 'individual') {
            documents.push({
                id: 'id-document',
                title: 'Personal Identification',
                label: 'ID Document',
                description: 'Upload a valid government-issued ID (National ID, Driver\'s License, Voter\'s Card, etc.)',
                required: true
            });
        } else if (applicantCategory === 'corporate') {
            documents.push({
                id: 'cac-document',
                title: 'Company Documentation',
                label: 'CAC Document',
                description: 'Upload the Certificate of Incorporation (CAC) document.',
                required: true
            });
        } else if (applicantCategory === 'multiple') {
            documents.push({
                id: 'multiple-id-document',
                title: 'Multiple Owners Identification',
                label: 'Consolidated ID Document',
                description: 'Upload a consolidated PDF containing all owners\' identification documents',
                required: true
            });
        }

        // Common documents
        documents.push(
            {
                id: 'ownership-document',
                title: 'Land Ownership Documents',
                label: 'Ownership Document',
                description: 'Upload document that proves ownership of the land (Deed of Assignment, Certificate of Occupancy, etc.)',
                required: true
            },
            {
                id: 'survey-plan-document',
                title: 'Survey Plan',
                label: 'Survey Plan Document',
                description: 'Upload the Survey Plan document.',
                required: true
            },
            {
                id: 'tax-receipt-document',
                title: 'Tax Clearance',
                label: 'Tax Receipt Document',
                description: 'Upload the Tax Receipt document.',
                required: true
            },
            {
                id: 'other-documents',
                title: 'Other Documents',
                label: 'Other Documents',
                description: 'Upload any other relevant documents.',
                required: false
            }
        );

        documents.forEach(doc => {
            const docSection = document.createElement('div');
            docSection.className = 'border border-gray-200 rounded-md p-4';
            docSection.innerHTML = `
                <h5 class="font-medium mb-3 text-gray-800">${doc.title}</h5>
                <div class="border border-gray-200 rounded-md p-3 mb-2 bg-white transition-colors" id="${doc.id}-container">
                    <div class="flex justify-between items-center mb-2">
                        <label class="text-sm font-medium">
                            ${doc.label} ${doc.required ? '<span class="text-red-500">*</span>' : ''}
                        </label>
                        <button type="button" class="inline-flex items-center justify-center rounded-md bg-transparent p-1 text-red-500 hover:text-red-600 transition-colors hidden" onclick="removeDocument('${doc.id}')">
                            <i data-lucide="x" class="h-4 w-4"></i>
                        </button>
                    </div>
                    <div id="${doc.id}-upload-area">
                        <input type="file" id="${doc.id}-input" class="block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500 focus:ring-opacity-20 outline-none transition-colors" accept=".pdf,.jpg,.jpeg,.png" onchange="handleDocumentUpload('${doc.id}', this)">
                        <p class="text-xs text-gray-500 mt-1">${doc.description}</p>
                    </div>
                    <div id="${doc.id}-uploaded" class="hidden">
                        <div class="flex items-center gap-2 text-sm">
                            <i data-lucide="file-text" class="h-4 w-4 text-blue-500"></i>
                            <div class="flex-1 min-w-0">
                                <p class="truncate font-medium" id="${doc.id}-filename"></p>
                                <p class="text-xs text-gray-500" id="${doc.id}-filesize"></p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            container.appendChild(docSection);
        });

        lucide.createIcons();
    }

    function handleDocumentUpload(documentId, input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            uploadedDocuments[documentId] = file;

            // Update UI
            const uploadArea = document.getElementById(`${documentId}-upload-area`);
            const uploadedArea = document.getElementById(`${documentId}-uploaded`);
            const filename = document.getElementById(`${documentId}-filename`);
            const filesize = document.getElementById(`${documentId}-filesize`);
            const container = document.getElementById(`${documentId}-container`);
            const removeBtn = container.querySelector('button');

            uploadArea.classList.add('hidden');
            uploadedArea.classList.remove('hidden');
            removeBtn.classList.remove('hidden');
            container.classList.add('bg-blue-50', 'border-blue-500');

            filename.textContent = file.name;
            filesize.textContent = formatFileSize(file.size);

            lucide.createIcons();
        }
    }

    function removeDocument(documentId) {
        delete uploadedDocuments[documentId];

        // Update UI
        const uploadArea = document.getElementById(`${documentId}-upload-area`);
        const uploadedArea = document.getElementById(`${documentId}-uploaded`);
        const container = document.getElementById(`${documentId}-container`);
        const removeBtn = container.querySelector('button');
        const input = document.getElementById(`${documentId}-input`);

        uploadArea.classList.remove('hidden');
        uploadedArea.classList.add('hidden');
        removeBtn.classList.add('hidden');
        container.classList.remove('bg-blue-50', 'border-blue-500');

        input.value = '';
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    function addOwner() {
        ownerCounter++;
        const ownerId = `owner-${ownerCounter}`;
        
        const ownerDiv = document.createElement('div');
        ownerDiv.className = 'border border-gray-200 rounded-md p-4 bg-white';
        ownerDiv.innerHTML = `
            <div class="flex justify-between items-start mb-4">
                <h4 class="text-lg font-medium">Owner ${ownerCounter}</h4>
                <div class="flex items-center gap-2">
                    <button type="button" class="inline-flex items-center justify-center rounded-md bg-red-500 px-2 py-1 text-xs font-medium text-white hover:bg-red-600 transition-colors" onclick="removeOwner('${ownerId}')">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                    <!-- Passport Photo Upload -->
                    <div class="border-2 border-dashed border-gray-300 rounded-md p-2 text-center w-20 h-28 flex flex-col items-center justify-center cursor-pointer hover:border-primary-500 hover:bg-primary-50 transition-colors">
                        <div id="${ownerId}-passport-placeholder" class="text-center">
                            <p class="text-xs text-gray-500 mb-1">PASSPORT PHOTO</p>
                            <div class="cursor-pointer" onclick="document.getElementById('${ownerId}-passport-upload').click()">
                                <div class="flex items-center justify-center bg-gray-100 rounded-md p-2 w-16 h-20">
                                    <i data-lucide="upload" class="h-4 w-4 text-gray-500"></i>
                                </div>
                            </div>
                            <input type="file" id="${ownerId}-passport-upload" accept="image/*" class="hidden" onchange="handleOwnerPassportUpload('${ownerId}', this)">
                        </div>
                        <div id="${ownerId}-passport-uploaded" class="text-center hidden">
                            <p class="text-xs text-green-600 font-medium">Photo uploaded</p>
                            <p id="${ownerId}-passport-filename" class="text-xs text-gray-500 mt-1"></p>
                            <button type="button" onclick="removeOwnerPassport('${ownerId}')" class="text-xs text-red-500 hover:text-red-600 mt-1 transition-colors">Remove</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="space-y-4">
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">1. Full Name *</label>
                    <input type="text" id="${ownerId}-name" class="block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500 focus:ring-opacity-20 outline-none transition-colors" required placeholder="Enter full name">
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">2. National Identity Number (NIN) *</label>
                    <div class="flex space-x-2">
                        <input type="text" id="${ownerId}-nin" class="block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500 focus:ring-opacity-20 outline-none transition-colors" maxlength="11" required placeholder="Enter 11-digit NIN" oninput="validateOwnerNIN('${ownerId}')">
                        <button type="button" id="${ownerId}-verify-btn" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50 transition-colors whitespace-nowrap disabled:opacity-50 disabled:cursor-not-allowed" onclick="verifyOwnerNIN('${ownerId}')" disabled>
                            <span id="${ownerId}-verify-text">Verify NIN</span>
                            <i id="${ownerId}-verify-icon" data-lucide="check-circle" class="h-4 w-4 ml-2 hidden text-green-500"></i>
                            <i id="${ownerId}-loading-icon" data-lucide="loader" class="h-4 w-4 ml-2 hidden animate-spin"></i>
                        </button>
                    </div>
                    <p id="${ownerId}-nin-success" class="text-xs text-green-600 hidden">
                        NIN verified successfully. Some fields have been auto-filled.
                    </p>
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">3. Address *</label>
                    <textarea id="${ownerId}-address" class="block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500 focus:ring-opacity-20 outline-none transition-colors resize-vertical min-h-[80px]" required placeholder="Enter address"></textarea>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">4. Phone Number *</label>
                        <input type="tel" id="${ownerId}-phone" class="block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500 focus:ring-opacity-20 outline-none transition-colors" required placeholder="Enter phone number">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">5. Email Address *</label>
                        <input type="email" id="${ownerId}-email" class="block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500 focus:ring-opacity-20 outline-none transition-colors" required placeholder="Enter email address">
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">6. Ownership Percentage *</label>
                    <div class="flex items-center space-x-2">
                        <input type="number" id="${ownerId}-percentage" class="block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500 focus:ring-opacity-20 outline-none transition-colors" min="0" max="100" step="0.01" required placeholder="0.00" oninput="updateOwnershipSummary()">
                        <span class="text-sm text-gray-500">%</span>
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">7. Relationship to Property</label>
                    <select id="${ownerId}-relationship" class="block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500 focus:ring-opacity-20 outline-none transition-colors">
                        <option value="">Select relationship</option>
                        <option value="spouse">Spouse</option>
                        <option value="child">Child</option>
                        <option value="parent">Parent</option>
                        <option value="sibling">Sibling</option>
                        <option value="business_partner">Business Partner</option>
                        <option value="investor">Investor</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div id="${ownerId}-other-relationship" class="space-y-2 hidden">
                    <label class="block text-sm font-medium text-gray-700">Specify Relationship</label>
                    <input type="text" id="${ownerId}-other-relationship-text" class="block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500 focus:ring-opacity-20 outline-none transition-colors" placeholder="Specify relationship">
                </div>
            </div>
        `;
        ownerDiv.id = ownerId;
        
        document.getElementById('owners-list').appendChild(ownerDiv);
        owners.push({ id: ownerId, counter: ownerCounter });
        
        // Add event listener for relationship dropdown
        document.getElementById(`${ownerId}-relationship`).addEventListener('change', function() {
            const otherDiv = document.getElementById(`${ownerId}-other-relationship`);
            if (this.value === 'other') {
                otherDiv.classList.remove('hidden');
            } else {
                otherDiv.classList.add('hidden');
            }
        });
        
        updateOwnershipSummary();
        lucide.createIcons();
    }

    function removeOwner(ownerId) {
        if (owners.length <= 1) {
            alert('At least one owner is required.');
            return;
        }
        
        const ownerElement = document.getElementById(ownerId);
        if (ownerElement) {
            ownerElement.remove();
            owners = owners.filter(owner => owner.id !== ownerId);
            updateOwnershipSummary();
        }
    }

    function validateOwnerNIN(ownerId) {
        const ninInput = document.getElementById(`${ownerId}-nin`);
        const verifyBtn = document.getElementById(`${ownerId}-verify-btn`);
        
        if (ninInput && verifyBtn) {
            verifyBtn.disabled = ninInput.value.length !== 11;
        }
    }

    function verifyOwnerNIN(ownerId) {
        const ninInput = document.getElementById(`${ownerId}-nin`);
        const verifyBtn = document.getElementById(`${ownerId}-verify-btn`);
        const verifyText = document.getElementById(`${ownerId}-verify-text`);
        const verifyIcon = document.getElementById(`${ownerId}-verify-icon`);
        const loadingIcon = document.getElementById(`${ownerId}-loading-icon`);
        const successMessage = document.getElementById(`${ownerId}-nin-success`);

        if (!ninInput || !ninInput.value || ninInput.value.length !== 11) return;

        verifyText.textContent = 'Verifying...';
        loadingIcon.classList.remove('hidden');
        verifyBtn.disabled = true;

        // Simulate API call
        setTimeout(() => {
            verifyText.textContent = 'Verified';
            loadingIcon.classList.add('hidden');
            verifyIcon.classList.remove('hidden');
            successMessage.classList.remove('hidden');

            // Auto-fill some fields if they're empty
            const nameInput = document.getElementById(`${ownerId}-name`);
            const phoneInput = document.getElementById(`${ownerId}-phone`);
            const emailInput = document.getElementById(`${ownerId}-email`);

            if (nameInput && !nameInput.value) {
                nameInput.value = `Owner ${ownerId.split('-')[1]}`;
            }
            if (phoneInput && !phoneInput.value) {
                phoneInput.value = `080${Math.floor(10000000 + Math.random() * 90000000)}`;
            }
            if (emailInput && !emailInput.value) {
                emailInput.value = `owner${ownerId.split('-')[1]}@example.com`;
            }
        }, 2000);
    }

    function handleOwnerPassportUpload(ownerId, input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const placeholder = document.getElementById(`${ownerId}-passport-placeholder`);
            const uploaded = document.getElementById(`${ownerId}-passport-uploaded`);
            const filename = document.getElementById(`${ownerId}-passport-filename`);

            placeholder.classList.add('hidden');
            uploaded.classList.remove('hidden');
            filename.textContent = file.name;
        }
    }

    function removeOwnerPassport(ownerId) {
        const placeholder = document.getElementById(`${ownerId}-passport-placeholder`);
        const uploaded = document.getElementById(`${ownerId}-passport-uploaded`);
        const input = document.getElementById(`${ownerId}-passport-upload`);

        placeholder.classList.remove('hidden');
        uploaded.classList.add('hidden');
        input.value = '';
    }

    function updateOwnershipSummary() {
        const summaryDiv = document.getElementById('ownership-summary');
        const breakdownDiv = document.getElementById('ownership-breakdown');
        const totalSpan = document.getElementById('total-ownership');
        const warningDiv = document.getElementById('ownership-warning');
        
        if (owners.length === 0) {
            summaryDiv.classList.add('hidden');
            return;
        }
        
        summaryDiv.classList.remove('hidden');
        
        let totalPercentage = 0;
        let breakdownHTML = '';
        
        owners.forEach((owner, index) => {
            const nameInput = document.getElementById(`${owner.id}-name`);
            const percentageInput = document.getElementById(`${owner.id}-percentage`);
            
            const name = nameInput ? nameInput.value || `Owner ${index + 1}` : `Owner ${index + 1}`;
            const percentage = percentageInput ? parseFloat(percentageInput.value) || 0 : 0;
            
            totalPercentage += percentage;
            
            breakdownHTML += `
                <div class="flex justify-between">
                    <span>${name}:</span>
                    <span>${percentage.toFixed(2)}%</span>
                </div>
            `;
        });
        
        breakdownDiv.innerHTML = breakdownHTML;
        totalSpan.textContent = `${totalPercentage.toFixed(2)}%`;
        
        // Show warning if total is not 100%
        if (Math.abs(totalPercentage - 100) > 0.01) {
            warningDiv.classList.remove('hidden');
            totalSpan.classList.add('text-red-600');
            totalSpan.classList.remove('text-green-600');
        } else {
            warningDiv.classList.add('hidden');
            totalSpan.classList.remove('text-red-600');
            totalSpan.classList.add('text-green-600');
        }
    }

    function verifyNIN() {
        const ninInput = document.getElementById('nin');
        const verifyBtn = document.getElementById('verify-nin-btn');
        const verifyText = document.getElementById('nin-verify-text');
        const verifyIcon = document.getElementById('nin-verify-icon');
        const loadingIcon = document.getElementById('nin-loading-icon');
        const successMessage = document.getElementById('nin-success-message');

        if (!ninInput.value || ninInput.value.length !== 11) return;

        verifyText.textContent = 'Verifying...';
        loadingIcon.classList.remove('hidden');
        verifyBtn.disabled = true;

        // Simulate API call
        setTimeout(() => {
            verifyText.textContent = 'Verified';
            loadingIcon.classList.add('hidden');
            verifyIcon.classList.remove('hidden');
            successMessage.classList.remove('hidden');

            // Auto-fill some fields
            if (!document.getElementById('applicant-name').value) {
                document.getElementById('applicant-name').value = 'John Doe';
            }
            if (!document.getElementById('phone').value) {
                document.getElementById('phone').value = '08012345678';
            }
            if (!document.getElementById('email').value) {
                document.getElementById('email').value = 'john.doe@example.com';
            }
        }, 2000);
    }

    function verifyRC() {
        const rcInput = document.getElementById('rc-number');
        const verifyBtn = document.getElementById('verify-rc-btn');
        const verifyText = document.getElementById('rc-verify-text');
        const verifyIcon = document.getElementById('rc-verify-icon');
        const loadingIcon = document.getElementById('rc-loading-icon');
        const successMessage = document.getElementById('rc-success-message');

        if (!rcInput.value || rcInput.value.length < 6) return;

        verifyText.textContent = 'Verifying...';
        loadingIcon.classList.remove('hidden');
        verifyBtn.disabled = true;

        // Simulate API call
        setTimeout(() => {
            verifyText.textContent = 'Verified';
            loadingIcon.classList.add('hidden');
            verifyIcon.classList.remove('hidden');
            successMessage.classList.remove('hidden');

            // Auto-fill some fields
            if (!document.getElementById('company-name').value) {
                document.getElementById('company-name').value = 'ABC Corporation Ltd';
            }
            if (!document.getElementById('phone').value) {
                document.getElementById('phone').value = '08011223344';
            }
            if (!document.getElementById('email').value) {
                document.getElementById('email').value = 'info@abccorp.com';
            }
        }, 2000);
    }

    function verifyTIN() {
        const tinInput = document.getElementById('tin');
        const verifyBtn = document.getElementById('verify-tin-btn');
        const verifyText = document.getElementById('tin-verify-text');
        const verifyIcon = document.getElementById('tin-verify-icon');
        const loadingIcon = document.getElementById('tin-loading-icon');
        const successMessage = document.getElementById('tin-success-message');

        if (!tinInput.value || tinInput.value.length < 10) return;

        verifyText.textContent = 'Verifying...';
        loadingIcon.classList.remove('hidden');
        verifyBtn.disabled = true;

        // Simulate API call
        setTimeout(() => {
            verifyText.textContent = 'Verified';
            loadingIcon.classList.add('hidden');
            verifyIcon.classList.remove('hidden');
            successMessage.classList.remove('hidden');
        }, 2000);
    }

    // Payment Integration Functions
    function updatePaymentDisplay() {
        const fees = feeStructures[applicantType];
        const totalAmount = Object.values(fees).reduce((sum, fee) => sum + fee, 0);

        // Update payment displays
        document.getElementById('payment-app-id-display').textContent = elements.parcelId.textContent;
        document.getElementById('payment-file-display').textContent = elements.fileNumber.value;
        document.getElementById('payment-property-display').textContent = `${applicantType.charAt(0).toUpperCase() + applicantType.slice(1)} Property`;
        document.getElementById('payment-type-display').textContent = applicantCategory.charAt(0).toUpperCase() + applicantCategory.slice(1);
        document.getElementById('payment-total-display').textContent = `₦${totalAmount.toLocaleString()}.00`;

        // Set applicant name based on category
        let applicantName = '';
        if (applicantCategory === 'individual') {
            applicantName = document.getElementById('applicant-name').value || 'Individual Applicant';
        } else if (applicantCategory === 'corporate') {
            applicantName = document.getElementById('company-name').value || 'Corporate Applicant';
        } else {
            applicantName = 'Multiple Owners';
        }
        document.getElementById('payment-applicant-display').textContent = applicantName;

        // Update property type icon
        const iconElement = document.querySelector('#property-type-icon i');
        const iconMap = {
            residential: 'home',
            commercial: 'building',
            warehouse: 'warehouse',
            agriculture: 'tractor'
        };
        iconElement.setAttribute('data-lucide', iconMap[applicantType] || 'home');

        // Generate payment breakdown
        generatePaymentBreakdown(fees);
        
        lucide.createIcons();
    }

    function generatePaymentBreakdown(fees) {
        const breakdownContainer = document.getElementById('payment-breakdown');
        const modalBreakdownContainer = document.getElementById('modal-payment-breakdown');
        
        let breakdownHTML = '';
        const feeItems = [
            { name: 'Application Form', amount: fees.applicationForm },
            { name: 'Site Plan', amount: fees.sitePlan },
            { name: 'Processing Fee', amount: fees.processingFee },
            { name: 'Betterment Fee', amount: fees.bettermentFee },
            { name: 'Bill Balance', amount: fees.billBalance },
            { name: 'Fees P & D', amount: fees.feesP_D },
            { name: 'Survey Fee', amount: fees.surveyFee },
            { name: 'Per Square Meter', amount: fees.squareMeterFee },
            { name: 'Per Beacon', amount: fees.beaconFee }
        ];

        feeItems.forEach(item => {
            breakdownHTML += `
                <div class="flex justify-between">
                    <span>${item.name}:</span>
                    <span>₦${item.amount.toLocaleString()}.00</span>
                </div>
            `;
        });

        breakdownContainer.innerHTML = breakdownHTML;
        modalBreakdownContainer.innerHTML = breakdownHTML;

        // Update modal total
        const totalAmount = Object.values(fees).reduce((sum, fee) => sum + fee, 0);
        document.getElementById('modal-payment-total').textContent = `₦${totalAmount.toLocaleString()}.00`;
    }

    function openPaymentModal() {
        document.getElementById('payment-modal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closePaymentModal() {
        document.getElementById('payment-modal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function selectPaymentMethod(method) {
        // Remove active state from all buttons
        document.querySelectorAll('.payment-method-btn').forEach(btn => {
            btn.classList.remove('border-blue-500', 'bg-blue-50');
        });

        // Add active state to selected button
        const selectedBtn = document.querySelector(`[data-method="${method}"]`);
        selectedBtn.classList.add('border-blue-500', 'bg-blue-50');

        // Show process payment button
        document.getElementById('process-payment-btn').classList.remove('hidden');
    }

    function processModalPayment() {
        const processBtn = document.getElementById('process-payment-btn');
        const processText = document.getElementById('process-payment-text');
        const processLoading = document.getElementById('process-payment-loading');
        const paymentProcessing = document.getElementById('payment-processing');

        // Hide payment methods and show processing
        document.querySelector('.grid').classList.add('hidden');
        processBtn.classList.add('hidden');
        paymentProcessing.classList.remove('hidden');

        // Simulate payment processing
        setTimeout(() => {
            paymentProcessing.classList.add('hidden');
            
            // Show success
            const paymentSuccess = document.getElementById('payment-success-modal');
            paymentSuccess.classList.remove('hidden');
            
            // Generate transaction details
            const transactionId = 'TXN' + Date.now().toString().slice(-8);
            const receiptNumber = 'RCP' + Math.floor(100000 + Math.random() * 900000);
            
            document.getElementById('transaction-id').textContent = transactionId;
            document.getElementById('receipt-number').textContent = receiptNumber;
            
            // Show continue button
            document.getElementById('modal-continue-btn').classList.remove('hidden');
            
            lucide.createIcons();
        }, 3000);
    }

    function completePayment() {
        // Update payment status in main form
        document.getElementById('payment-status-pending').classList.add('hidden');
        document.getElementById('payment-status-completed').classList.remove('hidden');
        
        // Update buttons
        document.getElementById('proceed-payment-btn').classList.add('hidden');
        document.getElementById('continue-after-payment-btn').classList.remove('hidden');
        
        // Set payment completed flag
        paymentCompleted = true;
        
        // Close modal
        closePaymentModal();
        
        lucide.createIcons();
    }

    function generateReviewContent() {
        let reviewHTML = '';

        // Applicant Information
        reviewHTML += '<div class="bg-gray-50 p-4 rounded-md"><h4 class="font-medium mb-4">Applicant Information</h4>';
        
        if (applicantCategory === 'individual') {
            const name = document.getElementById('applicant-name').value;
            const nin = document.getElementById('nin').value;
            const address = document.getElementById('address').value;
            const phone = document.getElementById('phone').value;
            const email = document.getElementById('email').value;

            reviewHTML += `
                <div class="space-y-2">
                    <p><span class="font-medium">Name:</span> ${name}</p>
                    <p><span class="font-medium">NIN:</span> ${nin}</p>
                    <p><span class="font-medium">Address:</span> ${address}</p>
                    <p><span class="font-medium">Phone:</span> ${phone}</p>
                    <p><span class="font-medium">Email:</span> ${email}</p>
                </div>
            `;
        } else if (applicantCategory === 'corporate') {
            const companyName = document.getElementById('company-name').value;
            const rcNumber = document.getElementById('rc-number').value;
            const tin = document.getElementById('tin').value;
            const address = document.getElementById('address').value;
            const phone = document.getElementById('phone').value;
            const email = document.getElementById('email').value;

            reviewHTML += `
                <div class="space-y-2">
                    <p><span class="font-medium">Company Name:</span> ${companyName}</p>
                    <p><span class="font-medium">RC Number:</span> ${rcNumber}</p>
                    <p><span class="font-medium">TIN:</span> ${tin}</p>
                    <p><span class="font-medium">Address:</span> ${address}</p>
                    <p><span class="font-medium">Phone:</span> ${phone}</p>
                    <p><span class="font-medium">Email:</span> ${email}</p>
                </div>
            `;
        } else if (applicantCategory === 'multiple') {
            reviewHTML += '<div class="space-y-2"><h3 class="font-medium">Multiple Owners</h3>';
            owners.forEach((owner, index) => {
                const name = document.getElementById(`${owner.id}-name`)?.value || '';
                const nin = document.getElementById(`${owner.id}-nin`)?.value || '';
                const address = document.getElementById(`${owner.id}-address`)?.value || '';
                const phone = document.getElementById(`${owner.id}-phone`)?.value || '';
                const email = document.getElementById(`${owner.id}-email`)?.value || '';
                const percentage = document.getElementById(`${owner.id}-percentage`)?.value || '';

                reviewHTML += `
                    <div class="pl-4 border-l-2 border-gray-200 mb-2">
                        <p><span class="font-medium">Owner ${index + 1}:</span> ${name}</p>
                        <p><span class="font-medium">NIN:</span> ${nin}</p>
                        <p><span class="font-medium">Address:</span> ${address}</p>
                        <p><span class="font-medium">Phone:</span> ${phone}</p>
                        <p><span class="font-medium">Email:</span> ${email}</p>
                        <p><span class="font-medium">Ownership Percentage:</span> ${percentage}%</p>
                    </div>
                `;
            });
            reviewHTML += '</div>';
        }

        // Property Information
        const location = document.getElementById('location').value;
        const lga = document.getElementById('lga').value;
        const plotNumber = document.getElementById('plot-number').value;
        const blockNumber = document.getElementById('block-number').value;
        const streetName = document.getElementById('street-name').value;

        reviewHTML += `
            <div class="mt-4">
                <p><span class="font-medium">Location:</span> ${location}</p>
                <p><span class="font-medium">LGA:</span> ${lga}</p>
                <p><span class="font-medium">Plot Number:</span> ${plotNumber}</p>
                <p><span class="font-medium">Block Number:</span> ${blockNumber}</p>
                <p><span class="font-medium">Street Name:</span> ${streetName}</p>
            </div>
        `;

        reviewHTML += '</div>';

        // Uploaded Documents
        reviewHTML += '<div class="bg-gray-50 p-4 rounded-md"><h4 class="font-medium mb-4">Uploaded Documents</h4>';
        if (Object.keys(uploadedDocuments).length > 0) {
            reviewHTML += '<div class="space-y-2">';
            Object.entries(uploadedDocuments).forEach(([docId, file]) => {
                const docName = docId.replace(/-/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                reviewHTML += `<p><span class="font-medium">${docName}:</span> ${file.name}</p>`;
            });
            reviewHTML += '</div>';
        } else {
            reviewHTML += '<p class="text-gray-500">No documents uploaded</p>';
        }
        reviewHTML += '</div>';

        elements.reviewContent.innerHTML = reviewHTML;
    }

    function submitApplication() {
        const submitBtn = elements.submitBtn;
        const submitText = document.getElementById('submit-text');
        const submitLoading = document.getElementById('submit-loading');

        isSubmitting = true;
        submitBtn.disabled = true;
        submitText.classList.add('hidden');
        submitLoading.classList.remove('hidden');

        // Simulate form submission
        setTimeout(() => {
            // Show success screen
            elements.stepContents.forEach(content => content.classList.add('hidden'));
            elements.successScreen.classList.remove('hidden');
            
            elements.successApplicantType.textContent = applicantType.toUpperCase();
            elements.successFileNumber.textContent = elements.fileNumber.value;

            isSubmitting = false;
        }, 2000);
    }

    function validateStep(step) {
        // Basic validation - can be expanded
        if (step === 1) {
            if (applicantCategory === 'individual') {
                const name = document.getElementById('applicant-name').value;
                const nin = document.getElementById('nin').value;
                if (!name || !nin) {
                    alert('Please fill in all required fields.');
                    return false;
                }
            } else if (applicantCategory === 'corporate') {
                const companyName = document.getElementById('company-name').value;
                const rcNumber = document.getElementById('rc-number').value;
                if (!companyName || !rcNumber) {
                    alert('Please fill in all required fields.');
                    return false;
                }
            } else if (applicantCategory === 'multiple') {
                if (owners.length === 0) {
                    alert('Please add at least one owner.');
                    return false;
                }
                
                // Validate each owner
                for (const owner of owners) {
                    const name = document.getElementById(`${owner.id}-name`).value;
                    const nin = document.getElementById(`${owner.id}-nin`).value;
                    const address = document.getElementById(`${owner.id}-address`).value;
                    const phone = document.getElementById(`${owner.id}-phone`).value;
                    const email = document.getElementById(`${owner.id}-email`).value;
                    const percentage = document.getElementById(`${owner.id}-percentage`).value;
                    
                    if (!name || !nin || !address || !phone || !email || !percentage) {
                        alert(`Please fill in all required fields for all owners.`);
                        return false;
                    }
                }
                
                // Validate ownership percentages
                let totalPercentage = 0;
                owners.forEach(owner => {
                    const percentageInput = document.getElementById(`${owner.id}-percentage`);
                    totalPercentage += parseFloat(percentageInput.value) || 0;
                });
                
                if (Math.abs(totalPercentage - 100) > 0.01) {
                    alert('Total ownership percentage must equal 100%.');
                    return false;
                }
            }
        } else if (step === 3) {
            if (!paymentCompleted) {
                alert('Please complete the payment before proceeding.');
                return false;
            }
        } else if (step === 4) {
            const termsCheckbox = document.getElementById('terms-checkbox');
            if (!termsCheckbox.checked) {
                alert('Please accept the terms and conditions.');
                return false;
            }
        }
        return true;
    }

    // Global functions for onclick handlers
    window.removeOwner = removeOwner;
    window.removeDocument = removeDocument;
    window.handleDocumentUpload = handleDocumentUpload;
    window.verifyOwnerNIN = verifyOwnerNIN;
    window.removeOwnerPassport = removeOwnerPassport;
    window.handleOwnerPassportUpload = handleOwnerPassportUpload;
    window.validateOwnerNIN = validateOwnerNIN;
    window.updateOwnershipSummary = updateOwnershipSummary;

    // Event listeners
    elements.tabTriggers.forEach(trigger => {
        trigger.addEventListener('click', () => {
            switchTab(trigger.dataset.tab);
        });
    });

    document.getElementById('add-owner-btn').addEventListener('click', addOwner);

    document.getElementById('regenerate-file-btn').addEventListener('click', () => {
        elements.fileNumber.value = generateFileNumber();
        elements.arn.value = generateARN();
    });

    document.getElementById('regenerate-arn-btn').addEventListener('click', () => {
        elements.arn.value = generateARN();
    });

    document.getElementById('copy-arn-btn').addEventListener('click', () => {
        navigator.clipboard.writeText(elements.arn.value).then(() => {
            alert('ARN copied to clipboard!');
        });
    });

    document.getElementById('verify-nin-btn').addEventListener('click', verifyNIN);
    document.getElementById('verify-rc-btn').addEventListener('click', verifyRC);
    document.getElementById('verify-tin-btn').addEventListener('click', verifyTIN);

    // NIN input validation
    document.getElementById('nin').addEventListener('input', (e) => {
        const verifyBtn = document.getElementById('verify-nin-btn');
        verifyBtn.disabled = e.target.value.length !== 11;
    });

    // RC Number input validation
    document.getElementById('rc-number').addEventListener('input', (e) => {
        const verifyBtn = document.getElementById('verify-rc-btn');
        verifyBtn.disabled = e.target.value.length < 6;
    });

    // TIN input validation
    document.getElementById('tin').addEventListener('input', (e) => {
        const verifyBtn = document.getElementById('verify-tin-btn');
        verifyBtn.disabled = e.target.value.length < 10;
    });

    // Ownership type radio buttons
    document.querySelectorAll('input[name="ownership-type"]').forEach(radio => {
        radio.addEventListener('change', (e) => {
            const otherInput = document.getElementById('other-ownership-type');
            if (e.target.value === 'others') {
                otherInput.classList.remove('hidden');
            } else {
                otherInput.classList.add('hidden');
            }
        });
    });

    // Passport photo upload
    document.getElementById('passport-upload').addEventListener('change', (e) => {
        if (e.target.files && e.target.files[0]) {
            const file = e.target.files[0];
            const placeholder = document.getElementById('passport-placeholder');
            const uploaded = document.getElementById('passport-uploaded');
            const filename = document.getElementById('passport-filename');

            placeholder.classList.add('hidden');
            uploaded.classList.remove('hidden');
            filename.textContent = file.name;
        }
    });

    document.getElementById('passport-photo-container').addEventListener('click', () => {
        document.getElementById('passport-upload').click();
    });

    // Payment event listeners
    document.getElementById('proceed-payment-btn').addEventListener('click', openPaymentModal);
    document.getElementById('payment-back-btn').addEventListener('click', () => showStep(2));
    document.getElementById('continue-after-payment-btn').addEventListener('click', () => {
        generateReviewContent();
        showStep(4);
    });

    // Payment modal event listeners
    document.getElementById('close-payment-modal').addEventListener('click', closePaymentModal);
    document.getElementById('modal-cancel-btn').addEventListener('click', closePaymentModal);
    document.getElementById('modal-continue-btn').addEventListener('click', completePayment);
    document.getElementById('process-payment-btn').addEventListener('click', processModalPayment);

    // Payment method selection
    document.querySelectorAll('.payment-method-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            selectPaymentMethod(btn.dataset.method);
        });
    });

    // Close modal when clicking outside
    document.getElementById('payment-modal').addEventListener('click', (e) => {
        if (e.target.id === 'payment-modal') {
            closePaymentModal();
        }
    });

    // Navigation buttons
    elements.nextBtn.addEventListener('click', () => {
        if (validateStep(currentStep)) {
            if (currentStep === 2) {
                updatePaymentDisplay();
            } else if (currentStep === 3) {
                generateReviewContent();
            }
            showStep(currentStep + 1);
        }
    });

    elements.previousBtn.addEventListener('click', () => {
        showStep(currentStep - 1);
    });

    elements.submitBtn.addEventListener('click', () => {
        if (validateStep(currentStep)) {
            submitApplication();
        }
    });

    elements.cancelBtn.addEventListener('click', () => {
        if (confirm('Are you sure you want to cancel? All entered data will be lost.')) {
            window.location.href = '/';
        }
    });

    elements.returnToApplicationsBtn.addEventListener('click', () => {
        window.location.href = '/';
    });

    // Initialize the form
    function init() {
        // Generate initial IDs
        elements.parcelId.textContent = generateParcelId();
        elements.fileNumber.value = generateFileNumber();
        elements.arn.value = generateARN();
        
        // Set initial applicant type
        elements.applicantTypeDisplay.textContent = applicantType.toUpperCase();
        
        // Show commercial purpose section if applicable
        if (applicantType === 'commercial') {
            document.getElementById('commercial-purpose-section').classList.remove('hidden');
        }
        
        // Initialize step 1
        showStep(1);
        switchTab('individual');
        populateFeesTable();
        updateDocumentUploadSection();
        
        lucide.createIcons();
    }

    // Initialize when DOM is loaded
    document.addEventListener('DOMContentLoaded', init);
</script>





        </div>
        <!-- Footer -->
        @include('admin.footer')
    </div>
    
    @include('sltr_approval.partial.deeds_js')
@endsection
