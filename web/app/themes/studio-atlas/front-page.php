<?php

/**
 * Gabarit de la page d'accueil — même mécanique que page.php (Flexible Content),
 * dans une vue dédiée pour permettre des ajustements visuels spécifiques à la home.
 *
 * @package StudioAtlas
 */

use StudioAtlas\Blocks\BlockManager;
use Timber\Timber;

$context = Timber::context();
$post    = Timber::get_post();

$context['post']   = $post;
$context['blocks'] = BlockManager::prepareFlexibleContent($post->ID);

Timber::render('pages/front-page.twig', $context);
