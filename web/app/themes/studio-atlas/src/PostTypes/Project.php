<?php

/**
 * @package StudioAtlas\PostTypes
 */

namespace StudioAtlas\PostTypes;

use StudioAtlas\Support\ImageHelper;
use Timber\Timber;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * CPT "project" — Réalisations de l'agence.
 * Champs ACF associés (galerie, client, année, description, catégorie) :
 * voir acf-json/group_project.json.
 */
class Project extends AbstractPostType
{
    public static function slug(): string
    {
        return 'project';
    }

    public static function registerPostType(): void
    {
        register_post_type(self::slug(), [
            'label'        => __('Réalisations', 'studio-atlas'),
            'labels'       => [
                'name'          => __('Réalisations', 'studio-atlas'),
                'singular_name' => __('Réalisation', 'studio-atlas'),
                'add_new_item'  => __('Ajouter une réalisation', 'studio-atlas'),
                'edit_item'     => __('Modifier la réalisation', 'studio-atlas'),
            ],
            'public'       => true,
            'has_archive'  => true,
            'show_in_rest' => true,
            'menu_icon'    => 'dashicons-building',
            'rewrite'      => ['slug' => 'realisations'],
            'supports'     => ['title', 'thumbnail', 'excerpt'],
            'taxonomies'   => ['project_category'],
        ]);

        register_taxonomy('project_category', self::slug(), [
            'label'        => __('Catégories de réalisations', 'studio-atlas'),
            'public'       => true,
            'hierarchical' => true,
            'show_in_rest' => true,
            'rewrite'      => ['slug' => 'realisations-categorie'],
        ]);
    }

    /**
     * Prépare les données ACF d'un projet pour la vue single-project.twig.
     * Aucune requête/logique dans le Twig : tout est résolu ici.
     *
     * @return array<string, mixed>
     */
    public static function context(int $post_id): array
    {
        return [
            'gallery'     => ImageHelper::toGallery(get_field('gallery', $post_id)),
            'client'      => get_field('client', $post_id),
            'year'        => get_field('year', $post_id),
            'description' => get_field('description', $post_id),
            'categories'  => wp_get_post_terms($post_id, 'project_category'),
        ];
    }

    /**
     * Liste des projets pour l'archive CPT.
     *
     * @return \Timber\Post[]
     */
    public static function archiveContext(): array
    {
        return Timber::get_posts([
            'post_type'      => self::slug(),
            'posts_per_page' => -1,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ])->to_array();
    }

    /**
     * Les N dernières réalisations, utilisées par le bloc "Grille de projets".
     *
     * @return \Timber\Post[]
     */
    public static function latest(int $count = 3): array
    {
        return Timber::get_posts([
            'post_type'      => self::slug(),
            'posts_per_page' => $count,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ])->to_array();
    }
}
