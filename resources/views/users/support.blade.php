@extends('layout.app')
@push('scripts')
<script src="{{ asset(config('layout.resources.validation_js')) }}" type="text/javascript"></script>
@endpush
@section('content')
@include('components/flash-message')
<div class="row">
	<div class="col-lg-12">
		<div class="card card-custom gutter-b">
            <form id="kt_form" class="form" method="POST">
            	@csrf
            	<div class="card-body">
            		<div class="row">
                		<div class="col-xl-12">
                    		<div class="form-group">
                    			<label class="font-weight-bold">{{ __('messages.send_suggestion') }}</label>
                    			<textarea class="form-control" name="support" rows="5" required data-fv-not-empty___message="{{__('validation.required', ['attribute' => 'Field'])}}">{{ old('support') }}</textarea>
                    		</div>
                    	</div>
                    </div>
            	</div>
            	<div class="card-footer">
            		<button type="submit" class="btn btn-primary mr-2">Send</button>
            	</div>
        	</form>
    	</div>
	</div>
</div>
@endsection