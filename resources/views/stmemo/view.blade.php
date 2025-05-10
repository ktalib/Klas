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
                         <h2 class="text-xl font-bold text-gray-700 uppercase tracking-wide">Physical Planning Department</h2>
                         <p class="text-sm text-gray-500">Kano State Government</p>
                    </div>
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-auto">
               </div>
               
               <div class="mb-6">
                    <div class="flex flex-col md:flex-row md:justify-between mb-2">
                         <div>
                              <span class="font-semibold text-gray-600">FROM:</span>
                              <span class="ml-2 text-gray-800">Director Physical Planning</span>
                         </div>
                         <div>
                              <span class="font-semibold text-gray-600">TO:</span>
                              <span class="ml-2 text-gray-800">Permanent Secretary</span>
                         </div>
                    </div>
                    <div class="mt-2">
                         <span class="font-semibold text-gray-600">RE:</span>
                         <span class="ml-2 text-gray-800">Application for Sectional Titling in respect of 
                              <span class="underline">{{ $memo->property_location }}</span> by 
                              <span class="underline">{{ $memo->applicant_name }}</span>
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
                         <span class="underline">{{ $memo->shared_facilities }}</span> with their respective recommended measurements:
                    </p>
                    
                    <div class="my-4 border border-gray-200 rounded-md overflow-hidden">
                         <table class="min-w-full divide-y divide-gray-200">
                              <thead class="bg-gray-50">
                                   <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Section/Unit No</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Measurement (sqm)</th>
                                   </tr>
                              </thead>
                              <tbody class="bg-white divide-y divide-gray-200">
                                   @foreach($measurements as $measurement)
                                   <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $measurement->section_no }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $measurement->measurement }}</td>
                                   </tr>
                                   @endforeach
                              </tbody>
                         </table>
                    </div>
                    
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
          </div>
     </div>
     
     <!-- Footer -->
     @include('admin.footer')
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Print functionality
    document.getElementById('printMemo').addEventListener('click', function() {
        const printContents = document.getElementById('printSection').innerHTML;
        const originalContents = document.body.innerHTML;
        
        document.body.innerHTML = `
            <style>
                @media print {
                    body {
                        font-family: Arial, sans-serif;
                        color: #000;
                        background: #fff !important;
                        margin: 0;
                        padding: 20px;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                    }
                    th, td {
                        border: 1px solid #ddd;
                        padding: 8px;
                        text-align: left;
                    }
                    th {
                        background-color: #f2f2f2;
                    }
                }
            </style>
            <div>${printContents}</div>
        `;
        
        window.print();
        document.body.innerHTML = originalContents;
        
        // Reinitialize Lucide icons after restoring content
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
});
</script>
@endpush
