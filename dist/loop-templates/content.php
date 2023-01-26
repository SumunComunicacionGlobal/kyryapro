<?php
/**
 * Post rendering content according to caller of get_template_part.
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
$post_type = get_post_type();

if('dlm_download' == $post_type) :
	$shortcode = '[download id="'.get_the_ID().'"]';
	echo do_shortcode( $shortcode );
else :
?>

	<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

		<header class="entry-header">

			<?php
			$target = '_self';

			if ( 'manual' == $post_type ) {
				$link = wp_get_attachment_url( get_post_meta( $post->ID, 'pdf', true ) );
				$target = '_blank';
			} else {
				$link = esc_url( get_permalink() );
			}

			the_title(
				sprintf( '<a href="%s" rel="bookmark" target="%s">', $link, $target ),
				'</a>'
			);
			?>

		</header><!-- .entry-header -->



	</article><!-- #post-## -->

<?php endif; ?>
