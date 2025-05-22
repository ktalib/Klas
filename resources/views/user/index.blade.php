@extends('layouts.app')
@section('page-title')
    {{ __('Users') }}
@endsection
@php
    $profile = asset(Storage::url('upload/profile/'));
@endphp
 
@section('content')
    <!-- Main Content -->
    <div class="flex-1 overflow-auto">
        <!-- Header -->
        @include('admin.header')
        <!-- Dashboard Content -->
        <div class="p-6">
        
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-4 border-b border-gray-200">
                    <div class="flex flex-wrap items-center justify-between">
                        <div>
                            <h5 class="text-lg font-semibold text-gray-800">
                                @if (\Auth::user()->type == 'super admin')
                                    {{ __('Customer List') }}
                                @else
                                    {{ __('User List') }}
                                @endif
                            </h5>
                        </div>
                        @if (Gate::check('create user'))
                            <div>
                                <a href="#" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md transition-colors customModal" data-size="lg"
                                    data-url="{{ route('users.create') }}"
                                    data-title=" @if (\Auth::user()->type == 'super admin') {{ __('Create Customer') }}
                                @else
                                    {{ __('Create User') }} @endif">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                    @if (\Auth::user()->type == 'super admin')
                                        {{ __('Create Customer') }}
                                    @else
                                        {{ __('Create User') }}
                                    @endif
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="p-4">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('User Profile') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Email') }}</th>
                                    @if (\Auth::user()->type == 'super admin')
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Active Package') }}</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Package Due Date') }}</th>
                                    @else
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Department') }}</th>

                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Role') }}</th>
                                    @endif
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($users as $user)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-full object-cover"
                                                        src="{{ !empty($user->profile) ? asset(Storage::url('upload/profile')) . '/' . $user->profile : asset(Storage::url('upload/profile')) . '/avatar.png' }}"
                                                        alt="User image">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $user->name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ !empty($user->phone_number) ? $user->phone_number : '' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                                        
                                        @if (\Auth::user()->type == 'super admin')
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ !empty($user->subscriptions) ? $user->subscriptions->title : '-' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ !empty($user->subscription_expire_date) ? dateFormat($user->subscription_expire_date) : __('Unlimited') }}</td>
                                        @else
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ ucfirst($user->type) }}</td>
                                             <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ ucfirst($user->assign_role) }}</td>
                                        @endif
                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex space-x-2">
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id], 'class' => 'inline-block']) !!}
                                                @if (Auth::user()->canImpersonate())
                                                    <a href="{{ route('impersonate', $user->id) }}" class="text-indigo-600 hover:text-indigo-900" title="{{ __('Continue as Customer') }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                                        </svg>
                                                    </a>
                                                @endif
                                                
                                                @can('show user')
                                                    <a href="{{ route('users.show', $user->id) }}" class="text-blue-600 hover:text-blue-900" title="{{ __('Show') }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    </a>
                                                @endcan
                                                
                                                @can('edit user')
                                                    <a href="#" class="text-green-600 hover:text-green-900 customModal" title="{{ __('Edit') }}" data-size="lg" 
                                                       data-url="{{ route('users.edit', $user->id) }}" data-title="{{ __('Edit User') }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </a>
                                                @endcan
                                                
                                                @can('delete user')
                                                    <a href="#" class="text-red-600 hover:text-red-900 confirm_dialog" title="{{ __('Delete') }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </a>
                                                @endcan
                                                {!! Form::close() !!}
                                            </div>
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
@endsection
