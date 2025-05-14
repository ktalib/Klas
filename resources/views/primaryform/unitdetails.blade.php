<div class="form-section" id="step3">
  <div class="p-6">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-xl font-bold text-center text-gray-800">MINISTRY OF LAND AND PHYSICAL PLANNING</h2>
      <button id="closeModal3" class="text-gray-500 hover:text-gray-700">
        <i data-lucide="x" class="w-5 h-5"></i>
      </button>
    </div>
    
    <div class="mb-6">
      <div class="flex items-center mb-2">
        <i data-lucide="file-text" class="w-5 h-5 mr-2 text-green-600"></i>
        <h3 class="text-lg font-bold">Application for Sectional Titling - Main Application</h3>
        <div class="ml-auto flex items-center">
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
      <p class="text-gray-600">Complete the form below to submit a new primary application for sectional titling</p>
    </div>

    <div class="flex items-center mb-8">
      <div class="flex items-center mr-4">
        <div class="step-circle inactive">1</div>
      </div>
      <div class="flex items-center mr-4">
        <div class="step-circle inactive">2</div>
      </div>
      <div class="flex items-center mr-4">
        <div class="step-circle active">3</div>
      </div>
      <div class="flex items-center mr-4">
        <div class="step-circle inactive">4</div>
      </div>
      <div class="flex items-center mr-4">
        <div class="step-circle inactive">5</div>
      </div>
      <div class="ml-4">Step 3</div>
    </div>

    <div class="mb-6">
      <div class="flex items-start mb-4">
        <i data-lucide="layout" class="w-5 h-5 mr-2 text-green-600"></i>
        <span class="font-medium">Buyers List</span>
      </div>
      
      <!-- Unit Details Form Section -->
      <div class="bg-gray-50 p-4 rounded-md mb-6">
        <h3 class="font-medium mb-4">Add list of buyer</h3>
     


      <div class="flex justify-between mt-8">
        <button type="button" class="px-4 py-2 bg-white border border-gray-300 rounded-md" id="backStep3">Back</button>
        <div class="flex items-center">
          <span class="text-sm text-gray-500 mr-4">Step 3 of 5</span>
          <button type="button" class="px-4 py-2 bg-black text-white rounded-md" id="nextStep3">Next</button>
        </div>
      </div>
    </div>
  </div>
</div>
