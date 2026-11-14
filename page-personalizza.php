<?php
/**
 * Personalizza il tuo orologio (slug "personalizza").
 *
 * @package gmbrand
 */

defined( 'ABSPATH' ) || exit;
get_header();
$gm_v    = gm_default_videos();
$gm_sent = isset( $_GET['sent'] ) ? sanitize_text_field( wp_unslash( $_GET['sent'] ) ) : ''; // phpcs:ignore
?>
<section class="page-hero">
	<video muted playsinline loop preload="none" poster="<?php echo esc_url( GM_URI . '/assets/img/personalizza-poster.jpg' ); ?>" data-lazy data-src="<?php echo esc_url( $gm_v['gears'][0] ); ?>" data-src-mobile="<?php echo esc_url( $gm_v['gears'][1] ); ?>"></video>
	<div class="container">
		<span class="eyebrow eyebrow--gold">100% personalizzato</span>
		<h1 class="display">Crea il tuo orologio dei sogni</h1>
		<p class="lead">Ogni dettaglio, costruito sul tuo stile. Raccontaci la tua idea: i nostri orologiai la progetteranno con te e la costruiranno in circa 5 giorni lavorativi.</p>
	</div>
</section>

<section class="section section--subtle">
	<div class="container">
		<ol class="timeline reveal" style="list-style:none;padding:0;margin:0">
			<li><h4>Base</h4><p>Datejust, Nautilus, Oak, Sub, Santos o un cronografo.</p></li>
			<li><h4>Quadrante e lancette</h4><p>Colori, texture, indici baguette o diamante.</p></li>
			<li><h4>Lunetta e cassa</h4><p>Finiture acciaio, nero, oro o oro rosa.</p></li>
			<li><h4>Bracciale</h4><p>Jubilee, oyster, integrato o cinturino in pelle.</p></li>
		</ol>
	</div>
</section>

<section class="section">
	<div class="container narrow">
		<div class="section-head reveal" style="margin-bottom:40px"><span class="eyebrow">Il tuo progetto</span><h2 class="h-lg">Raccontacelo</h2></div>
		<form class="form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="gm_contact">
			<input type="hidden" name="topic" value="Richiesta orologio su misura">
			<?php wp_nonce_field( 'gm_contact', 'gm_contact_nonce' ); ?>
			<input type="text" name="website" tabindex="-1" autocomplete="off" style="position:absolute;left:-9999px" aria-hidden="true">
			<?php if ( '1' === $gm_sent ) : ?>
				<p class="full woocommerce-message" style="padding:14px 18px;margin:0">Grazie! Abbiamo ricevuto il tuo progetto e ti contatteremo presto.</p>
			<?php endif; ?>
			<div><label for="p-name">Nome *</label><input id="p-name" name="name" required></div>
			<div><label for="p-email">Email *</label><input id="p-email" name="email" type="email" required></div>
			<div class="full"><label for="p-msg">Descrivi il tuo orologio * (modello base, quadrante, lunetta, bracciale, diametro, budget)</label><textarea id="p-msg" name="message" required placeholder="Es. Nautilus Mod. 41 mm, quadrante verde con indici diamante, cassa oro rosa…"></textarea></div>
			<div class="full"><button class="btn btn--red" type="submit">Invia il mio progetto</button></div>
		</form>
	</div>
</section>
<?php
get_footer();
