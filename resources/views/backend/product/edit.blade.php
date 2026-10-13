@extends('backend.layouts.layout')
@section('title', 'Edit Product - Pound Store')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Products</h4>
                    <h6>Edit Product</h6>
                </div>
            </div>

            <form method="post" action="{{ route('product.update', $product->id) }}" enctype="multipart/form-data">
                @csrf
                @include('backend.product._form', ['product' => $product])
            </form>
        </div>
    </div>
@endsection
