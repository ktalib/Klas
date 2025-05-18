 


<!-- Unit Information Section -->
<div class="bg-gray-50 p-4 rounded-lg">
    <h3 class="text-lg font-semibold mb-4 text-gray-700">Unit Information</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="space-y-2">
            <label for="PrimaryGISID" class="block text-sm font-medium text-gray-700">Primary GIS ID</label>
            <input type="text" id="PrimaryGISID" name="PrimaryGISID"class="w-full p-2 border border-gray-300 rounded-md bg-gray-100" readonly>
        </div>
        
        <div class="space-y-2">
            <label for="STFileNo" class="block text-sm font-medium text-gray-700">ST File Number</label>
            <input type="text" id="STFileNo" name="STFileNo" class="w-full p-2 border border-gray-300 rounded-md bg-gray-100" readonly>
        </div>
        
        <div class="space-y-2">
            <label for="app_id" class="block text-sm font-medium text-gray-700">Application ID</label>
            <input type="text" id="app_id" name="app_id" class="w-full p-2 border border-gray-300 rounded-md bg-gray-100" readonly>
        </div>
        
       <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700">Scheme Number</label>
            <input type="text" id="scheme_no_preview" class="w-full p-2 border border-gray-300 rounded-md text-sm">
            <input type="hidden" id="scheme_no" name="scheme_no">
        </div>

       <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700">Section Number</label>
            <input type="text" id="section_no_preview"  class="w-full p-2 border border-gray-300 rounded-md text-sm">
            <input type="hidden" id="section_no" name="section_no">
        </div>
        
     <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700">Block Number</label>
            <input type="text" id="block_no_preview"  class="w-full p-2 border border-gray-300 rounded-md text-sm">
            <input type="hidden" id="block_no" name="block_no">
        </div>
        
      <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700">Unit Number</label>
            <input type="text" id="unit_no_preview" class="w-full p-2 border border-gray-300 rounded-md text-sm">
            <input type="hidden" id="unit_no" name="unit_no">
        </div>
        
        <div class="space-y-2">
            <label for="landuse" class="block text-sm font-medium text-gray-700">Land Use</label>
            <input type="text" id="landuse" name="landuse" class="w-full p-2 border border-gray-300 rounded-md text-sm">
        </div>
        
        <div class="space-y-2">
            <label for="height" class="block text-sm font-medium text-gray-700">Height</label>
            <input type="text" id="height" name="height" class="w-full p-2 border border-gray-300 rounded-md text-sm">
        </div>
        
        <!-- Unit ID field is not editable -->
        <div class="space-y-2">
            <label for="unit_id" class="block text-sm font-medium text-gray-700">Unit ID</label>
            <input type="text" id="unit_id" name="unit_id" readonly class="w-full p-2 border border-gray-300 rounded-md text-sm bg-gray-100">
        </div>
    </div>
</div>

<!-- Unit Properties Section -->
<div class="bg-gray-50 p-4 rounded-lg mt-4">
    <h3 class="text-lg font-semibold mb-4 text-gray-700">Unit Properties</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="space-y-2">
            <label for="section_attribute" class="block text-sm font-medium text-gray-700">Section Attribute</label>
            <input type="text" id="section_attribute" name="section_attribute" class="w-full p-2 border border-gray-300 rounded-md text-sm">
        </div>
        
        <div class="space-y-2">
            <label for="base" class="block text-sm font-medium text-gray-700">Base</label>
            <input type="text" id="base" name="base" class="w-full p-2 border border-gray-300 rounded-md text-sm">
        </div>
        
        <div class="space-y-2">
            <label for="floor" class="block text-sm font-medium text-gray-700">Floor</label>
            <input type="text" id="floor" name="floor" class="w-full p-2 border border-gray-300 rounded-md text-sm">
        </div>
        
        <div class="space-y-2">
            <label for="tpreport" class="block text-sm font-medium text-gray-700">TP Report</label>
            <input type="text" id="tpreport" name="tpreport" class="w-full p-2 border border-gray-300 rounded-md text-sm">
        </div>
    </div>
</div>

<!-- Unit Control Information Section -->
<div class="bg-gray-50 p-4 rounded-lg mt-4">
    <h3 class="text-lg font-semibold mb-4 text-gray-700">Unit Control Information</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="space-y-2">
            <label for="UnitControlBeaconNo" class="block text-sm font-medium text-gray-700">Unit Control Beacon Number</label>
            <input type="text" id="UnitControlBeaconNo" name="UnitControlBeaconNo" class="w-full p-2 border border-gray-300 rounded-md text-sm">
        </div>
        
        <div class="space-y-2">
            <label for="UnitControlBeaconX" class="block text-sm font-medium text-gray-700">Unit Control Beacon X</label>
            <input type="text" id="UnitControlBeaconX" name="UnitControlBeaconX" class="w-full p-2 border border-gray-300 rounded-md text-sm">
        </div>
        
        <div class="space-y-2">
            <label for="UnitControlBeaconY" class="block text-sm font-medium text-gray-700">Unit Control Beacon Y</label>
            <input type="text" id="UnitControlBeaconY" name="UnitControlBeaconY" class="w-full p-2 border border-gray-300 rounded-md text-sm">
        </div>
        
        <div class="space-y-2">
            <label for="UnitSize" class="block text-sm font-medium text-gray-700">Unit Size</label>
            <input type="text" id="UnitSize" name="UnitSize" class="w-full p-2 border border-gray-300 rounded-md text-sm">
        </div>
        
        <div class="space-y-2">
            <label for="UnitDemsion" class="block text-sm font-medium text-gray-700">Unit Dimension</label>
            <input type="text" id="UnitDemsion" name="UnitDemsion" class="w-full p-2 border border-gray-300 rounded-md text-sm">
        </div>
        
        <div class="space-y-2">
            <label for="UnitPosition" class="block text-sm font-medium text-gray-700">Unit Position</label>
            <input type="text" id="UnitPosition" name="UnitPosition" class="w-full p-2 border border-gray-300 rounded-md text-sm">
        </div>
    </div>
</div>