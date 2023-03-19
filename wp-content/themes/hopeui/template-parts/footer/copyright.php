<?php

/**
 * Template part for displaying the footer info
 *
 * @package hopeui
 */

namespace HopeUI\Utility;
?>
<div class="copyright-footer">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 m-0 text-<?php echo esc_attr(get_theme_mod('footer_copyright_alignment','center')); ?>">
				<div class="pt-3 pb-3">
					<?php if (get_theme_mod('display_footer_copyright', true)) {  ?>
						<span class="copyright">
							<?php echo esc_html(get_theme_mod('footer_copyright_text', __('Copyright © 2022 - WordPress Theme by HopeUI', 'hopeui'))); ?>
						</span>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div><!-- .site-info -->
<?php
