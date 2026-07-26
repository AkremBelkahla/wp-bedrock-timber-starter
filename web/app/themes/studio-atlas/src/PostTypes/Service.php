<?php

/**
 * @package StudioAtlas\PostTypes
 */

namespace StudioAtlas\PostTypes;

use Timber\Timber;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * CPT "service" — Prestations proposées par l'agence.
 * Champs ACF associés (icône, description) : voir acf-json/group_service.json.
 */
class Service extends AbstractPostType
{
    public static function slug(): string
    {
        return 'service';
    }

    public static function registerPostType(): void
    {
        register_post_type(self::slug(), [
            'label'        => __('Services', 'studio-atlas'),
            'labels'       => [
                'name'          => __('Services', 'studio-atlas'),
                'singular_name' => __('Service', 'studio-atlas'),
                'add_new_item'  => __('Ajouter un service', 'studio-atlas'),
                'edit_item'     => __('Modifier le service', 'studio-atlas'),
            ],
            'public'       => true,
            'has_archive'  => false,
            'show_in_rest' => true,
            'menu_icon'    => 'dashicons-hammer',
            'rewrite'      => ['slug' => 'services'],
            'supports'     => ['title'],
        ]);
    }

    /**
     * Prépare les données ACF d'un service pour les composants Twig.
     *
     * @return array<string, mixed>
     */
    public static function context(int $post_id): array
    {
        return [
            'icon'        => get_field('icon', $post_id),
            'description' => get_field('description', $post_id),
        ];
    }

    /**
     * @return \Timber\Post[]
     */
    public static function all(): array
    {
        return Timber::get_posts([
            'post_type'      => self::slug(),
            'posts_per_page' => -1,
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
        ])->to_array();
    }
}
