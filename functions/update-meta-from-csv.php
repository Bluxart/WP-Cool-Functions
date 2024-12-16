<?php
/**
 *
 * Update Meta from URL by CSV
 *
 */

 // Function to read CSV file and return it as an associative array
function read_csv_to_array($file_path) {

    $data = [];
    if (($handle = fopen($file_path, 'r')) !== false) {

        // Read the header of the CSV
        $header = fgetcsv($handle, 1000, ';');

        while (($row = fgetcsv($handle, 1000, ';')) !== false) {

            // Combine each row with the header
            $data[] = array_combine($header, $row);

        }

        fclose($handle);

    }

    return $data;

}

// Function to retrieve the post ID from a URL
function get_post_id_by_url($url) {

    global $wpdb;

    // Parse URL and get the path part
    $path = parse_url($url, PHP_URL_PATH);
    $path = trim($path, '/');

    // Check if the URL is related to a custom post type with nested terms
    $segments = explode('/', $path);
    if (count($segments) >= 2 && $segments[0] === 'name-cpt') {

        $main_category_slug = $segments[1];

        // Get the main category term by its slug
        $main_category = get_term_by('slug', $main_category_slug, 'name-cpt-taxonomy');

        if ($main_category) {

            $parent_term = $main_category;

            // Loop through the remaining segments to find nested terms
            for ($i = 2; $i < count($segments); $i++) {

                $term_slug = $segments[$i];

                // Check if the term exists and is an ancestor of the parent term
                $term = get_term_by('slug', $term_slug, 'name-cpt-taxonomy');

                if ($term && term_is_ancestor_of($parent_term->term_id, $term->term_id, 'name-cpt-taxonomy')) {
                    $parent_term = $term;
                } else {
                    break;
                }

            }

            return $parent_term->term_id;

        }

    }

    // If not custom post type, query posts with the given URL slug
    $sql = $wpdb->prepare(
        "SELECT ID FROM $wpdb->posts WHERE post_name = %s AND post_type IN ('post', 'page', 'name-cpt')",
        basename($path)
    );
    $post_id = $wpdb->get_var($sql);

    // Check for old slug mappings if no post ID found
    if (!$post_id) {

        $query = new WP_Query([
            'post_type'      => 'any',
            'posts_per_page' => 1,
            'fields'         => 'ids',
            'meta_query'     => [
                [
                    'key'     => '_wp_old_slug',
                    'value'   => $path,
                    'compare' => 'LIKE',
                ],
            ],
        ]);

        if ($query->have_posts()) {
            $post_id = $query->posts[0];
        }

    }

    return $post_id ?: null;
}

// Set the CSV file path and read it into an array
$csv_file_path = 'url/csv';
$data = read_csv_to_array($csv_file_path);

// Check if the CSV contains data
if (!empty($data)) {

    echo '<pre>';

    // Loop through each row in the CSV
    foreach ($data as $row) {

        // Get the URL and new meta title/description from the CSV
        $url = $row['URL'];
        $new_meta_title = isset($row['TITLE']) ? $row['TITLE'] : 'Not found';
        $new_meta_description = isset($row['DESCRIPTION']) ? $row['DESCRIPTION'] : 'Not found';

        // Get the home URL for comparison
        $home_url = get_home_url();
        $home_url = rtrim($home_url, '/');

        // Check if the URL matches the home URL (i.e., the front page)
        if (rtrim($url, '/') === $home_url) {

            $id = get_option('page_on_front');

        } else {

            // Otherwise, try to find the post ID using the URL
            $id = get_post_id_by_url($url);

        }

        // If post ID is found, update its meta
        if ($id) {

            // If the ID corresponds to a taxonomy term
            $term = get_term($id, 'name-cpt-taxonomy');

            if ($term && !is_wp_error($term)) {

                // Get the current Yoast meta for the term or if Yoast meta is missing, get dynamic values ( Debug )
                $yoast_title       = WPSEO_Taxonomy_Meta::get_term_meta($term->term_id, 'name-cpt-taxonomy', 'title');
                $yoast_description = WPSEO_Taxonomy_Meta::get_term_meta($term->term_id, 'name-cpt-taxonomy', 'desc');

                if (!$yoast_title || !$yoast_description) {
                    $yoast_title       = YoastSEO()->meta->for_post($id)->title;
                    $yoast_description = YoastSEO()->meta->for_post($id)->description;
                }

                // Update Yoast meta values for the taxonomy term
                WPSEO_Taxonomy_Meta::set_values( $id, 'name-cpt-taxonomy',
                    [
                        'wpseo_title' => $new_meta_title,
                        'wpseo_desc' => $new_meta_description,
                    ]
                );

            } else {

                $post_type = get_post_type($id);

                // If it's a custom post type 'name-cpt'
                if ($post_type == 'name-cpt') {

                    // Get the current Yoast meta for the post or if Yoast meta is missing, get dynamic values ( Debug )
                    $yoast_title       = get_post_meta($id, '_yoast_wpseo_title', true);
                    $yoast_description = get_post_meta($id, '_yoast_wpseo_metadesc', true);

                    if (!$yoast_title || !$yoast_description) {
                        $yoast_title       = YoastSEO()->meta->for_post($id)->title;
                        $yoast_description = YoastSEO()->meta->for_post($id)->description;
                    }

                    update_post_meta($id, '_yoast_wpseo_title', $new_meta_title);
                    update_post_meta($id, '_yoast_wpseo_metadesc', $new_meta_description);

                } else {

                    // Get the current Yoast meta for the post or if Yoast meta is missing, get dynamic values ( Debug )
                    $yoast_title       = get_post_meta($id, '_yoast_wpseo_title', true);
                    $yoast_description = get_post_meta($id, '_yoast_wpseo_metadesc', true);

                    if (!$yoast_title || !$yoast_description) {
                        $yoast_title       = YoastSEO()->meta->for_post($id)->title;
                        $yoast_description = YoastSEO()->meta->for_post($id)->description;
                    }

                    update_post_meta($id, '_yoast_wpseo_title', $new_meta_title);
                    update_post_meta($id, '_yoast_wpseo_metadesc', $new_meta_description);

                }

            }

        }

    }

    echo '</pre>';

}
?>
