@extends('layouts.app')

@section('page-title')
    {{$PageTitle}}
@endsection

@include('sectionaltitling.partials.assets.css')

@section('content')
<div class="flex-1 overflow-auto bg-gray-100 min-h-screen py-8">
     <!-- Header -->
     @include('admin.header')
     
     <!-- Main Content -->
     <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg p-8 border border-gray-200 mb-8">
          <div class="flex justify-between items-center mb-6 border-b pb-4">
               <div>
                    <h2 class="text-2xl font-bold text-gray-800">Sectional Titling Memo</h2>
                    <p class="text-sm text-gray-500">Memo #: {{ $memo->memo_no }}</p>
               </div>
               <div class="flex items-center gap-2">
                    <a href="{{ route('stmemo.stmemo') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md flex items-center gap-2">
                         <i data-lucide="arrow-left" class="w-4 h-4"></i>
                         Back to List
                    </a>
                    <button id="printMemo" class="px-4 py-2 bg-blue-600 text-white rounded-md flex items-center gap-2">
                         <i data-lucide="printer" class="w-4 h-4"></i>
                         Print Memo
                    </button>
               </div>
          </div>
          
          <div id="printSection">
                  <div class="flex items-center justify-between mb-8">
                         <div>
                               <h2 class="text-xl font-bold text-gray-700 uppercase tracking-wide">PHYSICAL PLANNING DEPARTMENT</h2>
                               <p class="text-sm text-gray-500 uppercase">KANO STATE GOVERNMENT</p>
                         </div>
                         {{-- <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16 w-auto"> --}}
                  </div>
                  
                  <div class="mb-8 border-b border-gray-300 pb-4">
                         <div class="flex flex-col md:flex-row md:justify-between mb-3">
                               <div class="mb-2 md:mb-0">
                                     <span class="font-semibold text-gray-600 uppercase text-sm">FROM:</span>
                                     <span class="ml-2 text-gray-800 font-medium uppercase">DIRECTOR PHYSICAL PLANNING</span>
                               </div>
                               <div>
                                     <span class="font-semibold text-gray-600 uppercase text-sm">TO:</span>
                                     <span class="ml-2 text-gray-800 font-medium uppercase">PERMANENT SECRETARY</span>
                               </div>
                         </div>
                         <div class="mt-3">
                               <span class="font-semibold text-gray-600 uppercase text-sm">RE:</span>
                               <span class="ml-2 text-gray-800 font-medium uppercase">APPLICATION FOR SECTIONAL TITLING IN RESPECT OF 
                                     <span class="underline">{{ strtoupper($memo->property_location) }}</span> BY 
                                     <span class="underline">{{ strtoupper($memo->applicant_name) }}</span>
                               </span>
                         </div>
                  </div>
               
               <div class="mb-6 text-gray-700 leading-relaxed">
                    <p class="mb-4">Above subject refers, please.</p>
                    <p class="mb-4">
                         The physical site inspection conducted revealed that this application is accessible, conforms with existing land use, and has shared common boundaries.
                    </p>
                    <p class="mb-4">
                         The property is sub-divided into <span class="underline">{{ $measurements->count() }}</span> portions. 
                         All portions are accessible, conform with existing land use, and share the following facilities: 
                         <span class="underline">{{ $memo->shared_facilities }}</span> respective recommended measurements (See Overleat for the measurements)
                    </p>
                    
                    <p>
                         In view of the above facts and Section <span class="underline">12(3)</span> of Kano State Sectional and Systematic Land Titling Registration Law 2024 (1446AH), this application may be considered for recommendation. If you have no objection, please.
                    </p>
               </div>
               
               <div class="flex justify-between mt-10">
                    <div class="text-center">
                         <div class="h-8"></div>
                         <span class="block border-t border-gray-400 w-48 mx-auto"></span>
                         <span class="block mt-2 text-gray-700 font-semibold">Director Physical Planning</span>
                    </div>
                    <div class="text-center">
                         <div class="h-8"></div>
                         <span class="block border-t border-gray-400 w-48 mx-auto"></span>
                         <span class="block mt-2 text-gray-700 font-semibold">Permanent Secretary</span>
                    </div>
               </div>
               
               <div class="mt-8 text-sm text-gray-500">
                    <p>Generated on: {{ \Carbon\Carbon::parse($memo->created_at)->format('d F, Y') }}</p>
                    <p>Reference: {{ $memo->memo_no }}</p>
               </div>
               
               <!-- New Page for Measurements -->
               <div style="page-break-before: always;">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Measurements and Buyers Information</h3>
                    <p class="mb-4">Below are the respective recommended measurements and buyers for each section:</p>
                    
                    @php
                    // Get conveyance data from mother_applications
                    $buyersData = DB::connection('sqlsrv')
                        ->table('mother_applications')
                        ->where('id', $memo->application_id)
                        ->value('conveyance');
                        
                    $buyersArray = [];
                    if ($buyersData) {
                        $decodedData = json_decode($buyersData, true);
                        $buyers = isset($decodedData['records']) ? $decodedData['records'] : [];
                        
                        // Create an associative array with section numbers as keys
                        foreach ($buyers as $buyer) {
                            if (isset($buyer['sectionNo'])) {
                                $buyersArray[$buyer['sectionNo']] = [
                                    'title' => $buyer['buyerTitle'] ?? '',
                                    'name' => $buyer['buyerName'] ?? 'N/A'
                                ];
                            }
                        }
                    }
                    @endphp
                    
                    <div class="my-4 border border-gray-200 rounded-md overflow-hidden">
                         <table class="min-w-full divide-y divide-gray-200">
                              <thead class="bg-gray-50">
                                   <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Section/Unit No</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Measurement (sqm)</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Buyer</th>
                                   </tr>
                              </thead>
                              <tbody class="bg-white divide-y divide-gray-200">
                                   @foreach($measurements as $measurement)
                                   <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $measurement->section_no }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $measurement->measurement }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            @if(isset($buyersArray[$measurement->section_no]))
                                                @if(!empty($buyersArray[$measurement->section_no]['title']))
                                                    {{ $buyersArray[$measurement->section_no]['title'] }} 
                                                @endif
                                                {{ $buyersArray[$measurement->section_no]['name'] }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                   </tr>
                                   @endforeach
                              </tbody>
                         </table>
                    </div>
               </div>
          </div>
     </div>
     
     <!-- Footer -->
     @include('admin.footer')
</div>


 
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Print functionality
    document.getElementById('printMemo').addEventListener('click', function() {
        try {
            // Create a hidden iframe
            const iframe = document.createElement('iframe');
            iframe.style.position = 'fixed';
            iframe.style.width = '0';
            iframe.style.height = '0';
            iframe.style.opacity = '0';
            document.body.appendChild(iframe);
            
            // Get content to print
            const printContents = document.getElementById('printSection').innerHTML;
            
            // Write content to iframe
            iframe.contentDocument.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Sectional Titling Memo</title>
                    <style>
                        @page {
                            size: A4;
                            margin: 2cm;
                        }
                        body {
                            font-family: Arial, sans-serif;
                            color: #000;
                            background: #fff;
                            line-height: 1.5;
                            font-size: 12pt;
                        }
                        h2 {
                            font-size: 16pt;
                            margin-bottom: 10pt;
                            color: #333;
                        }
                        h3 {
                            font-size: 14pt;
                            margin-top: 16pt;
                            margin-bottom: 8pt;
                            color: #333;
                        }
                        p {
                            margin-bottom: 10pt;
                        }
                        table {
                            width: 100%;
                            border-collapse: collapse;
                            margin: 15pt 0;
                        }
                        th, td {
                            border: 1px solid #000;
                            padding: 8pt;
                            text-align: left;
                            font-size: 11pt;
                        }
                        th {
                            background-color: #f2f2f2;
                            font-weight: bold;
                        }
                        img {
                            max-width: 100%;
                            height: auto;
                        }
                        .page-break {
                            page-break-before: always;
                        }
                        .underline {
                            text-decoration: underline;
                        }
                        .flex {
                            display: flex;
                            justify-content: space-between;
                        }
                        .text-center {
                            text-align: center;
                        }
                        .mt-10 {
                            margin-top: 20pt;
                        }
                        .signature-line {
                            border-top: 1px solid #000;
                            width: 200px;
                            margin: 40pt auto 5pt;
                        }
                    </style>
                </head>
                <body>${printContents}</body>
                </html>
            `);
            
            // Wait for content to load then print
            iframe.onload = function() {
                setTimeout(function() {
                    iframe.contentWindow.focus();
                    iframe.contentWindow.print();
                    
                    // Remove the iframe after printing (or after a timeout)
                    setTimeout(function() {
                        document.body.removeChild(iframe);
                    }, 500);
                }, 250);
            };
            
            iframe.contentDocument.close();
            
        } catch (error) {
            console.error('Print error:', error);
            alert('There was an error when trying to print. Please try again.');
        }
    });
});
</script>
@endsection