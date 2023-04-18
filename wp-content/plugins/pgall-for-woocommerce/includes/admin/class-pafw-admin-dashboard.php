<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'PAFW_Admin_Dashboard' ) ) {
	class PAFW_Admin_Dashboard {

		public static function init() {
			if ( current_user_can( 'view_woocommerce_reports' ) || current_user_can( 'manage_woocommerce' ) || current_user_can( 'publish_shop_orders' ) ) {
				add_action( 'wp_dashboard_setup', array( __CLASS__, 'setup_dashboard_widget' ) );
			}
		}
		public static function setup_dashboard_widget() {
			wp_register_style( 'pafw-dashboard', plugins_url( '/assets/css/dashboard.css', PAFW_PLUGIN_FILE ), array(), PAFW_VERSION );
			wp_register_style( 'font-awesome', '//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css' );

			wp_enqueue_style( 'pafw-dashboard' );
			wp_enqueue_style( 'font-awesome' );

			add_meta_box(
				'codem_sell_status',
				__( '판매 진행 현황', 'pgall-for-woocommerce' ),
				array( __CLASS__, 'sell_status_widget' ),
				'dashboard',
				'normal',
				'high'
			);

			add_meta_box(
				'codem_sell_total',
				__( '판매 실적 & 판매현황', 'pgall-for-woocommerce' ),
				array( __CLASS__, 'sell_total_widget' ),
				'dashboard',
				'side',
				'high'
			);
		}

		static function sell_status_widget() {
			ob_start();
			include( 'views/html-order-status.php' );
			ob_end_flush();
		}

		static function sell_total_widget() {
			//판매실적 & 판매현황
			global $wpdb;


			//워드프레스 타임존 설정을 가져와서 처리
			date_default_timezone_set( get_option( 'timezone_string' ) );

			$from_date = date( "Y-m-d 00:00:00" );
			$to_date   = date( "Y-m-d 23:59:59" );


			//주문 상태별 금일 결제된 금액 확인
			$query = "
        SELECT SUM(meta.meta_value) AS total_sales, COUNT(posts.ID) AS total_orders FROM {$wpdb->posts} AS posts
        LEFT JOIN {$wpdb->postmeta} AS meta ON posts.ID = meta.post_id
        WHERE
            meta.meta_key       = '_order_total' AND
            posts.post_type     = 'shop_order' AND
            posts.post_status IN ( 'wc-" . implode( "','wc-", apply_filters( 'woocommerce_reports_order_statuses', array( 'completed', 'processing', 'shipped', 'order-received', 'refunded' ) ) ) . "' ) AND
            posts.post_date BETWEEN '{$from_date}' AND '{$to_date}'";

			$tmp_today_result = $wpdb->get_row( $query );

			//주문 상태별 금일 환불된 금액 확인
			$query = "
    SELECT SUM(meta.meta_value) AS total_refund, COUNT(posts.ID) AS total_orders FROM  {$wpdb->posts} AS posts
        LEFT JOIN {$wpdb->postmeta} AS meta ON posts.ID = meta.post_id
        WHERE
            meta.meta_key       = '_refund_amount' AND
            posts.post_type     = 'shop_order_refund' AND
            posts.post_status IN ( 'wc-" . implode( "','wc-", apply_filters( 'woocommerce_reports_order_statuses', array( 'completed', 'processing', 'shipped', 'order-received', 'refunded' ) ) ) . "' ) AND
            posts.post_date BETWEEN '{$from_date}' AND '{$to_date}'";

			$tmp_today_refund_result = $wpdb->get_row( $query );

			//주문 상태별 금일 결제된 건수 확인
			$query = "
        SELECT SUM(meta.meta_value) AS total_sales, COUNT(posts.ID) AS total_orders FROM  {$wpdb->posts} AS posts
        LEFT JOIN {$wpdb->postmeta} AS meta ON posts.ID = meta.post_id
        WHERE
            meta.meta_key       = '_order_total' AND
            posts.post_type     = 'shop_order' AND
            posts.post_status IN ( 'wc-" . implode( "','wc-", apply_filters( 'woocommerce_reports_order_statuses', array( 'completed', 'processing', 'shipped', 'order-received' ) ) ) . "' ) AND
            posts.post_date BETWEEN '{$from_date}' AND '{$to_date}'";

			$tmp_today_cnt_result = $wpdb->get_row( $query );

			$today_total_cnt   = $tmp_today_cnt_result->total_orders;
			$today_total_price = ( $tmp_today_result->total_sales - $tmp_today_refund_result->total_refund );

			if ( empty( $today_total_price ) ) {
				$today_total_price = 0;
			}

			$from_date = date( "Y-m-01 00:00:00" );
			$to_date   = date( "Y-m-t 23:59:59" );

			$query = "
        SELECT SUM(meta.meta_value) AS total_sales, COUNT(posts.ID) AS total_orders FROM {$wpdb->prefix}posts AS posts
        LEFT JOIN {$wpdb->prefix}postmeta AS meta ON posts.ID = meta.post_id
        WHERE
            meta.meta_key       = '_order_total' AND
            posts.post_type     = 'shop_order' AND
            posts.post_status IN ( 'wc-" . implode( "','wc-", apply_filters( 'woocommerce_reports_order_statuses', array( 'completed', 'processing', 'shipped', 'order-received', 'refunded' ) ) ) . "' ) AND
            posts.post_date BETWEEN '{$from_date}' AND '{$to_date}'";

			$tmp_month_result = $wpdb->get_row( $query );

			$query = "
        SELECT SUM(meta.meta_value) AS total_refund, COUNT(posts.ID) AS total_orders FROM {$wpdb->prefix}posts AS posts
        LEFT JOIN {$wpdb->prefix}postmeta AS meta ON posts.ID = meta.post_id
        WHERE
            meta.meta_key       = '_refund_amount' AND
            posts.post_type     = 'shop_order_refund' AND
            posts.post_status IN ( 'wc-" . implode( "','wc-", apply_filters( 'woocommerce_reports_order_statuses', array( 'completed', 'processing', 'shipped', 'order-received', 'refunded' ) ) ) . "' ) AND
            posts.post_date BETWEEN '{$from_date}' AND '{$to_date}'";

			$tmp_month_refund_result = $wpdb->get_row( $query );

			$query = "
        SELECT SUM(meta.meta_value) AS total_sales, COUNT(posts.ID) AS total_orders FROM {$wpdb->prefix}posts AS posts
        LEFT JOIN {$wpdb->prefix}postmeta AS meta ON posts.ID = meta.post_id
        WHERE
            meta.meta_key       = '_order_total' AND
            posts.post_type     = 'shop_order' AND
            posts.post_status IN ( 'wc-" . implode( "','wc-", apply_filters( 'woocommerce_reports_order_statuses', array( 'completed', 'processing', 'shipped', 'order-received' ) ) ) . "' ) AND
            posts.post_date BETWEEN '{$from_date}' AND '{$to_date}'";

			$tmp_month_cnt_result = $wpdb->get_row( $query );

			$month_total_cnt   = $tmp_month_cnt_result->total_orders;
			$month_total_price = ( $tmp_month_result->total_sales - $tmp_month_refund_result->total_refund );
			if ( empty( $month_total_price ) ) {
				$month_total_price = 0;
			}

			?>
            <div class="contets_box_con">
                <div class="chat_box chat_top gray">
                    <h2>TODAY</h2>
                    <p class="b_line"></p>
                    <p class="badge red"><?php echo number_format( $today_total_cnt ); ?></p>
                    <h1><?php echo wc_price( $today_total_price ); ?></h1>
                </div>
                <div class="chat_box chat_top gray">
                    <h2>MONTH</h2>
                    <p class="b_line"></p>
                    <p class="badge red"><?php echo number_format( $month_total_cnt ); ?></p>
                    <h1><?php echo wc_price( $month_total_price ); ?></h1>
                </div>
            </div>
			<?php
		}
	}

	PAFW_Admin_Dashboard::init();
}
