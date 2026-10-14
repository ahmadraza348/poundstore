@extends('backend.layouts.layout')
@section('title', 'Edit Outlet - Pound Store')
@section('content')
<div class="page-wrapper"><div class="content">
    <div class="page-header"><div class="page-title"><h4>Edit Outlet</h4><h6>Update this branch's contact details, hours, location and publication status.</h6></div></div>
    <form method="POST" action="{{ route('outlet.update', $outlet) }}" enctype="multipart/form-data">@csrf @method('PUT') @include('backend.outlet._form', ['outlet' => $outlet])</form>
</div></div>
@endsection
