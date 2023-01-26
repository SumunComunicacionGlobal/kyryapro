<?php 
// add_post_type_support( 'page', 'excerpt' );
// add_action( 'init', 'sumun_settings', 1000 );
// function sumun_settings() {  
//     register_taxonomy_for_object_type('ategory', 'page');  
// }

if ( ! function_exists('custom_post_type_manual') ) {

// Register Custom Post Type
function custom_post_type_manual() {

	$labels = array(
		'name'                  => _x( 'Manuales', 'Post Type General Name', 'sumun' ),
		'singular_name'         => _x( 'Manual', 'Post Type Singular Name', 'sumun' ),
		'menu_name'             => __( 'Manuales', 'sumun-admin' ),
		'name_admin_bar'        => __( 'Manual', 'sumun-admin' ),
		'add_new'               => __( 'Añadir nuevo Manual', 'sumun-admin' ),
		'new_item'              => __( 'Nuevo Manual', 'sumun-admin' ),
		'edit_item'             => __( 'Editar Manual', 'sumun-admin' ),
		'update_item'           => __( 'Actualizar Manual', 'sumun-admin' ),
		'view_item'             => __( 'Ver Manual', 'sumun-admin' ),
		'view_items'            => __( 'Ver Manuales', 'sumun-admin' ),
		'featured_image'		=> __( 'Imagen del producto', 'sumun-admin' ),
		'set_featured_image'	=> __( 'Establecer Imagen del producto', 'sumun-admin' ),
		'remove_featured_image'	=> __( 'Quitar Imagen del producto', 'sumun-admin' ),
		'use_featured_image'	=> __( 'Usar como Imagen del producto', 'sumun-admin' ),
	);
	$args = array(
		'label'                 => __( 'Manuales', 'sumun' ),
		'labels'                => $labels,
		'supports'              => array( 'title' ),
		'hierarchical'          => false,
		// 'public'                => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 23,
		'menu_icon'             => 'dashicons-media-document',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => false,
		// 'publicly_queryable'    => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		// 'taxonomies'			=> array('dlm_download_category'),
		'show_in_rest'			=> false,
		// 'query_var'				=> false,
	);
	register_post_type( 'manual', $args );

}
add_action( 'init', 'custom_post_type_manual', 10 );

}



