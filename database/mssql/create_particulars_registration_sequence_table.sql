-- Create particulars_registration_sequence table 
-- This table tracks the last used values for generating particulars registration numbers
CREATE TABLE particulars_registration_sequence (
    id INT IDENTITY(1,1) PRIMARY KEY,
    last_serial_no INT DEFAULT 0,
    last_page_no INT DEFAULT 0,
    last_volume_no INT DEFAULT 1,
    updated_at DATETIME NULL
);

-- Initialize the sequence with starting values
-- This will allow the first generated number to be 1/1/1
INSERT INTO particulars_registration_sequence (last_serial_no, last_page_no, last_volume_no, updated_at)
VALUES (0, 0, 1, GETDATE());
