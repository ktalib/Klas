<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Occupancy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Certificate container styling */
        .certificate-container {
              /* background-image: url('{{ asset('storage/upload/cofo/cofo.jpeg') }}');    */
            background-size: 100% 100%;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
            width: 21cm; /* A4 width */
            height: 29.7cm; /* A4 height */
            margin: 0 auto;
            padding: 5.5cm 2.5cm 3cm 2.5cm; /* Increased top padding to move content down */
            box-sizing: border-box;
        }

        /* Content wrapper to ensure proper positioning */
        .certificate-content {
            width: 100%;
            height: 100%;
            position: relative;
            overflow: hidden;
        }
        
        /* Title header styling with better positioning */
        .certificate-header {
            margin-top: 1.5cm; /* Add extra space at the top to push down the title */
            text-align: center;
            margin-bottom: 1cm;
        }
        
        @media print {
            body * {
                visibility: hidden;
            }
            
            .certificate-container,
            .certificate-container * {
                visibility: visible;
            }
            
            .certificate-container {
                position: absolute;
                top: 0;
                left: 0;
                width: 21cm;
                height: 29.7cm;
                margin: 0;
                padding: 3cm 2.5cm;
                box-shadow: none !important;
                page-break-inside: avoid;
            }
            
            @page {
                size: A4;
                margin: 0;
            }
            
            /* Optimize spacing for printing */
            .mb-6 {
                margin-bottom: 0.5rem !important;
            }
            
            .mb-2 {
                margin-bottom: 0.1rem !important;
            }
            
            .space-y-2 > * + * {
                margin-top: 0.1rem !important;
            }
            
            .mt-10 {
                margin-top: 0.5rem !important;
            }
            
            ol.list-decimal {
                padding-left: 1rem !important;
                margin-top: 0.1rem !important;
                margin-bottom: 0.1rem !important;
            }
            
            h1 {
                font-size: 1.2rem !important;
                margin-bottom: 0.2rem !important;
            }
            
            h2 {
                font-size: 1.1rem !important;
                margin-bottom: 0.2rem !important;
            }
            
            h3 {
                font-size: 1rem !important;
                margin-bottom: 0.2rem !important;
            }
            
            .certificate-metadata {
                display: none !important;
            }
        }
        
        .highlight {
            text-transform: uppercase;
            font-weight: bold;
        }
        
        /* Print button styles */
        .print-button:hover {
            background-color: #1e429f;
        }

        /* Font size adjustments for better fit */
        .certificate-content {
            font-size: 0.9rem;
        }
        
        .certificate-content h1 {
            font-size: 1.4rem;
        }
        
        .certificate-content h2 {
            font-size: 1.2rem;
        }
        
        .certificate-content h3 {
            font-size: 1rem;
        }
        
        /* List styles to ensure proper indentation */
        .certificate-content ol.list-decimal {
            padding-left: 1.5rem;
        }
        
        /* Ensure proper spacing between sections */
        .content-section {
            margin-bottom: 1rem;
        }
        
        /* Passport photo styling */
        .passport-photo {
            position: absolute;
            top: 1.7cm; /* Move further down */
            right: 0cm;
            width: 15vw;
            max-width: 2.5cm;
            min-width: 80px;
            height: auto;
            aspect-ratio: 5/6;
            border: 1px solid #000;
            overflow: hidden;
            background: #fff;
        }
        
        .passport-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
    </style>
</head>
<body class="bg-gray-100 p-4 md:p-8">
    <div class="certificate-metadata mb-4 bg-white p-4 rounded-md shadow-sm">
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
            <div class="md:col-span-3 mb-2">
            <a href="javascript:history.back()" class="bg-blue-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back
            </a>
            </div>
        </div>
    </div>

@php
    // Get the unit owner information from subapplications where fileno matches
    $unit_owner = DB::connection('sqlsrv')->table('subapplications')
        ->where('fileno', $cofo->file_no)
        ->first();
    
    // If no unit owner is found, set passport to default
    if (!$unit_owner) {
        $unit_owner = (object)['passport' => 'default-passport.jpg'];
    }
