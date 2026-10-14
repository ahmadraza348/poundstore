(function () {
  'use strict';

  function escapeHtml(value) {
    return String(value == null ? '' : value).replace(/[&<>"']/g, function (char) {
      return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[char];
    });
  }

  function hasCoords(item) {
    return item && typeof item.lat === 'number' && typeof item.lon === 'number' && isFinite(item.lat) && isFinite(item.lon);
  }
  function safeUrl(url) {
    return /^https?:\/\//i.test(String(url || '')) ? url : '#';
  }
  function plural(count, one, many) { return count + ' ' + (count === 1 ? one : many); }

  // Shared visual utilities: on-scroll reveals, count-up stats, parallax, and pagination.
  var reducedMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var revealObserver = null;

  function registerReveal(elements) {
    Array.prototype.forEach.call(elements || [], function (element, index) {
      if (!element || element.hasAttribute('data-reveal')) return;
      element.setAttribute('data-reveal', '');
      element.style.setProperty('--reveal-delay', ((index % 4) * 75) + 'ms');
      if (reducedMotion) {
        element.classList.add('is-visible');
      } else if (revealObserver) {
        revealObserver.observe(element);
      } else {
        element.classList.add('is-visible');
      }
    });
  }

  function numberText(value) {
    return Math.round(value).toLocaleString('en-PK');
  }

  function animateCounter(element) {
    if (!element || element.dataset.counterStarted === '1') return;
    element.dataset.counterStarted = '1';
    var target = Number(element.getAttribute('data-counter'));
    var suffix = element.getAttribute('data-counter-suffix') || '';
    var duration = Number(element.getAttribute('data-counter-duration')) || 1100;
    if (!Number.isFinite(target) || target <= 0) return; // markup already shows the real value
    if (reducedMotion) { element.textContent = numberText(target) + suffix; return; }
    // Count up from 55% of the real value so the number is never 0 and never "flashes" a wrong figure.
    var from = Math.round(target * 0.55);
    element.textContent = numberText(from) + suffix;
    var startTime = null;
    function tick(timestamp) {
      if (startTime === null) startTime = timestamp;
      var progress = Math.min(1, (timestamp - startTime) / duration);
      var eased = 1 - Math.pow(1 - progress, 3);
      element.textContent = numberText(from + (target - from) * eased) + suffix;
      if (progress < 1) window.requestAnimationFrame(tick);
      else element.textContent = numberText(target) + suffix;
    }
    window.requestAnimationFrame(tick);
  }

  function renderPagination(container, currentPage, totalPages, itemCount, pageSize, itemLabel, onChange) {
    if (!container) return;
    if (totalPages <= 1) {
      container.hidden = true;
      container.innerHTML = '';
      return;
    }
    container.hidden = false;
    var start = (currentPage - 1) * pageSize + 1;
    var end = Math.min(itemCount, currentPage * pageSize);
    var pageButtons = '';
    for (var pageNumber = 1; pageNumber <= totalPages; pageNumber += 1) {
      pageButtons += '<button type="button" class="pagination-button pagination-number' + (pageNumber === currentPage ? ' is-current' : '') + '" data-page-number="' + pageNumber + '"' + (pageNumber === currentPage ? ' aria-current="page"' : '') + ' aria-label="Page ' + pageNumber + '">' + pageNumber + '</button>';
    }
    container.innerHTML = '<div class="pagination-wrap"><span class="pagination-summary">Showing <strong>' + start + '–' + end + '</strong> of <strong>' + itemCount + '</strong> ' + itemLabel + '</span><div class="pagination-actions"><button type="button" class="pagination-button pagination-prev" data-page-prev' + (currentPage === 1 ? ' disabled' : '') + '><i class="bi bi-arrow-left" aria-hidden="true"></i><span>Previous</span></button>' + pageButtons + '<button type="button" class="pagination-button pagination-next" data-page-next' + (currentPage === totalPages ? ' disabled' : '') + '><span>Next</span><i class="bi bi-arrow-right" aria-hidden="true"></i></button></div></div>';
    container.querySelectorAll('[data-page-number]').forEach(function (button) {
      button.addEventListener('click', function () { onChange(Number(button.getAttribute('data-page-number'))); });
    });
    var previous = container.querySelector('[data-page-prev]');
    var next = container.querySelector('[data-page-next]');
    if (previous) previous.addEventListener('click', function () { if (currentPage > 1) onChange(currentPage - 1); });
    if (next) next.addEventListener('click', function () { if (currentPage < totalPages) onChange(currentPage + 1); });
  }

  function scrollToTopOf(element) {
    if (!element) return;
    var top = element.getBoundingClientRect().top + window.scrollY - 112;
    window.scrollTo({ top: Math.max(0, top), behavior: reducedMotion ? 'auto' : 'smooth' });
  }

  if ('IntersectionObserver' in window && !reducedMotion) {
    revealObserver = new IntersectionObserver(function (entries, observer) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        entry.target.classList.add('is-visible');
        observer.unobserve(entry.target);
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -36px 0px' });
  }

  registerReveal(document.querySelectorAll('.hero-copy, .hero-media, .section-heading, .category-card, .product-card, .feature-card, .benefit-card, .step-card, .process-card, .team-card, .mission-card, .value-card, .contact-card, .contact-grid, .story-grid, .map-teaser, .form-layout, .cta-band, .page-hero-grid, .form-card, .form-aside, .ceo-message, .proof-item, .network-motion-heading, .network-stat, .supply-step, .franchise-slider, .parallax-showcase-copy, .parallax-showcase-stamp'));

  // Count-up values only start when the reader reaches the relevant section.
  var counterObserver = null;
  if ('IntersectionObserver' in window) {
    counterObserver = new IntersectionObserver(function (entries, observer) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        animateCounter(entry.target);
        observer.unobserve(entry.target);
      });
    }, { threshold: 0.45 });
  }
  document.querySelectorAll('[data-counter]').forEach(function (counter) {
    if (!counterObserver || reducedMotion) animateCounter(counter);
    else counterObserver.observe(counter);
  });

  // Subtle parallax on wide images and the network backdrop.
  var parallaxItems = Array.prototype.slice.call(document.querySelectorAll('[data-parallax]'));
  var parallaxFrame = false;
  var heroLayers = Array.prototype.slice.call(document.querySelectorAll('[data-hero-parallax]'));
  function updateParallax() {
    parallaxFrame = false;
    if (reducedMotion) return;
    heroLayers.forEach(function (layer) {
      layer.style.setProperty('--parallax-offset', Math.min(window.scrollY * 0.22, 130).toFixed(1) + 'px');
    });
    parallaxItems.forEach(function (element) {
      var rect = element.getBoundingClientRect();
      if (rect.bottom < -150 || rect.top > window.innerHeight + 150) return;
      var depth = parseFloat(element.getAttribute('data-parallax')) || 0.035;
      var limit = Math.max(22, depth * 900);
      var centerDistance = rect.top + rect.height / 2 - window.innerHeight / 2;
      var offset = Math.max(-limit, Math.min(limit, centerDistance * -depth));
      element.style.setProperty('--parallax-offset', offset.toFixed(1) + 'px');
    });
  }
  function scheduleParallax() {
    if (!parallaxFrame) {
      parallaxFrame = true;
      window.requestAnimationFrame(updateParallax);
    }
  }
  if ((parallaxItems.length || heroLayers.length) && !reducedMotion) {
    window.addEventListener('scroll', scheduleParallax, { passive: true });
    window.addEventListener('resize', scheduleParallax, { passive: true });
    scheduleParallax();
  }

  // The wholesale-to-branch path draws itself in when its section appears.
  var progressFlow = document.querySelector('[data-progress-flow]');
  if (progressFlow && 'IntersectionObserver' in window && !reducedMotion) {
    var flowObserver = new IntersectionObserver(function (entries, observer) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          progressFlow.classList.add('is-in-view');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.25 });
    flowObserver.observe(progressFlow);
  } else if (progressFlow) {
    progressFlow.classList.add('is-in-view');
  }

  var stepTimeline = document.querySelector('[data-step-timeline]');
  if (stepTimeline && 'IntersectionObserver' in window && !reducedMotion) {
    var stepTimelineObserver = new IntersectionObserver(function (entries, observer) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          stepTimeline.classList.add('is-in-view');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.18 });
    stepTimelineObserver.observe(stepTimeline);
  } else if (stepTimeline) {
    stepTimeline.classList.add('is-in-view');
  }

  // Image-led franchise slider. Visitors control the slides; no aggressive auto-rotation.
  var franchiseSlider = document.querySelector('[data-franchise-slider]');
  if (franchiseSlider) {
    var sliderTrack = franchiseSlider.querySelector('[data-slider-track]');
    var sliderSlides = Array.prototype.slice.call(franchiseSlider.querySelectorAll('[data-franchise-slide]'));
    var sliderDots = Array.prototype.slice.call(franchiseSlider.querySelectorAll('[data-slide-to]'));
    var sliderCounter = franchiseSlider.querySelector('[data-slider-current]');
    var sliderIndex = 0;
    function showFranchiseSlide(nextIndex) {
      if (!sliderSlides.length) return;
      sliderIndex = (nextIndex + sliderSlides.length) % sliderSlides.length;
      if (sliderTrack) sliderTrack.style.transform = 'translate3d(' + (-sliderIndex * 100) + '%, 0, 0)';
      sliderSlides.forEach(function (slide, index) {
        var active = index === sliderIndex;
        slide.classList.toggle('is-active', active);
        slide.setAttribute('aria-hidden', active ? 'false' : 'true');
        if ('inert' in slide) slide.inert = !active;
      });
      sliderDots.forEach(function (dot, index) {
        var active = index === sliderIndex;
        dot.classList.toggle('is-active', active);
        if (active) dot.setAttribute('aria-current', 'true');
        else dot.removeAttribute('aria-current');
      });
      if (sliderCounter) sliderCounter.textContent = String(sliderIndex + 1).padStart(2, '0');
    }
    var sliderPrevious = franchiseSlider.querySelector('[data-slider-prev]');
    var sliderNext = franchiseSlider.querySelector('[data-slider-next]');
    if (sliderPrevious) sliderPrevious.addEventListener('click', function () { showFranchiseSlide(sliderIndex - 1); });
    if (sliderNext) sliderNext.addEventListener('click', function () { showFranchiseSlide(sliderIndex + 1); });
    sliderDots.forEach(function (dot) { dot.addEventListener('click', function () { showFranchiseSlide(Number(dot.getAttribute('data-slide-to'))); }); });
    franchiseSlider.addEventListener('keydown', function (event) {
      if (event.key === 'ArrowRight') { event.preventDefault(); showFranchiseSlide(sliderIndex + 1); }
      if (event.key === 'ArrowLeft') { event.preventDefault(); showFranchiseSlide(sliderIndex - 1); }
    });
    var touchStartX = null;
    franchiseSlider.addEventListener('touchstart', function (event) { touchStartX = event.changedTouches && event.changedTouches[0] ? event.changedTouches[0].clientX : null; }, { passive: true });
    franchiseSlider.addEventListener('touchend', function (event) {
      if (touchStartX === null || !event.changedTouches || !event.changedTouches[0]) return;
      var delta = event.changedTouches[0].clientX - touchStartX;
      if (Math.abs(delta) > 45) showFranchiseSlide(sliderIndex + (delta < 0 ? 1 : -1));
      touchStartX = null;
    }, { passive: true });
    showFranchiseSlide(0);
  }

  // Bottom pagination for the longer category directory.
  var categoryGrid = document.querySelector('[data-category-pagination]');
  if (categoryGrid) {
    var categoryCards = Array.prototype.slice.call(categoryGrid.querySelectorAll('.category-card'));
    var categoryPageSize = 6;
    var categoryPage = 1;
    var categoryPages = Math.max(1, Math.ceil(categoryCards.length / categoryPageSize));
    var categoryPagination = document.createElement('nav');
    categoryPagination.className = 'animated-pagination';
    categoryPagination.setAttribute('aria-label', 'Product category pages');
    categoryGrid.insertAdjacentElement('afterend', categoryPagination);
    function showCategoryPage(nextPage) {
      categoryPage = Math.min(categoryPages, Math.max(1, nextPage));
      categoryCards.forEach(function (card, index) {
        var visible = index >= (categoryPage - 1) * categoryPageSize && index < categoryPage * categoryPageSize;
        card.hidden = !visible;
        if (visible) {
          card.classList.remove('page-item-enter');
          void card.offsetWidth;
          card.classList.add('page-item-enter');
        }
      });
      renderPagination(categoryPagination, categoryPage, categoryPages, categoryCards.length, categoryPageSize, 'categories', showCategoryPage);
    }
    showCategoryPage(1);
  }
  function setPageReady() {
    window.setTimeout(function () { document.body.classList.add('page-ready'); }, 360);
  }
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', setPageReady);
  else setPageReady();

  var header = document.getElementById('siteHeader');
  var backTop = document.querySelector('[data-back-top]');
  function handleScroll() {
    if (header) header.classList.toggle('scrolled', window.scrollY > 12);
    if (backTop) backTop.classList.toggle('visible', window.scrollY > 500);
  }
  window.addEventListener('scroll', handleScroll, {passive:true});
  handleScroll();
  document.querySelectorAll('[data-current-year]').forEach(function (node) { node.textContent = String(new Date().getFullYear()); });

  // Mobile navigation: animated panel, Escape/outside-click close, focus moved in and restored, Tab kept inside while open.
  var menuToggle = document.querySelector('[data-menu-toggle]');
  var navPanel = document.querySelector('[data-nav-panel]');
  if (menuToggle && navPanel) {
    var mobileNav = window.matchMedia('(max-width: 1080px)');
    function navFocusables() { return Array.prototype.slice.call(navPanel.querySelectorAll('a[href],button')); }
    function setNav(open, returnFocus) {
      navPanel.classList.toggle('open', open);
      menuToggle.setAttribute('aria-expanded', String(open));
      menuToggle.setAttribute('aria-label', open ? 'Close navigation menu' : 'Open navigation menu');
      if (mobileNav.matches) {
        if ('inert' in navPanel) navPanel.inert = !open;
      }
      if (open && mobileNav.matches) { var first = navFocusables()[0]; if (first) window.setTimeout(function () { first.focus({preventScroll:true}); }, 60); }
      if (!open && returnFocus) menuToggle.focus({preventScroll:true});
    }
    function syncNav() { if ('inert' in navPanel) navPanel.inert = mobileNav.matches && !navPanel.classList.contains('open'); if (!mobileNav.matches) navPanel.classList.remove('open'); menuToggle.setAttribute('aria-expanded', String(navPanel.classList.contains('open'))); }
    syncNav();
    if (mobileNav.addEventListener) mobileNav.addEventListener('change', syncNav); else if (mobileNav.addListener) mobileNav.addListener(syncNav);
    menuToggle.addEventListener('click', function () { setNav(!navPanel.classList.contains('open'), false); });
    navPanel.addEventListener('click', function (event) { if (event.target.closest('a')) setNav(false, false); });
    document.addEventListener('keydown', function (event) {
      if (!navPanel.classList.contains('open') || !mobileNav.matches) return;
      if (event.key === 'Escape') { setNav(false, true); return; }
      if (event.key === 'Tab') {
        var items = navFocusables().concat([menuToggle]);
        var firstItem = items[0], lastItem = items[items.length - 1];
        // Order in DOM: toggle first, then panel links; keep Tab cycling within toggle + panel.
        var ordered = [menuToggle].concat(navFocusables());
        firstItem = ordered[0]; lastItem = ordered[ordered.length - 1];
        if (event.shiftKey && document.activeElement === firstItem) { event.preventDefault(); lastItem.focus(); }
        else if (!event.shiftKey && document.activeElement === lastItem) { event.preventDefault(); firstItem.focus(); }
      }
    });
    document.addEventListener('click', function (event) {
      if (navPanel.classList.contains('open') && mobileNav.matches && !navPanel.contains(event.target) && !menuToggle.contains(event.target)) setNav(false, false);
    });
  }
  if (backTop) backTop.addEventListener('click', function () { window.scrollTo({top:0,behavior:window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth'}); });

  // Catalogue page: products come from the database (window.POUND_STORE_CATALOGUE, set in category.blade.php).
  var productRoot = document.querySelector('[data-product-grid]');
  if (productRoot) {
    var catalogue = window.POUND_STORE_CATALOGUE || {};
    var allProducts = Array.isArray(catalogue.products) ? catalogue.products : [];
    var outletsUrl = productRoot.getAttribute('data-outlets-url') || '#';
    var countNode = document.querySelector('[data-product-count]');
    var searchNode = document.querySelector('[data-product-search]');
    var sortNode = document.querySelector('[data-product-sort]');
    var productPagination = document.querySelector('[data-product-pagination]');
    var productPageSize = 8;
    var productPage = 1;
    function formatPrice(value) {
      var price = Number(value) || 0;
      if (price <= 0) return 'Ask in store';
      return 'PKR ' + price.toLocaleString('en-PK', {minimumFractionDigits: 0, maximumFractionDigits: 2});
    }
    function renderProducts() {
      var term = searchNode ? searchNode.value.trim().toLowerCase() : '';
      var sorted = allProducts.filter(function (item) {
        return !term || (item.name + ' ' + (item.tag || '')).toLowerCase().indexOf(term) !== -1;
      });
      if (sortNode && sortNode.value === 'name') sorted.sort(function (a,b) { return a.name.localeCompare(b.name); });
      if (sortNode && sortNode.value === 'price-low') sorted.sort(function (a,b) { return a.price - b.price; });
      if (sortNode && sortNode.value === 'price-high') sorted.sort(function (a,b) { return b.price - a.price; });
      if (countNode) countNode.textContent = plural(sorted.length, 'item', 'items');
      var totalPages = Math.max(1, Math.ceil(sorted.length / productPageSize));
      productPage = Math.min(productPage, totalPages);
      if (!sorted.length) {
        var emptyTitle = allProducts.length ? 'No products match that search' : 'No products in this category yet';
        var emptyText = allProducts.length ? 'Try another keyword or clear the search field.' : 'Please check back soon or visit a store to see what is available.';
        productRoot.innerHTML = '<div class="empty-products"><i class="bi bi-search" aria-hidden="true"></i><h3>' + emptyTitle + '</h3><p>' + emptyText + '</p></div>';
        if (productPagination) { productPagination.hidden = true; productPagination.innerHTML = ''; }
        return;
      }
      var pageItems = sorted.slice((productPage - 1) * productPageSize, productPage * productPageSize);
      productRoot.innerHTML = pageItems.map(function (item) {
        var badge = item.tag ? '<span class="product-badge">' + escapeHtml(item.tag) + '</span>' : '';
        return '<article class="product-card"><div class="product-image"><img src="' + escapeHtml(item.image) + '" alt="' + escapeHtml(item.name) + '" loading="lazy" decoding="async">' + badge + '</div><div class="product-content"><p class="product-category">' + escapeHtml(item.category) + '</p><h3>' + escapeHtml(item.name) + '</h3><div class="product-price-row"><div class="product-price"><small>Price</small>' + escapeHtml(formatPrice(item.price)) + '</div><a class="product-link" href="' + escapeHtml(outletsUrl) + '">Find a store <i class="bi bi-arrow-up-right" aria-hidden="true"></i></a></div></div></article>';
      }).join('');
      registerReveal(productRoot.querySelectorAll('.product-card'));
      if (productPagination) renderPagination(productPagination, productPage, totalPages, sorted.length, productPageSize, 'products', function (nextPage) {
        productPage = nextPage;
        renderProducts();
        scrollToTopOf(productRoot);
      });
    }
    if (searchNode) searchNode.addEventListener('input', function () { productPage = 1; renderProducts(); });
    if (sortNode) sortNode.addEventListener('change', function () { productPage = 1; renderProducts(); });
    renderProducts();
  }

  // Interactive city-level branch overview using OpenStreetMap/Leaflet. Exact shop pins are not available in source data.
  var mapElement = document.getElementById('branchMap');
  if (mapElement) {
    var cityListings = Array.isArray(window.POUND_STORE_CITY_LISTINGS) ? window.POUND_STORE_CITY_LISTINGS.slice() : [];
    var mappableCities = cityListings.filter(hasCoords);
    var citySearch = document.querySelector('[data-city-search]');
    var cityList = document.querySelector('[data-city-list]');
    var cityTotal = document.querySelector('[data-city-total]');
    var mapStatus = document.querySelector('[data-map-status]');
    var map;
    var markersByCity = {};
    function renderCityList() {
      if (!cityList) return;
      var term = citySearch ? citySearch.value.trim().toLowerCase() : '';
      var matches = cityListings.filter(function (item) { return !term || item.city.toLowerCase().indexOf(term) !== -1; });
      cityList.innerHTML = matches.map(function (item) {
        return '<button type="button" class="city-result city-result-button" data-city-jump="' + escapeHtml(item.city) + '"><span><strong>' + escapeHtml(item.city) + '</strong><small>' + plural(item.count, 'active outlet', 'active outlets') + '</small></span><span class="city-count" aria-label="' + item.count + ' listings">' + item.count + '</span></button>';
      }).join('') || '<div class="city-result"><div><h3>No city found</h3><p>Try a different search.</p></div></div>';
      if (cityTotal) cityTotal.textContent = matches.length + ' of ' + plural(cityListings.length, 'city', 'cities') + ' with active outlets';
    }
    if (citySearch) citySearch.addEventListener('input', renderCityList);
    if (cityList) {
      cityList.addEventListener('click', function (event) {
        var button = event.target.closest('[data-city-jump]');
        var cityName = button && button.getAttribute('data-city-jump');
        if (!cityName || !map || !markersByCity[cityName]) return;
        var item = mappableCities.find(function (record) { return record.city === cityName; });
        if (!item) return;
        map.flyTo([item.lat, item.lon], 10, {duration:0.45});
        markersByCity[cityName].openPopup();
      });
      cityList.addEventListener('keydown', function (event) {
        if ((event.key === 'Enter' || event.key === ' ') && event.target.matches('[data-city-jump]')) { event.preventDefault(); event.target.click(); }
      });
    }
    renderCityList();
    if (window.L && mappableCities.length) {
      map = window.L.map(mapElement, {scrollWheelZoom:false, zoomControl:true}).setView([31.8,73.4], 6);
      window.L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom:18,
        attribution:'&copy; <a href="https://www.openstreetmap.org/copyright" target="_blank" rel="noopener noreferrer">OpenStreetMap</a> contributors'
      }).addTo(map);
      var markerBounds = [];
      mappableCities.forEach(function (item) {
        var icon = window.L.divIcon({className:'',html:'<span class="branch-marker">' + item.count + '</span>',iconSize:[32,32],iconAnchor:[16,16]});
        var marker = window.L.marker([item.lat,item.lon],{icon:icon}).addTo(map);
        marker.bindPopup('<strong>' + escapeHtml(item.city) + '</strong><span>' + plural(item.count, 'active outlet', 'active outlets') + '</span><small>Approximate city-centre marker. Use an outlet card for branch directions.</small>');
        markersByCity[item.city] = marker;
        markerBounds.push([item.lat,item.lon]);
      });
      map.fitBounds(markerBounds,{padding:[24,24],maxZoom:7});
      if (mapStatus) mapStatus.textContent = plural(cityListings.reduce(function (sum,item) { return sum + item.count; },0), 'active outlet', 'active outlets') + ' across ' + plural(cityListings.length, 'city', 'cities');
    } else if (mapStatus) {
      mapStatus.textContent = cityListings.length ? 'The map is unavailable. Use the city list and outlet directory below.' : 'No active outlets have been published yet.';
    }
  }

  // Outlet directory: one card per active outlet (window.POUND_STORE_OUTLETS, built from the admin panel).
  var outletDirectory = document.querySelector('[data-outlet-directory]');
  if (outletDirectory) {
    var directoryGrid = outletDirectory.querySelector('[data-outlet-grid]');
    var directorySearch = outletDirectory.querySelector('[data-outlet-search]');
    var directorySort = outletDirectory.querySelector('[data-outlet-sort]');
    var directoryLoadMore = outletDirectory.querySelector('[data-outlet-load-more]');
    var directoryCount = outletDirectory.querySelector('[data-outlet-result-count]');
    var directoryStatus = outletDirectory.querySelector('[data-outlet-pagination-status]');
    var directoryItems = Array.isArray(window.POUND_STORE_OUTLETS) ? window.POUND_STORE_OUTLETS.slice() : [];
    var directoryPageSize = 9;
    var directoryVisibleCount = directoryPageSize;
    var outletTypeLabels = {retail_store: 'Retail store', warehouse: 'Warehouse', head_office: 'Head office'};

    function filterOutlets() {
      var term = directorySearch ? directorySearch.value.trim().toLowerCase() : '';
      var matches = directoryItems.filter(function (item) {
        if (!term) return true;
        return [item.name, item.city, item.area, item.address, item.landmark, item.branch_code].join(' ').toLowerCase().indexOf(term) !== -1;
      });
      if (directorySort && directorySort.value === 'az') {
        matches.sort(function (a, b) { return a.name.localeCompare(b.name); });
      } else if (directorySort && directorySort.value === 'za') {
        matches.sort(function (a, b) { return b.name.localeCompare(a.name); });
      } // "Featured first" keeps the order sent by the server (featured, sort order, name).
      return matches;
    }

    function outletCard(item, index) {
      var directions = safeUrl(item.directions_url);
      var address = [item.address, item.area].filter(Boolean).join(', ');
      if (item.landmark) address += ' · Near ' + item.landmark;
      var typeLabel = outletTypeLabels[item.outlet_type] || 'Outlet';
      var featured = item.is_featured ? '<span class="outlet-count-badge"><strong><i class="bi bi-star-fill" aria-hidden="true"></i></strong><small>Featured</small></span>' : '';
      var footerLeft = item.phone ? '<i class="bi bi-telephone" aria-hidden="true"></i> ' + escapeHtml(item.phone) : '<i class="bi bi-info-circle" aria-hidden="true"></i> Call the team for details';
      return '<article class="outlet-card" style="--reveal-delay:' + ((index % 3) * 85) + 'ms">' +
        '<a class="outlet-card-image" href="' + escapeHtml(directions) + '" target="_blank" rel="noopener noreferrer" aria-label="Get directions to ' + escapeHtml(item.name) + '">' +
        '<img src="' + escapeHtml(item.image) + '" alt="' + escapeHtml(item.name) + '" loading="lazy" decoding="async">' +
        '<span class="outlet-image-badge"><i class="bi bi-geo-alt-fill" aria-hidden="true"></i> ' + escapeHtml(typeLabel) + '</span>' +
        '<span class="outlet-image-arrow" aria-hidden="true"><i class="bi bi-arrow-up-right"></i></span></a>' +
        '<div class="outlet-card-body"><div class="outlet-card-title-row"><div><span class="outlet-card-kicker">' + escapeHtml(item.city || 'Pakistan') + '</span><h3>' + escapeHtml(item.name) + '</h3></div>' + featured + '</div>' +
        '<p class="outlet-card-address"><i class="bi bi-pin-map" aria-hidden="true"></i><span>' + escapeHtml(address) + '<br>' + escapeHtml(item.hours_today || '') + '</span></p>' +
        '<div class="outlet-card-footer"><span>' + footerLeft + '</span><a href="' + escapeHtml(directions) + '" target="_blank" rel="noopener noreferrer">Get directions <i class="bi bi-arrow-up-right" aria-hidden="true"></i></a></div></div></article>';
    }

    function renderOutletDirectory() {
      if (!directoryGrid) return;
      var matches = filterOutlets();
      if (directoryCount) directoryCount.textContent = String(matches.length);
      if (!matches.length) {
        var none = directoryItems.length ? 'No outlet matched your search' : 'No outlets published yet';
        var hint = directoryItems.length ? 'Try another outlet name, city or area, or clear your search.' : 'Please check back soon.';
        directoryGrid.innerHTML = '<div class="outlet-empty-state"><span class="outlet-empty-icon"><i class="bi bi-search" aria-hidden="true"></i></span><h3>' + none + '</h3><p>' + hint + '</p></div>';
        if (directoryLoadMore) directoryLoadMore.hidden = true;
        if (directoryStatus) directoryStatus.textContent = 'No outlets found';
        return;
      }
      var visibleItems = matches.slice(0, directoryVisibleCount);
      directoryGrid.innerHTML = visibleItems.map(outletCard).join('');
      registerReveal(directoryGrid.querySelectorAll('.outlet-card'));
      if (directoryStatus) directoryStatus.textContent = 'Showing ' + visibleItems.length + ' of ' + plural(matches.length, 'outlet', 'outlets');
      if (directoryLoadMore) {
        directoryLoadMore.hidden = matches.length <= directoryPageSize;
        directoryLoadMore.innerHTML = directoryVisibleCount >= matches.length
          ? 'Show fewer outlets <i class="bi bi-arrow-up-circle" aria-hidden="true"></i>'
          : 'Show more outlets <i class="bi bi-arrow-down-circle" aria-hidden="true"></i>';
      }
    }

    if (directorySearch) directorySearch.addEventListener('input', function () {
      directoryVisibleCount = directoryPageSize;
      renderOutletDirectory();
    });
    if (directorySort) directorySort.addEventListener('change', function () {
      directoryVisibleCount = directoryPageSize;
      renderOutletDirectory();
    });
    if (directoryLoadMore) directoryLoadMore.addEventListener('click', function () {
      var matchesCount = filterOutlets().length;
      directoryVisibleCount = directoryVisibleCount >= matchesCount ? directoryPageSize : Math.min(directoryVisibleCount + directoryPageSize, matchesCount);
      renderOutletDirectory();
      if (directoryVisibleCount === directoryPageSize && matchesCount > directoryPageSize) {
        var directoryHeading = document.getElementById('outletDirectoryTitle');
        if (directoryHeading) directoryHeading.scrollIntoView({behavior: reducedMotion ? 'auto' : 'smooth', block: 'start'});
      }
    });
    renderOutletDirectory();
  }

  // Accordion FAQs: height-animated open/close, still works with motion reduced.
  document.querySelectorAll('[data-faq-question]').forEach(function (button) {
    var panel = button.nextElementSibling;
    button.addEventListener('click', function () {
      if (!panel) return;
      var expanded = button.getAttribute('aria-expanded') === 'true';
      button.setAttribute('aria-expanded', String(!expanded));
      if (reducedMotion) { panel.hidden = expanded; return; }
      var done = function () { panel.style.height = ''; if (expanded) panel.hidden = true; };
      if (!expanded) {
        panel.hidden = false;
        var target = panel.scrollHeight;
        panel.style.height = '0px';
        void panel.offsetHeight;
        panel.style.height = target + 'px';
      } else {
        panel.style.height = panel.scrollHeight + 'px';
        void panel.offsetHeight;
        panel.style.height = '0px';
      }
      var finished = false;
      var finish = function () { if (finished) return; finished = true; done(); };
      panel.addEventListener('transitionend', function handler(e) { if (e.target !== panel) return; panel.removeEventListener('transitionend', handler); finish(); });
      window.setTimeout(finish, 500);
    });
  });

  // Franchise + Contact forms: validate in the browser, then send to Laravel with fetch.
  // Forms use the data-ajax-form attribute. The URL comes from the form's action attribute.
  document.querySelectorAll('[data-ajax-form]').forEach(function (form) {
    var status = form.querySelector('[data-form-status]');
    var submitButton = form.querySelector('button[type="submit"]');

    function setError(field, message) {
      var holder = field.closest('.field');
      var existing = holder && holder.querySelector('.field-error');
      if (message) {
        if (holder && !existing) { existing = document.createElement('span'); existing.className = 'field-error'; existing.id = (field.id || field.name) + 'Error'; holder.appendChild(existing); }
        if (existing) { existing.textContent = message; field.setAttribute('aria-describedby', existing.id); }
      } else if (existing) { existing.remove(); field.removeAttribute('aria-describedby'); }
    }

    function showStatus(message, isError) {
      if (!status) return;
      status.classList.add('show');
      status.classList.toggle('is-error', !!isError);
      status.textContent = message;
    }

    // Returns the first invalid field, or null when everything is fine.
    function validate() {
      var firstInvalid = null;
      form.querySelectorAll('input,select,textarea').forEach(function (field) {
        if (field.type === 'hidden' || field.name === 'hp_check') return;
        var value = String(field.value || '').trim();
        var message = '';
        if (field.required && !value) message = 'This field is required.';
        else if (field.type === 'email' && value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) message = 'Enter a valid email address.';
        else if (field.name === 'phone' && value && value.replace(/\D/g, '').length < 10) message = 'Enter a phone number with at least 10 digits.';
        field.setAttribute('aria-invalid', message ? 'true' : 'false');
        field.classList.toggle('field-invalid', !!message);
        field.classList.toggle('field-valid', !message && !!value);
        setError(field, message);
        if (message && !firstInvalid) firstInvalid = field;
      });
      return firstInvalid;
    }

    form.addEventListener('submit', function (event) {
      event.preventDefault();

      var firstInvalid = validate();
      if (firstInvalid) {
        showStatus('Please fix the highlighted fields.', true);
        firstInvalid.focus();
        return;
      }

      var originalLabel = submitButton ? submitButton.innerHTML : '';
      if (submitButton) { submitButton.disabled = true; submitButton.textContent = 'Sending...'; }
      showStatus('Sending, please wait...', false);

      fetch(form.action, {
        method: 'POST',
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        body: new FormData(form) // includes the CSRF _token field from @csrf
      })
        .then(function (response) {
          return response.json().catch(function () { return {}; }).then(function (data) {
            return { ok: response.ok, status: response.status, data: data };
          });
        })
        .then(function (result) {
          if (result.ok) {
            form.reset();
            form.querySelectorAll('input,select,textarea').forEach(function (field) {
              field.classList.remove('field-valid', 'field-invalid');
              field.removeAttribute('aria-invalid');
            });
            showStatus(result.data.message || 'Thank you! Your message has been sent.', false);
          } else if (result.status === 422 && result.data.errors) {
            // Laravel validation errors: { errors: { fieldName: ['message'] } }
            var firstField = null;
            Object.keys(result.data.errors).forEach(function (name) {
              var field = form.querySelector('[name="' + name + '"]');
              if (!field) return;
              field.classList.add('field-invalid');
              field.setAttribute('aria-invalid', 'true');
              setError(field, result.data.errors[name][0]);
              if (!firstField) firstField = field;
            });
            showStatus('Please fix the highlighted fields.', true);
            if (firstField) firstField.focus();
          } else if (result.status === 429) {
            showStatus('Too many attempts. Please wait a minute and try again.', true);
          } else {
            showStatus('Something went wrong. Please try again, or call us on 0347 0006050.', true);
          }
        })
        .catch(function () {
          showStatus('Could not reach the server. Please check your connection and try again.', true);
        })
        .then(function () {
          if (submitButton) { submitButton.disabled = false; submitButton.innerHTML = originalLabel; }
        });
    });

    form.querySelectorAll('input,select,textarea').forEach(function (field) {
      field.addEventListener('input', function () {
        field.classList.remove('field-invalid');
        field.setAttribute('aria-invalid', 'false');
        setError(field, '');
      });
    });
  });

  // Image failures should remain graceful for demo/preview deployments without external connectivity.
  document.addEventListener('error', function (event) {
    var target = event.target;
    if (target && target.tagName === 'IMG' && target.dataset.fallbackApplied !== '1') {
      target.dataset.fallbackApplied = '1';
      target.style.display = 'none';
      target.alt = target.alt || 'Image preview unavailable offline';
    }
  }, true);

  /* ======================================================================
     v4 interaction modules
     ====================================================================== */

  // Make sure every [data-reveal] element is observed (manual markup) and can never stay hidden.
  (function initReveals() {
    var pending = Array.prototype.slice.call(document.querySelectorAll('[data-reveal]:not(.is-visible)'));
    if (!pending.length) return;
    if (!revealObserver || reducedMotion) { pending.forEach(function (el) { el.classList.add('is-visible'); }); return; }
    pending.forEach(function (el) { revealObserver.observe(el); });
    // Safety net: anything still hidden after 4s (observer quirks, print, background tabs) is shown.
    window.setTimeout(function () { pending.forEach(function (el) { el.classList.add('is-visible'); }); }, 4000);
  })();

  // Hero video: show it only once it is really playing; otherwise the poster/gradient stays.
  (function initHeroVideo() {
    var video = document.querySelector('[data-hero-video]');
    if (!video) return;
    function fail() { video.classList.remove('is-playing'); video.style.display = 'none'; }
    var source = video.querySelector('source');
    if (source) source.addEventListener('error', fail);
    video.addEventListener('error', fail);
    video.addEventListener('playing', function () { video.classList.add('is-playing'); });
    if (reducedMotion) { video.removeAttribute('autoplay'); video.pause && video.pause(); video.style.display = 'none'; return; }
    var attempt = video.play && video.play();
    if (attempt && attempt.catch) attempt.catch(fail);
  })();

  // Scroll-driven journeys (sourcing story + franchise steps). Uses scroll position + rAF; no pinning or scroll hijacking.
  (function initJourneys() {
    var journeys = Array.prototype.slice.call(document.querySelectorAll('[data-journey]'));
    if (!journeys.length) return;
    var states = journeys.map(function (root) {
      return {
        root: root,
        list: root.querySelector('.journey-list'),
        steps: Array.prototype.slice.call(root.querySelectorAll('[data-journey-step]')),
        slides: Array.prototype.slice.call(root.querySelectorAll('[data-journey-slide]')),
        active: -2
      };
    });
    var ticking = false;
    function update() {
      ticking = false;
      var vh = window.innerHeight || document.documentElement.clientHeight;
      var trigger = vh * 0.55;
      states.forEach(function (st) {
        // read phase
        var listRect = st.list.getBoundingClientRect();
        if (listRect.bottom < -200 || listRect.top > vh + 200) { if (st.active !== -2) return; }
        var tops = st.steps.map(function (step) { return step.getBoundingClientRect(); });
        var active = -1;
        tops.forEach(function (r, i) { if (r.top < trigger) active = i; });
        var first = tops[0], last = tops[tops.length - 1];
        var startY = first.top + 29, endY = last.top + 29;
        var progress = endY === startY ? 1 : (trigger - startY) / (endY - startY);
        progress = Math.max(0, Math.min(1, progress));
        // write phase
        st.root.style.setProperty('--p', progress.toFixed(4));
        if (active !== st.active) {
          st.active = active;
          st.steps.forEach(function (step, i) {
            step.classList.toggle('is-done', i < active);
            step.classList.toggle('is-active', i === active);
          });
          st.slides.forEach(function (slide, i) {
            slide.classList.toggle('is-active', i === Math.max(active, 0));
            slide.classList.toggle('is-past', i < Math.max(active, 0));
          });
        }
      });
    }
    function schedule() { if (!ticking) { ticking = true; window.requestAnimationFrame(update); } }
    states.forEach(function (st) { st.root.classList.add('is-live'); });
    window.addEventListener('scroll', schedule, { passive: true });
    window.addEventListener('resize', schedule, { passive: true });
    update();
  })();

  // Buttons: ripple on press, restrained magnetic pull on opted-in buttons (fine pointers only).
  (function initButtons() {
    var finePointer = window.matchMedia && window.matchMedia('(hover: hover) and (pointer: fine)').matches;
    document.addEventListener('pointerdown', function (event) {
      var btn = event.target.closest && event.target.closest('.btn');
      if (!btn || reducedMotion) return;
      var rect = btn.getBoundingClientRect();
      var size = Math.max(rect.width, rect.height);
      var dot = document.createElement('span');
      dot.className = 'ripple';
      dot.style.cssText = 'width:' + size + 'px;height:' + size + 'px;left:' + (event.clientX - rect.left - size / 2) + 'px;top:' + (event.clientY - rect.top - size / 2) + 'px';
      btn.appendChild(dot);
      window.setTimeout(function () { dot.remove(); }, 650);
    }, { passive: true });
    if (!finePointer || reducedMotion) return;
    document.querySelectorAll('[data-magnetic]').forEach(function (btn) {
      btn.addEventListener('pointermove', function (event) {
        var r = btn.getBoundingClientRect();
        var x = (event.clientX - (r.left + r.width / 2)) / r.width;
        var y = (event.clientY - (r.top + r.height / 2)) / r.height;
        btn.style.setProperty('--mx', (x * 8).toFixed(1) + 'px');
        btn.style.setProperty('--my', (y * 6).toFixed(1) + 'px');
      });
      btn.addEventListener('pointerleave', function () { btn.style.removeProperty('--mx'); btn.style.removeProperty('--my'); });
    });
  })();

  // Custom cursor: desktop fine pointers only, never when reduced motion is on. Native cursor stays visible.
  (function initCursor() {
    if (reducedMotion || !window.matchMedia) return;
    if (!window.matchMedia('(hover: hover) and (pointer: fine)').matches || window.innerWidth < 1024) return;
    var dot = document.createElement('div'); dot.className = 'cursor-dot'; dot.setAttribute('aria-hidden', 'true');
    var ring = document.createElement('div'); ring.className = 'cursor-ring'; ring.setAttribute('aria-hidden', 'true');
    document.body.appendChild(ring); document.body.appendChild(dot);
    var x = -100, y = -100, rx = -100, ry = -100, running = false, shown = false;
    function loop() {
      rx += (x - rx) * 0.28; ry += (y - ry) * 0.28;
      dot.style.transform = 'translate3d(' + x + 'px,' + y + 'px,0)';
      ring.style.transform = 'translate3d(' + rx + 'px,' + ry + 'px,0)';
      if (Math.abs(x - rx) > 0.1 || Math.abs(y - ry) > 0.1) window.requestAnimationFrame(loop); else running = false;
    }
    document.addEventListener('pointermove', function (e) {
      if (e.pointerType && e.pointerType !== 'mouse') return;
      x = e.clientX; y = e.clientY;
      if (!shown) { shown = true; rx = x; ry = y; document.documentElement.classList.add('cursor-on'); }
      if (!running) { running = true; window.requestAnimationFrame(loop); }
      var t = e.target.closest ? e.target : null;
      var text = !!(t && t.closest('input:not([type=checkbox]):not([type=radio]):not([type=submit]),textarea,select,[contenteditable]'));
      var link = !text && !!(t && t.closest('a,button,[role=button],.cat-tile,.city-chip,summary,label'));
      ring.classList.toggle('is-link', link); ring.classList.toggle('is-text', text); dot.classList.toggle('is-text', text);
    }, { passive: true });
    document.addEventListener('mouseleave', function () { document.documentElement.classList.remove('cursor-on'); shown = false; });
    window.addEventListener('blur', function () { document.documentElement.classList.remove('cursor-on'); shown = false; });
  })();

  // Homepage network map: approximate city-level markers from the active cities in the admin panel, with a visible fallback.
  (function initHomeMap() {
    var el = document.getElementById('homeMap');
    if (!el) return;
    var frame = el.closest('.netmap-frame');
    var listings = Array.isArray(window.POUND_STORE_CITY_LISTINGS) ? window.POUND_STORE_CITY_LISTINGS.slice() : [];
    var mappable = listings.filter(hasCoords);
    var card = document.querySelector('[data-map-card]');
    var cityNode = document.querySelector('[data-map-city]');
    var countNode = document.querySelector('[data-map-count]');
    var countLabel = document.querySelector('[data-map-count-label]');
    var chipsRoot = document.querySelector('[data-city-chips]');
    var markers = {};
    var map = null, activeCity = null;
    function select(item, fly) {
      if (!item) return;
      activeCity = item.city;
      if (cityNode) cityNode.textContent = item.city;
      if (countNode) countNode.textContent = String(item.count);
      if (countLabel) countLabel.textContent = (item.count === 1 ? 'active outlet' : 'active outlets') + ' in this city';
      if (card) { card.classList.remove('bump'); void card.offsetWidth; card.classList.add('bump'); }
      if (chipsRoot) chipsRoot.querySelectorAll('.city-chip').forEach(function (chip) { var on = chip.getAttribute('data-city') === item.city; chip.classList.toggle('is-active', on); chip.setAttribute('aria-pressed', String(on)); });
      Object.keys(markers).forEach(function (name) { var node = markers[name].getElement && markers[name].getElement(); var inner = node && node.querySelector('.branch-marker'); if (inner) inner.classList.toggle('is-active', name === item.city); });
      if (map && fly && hasCoords(item)) map.flyTo([item.lat, item.lon], Math.max(map.getZoom(), 8), { duration: reducedMotion ? 0 : 0.7 });
    }
    // Chips (also the fallback interaction when the map cannot load): highest listing counts first.
    var top = listings.slice().sort(function (a, b) { return b.count - a.count || a.city.localeCompare(b.city); }).slice(0, 10);
    if (chipsRoot) {
      chipsRoot.innerHTML = top.map(function (item) { return '<li><button type="button" class="city-chip" data-city="' + escapeHtml(item.city) + '" aria-pressed="false">' + escapeHtml(item.city) + '<b>' + item.count + '</b></button></li>'; }).join('');
      chipsRoot.addEventListener('click', function (event) {
        var chip = event.target.closest('.city-chip'); if (!chip) return;
        select(listings.find(function (r) { return r.city === chip.getAttribute('data-city'); }), true);
      });
    }
    if (top[0]) select(top[0], false);
    if (!window.L || !mappable.length) return; // fallback panel stays visible
    try {
      map = window.L.map(el, { scrollWheelZoom: false, zoomControl: true, attributionControl: true }).setView([31.2, 73.4], 6);
      var layer = window.L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 18, attribution: '&copy; <a href="https://www.openstreetmap.org/copyright" target="_blank" rel="noopener noreferrer">OpenStreetMap</a> contributors' }).addTo(map);
      layer.once('tileload', function () { if (frame) frame.classList.add('is-live'); });
      var bounds = [];
      mappable.forEach(function (item) {
        var size = 30 + Math.min(item.count, 5) * 3;
        var icon = window.L.divIcon({ className: '', html: '<span class="branch-marker" style="width:' + size + 'px;height:' + size + 'px">' + item.count + '</span>', iconSize: [size, size], iconAnchor: [size / 2, size / 2] });
        var marker = window.L.marker([item.lat, item.lon], { icon: icon, title: item.city + ': ' + plural(item.count, 'active outlet', 'active outlets') + ' (approximate city marker)', keyboard: true, riseOnHover: true }).addTo(map);
        marker.bindTooltip('<strong>' + escapeHtml(item.city) + '</strong> · ' + plural(item.count, 'outlet', 'outlets'), { direction: 'top', offset: [0, -10], className: 'ps-tip' });
        marker.on('click', function () { select(item, false); });
        markers[item.city] = marker; bounds.push([item.lat, item.lon]);
      });
      map.fitBounds(bounds, { padding: [30, 30], maxZoom: 7 });
      if (activeCity) select(listings.find(function (r) { return r.city === activeCity; }), false);
      window.setTimeout(function () { map.invalidateSize(); }, 350);
    } catch (err) { /* fallback panel remains */ }
  })();



    // Franchise + Contact forms: check the fields in the browser, then let the form submit normally.
  // Forms use the data-validate-form attribute. Laravel handles the saving and shows the result after the page reloads.
  document.querySelectorAll('[data-validate-form]').forEach(function (form) {
    var status = form.querySelector('[data-form-status]');
    var submitButton = form.querySelector('button[type="submit"]');
    var submitLabel = submitButton ? submitButton.innerHTML : '';

    // ---------- Validation rules (edit these to customize) ----------
    // "required", "minlength" and "maxlength" are read from the HTML attributes of each field.
    // The rules below add format checks by field name. Return an error message, or '' when the value is fine.
    var PHONE_CHARS = /^[0-9+\-\s()]+$/;

    function isEmail(value) {
      return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
    }

    function isPhone(value) {
      var digits = value.replace(/\D/g, '').length;
      return PHONE_CHARS.test(value) && digits >= 10 && digits <= 15;
    }

    var formatRules = {
      phone: function (value) {
        return isPhone(value) ? '' : 'Enter a valid phone number (10 to 15 digits, e.g. 0300 1234567).';
      },
      email: function (value) {
        return isEmail(value) ? '' : 'Enter a valid email address.';
      },
      contact: function (value) {
        return (isEmail(value) || isPhone(value)) ? '' : 'Enter a valid phone number or email address.';
      }
    };

    // Returns an error message for one field, or '' when it is valid.
    function getError(field) {
      var value = String(field.value || '').trim();

      if (field.required && !value) return 'This field is required.';
      if (!value) return ''; // optional and empty is fine

      var min = parseInt(field.getAttribute('minlength'), 10);
      var max = parseInt(field.getAttribute('maxlength'), 10);
      if (min && value.length < min) return 'Please enter at least ' + min + ' characters.';
      if (max && value.length > max) return 'Please enter no more than ' + max + ' characters.';

      var rule = formatRules[field.name];
      return rule ? rule(value) : '';
    }

    // ---------- UI helpers ----------
    function setError(field, message) {
      var holder = field.closest('.field');
      var existing = holder && holder.querySelector('.field-error');
      if (message) {
        if (holder && !existing) { existing = document.createElement('span'); existing.className = 'field-error'; existing.id = (field.id || field.name) + 'Error'; holder.appendChild(existing); }
        if (existing) { existing.textContent = message; field.setAttribute('aria-describedby', existing.id); }
      } else if (existing) { existing.remove(); field.removeAttribute('aria-describedby'); }
    }

    function showStatus(message, isError) {
      if (!status) return;
      status.classList.add('show');
      status.classList.toggle('is-error', !!isError);
      status.textContent = message;
    }

    // Validates one field and updates its look. Returns true when valid.
    function checkField(field) {
      var message = getError(field);
      var value = String(field.value || '').trim();
      field.setAttribute('aria-invalid', message ? 'true' : 'false');
      field.classList.toggle('field-invalid', !!message);
      field.classList.toggle('field-valid', !message && !!value);
      setError(field, message);
      return !message;
    }

    // Validates every field. Returns the first invalid field, or null when all are valid.
    function validateForm() {
      var firstInvalid = null;
      form.querySelectorAll('input,select,textarea').forEach(function (field) {
        if (field.type === 'hidden' || field.name === 'hp_check') return;
        if (!checkField(field) && !firstInvalid) firstInvalid = field;
      });
      return firstInvalid;
    }

    // ---------- Submit ----------
    form.addEventListener('submit', function (event) {
      var firstInvalid = validateForm();

      if (firstInvalid) {
        event.preventDefault(); // stop the submit, show the errors
        showStatus('Please fix the highlighted fields.', true);
        firstInvalid.focus();
        return;
      }

      // All good: the browser now posts the form to Laravel. Just prevent double clicks.
      if (submitButton) { submitButton.disabled = true; submitButton.textContent = 'Sending...'; }
    });

    // If the visitor presses the browser Back button, make the button usable again.
    window.addEventListener('pageshow', function () {
      if (submitButton) { submitButton.disabled = false; submitButton.innerHTML = submitLabel; }
    });

    // ---------- Live feedback ----------
    form.querySelectorAll('input,select,textarea').forEach(function (field) {
      if (field.name === 'hp_check') return;

      // While typing: stop the phone field from accepting letters, and clear the old error.
      field.addEventListener('input', function () {
        if (field.name === 'phone') field.value = field.value.replace(/[^0-9+\-\s()]/g, '');
        field.classList.remove('field-invalid');
        field.setAttribute('aria-invalid', 'false');
        setError(field, '');
      });

      // When leaving a field: validate it, but only if the visitor typed something.
      // (Empty required fields are reported on submit, so tabbing past a field is not an error.)
      field.addEventListener('blur', function () {
        if (String(field.value || '').trim() !== '') checkField(field);
      });
    });
  });

})();
