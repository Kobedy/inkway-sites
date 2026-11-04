<?php
/**
 * Compatibilité Elementor (gratuit et Pro) : emplacements Theme Builder, largeur de contenu.
 *
 * @package inkway-pken
 */

defined( 'ABSPATH' ) || exit;

/**
 * Déclare la prise en charge d’Elementor.
 */
function pken_elementor_support() {
	add_theme_support( 'elementor' );
	add_theme_support( 'elementor-pro' );
}
add_action( 'after_setup_theme', 'pken_elementor_support' );

/**
 * Emplacements Theme Builder (Elementor Pro) : en-tête, pied de page, contenus seuls et archives.
 *
 * @param object $manager Gestionnaire des emplacements Elementor.
 */
function pken_elementor_locations( $manager ) {
	if ( method_exists( $manager, 'register_all_core_location' ) ) {
		$manager->register_all_core_location();
		return;
	}
	foreach ( array( 'header', 'footer', 'single', 'archive' ) as $location ) {
		$manager->register_location( $location );
	}
}
add_action( 'elementor/theme/register_locations', 'pken_elementor_locations' );

/**
 * Affiche un emplacement Elementor s’il est défini (Theme Builder), sinon le gabarit du thème.
 *
 * @param string $location Emplacement (header, footer, single, archive).
 * @return bool Vrai si Elementor a affiché l’emplacement.
 */
function pken_elementor_location( $location ) {
	return function_exists( 'elementor_theme_do_location' ) && elementor_theme_do_location( $location );
}

/**
 * Vrai si la page courante est construite avec Elementor.
 *
 * @return bool
 */
function pken_is_elementor_page() {
	if ( ! did_action( 'elementor/loaded' ) || ! class_exists( '\Elementor\Plugin' ) ) {
		return false;
	}
	$id = get_queried_object_id();
	return $id && \Elementor\Plugin::$instance->documents->get( $id ) && \Elementor\Plugin::$instance->documents->get( $id )->is_built_with_elementor();
}

/**
 * Largeur de contenu Elementor alignée sur theme.json (1200 px), à l’activation si non réglée.
 */
function pken_elementor_defaults() {
	if ( false === get_option( 'elementor_container_width' ) ) {
		update_option( 'elementor_container_width', 1200 );
	}
	if ( false === get_option( 'elementor_disable_color_schemes' ) ) {
		update_option( 'elementor_disable_color_schemes', 'yes' );
	}
	if ( false === get_option( 'elementor_disable_typography_schemes' ) ) {
		update_option( 'elementor_disable_typography_schemes', 'yes' );
	}
}
add_action( 'after_switch_theme', 'pken_elementor_defaults' );
