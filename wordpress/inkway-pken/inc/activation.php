<?php
/**
 * À l’activation du thème : pages Accueil, Mentions légales et Confidentialité, page d’accueil statique,
 * menus « Principal » et « Pied de page » remplis. Rien n’est écrasé si les pages ou menus existent déjà.
 *
 * @package inkway-pken
 */

defined( 'ABSPATH' ) || exit;

/**
 * Crée une page si elle n’existe pas.
 *
 * @param string $slug    Identifiant.
 * @param string $title   Titre.
 * @param string $content Contenu.
 * @return int Identifiant de la page.
 */
function pken_ensure_page( $slug, $title, $content = '' ) {
	$page = get_page_by_path( $slug );
	if ( $page ) {
		return (int) $page->ID;
	}
	return (int) wp_insert_post(
		array(
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_name'    => $slug,
			'post_title'   => $title,
			'post_content' => $content,
		)
	);
}

/**
 * Crée un menu rempli et l’assigne à son emplacement s’il est libre.
 *
 * @param string $name     Nom du menu.
 * @param string $location Emplacement.
 */
function pken_ensure_menu( $name, $location ) {
	$menu = wp_get_nav_menu_object( $name );
	if ( ! $menu ) {
		$menu_id = wp_create_nav_menu( $name );
		if ( is_wp_error( $menu_id ) ) {
			return;
		}
		foreach ( pken_default_menu( $location ) as $i => $item ) {
			wp_update_nav_menu_item(
				$menu_id,
				0,
				array(
					'menu-item-title'    => $item[1],
					'menu-item-url'      => $item[0],
					'menu-item-type'     => 'custom',
					'menu-item-status'   => 'publish',
					'menu-item-position' => $i + 1,
				)
			);
		}
	} else {
		$menu_id = (int) $menu->term_id;
	}
	$locations = get_theme_mod( 'nav_menu_locations', array() );
	if ( empty( $locations[ $location ] ) ) {
		$locations[ $location ] = $menu_id;
		set_theme_mod( 'nav_menu_locations', $locations );
	}
}

/**
 * Mise en place du contenu.
 */
function pken_activate() {
	$legal   = require get_template_directory() . '/inc/legal-content.php';
	$home    = pken_ensure_page( 'accueil', 'Accueil', '' );
	$ml      = pken_ensure_page( 'mentions-legales', 'Mentions légales', '' );
	$conf    = pken_ensure_page( 'confidentialite', 'Politique de confidentialité', '' );
	$replace = array(
		'{{mentions-legales}}' => get_permalink( $ml ),
		'{{confidentialite}}'  => get_permalink( $conf ),
	);
	foreach ( array( $ml => 'mentions-legales', $conf => 'confidentialite' ) as $id => $key ) {
		if ( '' === trim( (string) get_post_field( 'post_content', $id ) ) ) {
			wp_update_post(
				array(
					'ID'           => $id,
					'post_content' => strtr( $legal[ $key ], $replace ),
				)
			);
		}
	}
	if ( 'page' !== get_option( 'show_on_front' ) || ! get_option( 'page_on_front' ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home );
	}
	if ( ! get_option( 'wp_page_for_privacy_policy' ) || ! get_post( (int) get_option( 'wp_page_for_privacy_policy' ) ) ) {
		update_option( 'wp_page_for_privacy_policy', $conf );
	}
	pken_ensure_menu( 'Principal', 'principal' );
	pken_ensure_menu( 'Pied de page', 'pied-de-page' );
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'pken_activate' );
