<?php
/**
 * Home page.
 *
 * @package gmbrand
 */

defined( 'ABSPATH' ) || exit;
get_header();

$gm_slides = gm_hero_slides();
$gm_v      = gm_default_videos();
$gm_cols   = gm_collections();
$gm_wc     = function_exists( 'gm_home_products' );
$gm_promos = gm_promos();
?>

<!-- ============ Hero: più video ============ -->
<section class="hero" aria-roledescription="carousel" aria-label="In evidenza">
	<?php foreach ( $gm_slides as $i => $s ) : ?>
		<div class="hero__slide<?php echo 0 === $i ? ' is-active' : ''; ?>" role="group" aria-roledescription="slide" aria-label="<?php echo esc_attr( ( $i + 1 ) . ' / ' . count( $gm_slides ) ); ?>">
			<div class="hero__media">
				<?php if ( $s['video'] ) : ?>
					<video muted playsinline loop preload="none" poster="<?php echo esc_url( $s['poster'] ); ?>" data-src="<?php echo esc_url( $s['video'] ); ?>" data-src-mobile="<?php echo esc_url( $s['video_m'] ); ?>"></video>
				<?php else : ?>
					<img src="<?php echo esc_url( $s['poster'] ); ?>" alt="">
				<?php endif; ?>
			</div>
			<div class="hero__scrim"></div>
			<div class="hero__content">
				<div class="container">
					<span class="eyebrow eyebrow--gold"><?php echo esc_html( $s['eyebrow'] ); ?></span>
					<?php if ( 0 === $i ) : ?>
						<h1 class="display"><?php echo esc_html( $s['title'] ); ?></h1>
					<?php else : ?>
						<h2 class="display"><?php echo esc_html( $s['title'] ); ?></h2>
					<?php endif; ?>
					<p class="hero__text"><?php echo esc_html( $s['text'] ); ?></p>
					<div class="hero__ctas">
						<a class="btn btn--red" href="<?php echo esc_url( $s['url'] ); ?>"><?php echo esc_html( $s['btn'] ); ?></a>
						<a class="btn btn--glass" href="<?php echo esc_url( gm_shop_url() ); ?>">Vedi tutti</a>
					</div>
				</div>
			</div>
		</div>
	<?php endforeach; ?>

	<div class="hero__controls">
		<div class="container">
			<div class="hero__tabs" role="tablist">
				<?php foreach ( $gm_slides as $i => $s ) : ?>
					<button class="hero__tab<?php echo 0 === $i ? ' is-active' : ''; ?>" role="tab" aria-label="<?php echo esc_attr( $s['label'] ); ?>">
						<span class="hero__tab-label"><?php echo esc_html( sprintf( '%02d', $i + 1 ) . '  ' . $s['label'] ); ?></span>
						<span class="hero__bar"><i></i></span>
					</button>
				<?php endforeach; ?>
			</div>
			<div class="hero__btns">
				<button class="round-btn js-hero-prev" aria-label="Slide precedente"><span class="ms">chevron_left</span></button>
				<button class="round-btn js-hero-toggle" aria-label="Metti in pausa"><span class="ms">pause</span></button>
				<button class="round-btn js-hero-next" aria-label="Slide successiva"><span class="ms">chevron_right</span></button>
			</div>
		</div>
	</div>
	<span class="hero__scroll" aria-hidden="true">Scorri</span>
</section>

