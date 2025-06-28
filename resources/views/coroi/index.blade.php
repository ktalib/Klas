@extends('layouts.app')
@section('page-title')
    {{ __('Confirmation Of Instrument Registration') }}
@endsection

@section('content')
    <style>
        .ck-editor__editable {
            min-height: 200px;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        textarea {
            min-height: 40px;
        }

        @media print {
            body * {
                visibility: hidden !important;
            }
            .print-area, .print-area * {
                visibility: visible !important;
            }
            .print-area {
                position: absolute !important;
                left: 0; 
                top: 0; 
                width: 100vw;
                margin: 0 !important;
                padding: 10px !important;
                box-shadow: none !important;
                background: white !important;
                z-index: 9999;
            }
            .print-button, .print-button * {
                display: none !important;
            }
            
            /* A4 page optimization */
            @page {
                size: A4;
                margin: 0.5in;
            }
            
            .certificate-container {
                max-width: 100% !important;
                padding: 5px !important;
                margin: 0 !important;
            }
            
            .certificate-grid {
                gap: 8px !important;
            }
            
            .certificate-item {
                font-size: 7px !important;
                line-height: 1.1 !important;
                padding: 4px !important;
            }
            
            .certificate-item img {
                width: 8px !important;
                height: 8px !important;
            }
            
            .red-box {
                padding: 3px !important;
                margin-bottom: 3px !important;
            }
        }

        .red-box {
            border: 1px solid #c41e3a;
            color: #c41e3a;
        }

        .print-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-bottom: 15px;
        }
        
        /* Compact layout for screen view */
        .certificate-container {
            max-width: 210mm; /* A4 width */
            margin: 0 auto;
        }
        
        .certificate-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        
        .certificate-item {
            border: 1px solid #d1d5db;
            padding: 6px;
            background: white;
            font-size: 8px;
            line-height: 1.2;
        }
        
        .certificate-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 4px;
        }
        
        .logo-container {
            width: 20px;
            display: flex;
            justify-content: center;
        }
        
        .logo-container img {
            width: 14px;
            height: 14px;
            object-fit: contain;
        }
        
        .seal-container {
            width: 20px;
            display: flex;
            justify-content: center;
        }
        
        .seal {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            border: 1px solid #9ca3af;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .seal img {
            width: 12px;
            height: 12px;
            object-fit: contain;
        }
        
        .reg-number {
            text-align: center;
            flex: 1;
        }
        
        .title {
            text-align: center;
            margin-bottom: 4px;
            font-weight: bold;
            font-size: 9px;
        }
        
        .red-box-compact {
            border: 1px solid #c41e3a;
            color: #c41e3a;
            padding: 4px;
            margin-bottom: 4px;
            font-size: 7px;
            line-height: 1.1;
        }
        
        .footer-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 6px;
            margin-top: 2px;
        }
        
        .footer-logo {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: #b91c1c;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .footer-logo img {
            width: 12px;
            height: 12px;
            object-fit: cover;
            border-radius: 50%;
        }
    </style>
    
    <div class="flex-1 overflow-auto">
        <!-- Header -->
        @include('admin.header')
        
        <!-- Print button -->
        <div class="p-4 flex justify-center">
            <button class="print-button" onclick="window.print()">Print</button>
        </div>
        
        <!-- Dashboard Content -->
        <div class="print-area">
            <div class="certificate-container p-4">
                <!-- 2x2 Grid of Certificates -->
                <div class="certificate-grid">
                    @for ($i = 0; $i < 4; $i++)
                        <div class="certificate-item">
                            <!-- Header with logos and registration number -->
                            <div class="certificate-header">
                                <!-- Nigerian Coat of Arms (local logo1.jpg) -->
                                <div class="logo-container">
                                    <img src="{{ asset('assets/logo/logo1.jpg') }}" alt="Nigerian Coat of Arms">
                                </div>

                                <!-- Registration Number -->
                                <div class="reg-number">
                                    <p class="font-bold text-[8px]">
                                    @if(isset($data) && isset($data->STM_Ref))
                                        {{ $data->STM_Ref }}
                                    @else
                                        @php
                                            $year = date('Y');
                                            echo "STM-{$year}-001";
                                        @endphp
                                    @endif
                                    </p>
                                </div>

                                <!-- KANGIS Logo (logo2.jpg) -->
                                <div class="logo-container">
                                    <img src="{{ asset('assets/logo/logo2.jpg') }}" alt="KANGIS Logo">
                                </div>

                              
                            </div>

                            <!-- Title -->
                            <div class="title">
                                <h2>CONFIRMATION OF REGISTRATION OF INSTRUMENT</h2>
                            </div>

                            <!-- Red Box 1 -->
                            <div class="red-box-compact">
                                <p>THIS {{ isset($data) && isset($data->instrument_type) ? strtoupper($data->instrument_type) : 'INSTRUMENT' }} WAS DELIVERED TO ME FOR REGISTRATION BY</p>
                                <p class="font-bold">{{ isset($data) && isset($data->Applicant_Name) ? strtoupper($data->Applicant_Name) : 'APPLICANT NAME' }}</p>
                                <p>AT {{ isset($data) && isset($data->hour_part) ? $data->hour_part : '12' }} O'CLOCK IN THE {{ isset($data) && isset($data->time_part) ? $data->time_part : 'AFTERNOON' }}</p>
                                <p>ON THE {{ isset($data) && isset($data->formatted_date) ? strtoupper($data->formatted_date) : strtoupper(date('jS \of F Y')) }}</p>
                                <p class="text-center mt-1">REGISTRAR OF DEEDS</p>
                                <div class="mt-1">
                                    <p>Signature: ________________________________</p>
                                    <p style="margin-top: 4px;">Date: ____________________________________</p>
                                </div>

                                <!-- Land Deeds Registry Office -->
                                <div class="text-center mt-2" style="color:black">
                                    <p class="font-bold">DEEDS REGISTRY</p>
                                    <p class="font-bold">DEEDS DEPARTMENT</p>
                                    <p class="font-bold">MINISTRY OF LANDS AND PHYSICAL PLANNING</p>
                                    <p class="font-bold">KANO STATE</p>
                                </div>
                            </div>

                            <!-- Red Box 2 -->
                            <div class="red-box-compact">
                                <p>THIS {{ isset($data) && isset($data->instrument_type) ? strtoupper($data->instrument_type) : 'INSTRUMENT' }} IS REGISTERED AS</p>
                                <p style="margin-top: 2px;">NO <strong>{{ isset($data) && isset($data->serial_no) ? $data->serial_no : '1' }}</strong> AT PAGE <strong>{{ isset($data) && isset($data->page_no) ? $data->page_no : '1' }}</strong> IN VOLUME <strong>{{ isset($data) && isset($data->volume_no) ? $data->volume_no : '1' }}</strong></p>
                                <p style="margin-top: 2px;">OF THE MINISTRY OF LAND AND PHYSICAL PLANNING</p>
                                <p style="margin-top: 2px;">AT KANO STATE</p>
                            </div>

                            <!-- Footer -->
                            <div class="footer-info">
                                <p>Generated by Kano State Land Administration Enterprise 
System (KLAES)</p>
                                <div class="footer-logo">
                                    <img src="http://klas.com.ng/storage/upload/logo/1.jpeg" alt="Kano State Logo">
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        @include('admin.footer')
    </div>
@endsection