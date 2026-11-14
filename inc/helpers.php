<?php
/**
 * Helpers: contenuti di default, collezioni, menu, icone.
 *
 * @package gmbrand
 */

defined( 'ABSPATH' ) || exit;

/** Theme mod con valore di default. */
function gm_mod( $key, $default = '' ) {
	$v = get_theme_mod( $key, $default );
	return ( '' === $v || null === $v ) ? $default : $v;
}

/** Immagine dalla libreria media attuale di gmbrand.it (finché non carichi le tue). */
function gm_remote( $path ) {
	return GM_UPLOADS . ltrim( $path, '/' );
}

/** Video stock (Pexels, licenza gratuita) – sostituibili da Aspetto › Personalizza › GMBRAND. */
function gm_default_videos() {
	$p = 'https://videos.pexels.com/video-files/';
	return array(
		'gears'    => array( $p . '11965370/11965370-hd_1920_1080_24fps.mp4', $p . '11965370/11965370-sd_960_540_24fps.mp4' ),
		'gold'     => array( $p . '13736229/13736229-hd_1280_720_30fps.mp4', $p . '13736229/13736229-sd_640_360_30fps.mp4' ), // versione leggera: 1,7 MB / 0,4 MB
		'wrist'    => array( $p . '6328383/6328383-hd_2048_1080_25fps.mp4', $p . '6328383/6328383-sd_960_506_25fps.mp4' ),
		'blue'     => array( $p . '39108088/16639006_1920_1080_25fps.mp4', $p . '39108088/16639003_960_540_25fps.mp4' ),
		'hands'    => array( $p . '12178371/12178371-hd_1920_1080_50fps.mp4', $p . '12178371/12178371-sd_960_540_25fps.mp4' ),
		'dial'     => array( $p . '4824611/4824611-hd_1920_1080_30fps.mp4', $p . '4824611/4824611-sd_960_540_30fps.mp4' ),
		'face'     => array( $p . '1034069/1034069-hd_1920_1080_25fps.mp4', $p . '1034069/1034069-sd_960_540_25fps.mp4' ),
		'closeup'  => array( $p . '1034068/1034068-hd_1920_1080_25fps.mp4', $p . '1034068/1034068-sd_960_540_25fps.mp4' ),
		'skeleton' => array( $p . '6913975/6913975-hd_1280_720_25fps.mp4', $p . '6913975/6913975-sd_640_360_25fps.mp4' ), // versione leggera: 2,9 MB / 0,6 MB
	);
}

/** Slide dell'hero (valori del Customizer con default). */
function gm_hero_slides() {
	$v    = gm_default_videos();
	$shop = gm_shop_url();
	$defaults = array(
		1 => array( 'label' => 'Made in Italy', 'eyebrow' => 'Made in Italy · Anima giapponese', 'title' => 'Orologi su misura, fatti a mano', 'text' => 'Ogni orologio GMBRAND è assemblato a mano in Toscana attorno a un movimento Seiko originale.', 'btn' => 'Scopri la collezione', 'url' => $shop, 'video' => $v['skeleton'][0], 'video_m' => $v['skeleton'][1], 'poster' => GM_URI . '/assets/img/hero-1-poster.jpg' ),
		2 => array( 'label' => 'Datejust Mod.', 'eyebrow' => 'Datejust Mod.', 'title' => 'Eleganza senza tempo', 'text' => 'Lunette zigrinate, indici baguette e bracciali jubilee in 36 e 39 mm.', 'btn' => 'Acquista Datejust Mod.', 'url' => gm_cat_link( 'datejust-mod' ), 'video' => $v['gold'][0], 'video_m' => $v['gold'][1], 'poster' => GM_URI . '/assets/img/hero-2-poster.jpg' ),
		3 => array( 'label' => 'Cronografi', 'eyebrow' => 'Edizioni limitate', 'title' => 'Precisione e carattere', 'text' => 'Cronografi panda, racing e vintage da 40 mm, costruiti per durare.', 'btn' => 'Acquista i cronografi', 'url' => gm_cat_link( 'cronografi' ), 'video' => $v['blue'][0], 'video_m' => $v['blue'][1], 'poster' => gm_remote( '2024/04/IMG_0303-768x512.jpg' ) ),
		4 => array( 'label' => 'Su misura', 'eyebrow' => '100% personalizzato', 'title' => 'Crea il tuo orologio dei sogni', 'text' => 'Scegli quadrante, lancette, lunetta e bracciale. I nostri orologiai lo costruiscono per te in cinque giorni lavorativi.', 'btn' => 'Inizia il progetto', 'url' => gm_page_url( 'personalizza' ), 'video' => $v['dial'][0], 'video_m' => $v['dial'][1], 'poster' => gm_remote( '2024/11/IMG_2409-768x512.jpg' ) ),
	);
	$slides = array();
	foreach ( $defaults as $i => $d ) {
		$s = array();
		foreach ( $d as $k => $def ) {
			$s[ $k ] = gm_mod( "gm_hero{$i}_{$k}", $def );
		}
		if ( gm_mod( "gm_hero{$i}_enabled", true ) && ( $s['video'] || $s['poster'] ) ) {
			$slides[] = $s;
		}
	}
	return $slides;
}

