<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>File Tracking Sheet - KLAS</title>
<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>
<!-- Lucide Icons -->
<script src="https://unpkg.com/lucide@latest"></script>
<!-- QR Code Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>

<script>
// Tailwind config
tailwind.config = {
  theme: {
    extend: {
      colors: {
        primary: '#3b82f6',
        'primary-foreground': '#ffffff',
        muted: '#f3f4f6',
        'muted-foreground': '#6b7280',
        border: '#e5e7eb',
        destructive: '#ef4444',
        'destructive-foreground': '#ffffff',
        secondary: '#f1f5f9',
        'secondary-foreground': '#0f172a',
      }
    }
  }
}
</script>

<style>
/* Print styles */
@media print {
  @page {
    size: A4 landscape;
    margin: 5mm;
  }
  body * {
    visibility: hidden;
  }
  #print-content, #print-content * {
    visibility: visible;
  }
  #print-content {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    padding: 5px;
    font-size: 9px;
    transform: scale(0.98);
    transform-origin: top left;
  }
  .no-print {
    display: none !important;
  }
  /* Ensure compact display */
  .mb-4 {
    margin-bottom: 0.5rem !important;
  }
  .mb-3 {
    margin-bottom: 0.25rem !important;
  }
  .mb-2 {
    margin-bottom: 0.15rem !important;
  }
  .p-4 {
    padding: 0.5rem !important;
  }
  .p-3 {
    padding: 0.25rem !important;
  }
  .p-2 {
    padding: 0.15rem !important;
  }
  .gap-4 {
    gap: 0.5rem !important;
  }
  .h-12 {
    height: 2rem !important;
  }
  .h-\[80px\] {
    height: 3rem !important;
  }
  .py-3 {
    padding-top: 0.5rem !important;
    padding-bottom: 0.5rem !important;
  }
}

/* Badge styles */
.badge {
  display: inline-flex;
  align-items: center;
  border-radius: 9999px;
  font-size: 0.65rem;
  font-weight: 500;
  line-height: 1;
  padding: 0.15rem 0.5rem;
  white-space: nowrap;
}

.badge-default {
  background-color: #3b82f6;
  color: white;
}

.badge-outline {
  background-color: transparent;
  border: 1px solid #e5e7eb;
  color: #374151;
}

.badge-secondary {
  background-color: #f1f5f9;
  color: #0f172a;
}

.badge-destructive {
  background-color: #ef4444;
  color: white;
}

.badge-warning {
  background-color: #f59e0b;
  color: white;
}

/* Button styles */
.btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  border-radius: 0.375rem;
  font-weight: 500;
  font-size: 0.875rem;
  line-height: 1.25rem;
  padding: 0.5rem 1rem;
  transition: all 0.2s;
  cursor: pointer;
  border: none;
}

.btn-primary {
  background-color: #3b82f6;
  color: white;
}

.btn-primary:hover {
  background-color: #2563eb;
}

/* Compact table styles */
.compact-table th,
.compact-table td {
  padding: 0.25rem 0.5rem;
  font-size: 0.75rem;
}

/* QR Code container */
.qr-container {
  border: 1px solid #e5e7eb;
  border-radius: 0.375rem;
  padding: 0.5rem;
  background-color: #ffffff;
}

#qr-code-canvas {
  border: 1px solid #d1d5db;
  border-radius: 0.25rem;
}
</style>
</head>
<body class="bg-gray-50 text-sm">

<!-- Print Button (Fixed Position) -->
<div class="fixed top-2 right-2 z-10 no-print">
  <button id="print-btn" class="btn btn-primary shadow-lg text-xs">
    <i data-lucide="printer" class="h-3 w-3 mr-1"></i>
    Print
  </button>
</div>

