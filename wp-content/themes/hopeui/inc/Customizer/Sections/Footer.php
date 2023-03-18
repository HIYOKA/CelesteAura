<?php

namespace HopeUI\Utility\Customizer\Sections;

use HopeUI\Utility\Component_Customizer;
use HopeUI\Utility\Customizer\WP_Custom_Control\WP_DropDown_Select;
use HopeUI\Utility\Customizer\WP_Custom_Control\WP_Image_Radio_Button;
use HopeUI\Utility\Customizer\WP_Custom_Control\WP_Input_Text;
use HopeUI\Utility\Customizer\WP_Custom_Control\WP_Toggle_Button;

/**
 * HopeUI\Utility\Customizer\Sections\Footer class
 *
 * @package hopeui
 * @version 1.0.0
 */

class Footer extends Component_Customizer
{
    public function init()
    {
        $this->panel_name = 'footer';
        $this->panel_title = __('Footer', 'hopeui');
    }
    public function enqueue_style(): string
    {
        $inline_css = '';

        return $inline_css;
    }

    public function hopeui_php_register_control_setting($wp_customize)
    {
        $wp_customize->add_setting(
            'footer_option',
            array(
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_string')
            )
        );
        $wp_customize->add_setting(
            'footer_layout',
            array(
                'default' => '3',
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_number')
            )
        );
        $wp_customize->add_setting(
            'footer_one',
            array(
                'default' => '1',
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_number')
            )
        );
        $wp_customize->add_setting(
            'footer_two',
            array(
                'default' => '1',
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_number')
            )
        );
        $wp_customize->add_setting(
            'footer_three',
            array(
                'default' => '1',
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_number')
            )
        );
        $wp_customize->add_setting(
            'footer_four',
            array(
                'default' => '1',
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_number')
            )
        );
        $wp_customize->add_setting(
            'footer_copyright',
            array(
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_string')
            )
        );
        $wp_customize->add_setting(
            'display_footer_copyright',
            array(
                'default' => true,
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_string')
            )
        );
        $wp_customize->add_setting(
            'footer_copyright_alignment',
            array(
                'default' => 'center',
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_string')
            )
        );
        $wp_customize->add_setting(
            'footer_copyright_text',
            array(
                'default' =>  esc_html__('Copyright © 2022 - WordPress Theme by HopeUI', 'hopeui'),
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_string')
            )
        );
    }

    public function hopeui_php_register_control($wp_customize)
    {
        // Panel And  Section


        $wp_customize->add_panel($this->panel_name, array(
            'priority'       => 1,
            'title'          => $this->panel_title,
            'capability'     => 'edit_theme_options'
        ));
        $wp_customize->add_section(
            'footer_option',
            array(
                'title'       => __('Footer Options', 'hopeui'),
                'capability'  => 'edit_theme_options',
                'panel'  => $this->panel_name
            )
        );

        $wp_customize->add_control(new WP_Image_Radio_Button(
            $wp_customize,
            'footer_layout',
            array(
                'label' => __('Footer Layout Structures', 'hopeui'),
                'section' =>  'footer_option',
                'choices' => array(
                    '1' => array(
                        'label' => 'Footer Layout 1',
                        'url' =>  '/assets/images/redux/footer_first.png',
                    ),
                    '2' => array(
                        'label' => 'Footer Layout 2',
                        'url' =>  '/assets/images/redux/footer_second.png',
                    ),
                    '3' => array(
                        'label' => 'Footer Layout 3',
                        'url' =>  '/assets/images/redux/footer_third.png',
                    ),
                    '4' => array(
                        'label' => 'Footer Layout 4',
                        'url' =>  '/assets/images/redux/footer_four.png',
                    ),
                ),
            )
        ));
        $wp_customize->add_control(new WP_DropDown_Select(
            $wp_customize,
            'footer_one',
            array(
                'section' =>  'footer_option',
                'label' => __('Select alignment for footer 1', 'hopeui'),
                'choices' => array(
                    '1' => __('Left', 'hopeui'),
                    '2' => __('Right', 'hopeui'),
                    '3' => __('Center', 'hopeui'),
                ),
            )
        ));
        $wp_customize->add_control(new WP_DropDown_Select(
            $wp_customize,
            'footer_two',
            array(
                'section' =>  'footer_option',
                'label' => __('Select alignment for footer 2', 'hopeui'),
                'choices' => array(
                    '1' => __('Left', 'hopeui'),
                    '2' => __('Right', 'hopeui'),
                    '3' => __('Center', 'hopeui'),
                ),
            )
        ));
        $wp_customize->add_control(new WP_DropDown_Select(
            $wp_customize,
            'footer_three',
            array(
                'section' =>  'footer_option',
                'label' => __('Select alignment for footer 3', 'hopeui'),
                'choices' => array(
                    '1' => __('Left', 'hopeui'),
                    '2' => __('Right', 'hopeui'),
                    '3' => __('Center', 'hopeui'),
                ),
            )
        ));
        $wp_customize->add_control(new WP_DropDown_Select(
            $wp_customize,
            'footer_four',
            array(
                'section' =>  'footer_option',
                'label' => __('Select alignment for footer 4', 'hopeui'),
                'choices' => array(
                    '1' => __('Left', 'hopeui'),
                    '2' => __('Right', 'hopeui'),
                    '3' => __('Center', 'hopeui'),
                ),
            )
        ));
        $wp_customize->add_section(
            'footer_copyright',
            array(
                'title'       => __('Footer CopyRight', 'hopeui'),
                'capability'  => 'edit_theme_options',
                'panel'  => $this->panel_name
            )
        );
        $wp_customize->add_control(new WP_Toggle_Button(
            $wp_customize,
            'display_footer_copyright',
            array(
                'label' => esc_html__('Display Copyrights', 'hopeui'),
                'section' =>  'footer_copyright',
            )
        ));

        $wp_customize->add_control(new WP_DropDown_Select(
            $wp_customize,
            'footer_copyright_alignment',
            array(
                'section' =>  'footer_copyright',
                'label' => __('Copyrights Text Alignment', 'hopeui'),
                'choices' => array(
                    'start' => __('Left', 'hopeui'),
                    'center' => __('Center', 'hopeui'),
                    'end' => __('Right', 'hopeui'),
                ),
            )
        ));
        $wp_customize->add_control('footer_copyright_text', array(
            'type' => 'textarea',
            'section' => 'footer_copyright',
            'label' =>  __('Copyrights Text', 'hopeui'),
        ));
    }
}
