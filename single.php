<?php
/**
 * Single blog post.
 *
 * @package gmbrand
 */

defined( 'ABSPATH' ) || exit;
get_header();
while ( have_posts() ) :
	the_post();
	?>
	<header class="page-title">
		<div class="container">
			<span class="eyebrow"><?php echo esc_html( get_the_date() ); ?></span>
			<h1 class="h-lg"><?php the_title(); ?></h1>
		</div>
	</header>
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="container" style="margin-top:40px"><?php the_post_thumbnail( 'full', array( 'style' => 'width:100%;max-height:70vh;object-fit:cover' ) ); ?></div>
	<?php endif; ?>
	<article class="container section"><div class="narrow prose"><?php the_content(); ?></div></article>
	<?php
endwhile;
get_footer();
