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
function child_enqueue_styles() { //style.css를 사용하기 위한 함수

	wp_enqueue_style( 'astra-child-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all' );

}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );
// add_action : 특정 훅에 특정 함수를 등록하는 함수
// 훅 : 특정 시점에 실행되는 함수
//wp_enqueue_scripts : 워드프레스에서 제공하는 훅 중 하나로, 웹사이트의 스크립트와 스타일을 로드하는 시점에 실행되는 함수

function astra_child_enqueue_custom_script() { //custom-script.js를 사용하기 위한 함수
    wp_enqueue_script( 'custom-script', get_stylesheet_directory_uri() . '/js/custom-script.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'astra_child_enqueue_custom_script' );

function create_custom_table() { 
    //테이블 생성하여 get, post, put, delete 요청을 처리하려 했으나 워드프레스, 우커머스 db를 사용하여 쓰이진 않음.
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
// init : 워드프레스에서 제공하는 훅 중 하나로, 웹사이트 초기화 시점에 실행되는 함수

function custom_api_routes() { //쓰이지 않음
    register_rest_route('custom-data/v1', '/item', array(
        'methods' => 'GET, POST, PUT, DELETE',
        'callback' => 'handle_custom_data_request',
    ));
}

add_action('rest_api_init', 'custom_api_routes');
// rest_api_init : 워드프레스에서 제공하는 훅 중 하나로, REST API 초기화 시점에 실행되는 함수

function handle_custom_data_request(WP_REST_Request $request) { // 쓰이지 않음
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

function custom_menu_item_visibility($items, $menu, $args) { //관리자와 에디터만 접근 가능한 메뉴를 일반 사용자에게는 보이지 않게 함.
    if (is_admin()) {
        return $items;
    }

    $hidden_menu_item_ids = array(5312); // 숨겨야 하는 메뉴 id 5312를 배열로 선언합니다.
    $current_user = wp_get_current_user(); // 현재 로그인한 사용자의 정보를 가져옵니다.

    if (!in_array('editor', $current_user->roles) && !in_array('administrator', $current_user->roles)) {
        foreach ($items as $key => $item) { // 메뉴 아이템을 하나씩 순회합니다. in_array : 배열에 특정 값이 존재하는지 확인합니다.
            if (in_array($item->ID, $hidden_menu_item_ids)) { // 메뉴 아이템의 ID가 숨겨야 하는 메뉴 아이템 ID 목록에 포함되어 있다면
                unset($items[$key]); // 메뉴 아이템을 제거합니다. unset : 변수를 제거합니다.
            }
        }
    }

    return $items;
}
add_filter('wp_get_nav_menu_items', 'custom_menu_item_visibility', 10, 3);
// add filter : 특정 훅에 특정 함수를 등록하는 함수
// wp_get_nav_menu_items : 워드프레스에서 제공하는 훅 중 하나로, 메뉴를 가져오는 시점에 실행되는 함수

add_action( 'template_redirect', 'restrict_access_to_specific_users' );
//template_redirect : 워드프레스에서 제공하는 훅 중 하나로, 템플릿을 로드하는 시점에 실행되는 함수

function restrict_access_to_specific_users(){ //관리자와 에디터만 접근 가능한 페이지를 일반 사용자에게는 접근할 수 없게 함.
    global $post; //global : 전역변수를 사용하기 위한 키워드
    $slug = $post->post_name; //-> : 객체의 속성과 메소드에 접근하기 위한 연산자
    
    if($slug === 'manager' || $slug === 'manager-2' || $slug === 'manager-3'){
        if(!is_user_logged_in() || (!current_user_can('editor') && !current_user_can('administrator'))){
            wp_die('관리자만 접근할 수 있습니다. 3초 후 메인페이지로 이동합니다. <script>setTimeout(function(){window.location="'.home_url().'"}, 3000);</script>', 'Access denied', array(
                'response' => 403, // 403 : 접근 금지
                'back_link' => true, // true : 뒤로가기 링크를 표시합니다.
            )); //wp_die : 워드프레스에서 제공하는 함수로, 특정 메시지를 출력하고 페이지를 중단시킵니다.
            exit;
        }
    }
}