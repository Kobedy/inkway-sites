<?php
/**
 * Section « salon » de l’accueil (reprise du site validé).
 *
 * @package inkway-pken
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="salon" id="salon"><div class="wrap">
  <div><figure data-reveal><img src="<?php echo esc_url( pken_img( 'facade.webp' ) ); ?>" alt="Façade du salon PKEN Coiffure, 2 bis boulevard Carnot à Alfortville" width="1080" height="720"><figcaption><?php echo esc_html( pken_opt( 'address' ) . ' · ' . pken_opt( 'city' ) ); ?></figcaption></figure><div class="inside"><a href="<?php echo esc_url( pken_img( 'interieur-postes.webp' ) ); ?>" data-lightbox data-caption="Les postes de coupe"><img src="<?php echo esc_url( pken_img( 'interieur-postes.webp' ) ); ?>" alt="Postes de coupe du salon PKEN Coiffure" loading="lazy"></a><a href="<?php echo esc_url( pken_img( 'zone-bacs.webp' ) ); ?>" data-lightbox data-caption="Le bac à shampoing"><img src="<?php echo esc_url( pken_img( 'zone-bacs.webp' ) ); ?>" alt="Bac à shampoing du salon PKEN Coiffure" loading="lazy"></a></div></div>
  <div><span class="kick">Le salon</span><h2 data-reveal>Un salon de quartier, <span class="script" style="color:var(--accent)">accueillant.</span></h2>
    <p class="sub">PKEN Coiffure vous reçoit au 2 bis boulevard Carnot à Alfortville, 7 jours sur 7. On prend le temps de vous écouter, on soigne la coupe, et on vous sert à boire en attendant.</p>
    <div class="welcome">
      <div data-reveal><svg viewBox="0 0 24 24"><path d="M8 3h8l-1 18H9L8 3zM8.5 9h7"/></svg><b>Eau</b></div>
      <div data-reveal><svg viewBox="0 0 24 24"><path d="M4 9h13v5a5 5 0 01-5 5H9a5 5 0 01-5-5V9zM17 10h2a2 2 0 010 4h-2"/></svg><b>Café</b></div>
      <div data-reveal><svg viewBox="0 0 24 24"><path d="M5 10h12v4a6 6 0 01-12 0v-4zM17 11h1.5a2 2 0 010 4H17M9 4c0 2 2 2 2 4"/></svg><b>Thé</b></div>
    </div>
    <div class="rmore" data-reveal><a class="btn o" href="<?php echo esc_url( pken_maps_dir_url() ); ?>" target="_blank" rel="noopener">Itinéraire jusqu’au salon</a></div>
  </div>
</div></section>
