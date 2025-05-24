-- Insert multiple property records as sample data
INSERT INTO [dbo].[property_records]
    ([mlsFNo], [kangisFileNo], [NewKANGISFileno], [title_type], [transaction_type], 
    [transaction_date], [serialNo], [pageNo], [volumeNo], [regNo], [instrument_type], 
    [period], [period_unit], [Assignor], [Assignee], [Mortgagor], [Mortgagee], 
    [Surrenderor], [Surrenderee], [Lessor], [Lessee], [Grantor], [Grantee], 
    [property_description], [location], [plot_no], [lgsaOrCity], [layout], [schedule], 
    [created_at], [updated_at], [deleted_at], [created_by], [updated_by])
VALUES
    -- Assignment transaction
    ('COM-1234', NULL, NULL, 'Customary', 'Assignment', '2025-01-10', '45', '22', '12', 
    '45/22/12', 'Deed of Assignment', 99, 'Years', 'John Smith', 'Mary Johnson', NULL, NULL, 
    NULL, NULL, NULL, NULL, NULL, NULL, 'Commercial property with 2 storefronts', 
    'Central Business District', 'Plot-123A', 'Kano City', 'Commercial', 'Regular', 
    GETDATE(), GETDATE(), NULL, 2, 2),
    
    -- Mortgage transaction
    (NULL, 'KNML 00123', NULL, 'Statutory', 'Mortgage', '2025-02-15', '78', '15', '33', 
    '78/15/33', 'Deed of Mortgage', 25, 'Years', NULL, NULL, 'Robert Williams', 'First National Bank', 
    NULL, NULL, NULL, NULL, NULL, NULL, 'Residential property with 3 bedrooms', 
    'Sabon Gari', 'Plot-456B', 'Kano', 'Residential', 'Regular', 
    GETDATE(), GETDATE(), NULL, 2, 2),
    
    -- Lease transaction
    (NULL, NULL, 'KN7896', 'Statutory', 'Lease', '2025-03-20', '12', '45', '78', 
    '12/45/78', 'Deed of Lease', 10, 'Years', NULL, NULL, NULL, NULL, 
    NULL, NULL, 'Government of Nigeria', 'ABC Ventures Ltd', NULL, NULL,
    'Industrial warehouse with office spaces', 'Industrial Zone', 'Block-789C', 
    'Nassarawa', 'Industrial', 'Sectional', 
    GETDATE(), GETDATE(), NULL, 2, 2),
    
    -- Surrender transaction
    ('RES-7842', NULL, NULL, 'Customary', 'Surrender', '2025-04-05', '36', '21', '55', 
    '36/21/55', 'Certificate of Occupancy', NULL, NULL, NULL, NULL, NULL, NULL, 
    'David Brown', 'Local Government Authority', NULL, NULL, NULL, NULL,
    'Farmland with irrigation system', 'Agricultural District', 'Farm-101D', 
    'Garun Malam', 'Agricultural', 'Regular', 
    GETDATE(), GETDATE(), NULL, 2, 2),
    
    -- Certificate of Occupancy transaction
    (NULL, 'KNGP 00567', NULL, 'Statutory', 'Certificate of Occupancy', '2025-05-12', '89', '67', '23', 
    '89/67/23', 'Certificate of Occupancy', 99, 'Years', NULL, NULL, NULL, NULL, 
    NULL, NULL, NULL, NULL, 'Federal Government', 'Sarah Johnson', 
    'Large retail complex with parking facilities', 'Shopping District', 'Block-235E', 
    'Fagge', 'Commercial', 'Regular', 
    GETDATE(), GETDATE(), NULL, 2, 2),
    
    -- Sub-Lease transaction
    ('COM-9876', NULL, NULL, 'Customary', 'Sub-Lease', '2025-06-18', '54', '32', '76', 
    '54/32/76', 'Deed of Sublease', 5, 'Years', NULL, NULL, NULL, NULL, 
    NULL, NULL, 'XYZ Holdings Inc', 'Local Business Ltd', NULL, NULL, 
    'Office space in high-rise building', 'Business Park', 'Tower-A-Floor-3', 
    'Dala', 'Commercial', 'Sectional', 
    GETDATE(), GETDATE(), NULL, 2, 2),
    
    -- Revocation transaction
    (NULL, NULL, 'KN4321', 'Statutory', 'Revocation', '2025-07-22', '21', '98', '43', 
    '21/98/43', 'Revocation Order', NULL, NULL, NULL, NULL, NULL, NULL, 
    NULL, NULL, NULL, NULL, 'State Government', NULL, 
    'Public land for infrastructure development', 'Highway Extension Area', 'Section-789F', 
    'Gwale', 'Industrial', 'Regular', 
    GETDATE(), GETDATE(), NULL, 2, 2),
    
    -- Power of Attorney transaction
    ('RES-6543', NULL, NULL, 'Customary', 'Power of Attorney', '2025-08-14', '76', '54', '32', 
    '76/54/32', 'Power of Attorney', NULL, NULL, NULL, NULL, NULL, NULL, 
    NULL, NULL, NULL, NULL, 'Elizabeth Taylor', 'Michael Scott', 
    'Residential villa with swimming pool', 'Upscale Residential Area', 'Villa-456G', 
    'Tarauni', 'Residential', 'Regular', 
    GETDATE(), GETDATE(), NULL, 2, 2),
    
    -- Court Order transaction
    (NULL, 'MNKL 00789', NULL, 'Statutory', 'Court Order', '2025-09-30', '43', '87', '65', 
    '43/87/65', 'Court Order', NULL, NULL, NULL, NULL, NULL, NULL, 
    NULL, NULL, NULL, NULL, 'High Court of Justice', 'James Wilson', 
    'Disputed property resolved by court', 'Central District', 'Plot-567H', 
    'Kumbotso', 'Residential', 'Regular', 
    GETDATE(), GETDATE(), NULL, 2, 2),
    
    -- Devolution Order transaction
    (NULL, NULL, 'KN1122', 'Customary', 'Devolution Order', '2025-10-15', '98', '76', '54', 
    '98/76/54', 'Devolution Order', NULL, NULL, NULL, NULL, NULL, NULL, 
    NULL, NULL, NULL, NULL, 'Estate of Late Chief', 'Family Members', 
    'Ancestral family compound with multiple structures', 'Traditional Area', 'Compound-123I', 
    'Ungogo', 'Residential', 'Regular', 
    GETDATE(), GETDATE(), NULL, 2, 2);
