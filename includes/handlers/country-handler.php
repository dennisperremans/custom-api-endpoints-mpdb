<?php

function custom_api_handle_countries(WP_REST_Request $request) {
    $args = [
        'post_type'      => 'gig',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'fields'         => 'ids',
    ];

    $gig_ids = get_posts($args);
    $countries = [];

    foreach ($gig_ids as $gig_id) {
        $country = get_field('country', $gig_id);
        if (!empty($country)) {
            $countries[] = $country;
        }
    }

    $unique_countries = array_unique($countries);
    sort($unique_countries);

    return array_values($unique_countries);
}
