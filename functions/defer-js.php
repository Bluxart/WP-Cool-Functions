<?php
/**
 * Enqueue some script
 *
 * @return void
 */
if ( !function_exists( 'az_add_js' ) ) {

	function az_add_js() {

		// Register Scripts
		wp_register_script( 'az-app', get_template_directory_uri() . '/_include/js/app.js', array( 'jquery' ), NULL, true );
		wp_register_script( 'az-utils', get_template_directory_uri() . '/_include/js/vendor/utils.js', array( 'jquery' ), NULL, true );
		/* Other Scripts Here... */

		// Enqueue Scripts
		wp_enqueue_script( 'az-utils' );
		wp_enqueue_script( 'az-app' );

	}

}
add_action( 'wp_enqueue_scripts', 'az_add_js', 100 );

/**
 * Add "defer" attribute to script js
 *
 * @param  mixed $tag
 * @param  mixed $handle
 * @param  mixed $src
 * @return void
 */
function az_defer_js( $tag, $handle, $src ) {

    /**
     * The handles of the enqueued scripts we want to defer or async or both.
     * You can also defer the js of other plugins like WooCommerce, WPML and other just insert the name of the script ( handle ).
     *
     * Example of handlers from WPML & WooCommerce Plugins:
     * 'wcml-mc-scripts' ( WPML )
     * 'wcml-front-scripts' ( WPML )
     * 'wc-add-to-cart' ( WooCommerce )
     * 'woocommerce' ( WooCommerce )
     * 'wc-cart-fragments' ( WooCommerce )
     * 'cart-widget' ( WooCommerce )
     */
    $defer_scripts = array(
        'az-utils',
        'az-app',
    );

    if ( in_array( $handle, $defer_scripts ) ) {
        return '<script src="' . $src . '" defer type="text/javascript"></script>' . "\n";
    }

    return $tag;

}
add_filter( 'script_loader_tag', 'az_defer_js', 10, 3 );
?>
