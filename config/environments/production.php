<?php

/**
 * Surcharges pour l'environnement de production.
 * Debug totalement désactivé, cache objet actif, édition de fichiers bloquée.
 *
 * @package StudioAtlas
 */

use Roots\WPConfig\Config;

Config::define('WP_DEBUG', false);
Config::define('WP_DEBUG_DISPLAY', false);
Config::define('WP_DEBUG_LOG', false);
Config::define('SCRIPT_DEBUG', false);
Config::define('DISALLOW_FILE_EDIT', true);
Config::define('WP_CACHE', true);
Config::define('AUTOMATIC_UPDATER_DISABLED', true);

ini_set('display_errors', '0');
