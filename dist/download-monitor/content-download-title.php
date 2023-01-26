<?php
/**
 * Shows title only.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/** @var DLM_Download $dlm_download */
?>
<a class="download-link" title="<?php if ( $dlm_download->get_version()->has_version_number() ) {
	printf( __( 'Version %s', 'download-monitor' ), $dlm_download->get_version()->get_version_number() );
} ?>" href="<?php $dlm_download->the_download_link(); ?>" rel="nofollow">

	<?php if ( has_post_thumbnail() ) {
			the_post_thumbnail( array(40,40), array('class' => 'mr-2') );
		} else {
			echo wp_get_attachment_image( PLACEHOLDER_ID, array(40,40), false, array('class' => 'placeholder-img mr-2' ) );
		} ?>
	<?php echo '<span class="title">' . get_the_title($dlm_download->get_ID()) . '</span>'; ?>
	<?php echo strip_tags( get_the_term_list( $dlm_download->get_ID(), 'dlm_download_category', '<span class="terms">', ', ', '</span>' ), '<span>' ); ?>

</a>