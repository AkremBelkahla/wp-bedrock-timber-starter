<?php

/**
 * @package StudioAtlas\Forms
 */

namespace StudioAtlas\Forms;

use Timber\Timber;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Construit et envoie l'email de contact via wp_mail(), avec un corps HTML
 * rendu par Twig (views/emails/contact.twig) plutôt qu'une chaîne PHP en dur.
 */
class ContactMailer
{
    /**
     * @param array<string, string> $data Champs déjà validés (name, email, message).
     */
    public static function send(array $data): bool
    {
        $to      = get_option('admin_email');
        $subject = sprintf(__('[Studio Atlas] Nouveau message de %s', 'studio-atlas'), $data['name']);

        $body = Timber::compile('emails/contact.twig', [
            'name'    => $data['name'],
            'email'   => $data['email'],
            'message' => $data['message'],
            'site'    => get_bloginfo('name'),
        ]);

        $headers = [
            'Content-Type: text/html; charset=UTF-8',
            sprintf('Reply-To: %s <%s>', $data['name'], $data['email']),
        ];

        return wp_mail($to, $subject, $body, $headers);
    }
}