<!-- Tracking Sheet Content -->
<div id="print-content" class="container mx-auto py-3 max-w-7xl">
  <div class="bg-white rounded-lg shadow-sm border p-4">
    <div class="tracking-sheet">
      <!-- Header Section -->
      <div class="flex justify-between items-start mb-4 pb-2 border-b-2 border-gray-800">
        <div>
          <div class="flex items-center gap-2">
            <div class="w-8 h-8 flex items-center justify-center bg-blue-100 rounded-full">
              <i data-lucide="file-text" class="h-5 w-5 text-blue-700"></i>
            </div>
            <div>
              <h2 class="text-lg font-bold text-gray-900">KANO STATE LAND REGISTRY</h2>
              <h3 class="text-sm font-semibold text-gray-700">FILE TRACKING SHEET</h3>
            </div>
          </div>
        </div>
        <div class="text-right">
          <div class="inline-block border border-gray-300 rounded-md px-3 py-1 bg-gray-50">
            <p class="text-sm font-bold text-blue-600">Tracking ID: <span id="tracking-id">TRK-2023-001</span></p>
            <p class="text-xs text-gray-500">Generated: <span id="generated-date"></span></p>
          </div>
        </div>
      </div>

      <!-- Main Content Grid -->
      <div class="grid grid-cols-12 gap-4 mb-4">
        
        <!-- File Details - Left Side -->
        <div class="col-span-8">
          <div class="text-sm font-bold border-b border-gray-300 pb-1 mb-2 text-gray-800">
            File Details
          </div>
          <div class="border border-gray-200 rounded-md p-3 bg-gray-50 mb-4">
            <h3 class="text-base font-bold mb-2 text-gray-900" id="file-title">Certificate of Occupancy - Alhaji Ibrahim Dantata</h3>
            <div class="flex items-center gap-2 mb-2">
              <span class="badge badge-default" id="status-badge">
                Status: In Process
              </span>
              <span class="badge badge-default" id="priority-badge">
                Priority: Normal
              </span>
            </div>
          </div>

          <!-- File Information and Current Location in 2 columns -->
          <div class="grid grid-cols-2 gap-4">
            <div>
              <div class="text-sm font-bold border-b border-gray-300 pb-1 mb-2 text-gray-800">
                File Information
              </div>
              <div class="bg-white rounded-md border border-gray-200 p-2">
                <div class="space-y-1 text-xs">
                  <div class="flex justify-between">
                    <span class="text-gray-600">MLSF Number:</span>
                    <span class="font-medium" id="mlsf-number">RES-2015-4859</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-gray-600">KANGIS Number:</span>
                    <span class="font-medium" id="kangis-number">KNGP 00338</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-gray-600">New KANGIS:</span>
                    <span class="font-medium" id="new-kangis-number">KNO001</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-gray-600">Date Received:</span>
                    <span class="font-medium" id="date-received">2023-06-15</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-gray-600">Due Date:</span>
                    <span class="font-medium" id="due-date">2023-06-30</span>
                  </div>
                </div>
              </div>
            </div>
            
            <div>
              <div class="text-sm font-bold border-b border-gray-300 pb-1 mb-2 text-gray-800">
                Current Location
              </div>
              <div class="bg-white rounded-md border border-gray-200 p-2">
                <div class="space-y-2 text-xs">
                  <div class="flex items-center gap-2">
                    <div class="bg-blue-100 text-blue-700 p-1 rounded">
                      <i data-lucide="map-pin" class="h-3 w-3"></i>
                    </div>
                    <div>
                      <p class="font-medium" id="current-location">Customer Care Unit</p>
                      <p class="text-gray-500">Last updated: <span id="last-updated">2023-06-15</span></p>
                    </div>
                  </div>
                  <div class="flex items-center gap-2">
                    <div class="bg-green-100 text-green-700 p-1 rounded">
                      <i data-lucide="user" class="h-3 w-3"></i>
                    </div>
                    <div>
                      <p class="font-medium" id="current-handler">Aisha Mohammed</p>
                      <p class="text-gray-500">Current handler</p>
                    </div>
                  </div>
                  <div class="flex items-center gap-2">
                    <div class="bg-purple-100 text-purple-700 p-1 rounded">
                      <i data-lucide="radio" class="h-3 w-3"></i>
                    </div>
                    <div>
                      <p class="font-medium" id="last-scanned">2023-06-15 11:45 AM</p>
                      <p class="text-gray-500">Last RFID scan</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- QR Code - Right Side -->
        <div class="col-span-4">
          <div class="text-sm font-bold border-b border-gray-300 pb-1 mb-2 text-gray-800">
            QR Code
          </div>
          <div class="qr-container">
            <div class="flex flex-col items-center">
              <canvas id="qr-code-canvas" width="100" height="100" class="mx-auto mb-1"></canvas>
              <p class="text-xs font-medium text-center">Contains file details</p>
              <p class="text-xs text-gray-500">MLSF: <span id="mlsf-display">RES-2015-4859</span></p>
              <div class="mt-1 inline-flex items-center gap-1 bg-blue-50 text-blue-700 px-2 py-1 rounded border border-blue-200 text-xs">
                <i data-lucide="tag" class="h-3 w-3"></i>
                <span class="font-medium" id="rfid-display">RFID-00125478</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Movement History -->
      <div class="mb-4">
        <div class="text-sm font-bold border-b border-gray-300 pb-1 mb-2 text-gray-800">
          Movement History
        </div>
        <div class="bg-white rounded-md border border-gray-200 overflow-hidden">
          <table class="w-full text-xs compact-table">
            <thead class="bg-gray-50">
              <tr class="border-b">
                <th class="text-left py-1 px-2 font-medium text-gray-600">Date & Time</th>
                <th class="text-left py-1 px-2 font-medium text-gray-600">Location</th>
                <th class="text-left py-1 px-2 font-medium text-gray-600">Handler</th>
                <th class="text-left py-1 px-2 font-medium text-gray-600">Action</th>
                <th class="text-left py-1 px-2 font-medium text-gray-600">Method</th>
              </tr>
            </thead>
            <tbody id="history-table-body">
              <!-- History entries will be populated by JavaScript -->
            </tbody>
          </table>
        </div>
      </div>

      <!-- Signature and Notes -->
      <div class="grid grid-cols-2 gap-4 mb-3">
        <div>
          <div class="text-sm font-bold border-b border-gray-300 pb-1 mb-2 text-gray-800">
            Signature
          </div>
          <div class="bg-white rounded-md border border-gray-200 p-3">
            <div class="h-12 border-b border-dashed mb-2"></div>
            <div class="flex justify-between items-center text-xs">
              <span class="text-gray-500">Authorized Signature</span>
              <span class="text-gray-500">Date: _____________</span>
            </div>
          </div>
        </div>
        <div>
          <div class="text-sm font-bold border-b border-gray-300 pb-1 mb-2 text-gray-800">
            Notes
          </div>
          <div class="bg-white rounded-md border border-gray-200 p-3 h-[80px]">
            <p class="text-xs text-gray-700" id="notes-content">
              All documents verified and ready for processing
            </p>
          </div>
        </div>
      </div>

      <!-- Footer -->
      <div class="pt-2 border-t border-gray-200">
        <div class="flex items-center justify-between text-xs">
          <div class="flex items-center gap-2">
            <div class="bg-gray-100 p-1 rounded-full">
              <i data-lucide="file-barcode" class="h-3 w-3 text-gray-500"></i>
            </div>
            <div>
              <p class="font-medium text-gray-700">KANO STATE LAND REGISTRY</p>
              <p class="text-gray-500">File Tracking System</p>
            </div>
          </div>
          <div class="text-right">
            <p class="text-gray-500">This tracking sheet should accompany the file at all times.</p>
            <p class="text-gray-500">For inquiries, contact File Management Office at ext. 2145.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>

  // Auto-print functionality
  function autoPrint() {
    // Set a delay to ensure all content is fully rendered
    setTimeout(() => {
      console.log('Auto-printing document...');
      window.print();
    }, 1500); // 1.5-second delay before printing
  }

  // Document ready
  document.addEventListener('DOMContentLoaded', () => {
    console.log('Page loaded, initializing tracking sheet...');
    populateTrackingSheet();
    console.log('Tracking sheet initialization complete');
    
    // Trigger automatic printing after content is loaded
    autoPrint();
  });
