<?php

/**
 * Template part for displaying the page header of the currently displayed page
 *
 * @package hopeui
 */

namespace HopeUI\Utility;

if (is_404()) {
?>
	<header class="page-header">
		<h1 class="page-title">
			<?php esc_html_e('Oops! That page can&rsquo;t be found.', 'hopeui'); ?>
		</h1>
	</header><!-- .page-header -->
<?php
} elseif (is_home() && !have_posts()) {
?>
	<header class="page-header">
		<h1 class="page-title">
			<?php esc_html_e('Nothing Found', 'hopeui'); ?>
		</h1>
	</header><!-- .page-header -->
<?php
} elseif (is_home() && !is_front_page()) {
?>
	<header class="page-header">
		<h1 class="page-title">
			<?php single_post_title(); ?>
		</h1>
	</header><!-- .page-header -->
<?php
} elseif (is_search()) {
?>
	<header class="page-header">
		<h2 class="page-title">
			<?php
			printf(
				__('Search Results for: %s', 'hopeui'),
				'<span>' . esc_html(get_search_query()) . '</span>'
			);
			?>
		</h2>
	</header><!-- .page-header -->
<?php
} elseif (is_archive()) {
?>
	<header class="page-header">
		<?php
		the_archive_title('<h1 class="page-title">', '</h1>');
		the_archive_description('<div class="archive-description">', '</div>');
		?>
	</header><!-- .page-header -->
<?php
}
