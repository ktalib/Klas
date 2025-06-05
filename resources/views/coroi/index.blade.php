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
            body {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }

            .page {
                margin: 0;
                border: initial;
                border-radius: initial;
                width: initial;
                min-height: initial;
                box-shadow: initial;
                background: initial;
                page-break-after: always;
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
    </style>
    <div class="flex-1 overflow-auto">
        <!-- Header -->
        @include('admin.header')
        
        <!-- Print button -->
        <div class="p-4 flex justify-center">
            <button class="print-button" onclick="window.print()">Print Certificates</button>
        </div>
        
        <!-- Dashboard Content - Always show certificates regardless of data availability -->
        <div class="p-6">
            <div class="max-w-4xl mx-auto bg-white p-6 shadow-md container mx-auto mt-4 p-4">
                <!-- 2x2 Grid of Certificates -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Certificate 1 -->

                    @for ($i = 0; $i < 4; $i++)
                        <div class="border border-gray-300 p-2 bg-white">
                            <div class="flex justify-between items-center mb-2">
                                <!-- Nigerian Coat of Arms -->
                                <div class="w-16">
                                    <div class="flex flex-col items-center">
                                        <img src="https://i.ibb.co/60m0yNx7/Whats-App-Image-2025-02-28-at-4-01-36-PM-1.jpg"
                                            alt="Nigerian Coat of Arms" class="w-12 h-12 object-contain">
                                    </div>
                                </div>

                                <!-- Registration Number -->
                                <div class="text-center">
                                    <p class="text-sm font-bold">
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

                                <!-- Official Seal -->
                                <div class="w-16">
                                    <div
                                        class="w-12 h-12 rounded-full border-2 border-gray-400 flex items-center justify-center mx-auto">
                                        <div
                                            class="w-10 h-10 rounded-full border border-gray-400 flex items-center justify-center">
                                            <img src="https://i.ibb.co/prw0q9jx/Whats-App-Image-2025-02-28-at-4-01-36-PM.jpg"
                                                alt="Nigerian Coat of Arms" class="w-12 h-12 object-contain">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Title -->
                            <div class="text-center mb-2">
                                <h2 class="text-xs font-bold">CONFIRMATION OF REGISTRATION OF INSTRUMENT</h2>
                            </div>

                            <!-- Red Box 1 -->
                            <div class="red-box p-2 mb-2 text-[10px] leading-tight">
                                <p>THIS {{ isset($data) && isset($data->instrument_type) ? strtoupper($data->instrument_type) : 'INSTRUMENT' }} WAS DELIVERED TO ME FOR REGISTRATION BY</p>
                                <p class="font-bold">{{ isset($data) && isset($data->Applicant_Name) ? strtoupper($data->Applicant_Name) : 'APPLICANT NAME' }}</p>
                                <p>AT {{ isset($data) && isset($data->hour_part) ? $data->hour_part : '12' }} O'CLOCK IN THE {{ isset($data) && isset($data->time_part) ? $data->time_part : 'AFTERNOON' }}</p>
                                <p>ON THE {{ isset($data) && isset($data->formatted_date) ? strtoupper($data->formatted_date) : strtoupper(date('jS \of F Y')) }}</p>
                                <p class="text-center mt-1">REGISTRAR OF DEEDS
                                </p>
                                <div class="mt-2">
                                    <p>Signature: -------------------------------------------------------------------------
                                    </p>
                                    <br><br>
                                    <p>Date:
                                        ------------------------------------------------------------------------------------
                                    </p>
                                </div>
                                <br>
                                <br>

                                <!-- Land Deeds Registry Office -->
                                <div class="text-center text-[10px] mb-2">
                                    <p class="font-bold" style="color:black">DEEDS REGISTRY </p>

                                    <p class="font-bold" style="color:black">MDEEDS DEPARTMENT</p>
                                    <p class="font-bold" style="color:black">
                                        MINISTRY OF LANDS AND PHYSICAL PLANNING
                                    </p>
                                    <p class="font-bold " style="color:black">KANO STATE</p>
                                </div>
                            </div>

                            <!-- Red Box 2 -->
                            <div class="red-box p-2 mb-2 text-[10px] leading-tight">
                                <p>THIS {{ isset($data) && isset($data->instrument_type) ? strtoupper($data->instrument_type) : 'INSTRUMENT' }} IS REGISTERED AS</p>
                                <br>
                                <p>NO <strong>{{ isset($data) && isset($data->serial_no) ? $data->serial_no : '1' }}</strong> AT PAGE <strong>{{ isset($data) && isset($data->page_no) ? $data->page_no : '1' }}</strong> IN VOLUME <strong>{{ isset($data) && isset($data->volume_no) ? $data->volume_no : '1' }}</strong></p>
                                <br>
                                <p>OF THE MINISTRY OF LAND AND PHYSICAL PLANNING</p>
                                <br>
                                <p>AT KANO STATE</p>
                            </div>

                            <!-- Footer -->
                            <div class="flex justify-between items-center text-[8px]">
                                <p>Generated by Kano State Land Admin System (KLAS)</p>
                                <div
                                    class="w-4 h-4 rounded-full bg-red-700 flex items-center justify-center text-white text-[6px]">
                                    <img src="http://klas.com.ng/storage/upload/logo/1.jpeg" alt="Kano State Logo"
                                        class="w-4 h-4 object-cover">
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
