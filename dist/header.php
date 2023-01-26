<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'understrap_container_type' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'wp_body_open' ); ?>
<div class="site" id="page">

	<div id="#header-group">

		<div class="topbar navbar navbar-dark bg-dark" id="topbar">

			<div class="container">
				<span class="navbar-brand tagline d-none d-sm-block"><?php echo get_bloginfo( 'description', 'display' ); ?></span>
				<ul class="navbar-nav mx-auto mr-sm-0">
					<?php echo '<li class="nav-item">' . get_boton_login() . '</li>'; ?>
				</ul>
			</div>

		</div>

		<!-- ******************* The Navbar Area ******************* -->
		<div id="wrapper-navbar" itemscope itemtype="http://schema.org/WebSite">

			<a class="skip-link sr-only sr-only-focusable" href="#content"><?php esc_html_e( 'Skip to content', 'understrap' ); ?></a>

			<nav class="navbar navbar-expand-md navbar-light">

			<?php if ( 'container' == $container ) : ?>
				<div class="container">
			<?php endif; ?>

					<!-- Your site title as branding in the menu -->
					<?php if ( ! has_custom_logo() ) { ?>

						<a href="<?php echo get_home_url(); ?>" class="navbar-brand custom-logo-link default-logo" rel="home">
							<img src="<?php echo get_stylesheet_directory_uri() ?>/img/logo-kyrya-pro.png" class="img-fluid" alt="<?php bloginfo('name'); ?>" width="212" height="75">
						</a> 

					<?php } else {
						the_custom_logo();
					} ?><!-- end custom logo -->

					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'understrap' ); ?>">
						<span class="navbar-toggler-icon"></span>
					</button>

					<!-- The WordPress Menu goes here -->
					<?php wp_nav_menu(
						array(
							'theme_location'  => 'primary',
							'container_class' => 'collapse navbar-collapse',
							'container_id'    => 'navbarNavDropdown',
							'menu_class'      => 'navbar-nav ml-auto',
							'fallback_cb'     => '',
							'menu_id'         => 'main-menu',
							'depth'           => 2,
							'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
						)
					); ?>
				<?php if ( 'container' == $container ) : ?>
				</div><!-- .container -->
				<?php endif; ?>

			</nav><!-- .site-navigation -->

		</div><!-- #wrapper-navbar end -->

		<?php if( !is_front_page() && function_exists('bcn_display') ) {
			if ( 'container' == $container ) :
				echo '<div class="container">';
			endif;
					echo '<div class="kyrya-breadcrumb">';
						bcn_display();
					echo '</div>';
			if ( 'container' == $container ) :
				echo '</div>';
			endif;
		}?>

	</div><!-- #header-group end -->
