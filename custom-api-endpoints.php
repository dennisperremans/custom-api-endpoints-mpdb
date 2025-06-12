<?php
/*
Plugin Name: Custom API endpoints
Description: Exposes API endpoints for MPDB WP site
Version: 1.1
Author: Dennis Perremans
*/

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

define('CAE_PLUGIN_DIR', plugin_dir_path(__FILE__));

// Load handlers (logic)
require_once CAE_PLUGIN_DIR . 'includes/handlers/songs-handler.php';
require_once CAE_PLUGIN_DIR . 'includes/handlers/venues-handler.php';
require_once CAE_PLUGIN_DIR . 'includes/handlers/country-handler.php';
require_once CAE_PLUGIN_DIR . 'includes/handlers/city-handler.php';

// Load routes (REST registration)
require_once CAE_PLUGIN_DIR . 'includes/routes/songs.php';
require_once CAE_PLUGIN_DIR . 'includes/routes/venues.php';
require_once CAE_PLUGIN_DIR . 'includes/routes/countries.php';
require_once CAE_PLUGIN_DIR . 'includes/routes/cities.php';


// Load admin info page
require_once CAE_PLUGIN_DIR . 'includes/admin-page.php';
