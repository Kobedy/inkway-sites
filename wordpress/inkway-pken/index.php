<?php
/**
 * Gabarit par défaut (articles, archives, recherche).
 *
 * @package inkway-pken
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="contenu">
	<div class="lg-hero"><div class="wrap">
		<span class="kick"><?php echo esc_html( pken_opt( 'brand' ) ); ?></span>
		<h1><?php echo is_singular() ? esc_html( get_the_title() ) : esc_html( wp_strip_all_tags( get_the_archive_title() ? get_the_archive_title() : get_bloginfo( 'name' ) ) ); ?></h1>
	</div></div>
	<div class="lg-body"><div class="wrap pken-page-wrap"><div class="lg-text">
	<?php
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			if ( is_singular() ) {
				the_content();
				wp_link_pages();
			} else {
				echo '<section><h2><a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a></h2>';
				the_excerpt();
				echo '</section>';
			}
		}
		the_posts_pagination();
	} else {
		echo '<p>' . esc_html__( 'Aucun contenu pour le moment.', 'inkway-pken' ) . '</p>';
	}
	?>
	</div></div></div>
</main>
<?php
get_footer();
