@extends('frontend.layouts.app')

@section('title', 'Find a Store | Pound Store Pakistan')
@section('description', 'Find active Pound Store Pakistan outlets by city, area, opening hours, contact details and branch directions.')

@section('content')
@php
    $activeOutlets = $frontendOutlets ?? [];
    $activeCities = $frontendCityListings ?? [];
    $activeOutletCount = count($activeOutlets);
    $activeCityCount = count($activeCities);
@endphp
<main id="main">
  <section class="page-hero">
    <div class="container-wide page-hero-grid">
      <div>
        <p class="eyebrow">Our network</p>
        <h1>Find a Pound Store <span class="highlight">location.</span></h1>
        <p class="lead">Browse active outlets, search by city or area, check branch contact information and open directions for the location you plan to visit.</p>
        <span class="page-hero-kicker"><i class="bi bi-geo-alt" aria-hidden="true"></i> {{ $activeOutletCount }} active {{ $activeOutletCount === 1 ? 'outlet' : 'outlets' }} · {{ $activeCityCount }} {{ $activeCityCount === 1 ? 'city' : 'cities' }}</span>
      </div>
      <img class="page-hero-image" data-parallax src="https://images.unsplash.com/photo-1604719312566-8912e9c8a213?auto=format&fit=crop&w=1000&q=82" alt="Products displayed inside a retail store" loading="eager">
    </div>
  </section>

  <section class="section">
    <div class="container-wide">
      <div class="section-heading">
        <p class="eyebrow">Explore by city</p>
        <h2>Find your closest <span class="highlight">store.</span></h2>
        <p>The map groups branches by city. The pins represent the city-centre coordinates entered in the admin panel, not a promise of the exact shop entrance. Use each outlet's directions link for branch-level navigation.</p>
      </div>
      <div class="map-layout">
        <div class="map-panel">
          <div class="map-panel-head"><strong><i class="bi bi-map" aria-hidden="true"></i> City / area map</strong><span data-map-status>Loading outlet locations…</span></div>
          <div id="branchMap" class="network-map" role="application" aria-label="Interactive map of cities with active Pound Store outlets"></div>
          <div class="map-note"><strong>Location accuracy:</strong> city markers use city-centre coordinates. Individual outlet records can include a Google Maps URL or verified branch coordinates for directions.</div>
        </div>
        <aside class="map-results">
          <div class="map-controls">
            <div class="field"><label for="citySearch">Search city or area</label><input type="search" id="citySearch" data-city-search placeholder="e.g. Gujranwala, Sialkot" autocomplete="off"></div>
            <p data-city-total class="map-note" style="margin:0">{{ $activeCityCount }} cities with active outlets</p>
          </div>
          <div class="city-list" data-city-list aria-live="polite"></div>
        </aside>
      </div>
    </div>
  </section>

  <section class="section section-soft outlet-directory" id="outlet-directory" data-outlet-directory aria-labelledby="outletDirectoryTitle">
    <div class="container-wide">
      <div class="section-heading split outlet-directory-heading">
        <div><p class="eyebrow">Outlet directory</p><h2 id="outletDirectoryTitle">Your next stop is <span class="highlight">closer than you think.</span></h2><p>Every card represents an individual outlet managed through the admin panel. A city can have any number of branches.</p></div>
        <span class="directory-total-pill"><i class="bi bi-shop" aria-hidden="true"></i> <strong data-outlet-result-count>{{ $activeOutletCount }}</strong> active {{ $activeOutletCount === 1 ? 'outlet' : 'outlets' }}</span>
      </div>
      <div class="outlet-directory-toolbar">
        <div class="field outlet-search-field"><label for="outletSearch">Find a branch</label><div class="outlet-search-wrap"><i class="bi bi-search" aria-hidden="true"></i><input type="search" id="outletSearch" data-outlet-search placeholder="Try an outlet name, city or neighbourhood" autocomplete="off"></div></div>
        <div class="field outlet-sort-field"><label for="outletSort">Sort outlets</label><select id="outletSort" data-outlet-sort><option value="popular">Featured first</option><option value="az">Outlet name A–Z</option><option value="za">Outlet name Z–A</option></select></div>
      </div>
      <div class="outlet-grid" data-outlet-grid aria-live="polite" aria-busy="false"></div>
      <div class="outlet-load-more-wrap"><p data-outlet-pagination-status aria-live="polite">Showing active outlets</p><button class="btn btn-outline outlet-load-more" type="button" data-outlet-load-more>Show more outlets <i class="bi bi-arrow-down-circle" aria-hidden="true"></i></button></div>
      <p class="outlet-directory-note"><i class="bi bi-info-circle" aria-hidden="true"></i> <span>Outlet information is maintained by Pound Store administrators. Please check the listed phone number or contact the team if you need to confirm a branch's current hours before travelling.</span></p>
    </div>
  </section>

  <section class="section section-soft"><div class="container-wide cta-band"><div><h2>Need help finding a branch?</h2><p>Send the team your city or area and ask them to confirm the closest location.</p></div><a href="{{ route('frontend.contact') }}" class="btn btn-primary"><i class="bi bi-chat-dots" aria-hidden="true"></i> Contact Pound Store</a></div></section>
</main>
@endsection
