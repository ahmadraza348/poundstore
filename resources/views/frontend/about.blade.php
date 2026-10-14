@extends('frontend.layouts.app')

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
          <p>Names and roles below are presented as listed on the public company website. The initials keep the team directory consistent until approved portraits are available.</p>
        </div>

         <div class="ceo-message "style="margin: 3rem 0;" aria-label="CEO message"><span class="team-avatar team-monogram" aria-hidden="true">WH</span>
          <div>
            <p class="eyebrow">Leadership perspective</p>
            <h3>Waseem Hussain Shah · Chief Executive Officer</h3>
            <p>Our progress is built on hard work, a better shopping experience and a wide choice of useful products at
              prices that feel fair. We welcome franchise partners who share our ambition to build trusted local stores
              with the right guidance and support.</p>
          </div>
        </div>

        <div class="team-grid">
          <article class="team-card"><span class="team-avatar team-monogram" aria-hidden="true">WH</span>
            <h3>Waseem Hussain Shah</h3>
            <p>Chief Executive Officer</p>
          </article>
          <article class="team-card"><span class="team-avatar team-monogram" aria-hidden="true">SR</span>
            <h3>Sohail Riaz</h3>
            <p>Chairman</p>
          </article>
          <article class="team-card"><span class="team-avatar team-monogram" aria-hidden="true">MA</span>
            <h3>Mouzzam Ali Shah</h3>
            <p>Managing Director</p>
          </article>
          <article class="team-card"><span class="team-avatar team-monogram" aria-hidden="true">PN</span>
            <h3>Peer Naseer ud Din Shah</h3>
            <p>Finance Director</p>
          </article>
          <article class="team-card"><span class="team-avatar team-monogram" aria-hidden="true">QA</span>
            <h3>Qalab Abbas</h3>
            <p>Business Advisor</p>
          </article>
          <article class="team-card"><span class="team-avatar team-monogram" aria-hidden="true">NH</span>
            <h3>Nadeem Hussain Shah</h3>
            <p>Sales Advisor</p>
          </article>
          <article class="team-card"><span class="team-avatar team-monogram" aria-hidden="true">MA</span>
            <h3>Master Anar Sajid</h3>
            <p>Mentor & Moral Support</p>
          </article>
          <article class="team-card"><span class="team-avatar team-monogram" aria-hidden="true">SH</span>
            <h3>Sheryar Haider</h3>
            <p>Operational Manager</p>
          </article>
          <article class="team-card"><span class="team-avatar team-monogram" aria-hidden="true">MN</span>
            <h3>Muhammad Naeem</h3>
            <p>Marketing & Development Manager</p>
          </article>
          <article class="team-card"><span class="team-avatar team-monogram" aria-hidden="true">II</span>
            <h3>Iqra Iftikhar</h3>
            <p>HR Manager & Trainer</p>
          </article>
          <article class="team-card"><span class="team-avatar team-monogram" aria-hidden="true">SA</span>
            <h3>Shoaib Ahmad</h3>
            <p>Social Media Influencer</p>
          </article>
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
