<?php

add_action('admin_menu', 'custom_api_add_info_page');

function custom_api_add_info_page() {
    add_menu_page(
        'API Info',
        'API Info',
        'manage_options',
        'custom-api-info',
        'custom_api_render_info_page',
        'dashicons-rest-api',
        100
    );
}

function custom_api_render_info_page() {
    ?>
    <div class="wrap">
        <h1>Custom API Endpoints</h1>
        <p>This plugin exposes the following API endpoints:</p>

        <h2>/wp-json/custom/v1/songs-played-count</h2>
        <p><strong>Method:</strong> GET<br>
        <strong>Description:</strong> Returns total songs played, number of gigs, and number of unique songs.</p>

        <h2>/wp-json/custom/v1/venues</h2>
        <p><strong>Method:</strong> GET<br>
        <strong>Description:</strong> Returns a list of unique venue names.</p>
    </div>
    <?php
}
