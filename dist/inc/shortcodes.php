<?php 
function contenido_pagina($atts) {
	extract( shortcode_atts(
		array(
				'id' 	=> 0,
				'imagen'	=> 'no',
				'dominio'	=> false,

		), $atts)	
	);
	if ($dominio) {
		$api_url = $dominio . '/wp-json/wp/v2/pages/' . $id;
		$data = wp_remote_get( $api_url );
		$data_decode = json_decode( $data['body'] );

		// echo '<pre>'; print_r($data_decode); echo '</pre>';

		$content = $data_decode->content->rendered;
		return $content;
	} else {
		if ( 0 != $id) {
			$content_post = get_post($id);
			$content = $content_post->post_content;
			$content = '<div class="post-content-container">'.apply_filters('the_content', $content) .'</div>';
			if ('si' == $imagen) {
				$content = '<div class="entry-thumbnail">'.get_the_post_thumbnail($id, 'full') . '</div>' . $content;
			}
			return $content;
		}
	}
}
add_shortcode('contenido_pagina','contenido_pagina');

function home_url_shortcode() {
	return get_home_url();
}
add_shortcode('home_url','home_url_shortcode');

function theme_url_shortcode() {
	return get_stylesheet_directory_uri();
}
add_shortcode('theme_url','theme_url_shortcode');

function uploads_url_shortcode() {
	$upload_dir = wp_upload_dir();
	$uploads_url = $upload_dir['baseurl'];
	return $uploads_url;
}
add_shortcode('uploads_url','uploads_url_shortcode');

function year_shortcode() {
  $year = date('Y');
  return $year;
}
add_shortcode('year', 'year_shortcode');

function term_link_sh( $atts ) {
	extract( shortcode_atts(
		array(
				'id' 	=> 0,
		), $atts)	
	);
	$id = intval($id);
	return get_term_link( $id );
}
add_shortcode('cat_link', 'term_link_sh');

function post_link_sh( $atts ) {
	extract( shortcode_atts(
		array(
				'id' 	=> 0,
		), $atts)	
	);
	$id = intval($id);
	return get_the_permalink( $id );
}
add_shortcode('post_link', 'post_link_sh');

// Link Sumun
function link_sumun( $atts ) {

	// Attributes
	extract( shortcode_atts(
		array(
			'texto' => 'Diseño web: Sumun.net',
			'url'	=> 'https://sumun.net',
		), $atts )
	);

    $link = '<a href="'.$url.'" target="_blank">'.$texto.'</a>';
    if (is_front_page()) {
        return $link;
    }
    return $texto;
}
add_shortcode( 'link_sumun', 'link_sumun' );

function paginas_hijas() {
	global $post;
	if ( is_post_type_hierarchical( $post->post_type ) /*&& '' == $post->post_content */) {
		$args = array(
			'post_type'			=> array($post->post_type),
			'posts_per_page'	=> -1,
			'post_status'		=> 'publish',
			'orderby'			=> 'menu_order',
			'order'				=> 'ASC',
			'post_parent'		=> $post->ID,
		);
		$r = '';
		$query = new WP_Query($args);
		if ($query->have_posts() ) {
			$r .= '<div class="contenido-adicional mt-5">';
			// $r .= '<h3>'.__( 'Contenido en', 'sumun' ).' "'.$post->post_title.'"</h3>';
			// $r .= '<ul>';
			while($query->have_posts() ) {
				$query->the_post();
				// $r .= '<li>';
					$r .= '<a class="btn btn-primary btn-lg mr-2 mb-2 pagina-hija" href="'.get_permalink( get_the_ID() ).'" title="'.get_the_title().'" role="button" aria-pressed="false">'.get_the_title().'</a>';
				$r .= '</li>';
			}
			// $r .= '</ul>';
			// $r .= '</div>';
		} elseif(0 != $post->post_parent) {
			wp_reset_postdata();
			$current_post_id = get_the_ID();
			$args['post_parent'] = $post->post_parent;
			$query = new WP_Query($args);
			if ($query->have_posts() && $query->found_posts > 1 ) {
				$r .= '<div class="contenido-adicional">';
				while($query->have_posts() ) {
					$query->the_post();
					if ($current_post_id == get_the_ID()) {
						$r .= '<span class="btn btn-primary btn-sm mr-2 mb-2">'.get_the_title().'</span>';
					} else {
						$r .= '<a class="btn btn-outline-primary btn-sm mr-2 mb-2" href="'.get_permalink( get_the_ID() ).'" title="'.get_the_title().'" role="button" aria-pressed="false">'.get_the_title().'</a>';
					}
				}
				$r .= '</div>';
			}
		}
		wp_reset_postdata();
		return $r;
	}
}
add_shortcode( 'paginas_hijas', 'paginas_hijas' );

