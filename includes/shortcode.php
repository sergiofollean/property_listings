<?php

if (! defined('ABSPATH')) {
    exit;
}

use Twig\Environment;

// Add [property_listings] shortcode to display property listings
add_shortcode('property_listings', function ($atts) {
    $atts = shortcode_atts([
        'posts_per_page' => 9,
        'city' => '',
        'status' => '',
        'type' => '',
    ], $atts, 'property_listings');

    $args = [
        'post_type' => 'listing',
        'posts_per_page' => $atts['posts_per_page'],
    ];

    if (! empty($atts['city'])) {
        $args['tax_query'] = [
            'relation' => 'OR',
            [
                'taxonomy' => 'city',
                'field' => 'slug',
                'terms' => $atts['city'],
            ]
        ];
    }

    if (! empty($atts['status'])) {
        $args['meta_query'] = [
            [
                'key' => 'status',
                'value' => $atts['status'],
                'compare' => '=',
            ],
        ];
    }

    if (! empty($atts['type'])) {
        $args['tax_query'][] = [
            'taxonomy' => 'type',
            'field' => 'slug',
            'terms' => $atts['type'],
        ];
    }

    $query = new WP_Query($args);

    if (! $query->have_posts()) {
        return '<p>' . __('No listings found.', 'textdomain') . '</p>';
    }

    $query->posts = array_map(function ($post) {
        $post->price = get_field('price', $post->ID);
        $post->status = get_field('status', $post->ID);
        $post->image_html = get_the_post_thumbnail($post->ID, 'listing-preview', [
            'class' => 'w-full h-50 object-cover',
        ]);
        $post->link = get_permalink($post->ID);

        return $post;
    }, $query->posts);

    $twig = rel_get_twig();

    return $twig->render('property_listings.twig', [
        'listings' => $query->posts,
        'placeholder_image' => REL_PLUGIN_URL . 'assets/placeholder.svg',
    ]);
});