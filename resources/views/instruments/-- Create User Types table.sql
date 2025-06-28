-- Dashboard (0)
INSERT INTO [klas].[dbo].[user_roles] 
([name], [guard_name], [description], [department_id], [level], [user_type], [is_active])
VALUES 
('Dashboard', 'dashboard.access', 'Dashboard access for all users', NULL, 'Lowest', 'ALL', 1);

-- CUSTOMER RELATIONSHIP MANAGEMENT (1-8)
INSERT INTO [klas].[dbo].[user_roles] 
([name], [guard_name], [description], [department_id], [level], [user_type], [is_active])
VALUES 
('Person', 'crm.person.manage', 'Person management', NULL, 'Lowest', 'ALL', 1),
('Individual', 'crm.individual.manage', 'Individual management', NULL, 'Lowest', 'ALL', 1),
('Group', 'crm.group.manage', 'Group management', NULL, 'Lowest', 'ALL', 1),
('Family', 'crm.family.manage', 'Family management', NULL, 'Lowest', 'ALL', 1),
('Corporate', 'crm.corporate.manage', 'Corporate management', NULL, 'Lowest', 'ALL', 1),
('Customer Manager', 'csu.customer.manager', 'Customer Manager', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'CSU'), 'High', 'Operations', 1),
('Appointment', 'csu.appointment.manage', 'Appointment management', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'CSU'), 'High', 'Operations', 1),
('Appointment Calendar', 'csu.appointment.calendar', 'Appointment Calendar', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'CSU'), 'High', 'Operations', 1);

-- PROGRAMMES (9-19)
INSERT INTO [klas].[dbo].[user_roles] 
([name], [guard_name], [description], [department_id], [level], [user_type], [is_active])
VALUES 
('Allocation', 'lands.allocation.manage', 'Land allocation management', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'LANDS'), 'Highest', 'Management', 1),
('Governors List', 'mgmt.governors.list', 'Governors List management', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'MGMT'), 'Highest', 'Management', 1),
('Commissioners List', 'mgmt.commissioners.list', 'Commissioners List management', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'MGMT'), 'Highest', 'Management', 1),
('Compensation/Resettlement', 'survey.compensation.manage', 'Compensation/Resettlement management', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'SURVEY'), 'High', 'Operations', 1),
('Recertification', 'gis.recertification.manage', 'Land recertification management', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'GIS'), 'High', 'Operations', 1),
('Conversion/Regularization', 'lands.conversion.manage', 'Conversion/Regularization management', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'LANDS'), 'High', 'Operations', 1),
('Land Property Enumeration', 'gis.enumeration.manage', 'Land Property Enumeration', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'GIS'), 'High', 'Operations', 1),
('Data Repository', 'gis.repository.manage', 'Data Repository management', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'GIS'), 'High', 'Operations', 1),
('Migrate Data', 'gis.migration.manage', 'Data migration management', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'GIS'), 'High', 'Operations', 1);

-- Continue with the rest of the roles in the same format...
-- INFORMATION PRODUCTS (20-24)
INSERT INTO [klas].[dbo].[user_roles] 
([name], [guard_name], [description], [department_id], [level], [user_type], [is_active])
VALUES 
('Letter of Administration/Grant/Offer Letter', 'lands.letter.admin', 'Letter of Administration/Grant/Offer Letter', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'LANDS'), 'Highest', 'Management', 1),
('Occupancy Permit (OP)', 'gis.occupancy.permit', 'Occupancy Permit (OP)', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'GIS'), 'High', 'Operations', 1),
('Site Plan/Parcel Plan', 'survey.siteplan.manage', 'Site Plan/Parcel Plan management', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'SURVEY'), 'High', 'Operations', 1),
('Right of Occupancy', 'lands.rofo.manage', 'Right of Occupancy management', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'LANDS'), 'Highest', 'Management', 1),
('Certificate of Occupancy', 'gis.cofo.manage', 'Certificate of Occupancy management', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'GIS'), 'High', 'Operations', 1);

