<?php

function custom_api_handle_songs_played(WP_REST_Request $request) {
    $args = [
        'post_type'      => 'gig',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'fields'         => 'ids',
    ];

    $gig_ids = get_posts($args);
    $total_songs_played = 0;

    foreach ($gig_ids as $gig_id) {
        $songs = get_field('songs', $gig_id);
        if (is_array($songs)) {
            $total_songs_played += count($songs);
        }
    }

    $total_gigs = count($gig_ids);

    $unique_songs_query = new WP_Query([
        'post_type' => 'song',
        'posts_per_page' => 1,
        'fields' => 'ids',
    ]);
    $total_unique_songs = $unique_songs_query->found_posts;

    return [
        'total_songs_played' => $total_songs_played,
        'total_gigs' => $total_gigs,
        'total_unique_songs' => $total_unique_songs,
    ];
}
