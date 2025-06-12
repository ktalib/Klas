<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\UserRole;
use App\Models\Department;

class DebugController extends Controller
{
    /**
     * Show debug information about departments and roles
     * Access this at /debug/roles-departments
     */
    public function rolesDepartments()
    {
        // Only allow in development environment
        if (app()->environment('production')) {
            return response()->json(['error' => 'Not available in production'], 403);
        }
        
        $departments = Department::withCount('userRoles')->get();
        $orphanedRoles = UserRole::whereDoesntHave('department')->get();
        $allRoles = UserRole::with('department')->get();
        
        $data = [
            'departments' => $departments->map(function($dept) {
                return [
                    'id' => $dept->id,
                    'name' => $dept->name,
                    'role_count' => $dept->user_roles_count,
                ];
            }),
            'orphaned_roles' => $orphanedRoles->map(function($role) {
                return [
                    'id' => $role->id,
                    'name' => $role->name,
                ];
            }),
            'all_roles' => $allRoles->map(function($role) {
                return [
                    'id' => $role->id,
                    'name' => $role->name,
                    'department_id' => $role->department_id,
                    'department_name' => $role->department ? $role->department->name : null,
                ];
            }),
        ];
        
        return response()->json($data);
    }

    /**
     * Debug method to check if roles exist in the database
     */
    public function checkUserRoles()
    {
        $output = [
            'status' => 'success',
            'message' => 'Debug information for user roles',
            'time' => now()->format('Y-m-d H:i:s'),
        ];
        
        try {
            // Check if the table exists
            $tableExists = DB::connection('sqlsrv')
                ->select("SELECT OBJECT_ID('user_roles', 'U') as table_exists")[0]->table_exists ?? false;
            
            $output['table_exists'] = $tableExists ? 'Yes' : 'No';
            
            if (!$tableExists) {
                $output['status'] = 'error';
                $output['message'] = 'user_roles table does not exist!';
                return response()->json($output);
            }
            
            // Get count
            $roleCount = DB::connection('sqlsrv')->table('user_roles')->count();
            $output['total_roles'] = $roleCount;
            
            // Check column names
            $columns = DB::connection('sqlsrv')->select("EXEC sp_columns 'user_roles'");
            $columnNames = [];
            foreach ($columns as $col) {
                $columnNames[] = $col->COLUMN_NAME;
            }
            $output['columns'] = $columnNames;
            
            // Get sample data
            $roles = DB::connection('sqlsrv')->table('user_roles')
                ->select('*')
                ->limit(10)
                ->get();
            
            $output['sample_roles'] = $roles;
            
            // Count by department
            $rolesByDept = DB::connection('sqlsrv')->table('user_roles')
                ->select(DB::raw('department_id, COUNT(*) as count'))
                ->groupBy('department_id')
                ->get();
            
            $output['roles_by_dept'] = $rolesByDept;
            
            // List departments
            $departments = Department::all(['id', 'name', 'code']);
            $output['departments'] = $departments;
            
            return response()->json($output);
            
        } catch (\Exception $e) {
            $output['status'] = 'error';
            $output['message'] = 'Error: ' . $e->getMessage();
            $output['trace'] = $e->getTraceAsString();
            return response()->json($output, 500);
        }
    }

    /**
     * Add sample roles to the database if none exist
     */
    public function addSampleRoles()
    {
        try {
            $count = UserRole::count();
            
            if ($count > 0) {
                return response()->json([
                    'status' => 'info',
                    'message' => "There are already {$count} roles in the database. No sample roles added.",
                ]);
            }
            
            $departments = Department::all();
            
            if ($departments->isEmpty()) {
                // Create a sample department if none exists
                $dept = Department::create([
                    'name' => 'Sample Department',
                    'code' => 'SAMPLE',
                    'description' => 'Sample department created by debug controller',
                    'is_active' => 1
                ]);
                
                $departmentId = $dept->id;
            } else {
                $departmentId = $departments->first()->id;
            }
            
            // Create sample roles
            $sampleRoles = [
                [
                    'name' => 'Administrator',
                    'guard_name' => 'web',
                    'description' => 'Administrator role with full access',
                    'department_id' => $departmentId,
                    'level' => 'system',
                    'is_active' => 1,
                ],
                [
                    'name' => 'Manager',
                    'guard_name' => 'web',
                    'description' => 'Manager role',
                    'department_id' => $departmentId,
                    'level' => 'management',
                    'is_active' => 1,
                ],
                [
                    'name' => 'Staff',
                    'guard_name' => 'web',
                    'description' => 'Regular staff role',
                    'department_id' => $departmentId,
                    'level' => 'operational',
                    'is_active' => 1,
                ],
                [
                    'name' => 'General Role',
                    'guard_name' => 'web',
                    'description' => 'Role not tied to any department',
                    'department_id' => null,
                    'level' => 'user',
                    'is_active' => 1,
                ],
            ];
            
            foreach ($sampleRoles as $role) {
                UserRole::create($role);
            }
            
            return response()->json([
                'status' => 'success',
                'message' => 'Added 4 sample roles to the database',
                'roles' => $sampleRoles,
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ], 500);
        }
    }
}
