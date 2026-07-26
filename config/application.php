<?php

/**
 * Configuration racine Bedrock, commune à tous les environnements.
 * Les fichiers config/environments/{WP_ENV}.php sont chargés après celui-ci
 * et peuvent surcharger n'importe quelle constante définie ici.
 *
 * @package StudioAtlas
 */

use Roots\WPConfig\Config;
use function Env\env;

Config::define('WP_ENV', env('WP_ENV') ?: 'production');

$root_dir    = dirname(__DIR__);
$webroot_dir = $root_dir . '/web';

if (file_exists($root_dir . '/.env')) {
    $env = \Dotenv\Dotenv::createUnsafeImmutable($root_dir);
    $env->load();
}

Config::define('WP_HOME', env('WP_HOME'));
Config::define('WP_SITEURL', env('WP_SITEURL'));

Config::define('DB_NAME', env('DB_NAME'));
Config::define('DB_USER', env('DB_USER'));
Config::define('DB_PASSWORD', env('DB_PASSWORD'));
Config::define('DB_HOST', env('DB_HOST') ?: 'localhost');
Config::define('DB_CHARSET', 'utf8mb4');
Config::define('DB_COLLATE', '');
$table_prefix = env('DB_PREFIX') ?: 'wp_';

Config::define('AUTH_KEY', env('AUTH_KEY'));
Config::define('SECURE_AUTH_KEY', env('SECURE_AUTH_KEY'));
Config::define('LOGGED_IN_KEY', env('LOGGED_IN_KEY'));
Config::define('NONCE_KEY', env('NONCE_KEY'));
Config::define('AUTH_SALT', env('AUTH_SALT'));
Config::define('SECURE_AUTH_SALT', env('SECURE_AUTH_SALT'));
Config::define('LOGGED_IN_SALT', env('LOGGED_IN_SALT'));
Config::define('NONCE_SALT', env('NONCE_SALT'));

Config::define('AUTOMATIC_UPDATER_DISABLED', true);
Config::define('DISABLE_WP_CRON', filter_var(env('DISABLE_WP_CRON'), FILTER_VALIDATE_BOOLEAN));
Config::define('DISALLOW_FILE_EDIT', true);

Config::define('WPACF_LICENSE_KEY', env('ACF_PRO_KEY'));
Config::define('WP_REDIS_HOST', env('WP_REDIS_HOST') ?: '127.0.0.1');
Config::define('WP_REDIS_PORT', env('WP_REDIS_PORT') ?: 6379);

Config::define('WP_DEBUG_DISPLAY', false);
Config::define('WP_DEBUG_LOG', false);
Config::define('SCRIPT_DEBUG', false);
ini_set('display_errors', '0');

$env_config = __DIR__ . '/environments/' . Config::get('WP_ENV') . '.php';
if (file_exists($env_config)) {
    require_once $env_config;
}

Config::apply();

if (!defined('ABSPATH')) {
    define('ABSPATH', $webroot_dir . '/wp/');
}
