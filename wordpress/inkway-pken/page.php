<?php
/**
 * Page (mentions légales, confidentialité, pages ajoutées) dans la mise en page des pages légales du site.
 *
 * @package inkway-pken
 */

defined( 'ABSPATH' ) || exit;

get_header();
while ( have_posts() ) :
	the_post();
	if ( pken_is_elementor_page() ) :
		?>
		<main id="contenu"><?php the_content(); ?></main>
		<?php
	else :
		?>
		<main id="contenu">
			<div class="lg-hero"><div class="wrap">
				<span class="kick"><?php echo esc_html( pken_opt( 'brand' ) ); ?></span>
				<h1><?php the_title(); ?></h1>
				<p><?php echo esc_html( sprintf( /* translators: %s: date */ __( 'Dernière mise à jour : %s', 'inkway-pken' ), get_the_modified_date() ) ); ?></p>
			</div></div>
			<div class="lg-body"><div class="wrap pken-page-wrap">
				<div class="lg-text entry-content"><?php the_content(); ?></div>
			</div></div>
		</main>
		<?php
	endif;
endwhile;
get_footer();