/** Collezioni – gli slug corrispondono all'import CSV di WooCommerce. */
function gm_collections() {
	return array(
		'datejust-mod' => array( 'name' => 'Datejust Mod.', 'img' => '2024/10/IMG_2015-768x512.jpg' ),
		'nautilus-mod' => array( 'name' => 'Nautilus Mod.', 'img' => '2024/11/IMG_2409-768x512.jpg' ),
		'oak-mod'      => array( 'name' => 'Oak Mod.', 'img' => '2024/10/IMG_1874-768x512.jpg' ),
		'sub-mod'      => array( 'name' => 'Sub. Mod.', 'img' => '2025/12/IMG_9748-768x512.jpg' ),
		'cronografi'   => array( 'name' => 'Cronografi', 'img' => '2024/04/IMG_0303-768x512.jpg' ),
		'santos-mod'   => array( 'name' => 'Santos Mod.', 'img' => '2024/10/IMG_2083-768x512.jpg' ),
	);
}
function gm_accessories() {
	return array(
		'cinturini'  => array( 'Cinturini', '2024/10/IMG_1769-768x512.jpg' ),
		'custodie'   => array( 'Custodie per orologi', '2024/02/IMG_0062-768x512.jpg' ),
	);
}

function gm_shop_url() {
	return function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/negozio/' );
}

function gm_term_link( $slug, $tax = 'product_cat' ) {
	if ( taxonomy_exists( $tax ) ) {
		$term = get_term_by( 'slug', $slug, $tax );
		if ( $term && ! is_wp_error( $term ) ) {
			return get_term_link( $term );
		}
	}
	return home_url( ( 'product_tag' === $tax ? '/tag-prodotto/' : '/categoria-prodotto/' ) . $slug . '/' );
}
function gm_cat_link( $slug ) {
	return gm_term_link( $slug, 'product_cat' );
}
function gm_tag_link( $slug ) {
	return gm_term_link( $slug, 'product_tag' );
}

/** Immagine categoria: miniatura WooCommerce se presente, altrimenti foto di default. */
function gm_cat_image( $slug ) {
	if ( taxonomy_exists( 'product_cat' ) ) {
		$term = get_term_by( 'slug', $slug, 'product_cat' );
		if ( $term ) {
			$thumb = get_term_meta( $term->term_id, 'thumbnail_id', true );
			if ( $thumb ) {
				return wp_get_attachment_image_url( $thumb, 'large' );
			}
		}
	}
	$c = gm_collections();
	return isset( $c[ $slug ] ) ? gm_remote( $c[ $slug ]['img'] ) : gm_remote( '2024/02/Final-Gm-brand-01-scaled.jpg' );
}

function gm_page_url( $slug ) {
	$p = get_page_by_path( $slug );
	return $p ? get_permalink( $p ) : home_url( '/' . $slug . '/' );
}

function gm_account_url( $endpoint = '' ) {
	if ( ! function_exists( 'wc_get_page_permalink' ) ) {
		return wp_login_url();
	}
	return $endpoint && function_exists( 'wc_get_account_endpoint_url' ) ? wc_get_account_endpoint_url( $endpoint ) : wc_get_page_permalink( 'myaccount' );
}

