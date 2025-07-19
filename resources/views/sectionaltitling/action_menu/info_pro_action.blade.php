@php
    $isApproved = $PrimaryApplication->application_status === 'Approved' && 
                  $PrimaryApplication->planning_recommendation_status === 'Approved';
@endphp

<div class="relative dropdown-container" 
     x-data="{ 
        open: false, 
        top: '0px', 
        left: '0px', 
        position: 'above',
        updatePosition() {
            if (!this.open) return;
            
            // Get the button position in viewport
            const toggle = this.$el.querySelector('.dropdown-toggle');
            const toggleRect = toggle.getBoundingClientRect();
            const menuHeight = this.$refs.dropdown.offsetHeight;
            const menuWidth = this.$refs.dropdown.offsetWidth;
            const viewportHeight = window.innerHeight;
            const viewportWidth = window.innerWidth;

            // Calculate space above and below
            const spaceAbove = toggleRect.top;
            const spaceBelow = viewportHeight - toggleRect.bottom;

            // Determine optimal vertical position
            let top;
            if (spaceBelow >= menuHeight || spaceBelow > spaceAbove) {
                top = toggleRect.bottom + 5;
            } else {
                top = toggleRect.top - menuHeight - 5;
            }
            // Prevent dropdown from going off the bottom/top
            if (top + menuHeight > viewportHeight) {
                top = viewportHeight - menuHeight - 10;
            }
            if (top < 0) {
                top = 10;
            }

            // Calculate horizontal position
            let left = toggleRect.left - menuWidth + toggleRect.width;
            // Prevent dropdown from going off the left/right edge
            if (left < 10) left = 10;
            if (left + menuWidth > viewportWidth) left = viewportWidth - menuWidth - 10;

            this.top = `${top}px`;
            this.left = `${left}px`;
        }
     }"
     x-init="$watch('open', value => {
        if (value) {
            $nextTick(() => updatePosition());
            window.addEventListener('scroll', updatePosition);
            window.addEventListener('resize', updatePosition);
        } else {
            window.removeEventListener('scroll', updatePosition);
            window.removeEventListener('resize', updatePosition);
        }
     })">
   <!-- Dropdown Toggle Button -->
   <button type="button" class="dropdown-toggle p-2 hover:bg-gray-100 focus:outline-none rounded-full" 
     @click.stop="
       open = !open;
       if (open) {
           $nextTick(() => updatePosition());
       }
     ">
      <i data-lucide="more-horizontal" class="w-5 h-5"></i>
   </button>
   <!-- Dropdown Menu -->
   <ul x-ref="dropdown" x-show="open" 
       @click.outside="open = false" 
       x-bind:style="`position: fixed; top: ${top}; left: ${left};`"
       class="action-menu z-50 bg-white border rounded-lg shadow-lg w-56" 
       style="display: none;">

      <li class="{{ $isApproved ? 'opacity-50 cursor-not-allowed' : '' }}">
         <a href="{{ route('sectionaltitling.viewrecorddetail')}}?id={{$PrimaryApplication->id}}" 
            class="w-full text-left px-4 py-2 hover:bg-gray-100 flex items-center space-x-2 {{ $isApproved ? 'pointer-events-none' : '' }}">
          <i data-lucide="edit" class="w-4 h-4 text-blue-600"></i>
          <span>Edit Application</span>
         </a>
      </li>

      <li class="{{ $isApproved ? 'opacity-50 cursor-not-allowed' : '' }}">
        <button type="button"
          onclick="{{ $isApproved ? 'return false;' : 'deleteApplication()' }}"
          class="w-full text-left px-4 py-2 hover:bg-gray-100 flex items-center space-x-2 {{ $isApproved ? 'bg-gray-300 text-gray-500 cursor-not-allowed' : 'text-red-600 hover:text-red-700' }}"
          {{ $isApproved ? 'aria-disabled=true tabindex=-1 disabled' : '' }}
          title="{{ $isApproved ? 'Cannot delete - Both Application Status and Planning Recommendation have been approved' : 'Delete Application' }}">
          <i data-lucide="trash-2" class="w-4 h-4"></i>
          <span>Delete Application</span>
        </button>
      </li>

      <hr class="my-2 border-gray-200">

      @if(!($PrimaryApplication->planning_recommendation_status == 'Pending' || 
        $PrimaryApplication->planning_recommendation_status == 'Declined' || 
        $PrimaryApplication->application_status == 'Pending' || 
        $PrimaryApplication->application_status == 'Declined'))
        
        @if(is_null($PrimaryApplication->final_conveyance_generated) || $PrimaryApplication->final_conveyance_generated == 0)
          <li>
            <a href="{{ route('actions.final-conveyance', ['id' => $PrimaryApplication->id]) }}" class="w-full text-left px-4 py-2 hover:bg-gray-100 flex items-center space-x-2">
            <i data-lucide="file-text" class="w-4 h-4 text-orange-500"></i>
            <span>Generate Final Conveyance</span>
            </a>
          </li>
        @else
          <li class="opacity-50 cursor-not-allowed">
            <a href="#" class="w-full text-left px-4 py-2 flex items-center space-x-2">
            <i data-lucide="file-text" class="w-4 h-4 text-gray-500"></i>
            <span>Generate Final Conveyance</span>
            </a>
          </li>
        @endif
      @else
        <li class="opacity-50 cursor-not-allowed">
          <a href="#" class="w-full text-left px-4 py-2 flex items-center space-x-2">
          <i data-lucide="file-text" class="w-4 h-4 text-gray-500"></i>
          <span>Generate Final Conveyance</span>
          </a>
        </li>
      @endif

      <hr class="my-2 border-gray-200">

     @if ($PrimaryApplication->application_status == 'Approved' && $PrimaryApplication->planning_recommendation_status == 'Approved')
       <li>
           <a href="{{ route('sectionaltitling.sub_application', [
             'application_id' => $PrimaryApplication->id,
             'land_use' => $PrimaryApplication->land_use,
             ]) }}" class="w-full text-left px-4 py-2 hover:bg-gray-100 flex items-center space-x-2">
           <i data-lucide="plus-square" class="w-4 h-4 text-green-500"></i>
           <span>Create Unit Application</span>
           </a>
       </li>
       @else
       <li class="opacity-50 cursor-not-allowed">
          <a href="#" class="w-full text-left px-4 py-2 flex items-center space-x-2">
          <i data-lucide="plus-square" class="w-4 h-4 text-gray-500"></i>
          <span>Create Unit Application</span>
          </a>
       </li>
       @endif  
   </ul>
 </div>
<script>
    // Delete Application Function
    function deleteApplication() {
        const applicationId = {{ $application->id ?? 'null' }};
        
        Swal.fire({
            title: 'Delete Application',
            text: 'Are you sure you want to delete this application? This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, Delete',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading state
                Swal.fire({
                    title: 'Deleting...',
                    html: 'Please wait while we delete the application',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Send delete request
                fetch(`{{ route('sectionaltitling.delete', '') }}/${applicationId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'Application has been deleted successfully.',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            // Redirect to applications list
                            window.location.href = '{{ route("sectionaltitling.index") }}';
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Failed to delete application'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An unexpected error occurred while deleting the application.'
                    });
                });
            }
        });
    }

</script>