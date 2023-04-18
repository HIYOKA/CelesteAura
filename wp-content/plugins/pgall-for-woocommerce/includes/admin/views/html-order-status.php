<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$post_counts = (array) wp_count_posts( 'shop_order' );

$on_hold_count        = $post_counts['wc-on-hold'];
$order_received_count = $post_counts['wc-order-received'];
$processing_count     = $post_counts['wc-processing'];
$shipping_count       = $post_counts['wc-shipping'];
$delayed_count        = $post_counts['wc-delayed'];
$shipped_count        = $post_counts['wc-shipped'];
?>

    <div id="grap_warp">
        <div class="grap deepblue">
            <span><i class="icon-eye-open"></i></span>
            <p class="grap_txt"><a href="<?php echo admin_url( 'edit.php?post_status=wc-on-hold&post_type=shop_order' ); ?>">입금확인중</a><br/><?php echo number_format( $on_hold_count ) . "건"; ?></p>
        </div>
        <div class="grap dkred">
            <span><i class="icon-shopping-cart"></i></span>
            <p class="grap_txt"><a href="<?php echo admin_url( 'edit.php?post_status=wc-order-received&post_type=shop_order' ); ?>">주문접수</a><br/><?php echo number_format( $order_received_count ) . "건"; ?></p>
        </div>
        <div class="grap dkgreen last">
            <span><i class="icon-tags"></i></span>
            <p class="grap_txt"><a href="<?php echo admin_url( 'edit.php?post_status=wc-processing&post_type=shop_order' ); ?>">발주확인</a><br/><?php echo number_format( $processing_count ) . "건"; ?></p>
        </div>
    </div>

    <div id="grap_warp">
        <div class="grap dkpurple">
            <span><i class="icon-plane"></i></span>
            <p class="grap_txt"><a href="<?php echo admin_url( 'edit.php?post_status=wc-shipping&post_type=shop_order' ); ?>">출고처리</a><br/><?php echo number_format( $shipping_count ) . "건"; ?></p>
        </div>
        <div class="grap dkorange">
            <span><i class="icon-warning-sign"></i></span>
            <p class="grap_txt"><a href="<?php echo admin_url( 'edit.php?post_status=wc-delayed&post_type=shop_order' ); ?>">출고지연</a><br/><?php echo number_format( $delayed_count ) . "건"; ?></p>
        </div>
        <div class="grap dkblue last">
            <span><i class="icon-flag"></i></span>
            <p class="grap_txt"><a href="<?php echo admin_url( 'edit.php?post_status=wc-shipped&post_type=shop_order' ); ?>">출고완료</a><br/><?php echo number_format( $shipped_count ) . "건"; ?></p>
        </div>
    </div>
