<?php

namespace vnh_namespace;

defined('ABSPATH') || wp_die(esc_html__('Direct access not permitted', 'vnh_textdomain'));

final class Plugin extends Core {
	public $admin;

	public static function instance($main_plugin_file) {
		if (!(self::$_instance instanceof self)) {
			self::$_instance = new self($main_plugin_file);
		}

		return self::$_instance;
	}

	public function register_core() {
		$this->admin = new Admin();
		$this->admin->boot();
	}

	public function register_frontend_assets() {
		return [
			'styles' => [],
			'scripts' => [
				PLUGIN_SLUG => [
					'src' => get_plugin_url('assets/js/dist/plugin.js'),
					'deps' => ['jquery'],
				],
			],
		];
	}

	public function register_backend_assets() {
		return [
			'styles' => [],
			'scripts' => [],
		];
	}

	public function enqueue_frontend_assets() {
		// TODO: Implement enqueue_frontend_assets() method.
	}

	public function enqueue_backend_assets() {
		// TODO: Implement enqueue_backend_assets() method.
	}
}
