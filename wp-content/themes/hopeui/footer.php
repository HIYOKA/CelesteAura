<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package hopeui
 */

namespace HopeUI\Utility;

?>
<footer class="footer hopeui_style-footer">
	<?php
	get_template_part('template-parts/footer/widget');
	get_template_part('template-parts/footer/copyright');
	?>
</footer><!-- #colophon -->
<?php


if (get_theme_mod('back_to_top', true)) {
?>
	<!-- === back-to-top === -->
	<div id="back-to-top" class="hopeui_style-top">
		<a class="top" id="top" href="#top">
			<i aria-hidden="true" class="fa fa-caret-up"></i>
			<?php
			if (!empty(get_theme_mod('back_to_top_btn_text'))) {
			?>
				<span><?php echo esc_html(get_theme_mod('back_to_top_btn_text')); ?></span>
			<?php
			}
			?>
		</a>
	</div>
	<!-- === back-to-top End === -->
<?php
}
?>
</div><!-- #page -->
<?php wp_footer(); ?>
</body>

</html>