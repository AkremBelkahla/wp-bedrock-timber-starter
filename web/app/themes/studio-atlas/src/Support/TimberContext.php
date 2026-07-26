<?php

/**
 * @package StudioAtlas\Support
 */

namespace StudioAtlas\Support;

use Timber\Menu;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enrichit le contexte global Timber (disponible dans toutes les vues Twig)
 * avec les menus et les données globales de l'agence.
 * `site` est déjà fourni par Timber lui-même avant l'exécution de ce filtre.
 * Aucune requête ou logique métier ne doit apparaître dans les fichiers .twig :
 * tout est préparé ici ou dans les Blocks/PostTypes correspondants.
 */
class TimberContext
{
    public static function add(array $context): array
    {
        $context['menu_primary'] = new Menu('primary');
        $context['menu_footer']  = new Menu('footer');

        $context['contact_form_action'] = home_url('/contact');

        return $context;
    }
}
