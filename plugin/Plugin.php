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

use vnh\Allowed_HTML;
use vnh\contracts\Bootable;
use vnh\contracts\Initable;
use vnh\contracts\Loadable;
use vnh\Plugin_Checker;
use vnh\Singleton;
use vnh_namespace\admin\Admin;
use vnh_namespace\admin\menu\Admin_Menu;
use vnh_namespace\settings_page\Settings_Page;
use vnh_namespace\tools\Config_CMB2;
use vnh_namespace\tools\Register_Assets;

use function vnh\is_woocommerce_active;
use function vnh\plugin_languages_path;

const PLUGIN_FILE = __FILE__;
const PLUGIN_DIR = __DIR__;

require_once PLUGIN_DIR . '/vendor/autoload.php';

final class Plugin extends Singleton implements Loadable, Initable, Bootable {
	public $allow_html;
	public $php_checker;
	public $wp_checker;
	public $settings_page;
	public $admin_menus;
	public $admin_notices;
	public $backend_assets;
	public $frontend_assets;
	public $register_backend_assets;
	public $register_frontend_assets;
	public $widgets;
	public $config_cmb2;

	protected function __construct() {
		$this->backend_assets = [
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

		$this->frontend_assets = [
			'styles' => [],
			'scripts' => [
				PLUGIN_SLUG => [
					'src' => get_plugin_url('assets/js/dist/frontend.js'),
					'deps' => ['jquery'],
				],
			],
		];
	}

	public function init() {
		$this->allow_html = new Allowed_HTML();
		$this->php_checker = new Plugin_Checker(MIN_PHP_VERSION, 'PHP', PLUGIN_FILE);
		$this->wp_checker = new Plugin_Checker(MIN_WP_VERSION, 'WordPress', PLUGIN_FILE);
		$this->admin_menus = new Admin_Menu();
		$this->admin_notices = new Admin();
		$this->settings_page = new Settings_Page();
		$this->config_cmb2 = new Config_CMB2();
		$this->register_backend_assets = new Register_Assets($this->backend_assets, 'backend');
		$this->register_frontend_assets = new Register_Assets($this->frontend_assets, 'frontend');
	}

	public function load() {
		if (!is_woocommerce_active()) {
			return;
		}

		$this->allow_html->boot();

		$this->php_checker->init();
		$this->wp_checker->init();

		$this->register_frontend_assets->boot();

		if (is_admin()) {
			$this->register_backend_assets->boot();

			$this->admin_menus->boot();

			$this->admin_notices->init();
			$this->admin_notices->boot();

			$this->settings_page->init();
			$this->settings_page->boot();

			$this->config_cmb2->boot();
		}
	}

	public function boot() {
		add_action('plugin_loaded', [$this, 'load_plugin_textdomain']);
		add_action('admin_enqueue_scripts', [$this, 'enqueue_backend_assets']);
		add_action('wp_enqueue_scripts', [$this, 'enqueue_frontend_assets']);
	}

	public function load_plugin_textdomain() {
		load_plugin_textdomain('vnh_textdomain', false, plugin_languages_path(PLUGIN_FILE));
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

Plugin::instance();
Plugin::instance()->init();
Plugin::instance()->load();
Plugin::instance()->boot();
