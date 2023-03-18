<?php

/**
 * HopeUI\Utility\Woocommerce\Component class
 *
 * @package hopeui
 */

namespace HopeUI\Utility\Woocommerce;

use HopeUI\Utility\Component_Interface;
use HopeUI\Utility\Templating_Component_Interface;
use function add_action;
use function HopeUI\Utility\hopeui;

/**
 * Class for managing Woocommerce UI.
 *
 * Exposes template tags:
 * * `hopeui()->the_comments( array $args = array() )`
 *
 * @link https://wordpress.org/plugins/amp/
 */
class Component implements Component_Interface, Templating_Component_Interface
{
	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Woocommerce slug.
	 */



	public function get_slug(): string
	{
		return 'woocommerce';
	}
	function __construct()
	{
		add_filter('woocommerce_gallery_thumbnail_size', function ($size) {
			return array(300, 300);
		});
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */

	public function initialize()
	{

		add_filter('woocommerce_show_page_title', '__return_false');
		remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
		add_action('woocommerce_before_shop_loop_item_title', array($this, 'hopeui_php_loop_product_thumbnail'), 10);

		remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
		remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);

		// WooCommerce Checkout Fields Hook
		add_filter('woocommerce_checkout_fields',  array($this, 'custom_wc_checkout_fields'));

		// Single
		remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
		add_action('woocommerce_single_product_summary',  array($this, 'woocommerce_my_single_title'), 5);
		add_action('after_setup_theme', array($this, 'hopeui_php_add_woocommerce_support'));
		remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
		remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

		add_action('woocommerce_before_main_content', array($this, 'hopeui_php_woocommerce_output_content_wrapper_start'));
		add_action('woocommerce_after_main_content', array($this, 'hopeui_php_woocommerce_output_content_wrapper_end'));

		// Remove add to cart
		remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');
		remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
		add_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 40);

