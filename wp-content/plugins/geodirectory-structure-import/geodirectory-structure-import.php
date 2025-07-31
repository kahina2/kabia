<?php
/*
Plugin Name: Import Structures (GeoDirectory)
Description: Importe des structures dans GeoDirectory via wp_insert_post() en évitant les doublons de SIREN.
Version: 1.0
Author: Nuxly Bayonne
*/

class Import_Structures_GeoDirectory {
    private $import_count = 0;
    private $skipped = [];

    public function __construct() {
        add_action('admin_menu', [$this, 'register_admin_menu']);
    }

    public function register_admin_menu() {
        add_menu_page(
            'Import Structures',
            'Import Structures',
            'manage_options',
            'import-structures-gd',
            [$this, 'render_import_page']
        );
    }

    private function generate_skipped_csv() {
        $upload_dir = wp_upload_dir();
        $filename = 'siren_ignores_' . time() . '.csv';
        $filepath = trailingslashit($upload_dir['basedir']) . $filename;

        $file = fopen($filepath, 'w');
        if ($file === false) return '';

        fputcsv($file, ['SIREN']);
        foreach ($this->skipped as $siren) {
            fputcsv($file, [$siren]);
        }
        fclose($file);

        return trailingslashit($upload_dir['baseurl']) . $filename;
    }

    public function render_import_page() {
        if (!current_user_can('manage_options')) return;

        echo '<div class="wrap"><h1>Importer des structures dans GeoDirectory</h1>';

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['structure_file'])) {
            $this->handle_csv_import($_FILES['structure_file']);
        }

        echo '<form method="post" enctype="multipart/form-data">';
        echo '<input type="file" name="structure_file" required> ';
        echo '<input type="submit" class="button button-primary" value="Importer">';
        echo '</form>';

        if ($this->import_count > 0 || count($this->skipped) > 0) {
            echo '<div class="notice notice-info"><h2>Résultat de l’import :</h2><ul>';
            echo '<li><strong>' . esc_html($this->import_count) . '</strong> structure(s) importée(s).</li>';
            if (!empty($this->skipped)) {
                echo '<li><strong>' . count($this->skipped) . '</strong> structure(s) ignorée(s) car le SIREN existe déjà :</li>';
                echo '<ul>';
                foreach ($this->skipped as $siren) {
                    echo '<li>SIREN déjà existant : ' . esc_html($siren) . '</li>';
                }
                echo '</ul>';
                $csv_url = $this->generate_skipped_csv();
                echo '<p><a href="' . esc_url($csv_url) . '" class="button">📥 Télécharger les SIREN ignorés</a></p>';
            }
            echo '</ul></div>';
        }

        echo '</div>';
    }

    private function handle_csv_import($file) {
        if ($file['error'] !== 0) {
            echo '<div class="notice notice-error"><p>Erreur lors du téléchargement du fichier. </p></div>';
            return;
        }

        $csv = array_map('str_getcsv', file($file['tmp_name']));
        echo "<script>console.log('CSV brut : ' + " . json_encode(file_get_contents($file['tmp_name'])) . ");</script>";
        $headers = array_map('trim', $csv[0]);
        unset($csv[0]);

        foreach ($csv as $row) {
            $row = array_combine($headers, $row);
            $this->import_row($row);
        }
    }

    private function import_row($row) {
        global $wpdb;
        $siren = trim($row['SIREN'] ?? '');
        if (empty($siren)) return;

        $exists = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM {$wpdb->prefix}geodir_gd_place_detail WHERE siren = %s",
            $siren
        ));

        if ($exists > 0) {
            $this->skipped[] = $siren;
            return;
        }

        $user_id = get_current_user_id(); // Utilisateur courant ou admin par défaut

        $post_id = wp_insert_post([
            'post_type'        => 'gd_place',
            'post_title'       => $row['RAISON SOCIALE'] ?? 'Structure',
            'post_status'      => 'draft', // ou 'pending' si vous préférez
            'post_author'      => $user_id,
            'meta_input'       => [
                'region'           => 'Nouvelle-Aquitaine',
                'city'             => $row['VILLE'] ?? '',
                'zip'              => $row['CP'] ?? '',
                'country'          => 'France',
                'siren'            => $siren,
                'raison_sociale'   => $row['RAISON SOCIALE'] ?? '',
                'statut_juridique' => $row['STATUT JURIDIQUE'] ?? '',
                'pole_territorial' => $row['PÔLE TERRITORIAL'] ?? '',
                'sdsei'            => $row['SDSEI'] ?? '',
                'utd'              => $row['UTD'] ?? '',
            ],
        ]);

        if (!is_wp_error($post_id)) {
            $this->import_count++;
        }
    }
}

new Import_Structures_GeoDirectory();
