@extends('layout.email')
@section('content')
<p><b>Name:</b> {{ $mail_data['user']->full_name }}</p>
<p><b>Company Name:</b> {{ $mail_data['user']->company_user->company->name }}</p>
<p><b>Support:</b> {!! $mail_data['message'] !!}</p>			
@endsection