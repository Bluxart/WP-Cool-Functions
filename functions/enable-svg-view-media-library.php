<?php
/**
 *
 * Enable to see the SVG in Media Library
 *
 */
function az_common_svg_media_thumbnails($response, $attachment, $meta) {

    if( $response['type'] === 'image' && $response['subtype'] === 'svg+xml' && class_exists('SimpleXMLElement') ) {
        try {
            $path = get_attached_file($attachment->ID);
            if( @file_exists($path) ){
                $svg    = new SimpleXMLElement( @file_get_contents($path) );
                $src    = $response['url'];
                $width  = (int) $svg['width'];
                $height = (int) $svg['height'];

                //Media Gallery
                $response['image'] = compact( 'src', 'width', 'height' );
                $response['thumb'] = compact( 'src', 'width', 'height' );

                //Media Single
                $response['sizes']['full'] = array(
                    'height'        => $height,
                    'width'         => $width,
                    'url'           => $src,
                    'orientation'   => $height > $width ? 'portrait' : 'landscape',
                );
            }
        }
        catch(Exception $e){}
    }

    return $response;

}
add_filter( 'wp_prepare_attachment_for_js', 'az_common_svg_media_thumbnails', 10, 3 );
?>
