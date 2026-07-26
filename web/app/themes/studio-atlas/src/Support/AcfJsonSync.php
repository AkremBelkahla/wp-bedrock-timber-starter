<?php

/**
 * @package StudioAtlas\Support
 */

namespace StudioAtlas\Support;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Force explicitement le point de sauvegarde/chargement ACF Local JSON vers
 * web/app/themes/studio-atlas/acf-json/, plutôt que de compter sur le
 * comportement par défaut d'ACF (qui suit le thème actif). Utile en Bedrock
 * où la structure diffère d'une install WP classique, et garantit que le
 * dossier reste stable même si le thème actif venait à changer de nom.
 *
 * Voir README > "ACF Local JSON" pour le détail du fonctionnement.
 */
class AcfJsonSync
{
    public static function register(): void
    {
        add_filter('acf/settings/save_json', [self::class, 'path']);
        add_filter('acf/settings/load_json', [self::class, 'paths']);
    }

    public static function path(): string
    {
        return get_stylesheet_directory() . '/acf-json';
    }

    public static function paths(array $paths): array
    {
        unset($paths[0]);
        $paths[] = self::path();

        return $paths;
    }
}
