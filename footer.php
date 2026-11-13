<?php
/**
 * Footer: newsletter, colonne di link, social, note legali, banner cookie.
 *
 * @package gmbrand
 */

defined( 'ABSPATH' ) || exit;
$gm_email   = gm_mod( 'gm_email', 'infowatches@gmbrand.it' );
$gm_privacy = get_privacy_policy_url() ? get_privacy_policy_url() : '#';
$gm_fcols   = array(
	'Collezioni'        => array_map( function ( $slug, $c ) { return array( $c['name'], gm_cat_link( $slug ) ); }, array_keys( gm_collections() ), gm_collections() ),
	'Idee regalo'       => array(
		array( 'Idee regalo per lui', gm_tag_link( 'regalo-lui' ) ),
		array( 'Idee regalo per lei', gm_tag_link( 'regalo-lei' ) ),
		array( 'Accessori', gm_cat_link( 'cinturini' ) ),
		array( 'Orologio su misura', gm_page_url( 'personalizza' ) ),
	),
	'Servizio clienti'  => array(
		array( 'Contattaci', gm_page_url( 'contatti' ) ),
		array( 'Domande frequenti', gm_page_url( 'faq' ) ),
		array( 'Spedizioni e resi', gm_page_url( 'spedizioni-resi' ) ),
		array( 'Servizi', gm_page_url( 'servizi' ) ),
		array( 'Garanzia', gm_page_url( 'garanzia' ) ),
		array( "Cura dell'orologio", gm_page_url( 'cura-orologio' ) ),
		array( 'Il mio account', gm_account_url() ),
	),
	'Universo GMBRAND'  => array(
		array( 'Chi siamo', gm_page_url( 'chi-siamo' ) ),
		array( $gm_email, 'mailto:' . $gm_email ),
		array( 'Instagram', gm_socials()['instagram'][1] ),
		array( 'TikTok', gm_socials()['tiktok'][1] ),
	),
);
?>
</main>

<section class="section section--tight" style="border-top:1px solid var(--hair)">
	<div class="container newsletter">
		<div>
			<h3>Iscriviti alla nostra newsletter</h3>
			<p>Nuove edizioni limitate, riassortimenti e offerte riservate: in anteprima.</p>
		</div>
		<form class="js-newsletter" novalidate>
			<div class="field-join">
				<label class="sr-only" for="nl-email">Indirizzo email</label>
				<input id="nl-email" type="email" placeholder="Indirizzo email" required>
				<button type="submit" aria-label="Iscriviti"><span class="ms">arrow_forward</span></button>
			</div>
			<p class="form-note">Iscrivendoti accetti la nostra <a href="<?php echo esc_url( $gm_privacy ); ?>" style="text-decoration:underline">informativa sulla privacy</a>.</p>
			<p class="form-msg" aria-live="polite"></p>
		</form>
	</div>
</section>

<footer class="site-footer">
	<div class="container">
		<div class="footer-grid">
			<div class="footer-brand">
				<img src="<?php echo esc_url( gm_logo() ); ?>" alt="<?php bloginfo( 'name' ); ?>">
				<p>Made in Italy con anima giapponese. Orologi personalizzati assemblati a mano ad <?php echo esc_html( gm_mod( 'gm_location', 'Anghiari, Toscana – Italia' ) ); ?>, sempre con movimento Seiko.</p>
				<div class="social">
					<?php foreach ( gm_socials() as $net => $s ) : ?>
						<a href="<?php echo esc_url( $s[1] ); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( $s[0] ); ?>"><?php echo gm_social_svg( $net ); // phpcs:ignore ?></a>
					<?php endforeach; ?>
				</div>
			</div>
			<?php
			$gm_i = 0;
			foreach ( $gm_fcols as $title => $links ) :
				$gm_i++;
				?>
				<div class="fcol">
					<h4><?php echo esc_html( $title ); ?></h4>
					<button class="fcol__toggle" data-acc aria-expanded="false" aria-controls="fc-<?php echo (int) $gm_i; ?>"><?php echo esc_html( $title ); ?> <span class="ms">add</span></button>
					<ul id="fc-<?php echo (int) $gm_i; ?>">
						<?php foreach ( $links as $l ) : ?>
							<li><a href="<?php echo esc_url( $l[1] ); ?>"><?php echo esc_html( $l[0] ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endforeach; ?>
		</div>

		<p class="disclaimer">GMBRAND è un’azienda indipendente. Non siamo affiliati, associati, autorizzati, sponsorizzati né in alcun modo ufficialmente collegati alle aziende e/o ai marchi citati in questo sito. Tutti i nomi di prodotti e aziende sono marchi dei rispettivi titolari e sono usati solo a scopo identificativo.</p>

		<div class="footer-bottom">
			<span class="footer-lang"><span class="ms">language</span> Italia · Italiano · EUR €</span>
			<nav aria-label="Note legali">
				<?php
				if ( has_nav_menu( 'footer' ) ) {
					wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false, 'depth' => 1, 'items_wrap' => '%3$s', 'fallback_cb' => false ) );
				} else {
					$terms = function_exists( 'wc_terms_and_conditions_page_id' ) && wc_terms_and_conditions_page_id() ? get_permalink( wc_terms_and_conditions_page_id() ) : '#';
					echo '<a href="' . esc_url( $terms ) . '">Condizioni di vendita</a>';
					echo '<a href="' . esc_url( $gm_privacy ) . '">Informativa sulla privacy</a>';
					echo '<a href="' . esc_url( gm_page_url( 'spedizioni-resi' ) ) . '">Politica di reso</a>';
					echo '<a href="#" data-cookie-open>Impostazioni cookie</a>';
				}
				?>
			</nav>
			<div class="payments" aria-label="Pagamenti accettati"><span>VISA</span><span>MASTERCARD</span><span>PAYPAL</span><span>APPLE PAY</span></div>
			<span>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> gmbrand.it · Tutti i diritti riservati</span>
		</div>
	</div>
</footer>

<div class="cookie" role="dialog" aria-label="Consenso cookie">
	<h4>Informativa sui cookie</h4>
	<p>Usiamo cookie tecnici per far funzionare il sito e, con il tuo consenso, cookie analitici per migliorarlo. Consulta la nostra <a href="<?php echo esc_url( $gm_privacy ); ?>">informativa sui cookie</a>.</p>
	<div class="cookie__btns">
		<button class="btn btn--black" data-cookie="essential">Rifiuta tutto</button>
		<button class="btn btn--red" data-cookie="all">Accetta tutto</button>
	</div>
</div>

<?php wp_footer(); ?>
</body>
</html>