@endphp

    <div class="max-w-4xl mx-auto certificate-container">
        <div class="certificate-content relative">
            <!-- Passport Photo absolutely positioned at top right corner -->
            <div class="passport-photo">
                <img src="{{ asset('storage/app/public/' . ($unit_owner->passport ?? 'default-passport.jpg')) }}" 
                     alt="Passport Photo">
            </div>
            <div class="certificate-header content-section">
                <h2 class="whitespace-nowrap text-xl font-bold mb-2 mr-20">SECTIONAL TITLING (ST) CERTIFICATE OF OCCUPANCY</h2>
                <div class="mb-2 font-semibold">New File No: <span class="highlight">{{ $cofo->file_no ?? 'ST/COM/2025/001' }}</span></div>
                <div class="mb-2 font-semibold"> {{ $cofo->land_use ?? 'Insert Landuse' }}</div>
                <div class="mb-2 font-semibold">
                    @if(!empty($cofo->unit_description))
                        {{ $cofo->unit_description }}
                    @else
                        Plot No: {{ $cofo->plot_no ?? 'N/A' }}, 
                        Block No: {{ $cofo->block_no ?? 'N/A' }}, 
                        Floor No: {{ $cofo->floor_no ?? 'N/A' }}, 
                        Flat No: {{ $cofo->flat_no ?? 'N/A' }}
                    @endif
                </div>
            </div>

            <div class="mb-6 content-section">
                <p class="mb-2">This is to certify that: <span class="highlight">{{ $cofo->file_no ?? '[Insert FileNo]' }}</span></p>
                <p class="mb-2">Whose address is <span class="highlight">{{ $cofo->holder_address ?? '[Insert Address]' }}</span></p>
                <p class="mb-2">
                    (Herein after called the holder, which terms shall include any person/persons in title) is hereby granted a right of occupancy for in and over the land described in the schedule, and more particularly in the plan printed hereto for a term of <span class="highlight">{{ $cofo->total_term ?? '[Tenancy]' }}</span> commencing from <span class="highlight">{{ isset($cofo->start_date) ? date('jS F, Y', strtotime($cofo->start_date)) : '[Insert Certificate Date]' }}</span> according to the true intent and meaning of the Kano State Sectional and Systematic Land Titling Registration Law, 2024 and subject to the provisions thereof and to the following special terms and conditions:
                </p>
            </div>

            <ol class="list-decimal pl-6 space-y-2 text-justify">
                <li>
                    To pay in advance without demand to the Government of the State (herein after referred to as the Governor) or any other officer or agency appointed by the Governor of the State:
                    <ol class="list-[lower-alpha] pl-6">
                        <li>Whatever is the computed revised and the current ground rent from the first day of January of each year or</li>
                        <li>Such revised ground rent as the Governor may from time to time prescribe.</li>
                        <li>Such penal rent as the Governor may from time to time impose.</li>
                    </ol>
                </li>
                <li>To pay and discharge all rates (including utilities), assessment and impositions, whatsoever which shall at any time be charged or imposed on the said land or any building thereon, or upon the occupier or occupiers thereof.</li>
                <li>To pay forthwith to the Kano State Government through Ministry of Land and Physical Planning or such other body or agency appointed by the Governor (if not sooner paid) all survey fees and other charges due in respect of the preparation, registration and issuance of this certificate.</li>
                <li>Within two years from the day of the commencement of the right of occupancy to erect and complete on the said land building(s) or other works specified in the related plans approved or to be approved by the Kano State Government or any other agency empowered to do so. The approval may be revoked after two (2) years.</li>
                <li>To maintain in good and substantial repair to the satisfaction of Kano State Government or any other officer appointed by the Governor, all buildings on the said land and appurtenances thereof, and to do other works, properly maintained in clean and good sanitary condition around all of the land and surroundings of the buildings.</li>
                <li>Upon the expiration of the said term to deliver up to the Governor in good and tenable state to the satisfaction of the Kano State Government or any other agency appointed by the State Governor, the said land and building(s) thereon.</li>
                <li>Not to erect build or permit to be erected or built on the land, buildings other than those permitted to be erected by virtue of this certificate of occupancy nor to make or permit to be made any addition or alteration to the said building(s) already erected on the land except in accordance with the plans and specifications approved by the Governor and or any officer authorized by him on his behalf.</li>
                <li>The Governor or any public officer duly authorized by the Governor on his behalf, shall have the power to enter upon and inspect the land comprised in any statutory right of occupancy or any improvements effected thereon, at any reasonable hour during the day and the occupier shall permit and give free access to the Governor or any such officer to enter and so inspect.</li>
                <li>Not to alienate the right of occupancy hereby granted or any part thereof by sale, assignment, mortgage, transfer of possessions, sub-lease or bequest, or otherwise howsoever without the prior consent of the Governor.</li>
                <li>To use the said land only for <span class="highlight">{{ $cofo->land_use ?? '[Insert Landuse]' }}</span> purpose.</li>
                <li>Not to contravene any of the provisions of the Kano State Sectional and Systematic Land Titling Registration Law, 2024 and to conform and comply with all rules and regulations laid down from time to time by Kano State Government.</li>
                <li>To become joint owner of the common property of the Sectional Titling Land and actively participate in all quotas that benefit or burden sections.</li>
                <li>To exclusively use certain parts and share undivided sections of the common property e.g, Garage, Garden, Parking space, Storeroom among others.</li>
                <li>
                    For the purpose of the rent to be paid under this certificate of occupancy:
                    <ol class="list-[lower-roman] pl-6">
                        <li>
                            The term of the Right Of Occupancy shall be divided into periods of five years and Governor may, at the expiration of each period of five years, revise the rent and fix the sum which shall be payable for the next period of five years. If the Governor shall so revise the rent, he shall cause a notice to be sent to the holder/holders and the rent so fixed or revised shall commenced to be payable one calendar month from the date of the receipt of such notice.
                        </li>
                        <li>
                            If any rent for the time being payable in respect of the land or any part hereof shall be in arrears for the period of three months whether same shall or shall not have been legally demanded or if the holder/holders become bankrupt or make a composition with creditors or enter into liquidation, whether compulsory or voluntarily or if there shall be any breach or non-observance of any of the occupier’s covenants or agreements herein contained. Then and in any of the said cases it shall be lawful for the Governor at any given time thereafter to hold and enjoy the same as if the right of occupancy had not been granted but without prejudice to Right of Action or remedy of Governor for any antecedent breach of covenant by the holder/holders.
                        </li>
                    </ol>
                </li>
            </ol>

            <div class="mt-8 content-section">
                <p class="mb-1 font-bold">DATED This____________________day of_____________________, 20______</p>
                <p class="text-center mb-2">Given under my hand the day and year above written</p>
                <div class="flex justify-end mt-20">
                    <div class="text-center w-64">
                        <div class="border-t border-black w-full mb-2"></div>
                        <p class="mb-1 font-bold">{{ $cofo->signed_by ?? 'Alh. Abduljabbar Mohammed Umar' }}</p>
                        <p class="font-bold">{{ $cofo->signed_title ?? 'Honorable Commissioner of Land and Physical Planning' }}</p>
                        <p class="font-bold">Kano State, Nigeria</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div>
        <button class="no-print bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 mx-auto block" onclick="printCertificate()">Generate Front Page</button>
    </div>
    <script>
        function printCertificate() {
            // Focus on the main content for better printing
            document.querySelector('.certificate-container').focus();
            // Print the document
            window.print();
        }
        
        // Initialize page when loaded
        window.onload = function() {
            // Adjust font size dynamically if content is too large
            const container = document.querySelector('.certificate-content');
            const containerHeight = document.querySelector('.certificate-container').clientHeight;
            const contentHeight = container.scrollHeight;
            
            if (contentHeight > containerHeight - 100) { // Leave some margin
                const scaleFactor = Math.min(0.9, (containerHeight - 100) / contentHeight);
                container.style.fontSize = (parseFloat(getComputedStyle(container).fontSize) * scaleFactor) + 'px';
            }
        };
    </script>
</body>
</html>