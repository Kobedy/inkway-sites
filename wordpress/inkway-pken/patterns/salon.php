<?php
/**
 * Title: Le salon
 * Slug: inkway-pken/salon
 * Categories: pken-coiffure
 * Keywords: coiffure, salon
 * Description: Photo de la façade, présentation et itinéraire.
 *
 * @package inkway-pken
 */

defined( 'ABSPATH' ) || exit;
?>
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
