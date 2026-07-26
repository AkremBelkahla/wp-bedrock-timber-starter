<?php

/**
 * Plugin Name: Studio Atlas — Loader
 * Description: Bootstrap de Timber et autoload PSR-4 du code custom du thème (src/).
 *              Vit en mu-plugin pour garantir qu'il est toujours actif, indépendamment
 *              du thème sélectionné en admin — le rendu Twig et les CPT ne doivent
 *              jamais pouvoir être désactivés par erreur.
 *
 * @package StudioAtlas
 */

namespace StudioAtlas\Loader;

if (!defined('ABSPATH')) {
    exit;
}

const THEME_SLUG      = 'studio-atlas';
const THEME_NAMESPACE = 'StudioAtlas';

/**
 * Autoload PSR-4 minimal pour StudioAtlas\* => web/app/themes/studio-atlas/src/*
 * On évite une dépendance à un composer.json de thème séparé : le mu-plugin
 * est le point d'entrée unique et garantit que les classes sont disponibles
 * même si le thème actif change.
 */
spl_autoload_register(static function (string $class): void {
    if (strpos($class, THEME_NAMESPACE . '\\') !== 0) {
        return;
    }

    $relative = substr($class, strlen(THEME_NAMESPACE . '\\'));
    $path     = get_theme_root() . '/' . THEME_SLUG . '/src/' . str_replace('\\', '/', $relative) . '.php';

    if (file_exists($path)) {
        require_once $path;
    }
});

/**
 * Timber est requis via Composer (timber/timber) dans le composer.json racine.
 * On vérifie sa présence pour échouer explicitement plutôt que fataler en silence.
 */
add_action('after_setup_theme', static function (): void {
    if (!class_exists('Timber\Timber')) {
        add_action('admin_notices', static function (): void {
            echo '<div class="notice notice-error"><p>' .
                esc_html__('Timber n\'est pas chargé. Lancez "composer install" à la racine du projet.', 'studio-atlas') .
                '</p></div>';
        });

        return;
    }

    \Timber\Timber::init();

    // Les vues Twig du thème actif sont ajoutées automatiquement par Timber ;
    // on complète avec les emails, communs à tous les thèmes potentiels.
    $locations = \Timber\Timber::$locations ?? [];
    $locations[] = get_theme_root() . '/' . THEME_SLUG . '/views/emails';
    \Timber\Timber::$locations = $locations;
}, 1);

/**
 * Enregistrement des CPT, blocs ACF et du formulaire de contact.
 * Chaque module s'enregistre lui-même via sa méthode statique register().
 */
add_action('after_setup_theme', static function (): void {
    $modules = [
        \StudioAtlas\PostTypes\Project::class,
        \StudioAtlas\PostTypes\TeamMember::class,
        \StudioAtlas\PostTypes\Service::class,
        \StudioAtlas\Blocks\BlockManager::class,
        \StudioAtlas\Forms\ContactFormRouteHandler::class,
    ];

    foreach ($modules as $module) {
        if (method_exists($module, 'register')) {
            $module::register();
        }
    }
}, 5);
