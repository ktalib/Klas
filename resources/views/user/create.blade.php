<div class="modal-dialog shadow-none" role="document">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">
                    @if (\Auth::user()->type == 'super admin')
                        {{ __('Create Customer') }}
                    @else
                        {{ __('Create User') }}
                    @endif
                </h3>
                <button type="button" class="text-gray-400 hover:text-gray-500 absolute top-4 right-4" data-dismiss="modal" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{ Form::open(['url' => 'users', 'method' => 'post']) }}

            @php
                $assignRoles = DB::table('assign_roles')->select('id', 'role_name')->get()->pluck('role_name', 'role_name')->toArray();
            @endphp

            <div class="p-6 overflow-y-auto max-h-[60vh]">
                <div class="flex flex-wrap -mx-2">
                    @if (\Auth::user()->type != 'super admin')
                        <div class="w-full px-3">
                            {{-- Inputs Section --}}
                            <div class="flex flex-wrap -mx-2 mb-4">
                                <div class="w-full md:w-1/2 px-2 mb-4">
                                    <div>
                                        {{ Form::label('role', __('Department'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                        {!! Form::select('role', $userRoles, null, [
                                            'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                                            'required' => 'required'
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="w-full md:w-1/2 px-2 mb-4">
                                    <div>
                                        {{ Form::label('name', __('Name'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                        {{ Form::text('name', null, [
                                            'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                                            'placeholder' => __('Enter Name'),
                                            'required' => 'required'
                                        ]) }}
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-wrap -mx-2 mb-4">
                                <div class="w-full md:w-1/2 px-2 mb-4">
                                    <div>
                                        {{ Form::label('email', __('Email'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                        {{ Form::text('email', null, [
                                            'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                                            'placeholder' => __('Enter email'),
                                            'required' => 'required'
                                        ]) }}
                                    </div>
                                </div>
                                <div class="w-full md:w-1/2 px-2 mb-4">
                                    <div>
                                        {{ Form::label('password', __('Password'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                        {{ Form::password('password', [
                                            'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                                            'placeholder' => __('Enter password'),
                                            'required' => 'required',
                                            'minlength' => '6'
                                        ]) }}
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-wrap -mx-2 mb-4">
                                <div class="w-full md:w-1/2 px-2 mb-4">
                                    <div>
                                        {{ Form::label('phone_number', __('Phone Number'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                        {{ Form::text('phone_number', null, [
                                            'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                                            'placeholder' => __('Enter phone number')
                                        ]) }}
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Roles Section in Grid Layout --}}
                            <div class="mt-6">
                                {{ Form::label('assign_role', __('Select role(s)'), ['class' => 'block text-sm font-medium text-gray-700 mb-2']) }}
                                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                    <div class="grid grid-cols-3 gap-3">
                                        @foreach ($assignRoles as $role)
                                            <div class="flex items-start">
                                                <div class="flex items-center h-5">
                                                    {{ Form::checkbox('assign_role[]', $role, false, [
                                                        'class' => 'h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500',
                                                        'id' => 'role_'.$role
                                                    ]) }}
                                                </div>
                                                <div class="ml-3 text-sm">
                                                    {{ Form::label('role_'.$role, $role, ['class' => 'font-medium text-gray-700']) }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="px-6 py-3 bg-gray-50 text-right">
                {{ Form::submit(__('Create'), ['class' => 'inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500']) }}
                <button type="button" class="ml-2 inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" data-dismiss="modal">
                    {{ __('Cancel') }}
                </button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
