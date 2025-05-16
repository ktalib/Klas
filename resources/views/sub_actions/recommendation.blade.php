@extends('layouts.app')
@section('page-title')
    {{ __('Planning Recommendation') }}
@endsection

<style>

   
    .tab-content {
      display: none;
    }
    .tab-content.active {
      display: block;
    }
    .tab-button {
      position: relative;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 0.75rem;
      padding: 0.5rem 1rem;
      border-radius: 0.25rem;
      cursor: pointer;
      transition: background-color 0.2s;
    }
    .tab-button.active {
      background-color: #f3f4f6;
      font-weight: 500;
    }
    .tab-button:hover:not(.active) {
      background-color: #f9fafb;
    }
    @media print {
        body * {
            visibility: hidden;
        }
        #final-tab, #final-tab * {
            visibility: visible;
        }
        #final-tab {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        .no-print, button, .tab-button, footer, nav {
            display: none !important;
        }
    }
  </style>
@include('sectionaltitling.partials.assets.css')
@section('content')
    <div class="flex-1 overflow-auto">
        <!-- Header -->
        @include('admin.header')
        <!-- Dashboard Content -->
        <div class="p-6">
        
            <div class="bg-white rounded-md shadow-sm border border-gray-200 p-6">
              
          @php
                     $surveyRecord = DB::connection('sqlsrv')
                        ->table('surveyCadastralRecord')
                        ->where('application_id', $application->id)
                        ->first();

                    $statusClass = match (strtolower($application->planning_recommendation_status ?? '')) {
                        'approve' => 'bg-green-100 text-green-800',
                        'approved' => 'bg-green-100 text-green-800',
                        'pending' => 'bg-yellow-100 text-yellow-800',
                        'decline' => 'bg-red-100 text-red-800',
                        'declined' => 'bg-red-100 text-red-800',
                        default => 'bg-gray-100 text-gray-800',
                    };

                    $statusIcon = match (strtolower($application->planning_recommendation_status ?? '')) {
                        'approve' => 'check-circle',
                        'approved' => 'check-circle',
                        'pending' => 'clock',
                        'decline' => 'x-circle',
                        'declined' => 'x-circle',
                        default => 'help-circle',
                    };
          @endphp
    

                <div class="modal-content8 p-6">
                    <div class="flex justify-between items-center mb-4">
                      <h2 class="text-lg font-medium">Planning Recommendation  <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $statusClass }}">
                        <i data-lucide="{{ $statusIcon }}" class="w-3 h-3 mr-1"></i>
                        {{$application->planning_recommendation_status }}
                      </span></h2>
                      <button  onclick="window.history.back()" class="text-gray-500 hover:text-gray-700">
                        <i data-lucide="x" class="w-5 h-5"></i>
                      </button>
                    </div>
                    
                    <div class="py-2">
                      <div class="flex items-center justify-between mb-4">
                        <div>
                          <h3 class="text-sm font-medium">{{$application->land_use }} Property</h3>
                          <p class="text-xs text-gray-500">
                            Application ID: {{$application->applicationID}} | File No: {{$application->fileno }}  
                          </p>
                          
                          <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $statusClass }}">
                            <i data-lucide="{{ $statusIcon }}" class="w-3 h-3 mr-1"></i>
                            {{$application->planning_recommendation_status }}
                          </span>
                        </div>
                        <div class="text-right">
                          <h3 class="text-sm font-medium">
                                          @if ($application->applicant_type == 'individual')
                          {{ $application->applicant_title }} {{ $application->first_name }}
                          {{ $application->surname }}
                        @elseif($application->applicant_type == 'corporate')
                          {{ $application->rc_number }} {{ $application->corporate_name }}
                        @elseif($application->applicant_type == 'multiple')
                          @php
                            $names = @json_decode($application->multiple_owners_names, true);
                            if (is_array($names) && count($names) > 0) {
                              echo implode(', ', $names);
                            } else {
                              echo $application->multiple_owners_names;
                            }
                          @endphp
                        @endif
    

                          </h3>
                          <p class="text-xs text-gray-500">
                          <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                            {{$application->land_use }}
                          </span>
                          </p>
                        </div>
                      </div>
                
                      <!-- Tabs Navigation -->
                      
                  

                      <div class="grid grid-cols-3 gap-2 mb-4">
                        @if(request()->query('url') !== 'phy_planning' || request()->query('url') == 'recommendation')
                          <button class="tab-button active" data-tab="detterment">
                            <i data-lucide="calculator" class="w-3.5 h-3.5 mr-1.5"></i>
                            Architectural Design
                          </button>
                        @endif
                        
                        @if(request()->query('url') == 'phy_planning')
                          <button class="tab-button" data-tab="initial">
                            <i data-lucide="banknote" class="w-3.5 h-3.5 mr-1.5"></i>
                            Planning Recommendation Approval
                          </button>
                        @endif
                        

                        @if(request()->query('url') !== 'phy_planning')
                        <button class="tab-button" data-tab="final">
                          <i data-lucide="file-check" class="w-3.5 h-3.5 mr-1.5"></i>
                          Planning Recommendation
                        </button>
                        @endif
                      </div>
 

                      @include('actions.architecturaldesign')

                      <div id="initial-tab" class="tab-content {{ request()->query('url') == 'phy_planning' ? 'active' : '' }}">
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                          <div class="p-4 border-b">
                            <h3 class="text-sm font-medium">Planning Recommendation Approval</h3>
                          </div>
                          <form id="planningRecommendationForm" method="post" action="javascript:void(0);" onsubmit="handlePlanningRecommendation(event)">
                            <!-- CSRF token for Laravel -->
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="p-4 space-y-4">
                              <input type="hidden" id="application_id" value="{{$application->id}}">
                              <input type="hidden" name="fileno" value="{{$application->fileno}}">
                              <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-2">
                                  <label class="text-xs font-medium block">
                                    Decision
                                  </label>
                                  <div class="flex items-center space-x-4">
                                    
                                    <label class="inline-flex items-center">
                                      <input type="radio" name="decision" value="Approved" class="form-radio" onchange="toggleReasonContainer(this)">
                                      <span class="ml-2 text-sm">Approve</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                      <input type="radio" name="decision" value="Declined" class="form-radio" onchange="toggleReasonContainer(this)">
                                      <span class="ml-2 text-sm">Decline</span>
                                    </label>

                  <script>
                    function toggleReasonContainer(radio) {
                    const reasonContainer = document.getElementById('reasonContainer');
                    if (radio.value === 'Declined') {
                      reasonContainer.style.display = 'block';
                    } else {
                      reasonContainer.style.display = 'none';
                    }
                    }
                  </script>
                                  </div>
                                </div>
                                <div class="space-y-2">
                                  <label for="approval-date" class="text-xs font-medium block">
                                    Approval/Decline Date
                                  </label>
                                  <input id="approval-date" type="date" class="w-full p-2 border border-gray-300 rounded-md text-sm">
                                </div>
                              </div>

                              <div class="grid grid-cols-1 gap-4">
                                <div id="reasonContainer" class="space-y-2" style="display: none;">
                                  <label for="comments" class="text-xs font-medium block">
                                    Reason <span class="text-red-500">*</span>
                                  </label>
                                  <textarea id="comments" rows="4" placeholder="Enter reason for declining" class="w-full p-2 border border-gray-300 rounded-md text-sm"></textarea>
                                  <p class="text-xs text-red-500 mt-1">Please provide a reason for declining this application</p>
                                </div>
                              </div>

                              <hr class="my-4">

                              <div class="flex justify-between items-center">
                                <div class="flex gap-2">
                                  <a href="{{route('sectionaltitling.primary')}}" class="flex items-center px-3 py-1 text-xs border border-gray-300 rounded-md bg-white hover:bg-gray-50">
                                    <i data-lucide="undo-2" class="w-3.5 h-3.5 mr-1.5"></i>
                                    Back
                                  </a>
                                  <button id="planningRecommendationSubmitBtn" type="submit" class="flex items-center px-3 py-1 text-xs bg-green-700 text-white rounded-md hover:bg-gray-800">
                                    <i data-lucide="send-horizontal" class="w-3.5 h-3.5 mr-1.5"></i>
                                    Submit
                                  </button>
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>

                        <script>
  console.log("JS loaded successfully"); // Debug log

  document.addEventListener('DOMContentLoaded', function() {
    // Tab switching functionality
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');
    tabButtons.forEach(button => {
      button.addEventListener('click', function() {
        const tabId = this.getAttribute('data-tab');
        // Deactivate all tabs
        tabButtons.forEach(btn => btn.classList.remove('active'));
        tabContents.forEach(content => content.classList.remove('active'));
        this.classList.add('active');
        document.getElementById(`${tabId}-tab`).classList.add('active');
      });
    });

    // Close modal button
    document.getElementById('closeModal').addEventListener('click', function() {
      // In a real application, this would close the modal
      alert('Modal closed');
    });

    // Print Planning Recommendation using a new window
    document.getElementById('print-planning-recommendation').addEventListener('click', function(e) {
      e.preventDefault();
      try {
        console.log('Print button clicked'); // Debug log
        
        // Create a new window with just the planning recommendation content
        const printWindow = window.open('', '_blank', 'height=800,width=800');
        
        // Get the direct URL to the planning recommendation with the print parameter
        const applicationId = document.getElementById('application_id').value;
        const printUrl = `{{ url('sub-actions/planning-recommendation/print') }}/${applicationId}?url=print`;
        
        // Navigate the new window to this URL
        printWindow.location.href = printUrl;
        
        // Set up listener for when content is loaded
        printWindow.onload = function() {
          setTimeout(function() {
            printWindow.focus();
            printWindow.print();
          }, 1000); // Short delay to ensure content is fully loaded
        };
      } catch (error) {
        console.error('Error printing:', error);
        alert('There was an error during printing. See console for details.');
      }
    });

    // Toggle reason field based on decision
    const decisionRadios = document.querySelectorAll('input[name="decision"]');
    const reasonContainer = document.getElementById('reasonContainer');
    decisionRadios.forEach(radio => {
      radio.addEventListener('change', function() {
        reasonContainer.style.display = (this.value === 'Declined') ? 'block' : 'none';
      });
    });
  });

  // Separate the form handling function
  function handlePlanningRecommendation(e) {
    e.preventDefault();
    showPreloader();
    const submitBtn = document.getElementById('planningRecommendationSubmitBtn');
    if (submitBtn) { submitBtn.disabled = true; }
    const applicationId = document.getElementById('application_id').value;
    const decision = document.querySelector('input[name="decision"]:checked').value;
    const approvalDate = document.getElementById('approval-date').value;
    const comments = document.getElementById('comments')?.value || '';
    
    fetch('{{ url("sub-actions/planning-recommendation/update") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            application_id: applicationId,
            status: decision,
            approval_date: approvalDate,
            comments: comments
        })
    })
    .then(response => response.json())
    .then(data => {
        hidePreloader();
        submitBtn.disabled = false;
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Planning recommendation updated successfully!',
                confirmButtonColor: '#10B981'
            }).then(() => { 
                // Redirect to sub-application print URL instead of primary application URL
                const applicationId = document.getElementById('application_id').value;
                const printUrl = `{{ url('sub-actions/planning-recommendation/print') }}/${applicationId}?url=print`;
                window.location.href = printUrl;
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message || 'Something went wrong!',
                confirmButtonColor: '#EF4444'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        hidePreloader();
        submitBtn.disabled = false;
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while updating planning recommendation.',
            confirmButtonColor: '#EF4444'
        });
    });
    return false;
  }

  function showPreloader() {
    Swal.fire({
      title: 'Processing...',
      html: 'Approval',
      allowOutsideClick: false,
      allowEscapeKey: false,
      didOpen: () => { Swal.showLoading(); }
    });
  }

  function hidePreloader() { Swal.close(); }
