<?php 
function sumun_nocookie_youtube_block( $block_content, $block ) {
    // echo '<pre>'; print_r($block); echo '</pre>';

    $aviso = '<p class="small text-muted">' . __( 'Al reproducir el vídeo aceptas la <a href="https://policies.google.com/technologies/cookies?hl=es" target="_blank" rel="nofollow">política de cookies y de privacidad de Google</a>.', 'sumun' ) . '</p>';
    if ( function_exists( 'gdpr_cookie_is_accepted' ) ) {
        if ( gdpr_cookie_is_accepted( 'thirdparty' ) ) {
            $aviso = '';
        }
    }

    if ( $block['blockName'] === 'core-embed/youtube' ) {
        $block_content = str_replace('www.youtube.com', 'www.youtube-nocookie.com', $block_content);
        $block_content .= $aviso;
    }
    if ( $block['blockName'] === 'acf/video-emergente' ) {
        $block_content .= $aviso;
    }
    return $block_content;
}
 
add_filter( 'render_block', 'sumun_nocookie_youtube_block', 10, 2 );

add_action('acf/init', 'sumun_init_block_types');
function sumun_init_block_types() {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // register a block.
        acf_register_block_type(array(
            'name'              => 'team',
            'title'             => __('Equipo', 'sumun-admin'),
            'description'       => __('Muestra a los miembros del equipo'),
            'render_template'   => 'loop-templates/blocks/team.php',
            'category'          => 'embed',
            'icon'              => 'id',
            'keywords'          => array( 'team', 'equipo', 'persona', 'people' ),
        ));
    }
}

add_filter( 'render_block', 'sumun_bootstrap_buttons', 10, 2 );
function sumun_bootstrap_buttons( $block_content, $block ) {

    if ( $block['blockName'] !== 'core/button' ) return $block_content;

    $block_content = str_replace( 'wp-block-button__link', 'wp-block-button__link btn btn-primary', $block_content);
    return $block_content;

}