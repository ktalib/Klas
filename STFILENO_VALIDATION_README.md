# ST Assignment and Sectional Titling CofO Registration Validation

## Overview
This implementation adds validation to ensure that for ST Assignment (Transfer of Title) and Sectional Titling CofO applications, both the StFileNo and the instrument type are properly registered for each application.

## Key Features

### 1. StFileNo Field Addition
- Added `StFileNo` column to the `registered_instruments` table
- Added completion tracking fields to the `subapplications` table:
  - `deeds_completion_status`
  - `deeds_completion_date`

### 2. Registration Validation

#### Single Registration
- Validates that StFileNo is provided for ST Assignment and Sectional Titling CofO
- Prevents duplicate registrations of the same instrument type for the same file number
- Logs registration attempts for tracking purposes

#### Batch Registration
- Pre-validates all entries before processing
- Checks for duplicates within the batch
- Ensures no existing registrations conflict with batch entries
- Validates that both instrument types can be registered together

### 3. Completion Tracking
- Automatically checks if both instrument types are registered for each file
- Updates completion status when both types are registered
- Provides detailed logging for audit purposes

### 4. New API Endpoint
- **GET** `/instrument_registration/check-registration-status?file_no={fileNo}`
- Returns detailed status of both instrument types for a given file number

## Database Changes

### Migration File
`database/migrations/2024_01_15_000000_add_stfileno_to_registered_instruments.php`

#### Changes Made:
1. Added `StFileNo` column to `registered_instruments` table
2. Added index on `StFileNo` for performance
3. Added completion tracking fields to `subapplications` table

### To Run Migration:
```bash
php artisan migrate
```

## Controller Changes

### InstrumentRegistrationController.php

#### New Methods:
1. `checkRegistrationStatus()` - API endpoint for status checking
2. `checkBothTypesRegistered()` - Internal validation helper
3. `updateApplicationCompletionStatus()` - Completion tracking

#### Enhanced Methods:
1. `registerSingle()` - Added StFileNo validation
2. `registerBatch()` - Added comprehensive batch validation
3. `prepareRegistrationData()` - Includes StFileNo field

## Validation Rules

### For ST Assignment (Transfer of Title) and Sectional Titling CofO:

1. **Required Fields:**
   - `instrument_type` must be specified
   - `file_no` (used as StFileNo) must be provided

2. **Duplicate Prevention:**
   - Cannot register the same instrument type twice for the same file number
   - Batch operations validate against existing registrations and within-batch duplicates

3. **Completion Tracking:**
   - System tracks when both instrument types are registered for a file
   - Updates application status accordingly

## API Usage Examples

### Check Registration Status
```javascript
fetch('/gisedms/instrument_registration/check-registration-status?file_no=ST-2024-001')
  .then(response => response.json())
  .then(data => {
    console.log('ST Assignment registered:', data.st_assignment.registered);
    console.log('Sectional Titling registered:', data.sectional_titling.registered);
    console.log('Both registered:', data.both_registered);
  });
```

### Response Format
```json
{
  "success": true,
  "file_no": "ST-2024-001",
  "st_assignment": {
    "registered": true,
    "status": "registered",
    "registration_number": "1/1/1",
    "stm_ref": "STM-2024-0001",
    "registered_date": "2024-01-15T10:30:00"
  },
  "sectional_titling": {
    "registered": false,
    "status": null,
    "registration_number": null,
    "stm_ref": null,
    "registered_date": null
  },
  "both_registered": false,
  "total_registrations": 1
}
```

## Logging

The system provides comprehensive logging for:
- Registration attempts
- Validation failures
- Completion status updates
- Error tracking

### Log Levels:
- **INFO**: Successful operations and status updates
- **WARNING**: Non-critical issues (e.g., completion status update failures)
- **ERROR**: Critical failures in registration process

## Error Handling

### Common Error Responses:

1. **Duplicate Registration:**
```json
{
  "success": false,
  "error": "A ST Assignment (Transfer of Title) registration already exists for file number ST-2024-001"
}
```

2. **Missing File Number:**
```json
{
  "success": false,
  "error": "File number (StFileNo) is required for ST Assignment (Transfer of Title)"
}
```

3. **Batch Validation Error:**
```json
{
  "success": false,
  "error": "Duplicate instrument types found in batch for file number ST-2024-001"
}
```

## Testing

### Manual Testing Steps:

1. **Single Registration Test:**
   - Register ST Assignment for a file number
   - Attempt to register the same type again (should fail)
   - Register Sectional Titling for the same file (should succeed)
   - Check completion status

2. **Batch Registration Test:**
   - Create batch with both types for same file
   - Verify both are registered successfully
   - Check completion status is updated

3. **API Testing:**
   - Use the status check endpoint
   - Verify response format and accuracy

## Future Enhancements

1. **Dashboard Integration:**
   - Add completion status indicators to main dashboard
   - Show progress for files with partial registrations

2. **Reporting:**
   - Generate reports on completion rates
   - Track registration timelines

3. **Notifications:**
   - Alert when both types are completed
   - Remind about pending registrations

## Support

For issues or questions regarding this implementation:
1. Check the application logs for detailed error information
2. Verify database migration has been run successfully
3. Ensure proper permissions are set for the new API endpoint