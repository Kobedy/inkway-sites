<?php
/**
 * Section « faq » de l’accueil (reprise du site validé).
 *
 * @package inkway-pken
 */

defined( 'ABSPATH' ) || exit;
?>
<section style="padding-top:0"><div class="wrap faq">
  <span class="kick">Questions fréquentes</span><h2 data-reveal>Bon à savoir</h2>
  <details><summary>Comment prendre rendez-vous ?</summary><p>Remplissez le formulaire de rendez-vous : votre demande s’ouvre dans WhatsApp. Le salon vous confirme ensuite le créneau. Vous pouvez aussi appeler le <?php echo esc_html( pken_opt( 'phone' ) ); ?>.</p></details>
  <details><summary>Proposez-vous la coupe femme ?</summary><p>Pas encore : le salon recrute une coiffeuse. La coupe femme sera ouverte dès son arrivée. Laissez-nous un message pour être prévenue.</p></details>
  <details><summary>Comment fonctionne la carte de fidélité ?</summary><p>Un tampon par coupe. Après neuf coupes, la dixième est offerte. Demandez votre carte au salon.</p></details>
  <details><summary>Êtes-vous ouverts le dimanche ?</summary><p><?php echo esc_html( pken_hours_sentence() ); ?></p></details>
</div></section>
