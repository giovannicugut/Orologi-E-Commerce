<?php
/**
 * Integrazione WooCommerce.
 *
 * @package gmbrand
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WooCommerce' ) ) {
	add_action( 'admin_notices', function () {
		if ( current_user_can( 'install_plugins' ) ) {
			echo '<div class="notice notice-warning"><p><strong>GMBRAND Prestige:</strong> installa e attiva <a href="' . esc_url( admin_url( 'plugin-install.php?s=woocommerce&tab=search&type=term' ) ) . '">WooCommerce</a> per attivare negozio, carrello, checkout, pagamenti, spedizioni e account clienti.</p></div>';
		}
	} );
	return;
}

/* Contatore carrello nell'header aggiornato dai frammenti AJAX di WooCommerce. */
add_filter( 'woocommerce_add_to_cart_fragments', function ( $fragments ) {
	$n = gm_cart_count();
	$fragments['span.js-cart-count'] = '<span class="cart-count js-cart-count" data-count="' . $n . '">' . ( $n ? $n : '' ) . '</span>';
	return $fragments;
} );

/* Prodotti per pagina / correlati. */
add_filter( 'loop_shop_per_page', function () { return 24; } );
add_filter( 'woocommerce_output_related_products_args', function ( $args ) {
	$args['posts_per_page'] = 4;
	$args['columns']        = 4;
	return $args;
} );

/* Nessuna sidebar, breadcrumb del tema. */
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
add_filter( 'woocommerce_breadcrumb_defaults', function ( $d ) {
	$d['delimiter']   = '<span class="sep">/</span>';
	$d['wrap_before'] = '<nav class="woocommerce-breadcrumb" aria-label="Percorso">';
	$d['home']        = 'Home';
	return $d;
} );

/* Chip delle collezioni sopra la griglia prodotti. */
add_action( 'woocommerce_before_shop_loop', function () {
	$current = is_product_category() ? get_queried_object()->slug : '';
	echo '<nav class="chips" aria-label="Collezioni"><a class="chip' . ( $current ? '' : ' is-active' ) . '" href="' . esc_url( gm_shop_url() ) . '">Tutti gli orologi</a>';
	foreach ( gm_collections() as $slug => $c ) {
		echo '<a class="chip' . ( $current === $slug ? ' is-active' : '' ) . '" href="' . esc_url( gm_cat_link( $slug ) ) . '">' . esc_html( $c['name'] ) . '</a>';
	}
	echo '</nav><div class="toolbar">';
}, 5 );
add_action( 'woocommerce_before_shop_loop', function () { echo '</div>'; }, 40 );

/* Riquadri marketing tra i prodotti (posizioni 7, 11 e 19 della griglia). */
add_action( 'woocommerce_shop_loop', function () {
	global $wp_query;
	$pos    = (int) $wp_query->current_post;
	$promos = gm_promos();
	$map    = array( 6 => 0, 10 => 1, 18 => 2 );
	if ( isset( $map[ $pos ] ) && isset( $promos[ $map[ $pos ] ] ) ) {
		echo gm_promo_html( $promos[ $map[ $pos ] ], 10 === $pos ); // phpcs:ignore
	}
} );

/* Vantaggi sotto "Aggiungi al carrello" nella scheda prodotto. */
add_action( 'woocommerce_single_product_summary', function () {
	?>
	<ul class="perks">
		<li><span class="ms">precision_manufacturing</span> Assemblato a mano in Italia con movimento Seiko</li>
		<li><span class="ms">verified</span> Garanzia di un anno</li>
		<li><span class="ms">local_shipping</span> Spedizione nel mondo – 1-2 giorni in Italia, 3-4 in Europa</li>
		<li><span class="ms">assignment_return</span> Reso entro 14 giorni con sigillo integro</li>
	</ul>
	<?php
}, 35 );

