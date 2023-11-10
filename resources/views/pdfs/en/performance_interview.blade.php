@extends('layout.pdf')
@php
$role_code = Auth::user()->user_role->role_code;
$ratings = __('form.array.rating');
$form_data_btn = __('form.array.form_data_btn');
$field = 'name_'.$lang;
$company_logo = ($user->company_user) ? $user->company_user->company->logo : '';
$company_logo = ($company_logo) ? ($user->company_user->company->file ? getLinkFromBucket($user->company_user->company->file->file_key) : '') : '';

#$today = date('d M Y');
$today = get_formatted_date($lang);
$sub_category_ids = unserialize($form->sub_category_ids);
$question_ids = unserialize($form->question_ids);
$fdata = ($form_data) ? unserialize($form_data->answers) : array();
$score_data = ($form_data) ? unserialize($form_data->scores) : array();
$goal_reviews = $user->goal_reviews->where('type', 'radio');
$manager_text = $user_roles->firstWhere('role_code', 'manager');
$fd_date = '';
if(isset($form_data->date) && !empty($form_data->date)) {
	#$fd_date = $form_data->date;
	$fd_date = get_formatted_date($lang, $form_data->date);
}
@endphp
@section('content')
<div class="text-right"><img src="{{ $company_logo }}" height="65px"/></div>
<h1 class="text-upper">{{ $review_type->name }}</h1>
<div>{!! '<b class="text-upper">'.trans_choice('form.label.employee', 1).':</b> '.$user->full_name !!}</div>
<div>{!! '<b class="text-upper">'.__('form.label.function').':</b> '.$user->function !!}</div>
<div>{!! '<b class="text-upper">'.__('form.label.date').':</b> '.$fd_date !!}</div>
<div>{!! '<b class="text-upper">'.$manager_text->$ur_field.':</b> '.(($user->manager) ? $user->manager->full_name : '') !!}</div>
@if(isset($fdata['name']) && !empty($fdata['name']))
	<div>{!! '<b class="text-upper">'.__('form.label.other_present').':</b> '.$fdata['name'] !!}</div>
@endif

<h2 class="mt-20 p-10 text-upper stripe">{{ __('form.label.competencies') }}</h2>
<div class="row">
	<table class="table" cellspacing="0" border="0">
		<tbody>
    		@foreach($sub_categories as $sub_category)
        		@php
    			$questions = $sub_category->question->whereIn('id', $question_ids);
    			$width = ($type == 'scoresheet') ? '80%' : '100%';
    			@endphp
    			<tr>
    				<td width="{{ $width }}"><b>{{ $sub_category->$field }}</b></td>
    				@if($type == 'scoresheet')
    				<td class="text-right"><b>{{ isset($score_data[$sub_category->id]) ? strtoupper($ratings[$score_data[$sub_category->id]['average_r']]) : '' }}</b></td>
    				@endif
    			</tr>
			
				@foreach($questions as $question)
					@php
					$colspan = $value = $ta_class = $b_class = '';
					$width = '80%';
					if($type == 'scoresheet' && $question->type!='textarea') {
						$ta_class = "text-right";
						$value = isset($fdata[$sub_category->id][$question->id]) ? $ratings[$fdata[$sub_category->id][$question->id]] : '';
					}
					if($question->type=='textarea') {
						$value = isset($fdata[$sub_category->id][$question->id]) ? $fdata[$sub_category->id][$question->id] : '';
						$colspan = '2';
						#$b_class = 'border';
						$width = '100%';
						
						echo '<tr><td colspan="{{ $colspan }}" width="{{ $width }}" class="p-5"></td></tr>';
					}
    				@endphp
					<tr class="{{ $b_class }}">
        				<td colspan="{{ $colspan }}" width="{{ $width }}">
        					@if($question->type!='textarea')
        					<span class="mr-10"><img src="{{ asset(config('layout.resources.checkmark')) }}" height="7px"/></span>
        					@endif
        					@if($question->type=='textarea')
        						@if ($value!='')
        							{{ $question->$field }}
        							<span>{!! $value !!}</span>
    							@endif
							@else
								{{ $question->$field }}
        					@endif
    					</td>
    					@if($type == 'scoresheet' && $question->type!='textarea')
        				<td class="{{ $ta_class }}">
        					<span>{{ ($value) ? $value : '' }}</span>
    					</td>
    					@endif
        			</tr>
				@endforeach
				
				<tr>
    				<td width="{{ $width }}" colspan="2" class="pb-20"></td>
    			</tr>
			@endforeach
		</tbody>
	</table>
