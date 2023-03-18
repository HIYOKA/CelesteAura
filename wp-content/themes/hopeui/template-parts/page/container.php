<?php

/**
 * Template part for displaying the header branding
 *
 * @package hopeui
 */

namespace HopeUI\Utility;

$page_structure =  get_post_meta(get_queried_object_id(), 'page_structure', true);

$noSidebar  = $page_structure == 'default' || $page_structure == 'no_sidebar';
$reverse = $page_structure == "left_sidebar" ? "flex-row-reverse" : '';

?>

<div class="<?php echo apply_filters('content_container_class', esc_attr('container')); ?>">
    <div class="row <?php echo esc_attr($reverse) ?>">
    <?php
    if (!$noSidebar) { ?>
        <div class="col-md-8 col-sm-12">
        <?php } else { ?>
            <div class="col-md-12 col-sm-12">
            <?php }
        while (have_posts()) : the_post();
            get_template_part('template-parts/content/entry_page', get_post_type());
        endwhile; // End of the loop.
        wp_reset_postdata();
            ?>
        </div>

        <?php
        if (!$noSidebar) {
        ?>
            <div class="col-md-4 col-sm-12">
                <?php
                dynamic_sidebar('sidebar-1');
                ?>
            </div>
        <?php
        } ?>
    </div>
</div><!-- #primary -->