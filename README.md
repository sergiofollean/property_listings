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
