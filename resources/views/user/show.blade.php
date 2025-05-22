@extends('layouts.app')
@php
    $profile = asset(Storage::url('upload/profile/'));
@endphp
@section('page-title')
    {{ __('Customer Details') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-indigo-600 hover:text-indigo-900">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('users.index') }}" class="text-indigo-600 hover:text-indigo-900">{{ __('Customer') }}</a></li>
    <li class="breadcrumb-item" aria-current="page">{{ __('Show') }}</li>
@endsection
@push('script-page')
<script>
    $(document).on('change','.plan_change', function () {
        $('.plan_change_info').hide();
        var plan_id = $('.plan_change:checked').attr('id');
        $('.plan_change_info.'+plan_id).show();
    });
</script>
@endpush
@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="border-b border-gray-200">
                <nav class="flex" aria-label="Tabs">
                    <a href="#profile-1" class="tab-button active px-6 py-3 text-sm font-medium text-indigo-600 border-b-2 border-indigo-500 whitespace-nowrap flex items-center" id="profile-tab-1" data-bs-toggle="tab" role="tab" aria-selected="true">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        {{ __('Transactions History') }}
                    </a>
                    <a href="#profile-2" class="tab-button px-6 py-3 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap flex items-center" id="profile-tab-2" data-bs-toggle="tab" role="tab" aria-selected="false">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        {{ __('Packages') }}
                    </a>
                </nav>
            </div>
            <div class="tab-content">
                <div class="tab-pane show active" id="profile-1" role="tabpanel" aria-labelledby="profile-tab-1">
                    <div class="p-4">
                        <div class="flex flex-col md:flex-row -mx-4">
                            <div class="w-full md:w-1/3 px-4 mb-6 md:mb-0">
                                <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                                    <div class="p-4 border-b border-gray-200">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-12 w-12">
                                                <img class="h-12 w-12 rounded-full object-cover"
                                                    src="{{ !empty($user->profile) ? $profile . '/' . $user->profile : $profile . '/avatar.png' }}"
                                                    alt="User image" />
                                            </div>
                                            <div class="ml-4">
                                                <h3 class="text-lg font-medium text-gray-900">{{ $user->name }}</h3>
                                                <p class="text-sm text-gray-500">{!! $user->SubscriptionLeftDay() !!}</p>
                                            </div>
                                            <div class="ml-auto">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                    {{ $user->type }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-2">
                                        <ul class="divide-y divide-gray-200">
                                            <li class="py-3 px-2">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 text-gray-400">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                        </svg>
                                                    </div>
                                                    <div class="ml-3 flex-1">
                                                        <p class="text-sm font-medium text-gray-900">{{ __('Email') }}</p>
                                                    </div>
                                                    <div class="ml-2">
                                                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="py-3 px-2">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 text-gray-400">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                        </svg>
                                                    </div>
                                                    <div class="ml-3 flex-1">
                                                        <p class="text-sm font-medium text-gray-900">{{ __('Phone') }}</p>
                                                    </div>
                                                    <div class="ml-2">
                                                        <p class="text-sm text-gray-500">{{ $user->phone_number }}</p>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="py-3 px-2">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 text-gray-400">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" />
                                                        </svg>
                                                    </div>
                                                    <div class="ml-3 flex-1">
                                                        <p class="text-sm font-medium text-gray-900">{{ __('Package') }}</p>
                                                    </div>
                                                    <div class="ml-2">
                                                        <p class="text-sm text-gray-500">{{ !empty($user->subscriptions) ? $user->subscriptions->title : '' }}</p>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full md:w-2/3 px-4">
                                <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                                    <div class="p-4 border-b border-gray-200">
                                        <h3 class="text-lg font-medium text-gray-900">{{ __('Transactions History') }}</h3>
                                    </div>
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('User') }}</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Date') }}</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Subscription') }}</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Amount') }}</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Payment Type') }}</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Payment Status') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach ($transactions as $transaction)
                                                    <tr>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                            {{ !empty($transaction->users) ? $transaction->users->name : '' }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                            {{ dateFormat($transaction->created_at) }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                            {{ !empty($transaction->subscriptions) ? $transaction->subscriptions->title : '-' }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                            {{ $settings['CURRENCY_SYMBOL'] . $transaction->amount }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                            {{ $transaction->payment_type }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                            @if ($transaction->payment_status == 'Pending')
                                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                                    {{ $transaction->payment_status }}
                                                                </span>
                                                            @elseif($transaction->payment_status == 'Success')
                                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                                    {{ $transaction->payment_status }}
                                                                </span>
                                                            @else
                                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                                    {{ $transaction->payment_status }}
                                                                </span>
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
                    </div>
                </div>
                
                <!-- Packages Tab -->
                <div class="tab-pane" id="profile-2" role="tabpanel" aria-labelledby="profile-tab-2">
                    <div class="p-4">
                        <div class="flex flex-col md:flex-row -mx-4">
                            <div class="w-full md:w-1/3 px-4 mb-6 md:mb-0">
                                <!-- User info card - same as in first tab -->
                                <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                                    <!-- ...existing user info code... -->
                                    <div class="p-4 border-b border-gray-200">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-12 w-12">
                                                <img class="h-12 w-12 rounded-full object-cover"
                                                    src="{{ !empty($user->profile) ? $profile . '/' . $user->profile : $profile . '/avatar.png' }}"
                                                    alt="User image" />
                                            </div>
                                            <div class="ml-4">
                                                <h3 class="text-lg font-medium text-gray-900">{{ $user->name }}</h3>
                                                <p class="text-sm text-gray-500">{!! $user->SubscriptionLeftDay() !!}</p>
                                            </div>
                                            <div class="ml-auto">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                    {{ $user->type }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-2">
                                        <ul class="divide-y divide-gray-200">
                                            <!-- ...existing user details... -->
                                            <li class="py-3 px-2">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 text-gray-400">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                        </svg>
                                                    </div>
                                                    <div class="ml-3 flex-1">
                                                        <p class="text-sm font-medium text-gray-900">{{ __('Email') }}</p>
                                                    </div>
                                                    <div class="ml-2">
                                                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="py-3 px-2">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 text-gray-400">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                        </svg>
                                                    </div>
                                                    <div class="ml-3 flex-1">
                                                        <p class="text-sm font-medium text-gray-900">{{ __('Phone') }}</p>
                                                    </div>
                                                    <div class="ml-2">
                                                        <p class="text-sm text-gray-500">{{ $user->phone_number }}</p>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="py-3 px-2">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 text-gray-400">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" />
                                                        </svg>
                                                    </div>
                                                    <div class="ml-3 flex-1">
                                                        <p class="text-sm font-medium text-gray-900">{{ __('Package') }}</p>
                                                    </div>
                                                    <div class="ml-2">
                                                        <p class="text-sm text-gray-500">{{ !empty($user->subscriptions) ? $user->subscriptions->title : '' }}</p>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full md:w-2/3 px-4">
                                <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                                    <div class="p-4">
                                        <div class="flex flex-col md:flex-row">
                                            <div class="w-full md:w-5/12">
                                                <img src="../assets/images/admin/img-bulb.svg" alt="images" class="max-w-full h-auto" />
                                                @foreach ($subscriptions as $subscription_key => $subscription)
                                                    <ul class="mt-4 space-y-2 plan_change_info customCheckdef{{ $subscription_key }}" style="display:{{ $subscription->id == $user->subscription ? 'block' : 'none' }}">
                                                        <li class="flex items-center">
                                                            <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                            </svg>
                                                            <span class="ml-2">{{ __('User Limit') }} {{ $subscription->user_limit }}</span>
                                                        </li>
                                                        <li class="flex items-center">
                                                            <svg class="h-5 w-5 {{ $subscription->enabled_logged_history ? 'text-green-500' : 'text-red-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $subscription->enabled_logged_history ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12' }}"></path>
                                                            </svg>
                                                            <span class="ml-2">
                                                                {{ $subscription->enabled_logged_history ? __('Enabled') : __('Disabled') }} {{ __('Logged History') }}
                                                            </span>
                                                        </li>
                                                    </ul>
                                                @endforeach
                                            </div>
                                            <div class="w-full md:w-7/12 mt-6 md:mt-0">
                                                <div class="space-y-4">
                                                    @foreach ($subscriptions as $sitem_key => $item)
                                                        <div class="border rounded-lg p-4 {{ $item->id == $user->subscription ? 'border-indigo-500 bg-indigo-50' : 'border-gray-200' }}">
                                                            <div class="flex items-center">
                                                                <input type="radio" name="radio1" 
                                                                    class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500 plan_change"
                                                                    {{ $item->id == $user->subscription ? 'checked' : '' }}
                                                                    id="customCheckdef{{ $sitem_key }}" />
                                                                <div class="ml-3 flex-1">
                                                                    <div class="flex justify-between items-center">
                                                                        <div>
                                                                            <p class="text-sm font-medium text-gray-900">{{ $item->title }}</p>
                                                                            @if ($item->id == $user->subscription)
                                                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 mt-1">
                                                                                    {{ __('Active') }}
                                                                                </span>
                                                                            @else
                                                                                {!! Form::open([
                                                                                    'method' => 'POST',
                                                                                    'route' => [
                                                                                        'subscription.manual_assign_package',
                                                                                        [\Illuminate\Support\Facades\Crypt::encrypt($item->id), $user->id],
                                                                                    ],
                                                                                ]) !!}
                                                                                <a class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 mt-1 hover:bg-indigo-200 cursor-pointer confirm_dialog"
                                                                                    data-dialog-title="{{ __('Are you sure want to Change Package?') }}"
                                                                                    data-dialog-text="{{ __('This record can not be restore after change. Do you want to confirm?') }}">
                                                                                    {{ __('Click to Select') }}
                                                                                </a>
                                                                                {!! Form::close() !!}
                                                                            @endif
                                                                        </div>
                                                                        <div class="text-right">
                                                                            <p class="text-lg font-semibold text-gray-900">
                                                                                {{ $item->package_amount }}{{ subscriptionPaymentSettings()['CURRENCY_SYMBOL'] }}/
                                                                                <span class="text-sm text-gray-500">{{ $item->interval }}</span>
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
