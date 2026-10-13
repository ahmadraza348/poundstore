  <footer class="site-footer">
    <div class="container-wide">
      <div class="footer-grid">
        <div><a class="footer-brand" href="{{ route('frontend.home') }}"><img src="{{asset('frontend/assets/images/pound-store-logo.png')}}"
              alt=""><span><strong>POUND STORE</strong><small>PAKISTAN</small></span></a>
          <p class="footer-intro">Affordability, variety and quality — serving communities across Pakistan since 2017.
            Explore our catalogue, find a store or ask about franchise opportunities.</p>
        </div>
        <div>
          <h3 class="footer-heading">Explore</h3>
          <ul class="footer-links">
            <li><a href="{{ route('frontend.categories') }}">Product categories</a></li>
            <li><a href="{{ route('frontend.category', ['category' => 'home-kitchen']) }}">Demo catalogue</a></li>
            <li><a href="{{ route('frontend.outlets') }}">Find a store</a></li>
            <li><a href="{{ route('frontend.about') }}">About Pound Store</a></li>
          </ul>
        </div>
        <div>
          <h3 class="footer-heading">Business</h3>
          <ul class="footer-links">
            <li><a href="{{ route('frontend.franchise') }}">Franchise opportunity</a></li>
            <li><a href="{{ route('frontend.sourcing') }}">Import & sourcing</a></li>
            <li><a href="{{ route('frontend.faq') }}">Frequently asked questions</a></li>
            <li><a href="{{ route('frontend.contact') }}">Contact the team</a></li>
          </ul>
        </div>
        <div>
          <h3 class="footer-heading">Contact</h3>
          <div class="footer-contact"><i class="bi bi-telephone" aria-hidden="true"></i><a href="tel:+923470006050">0347
              0006050</a></div>
          <div class="footer-contact"><i class="bi bi-envelope" aria-hidden="true"></i><a
              href="mailto:poundstorewarehouse@gmail.com">poundstorewarehouse@gmail.com</a></div>
          <div class="footer-contact"><i class="bi bi-geo-alt" aria-hidden="true"></i><span>Alipur Chowk, Gujranwala,
              Punjab</span></div><a class="footer-contact" href="https://wa.me/923470006050" target="_blank"
            rel="noopener noreferrer"><i class="bi bi-whatsapp" aria-hidden="true"></i><span>Chat on WhatsApp</span></a>
          <div class="footer-socials" aria-label="Social media links">
            <span class="footer-social-title">Follow Pound Store</span>
            <div class="footer-social-row">
              <a href="https://www.facebook.com/share/14p7z91uSR4/?mibextid=wwXIfr" target="_blank"
                rel="noopener noreferrer" aria-label="Pound Store on Facebook" title="Facebook"><i
                  class="bi bi-facebook" aria-hidden="true"></i></a>
              <a href="https://www.tiktok.com/@poundstore.com" target="_blank" rel="noopener noreferrer"
                aria-label="Pound Store on TikTok" title="TikTok"><i class="bi bi-tiktok" aria-hidden="true"></i></a>
              <a href="https://linktr.ee/pakistanpoundstore" target="_blank" rel="noopener noreferrer"
                aria-label="All official social links" title="All social links"><i class="bi bi-link-45deg"
                  aria-hidden="true"></i></a>
              <a href="https://wa.me/923470006050" target="_blank" rel="noopener noreferrer"
                aria-label="Pound Store on WhatsApp" title="WhatsApp"><i class="bi bi-whatsapp"
                  aria-hidden="true"></i></a>
            </div>
          </div>
        </div>
      </div>
      <div class="footer-bottom"><span>© <span data-current-year>2026</span> Pound Store Pakistan. All rights
          reserved.</span><span>Static frontend demo · Sample catalogue data only</span><a href="#top">Back to top ↑</a>
      </div>
    </div>
  </footer>