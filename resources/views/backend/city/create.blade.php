@extends('backend.layouts.layout')
@section('title', 'Add City - Pound Store')
@section('content')
<div class="page-wrapper"><div class="content">
    <div class="page-header"><div class="page-title"><h4>Add City / Area</h4><h6>Create this record before assigning branches to it.</h6></div></div>
    <form method="POST" action="{{ route('city.store') }}">@csrf @include('backend.city._form', ['city' => null])</form>
</div></div>
@endsection
