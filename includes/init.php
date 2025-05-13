<?php

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Init
 */
add_action('init', function () {
    register_listing_post_type();
    register_city_taxonomy();
    register_type_taxonomy();
});

/**
 * Register listing post type
 */
function register_listing_post_type() {
    $labels = [
        'name' => __('Listings', 'textdomain'),
        'singular_name' => __('Listing', 'textdomain'),
        'add_new' => __('Add New', 'textdomain'),
        'add_new_item' => __('Add New Listing', 'textdomain'),
        'edit_item' => __('Edit Listing', 'textdomain'),
        'new_item' => __('New Listing', 'textdomain'),
        'view_item' => __('View Listing', 'textdomain'),
        'search_items' => __('Search Listings', 'textdomain'),
        'not_found' => __('No listings found', 'textdomain'),
        'not_found_in_trash' => __('No listings found in Trash', 'textdomain'),
    ];

    $args = [
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'supports' => ['title', 'editor', 'thumbnail'],
        'menu_icon' => 'dashicons-building',
    ];

    register_post_type('listing', $args);
}

/**
 * Register city taxonomy
 */
function register_city_taxonomy() {
    $labels = [
        'name' => __('Cities', 'textdomain'),
        'singular_name' => __('City', 'textdomain'),
        'search_items' => __('Search Cities', 'textdomain'),
        'all_items' => __('All Cities', 'textdomain'),
        'parent_item' => __('Parent City', 'textdomain'),
        'parent_item_colon' => __('Parent City:', 'textdomain'),
        'edit_item' => __('Edit City', 'textdomain'),
        'update_item' => __('Update City', 'textdomain'),
        'add_new_item' => __('Add New City', 'textdomain'),
        'new_item_name' => __('New City Name', 'textdomain'),
    ];

    $args = [
        'labels' => $labels,
        'hierarchical' => false
    ];

    register_taxonomy('city', ['listing'], $args);
}

/**
 * Register type taxonomy
 */
function register_type_taxonomy() {
    $labels = [
        'name' => __('Types', 'textdomain'),
        'singular_name' => __('Type', 'textdomain'),
        'search_items' => __('Search Types', 'textdomain'),
        'all_items' => __('All Types', 'textdomain'),
        'parent_item' => __('Parent Type', 'textdomain'),
        'parent_item_colon' => __('Parent Type:', 'textdomain'),
        'edit_item' => __('Edit Type', 'textdomain'),
        'update_item' => __('Update Type', 'textdomain'),
        'add_new_item' => __('Add New Type', 'textdomain'),
        'new_item_name' => __('New Type Name', 'textdomain'),
    ];

    $args = [
        'labels' => $labels,
        'hierarchical' => false
    ];

    register_taxonomy('type', ['listing'], $args);
}