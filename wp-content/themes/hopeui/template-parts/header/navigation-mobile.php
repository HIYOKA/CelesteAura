<?php

/**
 * Template part for displaying the header navigation menu
 *
 * @package hopeui
 */

namespace HopeUI\Utility;

?>

<nav class="hopeui_style-menu-wrapper mobile-menu">
	<div class="navbar">

		<a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>">
			<?php
			get_template_part('template-parts/header/logo');
			?>
		</a>

		<button class="navbar-toggler custom-toggler ham-toggle close-custom-toggler" type="button">
			<span class="menu-btn d-inline-block is-active">
				<span class="line one"></span>
				<span class="line two"></span>
				<span class="line three"></span>
			</span>
		</button>
	</div>

	<div class="c-collapse">
		<div class="menu-new-wrapper">
			<div class="menu-scrollbar verticle-mn yScroller">
				<div id="hopeui_style-menu-main" class="hopeui_style-full-menu">
					<?php
					if (hopeui()->is_primary_nav_menu_active()) {
						hopeui()->display_primary_nav_menu(array('menu_class' => 'navbar-nav top-menu'));
					}
					?>
				</div>
			</div>
		</div>
	</div>
</nav><!-- #site-navigation -->