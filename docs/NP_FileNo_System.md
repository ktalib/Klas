# New Primary FileNo (NP FileNo) System

## Overview

The New Primary FileNo (NP FileNo) system has been implemented to provide a more structured and organized file numbering system for sectional titling applications.

## File Number Structure

### 1. New Primary FileNo (NPFN)
**Format**: `ST-Landuse-Year-SerialNo`

**Examples**:
- `ST-RES-2025-01` (Residential, Year 2025, Serial 01)
- `ST-COM-2025-02` (Commercial, Year 2025, Serial 02)
- `ST-IND-2025-03` (Industrial, Year 2025, Serial 03)

**Components**:
- **ST**: Sectional Title prefix
- **Landuse**: Land use code (RES/COM/IND)
  - RES = Residential
  - COM = Commercial
  - IND = Industrial
- **Year**: Current year (4 digits)
- **SerialNo**: Main application ID (2 digits, zero-padded)

### 2. Unit FileNo
**Format**: `NP FileNo + Unit Serial Number`

**Examples**:
- `ST-RES-2025-01-001` (First unit of NP FileNo ST-RES-2025-01)
- `ST-RES-2025-01-002` (Second unit of NP FileNo ST-RES-2025-01)
- `ST-COM-2025-02-001` (First unit of NP FileNo ST-COM-2025-02)

**Components**:
- **NP FileNo**: The New Primary FileNo
- **Unit Serial**: 3-digit unit number (001, 002, 003, etc.)

## Implementation Details

### Database Changes

1. **Added `np_fileno` column** to the following tables:
   - `StFileNo`
   - `subapplications`
   - `mother_applications`

2. **Migration file**: `2025_01_27_add_np_fileno_to_tables.php`

### Code Changes

1. **ApplicationMotherController.php**:
   - Updated `subApplication()` method to generate NP FileNo and Unit FileNo
   - Updated `storeSub()` method to save both file numbers

2. **sub_application.blade.php**:
   - Updated form to display both NP FileNo and Unit FileNo
   - Added visual distinction with color coding

3. **units.blade.php**:
   - Updated table headers to show "NP FileNo (NPFN)" and "Unit FileNo"
   - Updated data display logic to generate and show both file numbers

### User Interface

1. **Unit Application Form**:
   - **NP FileNo field**: Blue background, read-only, shows the New Primary FileNo
   - **Unit FileNo field**: Green background, read-only, shows the complete Unit FileNo

2. **Unit Applications Table**:
   - **NP FileNo (NPFN) column**: Shows the New Primary FileNo with blue styling
   - **Unit FileNo column**: Shows the complete Unit FileNo with green styling

## Benefits

1. **Better Organization**: Clear hierarchy between primary applications and units
2. **Easier Tracking**: Distinct file numbers for different purposes
3. **Scalability**: System can handle large numbers of applications and units
4. **Consistency**: Standardized format across all applications
5. **Backward Compatibility**: Legacy system still supported

## Usage

### For Administrators
- The system automatically generates both file numbers
- No manual intervention required
- Both numbers are displayed in the application forms and tables

### For Users
- NP FileNo represents the main application
- Unit FileNo represents individual units within the main application
- Both numbers are clearly labeled and color-coded for easy identification

## Acronyms

- **NPFN**: New Primary FileNo
- **NP FileNo**: New Primary FileNo (same as NPFN)
- **ST**: Sectional Title
- **RES**: Residential
- **COM**: Commercial
- **IND**: Industrial

## Migration Instructions

1. Run the migration to add the new database columns:
   ```bash
   php artisan migrate
   ```

2. The system will automatically start generating NP FileNos for new applications

3. Existing applications will continue to work with the legacy system

## Support

For any questions or issues related to the NP FileNo system, please contact the development team.