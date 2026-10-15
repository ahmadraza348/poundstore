@extends('frontend.layouts.app')

@section('title', 'Product Categories | Pound Store Pakistan')

@section('content')
<main id="main">
<section class="page-hero"><div class="container-wide page-hero-grid"><div><p class="eyebrow">What we sell</p><h1>A broad mix for <span class="highlight">everyday life.</span></h1><p class="lead">From home and kitchen essentials to stationery, toys, gifts and personal-care categories, explore the product areas available at Pound Store Pakistan.</p><span class="page-hero-kicker"><i class="bi bi-info-circle" aria-hidden="true"></i> Product availability can vary by branch</span></div><img class="page-hero-image" data-parallax src="https://images.unsplash.com/photo-1555529669-e69e7aa0ba9a?auto=format&fit=crop&w=1000&q=82" alt="Organised displays in a retail store" loading="eager"></div></section>
<section class="section" id="categories"><div class="container-wide"><div class="section-heading"><p class="eyebrow">Shop by category</p><h2>Find your kind of <span class="highlight">everyday useful.</span></h2><p>Choose a category to browse its products. Prices and availability can vary by branch, so please confirm with your nearest store.</p></div>@if ($categories->count())
<div class="category-grid" aria-label="Product categories">
@foreach ($categories as $category)
<a class="category-card" href="{{ $category['url'] }}"><div class="category-photo"><img src="{{ $category['image'] }}" alt="{{ $category['name'] }}" loading="lazy" decoding="async"><span class="category-photo-label">{{ $category['parent'] ?? ($category['product_count'] . ($category['product_count'] === 1 ? ' product' : ' products')) }}</span></div><div class="category-body"><h3>{{ $category['name'] }}</h3><p>{{ $category['description'] ?: 'Browse ' . $category['name'] . ' products.' }}</p><div class="category-foot"><span>View products ({{ $category['product_count'] }})</span><i class="bi bi-arrow-up-right" aria-hidden="true"></i></div></div></a>
@endforeach
</div>
{{ $categories->links('frontend.partials.pagination', ['label' => 'categories']) }}
@else
<p>No categories have been published yet. Please check back soon.</p>
@endif
</div></section>
<section class="section section-soft"><div class="container-wide cta-band"><div><h2>Prefer to explore in person?</h2><p>Use the branch directory to browse published city and area listings before visiting a location.</p></div><a href="{{ route('frontend.outlets') }}" class="btn btn-primary">Find a branch <i class="bi bi-geo-alt"></i></a></div></section>
</main>
@endsection
