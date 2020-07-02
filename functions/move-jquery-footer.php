<?php
/**
 * Move jQuery, jQuery Migrate to footer
 *
 * @return void
 */
function az_move_jquery_footer() {

    wp_scripts()->add_data( 'jquery', 'group', 1 );
    wp_scripts()->add_data( 'jquery-core', 'group', 1 );

}
add_action( 'wp_enqueue_scripts', 'az_move_jquery_footer' );

function az_move_head_scripts() {

    remove_action( 'wp_head', 'wp_print_scripts' );
    remove_action( 'wp_head', 'wp_print_head_scripts', 9 );
    remove_action( 'wp_head', 'wp_enqueue_scripts', 1 );

    add_action( 'wp_footer', 'wp_print_scripts', 5 );
    add_action( 'wp_footer', 'wp_enqueue_scripts', 5 );
    add_action( 'wp_footer', 'wp_print_head_scripts', 5 );

}
add_action( 'wp_enqueue_scripts', 'az_move_head_scripts' );

?>
