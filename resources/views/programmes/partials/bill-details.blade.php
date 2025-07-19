<div class="bill-details">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Bill Information -->
        <div class="bg-gray-50 rounded-lg p-4">
            <h4 class="text-lg font-semibold text-gray-900 mb-3">Bill Information</h4>
            <div class="space-y-2">
                <div class="flex justify-between">
                    <span class="text-gray-600">Bill ID:</span>
                    <span class="font-medium">{{ $bill->id }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Bill Type:</span>
                    <span class="font-medium">{{ ucfirst($type) }} Bill</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Created Date:</span>
                    <span class="font-medium">{{ $bill->created_at ? \Carbon\Carbon::parse($bill->created_at)->format('M d, Y') : 'N/A' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Status:</span>
                    <span class="font-medium">
                        @if($type === 'balance')
                            {{ ucfirst($bill->bill_status ?? 'Unknown') }}
                        @else
                            {{ $bill->Payment_Status ?? 'Unknown' }}
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <!-- Application Information -->
        <div class="bg-gray-50 rounded-lg p-4">
            <h4 class="text-lg font-semibold text-gray-900 mb-3">Application Information</h4>
            <div class="space-y-2">
                <div class="flex justify-between">
                    <span class="text-gray-600">File No:</span>
                    <span class="font-medium">{{ $bill->primary_fileno ?? $bill->unit_fileno ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Owner:</span>
                    <span class="font-medium">
                        @if(!empty($bill->primary_corporate_name) || !empty($bill->unit_corporate_name))
                            {{ $bill->primary_corporate_name ?? $bill->unit_corporate_name }}
                        @else
                            {{ trim(($bill->primary_first_name ?? $bill->unit_first_name) . ' ' . ($bill->primary_surname ?? $bill->unit_surname)) }}
                        @endif
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Property Location:</span>
                    <span class="font-medium">{{ $bill->primary_property_street ?? $bill->unit_property_location ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">LGA:</span>
                    <span class="font-medium">{{ $bill->primary_property_lga ?? 'N/A' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Bill Items -->
    <div class="bg-white border rounded-lg overflow-hidden">
        <div class="bg-gray-50 px-6 py-3 border-b">
            <h4 class="text-lg font-semibold text-gray-900">Bill Items</h4>
        </div>
        <div class="p-6">
            <div class="space-y-3">
                @if($type === 'initial')
                    @if($bill->Scheme_Application_Fee)
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-gray-700">Scheme Application Fee</span>
                            <span class="font-semibold">₦{{ number_format($bill->Scheme_Application_Fee, 2) }}</span>
                        </div>
                    @endif
                    @if($bill->Site_Plan_Fee)
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-gray-700">Site Plan Fee</span>
                            <span class="font-semibold">₦{{ number_format($bill->Site_Plan_Fee, 2) }}</span>
                        </div>
                    @endif
                    @if($bill->Unit_Application_Fees)
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-gray-700">Unit Application Fee</span>
                            <span class="font-semibold">₦{{ number_format($bill->Unit_Application_Fees, 2) }}</span>
                        </div>
                    @endif
                @elseif($type === 'betterment')
                    @if($bill->Betterment_Charges)
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-gray-700">Betterment Charges</span>
                            <span class="font-semibold">₦{{ number_format($bill->Betterment_Charges, 2) }}</span>
                        </div>
                    @endif
                    @if($bill->Land_Use_Charge)
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-gray-700">Land Use Charge</span>
                            <span class="font-semibold">₦{{ number_format($bill->Land_Use_Charge, 2) }}</span>
                        </div>
                    @endif
                    @if($bill->Processing_Fee)
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-gray-700">Processing Fee</span>
                            <span class="font-semibold">₦{{ number_format($bill->Processing_Fee, 2) }}</span>
                        </div>
                    @endif
                @elseif($type === 'balance')
                    @if($bill->processing_fee)
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-gray-700">Processing Fee</span>
                            <span class="font-semibold">₦{{ number_format($bill->processing_fee, 2) }}</span>
                        </div>
                    @endif
                    @if($bill->survey_fee)
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-gray-700">Survey Fee</span>
                            <span class="font-semibold">₦{{ number_format($bill->survey_fee, 2) }}</span>
                        </div>
                    @endif
                    @if($bill->assignment_fee)
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-gray-700">Assignment Fee</span>
                            <span class="font-semibold">₦{{ number_format($bill->assignment_fee, 2) }}</span>
                        </div>
                    @endif
                    @if($bill->bill_balance)
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-gray-700">Bill Balance</span>
                            <span class="font-semibold">₦{{ number_format($bill->bill_balance, 2) }}</span>
                        </div>
                    @endif
                @endif
            </div>

            <!-- Total -->
            <div class="mt-6 pt-4 border-t-2 border-gray-200">
                <div class="flex justify-between items-center">
                    <span class="text-xl font-bold text-gray-900">Total Amount:</span>
                    <span class="text-2xl font-bold text-blue-600">
                        @if($type === 'initial')
                            ₦{{ number_format(($bill->Scheme_Application_Fee ?? 0) + ($bill->Site_Plan_Fee ?? 0) + ($bill->Unit_Application_Fees ?? 0), 2) }}
                        @elseif($type === 'betterment')
                            ₦{{ number_format(($bill->Betterment_Charges ?? 0) + ($bill->Land_Use_Charge ?? 0) + ($bill->Processing_Fee ?? 0), 2) }}
                        @elseif($type === 'balance')
                            ₦{{ number_format($bill->total_amount ?? 0, 2) }}
                        @endif
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="mt-6 flex gap-3">
        <button onclick="printBill('{{ $type }}', '{{ $bill->id }}')" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700">
            <i data-lucide="printer" class="w-4 h-4 mr-2"></i>
            Print Bill
        </button>
        <button onclick="downloadBill('{{ $type }}', '{{ $bill->id }}')" class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700">
            <i data-lucide="download" class="w-4 h-4 mr-2"></i>
            Download PDF
        </button>
    </div>
</div>