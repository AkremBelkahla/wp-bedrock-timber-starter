<?php

/**
 * @package StudioAtlas\Blocks
 */

namespace StudioAtlas\Blocks;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Base commune à tous les blocs du page builder ACF Flexible Content.
 *
 * Chaque bloc concret :
 * - déclare le nom de layout ACF qu'il représente (`NAME`), qui doit
 *   correspondre exactement au layout défini dans acf-json/group_page_builder.json ;
 * - transforme les sous-champs bruts ACF en données prêtes à consommer par
 *   sa vue Twig jumelle dans views/blocks/{NAME}.twig.
 *
 * Aucune vue Twig ne doit faire de requête ou de transformation : tout passe
 * par `prepare()`.
 */
abstract class AbstractBlock
{
    /**
     * Nom du layout ACF (doit matcher acf-json).
     */
    public const NAME = '';

    /**
     * Transforme les données brutes d'un layout ACF Flexible Content
     * en tableau exploitable directement par la vue Twig du bloc.
     *
     * @param array<string, mixed> $layout Sous-champs bruts du layout courant.
     * @return array<string, mixed>
     */
    abstract public static function prepare(array $layout): array;
}
