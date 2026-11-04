<?php
/**
 * Section « barre du haut » de l’accueil (reprise du site validé).
 *
 * @package inkway-pken
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="top"><div class="wrap">
  <span data-open-status data-hours='<?php echo esc_attr( pken_hours_json() ); ?>'><?php echo esc_html( pken_hours_text() ); ?></span>
  <span class="top-r"><a href="<?php echo esc_url( pken_maps_url() ); ?>" target="_blank" rel="noopener"><?php echo esc_html( pken_full_address() ); ?></a><span class="top-soc"><a href="<?php echo esc_url( pken_opt( 'facebook' ) ); ?>" target="_blank" rel="noopener" aria-label="PKEN Coiffure sur Facebook" title="Facebook"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9.101 23.691v-7.98H6.627v-3.667h2.474v-1.58c0-4.085 1.848-5.978 5.858-5.978.401 0 .955.042 1.468.103a8.68 8.68 0 0 1 1.141.195v3.325a8.623 8.623 0 0 0-.653-.036 26.805 26.805 0 0 0-.733-.009c-.707 0-1.259.096-1.675.309a1.686 1.686 0 0 0-.679.622c-.258.42-.374.995-.374 1.752v1.297h3.919l-.386 2.103-.287 1.564h-3.246v8.245C19.396 23.238 24 18.179 24 12.044c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.628 3.874 10.35 9.101 11.647Z"/></svg></a><?php if ( pken_opt( 'instagram' ) ) : ?><a href="<?php echo esc_url( pken_opt( 'instagram' ) ); ?>" target="_blank" rel="noopener" aria-label="Instagram" title="Instagram"><svg viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M7 2h10a5 5 0 015 5v10a5 5 0 01-5 5H7a5 5 0 01-5-5V7a5 5 0 015-5zM7 4a3 3 0 00-3 3v10a3 3 0 003 3h10a3 3 0 003-3V7a3 3 0 00-3-3H7zm5 3a5 5 0 110 10 5 5 0 010-10zm0 2a3 3 0 100 6 3 3 0 000-6zm5.5-3.7a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"/></svg></a><?php endif; ?></span></span>
</div></div>
