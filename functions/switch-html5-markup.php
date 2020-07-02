<?php
/**
 *
 * Switch default core markup to output valid HTML5
 *
 */
if ( !function_exists( 'az_theme_setup' ) ) {

    function az_theme_setup() {

        /* Other stuff here... */

        add_theme_support( 'html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script'
        ) );

    }

}
add_action( 'after_setup_theme', 'az_theme_setup' );
?>
