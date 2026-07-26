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
 * Bloc "Hero" — titre, sous-titre, image de fond, CTA.
 * Champs ACF : voir acf-json/group_page_builder.json > layout "hero".
 */
class Hero extends AbstractBlock
{
    public const NAME = 'hero';

    public static function prepare(array $layout): array
    {
        return [
            'title'         => $layout['title'] ?? '',
            'subtitle'      => $layout['subtitle'] ?? '',
            'background'    => ImageHelper::toTimberImage($layout['background_image'] ?? null),
            'cta_label'     => $layout['cta_label'] ?? '',
            'cta_url'       => $layout['cta_url'] ?? '',
        ];
    }
}
