<div class="p-6">
    <div class="space-y-4">
        <!-- Filter Buttons -->
        <div class="flex gap-2 mb-4">
            <button class="inline-flex items-center justify-center rounded-md font-medium text-sm px-4 py-2 transition-all cursor-pointer border-0 bg-blue-600 text-white hover:bg-blue-700 filter-btn active" data-status="all">All Applications</button>
            <button class="inline-flex items-center justify-center rounded-md font-medium text-sm px-4 py-2 transition-all cursor-pointer bg-transparent border border-gray-300 text-gray-700 hover:bg-gray-100 filter-btn" data-status="pending">Pending</button>
            <button class="inline-flex items-center justify-center rounded-md font-medium text-sm px-4 py-2 transition-all cursor-pointer bg-transparent border border-gray-300 text-gray-700 hover:bg-gray-100 filter-btn" data-status="approved">Approved</button>
            <button class="inline-flex items-center justify-center rounded-md font-medium text-sm px-4 py-2 transition-all cursor-pointer bg-transparent border border-gray-300 text-gray-700 hover:bg-gray-100 filter-btn" data-status="rejected">Rejected</button>
        </div>

        <!-- Applications Table -->
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
            <div class="p-0">
                <table class="w-full border-collapse">
                    <thead>
                        <tr>
                            <th class="p-3 text-left border-b border-gray-200 font-medium text-gray-600 text-sm bg-gray-50/50">Parcel ID</th>
                            <th class="p-3 text-left border-b border-gray-200 font-medium text-gray-600 text-sm bg-gray-50/50">File Number</th>
                            <th class="p-3 text-left border-b border-gray-200 font-medium text-gray-600 text-sm bg-gray-50/50">Applicant</th>
                            <th class="p-3 text-left border-b border-gray-200 font-medium text-gray-600 text-sm bg-gray-50/50">Type</th>
                            <th class="p-3 text-left border-b border-gray-200 font-medium text-gray-600 text-sm bg-gray-50/50">Location</th>
                            <th class="p-3 text-left border-b border-gray-200 font-medium text-gray-600 text-sm bg-gray-50/50">Date</th>
                            <th class="p-3 text-left border-b border-gray-200 font-medium text-gray-600 text-sm bg-gray-50/50">Status</th>
                            <th class="p-3 text-right border-b border-gray-200 font-medium text-gray-600 text-sm bg-gray-50/50">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="applications-table-body" class="[&>tr:hover]:bg-gray-50/30">
                        <!-- Table rows will be populated by JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Application Details Modal -->
