-- Create instrument_particulars_log table
-- This table logs each generated particulars registration number
CREATE TABLE instrument_particulars_log (
    id INT IDENTITY(1,1) PRIMARY KEY,
    instrument_id INT NULL,
    serial_no INT NOT NULL,
    page_no INT NOT NULL,
    volume_no INT NOT NULL,
    generated_particulars_number NVARCHAR(255) NOT NULL,
    created_at DATETIME NULL,
    updated_at DATETIME NULL,
    CONSTRAINT FK_instrument_particulars_log_instrument_registration FOREIGN KEY (instrument_id)
    REFERENCES instrument_registration(id) ON DELETE SET NULL
);
