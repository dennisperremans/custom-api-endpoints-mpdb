<?php

add_action('rest_api_init', function () {
    register_rest_route('custom/v1', '/venues', [
        'methods' => 'GET',
        'callback' => 'custom_api_handle_unique_venues',
        'permission_callback' => '__return_true',
    ]);
});
