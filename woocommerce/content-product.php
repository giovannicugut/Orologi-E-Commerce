<?php
/**
 * Card prodotto (griglie negozio, home, correlati) – stile editoriale:
 * foto su fondo chiaro, nome, caratteristiche e prezzo centrati, nessun pulsante.
 * Sovrascrive woocommerce/templates/content-product.php
 *
 * @package gmbrand
 * @version 9.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
$gm_img_id = $product->get_image_id();
$gm_spec   = gm_product_spec( $product );
?>
<li <?php wc_product_class( '', $product ); ?>>
	<article class="pcard<?php echo $product->is_in_stock() ? '' : ' is-soldout'; ?>">
		<a class="pcard__media" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( $product->get_name() ); ?>">
			<span class="pcard__badges"><?php echo gm_product_badges( $product ); // phpcs:ignore ?></span>
			<?php
			if ( $gm_img_id ) {
				echo wp_get_attachment_image( $gm_img_id, 'woocommerce_thumbnail', false, array( 'loading' => 'lazy', 'alt' => $product->get_name() ) );
			} else {
				echo wc_placeholder_img( 'woocommerce_thumbnail' ); // phpcs:ignore
			}
			?>
		</a>
		<button class="pcard__wish" data-id="<?php echo esc_attr( $product->get_id() ); ?>" aria-label="Aggiungi alla lista dei desideri" aria-pressed="false"><span class="ms">favorite</span></button>
		<a class="pcard__body" href="<?php the_permalink(); ?>">
			<h3 class="pcard__title"><?php echo esc_html( $product->get_name() ); ?></h3>
			<p class="pcard__spec"><?php echo esc_html( $gm_spec ? $gm_spec : gm_product_cat_name( $product ) ); ?></p>
			<div class="pcard__price price"><?php echo $product->get_price_html(); // phpcs:ignore ?></div>
		</a>
	</article>
</li>
