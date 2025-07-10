-- SQL Script to add new fields to buyer_list table
-- Execute this script in your MS SQL Server database

-- Check if the buyer_list table exists before adding columns
IF EXISTS (SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = 'buyer_list')
BEGIN
    -- Add application_id column if it doesn't exist
    IF NOT EXISTS (SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'buyer_list' AND COLUMN_NAME = 'application_id')
    BEGIN
        ALTER TABLE buyer_list ADD [application_id] INT NULL;
        PRINT 'Added application_id column to buyer_list table';
    END
    ELSE
    BEGIN
        PRINT 'application_id column already exists in buyer_list table';
    END

    -- Add unit_measurement_id column if it doesn't exist
    IF NOT EXISTS (SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'buyer_list' AND COLUMN_NAME = 'unit_measurement_id')
    BEGIN
        ALTER TABLE buyer_list ADD [unit_measurement_id] INT NULL;
        PRINT 'Added unit_measurement_id column to buyer_list table';
    END
    ELSE
    BEGIN
        PRINT 'unit_measurement_id column already exists in buyer_list table';
    END

    -- Add buyer_title column if it doesn't exist
    IF NOT EXISTS (SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'buyer_list' AND COLUMN_NAME = 'buyer_title')
    BEGIN
        ALTER TABLE buyer_list ADD [buyer_title] NVARCHAR(50) NULL;
        PRINT 'Added buyer_title column to buyer_list table';
    END
    ELSE
    BEGIN
        PRINT 'buyer_title column already exists in buyer_list table';
    END

    -- Add buyer_name column if it doesn't exist
    IF NOT EXISTS (SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'buyer_list' AND COLUMN_NAME = 'buyer_name')
    BEGIN
        ALTER TABLE buyer_list ADD [buyer_name] NVARCHAR(255) NULL;
        PRINT 'Added buyer_name column to buyer_list table';
    END
    ELSE
    BEGIN
        PRINT 'buyer_name column already exists in buyer_list table';
    END

    -- Add unit_no column if it doesn't exist
    IF NOT EXISTS (SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'buyer_list' AND COLUMN_NAME = 'unit_no')
    BEGIN
        ALTER TABLE buyer_list ADD [unit_no] NVARCHAR(50) NULL;
        PRINT 'Added unit_no column to buyer_list table';
    END
    ELSE
    BEGIN
        PRINT 'unit_no column already exists in buyer_list table';
    END

    -- Add created_at column if it doesn't exist
    IF NOT EXISTS (SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'buyer_list' AND COLUMN_NAME = 'created_at')
    BEGIN
        ALTER TABLE buyer_list ADD [created_at] DATETIME2 NULL DEFAULT GETDATE();
        PRINT 'Added created_at column to buyer_list table';
    END
    ELSE
    BEGIN
        PRINT 'created_at column already exists in buyer_list table';
    END

    -- Add updated_at column if it doesn't exist
    IF NOT EXISTS (SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'buyer_list' AND COLUMN_NAME = 'updated_at')
    BEGIN
        ALTER TABLE buyer_list ADD [updated_at] DATETIME2 NULL DEFAULT GETDATE();
        PRINT 'Added updated_at column to buyer_list table';
    END
    ELSE
    BEGIN
        PRINT 'updated_at column already exists in buyer_list table';
    END

    -- Add final_conveyance_generated column if it doesn't exist
    IF NOT EXISTS (SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'buyer_list' AND COLUMN_NAME = 'final_conveyance_generated')
    BEGIN
        ALTER TABLE buyer_list ADD [final_conveyance_generated] BIT NULL DEFAULT 0;
        PRINT 'Added final_conveyance_generated column to buyer_list table';
    END
    ELSE
    BEGIN
        PRINT 'final_conveyance_generated column already exists in buyer_list table';
    END

    -- Add final_conveyance_generated_at column if it doesn't exist
    IF NOT EXISTS (SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'buyer_list' AND COLUMN_NAME = 'final_conveyance_generated_at')
    BEGIN
        ALTER TABLE buyer_list ADD [final_conveyance_generated_at] DATETIME2 NULL;
        PRINT 'Added final_conveyance_generated_at column to buyer_list table';
    END
    ELSE
    BEGIN
        PRINT 'final_conveyance_generated_at column already exists in buyer_list table';
    END

    PRINT 'All buyer_list table updates completed successfully';
END
ELSE
BEGIN
    PRINT 'buyer_list table does not exist. Please create the table first.';
END

-- Optional: Create the buyer_list table if it doesn't exist
IF NOT EXISTS (SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = 'buyer_list')
BEGIN
    CREATE TABLE buyer_list (
        [id] INT IDENTITY(1,1) PRIMARY KEY,
        [application_id] INT NULL,
        [unit_measurement_id] INT NULL,
        [buyer_title] NVARCHAR(50) NULL,
        [buyer_name] NVARCHAR(255) NULL,
        [unit_no] NVARCHAR(50) NULL,
        [created_at] DATETIME2 NULL DEFAULT GETDATE(),
        [updated_at] DATETIME2 NULL DEFAULT GETDATE(),
        [final_conveyance_generated] BIT NULL DEFAULT 0,
        [final_conveyance_generated_at] DATETIME2 NULL
    );
    PRINT 'Created buyer_list table with all required columns';
END

-- Add indexes for better performance
IF EXISTS (SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = 'buyer_list')
BEGIN
    -- Index on application_id for faster lookups
    IF NOT EXISTS (SELECT * FROM sys.indexes WHERE name = 'IX_buyer_list_application_id')
    BEGIN
        CREATE INDEX IX_buyer_list_application_id ON buyer_list (application_id);
        PRINT 'Created index on application_id';
    END

    -- Index on unit_no for faster unit lookups
    IF NOT EXISTS (SELECT * FROM sys.indexes WHERE name = 'IX_buyer_list_unit_no')
    BEGIN
        CREATE INDEX IX_buyer_list_unit_no ON buyer_list (unit_no);
        PRINT 'Created index on unit_no';
    END

    -- Index on unit_measurement_id for joins
    IF NOT EXISTS (SELECT * FROM sys.indexes WHERE name = 'IX_buyer_list_unit_measurement_id')
    BEGIN
        CREATE INDEX IX_buyer_list_unit_measurement_id ON buyer_list (unit_measurement_id);
        PRINT 'Created index on unit_measurement_id';
    END
END

PRINT 'Database update script completed successfully';