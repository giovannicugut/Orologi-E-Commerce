<?php
/**
 * Customizer: hero videos, banners, announcement bar, contacts, socials.
 * Appearance > Customize > "GMBRAND …" panels.
 *
 * @package gmbrand
 */

defined( 'ABSPATH' ) || exit;

function gm_customize_register( $wp ) {

	$text = function ( $id, $label, $section, $type = 'text', $sanitize = 'sanitize_text_field' ) use ( $wp ) {
		$wp->add_setting( $id, array( 'sanitize_callback' => $sanitize, 'transport' => 'refresh' ) );
		$wp->add_control( $id, array( 'label' => $label, 'section' => $section, 'type' => $type ) );
	};
	$media = function ( $id, $label, $section, $mime ) use ( $wp ) {
		$wp->add_setting( $id, array( 'sanitize_callback' => 'esc_url_raw' ) );
		$wp->add_control( new WP_Customize_Upload_Control( $wp, $id, array( 'label' => $label, 'section' => $section, 'mime_type' => $mime ) ) );
	};

	$wp->add_panel( 'gm_panel', array( 'title' => 'GMBRAND Theme', 'priority' => 20 ) );

	/* Announcement bar */

	/* Hero slides */
	for ( $i = 1; $i <= 4; $i++ ) {
		$s = "gm_hero{$i}";
		$wp->add_section( $s, array( 'title' => "Video hero – slide {$i}", 'panel' => 'gm_panel', 'description' => 'Carica un MP4 (1920×1080, max ~10 MB, 8–12 s) o incolla un URL. Lascia vuoto per usare i valori predefiniti.' ) );
		$wp->add_setting( "{$s}_enabled", array( 'default' => true, 'sanitize_callback' => 'wp_validate_boolean' ) );
		$wp->add_control( "{$s}_enabled", array( 'label' => 'Mostra questa slide', 'section' => $s, 'type' => 'checkbox' ) );
		$media( "{$s}_video", 'Video (desktop, MP4)', $s, 'video' );
		$media( "{$s}_video_m", 'Video (mobile, MP4 più leggero – facoltativo)', $s, 'video' );
		$media( "{$s}_poster", 'Immagine di anteprima (mostrata durante il caricamento)', $s, 'image' );
		$text( "{$s}_label", 'Etichetta della tab', $s );
		$text( "{$s}_eyebrow", 'Sopratitolo', $s );
		$text( "{$s}_title", 'Titolo', $s );
		$text( "{$s}_text", 'Testo', $s, 'textarea', 'sanitize_textarea_field' );
		$text( "{$s}_btn", 'Testo del pulsante', $s );
		$text( "{$s}_url", 'Link del pulsante', $s, 'url', 'esc_url_raw' );
	}

	/* Home sections */
	$wp->add_section( 'gm_home', array( 'title' => 'Sezioni della home', 'panel' => 'gm_panel' ) );
	$media( 'gm_split_video', 'Video sezione "Assemblati in Italia"', 'gm_home', 'video' );
	$media( 'gm_banner_video', 'Video banner "Crea il tuo orologio"', 'gm_home', 'video' );
	$text( 'gm_banner_title', 'Titolo del banner', 'gm_home' );
	$text( 'gm_banner_text', 'Testo del banner', 'gm_home', 'textarea', 'sanitize_textarea_field' );

	/* Contacts & social */
	$wp->add_section( 'gm_contacts', array( 'title' => 'Contatti e social', 'panel' => 'gm_panel' ) );
	$text( 'gm_email', 'Email (predefinita infowatches@gmbrand.it)', 'gm_contacts', 'email', 'sanitize_email' );
	$text( 'gm_phone', 'Telefono / WhatsApp (facoltativo)', 'gm_contacts' );
	$text( 'gm_location', 'Sede (predefinita Anghiari, Toscana – Italia)', 'gm_contacts' );
	$text( 'gm_instagram', 'Instagram URL', 'gm_contacts', 'url', 'esc_url_raw' );
	$text( 'gm_tiktok', 'TikTok URL', 'gm_contacts', 'url', 'esc_url_raw' );
	$text( 'gm_youtube', 'YouTube URL', 'gm_contacts', 'url', 'esc_url_raw' );
}
add_action( 'customize_register', 'gm_customize_register' );
