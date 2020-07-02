<?php
/**
 * Remove jQuery Migrate
 *
 * @param  mixed $scripts
 * @return void
 */
function az_remove_jquery_migrate( &$scripts ) {

    if( !is_admin() ) {
        $scripts->remove( 'jquery' );
        $scripts->add( 'jquery', false, array( 'jquery-core' ) );
    }

}
add_filter( 'wp_default_scripts', 'az_remove_jquery_migrate' );
?>
