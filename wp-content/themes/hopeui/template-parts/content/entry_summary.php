<?php

/**
 * Template part for displaying a post's summary
 *
 * @package hopeui
 */

namespace HopeUI\Utility;
?>
<div class="entry-summary">
	<?php
	if (is_singular()) {
		get_template_part('template-parts/content/entry_date', get_post_type());
	}
	if (!empty(get_the_excerpt()) && ord(get_the_excerpt()) !== 38) {
		the_excerpt();
	}
	?>
</div><!-- .entry-summary -->