function gm_cart_count() {
	return ( function_exists( 'WC' ) && WC()->cart ) ? (int) WC()->cart->get_cart_contents_count() : 0;
}

function gm_logo() {
	if ( has_custom_logo() ) {
		return wp_get_attachment_image_url( get_theme_mod( 'custom_logo' ), 'full' );
	}
	return GM_URI . '/assets/img/logo.png';
}

/**
 * Menu principale in stile "maison": usato dal mega menu desktop e dal menu mobile.
 * Ogni voce: label, url, colonne di link, tile con immagine.
 */
function gm_menu() {
	$shop = gm_shop_url();
	$cols = array();
	foreach ( gm_collections() as $slug => $c ) {
		$cols[] = array( $c['name'], gm_cat_link( $slug ) );
	}
	$tiles = array();
	foreach ( array_slice( gm_collections(), 0, 3, true ) as $slug => $c ) {
		$tiles[] = array( $c['name'], gm_cat_image( $slug ), gm_cat_link( $slug ) );
	}
	$acc = array();
	$acc_tiles = array();
	foreach ( gm_accessories() as $slug => $a ) {
		$acc[]       = array( $a[0], gm_cat_link( $slug ) );
		$acc_tiles[] = array( $a[0], gm_remote( $a[1] ), gm_cat_link( $slug ) );
	}
	return array(
		array(
			'label' => 'Orologi', 'url' => $shop,
			'cols'  => array(
				array( 'Collezioni', $cols ),
				array( 'Scopri', array(
					array( 'Novità', add_query_arg( 'orderby', 'date', $shop ) ),
					array( 'I più venduti', add_query_arg( 'orderby', 'popularity', $shop ) ),
					array( 'Prezzi speciali', add_query_arg( 'in_offerta', '1', $shop ) ),
					array( 'Edizioni limitate', $shop ),
				) ),
				array( 'Per diametro', array(
					array( '36 mm', add_query_arg( array( 's' => '36mm', 'post_type' => 'product' ), home_url( '/' ) ) ),
					array( '39 – 40 mm', add_query_arg( array( 's' => '40mm', 'post_type' => 'product' ), home_url( '/' ) ) ),
					array( '41 – 42 mm', add_query_arg( array( 's' => '42mm', 'post_type' => 'product' ), home_url( '/' ) ) ),
					array( '45 mm', add_query_arg( array( 's' => '45mm', 'post_type' => 'product' ), home_url( '/' ) ) ),
				) ),
			),
			'tiles' => $tiles,
		),
		array(
			'label' => 'Accessori', 'url' => gm_cat_link( 'cinturini' ),
			'cols'  => array( array( 'Accessori', $acc ) ),
			'tiles' => $acc_tiles,
		),
		array(
			'label' => 'Idee regalo', 'url' => gm_tag_link( 'regalo-lui' ),
			'cols'  => array(
				array( 'Idee regalo', array(
					array( 'Idee regalo per lui', gm_tag_link( 'regalo-lui' ) ),
					array( 'Idee regalo per lei', gm_tag_link( 'regalo-lei' ) ),
					array( 'Sotto i 250 €', add_query_arg( 'orderby', 'price', $shop ) ),
					array( 'Il regalo su misura', gm_page_url( 'personalizza' ) ),
				) ),
			),
			'tiles' => array(
				array( 'Per lui', gm_remote( '2025/12/IMG_9748-768x512.jpg' ), gm_tag_link( 'regalo-lui' ) ),
				array( 'Per lei', gm_remote( '2024/04/IMG_1513-768x512.jpg' ), gm_tag_link( 'regalo-lei' ) ),
				array( 'Su misura', gm_remote( '2024/10/IMG_1781-768x512.jpg' ), gm_page_url( 'personalizza' ) ),
			),
		),
		array( 'label' => 'Personalizza', 'url' => gm_page_url( 'personalizza' ) ),
		array(
			'label' => 'Servizi', 'url' => gm_page_url( 'servizi' ),
			'cols'  => array(
				array( 'Assistenza', array(
					array( 'Il nostro servizio', gm_page_url( 'servizi' ) ),
					array( "Cura dell'orologio", gm_page_url( 'cura-orologio' ) ),
					array( 'Domande frequenti', gm_page_url( 'faq' ) ),
					array( 'Contatti', gm_page_url( 'contatti' ) ),
				) ),
				array( 'Il tuo account', array(
					array( 'Il mio account', gm_account_url() ),
					array( 'I miei ordini', gm_account_url( 'orders' ) ),
					array( 'Lista dei desideri', add_query_arg( 'wishlist', '1', $shop ) ),
				) ),
			),
			'tiles' => array(
				array( 'Il nostro servizio', gm_px( 8327871, 600 ), gm_page_url( 'servizi' ) ),
				array( "Cura dell'orologio", gm_px( 8327590, 600 ), gm_page_url( 'cura-orologio' ) ),
			),
		),
		array( 'label' => 'Chi siamo', 'url' => gm_page_url( 'chi-siamo' ) ),
	);
}

