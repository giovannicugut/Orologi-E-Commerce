<?php
/**
 * Servizi – Cura dell'orologio (slug "cura-orologio").
 *
 * @package gmbrand
 */

defined( 'ABSPATH' ) || exit;
get_header();
$gm_tips = array(
	array( 'autorenew', 'Ricarica', 'Il movimento automatico si carica con il movimento del polso. Se non lo indossi per qualche giorno, ruota la corona 20–30 volte prima di regolare l’ora, oppure usa un caricatore automatico.' ),
	array( 'water_drop', 'Acqua', 'Prima di qualsiasi contatto con l’acqua controlla che la corona sia ben chiusa. Evita docce calde e sauna: gli sbalzi di temperatura mettono alla prova le guarnizioni.' ),
	array( 'cleaning_services', 'Pulizia', 'Pulisci cassa e bracciale con un panno morbido; per il bracciale in acciaio puoi usare uno spazzolino morbido con acqua tiepida. Asciuga sempre bene.' ),
	array( 'bolt', 'Magnetismo', 'Tieni l’orologio lontano da casse audio, tablet e chiusure magnetiche: un campo magnetico forte può alterare la precisione.' ),
	array( 'inventory_2', 'Conservazione', 'Quando non lo indossi, riponilo nella sua scatola o in una custodia, lontano da umidità e luce diretta del sole.' ),
	array( 'build', 'Revisione', 'Per mantenere precisione e impermeabilità consigliamo un controllo periodico. Scrivici: ti diremo come procedere.' ),
);
?>
<header class="page-title">
	<div class="container">
		<span class="eyebrow">Servizi</span>
		<h1 class="h-lg">Cura dell’orologio</h1>
		<p class="lead" style="max-width:640px;margin:12px auto 0">Piccoli gesti per far durare a lungo il tuo GMBRAND.</p>
	</div>
</header>
<section class="section">
	<div class="container">
		<div class="trust reveal" style="grid-template-columns:repeat(3,1fr)">
			<?php foreach ( $gm_tips as $t ) : ?>
				<div class="trust__item" style="align-items:flex-start;text-align:left;padding:40px 32px"><span class="ms"><?php echo esc_html( $t[0] ); ?></span><h4><?php echo esc_html( $t[1] ); ?></h4><p style="font-size:14px;line-height:22px"><?php echo esc_html( $t[2] ); ?></p></div>
			<?php endforeach; ?>
		</div>
		<?php
		while ( have_posts() ) :
			the_post();
			echo '<div class="narrow prose" style="margin-top:48px">';
			the_content();
			echo '</div>';
		endwhile;
		?>
		<div class="center" style="margin-top:56px;display:flex;gap:12px;justify-content:center;flex-wrap:wrap">
			<a class="btn btn--red" href="<?php echo esc_url( gm_page_url( 'contatti' ) ); ?>">Richiedi assistenza</a>
			<a class="btn btn--outline" href="<?php echo esc_url( gm_page_url( 'garanzia' ) ); ?>">Garanzia</a>
		</div>
	</div>
</section>
<?php
get_footer();
