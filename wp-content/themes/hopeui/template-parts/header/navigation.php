<?php

/**
 * Template part for displaying the header navigation menu
 *
 * @package hopeui
 */

namespace HopeUI\Utility;

?>

<nav id="site-navigation" class="navbar deafult-header navbar-expand-xl navbar-light p-0" aria-label="<?php esc_attr_e('Main menu', 'hopeui'); ?>" <?php
																																					if (hopeui()->is_amp()) {
																																					?> [class]=" siteNavigationMenu.expanded ? 'main-navigation nav--toggle-sub nav--toggle-small nav--toggled-on' : 'main-navigation nav--toggle-sub nav--toggle-small' " <?php
																																																																														}
																																																																															?>>

	<a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>">
		<?php
		if (has_custom_logo()) {
			$image = wp_get_attachment_url(get_theme_mod('custom_logo'));
			if (!empty($image)) {
				echo '<img class="img-fluid logo" src="' . esc_url($image) . '" alt="hopeui">';
			}
		}
		if (display_header_text()) { ?>
			<div class="hopeui_style-site-title-container">
				<h4 class="hopeui_style-logo-title"> <?php bloginfo('name'); ?></h4>
			</div>
		<?php } ?>
	</a>

	<div id="navbarSupportedContent" class="collapse navbar-collapse new-collapse justify-content-end">
		<div id="hopeui_style-menu-container" class="menu-all-pages-container">
			<?php
			if (hopeui()->is_primary_nav_menu_active()) {
				hopeui()->display_primary_nav_menu(array(
					'menu_class' => 'sf-menu top-menu navbar-nav ml-auto',
					'item_spacing' => 'discard'
				));
			}
			?>
		</div>
	</div>
	<div class="hopeui_style-header-right">
		<ul class="list-inline list-main-parent m-0">
			<?php if (get_theme_mod('display_search', true)) { ?>
				<li class="inline-item header-search">
					<?php get_template_part('template-parts/header/search'); ?>
				</li>
				<li class="inline-item header-search-toggle header-notification-icon">
					<div class="dropdown dropdown-search">
						<button class="hopeui_script-dropdown-toggle search-toggle animate slideIn btn" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-search"></i></button>
						<div class="dropdown-menu header-search dropdown-menu-right">
							<?php get_template_part('template-parts/header/search'); ?>
						</div>
					</div>
				</li>
			<?php }
			if (get_theme_mod('hopeui_php_display_cart', true)  && class_exists('woocommerce')) { ?>
				<li class="inline-item header-cart-icon header-notification-icon">
					<?php get_template_part('template-parts/header/cart'); ?>
				</li>
			<?php }
			?>
		</ul>
		<?php if (hopeui()->is_primary_nav_menu_active()) { ?>
			<button class="navbar-toggler custom-toggler ham-toggle" type="button">
				<span class="menu-btn d-inline-block" id="menu-btn">
					<span class="line one"></span>
					<span class="line two"></span>
					<span class="line three"></span>
				</span>
			</button>
		<?php } ?>
	</div>
</nav><!-- #site-navigation -->