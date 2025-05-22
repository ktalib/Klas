Phase 1 (Power of Attorney & Particulars Registration Number Generation)

Overall Goal: Develop the foundational "Instruments Capture" module for our application. This initial phase focuses on managing "Power of Attorney" (POA) instruments and implementing a system for auto-generating a particularsRegistrationNumber.

I. Power of Attorney (POA) Instrument Management

Data Model & Storage (instrument_registration table):
Utilize the instrument_registration table (see Appendix A for the full column list).
For POA instruments, ensure the following key fields are captured. Map these to appropriate columns in instrument_registration:
instrument_type: This field should store the type of instrument. For this task, it will be "Power of Attorney". (The original prompt listed an instrument column; instrument_type is suggested for clarity).
Grantor: (e.g., maps to Grantor column)
GrantorAddress: (e.g., maps to GrantorAddress column)
Grantee: (e.g., maps to Grantee column)
GranteeAddress: (e.g., maps to GranteeAddress column)
instrumentDate: (e.g., maps to instrumentDate column)
propertyDescription: (e.g., maps to propertyDescription column)
solicitorName: (e.g., maps to solicitorName column)
solicitorAddress: (e.g., maps to solicitorAddress column)
particularsRegistrationNumber: This will be populated by the system as described in Section II.
Instruction to AI: Identify and use other relevant fields from Appendix A as applicable to a Power of Attorney.
Ensure all records in instrument_registration have created_at and updated_at timestamps.
Functionality:
Create POA:
Implement a user interface (form) for capturing POA details.
On submission, save the POA data into the instrument_registration table.
Display POAs:
Implement a view (e.g., a data table) to list all captured POA instruments.
The table should display key information such as particularsRegistrationNumber, Grantor, Grantee, instrumentDate, and instrument_type.
II. Auto-Generation of particularsRegistrationNumber

This system is primarily invoked when a primary application identifier (e.g., an application's "Root Title Reg No") is not available for an instrument.

Triggering Mechanism:
In the user interface where an instrument is being created or managed (likely in relation to a parent application):
If the associated application is missing its "Root Title Reg No", display a button labeled "Generate Particulars Registration Number".
particularsRegistrationNumber Generation Logic:
Format: The particularsRegistrationNumber will be a string in the format S/P/V, where:
S = serial_no
P = page_no
V = volume_no
Sequence Generation Rules:
The sequence starts with S=1, P=1, V=1 (resulting in the string "1/1/1").
For subsequent numbers, S (serial_no) and P (page_no) are always identical and increment together.
Increment S and P from 1 up to 300 for the current V (volume_no).
Examples: "1/1/1", "2/2/1", "3/3/1", ..., "300/300/1".
When S (and P) reach 300 for the current V:
Reset S and P back to 1.
Increment V by 1.
The next number will be "1/1/[new V]".
Example: After "300/300/1", the next is "1/1/2". Then "2/2/2", ..., "300/300/2", then "1/1/3", and so on.
Action on Button Click: When the "Generate Particulars Registration Number" button is clicked:
The system must determine the next available S, P, V values based on the sequence logic and the tracking table (see point 3 below).
Construct the particularsRegistrationNumber string (e.g., "1/1/1").
Store this generated string in the particularsRegistrationNumber column of the current instrument_registration record being processed.
Update the tracking mechanism (see point 3) to reflect the new last used S, P, V values.
Tracking Table for Sequence State (particulars_registration_sequence):
Create a new database table to persist the last used values, ensuring unique and sequential generation.
Name: particulars_registration_sequence
Columns:
id (Primary Key, e.g., TINYINT UNSIGNED AUTO_INCREMENT or just INT PRIMARY KEY if only one row is expected, representing the global sequence state)
last_serial_no (INT, stores the last S used)
last_page_no (INT, stores the last P used - will be the same as last_serial_no per the logic)
last_volume_no (INT, stores the last V used)
updated_at (TIMESTAMP, automatically updated when the record changes)
Initialization: This table should be initialized (or seeded) with values that allow the first generated number to be "1/1/1". For example: last_serial_no=0, last_page_no=0, last_volume_no=1. The generation logic should handle this initial state to produce "1/1/1".
Logging Generated Particulars (instrument_particulars_log):
Create a table to log each generated particularsRegistrationNumber and its constituent parts, linking it to the specific instrument.
Name: instrument_particulars_log
Columns:
id (PK, BIGINT UNSIGNED AUTO_INCREMENT)
instrument_id (FK referencing instrument_registration.id, BIGINT UNSIGNED)
serial_no (INT)
page_no (INT)
volume_no (INT)
generated_particulars_number (VARCHAR(255), e.g., "1/1/1")
created_at (TIMESTAMP, default to CURRENT_TIMESTAMP)
updated_at (TIMESTAMP, default to CURRENT_TIMESTAMP on update)
Clarification on "0/0/0" Value:
The original prompt stated: "...this will automatically append 0/0/0 as the root title reg particulars".
Instruction to AI: For this phase, the "Generate Particulars Registration Number" button should exclusively trigger the sequential generation logic described in II.2 (starting "1/1/1").
If "0/0/0" is a required distinct value for particularsRegistrationNumber under different circumstances (e.g., manual entry, a different button), this will be specified as a separate requirement. Do not implement "0/0/0" assignment via this button unless explicitly told otherwise.
III. Database Table: instrument_registration (Recap)

This is the central table for storing all instrument details.
Key Columns to ensure exist and are correctly used for this phase:
id (Primary Key, e.g., BIGINT UNSIGNED AUTO_INCREMENT)
particularsRegistrationNumber (VARCHAR(255), to store the generated "S/P/V" string)
instrument_type (VARCHAR(255), e.g., "Power of Attorney"). (If original table has instrument, use that but understand its purpose is to store the type).
created_at (TIMESTAMP)
updated_at (TIMESTAMP)
Refer to Appendix A for the comprehensive list of columns. The AI should ensure the table schema can accommodate these, focusing on POA-relevant fields for now.
Appendix A: instrument_registration Table Column List (from original prompt for reference)

MLSFileNo
KAGISFileNO
NewKANGISFileNo
particularsRegistrationNumber
instrument (Interpreted as instrument_type)
Grantor
GrantorAddress
Grantee
GranteeAddress
mortgagor
mortgagorAddress
mortgagee
mortgageeAddress
loanAmount
interestRate
duration
assignor
assignorAddress
assignee
assigneeAddress
lessor
lessorAddress
lessee
lesseeAddress
leasePeriod
leaseTerms
propertyDescription
propertyAddress
originalPlotDetails
newSubDividedPlotDetails
mergedPlotInformation
surrenderingPartyName
receivingPartyName
propertyDetails
considerationAmount
changesVariations
heirBeneficiaryDetails
originalPropertyOwnerDetails
assentTerms
releasorName
releaseeName
releaseTerms
instrumentDate
solicitorName
solicitorAddress
surveyPlanNo
lga
district
size
plotNumber
created_at
updated_at
typeForm
surrenderee
surrenderor
subLease
thirdParty
landUseType
titleType
assignment
batchNumber
grantLease
statutory
customer
categoryCode
mortgage
assignorName
batchNo
plotNo
Period

 