<?php

/**
 * Gabarit d'archive pour le CPT "project" (liste des réalisations).
 *
 * @package StudioAtlas
 */

use StudioAtlas\PostTypes\Project;
use Timber\Timber;

$context = Timber::context();

$context['projects'] = Project::archiveContext();

Timber::render('pages/archive-project.twig', $context);
