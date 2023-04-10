<?php

namespace HopeUI\Utility\Customizer\Sections;

use HopeUI\Utility\Component_Customizer;
use HopeUI\Utility\Customizer\WP_Custom_Control\WP_Customize_Color_Control;
use HopeUI\Utility\Customizer\WP_Custom_Control\WP_DropDown_Select;
use HopeUI\Utility\Customizer\WP_Custom_Control\WP_Customize_Image_Control;
use HopeUI\Utility\Customizer\WP_Custom_Control\WP_Image_Radio_Button;
use HopeUI\Utility\Customizer\WP_Custom_Control\WP_Section_Tabs;
use HopeUI\Utility\Customizer\WP_Custom_Control\WP_Text_Radio_Button;
use HopeUI\Utility\Customizer\WP_Custom_Control\WP_Toggle_Button;

/**
 * HopeUI\Utility\Customizer\Sections\Breadcrumb class
 *
 * @package hopeui
 * @version 1.0.0
 */

class Breadcrumb extends Component_Customizer
{
    public function init()
    {
        $this->panel_title = __('Breadcrumb', 'hopeui');
        $this->panel_name = 'breadcrumb';
    }

    public function enqueue_style(): string
    {
        $inline_style = '';
        $breadcrumb_bg_image = get_theme_mod('breadcrumb_bg_image', 'transparent');
        $breadcrumb_bg_image = $breadcrumb_bg_image == 'transparent' ? 'transparent' : 'url(' . $breadcrumb_bg_image . ');';
        $breadcrumb_colors_arr = [
            [
                'selector' => '.hopeui_style-breadcrumb .title',
                'property' => 'color',
                'value' => get_theme_mod('breadcrumb_title_color')
            ],
            get_theme_mod('breadcrumb_bg_type') == 'color' ?
                [
                    'selector' => '.hopeui_style-breadcrumb ',
                    'property' => 'background-color',
                    'value' => get_theme_mod('breadcrumb_bg_color', '#fff')
                ] :
                [
                    'selector' => '.hopeui_style-breadcrumb ',
                    'property' => 'background-image',
                    'value' =>  $breadcrumb_bg_image
                ],
        ];
        foreach ($breadcrumb_colors_arr as $control) {
            if (!empty($control['value'])) {
                $inline_style .= $control['selector'] . '{' . $control['property'] . ':' . $control['value'] . '}';
            }
        }
        return $inline_style;
    }

