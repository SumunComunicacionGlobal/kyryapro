<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<section class="no-results not-found">

	<header class="page-header">

		<?php if( !is_user_logged_in() && is_restricted_tax() ) : ?>
		
			<h1 class="page-title"><?php echo __( 'You are not logged in.', 'wp-members' ); ?></h1>
			<p class=""><?php echo __( "This content is restricted to site members.  If you are an existing user, please log in.  New users may register below.", 'wp-members' ); ?></p>

		<?php else : ?>

			<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'understrap' ); ?></h1>

		<?php endif; ?>

	</header><!-- .page-header -->

	<div class="page-content">

		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'understrap' ), array(
	'a' => array(
		'href' => array(),
	),
) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php elseif ( !is_user_logged_in() ) : ?>

			<?php // echo get_boton_login( 'dark' ); ?>
			<?php get_search_form(); ?>

		<?php elseif ( is_search() ) : ?>

			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'understrap' ); ?></p>
			<?php
				get_search_form();
		else : ?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'understrap' ); ?></p>
			<?php
				// get_search_form();
		endif; ?>
	</div><!-- .page-content -->

</section><!-- .no-results -->
