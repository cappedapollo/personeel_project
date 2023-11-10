@extends('layout.email')
@php
$languages = __('form.array.lang');
@endphp
@section('content')
<p>New company registration:</p>
<p><b>Company Name:</b> {{ $inserted_comp_data->name ? $inserted_comp_data->name : '-' }}</p>
<p><b>Chamber Of Commerce:</b> {{ $inserted_comp_data->chamber_of_commerce ? $inserted_comp_data->chamber_of_commerce : '-' }}</p>
<p><b>Address:</b> {{ $inserted_comp_data->address ? $inserted_comp_data->address : '-' }}</p>
<p><b>Country:</b> {{ $inserted_comp_data->country ? $inserted_comp_data->country->name : '-' }}</p>
<p><b>Language:</b> {{ $inserted_comp_data->language ? $languages[$inserted_comp_data->language] : '-' }}</p>
<p><b>Employees:</b> {{ $inserted_comp_data->employee_no ? $inserted_comp_data->employee_no->nos : '-' }}</p>
<p><b>First Name (HR/Management):</b> {{ $inserted_data['first_name'] ? $inserted_data['first_name'] : '-' }}</p>
<p><b>Last Name (HR/Management):</b> {{ $inserted_data['last_name'] ? $inserted_data['last_name'] : '-' }}</p>
<p><b>Telephone (HR/Management):</b> {{ $inserted_data['telephone'] ? $inserted_data['telephone'] : '-' }}</p>
<p><b>Email (HR/Management):</b> {{ $inserted_data['email'] ? $inserted_data['email'] : '' }}</p>
<p><b>Function (HR/Management):</b> {{ $inserted_data['function'] ? $inserted_data['function'] : '' }}</p>
@endsection