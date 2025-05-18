<div class="p-6 bg-white border-b border-gray-200">
  <div class="flex justify-between items-center">
    <div>
    <h1 class="text-2xl font-bold">{{$PageTitle}}</h1>
    <p class="text-gray-500">{{$PageDescription}}</p>
    </div>
    <div class="flex items-center space-x-4">
      <!-- Back Button -->
      <button type="button"
        onclick="window.history.back()"
        class="flex items-center px-3 py-2 border border-gray-300 rounded-md bg-gray-50 hover:bg-gray-100 text-gray-700"
        title="Go Back">
        <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
        Back
      </button>
      <div class="relative">
        <i data-lucide="search" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-4 h-4"></i>
        <input
        type="text"
        placeholder="Search applications..."
        class="pl-10 pr-4 py-2 border border-gray-200 rounded-md w-64 focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
      </div>
      <div class="relative">
        <i data-lucide="bell" class="w-5 h-5"></i>
        <span class="absolute -top-1 -right-1 bg-orange-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
        2
        </span>
      </div>
      <form method="POST" action="{{ route('logout') }}" id="autoLogoutForm">
        @csrf
        <button type="submit" class="text-red-500 hover:text-red-700">
        Logout
        </button>
      </form>
    </div>
  </div>
</div>

<!-- Tailwind CDN must come BEFORE our configuration -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
  // Simple flag to force popup to show - for testing
  const FORCE_SHOW_POPUP = false;
  
  // Configure Tailwind - this must come AFTER the CDN import
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          brand: {
            red: '#D42E12',
            green: '#107C41',
            yellow: '#FFBA08',
            black: '#212121'
          }
        }
      }
    }
  }
</script>
<style>
  /* Custom colors as direct CSS variables for fallback */
  :root {
    --brand-red: #D42E12;
    --brand-green: #107C41;
    --brand-yellow: #FFBA08;
    --brand-black: #212121;
  }
  
  /* Apply fallback styles using the CSS variables */
  .bg-brand-green-fallback {
    background-color: var(--brand-green) !important;
  }
  .text-brand-green-fallback {
    color: var(--brand-green) !important;
  }
  .hover-brand-green-fallback:hover {
    background-color: rgba(16, 124, 65, 0.9) !important;
  }
  
  @keyframes flash {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
  }
  .flash-text {
    animation: flash 1.8s infinite;
  }
  .popup-overlay {
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.4s ease, visibility 0.4s ease;
  }
  .popup-overlay.active {
    opacity: 1;
    visibility: visible;
  }
  .popup-content {
    transform: scale(0.9);
    transition: transform 0.4s ease;
  }
  .popup-overlay.active .popup-content {
    transform: scale(1);
  }
  .brand-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-template-rows: 1fr 1fr;
    width: 60px;
    height: 60px;
  }
</style>
<!-- Welcome Popup -->
<div id="welcomePopup" class="popup-overlay fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50" style="display: none; background: linear-gradient(to bottom, rgba(0, 120, 212, 0.658), rgba(0, 104, 55, 0.8));">
  <div class="popup-content bg-white rounded-xl shadow-2xl w-11/12 max-w-md mx-auto overflow-hidden">
    <!-- Brand Logos Header -->
    <div class="flex justify-center items-center space-x-6 pt-4">
      <img src="{{ asset('storage/upload/logo/logo.png') }}" alt="KLAS Logo" class="h-12">
      <img src="{{ asset('storage/upload/logo/las.jpeg') }}" alt="LAAD-Sys Logo" class="h-12">
    </div>
    
     
    <!-- Popup Content -->
    <div class="p-6">
      <div class="mb-8 text-center">
        <div class="flex justify-center mb-4">
          <div class="w-16 h-1 rounded-full" style="background: linear-gradient(to right, #D42E12, #FFBA08, #107C41);"></div>
        </div>
        
        <p class="text-gray-600 mb-4">We're excited to have you here!</p>
        
        <div class="flash-text py-3 px-4 rounded-lg" style="background: linear-gradient(to right, rgba(212,46,18,0.1), rgba(255,186,8,0.1), rgba(16,124,65,0.1));">
          <h3 class="text-2xl md:text-3xl font-extrabold" style="color: #212121;">
            WELCOME TO KLAS
          </h3>
          <p class="text-xl md:text-2xl font-bold mt-2">
            Dear <span id="username" class="text-brand-green-fallback" style="color: #107C41;">USERNAME</span>
          </p>
        </div>
      </div>
      
      <div class="space-y-3">
        <button id="continueBtn" class="w-full bg-brand-green bg-brand-green-fallback hover-brand-green-fallback text-white font-semibold py-3 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-opacity-50 transition" style="background-color: #107C41;">
          Continue to Site
        </button>
      </div>
    </div>
  </div>
