<?php
/**
 *
 * Remove auto srcset from content
 *
 */
add_filter( 'wp_calculate_image_srcset_meta', '__return_empty_array' );
?>
