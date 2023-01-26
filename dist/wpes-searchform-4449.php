<?php
/**
 * The template for displaying search forms
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( !is_user_logged_in() ) {
	echo '<div class="mb-4">' . get_boton_login('dark') . '</div>';
} else {
?>

	<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
		<label class="sr-only" for="s"><?php esc_html_e( 'Search', 'understrap' ); ?></label>
		
		<div class="input-group">
			<input class="field form-control" id="s" name="s" type="text"
				placeholder="<?php esc_attr_e( 'Search &hellip;', 'understrap' ); ?>" value="<?php the_search_query(); ?>">
			<span class="input-group-append">
				<input class="submit btn btn-primary" id="searchsubmit" name="submit" type="submit"
				value="<?php esc_attr_e( 'Search', 'understrap' ); ?>">
			</span>
		</div>
		<!-- <input type='hidden' value='4449' name='wpessid' /> -->
	</form>


	<script>
		function focusCampo(id){
		    var inputField = document.getElementById(id);
		    if (inputField != null && inputField.value.length != 0){
		        if (inputField.createTextRange){
		            var FieldRange = inputField.createTextRange();
		            FieldRange.moveStart('character',inputField.value.length);
		            FieldRange.collapse();
		            FieldRange.select();
		        }else if (inputField.selectionStart || inputField.selectionStart == '0') {
		            var elemLen = inputField.value.length;
		            inputField.selectionStart = elemLen;
		            inputField.selectionEnd = elemLen;
		            inputField.focus();
		        }
		    }else{
		        inputField.focus();
		    }
		}
		focusCampo('s');
	</script>

<?php } ?>