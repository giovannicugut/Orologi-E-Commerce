<?php
/**
 * WooCommerce wrapper: shop, categories, single product.
 * Cart / checkout / account are normal pages rendered by page.php.
 *
 * @package gmbrand
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>
<div class="container wc-page">
	<?php
	if ( function_exists( 'woocommerce_breadcrumb' ) ) {
		woocommerce_breadcrumb();
	}
	woocommerce_content();
	?>
</div>
<?php
get_footer();
