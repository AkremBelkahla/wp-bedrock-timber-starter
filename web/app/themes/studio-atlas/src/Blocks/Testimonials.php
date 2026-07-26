<?php

/**
 * @package StudioAtlas\Blocks
 */

namespace StudioAtlas\Blocks;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Bloc "Témoignages" — répéteur ACF (citation, auteur, poste).
 * Champs ACF : voir acf-json/group_page_builder.json > layout "testimonials".
 */
class Testimonials extends AbstractBlock
{
    public const NAME = 'testimonials';

    public static function prepare(array $layout): array
    {
        $items = $layout['items'] ?? [];

        $testimonials = array_map(static function (array $item): array {
            return [
                'quote'  => $item['quote'] ?? '',
                'author' => $item['author'] ?? '',
                'role'   => $item['role'] ?? '',
            ];
        }, $items);

        return [
            'title'        => $layout['title'] ?? '',
            'testimonials' => $testimonials,
        ];
    }
}
