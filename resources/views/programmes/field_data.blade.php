@extends('layouts.app')

@section('page-title')
    {{ $PageTitle ?? __('KLAS') }}
@endsection
@section('content')
<style>
  /* Base styles */
  .container-card {
    background-color: white;
    border-radius: 0.5rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    border: 1px solid #e5e7eb;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
  }

  .section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #e5e7eb;
  }

  /* Dropzone styles */
  .dropzone {
    border: 2px dashed #4CAF50;
    border-radius: 8px;
    padding: 2.5rem 1.5rem;
    text-align: center;
    transition: all 0.3s ease;
    background-color: #f9fafb;
  }
  
  .dropzone.dragover {
    background-color: #e8f5e9;
    border-color: #2e7d32;
  }
  
  /* Modal styles */
  .modal {
    display: none;
    position: fixed;
    z-index: 50;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.5);
  }
  
  .modal-content {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 2rem;
    border-radius: 8px;
    width: 90%;
    max-width: 600px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  }
  
  /* File list styles */
  .file-list-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem;
    border-bottom: 1px solid #eee;
    margin-bottom: 0.5rem;
  }
  
  .progress-bar {
    height: 6px;
    background-color: #e0e0e0;
    border-radius: 3px;
    margin-top: 5px;
    width: 100%;
  }
  
  .progress {
    height: 100%;
    background-color: #4CAF50;
    border-radius: 3px;
    width: 0%;
    transition: width 0.3s ease;
  }
  
  /* Tab styling */
  .tabs {
    display: flex;
    border-bottom: 1px solid #e5e7eb;
    margin-bottom: 1.5rem;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
  }
  
  .tab-btn {
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    border-bottom: 2px solid transparent;
    cursor: pointer;
    white-space: nowrap;
    transition: all 0.2s ease;
  }
  
  .tab-btn:hover {
    color: #4CAF50;
    background-color: #f9fafb;
  }
  
  .tab-btn.active {
    border-bottom: 2px solid #4CAF50;
    color: #4CAF50;
    background-color: #f0fdf4;
  }
  
  .tab-content {
    display: none;
    padding: 1rem 0;
  }
  
  .tab-content.active {
    display: block;
  }

  /* Table styles */
  .data-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
  }

  .data-table th {
    background-color: #f9fafb;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    color: #4b5563;
    padding: 0.75rem 1rem;
    text-align: left;
    border-bottom: 1px solid #e5e7eb;
  }

  .data-table td {
    padding: 1rem;
    vertical-align: middle;
    border-bottom: 1px solid #f3f4f6;
  }

  .data-table tbody tr:hover {
    background-color: #f9fafb;
  }

  /* Button styles */
  .btn {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
  }

  .btn-primary {
    background-color: #4CAF50;
    color: white;
  }

  .btn-primary:hover {
    background-color: #3d8b40;
  }

  .btn-secondary {
    background-color: transparent;
    border: 1px solid #d1d5db;
    color: #374151;
  }

  .btn-secondary:hover {
    background-color: #f9fafb;
  }

  .btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
  }
</style>
 


