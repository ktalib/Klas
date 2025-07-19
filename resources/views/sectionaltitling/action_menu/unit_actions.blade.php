<div class="relative dropdown-container">
   <!-- Dropdown Toggle Button -->
   <button type="button" class="dropdown-toggle p-2 hover:bg-gray-100 focus:outline-none rounded-full" onclick="customToggleDropdown(this, event)">
      <i data-lucide="more-horizontal" class="w-5 h-5"></i>
   </button>
   <!-- Dropdown Menu -->
   <ul class="fixed action-menu z-50 bg-white border rounded-lg shadow-lg hidden w-56">
      <li> 
         <button type="button" class="block w-full text-left px-4 py-2 flex items-center space-x-2 cursor-not-allowed opacity-50" disabled>
         <i data-lucide="edit" class="w-4 h-4 text-gray-400"></i>
         <span class="text-gray-400">Edit Application</span>
         </button>
      </li>
      {{-- <li>
         <a href="{{ route('programmes.generate_memo', $app->id) }}"  class="w-full text-left px-4 py-2 hover:bg-gray-100 flex items-center space-x-2"
            data-id="{{ $app->id }}" onclick="generateMemo('{{ $app->id }}')">
         <i data-lucide="file-text" class="w-4 h-4 text-indigo-500"></i>
         <span>Generate ST Memo</span>
         </a>
      </li> --}}

      {{-- Divider after View/Edit Record, Bills & Payments --}}
      

      
         
       
      <li>
          <button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100 flex items-center space-x-2 cursor-not-allowed opacity-50"
            data-id="{{ $app->id }}" disabled>
          <i data-lucide="trash-2" class="w-4 h-4 text-gray-400"></i>
          <span class="text-gray-400">Delete Record</span>
          </button>
      </li>
      {{-- Divider --}}
      <hr class="my-2 border-gray-200">

      @php
         $rofoExists = DB::connection('sqlsrv')
            ->table('rofo')
            ->where('sub_application_id', $app->id)
            ->exists();
      @endphp

      @if(!$rofoExists)
         <li>
            <button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100 flex items-center space-x-2"
               onclick="window.location='{{ route('programmes.generate_rofo', $app->id) }}'">
               <i data-lucide="file-plus" class="w-4 h-4 text-purple-500"></i>
               <span>Generate RofO/Letter of Grant</span>
            </button>
         </li>
      @else
         <li>
            <button type="button" class="w-full text-left px-4 py-2 flex items-center space-x-2 cursor-not-allowed opacity-50" disabled>
               <i data-lucide="file-plus" class="w-4 h-4 text-gray-400"></i>
               <span class="text-gray-400">Generate RofO/Letter of Grant</span>
            </button>
         </li>
      @endif

      @php
         $cofoExists = DB::connection('sqlsrv')
            ->table('st_cofo')
            ->where('sub_application_id', $app->id)
            ->exists();
      @endphp

      @if(!$cofoExists)
         <li>
            <button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100 flex items-center space-x-2"
               onclick="window.location='{{ route('programmes.generate_cofo', $app->id) }}'">
               <i data-lucide="file-plus" class="w-4 h-4 text-purple-500"></i>
               <span>Generate CofO (FrontPage)</span>
            </button>
         </li>
      @else
         <li>
            <button type="button" class="w-full text-left px-4 py-2 flex items-center space-x-2 cursor-not-allowed opacity-50" disabled>
               <i data-lucide="file-plus" class="w-4 h-4 text-gray-400"></i>
               <span class="text-gray-400">Generate CofO (FrontPage)</span>
            </button>
         </li>
      @endif
               
   </ul>
 </div>
 <script>
   function customToggleDropdown(button, event) {
      event.stopPropagation();
      const dropdown = button.closest('.dropdown-container').querySelector('.action-menu');
      
      // Toggle visibility
      dropdown.classList.toggle('hidden');
      
      if (!dropdown.classList.contains('hidden')) {
         // Get button position
         const rect = button.getBoundingClientRect();
         
         // Position dropdown above the button
         dropdown.style.top = (rect.top - dropdown.offsetHeight - 5) + 'px';
         dropdown.style.left = (rect.left - dropdown.offsetWidth + rect.width) + 'px';
         
         // Check if dropdown would appear off the top of the screen
         if (rect.top - dropdown.offsetHeight < 0) {
            // If so, position it below the button instead
            dropdown.style.top = (rect.bottom + 5) + 'px';
         }
      }
   }
   
   // Close dropdown when clicking outside
   document.addEventListener('click', function (event) {
      const dropdowns = document.querySelectorAll('.action-menu');
      dropdowns.forEach(dropdown => {
         if (!dropdown.contains(event.target) && 
            !dropdown.previousElementSibling?.contains(event.target)) {
            dropdown.classList.add('hidden');
         }
      });
   });


   
   </script>


