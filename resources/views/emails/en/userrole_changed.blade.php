@extends('layout.email')
@section('content')
<p>The userrole of {{ $mail_data['user']->full_name }} with {{ $mail_data['user']->email }} has been changed to : {{ $mail_data['updated_user']->user_role->role_en }}</p>
@endsection