<?php
/**
 * Réglages du salon (Customizer) et fonctions d’affichage utilisées par tous les gabarits.
 *
 * @package inkway-pken
 */

defined( 'ABSPATH' ) || exit;

/**
 * Valeurs par défaut : informations validées de PKEN Coiffure.
 *
 * @return array<string,string>
 */
function pken_defaults() {
	return array(
		'brand'         => 'PKEN Coiffure',
		'phone'         => '06 95 94 98 08',
		'whatsapp'      => '33695949808',
		'email'         => 'pkencoiffure@gmail.com',
		'address'       => '2 bis boulevard Carnot',
		'postcode'      => '94140',
		'city'          => 'Alfortville',
		'hours'         => '{"1":["10:00","20:00"],"2":["10:00","20:00"],"3":["10:00","20:00"],"4":["10:00","20:00"],"5":["10:00","20:00"],"6":["10:00","20:00"],"0":["11:30","18:30"]}',
		'holidays'      => 'Dimanche & jours fériés',
		'facebook'      => 'https://www.facebook.com/pkencoiffure.fr/',
		'instagram'     => '',
		'services'      => "Coupe homme | 12 € | Coupe et finitions\nCoupe homme + barbe | 19 € | Formule complète | rdv\nBarbe | 7 € | Taille et contours\nCoupe enfant | 10 € | Pour les plus jeunes\nTeinture | dès 10 € | Tarif selon la prestation\nShampoing | 5 € | En complément de la coupe",
		'rating'        => '4,9',
		'reviews_count' => 'Plus de 70 avis',
		'review_url'    => 'https://www.google.com/search?q=PKEN+Coiffure+2+bis+boulevard+Carnot+Alfortville',
		'reviews_url'   => 'https://www.google.com/maps/search/?api=1&query=PKEN+Coiffure+2+bis+boulevard+Carnot+94140+Alfortville',
		'gallery'       => '',
		'legal_name'    => 'PKEN',
		'siret'         => '953 774 106 00017',
		'description'   => 'PKEN Coiffure, salon de coiffure et barbier à Alfortville (94140) : coupe homme, barbe, coupe enfant. Eau, café et thé offerts, carte de fidélité. Ouvert 7 jours sur 7. Rendez-vous par WhatsApp.',
	);
}

/**
 * Valeur d’un réglage du salon.
 *
 * @param string $key Clé du réglage.
 * @return string
 */
function pken_opt( $key ) {
	if ( pken_tokens() ) {
		return pken_token( "opt='" . $key . "'" );
	}
	$defaults = pken_defaults();
	$value    = get_theme_mod( 'pken_' . $key, isset( $defaults[ $key ] ) ? $defaults[ $key ] : '' );
	return is_string( $value ) ? trim( $value ) : '';
}

/**
 * Adresse d’un fichier du thème.
 *
 * @param string $path Chemin relatif au thème.
 * @return string
 */
function pken_asset( $path ) {
	return get_template_directory_uri() . '/' . ltrim( $path, '/' );
}

/**
 * Photo livrée avec le thème (assets/img).
 *
 * @param string $file Nom du fichier.
 * @return string
 */
function pken_img( $file ) {
	if ( pken_tokens() ) {
		return pken_token( "img='" . $file . "'" );
	}
	return pken_asset( 'assets/img/' . $file );
}

/**
 * Logo : logo personnalisé (Customizer › Identité du site) sinon logo blanc du salon.
 *
 * @return string
 */
function pken_logo_url() {
	if ( pken_tokens() ) {
		return pken_token( 'logo' );
	}
	$id = (int) get_theme_mod( 'custom_logo' );
	if ( $id ) {
		$src = wp_get_attachment_image_url( $id, 'medium' );
		if ( $src ) {
			return $src;
		}
	}
	return pken_img( 'pken-logo-blanc.png' );
}

/**
 * Lien tel: au format international (06… → +336…).
 *
 * @return string
 */
