<?php
/**
 *
 * Util for get the ID
 *
 */
function az_get_ID() {

    global $post;

    $post_id = '';
    if ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {

        if ( is_shop() || is_product_category() || is_product_tag() ) {
            $post_id = wc_get_page_id( 'shop' );
        } else {
            global $wp_query;
            $post_id = $wp_query->post->ID;
        }

    } else {

        if ( is_home() || is_archive() || is_search() || is_404() ) {

            if ( get_option( 'page_for_posts' ) ) {
                $post_id = get_option( 'page_for_posts' );
            } else if ( get_option( 'page_on_front' ) ) {
                $post_id = get_option( 'page_on_front' );
            } else {
                $post_id = get_current_blog_id();
            }

        } else {
            $post_id = $post->ID;
        }

    }

    return $post_id;

}
?>