    public function hopeui_php_register_control_setting($wp_customize)
    {
        // Colors Settings
        $wp_customize->add_setting(
            'breadcrumb_style',
            array(
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_number')
            )
        );
        $wp_customize->add_setting(
            'breadcrumb_section_tabs',
            array(
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'postMessage',
                'default' => 'general',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_string')
            )
        );
        $wp_customize->add_setting(
            'display_breadcrumb',
            array(
                'default' => true,
                'transport'  => 'refresh',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_bool')
            )
        );
        $wp_customize->add_setting(
            'display_breadcrumb_title',
            array(
                'default' => true,
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_bool')
            )
        );
        $wp_customize->add_setting(
            'breadcrumb_title_tag',
            array(
                'default' => 'h2',
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_bool')
            )
        );
        $wp_customize->add_setting(
            'display_breadcrumb_nav',
            array(
                'default' => true,
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_bool')
            )
        );
        $wp_customize->add_setting(
            'breadcrumb_title_color',
            array(
                'default' => '#000',
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'postMessage',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_hex_color')
            )
        );
        $wp_customize->add_setting(
            'breadcrumb_bg_type',
            array(
                'default' => 'color',
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_string')
            )
        );
        $wp_customize->add_setting(
            'breadcrumb_bg_color',
            array(
                'default' => '#000',
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'postMessage',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_hex_color')
            )
        );
        $wp_customize->add_setting(
            'breadcrumb_bg_image',
            array(
                'transport'  => 'postMessage',
                'default' => 'transparent',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_url')

            )
        );
    }
    public function hopeui_php_register_control($wp_customize)
    {
        $wp_customize->add_section(
            $this->panel_name,
            array(
                'title'       => $this->panel_title,
                'capability'  => 'edit_theme_options',
                'priority'  => 2
            )
        );

        $wp_customize->add_control(
            new WP_Section_Tabs(
                $wp_customize,
                'breadcrumb_section_tabs',
                array(
                    'section' => $this->panel_name,
                    'tabs' => array(
                        'general' => __('Generals', 'hopeui'),
                        'style' => __('Style', 'hopeui'),
                    ),
                    'default' => 'general'
                )
            )
        );


        $wp_customize->add_control(new WP_Image_Radio_Button(
            $wp_customize,
            'breadcrumb_style',
            array(
                'label' => __('Breadcrumb Style', 'hopeui'),
                'section' => $this->panel_name,
                'choices' => array(
                    '1' => array('url' =>  "/assets/images/redux/bg-1.jpg"),
                    '2' => array('url' => "/assets/images/redux/bg-2.jpg"),
                    '3' => array('url' => "/assets/images/redux/bg-3.jpg"),
                    '4' => array('url' => "/assets/images/redux/bg-4.jpg"),
                    '5' => array('url' => "/assets/images/redux/bg-5.jpg"),
                ),
                'tab' => 'style'
            )
        ));

        $wp_customize->add_control(new WP_Toggle_Button(
            $wp_customize,
            'display_breadcrumb',
            array(
                'label' => __('Display breadcrumb?', 'hopeui'),
                'section' =>  $this->panel_name,
                'tab' => 'general',
            )
        ));
        $wp_customize->add_control(new WP_Toggle_Button(
            $wp_customize,
            'display_breadcrumb_title',
            array(
                'label' => __('Display title on breadcrumb?', 'hopeui'),
                'section' =>  $this->panel_name,
                'tab' => 'general',
                'condition' => ['display_breadcrumb' => true]
            )
        ));
        $wp_customize->add_control(new WP_Toggle_Button(
            $wp_customize,
            'display_breadcrumb_nav',
            array(
                'label' => __('Display navigation on breadcrumb?', 'hopeui'),
                'section' =>  $this->panel_name,
                'tab' => 'general',
                'condition' => ['display_breadcrumb' => true]
            )
        ));

        $wp_customize->add_control(new WP_DropDown_Select(
            $wp_customize,
            'breadcrumb_title_tag',
            array(
                'section' =>  $this->panel_name,
                'label' => __('Select Title tag', 'hopeui'),
                'choices' => array(
                    'h1' => __('H1', 'hopeui'),
                    'h2' => __('H2', 'hopeui'),
                    'h3' => __('H3', 'hopeui'),
                    'h4' => __('H4', 'hopeui'),
                    'h5' => __('H5', 'hopeui'),
                    'h6' => __('H6', 'hopeui'),
                ),
                'tab' => 'general',
                'condition' => ['display_breadcrumb_title' => true, 'display_breadcrumb' => true]
            )
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control(
            $wp_customize,
            'breadcrumb_title_color',
            array(
                'section' =>  $this->panel_name,
                'label' => __('Breadcrumb Set Title Color', 'hopeui'),
                'tab' => 'style',
            )
        ));
        $wp_customize->add_control(new WP_Text_Radio_Button(
            $wp_customize,
            'breadcrumb_bg_type',
            array(
                'section' =>  $this->panel_name,
                'label' => __('Breadcrumb Background Type', 'hopeui'),
                'tab' => 'style',
                'choices' => array(
                    'color' => __('Color', 'hopeui'),
                    'img' => __('Image', 'hopeui'),
                ),
            )
        ));

        $wp_customize->add_control(new WP_Customize_Image_Control(
            $wp_customize,
            'breadcrumb_bg_image',
            array(
                'section' =>  $this->panel_name,
                'label' => __('Set Breadcrumb Background Image', 'hopeui'),
                'mime_type' => 'image',
                'tab' => 'style',
                'condition' => ['breadcrumb_bg_type' => 'img'],
            )
        ));



        $wp_customize->add_control(new WP_Customize_Color_Control(
            $wp_customize,
            'breadcrumb_bg_color',
            array(
                'section' =>  $this->panel_name,
                'label' => __('Breadcrumb Set Background Color', 'hopeui'),
                'condition' => ['breadcrumb_bg_type' => 'color'],
                'tab' => 'style',
            )
        ));
    }
    public function hopeui_php_register_partial($wp_customize)
    {
        $wp_customize->selective_refresh->add_partial('breadcrumb', array(
            'selector' => '.hopeui_style-breadcrumb,.hopeui_style-breadcrumb .hopeui_style-breadcrumb-nav',
            'settings' => array('breadcrumb_style'),
        ));
    }
}
