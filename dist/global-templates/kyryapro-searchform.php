<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if( !is_user_logged_in() ) return false;
    
if ( function_exists( 'facetwp_display') ) { ?>

	<?php echo facetwp_display( 'facet', 'buscar' ); ?>

	<div class="row">

		<!-- <div class="col-sm-6 col-md-4"> -->

			<?php // echo facetwp_display( 'facet', 'tipo' ); ?>

		<!-- </div> -->

		<div class="col-sm-6 col-md-4">

			<?php echo facetwp_display( 'facet', 'marca' ); ?>

		</div>

		<div class="col-sm-6 col-md-4">

			<?php echo facetwp_display( 'facet', 'producto' ); ?>

		</div>

	</div>

	<?php echo facetwp_display( 'template', 'descargas' ); ?>

	<div class="row">

		<div class="col-sm-6 text-center text-sm-left">

			<?php echo facetwp_display( 'facet', 'result_counts' ); ?>

		</div>

		<div class="col-sm-6 text-center text-sm-right">

			<?php echo facetwp_display( 'facet', 'paginacion' ); ?>

		</div>

	</div>

<?php } elseif ( function_exists( 'wpes_search_form' ) ) {

	wpes_search_form( array( 
		'wpessid' => 4449 
	) );

	echo get_subcategorias();

} else {

	get_search_form( true );

	echo get_subcategorias();

	// echo '<div class="mb-4">' . do_shortcode( '[ivory-search id="83" title="Descargas"]' ) . '</div>';

}      

