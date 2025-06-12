<?php

function custom_api_handle_cities(WP_REST_Request $request) {
    $args = [
        'post_type'      => 'gig',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'fields'         => 'ids',
    ];

    $gig_ids = get_posts($args);
    $cities = [];

    foreach ($gig_ids as $gig_id) {
        $city = get_field('city', $gig_id);
        if (!empty($city)) {
            $cities[] = $city;
        }
    }

    $unique_cities = array_unique($cities);
    sort($unique_cities);

    return array_values($unique_cities);
}
