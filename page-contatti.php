<?php
/**
 * Pagina Contatti (slug "contatti").
 *
 * @package gmbrand
 */

defined( 'ABSPATH' ) || exit;
get_header();
$gm_email = gm_mod( 'gm_email', 'infowatches@gmbrand.it' );
$gm_phone = gm_mod( 'gm_phone', '' );
$gm_sent  = isset( $_GET['sent'] ) ? sanitize_text_field( wp_unslash( $_GET['sent'] ) ) : ''; // phpcs:ignore
?>
<header class="page-title">
	<div class="container">
		<span class="eyebrow">Siamo qui per te</span>
		<h1 class="h-lg">Contattaci</h1>
	</div>
</header>
<section class="section">
	<div class="container contact-grid">
		<div class="contact-card">
			<p class="lead">Domande su un orologio, un ordine o un progetto su misura? Scrivici: rispondiamo personalmente a ogni messaggio.</p>
			<div>
				<a class="row" href="mailto:<?php echo esc_attr( $gm_email ); ?>"><span class="ms">mail</span><div><b>Email</b><small><?php echo esc_html( $gm_email ); ?></small></div></a>
				<?php if ( $gm_phone ) : ?>
					<a class="row" href="https://wa.me/<?php echo esc_attr( preg_replace( '/\D/', '', $gm_phone ) ); ?>"><span class="ms">chat</span><div><b>WhatsApp</b><small><?php echo esc_html( $gm_phone ); ?></small></div></a>
				<?php endif; ?>
				<a class="row" href="<?php echo esc_url( gm_socials()['instagram'][1] ); ?>" target="_blank" rel="noopener"><span class="ms">photo_camera</span><div><b>Instagram</b><small>@gmbrand_watches</small></div></a>
				<div class="row" style="display:flex;gap:14px;padding:18px 0;border-bottom:1px solid var(--hair)"><span class="ms" style="color:var(--red)">location_on</span><div><b style="font-family:var(--f-display);font-size:12px;letter-spacing:.14em;text-transform:uppercase;display:block;margin-bottom:4px">Laboratorio</b><small style="color:var(--gray)"><?php echo esc_html( gm_mod( 'gm_location', 'Anghiari, Toscana – Italia' ) ); ?></small></div></div>
			</div>
		</div>

		<form class="form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="gm_contact">
			<?php wp_nonce_field( 'gm_contact', 'gm_contact_nonce' ); ?>
			<input type="text" name="website" tabindex="-1" autocomplete="off" style="position:absolute;left:-9999px" aria-hidden="true">
			<?php if ( '1' === $gm_sent ) : ?>
				<p class="full woocommerce-message" style="padding:14px 18px;margin:0">Grazie! Il tuo messaggio è stato inviato, ti risponderemo presto.</p>
			<?php elseif ( '0' === $gm_sent ) : ?>
				<p class="full woocommerce-error" style="padding:14px 18px;margin:0">Compila nome, un’email valida e il messaggio.</p>
			<?php endif; ?>
			<div><label for="c-name">Nome *</label><input id="c-name" name="name" required></div>
			<div><label for="c-email">Email *</label><input id="c-email" name="email" type="email" required></div>
			<div class="full"><label for="c-topic">Argomento</label>
				<select id="c-topic" name="topic">
					<option>Informazioni su un orologio</option>
					<option>Orologio su misura</option>
					<option>Il mio ordine</option>
					<option>Resi e garanzia</option>
					<option>Altro</option>
				</select>
			</div>
			<div class="full"><label for="c-msg">Messaggio *</label><textarea id="c-msg" name="message" required></textarea></div>
			<div class="full"><label class="toggle-check" style="text-transform:none;letter-spacing:0;font-family:var(--f-body);font-size:12px"><input type="checkbox" required> Accetto l’informativa sulla privacy</label></div>
			<div class="full"><button class="btn btn--red" type="submit">Invia messaggio</button></div>
		</form>
	</div>
</section>
<?php
get_footer();
