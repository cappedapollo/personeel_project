@extends('layout.pdf')
@php
	$lang = ($company->language) ? $company->language : app()->getLocale();
    $field = 'name_'.$lang;
    $company_logo = ($company->logo) ? ($company->file ? getLinkFromBucket($company->file->file_key) : '') : '';
@endphp
@section('content')
<div class="text-right"><img src="{{ $company_logo }}" height="65px" alt="{{ $company->name }}"/></div>
<h1 class="text-upper">{{ $company->name }}</h1>

<h2 class="mt-20 p-10 text-upper stripe">{{ __('form.label.competencies') }}</h2>
<div class="row">
	@foreach($categories as $category)
		@php
		$sub_categories = $category->sub_category;
		@endphp
    	<table class="table" cellspacing="0" border="0">
    		<tbody>
        		@foreach($sub_categories as $sub_category)
            		@php
        			$questions = $sub_category->question;
        			@endphp
        			<tr>
        				<td><b>{{ $sub_category->$field }}</b></td>
        			</tr>
    			
    				@foreach($questions as $question)
    					<tr class="">
            				<td>
            					@if($question->type!='textarea')
            					<span class="mr-10"><img src="{{ asset(config('layout.resources.checkmark')) }}" height="7px"/></span>
            					@endif
            					{{ $question->$field }}
        					</td>
            			</tr>
    				@endforeach
    				
    				<tr>
        				<td class="pb-20"></td>
        			</tr>
    			@endforeach
    		</tbody>
    	</table>
	@endforeach
</div>
@endsection