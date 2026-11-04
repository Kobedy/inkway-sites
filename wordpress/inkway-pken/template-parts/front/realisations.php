<?php
/**
 * Section « realisations » de l’accueil (reprise du site validé).
 *
 * @package inkway-pken
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="reals" id="realisations"><div class="wrap">
  <span class="kick">Réalisations</span>
  <h2 data-reveal>Le travail du salon, <span class="script" style="color:var(--accent)">en photos.</span></h2>
  <p class="sub">Dégradés, contours, dessins, barbes : quelques coupes réalisées chez PKEN Coiffure. Touchez une photo pour l’agrandir.</p>
  <div class="rgrid"><?php pken_gallery_items(); ?></div>
  <div class="rmore"><a class="btn" href="#rdv" data-book="Coupe homme" data-focus="date">Je veux une coupe</a><a class="btn o" href="<?php echo esc_url( pken_maps_url() ); ?>" target="_blank" rel="noopener">Plus de photos sur Google</a></div>
</div></section>
