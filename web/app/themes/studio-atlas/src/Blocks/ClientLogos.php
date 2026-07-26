<?php

/**
 * @package StudioAtlas\Blocks
 */

namespace StudioAtlas\Blocks;

use StudioAtlas\Support\ImageHelper;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Bloc "Logos clients" — répéteur ACF d'images.
 * Champs ACF : voir acf-json/group_page_builder.json > layout "client_logos".
 */
class ClientLogos extends AbstractBlock
{
    public const NAME = 'client_logos';

    public static function prepare(array $layout): array
    {
        $items = $layout['logos'] ?? [];

        $logos = array_map(static function (array $item) {
            return ImageHelper::toTimberImage($item['logo'] ?? null);
        }, $items);

        return [
            'title' => $layout['title'] ?? '',
            'logos' => array_values(array_filter($logos)),
        ];
    }
}
