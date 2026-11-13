/* GMBRAND theme – front-end behaviour (vanilla JS, no dependencies).
   Shared by the WordPress theme and the static preview. */
(function () {
  'use strict';

  var $ = function (s, c) { return (c || document).querySelector(s); };
  var $$ = function (s, c) { return Array.prototype.slice.call((c || document).querySelectorAll(s)); };
  var body = document.body;
  var mqDesktop = window.matchMedia('(min-width: 1024px)');
  var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var GM = window.GM = window.GM || {};

  /* ---------- Toast ---------- */
  GM.toast = function (msg) {
    var t = $('.toast');
    if (!t) {
      t = document.createElement('div');
      t.className = 'toast';
      t.setAttribute('role', 'status');
      t.innerHTML = '<span class="ms">check_circle</span><span class="toast__msg"></span>';
      body.appendChild(t);
    }
    $('.toast__msg', t).textContent = msg;
    t.classList.add('is-visible');
    clearTimeout(t._h);
    t._h = setTimeout(function () { t.classList.remove('is-visible'); }, 2800);
  };

  /* ---------- Header: trasparente sull'hero, si nasconde scorrendo verso il basso ---------- */
  var header = $('.site-header');
  var overlay = $('.overlay');
  var hasHero = body.classList.contains('has-hero');
  var megaOpen = false;
  var lastY = window.scrollY || 0;

  function updateHeader() {
    if (!header) return;
    var y = window.scrollY || window.pageYOffset;
    var h = header.offsetHeight;
    header.classList.toggle('is-scrolled', y > 4);
    if (hasHero) header.classList.toggle('is-transparent', y < 40);
    if (y <= h) header.classList.remove('is-hidden');
    else if (y > lastY + 6 && !$('.drawer.is-open, .search-panel.is-open')) {
      if (!header.classList.contains('is-hidden') && megaOpen) closeMegas();
      header.classList.add('is-hidden');
    } else if (y < lastY - 6) header.classList.remove('is-hidden');
    lastY = y;
  }
  if (header) {
    window.addEventListener('scroll', function () { cancelAnimationFrame(updateHeader._r); updateHeader._r = requestAnimationFrame(updateHeader); }, { passive: true });
    window.addEventListener('resize', updateHeader);
    updateHeader();
  }

  /* ---------- Mega menu ---------- */
  function closeMegas() {
    $$('.primary-nav li.is-open').forEach(function (li) {
      li.classList.remove('is-open');
      var a = $('a', li); if (a) a.setAttribute('aria-expanded', 'false');
    });
    megaOpen = false;
    if (overlay && !$('.drawer.is-open') && !$('.search-panel.is-open')) overlay.classList.remove('is-visible');
    updateHeader();
  }
  function openMega(li) {
    if (li.classList.contains('is-open')) return;
    closeMegas();
    li.classList.add('is-open');
    var a = $('a', li); if (a) a.setAttribute('aria-expanded', 'true');
    megaOpen = true;
    if (overlay) overlay.classList.add('is-visible');
    updateHeader();
  }
  $$('.primary-nav > ul > li').forEach(function (li) {
    var panel = $('.mega, .sub-menu', li);
    if (!panel) return;
    var trigger = $('a', li);
    trigger.setAttribute('aria-haspopup', 'true');
    trigger.setAttribute('aria-expanded', 'false');
    trigger.setAttribute('role', 'button');
    // Il pannello si apre solo al clic (un secondo clic lo chiude).
    trigger.addEventListener('click', function (e) {
      e.preventDefault();
      if (li.classList.contains('is-open')) closeMegas(); else openMega(li);
    });
    var close = $('[data-mega-close]', panel);
    if (close) close.addEventListener('click', function () { closeMegas(); trigger.focus(); });
    trigger.addEventListener('keydown', function (e) {
      if (e.key === 'ArrowDown' || e.key === ' ') { e.preventDefault(); openMega(li); var f = $('a', panel); if (f) f.focus(); }
    });
  });

  /* ---------- Drawers / search ---------- */
  var lastFocus = null;
  GM.open = function (name) {
    var el = name === 'search' ? $('.search-panel') : $('[data-drawer="' + name + '"]');
    if (!el) return false;
    closeMegas();
    GM.closeAll(true);
    lastFocus = document.activeElement;
    el.classList.add('is-open');
    el.setAttribute('aria-hidden', 'false');
    if (overlay) overlay.classList.add('is-visible');
    body.classList.add('no-scroll');
    var f = $('input, button, a', el);
    setTimeout(function () { var i = $('input[type=search]', el); (i || f) && (i || f).focus(); }, 300);
    return true;
  };
  GM.closeAll = function (silent) {
    $$('.drawer.is-open, .search-panel.is-open').forEach(function (el) { el.classList.remove('is-open'); el.setAttribute('aria-hidden', 'true'); });
    if (!silent) {
      if (overlay) overlay.classList.remove('is-visible');
      body.classList.remove('no-scroll');
      if (lastFocus) lastFocus.focus();
    }
  };
  document.addEventListener('click', function (e) {
    var o = e.target.closest('[data-open]');
    if (o) { if (GM.open(o.getAttribute('data-open'))) e.preventDefault(); return; }
    if (e.target.closest('[data-close]') || e.target === overlay) { GM.closeAll(); closeMegas(); }
  });
  document.addEventListener('keydown', function (e) { if (e.key === 'Escape') { GM.closeAll(); closeMegas(); } });

  /* ---------- Accordions (mobile nav, footer, product, FAQ) ---------- */
  document.addEventListener('click', function (e) {
    var b = e.target.closest('[data-acc]');
    if (!b) return;
    var panel = document.getElementById(b.getAttribute('aria-controls')) || b.nextElementSibling;
    if (!panel) return;
    var open = b.getAttribute('aria-expanded') === 'true';
    if (b.hasAttribute('data-acc-single')) {
      $$('[data-acc][data-acc-single]', b.closest('[data-acc-group]') || document).forEach(function (o) {
        if (o !== b) { o.setAttribute('aria-expanded', 'false'); var p = document.getElementById(o.getAttribute('aria-controls')) || o.nextElementSibling; p && p.classList.remove('is-open'); }
      });
    }
    b.setAttribute('aria-expanded', String(!open));
    panel.classList.toggle('is-open', !open);
  });

  /* ---------- Hero video slider ---------- */
  function initHero(hero) {
    var slides = $$('.hero__slide', hero);
    var tabs = $$('.hero__tab', hero);
    var toggle = $('.js-hero-toggle', hero);
    if (!slides.length) return;
    var idx = 0, playing = !reduceMotion, start = 0, elapsed = 0, raf, visible = true;
    var IMG_DURATION = 7000, MAX_DURATION = 11000;
    var small = window.matchMedia('(max-width: 767px)').matches;

    slides.forEach(function (s) {
      var v = $('video', s);
      if (!v) return;
      var src = (small && v.getAttribute('data-src-mobile')) || v.getAttribute('data-src');
      v.muted = true; v.playsInline = true; v.setAttribute('muted', ''); v.setAttribute('playsinline', '');
      v._src = src;
    });

    function load(v) { if (v && v._src && !v.src) { v.src = v._src; v.load(); } }
    function durationOf(s) {
      var v = $('video', s);
      if (v && v.duration && isFinite(v.duration)) return Math.min(v.duration * 1000, MAX_DURATION);
      return IMG_DURATION;
    }
    function go(n) {
      var prev = slides[idx];
      var pv = $('video', prev); if (pv) pv.pause();
      idx = (n + slides.length) % slides.length;
      slides.forEach(function (s, i) { s.classList.toggle('is-active', i === idx); s.setAttribute('aria-hidden', i === idx ? 'false' : 'true'); });
      tabs.forEach(function (t, i) {
        t.classList.toggle('is-active', i === idx);
        t.classList.toggle('is-done', i < idx);
        t.setAttribute('aria-selected', i === idx ? 'true' : 'false');
        var bar = $('.hero__bar i', t); if (bar) bar.style.transform = i < idx ? 'scaleX(1)' : 'scaleX(0)';
      });
      var v = $('video', slides[idx]);
      load(v);
      load($('video', slides[(idx + 1) % slides.length])); // preload next
      if (v) { try { v.currentTime = 0; } catch (e) {} if (playing && visible) { var p = v.play(); p && p.catch(function () {}); } }
      elapsed = 0; start = performance.now();
    }
    function tick(now) {
      raf = requestAnimationFrame(tick);
      if (!playing || !visible) { start = now - elapsed; return; }
      elapsed = now - start;
      var d = durationOf(slides[idx]);
      var bar = tabs[idx] && $('.hero__bar i', tabs[idx]);
      if (bar) bar.style.transform = 'scaleX(' + Math.min(elapsed / d, 1) + ')';
      if (elapsed >= d) go(idx + 1);
    }
    function setPlaying(p) {
      playing = p;
      var v = $('video', slides[idx]);
      if (v) { if (p) { var pr = v.play(); pr && pr.catch(function () {}); } else v.pause(); }
      if (toggle) {
        $('.ms', toggle).textContent = p ? 'pause' : 'play_arrow';
        toggle.setAttribute('aria-label', p ? 'Metti in pausa' : 'Riproduci');
      }
    }
    tabs.forEach(function (t, i) { t.addEventListener('click', function () { go(i); }); });
    var prevB = $('.js-hero-prev', hero), nextB = $('.js-hero-next', hero);
    prevB && prevB.addEventListener('click', function () { go(idx - 1); });
    nextB && nextB.addEventListener('click', function () { go(idx + 1); });
    toggle && toggle.addEventListener('click', function () { setPlaying(!playing); });

    // swipe
    var sx = null;
    hero.addEventListener('touchstart', function (e) { sx = e.touches[0].clientX; }, { passive: true });
    hero.addEventListener('touchend', function (e) {
      if (sx === null) return;
      var dx = e.changedTouches[0].clientX - sx;
      if (Math.abs(dx) > 50) go(idx + (dx < 0 ? 1 : -1));
      sx = null;
    });
    // pause off-screen / hidden tab
    if ('IntersectionObserver' in window) {
      new IntersectionObserver(function (en) {
        visible = en[0].isIntersecting;
        var v = $('video', slides[idx]);
        if (v) { if (visible && playing) { var p = v.play(); p && p.catch(function () {}); } else v.pause(); }
      }, { threshold: 0.15 }).observe(hero);
    }
    document.addEventListener('visibilitychange', function () { visible = !document.hidden; });

    go(0);
    if (!playing) setPlaying(false);
    raf = requestAnimationFrame(tick);
  }
  $$('.hero').forEach(initHero);

  /* ---------- Lazy background videos (banners, splits, page heroes) ---------- */
  function initLazyVideos() {
    var vids = $$('video[data-lazy]');
    if (!vids.length) return;
    var small = window.matchMedia('(max-width: 767px)').matches;
    var play = function (v) { var p = v.play(); p && p.catch(function () {}); };
    if (!('IntersectionObserver' in window)) { vids.forEach(function (v) { v.src = v.getAttribute('data-src'); play(v); }); return; }
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) {
        var v = en.target;
        if (en.isIntersecting) {
          if (!v.src) { v.src = (small && v.getAttribute('data-src-mobile')) || v.getAttribute('data-src'); v.muted = true; }
          if (!v._userPaused && !reduceMotion) play(v);
        } else if (v.src) v.pause();
      });
    }, { rootMargin: '200px 0px' });
    vids.forEach(function (v) { v.muted = true; io.observe(v); });
  }
  initLazyVideos();
  document.addEventListener('click', function (e) {
    var b = e.target.closest('[data-video-toggle]');
    if (!b) return;
    var v = b.parentElement.querySelector('video');
    if (!v) return;
    if (v.paused) { v._userPaused = false; v.play(); $('.ms', b).textContent = 'pause'; }
    else { v._userPaused = true; v.pause(); $('.ms', b).textContent = 'play_arrow'; }
  });

  /* ---------- Carousels ---------- */
  GM.initCarousels = function (root) {
    $$('[data-carousel]', root).forEach(function (c) {
      if (c._gm) return; c._gm = true;
      var track = $('.carousel__track', c);
      var prev = $('.js-car-prev', c), next = $('.js-car-next', c), dashes = $('.dashes', c);
      if (!track) return;
      function pages() { return Math.max(1, Math.ceil((track.scrollWidth - 2) / track.clientWidth)); }
      function render() {
        if (!track.clientWidth) return; // hidden tab panel
        var n = pages();
        var cur = Math.round(track.scrollLeft / track.clientWidth);
        if (track.scrollLeft + track.clientWidth >= track.scrollWidth - 4) cur = n - 1;
        if (dashes) {
          if (dashes.children.length !== n) dashes.innerHTML = new Array(n + 1).join('<span></span>');
          $$('span', dashes).forEach(function (s, i) { s.classList.toggle('is-active', i === cur); });
        }
        if (prev) prev.disabled = track.scrollLeft <= 2;
        if (next) next.disabled = track.scrollLeft + track.clientWidth >= track.scrollWidth - 4;
        var nav = $('.carousel__nav', c); if (nav) nav.style.visibility = n > 1 ? '' : 'hidden';
      }
      prev && prev.addEventListener('click', function () { track.scrollBy({ left: -track.clientWidth, behavior: 'smooth' }); });
      next && next.addEventListener('click', function () { track.scrollBy({ left: track.clientWidth, behavior: 'smooth' }); });
      track.addEventListener('scroll', function () { cancelAnimationFrame(c._r); c._r = requestAnimationFrame(render); }, { passive: true });
      window.addEventListener('resize', render);
      render();
    });
  };
  GM.initCarousels();

  /* ---------- Tabs (product carousel on home) ---------- */
  $$('[data-tabs]').forEach(function (wrap) {
    var btns = $$('[data-tab]', wrap);
    btns.forEach(function (b) {
      b.addEventListener('click', function () {
        btns.forEach(function (x) { x.classList.toggle('is-active', x === b); x.setAttribute('aria-selected', x === b ? 'true' : 'false'); });
        $$('[data-panel]', wrap).forEach(function (p) {
          var on = p.getAttribute('data-panel') === b.getAttribute('data-tab');
          p.hidden = !on;
          if (on) { var t = $('.carousel__track', p); if (t) { t.scrollLeft = 0; t.dispatchEvent(new Event('scroll')); } }
        });
      });
    });
  });

  /* ---------- Reveal on scroll ---------- */
  GM.initReveal = function (root) {
    var els = $$('.reveal:not(.is-in)', root);
    if (!('IntersectionObserver' in window) || reduceMotion) { els.forEach(function (e) { e.classList.add('is-in'); }); return; }
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) { if (en.isIntersecting) { en.target.classList.add('is-in'); io.unobserve(en.target); } });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
    els.forEach(function (e) { io.observe(e); });
  };
  GM.initReveal();

  /* ---------- Wishlist (local, per browser) ---------- */
  var WKEY = 'gm_wishlist';
  function wishList() { try { return JSON.parse(localStorage.getItem(WKEY)) || []; } catch (e) { return []; } }
  GM.syncWish = function () {
    var w = wishList();
    $$('.pcard__wish[data-id]').forEach(function (b) {
      var on = w.indexOf(String(b.getAttribute('data-id'))) > -1;
      b.classList.toggle('is-on', on); b.setAttribute('aria-pressed', String(on));
    });
    $$('.js-wish-count').forEach(function (c) { c.textContent = w.length || ''; c.setAttribute('data-count', w.length); });
  };
  document.addEventListener('click', function (e) {
    var b = e.target.closest('.pcard__wish[data-id]');
    if (!b) return;
    e.preventDefault();
    var id = String(b.getAttribute('data-id')), w = wishList(), i = w.indexOf(id);
    if (i > -1) w.splice(i, 1); else { w.push(id); GM.toast('Aggiunto alla lista dei desideri'); }
    localStorage.setItem(WKEY, JSON.stringify(w));
    document.cookie = 'gm_wishlist=' + w.join('.') + ';path=/;max-age=31536000;SameSite=Lax';
    GM.syncWish();
  });
  GM.syncWish();

  /* ---------- Cookie banner ---------- */
  (function () {
    var c = $('.cookie');
    if (!c) return;
    var KEY = 'gm_cookie_consent';
    if (!localStorage.getItem(KEY)) setTimeout(function () { c.classList.add('is-visible'); }, 1200);
    $$('[data-cookie]', c).forEach(function (b) {
      b.addEventListener('click', function () {
        localStorage.setItem(KEY, b.getAttribute('data-cookie'));
        c.classList.remove('is-visible');
        document.dispatchEvent(new CustomEvent('gm:cookie', { detail: b.getAttribute('data-cookie') }));
      });
    });
    document.addEventListener('click', function (e) { if (e.target.closest('[data-cookie-open]')) { e.preventDefault(); c.classList.add('is-visible'); } });
  })();

  /* ---------- Newsletter ---------- */
  $$('.js-newsletter').forEach(function (f) {
    f.addEventListener('submit', function (e) {
      e.preventDefault();
      var msg = $('.form-msg', f), email = $('input[type=email]', f).value.trim();
      if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { msg.textContent = 'Inserisci un indirizzo email valido.'; return; }
      var cfg = window.gmTheme || {};
      var done = function (ok) { msg.style.color = ok ? '#16a34a' : ''; msg.textContent = ok ? 'Grazie! Ora sei iscritto alla newsletter.' : 'Qualcosa è andato storto, riprova.'; if (ok) f.reset(); };
      if (cfg.ajaxUrl) {
        var data = new FormData(); data.append('action', 'gm_newsletter'); data.append('email', email); data.append('nonce', cfg.nonce || '');
        fetch(cfg.ajaxUrl, { method: 'POST', body: data, credentials: 'same-origin' }).then(function (r) { return r.json(); }).then(function (r) { done(r && r.success); }).catch(function () { done(false); });
      } else done(true);
    });
  });

  /* ----------  Integazione al cart ---------- */
  if (window.jQuery) {
    window.jQuery(document.body).on('added_to_cart', function () { GM.toast('Aggiunto al carrello'); });
  }

  /* ---------- Product gallery (zoom, ascolto pulss, muose up) ---------- */
  GM.initGallery = function (root) {
    var g = $('.product__gallery', root);
    if (!g) return;
    var main = $('.product__main', g), img = $('img', main);
    $$('.product__thumbs button', g).forEach(function (b) {
      b.addEventListener('click', function () {
        $$('.product__thumbs button', g).forEach(function (x) { x.classList.toggle('is-active', x === b); });
        img.src = b.getAttribute('data-full');
      });
    });
    main.addEventListener('click', function () { main.classList.toggle('is-zoom'); });
    main.addEventListener('mousemove', function (e) {
      if (!main.classList.contains('is-zoom')) return;
      var r = main.getBoundingClientRect();
      img.style.transformOrigin = ((e.clientX - r.left) / r.width * 100) + '% ' + ((e.clientY - r.top) / r.height * 100) + '%';
    });
    main.addEventListener('mouseleave', function () { main.classList.remove('is-zoom'); });
  };
  GM.initGallery();
})();
