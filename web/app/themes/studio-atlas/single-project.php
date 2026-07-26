<?php

/**
 * Gabarit de fiche projet (CPT "project").
 * Toute la logique de récupération/transformation des champs ACF
 * (galerie, client, année, catégorie...) vit dans StudioAtlas\PostTypes\Project.
 *
 * @package StudioAtlas
 */

use StudioAtlas\PostTypes\Project;
use Timber\Timber;

$context = Timber::context();
$post    = Timber::get_post();

$context['post']    = $post;
$context['project'] = Project::context($post->ID);

Timber::render('pages/single-project.twig', $context);
