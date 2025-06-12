<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\UserRole;
use Illuminate\Support\Facades\DB;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create test departments if none exist
        if (Department::count() == 0) {
            $departments = [
                ['name' => 'Administration', 'code' => 'ADMIN', 'description' => 'Administrative department', 'is_active' => 1],
                ['name' => 'Finance', 'code' => 'FIN', 'description' => 'Finance department', 'is_active' => 1],
                ['name' => 'Human Resources', 'code' => 'HR', 'description' => 'Human Resources department', 'is_active' => 1],
                ['name' => 'IT', 'code' => 'IT', 'description' => 'Information Technology department', 'is_active' => 1],
                ['name' => 'Operations', 'code' => 'OPS', 'description' => 'Operations department', 'is_active' => 1],
            ];
            
            foreach ($departments as $dept) {
                Department::create($dept);
            }
        }
        
        // Get department IDs
        $admin_dept_id = Department::where('code', 'ADMIN')->first()->id ?? null;
        $it_dept_id = Department::where('code', 'IT')->first()->id ?? null;
        
        // Create user roles
        $roles = [
            // Admin department roles
            [
                'name' => 'Administrator',
                'guard_name' => 'web',
                'description' => 'System administrator with full access',
                'department_id' => $admin_dept_id,
                'level' => 'system',
                'is_active' => 1,
            ],
            [
                'name' => 'Manager',
                'guard_name' => 'web',
                'description' => 'Department manager',
                'department_id' => $admin_dept_id,
                'level' => 'management',
                'is_active' => 1,
            ],
            [
                'name' => 'Staff',
                'guard_name' => 'web',
                'description' => 'Regular staff member',
                'department_id' => $admin_dept_id,
                'level' => 'operational',
                'is_active' => 1,
            ],
            
            // IT department roles
            [
                'name' => 'IT Admin',
                'guard_name' => 'web',
                'description' => 'IT administrator',
                'department_id' => $it_dept_id,
                'level' => 'system',
                'is_active' => 1,
            ],
            [
                'name' => 'Developer',
                'guard_name' => 'web',
                'description' => 'Software developer',
                'department_id' => $it_dept_id,
                'level' => 'operational',
                'is_active' => 1,
            ],
            [
                'name' => 'Support',
                'guard_name' => 'web',
                'description' => 'Technical support',
                'department_id' => $it_dept_id,
                'level' => 'operational',
                'is_active' => 1,
            ],
            
            // General roles (no department)
            [
                'name' => 'Guest',
                'guard_name' => 'web',
                'description' => 'Limited access guest user',
                'department_id' => null,
                'level' => 'user',
                'is_active' => 1,
            ],
            [
                'name' => 'Viewer',
                'guard_name' => 'web',
                'description' => 'Read-only access',
                'department_id' => null,
                'level' => 'user',
                'is_active' => 1,
            ],
        ];
        
        foreach ($roles as $role) {
            // Check if role already exists
            $existingRole = UserRole::where('name', $role['name'])
                                  ->where('department_id', $role['department_id'])
                                  ->first();
            
            if (!$existingRole) {
                UserRole::create($role);
            }
        }
        
        echo "User roles seeded successfully!\n";
    }
}
