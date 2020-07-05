<?php
/**
 * Control mime-types WordPress
 *
 * @param  array $mimes
 * @return void
 */
function az_edit_mime_types( $mimes ) {

    // Allow mime-type
    $mimes['svg'] = 'image/svg+xml';
    $mimes['dwg'] = 'application/acad';
    $mimes['dwg'] = 'application/x-acad';
    $mimes['dwg'] = 'application/autocad_dwg';
    $mimes['dwg'] = 'application/dwg';
    $mimes['dwg'] = 'application/x-dwg';
    $mimes['dwg'] = 'application/x-autocad';
    $mimes['dwg'] = 'drawing/dwg';
    $mimes['zip'] = 'application/zip';
    $mimes['gz']  = 'application/x-gzip';

    // Unset mime-type
    unset( $mimes['jpg'] );

    return $mimes;

}
add_filter( 'upload_mimes', 'az_edit_mime_types' );
