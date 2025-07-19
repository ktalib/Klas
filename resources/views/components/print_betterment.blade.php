<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Betterment Bill Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
            background-color: #fff;
        }
        .receipt-container {
            max-width: 800px;
            margin: 0 auto;
            border: 2px solid #166534;
            padding: 30px;
            position: relative;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #166534;
            padding-bottom: 20px;
        }
        .logo {
            width: 80px;
            height: 80px;
        }
        .title {
            text-align: center;
            flex-grow: 1;
        }
        .title h1 {
            font-size: 18px;
            color: #166534;
            margin: 0;
            font-weight: bold;
        }
        .title h2 {
            font-size: 16px;
            color: #dc2626;
            margin: 5px 0 0;
            font-weight: bold;
        }
        .receipt-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 12px;
        }
        .receipt-info div {
            text-align: center;
        }
        .receipt-info .label {
            font-weight: bold;
            color: #166534;
        }
        .property-details {
            margin-bottom: 30px;
            background-color: #f9fafb;
            padding: 20px;
            border-radius: 8px;
        }
        .property-details h3 {
            color: #166534;
            margin-top: 0;
            font-size: 14px;
        }
        .details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            font-size: 12px;
        }
        .details-grid p {
            margin: 5px 0;
        }
        .details-grid .label {
            font-weight: bold;
            color: #374151;
        }
        .calculation-section {
            margin-bottom: 30px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            overflow: hidden;
        }
        .calculation-header {
            background-color: #166534;
            color: white;
            padding: 15px;
            font-weight: bold;
            text-align: center;
        }
        .calculation-body {
            padding: 20px;
        }
        .calculation-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e5e7eb;
            font-size: 14px;
        }
        .calculation-row:last-child {
            border-bottom: none;
            font-weight: bold;
            font-size: 16px;
            background-color: #f3f4f6;
            margin: 10px -20px -20px;
            padding: 15px 20px;
        }
        .calculation-row .label {
            color: #374151;
        }
        .calculation-row .value {
            color: #166534;
            font-weight: bold;
        }
        .footer-notes {
            margin-top: 30px;
            font-size: 12px;
            background-color: #fef3c7;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #f59e0b;
        }
        .footer-notes h4 {
            color: #92400e;
            margin-top: 0;
        }
        .footer-notes p {
            margin: 8px 0;
        }
        .signature-section {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
        }
        .signature-box {
            text-align: center;
            width: 200px;
        }
        .signature-line {
            border-top: 1px solid #000;
            margin-top: 50px;
            padding-top: 5px;
            font-size: 12px;
        }
        @media print {
            body {
                padding: 0;
                background-color: #fff;
            }
            .receipt-container {
                border: 2px solid #166534;
                padding: 20px;
                max-width: 100%;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <!-- Header with logos and title -->
        <div class="header">
            <img src="{{ asset('assets/logo/logo1.jpg') }}" alt="Kano State Logo" class="logo">
            <div class="title">
                <h1>KANO STATE MINISTRY OF LAND AND PHYSICAL PLANNING</h1>
                <h2>BETTERMENT CHARGES BILL</h2>
            </div>
            <img src="{{ asset('assets/logo/logo3.jpeg') }}" alt="Ministry Logo" class="logo">
        </div>
        
        <!-- Receipt Information -->
        <div class="receipt-info">
            <div>
                <div class="label">Bill Reference</div>
                <div>{{ $bill->ref_id ?? 'BB-' . $application->id . '-' . date('Ymd') }}</div>
            </div>
            <div>
                <div class="label">Date Generated</div>
                <div>{{ \Carbon\Carbon::parse($bill->created_at ?? now())->format('d/m/Y') }}</div>
            </div>
            <div>
                <div class="label">File Number</div>
                <div>{{ $application->fileno ?? 'N/A' }}</div>
            </div>
        </div>
        
        <!-- Property Details -->
        <div class="property-details">
            <h3>Property & Owner Details</h3>
            <div class="details-grid">
                <div>
                    <p><span class="label">Application ID:</span> {{ $application->id }}</p>
                    <p><span class="label">Owner Name:</span> 
                        @if(!empty($application->corporate_name))
                            {{ $application->corporate_name }}
                        @elseif(!empty($application->multiple_owners_names))
                            {{ $application->multiple_owners_names }}
                        @else
                            {{ $application->applicant_title ?? '' }} {{ $application->first_name ?? '' }} {{ $application->surname ?? '' }}
                        @endif
                    </p>
                    <p><span class="label">Property Size:</span> {{ $application->property_size ?? 'N/A' }} sqm</p>
                    <p><span class="label">Land Use:</span> {{ $application->land_use ?? 'N/A' }}</p>
                </div>
                <div>
                    <p><span class="label">Property Location:</span> 
                        {{ $application->property_house_no ?? '' }} 
                        {{ $application->property_plot_no ?? '' }}, 
                        {{ $application->property_street_name ?? '' }}, 
                        {{ $application->property_district ?? '' }}, 
                        {{ $application->property_lga ?? '' }}
                    </p>
                    <p><span class="label">Number of Units:</span> {{ $application->NoOfUnits ?? 'N/A' }}</p>
                    <p><span class="label">Sectional Title File:</span> {{ $bill->Sectional_Title_File_No ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
        
        <!-- Calculation Section -->
        <div class="calculation-section">
            <div class="calculation-header">
                BETTERMENT CHARGES CALCULATION
            </div>
            <div class="calculation-body">
                <div class="calculation-row">
                    <span class="label">Property Value:</span>
                    <span class="value">₦ {{ number_format($bill->property_value ?? 0, 2) }}</span>
                </div>
                <div class="calculation-row">
                    <span class="label">Betterment Rate:</span>
                    <span class="value">{{ $bill->betterment_rate ?? 0 }}%</span>
                </div>
                <div class="calculation-row">
                    <span class="label">Land Size Factor:</span>
                    <span class="value">
                        @php
                            $landSize = floatval($application->property_size ?? 1200);
                            if ($landSize <= 500) $factor = 0.8;
                            elseif ($landSize <= 1000) $factor = 1.0;
                            elseif ($landSize <= 2000) $factor = 1.2;
                            else $factor = 1.5;
                        @endphp
                        {{ $factor }}
                    </span>
                </div>
                <div class="calculation-row">
                    <span class="label">TOTAL BETTERMENT CHARGES:</span>
                    <span class="value">₦ {{ number_format($bill->Betterment_Charges ?? 0, 2) }}</span>
                </div>
            </div>
        </div>
        
        <!-- Amount in Words -->
        <div style="text-align: center; margin: 20px 0; font-size: 14px; font-style: italic; color: #374151;">
            <strong>Amount in Words:</strong> 
            @php
                $amount = floatval($bill->Betterment_Charges ?? 0);
                if (class_exists('NumberFormatter')) {
                    $formatter = new NumberFormatter('en', NumberFormatter::SPELLOUT);
                    $amountInWords = ucfirst($formatter->format($amount)) . ' Naira Only';
                } else {
                    $amountInWords = 'Amount conversion not available';
                }
            @endphp
            {{ $amountInWords }}
        </div>
        
        <!-- Footer Notes -->
        <div class="footer-notes">
            <h4>Important Notes:</h4>
            <p><strong>Payment Instructions:</strong> This betterment charge must be paid before the issuance of your sectional title certificate.</p>
            <p><strong>Payment Location:</strong> Payments can be made at the KANGIS Cashier's Office or designated payment points.</p>
            <p><strong>Receipt Required:</strong> Ensure you obtain a duly acknowledged revenue receipt for your payment.</p>
            <p><strong>Validity:</strong> This bill is valid for 90 days from the date of generation.</p>
            <p><strong>Enquiries:</strong> For any enquiries, please contact the Ministry of Land and Physical Planning with your reference number.</p>
        </div>
        
        <!-- Signature Section -->
        <div class="signature-section">
            <div class="signature-box">
                <div class="signature-line">
                    Authorized Officer<br>
                    Ministry of Land & Physical Planning
                </div>
            </div>
            <div class="signature-box">
                <div class="signature-line">
                    Date: {{ \Carbon\Carbon::now()->format('d/m/Y') }}
                </div>
            </div>
        </div>
        
        <!-- Print Buttons (hidden when printing) -->
        <div class="no-print" style="text-align: center; margin-top: 30px;">
            <button onclick="window.print()" style="padding: 10px 20px; background-color: #166534; color: white; border: none; border-radius: 4px; cursor: pointer; margin-right: 10px;">
                Print Receipt
            </button>
            <button onclick="window.close()" style="padding: 10px 20px; background-color: #6b7280; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Close
            </button>
        </div>
    </div>
    
    <script>
        // Auto-print when the page loads (optional)
        window.onload = function() {
            // Uncomment the line below to auto-print when the page loads
            // window.print();
        }
    </script>
</body>
</html>