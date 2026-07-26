<?php

/**
 * @package StudioAtlas\Forms
 */

namespace StudioAtlas\Forms;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Route Handler custom pour le formulaire de contact — pas de plugin, pas
 * d'admin-ajax.php. On intercepte la requête POST au plus tôt (template_redirect,
 * priorité 1) via un champ caché unique au formulaire, avant tout rendu de
 * template, puis on répond soit en JSON (appel fetch, voir assets/scripts/main.js)
 * soit par une redirection classique (fonctionnement sans JavaScript).
 */
class ContactFormRouteHandler
{
    private const NONCE_ACTION = 'studio_atlas_contact';
    private const FIELD_MARKER = 'studio_atlas_contact_submit';

    public static function register(): void
    {
        add_action('template_redirect', [self::class, 'handle'], 1);
    }

    public static function handle(): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST' || !isset($_POST[self::FIELD_MARKER])) {
            return;
        }

        $nonce = (string) ($_POST['studio_atlas_contact_nonce'] ?? '');

        if (!wp_verify_nonce($nonce, self::NONCE_ACTION)) {
            self::respond(false, ['form' => __('Formulaire expiré, merci de réessayer.', 'studio-atlas')]);
            return;
        }

        // Honeypot : réponse "succès" silencieuse pour ne pas guider les bots,
        // sans jamais envoyer l'email.
        if (Validator::isHoneypotTriggered($_POST)) {
            self::respond(true, [], __('Merci, votre message a bien été envoyé.', 'studio-atlas'));
            return;
        }

        $errors = Validator::validateContactForm($_POST);

        if (!empty($errors)) {
            self::respond(false, $errors);
            return;
        }

        $sent = ContactMailer::send([
            'name'    => sanitize_text_field(wp_unslash($_POST['name'])),
            'email'   => sanitize_email(wp_unslash($_POST['email'])),
            'message' => sanitize_textarea_field(wp_unslash($_POST['message'])),
        ]);

        if (!$sent) {
            self::respond(false, ['form' => __('L\'envoi a échoué, merci de réessayer plus tard.', 'studio-atlas')]);
            return;
        }

        self::respond(true, [], __('Merci, votre message a bien été envoyé.', 'studio-atlas'));
    }

    /**
     * @param array<string, string> $errors
     */
    private static function respond(bool $success, array $errors = [], string $message = ''): void
    {
        $wants_json = self::wantsJson();

        if ($wants_json) {
            status_header($success ? 200 : 422);
            wp_send_json([
                'success' => $success,
                'message' => $message !== '' ? $message : self::firstError($errors),
                'errors'  => $errors,
            ]);

            return;
        }

        $redirect_url = add_query_arg(
            'contact',
            $success ? 'success' : 'error',
            wp_get_referer() ?: home_url('/contact')
        );

        wp_safe_redirect($redirect_url);
        exit;
    }

    private static function wantsJson(): bool
    {
        $accept = $_SERVER['HTTP_ACCEPT'] ?? '';

        return is_string($accept) && strpos($accept, 'application/json') !== false;
    }

    /**
     * @param array<string, string> $errors
     */
    private static function firstError(array $errors): string
    {
        $values = array_values($errors);

        return $values[0] ?? __('Une erreur est survenue.', 'studio-atlas');
    }

    public static function nonceField(): string
    {
        return wp_nonce_field(self::NONCE_ACTION, 'studio_atlas_contact_nonce', true, false);
    }

    public static function fieldMarker(): string
    {
        return self::FIELD_MARKER;
    }
}
