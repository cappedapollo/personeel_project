@extends('layout.app')
@push('scripts')
<script src="{{ asset(config('layout.resources.validation_js')) }}" type="text/javascript"></script>
<script src="{{ asset(config('layout.resources.custom_js')) }}" type="text/javascript"></script>
@endpush
@php
    list($controller, $action) = getActionName();
    $role_code = Auth::user()->user_role->role_code;
    $count = 0;
    $greviews = array('0'=>array('id'=>'', 'title'=>'', 'description'=>''));
    if($goal_reviews->count() > 0) {
    	$greviews = $goal_reviews->toArray();
    }
    
    $disabled = '';
    if(!in_array($role_code, array('manager'))) {
    	$disabled = 'disabled';
    }
    
    $field = 'name_'.$lang;
    $category_ids = $sub_category_ids = $question_ids = array();
    $form = $user->form->where('completed', 'no')->sortDesc()->first();
    if($form) {
        $category_ids = unserialize($form->category_ids);
        $sub_category_ids = unserialize($form->sub_category_ids);
        $question_ids = unserialize($form->question_ids);
    }
    
    $submit_button = '';
    if	($role_code=='manager' && $user->manager_id!=Auth::id())
	{
		$submit_button = 'disabled';
	}
@endphp
@section('content')
<x-flash-message/>
<x-set-titles page="{{ $controller.'_'.$action }}" module=""/>

<div class="row">
	<div class="col-lg-12">
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
						{!! __('messages.expl_competencies_'.$role_code) !!}
                    </div>
                </div>
            </div>
        </div>
		
		<form id="kt_form" name="kt_form" class="form" method="POST" enctype="multipart/form-data" action="{{ route('goal_reviews.store', [app()->getLocale()]) }}">
        	@csrf
        	<input type="hidden" name="id" value="{{ ($form) ? $form->id : '' }}">
        	<input type="hidden" name="user_id" value="{{ $user->id }}"/>
        	@foreach($categories as $ckey=>$category)
        	<input type="hidden" name="cat[]" value="{{ $category->id }}"/>
        	@endforeach
        	
        	<div class="card card-custom gutter-b">
            	<div class="card-header card-header-tabs-line">
            		<div class="card-toolbar">
            			<ul class="nav nav-tabs nav-bold nav-tabs-line">
            				<li class="nav-item">
            					<a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1_4">
            					<span class="nav-text">{{ __('form.label.competencies') }}</span>
            					</a>
            				</li>
            				<li class="nav-item">
            					<a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2_4">
            					<span class="nav-text">{{ trans_choice('form.label.goal1', 2) }}</span>
            					</a>
            				</li>
            			</ul>
            		</div>
            	</div>
            	<div class="card-body">
            		<div class="tab-content">
            			<div class="tab-pane fade show active" id="kt_tab_pane_1_4" role="tabpanel" aria-labelledby="kt_tab_pane_1_4">
							@foreach($categories as $ckey=>$category)
                        		@php
                        		$cat_checked = 'checked="checked"';
                        		if($category_ids) {
                                	$cat_checked = '';
                                	if(in_array($category->id, $category_ids)) {
                                		$cat_checked = 'checked="checked"';
                                	}
                                }
                        		@endphp
        						<!-- subcategory -->
        						@foreach($category->sub_category as $skey=>$sub_category)
        							@php
        							$sc_label_text = __('form.label.on');
                            		#$scat_checked = 'checked="checked"';
                            		$scat_checked = '';
                            		if($sub_category_ids) {
                                    	$scat_checked = '';
                                    	$sc_label_text = __('form.label.on');
                                    	if(in_array($sub_category->id, $sub_category_ids)) {
                                    		$scat_checked = 'checked="checked"';
                                    		$sc_label_text = __('form.label.off');
                                    	}
                                    }
                            		@endphp
        							<div id="subcat{{ $sub_category->id }}">
        								<h6 class="bg-yellow py-5 pl-5">
        									<span class="mr-3">
                                             	<input name="subcat[]" value="{{ $sub_category->id }}" data-type="subcat" data-switch="true" data-size="small" type="checkbox" data-handle-width="50" data-on-text="{{ __('form.label.on') }}" data-off-text="{{ __('form.label.off') }}" data-label-text='{{ $sc_label_text }}' {{$scat_checked}} data-off-color="primary"/>
                                            </span>
                                            {{ $sub_category->$field }}
        								</h6>
        								<div class="que-cont ml-5 {{ ($scat_checked!='') ? '' : 'd-none' }}">
        									<!-- questions -->
        									@foreach($sub_category->question as $qkey=>$question)
        										@php
        										$disabled = '';
        										$que_label_text = __('form.label.on');
                                        		#$que_checked = 'checked="checked"';
                                        		$que_checked = '';
                                        		if($question_ids) {
                                                	$que_checked = '';
                                                	$que_label_text = __('form.label.on');
                                                	if(in_array($question->id, $question_ids)) {
                                                		$que_checked = 'checked="checked"';
                                                		$que_label_text = __('form.label.off');
                                                	}
                                                }
                                                
                                                if($question->type == 'textarea') {
                                                	$disabled = 'disabled="disabled"';
                                                	$que_checked = 'checked="checked"';
                                                }
                                                
                                                @endphp
        										<div class="que-list mb-2">
        											<span class="mr-3">
                                                     	<input name="que[]" value="{{ $question->id }}" class="{{ $question->type }}" data-type="que" data-switch="true" data-size="small" type="checkbox" data-handle-width="50" data-on-text="{{ __('form.label.on') }}" data-off-text="{{ __('form.label.off') }}" data-label-text='{{ $que_label_text }}' {{$que_checked}} {{ $disabled }} data-off-color="primary"/>
                                                     	@if($question->type == 'textarea')
                                                     	<input name="que[]" value="{{ $question->id }}" type="hidden"/>
                                                     	@endif
                                                    </span>	
                                                    {{ $question->$field }}
        										</div>
        									@endforeach
        								</div>
        								@if(count($category->sub_category) != $skey+1)
        								<div class="separator separator-solid separator-border-1 my-10"></div>
        								@endif
        							</div>
                                @endforeach
                            @endforeach
						</div>
						<div class="tab-pane fade" id="kt_tab_pane_2_4" role="tabpanel" aria-labelledby="kt_tab_pane_2_4">
							<div class="review-wrapper">
                            	<div class="row">
                        			<div class="col-xl-4">
                                		<label class="font-weight-bold">{{ __('form.label.title') }}:</label>
                            		</div>
                            		<div class="col-xl-6">
                                		<label class="font-weight-bold">{{ __('form.label.explanation') }}:</label>
                            		</div>
                        		</div>
                            	<div class="review-div">
                            		@foreach($greviews as $grkey=>$greview)
                                		<div class="row review-row">
                                			<input type="hidden" name="review[id][]" value="{{ isset($greview['id']) ? $greview['id'] : '' }}"/>
                                			<div class="col-xl-4">
                                        		<div class="form-group">
                                        			<input type="text" class="form-control" name="review[title][]" value="{{ isset($greview['title']) ? $greview['title'] : '' }}"/>
                                        		</div>
                                        	</div>
                                    		<div class="col-xl-6">
                                        		<div class="form-group">
                                        			<textarea class="form-control" name="review[description][]">{{ isset($greview['description']) ? $greview['description'] : '' }}</textarea>
                                        		</div>
                                    		</div>
                                    		<div class="col-xl-2 delete_review">
                                        		<div class="form-group">
                                        			<a class="btn btn-danger btn-sm" onclick="deletetrow(this, 'review', {{ $greview['id'] ? $greview['id'] : '' }}, 'module');" data-url="{{ route('goal_reviews.destroy', ['goal_review'=>($greview['id'] ? $greview['id'] : 0), 'locale'=>app()->getLocale()]) }}" data-csrf="{{ csrf_token() }}"><i class="flaticon-close"></i></a>
                                        		</div>
                                    		</div>
                                		</div>
                                		@php
                                		$count++;
                                		@endphp
                            		@endforeach
                                </div>
                                <button type="button" class="btn btn-primary btn-sm mr-2" onclick="add_more(this, 'review');">{{ trans_choice('form.label.add', 3) }}</button>
                            </div>
						</div>
					</div>
				</div>
				<div class="card-footer">
            		<button type="submit" class="btn btn-primary mr-2" {{ $submit_button }}>{{ __('form.label.save') }}</button>
            	</div>
        	</div>
		</form>
	</div>
