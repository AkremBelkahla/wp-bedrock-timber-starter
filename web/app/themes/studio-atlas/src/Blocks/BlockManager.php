<?php

/**
 * @package StudioAtlas\Blocks
 */

namespace StudioAtlas\Blocks;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Registre central des blocs du page builder ACF Flexible Content.
 *
 * Le champ ACF "flexible_content" (voir acf-json/group_page_builder.json) est
 * attaché aux pages. Chaque layout choisi en admin est résolu ici vers sa
 * classe StudioAtlas\Blocks\* correspondante, qui prépare les données ; le
 * résultat est une liste simple `[ ['type' => ..., 'data' => ...], ... ]`
 * consommée par views/pages/page.twig (ou front-page.twig) via :
 *
 *   {% include 'blocks/' ~ block.type ~ '.twig' with block.data %}
 */
class BlockManager
{
    /**
     * @var array<string, class-string<AbstractBlock>>
     */
    private const BLOCKS = [
        Hero::NAME            => Hero::class,
        ProjectGrid::NAME     => ProjectGrid::class,
        Testimonials::NAME    => Testimonials::class,
        ContactCta::NAME      => ContactCta::class,
        ClientLogos::NAME     => ClientLogos::class,
        TeamSection::NAME     => TeamSection::class,
    ];

    public static function register(): void
    {
        // Point d'extension : c'est ici que d'éventuels blocs ACF natifs
        // (acf_register_block_type) seraient enregistrés si le page builder
        // évoluait vers Gutenberg. Le Flexible Content actuel ne nécessite
        // aucun enregistrement PHP côté champ, tout vient d'acf-json/.
    }

    /**
     * @return array<int, array{type: string, data: array<string, mixed>}>
     */
    public static function prepareFlexibleContent(int $post_id): array
    {
        $layouts = get_field('flexible_content', $post_id);

        if (empty($layouts) || !is_array($layouts)) {
            return [];
        }

        $blocks = [];

        foreach ($layouts as $layout) {
            $name = $layout['acf_fc_layout'] ?? null;

            if (!$name || !isset(self::BLOCKS[$name])) {
                continue;
            }

            $class = self::BLOCKS[$name];

            $blocks[] = [
                'type' => $name,
                'data' => $class::prepare($layout),
            ];
        }

        return $blocks;
    }
}
