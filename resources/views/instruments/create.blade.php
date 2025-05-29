@extends('layouts.app')
@section('page-title')
    {{ __('Instrument Capture') }}
@endsection


@section('content')
@include('instruments.create.css')
    <!-- Main Content -->
    <div class="flex-1 overflow-auto">
        <!-- Header -->
        @include('admin.header')
        <!-- Dashboard Content -->
        <div class="p-6">
 
      <div class="min-h-screen p-6">
        <div class="max-w-6xl mx-auto">
            <div class="card p-6">
                <h1 class="text-2xl font-bold mb-4">Instrument Registration System</h1>
                <p class="text-gray-600 mb-6">Select an instrument type to register</p>
                
                <!-- Instrument Type Selection - All 12 Types -->
                <div class="grid grid-cols-1 gap-4 mb-6">
                    <button class="instrument-type-btn p-4 border rounded-lg hover:bg-gray-50 text-left" data-type="power-of-attorney">
                        <h3 class="font-medium">Power of Attorney</h3>
                        <p class="text-sm text-gray-600">General power of attorney document</p>
                    </button>
                    <button class="instrument-type-btn p-4 border rounded-lg hover:bg-gray-50 text-left" data-type="irrevocable-power-of-attorney">
                        <h3 class="font-medium">Irrevocable Power of Attorney</h3>
                        <p class="text-sm text-gray-600">Irrevocable power of attorney document</p>
                    </button>
                    <button class="instrument-type-btn p-4 border rounded-lg hover:bg-gray-50 text-left" data-type="deed-of-mortgage">
                        <h3 class="font-medium">Deed of Mortgage</h3>
                        <p class="text-sm text-gray-600">Mortgage agreement document</p>
                    </button>
                    <button class="instrument-type-btn p-4 border rounded-lg hover:bg-gray-50 text-left" data-type="tripartite-mortgage">
                        <h3 class="font-medium">Tripartite Mortgage</h3>
                        <p class="text-sm text-gray-600">Three-party mortgage agreement</p>
                    </button>
                    <button class="instrument-type-btn p-4 border rounded-lg hover:bg-gray-50 text-left" data-type="deed-of-assignment">
                        <h3 class="font-medium">Deed of Assignment</h3>
                        <p class="text-sm text-gray-600">Property assignment document</p>
                    </button>
                    <button class="instrument-type-btn p-4 border rounded-lg hover:bg-gray-50 text-left" data-type="deed-of-lease">
                        <h3 class="font-medium">Deed of Lease</h3>
                        <p class="text-sm text-gray-600">Property lease agreement</p>
                    </button>
                    <button class="instrument-type-btn p-4 border rounded-lg hover:bg-gray-50 text-left" data-type="deed-of-sub-lease">
                        <h3 class="font-medium">Deed of Sub-Lease</h3>
                        <p class="text-sm text-gray-600">Sub-lease agreement document</p>
                    </button>
                    <button class="instrument-type-btn p-4 border rounded-lg hover:bg-gray-50 text-left" data-type="deed-of-sub-under-lease">
                        <h3 class="font-medium">Deed of Sub-Under-Lease</h3>
                        <p class="text-sm text-gray-600">Sub-under-lease agreement</p>
                    </button>
                    <button class="instrument-type-btn p-4 border rounded-lg hover:bg-gray-50 text-left" data-type="deed-of-sub-division">
                        <h3 class="font-medium">Deed of Sub-Division</h3>
                        <p class="text-sm text-gray-600">Property subdivision document</p>
                    </button>
                    <button class="instrument-type-btn p-4 border rounded-lg hover:bg-gray-50 text-left" data-type="deed-of-merger">
                        <h3 class="font-medium">Deed of Merger</h3>
                        <p class="text-sm text-gray-600">Property merger document</p>
                    </button>
                    <button class="instrument-type-btn p-4 border rounded-lg hover:bg-gray-50 text-left" data-type="deed-of-surrender">
                        <h3 class="font-medium">Deed of Surrender</h3>
                        <p class="text-sm text-gray-600">Property surrender document</p>
                    </button>
                    <button class="instrument-type-btn p-4 border rounded-lg hover:bg-gray-50 text-left" data-type="deed-of-assent">
                        <h3 class="font-medium">Deed of Assent</h3>
                        <p class="text-sm text-gray-600">Estate assent document</p>
                    </button>
                    <button class="instrument-type-btn p-4 border rounded-lg hover:bg-gray-50 text-left" data-type="deed-of-release">
                        <h3 class="font-medium">Deed of Release</h3>
                        <p class="text-sm text-gray-600">Property release document</p>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Instrument Registration Form Dialog -->
    <div id="registration-dialog" class="dialog-backdrop hidden">
        <div class="dialog-content animate-fade-in">
            <div class="p-6 border-b">
                <h2 id="dialog-title" class="text-lg font-semibold">Register Instrument</h2>
                <p class="text-sm text-gray-600">Enter the details for the new instrument</p>
            </div>
            
            <form id="registration-form" class="p-6 space-y-6">
                <!-- File Number Section -->
                <div class="space-y-4 border rounded-md p-4 bg-gray-50">
                    <h3 class="text-lg font-medium">File Number</h3>
                    
                    <div class="flex items-center space-x-2 mb-4">
                        <input type="checkbox" id="isTemporaryFileNo" class="checkbox">
                        <label for="isTemporaryFileNo" class="label">
                            This application has no Extant File Number (Use Temporary File Number)
                        </label>
                        <i data-lucide="info" class="h-4 w-4 text-gray-400 cursor-help" title="For applications without an existing file number, a temporary file number will be generated."></i>
                    </div>

                    <div id="temporary-file-section" class="space-y-2 hidden">
                        <label for="temporaryFileNo" class="label">Temporary File Number</label>
                        <div class="flex gap-2">
                            <input id="temporaryFileNo" name="temporaryFileNo" class="input bg-muted" readonly>
                            <button type="button" id="regenerate-temp-btn" class="btn btn-outline">Regenerate</button>
                        </div>
                        <p class="text-xs text-gray-500">This temporary file number will be used until a permanent file number is assigned.</p>
                    </div>

                    <div id="regular-file-section" class="space-y-4">
                         @include('instruments.partial.fileno')
                    </div>
                </div>

                <!-- Registration Details Section -->
                <div class="space-y-4 border rounded-md p-4 bg-gray-50">
                    <h3 class="text-lg font-medium">Registration Details</h3>
                    
                    <div id="reg-no-section" class="space-y-2 hidden">
                        <label for="regNo" class="label">Registration Number (ROOT TITLE)</label>
                        <input id="regNo" name="regNo" value="0/0/0" readonly class="input bg-muted">
                        <p class="text-xs text-gray-500">Customary Titles are registered as ROOT TITLES with Registration Number 0/0/0 by default.</p>
                    </div>
                    
                    <div class="space-y-2">
                        <label for="rootRegNo" class="label">Root Registration Number</label>
                        <input id="rootRegNo" name="rootRegNo" class="input" placeholder="Enter root registration number">
                    </div>
                </div>

                <!-- First Party Section -->
                <div class="border rounded-md p-4 bg-gray-50">
                    <h3 id="first-party-title" class="text-lg font-medium mb-3">Grantor Information</h3>
                    
                    <div class="space-y-2 mb-4">
                        <label for="firstPartyName" id="first-party-label" class="label">Grantor Name</label>
                        <input id="firstPartyName" name="firstPartyName" class="input" placeholder="Enter grantor's full name">
                    </div>

                    <div class="space-y-3 border rounded-md p-3 bg-white">
                        <h4 class="font-medium">Grantor Address</h4>
                        <div class="space-y-2">
                            <label for="firstPartyStreet" class="label">Street Address</label>
                            <input id="firstPartyStreet" name="firstPartyStreet" class="input" placeholder="Enter street address">
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div class="space-y-2">
                                <label for="firstPartyCity" class="label">City</label>
                                <input id="firstPartyCity" name="firstPartyCity" class="input" placeholder="Enter city">
                            </div>
                            <div class="space-y-2">
                                <label for="firstPartyState" class="label">State</label>
                                <input id="firstPartyState" name="firstPartyState" class="input" placeholder="Enter state">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div class="space-y-2">
                                <label for="firstPartyPostalCode" class="label">Postal Code</label>
                                <input id="firstPartyPostalCode" name="firstPartyPostalCode" class="input" placeholder="Enter postal code">
                            </div>
                            <div class="space-y-2">
                                <label for="firstPartyCountry" class="label">Country</label>
                                <input id="firstPartyCountry" name="firstPartyCountry" class="input" placeholder="Enter country">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Second Party Section -->
                <div class="border rounded-md p-4 bg-gray-50">
                    <h3 id="second-party-title" class="text-lg font-medium mb-3">Grantee Information</h3>
                    
                    <div class="space-y-2 mb-4">
                        <label for="secondPartyName" id="second-party-label" class="label">Grantee Name</label>
                        <input id="secondPartyName" name="secondPartyName" class="input" placeholder="Enter grantee's full name">
                    </div>

                    <div class="space-y-3 border rounded-md p-3 bg-white">
                        <h4 class="font-medium">Grantee Address</h4>
                        <div class="space-y-2">
                            <label for="secondPartyStreet" class="label">Street Address</label>
                            <input id="secondPartyStreet" name="secondPartyStreet" class="input" placeholder="Enter street address">
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div class="space-y-2">
                                <label for="secondPartyCity" class="label">City</label>
                                <input id="secondPartyCity" name="secondPartyCity" class="input" placeholder="Enter city">
                            </div>
                            <div class="space-y-2">
                                <label for="secondPartyState" class="label">State</label>
                                <input id="secondPartyState" name="secondPartyState" class="input" placeholder="Enter state">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div class="space-y-2">
                                <label for="secondPartyPostalCode" class="label">Postal Code</label>
                                <input id="secondPartyPostalCode" name="secondPartyPostalCode" class="input" placeholder="Enter postal code">
                            </div>
                            <div class="space-y-2">
                                <label for="secondPartyCountry" class="label">Country</label>
                                <input id="secondPartyCountry" name="secondPartyCountry" class="input" placeholder="Enter country">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Solicitor Information Section -->
                <div class="border rounded-md p-4 bg-gray-50">
                    <h3 class="text-lg font-medium mb-3">Solicitor Information</h3>
                    
                    <div class="space-y-2 mb-4">
                        <label for="solicitorName" class="label">Solicitor Name</label>
                        <input id="solicitorName" name="solicitorName" class="input" placeholder="Enter solicitor's full name">
                    </div>

                    <div class="space-y-2">
                        <label for="solicitorAddress" class="label">Solicitor Address</label>
                        <textarea id="solicitorAddress" name="solicitorAddress" class="textarea" placeholder="Enter solicitor's complete address"></textarea>
                    </div>
                </div>

                <!-- Property Details Section -->
                <div class="border rounded-md p-4 bg-gray-50">
                    <h3 class="text-lg font-medium mb-3">Property Details</h3>
                    
                    <div class="space-y-2">
                        <label for="plotDescription" class="label">Plot Description</label>
                        <textarea id="plotDescription" name="plotDescription" class="textarea" placeholder="Enter plot description"></textarea>
                    </div>

                    <div class="space-y-2 mt-4">
                        <label for="plotSize" class="label">Plot Size</label>
                        <input id="plotSize" name="plotSize" class="input" placeholder="Enter plot size (e.g., 100 x 50 meters)">
                    </div>

                    <div class="flex items-center space-x-2 mt-4">
                        <input type="checkbox" id="surveyInfo" class="checkbox">
                        <label for="surveyInfo" class="label">Include Survey Information</label>
                    </div>

                    <div id="survey-info-section" class="space-y-4 mt-4 border-t pt-4 hidden">
                        <h4 class="font-medium">Survey Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label for="lga" class="label">LGA (Local Government Area)</label>
                                <select id="lga" name="lga" class="select">
                                    <option value="">Select LGA</option>
                                    <option value="Ajingi">Ajingi</option>
                                    <option value="Albasu">Albasu</option>
                                    <option value="Bagwai">Bagwai</option>
                                    <option value="Bebeji">Bebeji</option>
                                    <option value="Bichi">Bichi</option>
                                    <option value="Bunkure">Bunkure</option>
                                    <option value="Dala">Dala</option>
                                    <option value="Dambatta">Dambatta</option>
                                    <option value="Dawaki Kudu">Dawaki Kudu</option>
                                    <option value="Dawaki Tofa">Dawaki Tofa</option>
                                    <option value="Doguwa">Doguwa</option>
                                    <option value="Fagge">Fagge</option>
                                    <option value="Gabasawa">Gabasawa</option>
                                    <option value="Garko">Garko</option>
                                    <option value="Garun Mallam">Garun Mallam</option>
                                    <option value="Gaya">Gaya</option>
                                    <option value="Gezawa">Gezawa</option>
                                    <option value="Gwale">Gwale</option>
                                    <option value="Gwarzo">Gwarzo</option>
                                    <option value="Kabo">Kabo</option>
                                    <option value="Kano Municipal">Kano Municipal</option>
                                    <option value="Karaye">Karaye</option>
                                    <option value="Kibiya">Kibiya</option>
                                    <option value="Kiru">Kiru</option>
                                    <option value="Kumbotso">Kumbotso</option>
                                    <option value="Kunchi">Kunchi</option>
                                    <option value="Kura">Kura</option>
                                    <option value="Madobi">Madobi</option>
                                    <option value="Makoda">Makoda</option>
                                    <option value="Minjibir">Minjibir</option>
                                    <option value="Nasarawa">Nasarawa</option>
                                    <option value="Rano">Rano</option>
                                    <option value="Rimin Gado">Rimin Gado</option>
                                    <option value="Rogo">Rogo</option>
                                    <option value="Shanono">Shanono</option>
                                    <option value="Sumaila">Sumaila</option>
                                    <option value="Takai">Takai</option>
                                    <option value="Tarauni">Tarauni</option>
                                    <option value="Tofa">Tofa</option>
                                    <option value="Tsanyawa">Tsanyawa</option>
                                    <option value="Tudun Wada">Tudun Wada</option>
                                    <option value="Ungogo">Ungogo</option>
                                    <option value="Warawa">Warawa</option>
                                    <option value="Wudil">Wudil</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label for="district" class="label">District</label>
                                <input id="district" name="district" class="input" placeholder="Enter district">
                            </div>
                            <div class="space-y-2">
                                <label for="plotNumber" class="label">Plot Number</label>
                                <input id="plotNumber" name="plotNumber" class="input" placeholder="Enter plot number">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Instrument-Specific Fields Section -->
                <div id="instrument-specific-section" class="border rounded-md p-4 bg-gray-50">
                    <h3 class="text-lg font-medium mb-3">Additional Details</h3>
                    
                    <div id="instrument-fields" class="space-y-4">
                        <!-- Dynamic fields will be inserted here -->
                    </div>

                    <!-- Registration Dates -->
                    <div class="border-t pt-4 mt-4">
                        <h4 class="font-medium mb-3">Registration Dates</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label for="registrationDate" class="label">Registration Date</label>
                                <div class="date-picker">
                                    <input id="registrationDate" name="registrationDate" type="date" class="input date-picker-input">
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label for="entryDate" class="label">Entry Date</label>
                                <div class="date-picker">
                                    <input id="entryDate" name="entryDate" type="date" class="input date-picker-input">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="p-6 border-t flex justify-end gap-2">
                <button type="button" id="cancel-btn" class="btn btn-outline">Cancel</button>
                <button type="button" id="submit-btn" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>

        </div>

        <!-- Footer -->
        @include('admin.footer')
    </div>

@include('instruments.create.js')
@endsection
