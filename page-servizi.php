<?php
/**
 * Servizi (slug "servizi") – pagina editoriale con immagini grandi.
 * Testi e immagini sono in gm_services() (inc/helpers.php).
 *
 * @package gmbrand
 */

defined( 'ABSPATH' ) || exit;
get_header();
$gm_s = gm_services();
?>
<section class="svc-hero">
	<img src="<?php echo esc_url( $gm_s['hero'] ); ?>" alt="" fetchpriority="high">
	<div class="container">
		<span class="eyebrow eyebrow--gold">Servizi GMBRAND</span>
		<h1 class="display">Un servizio fatto a mano</h1>
		<p class="lead">Dal primo messaggio alla cura negli anni: ogni orologio GMBRAND è seguito dalle stesse mani che lo hanno costruito.</p>
	</div>
	<a class="svc-hero__down" href="#svc-intro" aria-label="Scorri"><span class="ms">expand_more</span></a>
</section>

<section class="section svc-intro" id="svc-intro">
	<div class="container narrow center reveal">
		<span class="eyebrow">Il nostro approccio</span>
		<h2 class="h-lg">Un orologio è un rapporto<br>che dura nel tempo</h2>
		<p class="lead">Non vendiamo soltanto orologi: li progettiamo con te, li costruiamo a mano in Toscana e restiamo al tuo fianco anche dopo la consegna. Per questo ogni servizio GMBRAND nasce da un’unica idea: trattare il tuo orologio come se fosse nostro.</p>
	</div>
</section>

<section class="section section--subtle pillars" id="impegni">
	<div class="container">
		<div class="section-head reveal"><span class="eyebrow">I nostri impegni</span><h2 class="h-lg">Cinque impegni, una promessa</h2></div>
		<div class="carousel" data-carousel>
			<ol class="carousel__track">
				<?php foreach ( $gm_s['pillars'] as $i => $p ) : ?>
					<li class="pillar" id="impegno-<?php echo (int) ( $i + 1 ); ?>">
						<figure><img src="<?php echo esc_url( $p[0] ); ?>" alt="" loading="lazy"></figure>
						<span class="pillar__num"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
						<h3><?php echo esc_html( $p[1] ); ?></h3>
						<p><?php echo esc_html( $p[2] ); ?></p>
					</li>
				<?php endforeach; ?>
			</ol>
			<div class="carousel__nav">
				<div class="dashes"></div>
				<div class="carousel__arrows">
					<button class="round-btn round-btn--light js-car-prev" aria-label="Precedente"><span class="ms">chevron_left</span></button>
					<button class="round-btn round-btn--light js-car-next" aria-label="Successivo"><span class="ms">chevron_right</span></button>
				</div>
			</div>
		</div>
	</div>
</section>

<figure class="fullbleed">
	<img src="<?php echo esc_url( $gm_s['fullbleed'] ); ?>" alt="" loading="lazy">
	<figcaption class="container"><span class="h-md">Precisione, pazienza, passione.</span></figcaption>
</figure>

<?php foreach ( $gm_s['splits'] as $i => $sp ) : ?>
	<section class="svc-split<?php echo $i % 2 ? ' svc-split--reverse' : ''; ?>" id="<?php echo esc_attr( $sp['id'] ); ?>">
		<div class="svc-split__media"><img src="<?php echo esc_url( $sp['img'] ); ?>" alt="" loading="lazy"></div>
		<div class="svc-split__body reveal">
			<span class="eyebrow"><?php echo esc_html( $sp['eyebrow'] ); ?></span>
			<h2 class="h-lg"><?php echo esc_html( $sp['title'] ); ?></h2>
			<p class="lead"><?php echo esc_html( $sp['text'] ); ?></p>
			<a class="link-arrow" href="<?php echo esc_url( gm_page_url( $sp['page'] ) ); ?>"><?php echo esc_html( $sp['link'] ); ?> <span class="ms" style="font-size:16px">chevron_right</span></a>
		</div>
	</section>
<?php endforeach; ?>

<section class="svc-quote">
	<div class="container narrow center reveal">
		<span class="ms" aria-hidden="true">format_quote</span>
		<blockquote>Ogni orologio che esce dal nostro laboratorio porta con sé la nostra firma. E una firma si rispetta.</blockquote>
		<span class="eyebrow eyebrow--gold">GMBRAND · Anghiari</span>
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

<section class="section" id="aiuto">
	<div class="container">
		<div class="section-head reveal"><span class="eyebrow">Scopri di più</span><h2 class="h-lg">Come possiamo aiutarti</h2></div>
		<div class="discover">
			<?php foreach ( $gm_s['discover'] as $d ) : ?>
				<a class="discover__card reveal" href="<?php echo esc_url( gm_page_url( $d[2] ) ); ?>">
					<figure><img src="<?php echo esc_url( $d[0] ); ?>" alt="" loading="lazy"></figure>
					<span class="discover__title"><?php echo esc_html( $d[1] ); ?> <span class="ms">arrow_forward</span></span>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php
get_footer();
