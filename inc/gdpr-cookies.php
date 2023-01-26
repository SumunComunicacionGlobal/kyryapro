<?php 

add_action( 'gdpr_force_reload', '__return_true' );

add_filter('gdpr_cookie_script_cache','gdpr_prevent_script_cache');
function gdpr_prevent_script_cache() {
    return array();
}

add_action('moove_gdpr_third_party_header_assets','moove_gdpr_third_party_header_assets');
function moove_gdpr_third_party_header_assets( $scripts ) {
    if (is_user_logged_in()) {
      $scripts = '<script>console.log("scripts-head-anulados");</script>';     
    }
  return $scripts;
}
add_action('moove_gdpr_third_party_body_assets','moove_gdpr_third_party_body_assets');
function moove_gdpr_third_party_body_assets( $scripts ) {
    if (is_user_logged_in()) {
      $scripts = '<script>console.log("scripts-body-anulados");</script>';     
    }
  return $scripts;
}
add_action('moove_gdpr_third_party_footer_assets','moove_gdpr_third_party_footer_assets');
function moove_gdpr_third_party_footer_assets( $scripts ) {
    if (is_user_logged_in()) {
      $scripts = '<script>console.log("scripts-footer-anulados");</script>';     
    }
  return $scripts;
}