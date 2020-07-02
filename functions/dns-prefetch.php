<?php
/**
 *
 * DNS Prefetch
 *
 */
if ( !function_exists( 'az_dns_prefetch' ) ) {

    function az_dns_prefetch() {

        echo '
        <!-- DNS PREFETCH -->
        <meta http-equiv="x-dns-prefetch-control" content="on">
        <link rel="dns-prefetch" href="//ajax.googleapis.com" />
        <link rel="dns-prefetch" href="//apis.google.com" />
        <link rel="dns-prefetch" href="//google-analytics.com" />
        <link rel="dns-prefetch" href="//www.google-analytics.com" />
        <link rel="dns-prefetch" href="//ssl.google-analytics.com" />
        <link rel="dns-prefetch" href="//connect.facebook.net" />
        <link rel="dns-prefetch" href="//s.gravatar.com" />
        <link rel="dns-prefetch" href="//s0.wp.com" />
        <link rel="dns-prefetch" href="//stats.wp.com" />
        <link rel="dns-prefetch" href="//player.vimeo.com" />
        <link rel="dns-prefetch" href="//www.youtube.com" />
        ';

    }
    add_action( 'wp_head', 'az_dns_prefetch', 0 );

}
?>
