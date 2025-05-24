@extends('layouts.app')
@section('page-title')
    {{ __('Property Record Assistant') }}
@endsection

@section('content')
@include('propertycard.css.style')
    <!-- Main Content -->
    <div class="flex-1 overflow-auto">
        <!-- Header -->
        @include('admin.header')
        <!-- Dashboard Content -->
        <div class="p-6">
            <div class="container mx-auto py-6 space-y-6">
                <!-- Page Header -->
                <div class="flex flex-col space-y-2">
                    <h1 class="text-3xl font-bold tracking-tight">Property Record Assistant</h1>
                    <p class="text-gray-500">Capture and manage property records</p>
                </div>
        
                <!-- Property Details Content -->
                @include('propertycard.partials.property_details')
           
            </div>
        
            <!-- Property Modal Dialogs -->
            @include('propertycard.partials.add_property_record')
            @include('propertycard.partials.edit_property_record')
            @include('propertycard.partials.view_property_record')
        </div>
        <!-- Footer -->
        @include('admin.footer')
    </div>
    
    <!-- Include JavaScript after all DOM elements -->
    @include('propertycard.js.javascript')
@endsection
