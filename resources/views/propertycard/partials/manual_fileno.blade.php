<div class="bg-green-50 border border-green-100 rounded-md p-4 mb-6" id="manual-fileno-container">
  <div class="flex items-center mb-2">
    <i data-lucide="file" class="w-5 h-5 mr-2 text-green-600"></i>
    <span class="font-medium">File Number Information</span>
  </div>
  <p class="text-sm text-gray-600 mb-4">Select file number type and enter the details</p>

  <!-- Hidden inputs for form submission -->
  <input type="hidden" id="manual_activeFileTab" name="activeFileTab" value="mlsFNo">
  <input type="hidden" id="manual_mlsFNo" name="mlsFNo" value="">
  <input type="hidden" id="manual_kangisFileNo" name="kangisFileNo" value="">
  <input type="hidden" id="manual_NewKANGISFileno" name="NewKANGISFileno" value="">

  <!-- Tab Navigation -->
  <div class="flex space-x-1 mb-4 bg-gray-100 p-1 rounded-lg">
    <button type="button" id="tab-mls" class="flex-1 px-3 py-2 text-sm font-medium rounded-md bg-white text-blue-600 shadow-sm transition-all">
      MLS
    </button>
    <button type="button" id="tab-kangis" class="flex-1 px-3 py-2 text-sm font-medium rounded-md text-gray-500 hover:text-gray-700 transition-all">
      KANGIS
    </button>
    <button type="button" id="tab-newkangis" class="flex-1 px-3 py-2 text-sm font-medium rounded-md text-gray-500 hover:text-gray-700 transition-all">
      New KANGIS
    </button>
  </div>

  <!-- MLS Tab Content -->
  <div id="content-mls" class="tab-content-panel">
    <p class="text-sm text-gray-600 mb-3">MLS File Number</p>
    <div class="grid grid-cols-3 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">File Prefix</label>
        <select id="mls-prefix" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
          <option value="">Select prefix</option>
          <option value="COM">COM</option>
          <option value="RES">RES</option>
          <option value="CON-COM">CON-COM</option>
          <option value="CON-RES">CON-RES</option>
          <option value="CON-AG">CON-AG</option>
          <option value="CON-IND">CON-IND</option>
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Serial Number</label>
        <input type="text" id="mls-number" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="e.g. 2022-572">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Full FileNo</label>
        <input type="text" id="mls-preview" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-50" readonly>
      </div>
    </div>
  </div>

  <!-- KANGIS Tab Content -->
  <div id="content-kangis" class="tab-content-panel" style="display: none;">
    <p class="text-sm text-gray-600 mb-3">KANGIS File Number</p>
    <div class="grid grid-cols-3 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">File Prefix</label>
        <select id="kangis-prefix" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
          <option value="">Select Prefix</option>
          <option value="KNML">KNML</option>
          <option value="MNKL">MNKL</option>
          <option value="MLKN">MLKN</option>
          <option value="KNGP">KNGP</option>
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Serial Number</label>
        <input type="text" id="kangis-number" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="e.g. 0001 or 2500">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Full FileNo</label>
        <input type="text" id="kangis-preview" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-50" readonly>
      </div>
    </div>
  </div>

  <!-- New KANGIS Tab Content -->
  <div id="content-newkangis" class="tab-content-panel" style="display: none;">
    <p class="text-sm text-gray-600 mb-3">New KANGIS File Number</p>
    <div class="grid grid-cols-3 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">File Prefix</label>
        <select id="newkangis-prefix" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
          <option value="">Select Prefix</option>
          <option value="KN">KN</option>
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Serial Number</label>
        <input type="text" id="newkangis-number" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="e.g. 1586">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Full FileNo</label>
        <input type="text" id="newkangis-preview" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-50" readonly>
      </div>
    </div>
  </div>
</div>