function pken_tel_href() {
	$digits = preg_replace( '/[^0-9+]/', '', pken_opt( 'phone' ) );
	if ( 0 === strpos( $digits, '0' ) ) {
		$digits = '+33' . substr( $digits, 1 );
	}
	return 'tel:' . $digits;
}

/**
 * Adresse complète du salon.
 *
 * @return string
 */
function pken_full_address() {
	return trim( pken_opt( 'address' ) . ', ' . trim( pken_opt( 'postcode' ) . ' ' . pken_opt( 'city' ) ), ' ,' );
}

/**
 * Recherche Google Maps du salon.
 *
 * @return string
 */
function pken_maps_url() {
	return 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode( pken_opt( 'brand' ) . ' ' . pken_full_address() );
}

/**
 * Itinéraire Google Maps jusqu’au salon.
 *
 * @return string
 */
function pken_maps_dir_url() {
	if ( pken_tokens() ) {
		return pken_token( 'itineraire' );
	}
	return 'https://www.google.com/maps/dir/?api=1&destination=' . rawurlencode( pken_opt( 'brand' ) . ' ' . pken_full_address() );
}

/**
 * Plan Google Maps intégré.
 *
 * @return string
 */
function pken_maps_embed_url() {
	return 'https://maps.google.com/maps?q=' . rawurlencode( pken_full_address() ) . '&z=16&output=embed';
}

/**
 * Adresse d’une page créée par le thème (mentions légales, confidentialité).
 *
 * @param string $slug Identifiant de la page.
 * @return string
 */
function pken_page_url( $slug ) {
	$page = get_page_by_path( $slug );
	return $page ? get_permalink( $page ) : home_url( '/' . $slug . '/' );
}

/**
 * Horaires : jour (0 = dimanche) → [ouverture, fermeture].
 *
 * @return array<int,array{0:string,1:string}>
 */
function pken_hours() {
	$data = json_decode( pken_opt( 'hours' ), true );
	if ( ! is_array( $data ) ) {
		$data = json_decode( pken_defaults()['hours'], true );
	}
	$out = array();
	foreach ( $data as $day => $slot ) {
		if ( is_array( $slot ) && 2 === count( $slot ) && preg_match( '/^\d{1,2}:\d{2}$/', $slot[0] ) && preg_match( '/^\d{1,2}:\d{2}$/', $slot[1] ) ) {
			$out[ (int) $day ] = array( $slot[0], $slot[1] );
		}
	}
	return $out;
}

/**
 * Horaires au format JSON pour le script du site (statut ouvert / fermé, créneaux).
 *
 * @return string
 */
function pken_hours_json() {
	return (string) wp_json_encode( (object) pken_hours() );
}

/**
 * « 10:00 » → « 10h », « 11:30 » → « 11h30 ».
 *
 * @param string $t Heure.
 * @return string
 */
function pken_h( $t ) {
	list( $h, $m ) = array_map( 'intval', explode( ':', $t ) );
	return $h . 'h' . ( $m ? sprintf( '%02d', $m ) : '' );
}

/**
 * Résumé court des horaires (barre du haut, avant le calcul du statut par le script).
 *
 * @return string
 */
function pken_hours_text() {
	$h = pken_hours();
	if ( isset( $h[1], $h[6] ) && $h[1] === $h[6] ) {
		$txt = 'Lun–sam ' . pken_h( $h[1][0] ) . '–' . pken_h( $h[1][1] );
		if ( isset( $h[0] ) ) {
			$txt .= ' · dim. ' . pken_h( $h[0][0] ) . '–' . pken_h( $h[0][1] );
		}
		return $txt;
	}
	return 'Horaires : voir la section Horaires & accès';
}

/**
 * Texte d’un jour (« Dimanche 11h30–18h30 »), vide si fermé.
 *
 * @param int    $day    Jour (0 = dimanche).
 * @param string $prefix Préfixe.
 * @return string
 */
