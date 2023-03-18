<?php

/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */
namespace HopeUI\Utility;

defined('ABSPATH') || exit;


global $product;
$hopeui_php_option = get_option('hopeui_options');

if (!$product->is_purchasable()) {
	return;
}

echo wc_get_stock_html($product); // WPCS: XSS ok.

if ($product->is_in_stock()) : ?>

	<?php do_action('woocommerce_before_add_to_cart_form'); ?>

	<form class="cart" action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>" method="post" enctype='multipart/form-data'>

		<?php do_action('woocommerce_before_add_to_cart_button'); ?>
		<div class="hopeui_style-cart-btn-wrapper <?php echo class_exists('ReduxFramework') && isset($hopeui_php_option['hopeui_php_display_product_wishlist_icon']) && $hopeui_php_option['hopeui_php_display_product_wishlist_icon'] == "no" ? esc_attr('has-no-wishlist'): '' ?>">
			<?php
			do_action('woocommerce_before_add_to_cart_quantity');

			woocommerce_quantity_input(
				array(
					'min_value'   => apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product),
					'max_value'   => apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product),
					'input_value' => isset($_POST['quantity']) ? wc_stock_amount(wp_unslash($_POST['quantity'])) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
				)
			);

			do_action('woocommerce_after_add_to_cart_quantity');

			if (class_exists('YITH_WCWL') && is_singular()) {
			?>
				<div class="wishlist">
				<?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
			</div>												
			<?php
			}
			?>

		
			

		</div>
		<?php
			hopeui()->hopeui_php_common_style($tag = "button",  $label = $product->single_add_to_cart_text(),$show_icon = false,$attr = array(
				'href' => home_url(),
				'name' => 'add-to-cart',
				'value' => $product->get_id(),
				'class' => 'hopeui_php-add-to-cart btn btn-hover',
			));
			?>

		<?php do_action('woocommerce_after_add_to_cart_button'); ?>

	</form>

	<?php do_action('woocommerce_after_add_to_cart_form'); ?>

<?php endif;