</div>

<script>
  // Simple flag to control popup visibility for testing purposes
  const TEST_POPUP_ENABLED = false; // Change to false to disable the popup for testing
  
  // Add this line to force execution - ensures the script runs
  console.log('Welcome popup script loaded');
  
  // Function to toggle welcome popup on/off for testing
  function toggleWelcomePopup(show) {
    const popup = document.getElementById('welcomePopup');
    if (!popup) return;
    
    if (show) {
      popup.style.display = 'flex';
      setTimeout(() => {
        popup.classList.add('active');
      }, 10);
    } else {
      popup.classList.remove('active');
      setTimeout(() => {
        popup.style.display = 'none';
      }, 400);
    }
    console.log('Welcome popup toggled:', show ? 'ON' : 'OFF');
  }
  
  // Wait for DOM to be fully loaded
  window.addEventListener('DOMContentLoaded', function() {
    console.log('DOM fully loaded');
    
    // Get elements
    const popup = document.getElementById('welcomePopup');
    const closeBtn = document.getElementById('closePopup');
    const continueBtn = document.getElementById('continueBtn');
    const learnMoreBtn = document.getElementById('learnMoreBtn');
    const usernameSpan = document.getElementById('username');
    
    // Get the username from PHP
    const username = "{{ Auth::user()->first_name ?? Auth::user()->name ?? Auth::user()->email ?? 'User' }}";
    console.log('Current user:', username);
    
    // Set the username in the popup
    if (usernameSpan) {
      usernameSpan.textContent = username;
    }
    
    // Function to show popup
    function showPopup() {
      console.log('Showing popup');
      popup.style.display = 'flex';
      // Add active class after a small delay to trigger animation
      setTimeout(() => {
        popup.classList.add('active');
      }, 10);
      
      // Mark as shown in server-side session via AJAX
      fetch("{{ route('markWelcomePopupShown') }}", {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
      }).then(response => {
        console.log('Marked popup as shown in session');
      });
    }
    
    // Function to hide popup
    function hidePopup() {
      console.log('Hiding popup');
      popup.classList.remove('active');
      // Remove from DOM after animation completes
      setTimeout(() => {
        popup.style.display = 'none';
      }, 400);
    }
    
    // Add event listeners
    if (closeBtn) closeBtn.addEventListener('click', hidePopup);
    if (continueBtn) continueBtn.addEventListener('click', hidePopup);
    
    // Handle learn more button
    if (learnMoreBtn) {
      learnMoreBtn.addEventListener('click', function() {
        alert('This would take you to more information about KLAS.');
      });
    }
    
    // Close when clicking outside
    popup.addEventListener('click', function(e) {
      if (e.target === popup) hidePopup();
    });
    
    // Close with Escape key
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape' && popup.classList.contains('active')) {
        hidePopup();
      }
    });
    
    // Check if we should show popup - based on server-side session or testing flag
    const shouldShowPopup = TEST_POPUP_ENABLED || {{ session('show_welcome_popup', true) ? 'true' : 'false' }};
    console.log('Should show popup:', shouldShowPopup);
    
    if (FORCE_SHOW_POPUP || shouldShowPopup) {
      console.log('Will show popup');
      // Small delay to ensure everything is loaded
      setTimeout(showPopup, 500);
    } else {
      console.log('Popup will not be shown');
    }
  });
  
  // Reset popup state on logout
  const logoutForm = document.getElementById('autoLogoutForm');
  if (logoutForm) {
    logoutForm.addEventListener('submit', function() {
      console.log('Logout detected, clearing popup state');
      sessionStorage.removeItem('welcomePopupShown');
    });
  }
