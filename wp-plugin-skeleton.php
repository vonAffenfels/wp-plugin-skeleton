<?php

/**
 * Plugin Name:       %%PLUGIN_NAME%%
 * Description:       %%PLUGIN_DESCRIPTION%%
 * Version:           1.0.0
 * Requires at least: 6.2
 * Author:            %%AUTHOR_COMPLETE%%
 * Author URI:        %%WEBSITE%%
 */

use %%PLUGIN_NAMESPACE%%\Plugin;

if (!defined('ABSPATH')) {
    die('');
}

$autoloadPath = __DIR__ . '/vendor/autoload.php';
if (file_exists($autoloadPath)) {
    require_once $autoloadPath;
}

Plugin::registerPlugin(__FILE__, defined('WP_DEBUG') && WP_DEBUG);
