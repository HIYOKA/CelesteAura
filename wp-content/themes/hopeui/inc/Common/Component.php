<?php

/**
 * HopeUI\Utility\Comments\Component class
 *
 * @package hopeui
 */

namespace HopeUI\Utility\Common;

use HopeUI\Utility\Component_Interface;
use HopeUI\Utility\Templating_Component_Interface;
use function add_action;

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
		return 'common';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize()
	{
		add_filter('widget_tag_cloud_args', array($this, 'hopeui_php_widget_tag_cloud_args'), 100);
		add_filter('wp_list_categories', array($this, 'hopeui_php_categories_postcount_filter'), 100);
		add_filter('get_archives_link', array($this, 'hopeui_php_style_the_archive_count'), 100);
		add_action('wp_enqueue_scripts', array($this, 'hopeui_php_remove_wp_block_library_css'), 100);
		add_filter('pre_get_posts', array($this, 'hopeui_php_searchfilter'), 100);
		add_theme_support('post-formats', array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
			'gallery',
			'audio',
		));
		add_action('after_switch_theme', array($this, 'hopeui_php_saferedirect_on_admin_page'));
	}

	public function __construct()
	{
		add_filter('the_content', array($this, 'hopeui_php_remove_empty_p'));
		add_filter('get_the_content', array($this, 'hopeui_php_remove_empty_p'));
		add_filter('get_the_excerpt', array($this, 'hopeui_php_remove_empty_p'));
		add_filter('the_excerpt', array($this, 'hopeui_php_remove_empty_p'));
		add_filter('body_class', array($this, 'hopeui_php_add_body_classes'));
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
			'hopeui_php_pagination' 		=> array($this, 'hopeui_php_pagination'),
			'hopeui_php_get_embed_video' 	=> array($this, 'hopeui_php_get_embed_video'),
		);
	}

	function hopeui_php_add_body_classes($classes)
	{
		if (class_exists('ReduxFramework')) {
			global $hopeui_php_options;
			$id = get_queried_object_id();
			$page_header_layout = (function_exists('get_field') && !empty($id)) ? get_post_meta($id, 'header_layout_type', true) : '';
			if ($hopeui_php_options['header_layout'] == 'custom' || $page_header_layout == 'custom') {
				$classes = array_merge($classes, array('hopeui_style-custom-header'));
			} else {
				$classes = array_merge($classes, array('hopeui_style-default-header'));
			}
		} else {
			$classes = array_merge($classes, array('hopeui_style-default-header'));
		}

		return $classes;
	}

	function hopeui_php_get_embed_video($post_id)
	{
		$post = get_post($post_id);
		$content = do_shortcode(apply_filters('the_content', $post->post_content));
		$embeds = get_media_embedded_in_content($content);
		if (!empty($embeds)) {
			foreach ($embeds as $embed) {
				if (strpos($embed, 'video') || strpos($embed, 'youtube') || strpos($embed, 'vimeo') || strpos($embed, 'dailymotion') || strpos($embed, 'vine') || strpos($embed, 'wordPress.tv') || strpos($embed, 'embed') || strpos($embed, 'audio') || strpos($embed, 'iframe') || strpos($embed, 'object')) {
					return $embed;
				}
			}
		} else {
			return;
		}
	}

	function hopeui_php_remove_empty_p($string)
	{
		return preg_replace('/<p>(?:\s|&nbsp;)*?<\/p>/i', '', $string);
	}

	function hopeui_php_remove_wp_block_library_css()
	{
		wp_dequeue_style('wp-block-library-theme');
	}

	public function hopeui_php_widget_tag_cloud_args($args)
	{
		$args['largest'] = 1;
		$args['smallest'] = 1;
		$args['unit'] = 'em';
		$args['format'] = 'list';

		return $args;
	}
	function hopeui_php_mime_types($mimes)
	{
		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
	}
	function hopeui_php_categories_postcount_filter($variable)
	{
		$variable = str_replace('(', '<span class="archiveCount"> (', $variable);
		$variable = str_replace(')', ') </span>', $variable);
		return $variable;
	}

	function hopeui_php_style_the_archive_count($links)
	{
		$links = str_replace('</a>&nbsp;(', '</a> <span class="archiveCount"> (', $links);
		$links = str_replace('&nbsp;)</li>', ' </li></span>', $links);
		return $links;
	}

	public function hopeui_php_pagination($numpages = '', $pagerange = '', $paged = '')
	{
		global $paged;
		if (empty($pagerange)) {
			$pagerange = 2;
		}
		$hopeui_php_paged = $paged;
		if (empty($hopeui_php_paged)) {
			$hopeui_php_paged = 1;
		}
		if ($numpages == '') {
			global $wp_query;
			$numpages = $wp_query->max_num_pages;
			if (!$numpages) {
				$numpages = 1;
			}
		}
		/**
		 * We construct the pagination arguments to enter into our paginate_links
		 * function.
		 */
		$pagination_args = array(
			'format' => '?paged=%#%',
			'total' => $numpages,
			'current' => $hopeui_php_paged,
			'show_all' => false,
			'end_size' => 1,
			'mid_size' => $pagerange,
			'prev_next' => true,
			'prev_text'       => '<i class="fas fa-chevron-left"></i>',
			'next_text'       => '<i class="fas fa-chevron-right"></i>',
			'type' => 'list',
			'add_args' => false,
			'add_fragment' => ''
		);

		$paginate_links = paginate_links($pagination_args);
		if ($paginate_links) {
			echo '<div class="col-lg-12 col-md-12 col-sm-12">
					<div class="pagination justify-content-center">
								<nav aria-label="Page navigation">';
			printf(esc_html('%s'), $paginate_links);
			echo '</nav>
					</div>
				</div>';
		}
	}

	function hopeui_php_searchfilter($query)
	{
		if (!is_admin()) {
			if ($query->is_search) {
				$query->set('post_type', 'post');
			}
			return $query;
		}
	}
	public function hopeui_php_saferedirect_on_admin_page()
	{
		if (is_child_theme())
			wp_safe_redirect(admin_url('admin.php?page=hopeui-dashboard'));
		else
			wp_safe_redirect(admin_url('themes.php?page=hopeui-dashboard'));
	}
}
