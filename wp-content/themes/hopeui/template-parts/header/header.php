<?php

/**
 * Template part for displaying the header
 *
 * @package hopeui
 */

namespace HopeUI\Utility;


global $hopeui_php_options;
$bgurl = $site_classes = $has_sticky = $default_header_container = '';
//theme site class
//loader
if (isset($hopeui_php_options['display_loader']) && $hopeui_php_options['display_loader'] === 'yes') {
    if (!empty($hopeui_php_options['loader_gif']['url'])) {
        $bgurl = $hopeui_php_options['loader_gif']['url'];
    }
}
//sticky header
if (isset($hopeui_php_options['display_sticky_header']) && $hopeui_php_options['display_sticky_header'] == 'yes') {
    $has_sticky = ' has-sticky';
}
// container
$default_header_container = get_theme_mod('header_container', 'container-fluid');

$has_sticky = ' has-sticky';
?>
<?php if (get_theme_mod('hopeui_php_show_loader', false)) { ?>
    <div id="loading">
        <div id="loading-center">
            <img src="<?php echo esc_url(get_theme_mod('hopeui_php_loader_img'), get_template_directory_uri() . '/assets/images/redux/loader.gif'); ?>" alt="<?php esc_attr_e('loader', 'hopeui'); ?>">
        </div>
    </div>
    <!-- loading End -->
<?php } ?>
<div id="page" class="site <?php echo esc_attr(trim($site_classes)); ?>">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'hopeui'); ?></a>
    <header class="header-default<?php echo esc_attr($has_sticky); ?>" id="default-header">
        <div class="<?php echo esc_attr($default_header_container); ?>">
            <div class="row">
                <div class="col-md-12">
                    <?php
                    get_template_part('template-parts/header/navigation');
                    ?>
                </div>
            </div>
        </div>
    </header><!-- #masthead -->
    <div class="hopeui_style-mobile-menu menu-style-one">
        <?php get_template_part('template-parts/header/navigation', 'mobile'); ?>
    </div>