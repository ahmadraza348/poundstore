@extends('frontend.layouts.app')

@section('title', 'Franchise Opportunities | Pound Store Pakistan')
@section('description', 'Explore the Pound Store Pakistan franchise proposition, published support areas, process and enquiry form.')

@section('content')
<main id="main">
    <section class="page-hero fr-hero">
        <div class="container-wide page-hero-grid">
            <div>
                <p class="eyebrow">Franchise opportunity</p>
                <h1>Bring Pound Store to <span class="highlight">your city.</span></h1>
                <p class="lead">A value-retail brand with sourcing, warehouse supply and a launch process behind it. Tell the franchise team where you would like to open, then work through the details together.</p>
                <div class="hero-ctas"><a class="btn btn-yellow btn-lg" data-magnetic href="#enquiry">Start an enquiry <i class="bi bi-arrow-down" aria-hidden="true"></i></a><a class="btn btn-light btn-lg" href="#process">See the six steps</a></div>
            </div><img class="page-hero-image" data-parallax src="https://images.unsplash.com/photo-1604719312566-8912e9c8a213?auto=format&fit=crop&w=1000&q=80" alt="Bright retail aisle with shelves of everyday products" loading="eager" fetchpriority="high">
        </div>
    </section>
    <section class="section sup" aria-labelledby="supTitle">
        <div class="container-wide">
            <div class="sec-head" data-reveal>
                <div>
                    <h2 id="supTitle">Practical support, from stock to signage.</h2>
                    <p>The support areas below come from the company’s public franchise information.</p>
                </div>
            </div>
            <div class="sup-grid">
                <article class="sup-card" data-reveal style="--reveal-delay:0ms"><span class="feature-icon"><i class="bi bi-box-seam" aria-hidden="true"></i></span>
                    <h3>Sourcing and warehouse supply</h3>
                    <p>Volume-led direct sourcing and central warehouse supply from Gujranwala.</p>
                </article>
                <article class="sup-card" data-reveal style="--reveal-delay:80ms"><span class="feature-icon"><i class="bi bi-person-gear" aria-hidden="true"></i></span>
                    <h3>Setup and training</h3>
                    <p>Store setup, merchandising, staff training and launch preparation.</p>
                </article>
                <article class="sup-card" data-reveal style="--reveal-delay:160ms"><span class="feature-icon"><i class="bi bi-megaphone" aria-hidden="true"></i></span>
                    <h3>Marketing and branding</h3>
                    <p>Signage, campaign material and central social media support.</p>
                </article>
                <article class="sup-card" data-reveal style="--reveal-delay:240ms"><span class="feature-icon"><i class="bi bi-geo" aria-hidden="true"></i></span>
                    <h3>Territory arrangements</h3>
                    <p>Defined catchment areas. Exact terms are confirmed with the team.</p>
                </article>
            </div>
        </div>
    </section>
    <section class="section process" id="process" aria-labelledby="processTitle">
        <div class="container-wide">
            <div class="sec-head" data-reveal>
                <div>
                    <h2 id="processTitle">Six steps from enquiry to grand opening.</h2>
                    <p>Scroll through the journey. Each step lights up as you reach it.</p>
                </div>
            </div>
            <div class="journey" data-journey>
                <ol class="journey-list"><span class="journey-line" aria-hidden="true"><i></i></span>
                    <li class="journey-step" data-journey-step><span class="journey-marker"><span>1</span></span>
                        <div class="journey-card"><span class="journey-icon"><i class="bi bi-chat-dots" aria-hidden="true"></i></span>
                            <div>
                                <h3>Enquire</h3>
                                <p>Share your city, preferred location and initial interest.</p>
                            </div>
                        </div>
                    </li>
                    <li class="journey-step" data-journey-step><span class="journey-marker"><span>2</span></span>
                        <div class="journey-card"><span class="journey-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
                            <div>
                                <h3>Discussion</h3>
                                <p>The franchise team discusses the model and current requirements.</p>
                            </div>
                        </div>
                    </li>
                    <li class="journey-step" data-journey-step><span class="journey-marker"><span>3</span></span>
                        <div class="journey-card"><span class="journey-icon"><i class="bi bi-geo-alt" aria-hidden="true"></i></span>
                            <div>
                                <h3>Site survey</h3>
                                <p>The proposed property is evaluated for size, footfall and catchment.</p>
                            </div>
                        </div>
                    </li>
                    <li class="journey-step" data-journey-step><span class="journey-marker"><span>4</span></span>
                        <div class="journey-card"><span class="journey-icon"><i class="bi bi-file-earmark-check" aria-hidden="true"></i></span>
                            <div>
                                <h3>Agreement</h3>
                                <p>Terms are reviewed and finalised between both parties.</p>
                            </div>
                        </div>
                    </li>
                    <li class="journey-step" data-journey-step><span class="journey-marker"><span>5</span></span>
                        <div class="journey-card"><span class="journey-icon"><i class="bi bi-box-seam" aria-hidden="true"></i></span>
                            <div>
                                <h3>Setup & stock</h3>
                                <p>Fit-out, opening stock and staff preparation are organised.</p>
                            </div>
                        </div>
                    </li>
                    <li class="journey-step" data-journey-step><span class="journey-marker"><span>6</span></span>
                        <div class="journey-card"><span class="journey-icon"><i class="bi bi-stars" aria-hidden="true"></i></span>
                            <div>
                                <h3>Grand opening</h3>
                                <p>Launch is coordinated, with ongoing operational support afterwards.</p>
                            </div>
                        </div>
                    </li>
                </ol>
                <div class="journey-stage" aria-hidden="true">
                    <div class="journey-slide" data-journey-slide><span class="slide-no" aria-hidden="true">01</span><span class="slide-icon"><i class="bi bi-chat-dots" aria-hidden="true"></i></span>
                        <p class="slide-count">Step 1 of 6</p>
                        <h3>Enquire</h3>
                        <p class="slide-detail">You tell us where you are thinking of opening.</p>
                    </div>
                    <div class="journey-slide" data-journey-slide><span class="slide-no" aria-hidden="true">02</span><span class="slide-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
                        <p class="slide-count">Step 2 of 6</p>
                        <h3>Discussion</h3>
                        <p class="slide-detail">Ask about investment, territory and what the team needs from you.</p>
                    </div>
                    <div class="journey-slide" data-journey-slide><span class="slide-no" aria-hidden="true">03</span><span class="slide-icon"><i class="bi bi-geo-alt" aria-hidden="true"></i></span>
                        <p class="slide-count">Step 3 of 6</p>
                        <h3>Site survey</h3>
                        <p class="slide-detail">The location is looked at before anything is agreed.</p>
                    </div>
                    <div class="journey-slide" data-journey-slide><span class="slide-no" aria-hidden="true">04</span><span class="slide-icon"><i class="bi bi-file-earmark-check" aria-hidden="true"></i></span>
                        <p class="slide-count">Step 4 of 6</p>
                        <h3>Agreement</h3>
                        <p class="slide-detail">Take the time to read and understand the terms.</p>
                    </div>
                    <div class="journey-slide" data-journey-slide><span class="slide-no" aria-hidden="true">05</span><span class="slide-icon"><i class="bi bi-box-seam" aria-hidden="true"></i></span>
                        <p class="slide-count">Step 5 of 6</p>
                        <h3>Setup & stock</h3>
                        <p class="slide-detail">Layout, merchandising and training come together.</p>
                    </div>
                    <div class="journey-slide" data-journey-slide><span class="slide-no" aria-hidden="true">06</span><span class="slide-icon"><i class="bi bi-stars" aria-hidden="true"></i></span>
                        <p class="slide-count">Step 6 of 6</p>
                        <h3>Grand opening</h3>
                        <p class="slide-detail">Your store opens its doors to the community.</p>
                    </div><span class="journey-meter"><i></i></span>
                </div>
            </div>
            <div class="journey-cta" data-reveal>
                <div>
                    <h3>Ready for step one?</h3>
                    <p>Share your city and a few details. The team will follow up on current requirements.</p>
                </div><a class="btn btn-primary btn-lg" data-magnetic href="#enquiry">Go to the enquiry form <i class="bi bi-arrow-down" aria-hidden="true"></i></a>
            </div>
        </div>
    </section>
    <section class="section form-section" id="enquiry">
        <div class="container-wide">
            <div class="form-layout">
                <aside class="form-aside form-aside--franchise">
                    <p class="eyebrow">Step 1 · Enquire</p>
                    <h2 class="form-aside-title">Tell us what you’re exploring.</h2>
                    <p>Share your contact details, city and proposed location. The franchise team will review your enquiry and get back to you.</p>
                    <div class="contact-point"><i class="bi bi-telephone" aria-hidden="true"></i>
                        <div><strong>Head office</strong><span>0347 0006050</span></div>
                    </div>
                    <div class="contact-point"><i class="bi bi-envelope" aria-hidden="true"></i>
                        <div><strong>Email</strong><span>poundstorewarehouse@gmail.com</span></div>
                    </div>
                    <div class="contact-point"><i class="bi bi-geo-alt" aria-hidden="true"></i>
                        <div><strong>Warehouse</strong><span>Alipur Chowk, Gujranwala</span></div>
                    </div>
                </aside>
                <div class="form-card">
                    <p class="eyebrow">Franchise enquiry</p>
                    <h2>Register your interest</h2>
                    <form data-validate-form action="{{ route('frontend.franchise.submit') }}" method="POST" novalidate>
                        @csrf
                        {{-- Honeypot: hidden from visitors, bots fill it in --}}
                        <div aria-hidden="true" style="position:absolute;left:-9999px;"><label for="frWebsite">Leave this field empty</label><input id="frWebsite" name="hp_check" tabindex="-1" autocomplete="off"></div>
                        <div class="form-grid">
                            <div class="field">
                                <label for="frName">Full name *</label>
                                <input id="frName" name="name" value="{{ old('name') }}" required minlength="2" maxlength="150" autocomplete="name" placeholder="Your full name" class="{{ $errors->has('name') ? 'field-invalid' : '' }}">
                                @error('name')<span class="field-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="field">
                                <label for="frPhone">Phone number *</label>
                                <input id="frPhone" name="phone" type="tel" value="{{ old('phone') }}" required maxlength="30" autocomplete="tel" inputmode="tel" placeholder="03XX XXXXXXX" class="{{ $errors->has('phone') ? 'field-invalid' : '' }}">
                                @error('phone')<span class="field-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="field">
                                <label for="frEmail">Email address</label>
                                <input id="frEmail" name="email" type="email" value="{{ old('email') }}" maxlength="150" autocomplete="email" placeholder="you@example.com" class="{{ $errors->has('email') ? 'field-invalid' : '' }}">
                                @error('email')<span class="field-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="field">
                                <label for="frCity">City / proposed location *</label>
                                <input id="frCity" name="city" value="{{ old('city') }}" required minlength="2" maxlength="150" placeholder="City or area" class="{{ $errors->has('city') ? 'field-invalid' : '' }}">
                                @error('city')<span class="field-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="field">
                                <label for="frBudget">Investment information preference</label>
                                <select id="frBudget" name="budget">
                                    <option value="">Choose a range</option>
                                    @foreach (['Prefer to discuss', 'I have a budget to discuss with the team', 'I would prefer to discuss current requirements first', 'I am exploring the opportunity'] as $option)
                                        <option @selected(old('budget') === $option)>{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="field">
                                <label for="frProperty">Property status</label>
                                <select id="frProperty" name="property_status">
                                    <option value="">Choose one</option>
                                    @foreach (['I own a property', 'I have a rental option', 'I am still looking'] as $option)
                                        <option @selected(old('property_status') === $option)>{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="field full">
                                <label for="frNotes">Anything else we should know?</label>
                                <textarea id="frNotes" name="notes" maxlength="2000" placeholder="Proposed shop size, experience or questions" class="{{ $errors->has('notes') ? 'field-invalid' : '' }}">{{ old('notes') }}</textarea>
                                @error('notes')<span class="field-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="field full">
                                <button class="btn btn-primary" type="submit">Send enquiry <i class="bi bi-arrow-right"></i></button>
                                {{-- Shows the success message (or a general error) after the page reloads --}}
                                <div class="form-status {{ session('success') || $errors->any() ? 'show' : '' }} {{ $errors->any() ? 'is-error' : '' }}" data-form-status role="status" aria-live="polite">@if (session('success')){{ session('success') }}@elseif ($errors->any())Please fix the highlighted fields.@endif</div>
                                <p class="form-required-note">* Required fields.</p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="container-wide cta-band">
            <div>
                <h2>Need current investment information?</h2>
                <p>Call the company for approved franchise terms, the current investment breakdown and availability by territory. We do not publish figures here because they can change.</p>
            </div><a href="tel:+923470006050" class="btn btn-primary"><i class="bi bi-telephone"></i> Call the team</a>
        </div>
    </section>
</main>
@endsection