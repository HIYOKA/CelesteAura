<?php

/**
 * Template part for displaying a post's date
 *
 * @package hopeui
 */

namespace HopeUI\Utility;

$post_type_obj = get_post_type_object(get_post_type());
$time_string = '';



// Show date only when the post type is 'post' or has an archive.
if ('post' === $post_type_obj->name || $post_type_obj->has_archive) {
	$time_string = '
	<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if (get_the_time('U') !== get_the_modified_time('U')) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	}

	$time_string = sprintf(
		$time_string,
		esc_attr(get_the_date('c')),
		esc_html(get_the_date()),
		esc_attr(get_the_modified_date('c')),
		esc_html(get_the_modified_date())
	);
	$archive_year  = get_the_time('Y');
	$archive_month = get_the_time('m');
	$archive_day   = get_the_time('d');
	$time_string = '<a href="' . esc_url(get_day_link($archive_year, $archive_month, $archive_day)) . '" rel="bookmark">' . $time_string . '</a>';
}

if (!empty($time_string)) { ?>
	<span class="posted-on hopeui_style-meta-date <?php echo isset($args['class']) ? esc_attr($args['class']) : '' ?>">
		<?php printf('%s', wp_kses($time_string, 'post')); ?>

	</span>
<?php
}
