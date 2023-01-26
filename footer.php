<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'understrap_container_type' );

?>
<div id="#footer-group">

	<?php if ( is_active_sidebar( 'prefooter' ) ) : ?>

		<!-- ******************* The Footer Full-width Widget Area ******************* -->

		<div class="wrapper" id="wrapper-prefooter">

			<div class="<?php echo esc_attr( $container ); ?>" id="prefooter-content" tabindex="-1">

				<?php dynamic_sidebar( 'prefooter' ); ?>

			</div>

		</div><!-- #wrapper-footer-full -->

	<?php endif; ?>


	<?php get_template_part( 'sidebar-templates/sidebar', 'footerfull' ); ?>

	<div class="wrapper bg-primary text-white" id="wrapper-footer">

		<div class="<?php echo esc_attr( $container ); ?>">

			<footer class="site-footer" id="colophon">

				<div class="site-info">

					<?php
					
				    if (is_active_sidebar( 'copyright' )) {
				        echo '<div class="row">';
				            dynamic_sidebar( 'copyright' );
				        echo '</div>';
				    } else {
				    	echo get_bloginfo( 'name' ) . ' © ' . date('Y');
				    }


					echo '<nav class="navbar-expand">';

						wp_nav_menu(
							array(
								'theme_location'  => 'legal',
								'container_class' => 'collapse navbar-collapse',
								'container_id'    => 'navbarLegal',
								'menu_class'      => 'navbar-nav mr-auto',
								'fallback_cb'     => '',
								'menu_id'         => 'legal-menu',
								'depth'           => 1,
								'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
							)
						);


			        echo '</nav>';
			        ?>

					<?php 
						$datos_login = get_datos_usuario_footer();
						if( $datos_login ) {
							echo '<div class="pt-3 mt-3 border-top text-center text-md-left text-small">';
								echo $datos_login;
							echo '</div>';
						}
					?>


				</div><!-- .site-info -->

			</footer><!-- #colophon -->

		</div><!-- container end -->

	</div><!-- wrapper end -->

</div><!-- #footer-group -->

</div><!-- #page we need this extra closing tag here -->

<?php wp_footer(); ?>

</body>

</html>

