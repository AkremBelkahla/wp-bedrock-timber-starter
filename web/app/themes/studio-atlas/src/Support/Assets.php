<?php

/**
 * @package StudioAtlas\Support
 */

namespace StudioAtlas\Support;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Chargement des assets compilés (assets/dist, généré par npm run build).
 * Aucun style inline : uniquement des fichiers CSS/JS versionnés par mtime.
 */
class Assets
{
    public static function enqueue(): void
    {
        $theme_dir = get_stylesheet_directory();
        $theme_uri = get_stylesheet_directory_uri();

        $style_path = '/assets/dist/main.css';
        $script_path = '/assets/dist/main.js';

        if (file_exists($theme_dir . $style_path)) {
            wp_enqueue_style(
                'studio-atlas',
                $theme_uri . $style_path,
                [],
                (string) filemtime($theme_dir . $style_path)
            );
        }

        if (file_exists($theme_dir . $script_path)) {
            wp_enqueue_script(
                'studio-atlas',
                $theme_uri . $script_path,
                [],
                (string) filemtime($theme_dir . $script_path),
                true
            );
        }
    }
}
