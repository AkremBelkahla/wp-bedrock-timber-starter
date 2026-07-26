<?php

/**
 * @package StudioAtlas\Blocks
 */

namespace StudioAtlas\Blocks;

use StudioAtlas\PostTypes\TeamMember;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Bloc "Section équipe" — relation ACF vers le CPT TeamMember.
 * Champs ACF : voir acf-json/group_page_builder.json > layout "team_section".
 */
class TeamSection extends AbstractBlock
{
    public const NAME = 'team_section';

    public static function prepare(array $layout): array
    {
        $related = $layout['members'] ?? [];
        $ids     = wp_list_pluck($related, 'ID');

        $members = TeamMember::byIds($ids);

        $members = array_map(static function ($member) {
            $member->extra = TeamMember::context($member->ID);
            return $member;
        }, $members);

        return [
            'title'   => $layout['title'] ?? '',
            'members' => $members,
        ];
    }
}
