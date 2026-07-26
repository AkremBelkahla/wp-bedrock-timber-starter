<?php

/**
 * Point d'entrée wp-config.php standard Bedrock.
 * WordPress Core (installé via Composer dans web/wp) charge ce fichier
 * en remontant l'arborescence ; il délègue toute la configuration réelle
 * à config/application.php.
 *
 * @package StudioAtlas
 */

require_once dirname(__DIR__) . '/config/application.php';
require_once ABSPATH . 'wp-settings.php';