/* Badge "Offerta" / "Novità" / "Esaurito". */
function gm_product_badges( $product ) {
	$out = '';
	if ( ! $product->is_in_stock() ) {
		$out .= '<span class="badge badge--outline">Esaurito</span>';
	} elseif ( $product->is_on_sale() ) {
		$out .= '<span class="badge badge--red">Offerta</span>';
	}
	$created = $product->get_date_created();
	if ( $product->is_in_stock() && ( ( $created && $created->getTimestamp() > strtotime( '-60 days' ) ) || has_term( 'novita', 'product_tag', $product->get_id() ) ) ) {
		$out .= '<span class="badge">Novità</span>';
	}
	return $out;
}

/* Riga caratteristiche: "40 mm, automatico Seiko". */
function gm_product_spec( $product ) {
	$parts = array();
	foreach ( array( 'Diametro cassa', 'Movimento' ) as $attr ) {
		$v = $product->get_attribute( $attr );
		if ( $v ) {
			$parts[] = 'Movimento' === $attr ? strtolower( $v ) : $v;
		}
	}
	return str_replace( 'seiko', 'Seiko', implode( ', ', $parts ) );
}

function gm_product_cat_name( $product ) {
	$terms = get_the_terms( $product->get_id(), 'product_cat' );
	if ( ! $terms || is_wp_error( $terms ) ) {
		return '';
	}
	foreach ( $terms as $t ) {
		if ( $t->parent ) {
			return $t->name;
		}
	}
	return $terms[0]->name;
}

/* Prodotti per le griglie della home. */
function gm_home_products( $type, $limit = 10 ) {
	$args = array(
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'posts_per_page' => $limit,
		'fields'         => 'ids',
		'no_found_rows'  => true,
		'tax_query'      => array( // phpcs:ignore
			array( 'taxonomy' => 'product_visibility', 'field' => 'name', 'terms' => array( 'exclude-from-catalog' ), 'operator' => 'NOT IN' ),
		),
	);
	switch ( $type ) {
		case 'new':
			$args['orderby'] = 'date';
			$args['order']   = 'DESC';
			break;
		case 'sale':
			$ids = wc_get_product_ids_on_sale();
			if ( ! $ids ) {
				return array();
			}
			$args['post__in'] = $ids;
			break;
		default: // più venduti (disponibili), poi i più recenti.
			$args['meta_key']   = 'total_sales'; // phpcs:ignore
			$args['orderby']    = array( 'meta_value_num' => 'DESC', 'date' => 'DESC' );
			$args['meta_query'] = array( array( 'key' => '_stock_status', 'value' => 'instock' ) ); // phpcs:ignore
	}
	$q = new WP_Query( $args );
	return array_filter( array_map( 'wc_get_product', $q->posts ) );
}

/* /negozio/?wishlist=1 mostra i prodotti salvati nel cookie gm_wishlist;
   /negozio/?in_offerta=1 mostra solo i prodotti in offerta. */
add_action( 'pre_get_posts', function ( $q ) {
	if ( is_admin() || ! $q->is_main_query() ) {
		return;
	}
	if ( ! ( $q->is_post_type_archive( 'product' ) || ( function_exists( 'is_shop' ) && is_shop() ) ) ) {
		return;
	}
	if ( ! empty( $_GET['wishlist'] ) ) { // phpcs:ignore
		$raw = isset( $_COOKIE['gm_wishlist'] ) ? sanitize_text_field( wp_unslash( $_COOKIE['gm_wishlist'] ) ) : '';
		$ids = array_filter( array_map( 'absint', explode( '.', $raw ) ) );
		$q->set( 'post__in', $ids ? $ids : array( 0 ) );
	} elseif ( ! empty( $_GET['in_offerta'] ) ) { // phpcs:ignore
		$ids = wc_get_product_ids_on_sale();
		$q->set( 'post__in', $ids ? $ids : array( 0 ) );
	}
} );
add_filter( 'woocommerce_page_title', function ( $title ) {
	if ( ! empty( $_GET['wishlist'] ) ) { // phpcs:ignore
		return 'La tua lista dei desideri';
	}
	if ( ! empty( $_GET['in_offerta'] ) ) { // phpcs:ignore
		return 'Prezzi speciali';
	}
	return $title;
} );
