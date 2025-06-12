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
        
       
            {{-- Department selector with improved auto-filtering --}}
            <div class="w-full md:w-1/2 px-3 mb-4">
                {{ Form::label('department_id', __('Department'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                {{ Form::select('department_id', $departments, null, [
                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                    'required' => 'required',
                    'id' => 'department_id',
                    'placeholder' => 'Select Department'
                ]) }}
            </div>
            
            {{-- Roles container with improved Alpine.js data model --}}
            <div class="w-full px-3 mb-4">
                <div class="mt-2" id="roles_container" x-data="{
                    selectedDept: null,
                    showAll: true,
                    
                    filterByDept() {
                        this.selectedDept = document.getElementById('department_id').value;
                        this.showAll = false;
                    },
                    
                    showAllRoles() {
                        this.showAll = true;
                    },
                    
                    init() {
                        // Initialize with current department value
                        this.$nextTick(() => {
                            const deptId = document.getElementById('department_id').value;
                            if (deptId) {
                                this.selectedDept = deptId;
                                this.showAll = false;
                                console.log('Initial department detected:', deptId);
                            }
                            
                            // Listen for department change events
                            document.getElementById('department_id').addEventListener('change', () => {
                                this.selectedDept = document.getElementById('department_id').value;
                                this.showAll = false;
                                console.log('Department changed to:', this.selectedDept);
                            });
                        });
                    }
                }">
                    {{ Form::label('assign_role', __('Select role(s)'), ['class' => 'block text-sm font-medium text-gray-700 mb-2']) }}
                    
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <div class="grid grid-cols-3 gap-3" id="roles_grid">
                            @foreach ($userRoles as $role)
                                <div class="flex items-start role-item" 
                                    x-show="showAll || '{{ $role->department_id ?? 'null' }}' == selectedDept || '{{ $role->department_id ?? 'null' }}' == 'null'"
                                    x-transition
                                    data-dept-id="{{ $role->department_id ?? 'null' }}">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" name="assign_role[]" value="{{ $role->id }}" {{ in_array($role->id, $userAssignedRoles ?? []) ? 'checked' : '' }} class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label class="font-medium text-gray-700">{{ $role->name }}</label>
                                        <span class="text-xs text-gray-500 block">
                                            {{ $role->department_id ? 'Dept ID: ' . $role->department_id : 'All Departments' }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Role Loading Helper Button -->
                    <div class="mt-3 text-right">
                        <button type="button" id="showAllRolesBtn" @click="showAllRoles()" 
                            :class="{'bg-indigo-600 text-white': showAll, 'text-indigo-600 border border-indigo-600': !showAll}"
                            class="text-sm py-1 px-2 rounded">
                            Show All Roles
                        </button>
                        <button type="button" id="filterRolesBtn" @click="filterByDept()" 
                            :class="{'bg-indigo-600 text-white': !showAll, 'text-indigo-600 border border-indigo-600 bg-white': showAll}"
                            class="text-sm py-1 px-2 rounded ml-2">
                            Filter by Department
                        </button>
                    </div>
                    
                    <!-- Department Filter Status Message -->
                    <div class="mt-2 text-sm text-green-600" x-show="!showAll && selectedDept">
                        <span>Showing roles for selected department</span>
                    </div>
                </div>
            </div>
            
            <div class="w-full md:w-1/2 px-3 mb-4">
                {{ Form::label('status', __('Status'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                {{ Form::select('status', [
                    'active' => __('Active'),
                    'inactive' => __('Inactive')
                ], null, [
                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                    'required' => 'required'
                ]) }}
            </div>
            
            <div class="w-full md:w-1/2 px-3 mb-4">
                {{ Form::label('password', __('New Password'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                {{ Form::password('password', [
                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                    'placeholder' => __('Leave blank to keep current password')
                ]) }}
                <p class="text-xs text-gray-500 mt-1">{{ __('Leave blank to keep current password') }}</p>
            </div>
            
            <div class="w-full md:w-1/2 px-3 mb-4">
                {{ Form::label('password_confirmation', __('Confirm New Password'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                {{ Form::password('password_confirmation', [
                    'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                    'placeholder' => __('Confirm new password')
                ]) }}
            </div>
    </div>
    
    <div class="mt-4 flex justify-end space-x-3 border-t border-gray-200 pt-4">
        <button type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50" data-dismiss="modal">
            {{ __('Cancel') }}
        </button>
        {{ Form::submit(__('Update User'), ['class' => 'px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700']) }}
    </div>
</div>
{{ Form::close() }}