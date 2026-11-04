<?php
/**
 * Inkway PKEN Coiffure — fonctions du thème.
 *
 * @package inkway-pken
 */

defined( 'ABSPATH' ) || exit;

require get_template_directory() . '/inc/options.php';
require get_template_directory() . '/inc/setup.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/elementor.php';
require get_template_directory() . '/inc/shortcodes.php';
require get_template_directory() . '/inc/activation.php';

/**
 * Ordre des sections de l’accueil.
 *
 * @return string[]
 */
function pken_front_sections() {
	return apply_filters( 'pken_front_sections', array( 'hero', 'atouts', 'tarifs', 'realisations', 'avis', 'fidelite', 'salon', 'rendez-vous', 'horaires-acces', 'faq' ) );
}