-- REVENUE MANAGEMENT (25-30)
INSERT INTO [klas].[dbo].[user_roles] 
([name], [guard_name], [description], [department_id], [level], [user_type], [is_active])
VALUES 
('Billing', 'finance.billing.manage', 'Billing management', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'ACCT'), 'High', 'Operations', 1),
('Automated Billing', 'finance.billing.auto', 'Automated Billing', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'ACCT'), 'High', 'Operations', 1),
('Legacy Billing', 'finance.billing.legacy', 'Legacy Billing', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'ACCT'), 'High', 'Operations', 1),
('Generate Receipt', 'finance.receipt.generate', 'Generate Receipt', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'ACCT'), 'High', 'Operations', 1),
('Land Use Charge (LUC)', 'lands.luc.manage', 'Land Use Charge (LUC)', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'LANDS'), 'High', 'Operations', 1),
('Bill Balance', 'deeds.bill.balance', 'Bill Balance management', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'DEEDS'), 'High', 'Operations', 1);

-- Continue from previous sections...

-- DEEDS (31-35)
INSERT INTO [klas].[dbo].[user_roles] 
([name], [guard_name], [description], [department_id], [level], [user_type], [is_active])
VALUES 
('Deeds - Property Records Assistant (Legacy Records)', 'deeds.property.records.legacy', 'Deeds - Property Records Assistant (Legacy Records)', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'DEEDS'), 'Lowest', 'User', 1),
('Deeds – AI Digital Assistant', 'deeds.ai.assistant', 'Deeds – AI Digital Assistant', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'DEEDS'), 'Lowest', 'User', 1),
('Deeds - Instrument Capture (New Records)', 'deeds.instrument.capture', 'Deeds - Instrument Capture (New Records)', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'DEEDS'), 'High', 'Operations', 1),
('Deeds - Instrument Registration (New Registration)', 'deeds.instrument.registration', 'Deeds - Instrument Registration (New Registration)', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'DEEDS'), 'High', 'Operations', 1),
('Deeds - Instrument Registration Reports', 'deeds.instrument.reports', 'Deeds - Instrument Registration Reports', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'DEEDS'), 'Highest', 'Management', 1);

-- SEARCH (36-38)
INSERT INTO [klas].[dbo].[user_roles] 
([name], [guard_name], [description], [department_id], [level], [user_type], [is_active])
VALUES 
('Deeds - Official (for filing purpose)', 'deeds.search.official', 'Deeds - Official (for filing purpose)', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'DEEDS'), 'High', 'Operations', 1),
('Deeds - On-Premise (Pay-Per-Search)', 'deeds.search.onpremise', 'Deeds - On-Premise (Pay-Per-Search)', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'DEEDS'), 'High', 'Operations', 1),
('Deeds - Legal Search Reports', 'deeds.search.legal.reports', 'Deeds - Legal Search Reports', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'DEEDS'), 'High', 'Operations', 1);

-- LANDS (39-47)
INSERT INTO [klas].[dbo].[user_roles] 
([name], [guard_name], [description], [department_id], [level], [user_type], [is_active])
VALUES 
('Lands - File Tracker/Tracking - RFID', 'lands.file.tracker.rfid', 'Lands - File Tracker/Tracking - RFID', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'LANDS'), 'High', 'Operations', 1),
('Lands - File Digital Archive – Doc-WARE', 'lands.file.digital.archive', 'Lands - File Digital Archive – Doc-WARE', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'LANDS'), 'High', 'Operations', 1),
('EDMS - Indexing', 'edms.indexing', 'EDMS - Indexing', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'LANDS'), 'High', 'Operations', 1),
('EDMS – AI Digital Assistant', 'edms.ai.assistant', 'EDMS – AI Digital Assistant', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'LANDS'), 'High', 'Operations', 1),
('EDMS - File Indexing Assistant', 'edms.file.indexing.assistant', 'EDMS - File Indexing Assistant', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'LANDS'), 'High', 'Operations', 1),
('EDMS - Print File Labels', 'edms.print.file.labels', 'EDMS - Print File Labels', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'LANDS'), 'High', 'Operations', 1),
('EDMS - Scanning', 'edms.scanning', 'EDMS - Scanning', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'LANDS'), 'Lowest', 'User', 1),
('EDMS - Upload', 'edms.upload', 'EDMS - Upload', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'LANDS'), 'Lowest', 'User', 1),
('EDMS - Download', 'edms.download', 'EDMS - Download', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'LANDS'), 'Lowest', 'User', 1),
('EDMS - PageTyping', 'edms.pagetyping', 'EDMS - PageTyping', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'LANDS'), 'Lowest', 'User', 1);

