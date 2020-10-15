let mix = require('laravel-mix');
var tailwindcss = require('tailwindcss');


/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .options({
        purifyCss: true, // Remove unused CSS selectors.
        processCssUrls: false,
        postCss: [ tailwindcss('./tailwind.config.js') ],
    });

// mix.options({
//           purifyCss: true, // Remove unused CSS selectors.
//       })
//       .js('resources/js/app.js', 'public/js')
//       .minify('public/js/app.js')
//       .postCss('resources/sass/app.scss', 'public/css', [
//           atImport(),
//           tailwindcss('./tailwind.config.js')
//       ])
//       .minify('public/css/app.css')
//       .version([]);


// mix.sass('resources/sass/app.scss', 'public/css')
//     .js('resources/js/app.js', 'public/js')
//   .options({
//     purifyCss: true,
//     postCss: [ tailwindcss('./tailwind.config.js') ],
//   });
