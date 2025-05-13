@extends('layouts.app')
@section('page-title')
    {{ __('GIS Data Capture') }}
@endsection


@include('sectionaltitling.partials.assets.css')
@section('content')
<div class="flex-1 overflow-auto">
    <!-- Header -->
   @include('admin.header')
    <!-- Dashboard Content -->
    <div class="p-6">
      <!-- Stats Cards -->
        
      
      <!-- Secondary Applications Table - Screenshot 135 -->
      <div class="bg-white rounded-md shadow-sm border border-gray-200 p-6">
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-xl font-bold">GIS Data Capture</h2>
          
          <div class="flex items-center space-x-4">
            <button   class="flex items-center space-x-2 px-4 py-2 bg-green-700 text-white rounded-md hover:bg-green-800">
              <i data-lucide="plus" class="w-4 h-4"></i>
              <span>Create New </span>
            </button>
            <button class="flex items-center space-x-2 px-4 py-2 border border-gray-200 rounded-md">
              <i data-lucide="download" class="w-4 h-4 text-gray-600"></i>
              <span>Export</span>
            </button>
          </div>
        </div>
       
       
    
    </div>
    <!-- Footer -->
    @include('admin.footer')
  </div>
 
@endsection
 