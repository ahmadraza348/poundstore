@extends('backend.layouts.layout')
@section('title', 'Edit City - Pound Store')
@section('content')
<div class="page-wrapper"><div class="content">
    <div class="page-header"><div class="page-title"><h4>Edit City / Area</h4><h6>Changes to the city name and status affect its public branch listings.</h6></div></div>
    <form method="POST" action="{{ route('city.update', $city) }}">@csrf @method('PUT') @include('backend.city._form', ['city' => $city])</form>
</div></div>
@endsection