<!-- ============ Selezione prodotti (griglia con riquadro marketing) ============ -->
<section class="section" data-tabs>
	<div class="container">
		<div class="section-head reveal">
			<span class="eyebrow">I nostri preferiti</span>
			<h2 class="h-lg">Il tuo stile, ovunque</h2>
		</div>
		<div class="tabs reveal" role="tablist">
			<button class="tab is-active" data-tab="best" role="tab" aria-selected="true">I più venduti</button>
			<button class="tab" data-tab="new" role="tab" aria-selected="false">Novità</button>
			<button class="tab" data-tab="sale" role="tab" aria-selected="false">Prezzi speciali</button>
		</div>
		<?php
		$gm_k = 0;
		foreach ( array( 'best', 'new', 'sale' ) as $type ) :
			$gm_items = $gm_wc ? gm_home_products( $type, 10 ) : array();
			?>
			<div data-panel="<?php echo esc_attr( $type ); ?>" <?php echo 'best' !== $type ? 'hidden' : ''; ?>>
				<?php if ( $gm_items ) : ?>
					<ul class="grid products">
						<?php
						foreach ( array_values( $gm_items ) as $n => $gm_p ) {
							if ( 6 === $n ) {
								echo gm_promo_html( $gm_promos[ $gm_k % count( $gm_promos ) ] ); // phpcs:ignore
							}
							$GLOBALS['product'] = $gm_p; // phpcs:ignore
							$GLOBALS['post']    = get_post( $gm_p->get_id() ); // phpcs:ignore
							setup_postdata( $GLOBALS['post'] );
							wc_get_template_part( 'content', 'product' );
						}
						wp_reset_postdata();
						?>
					</ul>
				<?php else : ?>
					<p class="empty"><?php echo $gm_wc ? 'Nessun prodotto: importa <code>woocommerce-import/products.csv</code> da Prodotti › Importa.' : 'Attiva WooCommerce per mostrare qui i tuoi orologi.'; ?></p>
				<?php endif; ?>
			</div>
			<?php
			$gm_k++;
		endforeach;
		?>
		<div class="center" style="margin-top:48px"><a class="btn btn--outline" href="<?php echo esc_url( gm_shop_url() ); ?>">Vedi tutti gli orologi</a></div>
	</div>
</section>

<!-- ============ Sezione editoriale con video ============ -->
<section class="split">
	<div class="split__media split__media--photo">
		<img src="<?php echo esc_url( GM_URI . '/assets/img/exploded-watch.webp' ); ?>" alt="Componenti di un orologio GMBRAND: cassa, movimento, quadrante e bracciale" loading="lazy">
	</div>
	<div class="split__body reveal">
		<span class="eyebrow">Il nostro laboratorio</span>
		<h2 class="h-lg red">Assemblati in Italia<br>dai nostri orologiai</h2>
		<p class="lead">Siamo in Toscana. La maggior parte dei nostri orologi è in edizione limitata, ma sempre con movimento Seiko: affidabile, facile da revisionare e fatto per durare.</p>
		<div class="facts">
			<div><strong>100%</strong><span>Su misura</span></div>
			<div><strong>1 anno</strong><span>Di garanzia</span></div>
			<div><strong>5 giorni</strong><span>Per costruirlo</span></div>
		</div>
		<a class="link-arrow" href="<?php echo esc_url( gm_page_url( 'chi-siamo' ) ); ?>">Chi siamo <span class="ms" style="font-size:16px">chevron_right</span></a>
	</div>
</section>

<!-- ============ Collezioni ============ -->
<section class="section">
	<div class="container">
		<div class="section-head reveal">
			<span class="eyebrow">Le collezioni</span>
			<h2 class="h-lg">Trova il tuo segno distintivo</h2>
			<p class="lead">Sei famiglie di orologi personalizzati, ognuna disponibile in colorazioni limitate.</p>
		</div>
		<div class="collections">
			<?php foreach ( $gm_cols as $slug => $c ) : ?>
				<a class="ctile reveal" href="<?php echo esc_url( gm_cat_link( $slug ) ); ?>">
					<img src="<?php echo esc_url( gm_cat_image( $slug ) ); ?>" alt="<?php echo esc_attr( $c['name'] ); ?>" loading="lazy">
					<div class="ctile__body">
						<h3><?php echo esc_html( $c['name'] ); ?></h3>
						<span>Scopri <span class="ms" style="font-size:15px">arrow_forward</span></span>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- ============ Banner video ============ -->
