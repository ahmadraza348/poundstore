<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function categories()
    {
        return view('frontend.categories');
    }

    public function category()
    {
        return view('frontend.category');
    }

    public function outlets()
    {
        return view('frontend.outlets');
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
