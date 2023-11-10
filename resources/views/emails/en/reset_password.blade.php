@extends('layout.email')
@section('content')
<p>Dear {{ $data['name'] }},</p>
<p>You have requested a new password to access <a href="{{ config('app.url') }}">{{ config('app.url') }}</a></p>
<p>Reset your password by following link:</p>
<p><a href="{{ $data['reset_url'] }}" class="btn btn-primary">Reset your password</a></p>
@endsection