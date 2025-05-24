<style>
    /* Custom styles */
    .dialog-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 50;
    }
    
    .dialog-content {
        background-color: white;
        border-radius: 0.5rem;
        padding: 1.5rem;
        max-width: 900px;
        width: 90%;
        max-height: 90vh;
        overflow: hidden; /* Changed from overflow-y: auto to prevent double scrollbars */
        display: flex;
        flex-direction: column;
    }
    
    /* Make internal container scrollable instead of entire dialog */
    .dialog-content form {
        display: flex;
        flex-direction: column;
        height: 100%;
        overflow: hidden;
    }

    .dialog-content .max-h-\[75vh\] {
        overflow-y: auto;
        flex-grow: 1;
        padding-right: 0.75rem; /* Give space for scrollbar */
    }
    
    /* Dialog content for property form specifically */
    .property-form-content {
        max-width: 1000px; /* Even wider for property forms */
    }
    
    /* Add this to ensure close buttons are clickable */
    .dialog-content button[id^="close-"], 
    .dialog-content button[id^="cancel-"] {
        cursor: pointer;
        z-index: 100;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .hidden {
        display: none !important; /* Use !important to override any other styles */
    }
    
    /* Fix for tab content display issues */
    .tab-content {
        display: block; /* Always visible since no more tabs */
    }
    
    /* File number tab content styles */
    .tabcontent {
        display: none !important; /* Default hidden - with important to override any inline styles */
        width: 100%; 
        visibility: hidden;
    }
    
    .tabcontent.active {
        display: block !important; /* Shown when active - with important to override any inline styles */
        visibility: visible;
    }
    
    .badge {
        display: inline-flex;
        align-items: center;
        border-radius: 9999px;
        padding: 0.25rem 0.75rem;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .badge-green {
        background-color: #10b981;
        color: white;
    }
    
    .badge-outline {
        background-color: transparent;
        border: 1px solid #e5e7eb;
    }

    .form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: #374151;
    }

    .form-input {
        width: 100%;
        padding: 0.5rem 0.75rem;
        border: 1px solid #cbd5e1;
        border-radius: 0.25rem;
        font-size: 0.875rem;
    }

    .form-select {
        width: 100%;
        padding: 0.5rem 0.75rem;
        border: 1px solid #cbd5e1;
        border-radius: 0.25rem;
        font-size: 0.875rem;
        background-color: white;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        font-weight: 500;
        border-radius: 0.375rem;
        transition: all 0.2s;
    }

    .btn-primary {
        background-color: #2563eb;
        color: white;
    }

    .btn-primary:hover {
        background-color: #1d4ed8;
    }

    .btn-secondary {
        background-color: white;
        color: #374151;
        border: 1px solid #d1d5db;
    }

    .btn-secondary:hover {
        background-color: #f9fafb;
    }

    .card {
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        overflow: hidden;
    }

    .card-header {
        padding: 1rem;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .card-body {
        padding: 1rem;
    }

    .table-container {
        overflow-x: auto;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th {
        background-color: #f9fafb;
        padding: 0.75rem 1rem;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 500;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 1px solid #e5e7eb;
    }

    .table td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #e5e7eb;
        font-size: 0.875rem;
        color: #374151;
    }

    .form-section {
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }

    .form-section-title {
        font-weight: 600;
        margin-bottom: 1rem;
        color: #1e40af;
    }

    /* Special styling for file number fields in edit/view mode */
    .disabled-tab {
        opacity: 0.8;
        cursor: not-allowed;
    }

    .disabled-tab input,
    .disabled-tab select {
        background-color: #f3f4f6;
        color: #6b7280;
        cursor: not-allowed;
    }

    /* Special style for all file tabs being visible */
    .all-tabs-visible .tabcontent {
        display: block !important;
        visibility: visible !important;
        margin-bottom: 1rem;
        opacity: 1 !important;
    }

    /* Ensure file tab headers are properly displayed */
    .file-tab-header {
        font-weight: 500;
        font-size: 0.875rem;
        color: #4b5563;
        margin-bottom: 0.5rem;
    }

    /* Hide tab buttons when all tabs are visible */
    .all-tabs-visible .tab {
        display: none;
    }

    .all-tabs-visible .tabcontent:last-child {
        border-bottom: none;
    }

    /* File tab header in view/edit mode */
    .file-tab-header {
        font-weight: 500;
        font-size: 0.875rem;
        color: #4b5563;
        margin-bottom: 0.5rem;
    }

    /* CSS to help click handling and overlay behavior */
    button svg, 
    button line, 
    button path {
        pointer-events: none;
    }

    /* Make readonly inputs still visible */
    input[readonly].form-input {
        background-color: #f9fafb !important;
        opacity: 1 !important;
        color: #374151;
    }
</style>