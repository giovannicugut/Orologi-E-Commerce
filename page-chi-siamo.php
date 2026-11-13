<?php
/**
 * Pagina Chi siamo (slug "chi-siamo").
 *
 * @package gmbrand
 */

defined( 'ABSPATH' ) || exit;
get_header();
$gm_v = gm_default_videos();
?>
<section class="page-hero">
	<video muted playsinline loop preload="none" data-lazy data-src="<?php echo esc_url( $gm_v['closeup'][0] ); ?>" data-src-mobile="<?php echo esc_url( $gm_v['closeup'][1] ); ?>"></video>
	<div class="container">
		<span class="eyebrow eyebrow--gold">Dall’Italia con amore</span>
		<h1 class="display">Chi siamo</h1>
		<p class="lead">Una piccola azienda italiana in Toscana, nata dalla passione per gli orologi.</p>
	</div>
</section>

<section class="split split--reverse">
	<div class="split__media" style="background:#fff"><img src="<?php echo esc_url( GM_URI . '/assets/img/gm-monogram.jpg' ); ?>" alt="GMBRAND" style="object-fit:contain"></div>
	<div class="split__body reveal">
		<span class="eyebrow">GMBRAND · Anghiari, Toscana</span>
		<h2 class="h-lg red">Made in Italy<br>con anima giapponese</h2>
		<p class="lead">Realizziamo design di orologi celebri con alta qualità e prezzi ragionevoli. Ogni pezzo è assemblato in Italia dai nostri orologiai esperti, sempre attorno a un movimento Seiko originale.</p>
		<p class="lead">La maggior parte dei nostri orologi è in edizione limitata. E poiché ci piace sempre parlare con te, possiamo esaudire le tue richieste e creare un orologio su misura solo per te.</p>
		<a class="btn btn--red" href="<?php echo esc_url( gm_page_url( 'personalizza' ) ); ?>">Crea il tuo orologio</a>
	</div>
</section>

<section class="section section--subtle">
	<div class="container">
		<div class="section-head reveal"><span class="eyebrow">Come lavoriamo</span><h2 class="h-lg">Dall’idea al tuo polso</h2></div>
		<ol class="timeline reveal" style="list-style:none;padding:0;margin:0">
			<li><h4>Scegli</h4><p>Parti da una collezione o da un foglio bianco insieme al nostro team.</p></li>
			<li><h4>Progetta</h4><p>Quadrante, lancette, lunetta, cassa e bracciale: 100% personalizzati.</p></li>
			<li><h4>Costruiamo</h4><p>Assemblaggio a mano e collaudo nel nostro laboratorio toscano, in circa 5 giorni lavorativi.</p></li>
			<li><h4>Spediamo</h4><p>Confezione premium, consegna in tutto il mondo e garanzia di un anno.</p></li>
		</ol>
	</div>
</section>

<?php
while ( have_posts() ) :
	the_post();
	if ( get_the_content() ) :
		?>
		<section class="section"><div class="container narrow prose"><?php the_content(); ?></div></section>
		<?php
	endif;
endwhile;
?>

<section class="section">
	<div class="container"><div class="trust reveal">
		<div class="trust__item"><span class="ms">handyman</span><h4>Fatti a mano</h4><p>Ogni orologio costruito a mano</p></div>
		<div class="trust__item"><span class="ms">palette</span><h4>100% su misura</h4><p>Il tuo stile, in ogni dettaglio</p></div>
		<div class="trust__item"><span class="ms">support_agent</span><h4>Assistenza dedicata</h4><p>Rispondiamo a ogni messaggio</p></div>
		<div class="trust__item"><span class="ms">public</span><h4>Spedizione nel mondo</h4><p>Il tuo orologio ti troverà</p></div>
	</div></div>
</section>
<?php
get_footer();
