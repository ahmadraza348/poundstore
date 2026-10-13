  <header class="site-header" id="siteHeader">
    <div class="container-wide nav-inner">
      <a class="brand" href="{{ route('frontend.home') }}" aria-label="Pound Store Pakistan home"><img
          src="{{asset('frontend/assets/images/pound-store-logo.png')}}" alt="Pound Store Pakistan logo" width="56" height="56"><span
          class="brand-name">Pound Store<small>Pakistan</small></span></a>
      <button class="menu-toggle" type="button" data-menu-toggle aria-expanded="false" aria-controls="primaryNavigation"
        aria-label="Open navigation menu"><span class="menu-bars"
          aria-hidden="true"><span></span><span></span><span></span></span></button>
      <div class="nav-panel" id="primaryNavigation" data-nav-panel>
        <nav class="nav-menu" aria-label="Main navigation">
          <a href="{{ route('frontend.home') }}">Home</a>
          <a href="{{ route('frontend.categories') }}">Categories</a>
        <a
            href="{{ route('frontend.about') }}">About</a><a href="{{ route('frontend.sourcing') }}">Sourcing</a><a href="{{ route('frontend.faq') }}">FAQ</a><a
            href="{{ route('frontend.contact') }}">Contact</a></nav>
        <div class="nav-actions"><a class="btn btn-ghost btn-sm" href="{{ route('frontend.outlets') }}"><i class="bi bi-geo-alt-fill"
              aria-hidden="true"></i> Find a Store</a><a class="btn btn-primary btn-sm" href="{{ route('frontend.franchise') }}">Open a
            Franchise <i class="bi bi-arrow-up-right" aria-hidden="true"></i></a></div>
      </div>
    </div>
  </header>