@extends('layout.email')
@section('content')
<p>Dear {{ $data['name'] }},</p>
<p>You have requested the setup of the setup verification link. You need to have the google authenticator smartphone app, which then will allow you to scan the QR code and access {{ config('app.name') }}.</p>
<p>Click on the button for your unique setup.</p>
<p><a href="{{ $data['register_url'] }}" class="btn btn-primary">SETUP</a></p>
@endsection