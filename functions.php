<?php
/**
 * GMBRAND Prestige – theme functions.
 *
 * @package gmbrand
 */

defined( 'ABSPATH' ) || exit;

define( 'GM_VERSION', '1.2.0' );
define( 'GM_DIR', get_template_directory() );
define( 'GM_URI', get_template_directory_uri() );
define( 'GM_UPLOADS', 'https://www.gmbrand.it/wp-content/uploads/' ); // fallback imagery (current site)

require GM_DIR . '/inc/helpers.php';
require GM_DIR . '/inc/customizer.php';
require GM_DIR . '/inc/woocommerce.php';
require GM_DIR . '/inc/setup-pages.php';

/* -------------------------------------------------------------------------
 * Theme setup
 * ---------------------------------------------------------------------- */
function gm_setup() {
	load_theme_textdomain( 'gmbrand', GM_DIR . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );
	add_theme_support( 'custom-logo', array( 'height' => 60, 'width' => 400, 'flex-height' => true, 'flex-width' => true ) );

	// WooCommerce.
	add_theme_support( 'woocommerce', array(
		'thumbnail_image_width' => 768,
		'single_image_width'    => 1200,
		'product_grid'          => array( 'default_columns' => 4, 'default_rows' => 6, 'min_columns' => 2, 'max_columns' => 4 ),
	) );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	register_nav_menus( array(
		'primary' => __( 'Menu principale (lascia vuoto per usare il mega menu integrato)', 'gmbrand' ),
		'footer'  => __( 'Link legali nel footer', 'gmbrand' ),
	) );
}
add_action( 'after_setup_theme', 'gm_setup' );

/* -------------------------------------------------------------------------
 * Assets
 * ---------------------------------------------------------------------- */
function gm_assets() {
	wp_enqueue_style( 'gm-fonts', 'https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500&family=Space+Grotesk:wght@400;500;600;700&family=Work+Sans:wght@300;400;500;600&display=swap', array(), null );
	wp_enqueue_style( 'gm-icons', 'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=block', array(), null );
	wp_enqueue_style( 'gm-main', GM_URI . '/assets/css/main.css', array(), GM_VERSION );
	wp_enqueue_style( 'gm-style', get_stylesheet_uri(), array( 'gm-main' ), GM_VERSION );

	wp_enqueue_script( 'gm-main', GM_URI . '/assets/js/main.js', array(), GM_VERSION, true );
	wp_localize_script( 'gm-main', 'gmTheme', array(
		'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		'nonce'   => wp_create_nonce( 'gm_newsletter' ),
	) );
}
add_action( 'wp_enqueue_scripts', 'gm_assets' );

function gm_resource_hints( $urls, $relation ) {
	if ( 'preconnect' === $relation ) {
		$urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
		$urls[] = 'https://fonts.googleapis.com';
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'gm_resource_hints', 10, 2 );

/* Body class used by the transparent header over the video hero. */
function gm_body_class( $classes ) {
	if ( is_front_page() || is_page( 'servizi' ) ) {
		$classes[] = 'has-hero';
	}
	return $classes;
}
add_filter( 'body_class', 'gm_body_class' );

/* -------------------------------------------------------------------------
 * Newsletter (stores emails + notifies admin; swap for Mailchimp/Brevo later)
 * ---------------------------------------------------------------------- */
function gm_newsletter() {
	check_ajax_referer( 'gm_newsletter', 'nonce' );
	$email = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	if ( ! is_email( $email ) ) {
		wp_send_json_error();
	}
	$list = get_option( 'gm_newsletter_emails', array() );
	if ( ! in_array( $email, $list, true ) ) {
		$list[] = $email;
		update_option( 'gm_newsletter_emails', $list, false );
		wp_mail( get_option( 'admin_email' ), 'Nuovo iscritto alla newsletter', $email );
	}
	wp_send_json_success();
}
add_action( 'wp_ajax_gm_newsletter', 'gm_newsletter' );
add_action( 'wp_ajax_nopriv_gm_newsletter', 'gm_newsletter' );

/* Show subscribers under Tools > Newsletter. */
function gm_newsletter_page() {
	add_management_page( 'Newsletter', 'Newsletter', 'manage_options', 'gm-newsletter', function () {
		$list = get_option( 'gm_newsletter_emails', array() );
		echo '<div class="wrap"><h1>Iscritti alla newsletter (' . count( $list ) . ')</h1><textarea readonly style="width:100%;height:400px">' . esc_textarea( implode( "\n", $list ) ) . '</textarea></div>';
	} );
}
add_action( 'admin_menu', 'gm_newsletter_page' );

/* -------------------------------------------------------------------------
 * Contact form (page-contact.php)
 * ---------------------------------------------------------------------- */
function gm_contact_submit() {
	if ( ! isset( $_POST['gm_contact_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['gm_contact_nonce'] ) ), 'gm_contact' ) ) {
		wp_die( 'Richiesta non valida' );
	}
	if ( ! empty( $_POST['website'] ) ) { // honeypot
		wp_safe_redirect( home_url( '/' ) );
		exit;
	}
	$name    = sanitize_text_field( wp_unslash( $_POST['name'] ?? '' ) );
	$email   = sanitize_email( wp_unslash( $_POST['email'] ?? '' ) );
	$topic   = sanitize_text_field( wp_unslash( $_POST['topic'] ?? '' ) );
	$message = sanitize_textarea_field( wp_unslash( $_POST['message'] ?? '' ) );
	$back    = wp_get_referer() ? wp_get_referer() : home_url( '/' );

	if ( ! $name || ! is_email( $email ) || ! $message ) {
		wp_safe_redirect( add_query_arg( 'sent', '0', $back ) );
		exit;
	}
	$to = gm_mod( 'gm_email', 'infowatches@gmbrand.it' );
	wp_mail( $to, '[GMBRAND] ' . $topic . ' – ' . $name, $message . "\n\n— " . $name . ' <' . $email . '>', array( 'Reply-To: ' . $name . ' <' . $email . '>' ) );
	wp_safe_redirect( add_query_arg( 'sent', '1', $back ) );
	exit;
}
add_action( 'admin_post_gm_contact', 'gm_contact_submit' );
add_action( 'admin_post_nopriv_gm_contact', 'gm_contact_submit' );
