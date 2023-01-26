<?php 

add_action( 'wpmem_pre_register_data', 'kyrya_wpmem_pre_register_data');
function kyrya_wpmem_pre_register_data( $user_post_data ) {

	global $wpmem_themsg;

	$cif = $user_post_data['cif'];
	if ( 	!isset( $user_post_data['cif'] )
			|| !$cif 
			|| '' == $cif 
			|| !kyrya_cif_es_cliente( $cif )
	) {
		$wpmem_themsg = '<p class="h4 alert-heading">'. __( 'CIF de cliente no encontrado', 'kyrya' ) .'</p>';
		$wpmem_themsg .= __( 'El acceso al área profesional está restringido a clientes. El CIF no se corresponde con el de ninguno de nuestros clientes. Si cree que se trata de un error, por favor contacte con nosotros por cualquiera de las vías indicadas en <a href="https://kyrya.es" target="_blank">kyrya.es</a>', 'kyrya' );
	}
}

add_filter( 'wpmem_msg_defaults', 'kyrya_anadir_wpmem_msg_dialog_arr', 10, 3);
function kyrya_anadir_wpmem_msg_dialog_arr( $defaults, $tag, $dialogs ) {

	$defaults['div_before'] = '<div class="alert alert-secondary alert-dismissible fade show" role="alert">';
	$defaults['div_after'] = '  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								    <span aria-hidden="true">&times;</span>
								  </button>
								</div>';

	return $defaults;
}


add_action( 'wpmem_post_register_data', 'kyrya_pro_activar_usuario_con_cif' );
function kyrya_pro_activar_usuario_con_cif( $user_post_data ) {

	$user_id = $user_post_data['ID'];
	$cif = $user_post_data['cif'];

	$cif = kyrya_limpiar_cif( $cif );
	if ( $cif && '' != $cif && kyrya_cif_es_cliente( $cif ) ) {

		wpmem_activate_user( $user_id, true );
		wpmem_update_user_role( $user_id, 'cliente', 'set' );
	
	}

}

function kyrya_limpiar_cif( $cif ) {
	return strtoupper( preg_replace('/[^A-Za-z0-9]/', "", $cif) );
}

function kyrya_cif_es_cliente( $cif ) {

	if ( !$cif || '' == $cif ) return false;

	global $wpdb;
	$table_name = $wpdb->prefix . 'cif';
	$field_name = 'cif';

	$prepared_statement = $wpdb->prepare( "SELECT {$field_name} FROM {$table_name} WHERE cif LIKE %s", $cif );
	$values = $wpdb->get_col( $prepared_statement );

	if ( $values && is_array( $values ) && count( $values ) > 0 ) return true;

	return false;
}

/**
 * This example allows you to disable any of the WP-Members
 * emails to users. Just update the settings array according
 * to the emails you want to disable.
 */
 add_filter( 'wpmem_email_filter', 'my_wpmem_disable_emails', 10, 3 );
 function my_wpmem_disable_emails( $email, $wpmem_fields, $field_data ) {
    
    // Set what emails will be disabled. Example array includes
    // all possibilities, remove unnecessary tags.
    $settings = array(
        // 'newreg',
        'newmod',
        // 'appmod',
        // 'repass',
        // 'getuser',
    );
    
    // Check which email is being sent ($arr['tag']). If it is in
    // the $settings array, disable it.
    if ( in_array( $email['tag'], $settings ) ) {
        $email['disable'] = true;
    }
    
    return $email;
 }

add_filter( 'wpmem_fields', 'kyrya_remove_profile_field', 10, 2 );
function kyrya_remove_profile_field( $fields, $tag ) {
 
    if ( 'profile' == $tag || 'profile_dashboard' == $tag ) {
        unset( $fields['cif'] );
    }
     
    return $fields;
}