<?php

global $product;
global $post;

$product = isset($args['id']) ? wc_get_product($args['id']) :  wc_get_product($post->ID); // condition fro Load Template from Plugin 
if (!$product) {
	return '';
}
?>
<div <?php wc_product_class('hopeui_style-sub-product', $product->get_id()); ?>>
	<div class="hopeui_style-inner-box ">
		<div class="hopeui_style-product-block">
			<?php
			$newness_days = 30;
			$created = strtotime($product->get_date_created());
			if (!$product->is_in_stock()) {
			?>
				<span class="onsale hopeui_style-sold-out"><span><?php echo esc_html__('Sold!', 'hopeui') ?></span></span>
			<?php } else if ($product->is_on_sale()) { ?>
				<span class="onsale hopeui_style-on-sale"><span><?php echo esc_html__('Sale!', 'hopeui') ?></span></span>
			<?php } else if ((time() - (60 * 60 * 24 * $newness_days)) < $created) { ?>
				<span class="onsale hopeui_style-new"><span><?php echo esc_html__('New!', 'hopeui'); ?></span></span>
			<?php } ?>

			<div class="hopeui_style-image-wrapper">
				<?php
				if ($product->get_image_id()) {
					$product->get_image('shop_catalog');
					$image = wp_get_attachment_image_src($product->get_image_id(), 'hopeui-product'); ?>
					<a href="<?php echo esc_url(the_permalink($product->get_id())); ?>" class="hopeui_style-product-title-link ">
						<div class="hopeui_style-product-image">
							<?php echo wp_kses(woocommerce_get_product_thumbnail(), array('img' => array('class' => true, 'src' => true, 'alt' => true, 'height' => true, 'width' => true))) ?>
						</div>
					</a><?php
					} else { ?>
					<a href="<?php echo esc_url(the_permalink($product->get_id())); ?>" class="hopeui_style-product-title-link ">
						<?php
						echo printf('<div class="hopeui_style-product-image"><img src="%s" alt="%s" class="wp-post-image" /></div>', esc_url(wc_placeholder_img_src()), esc_html__('Awaiting product image', 'hopeui')); ?>
					</a><?php
					}
						?>
			</div>
			<div class="hopeui_style-btn-container">
				<a href="<?php echo esc_url($product->add_to_cart_url()); ?>" class=" <?php echo $product->get_id() && !$product->is_type('grouped') ?   esc_attr('ajax_add_to_cart') : '' ?>  add_to_cart_button hopeui_style-button" data-product_id="<?php echo esc_attr($product->get_id()); ?>" data-product_sku="<?php echo esc_attr($product->get_sku()); ?>" data-product_name="<?php the_title(); ?>">
					<svg class="icon-24" width="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path opacity="0.4" fill-rule="evenodd" clip-rule="evenodd" d="M5.91064 20.5886C5.91064 19.7486 6.59064 19.0686 7.43064 19.0686C8.26064 19.0686 8.94064 19.7486 8.94064 20.5886C8.94064 21.4186 8.26064 22.0986 7.43064 22.0986C6.59064 22.0986 5.91064 21.4186 5.91064 20.5886ZM17.1606 20.5886C17.1606 19.7486 17.8406 19.0686 18.6806 19.0686C19.5106 19.0686 20.1906 19.7486 20.1906 20.5886C20.1906 21.4186 19.5106 22.0986 18.6806 22.0986C17.8406 22.0986 17.1606 21.4186 17.1606 20.5886Z" fill="currentColor"></path>
						<path fill-rule="evenodd" clip-rule="evenodd" d="M20.1907 6.34909C20.8007 6.34909 21.2007 6.55909 21.6007 7.01909C22.0007 7.47909 22.0707 8.13909 21.9807 8.73809L21.0307 15.2981C20.8507 16.5591 19.7707 17.4881 18.5007 17.4881H7.59074C6.26074 17.4881 5.16074 16.4681 5.05074 15.1491L4.13074 4.24809L2.62074 3.98809C2.22074 3.91809 1.94074 3.52809 2.01074 3.12809C2.08074 2.71809 2.47074 2.44809 2.88074 2.50809L5.26574 2.86809C5.60574 2.92909 5.85574 3.20809 5.88574 3.54809L6.07574 5.78809C6.10574 6.10909 6.36574 6.34909 6.68574 6.34909H20.1907ZM14.1307 11.5481H16.9007C17.3207 11.5481 17.6507 11.2081 17.6507 10.7981C17.6507 10.3781 17.3207 10.0481 16.9007 10.0481H14.1307C13.7107 10.0481 13.3807 10.3781 13.3807 10.7981C13.3807 11.2081 13.7107 11.5481 14.1307 11.5481Z" fill="currentColor"></path>
					</svg>
				</a>
			</div>
		</div>
		<div class="product-caption">

			<div class="hopeui_style-price-title-rating d-flex justify-content-between align-items-center ">
				<h6 class="woocommerce-loop-product__title th13  m-0">
					<a href="<?php echo esc_url(the_permalink($product->get_id())); ?>" class="hopeui_style-product-title-link ">
						<?php echo esc_html($product->get_name()); ?>
					</a>
				</h6>
				<div class="container-average-rating">
					<?php
					$rating_count = $product->get_rating_count();
					if ($rating_count >= 0) {
						$average      = $product->get_average_rating();
					?>
						<div class="star-rating">
							<span>
								<i class="fa-solid fa-star"></i>
								<?php printf('<span>%s</span> ', esc_html($average)); ?>
							</span>
						</div>
					<?php } ?>
				</div>
			</div>
			<div class="hopeui_style-price-rating-count d-flex justify-content-between align-items-center ">
				<div class="price-detail">
					<h5 class="price">
						<?php echo wp_kses($product->get_price_html(), 'hopeui'); ?>
					</h5>
				</div>
				<div class="container-rating">
					<?php
					if ($rating_count >= 0) {
					?>
						<div class="star-rating">
							<span>
								<?php printf('%s %s', esc_html($rating_count), $rating_count > 1 ? __('Ratings', 'hopeui') : __('Rating', 'hopeui')); ?>
							</span>
						</div>
					<?php } ?>
				</div>

			</div>

		</div>
	</div>
</div>