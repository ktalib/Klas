<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if the column already exists before adding it
        $columnExists = DB::connection('sqlsrv')->select("
            SELECT COLUMN_NAME 
            FROM INFORMATION_SCHEMA.COLUMNS 
            WHERE TABLE_NAME = 'registered_instruments' 
            AND COLUMN_NAME = 'StFileNo'
        ");

        if (empty($columnExists)) {
            DB::connection('sqlsrv')->statement("
                ALTER TABLE registered_instruments 
                ADD StFileNo NVARCHAR(255) NULL
            ");
            
            // Add index for better performance on StFileNo queries
            DB::connection('sqlsrv')->statement("
                CREATE INDEX IX_registered_instruments_StFileNo 
                ON registered_instruments (StFileNo)
            ");
        }

        // Check if completion status columns exist in subapplications table
        $completionStatusExists = DB::connection('sqlsrv')->select("
            SELECT COLUMN_NAME 
            FROM INFORMATION_SCHEMA.COLUMNS 
            WHERE TABLE_NAME = 'subapplications' 
            AND COLUMN_NAME = 'deeds_completion_status'
        ");

        if (empty($completionStatusExists)) {
            DB::connection('sqlsrv')->statement("
                ALTER TABLE subapplications 
                ADD deeds_completion_status NVARCHAR(100) NULL,
                    deeds_completion_date DATETIME2 NULL
            ");
        }

        // Try to add columns to mother_applications table if it exists
        try {
            // Check if overall completion tracking columns exist in mother_applications table
            $motherCompletionExists = DB::connection('sqlsrv')->select("
                SELECT COLUMN_NAME 
                FROM INFORMATION_SCHEMA.COLUMNS 
                WHERE TABLE_NAME = 'mother_applications' 
                AND COLUMN_NAME = 'deeds_overall_status'
            ");

            if (empty($motherCompletionExists)) {
                DB::connection('sqlsrv')->statement("
                    ALTER TABLE mother_applications 
                    ADD deeds_overall_status NVARCHAR(50) NULL,
                        deeds_completion_percentage DECIMAL(5,2) NULL,
                        deeds_total_registrations INT NULL,
                        deeds_expected_registrations INT NULL,
                        deeds_all_complete_date DATETIME2 NULL
                ");
            }
        } catch (\Exception $e) {
            // Table doesn't exist or we don't have permissions, skip this part
            // This is not critical for the main functionality
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the index first
        try {
            DB::connection('sqlsrv')->statement("
                DROP INDEX IX_registered_instruments_StFileNo 
                ON registered_instruments
            ");
        } catch (\Exception $e) {
            // Index might not exist, continue
        }

        // Drop the StFileNo column
        $columnExists = DB::connection('sqlsrv')->select("
            SELECT COLUMN_NAME 
            FROM INFORMATION_SCHEMA.COLUMNS 
            WHERE TABLE_NAME = 'registered_instruments' 
            AND COLUMN_NAME = 'StFileNo'
        ");

        if (!empty($columnExists)) {
            DB::connection('sqlsrv')->statement("
                ALTER TABLE registered_instruments 
                DROP COLUMN StFileNo
            ");
        }

        // Drop completion status columns
        $completionStatusExists = DB::connection('sqlsrv')->select("
            SELECT COLUMN_NAME 
            FROM INFORMATION_SCHEMA.COLUMNS 
            WHERE TABLE_NAME = 'subapplications' 
            AND COLUMN_NAME = 'deeds_completion_status'
        ");

        if (!empty($completionStatusExists)) {
            DB::connection('sqlsrv')->statement("
                ALTER TABLE subapplications 
                DROP COLUMN deeds_completion_status, deeds_completion_date
            ");
        }
    }
};