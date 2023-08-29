<?php

/**
 * Plugin Name:       %%PLUGINNAME%%
 * Description:       %%PLUGINDESCRIPTION%%
 * Version:           1.0.0
 * Requires at least: 6.2
 * Author:            Christoph Friedrich <christoph.friedrich@vonaffenfels.de>
 * Author URI:        https://www.vonaffenfels.de
 */

use VAF\WP\PluginSkeleton\Plugin;

if (!defined('ABSPATH')) {
    die('');
}

$autoloadPath = __DIR__ . '/vendor/autoload.php';
if (file_exists($autoloadPath)) {
    require_once $autoloadPath;
}

Plugin::registerPlugin(__FILE__, defined('WP_DEBUG') && WP_DEBUG);
