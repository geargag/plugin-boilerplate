<?php

namespace vnh_namespace;

$plugin = get_plugin_data(vnh_plugin_file);

define(__NAMESPACE__ . '\PLUGIN_NAME', $plugin['Name']);
define(__NAMESPACE__ . '\PLUGIN_DESC', $plugin['Description']);
define(__NAMESPACE__ . '\PLUGIN_URI', $plugin['PluginURI']);
define(__NAMESPACE__ . '\PLUGIN_VERSION', $plugin['Version']);
define(__NAMESPACE__ . '\PLUGIN_AUTHOR_NAME', $plugin['AuthorName']);
define(__NAMESPACE__ . '\PLUGIN_AUTHOR_URI', $plugin['AuthorURI']);
define(__NAMESPACE__ . '\PLUGIN_TEXT_DOMAIN', $plugin['TextDomain']);
define(__NAMESPACE__ . '\PLUGIN_AUTHOR', $plugin['Author']);
define(__NAMESPACE__ . '\PLUGIN_TITLE', $plugin['Title']);
define(__NAMESPACE__ . '\PLUGIN_BASE', plugin_basename(vnh_plugin_file));
define(__NAMESPACE__ . '\PLUGIN_SLUG', basename(vnh_plugin_file));

const DS = DIRECTORY_SEPARATOR;
const DEV_MODE = 'vnh_dev_mode';

const ASSETS_DIR = 'assets/';
const LIBS_DIR = ASSETS_DIR . 'libs/';

class Constants {
}
