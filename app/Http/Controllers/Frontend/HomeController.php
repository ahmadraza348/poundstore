<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\Frontend\CatalogueService;
use App\Services\Frontend\StoreLocatorService;

class HomeController extends Controller
{
    public function index(CatalogueService $catalogue, StoreLocatorService $stores)
    {
        return view('frontend.index', [
            'homeCategories'        => $catalogue->getHomeCategories(5),
            'frontendCityListings'  => $stores->getCities(),
            'frontendOutlets'       => $stores->getOutlets(),
        ]);
    }
}
