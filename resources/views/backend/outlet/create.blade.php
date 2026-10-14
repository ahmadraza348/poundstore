@extends('backend.layouts.layout')
@section('title', 'Add Outlet - Pound Store')
@section('content')
<div class="page-wrapper"><div class="content">
    <div class="page-header"><div class="page-title"><h4>Add Outlet</h4><h6>Create one record for every physical branch. Multiple outlets may belong to the same city.</h6></div></div>
    <form method="POST" action="{{ route('outlet.store') }}" enctype="multipart/form-data">@csrf @include('backend.outlet._form', ['outlet' => null])</form>
</div></div>
@endsection
