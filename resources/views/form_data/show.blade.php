@extends('layout.app')
@push('scripts')
<script src="{{ asset(config('layout.resources.custom_js')) }}" type="text/javascript"></script>
@endpush
@php
    $role_code = Auth::user()->user_role->role_code;
    $field = 'name_'.$lang;
    $ratings = __('form.array.rating');
    $form_data_btn = __('form.array.form_data_btn');
    $form_data_exp = __('messages.form_data_btn');
    $rating_count = count($ratings);
    $fdata = ($form_data) ? unserialize($form_data->answers) : array();
    $disabled = '';
    $sub_category_ids = unserialize($form->sub_category_ids);
    if ($sub_category_ids==null && $user->goal_reviews->where('type', 'radio')->count()==0)
    {
    	$disabled = 'disabled';
    }
@endphp
@section('content')
@include('components/flash-message')
<div class="row">
	<div class="col-lg-12">
		@if ($disabled == 'disabled')
		<div class="alert alert-custom alert-notice alert-light-danger fade show" role="alert">
            <div class="alert-icon"><i class="flaticon-warning"></i></div>
            <div class="alert-text">{{ __('messages.pbf_validation') }}</div>
        </div>
		@endif
	
		<div class="accordion accordion-solid accordion-panel accordion-svg-toggle mb-5" id="accordionExample3">
        	<div class="card">
                <div class="card-header" id="heading3">
                    <div class="card-title collapsed" data-toggle="collapse" data-target="#collapse3">
                    	<span class="svg-icon svg-icon-primary">
                         <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                          <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                           <polygon points="0 0 24 0 24 24 0 24"></polygon>
                           <path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero"></path>
                           <path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "></path>
                          </g>
                         </svg>
                        </span>
                        <div class="card-label pl-4">{{ __('form.label.explanation') }}</div>
                    </div>
                </div>
                <div id="collapse3" class="collapse" data-parent="#accordionExample3">
                    <div class="card-body">
						{{-- @foreach($ratings as $rkey=>$rating)
    					<div>{!! $rkey.': '.$rating !!}</div>
    					@endforeach --}}
    					{!! $form_data_exp[$review_type->number][$role_code] !!}
                    </div>
                </div>
            </div>
        </div>
		
		<form id="kt_form" class="form" method="POST" enctype="multipart/form-data" action="{{ route('form_data.store', [app()->getLocale()]) }}">
        	@csrf
        	<input type="hidden" name="id" value="{{ ($form_data && $form_data->year=='') ? $form_data->id : '' }}">
        	<input type="hidden" name="form_id" value="{{ ($form) ? $form->id : '' }}">
        	<input type="hidden" name="user_id" value="{{ $user->id }}">
        	<input type="hidden" name="review_type_id" value="{{ $review_type->id }}">
        	<input type="hidden" name="review_type_num" value="{{ $review_type_num }}">
        	<input type="hidden" name="date" value="">
        	<input type="hidden" name="year" value="">
        	<input type="hidden" name="full_name" value="">
        	<input type="hidden" name="save_final" value="">
        	
        	<div class="card card-custom gutter-b">
    			<div class="card-body">
    				<div class="row">
            			<div class="col-xl-4">
                    		<div class="form-group">
                    			<label class="font-weight-bold">{{ __('form.label.name').'/'.__('form.label.names') }}:</label>
    							<input type="text" class="form-control" name="ans[name]" value="{{ isset($fdata['name']) ? $fdata['name'] : '' }}"/>
                    		</div>
                		</div>
            		</div>
    			</div>
			</div>
        	
			<div class="card card-custom gutter-b">
            	<div class="card-body">
            		@foreach($categories as $category)
            			@php
            			$sub_category_ids = unserialize($form->sub_category_ids);
            			$sub_categories = $category->sub_category->whereIn('id', $sub_category_ids);
            			@endphp
                    	<div class="mb-10">
                    		<h6>{{ $category->$field }}</h6>
                    		@foreach($sub_categories as $sub_category)
                        		@php
                    			$question_ids = unserialize($form->question_ids);
                    			$questions = $sub_category->question->whereIn('id', $question_ids);
                    			@endphp
                        		<div class="table-responsive mb-5">
                            		<table class="table table-hover">
                            			<thead>
                            				<tr>
                            					<th width="50%">{{ $sub_category->$field }}</th>
                            					@if($show_ratings)
                                					@foreach($ratings as $rkey=>$rating)
                                					<th>{{ $rating }}</th>
                                					@endforeach
                            					@endif
                            				</tr>
                            			</thead>
                            			<tbody>
                            				@foreach($questions as $question)
                            				<tr>
                            					@if($question->type=='textarea')
                            						<td colspan="{{ $rating_count+1 }}">
                            							<textarea class="form-control" name="ans[{{ $sub_category->id }}][{{ $question->id }}]" placeholder="{{ $question->$field }}">{{ isset($fdata[$sub_category->id][$question->id]) ? $fdata[$sub_category->id][$question->id] : '' }}</textarea>
                            						</td>
                            					@else
                            						<td colspan="{{ ($show_ratings) ? '' : $rating_count+1 }}">{{ $question->$field }}</td>
                            						@if($show_ratings)
                                						@foreach($ratings as $rkey=>$rating)
                                    					<td>
                                    						<div class="radio-inline">
                                        						<label class="radio">
                                                                    <input type="radio" name="ans[{{ $sub_category->id }}][{{ $question->id }}]" value="{{ $rkey }}" {{ (isset($fdata[$sub_category->id][$question->id]) && $fdata[$sub_category->id][$question->id]==$rkey) ? 'checked' : '' }} />
                                                                    <span></span>
                                                                </label>
                                                            </div>
                                    					</td>
                                    					@endforeach
                                					@endif
                            					@endif
                            				</tr>
                            				@endforeach
                            			</tbody>
                            		</table>
                            	</div>
                        	@endforeach
                    	</div>
                	@endforeach
            	</div>
			</div>
			
			<div class="card card-custom gutter-b">
    			<div class="card-header">
            		<div class="card-title">
            			<h3 class="card-label">{{ trans_choice('form.label.goal', 2) }}</h3>
            		</div>
            	</div>
    			<div class="card-body">
    				@if($user->goal_reviews->where('type', 'radio')->count() > 0)
    					<div class="table-responsive">
                    		<table class="table table-hover">
                    			<thead>
                    				<tr>
                    					<th width="50%">{{ trans_choice('form.label.goal', 2) }}</th>
                    					@if($show_ratings)
                        					@foreach($ratings as $rkey=>$rating)
                        					<th>{{ $rating }}</th>
                        					@endforeach
                    					@endif
                    				</tr>
                    			</thead>
                    			<tbody>
                                	@foreach($user->goal_reviews->where('type', 'radio') as $goal_review)
                            		<tr>
                            			<td colspan="{{ ($show_ratings) ? '' : $rating_count+1 }}">
                                			<span><b>{{ $goal_review->title.': ' }}</b></span>
                                			<span>{!! $goal_review->description ? nl2br($goal_review->description) : '-' !!}</span>
                            			</td>
                            			@if($show_ratings)
                                			@foreach($ratings as $rkey=>$rating)
                        					<td>
                        						<div class="radio-inline">
                            						<label class="radio">
                                                        <input type="radio" name="ans[goals][{{ $goal_review->id }}]" value="{{ $rkey }}" {{ (isset($fdata['goals'][$goal_review->id]) && $fdata['goals'][$goal_review->id]==$rkey) ? 'checked' : '' }}/>
                                                        <span></span>
                                                    </label>
                                                </div>
                        					</td>
                        					@endforeach
                    					@endif
                            		</tr>
                            		<tr>
                            			<td colspan="{{ $rating_count+1 }}">
                							<textarea class="form-control" name="ans[goals][{{ $goal_review->id.'_desc' }}]" placeholder="{{ __('form.label.explanation') }}">{{ isset($fdata['goals'][$goal_review->id.'_desc']) ? $fdata['goals'][$goal_review->id.'_desc'] : '' }}</textarea>
                						</td>
                            		</tr>
                            		@endforeach
                    			</tbody>
                			</table>
            			</div>
                    @else
                    	<div>-</div>
                    @endif
    			</div>
    		</div>
    		
    		<div class="card card-custom gutter-b">
    			<div class="card-header">
            		<div class="card-title">
            			<h3 class="card-label">{{ __('form.label.general') }}</h3>
            		</div>
            	</div>
    			<div class="card-body">
    				<div class="form-group">
    					<textarea class="form-control" name="ans[general]" placeholder="{{ $form_data_btn[$review_type->number]['placeholder'] }}">{{ isset($fdata['general']) ? $fdata['general'] : '' }}</textarea>
					</div>
    			</div>
			</div>
    		
    		<div class="card-footer">
        		<button type="submit" class="btn btn-primary mr-2" name="save" value="1" {{ $disabled }}>{{ __('form.label.save') }}</button>
        		<button type="submit" class="btn btn-secondary mr-2" name="save_pdf" value="1" {{ $disabled }}>{{ __('form.label.save_pdf') }}</button>
        		<button type="button" class="btn btn-success mr-2" name="final" {{ $disabled }}>{{ __('form.label.final') }}</button>
        		<!-- <a href="{{ route('users.pdf', ['user' => $user->id, 'locale'=>app()->getLocale(), 'type'=>'scoresheet']) }}" class="btn btn-secondary mr-2">{{ __('form.label.save_pdf') }}</a> -->
        	</div>
		</form>
	</div>
