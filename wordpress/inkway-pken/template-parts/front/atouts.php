<?php
/**
 * Section « atouts » de l’accueil (reprise du site validé).
 *
 * @package inkway-pken
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="perks"><div class="wrap">
  <div class="perk"><i><svg viewBox="0 0 24 24"><path d="M6 3l12 0M8 3v5a4 4 0 008 0V3M4 21c2-4 5-6 8-6s6 2 8 6"/></svg></i><div><b>Coupe homme <?php echo esc_html( pken_price( 'Coupe homme' ) ); ?></b><small>Prix affichés, sans surprise</small></div></div>
  <div class="perk"><i><svg viewBox="0 0 24 24"><path d="M4 9h13v5a5 5 0 01-5 5H9a5 5 0 01-5-5V9zM17 10h2a2 2 0 010 4h-2M8 3c0 2 2 2 2 4M12 3c0 2 2 2 2 4"/></svg></i><div><b>Boissons offertes</b><small>Eau, café et thé</small></div></div>
  <div class="perk"><i><svg viewBox="0 0 24 24"><rect x="3" y="6" width="18" height="12" rx="2"/><circle cx="8" cy="12" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="16" cy="12" r="1.5"/></svg></i><div><b>10<sup>e</sup> coupe offerte</b><small>Avec la carte de fidélité</small></div></div>
  <div class="perk"><i><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg></i><div><b>Ouvert 7j/7</b><small><?php echo esc_html( pken_day_text( 0, 'Dimanche ' ) ); ?></small></div></div>
</div></div>
