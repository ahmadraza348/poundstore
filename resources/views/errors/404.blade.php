@extends('frontend.layouts.app')

@section('title', 'Page Not Found | Pound Store Pakistan')
@section('description', 'The page you are looking for could not be found on the Pound Store Pakistan website.')

@section('content')
<main id="main">
  <section class="page-hero">
    <div class="container-wide" style="text-align:center;padding-block:96px">
      <p class="eyebrow">Error 404</p>
      <h1>Page <span class="highlight">not found.</span></h1>
      <p>The page you are looking for may have moved or no longer exists.</p>
      <div style="display:flex;flex-wrap:wrap;gap:12px;justify-content:center;margin-top:24px">
        <a class="btn btn-primary btn-lg" href="{{ route('frontend.home') }}">Return Home</a>
        <a class="btn btn-outline btn-lg" href="{{ route('frontend.categories') }}">Browse Categories</a>
        <a class="btn btn-ghost btn-lg" href="{{ route('frontend.contact') }}">Contact Us</a>
      </div>
    </div>
  </section>
</main>
@endsection
