<?php

/**
 * Bootstrap du thème Studio Atlas.
 *
 * Le chargement de Timber, l'autoload PSR-4 de src/ et l'enregistrement des
 * CPT / blocs / formulaire se font dans le mu-plugin
 * web/app/mu-plugins/studio-atlas-loader.php (toujours actif, indépendant du thème).
 *
 * Ce fichier ne contient que ce qui est strictement lié au thème actif :
 * theme supports, menus, chargement des assets compilés et enrichissement
 * du contexte Timber.
 *
 * @package StudioAtlas
 */

namespace StudioAtlas;

use StudioAtlas\Support\AcfJsonSync;
use StudioAtlas\Support\Assets;
use StudioAtlas\Support\TimberContext;

if (!defined('ABSPATH')) {
    exit;
}

AcfJsonSync::register();

add_action('after_setup_theme', static function (): void {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');

    register_nav_menus([
        'primary' => __('Menu principal', 'studio-atlas'),
        'footer'  => __('Menu de pied de page', 'studio-atlas'),
    ]);
});

add_action('wp_enqueue_scripts', [Assets::class, 'enqueue']);

add_filter('timber/context', [TimberContext::class, 'add']);

/**
 * Twig est réservé au rendu : on désactive volontairement l'éditeur classique
 * de blocs Gutenberg pour les pages qui utilisent le page builder ACF, pour
 * éviter toute tentation d'ajouter du contenu/CSS hors du système de blocs.
 */
add_filter('use_block_editor_for_post_type', static function (bool $use_block_editor, string $post_type): bool {
    if ($post_type === 'page') {
        return false;
    }

    return $use_block_editor;
}, 10, 2);
