<?php

namespace vnh_namespace;

use DI\ContainerBuilder;
use vnh\Allowed_HTML;
use vnh\Our_Plugins;
use vnh\Plugin_Action_Links;
use vnh\Plugin_Row_Meta;
use vnh\Singleton;
use vnh_namespace\admin\Our_Plugins_Menu;
use vnh_namespace\admin\Settings;
use vnh_namespace\settings_page\CMB2_Settings_Page;
use vnh_namespace\settings_page\Settings_Page;
use vnh_namespace\tools\Config_CMB2;
use vnh_namespace\tools\PHP_Checker;
use vnh_namespace\tools\WordPress_Checker;
use function DI\create;

final class Container extends Singleton {
	public $services;

	protected function __construct() {
		$builder = new ContainerBuilder();
		$builder->addDefinitions(
			apply_filters('vnh_prefix/definitions', [
				PHP_Checker::class => create(),
				WordPress_Checker::class => create(),
				Our_Plugins::class => create()->constructor(PLUGINS_LIST_URL),
				Our_Plugins_Menu::class => create(),
				Allowed_HTML::class => create(),
				Plugin_Action_Links::class => create()->constructor(PLUGIN_BASE, PLUGIN_SLUG),
				Plugin_Row_Meta::class => create()->constructor(PLUGIN_BASE, PLUGIN_DOCUMENT_URI),
				Config_CMB2::class => create(),
				CMB2_Settings_Page::class => create(),
				Settings::class => create(),
				Settings_Page::class => create(),
				Enqueue_Backend_Assets::class => create(),
				Enqueue_Frontend_Assets::class => create(),
			])
		);

		$this->services = $builder->build();
	}
}
