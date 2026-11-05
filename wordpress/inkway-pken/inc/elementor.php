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

/**
 * Widgets HTML : les codes [pken] sont remplacés par les réglages du salon (texte et attributs).
 *
 * @param string $content Rendu du widget.
 * @param object $widget  Widget Elementor.
 * @return string
 */
function pken_elementor_html_codes( $content, $widget ) {
	if ( 'html' === $widget->get_name() && false !== strpos( $content, '[pken' ) ) {
		$content = do_shortcode( $content );
	}
	return $content;
}
add_filter( 'elementor/widget/render_content', 'pken_elementor_html_codes', 10, 2 );

/**
 * Cache d’éléments d’Elementor : un widget HTML contenant des codes [pken] est rendu à chaque affichage,
 * sinon un prix ou un horaire changé dans le Customizer n’apparaîtrait qu’à l’expiration du cache.
 *
 * @param bool  $dynamic  Contenu dynamique.
 * @param array $raw_data Données de l’élément.
 * @return bool
 */
function pken_elementor_codes_dynamic( $dynamic, $raw_data ) {
	if ( ! $dynamic && isset( $raw_data['widgetType'], $raw_data['settings']['html'] ) && 'html' === $raw_data['widgetType'] && is_string( $raw_data['settings']['html'] ) ) {
		$dynamic = false !== strpos( $raw_data['settings']['html'], '[pken' );
	}
	return $dynamic;
}
add_filter( 'elementor/element/is_dynamic_content', 'pken_elementor_codes_dynamic', 10, 2 );

/**
 * Contenu texte enregistré par Elementor (recherche, Yoast, flux) : les codes [pken] y sont remplacés
 * par leurs valeurs ; les autres codes courts (sections du site) restent tels quels.
 *
 * @param array $data Données de la publication (échappées).
 * @return array
 */
function pken_plain_content_codes( $data ) {
	if ( isset( $data['post_content'] ) && false !== strpos( $data['post_content'], '[pken ' ) ) {
		$content              = preg_replace_callback(
			'/\[pken [^\]]*\]/',
			function ( $m ) {
				return do_shortcode( $m[0] );
			},
			wp_unslash( $data['post_content'] )
		);
		$data['post_content'] = wp_slash( $content );
	}
	return $data;
}
add_filter( 'wp_insert_post_data', 'pken_plain_content_codes' );

/**
 * Sections Elementor de l’accueil, à l’identique du site validé : une section par bloc du thème.
 * Textes en widget HTML modifiable (valeurs et images en codes [pken]), blocs reliés au Customizer en code court.
 *
 * @return array
 */
