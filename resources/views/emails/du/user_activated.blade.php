@extends('layout.email')
@section('content')
<p>Je PB account is geactiveerd. Je kan met je tijdelijk wachtwoord inloggen of via FORGET PASSWORD een nieuw wachtwoord genereren.</p>
<p>Login gegevens
<br/><b>E-mail:</b> {{ $mail_data['email'] }}
<br/><b>Wachtwoord:</b> {{ $mail_data['password'] }}</p>
<p>Je kan hier inloggen: {{ config('app.url') }}</p>
@endsection