-- PHYSICAL PLANNING (48-57)
INSERT INTO [klas].[dbo].[user_roles] 
([name], [guard_name], [description], [department_id], [level], [user_type], [is_active])
VALUES 
('PP - Regular Applications', 'pp.regular.applications', 'PP - Regular Applications', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'PP'), 'High', 'Operations', 1),
('PP - Memo', 'pp.memo', 'PP - Memo', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'PP'), 'High', 'Operations', 1),
('PP - Planning Recommendation', 'pp.planning.recommendation', 'PP - Planning Recommendation', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'PP'), 'Highest', 'Management', 1),
('PP - SLTR Applications', 'pp.sltr.applications', 'PP - SLTR Applications', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'PP'), 'High', 'Operations', 1),
('PP - Memo (SLTR)', 'pp.memo.sltr', 'PP - Memo (SLTR)', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'PP'), 'High', 'Operations', 1),
('PP - Planning Recommendation (SLTR)', 'pp.planning.recommendation.sltr', 'PP - Planning Recommendation (SLTR)', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'PP'), 'Highest', 'Management', 1),
('PP Reports', 'pp.reports', 'PP Reports', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'PP'), 'Highest', 'Management', 1);

-- SURVEY (58-63)
INSERT INTO [klas].[dbo].[user_roles] 
([name], [guard_name], [description], [department_id], [level], [user_type], [is_active])
VALUES 
('Survey - Records', 'survey.records', 'Survey - Records', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'SURVEY'), 'High', 'Operations', 1),
('Survey – AI Digital Assistant', 'survey.ai_assistant', 'Survey – AI Digital Assistant', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'SURVEY'), 'High', 'Operations', 1),
('Survey - GIS', 'survey.gis', 'Survey - GIS', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'SURVEY'), 'High', 'Operations', 1),
('Survey - Approvals', 'survey.approvals', 'Survey - Approvals', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'SURVEY'), 'Highest', 'Management', 1),
('Survey - E-Registry', 'survey.e_registry', 'Survey - E-Registry', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'SURVEY'), 'High', 'Operations', 1),
('Survey Reports', 'survey.reports', 'Survey Reports', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'SURVEY'), 'High', 'Operations', 1);

-- CADASTRAL (64-69)
INSERT INTO [klas].[dbo].[user_roles] 
([name], [guard_name], [description], [department_id], [level], [user_type], [is_active])
VALUES 
('Cad - Records', 'cadastral.records', 'Cad - Records', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'CAD'), 'High', 'Operations', 1),
('Cad – AI Digital Assistant', 'cadastral.ai_assistant', 'Cad – AI Digital Assistant', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'CAD'), 'High', 'Operations', 1),
('Cad - GIS', 'cadastral.gis', 'Cad - GIS', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'CAD'), 'High', 'Operations', 1),
('Cad - Approvals', 'cadastral.approvals', 'Cad - Approvals', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'CAD'), 'Highest', 'Management', 1),
('Cad - E-Registry', 'cadastral.e_registry', 'Cad - E-Registry', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'CAD'), 'High', 'Operations', 1),
('Cadastral Reports', 'cadastral.reports', 'Cadastral Reports', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'CAD'), 'High', 'Operations', 1);

