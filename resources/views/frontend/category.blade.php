@extends('frontend.layouts.app')

@section('content')
<main id="main">
    <section class="page-hero">
        <div class="container-wide page-hero-grid">
            <div>
                <p class="eyebrow"><a href="{{ route('frontend.categories') }}" style="text-decoration:none;color:inherit">Product categories</a> &nbsp; / &nbsp; <span data-category-crumb>Home & Kitchen</span></p>
                <h1 data-category-title>Home & Kitchen</h1>
                <p class="lead" data-category-description>Browse sample products from this category.</p><span class="page-hero-kicker"><i class="bi bi-database" aria-hidden="true"></i> Static demo data · Not live stock</span>
            </div><img class="page-hero-image category-hero-image" data-category-hero-image data-parallax src="https://images.unsplash.com/photo-1556911220-e15b29be8c8f?auto=format&fit=crop&w=1000&q=82" alt="Representative Home and Kitchen category photography" fetchpriority="high">
        </div>
    </section>
    <section class="section">
        <div class="container-wide">
            <div class="catalogue-toolbar">
                <div>
                    <p class="eyebrow">Browse products</p>
                    <h2 style="margin-bottom:5px">Sample catalogue</h2>
                    <p data-product-count class="toolbar-count">4 demo items</p>
                </div>
                <div class="catalogue-controls">
                    <div class="field"><label for="productSearch">Search this category</label><input id="productSearch" data-product-search type="search" placeholder="Search sample products…"></div>
                    <div class="field"><label for="productSort">Sort by</label><select id="productSort" data-product-sort>
                            <option value="featured">Recommended</option>
                            <option value="name">Name A–Z</option>
                            <option value="price-low">Price: low to high</option>
                            <option value="price-high">Price: high to low</option>
                        </select></div>
                </div>
            </div>
            <div class="product-grid " data-product-grid aria-live="polite"></div>
            <nav class="animated-pagination" data-product-pagination aria-label="Product list pages" hidden></nav>           
        </div>
    </section>
    <section class="section section-soft">
        <div class="container-wide cta-band">
            <div>
                <h2>Found something you like?</h2>
                <p>Contact or visit a store to confirm current products, prices and availability.</p>
            </div><a href="{{ route('frontend.outlets') }}" class="btn btn-primary">Find a store <i class="bi bi-arrow-up-right"></i></a>
        </div>
    </section>
</main>
@endsection