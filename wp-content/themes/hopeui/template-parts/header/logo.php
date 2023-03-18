<?php

/**
 * Template part for displaying the header search
 *
 * @package HopeUI
 */

namespace HopeUI\Utility;

if (has_custom_logo()) {
    $image = wp_get_attachment_url(get_theme_mod('hopeui_php_mobile_logo'));
    if (!empty($image)) {
        echo '<img class="img-fluid logo" src="' . esc_url($image) . '" alt="hopeui">';
    }
}
if (display_header_text()) { ?>
    <div class="hopeui_style-site-title-container">
        <h4 class="hopeui_style-logo-title m-0"><?php bloginfo('name'); ?></h4>
    </div>
<?php } ?>