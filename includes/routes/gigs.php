<?php

add_action('rest_api_init', function () {
    register_rest_route('custom/v1', '/gigs', [
        'methods' => 'GET',
        'callback' => 'custom_api_handle_filtered_gigs',
        'permission_callback' => '__return_true',
        'args' => [
            'venue_name' => ['type' => 'string', 'required' => false],
            'country' => ['type' => 'string', 'required' => false],
            'city' => ['type' => 'string', 'required' => false],
            'page' => ['type' => 'integer', 'default' => 1],
            'per_page' => ['type' => 'integer', 'default' => 10],
        ],
    ]);
});
