<?php

/**
 * HopeUI\Utility\Comments\Component class
 *
 * @package hopeui
 */

namespace HopeUI\Utility\Breadcrumb;

use HopeUI\Utility\Component_Interface;
use HopeUI\Utility\Templating_Component_Interface;

/**
 * Class for managing breadcrumb UI.
 *
 * Exposes template tags:
 * * `hopeui()->hopeui_php_breadcrumb( )`
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
		return 'breadcrumb';
	}
	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
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
		return [
			'is_hopeui_php_breadcrumb' 	=> [$this, 'is_hopeui_php_breadcrumb'],
			'hopeui_php_breadcrumb' 	=> [$this, 'hopeui_php_breadcrumb'],
		];
	}

	public function hopeui_php_breadcrumb()
	{
		$breadcrumb_style = get_theme_mod('breadcrumb_style', 1);
		if (is_404()) {
			return;
		}
?>
		<div class="hopeui_style-breadcrumb hopeui_style-breadcrumb-style-<?php echo esc_attr($breadcrumb_style) ?>	">
			<div class="container">
				<?php

				if ($breadcrumb_style == '2') {
				?>
					<div class="row align-items-center">
						<div class="col-lg-8 col-md-8 text-start">
							<nav aria-label="breadcrumb">
								<?php $this->hopeui_php_breadcrumb_title(); ?>
								<?php $this->hopeui_php_breadcrumb_nav("breadcrumb main-bg"); ?>
							</nav>
						</div>
						<?php $this->hopeui_php_breadcrumb_feature_image(); ?>
					</div>
				<?php } elseif ($breadcrumb_style == '3') { ?>

					<div class="row align-items-center">
						<?php $this->hopeui_php_breadcrumb_feature_image(); ?>
						<div class="col">
							<nav aria-label="breadcrumb" class="text-end hopeui_style-breadcrumb-nav">
								<?php $this->hopeui_php_breadcrumb_title(); ?>
								<?php $this->hopeui_php_breadcrumb_nav("breadcrumb main-bg justify-content-end"); ?>
							</nav>
						</div>
					</div>
				<?php } elseif ($breadcrumb_style == '4') { ?>

					<div class="row align-items-center">
						<div class="col-md-6 mb-3 mb-md-0 text-center text-md-start">
							<?php $this->hopeui_php_breadcrumb_title(); ?>
						</div>
						<div class="col-md-6 text-md-end  text-sm-center">
							<nav aria-label="breadcrumb" class="hopeui_style-breadcrumb-nav">
								<?php $this->hopeui_php_breadcrumb_nav("breadcrumb main-bg justify-content-md-end"); ?>
							</nav>
						</div>
					</div>
				<?php } elseif ($breadcrumb_style == '5') { ?>

					<div class="row align-items-center hopeui_style-breadcrumb-three">
						<div class="col-md-6 mb-3 mb-md-0">
							<nav aria-label="breadcrumb" class="text-md-start text-center hopeui_style-breadcrumb-nav">
								<?php $this->hopeui_php_breadcrumb_nav("breadcrumb main-bg justify-content-md-start"); ?>
							</nav>
						</div>
						<div class="col-md-6 text-md-end text-center">
							<?php $this->hopeui_php_breadcrumb_title(); ?>
						</div>
					</div>
				<?php } else { ?>
					<div class="row align-items-center justify-content-center text-center">
						<div class="col-sm-12">
							<nav aria-label="breadcrumb" class="hopeui_style-breadcrumb-nav">
								<?php $this->hopeui_php_breadcrumb_title(); ?>
								<?php $this->hopeui_php_breadcrumb_nav("breadcrumb main-bg"); ?>
							</nav>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
		<?php
	}

	function hopeui_php_breadcrumb_title()
	{
		if (!get_theme_mod('display_breadcrumb_title', true)) return;

		$page_id = get_queried_object_id();

		//return if title option is not enable
		$page_option = get_post_meta($page_id, 'display_breadcrumb_title', true);
		if ($page_option == 'no') {
			return;
		} else if (isset($hopeui_php_options['display_breadcrumb_title']) && $hopeui_php_options['display_breadcrumb_title'] == 'no') {
			return;
		}

		$title = '';
		$title_tag = get_theme_mod('breadcrumb_title_tag', 'h2');

		if (is_archive()) {
			$title = get_the_archive_title();
		} elseif (is_search()) {
			$title = esc_html__('Search', 'hopeui');
		} elseif (is_404()) {
			$title = __('Oops! That page can not be found.', 'hopeui');
			if (isset($hopeui_php_options['404_title'])) {
				$title = !empty(trim($hopeui_php_options['404_title'])) ? $hopeui_php_options['404_title'] : '';
			}
		} elseif (is_home()) {
			$title = esc_html__('Home', 'hopeui');
		} elseif ('iqonic_hf_layout' === get_post_type()) {
			$title = get_the_title($page_id);
		} elseif (get_theme_mod('hopeui_php_display_breadcrumb_blog_title', true) && is_singular('post')) {
			$title = get_theme_mod('hopeui_php_breadcrumb_blog_title', __('Blog Detail', 'hopeui'));
		} else {
			$title = get_the_title();
		}
		if (!empty(trim($title))) :
		?>
			<<?php echo esc_attr($title_tag); ?> class="title">
				<?php echo wp_kses($title, array(['span' => array()])); ?>
			</<?php echo esc_attr($title_tag); ?>>
		<?php
		endif;
	}

	public function hopeui_php_breadcrumb_feature_image()
	{
		$bnurl = '';
		$page_id = get_queried_object_id();
		global $hopeui_php_options;
		if (has_post_thumbnail($page_id) && !is_single()) {
			$image_array = wp_get_attachment_image_src(get_post_thumbnail_id($page_id), 'full');
			$bnurl = $image_array[0];
		} elseif (is_404()) {
			if (!empty($hopeui_php_options['404_banner_image']['url'])) {
				$bnurl = $hopeui_php_options['404_banner_image']['url'];
			}
		} elseif (is_home()) {
			if (!empty($hopeui_php_options['blog_default_banner_image']['url'])) {
				$bnurl = $hopeui_php_options['blog_default_banner_image']['url'];
			}
		} else {
			if (!empty($hopeui_php_options['page_default_breadcrumb_image']['url'])) {
				$bnurl = $hopeui_php_options['page_default_breadcrumb_image']['url'];
			}
		}

		if (!empty($bnurl)) {
			$img_pos = "";
			if (!empty($hopeui_php_options['bg_image']) && $hopeui_php_options['bg_image'] != 1) {
				$img_pos = 'float-right';
			}
		?>
			<div class="col-lg-4 col-md-4 col-sm-12 align-breadcrumb-image">
				<img src="<?php echo esc_url($bnurl); ?>" class="img-fluid <?php echo esc_attr($img_pos) ?>" alt="<?php esc_attr_e('banner', 'hopeui'); ?>">
			</div>
<?php
		}
	}
	function hopeui_php_breadcrumb_nav($class = "")
	{
		//return if nav option is not enable
		if (!get_theme_mod('display_breadcrumb_nav', true)) return;

		global $post;
		echo '<ol class="' . esc_attr($class) . '">';
		$show_on_home = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
		$show_current = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show

		if (is_front_page()) {
			if ($show_on_home == 1) echo '<li class="breadcrumb-item"><a href="' .  esc_url(home_url()) . '">' . esc_html__('Home', 'hopeui') . '</a></li>';
		} else {

			echo '<li class="breadcrumb-item"><a href="' .  esc_url(home_url()) . '">' . esc_html__('Home', 'hopeui') . '</a></li> ';

			if (is_home()) {
				echo  '<li class="breadcrumb-item active">' . esc_html__('Blogs', 'hopeui') . '<span class="breadcrumbs-separator"></span></li>';
			} elseif (is_category()) {
				$this_cat = get_category(get_query_var('cat'), false);
				if ($this_cat->parent != 0) echo '<li class="breadcrumb-item">' . wp_kses(get_category_parents($this_cat->parent, TRUE, '  '), 'post') . '<span class="breadcrumbs-separator"></span></li>';
				echo  '<li class="breadcrumb-item active">' . esc_html__('Archive by category : ', 'hopeui') . ' "' . esc_html(single_cat_title('', false)) . '" <span class="breadcrumbs-separator"></span></li>';
			} elseif (is_search()) {
				echo  '<li class="breadcrumb-item active">' . esc_html__('Search results for : ', 'hopeui') . ' "' . esc_html(get_search_query()) . '"<span class="breadcrumbs-separator"></span></li>';
			} elseif (is_day()) {
				echo '<li class="breadcrumb-item"><a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . esc_html(get_the_time('Y')) . '</a><span class="breadcrumbs-separator"></span></li> ';
				echo '<li class="breadcrumb-item"><a href="' . esc_url(get_month_link(get_the_time('Y'), get_the_time('m'))) . '">' . esc_html(get_the_time('F')) . '</a><span class="breadcrumbs-separator"></span></li>  ';
				echo  '<li class="breadcrumb-item active">' . esc_html(get_the_time('d')) . '<span class="breadcrumbs-separator"></span></li>';
			} elseif (is_month()) {
				echo '<li class="breadcrumb-item"><a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . esc_html(get_the_time('Y')) . '</a><span class="breadcrumbs-separator"></span></li> ';
				echo  '<li class="breadcrumb-item active">' . esc_html(get_the_time('F')) . '<span class="breadcrumbs-separator"></span></li>';
			} elseif (is_year()) {
				echo  '<li class="breadcrumb-item active">' . esc_html(get_the_time('Y')) . '<span class="breadcrumbs-separator"></span></li>';
			} elseif (is_single() && !is_attachment()) {
				if (get_post_type() != 'post') {
					$post_type = get_post_type_object(get_post_type());
					$slug = $post_type->rewrite;
					if (!empty($slug)) {
						echo '<li class="breadcrumb-item"><a href="' .  esc_url(home_url($slug['slug'])) . '/">' . esc_html($post_type->labels->singular_name) . '</a><span class="breadcrumbs-separator"></span></li>';
					}
					if ($show_current == 1) echo '<li class="breadcrumb-item">' . esc_html(get_the_title()) . '<span class="breadcrumbs-separator"></span></li>';
				} else {
					$cat = get_the_category();
					if (!empty($cat)) {
						$cat = $cat[0];
						if ($show_current == 0) $cat = preg_replace("#^(.+)\as\s$#", "$1", $cat);
						echo '<li class="breadcrumb-item">' . wp_kses(get_category_parents($cat, TRUE, '  '), 'post') . '<span class="breadcrumbs-separator"></span></li>';
						if (!empty(get_the_title())) {
							if ($show_current == 1) echo  '<li class="breadcrumb-item active">' . esc_html(get_the_title()) . '<span class="breadcrumbs-separator"></span></li>';
						}
					}
				}
			} elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {
				$post_type = get_post_type_object(get_post_type());
				if ($post_type) {
					echo  '<li class="breadcrumb-item active">' . esc_html($post_type->labels->singular_name) . '<span class="breadcrumbs-separator"></span></li>';
				}
			} elseif (!is_single() && is_attachment()) {
				$parent = get_post($post->post_parent);
				$cat = get_the_category($parent->ID);
				$cat = $cat[0];
				echo '<li class="breadcrumb-item">' . esc_html(get_category_parents($cat, TRUE, '  ')) . '<span class="breadcrumbs-separator"></span></li>';
				echo '<li class="breadcrumb-item"><a href="' . esc_url(get_permalink($parent)) . '">' . esc_html($parent->post_title) . '</a><span class="breadcrumbs-separator"></span></li>';
				if ($show_current == 1) echo '<li class="breadcrumb-item active"> ' .  esc_html(get_the_title()) . '<span class="breadcrumbs-separator"></span></li>';
			} elseif (is_page() && !$post->post_parent) {
				if ($show_current == 1) echo  '<li class="breadcrumb-item active">' . esc_html(get_the_title()) . '<span class="breadcrumbs-separator"></span></li>';
			} elseif (is_page() && $post->post_parent) {
				$trail = '';
				if ($post->post_parent) {
					$parent_id = $post->post_parent;
					$breadcrumbs = array();
					while ($parent_id) {
						$page = get_post($parent_id);
						$breadcrumbs[] = '<li class="breadcrumb-item"><a href="' . esc_url(get_permalink($page->ID)) . '">' . esc_html(get_the_title($page->ID)) . '</a><span class="breadcrumbs-separator"></span></li>';
						$parent_id  = $page->post_parent;
					}
					$breadcrumbs = array_reverse($breadcrumbs);
					foreach ($breadcrumbs as $crumb) $trail .= $crumb;
				}

				echo wp_kses($trail, ["li" => ["class" => true], "a" => ["href" => true], "span" => ["class" => true]]);
				if ($show_current == 1) echo '<li class="breadcrumb-item active"> ' .  esc_html(get_the_title()) . '<span class="breadcrumbs-separator"></span></li>';
			} elseif (is_tag()) {
				echo  '<li class="breadcrumb-item active">' . esc_html__('Posts tagged', 'hopeui') . ' "' . esc_html(single_tag_title('', false)) . '"<span class="breadcrumbs-separator"></span></li>';
			} elseif (is_author()) {
				global $author;
				$userdata = get_userdata($author);
				echo  '<li class="breadcrumb-item active">' . esc_html__('Articles posted by : ', 'hopeui') . ' ' . esc_html($userdata->display_name) . '<span class="breadcrumbs-separator"></span></li>';
			} elseif (is_404()) {
				echo  '<li class="breadcrumb-item active">' . esc_html__('Error 404', 'hopeui') . '<span class="breadcrumbs-separator"></span></li>';
			}

			if (get_query_var('paged')) {
				echo '<li class="breadcrumb-item active">' . esc_html__('Page', 'hopeui') . ' ' . esc_html(get_query_var('paged')) . '<span class="breadcrumbs-separator"></span></li>';
			}
		}
		echo '</ol>';
	}

	public function is_hopeui_php_breadcrumb()
	{
		$page_id = get_queried_object_id();
		$breadcrumb_page_option = get_post_meta($page_id, 'page_banner', true);

		switch ($breadcrumb_page_option) {
			case 'disable':
				return false;
			case 'inherit':
				if (!get_theme_mod('display_breadcrumb', true) || !(get_theme_mod('display_breadcrumb_title', true) || get_theme_mod('display_breadcrumb_nav', true))) {
					return false;
				}
			default:
				return true;
				break;
		}
	}
}
