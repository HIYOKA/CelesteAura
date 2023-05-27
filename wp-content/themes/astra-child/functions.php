<?php
/**
 * Astra Child Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Astra Child
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_ASTRA_CHILD_VERSION', '1.0.0' );

/**
 * Enqueue styles
 */
function child_enqueue_styles() {

	wp_enqueue_style( 'astra-child-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all' );

}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );

function astra_child_enqueue_custom_script() {
    wp_enqueue_script( 'custom-script', get_stylesheet_directory_uri() . '/js/custom-script.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'astra_child_enqueue_custom_script' );

function create_custom_table() {
    global $wpdb;

    $table_name = $wpdb->prefix . "custom_data";
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id int(10) unsigned NOT NULL AUTO_INCREMENT,
        name varchar(255) NOT NULL,
        value varchar(255) NOT NULL,
        url varchar(255),
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

add_action('init', 'create_custom_table');

function custom_api_routes() {
    register_rest_route('custom-data/v1', '/item', array(
        'methods' => 'GET, POST, PUT, DELETE',
        'callback' => 'handle_custom_data_request',
    ));
}

add_action('rest_api_init', 'custom_api_routes');

function handle_custom_data_request(WP_REST_Request $request) {
    global $wpdb;
    $table_name = $wpdb->prefix . "custom_data";

    switch ($request->get_method()) {
        case 'GET':
            $results = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);
            wp_send_json($results);

        case 'POST':
            $params = $request->get_params();
            $wpdb->insert($table_name, array(
                'name' => $params['name'],
                'value' => $params['value'],
                'url' => $params['url']
            ));
            wp_send_json(array('success' => true, 'message' => 'Data added successfully.'));

        case 'PUT':
            $params = $request->get_params();
            $id = $params['id'];
            $wpdb->update($table_name, array(
                'name' => $params['name'],
                'value' => $params['value'],
                'url' => $params['url']
            ), array('id' => $id));
            wp_send_json(array('success' => true, 'message' => 'Data updated successfully.'));

        case 'DELETE':
            $id = $request->get_param('id');
            $wpdb->delete($table_name, array('id' => $id));
            wp_send_json(array('success' => true, 'message' => 'Data deleted successfully.'));

        default:
            return new WP_Error('invalid_method', 'Invalid request method', array('status' => 400));
    }
}

function custom_menu_item_visibility($items, $menu, $args) {
    if (is_admin()) {
        return $items;
    }

    $hidden_menu_item_ids = array(5312); 
    $current_user = wp_get_current_user();

    if (!in_array('editor', $current_user->roles) && !in_array('administrator', $current_user->roles)) {
        foreach ($items as $key => $item) {
            if (in_array($item->ID, $hidden_menu_item_ids)) {
                unset($items[$key]);
            }
        }
    }

    return $items;
}
add_filter('wp_get_nav_menu_items', 'custom_menu_item_visibility', 10, 3);

add_action( 'template_redirect', 'restrict_access_to_specific_users' );

function restrict_access_to_specific_users(){
    global $post;
    $slug = $post->post_name;
    
    if($slug === 'manager' || $slug === 'manager-2' || $slug === 'manager-3'){
        if(!is_user_logged_in() || (!current_user_can('editor') && !current_user_can('administrator'))){
            wp_die('관리자만 접근할 수 있습니다. 3초 후 메인페이지로 이동합니다. <script>setTimeout(function(){window.location="'.home_url().'"}, 3000);</script>', 'Access denied', array(
                'response' => 403,
                'back_link' => true,
            ));
            exit;
        }
    }
}