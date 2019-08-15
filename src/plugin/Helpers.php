<?php

namespace vnh_namespace;

function flatten_version($version) {
	if (empty($version)) {
		return null;
	}

	$parts = explode('.', $version);

	if (count($parts) === 2) {
		$parts[] = '0';
	}

	return implode('', $parts);
}

function get_plugin_path($dir = null) {
	if (empty($dir)) {
		return plugin_dir_path(Core::$plugin['path']);
	}

	return plugin_dir_path(Core::$plugin['path']) . $dir;
}

function get_plugin_url($dir = null) {
	if (empty($dir)) {
		return plugin_dir_url(Core::$plugin['url']);
	}

	return plugin_dir_url(Core::$plugin['url']) . $dir;
}

function is_dev() {
	return (defined(__NAMESPACE__ . '\DEV_MODE') && DEV_MODE !== 'disable') || isset($_GET['dev']);
}

class Helpers {
}
