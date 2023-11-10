@extends('layout.app')
@php
list($controller, $action) = getActionName();
$field = 'name_'.$lang;
@endphp
@section('content')
@include('components/flash-message')
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
						{!! __('messages.expl_category') !!}
                    </div>
                </div>
            </div>
        </div>
        
		<div class="card card-custom gutter-b">
			<div class="card-body">
				<!-- category accordion -->
                <div class="accordion accordion-solid accordion-toggle-plus" id="accordionExample3">
                	@foreach($categories as $ckey=>$category)
                		<div class="card">
                            <div class="card-header" id="heading{{$category->id}}3">
                                <div class="card-title bg-yellow text-dark font-weight-bolder {{ $ckey!=0 ? 'collapsed' : ''}}" data-toggle="collapse" data-target="#collapse{{$category->id}}3">
                                    {{ $category->$field }}
                                </div>
                            </div>
                            <div id="collapse{{$category->id}}3" class="collapse {{ $ckey==0 ? 'show' : ''}}" data-parent="#accordionExample3">
                                <div class="card-body">
                                    
    								<!-- subcategory -->
    								@foreach($category->sub_category as $skey=>$sub_category)
    									<div id="subcat{{ $sub_category->id }}">
        									<h6>
        										{{ $sub_category->$field }}
        									</h6>
        									<div class="que-cont">
        										<!-- questions -->
        										@foreach($sub_category->question as $qkey=>$question)
        											@if ($question->type != 'textarea')
            											<div class="que-list mb-2">
                											{{ $question->$field }}
                										</div>
            										@endif
        										@endforeach
        									</div>
        									@if(count($category->sub_category) != $skey+1)
        									<div class="separator separator-solid separator-border-1 my-10"></div>
        									@endif
        								</div>
                                    @endforeach
    
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
        	</div>
		</div>
	</div>
</div>
@endsection