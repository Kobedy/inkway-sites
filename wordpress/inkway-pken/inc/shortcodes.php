<?php
/**
 * Codes courts : réutilisent les sections du site dans Gutenberg (bloc « Code court ») ou Elementor (widget « Code court »).
 * [pken_section nom="tarifs"], [pken_rendez_vous], [pken_horaires], [pken_galerie], [pken_tarifs].
 *
 * @package inkway-pken
 */

defined( 'ABSPATH' ) || exit;

/**
 * Rendu d’une section de l’accueil.
 *
 * @param string $name Nom de la section.
 * @return string
 */
function pken_render_section( $name ) {
	$allowed = array( 'hero', 'atouts', 'tarifs', 'realisations', 'avis', 'fidelite', 'salon', 'rendez-vous', 'horaires-acces', 'faq' );
	if ( ! in_array( $name, $allowed, true ) ) {
		return '';
	}
	ob_start();
	get_template_part( 'template-parts/front/' . $name );
	return '<div class="pken-embed">' . ob_get_clean() . '</div>';
}

/**
 * [pken_section nom="…"].
 *
 * @param array $atts Attributs.
 * @return string
 */
function pken_shortcode_section( $atts ) {
	$atts = shortcode_atts( array( 'nom' => '' ), $atts, 'pken_section' );
	return pken_render_section( sanitize_key( $atts['nom'] ) );
}
add_shortcode( 'pken_section', 'pken_shortcode_section' );
/** [pken_rendez_vous] */
function pken_shortcode_rdv() {
	return pken_render_section( 'rendez-vous' );
}
add_shortcode( 'pken_rendez_vous', 'pken_shortcode_rdv' );

/** [pken_horaires] */
function pken_shortcode_horaires() {
	return pken_render_section( 'horaires-acces' );
}
add_shortcode( 'pken_horaires', 'pken_shortcode_horaires' );

/** [pken_galerie] */
function pken_shortcode_galerie() {
	return pken_render_section( 'realisations' );
}
add_shortcode( 'pken_galerie', 'pken_shortcode_galerie' );

/** [pken_tarifs] */
function pken_shortcode_tarifs() {
	return pken_render_section( 'tarifs' );
}
add_shortcode( 'pken_tarifs', 'pken_shortcode_tarifs' );
