<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Department;
use App\Models\UserRole;

class TestRolesAndDepartments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:roles-departments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test if departments and roles are properly configured';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Testing departments and roles setup...');
        
        // Test departments
        $departments = Department::all();
        $this->info("Found {$departments->count()} departments:");
        
        foreach($departments as $dept) {
            $this->line(" - {$dept->name} (ID: {$dept->id}, Code: {$dept->code})");
        }
        
        $this->newLine();
        
        // Test roles
        $roles = UserRole::all();
        $this->info("Found {$roles->count()} user roles:");
        
        foreach($roles as $role) {
            $deptName = $role->department ? $role->department->name : 'No Department';
            $this->line(" - {$role->name} (ID: {$role->id}, Department: {$deptName})");
        }
        
        $this->newLine();
        
        // Test a couple of department IDs to make sure roles can be found
        foreach($departments as $dept) {
            $deptRoles = UserRole::where('department_id', $dept->id)->get();
            $this->info("Department '{$dept->name}' has {$deptRoles->count()} associated roles:");
            
            foreach($deptRoles as $role) {
                $this->line(" - {$role->name} (ID: {$role->id})");
            }
            
            $this->newLine();
        }
        
        $this->info('Test completed successfully!');
        return 0;
    }
}
