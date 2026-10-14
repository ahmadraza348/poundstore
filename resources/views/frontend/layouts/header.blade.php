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
          <a href="{{ route('frontend.home') }}" class="{{ request()->routeIs('frontend.home') ? 'is-active' : '' }}" @if(request()->routeIs('frontend.home')) aria-current="page" @endif>Home</a>
          <a href="{{ route('frontend.categories') }}" class="{{ request()->routeIs('frontend.categories', 'frontend.category') ? 'is-active' : '' }}" @if(request()->routeIs('frontend.categories', 'frontend.category')) aria-current="page" @endif>Categories</a>
        <a href="{{ route('frontend.about') }}" class="{{ request()->routeIs('frontend.about') ? 'is-active' : '' }}" @if(request()->routeIs('frontend.about')) aria-current="page" @endif>About</a>
          <a href="{{ route('frontend.sourcing') }}" class="{{ request()->routeIs('frontend.sourcing') ? 'is-active' : '' }}" @if(request()->routeIs('frontend.sourcing')) aria-current="page" @endif>Sourcing</a>
          <a href="{{ route('frontend.faq') }}" class="{{ request()->routeIs('frontend.faq') ? 'is-active' : '' }}" @if(request()->routeIs('frontend.faq')) aria-current="page" @endif>FAQ</a>
          <a href="{{ route('frontend.contact') }}" class="{{ request()->routeIs('frontend.contact') ? 'is-active' : '' }}" @if(request()->routeIs('frontend.contact')) aria-current="page" @endif>Contact</a></nav>
        <div class="nav-actions"><a class="btn btn-ghost btn-sm {{ request()->routeIs('frontend.outlets') ? 'is-active' : '' }}" href="{{ route('frontend.outlets') }}" @if(request()->routeIs('frontend.outlets')) aria-current="page" @endif><i class="bi bi-geo-alt-fill"
              aria-hidden="true"></i> Find a branch</a><a class="btn btn-primary btn-sm {{ request()->routeIs('frontend.franchise') ? 'is-active' : '' }}" href="{{ route('frontend.franchise') }}" @if(request()->routeIs('frontend.franchise')) aria-current="page" @endif>Open a
            Franchise <i class="bi bi-arrow-up-right" aria-hidden="true"></i></a></div>
      </div>
    </div>
  </header>