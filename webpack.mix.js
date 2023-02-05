const mix = require("laravel-mix");

mix.js("resources/js/app.js", "public/js").vue({ version: 2 });

mix.styles(["public/css/main.css"], "public/css/all.css");