// Sample file data
const fileDetails = {
  id: "TRK-2023-001",
  fileName: "Certificate of Occupancy - Alhaji Ibrahim Dantata",
  fileNumber: "RES-2015-4859",
  kangisFileNo: "KNGP 00338",
  newKangisFileNo: "KNO001",
  currentLocation: "Customer Care Unit",
  currentHandler: "Aisha Mohammed",
  status: "In Process",
  priority: "Normal",
  dateReceived: "2023-06-15",
  dueDate: "2023-06-30",
  rfidTag: "RFID-00125478",
  lastScanned: "2023-06-15 11:45 AM",
  history: [
    {
      date: "2023-06-15",
      time: "09:30 AM",
      location: "Reception",
      handler: "Fatima Usman",
      action: "File received and registered",
      notes: "All documents verified",
      trackingMethod: "Manual",
    },
    {
      date: "2023-06-15",
      time: "11:45 AM",
      location: "Customer Care Unit",
      handler: "Aisha Mohammed",
      action: "File assigned for processing",
      notes: "Priority set to normal",
      trackingMethod: "RFID Scan",
    },
    {
      date: "2023-06-16",
      time: "02:15 PM",
      location: "Legal Department",
      handler: "Musa Abdullahi",
      action: "Legal review initiated",
      notes: "Documents under review",
      trackingMethod: "RFID Scan",
    },
  ],
};

