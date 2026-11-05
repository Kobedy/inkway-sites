<?php
/**
 * Section « en-tête » de l’accueil (reprise du site validé).
 *
 * @package inkway-pken
 */

defined( 'ABSPATH' ) || exit;
?>
<header data-header><div class="wrap hd">
  <a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( pken_opt( 'brand' ) ); ?>, accueil"><img src="<?php echo esc_url( pken_logo_url() ); ?>" alt=""><span><b>PKEN Coiffure</b></span></a>
  <nav class="nav" aria-label="Menu principal"><?php pken_menu_links( 'principal' ); ?></nav>
  <a class="btn hd-tel" href="<?php echo esc_url( pken_tel_href() ); ?>" aria-label="Appeler <?php echo esc_html( pken_opt( 'brand' ) ); ?> au <?php echo esc_html( pken_opt( 'phone' ) ); ?>"><svg viewBox="0 0 24 24"><path d="M6.6 10.8a15.1 15.1 0 006.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1A17 17 0 013 4c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1z"/></svg><?php echo esc_html( pken_opt( 'phone' ) ); ?></a>
  <button class="burger" data-nav-toggle aria-label="Ouvrir le menu" aria-expanded="false"><span></span></button>
</div></header>
