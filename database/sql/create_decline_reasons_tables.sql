-- Drop existing tables if they exist
IF OBJECT_ID('planning_decline_field_values', 'U') IS NOT NULL DROP TABLE planning_decline_field_values;
IF OBJECT_ID('planning_decline_sub_reasons', 'U') IS NOT NULL DROP TABLE planning_decline_sub_reasons;
IF OBJECT_ID('planning_decline_main_reasons', 'U') IS NOT NULL DROP TABLE planning_decline_main_reasons;
IF OBJECT_ID('planning_decline_reasons', 'U') IS NOT NULL DROP TABLE planning_decline_reasons;

-- Single comprehensive table for planning recommendation decline reasons
CREATE TABLE planning_decline_reasons (
    id INT IDENTITY(1,1) PRIMARY KEY,
    application_id INT NOT NULL,
    submitted_by INT NOT NULL,
    approval_date DATE,
    
    -- Main reason flags for quick filtering
    accessibility_selected BIT NOT NULL DEFAULT 0,
    land_use_selected BIT NOT NULL DEFAULT 0,
    utility_selected BIT NOT NULL DEFAULT 0,
    road_reservation_selected BIT NOT NULL DEFAULT 0,
    
    -- SIMPLIFIED FORM FIELDS - ACCESSIBILITY
    -- Mapped from accessibilitySpecificDetails textarea
    access_road_details NVARCHAR(MAX),
    -- Mapped from accessibilityObstructions textarea
    pedestrian_details NVARCHAR(MAX),
    
    -- SIMPLIFIED FORM FIELDS - LAND USE CONFORMITY
    -- Mapped from landUseDetails textarea
    zoning_details NVARCHAR(MAX),
    -- Mapped from landUseDeviations textarea
    density_details NVARCHAR(MAX),
    
    -- SIMPLIFIED FORM FIELDS - UTILITY LINE INTERFERENCE
    -- Mapped from utilityIssueDetails textarea
    overhead_details NVARCHAR(MAX),
    -- Mapped from utilityTypeDetails textarea
    underground_details NVARCHAR(MAX),
    
    -- SIMPLIFIED FORM FIELDS - ROAD RESERVATION
    -- Mapped from roadReservationIssues textarea
    right_of_way_details NVARCHAR(MAX),
    -- Mapped from roadMeasurements textarea
    road_width_details NVARCHAR(MAX),
    
    -- Complete formatted reason text (for display and reports)
    reason_summary NVARCHAR(MAX),
    
    created_at DATETIME DEFAULT GETDATE(),
    updated_at DATETIME DEFAULT GETDATE(),
    created_by NVARCHAR(50),
    updated_by NVARCHAR(50),
    
    CONSTRAINT FK_planning_decline_application FOREIGN KEY (application_id) REFERENCES applications(id),
    CONSTRAINT FK_planning_decline_user FOREIGN KEY (submitted_by) REFERENCES users(id)
);

-- Create indexes for efficient lookups
CREATE INDEX IX_planning_decline_application ON planning_decline_reasons(application_id);

-- Index on main reason flags for filtering by reason type
CREATE INDEX IX_planning_decline_main_reasons ON planning_decline_reasons(
    accessibility_selected, 
    land_use_selected, 
    utility_selected, 
    road_reservation_selected
);
