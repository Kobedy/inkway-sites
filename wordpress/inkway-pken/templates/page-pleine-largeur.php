<?php
/**
 * Template Name: Pleine largeur Elementor
 * Template Post Type: page
 *
 * En-tête et pied de page du site, contenu sur toute la largeur (idéal pour Elementor).
 *
 * @package inkway-pken
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="contenu" class="pken-full-width">
	<?php
	while ( have_posts() ) {
		the_post();
		the_content();
	}
	?>
</main>
<?php
get_footer();