		// Remove product title
		remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);

		// Remove product price
		remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);

		add_filter('get_the_archive_title', array($this, 'hopeui_php_product_archive_title'));

		/* Rating Create For Product Loop */
		remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);

		add_filter('woocommerce_add_to_cart_fragments', array($this, 'hopeui_php_refresh_mini_cart_count'));

		remove_action('woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10);
		remove_action('woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 20);
		add_action('woocommerce_widget_shopping_cart_buttons', array($this, 'custom_widget_cart_btn_view_cart'), 21);
		add_action('woocommerce_widget_shopping_cart_buttons', array($this, 'custom_widget_cart_checkout'), 12);

		add_filter('woocommerce_sale_flash', array($this, 'lw_hide_sale_flash'));


		/* hide terms and conditions toggle */
		add_action('wp_enqueue_scripts', array($this, 'hopeui_php_disable_terms'), 1000);

		/* woocommerce redirection after login registration */
		add_filter('woocommerce_registration_redirect', array($this, 'hopeui_php_after_login_registration'), 10, 1);
		add_filter('woocommerce_login_redirect', array($this, 'hopeui_php_after_login_registration'), 10, 1);


		add_action('woocommerce_before_checkout_form', array($this, 'hopeui_php_woocomerce_page_header'), -999);
		add_action('woocommerce_before_cart', array($this, 'hopeui_php_woocomerce_page_header'));
		add_action('hopeui_php_order_summary_before', array($this, 'hopeui_php_woocomerce_page_header'));

		add_filter('woocommerce_get_script_data', function ($params, $handle) {
			if (isset($params['i18n_view_cart'])) {
				$params['i18n_view_cart'] = '<span>' . $params['i18n_view_cart'] . '</span>';
			}
			return $params;
		}, 10, 2);


		if (has_filter('woocommerce_checkout_update_order_review_expired', true)) {
			add_filter('woocommerce_update_order_review_fragments', function ($ar) {
				$ar['form.woocommerce-checkout'] = "<div clas='woocommerce-notices-wrapper'>" . $ar['form.woocommerce-checkout'] . '</div>';
				return $ar;
			});
		}
	}
	public function template_tags(): array
	{
		return array(
			'hopeui_php_load_woocomerce_script' 	=> array($this, 'hopeui_php_load_woocomerce_script'),
			'hopeui_php_ajax_product_load_scripts' 	=> array($this, 'hopeui_php_ajax_product_load_scripts'),
		);
	}
	public function hopeui_php_load_woocomerce_script()
	{
		wp_enqueue_script("woocomerce-product-dependency", get_template_directory_uri() . '/assets/js/woocommerce.min.js',  array('jquery'), "1.0.0", true);
	}
	public function hopeui_php_ajax_product_load_scripts()
	{
		wp_enqueue_script("woocomerce-product-loadmore", get_template_directory_uri() . '/assets/js/ajax-product-load.min.js',  array('jquery'), "1.0.0", true);
	}
	/**
	 * Gets template tags to expose as methods on the Template_Tags class instance, accessible through `hopeui()`.
	 *
	 * @return array Associative array of $method_name => $callback_info pairs. Each $callback_info must either be
	 *               a callable or an array with key 'callable'. This approach is used to reserve the possibility of
	 *               adding support for further arguments in the future.
	 */

	public function lw_hide_sale_flash()
	{
		return false;
	}

	function hopeui_php_product_archive_title($title)
	{
		if (is_post_type_archive('product')) $title = esc_html__("Shop", 'hopeui');
		return $title;
	}

	function hopeui_php_add_woocommerce_support()
	{
		add_theme_support('woocommerce');
		add_theme_support('wc-product-gallery-zoom');
		add_theme_support('wc-product-gallery-lightbox');
		add_theme_support('wc-product-gallery-slider');
		// Declare WooCommerce support.
	}

	// overwrite existing output content wrapper function
	function hopeui_php_woocommerce_output_content_wrapper_start()
	{
		if (is_singular()) {
			echo '<div class="container">
						<div class="row" >
							<div class="col-sm-12" >';
		}
	}

	function hopeui_php_woocommerce_output_content_wrapper_end()
	{
		if (is_singular()) {
			echo '</div><!-- Col -->
						</div><!-- Close Row -->
					</div><!-- Close Container -->
				';
		}
	}

	function woocommerce_my_single_title()
	{
?>
		<h2 itemprop="name" class="product_title entry-title"><span>
				<h5 class="hopeui_style-product-title mt-0">
					<a href="<?php echo esc_url(the_permalink()); ?>" class="hopeui_style-product-title-link">
						<?php the_title('', '', true) ?>
					</a>
				</h5>
			</span></h3>
		<?php
	}

	public function hopeui_php_loop_product_thumbnail($args = array())
	{
		get_template_part('template-parts/wocommerce/entry');
	}

	// Change the format of fields with type, label, placeholder, class, required, clear, label_class, options
	function custom_wc_checkout_fields($fields)
	{

		//BILLING
		$fields['billing']['billing_first_name']['label'] = false;
		$fields['billing']['billing_first_name']['placeholder'] = "First Name *";

		$fields['billing']['billing_last_name']['label'] = false;
		$fields['billing']['billing_last_name']['placeholder'] = "Last Name *";

		$fields['billing']['billing_company']['label'] = false;
		$fields['billing']['billing_company']['placeholder'] = "Company *";

		$fields['billing']['billing_country']['label'] = false;
		$fields['billing']['billing_country']['placeholder'] = 'Country *';
		$fields['billing']['billing_address_1']['label'] = false;
		$fields['billing']['billing_city']['label'] = false;
		$fields['billing']['billing_city']['placeholder'] = 'City *';
		$fields['billing']['billing_state']['label'] = false;
		$fields['billing']['billing_state']['placeholder'] = 'State *';
		$fields['billing']['billing_postcode']['label'] = false;
		$fields['billing']['billing_postcode']['placeholder'] = 'Postcode *';
		$fields['billing']['billing_phone']['label'] = false;
		$fields['billing']['billing_phone']['placeholder'] = "Phone Number *";
		$fields['billing']['billing_email']['label'] = false;
		$fields['billing']['billing_email']['placeholder'] = "E-mail Address *";

		return $fields;
	}

	// refresh mini cart ------------//
	function hopeui_php_refresh_mini_cart_count($fragments)
	{
		ob_start();
		$empty = '';
		if (empty(WC()->cart->get_cart_contents_count())) {
			$empty = 'style=display:none';
		}
		?>
			<div id="mini-cart-count" <?php echo esc_attr($empty); ?> class="cart-items-count count">
				<?php echo  WC()->cart->get_cart_contents_count(); ?>
			</div>
		<?php
		$fragments['#mini-cart-count'] = ob_get_clean();
		return $fragments;
	}

	// Mini cart View Cart Buttou
	function custom_widget_cart_btn_view_cart()
	{
		hopeui()->hopeui_php_common_style($tag = "a",  $label = esc_html('View Cart', 'hopeui'), $show_icon = false, $attr = array(
			'href' => wc_get_cart_url(),
			'class' => 'checkout wc-forward view_cart btn-hover sample',
		));
	}

	//Mini Cart Checkout Button
	function custom_widget_cart_checkout()
	{
		hopeui()->hopeui_php_common_style($tag = "a",  $label = esc_html('Checkout', 'hopeui'), $show_icon = false, $attr = array(
			'href' => wc_get_checkout_url(),
			'class' => 'btn-hover checkout wc-forward',
		));
	}




	/* hide terms and conditions toggle */
	function hopeui_php_disable_terms()
	{
		wp_add_inline_script('wc-checkout', "jQuery( document ).ready( function() { jQuery( document.body ).off( 'click', 'a.woocommerce-terms-and-conditions-link' ); } );");
	}

	/* woocommerce redirection after login & registration */
	function hopeui_php_after_login_registration($hopeui_php_redirection_url)
	{
		$hopeui_php_redirection_url = esc_url(get_permalink(get_option('woocommerce_myaccount_page_id')) . 'my-account');
		return $hopeui_php_redirection_url;
	}


	public function hopeui_php_woocomerce_page_header()
	{
		$order_received =  is_checkout() && !empty(is_wc_endpoint_url('order-received'))  ? 'done' : '';
		$links = array(
			array(
				'name' => esc_html__('Shopping Cart', 'hopeui'),
				'class' => is_cart() ? 'active' : 'done',
			),
			array(
				'name' => esc_html__('Checkout', 'hopeui'),
				'class' => is_checkout() && empty(is_wc_endpoint_url('order-received'))  ? 'active' : $order_received,
			),
			array(
				'name' => esc_html__('Order Summary', 'hopeui'),
				'class' => is_checkout() && !empty(is_wc_endpoint_url('order-received'))  ? 'active' : '',
			),
		);

		?>
			<div class="hopeui_style-page-header">
				<ul class="hopeui_style-page-items">
					<?php
					foreach ($links as $key => $link) {
					?>
						<li class="hopeui_style-page-item <?php echo esc_attr($link['class']) ?>">
							<span class="hopeui_style-page-link ">
								<?php echo esc_html($link['name']); ?>
							</span>
						</li>
					<?php
					}
					?>
				</ul>
			</div>
	<?php
	}
}