function pken_day_text( $day, $prefix = '' ) {
	if ( pken_tokens() ) {
		return pken_token( "jour='" . (int) $day . "' prefixe='" . trim( $prefix ) . "'" );
	}
	$h = pken_hours();
	return isset( $h[ $day ] ) ? $prefix . pken_h( $h[ $day ][0] ) . '–' . pken_h( $h[ $day ][1] ) : $prefix . 'fermé';
}

/**
 * Phrase des horaires pour la FAQ.
 *
 * @return string
 */
function pken_hours_sentence() {
	if ( pken_tokens() ) {
		return pken_token( 'horaires' );
	}
	$h = pken_hours();
	if ( isset( $h[0] ) ) {
		$s = 'Oui, le dimanche et les jours fériés de ' . pken_h( $h[0][0] ) . ' à ' . pken_h( $h[0][1] ) . '.';
	} else {
		$s = 'Non, le salon est fermé le dimanche.';
	}
	if ( isset( $h[1], $h[6] ) && $h[1] === $h[6] ) {
		$s .= ' Du lundi au samedi, de ' . pken_h( $h[1][0] ) . ' à ' . pken_h( $h[1][1] ) . '.';
	}
	return $s;
}

/**
 * Lignes du tableau des horaires.
 */
function pken_hours_rows() {
	$names = array( 1 => 'Lundi', 2 => 'Mardi', 3 => 'Mercredi', 4 => 'Jeudi', 5 => 'Vendredi', 6 => 'Samedi', 0 => 'Dimanche' );
	$h     = pken_hours();
	foreach ( $names as $day => $name ) {
		$label = 0 === $day ? pken_opt( 'holidays' ) : $name;
		$value = isset( $h[ $day ] ) ? str_replace( ':', 'h', $h[ $day ][0] ) . ' – ' . str_replace( ':', 'h', $h[ $day ][1] ) : 'Fermé';
		printf( '<tr data-day="%1$d"><td>%2$s</td><td>%3$s</td></tr>', (int) $day, esc_html( $label ), esc_html( $value ) );
	}
}

/**
 * Prestations : une par ligne « Nom | Prix | Description | rdv » (rdv = uniquement dans le formulaire).
 *
 * @return array<int,array{name:string,price:string,desc:string,form_only:bool}>
 */
function pken_services() {
	$out = array();
	foreach ( preg_split( '/\r\n|\r|\n/', pken_opt( 'services' ) ) as $line ) {
		$parts = array_map( 'trim', explode( '|', $line ) );
		if ( '' === $parts[0] ) {
			continue;
		}
		$out[] = array(
			'name'      => $parts[0],
			'price'     => isset( $parts[1] ) ? $parts[1] : '',
			'desc'      => isset( $parts[2] ) ? $parts[2] : '',
			'form_only' => isset( $parts[3] ) && 'rdv' === strtolower( $parts[3] ),
		);
	}
	return $out;
}

/**
 * Prix d’une prestation (par son nom).
 *
 * @param string $name Nom de la prestation.
 * @return string
 */
function pken_price( $name ) {
	if ( pken_tokens() ) {
		return pken_token( "prix='" . $name . "'" );
	}
	foreach ( pken_services() as $s ) {
		if ( 0 === strcasecmp( $s['name'], $name ) ) {
			return $s['price'];
		}
	}
	return '';
}

/**
 * Lignes de la carte des prestations (section Prestations & tarifs).
 */
function pken_tarifs_items() {
	foreach ( pken_services() as $s ) {
		if ( $s['form_only'] ) {
			continue;
		}
		$price = esc_html( $s['price'] );
		if ( 0 === stripos( $s['price'], 'dès ' ) ) {
			$price = '<em>dès</em>' . esc_html( trim( substr( $s['price'], strlen( 'dès ' ) ) ) );
		}
		printf(
			'<div class="pi" data-reveal><div><h3>%1$s</h3><small>%2$s</small></div><span class="p">%3$s</span><button data-book="%4$s" onclick="location.hash=\'rdv\'">Réserver</button></div>',
			esc_html( $s['name'] ),
			esc_html( $s['desc'] ),
			$price, // Déjà échappé ci-dessus.
			esc_attr( $s['name'] )
		);
	}
}

