<?php

/**
 * Gabarit "page" — utilise le page builder ACF Flexible Content.
 * Toute la préparation de données (récupération + transformation) est faite
 * par StudioAtlas\Blocks\BlockManager ; page.twig ne fait que boucler.
 *
 * @package StudioAtlas
 */

use StudioAtlas\Blocks\BlockManager;
use Timber\Timber;

$context = Timber::context();
$post    = Timber::get_post();

$context['post']   = $post;
$context['blocks'] = BlockManager::prepareFlexibleContent($post->ID);

Timber::render('pages/page.twig', $context);