/** Social. */
function gm_socials() {
	return array(
		'instagram' => array( 'Instagram', gm_mod( 'gm_instagram', 'https://www.instagram.com/gmbrand_watches/' ) ),
		'tiktok'    => array( 'TikTok', gm_mod( 'gm_tiktok', 'https://www.tiktok.com/@gm_brand' ) ),
		'youtube'   => array( 'YouTube', gm_mod( 'gm_youtube', 'https://www.youtube.com/@gmbrand_watches' ) ),
	);
}

function gm_social_svg( $net ) {
	$p = array(
		'instagram' => 'M12 2.2c3.2 0 3.6 0 4.8.1 1.2.1 1.8.2 2.2.4.6.2 1 .5 1.4.9.4.4.7.8.9 1.4.2.4.4 1 .4 2.2.1 1.3.1 1.6.1 4.8s0 3.6-.1 4.8c-.1 1.2-.2 1.8-.4 2.2-.2.6-.5 1-.9 1.4-.4.4-.8.7-1.4.9-.4.2-1 .4-2.2.4-1.3.1-1.6.1-4.8.1s-3.6 0-4.8-.1c-1.2-.1-1.8-.2-2.2-.4-.6-.2-1-.5-1.4-.9-.4-.4-.7-.8-.9-1.4-.2-.4-.4-1-.4-2.2C2.2 15.6 2.2 15.2 2.2 12s0-3.6.1-4.8c.1-1.2.2-1.8.4-2.2.2-.6.5-1 .9-1.4.4-.4.8-.7 1.4-.9.4-.2 1-.4 2.2-.4C8.4 2.2 8.8 2.2 12 2.2zm0 3.1a6.7 6.7 0 1 0 0 13.4 6.7 6.7 0 0 0 0-13.4zm0 11a4.3 4.3 0 1 1 0-8.6 4.3 4.3 0 0 1 0 8.6zm6.9-11.3a1.6 1.6 0 1 1-3.1 0 1.6 1.6 0 0 1 3.1 0z',
		'tiktok'    => 'M16.6 5.8A4.3 4.3 0 0 1 15.5 3h-3.1v12.4a2.6 2.6 0 1 1-2.6-2.6c.3 0 .5 0 .8.1V9.7a5.7 5.7 0 1 0 4.9 5.7V9.1a7.3 7.3 0 0 0 4.3 1.4V7.4a4.3 4.3 0 0 1-3.2-1.6z',
		'youtube'   => 'M23 7.2a3 3 0 0 0-2.1-2.1C19 4.6 12 4.6 12 4.6s-7 0-8.9.5A3 3 0 0 0 1 7.2 31 31 0 0 0 .5 12a31 31 0 0 0 .5 4.8 3 3 0 0 0 2.1 2.1c1.9.5 8.9.5 8.9.5s7 0 8.9-.5a3 3 0 0 0 2.1-2.1 31 31 0 0 0 .5-4.8 31 31 0 0 0-.5-4.8zM9.7 15V9l5.8 3-5.8 3z',
	);
	return '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="' . $p[ $net ] . '"/></svg>';
}

