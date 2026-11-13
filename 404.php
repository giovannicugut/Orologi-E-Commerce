<?php
/**
 * 404.
 *
 * @package gmbrand
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>
<section class="notfound">
	<span class="eyebrow">Errore 404</span>
	<h1 class="display">Fuori tempo</h1>
	<p class="lead">La pagina che cerchi non esiste o è stata spostata.</p>
	<div class="hero__ctas" style="justify-content:center">
		<a class="btn btn--red" href="<?php echo esc_url( gm_shop_url() ); ?>">Vai al negozio</a>
		<a class="btn btn--outline" href="<?php echo esc_url( home_url( '/' ) ); ?>">Torna alla home</a>
	</div>
</section>
<?php
get_footer();
