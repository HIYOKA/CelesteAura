<?php

/**
 * Template part for displaying a post's featured image
 *
 * @package hopeui
 */

namespace HopeUI\Utility;

// Audio or video attachments can have featured images, so they need to be specifically checked.
$support_slug = get_post_type();
if ('attachment' === $support_slug) {
	if (wp_attachment_is('audio')) {
		$support_slug .= ':audio';
	} elseif (wp_attachment_is('video')) {
		$support_slug .= ':video';
	}
}

if (post_password_required() || !post_type_supports($support_slug, 'thumbnail')) {
	return;
}

if (is_singular(get_post_type())) {
?>
	<?php if (has_post_thumbnail()) : ?>
		<div class="hopeui_style-blog-image">
			<?php the_post_thumbnail('', array('class' => 'skip-lazy')); ?>
		</div><!-- .post-thumbnail -->
	<?php endif; ?>
	<?php
} else {
	if (has_post_thumbnail()) { ?>
		<div class="hopeui_style-blog-image">
			<?php
			if ('video' === get_post_format() || 'audio' === get_post_format()) {
				echo wp_kses(hopeui()->hopeui_php_get_embed_video(get_the_ID()), 'post');
			} elseif ('gallery' === get_post_format()) {
				echo wp_kses(get_post_gallery(), 'post');
			} else {
			?>
				<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
					<?php
					global $wp_query;
					if (0 === $wp_query->current_post) {
						the_post_thumbnail(
							'post-thumbnail',
							array(
								'class' => 'skip-lazy',
								'alt'   => the_title_attribute(
									array(
										'echo' => false,
									)
								),
							)
						);
					} else {
						the_post_thumbnail(
							'post-thumbnail',
							array(
								'alt' => the_title_attribute(
									array(
										'echo' => false,
									)
								),
							)
						);
					}
					?>
				</a><!-- .post-thumbnail -->
		</div>
<?php }
		}
	}
