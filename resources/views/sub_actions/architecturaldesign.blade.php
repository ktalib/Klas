<!-- architecturaldesign Bill Tab -->
@if (request()->query('url') !== 'phy_planning' || request()->query('url') == 'recommendation')
    <div id="detterment-tab" class="tab-content active">
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
        <div class="p-4 border-b">
            <h3 class="text-sm font-medium"> Architectural Design</h3>
            <p class="text-xs text-gray-500"> </p>
            <!-- Primary Application Reference -->
            @if(isset($application->primary_fileno))
            <p class="text-xs text-gray-500 mt-1">
                Primary Application: {{$application->primary_applicant_title ?? ''}} {{$application->primary_first_name ?? ''}} {{$application->primary_surname ?? ''}} 
                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                    <i data-lucide="link" class="w-3 h-3 mr-1"></i>File No: {{$application->primary_fileno ?? 'N/A'}}
                </span>
            </p>
            @endif
        </div>
        <input type="hidden" id="application_id" value="{{ $application->id }}">
        <input type="hidden" name="fileno" value="{{ $application->fileno ?? '' }}">
        <div class="p-4 space-y-4">

            <!-- Blade Template for displaying architecturaldesign -->
            <div class="space-y-6">
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h4 class="text-sm font-medium mb-3">Architectural Design Document</h4>

                    <div class="  gap-4" id="architectural-designs-container">
                        @php
                            // Ensure documents is decoded from JSON if needed
                            $documents = is_string($application->documents)
                                ? json_decode($application->documents, true)
                                : $application->documents;
                        @endphp

                        @if (isset($documents['architectural_design']))
                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                                <div class="h-48 bg-gray-100 relative">
                                    <img src="{{ asset('storage/app/public/' . $documents['architectural_design']['path']) }}"
                                        alt="Architectural Design" class="w-full h-full object-cover">
                                    <div class="absolute top-2 right-2">
                                        <button class="p-1 bg-white rounded-full shadow-sm hover:bg-gray-100"
                                            onclick="previewDesign('{{ asset('storage/app/public/' . $documents['architectural_design']['path']) }}')">
                                            <i data-lucide="maximize-2" class="w-4 h-4 text-gray-700"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="p-3">
                                    <h5 class="text-sm font-medium">Architectural Design</h5>
                                    <p class="text-xs text-gray-500 mt-1">Uploaded on:
                                        {{ \Carbon\Carbon::parse($documents['architectural_design']['uploaded_at'])->format('Y-m-d') }}
                                    </p>
                                    <div class="flex mt-2 gap-2">
                                        <a href="{{ asset('storage/app/public/' . $documents['architectural_design']['path']) }}"
                                            download
                                            class="text-xs px-2 py-1 bg-blue-50 text-blue-600 rounded-md flex items-center">
                                            <i data-lucide="download" class="w-3 h-3 mr-1"></i> Download
                                        </a>
                                        <button
                                            class="text-xs px-2 py-1 bg-gray-50 text-gray-600 rounded-md flex items-center"
                                            onclick="previewDesign('{{ asset('storage/app/public/' . $documents['architectural_design']['path']) }}')">
                                            <i data-lucide="eye" class="w-3 h-3 mr-1"></i> View
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div
                                class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden p-4 flex flex-col items-center justify-center">
                                <div class="text-gray-400 mb-2">
                                    <i data-lucide="file-question" class="w-10 h-10"></i>
                                </div>
                                <p class="text-sm text-gray-500">No architectural design uploaded yet</p>
                            </div>
                        @endif
                    </div>

                    <!-- Upload New Design Button -->
                      @if(request()->query('url') == 'recommendation')
                    <div class="mt-4 text-center">
                        <label for="architectural_design_upload"
                            class="inline-flex items-center px-3 py-2 text-xs bg-indigo-50 text-indigo-600 rounded-md hover:bg-indigo-100 cursor-pointer">
                            <i data-lucide="upload" class="w-3.5 h-3.5 mr-1.5"></i>
                            Upload New Design
                        </label>
                        <input type="file" id="architectural_design_upload" class="hidden" accept="image/*,.pdf">
                    </div>
                    @endif
                </div>
            </div>

            <!-- Modal for preview -->
            <div id="design-preview-modal"
                class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
                <div class="bg-white rounded-lg max-w-4xl w-full max-h-[90vh] overflow-hidden flex flex-col">
                    <div class="flex justify-between items-center p-4 border-b">
                        <h3 class="text-lg font-medium">Design Preview</h3>
                        <button onclick="closePreview()" class="p-1 hover:bg-gray-100 rounded-full">
                            <i data-lucide="x" class="w-5 h-5"></i>
                        </button>
                    </div>
                    <div class="p-4 flex-1 overflow-auto flex items-center justify-center">
                        <img id="preview-image" src="" alt="Design Preview"
                            class="max-w-full max-h-[70vh] object-contain">
                    </div>
                </div>
            </div>
             
            <hr class="my-4">
                
            <div class="flex justify-between items-center">
           
              <div class="flex gap-2">
            
             
           <button id="backButton" class="flex items-center px-3 py-1 text-xs border border-gray-300 rounded-md bg-white hover:bg-gray-50" onclick="window.history.back()">
            <i data-lucide="undo-2" class="w-3.5 h-3.5 mr-1.5"></i>
            Back
            </button>
                
                <!-- <button class="flex items-center px-3 py-1 text-xs bg-green-700 text-white rounded-md hover:bg-gray-800">
                    <i data-lucide="send-horizontal" class="w-3.5 h-3.5 mr-1.5"></i>
                     
                Submit
                </button> -->
              </div>
            </div>
          </div>
        </div>
      </div>
      @endif
            <!-- JavaScript for handling file upload and preview -->
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Initialize Lucide icons
                    if (typeof lucide !== 'undefined') {
                        lucide.createIcons();
                    }

                    // Set up the file upload event
                    const fileInput = document.getElementById('architectural_design_upload');
                    if (fileInput) {
                        fileInput.addEventListener('change', function() {
                            if (this.files && this.files[0]) {
                                // Validate file before upload
                                const file = this.files[0];
                                const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf'];
                                const maxSize = 10 * 1024 * 1024; // 10MB
                                
                                if (!allowedTypes.includes(file.type)) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Invalid File Type',
                                        text: 'Please upload an image or PDF file',
                                        confirmButtonColor: '#EF4444'
                                    });
                                    return;
                                }
                                
                                if (file.size > maxSize) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'File Too Large',
                                        text: 'File size should not exceed 10MB',
                                        confirmButtonColor: '#EF4444'
                                    });
                                    return;
                                }
                                
                                uploadArchitecturalDesign(file);
                            }
                        });
                    }
                });

                function previewDesign(url) {
                    document.getElementById('preview-image').src = url;
                    document.getElementById('design-preview-modal').classList.remove('hidden');
                }

                function closePreview() {
                    document.getElementById('design-preview-modal').classList.add('hidden');
                }

                function uploadArchitecturalDesign(file) {
                    // Create FormData
                    const formData = new FormData();
                    formData.append('architectural_design', file);
                    formData.append('_token', '{{ csrf_token() }}');

                    // Show enhanced loading indicator with more details
                    Swal.fire({
                        title: 'Uploading Design...',
                        html: `
                            <div class="mb-3">Uploading: ${file.name}</div>
                            <div class="text-sm text-gray-500">Size: ${(file.size / 1024).toFixed(2)} KB</div>
                            <div class="mt-4">Please wait while we process your file</div>
                        `,
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Send AJAX request
                    fetch('{{ route('actions.update-architectural-design', $application->id) }}', {
                            method: 'POST',
                            body: formData,
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`Server responded with ${response.status}: ${response.statusText}`);
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Upload Successful!',
                                    text: data.message || 'Your design has been uploaded successfully.',
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    // Update the UI with the new design
                                    updateDesignUI(data.design);
                                    // Reload after UI update
                                    setTimeout(() => location.reload(), 500);
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Upload Failed',
                                    text: data.message || 'There was an error uploading your design.',
                                    confirmButtonColor: '#EF4444'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Upload Failed',
                                text: 'There was an error uploading your design. Please try again.',
                                confirmButtonColor: '#EF4444',
                                footer: '<span class="text-xs text-gray-500">Error details: ' + error.message + '</span>'
                            });
                        });
                }

                function updateDesignUI(design) {
                    const container = document.getElementById('architectural-designs-container');
                    const formattedDate = new Date(design.uploaded_at).toISOString().split('T')[0];

                    const designHtml = `
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
      <div class="h-48 bg-gray-100 relative">
        <img 
          src="${design.full_path}" 
          alt="Architectural Design" 
          class="w-full h-full object-cover"
        >
        <div class="absolute top-2 right-2">
          <button class="p-1 bg-white rounded-full shadow-sm hover:bg-gray-100" onclick="previewDesign('${design.full_path}')">
            <i data-lucide="maximize-2" class="w-4 h-4 text-gray-700"></i>
          </button>
        </div>
      </div>
      <div class="p-3">
        <h5 class="text-sm font-medium">Architectural Design</h5>
        <p class="text-xs text-gray-500 mt-1">Uploaded on: ${formattedDate}</p>
        <div class="flex mt-2 gap-2">
          <a href="${design.full_path}" download class="text-xs px-2 py-1 bg-blue-50 text-blue-600 rounded-md flex items-center">
            <i data-lucide="download" class="w-3 h-3 mr-1"></i> Download
          </a>
          <button class="text-xs px-2 py-1 bg-gray-50 text-gray-600 rounded-md flex items-center" onclick="previewDesign('${design.full_path}')">
            <i data-lucide="eye" class="w-3 h-3 mr-1"></i> View
          </button>
        </div>
      </div>
    </div>
  `;

                    container.innerHTML = designHtml;

                    // Re-initialize icons
                    if (typeof lucide !== 'undefined') {
                        lucide.createIcons();
                    }
                }
            </script>
