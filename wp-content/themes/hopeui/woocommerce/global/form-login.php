<?php

/**
 * Login form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.6.0
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (is_user_logged_in()) {
	return;
}

?>
<form class="woocommerce-form woocommerce-form-login login" method="post">
	<div class="col-lg-6 mx-auto">
		<div class="hopeui_style-login-form-wrapper">
			<?php do_action('woocommerce_login_form_start'); ?>

			<?php echo esc_html($message) ? wpautop(wptexturize($message)) : ''; // @codingStandardsIgnoreLine 
			?>
			<div class="row">
				<div class="col-lg-12">
					<p class="clearfix">
						<label for="username" class="mb-3"><?php esc_html_e('Username or email', 'hopeui'); ?>&nbsp;<span class="required">*</span></label>
						<input type="text" class="input-text" name="username" id="username" autocomplete="username" />
					</p>
				</div>

				<div class="col-lg-12">
					<p class="clearfix">
						<label for="password" class="mb-3"><?php esc_html_e('Password', 'hopeui'); ?>&nbsp;<span class="required">*</span></label>
						<input class="input-text" type="password" name="password" id="password" autocomplete="current-password" />
					</p>
				</div>

				<div class="clear"></div>

				<?php do_action('woocommerce_login_form'); ?>

				<div class="hopeui_style-form-remember-wrapper">
					<div class="hopeui_style-check">
						<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
							<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /><span class="checkmark"></span><span><span class="text-check"><?php esc_html_e('Remember me', 'hopeui'); ?></span>
						</label>
					</div>
					<p class="lost_password">
						<a href="<?php echo esc_url(wp_lostpassword_url()); ?>"><?php esc_html_e('Lost your password?', 'hopeui'); ?></a>
					</p>



				</div>
				<div class="clear"></div>
				<?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
				<input type="hidden" name="redirect" value="<?php echo esc_url($redirect); ?>" />

				<button type="submit" class="woocommerce-button  btn woocommerce-form-login__submit hopeui_style-button " name="login" value="<?php esc_attr_e('Login', 'hopeui'); ?>">
					<?php esc_html_e('Login', 'hopeui'); ?>
				</button>



				<?php do_action('woocommerce_login_form_end'); ?>
			</div>
		</div>
	</div>
</form>