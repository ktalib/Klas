<header class="bg-white border-b">
    <div class="container mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight">File Digital Archive</h1>
                <p class="text-muted-foreground">Access and manage digitally archived files</p>
            </div>
            <div class="flex gap-2">
                <button id="export-button" class="btn btn-outline gap-2">
                    <i data-lucide="download" class="h-4 w-4"></i>
                    Export
                </button>
                <button id="add-file-button" class="btn btn-primary gap-2" data-modal-target="add-file-modal">
                    <i data-lucide="plus" class="h-4 w-4"></i>
                    Add File
                </button>
            </div>
        </div>
    </div>
</header>
