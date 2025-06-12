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

            <div class="p-6 overflow-y-auto max-h-[60vh]">
                <div class="flex flex-wrap -mx-2">
                    @if (\Auth::user()->type != 'super admin')
                        <div class="w-full px-3">
                            {{-- Inputs Section --}}
                            <div class="flex flex-wrap -mx-2 mb-4">
                                <div class="w-full md:w-1/2 px-2 mb-4">
                                    <div>
                                        {{ Form::label('first_name', __('First Name'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                        {{ Form::text('first_name', null, [
                                            'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                                            'placeholder' => __('Enter First Name'),
                                            'required' => 'required'
                                        ]) }}
                                    </div>
                                </div>
                                <div class="w-full md:w-1/2 px-2 mb-4">
                                    <div>
                                        {{ Form::label('last_name', __('Last Name'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                        {{ Form::text('last_name', null, [
                                            'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                                            'placeholder' => __('Enter Last Name'),
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
                                <div class="w-full md:w-1/2 px-2 mb-4">
                                    <div>
                                        {{ Form::label('department_id', __('Department'), ['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}
                                        {{ Form::select('department_id', $departments, null, [
                                            'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                                            'required' => 'required',
                                            'id' => 'department_id',
                                            'placeholder' => 'Select Department',
                                            '@change' => 'selectedDept = $event.target.value; showAll = false;'
                                        ]) }}
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Roles Section with improved Alpine.js data model --}}
                            <div class="mt-6" id="roles_container" x-data="{
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
                                    // Check for initial department value
                                    this.$nextTick(() => {
                                        const deptId = document.getElementById('department_id').value;
                                        if (deptId) {
                                            this.selectedDept = deptId;
                                            this.showAll = false;
                                            console.log('Initial department detected:', deptId);
                                        }
                                    });
                                    
                                    // Add a mutation observer to watch for department changes
                                    const deptSelect = document.getElementById('department_id');
                                    if (deptSelect) {
                                        deptSelect.addEventListener('change', () => {
                                            this.selectedDept = deptSelect.value;
                                            this.showAll = deptSelect.value ? false : true;
                                            console.log('Department changed to:', this.selectedDept);
                                        });
                                    }
                                }
                            }">
                                {{ Form::label('assign_role', __('Select role(s)'), ['class' => 'block text-sm font-medium text-gray-700 mb-2']) }}
                                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                    <div class="grid grid-cols-3 gap-3" id="roles_grid">
                                        @foreach ($userRoles as $role)
                                            <div class="flex items-start role-item" 
                                                x-show="showAll || '{{ $role->department_id ?? 'null' }}' == selectedDept || '{{ $role->department_id ?? 'null' }}' == 'null'"
                                                data-dept-id="{{ $role->department_id ?? 'null' }}">
                                                <div class="flex items-center h-5">
                                                    <input type="checkbox" name="assign_role[]" value="{{ $role->id }}" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                                </div>
                                                <div class="ml-3 text-sm">
                                                    <label class="font-medium text-gray-700">{{ $role->name }}</label>
                                                   
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
                                <div class="mt-2 text-sm" x-show="!showAll && selectedDept">
                                    <span class="text-green-600">Showing roles for selected department</span>
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
            <!-- Removed inline role-filtering JS; now included via assets/js/role-filter.js -->
        </div>
    </div>
</div>

