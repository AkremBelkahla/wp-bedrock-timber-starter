<?php

/**
 * @package StudioAtlas\PostTypes
 */

namespace StudioAtlas\PostTypes;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Base commune à tous les Custom Post Types de Studio Atlas.
 * Chaque CPT concret ne définit que sa "slug" et ses arguments WordPress ;
 * les champs eux-mêmes sont déclarés via ACF Local JSON (voir acf-json/),
 * jamais en dur en PHP.
 */
abstract class AbstractPostType
{
    public static function register(): void
    {
        add_action('init', [static::class, 'registerPostType']);
    }

    abstract public static function registerPostType(): void;

    /**
     * Slug du post type, utilisé pour les requêtes et le nommage des vues.
     */
    abstract public static function slug(): string;
}
