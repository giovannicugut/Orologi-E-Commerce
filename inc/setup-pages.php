<?php
/**
 * Crea le pagine del tema all'attivazione (solo se non esistono già).
 * Chi siamo, Contatti, FAQ, Personalizza e Cura dell'orologio usano template dedicati
 * (page-{slug}.php); Spedizioni e resi e Garanzia sono pagine normali modificabili.
 *
 * @package gmbrand
 */

defined( 'ABSPATH' ) || exit;

function gm_create_pages() {
	$pages = array(
		'chi-siamo'       => array( 'Chi siamo', '' ),
		'contatti'        => array( 'Contatti', '' ),
		'faq'             => array( 'Domande frequenti', '' ),
		'personalizza'    => array( 'Personalizza il tuo orologio', '' ),
		'servizi'         => array( 'Servizi', '' ),
		'cura-orologio'   => array( "Cura dell'orologio", '' ),
		'spedizioni-resi' => array( 'Spedizioni e resi',
			"<!-- wp:heading --><h2>Spedizioni</h2><!-- /wp:heading -->\n<!-- wp:paragraph --><p>Spediamo in tutto il mondo: ovunque tu sia, il tuo orologio ti troverà.</p><!-- /wp:paragraph -->\n<!-- wp:list --><ul><li>Italia: 1–2 giorni lavorativi</li><li>Europa: 3–4 giorni lavorativi</li><li>Resto del mondo: 5–10 giorni lavorativi</li><li>Orologi su misura: 5 giorni lavorativi in più per la costruzione</li></ul><!-- /wp:list -->\n<!-- wp:heading --><h2>Dazi doganali</h2><!-- /wp:heading -->\n<!-- wp:paragraph --><p>Nessun dazio all’interno dell’Unione Europea. Fuori dall’UE possono essere applicati dazi e tasse locali in base al paese.</p><!-- /wp:paragraph -->\n<!-- wp:heading --><h2>Resi</h2><!-- /wp:heading -->\n<!-- wp:paragraph --><p>Puoi restituire l’orologio entro 14 giorni dalla consegna. Il rimborso completo è previsto solo se il sigillo di ceralacca sulla scatola è intatto. Scrivici prima di rispedire il pacco.</p><!-- /wp:paragraph -->" ),
		'garanzia'        => array( 'Garanzia',
			"<!-- wp:paragraph --><p>Ogni orologio GMBRAND è coperto da una garanzia di un anno. Curiamo ogni dettaglio perché i nostri clienti siano sempre soddisfatti: se qualcosa non va, contattaci e ce ne occuperemo noi.</p><!-- /wp:paragraph -->" ),
	);
	foreach ( $pages as $slug => $p ) {
		if ( ! get_page_by_path( $slug ) ) {
			wp_insert_post( array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_name'    => $slug,
				'post_title'   => $p[0],
				'post_content' => $p[1],
			) );
		}
	}
}
add_action( 'after_switch_theme', 'gm_create_pages' );

/* Dopo un aggiornamento del tema crea le pagine nuove (una volta per versione). */
add_action( 'admin_init', function () {
	if ( get_option( 'gm_pages_version' ) !== GM_VERSION ) {
		gm_create_pages();
		update_option( 'gm_pages_version', GM_VERSION );
	}
} );
