<?php
/**
 * Understrap functions and definitions
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$placeholder_id = get_theme_mod( 'placeholder_id', 19 );
$download_form_id = get_theme_mod( 'download_form_id', 95 );
$fichas_page_id = get_theme_mod( 'fichas_page_id', 25 );
$orders_page_id = get_theme_mod( 'orders_page_id', 10309 );
$categoria_catalogos_id = get_theme_mod( 'categoria_catalogos_id', 11 );

// define('CONTACTO_ID', apply_filters( 'wpml_object_id', 17, 'page' ) );
define('PLACEHOLDER_ID', $placeholder_id );
define('ID_FORMULARIO_DESCARGA', $download_form_id );
define('ID_PAGINA_FICHAS', $fichas_page_id );
define('ID_PAGINA_PEDIDOS', apply_filters( 'wpml_object_id', $orders_page_id, 'page', TRUE ) );
define('CATEGORIA_CATALOGOS', apply_filters( 'wpml_object_id', $categoria_catalogos_id, 'dlm_download_category', TRUE  ) );

$understrap_includes = array(
    '/theme-settings.php',                  // Initialize theme default settings.
    '/setup.php',                           // Theme setup and custom theme supports.
    '/widgets.php',                         // Register widget area.
    '/enqueue.php',                         // Enqueue scripts and styles.
    '/template-tags.php',                   // Custom template tags for this theme.
    '/pagination.php',                      // Custom pagination for this theme.
    '/hooks.php',                           // Custom hooks.
    '/extras.php',                          // Custom functions that act independently of the theme templates.
    '/customizer.php',                      // Customizer additions.
    '/custom-comments.php',                 // Custom Comments file.
    '/jetpack.php',                         // Load Jetpack compatibility file.
    '/class-wp-bootstrap-navwalker.php',    // Load custom WordPress nav walker.
    '/woocommerce.php',                     // Load WooCommerce functions.
    '/editor.php',                          // Load Editor functions.
    '/deprecated.php',                      // Load deprecated functions.
    '/post-types.php',
    '/shortcodes.php',
    // '/dummy-content.php',
    '/seo.php',
    '/members.php',
    '/facetwp.php',
);

foreach ( $understrap_includes as $file ) {
    $filepath = locate_template( 'inc' . $file );
    if ( ! $filepath ) {
        trigger_error( sprintf( 'Error locating /inc%s for inclusion', $file ), E_USER_ERROR );
    }
    require_once $filepath;
}

// add_action('wp_head', 'show_template');
function show_template() {
    // if (is_user_logged_in()) {
        global $template;
            // echo '<div style="position:absolute;top:30%;">';
            echo '<div>';
            echo 'Plantilla: ';
            print_r($template);
            echo '</div>';
    // }
}


$content_width = 1140;
add_theme_support('editor-styles');
add_filter( 'widget_text', 'do_shortcode');
add_filter( 'wpcf7_form_elements', 'do_shortcode' );
function understrap_wpdocs_theme_add_editor_styles() {
    add_editor_style( 'css/custom-editor-style.css' );
}

add_action( 'after_setup_theme', 'editor_color_palette' );
function editor_color_palette() {

    $colores = array(
        array(
            'nombre'    => 'Primary',
            'valor'     => '#014CD5',
        ),
        array(
            'nombre'    => 'Secondary',
            'valor'     => '#75be81',
        ),
        array(
            'nombre'    => 'Purple',
            'valor'     => '#3182B8',
        ),
        array(
            'nombre'    => 'Yellow',
            'valor'     => '#F2E8C6',
        ),
        array(
            'nombre'    => 'Cyan',
            'valor'     => '#BDE0F4',
        ),
        array(
            'nombre'    => 'White',
            'valor'     => '#ffffff',
        ),
        array(
            'nombre'    => 'Light',
            'valor'     => '#E2F1F1',
        ),
        array(
            'nombre'    => 'Gray',
            'valor'     => '#6F6B61',
        ),
        array(
            'nombre'    => 'Gray Dark',
            'valor'     => '#1D1E1D',
        ),
        array(
            'nombre'    => 'Black',
            'valor'     => '#000000',
        ),
        array(
            'nombre'    => 'Dark',
            'valor'     => '#1B262C',
        ),
    );

    $colores_atts = array();
    foreach ($colores as $color) {
        $colores_atts[] = array(
            'name'      => $color['nombre'] . ' ' . $color['valor'],
            'slug'      => sanitize_title_with_dashes( $color['nombre'] ),
            'color'     => $color['valor'],
        );
    }

    add_theme_support( 'editor-color-palette', $colores_atts );
}


function author_page_redirect() {
    if ( is_author() ) {
        wp_redirect( home_url() );
    }
}
add_action( 'template_redirect', 'author_page_redirect' );

add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
    if (!current_user_can('edit_posts') && !is_admin()) {
        show_admin_bar(false);
    }
}

function es_blog() {

    if( is_singular('post') || is_category() || is_tag() || ( is_home() && !is_front_page() ) ) {
        return true;
    }

    return false;
}

add_filter( 'theme_mod_understrap_sidebar_position', 'cargar_sidebar');
function cargar_sidebar( $valor ) {
    global $wp_query;
    if ( es_blog() ) {
        $valor = 'right';
    }
    return $valor;
}

add_action( 'wp_body_open', 'top_anchor');
function top_anchor() {
    echo '<div id="top">';
}

add_action( 'wp_footer', 'back_to_top' );
function back_to_top() {
    echo '<a href="#top" class="back-to-top"></a>';
}

add_filter('body_class', 'wpml_body_class');
function wpml_body_class($classes) {
    // if(defined( 'ICL_LANGUAGE_CODE' )) $classes[] = ICL_LANGUAGE_CODE;
    $lang_class = apply_filters( 'wpml_current_language', NULL );
    if(!$lang_class) $lang_class = 'es';
    $classes[] = $lang_class;
    return $classes;
}

// PRO
// Envía notificaciones extra cuando se registra un usuario
add_filter( 'wpmem_notify_addr', 'kyrya_notificaciones_registro' );
function kyrya_notificaciones_registro( $email ) {
 
    // single email example
    $email = 'info@kyrya.es';
     
    // multiple emails example
    // $email = 'notify1@mydomain.com, notify2@mydomain.com';
     
    // take the default and append a second address to it example:
    // $email = $email . ', info@kyrya.es';
     
    // return the result
    return $email;
}

// PRO
function get_estado_usuario() {
    if (is_user_logged_in()) {
        $mi_perfil_id = 253;
        $link_perfil = get_permalink( $mi_perfil_id );
        return do_shortcode( '<strong><a href="'.$link_perfil.'" title="'.get_the_title( $mi_perfil_id ).'">[wpmem_field user_login]</a></strong>: [wpmem_logout url="'.get_permalink().'"]' . __( 'Cerrar sesión', 'kyrya' ) . '[/wpmem_logout]' );
    }
    return false;
}

// PRO
add_action( 'init', 'restringir_acceso_al_admin' );
function restringir_acceso_al_admin() {
    if ( is_user_logged_in() && is_admin() && ! current_user_can( 'edit_posts' ) && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
        wp_redirect( home_url() );
        exit;
    }
}

function kyrya_placeholder_url() {
    return get_stylesheet_directory_uri() . '/img/kyrya-placeholder.jpg';
}


if ( ! function_exists( 'get_current_page_url' ) ) {
    function get_current_page_url() {
      global $wp;
      return add_query_arg( $_SERVER['QUERY_STRING'], '', home_url( $wp->request ) );
    }
}


// PRO
add_action( 'template_redirect', 'pro_search_redirect');
function pro_search_redirect() {

    if( isset($_GET['wpessid']) && $_GET['wpessid'] == 4448 ) {
        return;
    }

    if( !is_user_logged_in() && ( isset($_GET['f']) || is_search() ) ) {
        $url = add_query_arg( array(
                'redirect_to'       => get_current_page_url(),
            ),  wpmem_login_url() );

        echo $url;
        wp_redirect( $url ); 
        exit();     
    }

    // Si está establecido el parámetro "f" en la url, redirige al Área Pro
    // De este modo se puede usar una url más sencilla para las búsquedas: https://kyrya.es?f=cuadro

    if ( is_user_logged_in() && isset($_GET['f']) ) {

        // Redirecciona automáticamente al idioma correspondiente según el idioma del navegador del visitante
        $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        do_action( 'wpml_switch_language', $lang );
        // $page_id = apply_filters( 'wpml_object_id', AREA_PROFESIONAL, 'page', true, $lang );
        // $base_url = get_the_permalink( $page_id );
        $base_url = get_home_url();

        // Establece parámetros UTM por defecto para medición si no vienen en la url
        $utm_source = ( isset($_GET['utm_source']) ) ? $_GET['utm_source'] : 'Tarifa interactiva';
        $utm_medium = ( isset($_GET['utm_medium']) ) ? $_GET['utm_medium'] : 'Enlace en tarifa pdf';
        $utm_campaign = ( isset($_GET['utm_campaign']) ) ? $_GET['utm_campaign'] : 'Tarifa Kyrya 2021 - idioma: ' . $lang;
        $utm_term = $_GET['f'];

        // Crea la url con el parámetro de búsqueda y los UTM y redirige
        $url = add_query_arg( array(
                                's'         => $_GET['f'],
                                'utm_source'        => $utm_source,
                                'utm_medium'        => $utm_medium,
                                'utm_campaign'      => $utm_campaign,
                                'utm_term'          => $utm_term,
                            ), $base_url );
        wp_redirect( $url ); 
        exit; 
    }   
}



add_filter('post-types-order_save-ajax-order', 'sincronizar_menu_order_wpml', 10, 3);
function sincronizar_menu_order_wpml($data, $key, $id) {
    $languages = apply_filters( 'wpml_active_languages', NULL, 'orderby=id&order=desc' );
    global $wpdb;

    if ( !empty( $languages ) ) {
        foreach( $languages as $l ) {
            $post = get_post($id);
            $id =  apply_filters( 'wpml_object_id', $id, $post->post_type, FALSE, $l['language_code'] );
            $wpdb->update( $wpdb->posts, $data, array('ID' => $id) );
  
        }
    }

    return $data;
}


add_action('tto/update-order', 'sincronizar_term_order_wpml', 20);
function sincronizar_term_order_wpml() {
    $languages = apply_filters( 'wpml_active_languages', NULL, 'orderby=id&order=desc' );
    global $wpdb;

    if ( !empty( $languages ) ) {

        $data               = stripslashes($_POST['order']);
        $unserialised_data  = json_decode($data, TRUE);

        foreach( $languages as $l ) {

            if (is_array($unserialised_data))
            foreach($unserialised_data as $key => $values ) {
                //$key_parent = str_replace("item_", "", $key);
                $items = explode("&", $values);
                unset($item);
                foreach ($items as $item_key => $item_)
                    {
                        $items[$item_key] = trim(str_replace("item[]=", "",$item_));
                    }
                
                if (is_array($items) && count($items) > 0)
                foreach( $items as $item_key => $term_id ) 
                    {
                        $term = get_term($term_id);
                        $term_id =  apply_filters( 'wpml_object_id', $term_id, $term->taxonomy, FALSE, $l['language_code'] );
                        $wpdb->update( $wpdb->terms, array('term_order' => ($item_key + 1)), array('term_id' => $term_id) );
                    } 
            }
  
        }
    }

}

// PRO
function get_boton_login( $btn_color = 'white' ) {

    if( is_user_logged_in() ) {

        $r = '';

        $r .= '<div class="navbar-expand">';

        $r .= '<div class="dropdown show">';

            // $r .= '<a href="'.wpmem_profile_url().'" class="btn btn-'.$btn_color.' btn-sm mr-2"><i class="fa fa-user mr-2"></i>'.do_shortcode( '[wpmem_field user_login]' ) .'</a> <a href="'.get_home_url().'/?a=logout" class="btn btn-outline-'.$btn_color.' btn-sm"><i class="fa fa-close mr-2"></i>'. __( 'Log out' ) .'</a>';

            $r .= '<a href="#" role="button" class="btn btn-'.$btn_color.' btn-sm dropdown-toggle" id="dropdownUserMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user mr-2"></i>'.do_shortcode( '[wpmem_field user_login]' ) .'</a>';

  //           $r .= '  <div class="dropdown-menu" aria-labelledby="dropdownUserMenuLink">
  //   <a class="dropdown-item" href="#">Action</a>
  //   <a class="dropdown-item" href="#">Another action</a>
  //   <a class="dropdown-item" href="#">Something else here</a>
  // </div>';

            $r .= wp_nav_menu(
                        array(
                            'theme_location'  => 'pro',
                            'container_class' => 'navbar-nav',
                            'container_id'    => 'user-menu-container',
                            'menu_class'      => 'dropdown-menu',
                            'fallback_cb'     => '',
                            'menu_id'         => 'user-menu',
                            'depth'           => 2,
                            'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
                            'echo'            => false,
                        )
                    );

        $r .= '</div>';

        return $r;
    }

    return '<a href="'.wpmem_register_url().'" class="btn btn-outline-'.$btn_color.' btn-sm mr-2"><i class="fa fa-user mr-2"></i>'. __( 'Solicitar alta','kyrya' ) .'</a> <a href="'.wpmem_login_url( get_current_page_url() ).'" class="btn btn-'.$btn_color.' btn-sm"><i class="fa fa-user mr-2"></i>'. __( 'Log in' ) .'</a>';

}

// PRO
// add_action('wp_head', 'modificar_titulos_descargas');
function modificar_titulos_descargas() {
    if (current_user_can( 'manage_options' ) && (1 == get_current_user_id() ) ) {
        $args = array(
                'post_type' => 'dlm_download',
                'posts_per_page'    => -1,
            );

        $posts = get_posts( $args );

        echo count($posts) . '<br>';
        $i = 0;

        foreach ($posts as $post ) {
            $i++;
            $titulo = get_the_title( $post->ID );
            // $nuevo_titulo = str_replace('-', ' ', $titulo);
            // $nuevo_titulo = str_replace('_', ' ', $nuevo_titulo);
            $nuevo_titulo = str_replace('V01 2', '', $titulo);


            if ($titulo != $nuevo_titulo) {

                echo $i . ' - ' . $titulo . ' - ' . $nuevo_titulo . '<br>';

                $nuevo_post = array(
                        'ID' => $post->ID,
                        'post_title' => $nuevo_titulo,
                    );

                $post_id = wp_update_post( $nuevo_post, true );
                if (is_wp_error($post_id)) {
                    $errors = $post_id->get_error_messages();
                    foreach ($errors as $error) {
                        echo $error;
                    }
                }
            }
        }
    }
}

// PRO
add_filter( 'the_title', 'mostrar_descarga_version', 10, 2);
function mostrar_descarga_version( $title, $post_id)  {
    if ('dlm_download_version' != get_post_type( $post_id ) ) return $title;

    $parent_id = wp_get_post_parent_id( $post_id );
    $version = get_post_meta( $post_id, '_version', true );
    return get_the_title( $parent_id ) . ' - ' . $title . ' (v: '.$version.')';
}

add_filter( 'single_post_title', 'traducir_solo_titulo', 10, 2 );
add_filter( 'the_title', 'traducir_solo_titulo', 10, 2 );
function traducir_solo_titulo( $title, $post ) {
    if (is_object($post)) {
        $post_id = $post->ID;
    } else {
        $post_id = $post;
    }

    $traducciones = get_post_meta( $post_id, 'traduccion_titulo', true );
    
    if ($traducciones ) {
        $traducciones_array = preg_split('/\r\n|[\r\n]/', $traducciones);
        $traducciones_codes_array = array();
        foreach ($traducciones_array as $trad_item) {
            $temp = explode(':', $trad_item);

            if (count($temp) > 1) {
                $code = trim( $temp[0] );
                if ( $code == 'pt') { $code = 'pt-pt'; }
                $traducciones_codes_array[$code] = trim( $temp[1] );
            }
        }

        if (isset($traducciones_codes_array[apply_filters( 'wpml_current_language', NULL )])) {
            $title = $traducciones_codes_array[apply_filters( 'wpml_current_language', NULL )];
        }
    }
    return $title;
}

add_filter( 'parse_tax_query', function ( $query ) {
    if ( 
        !is_admin() 
        && $query->is_main_query()
        && $query->is_tax()
    ) {
        $query->tax_query->queries[0]['include_children'] = 0;
    }
});

// PRO
// add_action( 'wpmem_account_validation_success', 'kyrya_anadir_suscriptor_createsend' );
add_action( 'user_register', 'kyrya_anadir_suscriptor_createsend' );
function kyrya_anadir_suscriptor_createsend( $user_id ) {

    $user_data = get_userdata( $user_id );
    $user_meta = get_user_meta( $user_id );

    // print_r($user_data);
    // print_r($user_meta);

    $email = $user_data->user_email;
    $name = $user_meta['first_name'][0];
    if( isset($user_meta['last_name'][0]) && $user_meta['last_name'][0] ) $name .= ' ' . $user_meta['last_name'][0];
    $CustomFields[] ="";
    $CustomFields[] = array('Key'=>'País', 'Value'=>$user_meta['billing_country'][0] );

    $subscribe = ( $user_meta['newsletter'][0] == 1) ? true : false;


    if($subscribe){

        try {


                $apiKey = '9ab9d43e61d544ee50703b68082332a078ab65d7844e76a2';
                $listId = 'cb5dfdc8ae3b21a9f5d2be59b69e15d3'; // Suscriptores desde el registro Kyrya Pro

                $subscriber = array(
                    'EmailAddress' => $email,
                    'Name' => $name,
                    'CustomFields' => $CustomFields,
                    'Resubscribe' => true,
                    'RestartSubscriptionBasedAutoresponders' => true,
                    'ConsentToTrack' => 'Yes' );

                $url = sprintf('https://api.createsend.com/api/v3.2/subscribers/%s.json', $listId);

                $vc_headers = array(
                                            'headers' => array(
                                                            'Authorization' => 'Basic ' . base64_encode($apiKey . ':x')
                                                                                ),
                                            'body' => wp_json_encode($subscriber)
                                                 );

                $resultsend = wp_remote_post($url, $vc_headers );

                $resultfinal = $resultsend;

                $cme_db_log = new cme_db_log( 'cme_db_issues',  $logfileEnabled,'api',$idform );
                $cme_db_log->cme_log_insert_db(1, 'Subscribe Response: ' , $resultfinal  );

        } catch ( Exception $e ) {

            $cme_db_log = new cme_db_log( 'cme_db_issues' , $logfileEnabled,'api',$idform );
            $cme_db_log->cme_log_insert_db(4, 'Contact Form 7 response: Try Catch  ' . $e->getMessage()  , $e  );

        }  
    }
}


// PRO
function kyrya_pro_search_shortcode() {

    // return false;

    // kyrya_pro_search_scripts();
    $pro_search_value = (isset($_GET['prosearch'])) ? $_GET['prosearch'] : '';

    ob_start(); ?>

    <div class="pro-search-wrapper bg-light">

        <h4><?php echo __( 'Buscador de fichas técnicas', 'kyrya' ); ?></h4>
        <div id="kyrya-pro-search">
            <form action="" method="get">
                <div class="input-group">
                    <input class="field form-control" type="text" name="prosearch" id="prosearch" value="" placeholder="<?php echo __( 'Buscar por código o nombre de producto...', 'kyrya' ); ?>">

                    <span class="input-group-btn">
                        <input class="btn btn-primary" type="submit" id="submit" name="submit" value="<?php echo __( 'Buscar', 'kyrya' ); ?>">
                    </span>
                </div>
            </form>

            <ul id="kyrya-pro-search-results" class="dlm-downloads"></ul>
        </div>

    </div>
     
    <?php
    return ob_get_clean();
}
add_shortcode ('kyrya_pro_search', 'kyrya_pro_search_shortcode');





add_filter( 'dlm_cpt_dlm_download_args', 'modificar_post_type_dlm_download', 10, 1 );
function modificar_post_type_dlm_download( $args ) {

    if(!is_user_logged_in()) {
        $args['exclude_from_search'] = true;
    } else {
        $args['public'] = true;
        $args['publicly_queriable'] = true;
        // $args['has_archive'] = __( 'downloads', 'kyrya' );
    }
    $args['description'] = false;
    $args['show_in_nav_menus'] = true;
    // $args['taxonomies'] = array_merge( $args['taxonomies'], array( 'marca', 'tipo-descarga') );
    // echo '<pre>'; print_r($args); echo '</pre>';
    
    return $args;
}


function remove_post_type_page_from_search() {
    global $wp_post_types;
    $wp_post_types['post']->exclude_from_search = true;
    $wp_post_types['page']->exclude_from_search = true;
}
add_action('init', 'remove_post_type_page_from_search');

add_filter( 'dlm_download_category_args', 'modificar_taxonomias_dlm_download', 10, 1 );
add_filter( 'dlm_download_tag_args', 'modificar_taxonomias_dlm_download', 10, 1 );
function modificar_taxonomias_dlm_download( $args ) {
    $args['show_in_nav_menus'] = true;
    // echo '<pre>'; print_r($args); echo '</pre>';
    return $args;
}

add_filter( 'dlm_shortcode_downloads_args', 'modificar_shortcode_descargas', 10, 2);
function modificar_shortcode_descargas( $args, $atts ) {
    // echo '<pre>'; print_r($args); echo '</pre>';
    // echo '<pre>'; print_r($atts); echo '</pre>';

    if(!is_user_logged_in()) {
        $args['meta_query'][] = array(
            'key'       => '_members_only',
            'value'     => 'yes',
            'compare'   => '!=',
        );
    }
    return $args;
}

// Replace Posts label as Articles in Admin Panel 
function change_post_menu_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = __( 'Avisos', 'kyrya-admin' );
    $submenu['edit.php'][5][0] = __( 'Avisos', 'kyrya-admin' );
    $submenu['edit.php'][10][0] = __( 'Añadir Avisos', 'kyrya-admin' );
    echo '';
}
function change_post_object_label() {
        global $wp_post_types;
        $labels = &$wp_post_types['post']->labels;
        $labels->name = __( 'Avisos', 'kyrya' );
        $labels->singular_name = __( 'Aviso', 'kyrya' );
        $labels->add_new = __( 'Añadir Aviso', 'kyrya-admin' );
        $labels->add_new_item = __( 'Añadir Aviso', 'kyrya-admin' );
        $labels->edit_item = __( 'Editar Aviso', 'kyrya-admin' );
        $labels->new_item = __( 'Aviso', 'kyrya-admin' );
        $labels->view_item = __( 'Ver Aviso', 'kyrya-admin' );
        $labels->search_items = __( 'Buscar Avisos', 'kyrya-admin' );
        $labels->not_found = __( 'No se han encontrado Avisos', 'kyrya-admin' );
        $labels->not_found_in_trash = __( 'No se han encontrado Avisos en la papelera', 'kyrya-admin' );
}
add_action( 'init', 'change_post_object_label' );
add_action( 'admin_menu', 'change_post_menu_label' );



add_filter('get_terms', 'hide_catalogos_terms', 10, 4);
function hide_catalogos_terms( $terms, $taxonomies, $args, $term_query ) {

    if ( is_admin() ) return $terms; 
    
    // list of category slug to exclude, 
    $exclude = array( CATEGORIA_CATALOGOS );

    foreach($terms as $key => $term){

        if( is_int( $term ) ) {

            if( in_array( $term, $exclude ) ) unset($terms[$key]);

        } else {

            if( in_array( $term->term_id, $exclude ) ) unset($terms[$key]);

        }

    }
    
    return $terms;
}


function get_subcategorias( $taxonomy = 'dlm_download_category', $post_type = 'dlm_download' ) {

    // if ( function_exists( 'facetwp_display') ) return false;

    $parent_id = 0;
    if( is_tax() ) $parent_id = get_queried_object_id();
    $terms = get_terms( $taxonomy, array('parent' => $parent_id) );

    if ( $terms ) {

        echo '<div class="subcategorias mb-4">';

            foreach ( $terms as $term ) {
                echo '<a href="'.get_term_link( $term ).'" class="btn btn-dark btn-lg mr-3 mb-3">' . $term->name . '</a>';
            }

        echo '</div>';

    }

}

// add_filter( 'wpmem_register_links_args', 'cambiar_estilos_listas_wp_members' );
add_filter( 'wpmem_member_links_args', 'cambiar_estilos_listas_wp_members' );
add_filter( 'wpmem_login_links_args', 'cambiar_estilos_listas_wp_members' );
add_filter( 'wpmem_status_links_args', 'cambiar_estilos_listas_wp_members' );
function cambiar_estilos_listas_wp_members( $arr ) {

    $arr['wrapper_before'] = '<ul class="list-group">';
    if(isset($arr['rows'])) {
        foreach ($arr['rows'] as $key => $row) {
            $arr['rows'][$key] = str_replace('<li>', '<li class="list-group-item">', $row);
        }
    }

    return $arr;
}

add_filter( 'wpmem_login_form_args', 'estilo_botones_wp_members', 10, 2 );
add_filter( 'wpmem_register_form_args', 'estilo_botones_wp_members', 10, 2 );
function estilo_botones_wp_members( $defaults, $action) {
    $defaults['button_class'] = 'btn btn-primary btn-lg';

    return $defaults;
}

function get_datos_usuario_footer() {
    if(!is_user_logged_in()) return false;
    $user_id = get_current_user_id();
    $nombre = get_user_meta( $user_id, 'first_name', true );
    $empresa = get_user_meta( $user_id, 'empresa', true );
    if( $empresa ) $nombre .= ' ('.$empresa.')';
    $id_cliente = get_user_meta( $user_id, 'codigo_cliente', true );

    $r = '';

    $r .= sprintf( __( 'You are logged in as %s', 'wp-members' ), $nombre );

    if( $id_cliente) $r .= ' / #' . $id_cliente;

    $r .= ' · ' . do_shortcode( '[wpmem_logout]' . __( 'Log out' ) . '[/wpmem_logout]' );

    return $r; 

}
function datos_usuario_footer() {
    echo get_datos_usuario_footer();
}

function is_restricted_tax() {

    if( is_tax( array('dlm_download_category', 'dlm_download_tag', 'marca' ) )) {
        return true;
    }

    return false;
}

// Añade una pantalla de pedidos en el área de usuario
add_filter( 'wpmem_member_links_args', 'kyrya_members_pedidos' );
function kyrya_members_pedidos( $arr ) {
    
    $orders_row = '<li class="list-group-item"><a href="' . esc_url( get_permalink( ID_PAGINA_PEDIDOS ) ) . '">' . get_the_title( ID_PAGINA_PEDIDOS ) . '</a></li>';

    array_unshift( $arr['rows'], $orders_row );

    return $arr;
}

add_action('init', 'kyrya_create_roles');
function kyrya_create_roles() {
    global $wp_roles;
    if ( ! isset( $wp_roles ) )
        $wp_roles = new WP_Roles();

    $adm = $wp_roles->get_role('subscriber');

    $wp_roles->add_role('agente', 'Agente comercial', $adm->capabilities);
}

function kyrya_user_is_agente() {
    $user = wp_get_current_user();
    if ( in_array( 'agente', (array) $user->roles ) ) {
        $agente_id = get_user_meta( $user->ID, 'numero_agente', true );
        if ( $agente_id ) return $agente_id;
    }

    return false;
}

function kyrya_user_is_cliente() {
    $user = wp_get_current_user();
    if ( in_array( 'cliente', (array) $user->roles ) ) {
        $cif = get_user_meta( $user->ID, 'cif', true );
        if ( $cif ) return $cif;
    }

    return false;
}


function get_user_orders( $cif = false, $agent_id = false ) {

    $r = '';

    $user = wp_get_current_user();

    if ( !$user ) return __( 'Inicie sesión para ver sus pedidos', 'kyrya' );

    if ( in_array( 'agente', (array) $user->roles ) ) {
        
        $agente_id = get_user_meta( $user->ID, 'numero_agente', true );
        
        if ( !$agente_id ) {
            return __( 'No se han encontrado pedidos. Compruebe su número de agente', 'kyrya' );
        }

        $curlopt_url = 'https://xvlflc76dj.execute-api.us-east-1.amazonaws.com/queryOrderAgent';
        $curlopt_postfields = '{"IDUnicAgent": "'.$agente_id.'"}';

        $r .= wpautop( sprintf( __( 'Pedidos para el agente %s', 'kyrya' ), $agente_id ) );

    } elseif( in_array( 'cliente', (array) $user->roles ) ) {

        $cif = get_user_meta( $user->ID, 'cif', true );
        if ( !$cif ) return __( 'Su CIF/VAT Number no está definido. Por favor revise su perfil o contacte con Kyrya', 'kyrya' );

        $curlopt_url = 'https://wei0zvbew4.execute-api.us-east-1.amazonaws.com/getOrders';
        $curlopt_postfields = '{"CIF": "'.$cif.'"}';

        $r .= wpautop( sprintf( __( 'Pedidos para el cliente con CIF %s', 'kyrya' ), $cif ) );

    } else {
        
        return __( 'No tiene permisos para ver esta página.', 'kyrya' );

    }



      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => $curlopt_url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_POSTFIELDS => $curlopt_postfields,
        CURLOPT_HTTPHEADER => array(
          'Content-Type: text/plain'
        ),
      ));
      
      $response_json = curl_exec($curl);
      $response = json_decode( $response_json );
      
      curl_close($curl);
      
    //  if ( current_user_can( 'manage_options' ) ) :
        // echo '<pre>';
        //     print_r ( $response );
        // echo '</pre>';
    //  endif;

    if ( isset($response->errorType) ) return __( 'Ha ocurrido un error. Inténtelo de nuevo más tarde.', 'kyrya' ) . ' - ' . $response['errorType'];

    if ( !isset($response->ok) || !$response->ok ) return __( 'Ha ocurrido un error. Inténtelo de nuevo más tarde.', 'kyrya' );

    if ( is_array( $response ) || is_object( $response ) ) {

            $string_map = array(
                'FiscalName'         => __( 'Razón social', 'kyrya'),
                'CompanyName'        => __( 'Empresa', 'kyrya'),
                'Customerreference'  => __( 'Referencia', 'kyrya'),
                'CustomerReference'  => __( 'Referencia', 'kyrya'),
                'ShipmentID'         => __( 'Referencia', 'kyrya'),
                'OrderID'            => __( 'Nº de pedido', 'kyrya'),
                'State'              => __( 'Estado', 'kyrya'),
                'ShipmentDate'       => __( 'Fecha de envío', 'kyrya'),
                'Comments'           => __( 'Comentarios', 'kyrya'),
                'Tracking'           => __( 'Seguimiento', 'kyrya'),
            );

            $pedidos = $response->data->result;

            if ( 204 == $response->code ) return __( 'Su CIF/VAT Number no se encuentra en nuestra base de datos. Por favor revise su perfil o contacte con Kyrya', 'kyrya' );
            if ( empty($pedidos) ) return __( 'No tiene pedidos asignados', 'kyrya' );

            $r .= '<div class="table-responsive">';

                $r .= '<table class="table table-striped">';

                $r .= '<thead>';

                    $r .= '<tr>';

                        $obj_vars = get_object_vars( $pedidos[0] );
                        $props = array_keys( $obj_vars );
        
                        foreach ( $props as $prop_name ) {

                            $title = $prop_name;
                            if ( isset( $string_map[$prop_name] ) ) $title = $string_map[$prop_name];

                            $r .= '<th class="'. sanitize_title( $prop_name ) .'">'. $title.'</th>';

                        }

                    $r .= '</tr>';

                $r .= '</thead>';

                $r .= '<tbody>';

                    foreach ( $pedidos as $key => $obj ) {

                        $r .= '<tr>';

                            foreach ( $props as $prop_name ) {

                                $value = $obj->$prop_name;

                                switch ($prop_name) {
                                    case 'Tracking':
                                        
                                        if( filter_var($value, FILTER_VALIDATE_URL) ) {
                                            $value = '<a class="btn btn-sm btn-outline-primary" href="'.$value.'" target="__blank">'. __( 'Ver seguimiento', 'kyrya' ) .'</a>';
                                        }
                                        
                                        break;

                                    case 'ShipmentDate':
                                    
                                        if( $value ) {
                                            $value = date('Y-m-d', strtotime( $value) );
                                        }

                                        break;
                                    
                                    case 'ShipmentID':
                                
                                        if( 'undefined' == $value ) {
                                            $value = '';
                                        }

                                        break;
                                        

                                    default:
                                        $value = $obj->$prop_name;
                                        break;
                                }

                                $r .= '<td class="'. sanitize_title( $prop_name ) .'">'. $value .'</td>';

                            }

                        $r .= '</tr>';

                    }

                $r .= '</table>';

            $r .= '</div>';

        }

    return $r;

}

function user_orders( $cif = false ) {
    echo get_user_orders( $cif );
}

add_action( 'save_post', 'kyrya_save_search_term_post_meta' );
function kyrya_save_search_term_post_meta( $post_id ) {

	if ( wp_is_post_revision( $post_id ) ) {
		return;
        }

	$terms = wp_get_post_terms( $post_id, 'dlm_download_category' );
    $terms_array = array();

    foreach( $terms as $term ) {

        $active_languages = apply_filters( 'wpml_active_languages', NULL, 'orderby=id&order=desc' );

        foreach ( $active_languages as $lang_code => $lang ) {

            $translated_id = apply_filters( 'wpml_object_id', $term->term_id, 'dlm_download_category', FALSE, $lang_code );
            $terms_array[] = get_term( $translated_id )->name;

        }

    }

    update_post_meta( $post_id, 'search_terms', implode(' ', $terms_array ) );
    
}

