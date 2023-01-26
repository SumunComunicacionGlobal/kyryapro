<?php
/**
 * The template for displaying search results pages.
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if(isset($_GET['s-manual'])) {
    load_template(TEMPLATEPATH . '/search-manuales.php');
}

get_header();

$container = get_theme_mod( 'understrap_container_type' );

?>

<div class="wrapper" id="search-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<!-- Do the left sidebar check and opens the primary div -->
			<?php get_template_part( 'global-templates/left-sidebar-check' ); ?>

			<main class="site-main" id="main">

				<?php if ( have_posts() ) : ?>

					<header class="page-header">

							<h1 class="page-title">
								<?php
								printf(
									/* translators: %s: query term */
									esc_html__( 'Search Results for: %s', 'understrap' ),
									'<span>' . get_search_query() . '</span>'
								);
								?>
							</h1>

					</header><!-- .page-header -->

					<?php get_template_part( 'global-templates/kyryapro-searchform' ); ?>

					<?php //echo '<pre>'; print_r( wp_list_pluck( $wp_query->posts, 'ID' ) ); echo '</pre>'; ?>
					<?php //echo '<pre>'; print_r( $wp_query ); echo '</pre>'; ?>

					<ul class="list-group">

						<?php /* Start the Loop */ ?>
						<?php while ( have_posts() ) : the_post(); ?>

							<li class="list-group-item">
							
								<?php
								/**
								 * Run the loop for the search to output the results.
								 * If you want to overload this in a child theme then include a file
								 * called content-search.php and that will be used instead.
								 */
								get_template_part( 'loop-templates/content', 'search' );
								?>

							</li>

						<?php endwhile; ?>

					</ul>

				<?php else : ?>

					<?php get_template_part( 'loop-templates/content', 'none' ); ?>

				<?php endif; ?>

			</main><!-- #main -->

			<!-- The pagination component -->
			<?php understrap_pagination(); ?>

			<!-- Do the right sidebar check -->
			<?php get_template_part( 'global-templates/right-sidebar-check' ); ?>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #search-wrapper -->

<?php get_footer(); ?>
