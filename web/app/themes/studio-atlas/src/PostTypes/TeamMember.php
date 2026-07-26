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
 * CPT "team_member" — Équipe de l'agence.
 * Champs ACF associés (poste, bio courte) : voir acf-json/group_team_member.json.
 * La photo utilise le thumbnail natif WordPress (post_thumbnail).
 */
class TeamMember extends AbstractPostType
{
    public static function slug(): string
    {
        return 'team_member';
    }

    public static function registerPostType(): void
    {
        register_post_type(self::slug(), [
            'label'        => __('Équipe', 'studio-atlas'),
            'labels'       => [
                'name'          => __('Équipe', 'studio-atlas'),
                'singular_name' => __('Membre de l\'équipe', 'studio-atlas'),
                'add_new_item'  => __('Ajouter un membre', 'studio-atlas'),
                'edit_item'     => __('Modifier le membre', 'studio-atlas'),
            ],
            'public'       => true,
            'has_archive'  => false,
            'show_in_rest' => true,
            'menu_icon'    => 'dashicons-groups',
            'rewrite'      => ['slug' => 'equipe'],
            'supports'     => ['title', 'thumbnail'],
        ]);
    }

    /**
     * Récupère un ensemble de membres par ID, pour le bloc "Section équipe"
     * (relation ACF vers ce CPT).
     *
     * @param int[] $ids
     * @return \Timber\Post[]
     */
    public static function byIds(array $ids): array
    {
        if (empty($ids)) {
            return [];
        }

        return Timber::get_posts([
            'post_type' => self::slug(),
            'post__in'  => $ids,
            'orderby'   => 'post__in',
        ])->to_array();
    }

    /**
     * Prépare les données ACF d'un membre pour les composants Twig.
     *
     * @return array<string, mixed>
     */
    public static function context(int $post_id): array
    {
        return [
            'role'       => get_field('role', $post_id),
            'short_bio'  => get_field('short_bio', $post_id),
        ];
    }
}
