<?php
/**
 *
 * Remove Emoji styles & scripts
 *
 */
if ( !function_exists( 'az_theme_setup' ) ) {

    function az_theme_setup() {

        /* Other stuff here... */

        remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
        remove_action( 'wp_print_styles', 'print_emoji_styles');

        remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
        remove_action( 'admin_print_styles', 'print_emoji_styles' );

    }

}
add_action( 'after_setup_theme', 'az_theme_setup' );
?>
