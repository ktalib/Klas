<div class="bg-gray-50 p-4 rounded-md mb-6">
    <h3 class="font-medium text-center mb-4">INITIAL BILL</h3>
    
    <div class="grid grid-cols-3 gap-4 mb-4">
      <div>
        <label class="flex items-center text-sm mb-1">
          <i data-lucide="file-text" class="w-4 h-4 mr-1 text-green-600"></i>
          Application fee (₦)
        </label>
        <input type="number" class="w-full p-2 border border-gray-300 rounded-md fee-input" placeholder="Enter application fee" name="application_fee" value="0.00">
      </div>
      <div>
        <label class="flex items-center text-sm mb-1">
          <i data-lucide="file-check" class="w-4 h-4 mr-1 text-green-600"></i>
          Processing fee (₦)
        </label>
        <input type="number" class="w-full p-2 border border-gray-300 rounded-md fee-input" placeholder="Enter processing fee" name="processing_fee" value="0.00">
      </div>
      <div>
        <label class="flex items-center text-sm mb-1">
          <i data-lucide="map" class="w-4 h-4 mr-1 text-green-600"></i>
          Site Plan (₦)
        </label>
        <input type="number" class="w-full p-2 border border-gray-300 rounded-md fee-input" placeholder="Enter site plan fee" name="site_plan_fee" value="0.00">
      </div>
    </div>
    
    <div class="flex justify-between items-center mb-4">
      <div class="flex items-center">
        <i data-lucide="file-text" class="w-4 h-4 mr-1 text-green-600"></i>
        <span>Total:</span>
      </div>
      <span class="font-bold" id="total-amount">₦0.00</span>
    </div>
    
    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="flex items-center text-sm mb-1">
          <i data-lucide="calendar" class="w-4 h-4 mr-1 text-green-600"></i>
          has been paid on
        </label>
        <input type="date" class="w-full p-2 border border-gray-300 rounded-md" value="{{ date('Y-m-d') }}" name="payment_date">
      </div>
      <div>
        <label class="flex items-center text-sm mb-1">
          <i data-lucide="receipt" class="w-4 h-4 mr-1 text-green-600"></i>
          with receipt No.
        </label>
        <input type="number" class="w-full p-2 border border-gray-300 rounded-md" placeholder="Enter receipt number" name="receipt_number">
      </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const feeInputs = document.querySelectorAll('.fee-input');
    const totalDisplay = document.getElementById('total-amount');
    
    // Function to calculate and update the total
    function updateTotal() {
        let total = 0;
        feeInputs.forEach(input => {
            const value = parseFloat(input.value) || 0;
            total += value;
        });
        
        // Format the total with 2 decimal places and the Naira symbol
        totalDisplay.textContent = '₦' + total.toFixed(2);
    }

    // Function to format amount as user types
    function formatAmountInput(input, newDigit) {
        // Get current value without decimal point
        let currentValue = input.value.replace(/[^\d]/g, '');
        
        // Add the new digit
        currentValue += newDigit;
        
        // Convert to number and divide by 100 to get proper decimal places
        let numericValue = parseInt(currentValue) / 100;
        
        // Format to 2 decimal places
        input.value = numericValue.toFixed(2);
        
        updateTotal();
    }

    // Add event listeners to all fee inputs
    feeInputs.forEach(input => {
        // Store original input type and change to text for better control
        input.type = 'text';
        input.setAttribute('inputmode', 'numeric');
        
        // Handle keydown events for number input
        input.addEventListener('keydown', function(e) {
            // Allow: backspace, delete, tab, escape, enter
            if ([8, 9, 27, 13, 46].indexOf(e.keyCode) !== -1 ||
                // Allow: Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
                (e.keyCode === 65 && e.ctrlKey === true) ||
                (e.keyCode === 67 && e.ctrlKey === true) ||
                (e.keyCode === 86 && e.ctrlKey === true) ||
                (e.keyCode === 88 && e.ctrlKey === true)) {
                return;
            }
            
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
                return;
            }
            
            e.preventDefault();
            
            // Handle backspace
            if (e.keyCode === 8) {
                let currentValue = input.value.replace(/[^\d]/g, '');
                if (currentValue.length > 0) {
                    currentValue = currentValue.slice(0, -1);
                    if (currentValue.length === 0) {
                        input.value = '0.00';
                    } else {
                        let numericValue = parseInt(currentValue) / 100;
                        input.value = numericValue.toFixed(2);
                    }
                    updateTotal();
                }
                return;
            }
            
            // Get the pressed digit
            let digit;
            if (e.keyCode >= 48 && e.keyCode <= 57) {
                digit = String.fromCharCode(e.keyCode);
            } else if (e.keyCode >= 96 && e.keyCode <= 105) {
                digit = String.fromCharCode(e.keyCode - 48);
            }
            
            if (digit !== undefined) {
                formatAmountInput(input, digit);
            }
        });

        // Handle focus event
        input.addEventListener('focus', function() {
            // Select all text for easy replacement
            input.select();
        });

        // Handle blur event
        input.addEventListener('blur', function() {
            if (input.value === "" || isNaN(parseFloat(input.value))) {
                input.value = "0.00";
            } else {
                // Always format to 2 decimal places
                input.value = parseFloat(input.value).toFixed(2);
            }
            updateTotal();
        });

        // Handle paste events
        input.addEventListener('paste', function(e) {
            e.preventDefault();
            let paste = (e.clipboardData || window.clipboardData).getData('text');
            let numericValue = parseFloat(paste.replace(/[^\d.]/g, ''));
            if (!isNaN(numericValue)) {
                input.value = numericValue.toFixed(2);
                updateTotal();
            }
        });
    });
    
    // Calculate initial total
    updateTotal();
});
</script>