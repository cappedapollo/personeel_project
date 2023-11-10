@extends('layout.email')
@php
$form_data_btn = __('form.array.form_data_btn');
@endphp
@section('content')
<p>{{ $mail_data['user'] }} heeft het formulier van het {{ $form_data_btn[$mail_data['review_type_num']]['txt_hover'] }} online klaargezet voor u om digitaal te ondertekenen.</p>
<p>Log hier in: {{ config('app.url') }}</p>
@endsection