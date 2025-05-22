@extends('layouts.app')
@section('page-title')
    {{ __('System Settings') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-indigo-600 hover:text-indigo-900">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item" aria-current="page">{{ __('System Settings') }}</li>
@endsection
@php
    $admin_logo = getSettingsValByName('company_logo');
    $profile = asset(Storage::url('upload/profile'));
    $activeTab = session('tab', 'user_profile_settings');
@endphp
@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <div class="flex flex-col md:flex-row -mx-4">
                    <div class="w-full md:w-1/4 px-4 mb-6 md:mb-0">
                        <ul class="space-y-1 bg-gray-50 rounded-lg border border-gray-200 overflow-hidden">
                            @if (Gate::check('manage account settings'))
                                <li>
                                    <a class="flex items-center px-4 py-3 {{ empty($activeTab) || $activeTab == 'user_profile_settings' ? 'bg-indigo-50 text-indigo-600 border-l-4 border-indigo-500' : 'text-gray-700 hover:bg-gray-100' }}"
                                        id="profile-tab-1" data-bs-toggle="tab" href="#user_profile_settings"
                                        role="tab" aria-selected="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <div>
                                            <p class="text-sm font-medium">{{ __('User Profile') }}</p>
                                            <p class="text-xs text-gray-500">{{ __('User Account Profile Settings') }}</p>
                                        </div>
                                    </a>
                                </li>
                            @endif
                            @if (Gate::check('manage password settings'))
                                <li>
                                    <a class="flex items-center px-4 py-3 {{ !empty($activeTab) && $activeTab == 'password_settings' ? 'bg-indigo-50 text-indigo-600 border-l-4 border-indigo-500' : 'text-gray-700 hover:bg-gray-100' }}"
                                        id="profile-tab-2" data-bs-toggle="tab" href="#password_settings" 
                                        role="tab" aria-selected="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                        </svg>
                                        <div>
                                            <p class="text-sm font-medium">{{ __('Password') }}</p>
                                            <p class="text-xs text-gray-500">{{ __('Password Settings') }}</p>
                                        </div>
                                    </a>
                                </li>
                            @endif
                            @if (Gate::check('manage general settings'))
                                <li>
                                    <a class="flex items-center px-4 py-3 {{ !empty($activeTab) && $activeTab == 'general_settings' ? 'bg-indigo-50 text-indigo-600 border-l-4 border-indigo-500' : 'text-gray-700 hover:bg-gray-100' }}"
                                        id="profile-tab-3" data-bs-toggle="tab" href="#general_settings" role="tab" aria-selected="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <div>
                                            <p class="text-sm font-medium">{{ __('General') }}</p>
                                            <p class="text-xs text-gray-500">{{ __('General Settings') }}</p>
                                        </div>
                                    </a>
                                </li>
                            @endif
                            @if (Gate::check('manage company settings'))
                                <li>
                                    <a class="flex items-center px-4 py-3 {{ !empty($activeTab) && $activeTab == 'company_settings' ? 'bg-indigo-50 text-indigo-600 border-l-4 border-indigo-500' : 'text-gray-700 hover:bg-gray-100' }}"
                                        id="profile-tab-4" data-bs-toggle="tab" href="#company_settings" role="tab"
                                        aria-selected="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h16v16H4z" />
                                        </svg>
                                        <div>
                                            <p class="text-sm font-medium">{{ __('Company') }}</p>
                                            <p class="text-xs text-gray-500">{{ __('Company Settings') }}</p>
                                        </div>
                                    </a>
                                </li>
                            @endif
                            @if (Gate::check('manage email settings'))
                                <li>
                                    <a class="flex items-center px-4 py-3 {{ !empty($activeTab) && $activeTab == 'email_SMTP_settings' ? 'bg-indigo-50 text-indigo-600 border-l-4 border-indigo-500' : 'text-gray-700 hover:bg-gray-100' }}"
                                        id="profile-tab-5" data-bs-toggle="tab" href="#email_SMTP_settings"
                                        role="tab" aria-selected="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12h4m0 0v4m0-4l-8 8-4-4-6 6" />
                                        </svg>
                                        <div>
                                            <p class="text-sm font-medium">{{ __('Email') }}</p>
                                            <p class="text-xs text-gray-500">{{ __('Email SMTP Settings') }}</p>
                                        </div>
                                    </a>
                                </li>
                            @endif
                            @if (Gate::check('manage payment settings'))
                                <li>
                                    <a class="flex items-center px-4 py-3 {{ !empty($activeTab) && $activeTab == 'payment_settings' ? 'bg-indigo-50 text-indigo-600 border-l-4 border-indigo-500' : 'text-gray-700 hover:bg-gray-100' }}"
                                        id="profile-tab-6" data-bs-toggle="tab" href="#payment_settings" role="tab"
                                        aria-selected="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 6h18M3 14h18M3 18h18" />
                                        </svg>
                                        <div>
                                            <p class="text-sm font-medium">{{ __('Payment') }}</p>
                                            <p class="text-xs text-gray-500">{{ __('Payment Settings') }}</p>
                                        </div>
                                    </a>
                                </li>
                            @endif
                            @if (Gate::check('manage seo settings'))
                                <li>
                                    <a class="flex items-center px-4 py-3 {{ !empty($activeTab) && $activeTab == 'site_SEO_settings' ? 'bg-indigo-50 text-indigo-600 border-l-4 border-indigo-500' : 'text-gray-700 hover:bg-gray-100' }}"
                                        id="profile-tab-7" data-bs-toggle="tab" href="#site_SEO_settings" role="tab"
                                        aria-selected="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18v18H3z" />
                                        </svg>
                                        <div>
                                            <p class="text-sm font-medium">{{ __('Site SEO') }}</p>
                                            <p class="text-xs text-gray-500">{{ __('Site SEO Settings') }}</p>
                                        </div>
                                    </a>
                                </li>
                            @endif
                            @if (Gate::check('manage google recaptcha settings'))
                                <li>
                                    <a class="flex items-center px-4 py-3 {{ !empty($activeTab) && $activeTab == 'google_recaptcha_settings' ? 'bg-indigo-50 text-indigo-600 border-l-4 border-indigo-500' : 'text-gray-700 hover:bg-gray-100' }}"
                                        id="profile-tab-8" data-bs-toggle="tab" href="#google_recaptcha_settings"
                                        role="tab" aria-selected="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18v18H3z" />
                                        </svg>
                                        <div>
                                            <p class="text-sm font-medium">{{ __('Google Recaptcha') }}</p>
                                            <p class="text-xs text-gray-500">{{ __('Google Recaptcha Settings') }}</p>
                                        </div>
                                    </a>
                                </li>
                            @endif
                            @if (Gate::check('manage 2FA settings'))
                                <li>
                                    <a class="flex items-center px-4 py-3 {{ !empty($activeTab) && $activeTab == '2FA' ? 'bg-indigo-50 text-indigo-600 border-l-4 border-indigo-500' : 'text-gray-700 hover:bg-gray-100' }}"
                                        id="profile-tab-9" data-bs-toggle="tab" href="#2FA" role="tab"
                                        aria-selected="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18v18H3z" />
                                        </svg>
                                        <div>
                                            <p class="text-sm font-medium">{{ __('2 Factors Authentication') }}</p>
                                            <p class="text-xs text-gray-500">{{ __('2 Factors Authentication Settings') }}</p>
                                        </div>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <div class="w-full md:w-3/4 px-4">
                        <div class="tab-content">
                            @if (Gate::check('manage account settings'))
                                <div class="tab-pane {{ empty($activeTab) || $activeTab == 'user_profile_settings' ? 'block' : 'hidden' }}"
                                    id="user_profile_settings" role="tabpanel" aria-labelledby="user_profile_settings">
                                    {{ Form::model($loginUser, ['route' => ['setting.account'], 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
                                    <div class="flex items-center mb-6">
                                        <div class="flex-shrink-0">
                                            <img src="{{ !empty($users->profile) ? $profile . '/' . $users->profile : $profile . '/avatar.png' }}"
                                                alt="user-image" class="h-20 w-20 rounded-full object-cover" />
                                        </div>
                                    </div>
                                    <div class="flex flex-wrap -mx-3">
                                        <div class="w-full md:w-1/2 px-3 mb-4">
                                            <div>
                                                {{ Form::label('name', __('Name'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                {{ Form::text('name', null, [
                                                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                                                    'placeholder' => __('Enter your name'),
                                                    'required' => 'required'
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="w-full md:w-1/2 px-3 mb-4">
                                            <div>
                                                {{ Form::label('email', __('Email Address'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                {{ Form::text('email', null, [
                                                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                                                    'placeholder' => __('Enter your email'),
                                                    'required' => 'required'
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="w-full md:w-1/2 px-3 mb-4">
                                            <div>
                                                {{ Form::label('phone_number', __('Phone Number'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                {{ Form::number('phone_number', null, [
                                                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                                                    'placeholder' => __('Enter your Phone Number')
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="w-full md:w-1/2 px-3 mb-4">
                                            <div>
                                                {{ Form::label('profile', __('Profile'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                {{ Form::file('profile', ['class' => 'w-full p-2 border border-gray-300 rounded-md text-sm']) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex justify-end mt-4">
                                        {{ Form::submit(__('Save'), ['class' => 'inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500']) }}
                                    </div>
                                    {{ Form::close() }}
                                </div>
                            @endif
                            @if (Gate::check('manage password settings'))
                                <div class="tab-pane {{ !empty($activeTab) && $activeTab == 'password_settings' ? 'block' : 'hidden' }}"
                                    id="password_settings" role="tabpanel" aria-labelledby="password_settings">
                                    {{ Form::model($loginUser, ['route' => ['setting.password'], 'method' => 'post']) }}
                                    <div class="flex flex-wrap -mx-3">
                                        <div class="w-full px-3 mb-4">
                                            <div>
                                                {{ Form::label('current_password', __('Current Password'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                {{ Form::password('current_password', [
                                                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                                                    'placeholder' => __('Enter your current password'),
                                                    'required' => 'required'
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="w-full px-3 mb-4">
                                            <div>
                                                {{ Form::label('new_password', __('New Password'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                {{ Form::password('new_password', [
                                                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                                                    'placeholder' => __('Enter your new password'),
                                                    'required' => 'required'
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="w-full px-3 mb-4">
                                            <div>
                                                {{ Form::label('confirm_password', __('Confirm New Password'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                {{ Form::password('confirm_password', [
                                                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                                                    'placeholder' => __('Enter your confirm new password'),
                                                    'required' => 'required'
                                                ]) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex justify-end mt-4">
                                        {{ Form::submit(__('Save'), ['class' => 'inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500']) }}
                                    </div>
                                    {{ Form::close() }}
                                </div>
                            @endif
                            @if (Gate::check('manage general settings'))
                                <div class="tab-pane {{ !empty($activeTab) && $activeTab == 'general_settings' ? 'block' : 'hidden' }}"
                                    id="general_settings" role="tabpanel" aria-labelledby="general_settings">
                                    {{ Form::model($settings, ['route' => ['setting.general'], 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
                                    <div class="flex flex-wrap -mx-3">
                                        <div class="w-full px-3 mb-4">
                                            <div>
                                                {{ Form::label('application_name', __('Application Name'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                {{ Form::text('application_name', !empty($settings['app_name']) ? $settings['app_name'] : env('APP_NAME'), [
                                                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                                                    'placeholder' => __('Enter your application name'),
                                                    'required' => 'required'
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="w-full md:w-1/3 px-3 mb-4">
                                            <div>
                                                {{ Form::label('logo', __('Logo'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                <a href="{{ asset(Storage::url('upload/logo/')) . '/' . (isset($admin_logo) && !empty($admin_logo) ? $admin_logo : 'logo.png') }}"
                                                    target="_blank"><i class="ti ti-eye ms-2 f-15"></i></a>
                                                {{ Form::file('logo', ['class' => 'w-full p-2 border border-gray-300 rounded-md text-sm']) }}
                                            </div>
                                        </div>
                                        <div class="w-full md:w-1/3 px-3 mb-4">
                                            <div>
                                                {{ Form::label('favicon', __('Favicon'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                <a href="{{ asset(Storage::url('upload/logo')) . '/' . $settings['company_favicon'] }}"
                                                    target="_blank"><i class="ti ti-eye ms-2 f-15"></i></a>
                                                {{ Form::file('favicon', ['class' => 'w-full p-2 border border-gray-300 rounded-md text-sm']) }}
                                            </div>
                                        </div>
                                        <div class="w-full md:w-1/3 px-3 mb-4">
                                            <div>
                                                {{ Form::label('light_logo', __('Light Logo'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                <a href="{{ asset(Storage::url('upload/logo')) . '/' . $settings['light_logo'] }}"
                                                    target="_blank"><i class="ti ti-eye ms-2 f-15"></i></a>
                                                {{ Form::file('light_logo', ['class' => 'w-full p-2 border border-gray-300 rounded-md text-sm']) }}
                                            </div>
                                        </div>
                                        @if (\Auth::user()->type == 'super admin')
                                            <div class="w-full md:w-1/3 px-3 mb-4">
                                                <div>
                                                    {{ Form::label('landing_logo', __('Landing Page Logo'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                    <a href="{{ asset(Storage::url('upload/logo/landing_logo.png')) }}"
                                                        target="_blank"><i class="ti ti-eye ms-2 f-15"></i></a>
                                                    {{ Form::file('landing_logo', ['class' => 'w-full p-2 border border-gray-300 rounded-md text-sm']) }}
                                                </div>
                                            </div>
                                            <div class="w-full md:w-1/3 px-3 mb-4">
                                                <div>
                                                    {{ Form::label('landing_logo', __('Owner Email Verification'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                    <div class="flex-shrink-0">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="owner_email_verification"
                                                                name="owner_email_verification"
                                                                {{ $settings['owner_email_verification'] == 'on' ? 'checked' : '' }}>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="w-full md:w-1/3 px-3 mb-4">
                                                <div>
                                                    {{ Form::label('landing_logo', __('Registration Page'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                    <div class="flex-shrink-0">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="register_page" name="register_page"
                                                                {{ $settings['register_page'] == 'on' ? 'checked' : '' }}>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="w-full md:w-1/3 px-3 mb-4">
                                                <div>
                                                    {{ Form::label('landing_logo', __('Landing Page'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                    <div class="flex-shrink-0">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="landing_page" name="landing_page"
                                                                {{ $settings['landing_page'] == 'on' ? 'checked' : '' }}>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="w-full md:w-1/3 px-3 mb-4">
                                                <div>
                                                    {{ Form::label('pricing_feature', __('Pricing Feature'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                    <div class="flex-shrink-0">
                                                        <div class="form-check form-switch">
                                                            <input type="hidden" name="pricing_feature"
                                                                value="off">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="pricing_feature" name="pricing_feature"
                                                                value="on"
                                                                {{ $settings['pricing_feature'] == 'on' ? 'checked' : '' }}>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex justify-end mt-4">
                                        {{ Form::submit(__('Save'), ['class' => 'inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500']) }}
                                    </div>
                                    {{ Form::close() }}
                                </div>
                            @endif
                            @if (Gate::check('manage company settings'))
                                <div class="tab-pane {{ !empty($activeTab) && $activeTab == 'company_settings' ? 'block' : 'hidden' }}"
                                    id="company_settings" role="tabpanel" aria-labelledby="company_settings">
                                    {{ Form::model($settings, ['route' => ['setting.company'], 'method' => 'post']) }}
                                    <div class="flex flex-wrap -mx-3">
                                        <div class="w-full md:w-1/2 px-3 mb-4">
                                            <div>
                                                {{ Form::label('company_name', __('Name'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                {{ Form::text('company_name', $settings['company_name'], [
                                                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                                                    'placeholder' => __('Enter company name')
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="w-full md:w-1/2 px-3 mb-4">
                                            <div>
                                                {{ Form::label('company_email', __('Email'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                {{ Form::text('company_email', $settings['company_email'], [
                                                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                                                    'placeholder' => __('Enter company email')
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="w-full md:w-1/2 px-3 mb-4">
                                            <div>
                                                {{ Form::label('company_phone', __('Phone Number'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                {{ Form::text('company_phone', $settings['company_phone'], [
                                                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                                                    'placeholder' => __('Enter company phone')
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="w-full md:w-1/2 px-3 mb-4">
                                            <div>
                                                {{ Form::label('company_address', __('Address'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                {{ Form::textarea('company_address', $settings['company_address'], [
                                                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                                                    'rows' => '2'
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="w-full md:w-1/2 px-3 mb-4">
                                            <div>
                                                {{ Form::label('CURRENCY_SYMBOL', __('Currency Icon'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                {{ Form::text('CURRENCY_SYMBOL', $settings['CURRENCY_SYMBOL'], [
                                                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                                                    'placeholder' => __('Enter currency symbol')
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="w-full md:w-1/2 px-3 mb-4">
                                            <div>
                                                {{ Form::label('timezone', __('Timezone'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                <select type="text" name="timezone" class="w-full p-2 border border-gray-300 rounded-md text-sm"
                                                    id="timezone">
                                                    <option value="">{{ __('Select Timezone') }}</option>
                                                    @foreach ($timezones as $k => $timezone)
                                                        <option value="{{ $k }}"
                                                            {{ $settings['timezone'] == $k ? 'selected' : '' }}>
                                                            {{ $timezone }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="w-full md:w-1/2 px-3 mb-4">
                                            <div>
                                                {{ Form::label('invoice_number_prefix', __('Invoice Number Prefix'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                {{ Form::text('invoice_number_prefix', $settings['invoice_number_prefix'], [
                                                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                                                    'placeholder' => __('Enter invoice number prefix')
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="w-full md:w-1/2 px-3 mb-4">
                                            <div>
                                                {{ Form::label('expense_number_prefix', __('Expense Number Prefix'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                {{ Form::text('expense_number_prefix', $settings['expense_number_prefix'], [
                                                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                                                    'placeholder' => __('Enter expense number prefix')
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="w-full md:w-1/4 px-3 mb-4">
                                            <div>
                                                {{ Form::label('company_zipcode', __('System Date Format'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                <div class="">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="company_date_format1"
                                                            name="company_date_format" class="custom-control-input"
                                                            value="M j, Y"
                                                            {{ $settings['company_date_format'] == 'M j, Y' ? 'checked' : '' }}>
                                                        <label class="custom-control-label"
                                                            for="company_date_format1">{{ date('M d,Y') }}</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="company_date_format2"
                                                            name="company_date_format" class="custom-control-input"
                                                            value="y-m-d"
                                                            {{ $settings['company_date_format'] == 'y-m-d' ? 'checked' : '' }}>
                                                        <label class="custom-control-label"
                                                            for="company_date_format2">{{ date('y-m-d') }}</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="company_date_format3"
                                                            name="company_date_format" class="custom-control-input"
                                                            value="d-m-y"
                                                            {{ $settings['company_date_format'] == 'd-m-y' ? 'checked' : '' }}>
                                                        <label class="custom-control-label"
                                                            for="company_date_format3">{{ date('d-m-y') }}</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="company_date_format4"
                                                            name="company_date_format" class="custom-control-input"
                                                            value="m-d-y"
                                                            {{ $settings['company_date_format'] == 'm-d-y' ? 'checked' : '' }}>
                                                        <label class="custom-control-label"
                                                            for="company_date_format4">{{ date('m-d-y') }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="w-full md:w-1/4 px-3 mb-4">
                                            <div>
                                                {{ Form::label('company_zipcode', __('System Time Format'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                <div class="">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="company_time_format1"
                                                            name="company_time_format" class="custom-control-input"
                                                            value="H:i"
                                                            {{ $settings['company_time_format'] == 'H:i' ? 'checked' : '' }}>
                                                        <label class="custom-control-label"
                                                            for="company_time_format1">{{ date('H:i') }}</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="company_time_format2"
                                                            name="company_time_format" class="custom-control-input"
                                                            value="g:i A"
                                                            {{ $settings['company_time_format'] == 'g:i A' ? 'checked' : '' }}>
                                                        <label class="custom-control-label"
                                                            for="company_time_format2">{{ date('g:i A') }}</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="company_time_format3"
                                                            name="company_time_format" class="custom-control-input"
                                                            value="g:i a"
                                                            {{ $settings['company_time_format'] == 'g:i a' ? 'checked' : '' }}>
                                                        <label class="custom-control-label"
                                                            for="company_time_format3">{{ date('g:i a') }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex justify-end mt-4">
                                        {{ Form::submit(__('Save'), ['class' => 'inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500']) }}
                                    </div>
                                    {{ Form::close() }}
                                </div>
                            @endif
                            @if (Gate::check('manage email settings'))
                                <div class="tab-pane {{ !empty($activeTab) && $activeTab == 'email_SMTP_settings' ? 'block' : 'hidden' }}"
                                    id="email_SMTP_settings" role="tabpanel" aria-labelledby="email_SMTP_settings">
                                    {{ Form::model($settings, ['route' => ['setting.smtp'], 'method' => 'post']) }}
                                    <div class="flex flex-wrap -mx-3">
                                        <div class="w-full md:w-1/2 px-3 mb-4">
                                            <div>
                                                {{ Form::label('sender_name', __('Sender Name'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                {{ Form::text('sender_name', $settings['FROM_NAME'], [
                                                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                                                    'placeholder' => __('Enter sender name')
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="w-full md:w-1/2 px-3 mb-4">
                                            <div>
                                                {{ Form::label('sender_email', __('Sender Email'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                {{ Form::text('sender_email', $settings['FROM_EMAIL'], [
                                                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                                                    'placeholder' => __('Enter sender email')
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="w-full md:w-1/2 px-3 mb-4">
                                            <div>
                                                {{ Form::label('server_driver', __('SMTP Driver'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                {{ Form::text('server_driver', $settings['SERVER_DRIVER'], [
                                                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                                                    'placeholder' => __('Enter smtp driver')
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="w-full md:w-1/2 px-3 mb-4">
                                            <div>
                                                {{ Form::label('server_host', __('SMTP Host'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                {{ Form::text('server_host', $settings['SERVER_HOST'], [
                                                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                                                    'placeholder' => __('Enter smtp host')
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="w-full md:w-1/2 px-3 mb-4">
                                            <div>
                                                {{ Form::label('server_username', __('SMTP Username'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                {{ Form::text('server_username', $settings['SERVER_USERNAME'], [
                                                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                                                    'placeholder' => __('Enter smtp username')
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="w-full md:w-1/2 px-3 mb-4">
                                            <div>
                                                {{ Form::label('server_password', __('SMTP Password'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                {{ Form::text('server_password', $settings['SERVER_PASSWORD'], [
                                                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                                                    'placeholder' => __('Enter smtp password')
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="w-full md:w-1/2 px-3 mb-4">
                                            <div>
                                                {{ Form::label('server_encryption', __('SMTP Encryption'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                {{ Form::text('server_encryption', $settings['SERVER_ENCRYPTION'], [
                                                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                                                    'placeholder' => __('Enter smtp encryption')
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="w-full md:w-1/2 px-3 mb-4">
                                            <div>
                                                {{ Form::label('server_port', __('SMTP Port'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                {{ Form::text('server_port', $settings['SERVER_PORT'], [
                                                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                                                    'placeholder' => __('Enter smtp port')
                                                ]) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex justify-end mt-4">
                                        <a href="#" data-size="md"
                                            data-url="{{ route('setting.smtp.test') }}"
                                            data-title="{{ __('Add Email') }}"
                                            class='btn btn-primary btn-rounded customModal me-1'>
                                            {{ __('Test Mail') }} </a>
                                        {{ Form::submit(__('Save'), ['class' => 'inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500']) }}
                                    </div>
                                    {{ Form::close() }}
                                </div>
                            @endif
                            @if (Gate::check('manage payment settings'))
                                <div class="tab-pane {{ !empty($activeTab) && $activeTab == 'payment_settings' ? 'block' : 'hidden' }}"
                                    id="payment_settings" role="tabpanel" aria-labelledby="payment_settings">
                                    {{ Form::model($settings, ['route' => ['setting.payment'], 'method' => 'post']) }}
                                    <div class="flex flex-wrap -mx-3">
                                        <div class="w-full md:w-1/2 px-3 mb-4">
                                            <div>
                                                {{ Form::label('CURRENCY_SYMBOL', __('Currency Icon'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                {{ Form::text('CURRENCY_SYMBOL', $settings['CURRENCY_SYMBOL'], [
                                                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                                                    'placeholder' => __('Enter currency icon'),
                                                    'required'
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="w-full md:w-1/2 px-3 mb-4">
                                            <div>
                                                {{ Form::label('CURRENCY', __('Currency Code'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                {{ Form::text('CURRENCY', $settings['CURRENCY'], [
                                                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm font-style',
                                                    'placeholder' => __('Enter currency code'),
                                                    'required'
                                                ]) }}
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="flex flex-wrap -mx-3 mt-4">
                                        <div class="w-full md:w-1/2 px-3 mb-4">
                                            <div class="flex items-center">
                                                {{ Form::label('stripe_payment', __('Stripe Payment'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                <div class="ml-2">
                                                    <div class="form-check custom-chek">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="stripe_payment" id="stripe_payment"
                                                            {{ $settings['STRIPE_PAYMENT'] == 'on' ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-wrap -mx-3">
                                        <div class="w-full md:w-1/2 px-3 mb-4">
                                            <div>
                                                {{ Form::label('stripe_key', __('Account Key'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                {{ Form::text('stripe_key', $settings['STRIPE_KEY'], [
                                                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                                                    'placeholder' => __('Enter stripe key')
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="w-full md:w-1/2 px-3 mb-4">
                                            <div>
                                                {{ Form::label('stripe_secret', __('Account Secret Key'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                {{ Form::text('stripe_secret', $settings['STRIPE_SECRET'], [
                                                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                                                    'placeholder' => __('Enter stripe secret')
                                                ]) }}
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="flex flex-wrap -mx-3 mt-4">
                                        <div class="w-full md:w-1/2 px-3 mb-4">
                                            <div class="flex items-center">
                                                {{ Form::label('paypal_payment', __('Paypal Payment'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                <div class="ml-2">
                                                    <div class="form-check custom-chek">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="paypal_payment" id="paypal_payment"
                                                            {{ $settings['paypal_payment'] == 'on' ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-wrap -mx-3">
                                        <div class="w-full px-3 mb-4">
                                            <div>
                                                {{ Form::label('paypal_mode', __('Account Mode'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                <div class="flex items-center">
                                                    <div class="form-check custom-chek form-check-inline">
                                                        <input class="form-check-input" type="radio" value="sandbox"
                                                            id="sandbox" name="paypal_mode"
                                                            {{ $settings['paypal_mode'] == 'sandbox' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="sandbox">{{ __('Sandbox') }}
                                                        </label>
                                                    </div>
                                                    <div class="form-check custom-chek form-check-inline ml-4">
                                                        <input class="form-check-input" type="radio" value="live"
                                                            id="live" name="paypal_mode"
                                                            {{ $settings['paypal_mode'] == 'live' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="live">{{ __('Live') }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="w-full md:w-1/2 px-3 mb-4">
                                            <div>
                                                {{ Form::label('paypal_client_id', __('Account Client ID'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                {{ Form::text('paypal_client_id', $settings['paypal_client_id'], [
                                                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                                                    'placeholder' => __('Enter client id')
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="w-full md:w-1/2 px-3 mb-4">
                                            <div>
                                                {{ Form::label('paypal_secret_key', __('Account Secret Key'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                {{ Form::text('paypal_secret_key', $settings['paypal_secret_key'], [
                                                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                                                    'placeholder' => __('Enter secret key')
                                                ]) }}
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="flex flex-wrap -mx-3 mt-4">
                                        <div class="w-full md:w-1/2 px-3 mb-4">
                                            <div class="flex items-center">
                                                {{ Form::label('bank_transfer_payment', __('Bank Transfer Payment'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                <div class="ml-2">
                                                    <div class="form-check custom-chek">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="bank_transfer_payment" id="bank_transfer_payment"
                                                            {{ $settings['bank_transfer_payment'] == 'on' ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-wrap -mx-3">
                                        <div class="w-full md:w-1/2 px-3 mb-4">
                                            <div>
                                                {{ Form::label('bank_name', __('Bank Name'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                {{ Form::text('bank_name', $settings['bank_name'], [
                                                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                                                    'placeholder' => __('Enter bank name')
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="w-full md:w-1/2 px-3 mb-4">
                                            <div>
                                                {{ Form::label('bank_holder_name', __('Bank Holder Name'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                {{ Form::text('bank_holder_name', $settings['bank_holder_name'], [
                                                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                                                    'placeholder' => __('Enter bank holder name')
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="w-full md:w-1/2 px-3 mb-4">
                                            <div>
                                                {{ Form::label('bank_account_number', __('Bank Account Number'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                {{ Form::text('bank_account_number', $settings['bank_account_number'], [
                                                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                                                    'placeholder' => __('Enter bank account number')
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="w-full md:w-1/2 px-3 mb-4">
                                            <div>
                                                {{ Form::label('bank_ifsc_code', __('Bank IFSC'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                {{ Form::text('bank_ifsc_code', $settings['bank_ifsc_code'], [
                                                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                                                    'placeholder' => __('Enter bank ifsc code')
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="w-full px-3 mb-4">
                                            <div>
                                                {{ Form::label('bank_other_details', __('Other Details'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                {{ Form::textarea('bank_other_details', $settings['bank_other_details'], [
                                                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                                                    'rows' => 1,
                                                    'placeholder' => __('Enter bank other details')
                                                ]) }}
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="flex flex-wrap -mx-3 mt-4">
                                        <div class="w-full md:w-1/2 px-3 mb-4">
                                            <div class="flex items-center">
                                                {{ Form::label('flutterwave_payment', __('Flutterwave Payment'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                <div class="ml-2">
                                                    <div class="form-check custom-chek">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="flutterwave_payment" id="flutterwave_payment"
                                                            {{ $settings['flutterwave_payment'] == 'on' ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-wrap -mx-3">
                                        <div class="w-full md:w-1/2 px-3 mb-4">
                                            <div>
                                                {{ Form::label('flutterwave_public_key', __('Public Key'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                {{ Form::text('flutterwave_public_key', $settings['flutterwave_public_key'], [
                                                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                                                    'placeholder' => __('Enter flutterwave public key')
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="w-full md:w-1/2 px-3 mb-4">
                                            <div>
                                                {{ Form::label('flutterwave_secret_key', __('Secret Key'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                {{ Form::text('flutterwave_secret_key', $settings['flutterwave_secret_key'], [
                                                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                                                    'placeholder' => __('Enter flutterwave secret key')
                                                ]) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex justify-end mt-4">
                                        {{ Form::submit(__('Save'), ['class' => 'inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500']) }}
                                    </div>
                                    {{ Form::close() }}
                                </div>
                            @endif
                            @if (Gate::check('manage seo settings'))
                                <div class="tab-pane {{ !empty($activeTab) && $activeTab == 'site_SEO_settings' ? 'block' : 'hidden' }}"
                                    id="site_SEO_settings" role="tabpanel" aria-labelledby="site_SEO_settings">
                                    {{ Form::model($settings, ['route' => ['setting.site.seo'], 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
                                    <div class="flex flex-wrap -mx-3">
                                        <div class="w-full px-3 mb-4">
                                            <div>
                                                {{ Form::label('meta_seo_title', __('Meta Title'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                {{ Form::text('meta_seo_title', $settings['meta_seo_title'], [
                                                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                                                    'placeholder' => __('Enter meta SEO title'),
                                                    'required' => 'required'
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="w-full px-3 mb-4">
                                            <div>
                                                {{ Form::label('meta_seo_keyword', __('Meta Keyword'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                {{ Form::text('meta_seo_keyword', $settings['meta_seo_keyword'], [
                                                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                                                    'placeholder' => __('Enter meta SEO keyword'),
                                                    'required' => 'required'
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="w-full px-3 mb-4">
                                            <div>
                                                {{ Form::label('meta_seo_description', __('Meta Description'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                {{ Form::textarea('meta_seo_description', $settings['meta_seo_description'], [
                                                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                                                    'placeholder' => __('Enter meta SEO description'),
                                                    'required' => 'required',
                                                    'rows' => '2'
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="w-full px-3 mb-4">
                                            <div>
                                                {{ Form::label('meta_seo_image', __('Meta Image'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                {{ Form::file('meta_seo_image', ['class' => 'w-full p-2 border border-gray-300 rounded-md text-sm']) }}
                                            </div>
                                        </div>
                                        @if (!empty($settings['meta_seo_image']))
                                            <div class="w-full px-3 mb-4">
                                                <img src="{{ asset(Storage::url('upload/seo')) . '/' . $settings['meta_seo_image'] }}"
                                                    class="setting-logo" alt="">
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex justify-end mt-4">
                                        {{ Form::submit(__('Save'), ['class' => 'inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500']) }}
                                    </div>
                                    {{ Form::close() }}
                                </div>
                            @endif
                            @if (Gate::check('manage google recaptcha settings'))
                                <div class="tab-pane {{ !empty($activeTab) && $activeTab == 'google_recaptcha_settings' ? 'block' : 'hidden' }}"
                                    id="google_recaptcha_settings" role="tabpanel"
                                    aria-labelledby="google_recaptcha_settings">
                                    {{ Form::model($settings, ['route' => ['setting.google.recaptcha'], 'method' => 'post']) }}
                                    <div class="flex flex-wrap -mx-3 mt-4">
                                        <div class="w-full md:w-1/2 px-3 mb-4">
                                            <div class="flex items-center">
                                                {{ Form::label('google_recaptcha', __('Google ReCaptch Enable'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                <div class="ml-2">
                                                    <div class="form-check custom-chek">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="google_recaptcha" id="google_recaptcha"
                                                            {{ $settings['google_recaptcha'] == 'on' ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-wrap -mx-3">
                                        <div class="w-full md:w-1/2 px-3 mb-4">
                                            <div>
                                                {{ Form::label('recaptcha_key', __('Recaptcha Key'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                {{ Form::text('recaptcha_key', $settings['recaptcha_key'], [
                                                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                                                    'placeholder' => __('Enter recaptcha key')
                                                ]) }}
                                            </div>
                                        </div>
                                        <div class="w-full md:w-1/2 px-3 mb-4">
                                            <div>
                                                {{ Form::label('recaptcha_secret', __('Recaptcha Secret'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                                {{ Form::text('recaptcha_secret', $settings['recaptcha_secret'], [
                                                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                                                    'placeholder' => __('Enter recaptcha secret')
                                                ]) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex justify-end mt-4">
                                        {{ Form::submit(__('Save'), ['class' => 'inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500']) }}
                                    </div>
                                    {{ Form::close() }}
                                </div>
                            @endif
                            @if (Gate::check('manage 2FA settings'))
                                <div class="tab-pane {{ !empty($activeTab) && $activeTab == '2FA' ? 'block' : 'hidden' }}"
                                    id="2FA" role="tabpanel" aria-labelledby="2FA">
                                    {{ Form::model($settings, ['route' => ['setting.twofa.enable'], 'method' => 'post']) }}
                                    <div class="flex flex-wrap -mx-3 mt-4">
                                        <div class="w-full px-3 mb-4">
                                            @if (empty(\Auth::user()->twofa_secret))
                                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                                    {{ __('2-factors authentication is currently') }}
                                                    <span class='badge bg-warning'>{{ __('disabled') }}</span>.
                                                    {{ __('To enable') }}:
                                                </label>
                                            @else
                                            <h5>
                                                {{ __('2-factors authentication is currently enable.') }}
                                                <a href="{{ route('2fa.disable') }}" class="ms-2">
                                                    <span class='btn btn-danger btn-rounded'>{{ __('click to disabled') }}</span>
                                                </a>
                                            </h5>
                                            @endif
                                        </div>
                                        @if (empty(\Auth::user()->twofa_secret))
                                            <div class="w-full px-3 mb-4">
                                                <ol class="list-left-align mt-10">
                                                    <li>
                                                        {!! __('Open your OTP app and <b>scan the following QR-code') !!}</b>
                                                        <p class="text-center">
                                                           <img src="{!! QrCode2FA() !!}" alt="2FA">
                                                        </p>
                                                    </li>
                                                    <li>
                                                        {{ __('Generate a One Time Password (OTP) and enter the value below.') }}
                                                        <div class="w-full px-3 mb-4">
                                                            <div>
                                                                <input name="otp"
                                                                    class="w-full p-2 border border-gray-300 rounded-md text-sm mr-1{{ $errors->has('otp') ? ' is-invalid' : '' }}"
                                                                    type="number" min="0" max="999999"
                                                                    step="1" required autocomplete="off">
                                                                @if ($errors->has('otp'))
                                                                    <span class="invalid-feedback text-left">
                                                                        <strong>{{ $errors->first('otp') }}</strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ol>
                                            </div>
                                        @endif
                                    </div>
                                    @if (empty(\Auth::user()->twofa_secret))
                                        <div class="flex justify-end mt-4">
                                            {{ Form::submit(__('Verify'), ['class' => 'inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500']) }}
                                        </div>
                                    @endif
                                    {{ Form::close() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
