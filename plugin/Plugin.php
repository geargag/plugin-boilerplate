<?php
/**
 * Plugin Name: vnh_name
 * Description: vnh_description
 * Version: vnh_version
 * Tags: vnh_tags
 * Author: vnh_author
 * Author URI: vnh_author_uri
 * License: vnh_license
 * License URI: vnh_license_uri
 * Document URI: vnh_document_uri
 * Text Domain: vnh_textdomain
 * Tested up to: WordPress vnh_tested_up_to
 * WC requires at least: vnh_wc_requires
 * WC tested up to: vnh_wc_tested_up_to
 */

namespace vnh_namespace;

defined('ABSPATH') || die();

use vnh_namespace\admin\Admin;
use vnh_namespace\admin\menu\Admin_Menu;
use vnh_namespace\settings_page\Settings_Page;
use vnh_namespace\tools\Checker;
use vnh_namespace\tools\Config_CMB2;
use vnh_namespace\tools\KSES;
use vnh_namespace\tools\Register_Assets;

final class Plugin {
	public $settings_page;
	public $admin_menus;
	public $admin_notices;
	public $frontend_assets;
	public $backend_assets;
	public $widgets;
	public $config_cmb2;

	const FILE = __FILE__;
	const DIR = __DIR__;

	public function __construct() {
		$this->load();
		$this->check_php();
		$this->check_wp();
		$this->init();
		$this->core();
		$this->register_assets();
		$this->boot();
	}

	private function load() {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
		require_once __DIR__ . '/vendor/autoload.php';
	}

	public function check_php() {
		$php_checker = new Checker(PHP_VERSION, MIN_PHP_VERSION, 'PHP');
		$php_checker->boot();

		if (!$php_checker->is_compatible_check()) {
			register_activation_hook(__FILE__, [$php_checker, 'version_too_low']);
		}
	}

	public function check_wp() {
		global $wp_version;

		$wp_checker = new Checker($wp_version, MIN_WP_VERSION, 'WordPress');
		$wp_checker->boot();

		if (!$wp_checker->is_compatible_check()) {
			register_activation_hook(__FILE__, [$wp_checker, 'version_too_low']);
		}
	}

	public function init() {
		new KSES();

		if (is_admin()) {
			$this->admin_menus = new Admin_Menu();
			$this->admin_menus->boot();

			$this->admin_notices = new Admin();
			$this->admin_notices->init();
			$this->admin_notices->boot();

			$this->settings_page = new Settings_Page();
			$this->settings_page->init();
			$this->settings_page->boot();

			$this->config_cmb2 = new Config_CMB2();
			$this->config_cmb2->boot();
		}
	}

	public function core() {
		if (!is_woocommerce_active()) {
			return;
		}

		$this->widgets = new Register_Widgets();
		$this->widgets->boot();
	}

	public function register_assets() {
		$this->backend_assets = new Register_Assets($this->register_backend_assets(), 'backend');
		$this->backend_assets->boot();

		$this->frontend_assets = new Register_Assets($this->register_frontend_assets(), 'frontend');
		$this->frontend_assets->boot();
	}

	public function register_backend_assets() {
		return [
			'styles' => [
				handle('settings-page') => [
					'src' => get_plugin_url('assets/css/settings_page.css'),
				],
			],
			'scripts' => [
				handle('settings-page') => [
					'src' => get_plugin_url('assets/js/dist/settings_page.js'),
					'deps' => ['jquery', 'jquery-form', 'jquery-ui-sortable'],
					'localize_script' => [
						'settingsPage' => [
							'saveMessage' => esc_html__('Settings Saved Successfully', 'vnh_textdomain'),
						],
					],
				],
			],
		];
	}

	public function register_frontend_assets() {
		return [
			'styles' => [],
			'scripts' => [
				PLUGIN_SLUG => [
					'src' => get_plugin_url('assets/js/dist/frontend.js'),
					'deps' => ['jquery'],
				],
			],
		];
	}

	public function boot() {
		add_action('plugin_loaded', [$this, 'load_plugin_textdomain']);
		add_action('admin_enqueue_scripts', [$this, 'enqueue_backend_assets']);
		add_action('wp_enqueue_scripts', [$this, 'enqueue_frontend_assets']);
	}

	public function load_plugin_textdomain() {
		load_plugin_textdomain('vnh_textdomain', false, dirname(plugin_basename(__FILE__)) . '/languages');
	}

	public function enqueue_backend_assets() {
		if (is_plugin_settings_page()) {
			wp_enqueue_style(handle('settings-page'));
			wp_enqueue_script(handle('settings-page'));
		}
	}

	public function enqueue_frontend_assets() {
		wp_enqueue_script(PLUGIN_SLUG);
	}
}

new Plugin();