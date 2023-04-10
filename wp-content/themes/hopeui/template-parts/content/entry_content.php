<?php

/**
 * Template part for displaying a post's content
 *
 * @package hopeui
 */

namespace HopeUI\Utility;



if (is_single()) {
?>
	<div class="hopeui_style-entry-content">
	<?php
	the_content();
} else {
	?>
		<div class="hopeui_style-entry-excerpt">
		<?php
		the_excerpt();
	}
		?>
		</div><!-- .entry-excerpt -->
	</div>