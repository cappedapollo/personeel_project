@extends('layout.email')
@section('content')
<p>Welcome,<p>
<p>Here are your login credentials:</p>
<p><b>Email:</b> {{ $mail_data['email'] }}</p>
<p><b>Password:</b> {{ $mail_data['password'] }}</p>
<p>You can login here: {{ config('app.url') }}</p>
@endsection