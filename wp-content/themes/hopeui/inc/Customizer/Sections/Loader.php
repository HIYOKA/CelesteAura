<?php

namespace HopeUI\Utility\Customizer\Sections;

use PHP_CodeSniffer\Tokenizers\PHP;
use HopeUI\Utility\Component_Customizer;
use HopeUI\Utility\Customizer\WP_Custom_Control\WP_Customize_Color_Control;
use HopeUI\Utility\Customizer\WP_Custom_Control\WP_Customize_Image_Control;
use HopeUI\Utility\Customizer\WP_Custom_Control\WP_Toggle_Button;
use HopeUI\Utility\Customizer\WP_Custom_Control\WP_Twodimensional_Input;

/**
 * HopeUI\Utility\Customizer\Sections\Loader class
 *
 * @package hopeui
 * @version 1.0.0
 */

class Loader extends Component_Customizer
{
    public function init()
    {
        $this->panel_name = 'loader';
        $this->panel_title = __('Loader', 'hopeui');
    }
    public function enqueue_style(): string
    {
        $inline_css = '';
        if (get_theme_mod('hopeui_php_show_loader', false)) {
            ob_start();
            ?>
            #loading{
            background-color: <?php echo esc_attr(get_theme_mod('hopeui_php_loader_bg_color', '#000')) ?>
            }
            <?php
            $hopeui_php_loader_size = get_theme_mod('hopeui_php_loader_size');
            if (isset($hopeui_php_loader_size) && !empty($hopeui_php_loader_size)) {
                $loader_img_side = json_decode($hopeui_php_loader_size);
            ?>
                #loading img{
                width: <?php echo esc_html($loader_img_side->width) . esc_html($loader_img_side->unit) ?>;
                height: <?php echo esc_html($loader_img_side->height) . esc_html($loader_img_side->unit) ?>;
                }

            <?php
            }

            $inline_css .= ob_get_clean();
        }
        return $inline_css;
    }


    public function hopeui_php_register_control_setting($wp_customize)
    {
        $wp_customize->add_setting(
            'loader',
            array(
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_string')
            )
        );
        $wp_customize->add_setting(
            'hopeui_php_show_loader',
            array(
                'default' => false,
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'postMessage',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_bool')
            )
        );
        $wp_customize->add_setting(
            'hopeui_php_loader_bg_color',
            array(
                'default' => '#000',
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'postMessage',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_hex_color')
            )
        );
        $wp_customize->add_setting(
            'hopeui_php_loader_img',
            array(
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_url')
            )
        );
        $wp_customize->add_setting(
            'hopeui_php_loader_size',
            array(
                'default' => array(700, 600, 'px'),
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'postMessage',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_multidimensional_input')
            )
        );
    }

    public function hopeui_php_register_control($wp_customize)
    {
        // Panel And  Section
        $wp_customize->add_section(
            $this->panel_name,
            array(
                'title'       => $this->panel_title,
                'capability'  => 'edit_theme_options',
                'priority'  => 2
            )
        );

        $wp_customize->add_control(new WP_Toggle_Button(
            $wp_customize,
            'hopeui_php_show_loader',
            array(
                'label' => __('Show Loader?', 'hopeui'),
                'section' =>  $this->panel_name,
                'description' => esc_html__('Turn on to show the icon/images loading animation while your site loads', 'hopeui'),
            )
        ));

        $wp_customize->add_control(new WP_Customize_Color_Control(
            $wp_customize,
            'hopeui_php_loader_bg_color',
            array(
                'section' => $this->panel_name,
                'label' => __('Loader Background Color', 'hopeui'),
                'condition' => array('hopeui_php_show_loader' => true),
            )
        ));
        $wp_customize->add_control(new WP_Customize_Image_Control(
            $wp_customize,
            'hopeui_php_loader_img',
            array(
                'section' => $this->panel_name,
                'label' => __('Select Loader Image', 'hopeui'),
                'condition' => array('hopeui_php_show_loader' => true),
            )
        ));
        $wp_customize->add_control(new WP_Twodimensional_Input(
            $wp_customize,
            'hopeui_php_loader_size',
            array(
                'section' => $this->panel_name,
                'label' => __('Select Loader Size', 'hopeui'),
                'unit' => array(
                    'px' => __('PX', 'hopeui'),
                    '%' => __('%', 'hopeui'),
                    'em' => __('EM', 'hopeui'),
                    'rem' => __('REM', 'hopeui'),
                ),
                'condition' => array('hopeui_php_show_loader' => true),
            )
        ));
    }
}
