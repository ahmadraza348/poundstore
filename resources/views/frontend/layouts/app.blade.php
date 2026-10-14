<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Pound Store Pakistan | Everyday Finds & Retail Value')</title>
  <meta name="description"
    content="@yield('description', 'Everyday finds at prices that make sense. Explore Pound Store Pakistan categories, find a store and learn about franchise opportunities.')">
  <meta name="theme-color" content="#103d29">
  <link rel="icon" type="image/png" href="{{ asset('frontend/assets/images/pound-store-logo.png') }}">
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="Pound Store Pakistan">
  <meta property="og:title" content="Pound Store Pakistan | Everyday Finds & Retail Value">
  <meta property="og:description"
    content="Everyday finds at prices that make sense. Explore Pound Store Pakistan categories, find a store and learn about franchise opportunities.">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,600;12..96,700;12..96,800&family=Manrope:wght@400;500;600;700;800&display=swap"
    rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="">
  <link href="{{asset('frontend/assets/css/style.css')}}" rel="stylesheet">
  <script>
    document.documentElement.classList.add('js');
  </script>
</head>

<body id="top">
  <a class="skip-link" href="#main">Skip to content</a>

  @include('frontend.layouts.header')
  @yield('content')
  @include('frontend.layouts.footer')

  <a class="whatsapp-float" href="https://wa.me/923470006050" target="_blank" rel="noopener noreferrer"
    aria-label="Contact Pound Store on WhatsApp"><i class="bi bi-whatsapp" aria-hidden="true"></i></a>
  <button class="back-top" type="button" data-back-top aria-label="Back to top"><i class="bi bi-arrow-up"
      aria-hidden="true"></i></button>

  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
  <script>
    // These arrays are built from active Cities and Outlets records by AppServiceProvider.
    // Do not reintroduce the old hard-coded demo directory here.
    window.POUND_STORE_CITY_LISTINGS = @json($frontendCityListings ?? []);
    window.POUND_STORE_OUTLETS = @json($frontendOutlets ?? []);
  </script>
  <script src="{{ asset('frontend/assets/js/main.js') }}"></script>
</body>

</html>