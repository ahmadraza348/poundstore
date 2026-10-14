@extends('frontend.layouts.app')

@php
    // Team & CEO portraits. Until a real photo exists, the generic empty portrait is shown.
    // To use a real photo, upload it to public/frontend/assets/images/team/ using the file
    // name listed below (.jpg, .jpeg, .png or .webp); the CEO photo is team/ceo.jpg.
    // It is picked up automatically, no code change needed.
    $teamImage = function (string $slug): string {
        foreach (['jpg', 'jpeg', 'png', 'webp'] as $ext) {
            if (file_exists(public_path("frontend/assets/images/team/{$slug}.{$ext}"))) {
                return asset("frontend/assets/images/team/{$slug}.{$ext}");
            }
        }
        return asset('frontend/assets/images/team-placeholder.svg');
    };
    $teamMembers = [
        ['name' => "Waseem Hussain Shah", 'role' => "Chief Executive Officer", 'slug' => 'waseem-hussain-shah'],
        ['name' => "Sohail Riaz", 'role' => "Chairman", 'slug' => 'sohail-riaz'],
        ['name' => "Mouzzam Ali Shah", 'role' => "Managing Director", 'slug' => 'mouzzam-ali-shah'],
        ['name' => "Peer Naseer ud Din Shah", 'role' => "Finance Director", 'slug' => 'peer-naseer-ud-din-shah'],
        ['name' => "Qalab Abbas", 'role' => "Business Advisor", 'slug' => 'qalab-abbas'],
        ['name' => "Nadeem Hussain Shah", 'role' => "Sales Advisor", 'slug' => 'nadeem-hussain-shah'],
        ['name' => "Master Anar Sajid", 'role' => "Mentor & Moral Support", 'slug' => 'master-anar-sajid'],
        ['name' => "Sheryar Haider", 'role' => "Operational Manager", 'slug' => 'sheryar-haider'],
        ['name' => "Muhammad Naeem", 'role' => "Marketing & Development Manager", 'slug' => 'muhammad-naeem'],
        ['name' => "Iqra Iftikhar", 'role' => "HR Manager & Trainer", 'slug' => 'iqra-iftikhar'],
        ['name' => "Shoaib Ahmad", 'role' => "Social Media Influencer", 'slug' => 'shoaib-ahmad'],
    ];
