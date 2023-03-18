<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package hopeui
 */

namespace HopeUI\Utility;

get_header();
$hopeui_php_layout = '';
$is_sidebar = hopeui()->is_primary_sidebar_active();
$post_section = hopeui()->post_style();
$hopeui_php_layout = get_theme_mod('blog_setting', 3);
?>
<div class="site-content-contain">
	<div id="content" class="site-content">
		<div id="primary" class="content-area">
			<main id="main" class="site-main">
				<div class="<?php printf('%s', esc_attr(apply_filters('content_container_class', 'container'))); ?>">
					<div class="row <?php echo esc_attr($post_section['row_reverse']); ?>">
						<?php
						if ($is_sidebar) {
							echo '<div class="col-xl-9 col-sm-12 hopeui_style-blog-main-list"><div class="row">';
						} else if ($hopeui_php_layout != '2' && $hopeui_php_layout != '3') {
							echo '<div class="col-lg-12 col-sm-12 hopeui_style-blog-main-list"><div class="row">';
						}


						if (have_posts()) {
							while (have_posts()) {
								the_post();
								get_template_part('template-parts/content/entry', get_post_type(), $post_section['post']);
							}

							if (!is_singular()) {
								if (get_theme_mod('display_pagination', true)) {
									get_template_part('template-parts/content/pagination');
								}
							}
						} else {
							get_template_part('template-parts/content/error');
						}

						if ($is_sidebar || $hopeui_php_layout != '2' && $hopeui_php_layout != '3') {
							echo '</div></div>';
						}
						if ($is_sidebar) {
							get_sidebar();
						}
						?>
					</div>
				</div>
			</main><!-- #primary -->
		</div>
	</div>
</div>
<?php
get_footer();
