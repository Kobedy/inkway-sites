<?php
/**
 * Page introuvable.
 *
 * @package inkway-pken
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="contenu">
	<div class="lg-hero"><div class="wrap">
		<span class="kick"><?php esc_html_e( 'Erreur 404', 'inkway-pken' ); ?></span>
		<h1><?php esc_html_e( 'Cette page n’existe pas', 'inkway-pken' ); ?></h1>
		<p><?php esc_html_e( 'Elle a peut-être été déplacée. Revenez à l’accueil ou prenez rendez-vous.', 'inkway-pken' ); ?></p>
	</div></div>
	<div class="lg-body"><div class="wrap pken-page-wrap"><div class="lg-text">
		<p class="rmore"><a class="btn" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Retour à l’accueil', 'inkway-pken' ); ?></a> <a class="btn o" href="<?php echo esc_url( home_url( '/#rdv' ) ); ?>"><?php esc_html_e( 'Prendre rendez-vous', 'inkway-pken' ); ?></a></p>
	</div></div></div>
</main>
<?php
get_footer();