@endphp
@section('content')
  <main id="main">
    <section class="page-hero">
      <div class="container-wide page-hero-grid">
        <div>
          <p class="eyebrow">About Pound Store</p>
          <h1>Retail shaped around <span class="highlight">everyday value.</span></h1>
          <p class="lead">Pound Store Pakistan describes a business built around affordable products, a broad everyday
            assortment and long-term relationships with customers and franchise partners.</p><span
            class="page-hero-kicker"><i class="bi bi-calendar2-check" aria-hidden="true"></i> Journey began in
            2017</span>
        </div><img class="page-hero-image" data-parallax
          src="https://images.unsplash.com/photo-1555529669-e69e7aa0ba9a?auto=format&fit=crop&w=1000&q=82"
          alt="Thoughtfully arranged everyday retail products" loading="eager">
      </div>
    </section>
    <section class="section">
      <div class="container-wide story-grid">
        <div class="story-image-wrap"><img class="story-image" data-parallax
            src="{{ asset('frontend/assets/images/hero-store.jpg') }}"
            alt="A well-stocked everyday retail store with organised product shelves" loading="lazy">
          <div class="story-year"><strong>2017</strong><span>Our beginning</span></div>
        </div>
        <div class="story-copy">
          <p class="eyebrow">The journey</p>
          <h2>A simple idea: make everyday shopping <span class="highlight">more accessible.</span></h2>
          <p class="lead">The company’s public story traces its beginning to 2017 and highlights affordability, variety,
            quality and a commitment to customer trust.</p>
          <p>Its store network and franchise model are central to the way Pound Store presents its continued growth. The
            website brings together product-category discovery, branch information and business enquiries so visitors
            can choose the next useful step.</p>
          <p>The story continues through a growing branch network, a broad everyday range and a franchise model built around local communities.</p><a class="text-link"
            href="{{ route('frontend.outlets') }}">Explore the network <i class="bi bi-arrow-right"></i></a>
        </div>
      </div>
    </section>

    <section class="section">
      <div class="container-wide">
        
        <div class="section-heading">
          <p class="eyebrow">The people behind the brand</p>
          <h2>Leadership & <span class="highlight">team.</span></h2>
          <p>Names and roles below are presented as listed on the public company website. Portraits will be added once approved photos are available.</p>
        </div>

         <div class="ceo-message "style="margin: 3rem 0;" aria-label="CEO message"><img class="team-avatar-image" src="{{ $teamImage('ceo') }}" alt="Portrait of Waseem Hussain Shah, Chief Executive Officer" width="100" height="100" loading="lazy" decoding="async">
          <div>
            <p class="eyebrow">Leadership perspective</p>
            <h3>Waseem Hussain Shah · Chief Executive Officer</h3>
            <p>Our progress is built on hard work, a better shopping experience and a wide choice of useful products at
              prices that feel fair. We welcome franchise partners who share our ambition to build trusted local stores
              with the right guidance and support.</p>
          </div>
        </div>

        <div class="team-grid">
          @foreach ($teamMembers as $member)
            <article class="team-card"><img class="team-avatar-image" src="{{ $teamImage($member['slug']) }}" alt="Portrait of {{ $member['name'] }}" width="82" height="82" loading="lazy" decoding="async">
              <h3>{{ $member['name'] }}</h3>
              <p>{{ $member['role'] }}</p>
            </article>
          @endforeach
        </div>
      </div>
    </section>

        <section class="section section-soft">
      <div class="container-wide">
        <div class="section-heading">
          <p class="eyebrow">What guides us</p>
          <h2>Values behind the <span class="highlight">experience.</span></h2>
          <p>The official website presents four guiding values. The descriptions below keep to the company’s published
            framing.</p>
        </div>
        <div class="values-grid">
          <article class="value-card"><i class="bi bi-shield-check" aria-hidden="true"></i>
            <h3>Integrity</h3>
            <p>Honest and transparent business practices.</p>
          </article>
          <article class="value-card"><i class="bi bi-award" aria-hidden="true"></i>
            <h3>Excellence</h3>
            <p>Commitment to high retail standards.</p>
          </article>
          <article class="value-card"><i class="bi bi-lightbulb" aria-hidden="true"></i>
            <h3>Innovation</h3>
            <p>Embracing new ideas to enhance customer experience.</p>
          </article>
          <article class="value-card"><i class="bi bi-heart" aria-hidden="true"></i>
            <h3>Customer commitment</h3>
            <p>Keeping customers at the heart of business decisions.</p>
          </article>
        </div>
      </div>
    </section>
    <section class="section">
      <div class="container-wide">
        <div class="section-heading">
          <p class="eyebrow">Mission & vision</p>
          <h2>What the business is <span class="highlight">working towards.</span></h2>
          <p>The mission and vision below are paraphrased from the company’s public website.</p>
        </div>
        <div class="mission-vision-grid">
          <article class="mission-card"><span class="mission-icon"><i class="bi bi-compass"
                aria-hidden="true"></i></span>
            <p class="eyebrow">Our vision</p>
            <h3>Lead with affordability, variety and excellence.</h3>
            <p>To become a leading retail chain in Pakistan while expanding through the company’s franchise system.</p>
          </article>
          <article class="mission-card"><span class="mission-icon"><i class="bi bi-bullseye"
                aria-hidden="true"></i></span>
            <p class="eyebrow">Our mission</p>
            <h3>Make useful products easier to access.</h3>
            <p>Offer reliable, affordable, high-quality products; build trust with customers and franchise partners; and
              keep innovating as retail needs evolve.</p>
          </article>
        </div>
       
      </div>
    </section>
    <section class="section section-soft">
      <div class="container-wide cta-band">
        <div>
          <h2>Get to know Pound Store in person.</h2>
          <p>Explore the category range, find a location or ask about the franchise model.</p>
        </div><a href="{{ route('frontend.outlets') }}" class="btn btn-primary">Find a branch <i class="bi bi-arrow-up-right"></i></a>
      </div>
    </section>
  </main>
@endsection
