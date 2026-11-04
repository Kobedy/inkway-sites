<?php
/**
 * Title: Accueil complet (toutes les sections)
 * Slug: inkway-pken/accueil-complet
 * Categories: pken-coiffure
 * Keywords: coiffure, salon
 * Description: Toutes les sections de l’accueil, dans l’ordre du site validé.
 *
 * @package inkway-pken
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:cover {"url":"<?php echo esc_url( pken_img( 'hero-salon.webp' ) ); ?>","dimRatio":80,"overlayColor":"encre","minHeight":560,"className":"pken-pattern","layout":{"type":"constrained","contentSize":"1200px"}} -->
<div class="wp-block-cover pken-pattern" style="min-height:560px"><span aria-hidden="true" class="wp-block-cover__background has-encre-background-color has-background-dim-80 has-background-dim"></span><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( pken_img( 'hero-salon.webp' ) ); ?>" data-object-fit="cover"/><div class="wp-block-cover__inner-container"><!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Votre coiffeur<br>à <span class="pken-script">Alfortville.</span></h1>
<!-- /wp:heading --><!-- wp:paragraph -->
<p>Coupe homme, barbe et coupe enfant, à deux pas du boulevard Carnot. Un accueil convivial, des prix clairs et un café qui vous attend.</p>
<!-- /wp:paragraph --><!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#rdv">Prendre rendez-vous</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div></div>
<!-- /wp:cover -->
<!-- wp:shortcode -->
[pken_tarifs]
<!-- /wp:shortcode -->
<!-- wp:shortcode -->
[pken_galerie]
<!-- /wp:shortcode -->
<!-- wp:shortcode -->
[pken_section nom="avis"]
<!-- /wp:shortcode -->
<!-- wp:group {"tagName":"section","className":"pken-pattern is-dark","anchor":"fidelite","layout":{"type":"constrained","contentSize":"1200px"}} -->
<section id="fidelite" class="wp-block-group pken-pattern is-dark"><!-- wp:paragraph {"className":"pken-kick"} -->
<p class="pken-kick">Carte de fidélité</p>
<!-- /wp:paragraph --><!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading">9 coupes,<br>la 10<sup>e</sup> est <span class="pken-script">offerte.</span></h2>
<!-- /wp:heading --><!-- wp:paragraph -->
<p>Demandez votre carte au salon. À chaque coupe, un tampon. Après neuf coupes, la dixième est pour nous.</p>
<!-- /wp:paragraph --></section>
<!-- /wp:group -->
<!-- wp:group {"tagName":"section","className":"pken-pattern","anchor":"salon","layout":{"type":"constrained","contentSize":"1200px"}} -->
<section id="salon" class="wp-block-group pken-pattern"><!-- wp:columns {"verticalAlignment":"center"} -->
<div class="wp-block-columns are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:image {"sizeSlug":"large","className":"is-style-rounded"} -->
<figure class="wp-block-image size-large is-style-rounded"><img src="<?php echo esc_url( pken_img( 'facade.webp' ) ); ?>" alt="Façade du salon PKEN Coiffure à Alfortville"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->
<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:paragraph {"className":"pken-kick"} -->
<p class="pken-kick">Le salon</p>
<!-- /wp:paragraph --><!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading">Un salon de quartier, <span class="pken-script">accueillant.</span></h2>
<!-- /wp:heading --><!-- wp:paragraph -->
<p>PKEN Coiffure vous reçoit au 2 bis boulevard Carnot à Alfortville, 7 jours sur 7. On prend le temps de vous écouter, on soigne la coupe, et on vous sert à boire en attendant.</p>
<!-- /wp:paragraph --><!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( pken_maps_dir_url() ); ?>">Itinéraire jusqu’au salon</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></section>
<!-- /wp:group -->
<!-- wp:shortcode -->
[pken_rendez_vous]
<!-- /wp:shortcode -->
<!-- wp:shortcode -->
[pken_horaires]
<!-- /wp:shortcode -->
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