<div class="flex-1 overflow-auto">
    <!-- Header -->
    @include($headerPartial ?? 'admin.header')
    
    <!-- Main Content -->
    <div class="p-6">
        <div class="container-card">
            <div class="section-header">
                <h2 class="text-xl font-bold">Field Data Import</h2>
                <button id="importBtn" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                    Import Data
                </button>
            </div>
            
            <!-- Tabs Navigation -->
            <div class="tabs">
                <div class="tab-btn active" data-tab="primary">Primary Applications</div>
                <div class="tab-btn" data-tab="secondary">Secondary Applications</div>
            </div>
            
            <!-- Primary Applications Tab (SectionalTitling) -->
            <div id="primary-tab" class="tab-content active">
                <div class="overflow-x-auto">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Owner Name</th>
                                <th>Address</th>
                                <th>Phone Number</th>
                                <th>LGA</th>
                                <th>Plot Area</th>
                                <th>File No</th>
                                <th>Date Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="primaryApplicationsTable">
                            <tr>
                                <td class="font-medium text-gray-900">Alhaji Kunle Olaniyan Taliban</td>
                                <td class="text-gray-600">No 2 DR. ADO BAYERO STREET Tarauni</td>
                                <td class="text-gray-600">08033333333</td>
                                <td class="text-gray-600">Tarauni</td>
                                <td class="text-gray-600">0.02 Ha</td>
                                <td class="text-gray-600">KN00023</td>
                                <td class="text-gray-600">2025-03-29</td>
                                <td>
                                    <button class="btn btn-sm text-indigo-600 hover:text-indigo-900 mr-2">View</button>
                                    <button class="btn btn-sm text-red-600 hover:text-red-900">Delete</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-medium text-gray-900">Mr. Nwaogwugwu Emeka Kingsley</td>
                                <td class="text-gray-600">10 11TH AV Ghhjjjnn Ajingi</td>
                                <td class="text-gray-600">08034077064</td>
                                <td class="text-gray-600">Ajingi</td>
                                <td class="text-gray-600">6.88 Ha</td>
                                <td class="text-gray-600">KN0618</td>
                                <td class="text-gray-600">2025-03-29</td>
                                <td>
                                    <button class="btn btn-sm text-indigo-600 hover:text-indigo-900 mr-2">View</button>
                                    <button class="btn btn-sm text-red-600 hover:text-red-900">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Secondary Applications Tab (SubApplication) -->
            <div id="secondary-tab" class="tab-content">
                <div class="overflow-x-auto">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Owner Name</th>
                                <th>Address</th>
                                <th>Phone Number</th>
                                <th>LGA</th>
                                <th>Unit Info</th>
                                <th>File No</th>
                                <th>Date Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="secondaryApplicationsTable">
                            <tr>
                                <td class="font-medium text-gray-900">Mr. Nwaogwugwu Emeka Hhhh</td>
                                <td class="text-gray-600">10TH ST Jjjj Ajingi</td>
                                <td class="text-gray-600">25654956666</td>
                                <td class="text-gray-600">Ajingi</td>
                                <td class="text-gray-600">Unit 1, Block 1, Section 1</td>
                                <td class="text-gray-600">KN0618</td>
                                <td class="text-gray-600">2025-03-29</td>
                                <td>
                                    <button class="btn btn-sm text-indigo-600 hover:text-indigo-900 mr-2">View</button>
                                    <button class="btn btn-sm text-red-600 hover:text-red-900">Delete</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-medium text-gray-900">Mr. Ola Niyi Kola</td>
                                <td class="text-gray-600">10TH ST Gghhh Ajingi</td>
                                <td class="text-gray-600">08022222222</td>
                                <td class="text-gray-600">Ajingi</td>
                                <td class="text-gray-600">Unit 7, Block 1, Section 1</td>
                                <td class="text-gray-600">N/A</td>
                                <td class="text-gray-600">2025-03-29</td>
                                <td>
                                    <button class="btn btn-sm text-indigo-600 hover:text-indigo-900 mr-2">View</button>
                                    <button class="btn btn-sm text-red-600 hover:text-red-900">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Empty State (hidden by default) -->
            <div id="emptyState" class="hidden flex flex-col items-center justify-center py-12 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Import History</h3>
                <p class="text-gray-600 max-w-md">
                    You haven't imported any field data yet. Click the "Import Data" button to get started.
                </p>
            </div>
        </div>
    </div>
    
    <!-- Import Modal -->
    <div id="importModal" class="modal">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-4 pb-3 border-b border-gray-200">
                <h3 class="text-lg font-bold">Import Field Data</h3>
                <button id="closeModal" class="text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <div id="dropzone" class="dropzone">
                <div id="dropzoneInitial">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-green-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    <p class="text-gray-700 mb-2 font-medium">Drag and drop your files here</p>
                    <p class="text-gray-500 text-sm mb-4">or</p>
                    <button id="browseFiles" class="btn btn-primary">
                        Browse Files
                    </button>
                    <input type="file" id="fileInput" class="hidden" multiple />
                    <p class="text-gray-500 text-xs mt-4">Supported formats: .xlsx, .xls, .csv, .json</p>
                </div>
                
                <div id="dropzoneProcessing" class="hidden">
                    <div class="mb-4">
                        <h4 class="font-medium text-gray-900 mb-3">Processing Files</h4>
                        <div id="fileList" class="text-left max-h-64 overflow-y-auto border border-gray-200 rounded-md p-2">
                            <!-- File items will be added here dynamically -->
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-3 mt-6">
                        <button id="cancelUpload" class="btn btn-secondary">
                            Cancel
                        </button>
                        <button id="importFiles" class="btn btn-primary">
                            Import
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Page Footer -->
    @include($footerPartial ?? 'admin.footer')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const importBtn = document.getElementById('importBtn');
        const importModal = document.getElementById('importModal');
        const closeModal = document.getElementById('closeModal');
        const dropzone = document.getElementById('dropzone');
        const fileInput = document.getElementById('fileInput');
        const browseFiles = document.getElementById('browseFiles');
        const cancelUpload = document.getElementById('cancelUpload');
        const importFiles = document.getElementById('importFiles');
        const fileList = document.getElementById('fileList');
        const dropzoneInitial = document.getElementById('dropzoneInitial');
        const dropzoneProcessing = document.getElementById('dropzoneProcessing');
        
        // Tab functionality
        const tabButtons = document.querySelectorAll('.tab-btn');
        const tabContents = document.querySelectorAll('.tab-content');
        
        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                const tabName = button.getAttribute('data-tab');
                
                // Update active tab button
                tabButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
                
                // Show active tab content
                tabContents.forEach(content => content.classList.remove('active'));
                document.getElementById(`${tabName}-tab`).classList.add('active');
            });
        });
        
        let files = [];
        
        // Open modal
        importBtn.addEventListener('click', function() {
            importModal.style.display = 'block';
        });
        
        // Close modal
        closeModal.addEventListener('click', function() {
            importModal.style.display = 'none';
            resetUpload();
        });
        
        // Close modal when clicking outside
        window.addEventListener('click', function(event) {
            if (event.target === importModal) {
                importModal.style.display = 'none';
                resetUpload();
            }
        });
        
        // Trigger file browse
        browseFiles.addEventListener('click', function() {
            fileInput.click();
        });
        
        // Handle file selection
        fileInput.addEventListener('change', function() {
            handleFiles(this.files);
        });
        
        // Drag and drop events
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, unhighlight, false);
        });
        
        function highlight() {
            dropzone.classList.add('dragover');
        }
        
        function unhighlight() {
            dropzone.classList.remove('dragover');
        }
        
        dropzone.addEventListener('drop', handleDrop, false);
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const droppedFiles = dt.files;
            handleFiles(droppedFiles);
        }
        
        function handleFiles(selectedFiles) {
            files = [...selectedFiles];
            
            // Show processing view
            dropzoneInitial.classList.add('hidden');
            dropzoneProcessing.classList.remove('hidden');
            
            // Clear file list
            fileList.innerHTML = '';
            
            // Add files to list
            files.forEach((file, index) => {
                const fileItem = document.createElement('div');
                fileItem.className = 'file-list-item';
                
                const isValidType = isValidFileType(file.name);
                const statusClass = isValidType ? 'text-green-600' : 'text-red-600';
                const statusText = isValidType ? 'Ready' : 'Invalid file type';
                
                fileItem.innerHTML = `
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-gray-900">${file.name}</p>
                            <p class="text-xs text-gray-500">${formatFileSize(file.size)}</p>
                        </div>
                    </div>
                    <span class="text-xs ${statusClass}">${statusText}</span>
                `;
                
                fileList.appendChild(fileItem);
            });
        }
        
        // Reset upload state
        function resetUpload() {
            files = [];
            fileInput.value = '';
            dropzoneInitial.classList.remove('hidden');
            dropzoneProcessing.classList.add('hidden');
            fileList.innerHTML = '';
        }
        
        // Cancel upload
        cancelUpload.addEventListener('click', function() {
            resetUpload();
        });
        
        // Import files
        importFiles.addEventListener('click', function() {
            if (files.length === 0) return;
            
            // Add progress bars
            const fileItems = fileList.querySelectorAll('.file-list-item');
            fileItems.forEach(item => {
                const progressContainer = document.createElement('div');
                progressContainer.className = 'progress-bar mt-2';
                progressContainer.innerHTML = '<div class="progress" style="width: 0%"></div>';
                item.firstElementChild.appendChild(progressContainer);
                
                // Update status
                const statusElement = item.querySelector('span');
                statusElement.className = 'text-xs text-blue-600';
                statusElement.textContent = 'Uploading...';
            });
            
            // Simulate upload progress
            simulateUpload(fileItems);
        });
        
        function simulateUpload(fileItems) {
            fileItems.forEach((item, index) => {
                const progress = item.querySelector('.progress');
                const statusElement = item.querySelector('span');
                
                let width = 0;
                const interval = setInterval(() => {
                    if (width >= 100) {
                        clearInterval(interval);
                        statusElement.className = 'text-xs text-green-600';
                        statusElement.textContent = 'Completed';
                        
                        // Close modal if all files complete
                        if (index === fileItems.length - 1) {
                            setTimeout(() => {
                                importModal.style.display = 'none';
                                resetUpload();
                                
                                // Update the appropriate tab based on file type
                                const fileName = item.querySelector('.text-sm.font-medium').textContent;
                                if (fileName.includes('SectionalTitling')) {
                                    // Select primary tab and refresh its data
                                    document.querySelector('[data-tab="primary"]').click();
                                } else if (fileName.includes('SubApplication')) {
                                    // Select secondary tab and refresh its data
                                    document.querySelector('[data-tab="secondary"]').click();
                                }
                            }, 1000);
                        }
                    } else {
                        width += 5;
                        progress.style.width = width + '%';
                    }
                }, 100 + Math.random() * 100);
            });
        }
        
        // Helper functions
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
        
        function isValidFileType(filename) {
            const validExtensions = ['.xlsx', '.xls', '.csv', '.json'];
            const ext = '.' + filename.split('.').pop().toLowerCase();
            return validExtensions.includes(ext);
        }
    });
</script>
@endsection


