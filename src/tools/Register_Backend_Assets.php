<?php

namespace vnh_namespace\tools;

use vnh\Register_Assets;

class Register_Backend_Assets extends Register_Assets {
	public $scripts;
	public $styles;

	public function __construct(array $assets) {
		$this->scripts = apply_filters('vnh_prefix/backend/register/scripts', $assets['scripts']);
		$this->styles = apply_filters('vnh_prefix/backend/register/styles', $assets['styles']);
	}

	public function boot() {
		add_action('admin_enqueue_scripts', [$this, 'register_scripts']);
		add_action('admin_enqueue_scripts', [$this, 'register_styles']);
	}
}