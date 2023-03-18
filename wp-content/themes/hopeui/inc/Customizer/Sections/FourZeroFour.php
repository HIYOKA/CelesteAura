<?php

namespace HopeUI\Utility\Customizer\Sections;

use HopeUI\Utility\Component_Customizer;
use HopeUI\Utility\Customizer\WP_Custom_Control\WP_Customize_Image_Control;
use HopeUI\Utility\Customizer\WP_Custom_Control\WP_Image_Radio_Button;
use HopeUI\Utility\Customizer\WP_Custom_Control\WP_Input_Text;
use HopeUI\Utility\Customizer\WP_Custom_Control\WP_Toggle_Button;

/**
 * HopeUI\Utility\Customizer\Sections\FourZeroFour class
 *
 * @package hopeui
 * @version 1.0.0
 */

class FourZeroFour extends Component_Customizer
{
    public function init()
    {
        $this->panel_name = 'fourzerofour';
        $this->panel_title = __('404', 'hopeui');
    }
    public function enqueue_style(): string
    {
        $inline_css = '';
        if (is_404()) {
            if (!get_theme_mod('header_on_404')) {
                ob_start();
                ?>header{
                display:none;
                }<?php
                $inline_css .= ob_get_clean();
            }
            if (!get_theme_mod('footer_on_404')) {
                ob_start();
                ?>footer{
                display:none;
                }<?php
                $inline_css .= ob_get_clean();
            }
        }

        return $inline_css;
    }

    public function hopeui_php_register_control_setting($wp_customize)
    {
        $wp_customize->add_setting(
            $this->panel_name,
            array(
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_string')
            )
        );
        $wp_customize->add_setting(
            '404_banner_image',
            array(
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_url')
            )
        );
        $wp_customize->add_setting(
            '404_title',
            array(
                'default' => esc_html__('Oops! This Page is Not Found.', 'hopeui'),
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_string')
            )
        );
        $wp_customize->add_setting(
            '404_backtohome_title',
            array(
                'default' => esc_html__('Back to Home', 'hopeui'),
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_string')
            )
        );
        $wp_customize->add_setting(
            '404_description',
            array(
                'default' => esc_html__('The requested page does not exist.', 'hopeui'),
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_string')
            )
        );
        $wp_customize->add_setting(
            'header_on_404',
            array(
                'default' => true,
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_bool')
            )
        );
        $wp_customize->add_setting(
            'footer_on_404',
            array(
                'default' => true,
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_bool')
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
        $wp_customize->add_control(new WP_Customize_Image_Control(
            $wp_customize,
            '404_banner_image',
            array(
                'section' =>  $this->panel_name,
                'label' => __('404 Background Image', 'hopeui'),
            )
        ));
        $wp_customize->add_control(new WP_Input_Text(
            $wp_customize,
            '404_title',
            array(
                'label' => __('404 Page Title', 'hopeui'),
                'section' =>  $this->panel_name,
            )
        ));

        $wp_customize->add_control('404_description', array(
            'type' => 'textarea',
            'section' => $this->panel_name,
            'label' => esc_html__('Description', 'hopeui'),
        ));
        $wp_customize->add_control(new WP_Input_Text(
            $wp_customize,
            '404_backtohome_title',
            array(
                'label' => esc_html__('Button Label', 'hopeui'),
                'section' =>  $this->panel_name,
            )
        ));
        $wp_customize->add_control(new WP_Toggle_Button(
            $wp_customize,
            'header_on_404',
            array(
                'label' => __('Display Header on 404 page?', 'hopeui'),
                'section' =>  $this->panel_name,
            )
        ));
        $wp_customize->add_control(new WP_Toggle_Button(
            $wp_customize,
            'footer_on_404',
            array(
                'label' => __('Display Footer on 404 page?', 'hopeui'),
                'section' =>  $this->panel_name,
            )
        ));
    }
}
