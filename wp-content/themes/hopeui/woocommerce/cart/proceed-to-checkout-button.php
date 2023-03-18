<?php

/**
 * Proceed to checkout button
 *
 * Contains the markup for the proceed to checkout button on the cart.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/proceed-to-checkout-button.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.4.0
 */
namespace HopeUI\Utility;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

hopeui()->hopeui_php_common_style($tag = "a",  $label = 'Proceed to checkout', $show_icon = false, $attr = array(
    'href' => wc_get_checkout_url(),
    'class' => 'alt wc-forward btn-hover'
));