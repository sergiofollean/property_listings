<?php

if (! defined('ABSPATH')) {
    exit;
}

add_action('acf/init', function () {
    acf_add_local_field_group([
        'key' => 'group_listing_fields',
        'title' => 'Listing Fields',
        'fields' => [
            [
                'key' => 'field_price',
                'label' => 'Price',
                'name' => 'price',
                'type' => 'number',
                'required' => 1,
            ],
            [
                'key' => 'field_location',
                'label' => 'Location',
                'name' => 'location',
                'type' => 'text',
                'required' => 1,
            ],
            [
                'key' => 'field_square_feet',
                'label' => 'Square Feet',
                'name' => 'square_feet',
                'type' => 'number',
            ],
            [
                'key' => 'field_status',
                'label' => 'Listing Status',
                'name' => 'status',
                'type' => 'select',
                'choices' => [
                    'For Sale' => 'For Sale',
                    'Sold' => 'Sold',
                    'Pending' => 'Pending',
                ],
                'allow_null' => 0,
                'multiple' => 0,
            ]
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'listing',
                ],
            ],
        ],
    ]);
});