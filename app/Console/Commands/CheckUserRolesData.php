<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckUserRolesData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:user-roles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if the user_roles table has the correct data structure';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking user_roles table structure...');
        
        try {
            // Check if the table exists
            $tableExists = DB::connection('sqlsrv')->select("SELECT OBJECT_ID('user_roles', 'U') as table_exists")[0]->table_exists;
            
            if (!$tableExists) {
                $this->error('The table user_roles does not exist!');
                return 1;
            }
            
            // Check columns
            $columns = DB::connection('sqlsrv')->select("EXEC sp_columns 'user_roles'");
            $this->info('Columns found: ' . count($columns));
            
            $requiredColumns = ['id', 'name', 'department_id', 'is_active'];
            $missingColumns = [];
            
            $columnNames = array_map(function($col) {
                return $col->COLUMN_NAME;
            }, $columns);
            
            $this->info('Column names: ' . implode(', ', $columnNames));
            
            foreach ($requiredColumns as $col) {
                if (!in_array($col, $columnNames)) {
                    $missingColumns[] = $col;
                }
            }
            
            if (count($missingColumns) > 0) {
                $this->error('Missing required columns: ' . implode(', ', $missingColumns));
                return 1;
            }
            
            // Check data
            $roles = DB::connection('sqlsrv')->table('user_roles')
                ->select('id', 'name', 'department_id', 'is_active')
                ->get();
            
            $this->info('Total roles found: ' . count($roles));
            
            if (count($roles) === 0) {
                $this->warn('No roles found in the user_roles table!');
                
                // Create some test roles
                $this->info('Creating test roles...');
                $this->createTestRoles();
                return 0;
            }
            
            // Group by departments
            $rolesByDept = [];
            foreach ($roles as $role) {
                $deptId = $role->department_id ?: 'null';
                if (!isset($rolesByDept[$deptId])) {
                    $rolesByDept[$deptId] = [];
                }
                $rolesByDept[$deptId][] = $role;
            }
            
            foreach ($rolesByDept as $deptId => $deptRoles) {
                $this->info("Department $deptId has " . count($deptRoles) . " roles:");
                foreach ($deptRoles as $role) {
                    $this->line(" - ID: {$role->id}, Name: {$role->name}, Active: {$role->is_active}");
                }
            }
            
            $this->info('User_roles table check completed successfully!');
            
        } catch (\Exception $e) {
            $this->error('Error checking user_roles: ' . $e->getMessage());
            $this->error($e->getTraceAsString());
            return 1;
        }
        
        return 0;
    }

    /**
     * Create test roles if none exist
     */
    protected function createTestRoles()
    {
        // Get first department
        $department = DB::connection('sqlsrv')->table('departments')->first();
        $departmentId = $department ? $department->id : null;
        
        // Create roles
        $roles = [
            [
                'name' => 'Administrator',
                'guard_name' => 'web',
                'department_id' => $departmentId,
                'level' => 'system',
                'is_active' => 1,
            ],
            [
                'name' => 'Manager',
                'guard_name' => 'web',
                'department_id' => $departmentId,
                'level' => 'management',
                'is_active' => 1,
            ],
            [
                'name' => 'User',
                'guard_name' => 'web',
                'department_id' => null, // General role
                'level' => 'operational',
                'is_active' => 1,
            ]
        ];
        
        foreach ($roles as $role) {
            DB::connection('sqlsrv')->table('user_roles')->insert($role);
            $this->info("Created role: {$role['name']}");
        }
    }
}
