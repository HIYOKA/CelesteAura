<?php

/**
 * HopeUI\Utility\Actions\Component class
 *
 * @package hopeui
 */

namespace HopeUI\Utility\Actions;

use HopeUI\Utility\Component_Interface;
use HopeUI\Utility\Templating_Component_Interface;

/**
 * Class for managing comments UI.
 *
 * Exposes template tags:
 * * `hopeui()->the_comments( array $args = array() )`
 *
 * @link https://wordpress.org/plugins/amp/
 */
class Component implements Component_Interface, Templating_Component_Interface
{
	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug(): string
	{
		return 'actions';
	}
	public function initialize()
	{
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
			'hopeui_php_get_blog_readmore_link' => array($this, 'hopeui_php_get_blog_readmore_link'),
			'hopeui_php_get_blog_readmore' => array($this, 'hopeui_php_get_blog_readmore'),
			'hopeui_php_get_comment_btn' => array($this, 'hopeui_php_get_comment_btn'),
			'hopeui_php_common_style' => array($this, 'hopeui_php_common_style'),
		);
	}

	//** Blog Read More Button Link **//
	public function hopeui_php_get_blog_readmore_link($link, $label = "Read More")
	{
		echo '<div class="blog-button">		
				<a class="hopeui_style-button " href="' . esc_url($link) . '">' . esc_html($label) . ' 
					
				</a>
			</div>';
	}

	//** Blog Read More Button **//
	public function hopeui_php_get_blog_readmore($link, $label)
	{
		echo '<div class="blog-button">
				<a class="hopeui_style-button" href="' . esc_url($link) . '">' . esc_html($label) . '</a>
			</div>';
	}
	//** Comment Submit Button **//
	public function hopeui_php_get_comment_btn()
	{
		return '<button name="submit" type="submit" id="submit" class="submit hopeui_style-button" value="' . __('Post Comment', 'hopeui') . '" >
					' . esc_html__('Post Comment', 'hopeui') . '
				</button>';
	}
	public function hopeui_php_common_style($tag = 'a',  $label = 'Post Comment', $show_icon = false, $attr = array(), $echo = true)
	{
		$classes = isset($attr['class']) ? $attr['class'] : '';
		$icon = $show_icon ? '<i class="fa-solid fa-angle-right"></i>' : '';

		$attr_render = '';
		$attr_render = ($tag == 'button') ? 'type=submit ' : '';

		foreach ($attr as $key => $value) {
			$attr_render .= $key . '=' . $value . ' ';
		}
		if ($echo) {
			echo '<' . tag_escape($tag) . '  class="hopeui_style-button ' . esc_attr($classes) . '  " ' . esc_attr($attr_render) . '  >
			' . esc_html($label) .
				$icon .
				' </' . tag_escape($tag) . '>';
		} else {
			return '<' . tag_escape($tag) . '  class="hopeui_style-button ' . esc_attr($classes) . '  " ' . esc_attr($attr_render) . '  >
			' . esc_html($label) .
				$icon .
				' </' . tag_escape($tag) . '>';
		}
	}
}
