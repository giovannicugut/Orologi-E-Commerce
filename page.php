<?php
/**
 * Default page (also cart, checkout, my account).
 *
 * @package gmbrand
 */

defined( 'ABSPATH' ) || exit;
get_header();
$gm_wc_page = function_exists( 'is_cart' ) && ( is_cart() || is_checkout() || is_account_page() );

while ( have_posts() ) :
	the_post();
	?>
	<header class="page-title">
		<div class="container">
			<span class="eyebrow"><?php echo $gm_wc_page ? 'GMBRAND' : esc_html( get_bloginfo( 'name' ) ); ?></span>
			<h1 class="h-lg"><?php the_title(); ?></h1>
		</div>
	</header>
	<div class="container section--tight" style="padding-top:48px;padding-bottom:96px">
		<div class="<?php echo $gm_wc_page ? '' : 'narrow prose'; ?>">
			<?php the_content(); ?>
		</div>
	</div>
	<?php
endwhile;

get_footer();
