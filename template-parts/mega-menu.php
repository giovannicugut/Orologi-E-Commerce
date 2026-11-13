<?php
/**
 * Mega menu integrato (usato se nessun menu WordPress è assegnato a "Primary").
 * I contenuti arrivano da gm_menu() in inc/helpers.php.
 *
 * @package gmbrand
 */

defined( 'ABSPATH' ) || exit;
?>
<ul>
	<?php foreach ( gm_menu() as $item ) : ?>
		<?php if ( empty( $item['cols'] ) ) : ?>
			<li><a href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a></li>
		<?php else : ?>
			<li class="has-mega">
				<a href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a>
				<div class="mega">
					<div class="mega__inner" style="--cols:<?php echo count( $item['cols'] ); ?>">
						<button type="button" class="mega__close" data-mega-close aria-label="Chiudi"><span class="ms">close</span></button>
						<?php foreach ( $item['cols'] as $ci => $col ) : ?>
							<div class="mega__col">
								<h4><?php echo esc_html( $col[0] ); ?></h4>
								<ul>
									<?php foreach ( $col[1] as $l ) : ?>
										<li><a href="<?php echo esc_url( $l[1] ); ?>"><?php echo esc_html( $l[0] ); ?></a></li>
									<?php endforeach; ?>
								</ul>
								<?php if ( 0 === $ci ) : ?><a class="mega__all" href="<?php echo esc_url( $item['url'] ); ?>">Scopri tutto <span class="ms" style="font-size:16px">arrow_forward</span></a><?php endif; ?>
							</div>
						<?php endforeach; ?>
						<div class="mega__feature" style="--tiles:<?php echo count( $item['tiles'] ); ?>">
							<?php foreach ( $item['tiles'] as $t ) : ?>
								<a class="mega__tile" href="<?php echo esc_url( $t[2] ); ?>">
									<figure><img src="<?php echo esc_url( $t[1] ); ?>" alt="<?php echo esc_attr( $t[0] ); ?>" loading="lazy"></figure>
									<span><?php echo esc_html( $t[0] ); ?></span>
								</a>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</li>
		<?php endif; ?>
	<?php endforeach; ?>
</ul>
