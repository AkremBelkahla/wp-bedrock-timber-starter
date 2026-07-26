<?php

/**
 * Bootstrap de test — stubs minimalistes des fonctions WordPress utilisées
 * par la logique métier custom testée. Volontairement PAS un bootstrap WP
 * complet : on ne teste jamais le core (voir README > Tests). Chaque fonction
 * ci-dessous est une réimplémentation naïve, suffisante pour les assertions.
 */

if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/../');
}

if (!function_exists('__')) {
    function __(string $text, string $domain = 'default'): string
    {
        return $text;
    }
}

if (!function_exists('esc_html__')) {
    function esc_html__(string $text, string $domain = 'default'): string
    {
        return $text;
    }
}

if (!function_exists('home_url')) {
    function home_url(string $path = ''): string
    {
        return 'https://studio-atlas.test' . $path;
    }
}

if (!function_exists('sanitize_text_field')) {
    function sanitize_text_field(string $value): string
    {
        return trim(strip_tags($value));
    }
}

if (!function_exists('sanitize_textarea_field')) {
    function sanitize_textarea_field(string $value): string
    {
        return trim($value);
    }
}

if (!function_exists('sanitize_email')) {
    function sanitize_email(string $value): string
    {
        return filter_var($value, FILTER_SANITIZE_EMAIL);
    }
}

if (!function_exists('wp_unslash')) {
    function wp_unslash($value)
    {
        return $value;
    }
}

if (!function_exists('wp_list_pluck')) {
    function wp_list_pluck(array $list, string $field): array
    {
        return array_map(static fn ($item) => is_array($item) ? ($item[$field] ?? null) : ($item->{$field} ?? null), $list);
    }
}
