<?php
/**
 * Accueil : mise en page du site validé, ou contenu de la page « Accueil » s’il a été construit
 * avec Elementor ou des blocs Gutenberg.
 *
 * @package inkway-pken
 */

defined( 'ABSPATH' ) || exit;

// Gabarit choisi pour la page d’accueil (ex. « Pleine largeur Elementor ») : il prime sur front-page.php.
$pken_template = is_page() ? get_page_template_slug( get_queried_object_id() ) : '';
if ( $pken_template && locate_template( $pken_template ) ) {
	locate_template( $pken_template, true );
	return;
}

get_header();
$pken_has_content = is_page() && '' !== trim( (string) get_post_field( 'post_content', get_queried_object_id() ) );
?>
<main id="contenu">
<?php
if ( $pken_has_content ) {
	while ( have_posts() ) {
		the_post();
		echo '<div class="pken-content">';
		the_content();
		echo '</div>';
	}
} else {
	foreach ( pken_front_sections() as $pken_section ) {
		get_template_part( 'template-parts/front/' . $pken_section );
	}
}
?>
</main>
<?php
get_footer();
