<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package hopeui
 */

namespace HopeUI\Utility;

if(!hopeui()->is_primary_sidebar_active()){
	return;
}

?>
<div class=" col-xl-3 col-sm-12 mt-5 mt-xl-0 sidebar-service-right">
	<aside id="secondary" class="primary-sidebar widget-area">
		<h2 class="screen-reader-text"><?php esc_html_e( 'Asides', 'hopeui' ); ?></h2>
		<?php hopeui()->display_primary_sidebar(); ?>
	</aside><!-- #secondary -->
</div>
