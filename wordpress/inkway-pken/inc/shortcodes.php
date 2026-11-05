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

/**
 * [pken …] : une valeur du salon (Customizer) ou une image du thème, à l’adresse réelle du site.
 * Utilisable dans le texte comme dans un attribut d’un widget HTML Elementor :
 * [pken prix='Coupe homme'], [pken img='facade.webp'], [pken logo], [pken opt='phone'],
 * [pken jour='0' prefixe='Dimanche'], [pken horaires], [pken itineraire].
 *
 * @param array|string $atts Attributs.
 * @return string
 */
function pken_shortcode_value( $atts ) {
	$atts = (array) $atts;
	if ( isset( $atts['img'] ) ) {
		$file = preg_replace( '#[^a-z0-9._/-]#i', '', str_replace( '..', '', $atts['img'] ) );
		return esc_url( pken_img( $file ) );
	}
	if ( in_array( 'logo', $atts, true ) ) {
		return esc_url( pken_logo_url() );
	}
	if ( in_array( 'itineraire', $atts, true ) ) {
		return esc_url( pken_maps_dir_url() );
	}
	if ( in_array( 'horaires', $atts, true ) ) {
		return esc_html( pken_hours_sentence() );
	}
	if ( isset( $atts['prix'] ) ) {
		return esc_html( pken_price( $atts['prix'] ) );
	}
	if ( isset( $atts['jour'] ) ) {
		$prefix = isset( $atts['prefixe'] ) && '' !== $atts['prefixe'] ? $atts['prefixe'] . ' ' : '';
		return esc_html( pken_day_text( (int) $atts['jour'], $prefix ) );
	}
	if ( isset( $atts['opt'] ) ) {
		return esc_html( pken_opt( sanitize_key( $atts['opt'] ) ) );
	}
	return '';
}
add_shortcode( 'pken', 'pken_shortcode_value' );

/**
 * Mode « codes » : les fonctions du salon renvoient un repère remplacé ensuite par un code [pken].
 *
 * @param bool|null $on Active ou coupe le mode ; null pour le lire.
 * @return bool
 */
function pken_tokens( $on = null ) {
	static $state = false;
	if ( null !== $on ) {
		$state = (bool) $on;
	}
	return $state;
}

/**
 * Repère d’un code [pken] (sans caractère modifié par esc_url ou esc_html).
 *
 * @param string $code Attributs du code court.
 * @return string
 */
function pken_token( $code ) {
	global $pken_token_map;
	$key                    = '/pken-repere-' . count( (array) $pken_token_map ) . '/';
	$pken_token_map[ $key ] = '[pken ' . $code . ']';
	return $key;
}

/**
 * Section de l’accueil dont les valeurs du salon et les images sont des codes [pken].
 *
 * @param string $name Nom de la section.
 * @return string
 */
function pken_render_section_codes( $name ) {
	global $pken_token_map;
	$pken_token_map = array();
	pken_tokens( true );
	$html = pken_render_section( $name );
	pken_tokens( false );
	return strtr( $html, $pken_token_map );
}
