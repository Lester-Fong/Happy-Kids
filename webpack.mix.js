const mix = require("laravel-mix");

mix.sourceMaps();

mix.js("resources/js/app.js", "public/js").vue()
    .sass("resources/sass/main.scss", "public/css/")

mix.webpackConfig({
    output: {
        publicPath: "/public/",
        chunkFilename: "[name].bundle.js?id=[contenthash]",
    },
    optimization: {
        splitChunks: {
            automaticNameDelimiter: "-",
            name: false,
        },
    },
});
