@extends('layouts.app')
@section('page-title')
    {{ __('SLTR/First Registration Overview') }}
@endsection

@section('content')
 
    <div class="flex-1 overflow-auto">
        <!-- Header -->
        @include('admin.header')
        <!-- Dashboard Content -->
        <div class="p-6">
            
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    /* Custom styles */
 
    /* Gradient card styles */
    .gradient-card {
        background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        color: white;
        border: none;
    }

    .gradient-card .text-muted-foreground {
        color: rgba(255, 255, 255, 0.8) !important;
    }

    /* Hover scale animation */
    .hover-scale {
        transition: transform 0.2s ease-in-out;
    }

    .hover-scale:hover {
        transform: scale(1.02);
    }

    /* Fade in animation */
    .animate-fade-in {
        animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Card styles */
    .card {
        background-color: white;
        border-radius: 0.5rem;
        border: 1px solid var(--border);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
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
        background-color: var(--primary);
        color: var(--primary-foreground);
    }

    .btn-primary:hover {
        background-color: #2563eb;
    }

    .btn-outline {
        background-color: transparent;
        border: 1px solid var(--border);
        color: #374151;
    }

    .btn-outline:hover {
        background-color: var(--muted);
    }

    .btn-ghost {
        background-color: transparent;
        color: #374151;
    }

    .btn-ghost:hover {
        background-color: var(--muted);
    }

    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }

    .btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Input styles */
    .input {
        display: block;
        width: 100%;
        border-radius: 0.375rem;
        border: 1px solid var(--border);
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        line-height: 1.25rem;
        background-color: white;
    }

    .input:focus {
        outline: none;
        border-color: var(--ring);
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.3);
    }

    /* Select styles */
    .select {
        display: block;
        width: 100%;
        border-radius: 0.375rem;
        border: 1px solid var(--border);
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        line-height: 1.25rem;
        background-color: white;
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
    }

    .select:focus {
        outline: none;
        border-color: var(--ring);
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.3);
    }

    /* Badge styles */
    .badge {
        display: inline-flex;
        align-items: center;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
        line-height: 1;
        padding: 0.25rem 0.5rem;
        white-space: nowrap;
    }

    .badge-default {
        background-color: var(--primary);
        color: var(--primary-foreground);
    }

    .badge-outline {
        background-color: transparent;
        border: 1px solid var(--border);
        color: #374151;
    }

    .badge-secondary {
        background-color: var(--secondary);
        color: var(--secondary-foreground);
    }

    .badge-success {
        background-color: var(--success);
        color: white;
    }

    .badge-destructive {
        background-color: var(--destructive);
        color: white;
    }

    /* Progress bar styles */
    .progress {
        position: relative;
        height: 0.5rem;
        width: 100%;
        overflow: hidden;
        border-radius: 9999px;
        background-color: var(--secondary);
    }

    .progress-indicator {
        height: 100%;
        width: 0%;
        background-color: var(--primary);
        transition: width 0.3s ease-in-out;
        border-radius: 9999px;
    }

    .progress-indicator.bg-yellow-500 {
        background-color: #eab308;
    }

    .progress-indicator.bg-red-500 {
        background-color: #ef4444;
    }

    .progress-indicator.bg-green-500 {
        background-color: #22c55e;
    }

    /* Tab styles */
    .tabs-list {
        display: flex;
        background-color: rgba(243, 244, 246, 0.5);
        border-radius: 0.375rem;
        padding: 0.25rem;
    }

    .tab-trigger {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem 1rem;
        border-radius: 0.25rem;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        background-color: transparent;
        color: var(--muted-foreground);
        border: none;
        flex: 1;
    }

    .tab-trigger.active {
        background-color: white;
        color: var(--primary);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    /* Dropdown styles */
    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-content {
        position: absolute;
        top: 100%;
        right: 0;
        z-index: 50;
        background-color: white;
        border: 1px solid var(--border);
        border-radius: 0.5rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        padding: 0.5rem 0;
        min-width: 12rem;
        margin-top: 0.25rem;
        display: none;
    }

    .dropdown-content.show {
        display: block;
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .dropdown-item:hover {
        background-color: var(--muted);
    }

    .dropdown-label {
        padding: 0.5rem 0.75rem;
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--muted-foreground);
        border-bottom: 1px solid var(--border);
        margin-bottom: 0.25rem;
    }

    /* Table styles */
    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th,
    .table td {
        padding: 0.75rem 1rem;
        text-align: left;
        border-bottom: 1px solid var(--border);
        vertical-align: top;
    }

    .table th {
        font-weight: 500;
        color: var(--muted-foreground);
        font-size: 0.875rem;
        background-color: #f9fafb;
        height: 3rem;
    }

    .table tbody tr:hover {
        background-color: var(--muted);
    }

    /* Scroll area styles */
    .scroll-area {
        overflow-y: auto;
        padding-right: 1rem;
    }

    .scroll-area::-webkit-scrollbar {
        width: 6px;
    }

    .scroll-area::-webkit-scrollbar-track {
        background: var(--muted);
        border-radius: 3px;
    }

    .scroll-area::-webkit-scrollbar-thumb {
        background: var(--muted-foreground);
        border-radius: 3px;
    }

    .scroll-area::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Chart container styles */
    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
    }

    /* Utility classes */
    .hidden { display: none !important; }
    .text-center { text-align: center; }
    .text-right { text-align: right; }
    .text-left { text-align: left; }
    .font-medium { font-weight: 500; }
    .font-semibold { font-weight: 600; }
    .font-bold { font-weight: 700; }
    .text-sm { font-size: 0.875rem; }
    .text-xs { font-size: 0.75rem; }
    .text-lg { font-size: 1.125rem; }
    .text-xl { font-size: 1.25rem; }
    .text-2xl { font-size: 1.5rem; }
    .text-3xl { font-size: 1.875rem; }
    .mb-1 { margin-bottom: 0.25rem; }
    .mb-2 { margin-bottom: 0.5rem; }
    .mb-4 { margin-bottom: 1rem; }
    .mb-6 { margin-bottom: 1.5rem; }
    .mt-1 { margin-top: 0.25rem; }
    .mt-2 { margin-top: 0.5rem; }
    .mt-4 { margin-top: 1rem; }
    .mt-6 { margin-top: 1.5rem; }
    .mr-1 { margin-right: 0.25rem; }
    .mr-2 { margin-right: 0.5rem; }
    .ml-1 { margin-left: 0.25rem; }
    .ml-2 { margin-left: 0.5rem; }
    .p-1 { padding: 0.25rem; }
    .p-2 { padding: 0.5rem; }
    .p-3 { padding: 0.75rem; }
    .p-4 { padding: 1rem; }
    .p-6 { padding: 1.5rem; }
    .px-2 { padding-left: 0.5rem; padding-right: 0.5rem; }
    .px-4 { padding-left: 1rem; padding-right: 1rem; }
    .py-1 { padding-top: 0.25rem; padding-bottom: 0.25rem; }
    .py-2 { padding-top: 0.5rem; padding-bottom: 0.5rem; }
    .py-4 { padding-top: 1rem; padding-bottom: 1rem; }
    .pb-2 { padding-bottom: 0.5rem; }
    .pt-0 { padding-top: 0; }
    .pl-2 { padding-left: 0.5rem; }
    .pl-8 { padding-left: 2rem; }
    .pr-4 { padding-right: 1rem; }
    .gap-1 { gap: 0.25rem; }
    .gap-2 { gap: 0.5rem; }
    .gap-4 { gap: 1rem; }
    .gap-6 { gap: 1.5rem; }
    .flex { display: flex; }
    .flex-col { flex-direction: column; }
    .flex-1 { flex: 1 1 0%; }
    .flex-wrap { flex-wrap: wrap; }
    .items-center { align-items: center; }
    .items-start { align-items: flex-start; }
    .justify-center { justify-content: center; }
    .justify-between { justify-content: space-between; }
    .justify-end { justify-content: flex-end; }
    .space-y-1 > * + * { margin-top: 0.25rem; }
    .space-y-2 > * + * { margin-top: 0.5rem; }
    .space-y-4 > * + * { margin-top: 1rem; }
    .space-y-6 > * + * { margin-top: 1.5rem; }
    .grid { display: grid; }
    .grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
    .grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    .grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
    .grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
    .col-span-2 { grid-column: span 2 / span 2; }
    .w-full { width: 100%; }
    .w-4 { width: 1rem; }
    .w-3 { width: 0.75rem; }
    .w-10 { width: 2.5rem; }
    .w-16 { width: 4rem; }
    .w-24 { width: 6rem; }
    .w-64 { width: 16rem; }
    .h-2 { height: 0.5rem; }
    .h-3 { height: 0.75rem; }
    .h-4 { width: 1rem; height: 1rem; }
    .h-5 { width: 1.25rem; height: 1.25rem; }
    .h-10 { width: 2.5rem; height: 2.5rem; }
    .h-12 { width: 3rem; height: 3rem; }
    .h-120 { height: 120px; }
    .h-180 { height: 180px; }
    .h-200 { height: 200px; }
    .h-250 { height: 250px; }
    .h-300 { height: 300px; }
    .h-400 { height: 400px; }
    .max-w-full { max-width: 100%; }
    .min-h-screen { min-height: 100vh; }
    .overflow-auto { overflow: auto; }
    .overflow-hidden { overflow: hidden; }
    .relative { position: relative; }
    .absolute { position: absolute; }
    .left-2 { left: 0.5rem; }
    .top-2 { top: 0.5rem; }
    .border { border-width: 1px; }
    .border-b { border-bottom-width: 1px; }
    .border-t { border-top-width: 1px; }
    .rounded { border-radius: 0.25rem; }
    .rounded-md { border-radius: 0.375rem; }
    .rounded-lg { border-radius: 0.5rem; }
    .rounded-full { border-radius: 9999px; }
    .bg-white { background-color: white; }
    .bg-gray-50 { background-color: #f9fafb; }
    .bg-background { background-color: white; }
    .bg-muted { background-color: var(--muted); }
    .bg-blue-500 { background-color: #3b82f6; }
    .bg-green-500 { background-color: #22c55e; }
    .bg-yellow-500 { background-color: #eab308; }
    .bg-purple-500 { background-color: #a855f7; }
    .text-primary { color: var(--primary); }
    .text-success { color: var(--success); }
    .text-warning { color: var(--warning); }
    .text-pending { color: var(--pending); }
    .text-destructive { color: var(--destructive); }
    .text-info { color: var(--info); }
    .text-muted-foreground { color: var(--muted-foreground); }
    .text-emerald-500 { color: #10b981; }
    .text-red-500 { color: #ef4444; }
    .cursor-pointer { cursor: pointer; }
    .transition-colors { transition: color 0.2s, background-color 0.2s; }

    /* Responsive design */
    @media (min-width: 768px) {
        .md\\:flex-row { flex-direction: row; }
        .md\\:items-center { align-items: center; }
        .md\\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .md\\:grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .md\\:col-span-2 { grid-column: span 2 / span 2; }
    }

    @media (min-width: 1024px) {
        .lg\\:grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .lg\\:grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
        .lg\\:grid-cols-7 { grid-template-columns: repeat(7, minmax(0, 1fr)); }
        .lg\\:col-span-2 { grid-column: span 2 / span 2; }
        .lg\\:col-span-3 { grid-column: span 3 / span 3; }
        .lg\\:col-span-4 { grid-column: span 4 / span 4; }
    }
</style>
 
 
<div class="flex flex-col min-h-screen">
    <!-- Page Header -->
    <div class="border-b bg-white">
        <div class="flex items-center justify-between p-6">
            <div>
                <h1 class="text-2xl font-bold">SLTR/FIRST REGISTRATION Overview</h1>
                <p class="text-muted-foreground">Systematic Land Titling and Registration in Kano State</p>
            </div>
            <div class="flex items-center gap-2">
                <div class="relative w-64">
                    <i data-lucide="search" class="absolute left-2 top-2 h-4 w-4 text-muted-foreground"></i>
                    <input type="search" placeholder="Search SLTR records..." class="input w-full pl-8">
                </div>
                <button class="btn btn-primary">
                    <i data-lucide="plus" class="h-4 w-4 mr-2"></i>
                    New Application
                </button>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 space-y-6 p-6 animate-fade-in">
        <!-- Statistics Cards -->
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
            <div class="card gradient-card hover-scale" style="--gradient-start: hsl(221.2, 83.2%, 53.3%); --gradient-end: hsl(262, 83.3%, 57.8%);">
                <div class="flex flex-row items-center justify-between space-y-0 pb-2 p-6">
                    <h3 class="text-sm font-medium">Total Applications</h3>
                    <i data-lucide="file-text" class="h-4 w-4 text-primary"></i>
                </div>
                <div class="p-6 pt-0">
                    <div class="text-2xl font-bold">3,842</div>
                    <p class="text-xs text-muted-foreground flex items-center mt-1">
                        <span class="text-emerald-500 flex items-center mr-1">
                            <i data-lucide="arrow-up-right" class="h-3 w-3 mr-1"></i>
                            15%
                        </span>
                        from last month
                    </p>
                </div>
            </div>

            <div class="card gradient-card hover-scale" style="--gradient-start: hsl(142.1, 76.2%, 36.3%); --gradient-end: hsl(198, 93%, 60%);">
                <div class="flex flex-row items-center justify-between space-y-0 pb-2 p-6">
                    <h3 class="text-sm font-medium">Registered Properties</h3>
                    <i data-lucide="building-2" class="h-4 w-4 text-success"></i>
                </div>
                <div class="p-6 pt-0">
                    <div class="text-2xl font-bold">2,156</div>
                    <p class="text-xs text-muted-foreground flex items-center mt-1">
                        <span class="text-emerald-500 flex items-center mr-1">
                            <i data-lucide="arrow-up-right" class="h-3 w-3 mr-1"></i>
                            8%
                        </span>
                        from last month
                    </p>
                </div>
            </div>

            <div class="card gradient-card hover-scale" style="--gradient-start: hsl(262, 83.3%, 57.8%); --gradient-end: hsl(339.6, 82.2%, 51.6%);">
                <div class="flex flex-row items-center justify-between space-y-0 pb-2 p-6">
                    <h3 class="text-sm font-medium">Registered Claimants</h3>
                    <i data-lucide="users" class="h-4 w-4 text-pending"></i>
                </div>
                <div class="p-6 pt-0">
                    <div class="text-2xl font-bold">4,289</div>
                    <p class="text-xs text-muted-foreground flex items-center mt-1">
                        <span class="text-emerald-500 flex items-center mr-1">
                            <i data-lucide="arrow-up-right" class="h-3 w-3 mr-1"></i>
                            12%
                        </span>
                        from last month
                    </p>
                </div>
            </div>

            <div class="card gradient-card hover-scale" style="--gradient-start: hsl(38, 92%, 50%); --gradient-end: hsl(262, 83.3%, 57.8%);">
                <div class="flex flex-row items-center justify-between space-y-0 pb-2 p-6">
                    <h3 class="text-sm font-medium">Pending Approvals</h3>
                    <i data-lucide="clock" class="h-4 w-4 text-warning"></i>
                </div>
                <div class="p-6 pt-0">
                    <div class="text-2xl font-bold">187</div>
                    <p class="text-xs text-muted-foreground flex items-center mt-1">
                        <span class="text-red-500 flex items-center mr-1">
                            <i data-lucide="arrow-down-right" class="h-3 w-3 mr-1"></i>
                            5%
                        </span>
                        from last month
                    </p>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="space-y-6">
            <div class="tabs-list">
                <button class="tab-trigger active" data-tab="summary">Summary</button>
                <button class="tab-trigger" data-tab="performance">Performance</button>
                <button class="tab-trigger" data-tab="geographic">Geographic Distribution</button>
                <button class="tab-trigger" data-tab="reports">Reports</button>
            </div>

            <!-- Summary Tab -->
            <div id="summary-tab" class="tab-content active space-y-6">
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-7">
                    <!-- Registration Trends Chart -->
                    <div class="card lg:col-span-4">
                        <div class="flex flex-row items-center justify-between pb-2 p-6">
                            <div>
                                <h3 class="text-lg font-semibold">Registration Trends</h3>
                                <p class="text-sm text-muted-foreground">Monthly registration activity over the past 12 months</p>
                            </div>
                            <div class="dropdown">
                                <button id="filter-dropdown-btn" class="btn btn-outline btn-sm">
                                    <i data-lucide="filter" class="h-3 w-3 mr-2"></i>
                                    Filter
                                </button>
                                <div id="filter-dropdown" class="dropdown-content">
                                    <div class="dropdown-label">Filter by</div>
                                    <div class="dropdown-item">
                                        <i data-lucide="check-circle-2" class="mr-2 h-4 w-4 text-success"></i>
                                        <span>Completed</span>
                                    </div>
                                    <div class="dropdown-item">
                                        <i data-lucide="clock" class="mr-2 h-4 w-4 text-warning"></i>
                                        <span>In Progress</span>
                                    </div>
                                    <div class="dropdown-item">
                                        <i data-lucide="x-circle" class="mr-2 h-4 w-4 text-destructive"></i>
                                        <span>Rejected</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 pt-0 pl-2">
                            <div class="h-300 w-full">
                                <canvas id="registration-trends-chart"></canvas>
                            </div>
                        </div>
                        <div class="flex justify-between p-6 pt-0">
                            <button class="btn btn-outline btn-sm">
                                <i data-lucide="download" class="h-3 w-3 mr-2"></i>
                                Download Report
                            </button>
                            <button class="btn btn-ghost btn-sm">
                                <i data-lucide="refresh-cw" class="h-3 w-3 mr-2"></i>
                                Refresh Data
                            </button>
                        </div>
                    </div>

                    <!-- Recent Applications -->
                    <div class="card lg:col-span-3">
                        <div class="p-6 border-b">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-semibold">Recent Applications</h3>
                                <button class="btn btn-ghost btn-sm">View All</button>
                            </div>
                            <p class="text-sm text-muted-foreground">Latest SLTR applications submitted</p>
                        </div>
                        <div class="p-6">
                            <div class="scroll-area h-300 pr-4">
                                <div id="recent-applications" class="space-y-4">
                                    <!-- Applications will be populated by JavaScript -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Process Status and Quick Stats -->
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                    <!-- Registration Process Status -->
                    <div class="card col-span-2">
                        <div class="p-6 border-b">
                            <h3 class="text-lg font-semibold">Registration Process Status</h3>
                            <p class="text-sm text-muted-foreground">Current status of SLTR processes</p>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="file-text" class="h-4 w-4 text-primary"></i>
                                        <span class="text-sm">Applications</span>
                                    </div>
                                    <span class="text-sm font-medium">3,842 total</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="progress flex-1">
                                        <div class="progress-indicator" style="width: 75%"></div>
                                    </div>
                                    <span class="text-xs text-muted-foreground">75%</span>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="clipboard-list" class="h-4 w-4 text-success"></i>
                                        <span class="text-sm">Field Data Collection</span>
                                    </div>
                                    <span class="text-sm font-medium">2,895 completed</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="progress flex-1">
                                        <div class="progress-indicator" style="width: 68%"></div>
                                    </div>
                                    <span class="text-xs text-muted-foreground">68%</span>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="landmark" class="h-4 w-4 text-warning"></i>
                                        <span class="text-sm">Approvals</span>
                                    </div>
                                    <span class="text-sm font-medium">2,156 approved</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="progress flex-1">
                                        <div class="progress-indicator" style="width: 56%"></div>
                                    </div>
                                    <span class="text-xs text-muted-foreground">56%</span>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="file-check" class="h-4 w-4 text-pending"></i>
                                        <span class="text-sm">Certificates Issued</span>
                                    </div>
                                    <span class="text-sm font-medium">1,924 issued</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="progress flex-1">
                                        <div class="progress-indicator" style="width: 50%"></div>
                                    </div>
                                    <span class="text-xs text-muted-foreground">50%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Property Types -->
                    <div class="card">
                        <div class="p-6 border-b">
                            <h3 class="text-lg font-semibold">Property Types</h3>
                            <p class="text-sm text-muted-foreground">Distribution by property type</p>
                        </div>
                        <div class="p-6 flex flex-col items-center justify-center">
                            <div class="h-180 w-180 relative mb-4">
                                <canvas id="property-types-chart"></canvas>
                            </div>
                            <div class="grid grid-cols-2 gap-2 w-full text-xs">
                                <div class="flex items-center">
                                    <div class="h-3 w-3 rounded-full bg-blue-500 mr-1"></div>
                                    <span>Residential (65%)</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="h-3 w-3 rounded-full bg-green-500 mr-1"></div>
                                    <span>Commercial (15%)</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="h-3 w-3 rounded-full bg-yellow-500 mr-1"></div>
                                    <span>Agricultural (12%)</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="h-3 w-3 rounded-full bg-purple-500 mr-1"></div>
                                    <span>Industrial (8%)</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="card">
                        <div class="p-6 border-b">
                            <h3 class="text-lg font-semibold">Quick Stats</h3>
                            <p class="text-sm text-muted-foreground">SLTR performance metrics</p>
                        </div>
                        <div class="p-6 space-y-4" id="quick-stats">
                            <!-- Stats will be populated by JavaScript -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Performance Tab -->
            <div id="performance-tab" class="tab-content space-y-6">
                <div class="card">
                    <div class="p-6 border-b">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold">Performance Metrics</h3>
                                <p class="text-sm text-muted-foreground">SLTR performance over time</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <select class="select" style="width: 180px;">
                                    <option value="month">This Month</option>
                                    <option value="quarter">This Quarter</option>
                                    <option value="year" selected>This Year</option>
                                    <option value="all">All Time</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                            <!-- Performance cards will be populated by JavaScript -->
                            <div id="performance-cards" class="contents">
                                <!-- Cards will be inserted here -->
                            </div>
                        </div>

                        <div class="mt-6">
                            <div class="card">
                                <div class="p-6 border-b">
                                    <h4 class="text-lg font-semibold">Department Performance</h4>
                                    <p class="text-sm text-muted-foreground">Processing efficiency by department</p>
                                </div>
                                <div class="p-6">
                                    <div class="rounded-md border">
                                        <div class="relative w-full overflow-auto">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Department</th>
                                                        <th>Applications</th>
                                                        <th>Avg. Processing Time</th>
                                                        <th>Approval Rate</th>
                                                        <th>Efficiency</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="department-performance-table">
                                                    <!-- Table rows will be populated by JavaScript -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Geographic Tab -->
            <div id="geographic-tab" class="tab-content space-y-6">
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                    <!-- Geographic Distribution Map -->
                    <div class="card lg:col-span-2">
                        <div class="p-6 border-b">
                            <h3 class="text-lg font-semibold">Geographic Distribution</h3>
                            <p class="text-sm text-muted-foreground">SLTR applications across Kano State</p>
                        </div>
                        <div class="p-6">
                            <div class="h-400 w-full">
                                <canvas id="geographic-map-chart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- LGA Distribution -->
                    <div class="card">
                        <div class="p-6 border-b">
                            <h3 class="text-lg font-semibold">LGA Distribution</h3>
                            <p class="text-sm text-muted-foreground">Applications by Local Government Area</p>
                        </div>
                        <div class="p-6">
                            <div class="h-200 mb-4">
                                <canvas id="lga-distribution-chart"></canvas>
                            </div>
                            <div class="scroll-area h-180">
                                <div id="lga-list" class="space-y-2">
                                    <!-- LGA list will be populated by JavaScript -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Geographic Views -->
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                    <div class="card">
                        <div class="p-6 border-b">
                            <h3 class="text-lg font-semibold">Registration Density</h3>
                            <p class="text-sm text-muted-foreground">Heat map of registration activity</p>
                        </div>
                        <div class="p-6">
                            <div class="h-250 w-full">
                                <canvas id="density-heatmap-chart"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="p-6 border-b">
                            <h3 class="text-lg font-semibold">Property Disputes</h3>
                            <p class="text-sm text-muted-foreground">Areas with property disputes</p>
                        </div>
                        <div class="p-6">
                            <div class="h-250 w-full">
                                <canvas id="disputes-map-chart"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="p-6 border-b">
                            <h3 class="text-lg font-semibold">Satellite View</h3>
                            <p class="text-sm text-muted-foreground">Satellite imagery with parcel boundaries</p>
                        </div>
                        <div class="p-6">
                            <div class="h-250 w-full">
                                <canvas id="satellite-view-chart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reports Tab -->
            <div id="reports-tab" class="tab-content space-y-6">
                <div class="card">
                    <div class="p-6 border-b">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold">SLTR Reports</h3>
                                <p class="text-sm text-muted-foreground">Generate and download reports</p>
                            </div>
                            <button class="btn btn-primary">
                                <i data-lucide="download" class="h-4 w-4 mr-2"></i>
                                Export All
                            </button>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3" id="reports-grid">
                            <!-- Report cards will be populated by JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Initialize Lucide icons
    lucide.createIcons();

    // Sample data
    const sampleApplications = [
        {
            id: "SLTR-2023-0042",
            applicant: "John Adamu",
            location: "Kano Municipal",
            date: "2023-06-15",
            status: "In Progress"
        },
        {
            id: "SLTR-2023-0041",
            applicant: "Sarah Ibrahim",
            location: "Nassarawa",
            date: "2023-06-12",
            status: "Approved"
        },
        {
            id: "SLTR-2023-0040",
            applicant: "Michael Okonkwo",
            location: "Fagge",
            date: "2023-06-10",
            status: "Pending"
        },
        {
            id: "SLTR-2023-0039",
            applicant: "Amina Yusuf",
            location: "Dala",
            date: "2023-06-05",
            status: "Approved"
        },
        {
            id: "SLTR-2023-0038",
            applicant: "Robert Eze",
            location: "Gwale",
            date: "2023-06-01",
            status: "Rejected"
        },
        {
            id: "SLTR-2023-0037",
            applicant: "Fatima Mohammed",
            location: "Tarauni",
            date: "2023-05-28",
            status: "Approved"
        },
        {
            id: "SLTR-2023-0036",
            applicant: "David Okafor",
            location: "Kumbotso",
            date: "2023-05-25",
            status: "In Progress"
        }
    ];

    const quickStats = [
        {
            label: "Avg. Processing Time",
            value: "14.2 days",
            change: "-2.5 days",
            icon: "clock",
            color: "text-success"
        },
        {
            label: "Approval Rate",
            value: "87%",
            change: "+3%",
            icon: "check-circle-2",
            color: "text-success"
        },
        {
            label: "Rejection Rate",
            value: "8%",
            change: "-2%",
            icon: "x-circle",
            color: "text-destructive"
        },
        {
            label: "Pending Rate",
            value: "5%",
            change: "-1%",
            icon: "alert-circle",
            color: "text-warning"
        },
        {
            label: "Revenue Generated",
            value: "₦42.5M",
            change: "+₦3.2M",
            icon: "trending-up",
            color: "text-success"
        }
    ];

    const departmentData = [
        {
            department: "Customer Care",
            applications: 3842,
            processingTime: "2.1 days",
            approvalRate: "98%",
            efficiency: 95
        },
        {
            department: "Field Data Collection",
            applications: 3512,
            processingTime: "5.3 days",
            approvalRate: "92%",
            efficiency: 88
        },
        {
            department: "Planning",
            applications: 3245,
            processingTime: "3.8 days",
            approvalRate: "89%",
            efficiency: 85
        },
        {
            department: "Survey",
            applications: 2987,
            processingTime: "4.2 days",
            approvalRate: "91%",
            efficiency: 87
        },
        {
            department: "Director's Office",
            applications: 2756,
            processingTime: "2.5 days",
            approvalRate: "95%",
            efficiency: 92
        },
        {
            department: "Certificate Issuance",
            applications: 2156,
            processingTime: "1.8 days",
            approvalRate: "99%",
            efficiency: 97
        }
    ];

    const lgaData = [
        { name: "Kano Municipal", count: 842, percent: 21.9 },
        { name: "Nassarawa", count: 623, percent: 16.2 },
        { name: "Fagge", count: 512, percent: 13.3 },
        { name: "Dala", count: 487, percent: 12.7 },
        { name: "Gwale", count: 356, percent: 9.3 },
        { name: "Tarauni", count: 298, percent: 7.8 },
        { name: "Kumbotso", count: 245, percent: 6.4 },
        { name: "Ungogo", count: 187, percent: 4.9 },
        { name: "Dawakin Tofa", count: 156, percent: 4.1 },
        { name: "Wudil", count: 136, percent: 3.5 }
    ];

    const reports = [
        {
            title: "Monthly Registration Summary",
            description: "Summary of all registrations by month",
            icon: "bar-chart-3",
            color: "text-primary"
        },
        {
            title: "LGA Performance Report",
            description: "Registration metrics by Local Government Area",
            icon: "map",
            color: "text-success"
        },
        {
            title: "Certificate Issuance Report",
            description: "Details of all certificates issued",
            icon: "file-check",
            color: "text-warning"
        },
        {
            title: "Revenue Collection Report",
            description: "Financial summary of all SLTR transactions",
            icon: "trending-up",
            color: "text-pending"
        },
        {
            title: "Field Data Collection Report",
            description: "Summary of field data collection activities",
            icon: "clipboard-list",
            color: "text-destructive"
        },
        {
            title: "Approval Process Report",
            description: "Analysis of the approval workflow",
            icon: "briefcase",
            color: "text-info"
        }
    ];

    // State management
    let currentTab = 'summary';
    let charts = {};

    // DOM elements
    const elements = {
        tabTriggers: document.querySelectorAll('.tab-trigger'),
        tabContents: document.querySelectorAll('.tab-content'),
        filterDropdownBtn: document.getElementById('filter-dropdown-btn'),
        filterDropdown: document.getElementById('filter-dropdown'),
        recentApplications: document.getElementById('recent-applications'),
        quickStats: document.getElementById('quick-stats'),
        performanceCards: document.getElementById('performance-cards'),
        departmentTable: document.getElementById('department-performance-table'),
        lgaList: document.getElementById('lga-list'),
        reportsGrid: document.getElementById('reports-grid')
    };

    // Helper functions
    function getBadgeClass(status) {
        switch (status) {
            case 'Approved': return 'badge-success';
            case 'Pending': return 'badge-secondary';
            case 'In Progress': return 'badge-default';
            case 'Rejected': return 'badge-destructive';
            default: return 'badge-secondary';
        }
    }

    function renderRecentApplications() {
        elements.recentApplications.innerHTML = '';
        
        sampleApplications.forEach(application => {
            const applicationDiv = document.createElement('div');
            applicationDiv.className = 'flex items-start gap-4 rounded-lg border p-3 hover:bg-muted transition-colors cursor-pointer';
            applicationDiv.innerHTML = `
                <div class="flex h-10 w-10 items-center justify-center rounded-full border bg-background">
                    <i data-lucide="file-text" class="h-5 w-5 text-primary"></i>
                </div>
                <div class="flex-1 space-y-1">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium">${application.id}</p>
                        <span class="badge ${getBadgeClass(application.status)}">${application.status}</span>
                    </div>
                    <div class="flex items-center text-xs text-muted-foreground">
                        <i data-lucide="users" class="mr-1 h-3 w-3"></i>
                        ${application.applicant}
                    </div>
                    <div class="flex items-center text-xs text-muted-foreground">
                        <i data-lucide="map-pin" class="mr-1 h-3 w-3"></i>
                        ${application.location}
                    </div>
                </div>
            `;
            elements.recentApplications.appendChild(applicationDiv);
        });
        
        lucide.createIcons();
    }

    function renderQuickStats() {
        elements.quickStats.innerHTML = '';
        
        quickStats.forEach(stat => {
            const statDiv = document.createElement('div');
            statDiv.className = 'flex items-center justify-between';
            statDiv.innerHTML = `
                <div class="flex items-center gap-2">
                    <i data-lucide="${stat.icon}" class="h-4 w-4 ${stat.color}"></i>
                    <span class="text-sm">${stat.label}</span>
                </div>
                <div class="text-right">
                    <div class="text-sm font-medium">${stat.value}</div>
                    <div class="text-xs text-success">${stat.change}</div>
                </div>
            `;
            elements.quickStats.appendChild(statDiv);
        });
        
        lucide.createIcons();
    }

    function renderPerformanceCards() {
        const performanceMetrics = [
            {
                title: "Processing Efficiency",
                value: "14.2 days",
                description: "Average time from application to certificate"
            },
            {
                title: "Revenue Generation",
                value: "₦42.5M",
                description: "Total revenue from SLTR processes"
            },
            {
                title: "Approval Rates",
                value: "87%",
                description: "Applications approved after review"
            }
        ];

        elements.performanceCards.innerHTML = '';
        
        performanceMetrics.forEach(metric => {
            const cardDiv = document.createElement('div');
            cardDiv.className = 'card';
            cardDiv.innerHTML = `
                <div class="p-6 pb-2">
                    <h4 class="text-base font-semibold">${metric.title}</h4>
                </div>
                <div class="p-6">
                    <div class="text-2xl font-bold">${metric.value}</div>
                    <p class="text-xs text-muted-foreground">${metric.description}</p>
                    <div class="mt-4 h-120">
                        <div class="flex items-center justify-center h-full">
                            <div class="text-center">
                                <i data-lucide="bar-chart-3" class="h-12 w-12 text-muted-foreground mx-auto mb-2" style="opacity: 0.5;"></i>
                                <p class="text-xs text-muted-foreground">Chart placeholder</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            elements.performanceCards.appendChild(cardDiv);
        });
        
        lucide.createIcons();
    }

    function renderDepartmentTable() {
        elements.departmentTable.innerHTML = '';
        
        departmentData.forEach(dept => {
            const row = document.createElement('tr');
            row.className = 'border-b transition-colors hover:bg-muted cursor-pointer';
            row.innerHTML = `
                <td class="p-4 align-middle font-medium">${dept.department}</td>
                <td class="p-4 align-middle">${dept.applications.toLocaleString()}</td>
                <td class="p-4 align-middle">${dept.processingTime}</td>
                <td class="p-4 align-middle">${dept.approvalRate}</td>
                <td class="p-4 align-middle">
                    <div class="flex items-center gap-2">
                        <div class="progress w-24">
                            <div class="progress-indicator" style="width: ${dept.efficiency}%"></div>
                        </div>
                        <span class="text-xs">${dept.efficiency}%</span>
                    </div>
                </td>
            `;
            elements.departmentTable.appendChild(row);
        });
    }

    function renderLGAList() {
        elements.lgaList.innerHTML = '';
        
        lgaData.forEach(lga => {
            const lgaDiv = document.createElement('div');
            lgaDiv.className = 'flex items-center justify-between';
            lgaDiv.innerHTML = `
                <span class="text-sm">${lga.name}</span>
                <div class="flex items-center gap-2">
                    <span class="text-xs text-muted-foreground">${lga.count}</span>
                    <div class="progress w-16">
                        <div class="progress-indicator" style="width: ${lga.percent}%"></div>
                    </div>
                    <span class="text-xs font-medium">${lga.percent}%</span>
                </div>
            `;
            elements.lgaList.appendChild(lgaDiv);
        });
    }

    function renderReports() {
        elements.reportsGrid.innerHTML = '';
        
        reports.forEach(report => {
            const reportDiv = document.createElement('div');
            reportDiv.className = 'card hover-scale';
            reportDiv.innerHTML = `
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <i data-lucide="${report.icon}" class="h-10 w-10 ${report.color}" style="opacity: 0.8;"></i>
                        <button class="btn btn-ghost btn-sm">
                            <i data-lucide="download" class="h-4 w-4"></i>
                        </button>
                    </div>
                    <h3 class="font-medium">${report.title}</h3>
                    <p class="text-sm text-muted-foreground mt-1">${report.description}</p>
                </div>
                <div class="p-6 pt-0">
                    <button class="btn btn-outline w-full">
                        <i data-lucide="chevron-right" class="h-4 w-4 mr-2"></i>
                        View Report
                    </button>
                </div>
            `;
            elements.reportsGrid.appendChild(reportDiv);
        });
        
        lucide.createIcons();
    }

    function createCharts() {
        // Destroy existing charts
        Object.values(charts).forEach(chart => {
            if (chart) chart.destroy();
        });

        // Registration Trends Chart
        const trendsCtx = document.getElementById('registration-trends-chart').getContext('2d');
        charts.trendsChart = new Chart(trendsCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Applications',
                    data: [320, 285, 390, 420, 380, 450, 410, 480, 440, 520, 490, 560],
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Property Types Pie Chart
        const propertyCtx = document.getElementById('property-types-chart').getContext('2d');
        charts.propertyChart = new Chart(propertyCtx, {
            type: 'pie',
            data: {
                labels: ['Residential', 'Commercial', 'Agricultural', 'Industrial'],
                datasets: [{
                    data: [65, 15, 12, 8],
                    backgroundColor: [
                        'rgb(59, 130, 246)',
                        'rgb(34, 197, 94)',
                        'rgb(234, 179, 8)',
                        'rgb(168, 85, 247)'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // LGA Distribution Chart
        const lgaCtx = document.getElementById('lga-distribution-chart').getContext('2d');
        charts.lgaChart = new Chart(lgaCtx, {
            type: 'bar',
            data: {
                labels: lgaData.slice(0, 5).map(lga => lga.name),
                datasets: [{
                    label: 'Applications',
                    data: lgaData.slice(0, 5).map(lga => lga.count),
                    backgroundColor: 'rgba(59, 130, 246, 0.8)',
                    borderColor: 'rgb(59, 130, 246)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Geographic Map Chart (placeholder)
        const geoCtx = document.getElementById('geographic-map-chart').getContext('2d');
        charts.geoChart = new Chart(geoCtx, {
            type: 'scatter',
            data: {
                datasets: [{
                    label: 'Kano State Map',
                    data: [],
                    backgroundColor: 'rgba(59, 130, 246, 0.6)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Geographic Distribution Map (Placeholder)'
                    }
                }
            }
        });

        // Density Heatmap Chart (placeholder)
        const densityCtx = document.getElementById('density-heatmap-chart').getContext('2d');
        charts.densityChart = new Chart(densityCtx, {
            type: 'scatter',
            data: {
                datasets: [{
                    label: 'Registration Density',
                    data: [],
                    backgroundColor: 'rgba(239, 68, 68, 0.6)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Registration Density Heatmap (Placeholder)'
                    }
                }
            }
        });

        // Disputes Map Chart (placeholder)
        const disputesCtx = document.getElementById('disputes-map-chart').getContext('2d');
        charts.disputesChart = new Chart(disputesCtx, {
            type: 'scatter',
            data: {
                datasets: [{
                    label: 'Property Disputes',
                    data: [],
                    backgroundColor: 'rgba(234, 179, 8, 0.6)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Property Disputes Map (Placeholder)'
                    }
                }
            }
        });

        // Satellite View Chart (placeholder)
        const satelliteCtx = document.getElementById('satellite-view-chart').getContext('2d');
        charts.satelliteChart = new Chart(satelliteCtx, {
            type: 'scatter',
            data: {
                datasets: [{
                    label: 'Satellite View',
                    data: [],
                    backgroundColor: 'rgba(168, 85, 247, 0.6)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Satellite View with Parcels (Placeholder)'
                    }
                }
            }
        });
    }

    function switchTab(tabName) {
        // Update tab triggers
        elements.tabTriggers.forEach(trigger => {
            trigger.classList.remove('active');
            if (trigger.dataset.tab === tabName) {
                trigger.classList.add('active');
            }
        });

        // Update tab contents
        elements.tabContents.forEach(content => {
            content.classList.remove('active');
            if (content.id === `${tabName}-tab`) {
                content.classList.add('active');
            }
        });

        currentTab = tabName;

        // Create charts when needed
        if (tabName === 'summary' || tabName === 'geographic') {
            setTimeout(() => {
                createCharts();
            }, 100);
        }

        // Render performance cards when performance tab is activated
        if (tabName === 'performance') {
            renderPerformanceCards();
            renderDepartmentTable();
        }

        // Render geographic data when geographic tab is activated
        if (tabName === 'geographic') {
            renderLGAList();
        }

        // Render reports when reports tab is activated
        if (tabName === 'reports') {
            renderReports();
        }
    }

    function toggleFilterDropdown() {
        elements.filterDropdown.classList.toggle('show');
    }

    // Event listeners
    elements.filterDropdownBtn.addEventListener('click', toggleFilterDropdown);

    elements.tabTriggers.forEach(trigger => {
        trigger.addEventListener('click', () => {
            switchTab(trigger.dataset.tab);
        });
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', (e) => {
        if (!elements.filterDropdownBtn.contains(e.target) && !elements.filterDropdown.contains(e.target)) {
            elements.filterDropdown.classList.remove('show');
        }
    });

    // Initialize the page
    function init() {
        renderRecentApplications();
        renderQuickStats();
        createCharts();
        lucide.createIcons();
    }

    // Initialize when DOM is loaded
    document.addEventListener('DOMContentLoaded', init);
</script>



        </div>
        <!-- Footer -->
        @include('admin.footer')
    </div>
    
    
@endsection
