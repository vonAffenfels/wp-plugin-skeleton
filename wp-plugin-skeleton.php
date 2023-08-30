<?php

/**
 * Plugin Name:       WP Plugin Skeleton
 * Description:       Skeleton for development of Wordpress plugins using the vAF Wordpress Framework
 * Version:           1.0.0
 * Requires at least: 6.2
 * Author:            Christoph Friedrich <christoph.friedrich@vonaffenfels.de>
 * Author URI:        https://www.vonaffenfels.de
 */

use WP\Plugin\Skeleton\Plugin;

if (!defined('ABSPATH')) {
    die('');
}

$autoloadPath = __DIR__ . '/vendor/autoload.php';
if (file_exists($autoloadPath)) {
    require_once $autoloadPath;
}

Plugin::registerPlugin(__FILE__, defined('WP_DEBUG') && WP_DEBUG);
