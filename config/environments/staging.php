<?php

/**
 * Surcharges pour l'environnement de pré-production.
 * Debug activé en log uniquement (jamais affiché), cache objet actif.
 *
 * @package StudioAtlas
 */

use Roots\WPConfig\Config;

Config::define('WP_DEBUG', true);
Config::define('WP_DEBUG_DISPLAY', false);
Config::define('WP_DEBUG_LOG', true);
Config::define('SCRIPT_DEBUG', false);
Config::define('DISALLOW_FILE_EDIT', true);
Config::define('WP_CACHE', true);

ini_set('display_errors', '0');
