<?php
/**
 * Template Name: Canevas (sans en-tête ni pied de page)
 * Template Post Type: page
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
<body <?php body_class( 'pken-canvas' ); ?>>
<?php wp_body_open(); ?>
<main id="contenu">
	<?php
	while ( have_posts() ) {
		the_post();
		the_content();
	}
	?>
</main>
<?php wp_footer(); ?>
</body>
</html>