if ( ! function_exists( 'custom_taxonomy_marca' ) ) {

// Register Custom Taxonomy
function custom_taxonomy_marca() {

	$labels = array(
		'name'                       => _x( 'Marcas', 'Taxonomy General Name', 'sumun' ),
		'singular_name'              => _x( 'Marca', 'Taxonomy Singular Name', 'sumun' ),
		'menu_name'                  => __( 'Marcas', 'sumun-admin' ),
		'all_items'                  => __( 'Todas los Marcas', 'sumun-admin' ),
		'parent_item'                => __( 'Marca superior', 'sumun-admin' ),
		'parent_item_colon'          => __( 'Marca superior:', 'sumun-admin' ),
		'new_item_name'              => __( 'Nombre de la nueva Marca', 'sumun-admin' ),
		'add_new_item'               => __( 'Añadir nueva Marca', 'sumun-admin' ),
		'edit_item'                  => __( 'Editar Marca', 'sumun-admin' ),
		'update_item'                => __( 'Actualizar Marca', 'sumun-admin' ),
		'view_item'                  => __( 'Ver Marca', 'sumun-admin' ),
		'separate_items_with_commas' => __( 'Separar Marcas con comas', 'sumun-admin' ),
		'add_or_remove_items'        => __( 'Añadir o quitar Marcas', 'sumun-admin' ),
		'choose_from_most_used'      => __( 'Elegir de entre las más usadas', 'sumun-admin' ),
		'popular_items'              => __( 'Marcas populares', 'sumun-admin' ),
		'search_items'               => __( 'Buscar Marcas', 'sumun-admin' ),
		'not_found'                  => __( 'No encontrada', 'sumun-admin' ),
		'no_terms'                   => __( 'No hay Marcas', 'sumun-admin' ),
		'items_list'                 => __( 'Lista de Marcas', 'sumun-admin' ),
		'items_list_navigation'      => __( 'Navegación de la lista de Marcas', 'sumun-admin' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'show_in_rest'               => false,
	);
	register_taxonomy( 'marca', array( 'dlm_download' ), $args );

}
add_action( 'init', 'custom_taxonomy_marca', 10 );

}

if ( ! function_exists( 'custom_taxonomy_tipo_descarga' ) ) {

// Register Custom Taxonomy
function custom_taxonomy_tipo_descarga() {

	$labels = array(
		'name'                       => _x( 'Tipos de Descargas', 'Taxonomy General Name', 'sumun' ),
		'singular_name'              => _x( 'Tipo de Descarga', 'Taxonomy Singular Name', 'sumun' ),
		'menu_name'                  => __( 'Tipos de Descargas', 'sumun-admin' ),
		'all_items'                  => __( 'Todos los Tipos de Descargas', 'sumun-admin' ),
		'parent_item'                => __( 'Tipo de Descarga superior', 'sumun-admin' ),
		'parent_item_colon'          => __( 'Tipo de Descarga superior:', 'sumun-admin' ),
		'new_item_name'              => __( 'Nombre del nuevo Tipo de Descarga', 'sumun-admin' ),
		'add_new_item'               => __( 'Añadir nuevo Tipo de Descarga', 'sumun-admin' ),
		'edit_item'                  => __( 'Editar Tipo de Descarga', 'sumun-admin' ),
		'update_item'                => __( 'Actualizar Tipo de Descarga', 'sumun-admin' ),
		'view_item'                  => __( 'Ver Tipo de Descarga', 'sumun-admin' ),
		'separate_items_with_commas' => __( 'Separar Tipos de Descargas con comas', 'sumun-admin' ),
		'add_or_remove_items'        => __( 'Añadir o quitar Tipos de Descargas', 'sumun-admin' ),
		'choose_from_most_used'      => __( 'Elegir de entre los más usados', 'sumun-admin' ),
		'popular_items'              => __( 'Tipos de Descargas populares', 'sumun-admin' ),
		'search_items'               => __( 'Buscar Tipos de Descargas', 'sumun-admin' ),
		'not_found'                  => __( 'No encontrado', 'sumun-admin' ),
		'no_terms'                   => __( 'No hay Tipos de Descargas', 'sumun-admin' ),
		'items_list'                 => __( 'Lista de Tipos de Descargas', 'sumun-admin' ),
		'items_list_navigation'      => __( 'Navegación de la lista de Tipos de Descargas', 'sumun-admin' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'show_in_rest'               => false,
	);
	register_taxonomy( 'tipo-descarga', array( 'dlm_download' ), $args );

}
add_action( 'init', 'custom_taxonomy_tipo_descarga', 0 );

}

function wpb_change_title_text( $title ){
     $screen = get_current_screen();
  
     if  ( 'portfolio_page' == $screen->post_type ) {
          $title = 'Título del proyecto';
     } elseif  ( 'slide' == $screen->post_type ) {
          $title = 'Título de la slide';
     } elseif  ( 'team' == $screen->post_type ) {
          $title = 'Nombre y apellidos';
     }
  
     return $title;
}
add_filter( 'enter_title_here', 'wpb_change_title_text' );

// ADD NEW COLUMN
add_filter('manage_posts_columns', 'sumun_columns_head');
add_filter('manage_pages_columns', 'sumun_columns_head');
add_action('manage_posts_custom_column', 'sumun_columns_content', 10, 2);
add_action('manage_pages_custom_column', 'sumun_columns_content', 10, 2);
function sumun_columns_head($defaults) {
	// $defaults = array('featured_image' => 'Imagen') + $defaults;
    $defaults['featured_image'] = 'Imagen';
    $defaults['extracto'] = 'Resumen';

    return $defaults;
}
 
// SHOW THE FEATURED IMAGE
function sumun_columns_content($column_name, $post_ID) {
    if ($column_name == 'featured_image') {
    	echo '<div style="height:100px;">' . get_the_post_thumbnail( $post_ID, array(80,80) ) . '</div>';

    }
    if ($column_name == 'extracto') {
    	$post = get_post($post_ID);
    	echo $post->post_excerpt;
    }
}

// Admin columnas personalizadas downloads
add_filter('manage_edit-dlm_download_columns', 'columnas_personalizadas_descargas');
function columnas_personalizadas_descargas($columns) {
    $columns['traduccion_titulo'] = __( 'Traducciones', 'kyrya' );
    $columns['marca'] = __( 'Marca', 'kyrya' );
    $columns['tipo'] = __( 'Tipo', 'kyrya' );
    return $columns;
}
// Render the custom columns for the "DOWNLOADS" post type
add_action('manage_dlm_download_posts_custom_column', 'render_columnas_personalizadas_descargas', 10, 2);
function render_columnas_personalizadas_descargas($column_name) {
    global $post;
    switch ($column_name) {
         case 'traduccion_titulo':
	        $traducciones = get_post_meta( $post->ID, $column_name, true );
	        if( $traducciones) {
	            echo $traducciones;
	            // echo(sprintf( '<span class="acf-field %s">%s</span>', $column_name, $traducciones ) );
	        }
        break;
         case 'marca':
	        $term_list = get_the_term_list( $post->ID, 'marca', '', ', ', '' );
	        echo $term_list;

        break;
         case 'tipo':
	        $term_list = get_the_term_list( $post->ID, 'tipo-descarga', '', ', ', '' );
	        echo $term_list;

        break;
    }
}


// COLUMNAS EN TABLAS DE USUARIOS
function kyrya_modify_user_table( $column ) {
    $column['datos'] = 'Datos';
    $column['registrado'] = 'Registrado el';
    $column['descargas'] = 'Descargas';
    $column['activado'] = 'Activado';
    return $column;
}
add_filter( 'manage_users_columns', 'kyrya_modify_user_table' );

function kyrya_modify_user_table_row( $val, $column_name, $user_id ) {
    switch ($column_name) {
        case 'datos' :
        	$telefono = get_the_author_meta( 'billing_phone', $user_id );
        	$telefono_link = 'tel:' . str_replace(' ', '', $telefono);
        	$cif = get_the_author_meta( 'cif', $user_id );
        	$cif = kyrya_limpiar_cif( $cif );
        	if ( !$cif ) $cif = '<span style="color:lightgray;">'.__( 'Sin CIF', 'sumun-admin' ).'</span>';

        	$match = '';
        	if ( kyrya_cif_es_cliente( $cif ) ) $match = '<small style="color:white;background-color:blue;padding:2px 8px;border-radius: 3px;"><b>MATCH</b></small>';

        	$codigo_cliente = get_the_author_meta( 'codigo_cliente', $user_id );
        	if ( !$codigo_cliente ) $codigo_cliente = '<span style="color:lightgray;">'.__( 'Sin código cliente', 'sumun-admin' ).'</span>';

            return '<b><a href="'.$telefono_link.'"><span class="dashicons dashicons-phone"></span> ' . $telefono . '</a></b><br><small><span class="dashicons dashicons-nametag"></span> '.$cif.'</small> '.$match.'<br><small><span class="dashicons dashicons-businessperson"></span> '.$codigo_cliente.'</small><br><small>' . get_the_author_meta( 'perfil', $user_id ) . ' (' . get_the_author_meta( 'billing_city', $user_id ) . ')</small>';
            break;
        case 'activado' :
        	$r = '<a href="'.get_edit_user_link( $user_id ).'#activate_user" title="';
	        	if ('1' == get_the_author_meta( 'active', $user_id ) ) {
	        		$r .= __( 'Desactivar', 'kyrya-admin' ) . '">';
	        	    $r .= '<span style="color:lightblue;">' . __( 'Sí', 'kyrya-admin' );
	        	} else {
	        		$r .= __( 'Activar', 'kyrya-admin' ) . '">';
	        		$r .= '<span style="color:red;">' . __( 'No', 'kyrya-admin' );
	        	}

	        	$r .= ' <span class="dashicons dashicons-arrow-right-alt" style=""></span></span>';
	        $r .= '</a>';

        	return $r;

            break;
        case 'registrado' :
        	$user_data = get_userdata( $user_id );
        	$registered = $user_data->user_registered;
        	// return $registered;
        	return date_i18n( get_option('date_format'), strtotime( $registered ) );
        	break;

        case 'descargas' :
        	global $wpdb;
        	$r = '';
        	$descargas = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}download_log WHERE user_id = {$user_id}", OBJECT );
        	if (!empty($descargas)) {
        		$r .= '<p style="border-bottom:1px solid lightgray;"><strong>'.__( 'Total', 'kyrya-admin' ).': '.count($descargas).'</strong></p>';
        		$r .= '<ul style="line-height:1.2; overflow:hidden;" class="colapsar">';
	        	foreach ($descargas as $descarga) {
		        	$r .= '<li><small>' . get_the_title( $descarga->download_id ) . ' <span style="color:lightgray;">(' . date_i18n( get_option('date_format'), strtotime( $descarga->download_date ) )  . ')</span></small></li>';
		        	// $r .= '<li>' . get_the_title( $descarga->download_id ) . '</li>';
	        	}
	        	$r .= '</ul>';
		    }



	        return $r;
        	break;
        default:
    }
    return $val;
}
add_filter( 'manage_users_custom_column', 'kyrya_modify_user_table_row', 10, 3 );

add_action( 'admin_footer', 'estilos_y_scripts_admin', 10 );
function estilos_y_scripts_admin() {
	global $pagenow;
	if ('users.php' == $pagenow) { ?>
			<script type="text/javascript">
				jQuery(document).ready(function ($) {
				  var maxheight=100;
				  var showText = "<?php _e('...<br>Ver más', 'kyrya-admin'); ?>";
				  var hideText = "[<?php _e('Cerrar', 'kyrya-admin'); ?>]";

				  $('.colapsar').each(function () {
				    var text = $(this);
				    if (text.height() > maxheight){
				        text.css('max-height', maxheight + 'px').addClass('oculto');

				        var link = $('<a class="leer-mas" href="#">' + showText + '</a>');
				        var linkDiv = $('<div></div>');
				        linkDiv.append(link);
				        $(this).after(linkDiv);

				        link.click(function (event) {
				          event.preventDefault();
				          if (text.height() > maxheight) {
				              $(this).html(showText);
				              text.css('max-height', maxheight + 'px').addClass('oculto');
				          } else {
				              $(this).html(hideText);
				              text.css('max-height', '10000px').removeClass('oculto');
				          }
				        });
				    }       
				  });
				});
			</script>
	<?php }
}

add_filter( 'manage_users_sortable_columns', 'kyrya_make_registered_column_sortable' );
function kyrya_make_registered_column_sortable( $columns ) {
	return wp_parse_args( array( 
		'registrado' => 'reg',
		// 'activado' => 'act',
		 ), $columns );
	// return wp_parse_args( array( 'activado' => 'act' ), $columns );
}


add_action( 'pre_user_query', 'kyrya_pre_user_query', 1 );
function kyrya_pre_user_query( $query ) {
    global $wpdb, $current_screen;

    // Only filter in the admin
    if ( ! is_admin() )
        return;

    // Only filter on the users screen
    if ( ! ( isset( $current_screen ) && 'users' == $current_screen->id ) )
        return;
  
   	// echo '<pre>'; print_r($query); echo '</pre>';


	if ( !isset( $_GET['orderby'] ) ) {
		$query->query_orderby = 'ORDER BY user_registered DESC';
		return;
	}

    // We need the order - default is ASC
    $order = isset( $query->query_vars ) && isset( $query->query_vars[ 'order' ] ) && strcasecmp( $query->query_vars[ 'order' ], 'asc' ) == 0 ? 'ASC' : 'DESC';


    // Only filter if orderby is set to 'art'
    if ( 'reg' == $query->query_vars[ 'orderby' ] ) {
        // Order the posts by product count
        // $query->query_orderby = "ORDER BY ( SELECT COUNT(*) FROM {$wpdb->posts} products WHERE products.post_type = 'product' AND products.post_status = 'publish' AND products.post_author = {$wpdb->users}.ID ) {$order}";
    	$query->query_orderby = 'ORDER BY user_registered ' . $order;
    } elseif ( 'act' == $query->query_vars[ 'orderby' ] ) {
    	// $query->query_from .= " INNER JOIN {$wpdb->usermeta} m1 ON {$wpdb->users}.ID=m1.user_id AND (m1.meta_key='active')";
    	$query->query_from .= " INNER JOIN {$wpdb->usermeta} m1 ON {$wpdb->users}.ID=m1.user_id AND (m1.meta_key='active')";
        $query->query_orderby = ' ORDER BY UPPER(m1.meta_value) '. $order;
    }

}
?>