<?php

namespace vnh_namespace;

defined('WPINC') || die();

function is_plugin_settings_page() {
	return strpos(get_current_screen()->id, MENU_SLUG) !== false;
}

function get_plugin_path($dir = null) {
	if (empty($dir)) {
		return PLUGIN_PATH;
	}

	return PLUGIN_PATH . $dir;
}

function get_plugin_url($dir = null) {
	if (empty($dir)) {
		return PLUGIN_URL;
	}

	return PLUGIN_URL . $dir;
}

function is_dev() {
	return (defined(__NAMESPACE__ . '\DEV_MODE') && DEV_MODE !== 'disable') || isset($_GET['dev']);
}