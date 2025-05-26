<script>
    // Add SweetAlert2 library
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof Swal === 'undefined') {
            const sweetAlertScript = document.createElement('script');
            sweetAlertScript.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
            document.head.appendChild(sweetAlertScript);
        }
    });

    // Initialize Lucide icons
    lucide.createIcons();

    // State management
    const state = {
      activeTab: 'pending',
      selectedFile: null,
      currentPage: 1,
      typedContent: '',
      typingProgress: 0,
      zoomLevel: 100,
      rotation: 0,
      showFolderView: false,
      selectedPageInFolder: null,
      pageType: '1',
      pageSubType: '1',
      serialNo: '01',
      expandedFiles: [],
      batchMode: false,
      batchTypedPages: {},
      currentBatchPageIndex: null,
      batchSubmitReady: false,
      batchProgress: 0,
      batchProcessing: false,
      processedPages: {}
    };

    const samplePages = {
      "FILE-2023-001": [
        "{{ asset('storage/upload/dummy/1.jpg') }}",
        "{{ asset('storage/upload/dummy/2.jpg') }}",
        "{{ asset('storage/upload/dummy/3.jpg') }}",
        "{{ asset('storage/upload/dummy/4.jpg') }}",
        "{{ asset('storage/upload/dummy/5.jpg') }}"
      ],
      "FILE-2023-002": [
        "{{ asset('storage/upload/dummy/1.jpg') }}",
        "{{ asset('storage/upload/dummy/2.jpg') }}",
        "{{ asset('storage/upload/dummy/3.jpg') }}"
      ],
      "FILE-2023-003": [
        "{{ asset('storage/upload/dummy/1.jpg') }}",
        "{{ asset('storage/upload/dummy/2.jpg') }}"
      ],
      "FILE-2023-004": [
        "{{ asset('storage/upload/dummy/1.jpg') }}",
        "{{ asset('storage/upload/dummy/2.jpg') }}",
        "{{ asset('storage/upload/dummy/3.jpg') }}",
        "{{ asset('storage/upload/dummy/4.jpg') }}"
      ],
      "FILE-2023-005": [
        "{{ asset('storage/upload/dummy/1.jpg') }}",
        "{{ asset('storage/upload/dummy/2.jpg') }}",
        "{{ asset('storage/upload/dummy/3.jpg') }}",
        "{{ asset('storage/upload/dummy/4.jpg') }}",
        "{{ asset('storage/upload/dummy/5.jpg') }}",
        "{{ asset('storage/upload/dummy/6.jpg') }}"
      ],
      "FILE-2023-006": [
        "{{ asset('storage/upload/dummy/1.jpg') }}",
        "{{ asset('storage/upload/dummy/2.jpg') }}",
        "{{ asset('storage/upload/dummy/3.jpg') }}"
      ],
      "SCAN-EXAMPLE": [
        "{{ asset('storage/upload/dummy/1.jpg') }}",
        "{{ asset('storage/upload/dummy/2.jpg') }}",
        "{{ asset('storage/upload/dummy/3.jpg') }}"
      ]
    };

    // Sample data for pending typing files
    const pendingFiles = [
      {
        id: "FILE-2023-001",
        fileNumber: "KNML 34591",
        name: "Certificate of Occupancy - Alhaji Ibrahim Dantata",
        type: "Certificate of Occupancy",
        pages: 5,
        completed: 0,
        date: "2023-06-15",
        status: "Pending",
      },
      {
        id: "FILE-2023-002",
        fileNumber: "KNGP 00892",
        name: "Site Plan - Hajiya Amina Yusuf",
        type: "Site Plan",
        pages: 3,
        completed: 0,
        date: "2023-06-14",
        status: "Pending",
      },
      {
        id: "FILE-2023-003",
        fileNumber: "KNML 42786",
        name: "Letter of Administration - Kano Traders Association",
        type: "Letter of Administration",
        pages: 2,
        completed: 0,
        date: "2023-06-13",
        status: "Pending",
      },
      {
        id: "SCAN-EXAMPLE",
        fileNumber: "KNML 09846",
        name: "Certificate of Occupancy - Example",
        type: "Certificate of Occupancy",
        pages: 3,
        completed: 0,
        date: "2023-06-18",
        status: "Pending",
      }
    ];

    // Sample data for in-progress typing files
    const inProgressFiles = [
      {
        id: "FILE-2023-006",
        fileNumber: "KNML 09213",
        name: "Land Use Permit - Abdullahi Sani",
        type: "Land Use Permit",
        pages: 3,
        completed: 1,
        date: "2023-06-09",
        status: "In Progress",
      }
    ];

    // Sample data for completed typing files
    const completedFiles = [
      {
        id: "FILE-2023-004",
        fileNumber: "KNGP 01478",
        name: "Right of Occupancy - Musa Usman Bayero",
        type: "Right of Occupancy",
        pages: 4,
        completed: 4,
        date: "2023-06-12",
        status: "Completed",
        processedPages: [
          { pageNumber: 1, pageCode: "KNGP 01478-1-1-01", pageType: "File Cover", pageSubType: "New File Cover" },
          {
            pageNumber: 2,
            pageCode: "KNGP 01478-5-5-02",
            pageType: "Land Title",
            pageSubType: "Certificate of Occupancy",
          },
          { pageNumber: 3, pageCode: "KNGP 01478-9-25-03", pageType: "Survey", pageSubType: "Survey Plan" },
          {
            pageNumber: 4,
            pageCode: "KNGP 01478-4-8-04",
            pageType: "Correspondence",
            pageSubType: "Acknowledgment Letter",
          }
        ]
      },
      {
        id: "FILE-2023-005",
        fileNumber: "KNML 37925",
        name: "Deed of Assignment - Hajiya Fatima Mohammed",
        type: "Deed of Assignment",
        pages: 6,
        completed: 6,
        date: "2023-06-10",
        status: "Completed",
        processedPages: [
          { pageNumber: 1, pageCode: "KNML 37925-1-1-01", pageType: "File Cover", pageSubType: "New File Cover" },
          { pageNumber: 2, pageCode: "KNML 37925-6-53-02", pageType: "Legal", pageSubType: "Deed of Assignment" },
          { pageNumber: 3, pageCode: "KNML 37925-6-53-03", pageType: "Legal", pageSubType: "Deed of Assignment" },
          { pageNumber: 4, pageCode: "KNML 37925-7-20-04", pageType: "Payment Evidence", pageSubType: "Bank Teller" },
          { pageNumber: 5, pageCode: "KNML 37925-7-78-05", pageType: "Payment Evidence", pageSubType: "Receipts" },
          {
            pageNumber: 6,
            pageCode: "KNML 37925-4-72-06",
            pageType: "Correspondence",
            pageSubType: "Letter of Acceptance",
          }
        ]
      }
    ];

    // Page types and subtypes
    const pageTypes = [
      { id: 1, code: "FC", name: "File Cover" },
      { id: 2, code: "APP", name: "Application" },
      { id: 3, code: "BN", name: "Bill Notice" },
      { id: 4, code: "COR", name: "Correspondence" },
      { id: 5, code: "LT", name: "Land Title" },
      { id: 6, code: "LEG", name: "Legal" },
      { id: 7, code: "PE", name: "Payment Evidence" },
      { id: 8, code: "REP", name: "Report" },
      { id: 9, code: "SUR", name: "Survey" },
      { id: 10, code: "MISC", name: "Miscellaneous" },
      { id: 11, code: "IMG", name: "Image" },
      { id: 12, code: "TP", name: "Town Planning" }
    ];

    // Page subtypes organized by page type ID
    const pageSubTypes = {
      1: [
        // File Cover
        { id: 1, code: "NFC", name: "New File Cover" },
        { id: 2, code: "OFC", name: "Old File Cover" }
      ],
      2: [
        // Application
        { id: 3, code: "CO", name: "Certificate of Occupancy" },
        { id: 4, code: "REV", name: "Revalidation" },
        { id: 42, code: "OTH", name: "Others" },
        { id: 96, code: "ASI", name: "Application for Surrender/Issuance of CofO" },
        { id: 97, code: "ATF", name: "Application for Temporary Files" },
        { id: 128, code: "REC", name: "Recertification" },
        { id: 136, code: "INS", name: "Inspection" },
        { id: 137, code: "CF", name: "Computer Form" }
      ],
      3: [
        // Bill Notice
        { id: 7, code: "DGR", name: "Demand for Ground Rent" },
        { id: 34, code: "DN", name: "Demand Notice" },
        { id: 35, code: "MISC", name: "Miscellaneous" },
        { id: 77, code: "NOA", name: "Notice of Assessment" },
        { id: 92, code: "AUC", name: "Auction Notice" },
        { id: 133, code: "FRP", name: "First Registration of Plot Bill" }
      ],
      4: [
        // Correspondence
        { id: 8, code: "AL", name: "Acknowledgment Letter" },
        { id: 9, code: "ASR", name: "Application Submission for Recommendation" },
        { id: 10, code: "ACO", name: "Approval of Certificate of Occupancy" },
        { id: 11, code: "AUL", name: "Authority Letter" },
        { id: 12, code: "BIR", name: "Board of Internal Revenue" },
        { id: 13, code: "CL", name: "Conveyance Letter" },
        { id: 14, code: "DTP", name: "Director Town Planning" },
        { id: 15, code: "SD", name: "Survey Description" },
        { id: 16, code: "SP", name: "Survey Plan" },
        { id: 17, code: "SG", name: "Surveyor General" },
        { id: 29, code: "MISC", name: "Miscellaneous" },
        { id: 30, code: "IM", name: "Internal Memo" },
        { id: 31, code: "EM", name: "External Memo" }
        // ... more subtypes
      ],
      5: [
        // Land Title
        { id: 5, code: "CO", name: "Certificate of Occupancy" },
        { id: 6, code: "SP", name: "Survey Plan" },
        { id: 32, code: "MISC", name: "Miscellaneous" },
        { id: 130, code: "LFR", name: "Letter of First Registration" },
        { id: 131, code: "CR", name: "Confirmation of Registration" },
        { id: 140, code: "PRO", name: "Provisional Right of Occupancy" }
      ],
      6: [
        // Legal
        { id: 18, code: "AGR", name: "Agreement" },
        { id: 39, code: "REP", name: "Report" },
        { id: 44, code: "POA", name: "Power of Attorney" },
        { id: 45, code: "DOS", name: "Deed of Surrender" },
        { id: 46, code: "WCC", name: "Withdrawal of Clients CofO" },
        { id: 48, code: "CACC", name: "CAC Certificate" },
        { id: 49, code: "CI", name: "Certificate of Incorporation" },
        { id: 50, code: "LA", name: "Letter of Administration" },
        { id: 51, code: "MISC", name: "Miscellaneous" },
        { id: 53, code: "DOA", name: "Deed of Assignment" }
        // ... more subtypes
      ],
      7: [
        // Payment Evidence
        { id: 19, code: "AOF", name: "Assessment of Fees" },
        { id: 20, code: "BT", name: "Bank Teller" },
        { id: 21, code: "ITCC", name: "Income Tax Clearance Certificate" },
        { id: 22, code: "RCR", name: "Revenue Collector's Receipt" },
        { id: 36, code: "MISC", name: "Miscellaneous" },
        { id: 41, code: "REP", name: "Report" },
        { id: 70, code: "ITPR", name: "Income TAX P.A.Y.E Receipt" },
        { id: 78, code: "REC", name: "Receipts" }
        // ... more subtypes
      ],
      8: [
        // Report
        { id: 23, code: "RR", name: "Reinspection Report" },
        { id: 37, code: "MISC", name: "Miscellaneous" },
        { id: 65, code: "IPVR", name: "Inspection and Property Valuation Report" },
        { id: 101, code: "PSR", name: "Property Search Report" },
        { id: 110, code: "LITR", name: "Low Income TAX Report" },
        { id: 111, code: "RVR", name: "Reconciliation of Valuation Report" },
        { id: 116, code: "PVR", name: "Property Valuation Report" }
      ],
      9: [
        // Survey
        { id: 24, code: "TDP", name: "Title Deed Plan" },
        { id: 25, code: "SP", name: "Survey Plan" },
        { id: 26, code: "SD", name: "Survey Description" },
        { id: 33, code: "MISC", name: "Miscellaneous" },
        { id: 38, code: "REP", name: "Report" }
      ],
      10: [
        // Miscellaneous
        { id: 27, code: "MISC", name: "Miscellaneous" },
        { id: 43, code: "OC", name: "Other Certificates" },
        { id: 59, code: "CP", name: "Company Profile" },
        { id: 132, code: "LRAT", name: "Land Registration Acknowledgment Ticket" }
      ],
      11: [
        // Image
        { id: 28, code: "PP", name: "Passport" }
      ],
      12: [
        // Town Planning
        { id: 135, code: "SKT", name: "Sketch" },
        { id: 141, code: "LP", name: "Location Plan" }
      ]
    };

    // Get all files
    const allFiles = [...pendingFiles, ...inProgressFiles, ...completedFiles];

    // DOM Elements
    const elements = {
      // Tabs
      tabs: document.querySelectorAll('[role="tab"]'),
      tabContents: document.querySelectorAll('[role="tabpanel"]'),
      typingTab: document.getElementById('typing-tab'),
      
      // File lists
      pendingFilesList: document.getElementById('pending-files-list'),
      inProgressFilesList: document.getElementById('in-progress-files-list'),
      completedFilesList: document.getElementById('completed-files-list'),
      
      // Typing card
      typingCard: document.getElementById('typing-card'),
      
      // Counters
      pendingCount: document.getElementById('pending-count'),
      inProgressCount: document.getElementById('in-progress-count'),
      completedCount: document.getElementById('completed-count')
    };

    // Helper functions
    function getFileById(fileId) {
      return allFiles.find(file => file.id === fileId);
    }

    function getPageTypeById(typeId) {
      return pageTypes.find(type => type.id.toString() === typeId);
    }

    function getPageSubTypeById(typeId, subTypeId) {
      return pageSubTypes[parseInt(typeId)]?.find(subType => subType.id.toString() === subTypeId);
    }

    function getCurrentPageImage() {
      if (!state.selectedFile || !samplePages[state.selectedFile]) {
        return null;
      }

      const pageIndex = state.currentPage - 1;
      return pageIndex >= 0 && pageIndex < samplePages[state.selectedFile].length 
        ? samplePages[state.selectedFile][pageIndex] 
        : null;
    }

    // UI update functions
    function updateUI() {
      // Update tabs
      elements.tabs.forEach(tab => {
        const tabId = tab.getAttribute('data-tab');
        tab.setAttribute('aria-selected', tabId === state.activeTab);
      });
      
      elements.tabContents.forEach(content => {
        const contentId = content.getAttribute('data-tab-content');
        content.setAttribute('aria-hidden', contentId !== state.activeTab);
      });

      // Update typing tab state
      elements.typingTab.setAttribute('aria-disabled', state.selectedFile ? 'false' : 'true');

      // Update counters
      elements.pendingCount.textContent = pendingFiles.length;
      elements.inProgressCount.textContent = inProgressFiles.length;
      elements.completedCount.textContent = completedFiles.length;

      // Render file lists
      renderPendingFiles();
      renderInProgressFiles();
      renderCompletedFiles();

      // Render typing view if needed
      if (state.selectedFile) {
        renderTypingView();
      }
    }

    function renderPendingFiles() {
      elements.pendingFilesList.innerHTML = '';
      
      if (pendingFiles.length === 0) {
        elements.pendingFilesList.innerHTML = `
          <div class="rounded-md border p-8 text-center">
            <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-muted">
              <i data-lucide="file-text" class="h-6 w-6"></i>
            </div>
            <h3 class="mb-2 text-lg font-medium">No files pending page typing</h3>
            <p class="mb-4 text-sm text-muted-foreground">All files have been processed</p>
          </div>
        `;
        lucide.createIcons();
        return;
      }
      
      pendingFiles.forEach(file => {
        const fileItem = document.createElement('div');
        fileItem.className = 'flex items-center justify-between p-4';
        fileItem.innerHTML = `
          <div class="flex items-center gap-3">
            <i data-lucide="file-text" class="h-8 w-8 text-blue-500"></i>
            <div>
              <p class="text-blue-600 font-medium">${file.fileNumber}</p>
              <p class="text-sm text-gray-700 mt-0.5">
                ${file.name.includes(" - ") ? file.name.split(" - ")[1] : file.name}
              </p>
              <div class="flex items-center gap-2 mt-1">
                <span class="badge badge-secondary text-xs">
                  ${file.pages} ${file.pages === 1 ? "page" : "pages"}
                </span>
                <span class="text-xs text-muted-foreground">${file.date}</span>
              </div>
            </div>
          </div>
          <button class="btn btn-outline btn-sm start-typing" data-id="${file.id}">
            <i data-lucide="edit" class="h-3.5 w-3.5 mr-1"></i>
            Start Page Typing
          </button>
        `;
        
        elements.pendingFilesList.appendChild(fileItem);
      });
      
      // Initialize icons for the new elements
      lucide.createIcons();
      
      // Add event listeners
      document.querySelectorAll('.start-typing').forEach(btn => {
        btn.addEventListener('click', () => {
          const fileId = btn.getAttribute('data-id');
          selectFileForTyping(fileId);
        });
      });
    }

    function renderInProgressFiles() {
      elements.inProgressFilesList.innerHTML = '';
      
      if (inProgressFiles.length === 0) {
        elements.inProgressFilesList.innerHTML = `
          <div class="rounded-md border p-8 text-center">
            <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-muted">
              <i data-lucide="file-text" class="h-6 w-6"></i>
            </div>
            <h3 class="mb-2 text-lg font-medium">No files in progress</h3>
            <p class="mb-4 text-sm text-muted-foreground">Start typing a file to see it here</p>
          </div>
        `;
        lucide.createIcons();
        return;
      }
      
      inProgressFiles.forEach(file => {
        const fileItem = document.createElement('div');
        fileItem.className = 'flex items-center justify-between p-4';
        fileItem.innerHTML = `
          <div class="flex items-center gap-3">
            <i data-lucide="file-text" class="h-8 w-8 text-orange-500"></i>
            <div class="flex-1">
              <p class="text-blue-600 font-medium">${file.fileNumber}</p>
              <p class="text-sm text-gray-700 mt-0.5">
                ${file.name.includes(" - ") ? file.name.split(" - ")[1] : file.name}
              </p>
              <div class="flex items-center gap-2 mt-1">
                <span class="badge badge-secondary text-xs">
                  ${file.completed}/${file.pages} pages
                </span>
                <span class="text-xs text-muted-foreground">${file.date}</span>
              </div>
              <div class="mt-2 w-full">
                <div class="progress">
                  <div class="progress-bar" style="width: ${(file.completed / file.pages) * 100}%"></div>
                </div>
              </div>
            </div>
          </div>
          <button class="btn btn-outline btn-sm continue-typing" data-id="${file.id}">
            <i data-lucide="edit" class="h-3.5 w-3.5 mr-1"></i>
            Continue
          </button>
        `;
        
        elements.inProgressFilesList.appendChild(fileItem);
      });
      
      // Initialize icons for the new elements
      lucide.createIcons();
      
      // Add event listeners
      document.querySelectorAll('.continue-typing').forEach(btn => {
        btn.addEventListener('click', () => {
          const fileId = btn.getAttribute('data-id');
          selectFileForTyping(fileId);
        });
      });
    }

    function renderCompletedFiles() {
      elements.completedFilesList.innerHTML = '';
      
      if (completedFiles.length === 0) {
        elements.completedFilesList.innerHTML = `
          <div class="rounded-md border p-8 text-center">
            <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-muted">
              <i data-lucide="file-text" class="h-6 w-6"></i>
            </div>
            <h3 class="mb-2 text-lg font-medium">No completed files</h3>
            <p class="mb-4 text-sm text-muted-foreground">Complete typing files to see them here</p>
          </div>
        `;
        lucide.createIcons();
        return;
      }
      
      completedFiles.forEach(file => {
        const fileItem = document.createElement('div');
        fileItem.className = 'rounded-md border overflow-hidden';
        
        // Header section
        const header = document.createElement('div');
        header.className = 'p-4 border-b bg-muted/20 cursor-pointer hover:bg-muted/30 transition-colors';
        header.setAttribute('data-id', file.id);
        header.innerHTML = `
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
              <i data-lucide="file-text" class="h-8 w-8 text-green-500"></i>
              <div>
                <p class="text-blue-600 font-medium">${file.fileNumber}</p>
                <p class="text-sm text-gray-700 mt-0.5">
                  ${file.name.includes(" - ") ? file.name.split(" - ")[1] : file.name}
                </p>
                <div class="flex items-center gap-2 mt-1">
                  <span class="badge badge-secondary text-xs">
                    ${file.pages} ${file.pages === 1 ? "page" : "pages"}
                  </span>
                  <span class="text-xs text-muted-foreground">${file.date}</span>
                </div>
              </div>
            </div>
            <div class="flex items-center gap-2">
              <span class="badge bg-green-500 text-white">
                <i data-lucide="check-circle" class="h-3 w-3 mr-1"></i>
                Completed
              </span>
              <button class="btn btn-ghost btn-icon toggle-expand" data-id="${file.id}">
                <i data-lucide="${state.expandedFiles.includes(file.id) ? 'arrow-up' : 'arrow-down'}" class="h-4 w-4"></i>
              </button>
            </div>
          </div>
        `;
        
        fileItem.appendChild(header);
        
        // Expanded content section (initially hidden)
        if (state.expandedFiles.includes(file.id)) {
          const content = document.createElement('div');
          content.className = 'p-4';
          content.innerHTML = `
            <h4 class="text-sm font-medium mb-3">Processed Pages</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
              ${file.processedPages.map((page, index) => `
                <div class="border rounded-md overflow-hidden">
                  <div class="h-32 bg-muted flex items-center justify-center">
                    ${samplePages[file.id] && samplePages[file.id][index] 
                      ? `<img src="${samplePages[file.id][index]}" alt="Page ${page.pageNumber}" class="max-h-full max-w-full object-contain">`
                      : `<i data-lucide="file-text" class="h-10 w-10 text-muted-foreground"></i>`
                    }
                  </div>
                  <div class="p-2 bg-gray-50 border-t">
                    <div class="flex justify-between items-center">
                      <span class="text-xs font-medium">Page ${page.pageNumber}</span>
                      <span class="badge badge-outline text-xs">${page.pageType}</span>
                    </div>
                    <div class="mt-1">
                      <span class="badge bg-blue-500 text-white text-xs mt-1 w-full justify-center overflow-hidden text-ellipsis">
                        ${page.pageCode}
                      </span>
                      <p class="text-xs text-muted-foreground mt-1 truncate" title="${page.pageSubType}">
                        ${page.pageSubType}
                      </p>
                    </div>
                  </div>
                </div>
              `).join('')}
            </div>
          `;
          
          fileItem.appendChild(content);
        }
        
        elements.completedFilesList.appendChild(fileItem);
      });
      
      // Initialize icons for the new elements
      lucide.createIcons();
      
      // Add event listeners
      document.querySelectorAll('.toggle-expand').forEach(btn => {
        btn.addEventListener('click', (e) => {
          e.stopPropagation();
          const fileId = btn.getAttribute('data-id');
          toggleFileExpansion(fileId);
        });
      });
      
      document.querySelectorAll('[data-id]').forEach(header => {
        if (header.classList.contains('toggle-expand')) return;
        
        header.addEventListener('click', () => {
          const fileId = header.getAttribute('data-id');
          toggleFileExpansion(fileId);
        });
      });
    }

    function renderTypingView() {
      const file = getFileById(state.selectedFile);
      if (!file) return;
      
      // Determine what to show based on state
      let content = '';
      
      // Header content
      const headerContent = `
        <div class="p-6 border-b">
          <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
              <h2 class="text-lg font-semibold">
                <span class="text-blue-600">${file.fileNumber}</span> - 
                ${file.name.split(" - ").length > 1 ? file.name.split(" - ")[1] : file.name}
              </h2>
              <p class="text-sm text-muted-foreground">
                ${state.showFolderView && state.selectedPageInFolder === null
                  ? state.batchMode
                    ? "Select pages to type in batch mode"
                    : "Select a page to type or categorize"
                  : state.selectedPageInFolder !== null
                    ? `Categorizing Page ${state.selectedPageInFolder + 1}`
                    : `Typing Page ${state.currentPage} of ${file.pages}`}
              </p>
            </div>
            <div class="flex items-center gap-2">
              ${state.showFolderView && state.selectedPageInFolder === null 
                ? `<button class="btn ${state.batchMode ? 'btn-primary' : 'btn-outline'} btn-sm toggle-batch-mode">
                    <i data-lucide="check-square" class="h-4 w-4 mr-1"></i>
                    ${state.batchMode ? 'Exit Batch Mode' : 'Batch Mode'}
                  </button>` 
                : ''}
              <button class="btn btn-outline btn-sm back-button">
                ${state.selectedPageInFolder !== null ? 'Back to Folder' : 'Cancel'}
              </button>
              ${!state.showFolderView 
                ? `<button class="btn btn-primary btn-sm save-page">
                    <i data-lucide="save" class="h-4 w-4 mr-1"></i>
                    Save Page
                  </button>` 
                : ''}
            </div>
          </div>
        </div>
      `;
      
      // Main content based on view mode
      if (state.showFolderView) {
        if (state.selectedPageInFolder !== null) {
          // Page categorization view
          content = `
            ${headerContent}
            <div class="p-6">
              <div class="space-y-6">
                <div class="flex justify-between items-center">
                  <h3 class="text-lg font-medium">Categorize Page ${state.selectedPageInFolder + 1}</h3>
                  <span class="badge bg-blue-500 text-white">${file.fileNumber}</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div>
                    <div class="border rounded-md p-4 h-[400px] bg-white relative">
                      ${samplePages[state.selectedFile] && samplePages[state.selectedFile][state.selectedPageInFolder] 
                        ? `<div class="w-full h-full flex flex-col">
                            <div class="flex justify-between mb-2">
                              <span class="text-sm font-medium">Document Preview - Page ${state.selectedPageInFolder + 1}</span>
                              <div class="flex items-center gap-2">
                                <button class="btn btn-ghost btn-icon zoom-out">
                                  <i data-lucide="zoom-out" class="h-4 w-4"></i>
                                </button>
                                <span class="text-xs">${state.zoomLevel}%</span>
                                <button class="btn btn-ghost btn-icon zoom-in">
                                  <i data-lucide="zoom-in" class="h-4 w-4"></i>
                                </button>
                                <button class="btn btn-ghost btn-icon rotate">
                                  <i data-lucide="rotate-cw" class="h-4 w-4"></i>
                                </button>
                              </div>
                            </div>
                            <div class="flex-1 overflow-auto flex items-center justify-center">
                              <img
                                src="${samplePages[state.selectedFile][state.selectedPageInFolder]}"
                                alt="Page ${state.selectedPageInFolder + 1}"
                                class="max-h-full max-w-full object-contain transition-transform"
                                style="transform: scale(${state.zoomLevel / 100}) rotate(${state.rotation}deg);"
                              />
                            </div>
                          </div>`
                        : `<div class="h-full flex items-center justify-center">
                            <div class="text-center">
                              <i data-lucide="file-text" class="h-12 w-12 mx-auto mb-4 text-muted-foreground"></i>
                              <p class="text-sm font-medium">Document preview not available</p>
                            </div>
                          </div>`
                      }
                    </div>
                  </div>
                  <div class="space-y-6">
                    <div class="space-y-4">
                      <div>
                        <label for="page-type" class="block text-sm font-medium mb-1.5">Page Type</label>
                        <select id="page-type" class="input">
                          ${pageTypes.map(type => 
                            `<option value="${type.id}" ${state.pageType == type.id ? 'selected' : ''}>
                              ${type.name} (${type.code})
                            </option>`
                          ).join('')}
                        </select>
                      </div>
                      <div>
                        <label for="page-subtype" class="block text-sm font-medium mb-1.5">Page Subtype</label>
                        <select id="page-subtype" class="input">
                          ${pageSubTypes[parseInt(state.pageType)]?.map(subtype => 
                            `<option value="${subtype.id}" ${state.pageSubType == subtype.id ? 'selected' : ''}>
                              ${subtype.name} (${subtype.code})
                            </option>`
                          ).join('')}
                        </select>
                      </div>
                      <div>
                        <label for="serial-no" class="block text-sm font-medium mb-1.5">Serial Number</label>
                        <input id="serial-no" value="${state.serialNo}" class="input" maxlength="2" pattern="[0-9]*">
                        <p class="text-xs text-muted-foreground mt-1">
                          Two-digit serial number (e.g., 01, 02, etc.)
                        </p>
                      </div>
                    </div>

                    <div class="p-4 border rounded-md bg-muted/30">
                      <h4 class="font-medium mb-2">Page Code Preview</h4>
                      <div class="flex items-center gap-2">
                        <span class="badge bg-blue-500 text-white text-base py-1 px-3">
                          ${file.fileNumber}-
                          ${getPageTypeById(state.pageType)?.code}-
                          ${getPageSubTypeById(state.pageType, state.pageSubType)?.code}-
                          ${state.serialNo}
                        </span>
                      </div>
                      <p class="text-xs text-muted-foreground mt-2">
                        This code will be assigned to the page for easy identification and retrieval.
                      </p>
                    </div>

                    <button class="btn btn-primary w-full process-page">
                      ${state.batchMode ? 'Add to Batch' : 'Process Page'}
                    </button>
                  </div>
                </div>
              </div>
            </div>
          `;
        } else {
          // Folder view
          content = `
            ${headerContent}
            <div class="p-6">
              <div class="space-y-6">
                <div class="flex justify-between items-center">
                  <h3 class="text-lg font-medium">File Pages</h3>
                  <span class="badge bg-blue-500 text-white">${file.fileNumber}</span>
                </div>

                ${state.batchMode 
                  ? `<div class="space-y-2">
                      <div class="flex justify-between text-sm">
                        <span>Batch Progress</span>
                        <span>${Math.round(state.batchProgress)}%</span>
                      </div>
                      <div class="progress">
                        <div class="progress-bar" style="width: ${state.batchProgress}%"></div>
                      </div>
                      <div class="flex justify-between text-xs text-muted-foreground">
                        <span>Pages typed: ${Object.keys(state.batchTypedPages).length}</span>
                        <span>Total pages: ${samplePages[state.selectedFile]?.length || 0}</span>
                      </div>
                    </div>`
                  : ''}

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4" id="folder-pages">
                  ${samplePages[state.selectedFile] 
                    ? samplePages[state.selectedFile].map((page, index) => `
                      <div class="border rounded-md overflow-hidden cursor-pointer hover:border-blue-500 transition-colors folder-page ${
                        (state.batchMode && state.batchTypedPages[index]) || (!state.batchMode && state.processedPages[index])
                          ? 'border-green-500 bg-green-50'
                          : ''
                      }" data-index="${index}">
                        <div class="h-40 bg-muted flex items-center justify-center relative">
                          ${((state.batchMode && state.batchTypedPages[index]) || (!state.batchMode && state.processedPages[index])) 
                            ? `<div class="absolute top-2 right-2 z-10">
                                <span class="badge bg-green-500 text-white">
                                  <i data-lucide="check-circle" class="h-3 w-3 mr-1"></i>
                                  Typed
                                </span>
                              </div>`
                            : ''}
                          <img
                            src="${page}"
                            alt="Page ${index + 1}"
                            class="max-h-full max-w-full object-contain"
                          />
                        </div>
                        <div class="p-2 bg-gray-50 border-t">
                          <div class="flex justify-between items-center">
                            <span class="text-sm font-medium">Page ${index + 1}</span>
                            <span class="badge badge-outline text-xs">
                              ${index === 0 ? 'Cover' : 'Content'}
                            </span>
                          </div>
                          <div class="mt-1 text-xs text-muted-foreground">
                            ${file.fileNumber}-${(index + 1).toString().padStart(2, '0')}
                          </div>
                          ${state.batchMode && state.batchTypedPages[index] 
                            ? `<div class="mt-1">
                                <span class="badge bg-blue-500 text-white text-xs w-full justify-center overflow-hidden text-ellipsis">
                                  ${file.fileNumber}-
                                  ${getPageTypeById(state.batchTypedPages[index].pageType)?.code}-
                                  ${getPageSubTypeById(
                                    state.batchTypedPages[index].pageType, 
                                    state.batchTypedPages[index].pageSubType
                                  )?.code}-
                                  ${state.batchTypedPages[index].serialNo}
                                </span>
                              </div>`
                            : ''}
                          ${!state.batchMode && state.processedPages[index] 
                            ? `<div class="mt-1">
                                <span class="badge bg-blue-500 text-white text-xs w-full justify-center overflow-hidden text-ellipsis">
                                  ${state.processedPages[index].pageCode}
                                </span>
                              </div>`
                            : ''}
                        </div>
                      </div>
                    `).join('')
                    : `<div class="col-span-4 text-center p-8 border rounded-md">
                        <i data-lucide="file-digit" class="h-12 w-12 mx-auto mb-4 text-muted-foreground"></i>
                        <p class="text-sm font-medium">No pages available for this file</p>
                      </div>`
                  }
                </div>

                ${state.batchMode && state.batchSubmitReady 
                  ? `<div class="mt-6 flex justify-center">
                      <button class="btn btn-primary btn-lg submit-batch ${state.batchProcessing ? 'disabled' : ''}" ${state.batchProcessing ? 'disabled' : ''}>
                        ${state.batchProcessing 
                          ? `<div class="animate-spin h-4 w-4 border-2 border-current border-t-transparent rounded-full mr-2"></div>
                             Processing Batch...`
                          : `<i data-lucide="upload" class="h-4 w-4 mr-2"></i>
                             Submit All Pages as Batch`
                        }
                      </button>
                    </div>`
                  : ''}
              </div>
            </div>
          `;
        }
      } else {
        // Traditional typing view
        content = `
          ${headerContent}
          <div class="p-6">
            <div class="space-y-6">
              <div class="space-y-2">
                <div class="flex justify-between text-sm">
                  <span>Typing Progress</span>
                  <span>${Math.round(state.typingProgress)}%</span>
                </div>
                <div class="progress">
                  <div class="progress-bar" style="width: ${state.typingProgress}%"></div>
                </div>
              </div>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <div class="border rounded-md p-4 h-[400px] bg-white relative">
                    ${getCurrentPageImage() 
                      ? `<div class="w-full h-full flex flex-col">
                          <div class="flex justify-between mb-2">
                            <span class="text-sm font-medium">Document Preview - Page ${state.currentPage}</span>
                            <div class="flex items-center gap-2">
                              <button class="btn btn-ghost btn-icon zoom-out">
                                <i data-lucide="zoom-out" class="h-4 w-4"></i>
                              </button>
                              <span class="text-xs">${state.zoomLevel}%</span>
                              <button class="btn btn-ghost btn-icon zoom-in">
                                <i data-lucide="zoom-in" class="h-4 w-4"></i>
                              </button>
                              <button class="btn btn-ghost btn-icon rotate">
                                <i data-lucide="rotate-cw" class="h-4 w-4"></i>
                              </button>
                            </div>
                          </div>
                          <div class="flex-1 overflow-auto flex items-center justify-center">
                            <img
                              src="${getCurrentPageImage()}"
                              alt="Page ${state.currentPage}"
                              class="max-h-full max-w-full object-contain transition-transform"
                              style="transform: scale(${state.zoomLevel / 100}) rotate(${state.rotation}deg);"
                            />
                          </div>
                        </div>`
                      : `<div class="h-full flex items-center justify-center">
                          <div class="text-center">
                            <i data-lucide="file-text" class="h-12 w-12 mx-auto mb-4 text-muted-foreground"></i>
                            <p class="text-sm font-medium">Document preview not available</p>
                          </div>
                        </div>`
                    }
                  </div>
                </div>
                <div>
                  <label for="typed-content" class="block text-sm font-medium mb-2">
                    Type the content of page ${state.currentPage}:
                  </label>
                  <textarea
                    id="typed-content"
                    class="textarea h-[350px]"
                    placeholder="Type the content of the document here..."
                  >${state.typedContent}</textarea>
                </div>
              </div>
            </div>
          </div>
          <div class="flex justify-between border-t pt-4 p-6">
            <div class="flex gap-2">
              <button class="btn btn-outline prev-page ${state.currentPage === 1 ? 'disabled' : ''}" ${state.currentPage === 1 ? 'disabled' : ''}>
                <i data-lucide="arrow-left" class="h-4 w-4 mr-1"></i>
                Previous Page
              </button>
              <button class="btn btn-outline next-page ${state.currentPage === file.pages ? 'disabled' : ''}" ${state.currentPage === file.pages ? 'disabled' : ''}>
                Next Page
                <i data-lucide="arrow-right" class="h-4 w-4 ml-1"></i>
              </button>
            </div>
            <button class="btn btn-primary save-continue">
              <i data-lucide="save" class="h-4 w-4 mr-1"></i>
              Save and Continue
            </button>
          </div>
        `;
      }
      
      // Update the typing card
      elements.typingCard.innerHTML = content;
      
      // Initialize icons for the new elements
      lucide.createIcons();
      
      // Add event listeners
      if (state.showFolderView) {
        if (state.selectedPageInFolder !== null) {
          // Page categorization view listeners
          document.querySelector('#page-type')?.addEventListener('change', (e) => {
            state.pageType = e.target.value;
            // Reset subtype when type changes - select first subtype of the selected type
            const firstSubtypeId = pageSubTypes[parseInt(state.pageType)]?.[0]?.id.toString() || "1";
            state.pageSubType = firstSubtypeId;
            updateUI();
          });
          
          document.querySelector('#page-subtype')?.addEventListener('change', (e) => {
            state.pageSubType = e.target.value;
            updateUI();
          });
          
          document.querySelector('#serial-no')?.addEventListener('input', (e) => {
            state.serialNo = e.target.value.padStart(2, '0');
            updateUI();
          });
          
          document.querySelector('.process-page')?.addEventListener('click', processPage);
          
          // Image controls
          document.querySelector('.zoom-in')?.addEventListener('click', zoomIn);
          document.querySelector('.zoom-out')?.addEventListener('click', zoomOut);
          document.querySelector('.rotate')?.addEventListener('click', rotate);
        } else {
          // Folder view listeners
          document.querySelector('.toggle-batch-mode')?.addEventListener('click', toggleBatchMode);
          
          document.querySelectorAll('.folder-page').forEach(page => {
            page.addEventListener('click', () => {
              const index = parseInt(page.getAttribute('data-index'));
              selectPageFromFolder(index);
            });
          });
          
          document.querySelector('.submit-batch')?.addEventListener('click', submitBatch);
        }
        
        document.querySelector('.back-button')?.addEventListener('click', () => {
          if (state.selectedPageInFolder !== null) {
            state.selectedPageInFolder = null;
          } else if (state.showFolderView) {
            state.showFolderView = false;
            state.selectedFile = null;
            state.activeTab = 'pending';
          } else {
            state.selectedFile = null;
            state.activeTab = 'pending';
          }
          updateUI();
        });
      } else {
        // Traditional typing view listeners
        document.querySelector('#typed-content')?.addEventListener('input', (e) => {
          state.typedContent = e.target.value;
        });
        
        document.querySelector('.prev-page')?.addEventListener('click', goToPreviousPage);
        document.querySelector('.next-page')?.addEventListener('click', goToNextPage);
        document.querySelector('.save-page')?.addEventListener('click', saveTypedContent);
        document.querySelector('.save-continue')?.addEventListener('click', saveTypedContent);
        
        // Image controls
        document.querySelector('.zoom-in')?.addEventListener('click', zoomIn);
        document.querySelector('.zoom-out')?.addEventListener('click', zoomOut);
        document.querySelector('.rotate')?.addEventListener('click', rotate);
        
        document.querySelector('.back-button')?.addEventListener('click', () => {
          state.selectedFile = null;
          state.activeTab = 'pending';
          updateUI();
        });
      }
    }

    // Event handlers
    function switchTab(tabId) {
      state.activeTab = tabId;
      updateUI();
    }

    function selectFileForTyping(fileId) {
      state.selectedFile = fileId;
      state.currentPage = 1;
      state.typedContent = "";
      state.activeTab = "typing";
      state.zoomLevel = 100;
      state.rotation = 0;
      state.showFolderView = true;
      state.selectedPageInFolder = null;
      state.serialNo = "01"; // Reset serial number when selecting a new file
      state.batchMode = false;
      state.batchTypedPages = {};
      state.currentBatchPageIndex = null;
      state.batchSubmitReady = false;
      state.processedPages = {};

      // Calculate progress based on completed pages
      const file = getFileById(fileId);
      if (file) {
        state.typingProgress = (file.completed / file.pages) * 100;
      }
      
      updateUI();
    }

    function saveTypedContent() {
      if (!state.selectedFile) return;

      const file = getFileById(state.selectedFile);
      if (!file) return;

      // In a real app, this would save the content to a database
      Swal.fire({
        title: 'Success!',
        text: `Content for page ${state.currentPage} of ${file.name} saved successfully!`,
        icon: 'success',
        confirmButtonText: 'OK'
      });

      // Update progress
      const newProgress = (state.currentPage / file.pages) * 100;
      state.typingProgress = newProgress;

      // Clear content for next page
      state.typedContent = "";

      // Move to next page if available
      if (state.currentPage < file.pages) {
        state.currentPage++;
      } else {
        // If all pages are completed, go back to file list
        Swal.fire({
          title: 'Complete!',
          text: 'All pages completed! Returning to file list.',
          icon: 'success',
          confirmButtonText: 'OK'
        });
        state.selectedFile = null;
        state.activeTab = "completed";
      }
      
      updateUI();
    }

    function processPage() {
      if (!state.selectedFile || state.selectedPageInFolder === null) return;

      const file = getFileById(state.selectedFile);
      if (!file) return;

      // Generate the page code with the new format including serial number
      const pageTypeObj = getPageTypeById(state.pageType);
      const pageSubTypeObj = getPageSubTypeById(state.pageType, state.pageSubType);
      
      const pageCode = `${file.fileNumber}-${pageTypeObj?.code}-${pageSubTypeObj?.code}-${state.serialNo}`;

      if (state.batchMode) {
        // In batch mode, add to batch instead of immediate submission
        state.batchTypedPages = {
          ...state.batchTypedPages,
          [state.selectedPageInFolder]: {
            pageType: state.pageType,
            pageSubType: state.pageSubType,
            serialNo: state.serialNo,
          }
        };

        // Increment serial number for next page
        const nextSerialNo = parseInt(state.serialNo) + 1;
        state.serialNo = nextSerialNo.toString().padStart(2, '0');

        // Return to folder view
        state.selectedPageInFolder = null;

        // Check if all pages are typed
        const totalPages = samplePages[state.selectedFile]?.length || 0;
        const typedPagesCount = Object.keys(state.batchTypedPages).length; // Count after adding current page

        // Update batch progress
        const progress = Math.min((typedPagesCount / totalPages) * 100, 100);
        state.batchProgress = progress;

        // If all pages are typed, show submit button
        if (typedPagesCount >= totalPages) {
          state.batchSubmitReady = true;
        }
      } else {
        // In normal mode, submit immediately
        // In a real app, this would save the page type and subtype to the database
        Swal.fire({
          title: 'Page Processed',
          text: `Page ${state.selectedPageInFolder + 1} processed with code: ${pageCode}`,
          icon: 'success',
          confirmButtonText: 'OK'
        });

        // Store the processed page information
        state.processedPages = {
          ...state.processedPages,
          [state.selectedPageInFolder]: {
            pageType: state.pageType,
            pageSubType: state.pageSubType,
            serialNo: state.serialNo,
            pageCode: pageCode,
          }
        };

        // Increment serial number for next page
        const nextSerialNo = parseInt(state.serialNo) + 1;
        state.serialNo = nextSerialNo.toString().padStart(2, '0');

        // Return to folder view
        state.selectedPageInFolder = null;
      }
      
      updateUI();
    }

    function submitBatch() {
      if (!state.selectedFile) return;

      const file = getFileById(state.selectedFile);
      if (!file) return;

      state.batchProcessing = true;
      updateUI();

      // Simulate batch processing
      setTimeout(() => {
        // In a real app, this would submit all pages to the database
        const pageCount = Object.keys(state.batchTypedPages).length;
        // Extract just the person's name from the file name (removing document type)
        const personName = file.name.includes(" - ") ? file.name.split(" - ")[1] : file.name;
        Swal.fire({
          title: 'Batch Submitted',
          text: `Successfully submitted ${pageCount} pages as a batch for ${file.fileNumber} - ${personName}!`,
          icon: 'success',
          confirmButtonText: 'OK'
        });

        // Reset batch mode
        state.batchMode = false;
        state.batchTypedPages = {};
        state.batchSubmitReady = false;
        state.batchProcessing = false;

        // Return to file list
        state.selectedFile = null;
        state.activeTab = "completed";
        
        updateUI();
      }, 2000);
    }

    function toggleBatchMode() {
      state.batchMode = !state.batchMode;
      if (!state.batchMode) {
        // Exiting batch mode, clear batch data
        state.batchTypedPages = {};
        state.batchSubmitReady = false;
        state.currentBatchPageIndex = null;
      }
      updateUI();
    }

    function goToPreviousPage() {
      if (state.currentPage > 1) {
        state.currentPage--;
        state.typedContent = "";
        updateUI();
      }
    }

    function goToNextPage() {
      const file = getFileById(state.selectedFile);
      if (file && state.currentPage < file.pages) {
        state.currentPage++;
        state.typedContent = "";
        updateUI();
      }
    }

    function zoomIn() {
      state.zoomLevel = Math.min(state.zoomLevel + 25, 200);
      updateUI();
    }

    function zoomOut() {
      state.zoomLevel = Math.max(state.zoomLevel - 25, 50);
      updateUI();
    }

    function rotate() {
      state.rotation = (state.rotation + 90) % 360;
      updateUI();
    }

    function toggleFileExpansion(fileId) {
      if (state.expandedFiles.includes(fileId)) {
        state.expandedFiles = state.expandedFiles.filter(id => id !== fileId);
      } else {
        state.expandedFiles.push(fileId);
      }
      updateUI();
    }

    function selectPageFromFolder(pageIndex) {
      // If this page is already typed in batch mode, don't allow re-typing
      if (state.batchMode && state.batchTypedPages[pageIndex]) {
        return;
      }

      state.selectedPageInFolder = pageIndex;

      // Reset form for new page
      state.pageType = "1";
      state.pageSubType = "1";
      state.typedContent = "";
      
      updateUI();
    }

    // Initialize the page
    function init() {
      // Set up event listeners for tabs
      elements.tabs.forEach(tab => {
        tab.addEventListener('click', () => {
          const tabId = tab.getAttribute('data-tab');
          if (tabId === 'typing' && !state.selectedFile) {
            return; // Don't switch to typing tab if no file is selected
          }
          switchTab(tabId);
        });
      });
      
      // Check URL for fileId parameter
      const urlParams = new URLSearchParams(window.location.search);
      const fileId = urlParams.get('fileId');
      
      if (fileId) {
        selectFileForTyping(fileId);
      }
      
      // Initial UI update
      updateUI();
    }
    
    // Initialize the page when DOM is loaded
    document.addEventListener('DOMContentLoaded', init);
  </script>