</script>
                        </div>
                      </div>
                        

                  
                            
                      
                
                      <!-- Final Bill Tab -->
                        <div id="final-tab" class="tab-content">


                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                          <div class="p-4 border-b">
                            <h3 class="text-sm font-medium">Planning Recommendation</h3>
                            <p class="text-xs text-gray-500"></p>
                          </div>
                          <input type="hidden" id="application_id" value="{{$application->id}}">
                      <input type="hidden" name="fileno" value="{{$application->fileno}}">
                          <div class="p-4 space-y-4">
                             
                            @include('actions.planning_recomm')
                            <hr class="my-4">
                
                            <div class="flex justify-between items-center">
                                <div class="flex gap-2">
                                    <button onclick="window.history.back()" class="flex items-center px-3 py-1 text-xs border border-gray-300 rounded-md bg-white hover:bg-gray-50" onclick="window.history.back()">
                                    <i data-lucide="undo-2" class="w-3.5 h-3.5 mr-1.5"></i>
                                    Back
                                    </button>
                                 
                                    <button type="button" id="print-planning-recommendation" class="flex items-center px-3 py-1 text-xs bg-green-700 text-white rounded-md hover:bg-gray-800">
                                        <i data-lucide="printer-check" class="w-3.5 h-3.5 mr-1.5"></i>
                                        Print
                                    </button>
                                    
                                    <!-- Fallback Print Link -->
                                    <a href="{{ url('sub-actions/planning-recommendation/print') }}/{{$application->id}}?url=print" target="_blank" class="flex items-center px-3 py-1 text-xs bg-blue-700 text-white rounded-md hover:bg-blue-800">
                                        <i data-lucide="external-link" class="w-3.5 h-3.5 mr-1.5"></i>
                                        Print (Alt)
                                    </a>
                                </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                <!-- Footer -->
                @include('admin.footer')
            </div>
            <script>
  console.log("JS loaded successfully"); // Debug log

  document.addEventListener('DOMContentLoaded', function() {
    // Tab switching functionality
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');
    tabButtons.forEach(button => {
      button.addEventListener('click', function() {
        const tabId = this.getAttribute('data-tab');
        // Deactivate all tabs
        tabButtons.forEach(btn => btn.classList.remove('active'));
        tabContents.forEach(content => content.classList.remove('active'));
        this.classList.add('active');
        document.getElementById(`${tabId}-tab`).classList.add('active');
      });
    });

    // Close modal button
    document.getElementById('closeModal').addEventListener('click', function() {
      // In a real application, this would close the modal
      alert('Modal closed');
    });

    // Print Planning Recommendation using a new window
    document.getElementById('print-planning-recommendation').addEventListener('click', function(e) {
      e.preventDefault();
      try {
        console.log('Print button clicked'); // Debug log
        
        // Create a new window with just the planning recommendation content
        const printWindow = window.open('', '_blank', 'height=800,width=800');
        
        // Get the direct URL to the planning recommendation with the print parameter
        const applicationId = document.getElementById('application_id').value;
        const printUrl = `{{ url('sub-actions/planning-recommendation/print') }}/${applicationId}?url=print`;
        
        // Navigate the new window to this URL
        printWindow.location.href = printUrl;
        
        // Set up listener for when content is loaded
        printWindow.onload = function() {
          setTimeout(function() {
            printWindow.focus();
            printWindow.print();
          }, 1000); // Short delay to ensure content is fully loaded
        };
      } catch (error) {
        console.error('Error printing:', error);
        alert('There was an error during printing. See console for details.');
      }
    });

    // Toggle reason field based on decision
    const decisionRadios = document.querySelectorAll('input[name="decision"]');
    const reasonContainer = document.getElementById('reasonContainer');
    decisionRadios.forEach(radio => {
      radio.addEventListener('change', function() {
        reasonContainer.style.display = (this.value === 'Declined') ? 'block' : 'none';
      });
    });

    // Form submission via AJAX with SweetAlert and preloader
    const form = document.getElementById('planningRecommendationForm');
    form.addEventListener('submit', function(e) {
      e.preventDefault();
      showPreloader();
      const submitBtn = document.getElementById('planningRecommendationSubmitBtn');
      if (submitBtn) { submitBtn.disabled = true; }
      const applicationId = document.getElementById('application_id').value;
      const decision = document.querySelector('input[name="decision"]:checked').value;
      const approvalDate = document.getElementById('approval-date').value;
      const comments = document.getElementById('comments').value || '';
      
      fetch('{{ url("sub-actions/planning-recommendation/update") }}', {
          method: 'POST',
          headers: {
              'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
              'Content-Type': 'application/json',
              'Accept': 'application/json'
          },
          body: JSON.stringify({
              application_id: applicationId,
              status: decision,
              approval_date: approvalDate,
              comments: comments
          })
      })
      .then(response => response.json())
      .then(data => {
          hidePreloader();
          submitBtn.disabled = false;
          if (data.success) {
              Swal.fire({
                  icon: 'success',
                  title: 'Success!',
                  text: 'Planning recommendation updated successfully!',
                  confirmButtonColor: '#10B981'
              }).then(() => { 
                  // Redirect to sub-application print URL instead of primary application URL
                  const applicationId = document.getElementById('application_id').value;
                  const printUrl = `{{ url('sub-actions/planning-recommendation/print') }}/${applicationId}?url=print`;
                  window.location.href = printUrl;
              });
          } else {
              Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: data.message || 'Something went wrong!',
                  confirmButtonColor: '#EF4444'
              });
          }
      })
      .catch(error => {
          console.error('Error:', error);
          hidePreloader();
          submitBtn.disabled = false;
          Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'An error occurred while updating planning recommendation.',
              confirmButtonColor: '#EF4444'
          });
      });
    });
  });

  function showPreloader() {
    Swal.fire({
      title: 'Processing...',
      html: 'Approval',
      allowOutsideClick: false,
      allowEscapeKey: false,
      didOpen: () => { Swal.showLoading(); }
    });
  }

  function hidePreloader() { Swal.close(); }
  
</script>
    
  @endsection


