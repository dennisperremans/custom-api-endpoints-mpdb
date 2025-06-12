<?php

add_action('rest_api_init', function () {
    register_rest_route('custom/v1', '/countries', [
        'methods' => 'GET',
        'callback' => 'custom_api_handle_countries',
        'permission_callback' => '__return_true',
    ]);
});
