<?php
/**
 * Header: mega menu, menu mobile, ricerca.
 *
 * @package gmbrand
 */

defined( 'ABSPATH' ) || exit;
$gm_count = gm_cart_count();
$gm_menu  = gm_menu();
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="theme-color" content="#ffffff">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link sr-only" href="#main">Vai al contenuto</a>

<header class="site-header<?php echo ( is_front_page() || is_page( 'servizi' ) ) ? ' is-transparent' : ''; ?>">
	<div class="container header-main">
		<div class="header-left">
			<button class="icon-btn hide-desktop" data-open="menu" aria-label="Apri il menu"><span class="ms">menu</span></button>
			<button class="icon-btn icon-btn--text" data-open="search" aria-label="Cerca"><span class="ms">search</span><span class="icon-btn__label hide-mobile">Cerca</span></button>
			<a class="icon-btn icon-btn--text hide-mobile" href="<?php echo esc_url( gm_page_url( 'contatti' ) ); ?>"><span class="ms">call</span><span class="icon-btn__label">Contattaci</span></a>
		</div>

		<a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<img src="<?php echo esc_url( gm_logo() ); ?>" alt="<?php bloginfo( 'name' ); ?>" width="400" height="60">
		</a>

		<div class="header-right">
			<a class="icon-btn hide-mobile" href="<?php echo esc_url( gm_account_url() ); ?>" aria-label="Il mio account"><span class="ms">person</span></a>
			<a class="icon-btn" href="<?php echo esc_url( add_query_arg( 'wishlist', '1', gm_shop_url() ) ); ?>" aria-label="Lista dei desideri"><span class="ms">favorite</span><span class="cart-count js-wish-count"></span></a>
			<a class="icon-btn" href="<?php echo esc_url( function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : '#' ); ?>" aria-label="Carrello">
				<span class="ms">shopping_bag</span>
				<span class="cart-count js-cart-count" data-count="<?php echo (int) $gm_count; ?>"><?php echo $gm_count ? (int) $gm_count : ''; ?></span>
			</a>
		</div>
	</div>

	<nav class="primary-nav" aria-label="Menu principale">
		<?php
		if ( has_nav_menu( 'primary' ) ) {
			wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'depth' => 2 ) );
		} else {
			get_template_part( 'template-parts/mega-menu' );
		}
		?>
	</nav>
</header>

<div class="overlay" aria-hidden="true"></div>

<!-- Menu mobile -->
<aside class="drawer drawer--left" data-drawer="menu" aria-hidden="true" aria-label="Menu">
	<div class="drawer__head">
		<img src="<?php echo esc_url( gm_logo() ); ?>" alt="" style="height:18px;width:auto">
		<button class="icon-btn" data-close aria-label="Chiudi il menu"><span class="ms">close</span></button>
	</div>
	<div class="drawer__body">
		<ul class="m-nav" data-acc-group>
			<?php foreach ( $gm_menu as $i => $item ) : ?>
				<?php if ( empty( $item['cols'] ) ) : ?>
					<li><a href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a></li>
				<?php else : ?>
					<li>
						<button class="m-nav__toggle" data-acc data-acc-single aria-expanded="false" aria-controls="mn-<?php echo (int) $i; ?>"><?php echo esc_html( $item['label'] ); ?> <span class="ms">add</span></button>
						<ul class="m-nav__panel" id="mn-<?php echo (int) $i; ?>">
							<?php foreach ( $item['cols'] as $col ) : ?>
								<?php foreach ( $col[1] as $l ) : ?>
									<li><a href="<?php echo esc_url( $l[1] ); ?>"><?php echo esc_html( $l[0] ); ?></a></li>
								<?php endforeach; ?>
							<?php endforeach; ?>
						</ul>
					</li>
				<?php endif; ?>
			<?php endforeach; ?>
			<li><a href="<?php echo esc_url( gm_page_url( 'contatti' ) ); ?>">Contatti</a></li>
		</ul>
		<div class="m-nav-extra">
			<a href="<?php echo esc_url( gm_account_url() ); ?>"><span class="ms">person</span> Il mio account</a>
			<a href="mailto:<?php echo esc_attr( gm_mod( 'gm_email', 'infowatches@gmbrand.it' ) ); ?>"><span class="ms">mail</span> <?php echo esc_html( gm_mod( 'gm_email', 'infowatches@gmbrand.it' ) ); ?></a>
			<a href="<?php echo esc_url( gm_page_url( 'spedizioni-resi' ) ); ?>"><span class="ms">local_shipping</span> Spedizioni e resi</a>
		</div>
	</div>
</aside>

<!-- Ricerca -->
<div class="search-panel" aria-hidden="true" role="dialog" aria-label="Cerca">
	<div class="container">
		<form class="search-panel__bar" role="search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<span class="ms">search</span>
			<label class="sr-only" for="gm-search">Cerca orologi</label>
			<input id="gm-search" type="search" name="s" placeholder="Cerca orologi…" autocomplete="off">
			<?php if ( class_exists( 'WooCommerce' ) ) : ?><input type="hidden" name="post_type" value="product"><?php endif; ?>
			<button type="button" class="icon-btn" data-close aria-label="Chiudi la ricerca"><span class="ms">close</span></button>
		</form>
		<div class="search-panel__body">
			<span class="eyebrow">Ricerche frequenti</span>
			<div class="search-tags">
				<?php foreach ( array( 'Nautilus', 'Datejust', 'Oak', 'Cronograph', 'GMT', 'Tiffany', 'Rose gold' ) as $tag ) : ?>
					<a href="<?php echo esc_url( add_query_arg( array( 's' => $tag, 'post_type' => 'product' ), home_url( '/' ) ) ); ?>"><?php echo esc_html( $tag ); ?></a>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>

<main id="main">