-- GIS (70-75)
INSERT INTO [klas].[dbo].[user_roles] 
([name], [guard_name], [description], [department_id], [level], [user_type], [is_active])
VALUES 
('GIS - Records', 'gis.records', 'GIS - Records', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'GIS'), 'High', 'Operations', 1),
('GIS – AI Digital Assistant', 'gis.ai_assistant', 'GIS – AI Digital Assistant', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'GIS'), 'High', 'Operations', 1),
('GIS - GIS', 'gis.gis', 'GIS - GIS', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'GIS'), 'High', 'Operations', 1),
('GIS - Approvals', 'gis.approvals', 'GIS - Approvals', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'GIS'), 'Highest', 'Management', 1),
('GIS - e-Registry', 'gis.e_registry', 'GIS - e-Registry', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'GIS'), 'High', 'Operations', 1),
('GIS Reports', 'gis.reports', 'GIS Reports', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE code = 'GIS'), 'High', 'Operations', 1);

-- SECTIONAL TITLING (76-96)
INSERT INTO [klas].[dbo].[user_roles] 
([name], [guard_name], [description], [department_id], [level], [user_type], [is_active])
VALUES 
('ST - Overview', 'st.overview', 'ST - Overview', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'Sectional Titling'), 'High', 'Operations', 1),
('ST - Primary Application', 'st.primary_application', 'ST - Primary Application', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'Sectional Titling'), 'High', 'Operations', 1),
('ST - Unit Application', 'st.unit_application', 'ST - Unit Application', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'Sectional Titling'), 'High', 'Operations', 1),
('ST - Field Data', 'st.field_data', 'ST - Field Data', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'Sectional Titling'), 'High', 'Operations', 1),
('ST - Payments', 'st.payments', 'ST - Payments', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'Sectional Titling'), 'High', 'Operations', 1),
('ST - Approvals', 'st.approvals', 'ST - Approvals', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'Sectional Titling'), 'High', 'Operations', 1),
('ST - Other Departments', 'st.other_departments', 'ST - Other Departments', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'Sectional Titling'), 'High', 'Operations', 1),
('ST - Planning Recommendation', 'st.planning_recommendation', 'ST - Planning Recommendation', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'Sectional Titling'), 'High', 'Operations', 1),
('ST - Director''s Approval', 'st.directors_approval', 'ST - Director''s Approval', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'Sectional Titling'), 'Highest', 'Management', 1),
('ST - Memo', 'st.memo', 'ST - Memo', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'Sectional Titling'), 'High', 'Operations', 1),
('ST - Certificate', 'st.certificate', 'ST - Certificate', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'Sectional Titling'), 'High', 'Operations', 1),
('ST - RofO', 'st.rofo', 'ST - RofO', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'Sectional Titling'), 'High', 'Operations', 1),
('ST - CofO', 'st.cofo', 'ST - CofO', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'Sectional Titling'), 'High', 'Operations', 1),
('ST - e-Registry', 'st.e_registry', 'ST - e-Registry', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'Sectional Titling'), 'High', 'Operations', 1),
('ST - Files', 'st.files', 'ST - Files', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'Sectional Titling'), 'High', 'Operations', 1),
('ST - GIS', 'st.gis', 'ST - GIS', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'Sectional Titling'), 'High', 'Operations', 1),
('ST - GIS Attribution', 'st.gis_attribution', 'ST - GIS Attribution', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'Sectional Titling'), 'High', 'Operations', 1),
('ST - Map', 'st.map', 'ST - Map', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'Sectional Titling'), 'High', 'Operations', 1),
('ST - Survey', 'st.survey', 'ST - Survey', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'Sectional Titling'), 'High', 'Operations', 1),
('ST - Survey Attribution', 'st.survey_attribution', 'ST - Survey Attribution', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'Sectional Titling'), 'High', 'Operations', 1),
('ST - Reports', 'st.reports', 'ST - Reports', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'Sectional Titling'), 'Highest', 'Management', 1);