/** Riquadri marketing inseriti tra i prodotti (stile editoriale). */
function gm_promos() {
	return array(
		array( 'img' => gm_remote( '2025/12/IMG_9912-768x512.jpg' ), 'eyebrow' => 'Il nostro laboratorio', 'title' => 'Assemblati a mano in Italia', 'text' => 'Ogni orologio GMBRAND nasce nel nostro laboratorio in Toscana, sempre con un movimento Seiko originale.', 'link' => 'Scopri chi siamo', 'url' => gm_page_url( 'chi-siamo' ) ),
		array( 'img' => gm_remote( '2024/10/IMG_1858-768x512.jpg' ), 'eyebrow' => '100% personalizzato', 'title' => 'Il tuo orologio su misura', 'text' => 'Quadrante, lancette, lunetta e bracciale: scegli ogni dettaglio, noi lo costruiamo in circa cinque giorni lavorativi.', 'link' => 'Inizia il progetto', 'url' => gm_page_url( 'personalizza' ) ),
		array( 'img' => gm_remote( '2024/10/IMG_1781-768x512.jpg' ), 'eyebrow' => 'Ovunque tu sia', 'title' => 'Spedizione in tutto il mondo', 'text' => '1–2 giorni in Italia, 3–4 in Europa. Nessun dazio nell’Unione Europea e garanzia di un anno su ogni orologio.', 'link' => 'Spedizioni e resi', 'url' => gm_page_url( 'spedizioni-resi' ) ),
	);
}

function gm_promo_html( $p, $reverse = false ) {
	return '<li class="promo-tile' . ( $reverse ? ' promo-tile--reverse' : '' ) . '"><a class="promo-tile__media" href="' . esc_url( $p['url'] ) . '"><img src="' . esc_url( $p['img'] ) . '" alt="" loading="lazy"></a>'
		. '<div class="promo-tile__body"><span class="eyebrow">' . esc_html( $p['eyebrow'] ) . '</span><h3>' . esc_html( $p['title'] ) . '</h3><p>' . esc_html( $p['text'] ) . '</p><a class="promo-tile__link" href="' . esc_url( $p['url'] ) . '">' . esc_html( $p['link'] ) . '</a></div></li>';
}

/** Recensioni clienti (da gmbrand.it – modificabili). */
function gm_reviews() {
	return array(
		array( 'Sarah M.', 'Londra, Regno Unito', 'Orologio fantastico, esattamente come nelle foto. Lo adoro!' ),
		array( 'James R.', 'New York, USA', 'Ordine semplicissimo, confezione premium e un orologio che al polso trasmette vero lusso.' ),
		array( 'Amina K.', 'Dubai, EAU', 'Tante possibilità di personalizzazione e spedizione internazionale. È arrivato in fretta e in perfette condizioni.' ),
		array( 'Daniel T.', 'Sydney, Australia', 'Da collezionista apprezzo la cura artigianale e l’unicità, a un prezzo che ha senso.' ),
	);
}

/** Foto galleria Instagram. */
function gm_gallery() {
	return array( '2025/12/IMG_9912', '2025/12/IMG_9826', '2025/12/IMG_9723', '2025/12/IMG_9676', '2024/11/IMG_2472', '2024/11/IMG_2407', '2024/11/IMG_2220', '2024/11/IMG_2325', '2024/11/IMG_2421', '2024/11/IMG_2198', '2024/10/IMG_2081', '2024/10/IMG_1858' );
}

