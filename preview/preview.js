/* Solo anteprima statica (non caricato da WordPress).
   Inserisce lo stesso header/footer di header.php / footer.php,
   disegna i prodotti da assets/data/products.js e simula il carrello. */
(function () {
  'use strict';
  var GM = window.GM = window.GM || {};
  var P = window.GM_PRODUCTS || [], CATS = window.GM_CATEGORIES || {};
  var ORDER = ['datejust', 'nautilus', 'oak', 'sub', 'chronographs', 'santos'];
  var CAT_IMG = { datejust: '2024/10/IMG_2015', nautilus: '2024/11/IMG_2409', oak: '2024/10/IMG_1874', sub: '2025/12/IMG_9748', chronographs: '2024/04/IMG_0303', santos: '2024/10/IMG_2083' };
  var U = 'https://www.gmbrand.it/wp-content/uploads/';
  var img = function (p) { return U + p + '-768x512.jpg'; };
  var px = function (id, w) { return 'https://images.pexels.com/photos/' + id + '/pexels-photo-' + id + '.jpeg?auto=compress&cs=tinysrgb&w=' + (w || 1920); };
  var EMAIL = 'infowatches@gmbrand.it';
  var IG = 'https://www.instagram.com/gmbrand_watches/', TT = 'https://www.tiktok.com/@gm_brand', YT = 'https://www.youtube.com/@gmbrand_watches';
  var esc = function (s) { return String(s).replace(/[&<>"']/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]; }); };
  var eur = function (n) { return n.toFixed(2).replace('.', ',') + ' €'; };
  var catUrl = function (c) { return 'negozio.html?cat=' + c; };
  var isHome = document.body.classList.contains('has-hero');
  var ACC = [['Cinturini', '2024/10/IMG_1769'], ['Custodie per orologi', '2024/02/IMG_0062']];

  /* Stessa struttura di gm_menu() in inc/helpers.php */
  var MENU = [
    { label: 'Orologi', url: 'negozio.html', cols: [
      ['Collezioni', ORDER.map(function (c) { return [CATS[c], catUrl(c)]; })],
      ['Scopri', [['Novità', 'negozio.html?sort=new'], ['I più venduti', 'negozio.html?sort=popular'], ['Prezzi speciali', 'negozio.html?sale=1'], ['Edizioni limitate', 'negozio.html']]],
      ['Per diametro', [['36 mm', 'negozio.html?q=36mm'], ['39 – 40 mm', 'negozio.html?q=40mm'], ['41 – 42 mm', 'negozio.html?q=42mm'], ['45 mm', 'negozio.html?q=45mm']]]
    ], tiles: ORDER.slice(0, 3).map(function (c) { return [CATS[c], img(CAT_IMG[c]), catUrl(c)]; }) },
    { label: 'Accessori', url: 'negozio.html?cat=accessori', cols: [['Accessori', ACC.map(function (a) { return [a[0], 'negozio.html?cat=accessori']; })]],
      tiles: ACC.map(function (a) { return [a[0], img(a[1]), 'negozio.html?cat=accessori']; }) },
    { label: 'Idee regalo', url: 'negozio.html?gift=lui', cols: [['Idee regalo', [['Idee regalo per lui', 'negozio.html?gift=lui'], ['Idee regalo per lei', 'negozio.html?gift=lei'], ['Sotto i 250 €', 'negozio.html?sort=price-asc'], ['Il regalo su misura', 'personalizza.html']]]],
      tiles: [['Per lui', img('2025/12/IMG_9748'), 'negozio.html?gift=lui'], ['Per lei', img('2024/04/IMG_1513'), 'negozio.html?gift=lei'], ['Su misura', img('2024/10/IMG_1781'), 'personalizza.html']] },
    { label: 'Personalizza', url: 'personalizza.html' },
    { label: 'Servizi', url: 'servizi.html' },
    { label: 'Chi siamo', url: 'chi-siamo.html' },
    { label: 'Info', url: 'faq.html', cols: [
      ['Assistenza', [["Cura dell'orologio", 'cura-orologio.html'], ['Domande frequenti', 'faq.html'], ['Contatti', 'contatti.html']]],
      ['Il tuo account', [['Il mio account', '#account'], ['I miei ordini', '#account'], ['Lista dei desideri', 'negozio.html?wishlist=1']]]
    ], tiles: [["Cura dell'orologio", px(8327590, 600), 'cura-orologio.html'], ['Contattaci', px(8327525, 600), 'contatti.html']] }
  ];
  var PROMOS = [
    { img: img('2025/12/IMG_9912'), eyebrow: 'Il nostro laboratorio', title: 'Assemblati a mano in Italia', text: 'Ogni orologio GMBRAND nasce nel nostro laboratorio in Toscana, sempre con un movimento Seiko originale.', link: 'Scopri chi siamo', url: 'chi-siamo.html' },
    { img: img('2024/10/IMG_1858'), eyebrow: '100% personalizzato', title: 'Il tuo orologio su misura', text: 'Quadrante, lancette, lunetta e bracciale: scegli ogni dettaglio, noi lo costruiamo in circa cinque giorni lavorativi.', link: 'Inizia il progetto', url: 'personalizza.html' },
    { img: img('2024/10/IMG_1781'), eyebrow: 'Ovunque tu sia', title: 'Spedizione in tutto il mondo', text: '1–2 giorni in Italia, 3–4 in Europa. Nessun dazio nell’Unione Europea e garanzia di un anno su ogni orologio.', link: 'Spedizioni e resi', url: 'faq.html' }
  ];
  function promo(p, rev) {
    return '<li class="promo-tile' + (rev ? ' promo-tile--reverse' : '') + '"><a class="promo-tile__media" href="' + p.url + '"><img src="' + p.img + '" alt="" loading="lazy"></a><div class="promo-tile__body"><span class="eyebrow">' + esc(p.eyebrow) + '</span><h3>' + esc(p.title) + '</h3><p>' + esc(p.text) + '</p><a class="promo-tile__link" href="' + p.url + '">' + esc(p.link) + '</a></div></li>';
  }

  var SVG = {
    instagram: 'M12 2.2c3.2 0 3.6 0 4.8.1 1.2.1 1.8.2 2.2.4.6.2 1 .5 1.4.9.4.4.7.8.9 1.4.2.4.4 1 .4 2.2.1 1.3.1 1.6.1 4.8s0 3.6-.1 4.8c-.1 1.2-.2 1.8-.4 2.2-.2.6-.5 1-.9 1.4-.4.4-.8.7-1.4.9-.4.2-1 .4-2.2.4-1.3.1-1.6.1-4.8.1s-3.6 0-4.8-.1c-1.2-.1-1.8-.2-2.2-.4-.6-.2-1-.5-1.4-.9-.4-.4-.7-.8-.9-1.4-.2-.4-.4-1-.4-2.2C2.2 15.6 2.2 15.2 2.2 12s0-3.6.1-4.8c.1-1.2.2-1.8.4-2.2.2-.6.5-1 .9-1.4.4-.4.8-.7 1.4-.9.4-.2 1-.4 2.2-.4C8.4 2.2 8.8 2.2 12 2.2zm0 3.1a6.7 6.7 0 1 0 0 13.4 6.7 6.7 0 0 0 0-13.4zm0 11a4.3 4.3 0 1 1 0-8.6 4.3 4.3 0 0 1 0 8.6zm6.9-11.3a1.6 1.6 0 1 1-3.1 0 1.6 1.6 0 0 1 3.1 0z',
    tiktok: 'M16.6 5.8A4.3 4.3 0 0 1 15.5 3h-3.1v12.4a2.6 2.6 0 1 1-2.6-2.6c.3 0 .5 0 .8.1V9.7a5.7 5.7 0 1 0 4.9 5.7V9.1a7.3 7.3 0 0 0 4.3 1.4V7.4a4.3 4.3 0 0 1-3.2-1.6z',
    youtube: 'M23 7.2a3 3 0 0 0-2.1-2.1C19 4.6 12 4.6 12 4.6s-7 0-8.9.5A3 3 0 0 0 1 7.2 31 31 0 0 0 .5 12a31 31 0 0 0 .5 4.8 3 3 0 0 0 2.1 2.1c1.9.5 8.9.5 8.9.5s7 0 8.9-.5a3 3 0 0 0 2.1-2.1 31 31 0 0 0 .5-4.8 31 31 0 0 0-.5-4.8zM9.7 15V9l5.8 3-5.8 3z'
  };
  var svg = function (n) { return '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="' + SVG[n] + '"/></svg>'; };
  var links = function (arr) { return arr.map(function (l) { return '<li><a href="' + l[1] + '">' + esc(l[0]) + '</a></li>'; }).join(''); };

  /* ---------------- Header ---------------- */
  var nav = MENU.map(function (m) {
    if (!m.cols) return '<li><a href="' + m.url + '">' + esc(m.label) + '</a></li>';
    return '<li class="has-mega"><a href="' + m.url + '">' + esc(m.label) + '</a><div class="mega"><div class="mega__inner" style="--cols:' + m.cols.length + '"><button type="button" class="mega__close" data-mega-close aria-label="Chiudi"><span class="ms">close</span></button>' +
      m.cols.map(function (c, ci) { return '<div class="mega__col"><h4>' + esc(c[0]) + '</h4><ul>' + links(c[1]) + '</ul>' + (ci ? '' : '<a class="mega__all" href="' + m.url + '">Scopri tutto <span class="ms" style="font-size:16px">arrow_forward</span></a>') + '</div>'; }).join('') +
      '<div class="mega__feature" style="--tiles:' + m.tiles.length + '">' + m.tiles.map(function (t) { return '<a class="mega__tile" href="' + t[2] + '"><figure><img src="' + t[1] + '" alt="" loading="lazy"></figure><span>' + esc(t[0]) + '</span></a>'; }).join('') + '</div>' +
      '</div></div></li>';
  }).join('');
  var mnav = MENU.map(function (m, i) {
    if (!m.cols) return '<li><a href="' + m.url + '">' + esc(m.label) + '</a></li>';
    return '<li><button class="m-nav__toggle" data-acc data-acc-single aria-expanded="false" aria-controls="mn-' + i + '">' + esc(m.label) + ' <span class="ms">add</span></button><ul class="m-nav__panel" id="mn-' + i + '">' + m.cols.map(function (c) { return links(c[1]); }).join('') + '</ul></li>';
  }).join('') + '<li><a href="contatti.html">Contatti</a></li>';

  var header =
    '<a class="skip-link sr-only" href="#main">Vai al contenuto</a>' +
    '<header class="site-header' + (isHome ? ' is-transparent' : '') + '"><div class="container header-main">' +
      '<div class="header-left">' +
        '<button class="icon-btn hide-desktop" data-open="menu" aria-label="Apri il menu"><span class="ms">menu</span></button>' +
        '<button class="icon-btn icon-btn--text" data-open="search" aria-label="Cerca"><span class="ms">search</span><span class="icon-btn__label hide-mobile">Cerca</span></button>' +
        '<a class="icon-btn icon-btn--text hide-mobile" href="contatti.html"><span class="ms">call</span><span class="icon-btn__label">Contattaci</span></a>' +
      '</div>' +
      '<a class="logo" href="index.html" rel="home"><img src="../assets/img/logo.png" alt="GMBRAND" width="400" height="60"></a>' +
      '<div class="header-right">' +
        '<a class="icon-btn hide-mobile" href="#account" aria-label="Il mio account"><span class="ms">person</span></a>' +
        '<a class="icon-btn" href="negozio.html?wishlist=1" aria-label="Lista dei desideri"><span class="ms">favorite</span><span class="cart-count js-wish-count"></span></a>' +
        '<a class="icon-btn" href="#" data-open="cart" aria-label="Carrello"><span class="ms">shopping_bag</span><span class="cart-count js-cart-count"></span></a>' +
      '</div></div>' +
      '<nav class="primary-nav" aria-label="Menu principale"><ul>' + nav + '</ul></nav>' +
    '</header>' +
    '<div class="overlay" aria-hidden="true"></div>' +
    '<aside class="drawer drawer--left" data-drawer="menu" aria-hidden="true" aria-label="Menu">' +
      '<div class="drawer__head"><img src="../assets/img/logo.png" alt="" style="height:18px;width:auto"><button class="icon-btn" data-close aria-label="Chiudi il menu"><span class="ms">close</span></button></div>' +
      '<div class="drawer__body"><ul class="m-nav" data-acc-group>' + mnav + '</ul>' +
      '<div class="m-nav-extra"><a href="#account"><span class="ms">person</span> Il mio account</a><a href="mailto:' + EMAIL + '"><span class="ms">mail</span> ' + EMAIL + '</a><a href="faq.html"><span class="ms">local_shipping</span> Spedizioni e resi</a></div></div>' +
    '</aside>' +
    '<aside class="drawer drawer--right" data-drawer="cart" aria-hidden="true" aria-label="Carrello">' +
      '<div class="drawer__head"><h3>Il tuo carrello <span class="js-cart-title"></span></h3><button class="icon-btn" data-close aria-label="Chiudi il carrello"><span class="ms">close</span></button></div>' +
      '<div class="drawer__body js-cart-body"></div><div class="drawer__foot js-cart-foot"></div>' +
    '</aside>' +
    '<div class="search-panel" aria-hidden="true" role="dialog" aria-label="Cerca"><div class="container">' +
      '<form class="search-panel__bar" role="search" action="negozio.html"><span class="ms">search</span><label class="sr-only" for="gm-search">Cerca orologi</label><input id="gm-search" type="search" name="q" placeholder="Cerca orologi…" autocomplete="off"><button type="button" class="icon-btn" data-close aria-label="Chiudi la ricerca"><span class="ms">close</span></button></form>' +
      '<div class="search-panel__body"><span class="eyebrow">Ricerche frequenti</span><div class="search-tags">' +
        ['Nautilus', 'Datejust', 'Oak', 'Cronograph', 'GMT', 'Tiffany', 'Rose gold'].map(function (t) { return '<a href="negozio.html?q=' + encodeURIComponent(t) + '">' + t + '</a>'; }).join('') +
      '</div><div class="search-results"></div></div>' +
    '</div></div>';

  /* ---------------- Footer ---------------- */
  var FCOLS = [
    ['Collezioni', ORDER.map(function (c) { return [CATS[c], catUrl(c)]; })],
    ['Idee regalo', [['Idee regalo per lui', 'negozio.html?gift=lui'], ['Idee regalo per lei', 'negozio.html?gift=lei'], ['Accessori', 'negozio.html?cat=accessori'], ['Orologio su misura', 'personalizza.html']]],
    ['Servizio clienti', [['Contattaci', 'contatti.html'], ['Domande frequenti', 'faq.html'], ['Spedizioni e resi', 'faq.html'], ['Servizi', 'servizi.html'], ["Cura dell'orologio", 'cura-orologio.html'], ['Il mio account', '#account']]],
    ['Universo GMBRAND', [['Chi siamo', 'chi-siamo.html'], [EMAIL, 'mailto:' + EMAIL], ['Instagram', IG], ['TikTok', TT]]]
  ];
  var footer =
    '<section class="section section--tight" style="border-top:1px solid var(--hair)"><div class="container newsletter">' +
      '<div><h3>Iscriviti alla nostra newsletter</h3><p>Nuove edizioni limitate, riassortimenti e offerte riservate: in anteprima.</p></div>' +
      '<form class="js-newsletter" novalidate><div class="field-join"><label class="sr-only" for="nl-email">Indirizzo email</label><input id="nl-email" type="email" placeholder="Indirizzo email" required><button type="submit" aria-label="Iscriviti"><span class="ms">arrow_forward</span></button></div><p class="form-note">Iscrivendoti accetti la nostra <a href="#" style="text-decoration:underline">informativa sulla privacy</a>.</p><p class="form-msg" aria-live="polite"></p></form>' +
    '</div></section>' +
    '<footer class="site-footer"><div class="container"><div class="footer-grid">' +
      '<div class="footer-brand"><img src="../assets/img/logo.png" alt="GMBRAND"><p>Made in Italy con anima giapponese. Orologi personalizzati assemblati a mano ad Anghiari, Toscana – Italia, sempre con movimento Seiko.</p>' +
        '<div class="social"><a href="' + IG + '" target="_blank" rel="noopener" aria-label="Instagram">' + svg('instagram') + '</a><a href="' + TT + '" target="_blank" rel="noopener" aria-label="TikTok">' + svg('tiktok') + '</a><a href="' + YT + '" target="_blank" rel="noopener" aria-label="YouTube">' + svg('youtube') + '</a></div></div>' +
      FCOLS.map(function (c, i) { return '<div class="fcol"><h4>' + esc(c[0]) + '</h4><button class="fcol__toggle" data-acc aria-expanded="false" aria-controls="fc-' + i + '">' + esc(c[0]) + ' <span class="ms">add</span></button><ul id="fc-' + i + '">' + links(c[1]) + '</ul></div>'; }).join('') +
    '</div>' +
    '<p class="disclaimer">GMBRAND è un’azienda indipendente. Non siamo affiliati, associati, autorizzati, sponsorizzati né in alcun modo ufficialmente collegati alle aziende e/o ai marchi citati in questo sito. Tutti i nomi di prodotti e aziende sono marchi dei rispettivi titolari e sono usati solo a scopo identificativo.</p>' +
    '<div class="footer-bottom"><span class="footer-lang"><span class="ms">language</span> Italia · Italiano · EUR €</span><nav aria-label="Note legali"><a href="#">Condizioni di vendita</a><a href="#">Informativa sulla privacy</a><a href="faq.html">Politica di reso</a><a href="#" data-cookie-open>Impostazioni cookie</a></nav><div class="payments"><span>VISA</span><span>MASTERCARD</span><span>PAYPAL</span><span>APPLE PAY</span></div><span>&copy; ' + new Date().getFullYear() + ' gmbrand.it · Tutti i diritti riservati</span></div>' +
    '</div></footer>' +
    '<div class="cookie" role="dialog" aria-label="Consenso cookie"><h4>Informativa sui cookie</h4><p>Usiamo cookie tecnici per far funzionare il sito e, con il tuo consenso, cookie analitici per migliorarlo. Consulta la nostra <a href="#">informativa sui cookie</a>.</p><div class="cookie__btns"><button class="btn btn--black" data-cookie="essential">Rifiuta tutto</button><button class="btn btn--red" data-cookie="all">Accetta tutto</button></div></div>';

  var h = document.getElementById('gm-header'), f = document.getElementById('gm-footer');
  if (h) h.outerHTML = header;
  if (f) f.outerHTML = footer;
  document.addEventListener('click', function (e) { if (e.target.closest('a[href="#account"]')) { e.preventDefault(); GM.toast('L’account cliente è gestito da WooCommerce in WordPress'); } });

  /* ---------------- Card prodotto (stesso markup di woocommerce/content-product.php) ---------------- */
  function spec(p) { return [p.size, p.movement.replace('Movimento Seiko', 'movimento Seiko').replace('Automatico', 'automatico').replace('Cronografo', 'cronografo')].filter(Boolean).join(', '); }
  function priceHtml(p) { return p.onSale ? '<del>' + eur(p.regular) + '</del><ins>' + eur(p.price) + '</ins>' : eur(p.price); }
  function card(p) {
    var badges = p.soldOut ? '<span class="badge badge--outline">Esaurito</span>' : (p.onSale ? '<span class="badge badge--red">Offerta</span>' : '') + (p.isNew ? '<span class="badge">Novità</span>' : '');
    var href = 'prodotto.html?p=' + p.slug;
    return '<li><article class="pcard' + (p.soldOut ? ' is-soldout' : '') + '">' +
      '<a class="pcard__media" href="' + href + '" aria-label="' + esc(p.name) + '"><span class="pcard__badges">' + badges + '</span><img src="' + p.img + '" alt="' + esc(p.name) + '" loading="lazy" width="768" height="512"></a>' +
      '<button class="pcard__wish" data-id="' + p.id + '" aria-label="Aggiungi alla lista dei desideri" aria-pressed="false"><span class="ms">favorite</span></button>' +
      '<a class="pcard__body" href="' + href + '"><h3 class="pcard__title">' + esc(p.name) + '</h3><p class="pcard__spec">' + esc(spec(p)) + '</p><div class="pcard__price price">' + priceHtml(p) + '</div></a>' +
      '</article></li>';
  }
  /* Griglia con riquadri marketing alle posizioni 7, 11 e 19 (come in WordPress) */
  function gridHtml(list, promoStart) {
    var map = { 6: 0, 10: 1, 18: 2 }, out = '';
    list.forEach(function (p, i) {
      if (map[i] !== undefined) { var k = (map[i] + (promoStart || 0)) % PROMOS.length; out += promo(PROMOS[k], i === 10); }
      out += card(p);
    });
    return out;
  }

  /* Home */
  var pick = {
    best: P.filter(function (p) { return !p.soldOut; }).filter(function (p, i) { return i % 5 === 0 || p.isNew; }).slice(0, 10),
    new: P.filter(function (p) { return p.isNew; }).concat(P.slice(-6)).slice(0, 10),
    sale: P.filter(function (p) { return p.onSale; }).concat(P.filter(function (p) { return !p.onSale && !p.soldOut; }).slice(20, 25))
  };
  document.querySelectorAll('[data-products]').forEach(function (el, i) { el.innerHTML = gridHtml(pick[el.getAttribute('data-products')] || [], i); });
  var cg = document.querySelector('[data-collections]');
  if (cg) cg.innerHTML = ORDER.map(function (c) {
    return '<a class="ctile reveal" href="' + catUrl(c) + '"><img src="' + img(CAT_IMG[c]) + '" alt="' + esc(CATS[c]) + '" loading="lazy"><div class="ctile__body"><h3>' + esc(CATS[c]) + '</h3><span>Scopri <span class="ms" style="font-size:15px">arrow_forward</span></span></div></a>';
  }).join('');

  /* ---------------- Negozio ---------------- */
  var shop = document.querySelector('[data-shop]');
  if (shop) {
    var qs = new URLSearchParams(location.search);
    var state = { cat: qs.get('cat') || '', q: qs.get('q') || '', gift: qs.get('gift') || '', sort: qs.get('sort') || 'popular', sale: qs.get('sale') === '1', instock: false, wish: qs.get('wishlist') === '1', shown: 24 };
    var title = document.querySelector('[data-shop-title]'), lead = document.querySelector('[data-shop-lead]');
    var chips = document.querySelector('[data-chips]');
    chips.innerHTML = '<button class="chip" data-cat="">Tutti gli orologi</button>' + ORDER.map(function (c) { return '<button class="chip" data-cat="' + c + '">' + esc(CATS[c]) + '</button>'; }).join('');
    var sortSel = document.querySelector('[data-sort]'), stockChk = document.querySelector('[data-instock]'), count = document.querySelector('[data-count]'), more = document.querySelector('[data-more]');
    sortSel.value = ['popular', 'new', 'price-asc', 'price-desc'].indexOf(state.sort) > -1 ? state.sort : 'popular';
    var DESC = {
      '': 'Ogni dettaglio, personalizzato al 100% sul tuo stile. Tutti i nostri orologi sono assemblati in Italia dai nostri orologiai esperti.',
      datejust: 'Lunette zigrinate, bracciali jubilee e indici baguette, in 36 e 39 mm.',
      nautilus: 'Bracciali integrati e quadranti a righe orizzontali, in 40 e 41 mm.',
      oak: 'Lunetta ottagonale e quadranti tapisserie su cassa da 42 mm.',
      sub: 'Subacquei, GMT e quadranti unici da 39 a 45 mm.',
      chronographs: 'Cronografi panda, racing e vintage da 40 mm.',
      santos: 'Cassa quadrata con viti a vista, 39 mm.',
      accessori: 'Cinturini, custodie e caricatori automatici: in arrivo.'
    };
    function render() {
      var list = P.slice();
      if (state.wish) { var w = JSON.parse(localStorage.getItem('gm_wishlist') || '[]'); list = list.filter(function (p) { return w.indexOf(String(p.id)) > -1; }); }
      if (state.cat) list = list.filter(function (p) { return p.cat === state.cat; });
      if (state.gift) list = list.filter(function (p) { return p.gift === state.gift && !p.soldOut; });
      if (state.q) { var q = state.q.toLowerCase().replace(/\s/g, ''); list = list.filter(function (p) { return (p.name + ' ' + p.catName).toLowerCase().replace(/\s/g, '').indexOf(q) > -1; }); }
      if (state.sale) list = list.filter(function (p) { return p.onSale; });
      if (state.instock) list = list.filter(function (p) { return !p.soldOut; });
      if (state.sort === 'price-asc') list.sort(function (a, b) { return a.price - b.price; });
      if (state.sort === 'price-desc') list.sort(function (a, b) { return b.price - a.price; });
      if (state.sort === 'new') list.sort(function (a, b) { return (b.isNew - a.isNew) || (b.id - a.id); });
      if (state.sort === 'popular') list.sort(function (a, b) { return (a.soldOut - b.soldOut); });
      title.textContent = state.wish ? 'La tua lista dei desideri' : state.q ? 'Risultati per “' + state.q + '”' : state.sale ? 'Prezzi speciali' : state.gift === 'lei' ? 'Idee regalo per lei' : state.gift === 'lui' ? 'Idee regalo per lui' : state.cat === 'accessori' ? 'Accessori' : state.cat ? CATS[state.cat] : 'Tutti gli orologi';
      lead.textContent = DESC[state.cat] || DESC[''];
      chips.querySelectorAll('.chip').forEach(function (c) { c.classList.toggle('is-active', c.getAttribute('data-cat') === state.cat && !state.wish && !state.gift); });
      count.textContent = list.length + (list.length === 1 ? ' orologio' : ' orologi');
      var shown = list.slice(0, state.shown);
      shop.innerHTML = shown.length ? gridHtml(shown) : '<li class="empty" style="grid-column:1/-1">' + (state.wish ? 'La tua lista è vuota: tocca il ♥ su un orologio per salvarlo.' : state.cat === 'accessori' ? 'Gli accessori arriveranno presto.' : 'Nessun orologio trovato.') + '</li>';
      more.innerHTML = list.length > state.shown ? '<span>Hai visto ' + shown.length + ' di ' + list.length + ' orologi</span><span class="load-more__bar"><i style="width:' + (shown.length / list.length * 100) + '%"></i></span><button class="btn btn--outline js-more">Carica altri</button>' : (list.length ? '<span>Hai visto tutti i ' + list.length + ' orologi</span>' : '');
      GM.syncWish && GM.syncWish();
    }
    chips.addEventListener('click', function (e) { var c = e.target.closest('.chip'); if (!c) return; state.cat = c.getAttribute('data-cat'); state.wish = false; state.q = ''; state.gift = ''; state.sale = false; state.shown = 24; history.replaceState(null, '', state.cat ? '?cat=' + state.cat : location.pathname); render(); });
    sortSel.addEventListener('change', function () { state.sort = sortSel.value; render(); });
    stockChk.addEventListener('change', function () { state.instock = stockChk.checked; render(); });
    more.addEventListener('click', function (e) { if (e.target.closest('.js-more')) { state.shown += 24; render(); } });
    render();
  }

  /* ---------------- Scheda prodotto ---------------- */
  var pd = document.querySelector('[data-product]');
  if (pd) {
    var slug = new URLSearchParams(location.search).get('p');
    var p = P.filter(function (x) { return x.slug === slug; })[0] || P[1];
    document.title = p.name + ' – GMBRAND';
    var related = P.filter(function (x) { return x.cat === p.cat && x.id !== p.id && !x.soldOut; }).slice(0, 4);
    var thumbs = [p.img].concat(related.slice(0, 3).map(function (r) { return r.img; }));
    pd.innerHTML =
      '<nav class="breadcrumbs"><a href="index.html">Home</a><span class="sep">/</span><a href="negozio.html">Orologi</a><span class="sep">/</span><a href="' + catUrl(p.cat) + '">' + esc(p.catName) + '</a><span class="sep">/</span>' + esc(p.name) + '</nav>' +
      '<div class="product">' +
        '<div class="product__gallery"><div class="product__thumbs">' + thumbs.map(function (t, i) { return '<button class="' + (i ? '' : 'is-active') + '" data-full="' + t + '" aria-label="Immagine ' + (i + 1) + '"><img src="' + t + '" alt="" loading="lazy"></button>'; }).join('') + '</div>' +
          '<div class="product__main"><img src="' + p.img + '" alt="' + esc(p.name) + '"></div></div>' +
        '<div class="product__info">' +
          '<div class="pcard__badges" style="position:static">' + (p.soldOut ? '<span class="badge badge--outline">Esaurito</span>' : p.onSale ? '<span class="badge badge--red">Offerta</span>' : '') + (p.isNew ? '<span class="badge">Novità</span>' : '') + '<span class="badge badge--gold">Edizione limitata</span></div>' +
          '<span class="eyebrow">' + esc(p.catName) + '</span><h1>' + esc(p.name) + '</h1>' +
          '<div class="product__meta"><span>Cod. ' + p.sku + '</span><span class="stock' + (p.soldOut ? ' is-out' : '') + '">' + (p.soldOut ? 'Esaurito' : 'Disponibile – spedito in 1-2 giorni') + '</span></div>' +
          '<div class="price" style="justify-content:flex-start;font-size:20px">' + priceHtml(p) + '</div>' +
          '<p class="muted" style="margin:0">Cassa ' + esc(p.size || 'personalizzata') + ', ' + esc(spec(p).split(', ').pop()) + '. Assemblato a mano in Italia.</p>' +
          (p.soldOut
            ? '<a class="btn btn--black btn--block" href="contatti.html">Chiedici di costruirne uno per te</a>'
            : '<div class="buy-row"><div class="qty"><button type="button" class="js-qty" data-d="-1" aria-label="Meno"><span class="ms" style="font-size:18px">remove</span></button><input type="number" value="1" min="1" max="5" aria-label="Quantità" class="js-qty-in"><button type="button" class="js-qty" data-d="1" aria-label="Più"><span class="ms" style="font-size:18px">add</span></button></div><button class="btn btn--red js-add" data-id="' + p.id + '" data-qty-from=".js-qty-in"><span class="ms" style="font-size:18px">shopping_bag</span> Aggiungi al carrello</button><button class="btn btn--outline pcard__wish" data-id="' + p.id + '" style="position:static;opacity:1;width:48px;padding:0;border-radius:0;background:#fff" aria-label="Lista dei desideri"><span class="ms">favorite</span></button></div>') +
          '<ul class="perks"><li><span class="ms">precision_manufacturing</span> Assemblato a mano in Italia con movimento Seiko</li><li><span class="ms">verified</span> Garanzia di un anno</li><li><span class="ms">local_shipping</span> Spedizione nel mondo – 1-2 giorni in Italia, 3-4 in Europa</li><li><span class="ms">assignment_return</span> Reso entro 14 giorni con sigillo integro</li></ul>' +
          '<div>' +
            acc('d1', 'Descrizione', '<p>' + esc(p.name) + ' è un orologio personalizzato, assemblato nel nostro laboratorio in Toscana da orologiai esperti, che unisce componenti originali Seiko a parti aftermarket selezionate. La maggior parte dei nostri orologi è in edizione limitata: contattaci se desideri un quadrante, lancette o bracciale diversi.</p>', true) +
            acc('d2', 'Caratteristiche', '<table class="specs"><tr><th>Collezione</th><td>' + esc(p.catName) + '</td></tr><tr><th>Diametro cassa</th><td>' + esc(p.size || '—') + '</td></tr><tr><th>Movimento</th><td>' + esc(p.movement) + '</td></tr><tr><th>Assemblaggio</th><td>Italia</td></tr><tr><th>Garanzia</th><td>1 anno</td></tr></table>') +
            acc('d3', 'Spedizioni e resi', '<p>Italia 1–2 giorni lavorativi, Europa 3–4, resto del mondo 5–10. Gli orologi su misura richiedono 5 giorni lavorativi in più. Nessun dazio nell’UE. Reso accettato entro 14 giorni se il sigillo di ceralacca sulla scatola è intatto.</p>') +
          '</div>' +
        '</div>' +
      '</div>' +
      '<div class="sticky-buy"><span class="sticky-buy__name">' + esc(p.name) + '<br><b style="font-size:13px">' + eur(p.price) + '</b></span>' + (p.soldOut ? '' : '<button class="btn btn--red js-add" data-id="' + p.id + '" style="height:44px;padding:0 20px">Aggiungi</button>') + '</div>';
    var rel = document.querySelector('[data-related]');
    if (rel) rel.innerHTML = related.map(card).join('');
    document.addEventListener('click', function (e) {
      var b = e.target.closest('.js-qty'); if (!b) return;
      var i = document.querySelector('.js-qty-in'); i.value = Math.max(1, Math.min(5, (+i.value || 1) + +b.getAttribute('data-d')));
    });
    var sb = document.querySelector('.sticky-buy'), buy = document.querySelector('.buy-row');
    if (sb && buy && 'IntersectionObserver' in window) new IntersectionObserver(function (en) { sb.classList.toggle('is-visible', !en[0].isIntersecting && en[0].boundingClientRect.top < 0); }).observe(buy);
  }
  function acc(id, t, html, open) {
    return '<div class="acc"><button class="acc__btn" data-acc aria-expanded="' + (open ? 'true' : 'false') + '" aria-controls="' + id + '">' + t + ' <span class="ms">add</span></button><div class="acc__panel' + (open ? ' is-open' : '') + '" id="' + id + '">' + html + '</div></div>';
  }

  /* ---------------- Carrello demo (in WordPress lo gestisce WooCommerce) ---------------- */
  var CKEY = 'gm_demo_cart';
  function getCart() { try { return JSON.parse(localStorage.getItem(CKEY)) || []; } catch (e) { return []; } }
  function setCart(c) { localStorage.setItem(CKEY, JSON.stringify(c)); renderCart(); }
  function byId(id) { return P.filter(function (p) { return p.id === +id; })[0]; }
  function renderCart() {
    var c = getCart(), n = 0, tot = 0;
    c.forEach(function (it) { var p = byId(it.id); if (p) { n += it.q; tot += it.q * p.price; } });
    document.querySelectorAll('.js-cart-count').forEach(function (el) { el.textContent = n || ''; el.setAttribute('data-count', n); });
    var t = document.querySelector('.js-cart-title'); if (t) t.textContent = n ? '(' + n + ')' : '';
    var b = document.querySelector('.js-cart-body'), f = document.querySelector('.js-cart-foot');
    if (!b) return;
    if (!c.length) {
      b.innerHTML = '<div class="mini-empty"><span class="ms">shopping_bag</span><p>Il tuo carrello è vuoto.</p><a class="btn btn--outline" href="negozio.html">Scopri i nostri orologi</a></div>';
      f.innerHTML = ''; return;
    }
    b.innerHTML = '<div class="ship-meter"><span class="ms" style="font-size:16px;vertical-align:-3px;color:var(--red)">local_shipping</span> Spedizione in tutto il mondo · Nessun dazio nell’UE</div>' + c.map(function (it) {
      var p = byId(it.id); if (!p) return '';
      return '<div class="mini-item"><img src="' + p.thumb + '" alt=""><div><h5>' + esc(p.name) + '</h5><span style="font-size:13px;font-weight:600">' + eur(p.price) + '</span><div class="qty"><button data-cq="' + p.id + '" data-d="-1" aria-label="Meno">–</button><input value="' + it.q + '" readonly aria-label="Quantità"><button data-cq="' + p.id + '" data-d="1" aria-label="Più">+</button></div></div><button class="mini-item__rm" data-rm="' + p.id + '" aria-label="Rimuovi"><span class="ms" style="font-size:20px">close</span></button></div>';
    }).join('');
    f.innerHTML = '<div class="mini-total"><span>Subtotale</span><span>' + eur(tot) + '</span></div><p class="mini-note">Spedizione e tasse calcolate al checkout.</p><button class="btn btn--red btn--block" onclick="GM.toast(\'Checkout, pagamenti e spedizioni sono gestiti da WooCommerce in WordPress\')">Procedi al checkout</button>';
  }
  document.addEventListener('click', function (e) {
    var a = e.target.closest('.js-add');
    if (a) {
      e.preventDefault();
      var id = +a.getAttribute('data-id'), q = 1, sel = a.getAttribute('data-qty-from');
      if (sel && document.querySelector(sel)) q = +document.querySelector(sel).value || 1;
      var c = getCart(), it = c.filter(function (x) { return x.id === id; })[0];
      if (it) it.q += q; else c.push({ id: id, q: q });
      setCart(c);
      GM.open('cart');
      return;
    }
    var cq = e.target.closest('[data-cq]');
    if (cq) {
      var c2 = getCart(), id2 = +cq.getAttribute('data-cq');
      c2.forEach(function (x) { if (x.id === id2) x.q = Math.max(1, x.q + +cq.getAttribute('data-d')); });
      setCart(c2); return;
    }
    var rm = e.target.closest('[data-rm]');
    if (rm) setCart(getCart().filter(function (x) { return x.id !== +rm.getAttribute('data-rm'); }));
  });

  /* Risultati immediati nel pannello di ricerca */
  document.addEventListener('input', function (e) {
    if (e.target.id !== 'gm-search') return;
    var q = e.target.value.trim().toLowerCase(), box = document.querySelector('.search-results');
    if (!box) return;
    if (q.length < 2) { box.innerHTML = ''; return; }
    var r = P.filter(function (p) { return p.name.toLowerCase().indexOf(q) > -1 || p.catName.toLowerCase().indexOf(q) > -1; }).slice(0, 10);
    box.innerHTML = r.length ? r.map(function (p) { return '<a href="prodotto.html?p=' + p.slug + '"><img src="' + p.thumb + '" alt=""><span>' + esc(p.name) + '</span><em>' + eur(p.price) + '</em></a>'; }).join('') : '<p class="muted">Nessun orologio trovato per “' + esc(q) + '”.</p>';
  });

  document.addEventListener('DOMContentLoaded', renderCart);
  setTimeout(renderCart, 0);
})();
