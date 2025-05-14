# Getting started

1. Install composer packages using `composer install`
2. Install NPM packages using `npm install`
3. Watch file changes using `npm run dev`

## Notes

- ACF and Twig are installed using Composer
- Please ensure ACF fields are registered or exported using PHP
- Tailwind is preconfigured
- Twig is preconfigured to utilise the `./templates` directory (you do not have to use it)
- You can obtain a Twig instance using the method `rel_get_twig()`
- Faker is also installed via composer should you wish to use it to generate dummy data

## Performance considerations
- Core functionality is split into includes/ to ensure maintainable, readable, and scalable code
- All WP_Query instances use selective fields and batching (e.g., paginated deletes) to reduce memory usage and improve performance
- The "View Listing" button uses the wp-element-button class for consistent styling with WordPress block themes, avoiding redundant custom styles

## WP CLI Commands
**wp generate_listings**\
Creates 1000 random listings with fake data (title, price, city, status, etc.).

**wp generate_listings --with-image**\
Creates 1000 listings and attaches random featured images

**wp delete_listings**\
delete all listing posts

**wp delete_listings --delete-cities**\
delete all listing posts and citiy terms