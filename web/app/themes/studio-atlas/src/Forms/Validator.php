<?php

/**
 * @package StudioAtlas\Forms
 */

namespace StudioAtlas\Forms;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Validation serveur pure (aucune dépendance WordPress), testable en isolation
 * via Pest sans bootstrap WordPress complet.
 */
class Validator
{
    /**
     * @param array<string, mixed> $data
     * @return array<string, string> Erreurs indexées par nom de champ (vide si valide).
     */
    public static function validateContactForm(array $data): array
    {
        $errors = [];

        $name = trim((string) ($data['name'] ?? ''));
        if ($name === '') {
            $errors['name'] = __('Le nom est requis.', 'studio-atlas');
        }

        $email = trim((string) ($data['email'] ?? ''));
        if ($email === '') {
            $errors['email'] = __('L\'adresse email est requise.', 'studio-atlas');
        } elseif (!self::isValidEmail($email)) {
            $errors['email'] = __('L\'adresse email n\'est pas valide.', 'studio-atlas');
        }

        $message = trim((string) ($data['message'] ?? ''));
        if ($message === '') {
            $errors['message'] = __('Le message est requis.', 'studio-atlas');
        }

        return $errors;
    }

    public static function isValidEmail(string $email): bool
    {
        return (bool) preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]+$/', $email);
    }

    /**
     * Le honeypot est un champ caché (nom volontairement générique, ex.
     * "website") que seuls les bots remplissent. S'il contient une valeur,
     * la soumission est silencieusement rejetée.
     *
     * @param array<string, mixed> $data
     */
    public static function isHoneypotTriggered(array $data): bool
    {
        return trim((string) ($data['website'] ?? '')) !== '';
    }
}
