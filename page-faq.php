<?php
/**
 * Domande frequenti (slug "faq").
 *
 * @package gmbrand
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>
<header class="page-title">
	<div class="container">
		<span class="eyebrow">Servizio clienti</span>
		<h1 class="h-lg">Domande frequenti</h1>
	</div>
</header>
<section class="section">
	<div class="container narrow">
		<div class="faq-list" data-acc-group>
			<?php foreach ( gm_faqs() as $i => $f ) : ?>
				<div class="acc">
					<button class="acc__btn" data-acc aria-expanded="<?php echo 0 === $i ? 'true' : 'false'; ?>" aria-controls="faq-<?php echo (int) $i; ?>"><?php echo esc_html( $f[0] ); ?> <span class="ms">add</span></button>
					<div class="acc__panel<?php echo 0 === $i ? ' is-open' : ''; ?>" id="faq-<?php echo (int) $i; ?>"><p><?php echo esc_html( $f[1] ); ?></p></div>
				</div>
			<?php endforeach; ?>
		</div>
		<?php
		while ( have_posts() ) :
			the_post();
			echo '<div class="prose" style="margin-top:40px">';
			the_content();
			echo '</div>';
		endwhile;
		?>
		<div class="center" style="margin-top:56px">
			<p class="lead">Hai ancora una domanda?</p>
			<a class="btn btn--red" href="<?php echo esc_url( gm_page_url( 'contatti' ) ); ?>">Contattaci</a>
		</div>
	</div>
</section>
<?php
get_footer();