function pken_elementor_home_elements() {
	$editable = array( 'hero', 'atouts', 'fidelite', 'salon', 'faq' );
	$zero     = array( 'unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'isLinked' => true );
	$elements = array();
	foreach ( pken_front_sections() as $name ) {
		$widget     = in_array( $name, $editable, true )
			? array( 'widgetType' => 'html', 'settings' => array( 'html' => trim( pken_render_section_codes( $name ) ) ) )
			: array( 'widgetType' => 'shortcode', 'settings' => array( 'shortcode' => '[pken_section nom="' . $name . '"]' ) );
		$elements[] = array(
			'id'       => substr( md5( 's' . $name ), 0, 7 ),
			'elType'   => 'section',
			'settings' => array( 'layout' => 'full_width', 'gap' => 'no', 'padding' => $zero, '_title' => ucfirst( str_replace( '-', ' ', $name ) ) ),
			'elements' => array(
				array(
					'id'       => substr( md5( 'c' . $name ), 0, 7 ),
					'elType'   => 'column',
					'settings' => array( '_column_size' => 100, 'padding' => $zero ),
					'elements' => array( array_merge( array( 'id' => substr( md5( 'w' . $name ), 0, 7 ), 'elType' => 'widget' ), $widget ) ),
					'isInner'  => false,
				),
			),
			'isInner'  => false,
		);
	}
	return $elements;
}

/**
 * Crée (ou recrée) l’accueil Elementor : sections du site validé, gabarit pleine largeur,
 * enregistrement par Elementor (révision conservée, contenu texte rempli pour Yoast).
 *
 * @param int $id Page d’accueil.
 * @return bool
 */
function pken_elementor_build_home( $id ) {
	if ( ! $id || ! class_exists( '\Elementor\Plugin' ) ) {
		return false;
	}
	update_post_meta( $id, '_elementor_edit_mode', 'builder' );
	update_post_meta( $id, '_elementor_template_type', 'wp-page' );
	update_post_meta( $id, '_wp_page_template', 'templates/page-pleine-largeur.php' );
	$doc = \Elementor\Plugin::$instance->documents->get( $id, false );
	return $doc && $doc->save( array( 'elements' => pken_elementor_home_elements() ) );
}

/**
 * Apparence › Accueil Elementor : bouton qui crée l’accueil Elementor (Elementor actif uniquement).
 */
function pken_elementor_home_menu() {
	if ( ! class_exists( '\Elementor\Plugin' ) ) {
		return;
	}
	add_theme_page( __( 'Accueil Elementor', 'inkway-pken' ), __( 'Accueil Elementor', 'inkway-pken' ), 'edit_theme_options', 'pken-accueil-elementor', 'pken_elementor_home_page' );
}
add_action( 'admin_menu', 'pken_elementor_home_menu' );

/**
 * Page « Accueil Elementor ».
 */
function pken_elementor_home_page() {
	$id   = (int) get_option( 'page_on_front' );
	$done = isset( $_GET['fait'] ) ? sanitize_key( $_GET['fait'] ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	echo '<div class="wrap"><h1>' . esc_html__( 'Accueil Elementor', 'inkway-pken' ) . '</h1>';
	if ( 'oui' === $done ) {
		echo '<div class="notice notice-success"><p>' . esc_html__( 'Accueil créé. Ouvrez-le avec « Modifier avec Elementor ».', 'inkway-pken' ) . '</p></div>';
	} elseif ( 'non' === $done ) {
		echo '<div class="notice notice-error"><p>' . esc_html__( 'L’accueil n’a pas pu être créé.', 'inkway-pken' ) . '</p></div>';
	}
	echo '<p>' . esc_html__( 'Crée la page d’accueil dans Elementor à l’identique du site validé : une section par bloc. Hero, atouts, fidélité, salon et FAQ sont des widgets HTML modifiables ; tarifs, réalisations, avis, rendez-vous et horaires restent reliés au Customizer.', 'inkway-pken' ) . '</p>';
	echo '<p>' . esc_html__( 'Dans les widgets HTML, les codes [pken …] affichent les réglages du salon et les images du thème : [pken prix=\'Coupe homme\'], [pken img=\'facade.webp\'], [pken logo], [pken opt=\'phone\'], [pken horaires].', 'inkway-pken' ) . '</p>';
	if ( ! $id ) {
		echo '<p><strong>' . esc_html__( 'Aucune page d’accueil statique (Réglages › Lecture).', 'inkway-pken' ) . '</strong></p></div>';
		return;
	}
	if ( get_post_meta( $id, '_elementor_data', true ) ) {
		echo '<p><strong>' . esc_html__( 'L’accueil a déjà un contenu Elementor : il sera remplacé (l’ancienne version reste dans les révisions).', 'inkway-pken' ) . '</strong></p>';
	}
	echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '">';
	wp_nonce_field( 'pken_accueil_elementor' );
	echo '<input type="hidden" name="action" value="pken_accueil_elementor">';
	submit_button( __( 'Créer l’accueil Elementor', 'inkway-pken' ) );
	echo '</form></div>';
}

/**
 * Traitement du bouton « Créer l’accueil Elementor ».
 */
function pken_elementor_home_action() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		wp_die( esc_html__( 'Action non autorisée.', 'inkway-pken' ) );
	}
	check_admin_referer( 'pken_accueil_elementor' );
	$ok = pken_elementor_build_home( (int) get_option( 'page_on_front' ) );
	wp_safe_redirect( admin_url( 'themes.php?page=pken-accueil-elementor&fait=' . ( $ok ? 'oui' : 'non' ) ) );
	exit;
}
add_action( 'admin_post_pken_accueil_elementor', 'pken_elementor_home_action' );
