<?php

/**
 * Template WordPress par défaut (fallback de la hiérarchie de templates).
 * Aucune logique ici : seul point de contact entre WordPress et Timber.
 *
 * @package StudioAtlas
 */

use Timber\Timber;

$context = Timber::context();

Timber::render('pages/page.twig', $context);
