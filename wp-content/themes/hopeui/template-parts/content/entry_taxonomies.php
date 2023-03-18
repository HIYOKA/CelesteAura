<?php

/**
 * Template part for displaying a post's taxonomy terms
 *
 * @package hopeui
 */

namespace HopeUI\Utility;

$taxonomies = wp_list_filter(
	get_object_taxonomies($post, 'objects'),
	array(
		'public' => true,
	)
);

$hopeui_php_tags = wp_get_post_terms( $post->ID );
$hopeui_php_count = count( $hopeui_php_tags );

if($hopeui_php_count != 0){  
    ?>
	<ul class="hopeui_style-blogtag list-inline">
		<?php
		if ($hopeui_php_count == 1) {
			?>
			<li class="hopeui_style-label"><?php esc_html_e('Tag:','hopeui'); ?></li>  
			<?php
		} else {
			?>
				<li class="hopeui_style-label"><?php esc_html_e('Tags:','hopeui'); ?></li>  
			<?php
		}
	$post_tag = get_the_tags();
	if ($post_tag) { ?>
		<?php foreach ($post_tag as $_cat) { ?>
			<li><a href="<?php echo esc_url(get_tag_link($_cat)) ?>"><?php echo esc_html($_cat->name); ?></a></li>
		<?php } ?>
	<?php }
	?>
	</ul>
	<?php
}