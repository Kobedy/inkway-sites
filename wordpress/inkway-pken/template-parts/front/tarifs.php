<?php
/**
 * Section « tarifs » de l’accueil (reprise du site validé).
 *
 * @package inkway-pken
 */

defined( 'ABSPATH' ) || exit;
?>
<section id="tarifs"><div class="wrap">
  <span class="kick">Prestations &amp; tarifs</span>
  <h2 data-reveal>Des prix clairs, <span class="script" style="color:var(--accent)">affichés.</span></h2>
  <p class="sub">Choisissez votre prestation, demandez votre créneau : le salon vous confirme le rendez-vous.</p>
  <div class="tarifs">
    <div class="pl"><?php pken_tarifs_items(); ?></div>
    <div>
      <div class="soon" data-reveal><span class="badge">Bientôt disponible</span><h3>Coupe femme</h3><p>Le salon recrute actuellement une coiffeuse. La coupe femme sera proposée dès son arrivée.</p>
        <a class="btn w" target="_blank" rel="noopener" href="<?php echo esc_url( 'https://wa.me/' . pken_opt( 'whatsapp' ) ); ?>?text=Bonjour%20PKEN%20Coiffure%2C%20je%20souhaite%20%C3%AAtre%20pr%C3%A9venue%20de%20l%E2%80%99ouverture%20de%20la%20coupe%20femme.">Être prévenue de l’ouverture</a></div>
      <div class="note" data-reveal><b>Inclus à chaque visite :</b> eau, café ou thé offerts pendant votre attente.</div>
    </div>
  </div>
</div></section>
