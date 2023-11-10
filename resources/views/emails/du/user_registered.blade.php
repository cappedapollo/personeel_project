@extends('layout.email')
@section('content')
<p>Welkom bij PB Online. Je account is geactiveerd en je kunt nu inloggen met de
volgende login-gegevens:</p>
<p><b>E-mail:</b> {{ $mail_data['email'] }}</p>
<p><b>Wachtwoord:</b> {{ $mail_data['password'] }}</p>
<p>Je kan hier inloggen: {{ config('app.url') }}</p>
@endsection