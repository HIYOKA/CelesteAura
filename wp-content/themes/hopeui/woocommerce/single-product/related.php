<?php

/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version      4.1.1
 */

namespace HopeUI\Utility;

if (!defined('ABSPATH')) {
	exit;
}
if ($related_products) :
	$hopeui_php_option = get_option('hopeui_options');
	if (isset($hopeui_php_option['hopeui_php_show_related_product']) && $hopeui_php_option['hopeui_php_show_related_product'] == 'no' && is_product()) {
		return false;
	}
?>

	<section class="related products container-fluid">
		<?php
		$heading = apply_filters('woocommerce_product_related_products_heading', isset($args['name']) ? $args['name'] : esc_html__('Related Products', 'hopeui'));
		if ($heading) :
		?>

			<div class=" hopeui_style-title-box hopeui_style-title-box-1 text-animation">
				<h4 class="main-title">
					<?php
					echo esc_html($heading);
					?>
				</h4>
			</div>

		<?php endif; ?>

		<div class="columns-4 products  hopeui_style-main-product">
			<?php

			foreach ($related_products as $related_product) :
				if (!$related_product) continue;
				$post_object = get_post($related_product->get_id());
				setup_postdata($GLOBALS['post'] = &$post_object);
				get_template_part('template-parts/wocommerce/entry');
			endforeach;

			?>
		</div>

	</section>
<?php
endif;

wp_reset_postdata();
