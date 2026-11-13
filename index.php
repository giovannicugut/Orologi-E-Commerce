<?php
/**
 * Fallback template: blog, archives, search results.
 *
 * @package gmbrand
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>
<header class="page-title">
	<div class="container">
		<span class="eyebrow"><?php echo is_search() ? 'Ricerca' : 'Novità e storie'; ?></span>
		<h1 class="h-lg">
			<?php
			if ( is_search() ) {
				printf( 'Risultati per “%s”', esc_html( get_search_query() ) );
			} elseif ( is_archive() ) {
				the_archive_title();
			} else {
				echo 'Journal';
			}
			?>
		</h1>
	</div>
</header>
<div class="container section">
	<?php if ( have_posts() ) : ?>
		<div class="grid">
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article class="pcard">
					<a class="pcard__media" href="<?php the_permalink(); ?>">
						<?php
						if ( has_post_thumbnail() ) {
							the_post_thumbnail( 'medium_large' );
						} else {
							echo '<img src="' . esc_url( GM_URI . '/assets/img/gm-monogram.jpg' ) . '" alt="">';
						}
						?>
					</a>
					<div class="pcard__body">
						<span class="pcard__cat"><?php echo esc_html( get_the_date() ); ?></span>
						<h2 class="pcard__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					</div>
				</article>
			<?php endwhile; ?>
		</div>
		<div style="margin-top:48px" class="center"><?php the_posts_pagination(); ?></div>
	<?php else : ?>
		<p class="empty">Nessun risultato. Prova un’altra ricerca.</p>
	<?php endif; ?>
</div>
<?php
get_footer();
