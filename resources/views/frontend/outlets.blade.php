@extends('frontend.layouts.app')

@section('title', 'Find a Branch | Pound Store Pakistan')
@section('description', 'Find active Pound Store Pakistan branches by city, area, contact details and directions.')

@section('content')
@php
    $activeOutlets = $frontendOutlets ?? [];
    $activeCities = $frontendCityListings ?? [];
    $activeOutletCount = count($activeOutlets);
    $activeCityCount = count($activeCities);
@endphp
<main id="main">
  <section class="page-hero">
    <div class="container-wide page-hero-grid page-hero-grid--no-image">
      <div>
        <p class="eyebrow">Our network</p>
        <h1>Find your nearest Pound Store <span class="highlight">branch.</span></h1>
        <p class="lead">Browse branches by city or area, check contact information and open directions for the location you plan to visit.</p>
        <span class="page-hero-kicker"><i class="bi bi-geo-alt" aria-hidden="true"></i> {{ $activeOutletCount }} active {{ $activeOutletCount === 1 ? 'branch' : 'branches' }} · {{ $activeCityCount }} {{ $activeCityCount === 1 ? 'city' : 'cities' }}</span>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="container-wide">
      <div class="section-heading">
        <p class="eyebrow">Explore by city</p>
        <h2>Find your closest <span class="highlight">branch.</span></h2>
        <p>Choose a city to show saved branch pins on the map. Select a pin to see the address and open directions; branches without saved coordinates remain available in the directory below.</p>
      </div>
      <div class="map-layout">
        <div class="map-panel">
          <div class="map-panel-head"><strong><i class="bi bi-map" aria-hidden="true"></i> Branch location map</strong><span data-map-status>Loading branch locations…</span></div>
          <div id="branchMap" class="network-map" role="application" aria-label="Interactive map of active Pound Store branches"></div>
        </div>
        <aside class="map-results">
          <div class="map-controls">
            <div class="field"><label for="citySearch">Search city or area</label><input type="search" id="citySearch" data-city-search placeholder="e.g. Gujranwala, Sialkot" autocomplete="off"></div>
            <p data-city-total class="map-note" style="margin:0">{{ $activeCityCount }} cities with active branches</p>
          </div>
          <div class="city-list" data-city-list aria-live="polite"></div>
        </aside>
      </div>
    </div>
  </section>

  <section class="section section-soft outlet-directory" id="outlet-directory" data-outlet-directory aria-labelledby="outletDirectoryTitle">
    <div class="container-wide">
      <div class="section-heading split outlet-directory-heading">
        <div><p class="eyebrow">Branch directory</p><h2 id="outletDirectoryTitle">Your next stop is <span class="highlight">closer than you think.</span></h2><p>Each card represents an active branch managed through the admin panel.</p></div>
        <span class="directory-total-pill"><i class="bi bi-shop" aria-hidden="true"></i> <strong data-outlet-result-count>{{ $activeOutletCount }}</strong> active {{ $activeOutletCount === 1 ? 'branch' : 'branches' }}</span>
      </div>
      <div class="outlet-directory-toolbar">
        <div class="field outlet-search-field"><label for="outletSearch">Find a branch</label><div class="outlet-search-wrap"><i class="bi bi-search" aria-hidden="true"></i><input type="search" id="outletSearch" data-outlet-search placeholder="Try a branch name, city or neighbourhood" autocomplete="off"></div></div>
        <div class="field outlet-sort-field"><label for="outletSort">Sort branches</label><select id="outletSort" data-outlet-sort><option value="popular">Default order</option><option value="az">Branch name A–Z</option><option value="za">Branch name Z–A</option></select></div>
      </div>
      <div class="outlet-grid" data-outlet-grid aria-live="polite" aria-busy="false"></div>
      <div class="outlet-load-more-wrap"><p data-outlet-pagination-status aria-live="polite">Showing active branches</p><button class="btn btn-outline outlet-load-more" type="button" data-outlet-load-more>Show more branches <i class="bi bi-arrow-down-circle" aria-hidden="true"></i></button></div>
    </div>
  </section>

  <section class="section section-soft"><div class="container-wide cta-band"><div><h2>Need help finding a branch?</h2><p>Send the team your city or area and ask them to confirm the closest location.</p></div><a href="{{ route('frontend.contact') }}" class="btn btn-primary"><i class="bi bi-chat-dots" aria-hidden="true"></i> Contact Pound Store</a></div></section>
</main>
@endsection
