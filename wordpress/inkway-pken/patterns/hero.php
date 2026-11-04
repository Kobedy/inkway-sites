<?php
/**
 * Title: Accueil · Héros
 * Slug: inkway-pken/hero
 * Categories: pken-coiffure
 * Keywords: coiffure, salon
 * Description: Titre « Votre coiffeur à Alfortville », accroche et bouton de rendez-vous sur la photo du salon.
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
