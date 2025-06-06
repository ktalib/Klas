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
       @if($app->status == 'registered' && $app->STM_Ref)
       <a href="{{ route('coroi.index') }}?url=registered_instruments?STM_Ref={{ $app->STM_Ref }}" 
           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
            <i class="fas fa-eye mr-2 text-blue-500"></i>
            View Confirmation of Registration (CoR)
        </a>  
        @endif
        
        @if($app->status == 'pending')
        <a href="#" 
           onclick="openSingleRegisterModalWithData('{{ $app->id }}'); return false;"
           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
            <i class="fas fa-file-signature mr-2 text-green-500"></i> Register
        </a>
        <a href="#" 
           onclick="declineRegistration('{{ $app->id }}'); return false;"
           class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
            <i class="fas fa-times mr-2"></i> Decline
        </a>
        @endif
    
</div>