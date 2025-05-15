<div class="relative inline-block text-left">
    <button class="flex items-center px-2 py-1 text-xs border border-gray-200 rounded-md bg-white hover:bg-gray-50"
        onclick="toggleDropdown(event)">
        <i data-lucide="more-horizontal" class="w-4 h-4"></i>
    </button>
    <div class="dropdown-menu hidden fixed w-48 bg-white shadow-lg rounded-md z-[9999]">
        <ul class="py-2">
            <li>
                <a href="{{ route('sectionaltitling.viewrecorddetail') }}?id={{ $PrimaryApplication->id }}"
                    class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <i data-lucide="eye" class="w-4 h-4 text-blue-500"></i>
                    View Application
                </a>
            </li>
            <!-- ST Memo -->
            <li>
                <a href="javascript:void(0)"
                    onclick="if(!{{ $stMemoGenerated ? 'true' : 'false' }}) generateSTMemo({{ $PrimaryApplication->id }})"
                    class="flex items-center gap-2 px-4 py-2 text-sm {{ $stMemoGenerated ? 'text-gray-400 cursor-not-allowed bg-gray-50' : 'text-gray-700 hover:bg-gray-100' }}"
                    @if ($stMemoGenerated) tabindex="-1" aria-disabled="true" @endif>
                    <i data-lucide="check" class="w-4 h-4 {{ $stMemoGenerated ? 'text-gray-400' : 'text-red-500' }}"></i>
                    Generate ST Memo
                </a>
            </li>
            <li>
                <a href="{{ route('stmemo.view', $PrimaryApplication->id) }}"
                    class="flex items-center gap-2 px-4 py-2 text-sm {{ $stMemoGenerated ? 'text-gray-700 hover:bg-gray-100' : 'text-gray-400 cursor-not-allowed bg-gray-50' }}"
                    @if (!$stMemoGenerated) tabindex="-1" aria-disabled="true" onclick="return false;" @endif>
                    <i data-lucide="eye" class="w-4 h-4 {{ $stMemoGenerated ? 'text-blue-500' : 'text-gray-400' }}"></i>
                    View ST Memo
                </a>
            </li>
            <!-- Site Plan -->
            <li>
                <a href="{{ route('stmemo.uploadSitePlan', $PrimaryApplication->id) }}"
                    class="flex items-center gap-2 px-4 py-2 text-sm {{ $sitePlanUploaded ? 'text-gray-400 cursor-not-allowed bg-gray-50' : 'text-gray-700 hover:bg-gray-100' }}"
                    @if ($sitePlanUploaded) tabindex="-1" aria-disabled="true" onclick="return false;" @endif>
                    <i data-lucide="upload"
                        class="w-4 h-4 {{ $sitePlanUploaded ? 'text-gray-400' : 'text-green-500' }}"></i>
                    Upload Site Plan
                </a>
            </li>
            <li>
                <a href="{{ route('stmemo.viewSitePlan', $PrimaryApplication->id) }}"
                    class="flex items-center gap-2 px-4 py-2 text-sm {{ $sitePlanUploaded ? 'text-gray-700 hover:bg-gray-100' : 'text-gray-400 cursor-not-allowed bg-gray-50' }}"
                    @if (!$sitePlanUploaded) tabindex="-1" aria-disabled="true" onclick="return false;" @endif>
                    <i data-lucide="eye" class="w-4 h-4 {{ $sitePlanUploaded ? 'text-blue-500' : 'text-gray-400' }}"></i>
                    View Site Plan
                </a>
            </li>
            <!-- Approval -->
            <li>
                <a href="{{ route('actions.recommendation', ['id' => $PrimaryApplication->id]) }}?url=phy_planning"
                    class="flex items-center gap-2 px-4 py-2 text-sm {{ $approvalStatus ? 'text-gray-400 cursor-not-allowed bg-gray-50' : 'text-gray-700 hover:bg-gray-100' }}"
                    @if ($approvalStatus) tabindex="-1" aria-disabled="true" onclick="return false;" @endif>
                    <i data-lucide="check-circle"
                        class="w-4 h-4 {{ $approvalStatus ? 'text-gray-400' : 'text-green-500' }}"></i>
                    Approval
                </a>
            </li>
            <!-- Planning Recommendation -->
            <li>
                <a href="{{ route('actions.recommendation', ['id' => $PrimaryApplication->id]) }}?url=recommendation"
                    class="flex items-center gap-2 px-4 py-2 text-">
                    <i data-lucide="file-text" class="w-4 h-4 text-yellow-500"></i>
                    Planning Recommendation
                </a>
            </li>
        </ul>
    </div>
</div>
<script>
    function toggleDropdown(event) {
        event.stopPropagation();
        const button = event.currentTarget;
        const dropdownMenu = button.nextElementSibling;

        // Hide all other dropdowns first
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            if (menu !== dropdownMenu) menu.classList.add('hidden');
        });

        // Toggle visibility of this dropdown
        const isHidden = dropdownMenu.classList.contains('hidden');
        
        if (isHidden) {
            // Show dropdown
            dropdownMenu.classList.remove('hidden');
            
            // Position dropdown relative to button
            const buttonRect = button.getBoundingClientRect();
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            const scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;
            
            // Start with positioning to the right of button
            let left = buttonRect.left;
            let top = buttonRect.bottom + scrollTop;
            
            // Get viewport and dropdown dimensions
            const viewportWidth = window.innerWidth;
            const viewportHeight = window.innerHeight;
            const dropdownWidth = dropdownMenu.offsetWidth;
            const dropdownHeight = dropdownMenu.offsetHeight;
            
            // Adjust horizontal position if dropdown would go off right edge
            if (left + dropdownWidth > viewportWidth - 10) {
                left = Math.max(10, buttonRect.right - dropdownWidth);
            }
            
            // Adjust vertical position if dropdown would go off bottom edge
            if (top + dropdownHeight > scrollTop + viewportHeight - 10) {
                top = buttonRect.top + scrollTop - dropdownHeight;
            }
            
            // Apply calculated position
            dropdownMenu.style.left = `${left}px`;
            dropdownMenu.style.top = `${top}px`;
        } else {
            // Hide dropdown
            dropdownMenu.classList.add('hidden');
        }
    }

    // Close all dropdowns when clicking outside
    document.addEventListener('click', () => {
        document.querySelectorAll('.dropdown-menu').forEach(menu => menu.classList.add('hidden'));
    });
    
    // Close dropdowns on window resize (responsive behavior)
    window.addEventListener('resize', () => {
        document.querySelectorAll('.dropdown-menu').forEach(menu => menu.classList.add('hidden'));
    });
    
    // Prevent clicks inside dropdown from closing it
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            menu.addEventListener('click', (e) => {
                if (e.target.tagName !== 'A') {
                    e.stopPropagation();
                }
            });
        });
    });
</script>
