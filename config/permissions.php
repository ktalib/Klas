<?php

return [
    /*
    |--------------------------------------------------------------------------
    | User Role Levels
    |--------------------------------------------------------------------------
    |
    | This mapping defines the role levels and their priorities
    |
    */
    'role_levels' => [
        'system' => 4,        // Highest level - Super admin and System admins
        'management' => 3,    // Management level roles - Managers, Directors, etc.
        'operational' => 2,   // Operational level roles - Regular staff with specialized functions
        'user' => 1,          // Basic user level - Limited function access
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Default Permissions for Role Levels
    |--------------------------------------------------------------------------
    |
    | This defines the default permissions each role level has
    |
    */
    'level_permissions' => [
        'system' => [
            'manage user', 'create user', 'edit user', 'delete user', 'show user',
            'manage logged history', 'delete logged history',
            // All other permissions...
        ],
        'management' => [
            'manage user', 'create user', 'edit user', 'show user',
            'manage document', 'create document', 'edit document', 'delete document', 'show document',
            // Other management permissions...
        ],
        'operational' => [
            'show user', 
            'manage document', 'create document', 'edit document', 'show document',
            // Other operational permissions...
        ],
        'user' => [
            'show document',
            // Minimal permissions...
        ],
    ],
];