</div>

<!-- start: Modal to add final -->
<div class="modal fade" id="final-modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="final-form" class="form" method="POST" action="">
        	@csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="final-modal-label">{{ $form_data_btn[$review_type->number]['txt_hover'] }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
            		<div class="form-group">
            			<label class="font-weight-bold">{{ __('form.label.date_meeting') }}: *</label>
						<input type="text" class="form-control kt-datepicker" name="date" data-value="" required="required" onblur="check_fields()"/>
            		</div>
                	<div class="form-group">
						<label class="font-weight-bold">{{ __('form.label.year') }}: *</label>
            			<input type="number" class="form-control" name="year" required="required" min="2000" max="2999" onblur="check_fields()"/>
            			<span class="form-text text-muted">{{ __('messages.year_validate') }}</span>
            		</div>
            		<div class="form-group">
						<label class="font-weight-bold">{{ __('form.label.enter_full_name') }}: *</label>
            			<input type="text" class="form-control" name="full_name" required="required" onblur="check_fields()"/>
            		</div>
            		<div class="form-group">
            			{{ __('messages.final_text') }}
            		</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">{{__('form.label.close')}}</button>
                    <button type="button" class="btn btn-light-primary font-weight-bold" name="final">{{__('form.label.submit')}}</button>
                </div>
            </div>
    	</form>
    </div>
</div>
<!-- end: Modal to add final -->
@endsection
@push('scripts')
<script>
var icon_url = "{{ asset(config('layout.resources.popup_icon')) }}";
$(function() {
	var lang = '{{ app()->getLocale() }}';
	$('.kt-datepicker').datepicker({
        format: "dd M yyyy",
		autoclose: true,
        orientation: "bottom left",
        language: (lang=='du') ? "nl" : lang,
    }).on('changeDate', function(e){
    	$(this).attr('data-value', moment(e.date).format('YYYY-MM-DD'));
    });
    
	$('button[name="save_pdf"]').click(function (e) {
		var res = check_selection();
		if(res) {
			return true;
    	}
		e.preventDefault();
    });

    $('#final-form button[name=final]').click(function (e)
   	{
    	var blank = false;
    	$("#final-form input").each(function() {
    		$(this).removeClass('is-invalid');
			var val = $(this).val();
			if (val=='')
			{
				blank = true;
				$(this).addClass('is-invalid');
			}
    	});
    	if (blank)
    	{
    		return false;
    	}
    	
    	KTApp.blockPage();
    	var date = $('#final-form input[name=date]').attr('data-value');
        var year = $('#final-form input[name=year]').val();
        var full_name = $('#final-form input[name=full_name]').val();
        var year = +(year.trim());
        if(year >= 2000 && year <= 2999) {
        	if(date != '' && year != '' && full_name!='') {
            	$('#kt_form input[name=date]').val(date);
                $('#kt_form input[name=year]').val(year);
                $('#kt_form input[name=full_name]').val(full_name);
                $('#kt_form input[name=save_final]').val('1');
                document.getElementById('kt_form').submit();
            }
        }else {
        	KTApp.unblockPage();
        	Swal.fire({
    			title: "{{ __('messages.year_validate') }}",
    			imageUrl: icon_url,
        	});
    		return false;
        }
    });

    $('#kt_form button[name=final]').click(function (e) {
    	var res = check_selection();
    	if(res) {
    		$('#final-modal').modal('show');
    	}
    });
});

function check_selection() {
	var blank = false;
	$("input[type=radio]").each(function() {
	    var val = $('input[type=radio][name="' + this.name + '"]:checked').val();
	    if (val === undefined) {
	        blank = true;
	        return false;
	    }
	});
	
	if (blank) {
		Swal.fire({
			title: "{{ __('messages.fill_ratings') }}",
			imageUrl: icon_url,
    	});
		return false;
	}else {
		//document.getElementById('kt_form').submit();
		return true;
	}
}

function check_fields() 
{
	$('#final-form button[name=final]').addClass('btn-light-primary').removeClass('btn-success');
	var date = $('#final-form input[name=date]').attr('data-value');
    var year = $('#final-form input[name=year]').val();
    var full_name = $('#final-form input[name=full_name]').val();
    if(date != '' && year != '' && full_name!='')
    {
    	$('#final-form button[name=final]').addClass('btn-success').removeClass('btn-light-primary');
	}
}
</script>
@endpush