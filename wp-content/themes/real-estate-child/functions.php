<?php
// Hériter des styles du thème parent
add_action('wp_enqueue_scripts', function() {
    wp_enqueue_style('real-estate-style', get_template_directory_uri() . '/style.css');
}, 10);
