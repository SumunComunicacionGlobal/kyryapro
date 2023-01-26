<?php


$args = array(
	'posts_per_page'		=> 4
);

$q = new WP_Query($args); ?>

<?php if ( $q->have_posts() ) { ?>

	<section class="wrapper" id="seccion-noticias">

		<div class="container">

			<div class="row noticias mb-5">

				<?php while ( $q->have_posts() ) { $q->the_post(); ?>
					
					<div class="col-md-6 col-lg-3 mb-4 animado">

						<?php get_template_part( 'loop-templates/content', 'post' ); ?>

					</div>

				<?php } ?>

			</div>

			<?php
			$noticias_id = get_option( 'page_for_posts' );
			if ($noticias_id) {
				$titulo = get_the_title( $noticias_id );
				echo '<a class="btn btn-outline-primary" href="'.get_the_permalink( $noticias_id ).'" title="'.$titulo.'">'.$titulo.'</a>';
			}
			?>

		</div>

	</section>

<?php } ?>

<?php wp_reset_postdata(); ?>

