@extends('frontend.layouts.app')
@php
    $activeOutletCount = count($frontendOutlets ?? []);
    $activeCityCount = count($frontendCityListings ?? []);
@endphp
@section('content')
 <main id="main">
    <section class="hx" id="hero" aria-labelledby="heroTitle">
      <div class="hx-media" aria-hidden="true">
        <div class="hx-layer" data-hero-parallax>
          <!-- Poster image is a representative stock photo, not a real Pound Store outlet. Replace with approved brand photography. -->
          <img class="hx-poster"
            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRfLoUOdPu3FAZ_qaELx5m8B1xe5heNHAR6XmJEsAet9T2Vzy_dl9jiP6a5&s=10"
            alt="" fetchpriority="high" decoding="async" width="1800" height="1200">
          <!-- Replace assets/video/pound-store-hero.mp4 with approved brand footage (see assets/video/README.txt). -->
          <video class="hx-video" data-hero-video autoplay muted loop playsinline preload="metadata"
            poster="{{ asset('frontend/assets/images/herobanner.jpg') }}">
            <source src="{{ asset('frontend/assets/video/bannervideo.mp4#t=5') }}" type="video/mp4">
          </video>
        </div>
        <div class="hx-shade"></div>
        <!-- <span class="hx-shape hx-shape-a"></span><span class="hx-shape hx-shape-b"></span> -->
      </div>
      <!-- <div class="hx-floats" aria-hidden="true"><span class="hx-chip c3"><i class="bi bi-gift"></i></span><span class="hx-chip c4"><i class="bi bi-pencil"></i></span><span class="hx-chip c5"><i class="bi bi-cup-hot"></i></span></div> -->
      <div class="container-wide hx-content">
        <p class="hx-eyebrow hx-in" style="--i:0">Value retail across Pakistan, since 2017</p>
        <h1 id="heroTitle"><span class="hx-line"><span class="hx-in" style="--i:1">Everyday finds.</span></span><span
            class="hx-line"><span class="hx-in hx-yellow" style="--i:2">Prices that make sense.</span></span></h1>
        <p class="hx-lead hx-in" style="--i:3">Crockery, stationery, gifts, toys, perfumes and home essentials, all
          under one roof at Pound Store Pakistan.</p>
        <div class="hx-actions hx-in" style="--i:4"><a class="btn btn-yellow btn-lg" data-magnetic
            href="{{ route('frontend.outlets') }}"><i class="bi bi-geo-alt-fill" aria-hidden="true"></i> Find a Store</a><a
            class="btn btn-light btn-lg" data-magnetic href="{{ route('frontend.categories') }}">Explore Categories <i
              class="bi bi-arrow-right" aria-hidden="true"></i></a><a class="hx-link" href="{{ route('frontend.franchise') }}">Open a
            Franchise <i class="bi bi-arrow-up-right" aria-hidden="true"></i></a></div>
      </div>
      <a class="hx-scroll" href="#proof" aria-label="Scroll to the next section"><span></span></a>
    </section>

    <section class="proof" id="proof" aria-label="Pound Store at a glance">
      <div class="container-wide proof-grid">
        <div class="proof-item" data-reveal><i class="bi bi-calendar2-check" aria-hidden="true"></i>
          <div><strong>2017</strong><span>Founded</span></div>
        </div>
        <div class="proof-item" data-reveal style="--reveal-delay:70ms"><i class="bi bi-shop" aria-hidden="true"></i>
          <div><strong data-counter="{{ $activeOutletCount }}">{{ $activeOutletCount }}</strong><span>Active outlets</span></div>
        </div>
        <div class="proof-item" data-reveal style="--reveal-delay:140ms"><i class="bi bi-pin-map"
            aria-hidden="true"></i>
          <div><strong data-counter="{{ $activeCityCount }}">{{ $activeCityCount }}</strong><span>Cities with active outlets</span></div>
        </div>
        <div class="proof-item" data-reveal style="--reveal-delay:210ms"><i class="bi bi-box-seam"
            aria-hidden="true"></i>
          <div><strong>Find a store</strong><span>Across our network</span></div>
        </div>
      </div>
    </section>

    <section class="section cats" aria-labelledby="catsTitle">
      <div class="container-wide">
        <div class="sec-head" data-reveal>
          <div>
            <h2 id="catsTitle">Find your kind of everyday useful.</h2>
            <p>Pick a category to browse our products. Availability and prices can vary by outlet.</p>
          </div><a class="btn btn-outline" href="{{ route('frontend.categories') }}">All categories <i class="bi bi-arrow-up-right"
              aria-hidden="true"></i></a>
        </div>
        <div class="cat-grid">
          @forelse ($homeCategories as $category)
            <a class="cat-tile {{ $loop->first ? 'cat-lg' : '' }}" data-reveal style="--reveal-delay:{{ $loop->index * 80 }}ms" href="{{ $category['url'] }}"><img
                src="{{ $category['image'] }}"
                alt="{{ $category['name'] }}" loading="lazy" decoding="async"
                width="700" height="700"><span class="cat-tile-body"><strong>{{ $category['name'] }}</strong><span>{{ $category['description'] ?: 'Browse ' . $category['name'] }}</span></span><span class="cat-tile-go" aria-hidden="true"><i
                  class="bi bi-arrow-up-right"></i></span></a>
          @empty
            <p>Categories will appear here soon.</p>
          @endforelse
        </div>
      </div>
    </section>

    <section class="section netmap" id="network" aria-labelledby="mapTitle">
      <div class="container-wide">
        <div class="netmap-grid">
          <div class="netmap-copy" data-reveal>
            <h2 id="mapTitle">A network that keeps growing across Pakistan.</h2>
            <p>{{ $activeOutletCount }} active {{ $activeOutletCount === 1 ? 'outlet' : 'outlets' }} across {{ $activeCityCount }} {{ $activeCityCount === 1 ? 'city' : 'cities' }} are currently published from the admin panel. Choose a city to see its outlet count.</p>
            <div class="netmap-card" data-map-card aria-live="polite">
              <p class="netmap-card-kicker">Selected area</p>
              <h3 data-map-city>{{ $frontendCityListings[0]['city'] ?? 'No active cities yet' }}</h3>
              <p><strong data-map-count>{{ $frontendCityListings[0]['count'] ?? 0 }}</strong> <span data-map-count-label>active outlets in this city</span></p>
              <small>Markers show approximate city or area centres, not exact storefronts. Confirm a branch address by
                phone before you travel.</small>
            </div>
            <ul class="city-chips" data-city-chips aria-label="Cities with active Pound Store outlets"></ul>
            <a class="btn btn-primary" href="{{ route('frontend.outlets') }}">Explore All Locations <i class="bi bi-arrow-up-right"
                aria-hidden="true"></i></a>
          </div>
          <div class="netmap-frame" data-reveal style="--reveal-delay:120ms">
            <div class="map-fallback" data-map-fallback><i class="bi bi-map" aria-hidden="true"></i>
              <p>The interactive map needs an internet connection. Use the city list or <a href="{{ route('frontend.outlets') }}">browse
                  every location</a>.</p>
            </div>
            <div id="homeMap" class="netmap-canvas" role="application"
              aria-label="Map of approximate Pound Store city and area coverage across Pakistan"></div>
            <p class="netmap-note"><i class="bi bi-info-circle" aria-hidden="true"></i> City-centre coordinates are maintained in the admin panel; they are not exact branch entrance pins.</p>
          </div>
        </div>
      </div>
    </section>

    <section class="section story" id="sourcing-story" aria-labelledby="storyTitle" data-story>
      <div class="story-bg" aria-hidden="true">
        <div class="story-bg-img" data-parallax="0.09"
          style="background-image:url('https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=1800&q=80')">
        </div>
      </div>
      <div class="container-wide">
        <div class="sec-head sec-head-light" data-reveal>
          <div>
            <h2 id="storyTitle">From source to your local shelf.</h2>
            <p>Follow the published supply journey. Photography here is representative stock imagery, to be replaced by
              approved warehouse and store media.</p>
          </div><a class="btn btn-yellow" href="{{ route('frontend.sourcing') }}">Full sourcing story <i class="bi bi-arrow-up-right"
              aria-hidden="true"></i></a>
        </div>
        <div class="journey journey--dark" data-journey>
          <ol class="journey-list"><span class="journey-line" aria-hidden="true"><i></i></span>
            <li class="journey-step" data-journey-step><span class="journey-marker"><span>1</span></span>
              <div class="journey-card"><span class="journey-icon"><i class="bi bi-globe-asia-australia"
                    aria-hidden="true"></i></span>
                <div>
                  <h3>Direct sourcing</h3>
                  <p>Stock is bought at source in volume, which the company says keeps extra layers out of the chain.
                  </p>
                </div>
              </div>
            </li>
            <li class="journey-step" data-journey-step><span class="journey-marker"><span>2</span></span>
              <div class="journey-card"><span class="journey-icon"><i class="bi bi-patch-check"
                    aria-hidden="true"></i></span>
                <div>
                  <h3>Quality checks</h3>
                  <p>Consignments are checked before they enter the Pound Store network.</p>
                </div>
              </div>
            </li>
            <li class="journey-step" data-journey-step><span class="journey-marker"><span>3</span></span>
              <div class="journey-card"><span class="journey-icon"><i class="bi bi-building"
                    aria-hidden="true"></i></span>
                <div>
                  <h3>Gujranwala warehouse</h3>
                  <p>The central warehouse in Gujranwala is the stock and supply point for the network.</p>
                </div>
              </div>
            </li>
            <li class="journey-step" data-journey-step><span class="journey-marker"><span>4</span></span>
              <div class="journey-card"><span class="journey-icon"><i class="bi bi-truck" aria-hidden="true"></i></span>
                <div>
                  <h3>Distribution</h3>
                  <p>A distribution network supports replenishment across retail locations.</p>
                </div>
              </div>
            </li>
            <li class="journey-step" data-journey-step><span class="journey-marker"><span>5</span></span>
              <div class="journey-card"><span class="journey-icon"><i class="bi bi-shop-window"
                    aria-hidden="true"></i></span>
                <div>
                  <h3>Local stores</h3>
                  <p>Stores serve their own communities, a familiar place to discover everyday finds.</p>
                </div>
              </div>
            </li>
          </ol>
          <div class="journey-stage" aria-hidden="true">
            <div class="journey-slide" data-journey-slide><span class="slide-no" aria-hidden="true">01</span><span
                class="slide-icon"><i class="bi bi-globe-asia-australia" aria-hidden="true"></i></span>
              <p class="slide-count">Stage 1 of 5</p>
              <h3>Direct sourcing</h3>
            </div>
            <div class="journey-slide" data-journey-slide><span class="slide-no" aria-hidden="true">02</span><span
                class="slide-icon"><i class="bi bi-patch-check" aria-hidden="true"></i></span>
              <p class="slide-count">Stage 2 of 5</p>
              <h3>Quality checks</h3>
            </div>
            <div class="journey-slide" data-journey-slide><span class="slide-no" aria-hidden="true">03</span><span
                class="slide-icon"><i class="bi bi-building" aria-hidden="true"></i></span>
              <p class="slide-count">Stage 3 of 5</p>
              <h3>Gujranwala warehouse</h3>
            </div>
            <div class="journey-slide" data-journey-slide><span class="slide-no" aria-hidden="true">04</span><span
                class="slide-icon"><i class="bi bi-truck" aria-hidden="true"></i></span>
              <p class="slide-count">Stage 4 of 5</p>
              <h3>Distribution</h3>
            </div>
            <div class="journey-slide" data-journey-slide><span class="slide-no" aria-hidden="true">05</span><span
                class="slide-icon"><i class="bi bi-shop-window" aria-hidden="true"></i></span>
              <p class="slide-count">Stage 5 of 5</p>
              <h3>Local stores</h3>
            </div><span class="journey-meter"><i></i></span>
          </div>
        </div>
      </div>
    </section>

    <section class="section fr" aria-labelledby="frTitle">
      <div class="container-wide fr-grid">
        <div class="fr-copy" data-reveal>
          <h2 id="frTitle">Open a Pound Store in your city.</h2>
          <p>The company describes support across sourcing, setup, branding and territory. Talk to the franchise team
            about current requirements for your area. No profit or return is promised or implied.</p>
          <div class="fr-actions"><a class="btn btn-primary btn-lg" data-magnetic href="">Start an
              enquiry <i class="bi bi-arrow-up-right" aria-hidden="true"></i></a><a class="text-link"
              href="">See the six-step process <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
          </div>
        </div>
        <div class="franchise-slider" data-franchise-slider aria-roledescription="carousel"
          aria-label="Franchise support areas" data-reveal style="--reveal-delay:120ms">
          <div class="franchise-slider-viewport">
            <div class="franchise-slider-track" data-slider-track>
              <article class="franchise-slide is-active" data-franchise-slide aria-label="Slide 1 of 4">
                <div class="franchise-slide-image"><img
                    src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=1000&q=80"
                    alt="Representative stock photo of organised warehouse shelves" loading="lazy"
                    decoding="async"><span class="slide-image-label"><i class="bi bi-box-seam" aria-hidden="true"></i>
                    Supply</span></div>
                <div class="franchise-slide-copy"><span class="slide-kicker">01 · Sourcing & warehouse supply</span>
                  <h3>Stock that keeps moving.</h3>
                  <p>The published model links volume-led sourcing with central warehouse supply for a broad everyday
                    range.</p>
                  <ul>
                    <li><i class="bi bi-check2-circle" aria-hidden="true"></i> Central warehouse supply approach</li>
                    <li><i class="bi bi-check2-circle" aria-hidden="true"></i> Everyday multi-category assortment</li>
                  </ul>
                </div>
              </article>
              <article class="franchise-slide" data-franchise-slide aria-label="Slide 2 of 4" aria-hidden="true">
                <div class="franchise-slide-image"><img
                    src="https://images.unsplash.com/photo-1555529669-e69e7aa0ba9a?auto=format&fit=crop&w=1000&q=80"
                    alt="Representative stock photo of a tidy retail store floor" loading="lazy" decoding="async"><span
                    class="slide-image-label"><i class="bi bi-wrench-adjustable" aria-hidden="true"></i> Setup</span>
                </div>
                <div class="franchise-slide-copy"><span class="slide-kicker">02 · Setup & training</span>
                  <h3>From empty shop to opening day.</h3>
                  <p>Support areas include layout and merchandising guidance, staff training and launch preparation.</p>
                  <ul>
                    <li><i class="bi bi-check2-circle" aria-hidden="true"></i> Layout and merchandising guidance</li>
                    <li><i class="bi bi-check2-circle" aria-hidden="true"></i> Staff training and launch preparation
                    </li>
                  </ul>
                </div>
              </article>
              <article class="franchise-slide" data-franchise-slide aria-label="Slide 3 of 4" aria-hidden="true">
                <div class="franchise-slide-image"><img
                    src="https://images.unsplash.com/photo-1604719312566-8912e9c8a213?auto=format&fit=crop&w=1000&q=80"
                    alt="Representative stock photo of colourful retail shelves" loading="lazy" decoding="async"><span
                    class="slide-image-label"><i class="bi bi-megaphone" aria-hidden="true"></i> Brand</span></div>
                <div class="franchise-slide-copy"><span class="slide-kicker">03 · Marketing & branding</span>
                  <h3>A familiar name on your street.</h3>
                  <p>Signage, campaign material and central social media support are listed as part of the proposition.
                  </p>
                  <ul>
                    <li><i class="bi bi-check2-circle" aria-hidden="true"></i> Signage and brand material</li>
                    <li><i class="bi bi-check2-circle" aria-hidden="true"></i> Central social media support</li>
                  </ul>
                </div>
              </article>
              <article class="franchise-slide" data-franchise-slide aria-label="Slide 4 of 4" aria-hidden="true">
                <div class="franchise-slide-image"><img
                    src="https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=1000&q=80"
                    alt="Representative stock photo of a home goods display" loading="lazy" decoding="async"><span
                    class="slide-image-label"><i class="bi bi-geo" aria-hidden="true"></i> Territory</span></div>
                <div class="franchise-slide-copy"><span class="slide-kicker">04 · Territory arrangements</span>
                  <h3>A catchment that makes sense.</h3>
                  <p>Defined catchment areas are referenced in the published model. Exact terms and availability are
                    confirmed with the team.</p>
                  <ul>
                    <li><i class="bi bi-check2-circle" aria-hidden="true"></i> Local catchment conversation</li>
                    <li><i class="bi bi-check2-circle" aria-hidden="true"></i> Current requirements shared directly</li>
                  </ul>
                </div>
              </article>
            </div>
          </div>
          <div class="franchise-slider-footer">
            <div class="franchise-slider-dots" data-slider-dots aria-label="Choose a support area"><button type="button"
                class="slider-dot is-active" data-slide-to="0" aria-label="Show Sourcing & warehouse supply"
                aria-current="true"></button><button type="button" class="slider-dot" data-slide-to="1"
                aria-label="Show Setup & training"></button><button type="button" class="slider-dot" data-slide-to="2"
                aria-label="Show Marketing & branding"></button><button type="button" class="slider-dot"
                data-slide-to="3" aria-label="Show Territory arrangements"></button></div>
            <div class="franchise-slider-controls"><span class="slider-counter"><strong
                  data-slider-current>01</strong><span> / 04</span></span><button class="slider-arrow" type="button"
                data-slider-prev aria-label="Previous support area"><i class="bi bi-arrow-left"
                  aria-hidden="true"></i></button><button class="slider-arrow slider-arrow-next" type="button"
                data-slider-next aria-label="Next support area"><i class="bi bi-arrow-right"
                  aria-hidden="true"></i></button></div>
          </div>
        </div>
      </div>
    </section>

    <section class="final" aria-labelledby="finalTitle">
      <div class="container-wide final-inner" data-reveal>
        <span class="final-shape" aria-hidden="true"></span>
        <h2 id="finalTitle">Ready to visit, or to open your own?</h2>
        <p>Find the closest listed area, or start a conversation with the team about a franchise.</p>
        <div class="final-actions"><a class="btn btn-yellow btn-lg" data-magnetic href="{{ route('frontend.outlets') }}"><i
              class="bi bi-geo-alt-fill" aria-hidden="true"></i> Find a Store</a><a class="btn btn-light btn-lg"
            data-magnetic href="{{ route('frontend.franchise') }}">Open a Franchise <i class="bi bi-arrow-up-right"
              aria-hidden="true"></i></a></div>
        <ul class="final-contact">
          <li><a href="tel:+923470006050"><i class="bi bi-telephone" aria-hidden="true"></i> 0347 0006050</a></li>
          <li><a href="https://wa.me/923470006050" target="_blank" rel="noopener noreferrer"><i class="bi bi-whatsapp"
                aria-hidden="true"></i> WhatsApp</a></li>
          <li><a href="mailto:poundstorewarehouse@gmail.com"><i class="bi bi-envelope" aria-hidden="true"></i> Email the
              team</a></li>
        </ul>
      </div>
    </section>
  </main>
@endsection