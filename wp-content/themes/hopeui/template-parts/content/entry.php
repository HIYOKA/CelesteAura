<?php

/**
 * Template part for displaying a post
 *
 * @package hopeui
 */

namespace HopeUI\Utility;


?>
<div class="hopeui_style-blog-item <?php echo esc_attr($args); ?>">
	<article id="post-<?php the_ID(); ?>" <?php post_class('entry'); ?>>
		<div class="hopeui_style-blog-box">
			<?php
			if (!is_singular('team')) {
				get_template_part('template-parts/content/entry_header', get_post_type());
			}
			if (is_single()) {
				get_template_part('template-parts/content/entry_content', get_post_type());
			} else {
				get_template_part('template-parts/content/entry_summary', get_post_type());
			}
			wp_link_pages(array(
				'before'      => '<div class="page-links">' . esc_html__('Pages:', 'hopeui'),
				'after'       => '</div>',
				'link_before' => '<span class="page-number">',
				'link_after'  => '</span>',
			));
			if (!is_single()) {
				get_template_part('template-parts/content/entry_footer', get_post_type());
			}
			?>
		</div>
	</article>
	<!-- #post-<?php the_ID(); ?> -->
	<?php

	if (is_singular(get_post_type())) {
		if (get_theme_mod('display_comment', true)) {
			// Show comments only when the post type supports it and when comments are open or at least one comment exists.
			if (post_type_supports(get_post_type(), 'comments') && (comments_open() || get_comments_number())) {
				comments_template();
			}
		}
	}
	?>
</div>