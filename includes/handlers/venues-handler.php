<?php

function custom_api_handle_unique_venues(WP_REST_Request $request) {
    $args = [
        'post_type'      => 'gig',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'fields'         => 'ids',
    ];

    $gig_ids = get_posts($args);
    $venues = [];

    foreach ($gig_ids as $gig_id) {
        $venue = get_field('venue_name', $gig_id);
        if (!empty($venue)) {
            $venues[] = $venue;
        }
    }

    $unique_venues = array_unique($venues);
    sort($unique_venues);

    return array_values($unique_venues);
}