/**
 * Options du formulaire de rendez-vous (avec le prix pour le récapitulatif).
 */
function pken_service_options() {
	foreach ( pken_services() as $s ) {
		printf( '<option data-price="%1$s">%2$s</option>', esc_attr( $s['price'] ), esc_html( $s['name'] ) );
	}
}

/**
 * Photos des réalisations : images choisies dans le Customizer (identifiants de la médiathèque), sinon photos du thème.
 */
function pken_gallery_items() {
	$ids = array_filter( array_map( 'absint', explode( ',', pken_opt( 'gallery' ) ) ) );
	if ( $ids ) {
		foreach ( $ids as $id ) {
			$full = wp_get_attachment_image_url( $id, 'large' );
			if ( ! $full ) {
				continue;
			}
			$alt     = get_post_meta( $id, '_wp_attachment_image_alt', true );
			$caption = wp_get_attachment_caption( $id );
			printf(
				'<a href="%1$s" data-lightbox data-caption="%2$s" data-reveal>%3$s<span>%4$s</span></a>',
				esc_url( $full ),
				esc_attr( $caption ? $caption : $alt ),
				wp_get_attachment_image( $id, 'medium_large', false, array( 'loading' => 'lazy' ) ),
				esc_html( $caption ? $caption : $alt )
			);
		}
		return;
	}
	$items = require get_template_directory() . '/inc/gallery-default.php';
	foreach ( $items as $g ) {
		printf(
			'<a href="%1$s" data-lightbox data-caption="%2$s" data-reveal><img src="%1$s" alt="%3$s" loading="lazy" width="%4$d" height="%5$d"><span>%6$s</span></a>',
			esc_url( pken_img( $g['file'] ) ),
			esc_attr( $g['caption'] ),
			esc_attr( $g['alt'] ),
			(int) $g['w'],
			(int) $g['h'],
			esc_html( $g['label'] )
		);
	}
}

/**
 * Liens d’un menu (sans liste <ul>, comme sur le site validé). Menu par défaut si aucun menu n’est assigné.
 *
 * @param string $location Emplacement du menu.
 */
function pken_menu_links( $location ) {
	$locations = get_nav_menu_locations();
	$items     = array();
	if ( ! empty( $locations[ $location ] ) ) {
		$menu_items = wp_get_nav_menu_items( $locations[ $location ] );
		foreach ( (array) $menu_items as $item ) {
			if ( empty( $item->menu_item_parent ) ) {
				$items[] = array( $item->url, $item->title, $item->target );
			}
		}
	}
	if ( ! $items ) {
		foreach ( pken_default_menu( $location ) as $item ) {
			$items[] = array( $item[0], $item[1], '' );
		}
	}
	foreach ( $items as $item ) {
		printf(
			'<a href="%1$s"%2$s>%3$s</a>',
			esc_url( $item[0] ),
			$item[2] ? ' target="' . esc_attr( $item[2] ) . '" rel="noopener"' : '',
			esc_html( $item[1] )
		);
	}
}

/**
 * Menus par défaut (aussi utilisés pour remplir les menus à l’activation).
 *
 * @param string $location Emplacement.
 * @return array<int,array{0:string,1:string}>
 */
function pken_default_menu( $location ) {
	$home = home_url( '/' );
	if ( 'pied-de-page' === $location ) {
		return array(
			array( $home . '#tarifs', 'Prestations & tarifs' ),
			array( $home . '#fidelite', 'Carte de fidélité' ),
			array( $home . '#rdv', 'Rendez-vous' ),
			array( $home . '#avis', 'Avis Google' ),
		);
	}
	return array(
		array( $home . '#tarifs', 'Prestations' ),
		array( $home . '#realisations', 'Réalisations' ),
		array( $home . '#fidelite', 'Fidélité' ),
		array( $home . '#salon', 'Le salon' ),
		array( $home . '#acces', 'Horaires & accès' ),
		array( $home . '#rdv', 'Rendez-vous' ),
	);
}
