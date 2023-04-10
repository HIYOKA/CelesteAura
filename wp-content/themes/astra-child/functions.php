<?php
add_action('rest_api_init', function () {
  register_rest_route('custom-db/v1', '/data', [
    'methods' => 'GET',
    'callback' => 'get_custom_data',
  ]);

  register_rest_route('custom-db/v1', '/data', [
    'methods' => 'POST',
    'callback' => 'add_custom_data',
  ]);
});

function get_custom_data() {
  global $wpdb;
  $data = $wpdb->get_results("SELECT * FROM wp_custom_data");
  return $data;
}

function add_custom_data(WP_REST_Request $request) {
  global $wpdb;
  $name = $request->get_param('name');
  $value = $request->get_param('value');
  $wpdb->insert('wp_custom_data', ['name' => $name, 'value' => $value]);
  return ['success' => true];
}