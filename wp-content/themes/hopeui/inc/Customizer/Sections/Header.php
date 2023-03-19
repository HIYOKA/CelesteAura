<?php


namespace HopeUI\Utility\Customizer\Sections;

use HopeUI\Utility\Component_Customizer;
use HopeUI\Utility\Customizer\WP_Custom_Control\WP_Customize_Color_Control;
use HopeUI\Utility\Customizer\WP_Custom_Control\WP_Customize_Cropped_Image_Control;
use HopeUI\Utility\Customizer\WP_Custom_Control\WP_Customize_Image_Control;
use HopeUI\Utility\Customizer\WP_Custom_Control\WP_Customize_Upload_Control;
use HopeUI\Utility\Customizer\WP_Custom_Control\WP_Input_Text;
use HopeUI\Utility\Customizer\WP_Custom_Control\WP_Section_Tabs;
use HopeUI\Utility\Customizer\WP_Custom_Control\WP_Text_Radio_Button;
use HopeUI\Utility\Customizer\WP_Custom_Control\WP_Toggle_Button;

/**
 * HopeUI\Utility\Customizer\Sections\Header class
 *
 * @package hopeui
 * @version 1.0.0
 */

class Header extends Component_Customizer
{
    public function init()
    {
        $this->panel_name = 'header';
        $this->panel_title = __('Header', 'hopeui');
        add_filter('body_class', array($this, 'hopeui_php_add_body_classes'));
    }
    public function enqueue_style(): string
    {
        $inline_css = '';
        switch (get_theme_mod('header_background_type', 'default')) {
            case 'color':
                $inline_css .= 'header#default-header{
                background-color : ' . get_theme_mod('header_background_color') . ' !important;
                            }';
                break;

            case 'img':
                $inline_css .= 'header#default-header{
                background-image : url(' . get_theme_mod('header_background_img') . ');
                    }';
                break;

            case 'transparent':
                $inline_css .= 'header#default-header{
                background :transparent !important';
                break;
            default:

                break;
        }
        return $inline_css;
    }


    public function hopeui_php_register_control_setting($wp_customize)
    {
        $wp_customize->add_setting(
            'header_layout',
            array(
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_string')
            )
        );
        $wp_customize->add_setting(
            'header_container',
            array(
                'default' => 'container-fluid',
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'postMessage',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_string')
            )
        );
        $wp_customize->add_setting(
            'header_section_tabs',
            array(
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'postMessage',
                'default' => 'general',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_string')
            )
        );
        $wp_customize->add_setting(
            'header_postion',
            array(
                'default' => 'static',
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'postMessage',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_string')
            )
        );
        $wp_customize->add_setting(
            'display_search',
            array(
                'default' => true,
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'postMessage',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_bool')
            )
        );
            $wp_customize->add_setting(
                'hopeui_php_display_cart',
                array(
                    'default' => true,
                    'type'       => 'theme_mod',
                    'capability' => 'edit_theme_options',
                    'transport'  => 'refresh',
                    'sanitize_callback' => array($this, 'hopeui_php_sanitize_bool')
                )
            );
        
        $wp_customize->add_setting(
            'hopeui_php_search_placeholder',
            array(
                'default' => __('Search', 'hopeui'),
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'postMessage',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_bool')
            )
        );
        $wp_customize->add_setting(
            'header_background_type',
            array(
                'default' => 'default',
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'postMessage',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_bool')
            )
        );
        $wp_customize->add_setting(
            'header_background_color',
            array(
                'default' => '#000',
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'postMessage',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_hex_color')
            )
        );
        $wp_customize->add_setting(
            'header_background_img',
            array(
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'postMessage',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_url')
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
            'header_layout',
            array(
                'title'       => __('Header Layout', 'hopeui'),
                'capability'  => 'edit_theme_options',
                'panel'          => $this->panel_name,
            )
        );

        $wp_customize->add_control(
            new WP_Section_Tabs(
                $wp_customize,
                'header_section_tabs',
                array(
                    'section' => 'header_layout',
                    'tabs' => array(
                        'general' => __('Generals', 'hopeui'),
                        'style' => __('Style', 'hopeui'),
                    ),
                    'default' => 'general'
                )
            )
        );

        $wp_customize->add_control(new WP_Text_Radio_Button(
            $wp_customize,
            'header_container',
            array(
                'label' => __('Header Container', 'hopeui'),
                'section' => 'header_layout',
                'choices' => array(
                    'container-fluid'     => esc_html__('Full width', 'hopeui'),
                    'container'         => esc_html__('Container', 'hopeui'),
                ),
                'tab' => 'general'
            )
        ));
        $wp_customize->add_control(new WP_Text_Radio_Button(
            $wp_customize,
            'header_postion',
            array(
                'label' => __('Header Position', 'hopeui'),
                'section' => 'header_layout',
                'choices' => array(
                    'static' => esc_html__('Default', 'hopeui'),
                    'over' => esc_html__('Over', 'hopeui'),
                ),
                'tab' => 'general'
            )
        ));
        $wp_customize->add_control(new WP_Toggle_Button(
            $wp_customize,
            'display_search',
            array(
                'label' => __('Display Search Icon?', 'hopeui'),
                'section' =>  'header_layout',
                'tab' => 'general',
            )
        ));
        if(class_exists( 'woocommerce' )){
            $wp_customize->add_control(new WP_Toggle_Button(
                $wp_customize,
                'hopeui_php_display_cart',
                array(
                    'label' => __('Display Mini Cart Icon?', 'hopeui'),
                    'section' =>  'header_layout',
                    'tab' => 'general',
                )
            ));
        }
        $wp_customize->add_control(new WP_Input_Text(
            $wp_customize,
            'hopeui_php_search_placeholder',
            array(
                'label' => __('Enter Search label', 'hopeui'),
                'section' =>  'header_layout',
                'tab' => 'general',
                'condition' => array('display_search' => true)
            )
        ));
        $wp_customize->add_control(new WP_Text_Radio_Button(
            $wp_customize,
            'header_background_type',
            array(
                'label' => __('Background', 'hopeui'),
                'section' => 'header_layout',
                'choices' => array(
                    'default' => esc_html__('Default', 'hopeui'),
                    'color' => esc_html__('Color', 'hopeui'),
                    'img' => esc_html__('Image', 'hopeui'),
                    'transparent' => esc_html__('Transparent', 'hopeui'),
                ),
                'tab' => 'style'
            )
        ));


        $wp_customize->add_control(new WP_Customize_Color_Control(
            $wp_customize,
            'header_background_color',
            array(
                'section' => 'header_layout', // Add a default or your own section
                'label' => __('Header BackGround Color','hopeui'),
                'condition' => array('header_background_type' => 'color'),
                'tab' => 'style'
            )
        ));

        $wp_customize->add_control(new WP_Customize_Image_Control(
            $wp_customize,
            'header_background_img',
            array(
                'section' =>  'header_layout',
                'label' => __('Set Header Background Image', 'hopeui'),
                'condition' => ['header_background_type' => 'img'],
                'settings'=> 'header_background_img',
                'tab' => 'style',
            )
        ));

        $wp_customize->remove_control('header_image');
      
    }

    public function hopeui_php_add_body_classes($classes)
    {
        $classes[] = 'hopeui_style-header-' . get_theme_mod('header_postion', 'static');
        return $classes;
    }
}
