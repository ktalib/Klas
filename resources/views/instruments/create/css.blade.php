   <style>
        /* Custom styles */
        :root {
            --primary: #3b82f6;
            --primary-foreground: #ffffff;
            --muted: #f3f4f6;
            --muted-foreground: #6b7280;
            --border: #e5e7eb;
            --ring: #3b82f6;
            --success: #10b981;
            --warning: #f59e0b;
            --destructive: #ef4444;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            color: #0f172a;
            background-color: #f8fafc;
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

        .input:read-only {
            background-color: var(--muted);
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

        /* Textarea styles */
        .textarea {
            display: block;
            width: 100%;
            border-radius: 0.375rem;
            border: 1px solid var(--border);
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            line-height: 1.25rem;
            background-color: white;
            min-height: 80px;
            resize: vertical;
        }

        .textarea:focus {
            outline: none;
            border-color: var(--ring);
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.3);
        }

        /* Dialog styles */
        .dialog-backdrop {
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
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 700px;
            max-height: 90vh;
            overflow-y: auto;
            margin: 1rem;
        }

        /* Checkbox styles */
        .checkbox {
            width: 1rem;
            height: 1rem;
            border: 1px solid var(--border);
            border-radius: 0.25rem;
            background-color: white;
            cursor: pointer;
        }

        .checkbox:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        /* Label styles */
        .label {
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
        }

        /* Animation classes */
        .animate-fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Utility classes */
        .hidden { display: none !important; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-medium { font-weight: 500; }
        .font-semibold { font-weight: 600; }
        .font-bold { font-weight: 700; }
        .text-sm { font-size: 0.875rem; }
        .text-xs { font-size: 0.75rem; }
        .text-lg { font-size: 1.125rem; }
        .text-xl { font-size: 1.25rem; }
        .text-2xl { font-size: 1.5rem; }
        .mb-1 { margin-bottom: 0.25rem; }
        .mb-2 { margin-bottom: 0.5rem; }
        .mb-3 { margin-bottom: 0.75rem; }
        .mb-4 { margin-bottom: 1rem; }
        .mb-6 { margin-bottom: 1.5rem; }
        .mt-1 { margin-top: 0.25rem; }
        .mt-2 { margin-top: 0.5rem; }
        .mt-4 { margin-top: 1rem; }
        .mr-2 { margin-right: 0.5rem; }
        .ml-2 { margin-left: 0.5rem; }
        .p-2 { padding: 0.5rem; }
        .p-4 { padding: 1rem; }
        .p-6 { padding: 1.5rem; }
        .px-3 { padding-left: 0.75rem; padding-right: 0.75rem; }
        .py-2 { padding-top: 0.5rem; padding-bottom: 0.5rem; }
        .py-4 { padding-top: 1rem; padding-bottom: 1rem; }
        .pb-3 { padding-bottom: 0.75rem; }
        .pt-2 { padding-top: 0.5rem; }
        .pt-4 { padding-top: 1rem; }
        .gap-2 { gap: 0.5rem; }
        .gap-3 { gap: 0.75rem; }
        .gap-4 { gap: 1rem; }
        .gap-6 { gap: 1.5rem; }
        .flex { display: flex; }
        .flex-col { flex-direction: column; }
        .items-center { align-items: center; }
        .items-start { align-items: flex-start; }
        .justify-center { justify-content: center; }
        .justify-between { justify-content: space-between; }
        .justify-end { justify-content: flex-end; }
        .space-y-2 > * + * { margin-top: 0.5rem; }
        .space-y-3 > * + * { margin-top: 0.75rem; }
        .space-y-4 > * + * { margin-top: 1rem; }
        .space-y-6 > * + * { margin-top: 1.5rem; }
        .space-x-2 > * + * { margin-left: 0.5rem; }
        .space-x-6 > * + * { margin-left: 1.5rem; }
        .grid { display: grid; }
        .grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
        .grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
        .w-full { width: 100%; }
        .h-4 { height: 1rem; }
        .h-5 { height: 1.25rem; }
        .h-8 { height: 2rem; }
        .h-10 { height: 2.5rem; }
        .h-16 { height: 4rem; }
        .h-24 { height: 6rem; }
        .w-4 { width: 1rem; }
        .w-5 { width: 1.25rem; }
        .w-8 { width: 2rem; }
        .w-10 { width: 2.5rem; }
        .w-12 { width: 3rem; }
        .w-16 { width: 4rem; }
        .min-h-screen { min-height: 100vh; }
        .max-w-xs { max-width: 20rem; }
        .max-h-48 { max-height: 12rem; }
        .overflow-y-auto { overflow-y: auto; }
        .relative { position: relative; }
        .absolute { position: absolute; }
        .top-0 { top: 0; }
        .left-0 { left: 0; }
        .right-0 { right: 0; }
        .bottom-0 { bottom: 0; }
        .border { border-width: 1px; }
        .border-b { border-bottom-width: 1px; }
        .border-t { border-top-width: 1px; }
        .border-gray-200 { border-color: #e5e7eb; }
        .border-gray-300 { border-color: #d1d5db; }
        .rounded { border-radius: 0.25rem; }
        .rounded-md { border-radius: 0.375rem; }
        .rounded-lg { border-radius: 0.5rem; }
        .bg-white { background-color: white; }
        .bg-gray-50 { background-color: #f9fafb; }
        .bg-gray-100 { background-color: #f3f4f6; }
        .bg-blue-50 { background-color: #eff6ff; }
        .bg-muted { background-color: var(--muted); }
        .text-gray-400 { color: #9ca3af; }
        .text-gray-500 { color: #6b7280; }
        .text-gray-600 { color: #4b5563; }
        .text-gray-700 { color: #374151; }
        .text-gray-900 { color: #111827; }
        .text-blue-600 { color: #2563eb; }
        .text-muted-foreground { color: var(--muted-foreground); }
        .cursor-pointer { cursor: pointer; }
        .cursor-help { cursor: help; }
        .select-none { user-select: none; }

        /* Date picker styles */
        .date-picker {
            position: relative;
        }

        .date-picker-input {
            cursor: pointer;
        }

        .date-picker-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid var(--border);
            border-radius: 0.375rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            z-index: 10;
            padding: 1rem;
            margin-top: 0.25rem;
        }

        /* Responsive design */
        @media (min-width: 768px) {
            .md\\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .md\\:grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
            .md\\:grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
        }
    </style>