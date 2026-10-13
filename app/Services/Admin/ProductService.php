<?php

namespace App\Services\Admin;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductService
{
    public function create(array $data): Product
    {
        return DB::transaction(function () use ($data) {

            $data['slug'] = $this->makeUniqueSlug($data['slug'] ?? null, $data['name']);

            if (!empty($data['image'])) {
                $data['image'] = $data['image']->store('images/products', 'public');
            }

            return Product::create($data);
        });
    }

    public function update(Product $product, array $data): Product
    {
        return DB::transaction(function () use ($product, $data) {

            // Blank slug on edit = keep the current one
            if (blank($data['slug'] ?? null)) {
                unset($data['slug']);
            }

            if (!empty($data['image'])) {
                $this->deleteImage($product->image);
                $data['image'] = $data['image']->store('images/products', 'public');
            } else {
                unset($data['image']); // keep existing image
            }

            $product->update($data);

            return $product;
        });
    }

    public function delete(Product $product): void
    {
        DB::transaction(function () use ($product) {
            $this->deleteImage($product->image);
            $product->delete();
        });
    }

    public function bulkDelete(array $productIds): void
    {
        DB::transaction(function () use ($productIds) {
            Product::whereIn('id', $productIds)->get()->each(function (Product $product) {
                $this->deleteImage($product->image);
                $product->delete();
            });
        });
    }

    /* ----------------------------------------------------------------- */

    private function deleteImage(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }

    /** Use the typed slug, or build one from the name, and make sure it is unique. */
    private function makeUniqueSlug(?string $slug, string $name): string
    {
        $base = Str::slug($slug ?: $name) ?: 'product';
        $candidate = $base;
        $i = 2;

        while (Product::where('slug', $candidate)->exists()) {
            $candidate = $base . '-' . $i++;
        }

        return $candidate;
    }
}
