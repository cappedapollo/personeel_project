@extends('layout.email')
@section('content')
<p>Your PB Online account is made active. You can login with your temporary password and then immediately change your password.</p>
<p>Your personal login details:
<br/><b>Username:</b> {{ $mail_data['email'] }}
<br/><b>Password:</b> {{ $mail_data['password'] }}</p>
<p>You can login here: {{ config('app.url') }}</p>
@endsection