<section class="banner">
	<video muted playsinline loop preload="none" data-lazy data-src="<?php echo esc_url( gm_mod( 'gm_banner_video', $gm_v['face'][0] ) ); ?>" data-src-mobile="<?php echo esc_url( gm_mod( 'gm_banner_video', $gm_v['face'][1] ) ); ?>"></video>
	<div class="banner__body reveal">
		<span class="eyebrow eyebrow--gold">100% personalizzato</span>
		<h2 class="display"><?php echo esc_html( gm_mod( 'gm_banner_title', 'Crea il tuo orologio dei sogni' ) ); ?></h2>
		<p class="lead"><?php echo esc_html( gm_mod( 'gm_banner_text', 'Ogni dettaglio, costruito sul tuo stile. Contattaci per progettare il tuo orologio insieme ai nostri orologiai.' ) ); ?></p>
		<a class="btn btn--white" href="<?php echo esc_url( gm_page_url( 'personalizza' ) ); ?>">Inizia il progetto</a>
	</div>
	<button class="round-btn banner__toggle" data-video-toggle aria-label="Metti in pausa"><span class="ms">pause</span></button>
</section>

<!-- ============ Manifesto ============ -->
<section class="section section--subtle">
	<div class="container statement reveal">
		<img class="statement__mark" src="<?php echo esc_url( GM_URI . '/assets/img/gm-monogram.jpg' ); ?>" alt="" width="84" height="84">
		<span class="eyebrow">Made in Italy con anima giapponese</span>
		<h2 class="h-lg red">Prodotti fatti a mano,<br>assistenza dedicata</h2>
		<p class="lead">GMBRAND nasce dalla passione per gli orologi. Realizziamo design iconici con alta qualità e prezzi onesti, e ci piace sempre parlare con te per realizzare le tue richieste.</p>
		<a class="btn btn--outline" href="<?php echo esc_url( gm_page_url( 'contatti' ) ); ?>">Contattaci</a>
	</div>
</section>

<!-- ============ Garanzie ============ -->
<section class="section section--tight">
	<div class="container">
		<div class="trust reveal">
			<div class="trust__item"><span class="ms">verified</span><h4>Garanzia di un anno</h4><p>Su ogni orologio che costruiamo</p></div>
			<div class="trust__item"><span class="ms">settings</span><h4>Movimento Seiko</h4><p>Calibri giapponesi originali, assemblati in Italia</p></div>
			<div class="trust__item"><span class="ms">public</span><h4>Spedizione nel mondo</h4><p>Nessun dazio all’interno dell’UE</p></div>
			<div class="trust__item"><span class="ms">lock</span><h4>Pagamenti sicuri</h4><p>Carte, PayPal e Apple Pay</p></div>
		</div>
	</div>
</section>

<!-- ============ Recensioni ============ -->
<section class="section section--subtle reviews">
	<div class="container">
		<div class="section-head reveal">
			<span class="eyebrow">Clienti in tutto il mondo</span>
			<h2 class="h-lg">Indossano GMBRAND</h2>
		</div>
		<div class="carousel" data-carousel>
			<div class="carousel__track">
				<?php foreach ( gm_reviews() as $r ) : ?>
					<figure class="review">
						<div class="review__stars" aria-label="5 su 5">★★★★★</div>
						<blockquote>“<?php echo esc_html( $r[2] ); ?>”</blockquote>
						<footer>
							<span class="review__avatar"><?php echo esc_html( substr( $r[0], 0, 1 ) ); ?></span>
							<div><b><?php echo esc_html( $r[0] ); ?></b><span><?php echo esc_html( $r[1] ); ?></span></div>
						</footer>
					</figure>
				<?php endforeach; ?>
			</div>
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

<!-- ============ Instagram ============ -->
<section class="section section--tight">
	<div class="container">
		<div class="section-head reveal" style="margin-bottom:32px">
			<span class="eyebrow eyebrow--red">@gmbrand_watches</span>
			<h2 class="h-lg">Seguici su Instagram</h2>
		</div>
	</div>
	<div class="gallery">
		<?php foreach ( gm_gallery() as $g ) : ?>
			<a href="<?php echo esc_url( gm_socials()['instagram'][1] ); ?>" target="_blank" rel="noopener" aria-label="Apri Instagram">
				<img src="<?php echo esc_url( gm_remote( $g . '-300x300.jpg' ) ); ?>" alt="" loading="lazy">
			</a>
		<?php endforeach; ?>
	</div>
</section>

<?php
get_footer();
