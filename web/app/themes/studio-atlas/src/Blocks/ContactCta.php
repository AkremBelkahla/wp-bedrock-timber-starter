<?php

/**
 * @package StudioAtlas\Blocks
 */

namespace StudioAtlas\Blocks;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Bloc "CTA de contact" — titre, texte, bouton (ancre vers le formulaire ou lien externe).
 * Champs ACF : voir acf-json/group_page_builder.json > layout "contact_cta".
 */
class ContactCta extends AbstractBlock
{
    public const NAME = 'contact_cta';

    public static function prepare(array $layout): array
    {
        return [
            'title'     => $layout['title'] ?? '',
            'text'      => $layout['text'] ?? '',
            'cta_label' => $layout['cta_label'] ?? '',
            'cta_url'   => $layout['cta_url'] ?? home_url('/contact'),
        ];
    }
}
