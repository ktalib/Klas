Let's **reuse the existing code** from **ST Transfer of Title (Assignments)** for the new **Instrument Registration** module.

### 🗂️ Main View Table

Update the main view table to include the following fields:

* Reg. Number
* File No
* Grantor
* Grantee
* Instrument Type
* Duration
* LGA
* District
* Plot Number
* Plot Size
* Plot Description
* Date
* Status

---

### 🔄 Batch Transfer → Now "Batch Registration"

Use the same table structure from the previous batch transfer, but adjust accordingly.

* Not all fields are needed
* Add a **dropdown (select option)** for **Instrument Types** for each entry in Batch Registration

---

### ➕ Single Registration

Update this section by removing the following fields and replacing them with **Instrument-specific details**:

**Remove:**

* ST File No
* Number of Units
* Number of Sections
* Number of Blocks
* Certificate of Occupancy Details
* Sectional Title File No \*
* Applicant Name \*
* Tenure Period (Years) \*

**Add:**

* A dropdown for **Instrument Types**

---

### ⚙️ Key Notes

* **Retain**:

  * Registration Details section
  * Registration Number Information
  * Deeds Time \*
  * Deeds Date \*

* Replace all references to **"Assignments"** with **"Instrument Registrations"**

* Replace **"Transferred"** with **"Registered"** where applicable

---

**Note**: Use the `instrument_registration` table below for all required fields and form values.
No need for Mother_applications table

SELECT all  from instrument_registration 
Feilds are .. 
      ,[MLSFileNo]
      ,[KAGISFileNO]
      ,[NewKANGISFileNo]
      ,[rootRegistrationNumber]
      ,[particularsRegistrationNumber]
      ,[instrument_type]
      ,[Grantor]
      ,[GrantorAddress]
      ,[Grantee]
      ,[GranteeAddress]
      ,[mortgagor]
      ,[mortgagorAddress]
      ,[mortgagee]
      ,[mortgageeAddress]
      ,[loanAmount]
      ,[interestRate]
      ,[duration]
      ,[assignor]
      ,[assignorAddress]
      ,[assignee]
      ,[assigneeAddress]
      ,[lessor]
      ,[lessorAddress]
      ,[lessee]
      ,[lesseeAddress]
      ,[leasePeriod]
      ,[leaseTerms]
      ,[propertyDescription]
      ,[propertyAddress]
      ,[originalPlotDetails]
      ,[newSubDividedPlotDetails]
      ,[mergedPlotInformation]
      ,[surrenderingPartyName]
      ,[receivingPartyName]
      ,[propertyDetails]
      ,[considerationAmount]
      ,[changesVariations]
      ,[heirBeneficiaryDetails]
      ,[originalPropertyOwnerDetails]
      ,[assentTerms]
      ,[releasorName]
      ,[releaseeName]
      ,[releaseTerms]
      ,[instrumentDate]
      ,[solicitorName]
      ,[solicitorAddress]
      ,[surveyPlanNo]
      ,[lga]
      ,[district]
      ,[size]
      ,[plotNumber]
      ,[typeForm]
      ,[surrenderee]
      ,[surrenderor]
      ,[subLease]
      ,[thirdParty]
      ,[landUseType]
      ,[titleType]
      ,[assignment]
      ,[batchNumber]
      ,[grantLease]
      ,[statutory]
      ,[customer]
      ,[categoryCode]
      ,[mortgage]
      ,[assignorName]
      ,[batchNo]
      ,[plotNo]
      ,[Period]
      ,[created_at]
      ,[updated_at]
 