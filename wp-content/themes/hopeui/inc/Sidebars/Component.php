<?php

/**
 * HopeUI\Utility\Sidebars\Component class
 *
 * @package hopeui
 */

namespace HopeUI\Utility\Sidebars;

use HopeUI\Utility\Component_Interface;
use HopeUI\Utility\Templating_Component_Interface;
use function add_action;
use function add_filter;
use function register_sidebar;
use function is_active_sidebar;
use function dynamic_sidebar;

/**
 * Class for managing sidebars.
 *
 * Exposes template tags:
 * * `hopeui()->is_primary_sidebar_active()`
 * * `hopeui()->display_primary_sidebar()`
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/
 */
class Component implements Component_Interface, Templating_Component_Interface
{

	const PRIMARY_SIDEBAR_SLUG = 'sidebar-1';
	public $get_option = '';

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug(): string
	{
		return 'sidebars';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize()
	{
		add_action('widgets_init', array($this, 'action_register_sidebars'));
		add_filter('body_class', array($this, 'filter_body_classes'));
	}

	/**
	 * Gets template tags to expose as methods on the Template_Tags class instance, accessible through `hopeui()`.
	 *
	 * @return array Associative array of $method_name => $callback_info pairs. Each $callback_info must either be
	 *               a callable or an array with key 'callable'. This approach is used to reserve the possibility of
	 *               adding support for further arguments in the future.
	 */
	public function template_tags(): array
	{
		return array(
			'is_primary_sidebar_active' => array($this, 'is_primary_sidebar_active'),
			'display_primary_sidebar' => array($this, 'display_primary_sidebar'),
			'post_style' => array($this, 'post_style'),
		);
	}

	/**
	 * Registers the sidebars.
	 */
	public function action_register_sidebars()
	{
		register_sidebar(
			array(
				'name' => esc_html__('Blog Sidebar', 'hopeui'),
				'id' => static::PRIMARY_SIDEBAR_SLUG,
				'description' => esc_html__('Add widgets here.', 'hopeui'),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title' => '<h5 class="widget-title"> <span>  ',
				'after_title' => ' </span></h5>',
			)
		);
		if (class_exists('WooCommerce')) {
			register_sidebar(array(
				'name'          => esc_html__('Product Sidebar', 'hopeui'),
				'class'         => 'nav-list',
				'id'            => 'product_sidebar',
				'before_widget' => '<div class="sidebar_widget widget-woof %2$s">',
				'after_widget'  => '</div>',
				'before_title' => '<h5 class="widget-title">',
				'after_title' => '<span class="line_"></span></h5>',
			));
		}
	}

	/**
	 * Adds custom classes to indicate whether a sidebar is present to the array of body classes.
	 *
	 * @param array $classes Classes for the body element.
	 * @return array Filtered body classes.
	 */
	public function filter_body_classes(array $classes): array
	{
		if ($this->is_primary_sidebar_active()) {
			global $template;

			if (!in_array(basename($template), array('front-page.php', 'FourZeroFour.php', 'offline.php'))) {
				$classes[] = 'has-sidebar';
			}
		}

		return $classes;
	}

	/**
	 * Checks whether the primary sidebar is active.
	 *
	 * @return bool True if the primary sidebar is active, false otherwise.
	 */
	public function is_primary_sidebar_active(): bool
	{
		if (is_search()) {
			$option =	get_theme_mod('search_sidebar_setting', 3);
		} else if (is_singular()) {
			$option =	get_theme_mod('blog_single_page_sidebar_setting', 2);
		} else {
			$option = get_theme_mod('blog_sidebar_setting', 1);
		}

		if ($option == 2) {
			return false;
		}
		return (bool)is_active_sidebar(static::PRIMARY_SIDEBAR_SLUG);
	}

	/**
	 * Displays the primary sidebar.
	 */
	public function display_primary_sidebar()
	{
		if (class_exists('WooCommerce') && is_shop() || is_tax()) {
			dynamic_sidebar('product_sidebar');
		} else {
			dynamic_sidebar(static::PRIMARY_SIDEBAR_SLUG);
		}
	}

	public function post_style(): array
	{
		$section['row_reverse'] = '';
		$section['post'] = 'col-lg-12 col-sm-12';

		if (is_search()) {
			$section['row_reverse'] = get_theme_mod('search_sidebar_setting', 3) == 1 ? ' flex-row-reverse' : '';
			return $section;
		} else if (is_single()) {
			$section['row_reverse'] = get_theme_mod('blog_single_page_sidebar_setting', 2) == 1 ? ' flex-row-reverse' : '';
			return $section;
		} else {
			$options = get_theme_mod('blog_column', 1);
			$section['row_reverse'] = get_theme_mod('blog_sidebar_setting', 3) == 1 ?  ' flex-row-reverse' : '';
		}

		switch ($options) {
			case 2:
				$section['post'] = 'col-lg-6 col-sm-6';
				break;
			case 3:
				$section['post'] = 'col-lg-4 col-sm-6';
				break;
			case 4:
				$section['post'] = 'col-lg-3 col-sm-6';
				break;
		}
		return $section;
	}
}
