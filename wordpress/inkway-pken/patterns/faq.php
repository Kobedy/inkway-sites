<?php
/**
 * Title: Questions fréquentes
 * Slug: inkway-pken/faq
 * Categories: pken-coiffure
 * Keywords: coiffure, salon
 * Description: Questions et réponses dépliables.
 *
 * @package inkway-pken
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"tagName":"section","className":"pken-pattern","anchor":"faq","layout":{"type":"constrained","contentSize":"1200px"}} -->
<section id="faq" class="wp-block-group pken-pattern"><!-- wp:paragraph {"className":"pken-kick"} -->
<p class="pken-kick">Questions fréquentes</p>
<!-- /wp:paragraph --><!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading">Bon à savoir</h2>
<!-- /wp:heading --><!-- wp:details -->
<details class="wp-block-details"><summary>Comment prendre rendez-vous ?</summary><!-- wp:paragraph -->
<p>Remplissez le formulaire de rendez-vous : votre demande s’ouvre dans WhatsApp. Le salon vous confirme ensuite le créneau. Vous pouvez aussi appeler le <?php echo esc_html( pken_opt( 'phone' ) ); ?>.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details --><!-- wp:details -->
<details class="wp-block-details"><summary>Proposez-vous la coupe femme ?</summary><!-- wp:paragraph -->
<p>Pas encore : le salon recrute une coiffeuse. La coupe femme sera ouverte dès son arrivée. Laissez-nous un message pour être prévenue.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details --><!-- wp:details -->
<details class="wp-block-details"><summary>Comment fonctionne la carte de fidélité ?</summary><!-- wp:paragraph -->
<p>Un tampon par coupe. Après neuf coupes, la dixième est offerte. Demandez votre carte au salon.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details --><!-- wp:details -->
<details class="wp-block-details"><summary>Êtes-vous ouverts le dimanche ?</summary><!-- wp:paragraph -->
<p><?php echo esc_html( pken_hours_sentence() ); ?></p>
<!-- /wp:paragraph --></details>
<!-- /wp:details --></section>
<!-- /wp:group -->
