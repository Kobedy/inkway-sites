<?php
/**
 * Section « horaires-acces » de l’accueil (reprise du site validé).
 *
 * @package inkway-pken
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="acces" id="acces"><div class="wrap">
  <div><span class="kick">Horaires &amp; accès</span><h2 data-reveal>Ouvert 7 jours sur 7</h2>
    <table class="hours"><?php pken_hours_rows(); ?></table>
    <div class="contact">
      <a href="<?php echo esc_url( pken_maps_url() ); ?>" target="_blank" rel="noopener"><svg viewBox="0 0 24 24"><path d="M12 2a7 7 0 00-7 7c0 5 7 13 7 13s7-8 7-13a7 7 0 00-7-7zm0 9.5A2.5 2.5 0 1112 6a2.5 2.5 0 010 5.5z"/></svg><?php echo esc_html( pken_full_address() ); ?></a>
      <a href="<?php echo esc_url( pken_tel_href() ); ?>"><svg viewBox="0 0 24 24"><path d="M6.6 10.8a15.1 15.1 0 006.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1A17 17 0 013 4c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1z"/></svg><?php echo esc_html( pken_opt( 'phone' ) ); ?></a>
      <a href="<?php echo esc_url( 'mailto:' . pken_opt( 'email' ) ); ?>"><svg viewBox="0 0 24 24"><path d="M3 5h18v14H3V5zm9 7L4 7v1l8 5 8-5V7l-8 5z"/></svg><?php echo esc_html( pken_opt( 'email' ) ); ?></a>
      <a href="<?php echo esc_url( pken_opt( 'facebook' ) ); ?>" target="_blank" rel="noopener"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9.101 23.691v-7.98H6.627v-3.667h2.474v-1.58c0-4.085 1.848-5.978 5.858-5.978.401 0 .955.042 1.468.103a8.68 8.68 0 0 1 1.141.195v3.325a8.623 8.623 0 0 0-.653-.036 26.805 26.805 0 0 0-.733-.009c-.707 0-1.259.096-1.675.309a1.686 1.686 0 0 0-.679.622c-.258.42-.374.995-.374 1.752v1.297h3.919l-.386 2.103-.287 1.564h-3.246v8.245C19.396 23.238 24 18.179 24 12.044c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.628 3.874 10.35 9.101 11.647Z"/></svg>Facebook · PKEN Coiffure</a>
      <?php if ( pken_opt( 'instagram' ) ) : ?><a href="<?php echo esc_url( pken_opt( 'instagram' ) ); ?>" target="_blank" rel="noopener"><svg viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M7 2h10a5 5 0 015 5v10a5 5 0 01-5 5H7a5 5 0 01-5-5V7a5 5 0 015-5zM7 4a3 3 0 00-3 3v10a3 3 0 003 3h10a3 3 0 003-3V7a3 3 0 00-3-3H7zm5 3a5 5 0 110 10 5 5 0 010-10zm0 2a3 3 0 100 6 3 3 0 000-6zm5.5-3.7a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"/></svg>Instagram · <?php echo esc_html( pken_opt( 'brand' ) ); ?></a><?php endif; ?>
    </div>
  </div>
  <iframe class="map" loading="lazy" title="Plan d’accès PKEN Coiffure" src="<?php echo esc_url( pken_maps_embed_url() ); ?>"></iframe>
</div></section>
