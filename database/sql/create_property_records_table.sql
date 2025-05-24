CREATE TABLE [dbo].[property_records] (
    [id] INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
    -- File number fields - now all can be populated simultaneously
    [mlsFNo] NVARCHAR(100) NULL,
    [kangisFileNo] NVARCHAR(100) NULL,
    [NewKANGISFileno] NVARCHAR(100) NULL,
    [title_type] NVARCHAR(50) NOT NULL,
    [transaction_type] NVARCHAR(50) NOT NULL,
    [transaction_date] DATE NOT NULL,
    -- Registration number components
    [serialNo] NVARCHAR(20) NULL,
    [pageNo] NVARCHAR(20) NULL,
    [volumeNo] NVARCHAR(20) NULL,
    [regNo] NVARCHAR(50) NULL,
    [instrument_type] NVARCHAR(100) NULL,
    [period] INT NULL,
    [period_unit] NVARCHAR(20) NULL,
    -- Party information
    [Assignor] NVARCHAR(255) NULL,
    [Assignee] NVARCHAR(255) NULL,
    [Mortgagor] NVARCHAR(255) NULL,
    [Mortgagee] NVARCHAR(255) NULL,
    [Surrenderor] NVARCHAR(255) NULL,
    [Surrenderee] NVARCHAR(255) NULL,
    [Lessor] NVARCHAR(255) NULL,
    [Lessee] NVARCHAR(255) NULL,
    [Grantor] NVARCHAR(255) NULL,
    [Grantee] NVARCHAR(255) NULL,
    -- Property information
    [property_description] NVARCHAR(MAX) NULL,
    [location] NVARCHAR(255) NULL,
    [plot_no] NVARCHAR(100) NULL,
    -- New added fields
    [lgsaOrCity] NVARCHAR(100) NULL,
    [plotNo] NVARCHAR(100) NULL,
    [layout] NVARCHAR(50) NULL,
    [schedule] NVARCHAR(50) NULL,
    -- Timestamps
    [created_at] DATETIME NOT NULL DEFAULT GETDATE(),
    [updated_at] DATETIME NOT NULL DEFAULT GETDATE(),
    [deleted_at] DATETIME NULL,
    -- User tracking fields
    [created_by] INT NULL,
    [updated_by] INT NULL
);

-- Add index to improve search performance
CREATE INDEX [IX_property_records_mlsFNo] ON [dbo].[property_records]([mlsFNo]);
CREATE INDEX [IX_property_records_kangisFileNo] ON [dbo].[property_records]([kangisFileNo]);
CREATE INDEX [IX_property_records_NewKANGISFileno] ON [dbo].[property_records]([NewKANGISFileno]);
CREATE INDEX [IX_property_records_regNo] ON [dbo].[property_records]([regNo]);

-- Add indexes for new fields to improve search performance
CREATE INDEX [IX_property_records_lgsaOrCity] ON [dbo].[property_records]([lgsaOrCity]);
CREATE INDEX [IX_property_records_layout] ON [dbo].[property_records]([layout]);

-- Create index on user tracking fields
CREATE INDEX [IX_property_records_created_by] ON [dbo].[property_records]([created_by]);
CREATE INDEX [IX_property_records_updated_by] ON [dbo].[property_records]([updated_by]);
