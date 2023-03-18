<?php

/**
 * HopeUI\Utility\Customizer\Component class
 *
 * @package hopeui
 */

namespace HopeUI\Utility\Customizer;

use WP_Customize_Control;
use HopeUI\Utility\Component_Interface;
use function HopeUI\Utility\hopeui;
use WP_Customize_Manager;
use function add_action;
use function bloginfo;
use function wp_enqueue_script;
use function get_theme_file_uri;
use function get_theme_file_path;

/**
 * Class for managing Customizer integration.
 */
class Component implements Component_Interface
{

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug(): string
	{
		return 'customizer';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize()
	{

		add_action('customize_register', array($this, 'action_customize_register'));
		add_action('customize_controls_enqueue_scripts', array($this, 'action_enqueue_customize_preview_js'), 99);
		add_action('after_setup_theme', array($this, 'hopeui_php_add_customize_options'));
		add_action('customize_preview_init', array($this, 'hopeui_php_enqueue_preview'));
	}

	/**
	 * Adds postMessage support for site title and description, plus a custom Theme Options section.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer manager instance.
	 */
	public function action_customize_register(WP_Customize_Manager $wp_customize)
	{

		$wp_customize->get_setting('blogname')->transport         = 'postMessage';
		$wp_customize->get_setting('blogdescription')->transport  = 'postMessage';
		$wp_customize->get_setting('header_textcolor')->transport = 'postMessage';


		if (isset($wp_customize->selective_refresh)) {
			$wp_customize->selective_refresh->add_partial(
				'blogname',
				array(
					'selector'        => '.site-title a',
					'render_callback' => function () {
						bloginfo('name');
					},
				)
			);
			$wp_customize->selective_refresh->add_partial(
				'blogdescription',
				array(
					'selector'        => '.site-description',
					'render_callback' => function () {
						bloginfo('description');
					},
				)
			);
		}
	}

	/**
	 * Enqueues JavaScript to make Customizer preview reload changes asynchronously.
	 */
	public function action_enqueue_customize_preview_js()
	{
		wp_enqueue_script(
			'hopeui-customizer',
			get_parent_theme_file_uri('assets/js/customizer.min.js'),
			array('jquery'),
			hopeui()->get_asset_version(get_theme_file_path('assets/js/customizer.min.js')),
			true
		);

		wp_enqueue_style('hopeui-customizer', get_parent_theme_file_uri('assets/css/customizer.min.css'));
	}

	public function hopeui_php_add_customize_options()
	{
		new Sections\General();
		new Sections\Breadcrumb();
		new Sections\Header();
		new Sections\Loader();
		new Sections\Blog();
		new Sections\Page();
		new Sections\FourZeroFour();
		new Sections\Footer();
	}

	public function hopeui_php_enqueue_preview()
	{
		wp_enqueue_script(
			'hopeui-customizer',
			get_theme_file_uri('assets/js/customizer-perview.min.js'),
			array('jquery'),
			hopeui()->get_asset_version(get_theme_file_path('assets/js/customizer-perview.min.js')),
			true
		);
	}
}

/**
 * Custom Control Base Class
 * @package hopeui
 *
 */
if (class_exists('WP_Customize_Control')) {

	class HopeUI_Customize_Control extends \WP_Customize_Control
	{
		public $tab, $condition, $default, $display_inline;

		public function to_json()
		{
			parent::to_json();
			$this->json['tab'] = $this->tab;
			$this->json['condition'] = $this->condition;
			$this->json['default'] = $this->default;
		}
	}
}
