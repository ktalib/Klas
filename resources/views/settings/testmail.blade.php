{{ Form::model(Auth::User(), array('route' => array('setting.smtp.testing'), 'method' => 'POST')) }}
<div class="p-6">
    <div class="flex justify-between items-center mb-4 border-b border-gray-200 pb-3">
        <h3 class="text-lg font-medium text-gray-900">{{ __('Test Email Configuration') }}</h3>
        <button type="button" class="text-gray-400 hover:text-gray-500" data-dismiss="modal" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    
    <div class="mb-4">
        <div class="w-full">
            {{Form::label('email', __('Test Email'), ['class' => 'block text-sm font-medium text-gray-700 mb-1'])}}
            {{Form::text('email', null, [
                'class' => 'w-full p-2 border border-gray-300 rounded-md text-sm',
                'placeholder' => __('Enter User Email'),
                'required' => 'required'
            ])}}
            <p class="text-xs text-gray-500 mt-1">{{ __('An email will be sent to this address to test your settings.') }}</p>
        </div>
    </div>
</div>
<div class="px-6 py-3 bg-gray-50 text-right">
    {{Form::submit(__('Send Mail'), ['class' => 'inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500'])}}
    <button type="button" class="ml-2 inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" data-dismiss="modal">
        {{ __('Cancel') }}
    </button>
</div>
{{ Form::close() }}
