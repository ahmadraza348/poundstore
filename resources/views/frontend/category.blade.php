@extends('frontend.layouts.app')

@section('title', $category['name'] . ' | Pound Store Pakistan')
@section('description', $category['description'] ?: 'Browse ' . $category['name'] . ' products at Pound Store Pakistan.')

@section('content')
<main id="main">
    <section class="page-hero">
        <div class="container-wide page-hero-grid">
            <div>
                <p class="eyebrow"><a href="{{ route('frontend.categories') }}" style="text-decoration:none;color:inherit">Product categories</a> &nbsp; / &nbsp; <span data-category-crumb>{{ $category['name'] }}</span></p>
                <h1 data-category-title>{{ $category['name'] }}</h1>
                <p class="lead" data-category-description>{{ $category['description'] ?: 'Browse products from this category.' }}</p><span class="page-hero-kicker"><i class="bi bi-box-seam" aria-hidden="true"></i> {{ $productTotal }} {{ $productTotal === 1 ? 'product' : 'products' }} · Availability varies by branch</span>
            </div><img class="page-hero-image category-hero-image" data-category-hero-image data-parallax src="{{ $category['image'] ?: asset('frontend/assets/images/hero-store.jpg') }}" alt="{{ $category['name'] }}" fetchpriority="high">
        </div>
    </section>
    <section class="section" id="products">
        <div class="container-wide">
            <div class="catalogue-toolbar">
                <div>
                    <p class="eyebrow">Browse products</p>
                    <h2 style="margin-bottom:5px">{{ $category['name'] }}</h2>
                    <p class="toolbar-count">{{ $products->total() }} {{ $products->total() === 1 ? 'item' : 'items' }}{{ $search !== '' ? ' matching “' . $search . '”' : '' }}</p>
                </div>
                <form class="catalogue-controls" method="GET" action="{{ url()->current() }}#products" role="search">
                    <div class="field catalogue-search"><label for="productSearch">Search this category</label><input id="productSearch" name="q" type="search" value="{{ $search }}" placeholder="Search products…"></div>
                    <div class="field catalogue-sort"><label for="productSort">Sort by</label><select id="productSort" name="sort" onchange="this.form.submit()">
                            <option value="featured" @selected($sort === 'featured')>Recommended</option>
                            <option value="name" @selected($sort === 'name')>Name A–Z</option>
                            <option value="price-low" @selected($sort === 'price-low')>Price: low to high</option>
                            <option value="price-high" @selected($sort === 'price-high')>Price: high to low</option>
                        </select></div>
                    <button class="btn btn-primary catalogue-submit" type="submit"><i class="bi bi-search" aria-hidden="true"></i> Search</button>
                </form>
            </div>
            @if ($products->count())
            <div class="product-grid" aria-live="polite">
                @foreach ($products as $product)
                @php
                    $price = (float) $product['price'];
                    $priceText = $price > 0 ? 'PKR ' . rtrim(rtrim(number_format($price, 2), '0'), '.') : 'Ask in store';
                @endphp
                <article class="product-card">
                    <div class="product-image"><img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" loading="lazy" decoding="async">@if ($product['tag'])<span class="product-badge">{{ $product['tag'] }}</span>@endif</div>
                    <div class="product-content">
                        <p class="product-category">{{ $product['category'] }}</p>
                        <h3>{{ $product['name'] }}</h3>
                        <div class="product-price-row">
                            <div class="product-price"><small>Price</small>{{ $priceText }}</div>
                            <a class="product-link" href="{{ route('frontend.outlets') }}">Find a branch <i class="bi bi-arrow-up-right" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
            {{ $products->links('frontend.partials.pagination', ['label' => 'products']) }}
            @else
            <div class="empty-products">
                <i class="bi bi-search" aria-hidden="true"></i>
                <h3>{{ $search !== '' ? 'No products match that search' : 'No products in this category yet' }}</h3>
                <p>{{ $search !== '' ? 'Try another keyword or clear the search field.' : 'Please check back soon or visit a store to see what is available.' }}</p>
                @if ($search !== '')<a class="btn btn-outline" href="{{ url()->current() }}#products">Clear search</a>@endif
            </div>
            @endif
        </div>
    </section>
    <section class="section section-soft">
        <div class="container-wide cta-band">
            <div>
                <h2>Found something you like?</h2>
                <p>Contact or visit a store to confirm current products, prices and availability.</p>
            </div><a href="{{ route('frontend.outlets') }}" class="btn btn-primary">Find a branch <i class="bi bi-arrow-up-right"></i></a>
        </div>
    </section>
</main>
@endsection
