<?php
/*
Plugin Name: Tableau de Bord GeoDirectory
Description: Dashboard personnalisé pour afficher les stats des lieux GeoDirectory.
Version: 1.0
Author: TonNom
*/

if (!defined('ABSPATH')) exit;

// Ajouter le menu admin
add_action('admin_menu', function() {
    add_menu_page(
        'Dashboard GeoDirectory',
        'Stats GeoDirectory',
        'manage_options',
        'mpd-dashboard',
        'mpd_afficher_dashboard',
        'dashicons-chart-area',
        3
    );
});

// Charger Bootstrap + Chart.js + custom
add_action('admin_enqueue_scripts', function($hook) {
    if ($hook !== 'toplevel_page_mpd-dashboard') return;

    wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css');
    wp_enqueue_script('chartjs', 'https://cdn.jsdelivr.net/npm/chart.js', [], null, true);
    wp_enqueue_script('mpd-js', plugins_url('assets/dashboard.js', __FILE__), ['jquery', 'chartjs'], null, true);
});

// Affichage du dashboard
function mpd_afficher_dashboard() {
    include plugin_dir_path(__FILE__) . 'templates/dashboard.php';
}