@extends('layout.email')
@php
$form_data_btn = __('form.array.form_data_btn');
@endphp
@section('content')
<p>{{ $mail_data['user'] }} has put the form of the {{ $form_data_btn[$mail_data['review_type_num']]['txt_hover'] }} online for you to digitally sign.</p>
<p>Log in here: {{ config('app.url') }}</p>
@endsection