<?php

/**
 * HopeUI\Utility\Meta_Box\Component class
 *
 * @package hopeui
 */

namespace HopeUI\Utility\Meta_Box;

use HopeUI\Utility\Component_Interface;
use function add_action;
use function add_theme_support;
use function apply_filters;

/**
 * Class for adding custom logo support.
 *
 * @link https://codex.wordpress.org/Theme_Logo
 */
class Component implements Component_Interface
{

    /**
     * Gets the unique identifier for the theme component.
     *
     * @return string Component slug.
     */
    public function get_slug(): string
    {
        return 'meta_box';
    }

    /**
     * Adds the action and filter hooks to integrate with WordPress.
     */
    public function initialize()
    {
        add_action('enqueue_block_editor_assets', array($this, 'hopeui_php_enqueue_block_editor_assets'));
        add_action('init', array($this, 'hopeui_php_register_postmeta'));
    }
    public function hopeui_php_enqueue_block_editor_assets()
    {
        $hopeui_php_meta_uri = get_template_directory_uri() . '/inc/Meta_Box/static';
        $hopeui_php_meta_dir = get_template_directory() . '/inc/Meta_Box/static';
        $asset_file = include($hopeui_php_meta_dir . '/index.asset.php');
        wp_enqueue_script(
            'hopeui-editor-script',
            $hopeui_php_meta_uri  . '/index.js',
            $asset_file['dependencies'],
            $asset_file['version']
        );
        wp_enqueue_style(
            'hopeui-editor-style',
            $hopeui_php_meta_uri  . '/index.css',
        );
    }
    public function hopeui_php_register_postmeta()
    {
        register_post_meta('page', 'page_structure', [
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
            'default' => 'default'
        ]);
        register_post_meta('page', 'page_banner', [
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
            'default' => 'inherit'
        ]);
        register_post_meta('page', 'page_container_source', [
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
            'default' => 'inherit'
        ]);
        register_post_meta('page', 'page_container', [
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
            'default' => 'container'
        ]);
        register_post_meta('page', 'hopeui_php_page_bg_color', [
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
            'default' => 'false'
        ]);
    }
}
