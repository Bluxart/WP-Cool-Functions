<?php
/**
 * Add Thumbnail Column to Admin ( Post/Page )
 *
 */
function az_add_thumbnail_column( $columns ) {

    global $post;

    $col_thumb = array( 'thumbnail' => __( 'Thumbnail', 'textdomain' ) );
    $columns   = array_slice( $columns, 0, 2, true ) + $col_thumb + array_slice( $columns, 1, NULL, true );

    return $columns;

}

function az_display_thumbnail_admin( $column ) {

    global $post;

    switch ( $column ) {

        case 'thumbnail':
            echo get_the_post_thumbnail( $post->ID, array( 50, 50 ) );
        break;

    }

}

// Add Thumb Post
add_filter( 'manage_post_posts_columns', 'az_add_thumbnail_column', 10, 2 );
add_action( 'manage_post_posts_custom_column', 'az_display_thumbnail_admin', 10, 2 );

// Add Thumb Page
add_filter( 'manage_page_posts_columns', 'az_add_thumbnail_column', 10, 2 );
add_action( 'manage_page_posts_custom_column', 'az_display_thumbnail_admin', 10, 2 );
?>