</script>

<!-- Auto Logout Script and Toast -->
<style>
  /* Toast Container Styles */
  #autoLogoutToast {
    position: fixed;
    top: 30px;
    right: 30px;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    padding: 16px 20px;
    display: none;
    z-index: 9999;
    width: 320px;
    font-family: system-ui, -apple-system, sans-serif;
  }
  
  /* Toast Header */
  .toast-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
  }
  
  /* Toast Title */
  .toast-title {
    font-weight: 600;
    font-size: 16px;
    color: #212121;
  }
  
  /* Toast Close Button */
  .toast-close {
    background: none;
    border: none;
    cursor: pointer;
    color: #aaa;
    font-size: 18px;
  }
  
  /* Toast Content */
  .toast-content {
    display: flex;
    align-items: center;
  }
  
  /* Toast Message */
  .toast-message {
    flex-grow: 1;
    font-size: 14px;
    color: #555;
    margin-right: 15px;
  }
  
  /* Progress Circle Container */
  .progress-circle-container {
    position: relative;
    width: 44px;
    height: 44px;
  }
  
  /* Progress Circle */
  .progress-circle {
    transform: rotate(-90deg);
    width: 44px;
    height: 44px;
  }
  
  /* Progress Circle Background */
  .progress-circle-bg {
    fill: none;
    stroke: #f3f3f3;
    stroke-width: 4;
  }
  
  /* Progress Circle Indicator */
  .progress-circle-indicator {
    fill: none;
    stroke: #D42E12;
    stroke-width: 4;
    stroke-linecap: round;
    transition: stroke-dashoffset 0.3s ease;
  }
  
  /* Countdown Text */
  .countdown-text {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 12px;
    font-weight: 700;
    color: #D42E12;
  }
  
  /* Toast Actions */
  .toast-actions {
    display: flex;
    justify-content: flex-end;
    margin-top: 15px;
  }
  
  /* Continue Button */
  .continue-btn {
    background-color: #107C41;
    color: white;
    border: none;
    border-radius: 4px;
    padding: 8px 16px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.2s;
  }
  
  .continue-btn:hover {
    background-color: #0c6a38;
  }
</style>

<!-- Auto Logout Toast -->
<div id="autoLogoutToast">
  <div class="toast-header">
    <div class="toast-title">Session Timeout</div>
    <button class="toast-close" id="closeAutoLogoutToast">&times;</button>
  </div>
  <div class="toast-content">
    <div class="toast-message">
      Your session is about to expire due to inactivity.
    </div>
    <div class="progress-circle-container">
      <svg class="progress-circle" viewBox="0 0 36 36">
        <circle class="progress-circle-bg" cx="18" cy="18" r="16"></circle>
        <circle class="progress-circle-indicator" cx="18" cy="18" r="16" 
                stroke-dasharray="100" stroke-dashoffset="0"></circle>
      </svg>
      <div class="countdown-text" id="countdownText">30</div>
    </div>
  </div>
  <div class="toast-actions">
    <button class="continue-btn" id="continueSessionBtn">Continue Session</button>
  </div>
</div>

<script>
// Auto Logout Configuration
const AUTO_LOGOUT_CONFIG = {
  idleTime:  6000000, // 3 minutes in seconds
  warningTime: 30, // Show warning 30 seconds before logout
  checkInterval: 1000, // Check every second
};

// User activity tracking
let lastActivityTime = Date.now();
let autoLogoutTimer = null;
let countdownTimer = null;
let warningShown = false;

// Toast and countdown elements
const autoLogoutToast = document.getElementById('autoLogoutToast');
const countdownText = document.getElementById('countdownText');
const progressCircle = document.querySelector('.progress-circle-indicator');
const CIRCLE_CIRCUMFERENCE = 2 * Math.PI * 16; // 2πr where r=16 (from SVG)

