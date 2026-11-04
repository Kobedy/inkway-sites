<?php
/**
 * Section « hero » de l’accueil (reprise du site validé).
 *
 * @package inkway-pken
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="hero" style="padding:0"><div class="wrap">
  <div>
    <span class="status" data-open-status data-reveal></span>
    <h1 data-reveal>Votre coiffeur<br>à <span class="script">Alfortville.</span></h1>
    <p class="lead" data-reveal>Coupe homme, barbe et coupe enfant, à deux pas du boulevard Carnot. Un accueil convivial, des prix clairs et un café qui vous attend.</p>
    <div data-reveal style="display:flex;gap:12px;flex-wrap:wrap">
      <a class="btn btn-xl" href="#rdv">Prendre rendez-vous</a>
    </div>
    <div class="chips" data-reveal><span class="chip">Coupe homme <b><?php echo esc_html( pken_price( 'Coupe homme' ) ); ?></b></span><span class="chip">Barbe <b><?php echo esc_html( pken_price( 'Barbe' ) ); ?></b></span><span class="chip">Eau, café &amp; thé <b>offerts</b></span><span class="chip">10<sup>e</sup> coupe <b>offerte</b></span></div>
  </div>
  <div class="hv" data-reveal>
    <span class="ring"></span><span class="ring r2"></span>
    <div class="photo"><img src="<?php echo esc_url( pken_img( 'hero-coiffeur.webp' ) ); ?>" alt="" width="1080" height="720"></div>
    <div class="logo"><img src="<?php echo esc_url( pken_logo_url() ); ?>" alt="Logo PKEN Coiffure"></div>
    <div class="orbit o1" aria-hidden="true"><div class="opos"><span class="tag t1">Ouvert 7j/7<small>dimanche inclus</small></span></div></div>
    <div class="orbit o2" aria-hidden="true"><div class="opos"><span class="tag t2">Coupe enfant<small><?php echo esc_html( pken_price( 'Coupe enfant' ) ); ?></small></span></div></div>
  </div>
</div></section>
