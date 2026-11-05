<?php
/**
 * Customizer : coordonnées, horaires, réseaux sociaux, prestations, avis et photos du salon.
 * Toutes ces valeurs sont réutilisées dans le thème (aucune donnée en dur dans les gabarits).
 *
 * @package inkway-pken
 */

defined( 'ABSPATH' ) || exit;

/**
 * Horaires : JSON valide « jour → [ouverture, fermeture] », sinon valeur précédente.
 *
 * @param string $value Valeur saisie.
 * @return string
 */
function pken_sanitize_hours( $value ) {
	$data = json_decode( (string) $value, true );
	if ( ! is_array( $data ) ) {
		return get_theme_mod( 'pken_hours', pken_defaults()['hours'] );
	}
	$clean = array();
	foreach ( $data as $day => $slot ) {
		$day = (int) $day;
		if ( $day < 0 || $day > 6 || ! is_array( $slot ) || 2 !== count( $slot ) ) {
			continue;
		}
		$open  = (string) $slot[0];
		$close = (string) $slot[1];
		if ( preg_match( '/^\d{1,2}:\d{2}$/', $open ) && preg_match( '/^\d{1,2}:\d{2}$/', $close ) ) {
			$clean[ (string) $day ] = array( $open, $close );
		}
	}
	return (string) wp_json_encode( (object) $clean );
}

/**
 * Numéro WhatsApp : chiffres uniquement (format international sans +).
 *
 * @param string $value Valeur saisie.
 * @return string
 */
function pken_sanitize_digits( $value ) {
	return preg_replace( '/\D/', '', (string) $value );
}

/**
 * Liste d’identifiants d’images séparés par des virgules.
 *
 * @param string $value Valeur saisie.
 * @return string
 */
function pken_sanitize_ids( $value ) {
	return implode( ',', array_filter( array_map( 'absint', explode( ',', (string) $value ) ) ) );
}

/**
 * Déclaration des réglages.
 *
 * @param WP_Customize_Manager $wp_customize Gestionnaire du Customizer.
 */