</div>

@if($goal_reviews->count() > 0)
<h2 class="mt-20 p-10 text-upper stripe">{{ trans_choice('form.label.goal1', 2) }}</h2>
<div>
	<table class="table">
		<tbody>
    	@foreach($goal_reviews as $goal_review)
    		<tr>
				<td>
					<div><b class="text-upper">{{ $goal_review->title }}</b></div>
					<div>{!! $goal_review->description ? nl2br($goal_review->description) : '-' !!}</div>
					<tr><td></td></tr>
					<div>
						{{ __('form.label.explanation').': ' }}
						{!! isset($fdata['goals'][$goal_review->id.'_desc']) ? $fdata['goals'][$goal_review->id.'_desc'] : '---' !!}
					</div>
				</td>
			</tr>
			<tr><td class="p-5"></td></tr>
    	@endforeach
    	</tbody>
	</table>
</div>
@endif

@if(isset($fdata['general']))
<div class="row mt-20">
	<span>
		<b>{{ __('form.label.general').": " }}</b>
		{!! $fdata['general'] !!}
	</span>
</div>
@endif

@if($type == 'scoresheet')
<h2 class="mt-20 p-10 text-upper stripe">{{ __('form.label.assessment_result') }}</h2>
<div class="row mt-20">
	<table class="table" cellspacing="0" border="0">
		<tbody>
			<tr>
				<td width="80%">{{ __('form.label.os_comp') }}</td>
				<td class="text-right">{{ isset($score_data['competencies']) ? $ratings[$score_data['competencies']['average_r']] : '' }}</td>
			</tr>
			<tr>
				<td width="80%">{{ __('form.label.os_goals') }}</td>
				<td class="text-right">{{ isset($score_data['goals']) ? $ratings[$score_data['goals']['average_r']] : '' }}</td>
			</tr>
			<tr><td width="100%" colspan="2">  </td></tr>
			<tr>
				<td width="80%" style="font-size:14px;"><b>{{ __('form.label.final_score') }}</b></td>
				<td class="text-right text-upper"><b>{{ ($form_data) ? $ratings[$form_data->average] : '' }}</b></td>
			</tr>
		</tbody>
	</table>
</div>
@endif

<div class="row mt-100">
	<h2 class="p-10 text-upper stripe">{{ __('form.label.signature') }}</h2>
	<div class="col-6">
		<span class="mb-2">
			<h1>
			@if($form_data->archive)
			{{ $form_data->archive->full_name }}
			@else
			{{ ' ' }}
			@endif
			</h1>
		</span>
		<hr width="80%" class="m-0"/>
		<div>{{ $user->full_name }}</div>
		@if($user->function)
		<div>{!! $user->function !!}</div>
		@endif
		<div>{{ __('form.label.date').": ".( ($form_data->archive) ? $today : '' ) }}</div>
	</div>
	<div class="col-6">
		@if($form_data)
			<span class="mb-2"><h1>{{ $form_data->full_name }}</h1></span>
		@endif
		<hr width="80%" class="m-0"/>
		<div>{{ ($user->manager) ? $user->manager->full_name : '' }}</div>
		@if($user->manager)
			@if($user->manager->function)
			<div>{!! $user->manager->function !!}</div>
			@endif
		@endif
		<div>{{ __('form.label.date').": ".$today }}</div>
	</div>
</div>
@endsection