<?php
/**
 * Pied de page du site, ou pied de page Elementor Theme Builder.
 *
 * @package inkway-pken
 */

defined( 'ABSPATH' ) || exit;

if ( ! pken_elementor_location( 'footer' ) ) {
	get_template_part( 'template-parts/site-footer' );
}
wp_footer();
?>
</body>
</html>
