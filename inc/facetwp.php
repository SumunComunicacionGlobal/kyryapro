<?php 
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

function fwp_add_facet_labels() {
    if ( !function_exists( 'facetwp_display' ) ) return false;
  ?>
    <script>
      (function($) {
        $(document).on('facetwp-loaded', function() {
          $('.facetwp-facet').each(function() {
            var facet = $(this);
            var facet_name = facet.attr('data-name');
            var facet_type = facet.attr('data-type');
            var facet_label = FWP.settings.labels[facet_name];
            if (facet_type !== 'pager' && facet_type !== 'sort' && facet_type !== 'search') {
              if (facet.closest('.facet-wrap').length < 1 && facet.closest('.facetwp-flyout').length < 1) {
                facet.wrap('<div class="facet-wrap"></div>');
                facet.before('<h3 class="facet-label">' + facet_label + '</h3>');
              }
            }
          });
        });
      })(jQuery);
    </script>
  <?php
}
add_action( 'wp_head', 'fwp_add_facet_labels', 100 );

add_action( 'wp_footer', function() {
?>
    <script>
    (function($) {
        $(document).on('facetwp-loaded', function() {

        var searchfacet = 'buscar'; // Replace 'my_search_facet' with the name of your Search facet
        var searchbox = $('[data-name="' + searchfacet + '"] .facetwp-search');

        if(! searchbox.next('i').length) {
            searchbox.after('<i class="clear" title="Clear Search"></i>');
        }

        if (searchbox.val() === '') {
            searchbox.next().hide();
        }

        searchbox.on('keyup', function() {
            if('yes' === FWP.settings[searchfacet]['auto_refresh']) {
            $(this).addClass('loading');
            }
            if ($(this).val() !== '') {
            $(this).next().show();
            }
        });
        
        searchbox.removeClass('loading');

        searchbox.next().click(function() {
            // ignore while Search facet is loading
            if (!searchbox.prev().hasClass('f-loading')) {
            $(this).hide();
            searchbox.val('');
            if (FWP.facets[searchfacet].length) {
                FWP.autoload();
            }
            }
        });
        });

    })(jQuery);
    </script>
<?php
}, 100 );

/**
 * Manually translate taxonomy terms
 * 
 * Change $facet_name
 * Change $tax_name
 */
add_filter( 'facetwp_facet_display_value', function( $label, $params ) {
    $facet_name = 'producto';
    $tax_name = 'dlm_download_category';

	if ( $facet_name == $params['facet']['name'] ) {
		$current = ( !empty( FWP()->facet->http_params['lang'] ) ) ? FWP()->facet->http_params['lang'] :  apply_filters( 'wpml_current_language', null );  
		$default = apply_filters('wpml_default_language', NULL );
		if ( $current != $default ) {
			$translated_id = apply_filters( 'wpml_object_id', $params['row']['term_id'], $tax_name, TRUE, $current );
			$term = get_term( $translated_id );

			if ( ! empty( $term ) ) {
				$label = esc_html( $term->name );
			}
		}        
	}
	return $label;
}, 10, 2 );

// Add to your (child) theme's functions.php

add_action( 'wp_head', function() {
    ?>
    <script>
    document.addEventListener('facetwp-loaded', function() {
        let $facet = fUtil('.facetwp-type-hierarchy');
    
        if ($facet.len()) {
            let depthNodes = $facet.find('.facetwp-depth').nodes;
            let lastDepthNode = depthNodes[depthNodes.length - 1];
            $facet.find('.facetwp-link').addClass('facetwp-hidden');
            fUtil(lastDepthNode).find('.facetwp-link').removeClass('facetwp-hidden');
        }
    });
    </script>
    <?php
}, 100 );

// Change term links to point to a specific URL

add_filter( 'term_link', function( $termlink, $term, $taxonomy ) {
    global $sitepress;

    if ( in_array( $taxonomy, array( 'dlm_download_category', 'marca' ) ) ) {

        $facetwp_slug = $taxonomy;
        if ( $taxonomy == 'dlm_download_category' ) {
            $facetwp_slug = 'producto';
        }

        $termlink = get_the_permalink( ID_PAGINA_FICHAS ) . '?_'.$facetwp_slug.'=' . $term->slug;

        if ( isset( $sitepress ) ) {
                
            $current_lang = apply_filters( 'wpml_current_language', null );
            $default_lang = apply_filters( 'wpml_default_language', NULL );

            if ( $current_lang != $default_lang ) {

                $default_id = apply_filters( 'wpml_object_id', $term->term_id, $taxonomy, TRUE, $default_lang );
                remove_filter( 'get_term', array( $sitepress, 'get_term_adjust_id' ),1, 1 );
                $default_term = get_term( $default_id );
                $default_slug = $default_term->slug;

                $termlink = get_the_permalink( ID_PAGINA_FICHAS ) . '?_'.$facetwp_slug.'=' . $default_slug;

                add_filter( 'get_term', array( $sitepress, 'get_term_adjust_id' ), 1, 1 );
                
            }

        }

    }
    return $termlink;
}, 10, 3);