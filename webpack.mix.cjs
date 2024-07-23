const mix = require('laravel-mix');

// Minify existing CSS files in the public/css directory
mix.styles([
    'public/assets/css/demo.css',
    // vendor
    'public/assets/vendor/css/core.css',
    'public/assets/vendor/css/theme-default.css',
    'public/assets/vendor/css/pages/page-account-settings.css',
    'public/assets/vendor/css/pages/page-auth.css',
    'public/assets/vendor/css/pages/page-icons.css',
    'public/assets/vendor/css/pages/page-misc.css',

    // fonts
    'public/assets/vendor/fonts/boxicons.css',

    // libs
    'public/assets/vendor/libs/apex-charts/apex-charts.css',
    'public/assets/vendor/libs/highlight/highlight.css',
    'public/assets/vendor/libs/highlight/highlight-github.css',
    'public/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css'
    // Ajoutez d'autres fichiers CSS si nécessaire
], 'public/assets/styles.min.css');

// Minify existing JavaScript files in the public/js directory
mix.scripts([
    'public/assets/js/chart.js',
    'public/assets/js/config.js',
    'public/assets/js/dashboards-analytics.js',
    'public/assets/js/extended-ui-perfect-scrollbar.js',
    'public/assets/js/form-basic-inputs.js',
    'public/assets/js/main.js',
    'public/assets/js/pages-account-settings-account.js',
    'public/assets/js/ui-modals.js',
    'public/assets/js/ui-popover.js',
    'public/assets/js/ui-toasts.js',
    // vendor
    'public/assets/vendor/js/bootstrap.js',
    'public/assets/vendor/js/helpers.js',
    'public/assets/vendor/js/menu.js',

    // libs
    'public/assets/vendor/libs/apex-charts/apexcharts.js',
    'public/assets/vendor/libs/highlight/highlight.js',
    'public/assets/vendor/libs/jquery/jquery.js',
    'public/assets/vendor/libs/masonry/masonry.js',
    'public/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js',
    'public/assets/vendor/libs/popper/popper.js'
    // Ajoutez d'autres fichiers JS si nécessaire
], 'public/assets/javascripts.min.js');

// Minify additional JavaScript files in js_pie_chart directory
// mix.scripts([
//     'public/js_pie_chart/pie_chart.js',
//     // Ajoutez d'autres fichiers JS de ce dossier si nécessaire
// ], 'public/js_pie_chart/pie_chart.min.js');

// Optionally, version the files for cache busting
if (mix.inProduction()) {
    mix.version();
}