// Set the circle's length
progressCircle.style.strokeDasharray = CIRCLE_CIRCUMFERENCE;
progressCircle.style.strokeDashoffset = '0';

// Function to update user's last activity time
function updateActivity() {
  lastActivityTime = Date.now();
  
  // Hide warning toast if it's visible
  if (warningShown) {
    hideLogoutWarning();
  }
}

// Function to check if user is idle
function checkUserIdle() {
  const currentTime = Date.now();
  const idleTime = (currentTime - lastActivityTime) / 1000; // Convert to seconds
  
  // If user has been idle for longer than the warning threshold but warning not shown yet
  if (idleTime >= (AUTO_LOGOUT_CONFIG.idleTime - AUTO_LOGOUT_CONFIG.warningTime) && !warningShown) {
    showLogoutWarning();
  }
  
  // If user has been idle for longer than the idle threshold
  if (idleTime >= AUTO_LOGOUT_CONFIG.idleTime) {
    performAutoLogout();
  }
}

// Show the logout warning and start countdown
function showLogoutWarning() {
  warningShown = true;
  let countdownSeconds = AUTO_LOGOUT_CONFIG.warningTime;
  
  // Show the toast
  autoLogoutToast.style.display = 'block';
  
  // Set initial countdown
  countdownText.textContent = countdownSeconds;
  
  // Start countdown timer
  countdownTimer = setInterval(() => {
    countdownSeconds--;
    
    // Update text countdown
    countdownText.textContent = countdownSeconds;
    
    // Update circular progress
    const progressPercentage = (countdownSeconds / AUTO_LOGOUT_CONFIG.warningTime) * 100;
    const dashOffset = CIRCLE_CIRCUMFERENCE * (1 - progressPercentage / 100);
    progressCircle.style.strokeDashoffset = dashOffset;
    
    // If countdown finished
    if (countdownSeconds <= 0) {
      clearInterval(countdownTimer);
    }
  }, 1000);
}

// Hide the logout warning and reset countdown
function hideLogoutWarning() {
  warningShown = false;
  autoLogoutToast.style.display = 'none';
  
  // Clear the countdown timer
  if (countdownTimer) {
    clearInterval(countdownTimer);
    countdownTimer = null;
  }
  
  // Reset circular progress
  progressCircle.style.strokeDashoffset = '0';
}

// Function to perform the actual logout
function performAutoLogout() {
  // Clear all timers
  if (autoLogoutTimer) {
    clearInterval(autoLogoutTimer);
  }
  if (countdownTimer) {
    clearInterval(countdownTimer);
  }
  
  // Submit the logout form
  const logoutForm = document.getElementById('autoLogoutForm');
  if (logoutForm) {
    logoutForm.submit();
  } else {
    // Fallback if logout form not found
    window.location.href = "{{ route('logout') }}";
  }
}

// Start monitoring user activity
document.addEventListener('DOMContentLoaded', function() {
  // Register activity events
  const activityEvents = ['mousedown', 'mousemove', 'keydown', 'scroll', 'touchstart', 'click'];
  
  activityEvents.forEach(event => {
    document.addEventListener(event, updateActivity, true);
  });
  
  // Set up timer to periodically check for inactivity
  autoLogoutTimer = setInterval(checkUserIdle, AUTO_LOGOUT_CONFIG.checkInterval);
  
  // Set initial activity timestamp
  updateActivity();
  
  // Set up continue session button
  const continueSessionBtn = document.getElementById('continueSessionBtn');
  if (continueSessionBtn) {
    continueSessionBtn.addEventListener('click', updateActivity);
  }
  
  // Set up close button
  const closeToastBtn = document.getElementById('closeAutoLogoutToast');
  if (closeToastBtn) {
    closeToastBtn.addEventListener('click', updateActivity);
  }
});
</script>

<!-- Set last login time in session -->
@php
    if (!session()->has('last_login_time')) {
        session(['last_login_time' => time()]);
    }
@endphp

<!-- Set welcome popup flag in session if not set -->
@php
    // Set welcome popup flag to true for first-time visits in a login session
    if (!session()->has('show_welcome_popup')) {
        session(['show_welcome_popup' => true]);
    }
@endphp
