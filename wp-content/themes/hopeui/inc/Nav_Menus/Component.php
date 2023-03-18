<?php

/**
 * HopeUI\Utility\Nav_Menus\Component class
 *
 * @package hopeui
 */

namespace HopeUI\Utility\Nav_Menus;

use HopeUI\Utility\Component_Interface;
use HopeUI\Utility\Templating_Component_Interface;
use WP_Post;
use function add_action;
use function add_filter;
use function register_nav_menus;
use function has_nav_menu;
use function wp_nav_menu;

/**
 * Class for managing navigation menus.
 *
 * Exposes template tags:
 * * `hopeui()->is_primary_nav_menu_active()`
 * * `hopeui()->display_primary_nav_menu( array $args = array() )`
 */
class Component implements Component_Interface, Templating_Component_Interface
{

	const PRIMARY_NAV_MENU_SLUG = 'primary';

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug(): string
	{
		return 'nav_menus';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize()
	{
		add_action('after_setup_theme', array($this, 'action_register_nav_menus'));
		add_filter('nav_menu_item_args', array($this, 'hopeui_php_menu_dropdown_arrow'), 10, 4);
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
			'is_primary_nav_menu_active' => array($this, 'is_primary_nav_menu_active'),
			'display_primary_nav_menu'   => array($this, 'display_primary_nav_menu'),
		);
	}

	/**
	 * Registers the navigation menus.
	 */
	public function action_register_nav_menus()
	{
		register_nav_menus(
			array(
				static::PRIMARY_NAV_MENU_SLUG => esc_html__('Primary', 'hopeui'),
			)
		);
	}

	/**
	 * Adds a dropdown symbol to nav menu items with children.
	 *
	 * Adds the dropdown markup after the menu link element,
	 * before the submenu.
	 *
	 * Javascript converts the symbol to a toggle button.
	 *
	 * @TODO:
	 * - This doesn't work for the page menu because it
	 *   doesn't have a similar filter. So the dropdown symbol
	 *   is only being added for page menus if JS is enabled.
	 *   Create a ticket to add to core?
	 *
	 * @param string  $item_output The menu item's starting HTML output.
	 * @param WP_Post $item        Menu item data object.
	 * @param int     $depth       Depth of menu item. Used for padding.
	 * @param object  $args        An object of wp_nav_menu() arguments.
	 * @return string Modified nav menu HTML.
	 */
	public function filter_primary_nav_menu_dropdown_symbol(string $item_output, WP_Post $item, int $depth, $args): string
	{

		// Only for our primary menu location.
		if (empty($args->theme_location) || static::PRIMARY_NAV_MENU_SLUG !== $args->theme_location) {
			return $item_output;
		}

		// Add the dropdown for items that have children.
		if (!empty($item->classes) && in_array('menu-item-has-children', $item->classes)) {
			return str_replace('</a>', '<span class="dropdown"><i class="fa fa-chevron-right"></i></span></a>', $item_output);
		}

		return $item_output;
	}

	public function hopeui_php_menu_dropdown_arrow($args, $item, $depth)
	{
		// Only add class to 'top level' items on the 'primary' menu.
		$is_horizontal = ['sf-menu top-menu navbar-nav ml-auto', 'navbar-nav top-menu'];
		$is_megamenu = get_post_meta($item->ID, '_is_megamenu', true);
		$selected_megamenu = get_post_meta($item->ID, '_is_selected_megamenu', true);
		if (in_array($args->menu_class, $is_horizontal) && in_array("menu-item-has-children", $item->classes) || $is_megamenu == "1" && !empty($selected_megamenu)) {
			$args->before = '<div class="hopeui_style-menu-item-wrapper">';
			$args->after = '<button type="button" class="hopeui_style-menu-toggle  btn" aria-dropdown="false"><i class="fa fa-chevron-right toggledrop hopeui_style-toggleer" aria-hidden="true"></i></button></div>';
		} else {
			$args->after = $args->before = null;
		}
		return $args;
	}

	/**
	 * Checks whether the primary navigation menu is active.
	 *
	 * @return bool True if the primary navigation menu is active, false otherwise.
	 */
	public function is_primary_nav_menu_active(): bool
	{
		$has_primary_menu = (bool) has_nav_menu(static::PRIMARY_NAV_MENU_SLUG);
		if ($has_primary_menu) {
			return $has_primary_menu;
		} else {
			if (wp_count_posts('page')->publish > 0) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Displays the primary navigation menu.
	 *
	 * @param array $args Optional. Array of arguments. See `wp_nav_menu()` documentation for a list of supported
	 *                    arguments.
	 */
	public function display_primary_nav_menu(array $args = array())
	{
		if (!isset($args['container'])) {
			$args['container'] = '';
		}

		$args['theme_location'] = static::PRIMARY_NAV_MENU_SLUG;

		if (has_nav_menu(static::PRIMARY_NAV_MENU_SLUG)) {
			wp_nav_menu($args);
		} elseif (!has_nav_menu(static::PRIMARY_NAV_MENU_SLUG)) {
			$this->hopeui_php_wp_pages_menu(true, $args['menu_class']);
		}
	}
	public function hopeui_php_wp_pages_menu($display = true, $menu_class)
	{
		if (!$display) return;
		$output = sprintf('<ul id="menu-all-pages" class="%s">%s</ul>', esc_attr($menu_class), wp_list_pages(
			array(
				'walker' => new HopeUI_Walker_Page(),
				'title_li' => false,
				'echo' => false,
			)
		));

		echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}


// 