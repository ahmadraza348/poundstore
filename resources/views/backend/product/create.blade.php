@extends('backend.layouts.layout')
@section('title', 'Create Product - Pound Store')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Products</h4>
                    <h6>Add New Product</h6>
                </div>
            </div>

            <form method="post" action="{{ route('product.store') }}" enctype="multipart/form-data">
                @csrf
                @include('backend.product._form', ['product' => null])
            </form>
        </div>
    </div>
@endsection