</div>
@endsection
@push('scripts')
<script>
$(function() {
	$('[data-switch=true]').bootstrapSwitch({
	    onSwitchChange: function(event, state){
	        var id = $(this).val();
	        var type = $(this).data('type');
	        if(state) {
				$(this).bootstrapSwitch('labelText', "{{ __('form.label.off') }}");
	        }else {
	        	$(this).bootstrapSwitch('labelText', "{{ __('form.label.on') }}");
	        }
	        if (type == 'subcat')
	        {
	        	if(state) {
    	        	$('#subcat'+id).find('.que-cont .que-list [data-switch=true]:not(.textarea)').bootstrapSwitch('disabled', !state); 
    	        	$('#subcat'+id).find('.que-cont .que-list [data-switch=true]:not(.textarea)').bootstrapSwitch('state', state);
    	        	$('#subcat'+id).find('.que-cont').removeClass('d-none');
    	        }else {
    	        	$('#subcat'+id).find('.que-cont .que-list [data-switch=true]:not(.textarea)').bootstrapSwitch('state', state); 
    	        	$('#subcat'+id).find('.que-cont .que-list [data-switch=true]:not(.textarea)').bootstrapSwitch('disabled', !state);
    	        	$('#subcat'+id).find('.que-cont').addClass('d-none');
    	        }
	        } 
	    }
	});

	$("button[name=gr-save]").click(function() {
		$("#kt_form2").submit();
	});
});
</script>
@endpush