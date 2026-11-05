<?php
/**
 * Fonctionnalités du thème, chargement des styles et scripts, données structurées.
 *
 * @package inkway-pken
 */

defined( 'ABSPATH' ) || exit;

if ( ! isset( $content_width ) ) {
	$content_width = 1200; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
}

/**
 * Fonctionnalités prises en charge.
 */
function pken_setup() {
	load_theme_textdomain( 'inkway-pken', get_template_directory() . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );
	add_theme_support( 'custom-logo', array( 'height' => 120, 'width' => 120, 'flex-height' => true, 'flex-width' => true ) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );
	add_editor_style( array( 'assets/css/fonts.css', 'assets/css/editor.css' ) );
	register_nav_menus(
		array(
			'principal'    => __( 'Principal', 'inkway-pken' ),
			'pied-de-page' => __( 'Pied de page', 'inkway-pken' ),
		)
	);
}
add_action( 'after_setup_theme', 'pken_setup' );

/**
 * Styles et scripts (versionnés avec la version du thème).
 */
function pken_assets() {
	$v = wp_get_theme( get_template() )->get( 'Version' );
	// Pages Elementor : la feuille d’Elementor passe avant celle du thème, sinon ses remises à zéro
	// (.elementor img, .elementor a) l’emportent sur les styles du site validé.
	$after = array();
	if ( wp_style_is( 'elementor-frontend', 'registered' ) && ( pken_is_elementor_page() || ( class_exists( '\Elementor\Plugin' ) && \Elementor\Plugin::$instance->preview->is_preview_mode() ) ) ) {
		$after[] = 'elementor-frontend';
	}
	wp_enqueue_style( 'pken-fonts', pken_asset( 'assets/css/fonts.css' ), $after, $v );
	wp_enqueue_style( 'pken-base', pken_asset( 'assets/css/base.css' ), array( 'pken-fonts' ), $v );
	wp_enqueue_style( 'pken-site', pken_asset( 'assets/css/pken.css' ), array( 'pken-base' ), $v );
	wp_enqueue_style( 'pken-blocks', pken_asset( 'assets/css/blocks.css' ), array( 'pken-site' ), $v );
	if ( ! is_front_page() ) {
		wp_enqueue_style( 'pken-legal', pken_asset( 'assets/css/legal.css' ), array( 'pken-site' ), $v );
	}
	wp_enqueue_style( 'inkway-pken', get_stylesheet_uri(), array( 'pken-site' ), $v );
	wp_enqueue_script( 'pken-site', pken_asset( 'assets/js/site.js' ), array(), $v, true );
	// Aperçu Elementor : les sections sont rendues après site.js ; on y recopie le statut déjà calculé
	// dans la barre du haut et on repère le jour courant des horaires.
	if ( class_exists( '\Elementor\Plugin' ) && \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
		$codes = array();
		preg_match_all( '/\[pken [^\]]*\]/', (string) get_post_meta( get_queried_object_id(), '_elementor_data', true ), $found );
		foreach ( array_unique( $found[0] ) as $code ) {
			$codes[ $code ] = do_shortcode( $code );
		}
		wp_add_inline_script(
			'pken-site',
			'var PKEN_CODES=' . wp_json_encode( $codes ) . ';(function(){var fill=function($s){var w=$s[0];var h=w.innerHTML;Object.keys(PKEN_CODES).forEach(function(k){if(h.indexOf(k)>-1){h=h.split(k).join(PKEN_CODES[k]);}});if(h!==w.innerHTML){w.innerHTML=h;}var src=document.querySelector("[data-open-status]:not(:empty)");$s[0].querySelectorAll("[data-open-status]").forEach(function(el){if(src&&!el.innerHTML)el.innerHTML=src.innerHTML;});$s[0].querySelectorAll("[data-day]").forEach(function(el){el.classList.toggle("today",+el.dataset.day===new Date().getDay());});};var hook=function(){elementorFrontend.hooks.addAction("frontend/element_ready/global",fill);};if(window.elementorFrontend&&elementorFrontend.hooks){hook();}else{jQuery(window).on("elementor/frontend/init",hook);}jQuery(window).on("load",function(){fill(jQuery(document.body));});})();'
		);
	}
}
add_action( 'wp_enqueue_scripts', 'pken_assets' );

/**
 * Icône du site par défaut, couleur du navigateur, description (si aucune extension SEO).
 */
function pken_head() {
	echo '<meta name="theme-color" content="#0b0b0b">' . "\n";
	if ( ! has_site_icon() ) {
		echo '<link rel="icon" href="' . esc_url( pken_img( 'favicon.png' ) ) . '">' . "\n";
	}
	$seo = defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'AIOSEO_VERSION' ) || class_exists( 'SEOPress\\Core\\Kernel' );
	if ( ! $seo && is_front_page() ) {
		echo '<meta name="description" content="' . esc_attr( pken_opt( 'description' ) ) . '">' . "\n";
		echo '<meta property="og:title" content="' . esc_attr( pken_opt( 'brand' ) . ' — ' . pken_opt( 'city' ) ) . '">' . "\n";
		echo '<meta property="og:description" content="' . esc_attr( pken_opt( 'description' ) ) . '">' . "\n";
		echo '<meta property="og:image" content="' . esc_url( pken_img( 'facade.jpg' ) ) . '">' . "\n";
	}
	// Avec Yoast SEO, le salon rejoint le graphe Yoast (pken_yoast_schema) au lieu d’un second bloc JSON-LD.
	if ( is_front_page() && ! defined( 'WPSEO_VERSION' ) ) {
		pken_json_ld();
	}
}
add_action( 'wp_head', 'pken_head', 5 );