<script>
// Immediately Invoked Function Expression to avoid conflicts
(function() {
    'use strict';
    
    console.log('Manual fileno script loading...');
    
    // Configuration
    const TABS = {
        mls: {
            button: 'tab-mls',
            content: 'content-mls',
            prefix: 'mls-prefix',
            number: 'mls-number',
            preview: 'mls-preview',
            hidden: 'manual_mlsFNo',
            activeValue: 'mlsFNo',
            format: (p, n) => p && n ? `${p}-${n}` : p || n || ''
        },
        kangis: {
            button: 'tab-kangis',
            content: 'content-kangis',
            prefix: 'kangis-prefix',
            number: 'kangis-number',
            preview: 'kangis-preview',
            hidden: 'manual_kangisFileNo',
            activeValue: 'kangisFileNo',
            format: (p, n) => {
                if (p && n) {
                    n = n.padStart(5, '0');
                    document.getElementById('kangis-number').value = n;
                    return `${p} ${n}`;
                }
                return p || n || '';
            }
        },
        newkangis: {
            button: 'tab-newkangis',
            content: 'content-newkangis',
            prefix: 'newkangis-prefix',
            number: 'newkangis-number',
            preview: 'newkangis-preview',
            hidden: 'manual_NewKANGISFileno',
            activeValue: 'NewKANGISFileno',
            format: (p, n) => p && n ? `${p}${n}` : p || n || ''
        }
    };
    
    let currentTab = 'mls';
    
    // Update preview for a specific tab
    function updatePreview(tabKey) {
        const tab = TABS[tabKey];
        if (!tab) return;
        
        const prefixEl = document.getElementById(tab.prefix);
        const numberEl = document.getElementById(tab.number);
        const previewEl = document.getElementById(tab.preview);
        const hiddenEl = document.getElementById(tab.hidden);
        
        if (!prefixEl || !numberEl || !previewEl || !hiddenEl) {
            console.error(`Missing elements for tab: ${tabKey}`);
            return;
        }
        
        const prefix = prefixEl.value.trim();
        const number = numberEl.value.trim();
        const formatted = tab.format(prefix, number);
        
        previewEl.value = formatted;
        hiddenEl.value = formatted;
        
        console.log(`Updated ${tabKey}: ${formatted}`);
    }
    
    // Switch to a specific tab
    function switchTab(tabKey) {
        console.log(`Switching to tab: ${tabKey}`);
        
        // Hide all content panels
        Object.keys(TABS).forEach(key => {
            const contentEl = document.getElementById(TABS[key].content);
            if (contentEl) {
                contentEl.style.display = 'none';
            }
        });
        
        // Reset all button styles
        Object.keys(TABS).forEach(key => {
            const buttonEl = document.getElementById(TABS[key].button);
            if (buttonEl) {
                buttonEl.className = 'flex-1 px-3 py-2 text-sm font-medium rounded-md text-gray-500 hover:text-gray-700 transition-all';
            }
        });
        
        // Show selected content and highlight button
        const selectedTab = TABS[tabKey];
        if (selectedTab) {
            const contentEl = document.getElementById(selectedTab.content);
            const buttonEl = document.getElementById(selectedTab.button);
            
            if (contentEl) {
                contentEl.style.display = 'block';
            }
            
            if (buttonEl) {
                buttonEl.className = 'flex-1 px-3 py-2 text-sm font-medium rounded-md bg-white text-blue-600 shadow-sm transition-all';
            }
            
            // Update active tab field
            const activeTabEl = document.getElementById('manual_activeFileTab');
            if (activeTabEl) {
                activeTabEl.value = selectedTab.activeValue;
            }
            
            currentTab = tabKey;
            updatePreview(tabKey);
        }
    }
    
    // Initialize the component
    function init() {
        console.log('Initializing manual fileno component...');
        
        // Add click listeners to tab buttons
        Object.keys(TABS).forEach(tabKey => {
            const tab = TABS[tabKey];
            const buttonEl = document.getElementById(tab.button);
            
            if (buttonEl) {
                buttonEl.addEventListener('click', function(e) {
                    e.preventDefault();
                    switchTab(tabKey);
                });
                console.log(`Added click listener to ${tab.button}`);
            } else {
                console.error(`Button not found: ${tab.button}`);
            }
        });
        
        // Add change/input listeners for preview updates
        Object.keys(TABS).forEach(tabKey => {
            const tab = TABS[tabKey];
            const prefixEl = document.getElementById(tab.prefix);
            const numberEl = document.getElementById(tab.number);
            
            if (prefixEl) {
                prefixEl.addEventListener('change', function() {
                    updatePreview(tabKey);
                });
                console.log(`Added change listener to ${tab.prefix}`);
            }
            
            if (numberEl) {
                numberEl.addEventListener('input', function() {
                    updatePreview(tabKey);
                });
                console.log(`Added input listener to ${tab.number}`);
            }
        });
        
        // Initialize with MLS tab
        switchTab('mls');
        
        console.log('Manual fileno component initialized successfully');
    }
    
    // Function to update form data for submission
    function updateFormData() {
        Object.keys(TABS).forEach(tabKey => {
            updatePreview(tabKey);
        });
        return true;
    }
    
    // Expose functions globally
    window.initManualFileno = init;
    window.updateManualFormFileData = updateFormData;
    
    // Auto-initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        // DOM is already ready
        setTimeout(init, 100);
    }
    
})();
</script>