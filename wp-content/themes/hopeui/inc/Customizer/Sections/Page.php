<?php

namespace HopeUI\Utility\Customizer\Sections;

use HopeUI\Utility\Component_Customizer;
use HopeUI\Utility\Customizer\WP_Custom_Control\WP_Customize_Cropped_Image_Control;
use HopeUI\Utility\Customizer\WP_Custom_Control\WP_Image_Radio_Button;
use HopeUI\Utility\Customizer\WP_Custom_Control\WP_Toggle_Button;

/**
 * HopeUI\Utility\Customizer\Sections\Page class
 *
 * @package hopeui
 * @version 1.0.0
 */

class Page extends Component_Customizer
{
    public function init()
    {
        $this->panel_name = 'page_settings';
        $this->panel_title = __('Page Settings', 'hopeui');
    }
    public function enqueue_style(): string
    {
        $inline_css = '';

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
            'search_sidebar_setting',
            array(
                'default' => '3',
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_number')
            )
        );
        $wp_customize->add_setting(
            'hopeui_php_mobile_logo',
            array(
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_url')
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

        $wp_customize->add_control(new WP_Image_Radio_Button(
            $wp_customize,
            'search_sidebar_setting',
            array(
                'label' => __('Search Page Setting', 'hopeui'),
                'section' =>  $this->panel_name,
                'choices' => array(
                    '1' => array(
                        'label' => 'Left Sidebar',
                        'url' =>  '/assets/images/redux//left-side.jpg',
                    ),
                    '2' => array(
                        'label' => 'Full Width',
                        'url' =>  '/assets/images/redux//single-column.jpg',
                    ),
                    '3' => array(
                        'label' => 'Right Sidebar',
                        'url' =>  '/assets/images/redux//right-side.jpg',
                    ),
                ),
                'display_inline' => true
            )
        ));


        $wp_customize->add_control(new WP_Customize_Cropped_Image_Control(
            $wp_customize,
            'custom_logo',
            array(
                'label' => __('Logo', 'hopeui'),
                'section' => 'title_tagline',
                'priority' => 0,
            )
        ));
        $wp_customize->add_control(new WP_Customize_Cropped_Image_Control(
            $wp_customize,
            'hopeui_php_mobile_logo',
            array(
                'label' => __('Mobile Logo', 'hopeui'),
                'section' => 'title_tagline',
                'priority' => 0,
            )
        ));
    }
}
