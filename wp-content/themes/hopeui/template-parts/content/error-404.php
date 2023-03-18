<?php

/**
 * Template part for displaying the page content when a 404 error has occurred
 *
 * @package hopeui
 */

namespace HopeUI\Utility;
?>
<div class="<?php printf('%s', esc_attr(apply_filters('content_container_class', 'container'))); ?>">
	<div class="content-area">
		<main class="site-main">
			<div class="error-404 not-found">
				<div class="page-content">
					<div class="row">
						<div class="col-sm-12 text-center">
							<div class="fourzero-image mb-5">
								<img src="<?php echo esc_url(get_theme_mod('404_banner_image', get_template_directory_uri() . '/assets/images/redux/404.png')); ?>" alt="<?php esc_attr_e('404', 'hopeui'); ?>" />
							</div>
							<h4>
								<?php echo esc_html(get_theme_mod('404_title', __('Oops! This Page is Not Found.', 'hopeui'))); ?>
							</h4>
							<p class="mb-5">
								<?php echo esc_html(get_theme_mod('404_description', __('The requested page does not exist.', 'hopeui'))); ?>
							</p>
							<div class="d-block">
								<?php hopeui()->hopeui_php_get_blog_readmore(home_url(), get_theme_mod('404_backtohome_title', __('Back to Home', 'hopeui'))); ?>
							</div>
						</div>
					</div>
				</div><!-- .page-content -->
			</div><!-- .error-404 -->
		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .container -->