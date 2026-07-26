<?php

/**
 * @package StudioAtlas\Blocks
 */

namespace StudioAtlas\Blocks;

use StudioAtlas\PostTypes\Project;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Bloc "Grille de projets" — sélection manuelle ou automatique des N derniers
 * Project. Champs ACF : voir acf-json/group_page_builder.json > layout "project_grid".
 */
class ProjectGrid extends AbstractBlock
{
    public const NAME = 'project_grid';

    public static function prepare(array $layout): array
    {
        $mode = $layout['selection_mode'] ?? 'automatic';

        if ($mode === 'manual' && !empty($layout['projects'])) {
            $ids = wp_list_pluck($layout['projects'], 'ID');
            $projects = \Timber\Timber::get_posts([
                'post_type' => Project::slug(),
                'post__in'  => $ids,
                'orderby'   => 'post__in',
            ])->to_array();
        } else {
            $projects = Project::latest((int) ($layout['count'] ?? 3));
        }

        return [
            'title'    => $layout['title'] ?? '',
            'projects' => $projects,
        ];
    }
}
