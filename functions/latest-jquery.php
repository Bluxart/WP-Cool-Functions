<?php
/**
 *
 * Use last version of jQuery Front-End Only
 *
 */
if ( !function_exists( 'az_jquery_frontend' ) ) {

    function az_jquery_frontend() {

        $wp_admin 	   = is_admin();
        $wp_customizer = is_customize_preview();

        // jQuery
        if ( $wp_admin || $wp_customizer ) {

            // Use default jQuery version here;
            return;

        } else {

            // Deregister old version of jQuery
            wp_deregister_script( 'jquery' );
            wp_deregister_script( 'jquery-core' );
            wp_deregister_script( 'jquery-migrate' );

            // Register jquery using jquery-core as a dependency, so other scripts could use the jquery handle
            wp_register_script( 'jquery-core', 'https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js', array(), null, false );
            wp_register_script( 'jquery', false, array( 'jquery-core' ), null, false );
            wp_enqueue_script( 'jquery' );

        }

    }

}
add_action( 'wp_enqueue_scripts', 'az_jquery_frontend', 100 );
?>
