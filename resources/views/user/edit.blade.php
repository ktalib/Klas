{{ Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'PUT']) }}
<div class="p-6">
    <div class="flex justify-between items-center mb-4 border-b border-gray-200 pb-3">
        <h3 class="text-lg font-medium text-gray-900">{{ __('Edit User') }}</h3>
        <button type="button" class="text-gray-400 hover:text-gray-500" data-dismiss="modal" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    
    <div class="flex flex-wrap -mx-3">
        @if (\Auth::user()->type != 'super admin')
            <div class="w-full md:w-1/2 px-3 mb-4">
                {{ Form::label('role', __('Department'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                {!! Form::select('role', $userRoles, !empty($user->roles) ? $user->roles[0]->id : null, [
                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                    'required' => 'required',
                ]) !!}
            </div>
        @endif
        
        @if (\Auth::user()->type == 'super admin')
            <div class="w-full md:w-1/2 px-3 mb-4">
                {{ Form::label('name', __('Name'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                {{ Form::text('name', null, [
                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                    'placeholder' => __('Enter Name'),
                    'required' => 'required'
                ]) }}
            </div>
        @else
            <div class="w-full md:w-1/2 px-3 mb-4">
                {{ Form::label('first_name', __('First Name'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                {{ Form::text('first_name', null, [
                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                    'placeholder' => __('Enter First Name'),
                    'required' => 'required'
                ]) }}
            </div>
            <div class="w-full md:w-1/2 px-3 mb-4">
                {{ Form::label('last_name', __('Last Name'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                {{ Form::text('last_name', null, [
                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                    'placeholder' => __('Enter Last Name'),
                    'required' => 'required'
                ]) }}
            </div>
        @endif
        
        <div class="w-full md:w-1/2 px-3 mb-4">
            {{ Form::label('name', __('Name'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
            {{ Form::text('name', null, [
                'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                'placeholder' => __('Enter Name'),
                'required' => 'required'
            ]) }}
        </div>
        
        <div class="w-full md:w-1/2 px-3 mb-4">
            {{ Form::label('email', __('Email'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
            {{ Form::text('email', null, [
                'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                'placeholder' => __('Enter Email'),
                'required' => 'required'
            ]) }}
        </div>
        
        <div class="w-full md:w-1/2 px-3 mb-4">
            {{ Form::label('phone_number', __('Phone Number'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
            {{ Form::text('phone_number', null, [
                'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                'placeholder' => __('Enter Phone Number')
            ]) }}
        </div>
    </div>
</div>
<div class="px-6 py-3 bg-gray-50 text-right">
    {{ Form::submit(__('Update'), ['class' => 'inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500']) }}
    <button type="button" class="ml-2 inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" data-dismiss="modal">
        {{ __('Cancel') }}
    </button>
</div>
{{ Form::close() }}
