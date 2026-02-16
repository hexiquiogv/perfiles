const mix = require('laravel-mix');

mix.copy('resources/images','public/images')
   .copy('resources/font_awesome','public/font_awesome')
   .copy('resources/MDB','public/MDB');
