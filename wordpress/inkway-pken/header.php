<?php
/**
 * En-tête du site : barre du haut (ordinateur) et en-tête collant, ou en-tête Elementor Theme Builder.
 *
 * @package inkway-pken
 */

defined( 'ABSPATH' ) || exit;
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width,initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php
wp_body_open();
if ( ! pken_elementor_location( 'header' ) ) {
	get_template_part( 'template-parts/top-bar' );
	get_template_part( 'template-parts/site-header' );
}
