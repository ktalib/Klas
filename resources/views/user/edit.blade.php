<div class="modal-dialog shadow-none" role="document">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">{{ __('Edit User') }}</h3>
                <button type="button" class="text-gray-400 hover:text-gray-500 absolute top-4 right-4" data-dismiss="modal">
                    <span class="sr-only">Close</span>
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            {{ Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'PUT']) }}
            <div class="p-6 overflow-y-auto max-h-[60vh]">
                <div class="flex flex-wrap -mx-2" x-data="{
                    userType: '{{ old('user_type', $user->user_type) }}',
                    selectedDept: '{{ old('department_id', $user->department_id) }}',
                    showAll: {{ old('department_id', $user->department_id) ? 'false' : 'true' }},
                    get userLevel() {
                        switch(this.userType) {
                            case 'ALL': case 'User': return 'Lowest';
                            case 'Management': case 'System_Highest': return 'Highest';
                            case 'Operations': case 'System_High': return 'High';
                            default: return '';
                        }
                    },
                    isRoleAllowed(name) {
                        const n = name.toLowerCase();
                        if ((this.userType === 'Operations' || this.userType === 'User') &&
                            (n.includes('approval') || n === 'st - planning recommendation')) return false;
                        return true;
                    },
                    init() {
                        const ut = document.getElementById('user_type');
                        if (ut) ut.addEventListener('change', e => this.userType = e.target.value);
                        this.$nextTick(() => { if (this.selectedDept) this.showAll = false; });
                    },
                    checkAll() { document.querySelectorAll('#roles_grid > div[x-show]').forEach(el => el.offsetParent!==null && (el.querySelector('input').checked = true)); },
                    uncheckAll() { document.querySelectorAll('#roles_grid > div[x-show]').forEach(el => el.offsetParent!==null && (el.querySelector('input').checked = false)); }
                }" x-init="init()">

                    <!-- Username -->
                    <div class="w-full md:w-1/2 px-2 mb-4">
                        {{ Form::label('username', __('Username'), ['class'=>'block text-sm font-medium text-gray-700 mb-1']) }}
                        {{ Form::text('username', null, ['class'=>'w-full p-2 border rounded text-sm','placeholder'=>__('Enter Username'),'required']) }}
                    </div>
                    <!-- Password -->
                    <div class="w-full md:w-1/2 px-2 mb-4">
                        {{ Form::label('password', __('New Password'), ['class'=>'block text-sm font-medium text-gray-700 mb-1']) }}
                        {{ Form::password('password', ['class'=>'w-full p-2 border rounded text-sm','placeholder'=>__('Leave blank to keep current password')]) }}
                        <p class="text-xs text-gray-500 mt-1">{{ __('Leave blank to keep current password') }}</p>
                    </div>
                    <!-- First Name -->
                    <div class="w-full md:w-1/2 px-2 mb-4">
                        {{ Form::label('first_name', __('First Name'), ['class'=>'block text-sm font-medium text-gray-700 mb-1']) }}
                        {{ Form::text('first_name', null, ['class'=>'w-full p-2 border rounded text-sm','placeholder'=>__('Enter First Name'),'required']) }}
                    </div>
                    <!-- Last Name -->
                    <div class="w-full md:w-1/2 px-2 mb-4">
                        {{ Form::label('last_name', __('Last Name'), ['class'=>'block text-sm font-medium text-gray-700 mb-1']) }}
                        {{ Form::text('last_name', null, ['class'=>'w-full p-2 border rounded text-sm','placeholder'=>__('Enter Last Name'),'required']) }}
                    </div>
                    <!-- Phone Number -->
                    <div class="w-full md:w-1/2 px-2 mb-4">
                        {{ Form::label('phone_number', __('Phone Number'), ['class'=>'block text-sm font-medium text-gray-700 mb-1']) }}
                        {{ Form::text('phone_number', null, ['class'=>'w-full p-2 border rounded text-sm','placeholder'=>__('Enter Phone Number')]) }}
                    </div>
                    <!-- Email -->
                    <div class="w-full md:w-1/2 px-2 mb-4">
                        {{ Form::label('email', __('Email'), ['class'=>'block text-sm font-medium text-gray-700 mb-1']) }}
                        {{ Form::text('email', null, ['class'=>'w-full p-2 border rounded text-sm','placeholder'=>__('Enter Email'),'required']) }}
                    </div>
                    <!-- User Type -->
                    <div class="w-full md:w-1/2 px-2 mb-4">
                        {{ Form::label('user_type', __('User Type'), ['class'=>'block text-sm font-medium text-gray-700 mb-1']) }}
                        <select id="user_type" name="user_type" class="w-full p-2 border rounded text-sm" x-model="userType" required>
                            <option value="">Select User Type</option>
                            <option value="ALL">ALL</option>
                            <option value="Management">Management</option>
                            <option value="Operations">Operations</option>
                            <option value="User">User</option>
                            <option value="System_Highest">System (Highest)</option>
                            <option value="System_High">System (High)</option>
                        </select>
                    </div>
                    <!-- User Level -->
                    <div class="w-full md:w-1/2 px-2 mb-4">
                        {{ Form::label('user_level', __('User Level'), ['class'=>'block text-sm font-medium text-gray-700 mb-1']) }}
                        <input type="text" id="user_level" name="user_level" class="w-full p-2 border rounded text-sm bg-gray-100" x-bind:value="userLevel" readonly>
                    </div>
                    <!-- Department -->
                    <div class="w-full md:w-1/2 px-2 mb-4">
                        {{ Form::label('department_id', __('Department'), ['class'=>'block text-sm font-medium text-gray-700 mb-1']) }}
                        {{ Form::select('department_id',$departments, null,['class'=>'w-full p-2 border rounded text-sm','id'=>'department_id','placeholder'=>'Select Department','required','@change'=>'selectedDept=$event.target.value;showAll=false']) }}
                    </div>
                    <!-- Roles -->
                    <div class="w-full px-2 mb-4" id="roles_container" x-data="{
    selectedDept: (function() {
        const dept = document.getElementById('department_id');
        return dept ? dept.value : null;
    })(),
    showAll: {{ old('department_id', $user->department_id) ? 'false' : 'true' }},
    userType: '{{ old('user_type', $user->user_type) }}',
    checkAll() {
        document.querySelectorAll('#roles_grid > div[x-show]').forEach(el => {
            if (el.offsetParent !== null) {
                el.querySelector('input[type=checkbox]').checked = true;
            }
        });
    },
    uncheckAll() {
        document.querySelectorAll('#roles_grid > div[x-show]').forEach(el => {
            if (el.offsetParent !== null) {
                el.querySelector('input[type=checkbox]').checked = false;
            }
        });
    },
    filterByDept() {
        this.selectedDept = document.getElementById('department_id').value;
        this.showAll = false;
    },
    showAllRoles() {
        this.showAll = true;
    },
    shouldShowRole(roleName) {
        const hideForOpsOrUser = [
            'Approvals',
            'Director\'s Approval',
            'Director SLTR',
            'Planning Recommendation',
            'Reports'
        ];
        const normalized = roleName.toLowerCase();
        if (['Operations', 'User'].includes(this.userType)) {
            return !hideForOpsOrUser.some(keyword => normalized.includes(keyword.toLowerCase()));
        }
        return true;
    },
    init() {
        const ut = document.getElementById('user_type');
        if (ut) ut.addEventListener('change', e => this.userType = e.target.value);
        this.$nextTick(() => {
            const deptId = document.getElementById('department_id').value;
            if (deptId) {
                this.selectedDept = deptId;
                this.showAll = false;
            }
        });
        const deptSelect = document.getElementById('department_id');
        if (deptSelect) {
            deptSelect.addEventListener('change', () => {
                this.selectedDept = deptSelect.value;
                this.showAll = deptSelect.value ? false : true;
            });
        }
    }
}" x-init="init()">
                        {{ Form::label('assign_role', __('Select role(s)'), ['class'=>'block text-sm font-medium text-gray-700 mb-2']) }}
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <div class="mb-3 flex gap-2">
                                <button type="button" @click="checkAll" class="text-xs py-1 px-2 rounded bg-green-500 text-white hover:bg-green-600">Check All</button>
                                <button type="button" @click="uncheckAll" class="text-xs py-1 px-2 rounded bg-red-500 text-white hover:bg-red-600">Uncheck All</button>
                            </div>
                            <div class="grid grid-cols-3 gap-3" id="roles_grid">
                                @foreach($userRoles as $role)
                                    <div class="flex items-start"
                                        x-show="(
                                            '{{ $role->user_type ?? '' }}' === 'ALL' ||
                                            showAll ||
                                            '{{ $role->department_id ?? 'null' }}' == selectedDept ||
                                            '{{ $role->department_id ?? 'null' }}' == 'null'
                                        ) && shouldShowRole(`{{ $role->name }}`)"
                                        data-dept-id="{{ $role->department_id ?? 'null' }}">
                                        <div class="flex items-center h-5">
                                            <input type="checkbox" name="assign_role[]" value="{{ $role->id }}"
                                                @checked(in_array($role->id, old('assign_role', $userAssignedRoles ?? [])))
                                                class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label class="font-medium text-gray-700">{{ $role->name }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
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
                        <div class="mt-2 text-sm" x-show="!showAll && selectedDept">
                            <span class="text-green-600">Showing roles for selected department</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-6 py-3 bg-gray-50 text-right">
                {{ Form::submit(__('Save Changes'), ['class'=>'inline-flex justify-center py-2 px-4 bg-indigo-600 text-white rounded']) }}
                <button type="button" class="ml-2 inline-flex justify-center py-2 px-4 bg-white text-gray-700 rounded border" data-dismiss="modal">{{ __('Cancel') }}</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>