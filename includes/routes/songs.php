<?php

add_action('rest_api_init', function () {
    register_rest_route('custom/v1', '/songs-played-count', [
        'methods' => 'GET',
        'callback' => 'custom_api_handle_songs_played',
        'permission_callback' => '__return_true',
    ]);
});
