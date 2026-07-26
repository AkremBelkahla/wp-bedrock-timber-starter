<?php

/**
 * @package StudioAtlas\Support
 */

namespace StudioAtlas\Support;

use Timber\Image;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Normalise les champs image ACF (tableau brut, ID ou faux) en Timber\Image,
 * pour que les vues Twig n'aient jamais à vérifier le type du champ.
 */
class ImageHelper
{
    /**
     * @param array|int|false|null $field Valeur brute d'un champ ACF de type "image".
     */
    public static function toTimberImage($field): ?Image
    {
        if (empty($field)) {
            return null;
        }

        $id = is_array($field) ? ($field['ID'] ?? $field['id'] ?? null) : $field;

        if (!$id) {
            return null;
        }

        return new Image($id);
    }

    /**
     * Transforme un répéteur ACF d'images (galerie) en tableau de Timber\Image.
     *
     * @param array<int, array|int>|null $gallery
     * @return Image[]
     */
    public static function toGallery(?array $gallery): array
    {
        if (empty($gallery)) {
            return [];
        }

        $images = array_map([self::class, 'toTimberImage'], $gallery);

        return array_values(array_filter($images));
    }
}
