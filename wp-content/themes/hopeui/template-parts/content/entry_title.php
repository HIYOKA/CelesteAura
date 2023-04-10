<?php

/**
 * Template part for displaying a post's title
 *
 * @package hopeui
 */

namespace HopeUI\Utility;


if (!empty(trim(get_the_title()))) {
	echo '<a href="' . esc_url(get_permalink()) . '" rel="bookmark"><h3 class="entry-title">' . esc_html(get_the_title()) . '</h3></a>';
}