<div id="details-modal" class="modal fixed inset-0 bg-black/50 flex items-center justify-center z-50" style="display: none;">
    <div class="modal-content bg-white rounded-lg max-w-4xl w-[90%] max-h-[90vh] overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 id="modal-title" class="text-xl font-semibold">Application Details</h2>
                <button id="close-modal" class="inline-flex items-center justify-center bg-transparent text-gray-700 hover:bg-gray-100 h-8 w-8 rounded-md">
                    <i data-lucide="x" class="h-4 w-4"></i>
                </button>
            </div>
        </div>
        <div class="p-6 max-h-[70vh] overflow-y-auto">
            <div class="grid grid-cols-4 bg-gray-100 rounded-md p-1 mb-4">
                <button class="tab-trigger flex items-center justify-center px-4 py-2 rounded text-sm font-medium cursor-pointer transition-all bg-white text-blue-600 shadow-sm active" data-tab="overview">Overview</button>
                <button class="tab-trigger flex items-center justify-center px-4 py-2 rounded text-sm font-medium cursor-pointer transition-all bg-transparent text-gray-600 hover:bg-gray-50" data-tab="applicant">Applicant</button>
                <button class="tab-trigger flex items-center justify-center px-4 py-2 rounded text-sm font-medium cursor-pointer transition-all bg-transparent text-gray-600 hover:bg-gray-50" data-tab="property">Property</button>
                <button class="tab-trigger flex items-center justify-center px-4 py-2 rounded text-sm font-medium cursor-pointer transition-all bg-transparent text-gray-600 hover:bg-gray-50" data-tab="documents">Documents</button>
            </div>

            <div class="overflow-y-auto pr-4 h-[500px] [&::-webkit-scrollbar]:w-1.5 [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-track]:rounded [&::-webkit-scrollbar-thumb]:bg-gray-400 [&::-webkit-scrollbar-thumb]:rounded [&::-webkit-scrollbar-thumb:hover]:bg-gray-500">
                <!-- Overview Tab -->
                <div id="overview-tab" class="tab-content block space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                            <div class="p-4">
                                <h3 class="text-lg font-medium mb-2">Application Summary</h3>
                                <div id="application-summary" class="space-y-2 text-sm">
                                    <!-- Summary content will be populated by JavaScript -->
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                            <div class="p-4">
                                <h3 class="text-lg font-medium mb-2">Fees & Payments</h3>
                                <div id="fees-summary" class="space-y-2 text-sm">
                                    <!-- Fees content will be populated by JavaScript -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                        <div class="p-4">
                            <h3 class="text-lg font-medium mb-2">Comments & Notes</h3>
                            <p id="application-comments" class="text-sm"></p>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                        <div class="p-4">
                            <h3 class="text-lg font-medium mb-2">Application Timeline</h3>
                            <div id="application-timeline" class="space-y-4">
                                <!-- Timeline content will be populated by JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Applicant Tab -->
                <div id="applicant-tab" class="tab-content hidden space-y-4">
                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                        <div class="p-4">
                            <h3 class="text-lg font-medium mb-4">Applicant Information</h3>
                            <div id="applicant-details" class="space-y-4">
                                <!-- Applicant details will be populated by JavaScript -->
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                        <div class="p-4">
                            <h3 class="text-lg font-medium mb-4">Ownership Information</h3>
                            <div id="ownership-details" class="space-y-4">
                                <!-- Ownership details will be populated by JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Property Tab -->
                <div id="property-tab" class="tab-content hidden space-y-4">
                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                        <div class="p-4">
                            <h3 class="text-lg font-medium mb-4">Property Information</h3>
                            <div id="property-details" class="space-y-4">
                                <!-- Property details will be populated by JavaScript -->
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                        <div class="p-4">
                            <h3 class="text-lg font-medium mb-4">Property Map</h3>
                            <div class="bg-gray-100 rounded-md h-[200px] flex items-center justify-center">
                                <div class="text-center">
                                    <i data-lucide="map-pin" class="h-8 w-8 text-red-500 mx-auto mb-2"></i>
                                    <p class="text-sm text-gray-600">GIS Map Integration</p>
                                    <p class="text-xs text-gray-500">Interactive map would be displayed here</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Documents Tab -->
                <div id="documents-tab" class="tab-content hidden space-y-4">
                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                        <div class="p-4">
                            <h3 class="text-lg font-medium mb-4">Document Status</h3>
                            <div id="document-status" class="space-y-4">
                                <!-- Document status will be populated by JavaScript -->
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                            <div class="p-4">
                                <h3 class="text-lg font-medium mb-4">Required Documents</h3>
                                <ul id="required-documents" class="space-y-2">
                                    <!-- Required documents list will be populated by JavaScript -->
                                </ul>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                            <div class="p-4">
                                <h3 class="text-lg font-medium mb-4">Document Actions</h3>
                                <div class="space-y-2">
                                    <button class="inline-flex items-center justify-start bg-transparent border border-gray-300 text-gray-700 hover:bg-gray-100 w-full px-4 py-2 rounded-md text-sm font-medium">
                                        <i data-lucide="eye" class="h-4 w-4 mr-2"></i>
                                        View All Documents
                                    </button>
                                    <button class="inline-flex items-center justify-start bg-transparent border border-gray-300 text-gray-700 hover:bg-gray-100 w-full px-4 py-2 rounded-md text-sm font-medium">
                                        <i data-lucide="file-text" class="h-4 w-4 mr-2"></i>
                                        Generate Document Report
                                    </button>
                                    <button class="inline-flex items-center justify-start bg-transparent border border-gray-300 text-gray-700 hover:bg-gray-100 w-full px-4 py-2 rounded-md text-sm font-medium">
                                        <i data-lucide="check-circle-2" class="h-4 w-4 mr-2"></i>
                                        Verify All Documents
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Add required CSS for tabs and modal */
    .modal {
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }
    .modal.show {
        opacity: 1;
        visibility: visible;
        display: flex !important;
    }
    .tab-content {
        display: none;
    }
    .tab-content.active {
        display: block;
    }
    .dropdown-content {
        display: none;
    }
    .dropdown-content.show {
        display: block;
    }
</style>

