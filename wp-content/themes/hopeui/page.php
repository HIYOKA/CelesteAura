<?php

/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage hopeui
 * @since 1.0
 * @version 1.0
 */
get_header();
$page_container = '';
if (get_post_meta(get_the_ID(), 'page_container_source', true) === "custom") {
	$page_container = get_post_meta(get_the_ID(), 'page_container', true);
} else {
	$page_container = get_theme_mod('hopeui_php_container_type', '');
}
?>
<div id="primary" class="content-area">
	<main id="main" class="site-main">
		<?php
		get_template_part('template-parts/page/container', $page_container);
		?>
	</main><!-- #main -->
</div><!-- .container -->
<?php get_footer();
