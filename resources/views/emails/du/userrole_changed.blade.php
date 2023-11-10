@extends('layout.email')
@section('content')
<p>De gebruikersrol van {{ $mail_data['user']->full_name }} met {{ $mail_data['user']->email }} is veranderd naar : {{ $mail_data['updated_user']->user_role->role_du }}</p>
@endsection