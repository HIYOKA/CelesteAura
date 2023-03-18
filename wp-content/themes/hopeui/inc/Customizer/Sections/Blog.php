<?php

namespace HopeUI\Utility\Customizer\Sections;

use HopeUI\Utility\Component_Customizer;
use HopeUI\Utility\Customizer\WP_Custom_Control\WP_Customize_Color_Control;
use HopeUI\Utility\Customizer\WP_Custom_Control\WP_Customize_Image_Control;
use HopeUI\Utility\Customizer\WP_Custom_Control\WP_DropDown_Select;
use HopeUI\Utility\Customizer\WP_Custom_Control\WP_Image_Radio_Button;
use HopeUI\Utility\Customizer\WP_Custom_Control\WP_Toggle_Button;
use HopeUI\Utility\Customizer\WP_Custom_Control\WP_Twodimensional_Input;

/**
 * HopeUI\Utility\Customizer\Sections\Blog class
 *
 * @package hopeui
 * @version 1.0.0
 */

class Blog extends Component_Customizer
{
    public function init()
    {
        $this->panel_name = 'blog';
        $this->panel_title = __('Blog', 'hopeui');
    }
    public function enqueue_style(): string
    {
        $inline_css = '';
        $post_format = get_post_format();
        if (in_array(get_post_format(), explode(',', get_theme_mod('posts_select')))) {
            $inline_css .= '.format-' . $post_format . ' .hopeui_style-blog-box .hopeui_style-blog-image img { display: none !important; }';
        }

        return $inline_css;
    }


    public function hopeui_php_register_control_setting($wp_customize)
    {
        $wp_customize->add_setting(
            'blog_general',
            array(
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_string')
            )
        );
        $wp_customize->add_setting(
            'blog_single_post',
            array(
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_string')

            )
        );
        $wp_customize->add_setting(
            'blog_column',
            array(
                'default' => 1,
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_number')
            )
        );
        $wp_customize->add_setting(
            'blog_sidebar_setting',
            array(
                'default' => 3,
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_number')
            )
        );
        $wp_customize->add_setting(
            'display_pagination',
            array(
                'default' => true,
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_bool')
            )
        );
        $wp_customize->add_setting(
            'display_feature_img_archive',
            array(
                'default' => true,
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_bool')
            )
        );
        $wp_customize->add_setting(
            'blog_single_page_sidebar_setting',
            array(
                'default' => '2',
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_number')
            )
        );
        $wp_customize->add_setting(
            'display_comment',
            array(
                'default' => true,
                'type'       => 'theme_mod',
                'capability' => 'edit_theme_options',
                'transport'  => 'refresh',
                'sanitize_callback' => array($this, 'hopeui_php_sanitize_bool')
            )
        );
        $wp_customize->add_setting(
            'posts_select',
            array(
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
            'blog_general',
            array(
                'title'       => __('Blog General', 'hopeui'),
                'capability'  => 'edit_theme_options',
                'panel'          => $this->panel_name,
            )
        );

        $wp_customize->add_control(new WP_Image_Radio_Button(
            $wp_customize,
            'blog_column',
            array(
                'label' => __('Blog Column Setting', 'hopeui'),
                'section' => 'blog_general',
                'choices' => array(
                    '1' => array(
                        'label' => 'One Column',
                        'url' =>  '/assets/images/redux//single-column.jpg',
                    ),
                    '2' => array(
                        'label' => 'Two Column',
                        'url' =>  '/assets/images/redux//two-column.jpg',
                    ),
                    '3' => array(
                        'label' => 'Three Column',
                        'url' =>  '/assets/images/redux//three-column.jpg',
                    ),
                ),
                'display_inline' => true
            )
        ));
        $wp_customize->add_control(new WP_Image_Radio_Button(
            $wp_customize,
            'blog_sidebar_setting',
            array(
                'label' => __('Blog SideBar Alignment', 'hopeui'),
                'section' => 'blog_general',
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
        $wp_customize->add_control(new WP_Toggle_Button(
            $wp_customize,
            'display_pagination',
            array(
                'label' => __('Display Previous/Next Pagination?', 'hopeui'),
                'section' => 'blog_general',
                'description' => __('Turn on to display the previous/next post pagination for blog page.', 'hopeui')
            )
        ));
        $wp_customize->add_control(new WP_Toggle_Button(
            $wp_customize,
            'display_feature_img_archive',
            array(
                'label' => __('Display Featured Image on Blog Archive Page?', 'hopeui'),
                'section' => 'blog_general',
                'description' => __('Turn on to display featured images on the blog or archive pages.', 'hopeui')
            )
        ));

        $wp_customize->add_section(
            'blog_single_post',
            array(
                'title'       => __('Blog Single Post', 'hopeui'),
                'capability'  => 'edit_theme_options',
                'panel'          => $this->panel_name,
            )
        );
        $wp_customize->add_control(new WP_Image_Radio_Button(
            $wp_customize,
            'blog_single_page_sidebar_setting',
            array(
                'label' => __('Blog Single page Setting', 'hopeui'),
                'section' => 'blog_single_post',
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

        $wp_customize->add_control(new WP_Toggle_Button(
            $wp_customize,
            'display_comment',
            array(
                'label' => __('Display Comments?', 'hopeui'),
                'section' => 'blog_single_post',
            )
        ));
        $wp_customize->add_control(new WP_DropDown_Select(
            $wp_customize,
            'posts_select',
            array(
                'section' =>  'blog_single_post',
                'label' => __('Select Posts for hide Featues Images', 'hopeui'),
                'choices' => array(
                    "video"   => "Video Format",
                    "quote"   => "Quote Format",
                    "link"    => "Link Format",
                    "audio"   => "Audio Format",
                    "gallery" => "Gallery Format",
                    "image"   => "Image Format"
                ),
                'input_attrs' => array('multiselect' => true),
                'display_block' => true
            )
        ));
    }
}
