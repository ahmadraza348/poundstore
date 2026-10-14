@extends('frontend.layouts.app')

@section('title', 'Contact Pound Store Pakistan | Phone & Email')
@section('description', 'Contact Pound Store Pakistan for branch questions, franchise enquiries and general information.')

@section('content')
<main id="main">
<section class="page-hero"><div class="container-wide page-hero-grid"><div><p class="eyebrow">Contact</p><h1>Let’s get you to the <span class="highlight">right conversation.</span></h1><p class="lead">Reach Pound Store Pakistan for store-location confirmation, franchise enquiries or general questions.</p><span class="page-hero-kicker"><i class="bi bi-chat-dots" aria-hidden="true"></i> Contact details shown on the public website</span></div><img class="page-hero-image" data-parallax src="https://images.unsplash.com/photo-1521737711867-e3b97375f902?auto=format&fit=crop&w=1000&q=82" alt="People collaborating in a meeting" loading="eager"></div></section>
<section class="section"><div class="container-wide"><div class="section-heading"><p class="eyebrow">Get in touch</p><h2>Choose the <span class="highlight">right path.</span></h2><p>Contact details below are taken from the company website. For branch-specific stock, timings or address questions, call before visiting.</p></div><div class="contact-grid"><article class="contact-card"><i class="bi bi-telephone" aria-hidden="true"></i><h3>Call the team</h3><p>For store assistance and general enquiries.</p><a href="tel:+923470006050">0347 0006050</a></article><article class="contact-card"><i class="bi bi-envelope" aria-hidden="true"></i><h3>Email</h3><p>For written questions and follow-up.</p><a href="mailto:poundstorewarehouse@gmail.com">poundstorewarehouse@gmail.com</a></article><article class="contact-card"><i class="bi bi-geo-alt" aria-hidden="true"></i><h3>Warehouse / contact address</h3><p>Written address listed on the public website.</p><a href="{{ route('frontend.outlets') }}">Alipur Chowk, Gujranwala, Punjab</a></article></div></div></section>
<section class="section section-soft" id="contact-form">
    <div class="container-wide">
        <div class="form-layout">
            <aside class="form-aside">
                <p class="eyebrow">Before you send</p>
                <h2>How can we help?</h2>
                <p>Choose a subject and leave a note below. The team will read your message and reply as soon as possible.</p>
                <div class="contact-point"><i class="bi bi-shop" aria-hidden="true"></i><div><strong>Outlet assistance</strong><span>Current branch address, hours and availability</span></div></div>
                <div class="contact-point"><i class="bi bi-people" aria-hidden="true"></i><div><strong>Franchise enquiries</strong><span>Location, process and current requirements</span></div></div>
                <div class="contact-point"><i class="bi bi-info-circle" aria-hidden="true"></i><div><strong>General questions</strong><span>Company, product categories and sourcing</span></div></div>
            </aside>
            <div class="form-card">
                <p class="eyebrow">Contact form</p>
                <h2>Write to the team</h2>
                <form data-validate-form action="{{ route('frontend.contact.submit') }}" method="POST" novalidate>
                    @csrf
                    {{-- Honeypot: hidden from visitors, bots fill it in --}}
                    <div aria-hidden="true" style="position:absolute;left:-9999px;"><label for="contactWebsite">Leave this field empty</label><input id="contactWebsite" name="hp_check" tabindex="-1" autocomplete="off"></div>
                    <div class="form-grid">
                        <div class="field">
                            <label for="contactName">Full name *</label>
                            <input id="contactName" name="name" value="{{ old('name') }}" required minlength="2" maxlength="150" autocomplete="name" placeholder="Your name" class="{{ $errors->has('name') ? 'field-invalid' : '' }}">
                            @error('name')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="field">
                            <label for="contactMethod">Phone or email *</label>
                            <input id="contactMethod" name="contact" value="{{ old('contact') }}" required maxlength="150" placeholder="How should the team reach you?" class="{{ $errors->has('contact') ? 'field-invalid' : '' }}">
                            @error('contact')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="field full">
                            <label for="contactSubject">I’m contacting about</label>
                            <select id="contactSubject" name="subject">
                                @foreach (['Store location / branch details', 'Franchise enquiry', 'Product categories', 'General question'] as $option)
                                    <option @selected(old('subject') === $option)>{{ $option }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="field full">
                            <label for="contactMessage">Message *</label>
                            <textarea id="contactMessage" name="message" required minlength="10" maxlength="3000" placeholder="How can the team help?" class="{{ $errors->has('message') ? 'field-invalid' : '' }}">{{ old('message') }}</textarea>
                            @error('message')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="field full">
                            <button class="btn btn-primary" type="submit">Send message <i class="bi bi-arrow-right"></i></button>
                            {{-- Shows the success message (or a general error) after the page reloads --}}
                            <div class="form-status {{ session('success') || $errors->any() ? 'show' : '' }} {{ $errors->any() ? 'is-error' : '' }}" data-form-status role="status" aria-live="polite">@if (session('success')){{ session('success') }}@elseif ($errors->any())Please fix the highlighted fields.@endif</div>
                            <p class="demo-note">* Required fields.</p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<section class="section"><div class="container-wide cta-band"><div><h2>Rather speak directly?</h2><p>Call the published contact number to get help from Pound Store Pakistan.</p></div><a href="tel:+923470006050" class="btn btn-primary"><i class="bi bi-telephone"></i> 0347 0006050</a></div></section>
</main>
@endsection