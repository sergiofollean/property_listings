<?php

if (! defined('ABSPATH')) {
    exit;
}

use Faker\Factory;

class Generate_Listings_Command {
    const INSERTION_COUNT = 1000;
    const POSTS_PER_PAGE = 100;
    const CITIES = [
        'Los Angeles', 'New York', 'Chicago', 'Houston', 'Phoenix',
        'San Diego', 'Dallas', 'San Jose', 'Austin', 'Jacksonville',
        'Fort Worth', 'Columbus', 'Charlotte', 'San Francisco', 'Indianapolis',
        'Seattle', 'Denver', 'Washington', 'Boston', 'Nashville',
    ];
    const TYPES = [
        'Apartment', 'Condo', 'House', 'Townhouse', 'Villa',
        'Cottage', 'Bungalow', 'Duplex', 'Triplex', 'Penthouse',
    ];

    public function __invoke($args, $assoc_args) {
        $faker = Factory::create();

        for ($i = 0; $i < self::INSERTION_COUNT; $i++) {
            $title = $faker->numberBetween(1, 5) . "-Bedroom " . $faker->word . " in " . $faker->city;
            $post_id = wp_insert_post([
                'post_title'   => $title,
                'post_content' => $faker->paragraph(5),
                'post_status'  => 'publish',
                'post_type'    => 'listing',
            ]);

            if (is_wp_error($post_id)) {
                WP_CLI::warning("Failed to insert post: " . $post_id->get_error_message());
                continue;
            }

            update_post_meta($post_id, 'price', $faker->numberBetween(100000, 1000000));
            update_post_meta($post_id, 'location', $faker->address);
            update_post_meta($post_id, 'square_feet', $faker->numberBetween(500, 5000));
            update_post_meta($post_id, 'status', $faker->randomElement(['For Sale', 'Sold', 'Pending']));
            wp_set_object_terms($post_id, $faker->randomElement(self::CITIES), 'city');
            wp_set_object_terms($post_id, $faker->randomElement(self::TYPES), 'type');

            // --with-image flag to insert random images
            if (isset($assoc_args['with-image']) && $assoc_args['with-image']) {
                if (rand(0, 1) === 0) {
                    continue;
                }

                $image_url = 'https://picsum.photos/seed/'.$i.'/600/400.jpg';
                $image_id  = media_sideload_image($image_url, $post_id, null, 'id');
                if (is_wp_error($image_id)) {
                    WP_CLI::warning("Failed to insert image: ".$image_id->get_error_message());
                    continue;
                }

                set_post_thumbnail($post_id, $image_id);
                WP_CLI::success("Inserted image for post ID: $post_id");
            }
        }

        WP_CLI::success("Inserted 1000 fake listings.");
    }

    // Command to delete all listings
    public function delete($args, $assoc_args) {
        $args = [
            'post_type' => 'listing',
            'posts_per_page' => self::POSTS_PER_PAGE,
            'post_status' => 'any',
        ];

        do {
            $query = new WP_Query($args);

            if (! $query->have_posts()) {
                break;
            }

            while ( $query->have_posts() ) {
                $query->the_post();
                wp_delete_post(get_the_ID(), true);
            }
        } while ($query->post_count !== 0);

        // --delete-cities flag to delete all cities
        if (isset($assoc_args['delete-cities']) && $assoc_args['delete-cities']) {
            $cities = get_terms(['taxonomy' => 'city', 'hide_empty' => false]);
            foreach ($cities as $city) {
                wp_delete_term($city->term_id, 'city');
            }

            WP_CLI::success("Deleted all cities.");
        }

        WP_CLI::success("Deleted all listings.");
    }
}

if (class_exists('WP_CLI') && WP_CLI) {
    WP_CLI::add_command('generate_listings', Generate_Listings_Command::class);
    WP_CLI::add_command('delete_listings', [Generate_Listings_Command::class, 'delete']);
}