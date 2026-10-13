<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\{StoreProductRequest, UpdateProductRequest, BulkDeleteProductRequest};
use App\Models\Category;
use App\Models\Product;
use App\Services\Admin\ProductService;

class ProductController extends Controller
{
    protected ProductService $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $data['products'] = Product::with('category')->latest()->get();
        return view('backend.product.index', $data);
    }

    public function create()
    {
        $categories = Category::with('parent')->active()->ordered()->get();
        return view('backend.product.create', compact('categories'));
    }

    public function store(StoreProductRequest $request)
    {
        $this->service->create($request->validated());
        toastr()->success('Product created successfully');
        return redirect()->route('product.index');
    }

    public function edit(Product $product)
    {
        // Active categories + the product's current one (even if it was blocked later)
        $categories = Category::with('parent')
            ->where(fn ($q) => $q->where('status', 1)->orWhere('id', $product->category_id))
            ->ordered()
            ->get();

        return view('backend.product.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->service->update($product, $request->validated());
        toastr()->success('Product updated successfully');
        return redirect()->route('product.index');
    }

    public function destroy(Product $product)
    {
        $this->service->delete($product);
        toastr()->success('Product deleted successfully');
        return back();
    }

    public function bulkDelete(BulkDeleteProductRequest $request)
    {
        $this->service->bulkDelete($request->getProductIds());
        toastr()->success('Products deleted successfully');
        return back();
    }
}