add_filter('the_content', 'mostrar_paginas_hijas', 100);
function mostrar_paginas_hijas($content) {
	global $post;
	if (is_admin() || !is_singular() || !in_the_loop() || is_front_page() ) return $content;
	global $post;
	if (has_shortcode( $post->post_content, 'paginas_hijas' )) return $content;

	return $content . paginas_hijas();

}

function get_redes_sociales() {

	$r = '';
	
    $redes_sociales = array(
        'email' => 'envelope',
        'whatsapp' => 'whatsapp',
        'linkedin' => 'linkedin',
        'twitter' => 'twitter',
        'facebook' => 'facebook',
        'instagram' => 'instagram',
        'youtube' => 'youtube',
        'skype' => 'skype',
        'pinterest' => 'pinterest',
        'flickr' => 'flickr',
        'blog' => 'rss',
    );
    $r .= '<div class="redes-sociales">';

    foreach ($redes_sociales as $red => $fa_class) {
    	$url = get_theme_mod( $red, '' );
    	if( '' != $url) {
	    	$r .= '<a href="'.$url.'" target="_blank" rel="nofollow" title="'.sprintf( __( 'Abrir %s en otra pestaña', 'sumun' ), $red ).'"><span class="red-social '.$red.' fa fa-'.$fa_class.'"></span></a>';
    	}
    }

    // $r .= '<span class="follow-us">' . __( 'Follow us', 'sumun' ) . '</span>';

    $r .= '</div>';

    return $r;

}
add_shortcode( 'redes_sociales', 'get_redes_sociales' );

function get_info_basica_privacidad() {

	$r = '';
	
	$text = get_theme_mod( 'info_privacidad_formularios', '' );
	if( '' != $text) {
		$r .= '<div class="info-basica-privacidad">';
	    	$r .= wpautop( $text );
		$r .= '</div>';
	}

    return $r;

}
add_shortcode( 'info_basica_privacidad', 'get_info_basica_privacidad' );

function sitemap() {
	$pt_args = array(
		'has_archive'		=> true,
	);
	$pts = get_post_types( $pt_args );
	// if (isset($pts['rl_gallery'])) unset $pts['rl_gallery'];
	$pts = array_merge( array('page'), $pts, array('post') );
	$r = '';

	foreach ($pts as $pt) {
		$pto = get_post_type_object( $pt );
		$taxonomies = get_object_taxonomies( $pt );

		$posts_args = array(
				'post_type'			=> $pt,
				'posts_per_page'	=> -1,
				'orderby'			=> 'menu_order',
				'order'				=> 'asc',
		);

		$posts_q = new WP_Query($posts_args);
		if ($posts_q->have_posts()) {

			$r .= '<h3 class="mt-3">'.$pto->labels->name.'</h3>';
			if ($taxonomies) {
				foreach ($taxonomies as $tax) {
					$terms = get_terms( array('taxonomy' => $tax) );
					foreach ($terms as $term) {
						$r .= '<a href="'.get_term_link( $term ).'" class="btn btn-dark btn-sm mr-1 mb-1">'.$term->name.'</a>';
					}
				}
			}

			while ($posts_q->have_posts()) { $posts_q->the_post();
				$r .= '<a href="'.get_the_permalink().'" class="btn btn-outline-primary btn-sm mr-1 mb-1">'.get_the_title().'</a>';
			}
		}

		wp_reset_postdata();
	}

	return $r;
}
add_shortcode( 'sitemap', 'sitemap' );

function testimonios() {
	ob_start();
	get_template_part( 'global-templates/carousel-testimonios' );
	$r = ob_get_clean();

	return $r;
}
add_shortcode( 'testimonios', 'testimonios' );

function sumun_get_reusable_block( $block_id = '' ) {
    if ( empty( $block_id ) || (int) $block_id !== $block_id ) {
        return;
    }
    $content = get_post_field( 'post_content', $block_id );
    return apply_filters( 'the_content', $content );
}

