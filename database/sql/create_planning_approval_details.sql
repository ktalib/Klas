-- Create table for planning approval additional details
IF OBJECT_ID('planning_approval_details', 'U') IS NULL
BEGIN
    CREATE TABLE planning_approval_details (
        id INT IDENTITY(1,1) PRIMARY KEY,
        application_id INT NOT NULL,
        additional_observations NVARCHAR(MAX),
        created_at DATETIME DEFAULT GETDATE(),
        updated_at DATETIME DEFAULT GETDATE(),
        created_by NVARCHAR(50),
        updated_by NVARCHAR(50),
        
        CONSTRAINT FK_planning_approval_application FOREIGN KEY (application_id) REFERENCES applications(id)
    );
    
    -- Create index for efficient lookups
    CREATE INDEX IX_planning_approval_application ON planning_approval_details(application_id);
END
