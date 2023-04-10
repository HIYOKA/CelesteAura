<?php

/**
 * Template part for displaying a post's header
 *
 * @package hopeui
 */

namespace HopeUI\Utility;

?>
<?php
if (!is_search()) {
	if (is_archive()) {
		if (get_theme_mod('display_feature_img_archive', true)) {
			get_template_part('template-parts/content/entry_thumbnail', get_post_type());
		}
	} else {
		get_template_part('template-parts/content/entry_thumbnail', get_post_type());
	}
} ?>
<div class="hopeui_style-blog-detail">
	<?php
	get_template_part('template-parts/content/entry_date', get_post_type(), array('class' => 'd-block'));
	get_template_part('template-parts/content/entry_title', get_post_type());
	get_template_part('template-parts/content/entry_meta', get_post_type());
	?>
	<!-- .entry-header -->