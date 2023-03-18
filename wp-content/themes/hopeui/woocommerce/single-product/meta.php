<?php

/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.0.0
 */

if (!defined('ABSPATH')) {
	exit;
}
$hopeui_php_option = get_option('hopeui_options');
global $product;
?>
<div class="product_meta">

	<?php do_action('woocommerce_product_meta_start'); ?>

	<?php if (wc_product_sku_enabled() && ($product->get_sku() || $product->is_type('variable'))) : ?>

		<span class="sku_wrapper"><span class="sku_title"><?php esc_html_e('SKU :', 'hopeui'); ?></span> <span class="sku"><?php echo esc_html($sku = $product->get_sku()) ? $sku : esc_html__('N/A', 'hopeui'); ?></span></span>

	<?php endif; ?>

	<?php
	
		// Categories
		$prodcat = get_the_terms($product->get_id(), 'product_cat');
		if (!empty($prodcat)) {
			echo '<span class="posted_in hopeui_style-product-meta-list">';
			echo '<span>' . _n('Category :', 'Categories :', count($product->get_category_ids()), 'hopeui') . '</span>';
			foreach ($prodcat as $cat) { ?>
				<a href="<?php echo get_category_link($cat->term_id) ?>"><?php echo esc_html($cat->name); ?></a></li>
	<?php
			}
			echo '</span>';
		}
	
	?>


	<?php
	// Tags
	$prodcat = get_the_terms($product->get_id(), 'product_tag');
	if (!empty($prodcat)) {
		echo '<span class="tagged_as hopeui_style-product-meta-list">';
		echo '<span>' . _n('Tag :', 'Tags :', count($product->get_tag_ids()), 'hopeui') . '</span>';
		foreach ($prodcat as $cat) { ?>
			<a href="<?php echo get_category_link($cat->term_id) ?>"><?php echo esc_html($cat->name); ?></a>
	<?php
		}
		echo '</span>';
	}
	?>

	<?php do_action('woocommerce_product_meta_end'); ?>

</div>