function pken_customize_register( $wp_customize ) {
	$wp_customize->add_panel(
		'pken',
		array(
			'title'       => __( 'Salon PKEN Coiffure', 'inkway-pken' ),
			'description' => __( 'Coordonnées, horaires, prestations et photos utilisés partout sur le site.', 'inkway-pken' ),
			'priority'    => 30,
		)
	);
	$sections = array(
		'pken_contact'  => __( 'Coordonnées', 'inkway-pken' ),
		'pken_hours'    => __( 'Horaires', 'inkway-pken' ),
		'pken_services' => __( 'Prestations et tarifs', 'inkway-pken' ),
		'pken_social'   => __( 'Réseaux sociaux et avis Google', 'inkway-pken' ),
		'pken_photos'   => __( 'Photos des réalisations', 'inkway-pken' ),
		'pken_legal'    => __( 'Société et référencement', 'inkway-pken' ),
	);
	foreach ( $sections as $id => $title ) {
		$wp_customize->add_section( $id, array( 'title' => $title, 'panel' => 'pken' ) );
	}

	$d      = pken_defaults();
	$fields = array(
		array( 'brand', 'pken_contact', __( 'Nom du salon', 'inkway-pken' ), 'text', 'sanitize_text_field', '' ),
		array( 'phone', 'pken_contact', __( 'Téléphone (affiché)', 'inkway-pken' ), 'text', 'sanitize_text_field', __( 'Ex. 06 95 94 98 08', 'inkway-pken' ) ),
		array( 'whatsapp', 'pken_contact', __( 'WhatsApp (format international sans +)', 'inkway-pken' ), 'text', 'pken_sanitize_digits', __( 'Ex. 33695949808 : reçoit les demandes de rendez-vous du formulaire.', 'inkway-pken' ) ),
		array( 'email', 'pken_contact', __( 'E-mail', 'inkway-pken' ), 'email', 'sanitize_email', '' ),
		array( 'address', 'pken_contact', __( 'Adresse', 'inkway-pken' ), 'text', 'sanitize_text_field', '' ),
		array( 'postcode', 'pken_contact', __( 'Code postal', 'inkway-pken' ), 'text', 'sanitize_text_field', '' ),
		array( 'city', 'pken_contact', __( 'Ville', 'inkway-pken' ), 'text', 'sanitize_text_field', '' ),
		array( 'hours', 'pken_hours', __( 'Horaires (JSON)', 'inkway-pken' ), 'textarea', 'pken_sanitize_hours', __( 'Jour → [ouverture, fermeture] ; 0 = dimanche, 1 = lundi… 6 = samedi. Retirez un jour pour l’afficher fermé. Ex. {"1":["10:00","20:00"],"0":["11:30","18:30"]}', 'inkway-pken' ) ),
		array( 'holidays', 'pken_hours', __( 'Libellé du dimanche dans le tableau', 'inkway-pken' ), 'text', 'sanitize_text_field', __( 'Ex. « Dimanche & jours fériés »', 'inkway-pken' ) ),
		array( 'services', 'pken_services', __( 'Prestations (une par ligne)', 'inkway-pken' ), 'textarea', 'sanitize_textarea_field', __( 'Nom | Prix | Description. Ajoutez « | rdv » pour une prestation proposée seulement dans le formulaire de rendez-vous. Les prix du site (accueil, carte, formulaire) se mettent à jour automatiquement.', 'inkway-pken' ) ),
		array( 'facebook', 'pken_social', __( 'Page Facebook', 'inkway-pken' ), 'url', 'esc_url_raw', '' ),
		array( 'instagram', 'pken_social', __( 'Compte Instagram', 'inkway-pken' ), 'url', 'esc_url_raw', __( 'Laissez vide pour masquer les icônes Instagram.', 'inkway-pken' ) ),
		array( 'rating', 'pken_social', __( 'Note Google', 'inkway-pken' ), 'text', 'sanitize_text_field', __( 'Note réelle affichée par Google, ex. 4,9', 'inkway-pken' ) ),
		array( 'reviews_count', 'pken_social', __( 'Nombre d’avis', 'inkway-pken' ), 'text', 'sanitize_text_field', __( 'Ex. Plus de 70 avis', 'inkway-pken' ) ),
		array( 'review_url', 'pken_social', __( 'Lien « Laisser un avis »', 'inkway-pken' ), 'url', 'esc_url_raw', __( 'Lien « Demander des avis » de la fiche Google (g.page/r/…/review).', 'inkway-pken' ) ),
		array( 'reviews_url', 'pken_social', __( 'Lien « Voir tous les avis »', 'inkway-pken' ), 'url', 'esc_url_raw', '' ),
		array( 'gallery', 'pken_photos', __( 'Photos des réalisations (identifiants)', 'inkway-pken' ), 'text', 'pken_sanitize_ids', __( 'Identifiants des images de la Médiathèque, séparés par des virgules (ex. 12,15,18). Laissez vide pour les photos livrées avec le thème. La légende de chaque image s’affiche sous la photo.', 'inkway-pken' ) ),
		array( 'legal_name', 'pken_legal', __( 'Raison sociale', 'inkway-pken' ), 'text', 'sanitize_text_field', '' ),
		array( 'siret', 'pken_legal', __( 'SIRET', 'inkway-pken' ), 'text', 'sanitize_text_field', '' ),
		array( 'description', 'pken_legal', __( 'Description pour Google (accueil)', 'inkway-pken' ), 'textarea', 'sanitize_textarea_field', __( 'Utilisée si aucune extension SEO n’est installée.', 'inkway-pken' ) ),
	);
	foreach ( $fields as $f ) {
		list( $key, $section, $label, $type, $sanitize, $desc ) = $f;
		$wp_customize->add_setting(
			'pken_' . $key,
			array(
				'default'           => $d[ $key ],
				'sanitize_callback' => $sanitize,
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			'pken_' . $key,
			array(
				'label'       => $label,
				'section'     => $section,
				'type'        => $type,
				'description' => $desc,
			)
		);
	}
}
add_action( 'customize_register', 'pken_customize_register' );