/**
 * Yoast SEO : description du salon utilisée par défaut sur l’accueil tant qu’elle n’est pas renseignée dans Yoast.
 *
 * @param string $desc Description Yoast.
 * @return string
 */
function pken_yoast_front_desc( $desc ) {
	return ( '' === trim( (string) $desc ) && is_front_page() ) ? pken_opt( 'description' ) : $desc;
}
add_filter( 'wpseo_metadesc', 'pken_yoast_front_desc' );
add_filter( 'wpseo_opengraph_desc', 'pken_yoast_front_desc' );
add_filter( 'wpseo_twitter_description', 'pken_yoast_front_desc' );

/**
 * Yoast SEO : image de partage par défaut (façade du salon) si aucune n’est définie.
 *
 * @param object $images Images Open Graph de Yoast.
 */
function pken_yoast_og_image( $images ) {
	if ( is_front_page() && method_exists( $images, 'has_images' ) && ! $images->has_images() ) {
		$images->add_image_by_url( pken_img( 'facade.jpg' ) );
	}
}
add_action( 'wpseo_add_opengraph_images', 'pken_yoast_og_image' );

/**
 * Yoast SEO : le salon (HairSalon) ajouté au graphe Schema de l’accueil, relié à la page.
 *
 * @param array $graph Graphe Yoast.
 * @return array
 */
function pken_yoast_schema( $graph ) {
	if ( ! is_front_page() || ! is_array( $graph ) ) {
		return $graph;
	}
	$salon = pken_json_ld_data();
	unset( $salon['@context'] );
	$salon['@id'] = home_url( '/#salon' );
	foreach ( $graph as &$piece ) {
		if ( isset( $piece['@type'] ) && 'WebPage' === $piece['@type'] ) {
			$piece['about'] = array( '@id' => $salon['@id'] );
		}
	}
	unset( $piece );
	$graph[] = $salon;
	return $graph;
}
add_filter( 'wpseo_schema_graph', 'pken_yoast_schema' );

/**
 * Données structurées HairSalon (adresse, horaires, prestations) générées depuis les réglages.
 */
function pken_json_ld() {
	echo '<script type="application/ld+json">' . wp_json_encode( pken_json_ld_data(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}

/**
 * Données HairSalon du salon.
 *
 * @return array
 */
function pken_json_ld_data() {
	$days  = array( 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday' );
	$slots = array();
	foreach ( pken_hours() as $day => $h ) {
		$key = $h[0] . '-' . $h[1];
		if ( ! isset( $slots[ $key ] ) ) {
			$slots[ $key ] = array(
				'@type'     => 'OpeningHoursSpecification',
				'dayOfWeek' => array(),
				'opens'     => $h[0],
				'closes'    => $h[1],
			);
		}
		$slots[ $key ]['dayOfWeek'][] = $days[ $day ];
	}
	$offers = array();
	foreach ( pken_services() as $s ) {
		if ( preg_match( '/(\d+(?:[.,]\d+)?)/', $s['price'], $m ) ) {
			$offers[] = array(
				'@type'         => 'Offer',
				'name'          => $s['name'],
				'price'         => str_replace( ',', '.', $m[1] ),
				'priceCurrency' => 'EUR',
			);
		}
	}
	$same = array_values( array_filter( array( pken_opt( 'facebook' ), pken_opt( 'instagram' ) ) ) );
	$data = array(
		'@context'                  => 'https://schema.org',
		'@type'                     => 'HairSalon',
		'name'                      => pken_opt( 'brand' ),
		'url'                       => home_url( '/' ),
		'image'                     => pken_img( 'facade.jpg' ),
		'logo'                      => pken_img( 'pken-logo-noir.png' ),
		'telephone'                 => substr( pken_tel_href(), 4 ),
		'email'                     => pken_opt( 'email' ),
		'legalName'                 => pken_opt( 'legal_name' ),
		'taxID'                     => pken_opt( 'siret' ),
		'address'                   => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => pken_opt( 'address' ),
			'postalCode'      => pken_opt( 'postcode' ),
			'addressLocality' => pken_opt( 'city' ),
			'addressCountry'  => 'FR',
		),
		'openingHoursSpecification' => array_values( $slots ),
		'makesOffer'                => $offers,
	);
	if ( $same ) {
		$data['sameAs'] = $same;
	}
	return $data;
}

/**
 * Catégorie des compositions de blocs.
 */
function pken_patterns_category() {
	if ( function_exists( 'register_block_pattern_category' ) ) {
		register_block_pattern_category( 'pken-coiffure', array( 'label' => __( 'PKEN Coiffure', 'inkway-pken' ) ) );
	}
}
add_action( 'init', 'pken_patterns_category' );

/**
 * Lien d’évitement pour la navigation au clavier.
 */
function pken_skip_link() {
	echo '<a class="skip-link screen-reader-text" href="#contenu">' . esc_html__( 'Aller au contenu', 'inkway-pken' ) . '</a>';
}
add_action( 'wp_body_open', 'pken_skip_link', 5 );