// DOM elements
const elements = {
  printBtn: document.getElementById('print-btn'),
  qrCodeCanvas: document.getElementById('qr-code-canvas'),
  historyTableBody: document.getElementById('history-table-body'),
  generatedDate: document.getElementById('generated-date'),
};

// Helper function - getBadgeClass
function getBadgeClass(status, type = 'status') {
  if (type === 'status') {
    switch (status) {
      case 'Completed': return 'badge-outline';
      case 'In Process': return 'badge-default';
      case 'Pending': return 'badge-secondary';
      case 'On Hold': return 'badge-destructive';
      case 'Awaiting Approval': return 'badge-warning';
      default: return 'badge-default';
    }
  } else if (type === 'priority') {
    switch (status) {
      case 'Urgent': return 'badge-destructive';
      case 'High': return 'badge-warning';
      case 'Low': return 'badge-outline';
      default: return 'badge-default';
    }
  }
}

function generateQRCode() {
  console.log('Starting QR code generation...');
  
  const qrData = `TRK:${fileDetails.id}|FILE:${fileDetails.fileNumber}|KANGIS:${fileDetails.kangisFileNo}|LOC:${fileDetails.currentLocation}|RFID:${fileDetails.rfidTag}`;

  try {
    if (typeof QRious === 'undefined') {
      throw new Error('QRious library not loaded');
    }

    const qr = new QRious({
      element: elements.qrCodeCanvas,
      value: qrData,
      size: 100,
      level: 'M',
      background: '#ffffff',
      foreground: '#000000'
    });

    console.log('QR Code generated successfully');

  } catch (error) {
    console.error('QR Code generation error:', error);
    
    const ctx = elements.qrCodeCanvas.getContext('2d');
    ctx.fillStyle = '#f3f4f6';
    ctx.fillRect(0, 0, 100, 100);
    ctx.strokeStyle = '#d1d5db';
    ctx.strokeRect(0, 0, 100, 100);
    ctx.fillStyle = '#6b7280';
    ctx.font = '10px Arial';
    ctx.textAlign = 'center';
    ctx.fillText('QR Code', 50, 45);
    ctx.fillText('Placeholder', 50, 58);
  }
}

