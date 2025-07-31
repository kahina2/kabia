<?php
/**
 * Plugin Name: Override Menu Wrapper
 * Description: Remplace le contenu du bloc menu-wrapper avec un titre personnalisé.
 * Version: 1.0
 * Author: ChatGPT
 */

// Use a higher priority than the theme's filter (15) so this override wins.
add_filter('real_estate_listings_pattern_menu_wrapper', function() {
    return '
    <!-- wp:blockstrap/blockstrap-widget-navbar-brand {"text":"<span class=\"text-primary\"><i class=\"fas fa-home\"></i> Structure</span> ESS","img_max_width":150,"custom_url":"/","brand_font_size":"h4","brand_font_weight":"font-weight-bold"} /-->
    ';
}, 20);
