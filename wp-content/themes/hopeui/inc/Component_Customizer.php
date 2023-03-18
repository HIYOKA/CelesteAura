<?php

/**
 * HopeUI\Utility\WP_Customizer interface
 *
 * @package hopeui
 */

namespace HopeUI\Utility;


/**
 * Interface for a theme component.
 */
abstract class Component_Customizer
{
    /** 
     * @var String $panel_name Panel Name
     */
    private $panel_name;

    /** 
     * @var String $panel_title Display Panel Title 
     */
    public $panel_title;


    public function __construct()
    {
        add_action('customize_register', array($this, 'hopeui_php_register_control_setting'), 10);
        add_action('customize_register', array($this, 'hopeui_php_register_control'), 11);
        add_action('customize_register', array($this, 'hopeui_php_register_partial'), 12);
        add_action('wp_enqueue_scripts', function () {


            // var_dump(get_option('hopeui-'))

            wp_register_style('hopeui-global', false);
            wp_enqueue_style('hopeui-global');
            wp_add_inline_style('hopeui-global', $this->enqueue_style());

            wp_register_script('hopeui-global', '');
            wp_enqueue_script('hopeui-global');
            wp_add_inline_script('hopeui-global', $this->enqueue_scripts());
        }, 99);

        $this->init();
    }
    public function init()
    {
    }

    public function enqueue_scripts(): String
    {
        return "";
    }
    public function enqueue_style(): String
    {
        return "";
    }

    public function hopeui_php_header_output()
    {
    }

    public function hopeui_php_register_control_setting($wp_customize)
    {
    }

    public function hopeui_php_register_control($wp_customize)
    {
    }
    public function hopeui_php_register_partial($wp_customize)
    {
    }
    public function hopeui_php_enqueue_style($theme_mod, $handler = 'hopeui-global')
    {
        $global_font = $theme_mod;
        if (gettype($theme_mod) == 'string') {
            $global_font = json_decode(get_theme_mod('hopeui_php_typography'));
        }
        if (isset($global_font->font) && !empty($global_font->font)) {
            wp_enqueue_style($handler, 'https://fonts.googleapis.com/css?family=' . $global_font->font . ':' . $global_font->boldweight . $global_font->regularweight, false);
        }
    }
    public function hopeui_php_sanitize_typography($val)
    {
        $val = json_decode($val);
        $arr =  array(
            'font' => filter_var($val->font, FILTER_SANITIZE_STRING),
            'regularweight' => filter_var($val->regularweight, FILTER_SANITIZE_STRING),
            'boldweight' => filter_var($val->boldweight, FILTER_SANITIZE_STRING),
            'size' => filter_var($val->size, FILTER_SANITIZE_STRING),
            'category' => filter_var($val->category, FILTER_SANITIZE_STRING),
        );
        return json_encode($arr);
    }
    public function hopeui_php_sanitize_string($val)
    {
        return filter_var($val, FILTER_SANITIZE_STRING);
    }
    public function hopeui_php_sanitize_bool($val)
    {
        return filter_var($val, FILTER_SANITIZE_STRING);
    }
    public function hopeui_php_sanitize_hex_color($val)
    {
        return sanitize_text_field($val);
    }
    public function hopeui_php_sanitize_number($val)
    {
        return filter_var($val, FILTER_SANITIZE_NUMBER_INT);
    }
    public function hopeui_php_sanitize_url($val)
    {
        return esc_url_raw($val);
    }
    public function hopeui_php_sanitize_multidimensional_input($val)
    {
        $new_arra = array();
        $val = json_decode($val);
        $new_arra['height'] = isset($val->height) ? $this->hopeui_php_sanitize_number($val->height) : 'auto';
        $new_arra['width'] = isset($val->width) ? $this->hopeui_php_sanitize_number($val->width) : 'auto';
        $new_arra['unit'] = isset($val->unit) ? $this->hopeui_php_sanitize_string($val->unit) : 'px';
        return json_encode($new_arra);
    }
}
