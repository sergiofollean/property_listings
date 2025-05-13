<?php

/**
 * Plugin Name: Real Estate Listings
 * Description: A high-performance real estate listings plugin.
 * Version: 1.0.0
 */

if (! defined('ABSPATH')) {
    exit;
}

define('REL_PLUGIN_VERSION', '1.0.0');
define('REL_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('REL_PLUGIN_URL', plugin_dir_url(__FILE__));

if (file_exists(REL_PLUGIN_DIR . 'vendor/autoload.php')) {
    require_once REL_PLUGIN_DIR . 'vendor/autoload.php';
}

/**
 * Includes
 */
require_once REL_PLUGIN_DIR . 'composer-plugins/advanced-custom-fields/acf.php';
require_once REL_PLUGIN_DIR . 'includes/init.php';
require_once REL_PLUGIN_DIR . 'includes/twig-init.php';
require_once REL_PLUGIN_DIR . 'includes/shortcode.php';
require_once REL_PLUGIN_DIR . 'includes/wp-cli.php';
require_once REL_PLUGIN_DIR . 'includes/acf.php';

/**
 * Enqueue scripts and styles
 */
add_action('wp_enqueue_scripts', function () {
    $css_path = REL_PLUGIN_DIR . 'assets/dist.css';
    $css_url = REL_PLUGIN_URL . 'assets/dist.css';

    $version = file_exists($css_path) ? filemtime($css_path) : REL_PLUGIN_VERSION;

    wp_enqueue_style(
        'real-estate-tailwind',
        $css_url,
        [],
        $version
    );
}, 100);

/**
 * Register preview image size
 */
add_action('after_setup_theme', function () {
    add_image_size('listing-preview', 600, 400, true);
}, 100);