-- SLTR / FIRST REGISTRATION (97-118)
INSERT INTO [klas].[dbo].[user_roles] 
([name], [guard_name], [description], [department_id], [level], [user_type], [is_active])
VALUES 
('SLTR - Overview', 'sltr.overview', 'SLTR - Overview', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'SLTR'), 'High', 'Operations', 1),
('SLTR - Application', 'sltr.application', 'SLTR - Application', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'SLTR'), 'High', 'Operations', 1),
('SLTR - Claimants', 'sltr.claimants', 'SLTR - Claimants', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'SLTR'), 'High', 'Operations', 1),
('SLTR - Legacy Data', 'sltr.legacy_data', 'SLTR - Legacy Data', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'SLTR'), 'High', 'Operations', 1),
('SLTR - Field Data', 'sltr.field_data', 'SLTR - Field Data', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'SLTR'), 'High', 'Operations', 1),
('SLTR - Payments', 'sltr.payments', 'SLTR - Payments', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'SLTR'), 'High', 'Operations', 1),
('SLTR - Approvals', 'sltr.approvals', 'SLTR - Approvals', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'SLTR'), 'Highest', 'Management', 1),
('SLTR - Planning Recommendation', 'sltr.planning_recommendation', 'SLTR - Planning Recommendation', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'SLTR'), 'High', 'Operations', 1),
('SLTR - Director SLTR', 'sltr.director', 'SLTR - Director SLTR', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'SLTR'), 'Highest', 'Management', 1),
('SLTR - Other Departments', 'sltr.other_departments', 'SLTR - Other Departments', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'SLTR'), 'High', 'Operations', 1),
('SLTR - Memo', 'sltr.memo', 'SLTR - Memo', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'SLTR'), 'High', 'Operations', 1),
('SLTR - Certificate', 'sltr.certificate', 'SLTR - Certificate', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'SLTR'), 'High', 'Operations', 1),
('SLTR - RofO', 'sltr.rofo', 'SLTR - RofO', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'SLTR'), 'High', 'Operations', 1),
('SLTR - CofO', 'sltr.cofo', 'SLTR - CofO', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'SLTR'), 'High', 'Operations', 1),
('SLTR - e-Registry', 'sltr.e_registry', 'SLTR - e-Registry', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'SLTR'), 'High', 'Operations', 1),
('SLTR - Files', 'sltr.files', 'SLTR - Files', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'SLTR'), 'High', 'Operations', 1),
('SLTR - GIS', 'sltr.gis', 'SLTR - GIS', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'SLTR'), 'High', 'Operations', 1),
('SLTR - GIS Attribution', 'sltr.gis_attribution', 'SLTR - GIS Attribution', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'SLTR'), 'High', 'Operations', 1),
('SLTR - Map', 'sltr.map', 'SLTR - Map', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'SLTR'), 'High', 'Operations', 1),
('SLTR - Survey', 'sltr.survey', 'SLTR - Survey', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'SLTR'), 'High', 'Operations', 1),
('SLTR - Survey Attribution', 'sltr.survey_attribution', 'SLTR - Survey Attribution', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'SLTR'), 'High', 'Operations', 1),
('SLTR - Reports', 'sltr.reports', 'SLTR - Reports', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'SLTR'), 'High', 'Operations', 1);

-- SYSTEMS, LEGACY SYSTEMS, SYSTEM ADMIN (119-125)
INSERT INTO [klas].[dbo].[user_roles] 
([name], [guard_name], [description], [department_id], [level], [user_type], [is_active], [created_at], [updated_at])
VALUES 
('Caveat', 'deeds.caveat', 'Caveat', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'Deeds'), 'High', 'Operations', 1, NULL, NULL),
('Encumbrance', 'deeds.encumbrance', 'Encumbrance', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'Deeds'), 'High', 'Operations', 1, NULL, NULL),
('Legacy System', 'ict.legacy', 'Legacy System', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'ICT'), 'Highest', 'System', 1, NULL, NULL),
('User Account', 'ict.user_account', 'User Account', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'ICT'), 'High', 'System', 1, NULL, NULL),
('Departments', 'ict.departments', 'Departments', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'ICT'), 'High', 'System', 1, NULL, NULL),
('User Roles', 'ict.user_roles', 'User Roles', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'ICT'), 'High', 'System', 1, NULL, NULL),
('System Settings', 'ict.settings', 'System Settings', 
 (SELECT id FROM [klas].[dbo].[departments] WHERE name = 'ICT'), 'High', 'System', 1, NULL, NULL);