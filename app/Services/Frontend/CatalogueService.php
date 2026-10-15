<?php

namespace App\Services\Frontend;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
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
     * Active categories for the "Categories" page, 8 per page.
     */
    public function getAllCategories(int $perPage = 8): LengthAwarePaginator
    {
        $categories = Category::with('parent:id,name')
            ->active()
            ->ordered()
            ->paginate($perPage)
            ->withQueryString()
            ->fragment('categories');

        $counts = $this->getProductCounts();

        return $categories->through(fn ($category) => $this->formatCategory($category, $counts));
    }

    /**
     * One category and its products (8 per page, with search + sort).
     * Returns null if the category does not exist or is inactive.
     */
    public function getCategoryPage(string $slug, string $search = '', string $sort = 'featured', int $perPage = 8): ?array
    {
        $category = Category::active()->where('slug', $slug)->first();

        if (!$category) {
            return null;
        }

        // Products of this category + products of its sub-categories
        $categoryIds = array_merge([$category->id], $this->getChildIds($category->id));

        $base = Product::active()->whereIn('category_id', $categoryIds);
        $productTotal = (clone $base)->count();

        $query = (clone $base)->with('category:id,name');

        $search = trim($search);
        if ($search !== '') {
            $like = '%' . addcslashes($search, '%_\\') . '%';
            $query->where(fn ($q) => $q->where('name', 'like', $like)->orWhere('tag', 'like', $like));
        }

        match ($sort) {
            'name'       => $query->orderBy('name'),
            'price-low'  => $query->orderBy('price')->orderBy('name'),
            'price-high' => $query->orderByDesc('price')->orderBy('name'),
            default      => $query->orderByDesc('is_featured')->orderByDesc('id'),
        };

        $products = $query->paginate($perPage)
            ->withQueryString()
            ->fragment('products')
            ->through(fn ($product) => [
                'name'     => $product->name,
                'category' => $product->category->name ?? $category->name,
                'price'    => (float) $product->price,
                'tag'      => $product->tag,
                'image'    => $product->image_url ?? asset('frontend/assets/images/hero-store.jpg'),
            ]);

        return [
            'category' => [
                'name'        => $category->name,
                'description' => $this->cleanText($category->description),
                'image'       => $category->image_url ?? asset('frontend/assets/images/hero-store.jpg'),
            ],
            'products'     => $products,
            'productTotal' => $productTotal,
            'search'       => $search,
            'sort'         => in_array($sort, ['name', 'price-low', 'price-high'], true) ? $sort : 'featured',
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
            'image'         => $category->image_url ?? asset('frontend/assets/images/hero-store.jpg'),
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
