<?php

/**
 * Gabarit de la page "Contact" (WordPress résout automatiquement ce fichier
 * pour la page dont le slug est "contact", cf. hiérarchie de templates).
 * Le traitement de la soumission est intercepté avant même l'exécution de ce
 * fichier par StudioAtlas\Forms\ContactFormRouteHandler (template_redirect).
 *
 * @package StudioAtlas
 */

use StudioAtlas\Blocks\BlockManager;
use StudioAtlas\Forms\ContactFormRouteHandler;
use Timber\Timber;

$context = Timber::context();
$post    = Timber::get_post();

$context['post']   = $post;
$context['blocks'] = BlockManager::prepareFlexibleContent($post->ID);

$context['contact_form'] = [
    'nonce_field'  => ContactFormRouteHandler::nonceField(),
    'field_marker' => ContactFormRouteHandler::fieldMarker(),
    'status'       => sanitize_text_field(wp_unslash($_GET['contact'] ?? '')),
];

Timber::render('pages/contact.twig', $context);