function sumun_reusable_block( $block_id = '' ) {
    echo sumun_get_reusable_block( $block_id );
}

function sumun_reusable_block_shortcode( $atts ) {
    extract( shortcode_atts( array(
        'id' => '',
    ), $atts ) );
    if ( empty( $id ) || (int) $id !== $id ) {
        return;
    }
    $content = advent_get_reusable_block( $id );
    return $content;
}
add_shortcode( 'reusable', 'sumun_reusable_block_shortcode' );

add_shortcode('buscador', 'get_search_form_descargas');
function get_search_form_descargas() {
	ob_start();
	get_template_part( 'wpes-searchform-2513' );
	return ob_get_clean();
}

add_shortcode('buscador_manuales', 'get_search_form_manuales');
function get_search_form_manuales() {
	ob_start();
	get_template_part( 'wpes-searchform-2508' );
	return ob_get_clean();
}

function shortcode_descarga_catalogos() {
    $r = '';
    $tax = 'dlm_download_category';
       
    $args = array(
        'post_type'     => 'dlm_download',
        'posts_per_page'  => -1,
        'fields'            => 'ids',
    );
    $args['tax_query'] = [[
            'taxonomy'  => $tax,
            'field'     => 'term_id',
            'terms'     => CATEGORIA_CATALOGOS,
    ]];
    $args['meta_query'] = [[
            'key' => '_members_only',
            'value'    => 'yes',
            'compare' => '!=',
    ]];

    $q = new WP_Query($args);

    if ( $q->have_posts() ) {
   	
       $r .= '<ul class="dlm-downloads">';
            $r .= '<div class="miniaturas-descargas d-none d-md-block">';
            	while ( $q->have_posts() ) { $q->the_post();

                	$id_descarga = get_the_ID();
                    if (has_post_thumbnail( $id_descarga )) $r .= get_the_post_thumbnail( $id_descarga, 'medium', array('class' => 'miniatura-descarga') );
                }
            $r .= '</div>';

            $r .= '[email-download download_id="'.implode(',', $q->posts).'" contact_form_id="'.ID_FORMULARIO_DESCARGA.'"]';
        
        $r .= '</ul>';

    }

    wp_reset_postdata();

    return do_shortcode($r);
}
add_shortcode( 'descarga_catalogos', 'shortcode_descarga_catalogos' );

function shortcode_descargas_destacadas(){
	$r = '<h2>' . __( 'Descargas destacadas', 'kyrya' ) . '</h2>';

	if( is_user_logged_in() ) {
		$r_downloads = do_shortcode( '[downloads featured="true" loop_start="<ul class=&quot;list-group&quot;>" before="<li class=&quot;list-group-item&quot;>"]' );
		if( $r_downloads ) {
			$r .= $r_downloads;
		} else {
			$r .= wpautop( __( 'No hay contenido en esta sección', 'kyrya' ) );
		}
	} else {
		$r .= get_boton_login( 'dark' );
	}

	return $r;
}
add_shortcode( 'descargas_destacadas', 'shortcode_descargas_destacadas' );


function shortcode_descargas_recientes(){
	$r = '<h2>' . __( 'Descargas recientes', 'kyrya' ) . '</h2>';

	if( is_user_logged_in() ) {
		$r_downloads = do_shortcode( '[downloads per_page="8" loop_start="<ul class=&quot;list-group&quot;>" before="<li class=&quot;list-group-item&quot;>"]' );
		if( $r_downloads ) {
			$r .= $r_downloads;
		} else {
			$r .= wpautop( __( 'No hay contenido en esta sección', 'kyrya' ) );
		}

	} else {
		$r .= get_boton_login( 'dark' );
	}

	return $r;
}
add_shortcode( 'descargas_recientes', 'shortcode_descargas_recientes' );

function shortcode_categorias_descargas() {
	$taxonomy = 'dlm_download_category';

	$r = '';

	$terms = get_terms( array('taxonomy' => $taxonomy, 'parent' => 0) );
	foreach ($terms as $term) {
		$r .= '<a href="'.get_term_link( $term ).'" class="btn btn-outline-dark mr-2 mb-2">'.$term->name.'</a>';
	}

	if($r) $r = '<div class="terms-buttons my-5">'.$r.'</div>';
	return $r;
}
add_shortcode( 'categorias_descargas', 'shortcode_categorias_descargas' );