function populateTrackingSheet() {
  console.log('Populating tracking sheet...');
  
  // Update text content
  document.getElementById('tracking-id').textContent = fileDetails.id;
  document.getElementById('file-title').textContent = fileDetails.fileName;
  document.getElementById('mlsf-display').textContent = fileDetails.fileNumber;
  document.getElementById('rfid-display').textContent = fileDetails.rfidTag;
  document.getElementById('mlsf-number').textContent = fileDetails.fileNumber;
  document.getElementById('kangis-number').textContent = fileDetails.kangisFileNo;
  document.getElementById('new-kangis-number').textContent = fileDetails.newKangisFileNo;
  document.getElementById('date-received').textContent = fileDetails.dateReceived;
  document.getElementById('due-date').textContent = fileDetails.dueDate;
  document.getElementById('current-location').textContent = fileDetails.currentLocation;
  document.getElementById('current-handler').textContent = fileDetails.currentHandler;
  document.getElementById('last-scanned').textContent = fileDetails.lastScanned;
  document.getElementById('last-updated').textContent = fileDetails.history[fileDetails.history.length - 1]?.date;
  document.getElementById('notes-content').textContent = fileDetails.history[fileDetails.history.length - 1]?.notes || "No notes available";
  elements.generatedDate.textContent = new Date().toLocaleString();

  // Update badges
  const statusBadge = document.getElementById('status-badge');
  statusBadge.textContent = `Status: ${fileDetails.status}`;
  statusBadge.className = `badge ${getBadgeClass(fileDetails.status, 'status')}`;

  const priorityBadge = document.getElementById('priority-badge');
  priorityBadge.textContent = `Priority: ${fileDetails.priority}`;
  priorityBadge.className = `badge ${getBadgeClass(fileDetails.priority, 'priority')}`;

  // Populate history table
  elements.historyTableBody.innerHTML = '';
  fileDetails.history.forEach((entry, index) => {
    const row = document.createElement('tr');
    row.className = index % 2 === 0 ? "bg-gray-50" : "bg-white";
    row.innerHTML = `
      <td class="py-1 px-2 border-b text-xs">
        <div class="flex items-center gap-1">
          <i data-lucide="calendar" class="h-2 w-2 text-gray-400"></i>
          <span>${entry.date} ${entry.time}</span>
        </div>
      </td>
      <td class="py-1 px-2 border-b text-xs">
        <div class="flex items-center gap-1">
          <i data-lucide="map-pin" class="h-2 w-2 text-gray-400"></i>
          <span>${entry.location}</span>
        </div>
      </td>
      <td class="py-1 px-2 border-b text-xs">
        <div class="flex items-center gap-1">
          <i data-lucide="user" class="h-2 w-2 text-gray-400"></i>
          <span>${entry.handler}</span>
        </div>
      </td>
      <td class="py-1 px-2 border-b text-xs">${entry.action}</td>
      <td class="py-1 px-2 border-b text-xs">
        <span class="${entry.trackingMethod === "RFID Scan" ? "text-blue-600 font-medium" : "text-gray-600"}">
          ${entry.trackingMethod}
        </span>
      </td>
    `;
    elements.historyTableBody.appendChild(row);
  });

  // Re-initialize Lucide icons
  lucide.createIcons();
  
  // Generate QR code
  setTimeout(() => {
    generateQRCode();
  }, 100);
}

function handlePrint() {
  // Set a slight delay to ensure all elements are properly laid out
  setTimeout(() => {
    window.print();
  }, 200);
}

// Event listeners
elements.printBtn.addEventListener('click', handlePrint);

// Initialize when page loads
document.addEventListener('DOMContentLoaded', () => {
  console.log('Page loaded, initializing tracking sheet...');
  populateTrackingSheet();
  console.log('Tracking sheet initialization complete');
});
</script>
</body>
</html>