/** FAQ (da gmbrand.it). */
function gm_faqs() {
	return array(
		array( 'Ogni orologio ha un numero di referenza?', 'No. I nostri orologi non hanno un numero di referenza perché non sono prodotti da Seiko: sono creazioni personalizzate assemblate nel nostro laboratorio in Italia.' ),
		array( 'Cosa significa "Seiko mod"?', 'Un Seiko mod è un orologio costruito attorno a componenti originali Seiko – a partire dal movimento – abbinati a parti aftermarket selezionate come cassa, quadrante, lancette, lunetta e bracciale.' ),
		array( 'Quanto tempo richiede la spedizione?', 'Gli orologi disponibili partono in 1–2 giorni lavorativi in Italia, 3–4 giorni lavorativi in Europa e 5–10 giorni lavorativi nel resto del mondo. Gli orologi personalizzati richiedono 5 giorni lavorativi in più per la costruzione.' ),
		array( 'Pagherò dazi doganali?', 'No, per le consegne all’interno dell’Unione Europea non ci sono dazi. Fuori dall’UE possono essere applicati dazi e tasse locali in base al tuo paese.' ),
		array( 'Posso restituire un orologio?', 'Sì, puoi restituire l’orologio entro 14 giorni dalla consegna. Il rimborso completo è previsto solo se il sigillo di ceralacca sulla scatola è intatto.' ),
		array( 'Gli orologi hanno una garanzia?', 'Sì, ogni orologio GMBRAND è coperto da una garanzia di un anno.' ),
		array( 'Posso progettare il mio orologio?', 'Certo. Contattaci con la tua idea – colore del quadrante, lancette, lunetta, bracciale – e progetteremo e costruiremo insieme il tuo orologio dei sogni.' ),
	);
}

/** Foto Pexels (licenza gratuita) in alta risoluzione. */
function gm_px( $id, $w = 1920 ) {
	return 'https://images.pexels.com/photos/' . $id . '/pexels-photo-' . $id . '.jpeg?auto=compress&cs=tinysrgb&w=' . $w;
}

/** Contenuti della pagina Servizi. */
function gm_services() {
	return array(
		'hero'      => gm_px( 8327871, 2400 ),
		'fullbleed' => gm_px( 8327524, 2400 ),
		'pillars'   => array(
			array( gm_px( 8327525, 900 ), 'Assistenza personale', 'Rispondiamo personalmente a ogni messaggio – email, Instagram o WhatsApp – prima e dopo l’acquisto.' ),
			array( gm_px( 8327590, 900 ), 'Garanzia di un anno', 'Ogni orologio GMBRAND è coperto da garanzia per un anno. Se qualcosa non va, ce ne occupiamo noi.' ),
			array( gm_px( 8327823, 900 ), 'Collaudo in laboratorio', 'Prima della spedizione ogni orologio viene controllato e regolato a mano nel nostro laboratorio in Toscana.' ),
			array( gm_px( 8327752, 900 ), 'Su misura', 'Quadrante, lancette, lunetta e bracciale: progettiamo insieme il tuo orologio e lo costruiamo in circa 5 giorni lavorativi.' ),
			array( gm_remote( '2024/10/IMG_1781-768x512.jpg' ), 'Spedizione nel mondo', '1–2 giorni in Italia, 3–4 in Europa, 5–10 nel resto del mondo. Nessun dazio all’interno dell’UE.' ),
		),
		'splits'    => array(
			array( 'img' => gm_px( 8327872, 1600 ), 'eyebrow' => 'Revisione', 'title' => 'Prenditi cura del tuo orologio', 'text' => 'Un movimento meccanico è fatto per durare, ma come ogni meccanismo di precisione ha bisogno di attenzione. Se noti un ritardo, un anticipo o un problema di impermeabilità, scrivici: ti diremo come procedere e ci occuperemo noi del controllo.', 'link' => 'Richiedi assistenza', 'page' => 'contatti' ),
			array( 'img' => gm_px( 8327592, 1600 ), 'eyebrow' => 'Cura quotidiana', 'title' => 'Piccoli gesti, lunga vita', 'text' => 'Ricarica, acqua, pulizia, magnetismo e conservazione: abbiamo raccolto i consigli più semplici per mantenere il tuo GMBRAND preciso e bello come il primo giorno.', 'link' => 'Consigli di cura', 'page' => 'cura-orologio' ),
		),
		'discover'  => array(
			array( gm_px( 8327871, 900 ), "Cura dell'orologio", 'cura-orologio' ),
			array( gm_remote( '2024/11/IMG_2440-768x512.jpg' ), 'Garanzia', 'garanzia' ),
			array( gm_remote( '2024/10/IMG_1803-768x512.jpg' ), 'Spedizioni e resi', 'spedizioni-resi' ),
			array( gm_px( 8327525, 900 ), 'Contattaci', 'contatti' ),
		),
	);
}
