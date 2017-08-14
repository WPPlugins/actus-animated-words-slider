<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * @since      1.0.0
 *
 * @package    Actus_Animated_Words_Slider
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}



actus_aaws_uninstall();

function actus_aaws_uninstall() {
    
    delete_option( 'ACTUS_AAWS_VERSION' );
    
    // actus_aaws_slider_options
    $meta_type  = 'user';
    $user_id    = 0;
    $meta_key   = 'actus_aaws_slider_options';
    $meta_value = '';
    $delete_all = true;
    delete_metadata( $meta_type, $user_id, $meta_key, $meta_value, $delete_all );

    // DELETE actus_aaws_options
    $meta_type  = 'user';
    $user_id    = 0;
    $meta_key   = 'actus_aaws_options';
    $meta_value = '';
    $delete_all = true;
    delete_metadata( $meta_type, $user_id, $meta_key, $meta_value, $delete_all );

}


