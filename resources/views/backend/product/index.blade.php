@extends('backend.layouts.layout')
@section('title', 'All Products - Pound Store')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Manage Products</h4>
                <h6>Products shown on the website category pages</h6>
            </div>
            <div class="page-btn">
                <a href="{{ route('product.create') }}" class="btn btn-added"><img
                        src="{{ asset('backend/assets/img/icons/plus.svg') }}" alt="img">Add Product</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table datanew">
                        <thead>
                            <tr>
                                <th>
                                    <label class="checkboxs">
                                        <input type="checkbox" id="select-all-products" onclick="productSelectAll(this)">
                                        <span class="checkmarks"></span>
                                    </label>
                                </th>
                                <th>Image</th>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Price (PKR)</th>
                                <th>Tag</th>
                                <th>Featured</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                            <tr>
                                <td>
                                    <label class="checkboxs">
                                        <input type="checkbox" class="select-product" data-id="{{ $product->id }}"
                                            onchange="productToggleDelete()">
                                        <span class="checkmarks"></span>
                                    </label>
                                </td>
                                <td>
                                    <a href="javascript:void(0);" class="product-img">
                                        <img src="{{ $product->image_url ?? asset('backend/assets/img/noimage.png') }}"
                                            alt="{{ $product->name }}"
                                            style="width:60px; height:60px; border-radius:8px; object-fit:cover;">
                                    </a>
                                </td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category->name ?? 'Uncategorised' }}</td>
                                <td>{{ number_format($product->price, 0) }}</td>
                                <td>{{ $product->tag ?: '—' }}</td>
                                <td>
                                    @if ($product->is_featured)
                                    <span class="badge rounded-pill bg-success">Yes</span>
                                    @else
                                    <span class="badge rounded-pill bg-danger">No</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($product->status)
                                    <span class="badge rounded-pill bg-success">Active</span>
                                    @else
                                    <span class="badge rounded-pill bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('product.edit', $product->id) }}" class="me-3">
                                        <img src="{{ asset('backend/assets/img/icons/edit.svg') }}" alt="edit">
                                    </a>

                                    <form id="deleteProduct-{{ $product->id }}"
                                        action="{{ route('product.destroy', $product->id) }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                        @method('delete')
                                    </form>

                                    <a href="javascript:void(0);"
                                        onclick="if(confirm('Are you sure to permanently delete this product?')) { document.getElementById('deleteProduct-{{ $product->id }}').submit(); } return false;"
                                        class="me-3">
                                        <img src="{{ asset('backend/assets/img/icons/delete.svg') }}" alt="delete">
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <button id="delete-selected-products-btn" class="btn btn-danger mt-3" style="display: none;"
                    onclick="deleteSelectedProducts()">Delete Selected
                </button>

            </div>
        </div>

        <!-- Bulk Delete Form -->
        <form id="bulk-delete-products-form" action="{{ route('product.bulk-delete') }}" method="POST"
            style="display: none;">
            @csrf
            <input type="hidden" name="product_ids" id="product-ids">
        </form>

    </div>
</div>

<script>
    function productSelectAll(source) {
        document.querySelectorAll('.select-product').forEach(function (cb) { cb.checked = source.checked; });
        productToggleDelete();
    }

    function productToggleDelete() {
        var count = document.querySelectorAll('.select-product:checked').length;
        document.getElementById('delete-selected-products-btn').style.display = count ? 'inline-block' : 'none';
    }

    function deleteSelectedProducts() {
        var ids = Array.prototype.map.call(document.querySelectorAll('.select-product:checked'), function (cb) {
            return cb.getAttribute('data-id');
        });
        if (!ids.length) return;
        if (!confirm('Delete ' + ids.length + ' selected product(s)? This cannot be undone.')) return;
        document.getElementById('product-ids').value = ids.join(',');
        document.getElementById('bulk-delete-products-form').submit();
    }
</script>
@endsection
