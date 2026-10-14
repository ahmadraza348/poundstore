<?php

namespace App\Services\Frontend;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

/**
 * Gets categories and products for the public website.
 * Only active records are returned.
 */
class CatalogueService
{
    /**
     * Categories for the home page.
     * Featured categories come first, then the newest active ones fill the rest.
     */
    public function getHomeCategories(int $limit = 5): array
    {
        $featured = Category::active()
            ->where('is_featured', true)
            ->ordered()
            ->limit($limit)
            ->get();

        $others = Category::active()
            ->whereNotIn('id', $featured->pluck('id'))
            ->latest('id')
            ->limit($limit - $featured->count())
            ->get();

        $categories = $featured->concat($others);
        $counts = $this->getProductCounts();

        return $categories->map(fn ($category) => $this->formatCategory($category, $counts))->all();
    }

    /**
     * All active categories for the "Categories" page.
     */
    public function getAllCategories(): array
    {
        $categories = Category::with('parent:id,name')->active()->ordered()->get();
        $counts = $this->getProductCounts();

        return $categories->map(fn ($category) => $this->formatCategory($category, $counts))->all();
    }

    /**
     * One category and its products. Returns null if the category
     * does not exist or is inactive.
     */
    public function getCategoryPage(string $slug): ?array
    {
        $category = Category::active()->where('slug', $slug)->first();

        if (!$category) {
            return null;
        }

        // Products of this category + products of its sub-categories
        $categoryIds = array_merge([$category->id], $this->getChildIds($category->id));

        $products = Product::with('category:id,name')
            ->active()
            ->whereIn('category_id', $categoryIds)
            ->orderByDesc('is_featured')
            ->latest('id')
            ->limit(1000)
            ->get();

        return [
            'category' => [
                'name'        => $category->name,
                'description' => $this->cleanText($category->description),
                'image'       => $category->image_url ?? asset('frontend/assets/images/placeholder.svg'),
            ],
            'products' => $products->map(fn ($product) => [
                'name'     => $product->name,
                'category' => $product->category->name ?? $category->name,
                'price'    => (float) $product->price,
                'tag'      => $product->tag,
                'image'    => $product->image_url ?? asset('frontend/assets/images/placeholder.svg'),
            ])->all(),
        ];
    }

    /* ---------------------------------------------------------------
     | Helpers
     * ------------------------------------------------------------- */

    private function formatCategory(Category $category, array $counts): array
    {
        return [
            'name'          => $category->name,
            'url'           => route('frontend.category', ['category' => $category->slug]),
            'description'   => Str::limit($this->cleanText($category->description), 110),
            'image'         => $category->image_url ?? asset('frontend/assets/images/placeholder.svg'),
            'parent'        => $category->parent->name ?? null,
            'product_count' => $counts[$category->id] ?? 0,
        ];
    }

    /**
     * Number of active products per category.
     * A parent category also counts the products of its sub-categories.
     */
    private function getProductCounts(): array
    {
        $ownCounts = Product::active()
            ->selectRaw('category_id, COUNT(*) as total')
            ->whereNotNull('category_id')
            ->groupBy('category_id')
            ->pluck('total', 'category_id');

        $counts = [];

        foreach (Category::active()->pluck('id') as $id) {
            $total = $ownCounts[$id] ?? 0;

            foreach ($this->getChildIds($id) as $childId) {
                $total += $ownCounts[$childId] ?? 0;
            }

            $counts[$id] = $total;
        }

        return $counts;
    }

    /**
     * IDs of all active sub-categories (children, grandchildren...).
     */
    private function getChildIds(int $parentId): array
    {
        $ids = [];
        $parents = [$parentId];

        while (!empty($parents)) {
            $children = Category::active()
                ->whereIn('parent_id', $parents)
                ->pluck('id')
                ->all();

            // Skip ids we already have (protects against bad data loops)
            $parents = array_diff($children, $ids, [$parentId]);
            $ids = array_merge($ids, $parents);
        }

        return $ids;
    }

    /**
     * Descriptions come from a text editor and may contain HTML.
     * The website only needs plain text.
     */
    private function cleanText(?string $html): string
    {
        $text = html_entity_decode(strip_tags((string) $html));

        return trim(preg_replace('/\s+/', ' ', $text));
    }
}
