<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\Frontend\CatalogueService;
use App\Services\Frontend\StoreLocatorService;

class PageController extends Controller
{
    public function categories(CatalogueService $catalogue)
    {
        return view('frontend.categories', [
            'categories' => $catalogue->getAllCategories(),
        ]);
    }

    public function category(CatalogueService $catalogue, string $category)
    {
        $page = $catalogue->getCategoryPage($category);

        // Category not found or inactive -> 404 page
        abort_if($page === null, 404);

        return view('frontend.category', $page);
    }

    public function outlets(StoreLocatorService $stores)
    {
        return view('frontend.outlets', [
            'frontendCityListings' => $stores->getCities(),
            'frontendOutlets'      => $stores->getOutlets(),
        ]);
    }

    public function about()
    {
        return view('frontend.about');
    }

    public function franchise()
    {
        return view('frontend.franchise');
    }

    public function sourcing()
    {
        return view('frontend.sourcing');
    }

    public function faq()
    {
        return view('frontend.faq');
    }

    public function contact()
    {
        return view('frontend.contact');
    }
}