<script>
    // Initialize Lucide icons
    lucide.createIcons();

    // Mock data
    const mockApplications = [
        {
            id: "SLTR-447052",
            fileNumber: "SLTR-RES-2023-01",
            arn: "ARN-RES-2023-01-123456",
            applicantName: "John Doe",
            applicantType: "individual",
            applicantDetails: {
                address: "123 Main Street, Abuja",
                phone: "08012345678",
                email: "john.doe@example.com",
                nin: "12345678901",
                idType: "National ID",
            },
            propertyDetails: {
                plotNumber: "PLT-123",
                blockNumber: "BLK-45",
                streetName: "Ahmadu Bello Way",
                location: "Garki District",
                lga: "Abuja Municipal",
                landUse: "residential",
                gpsCoordinates: {
                    lat: "9.0765",
                    lng: "7.3986",
                },
            },
            ownershipType: "inheritance",
            dateSubmitted: "2023-05-15",
            status: "pending",
            documents: [
                { name: "ID Document", status: "verified" },
                { name: "Proof of Ownership", status: "pending" },
                { name: "Survey Plan", status: "verified" },
                { name: "Tax Receipt", status: "verified" },
            ],
            fees: {
                applicationFee: "2,000.00",
                processingFee: "20,000.00",
                surveyFee: "14,000.00",
                totalPaid: "36,000.00",
            },
            comments: "Awaiting document verification",
            assignedOfficer: "Sarah Johnson",
        },
        {
            id: "SLTR-623891",
            fileNumber: "SLTR-COM-2023-01",
            arn: "ARN-COM-2023-01-789012",
            applicantName: "ABC Corporation",
            applicantType: "corporate",
            applicantDetails: {
                address: "45 Business Avenue, Abuja",
                phone: "08023456789",
                email: "contact@abccorp.com",
                rcNumber: "RC123456",
                contactPerson: "Jane Smith",
            },
            propertyDetails: {
                plotNumber: "PLT-456",
                blockNumber: "BLK-12",
                streetName: "Shehu Shagari Way",
                location: "Central Business District",
                lga: "Abuja Municipal",
                landUse: "commercial",
                gpsCoordinates: {
                    lat: "9.0543",
                    lng: "7.4865",
                },
            },
            ownershipType: "purchase",
            dateSubmitted: "2023-05-10",
            status: "approved",
            documents: [
                { name: "CAC Document", status: "verified" },
                { name: "Proof of Ownership", status: "verified" },
                { name: "Survey Plan", status: "verified" },
                { name: "Tax Receipt", status: "verified" },
            ],
            fees: {
                applicationFee: "5,000.00",
                processingFee: "50,000.00",
                surveyFee: "14,000.00",
                totalPaid: "69,000.00",
            },
            comments: "All documents verified. Certificate issued.",
            assignedOfficer: "Michael Okonkwo",
        },
        {
            id: "SLTR-789456",
            fileNumber: "SLTR-AGR-2023-01",
            arn: "ARN-AGR-2023-01-345678",
            applicantName: "Ministry of Agriculture",
            applicantType: "government",
            applicantDetails: {
                address: "Federal Secretariat Complex, Abuja",
                phone: "08034567890",
                email: "info@agriculture.gov.ng",
                idType: "Government ID",
            },
            propertyDetails: {
                plotNumber: "PLT-789",
                blockNumber: "BLK-78",
                streetName: "N/A",
                location: "Gwagwalada Area Council",
                lga: "Gwagwalada",
                landUse: "agriculture",
                gpsCoordinates: {
                    lat: "8.9456",
                    lng: "7.0865",
                },
            },
            ownershipType: "directLGA",
            dateSubmitted: "2023-05-05",
            status: "rejected",
            documents: [
                { name: "Government Allocation Letter", status: "verified" },
                { name: "Survey Plan", status: "invalid" },
                { name: "Environmental Impact Assessment", status: "missing" },
            ],
            fees: {
                applicationFee: "5,000.00",
                processingFee: "50,000.00",
                surveyFee: "14,000.00",
                totalPaid: "69,000.00",
            },
            comments: "Rejected due to invalid survey plan and missing environmental assessment",
            assignedOfficer: "Fatima Abdullahi",
        },
        {
            id: "SLTR-135792",
            fileNumber: "SLTR-WAR-2023-01",
            arn: "ARN-WAR-2023-01-901234",
            applicantName: "XYZ Logistics Ltd",
            applicantType: "corporate",
            applicantDetails: {
                address: "78 Industrial Layout, Abuja",
                phone: "08045678901",
                email: "operations@xyzlogistics.com",
                rcNumber: "RC789012",
                contactPerson: "Robert Eze",
            },
            propertyDetails: {
                plotNumber: "PLT-321",
                blockNumber: "BLK-33",
                streetName: "Industrial Avenue",
                location: "Idu Industrial Area",
                lga: "Abuja Municipal",
                landUse: "warehouse",
                gpsCoordinates: {
                    lat: "9.1234",
                    lng: "7.3456",
                },
            },
            ownershipType: "purchase",
            dateSubmitted: "2023-05-01",
            status: "pending",
            documents: [
                { name: "CAC Document", status: "verified" },
                { name: "Proof of Ownership", status: "verified" },
                { name: "Survey Plan", status: "pending" },
                { name: "Tax Receipt", status: "pending" },
                { name: "Building Plan", status: "pending" },
            ],
            fees: {
                applicationFee: "10,000.00",
                processingFee: "100,000.00",
                surveyFee: "14,000.00",
                totalPaid: "124,000.00",
            },
            comments: "Awaiting survey plan verification",
            assignedOfficer: "David Adamu",
        },
    ];

    // State management
    let currentFilter = 'all';
    let expandedRows = {};
    let selectedApplication = null;

    // DOM elements
    const elements = {
        tableBody: document.getElementById('applications-table-body'),
        filterBtns: document.querySelectorAll('.filter-btn'),
        detailsModal: document.getElementById('details-modal'),
        closeModal: document.getElementById('close-modal'),
        modalTitle: document.getElementById('modal-title'),
        tabTriggers: document.querySelectorAll('.tab-trigger'),
        tabContents: document.querySelectorAll('.tab-content'),
        applicationSummary: document.getElementById('application-summary'),
        feesSummary: document.getElementById('fees-summary'),
        applicationComments: document.getElementById('application-comments'),
        applicationTimeline: document.getElementById('application-timeline'),
        applicantDetails: document.getElementById('applicant-details'),
        ownershipDetails: document.getElementById('ownership-details'),
        propertyDetails: document.getElementById('property-details'),
        documentStatus: document.getElementById('document-status'),
        requiredDocuments: document.getElementById('required-documents')
    };

    // Helper functions
    function getLandUseIcon(landUse) {
        const icons = {
            residential: 'home',
            commercial: 'building',
            warehouse: 'warehouse',
            agriculture: 'tractor'
        };
        return icons[landUse] || 'home';
    }

    function getLandUseColor(landUse) {
        const colors = {
            residential: 'text-blue-500',
            commercial: 'text-purple-500',
            warehouse: 'text-amber-500',
            agriculture: 'text-green-500'
        };
        return colors[landUse] || 'text-gray-500';
    }

    function getStatusBadgeClass(status) {
        switch (status) {
            case 'approved': 
                return 'inline-flex items-center rounded-full text-xs font-medium px-2 py-1 bg-green-600 text-white';
            case 'rejected': 
                return 'inline-flex items-center rounded-full text-xs font-medium px-2 py-1 bg-red-500 text-white';
            case 'pending': 
                return 'inline-flex items-center rounded-full text-xs font-medium px-2 py-1 bg-blue-600 text-white';
            default: 
                return 'inline-flex items-center rounded-full text-xs font-medium px-2 py-1 bg-transparent border border-gray-300 text-gray-700';
        }
    }

    function getDocumentStatusIcon(status) {
        const icons = {
            verified: { icon: 'check-circle-2', color: 'text-green-500' },
            invalid: { icon: 'x-circle', color: 'text-red-500' },
            pending: { icon: 'clock', color: 'text-amber-500' },
            missing: { icon: 'x-circle', color: 'text-gray-500' }
        };
        return icons[status] || icons.pending;
    }

    function filterApplications(status) {
        return status === 'all' ? mockApplications : mockApplications.filter(app => app.status === status);
    }

    function toggleRowExpansion(id) {
        expandedRows[id] = !expandedRows[id];
        renderTable();
    }

    function openApplicationDetails(application) {
        selectedApplication = application;
        elements.modalTitle.textContent = `Application Details: ${application.id}`;
        populateModalContent(application);
        elements.detailsModal.classList.add('show');
        // Ensure first tab is active by default
        switchTab('overview');
    }

    function closeApplicationDetails() {
        elements.detailsModal.classList.remove('show');
        selectedApplication = null;
    }

    function switchTab(tabName) {
        // Update tab triggers
        elements.tabTriggers.forEach(trigger => {
            trigger.classList.remove('bg-white', 'text-blue-600', 'shadow-sm', 'active');
            trigger.classList.add('bg-transparent', 'text-gray-600', 'hover:bg-gray-50');
            
            if (trigger.dataset.tab === tabName) {
                trigger.classList.remove('bg-transparent', 'text-gray-600', 'hover:bg-gray-50');
                trigger.classList.add('bg-white', 'text-blue-600', 'shadow-sm', 'active');
            }
        });

        // Update tab contents
        elements.tabContents.forEach(content => {
            content.classList.remove('active', 'block');
            content.classList.add('hidden');
            
            if (content.id === `${tabName}-tab`) {
                content.classList.remove('hidden');
                content.classList.add('active', 'block');
            }
        });
    }

    function populateModalContent(application) {
        // Application Summary
        elements.applicationSummary.innerHTML = `
            <div class="flex justify-between">
                <span class="text-gray-600">Application ID:</span>
                <span class="font-medium">${application.id}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">File Number:</span>
                <span class="font-mono">${application.fileNumber}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">ARN:</span>
                <span class="font-mono">${application.arn}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Date Submitted:</span>
                <span>${application.dateSubmitted}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Status:</span>
                <span class="${getStatusBadgeClass(application.status)}">${application.status.charAt(0).toUpperCase() + application.status.slice(1)}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Assigned Officer:</span>
                <span>${application.assignedOfficer}</span>
            </div>
        `;

        // Fees Summary
        elements.feesSummary.innerHTML = `
            <div class="flex justify-between">
                <span class="text-gray-600">Application Fee:</span>
                <span>₦${application.fees.applicationFee}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Processing Fee:</span>
                <span>₦${application.fees.processingFee}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Survey Fee:</span>
                <span>₦${application.fees.surveyFee}</span>
            </div>
            <div class="flex justify-between border-t border-gray-200 pt-2 mt-2">
                <span class="text-gray-600 font-medium">Total Paid:</span>
                <span class="font-medium">₦${application.fees.totalPaid}</span>
            </div>
        `;

        // Comments
        elements.applicationComments.textContent = application.comments;

        // Timeline
        elements.applicationTimeline.innerHTML = `
            <div class="flex gap-3">
                <div class="flex flex-col items-center">
                    <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                        <i data-lucide="check-circle-2" class="h-4 w-4 text-green-600"></i>
                    </div>
                    <div class="w-0.5 h-full bg-gray-200 mt-1"></div>
                </div>
                <div>
                    <p class="font-medium">Application Submitted</p>
                    <p class="text-sm text-gray-600">${application.dateSubmitted}</p>
                    <p class="text-sm mt-1">Application was submitted by ${application.applicantName}</p>
                </div>
            </div>
            <div class="flex gap-3">
                <div class="flex flex-col items-center">
                    <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                        <i data-lucide="user" class="h-4 w-4 text-blue-600"></i>
                    </div>
                    <div class="w-0.5 h-full bg-gray-200 mt-1"></div>
                </div>
                <div>
                    <p class="font-medium">Officer Assigned</p>
                    <p class="text-sm text-gray-600">${application.dateSubmitted}</p>
                    <p class="text-sm mt-1">Application assigned to ${application.assignedOfficer}</p>
                </div>
            </div>
            <div class="flex gap-3">
                <div class="flex flex-col items-center">
                    <div class="h-8 w-8 rounded-full bg-amber-100 flex items-center justify-center">
                        <i data-lucide="file-text" class="h-4 w-4 text-amber-600"></i>
                    </div>
                </div>
                <div>
                    <p class="font-medium">Document Verification</p>
                    <p class="text-sm text-gray-600">In Progress</p>
                    <p class="text-sm mt-1">${application.documents.filter(d => d.status === 'verified').length} of ${application.documents.length} documents verified</p>
                </div>
            </div>
        `;

        // Applicant Details
        const applicantDetailsHtml = `
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600">Full Name</p>
                    <p class="font-medium">${application.applicantName}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Applicant Type</p>
                    <p class="font-medium capitalize">${application.applicantType}</p>
                </div>
            </div>
            <div>
                <p class="text-sm text-gray-600">Address</p>
                <p class="font-medium">${application.applicantDetails.address}</p>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600">Phone Number</p>
                    <p class="font-medium">${application.applicantDetails.phone}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Email Address</p>
                    <p class="font-medium">${application.applicantDetails.email}</p>
                </div>
            </div>
        `;

        if (application.applicantType === 'corporate') {
            elements.applicantDetails.innerHTML = applicantDetailsHtml + `
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">RC Number</p>
                        <p class="font-medium">${application.applicantDetails.rcNumber}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Contact Person</p>
                        <p class="font-medium">${application.applicantDetails.contactPerson}</p>
                    </div>
                </div>
            `;
        } else {
            elements.applicantDetails.innerHTML = applicantDetailsHtml + `
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">ID Type</p>
                        <p class="font-medium">${application.applicantDetails.idType}</p>
                    </div>
                    ${application.applicantDetails.nin ? `
                        <div>
                            <p class="text-sm text-gray-600">NIN</p>
                            <p class="font-medium">${application.applicantDetails.nin}</p>
                        </div>
                    ` : ''}
                </div>
            `;
        }

        // Ownership Details
        elements.ownershipDetails.innerHTML = `
            <div>
                <p class="text-sm text-gray-600">Ownership Type</p>
                <p class="font-medium capitalize">${application.ownershipType}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Declaration</p>
                <p class="text-sm mt-1">I/we hereby declare that by signing this form I/we solemnly swear that information provided above in this application form is to the best of my/our knowledge complete, accurate and true, and that false declaration may lead to prosecution in term of Section 37 of the Land Use Act of 1978.</p>
            </div>
        `;

        // Property Details
        elements.propertyDetails.innerHTML = `
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <p class="text-sm text-gray-600">Plot Number</p>
                    <p class="font-medium">${application.propertyDetails.plotNumber}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Block Number</p>
                    <p class="font-medium">${application.propertyDetails.blockNumber}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Land Use</p>
                    <div class="flex items-center gap-1 font-medium">
                        <i data-lucide="${getLandUseIcon(application.propertyDetails.landUse)}" class="h-4 w-4 ${getLandUseColor(application.propertyDetails.landUse)}"></i>
                        <span class="capitalize">${application.propertyDetails.landUse}</span>
                    </div>
                </div>
            </div>
            <div>
                <p class="text-sm text-gray-600">Street Name</p>
                <p class="font-medium">${application.propertyDetails.streetName}</p>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600">Location</p>
                    <p class="font-medium">${application.propertyDetails.location}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">LGA</p>
                    <p class="font-medium">${application.propertyDetails.lga}</p>
                </div>
            </div>
            <div>
                <p class="text-sm text-gray-600">GPS Coordinates</p>
                <p class="font-medium">Lat: ${application.propertyDetails.gpsCoordinates.lat}, Lng: ${application.propertyDetails.gpsCoordinates.lng}</p>
            </div>
        `;

        // Document Status
        elements.documentStatus.innerHTML = application.documents.map(doc => {
            const statusIcon = getDocumentStatusIcon(doc.status);
            return `
                <div class="flex items-center justify-between border-b border-gray-200 pb-3">
                    <div class="flex items-center gap-2">
                        <i data-lucide="file-text" class="h-5 w-5 text-blue-500"></i>
                        <div>
                            <p class="font-medium">${doc.name}</p>
                            <p class="text-xs text-gray-600">
                                ${doc.status === 'verified' ? 'Document verified successfully' :
                                  doc.status === 'pending' ? 'Document verification in progress' :
                                  doc.status === 'invalid' ? 'Document verification failed' :
                                  'Document not submitted'}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-1">
                        <i data-lucide="${statusIcon.icon}" class="h-4 w-4 ${statusIcon.color}"></i>
                        <span class="text-sm capitalize">${doc.status}</span>
                    </div>
                </div>
            `;
        }).join('');

        // Required Documents
        const requiredDocs = [
            'Proof of Identity (National ID, Passport, etc.)',
            'Proof of Ownership (Deed, Certificate, etc.)',
            'Survey Plan',
            'Tax Receipt'
        ];

        if (application.applicantType === 'corporate') {
            requiredDocs.push('CAC Registration Documents');
        }

        elements.requiredDocuments.innerHTML = requiredDocs.map(doc => `
            <li class="flex items-center gap-2 text-sm">
                <i data-lucide="check-circle-2" class="h-4 w-4 text-green-500"></i>
                ${doc}
            </li>
        `).join('');

        // Re-initialize Lucide icons for the modal content
        lucide.createIcons();
    }

    function renderTable() {
        const filteredApps = filterApplications(currentFilter);
        elements.tableBody.innerHTML = '';

        if (filteredApps.length === 0) {
            elements.tableBody.innerHTML = `
                <tr>
                    <td colspan="8" class="text-center py-4">No applications found</td>
                </tr>
            `;
            return;
        }

        filteredApps.forEach(application => {
            // Main row
            const mainRow = document.createElement('tr');
            mainRow.className = 'cursor-pointer hover:bg-gray-50/30';
            mainRow.innerHTML = `
                <td class="p-3 border-b border-gray-200 font-medium">${application.id}</td>
                <td class="p-3 border-b border-gray-200 font-mono text-sm">${application.fileNumber}</td>
                <td class="p-3 border-b border-gray-200">${application.applicantName}</td>
                <td class="p-3 border-b border-gray-200">
                    <div class="flex items-center gap-1">
                        <i data-lucide="${getLandUseIcon(application.propertyDetails.landUse)}" class="h-4 w-4 ${getLandUseColor(application.propertyDetails.landUse)}"></i>
                        <span class="capitalize">${application.propertyDetails.landUse}</span>
                    </div>
                </td>
                <td class="p-3 border-b border-gray-200">${application.propertyDetails.location}</td>
                <td class="p-3 border-b border-gray-200">${application.dateSubmitted}</td>
                <td class="p-3 border-b border-gray-200">
                    <span class="${getStatusBadgeClass(application.status)}">
                        ${application.status.charAt(0).toUpperCase() + application.status.slice(1)}
                    </span>
                </td>
                <td class="p-3 border-b border-gray-200 text-right">
                    <div class="flex items-center justify-end gap-1">
                        <button class="inline-flex items-center justify-center bg-transparent text-gray-700 hover:bg-gray-100 h-8 w-8 rounded-md expand-btn" data-id="${application.id}">
                            <i data-lucide="${expandedRows[application.id] ? 'chevron-down' : 'chevron-right'}" class="h-4 w-4"></i>
                        </button>
                        <div class="dropdown relative inline-block">
                            <button class="inline-flex items-center justify-center bg-transparent text-gray-700 hover:bg-gray-100 h-8 w-8 rounded-md dropdown-btn">
                                <i data-lucide="more-horizontal" class="h-4 w-4"></i>
                            </button>
                            <div class="dropdown-content absolute top-full right-0 z-50 bg-white border border-gray-200 rounded-lg shadow-lg py-2 min-w-48 mt-1">
                                <div class="dropdown-item flex items-center px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-gray-100 view-details-btn" data-id="${application.id}">
                                    <i data-lucide="eye" class="h-4 w-4 mr-2"></i>
                                    View Details
                                </div>
                                ${application.status === 'pending' ? `
                                    <div class="dropdown-item flex items-center px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-gray-100">
                                        <i data-lucide="check-circle-2" class="h-4 w-4 mr-2"></i>
                                        Approve
                                    </div>
                                    <div class="dropdown-item flex items-center px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-gray-100">
                                        <i data-lucide="x-circle" class="h-4 w-4 mr-2"></i>
                                        Reject
                                    </div>
                                ` : ''}
                                <div class="dropdown-item flex items-center px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-gray-100">
                                    <i data-lucide="file-text" class="h-4 w-4 mr-2"></i>
                                    Generate Report
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            `;
            elements.tableBody.appendChild(mainRow);

            // Expanded row
            if (expandedRows[application.id]) {
                const expandedRow = document.createElement('tr');
                expandedRow.className = 'bg-gray-50/20';
                expandedRow.innerHTML = `
                    <td colspan="8" class="p-0">
                        <div class="p-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Applicant Details -->
                            <div class="space-y-2">
                                <h4 class="text-sm font-medium flex items-center gap-1">
                                    <i data-lucide="user" class="h-4 w-4"></i> Applicant Details
                                </h4>
                                <div class="text-sm space-y-1">
                                    <p><span class="text-gray-600">Name:</span> ${application.applicantName}</p>
                                    <p><span class="text-gray-600">Type:</span> ${application.applicantType}</p>
                                    <p><span class="text-gray-600">Address:</span> ${application.applicantDetails.address}</p>
                                    <p><span class="text-gray-600">Phone:</span> ${application.applicantDetails.phone}</p>
                                    <p><span class="text-gray-600">Email:</span> ${application.applicantDetails.email}</p>
                                    ${application.applicantType === 'corporate' ? 
                                        `<p><span class="text-gray-600">RC Number:</span> ${application.applicantDetails.rcNumber}</p>` :
                                        `<p><span class="text-gray-600">ID Type:</span> ${application.applicantDetails.idType}</p>`
                                    }
                                </div>
                            </div>

                            <!-- Property Details -->
                            <div class="space-y-2">
                                <h4 class="text-sm font-medium flex items-center gap-1">
                                    <i data-lucide="map-pin" class="h-4 w-4"></i> Property Details
                                </h4>
                                <div class="text-sm space-y-1">
                                    <p><span class="text-gray-600">Plot Number:</span> ${application.propertyDetails.plotNumber}</p>
                                    <p><span class="text-gray-600">Block Number:</span> ${application.propertyDetails.blockNumber}</p>
                                    <p><span class="text-gray-600">Street:</span> ${application.propertyDetails.streetName}</p>
                                    <p><span class="text-gray-600">Location:</span> ${application.propertyDetails.location}</p>
                                    <p><span class="text-gray-600">LGA:</span> ${application.propertyDetails.lga}</p>
                                    <p><span class="text-gray-600">GPS:</span> ${application.propertyDetails.gpsCoordinates.lat}, ${application.propertyDetails.gpsCoordinates.lng}</p>
                                </div>
                            </div>

                            <!-- Application Details -->
                            <div class="space-y-2">
                                <h4 class="text-sm font-medium flex items-center gap-1">
                                    <i data-lucide="file-text" class="h-4 w-4"></i> Application Details
                                </h4>
                                <div class="text-sm space-y-1">
                                    <p><span class="text-gray-600">File Number:</span> ${application.fileNumber}</p>
                                    <p><span class="text-gray-600">ARN:</span> ${application.arn}</p>
                                    <p><span class="text-gray-600">Ownership:</span> ${application.ownershipType}</p>
                                    <p><span class="text-gray-600">Date:</span> ${application.dateSubmitted}</p>
                                    <p><span class="text-gray-600">Status:</span> ${application.status}</p>
                                    <p><span class="text-gray-600">Officer:</span> ${application.assignedOfficer}</p>
                                </div>
                            </div>

                            <!-- Documents -->
                            <div class="md:col-span-2 space-y-2">
                                <h4 class="text-sm font-medium flex items-center gap-1">
                                    <i data-lucide="file-text" class="h-4 w-4"></i> Documents
                                </h4>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                    ${application.documents.map(doc => {
                                        const statusIcon = getDocumentStatusIcon(doc.status);
                                        return `
                                            <div class="border border-gray-200 rounded-md p-2 flex items-center gap-2">
                                                <i data-lucide="${statusIcon.icon}" class="h-4 w-4 ${statusIcon.color}"></i>
                                                <span class="text-sm">${doc.name}</span>
                                            </div>
                                        `;
                                    }).join('')}
                                </div>
                            </div>

                            <!-- Fees -->
                            <div class="space-y-2">
                                <h4 class="text-sm font-medium flex items-center gap-1">
                                    <i data-lucide="calendar" class="h-4 w-4"></i> Fees & Payments
                                </h4>
                                <div class="text-sm space-y-1">
                                    <p><span class="text-gray-600">Application Fee:</span> ₦${application.fees.applicationFee}</p>
                                    <p><span class="text-gray-600">Processing Fee:</span> ₦${application.fees.processingFee}</p>
                                    <p><span class="text-gray-600">Survey Fee:</span> ₦${application.fees.surveyFee}</p>
                                    <p><span class="text-gray-600">Total Paid:</span> ₦${application.fees.totalPaid}</p>
                                </div>
                            </div>
                        </div>
                    </td>
                `;
                elements.tableBody.appendChild(expandedRow);
            }
        });

        // Re-initialize Lucide icons
        lucide.createIcons();

        // Add event listeners
        addTableEventListeners();
    }

    function addTableEventListeners() {
        // Expand/collapse buttons
        document.querySelectorAll('.expand-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const id = btn.dataset.id;
                toggleRowExpansion(id);
            });
        });

        // Dropdown buttons
        document.querySelectorAll('.dropdown-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const dropdown = btn.nextElementSibling;
                
                // Close all other dropdowns
                document.querySelectorAll('.dropdown-content').forEach(d => {
                    if (d !== dropdown) d.classList.remove('show');
                });
                
                dropdown.classList.toggle('show');
            });
        });

        // View details buttons
        document.querySelectorAll('.view-details-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const id = btn.dataset.id;
                const application = mockApplications.find(app => app.id === id);
                if (application) {
                    openApplicationDetails(application);
                }
                
                // Close dropdown
                btn.closest('.dropdown-content').classList.remove('show');
            });
        });
    }

    function setActiveFilter(status) {
        currentFilter = status;
        
        // Update button states
        elements.filterBtns.forEach(btn => {
            btn.classList.remove('bg-blue-600', 'text-white', 'hover:bg-blue-700', 'active');
            btn.classList.add('bg-transparent', 'border', 'border-gray-300', 'text-gray-700', 'hover:bg-gray-100');
            
            if (btn.dataset.status === status) {
                btn.classList.remove('bg-transparent', 'border', 'border-gray-300', 'text-gray-700', 'hover:bg-gray-100');
                btn.classList.add('bg-blue-600', 'text-white', 'hover:bg-blue-700', 'active');
            }
        });
        
        renderTable();
    }

    // Event listeners
    elements.filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            setActiveFilter(btn.dataset.status);
        });
    });

    elements.closeModal.addEventListener('click', closeApplicationDetails);

    elements.detailsModal.addEventListener('click', (e) => {
        if (e.target === elements.detailsModal) {
            closeApplicationDetails();
        }
    });

    elements.tabTriggers.forEach(trigger => {
        trigger.addEventListener('click', () => {
            switchTab(trigger.dataset.tab);
        });
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.dropdown')) {
            document.querySelectorAll('.dropdown-content').forEach(dropdown => {
                dropdown.classList.remove('show');
            });
        }
    });

    // Initialize the page
    function init() {
        renderTable();
    }

    // Initialize when DOM is loaded
    document.addEventListener('DOMContentLoaded', init);
</script>