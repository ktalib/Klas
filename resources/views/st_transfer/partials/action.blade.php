<div 
    x-ref="actionMenu"
    x-show="open" 
    x-cloak 
    @click.away="open = false"
    x-transition:enter="transition ease-out duration-100"
    x-transition:enter-start="transform opacity-0 scale-95"
    x-transition:enter-end="transform opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-75"
    x-transition:leave-start="transform opacity-100 scale-100"
    x-transition:leave-end="transform opacity-0 scale-95"
    class="action-menu">
    <a href="{{ route('st_transfer.view', $app->mother_id) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
      <i data-lucide="eye" class="inline w-4 h-4 mr-1 text-green-500"></i> View Details
    </a>
  
    @if($app->status == 'pending')
    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" @click="open = false; openSingleRegisterModalWithData({{ $app->mother_id }})">
      <i data-lucide="file-text" class="inline w-4 h-4 mr-1 text-blue-500"></i>Register Title 
    </a>
    
    <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100" @click="open = false; declineRegistration({{ $app->mother_id }})">
      <i data-lucide="x-circle" class="inline w-4 h-4 mr-1 text-red-600"></i> Decline
    </a>
    @else
    <a href="#" class="block px-4 py-2 text-sm text-gray-400 cursor-not-allowed">
      <i data-lucide="file-text" class="inline w-4 h-4 mr-1 text-gray-400"></i>Register Title 
    </a>
    
    <a href="#" class="block px-4 py-2 text-sm text-gray-400 cursor-not-allowed">
      <i data-lucide="x-circle" class="inline w-4 h-4 mr-1 text-gray-400"></i> Decline
    </a>
    @endif
</div>