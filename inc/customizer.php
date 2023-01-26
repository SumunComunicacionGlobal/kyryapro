<?php
/**
 * Understrap Theme Customizer
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
if ( ! function_exists( 'understrap_customize_register' ) ) {
	/**
	 * Register basic customizer support.
	 *
	 * @param object $wp_customize Customizer reference.
	 */
	function understrap_customize_register( $wp_customize ) {
		$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
		$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	}
}
add_action( 'customize_register', 'understrap_customize_register' );

/**
* Crear panel de opciones en el customizador
*/
function sumun_new_customizer_settings($wp_customize) {
    $web_title = get_bloginfo( 'name' );
    // create settings section
    $wp_customize->add_panel('sumun_opciones', array(
        'title'         => $web_title . ': ' . __( 'Opciones de configuración', 'sumun-admin' ),
        'description'   => __( 'Opciones para este sitio web', 'sumun-admin' ),
        'priority'      => 1,
    ));
    $wp_customize->add_section('sumun_redes_sociales', array(
        'title'         => __( 'Redes sociales', 'sumun-admin' ),
        'priority'      => 20,
        'panel'         => 'sumun_opciones',
    ));
    $wp_customize->add_section('sumun_ajustes', array(
        'title'         => __( 'Otros ajustes', 'sumun-admin' ),
        'priority'      => 20,
        'panel'         => 'sumun_opciones',
    ));



    $redes_sociales = array(
        'email',
        'whatsapp',
        'linkedin',
        'twitter',
        'facebook',
        'instagram',
        'youtube',
        'skype',
        'pinterest',
        'flickr',
        'blog',
    );
    foreach ($redes_sociales as $red) {
        // add a setting
        $wp_customize->add_setting($red);
        
        // Add a control
        $wp_customize->add_control( $red,   array(
            'type'      => 'text',
            'label'     => 'URL ' . $red,
            'section'   => 'sumun_redes_sociales',
        ) );
    }


    $wp_customize->add_setting('info_privacidad_formularios');
    $wp_customize->add_control( 'info_privacidad_formularios',   array(
        'type'      => 'textarea',
        'label'     => 'Información básica de privacidad para formularios',
        'description' => 'Esta información se puede reproducir en cualquier lugar con el shortcode [info_basica_privacidad].',
        'section'   => 'sumun_ajustes',
    ) );

    $wp_customize->add_setting('placeholder_id');
    $wp_customize->add_control( 'placeholder_id',   array(
        'type'      => 'number',
        'label'     => 'ID de la imagen por defecto',
        'section'   => 'sumun_ajustes',
    ) );

    $wp_customize->add_setting('download_form_id');
    $wp_customize->add_control( 'download_form_id',   array(
        'type'      => 'number',
        'label'     => 'ID del formulario de descarga',
        'section'   => 'sumun_ajustes',
    ) );

    $wp_customize->add_setting('fichas_page_id');
    $wp_customize->add_control( 'fichas_page_id',   array(
        'type'      => 'number',
        'label'     => 'ID de la página de fichas de producto',
        'section'   => 'sumun_ajustes',
    ) );

    $wp_customize->add_setting('orders_page_id');
    $wp_customize->add_control( 'orders_page_id',   array(
        'type'      => 'number',
        'label'     => 'ID de la página de pedidos',
        'section'   => 'sumun_ajustes',
    ) );

    $wp_customize->add_setting('categoria_catalogos_id');
    $wp_customize->add_control( 'categoria_catalogos_id',   array(
        'type'      => 'number',
        'label'     => 'ID de la categoría de los catálogos',
        'section'   => 'sumun_ajustes',
    ) );

}
add_action('customize_register', 'sumun_new_customizer_settings');
/***/

if ( ! function_exists( 'understrap_theme_customize_register' ) ) {
	/**
	 * Register individual settings through customizer's API.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer reference.
	 */
	function understrap_theme_customize_register( $wp_customize ) {

		// Theme layout settings.
		$wp_customize->add_section(
			'understrap_theme_layout_options',
			array(
				'title'       => __( 'Theme Layout Settings', 'understrap' ),
				'capability'  => 'edit_theme_options',
				'description' => __( 'Container width and sidebar defaults', 'understrap' ),
				'priority'    => 160,
			)
		);

		/**
		 * Select sanitization function
		 *
		 * @param string               $input   Slug to sanitize.
		 * @param WP_Customize_Setting $setting Setting instance.
		 * @return string Sanitized slug if it is a valid choice; otherwise, the setting default.
		 */
		function understrap_theme_slug_sanitize_select( $input, $setting ) {

			// Ensure input is a slug (lowercase alphanumeric characters, dashes and underscores are allowed only).
			$input = sanitize_key( $input );

			// Get the list of possible select options.
			$choices = $setting->manager->get_control( $setting->id )->choices;

				// If the input is a valid key, return it; otherwise, return the default.
				return ( array_key_exists( $input, $choices ) ? $input : $setting->default );

		}

		$wp_customize->add_setting(
			'understrap_container_type',
			array(
				'default'           => 'container',
				'type'              => 'theme_mod',
				'sanitize_callback' => 'understrap_theme_slug_sanitize_select',
				'capability'        => 'edit_theme_options',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'understrap_container_type',
				array(
					'label'       => __( 'Container Width', 'understrap' ),
					'description' => __( 'Choose between Bootstrap\'s container and container-fluid', 'understrap' ),
					'section'     => 'understrap_theme_layout_options',
					'settings'    => 'understrap_container_type',
					'type'        => 'select',
					'choices'     => array(
						'container'       => __( 'Fixed width container', 'understrap' ),
						'container-fluid' => __( 'Full width container', 'understrap' ),
					),
					'priority'    => '10',
				)
			)
		);

		$wp_customize->add_setting(
			'understrap_sidebar_position',
			array(
				'default'           => 'right',
				'type'              => 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
				'capability'        => 'edit_theme_options',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'understrap_sidebar_position',
				array(
					'label'             => __( 'Sidebar Positioning', 'understrap' ),
					'description'       => __(
						'Set sidebar\'s default position. Can either be: right, left, both or none. Note: this can be overridden on individual pages.',
						'understrap'
					),
					'section'           => 'understrap_theme_layout_options',
					'settings'          => 'understrap_sidebar_position',
					'type'              => 'select',
					'sanitize_callback' => 'understrap_theme_slug_sanitize_select',
					'choices'           => array(
						'right' => __( 'Right sidebar', 'understrap' ),
						'left'  => __( 'Left sidebar', 'understrap' ),
						'both'  => __( 'Left & Right sidebars', 'understrap' ),
						'none'  => __( 'No sidebar', 'understrap' ),
					),
					'priority'          => '20',
				)
			)
		);
	}
} // endif function_exists( 'understrap_theme_customize_register' ).
add_action( 'customize_register', 'understrap_theme_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
if ( ! function_exists( 'understrap_customize_preview_js' ) ) {
	/**
	 * Setup JS integration for live previewing.
	 */
	function understrap_customize_preview_js() {
		wp_enqueue_script(
			'understrap_customizer',
			get_template_directory_uri() . '/js/customizer.js',
			array( 'customize-preview' ),
			'20130508',
			true
		);
	}
}
add_action( 'customize_preview_init', 'understrap_customize_preview_js' );
