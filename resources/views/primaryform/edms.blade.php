<!-- Step 4: EDMS -->
<div class="form-section" id="step4">
  <div class="p-6">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-xl font-bold text-gray-800">MINISTRY OF LAND AND PHYSICAL PLANNING</h2>
      <button type="button" onclick="window.history.back()" class="text-gray-500 hover:text-gray-700">
        <i data-lucide="x" class="w-5 h-5"></i>
      </button>
    </div>
    
    <div class="mb-6">
      <div class="flex items-center justify-between">
        <div class="flex items-center">
          <i data-lucide="database" class="w-5 h-5 mr-2 text-green-600"></i>
          <h3 class="text-lg font-bold">Electronic Document Management System (EDMS)</h3>
        </div>
        <div class="flex items-center">
          <span class="text-gray-600 mr-2">Land Use:</span>
          <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">
            @if (request()->query('landuse') === 'Commercial')
              Commercial
            @elseif (request()->query('landuse') === 'Residential')
                Residential
            @elseif (request()->query('landuse') === 'Industrial')
                Industrial
            @else
                Mixed Use
            @endif 
          </span>
        </div>
      </div>
      <p class="text-gray-600 mt-1"> </p>
    </div>

    <div class="flex items-center mb-6">
      <div class="flex items-center mr-4">
        <div class="step-circle inactive flex items-center justify-center">1</div>
      </div>
      <div class="flex items-center mr-4">
        <div class="step-circle inactive flex items-center justify-center">2</div>
      </div>
      <div class="flex items-center mr-4">
        <div class="step-circle inactive flex items-center justify-center">3</div>
      </div>
      <div class="flex items-center mr-4">
        <div class="step-circle active flex items-center justify-center">4</div>
      </div>
      <div class="flex items-center mr-4">
        <div class="step-circle inactive flex items-center justify-center">5</div>
      </div>
      <div class="flex items-center mr-4">
        <div class="step-circle inactive flex items-center justify-center">6</div>
      </div>
      
      <div class="ml-4">Step 4 - EDMS </div>
    </div>

    <div class="mb-6">
      <div class="text-right text-sm text-gray-500">CODE: ST FORM - 4</div>
      <hr class="my-4">
      <div class="p-6">
        <div class="mb-6">
          <ul class="flex border-b" id="edmsTabs">
            <li class="-mb-px mr-1">
              <a id="tab-indexing" class="tab-link bg-white inline-block border-l border-t border-r rounded-t py-2 px-4 text-blue-700 font-semibold" href="javascript:void(0)" onclick="showTab('indexing')">File Indexing</a>
            </li>
            <li class="mr-1">
              <a id="tab-scanning" class="tab-link bg-white inline-block py-2 px-4 text-blue-500 hover:text-blue-800 font-semibold" href="javascript:void(0)" onclick="showTab('scanning')">Scanning</a>
            </li>
            <li class="mr-1">
              <a id="tab-pagetyping" class="tab-link bg-white inline-block py-2 px-4 text-red-600 font-semibold border   rounded-t" href="javascript:void(0)" onclick="showTab('pagetyping')">
                PageTyping
               
              </a>
            </li>
          </ul>
          <div class="mt-6">
            <div id="tab-content-indexing">
              <h3 class="text-lg font-bold mb-2">File Indexing</h3>
             <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Error:</strong>
                <span class="block sm:inline">Missing component</span>
              </div>
            </div>
            <div id="tab-content-scanning" style="display:none;">
              <h3 class="text-lg font-bold mb-2">Scanning</h3>
             <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Error:</strong>
                <span class="block sm:inline">Missing component</span>
              </div>
            </div>
            <div id="tab-content-pagetyping" style="display:none;">
              <h3 class="text-lg font-bold mb-2 ">PageTyping</h3>
              <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Error:</strong>
                <span class="block sm:inline">Missing component</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    
    </div>

    <div class="flex justify-between mt-8">
      <button type="button" class="px-4 py-2 bg-white border border-gray-300 rounded-md" id="prevStep4">Previous</button>
      <div class="flex items-center">
        <span class="text-sm text-gray-500 mr-4">Step 4 of 6</span>
        <button type="button" class="px-4 py-2 bg-black text-white rounded-md" id="nextStep4">Next</button>
      </div>
    </div>
  </div>
</div>

<script>
function showTab(tab) {
  // Hide all tab contents
  document.getElementById('tab-content-indexing').style.display = 'none';
  document.getElementById('tab-content-scanning').style.display = 'none';
  document.getElementById('tab-content-pagetyping').style.display = 'none';

  // Remove active styles from all tabs
  document.getElementById('tab-indexing').classList.remove('border-l', 'border-t', 'border-r', 'text-blue-700');
  document.getElementById('tab-indexing').classList.add('text-blue-500');
  document.getElementById('tab-scanning').classList.remove('border-l', 'border-t', 'border-r', 'text-blue-700');
  document.getElementById('tab-scanning').classList.add('text-blue-500');
  document.getElementById('tab-pagetyping').classList.remove('border-l', 'border-t', 'border-r', 'text-blue-700');
  document.getElementById('tab-pagetyping').classList.add('text-red-600');

  // Show selected tab content and set active style
  if(tab === 'indexing') {
    document.getElementById('tab-content-indexing').style.display = '';
    document.getElementById('tab-indexing').classList.add('border-l', 'border-t', 'border-r', 'text-blue-700');
    document.getElementById('tab-indexing').classList.remove('text-blue-500');
  } else if(tab === 'scanning') {
    document.getElementById('tab-content-scanning').style.display = '';
    document.getElementById('tab-scanning').classList.add('border-l', 'border-t', 'border-r', 'text-blue-700');
    document.getElementById('tab-scanning').classList.remove('text-blue-500');
  } else if(tab === 'pagetyping') {
    document.getElementById('tab-content-pagetyping').style.display = '';
    document.getElementById('tab-pagetyping').classList.add('border-l', 'border-t', 'border-r', 'text-blue-700');
    document.getElementById('tab-pagetyping').classList.remove('text-red-600');
  }
}

// Optionally, set default tab on page load
document.addEventListener('DOMContentLoaded', function() {
  showTab('indexing');
});

function addAuthorizedUser() {
    const container = document.getElementById('authorizedUsersContainer');
    const newUserDiv = document.createElement('div');
    newUserDiv.className = 'grid grid-cols-3 gap-4 mb-2';
    newUserDiv.innerHTML = `
        <input type="text" name="authorized_users_name[]" placeholder="Full Name" class="w-full p-2 border border-gray-300 rounded-md">
        <input type="email" name="authorized_users_email[]" placeholder="Email Address" class="w-full p-2 border border-gray-300 rounded-md">
        <div class="flex gap-2">
            <input type="text" name="authorized_users_phone[]" placeholder="Phone Number" class="w-full p-2 border border-gray-300 rounded-md">
            <button type="button" onclick="removeAuthorizedUser(this)" class="px-2 py-1 bg-red-500 text-white text-sm rounded hover:bg-red-600">
                Remove
            </button>
        </div>
    `;
    container.appendChild(newUserDiv);
}

function removeAuthorizedUser(button) {
    button.closest('.grid').remove();
}
</script>