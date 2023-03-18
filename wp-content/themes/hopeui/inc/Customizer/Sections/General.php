<?php


namespace HopeUI\Utility\Customizer\Sections;

use HopeUI\Utility\Component_Customizer;
use HopeUI\Utility\Customizer\WP_Custom_Control\WP_Customize_Color_Control;
use HopeUI\Utility\Customizer\WP_Custom_Control\WP_Highlight_Section;
use HopeUI\Utility\Customizer\WP_Custom_Control\WP_Input_Text;
use HopeUI\Utility\Customizer\WP_Custom_Control\WP_Slider_Control;
use HopeUI\Utility\Customizer\WP_Custom_Control\WP_Text_Radio_Button;
use HopeUI\Utility\Customizer\WP_Custom_Control\WP_Toggle_Button;
use HopeUI\Utility\Customizer\WP_Custom_Control\WP_Typography;

/**
 * HopeUI\Utility\Customizer\Sections\General class
 *
 * @package hopeui
 * @version 1.0.0
 */

class General extends Component_Customizer
{
	public function init()
	{
		$this->panel_name = 'generals';
		$this->panel_title = __('Generals', 'hopeui');
	}
	public function enqueue_style(): string
	{
		$global_query_object = get_queried_object_id();
		$inline_css = ':root{';
		$inline_css .= "--content-width-sm:" . get_theme_mod('container_width', 1300) . "px !important;";


		$colors = [
			["primary_color", "--color-theme-primary"],
			["secondary_color", "--color-theme-secondary"],
			["title_color", "--global-font-title"],
			["text_color", "--global-font-color"],
		];

		foreach ($colors  as $color) {
			$color_var = get_theme_mod($color[0]);
			if (empty($color_var))
				continue;
			$inline_css .= $color[1] . ":" . $color_var . '!important;';
		}
		$inline_css .= '}';

		// To Set The Page BG Color
		$bg_color = get_post_meta($global_query_object, 'hopeui_php_page_bg_color', true);
		if ($bg_color!=false) {
			$inline_css = "body {background: ${bg_color};}";
		}

		$global_font = json_decode(get_theme_mod('hopeui_php_body_typography'));
		if (get_theme_mod('hopeui_php_custom_typography', false) && isset($global_font)) {
			$inline_css .= ':root{';
			$inline_css .= '--global-font-family:"' . $global_font->font . '" !important;';
			$inline_css .= '--highlight-font-family:"' . $global_font->font . '" !important;';
			$inline_css .= '--font-size-body:' . $global_font->size . '!important;';
			$inline_css .= '}';
			$inline_css .= 'body{font-weight:' . $global_font->boldweight . '}';
			$this->hopeui_php_enqueue_style($global_font, 'hopeui-google-font');
		}

		return $inline_css;
	}


	public function hopeui_php_register_control_setting($wp_customize)
	{
		// Add Controls Setting
		$wp_customize->add_setting(
			'container_width',
			array(
				'default'    => '1500',
				'type'       => 'theme_mod',
				'capability' => 'edit_theme_options',
				'transport'  => 'postMessage',
				'sanitize_callback' => array($this, 'hopeui_php_sanitize_string')
			)
		);

		$wp_customize->add_setting(
			'hopeui_php_container_type',
			array(
				'default'    => 'container',
				'sanitize_callback' => array($this, 'hopeui_php_sanitize_string')
			)
		);

		$wp_customize->add_setting(
			'body_option',
			array(
				'default' => 'default',
				'type'       => 'theme_mod',
				'capability' => 'edit_theme_options',
				'transport'  => 'postMessage',
				'sanitize_callback' => array($this, 'hopeui_php_sanitize_string')
			)
		);
		$wp_customize->add_setting(
			'back_to_top',
			array(
				'default' => 'yes',
				'type'       => 'theme_mod',
				'capability' => 'edit_theme_options',
				'transport'  => 'refresh',
				'sanitize_callback' => array($this, 'hopeui_php_sanitize_bool')
			)
		);
		$wp_customize->add_setting(
			'back_to_top_btn_text',
			array(
				'default' => __('Scroll Up', 'hopeui'),
				'type'       => 'theme_mod',
				'capability' => 'edit_theme_options',
				'transport'  => 'postMessage',
				'sanitize_callback' => array($this, 'hopeui_php_sanitize_string')
			)
		);


		// Colors Settings
		$wp_customize->add_setting(
			'primary_color',
			array(
				'transport'  => 'postMessage',
				'sanitize_callback' => array($this, 'hopeui_php_sanitize_hex_color')
			)
		);
		$wp_customize->add_setting(
			'secondary_color',
			array(
				'transport'  => 'postMessage',
				'sanitize_callback' => array($this, 'hopeui_php_sanitize_hex_color')
			)
		);
		$wp_customize->add_setting(
			'title_color',
			array(
				'transport'  => 'postMessage',
				'sanitize_callback' => array($this, 'hopeui_php_sanitize_hex_color')
			)
		);
		$wp_customize->add_setting(
			'text_color',
			array(
				'transport'  => 'postMessage',
				'sanitize_callback' => array($this, 'hopeui_php_sanitize_hex_color')
			)
		);
		$wp_customize->add_setting(
			'hopeui_php_typography_section',
			array(
				'transport'  => 'postMessage',
				'sanitize_callback' => array($this, 'hopeui_php_sanitize_hex_color')
			)
		);
		$wp_customize->add_setting(
			'hopeui_php_custom_typography',
			array(
				'default' => false,
				'transport'  => 'refresh',
				'sanitize_callback' => array($this, 'hopeui_php_sanitize_bool')
			)
		);
		$wp_customize->add_setting(
			'hopeui_php_body_typography',
			array(
				'transport'  => 'refresh',
				'sanitize_callback' => array($this, 'hopeui_php_sanitize_typography')
			)
		);
		$wp_customize->add_setting(
			'hopeui_php_theme_doc_link',
			array(
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
		$wp_customize->add_section(new WP_Highlight_Section(
			$wp_customize,
			'hopeui_php_doc_heading',
			array(
				'title' => __('View Support Documentation', 'hopeui'),
				'url' => 'https://assets.iqonic.design/documentation/wordpress/hopeui-doc/index.html',
				'priority' => -99,
			)
		));
		$wp_customize->add_control('hopeui_php_theme_doc_link', array(
			'type' => 'text',
			'section' => 'hopeui_php_doc_heading', // Add a default or your own section
		));
		$wp_customize->remove_section('background_image');

		$wp_customize->add_section(
			'body_layout',
			array(
				'title'       => __('Body Layout', 'hopeui'),
				'capability'  => 'edit_theme_options',
				'panel'          => $this->panel_name,
			)
		);
		$wp_customize->add_control(new WP_Text_Radio_Button(
			$wp_customize,
			'hopeui_php_container_type',
			array(
				'label' => __('Container Type', 'hopeui'),
				'section' => 'body_layout',
				'choices' => array(
					'container' => __('Container', 'hopeui'),
					'fluid' => __('Full Width', 'hopeui'),
				)
			)
		));
		$wp_customize->add_control(new WP_Slider_Control(
			$wp_customize,
			'grid_container',
			array(
				'label'	=> __('Container Width', 'hopeui'),
				'section' => 'body_layout',
				'settings' => 'container_width',
				'input_attrs' => array(
					'min' => 500,
					'max' => 2000,
					'step' => 1,
					'unit' => esc_html__('PX', 'hopeui'),
				),
			)
		));

		$wp_customize->add_control(new WP_Text_Radio_Button(
			$wp_customize,
			'body_option',
			array(
				'label' => __('Body Set Option', 'hopeui'),
				'section' => 'body_layout',
				'choices' => array(
					'color' => __('Color', 'hopeui'),
					'default' => __('Default', 'hopeui'),
					'image' => __('Image', 'hopeui')
				)
			)
		));
		$wp_customize->add_control(new WP_Customize_Color_Control(
			$wp_customize,
			'background_color',
			array(
				'label' => __('Set Background Color', 'hopeui'),
				'section' => 'body_layout',
				'condition' => ['body_option' => 'color']
			)
		));

		$wp_customize->add_section(
			'back_to_top',
			array(
				'title'       => __('Back to Top', 'hopeui'),
				'priority'    => 11,
				'capability'  => 'edit_theme_options',
				'panel'          => $this->panel_name,
			)
		);

		$wp_customize->add_control(new WP_Toggle_Button(
			$wp_customize,
			'back_to_top',
			array(
				'label' => __('Show Back To Top?', 'hopeui'),
				'section' => 'back_to_top',

			)
		));

		$wp_customize->add_control(new WP_Input_Text(
			$wp_customize,
			'back_to_top_btn_text',
			array(
				'section' => 'back_to_top', // Add a default or your own section
				'label' => __('Back to top Button Text', 'hopeui'),
				'description' => __('Text to show on "Back to top" button.', 'hopeui'),
				'condition' => ['back_to_top' => true]
			)
		));


		$wp_customize->add_section(
			'colors',
			array(
				'title'       => __('Colors', 'hopeui'),
				'priority'    => 15,
				'capability'  => 'edit_theme_options',
				'panel'          => $this->panel_name,
			)
		);
		$wp_customize->add_control('primary_color', array(
			'type' => 'color',
			'section' => 'colors', // Add a default or your own section
			'label' => __('Primary Color', 'hopeui'),
		));
		$wp_customize->add_control('secondary_color', array(
			'type' => 'color',
			'section' => 'colors', // Add a default or your own section
			'label' => __('Secondary Color', 'hopeui'),
		));
		$wp_customize->add_control('title_color', array(
			'type' => 'color',
			'section' => 'colors', // Add a default or your own section
			'label' => __('Title Color', 'hopeui'),
		));
		$wp_customize->add_control('text_color', array(
			'type' => 'color',
			'section' => 'colors', // Add a default or your own section
			'label' => __('Text Color', 'hopeui'),
		));
		$wp_customize->remove_section('background_image');


		$wp_customize->add_section(
			'hopeui_php_typography_section',
			array(
				'title'       => __('Typography', 'hopeui'),
				'priority'    => 16,
				'capability'  => 'edit_theme_options',
				'panel'          => $this->panel_name,
			)
		);
		$wp_customize->add_control(new WP_Toggle_Button(
			$wp_customize,
			'hopeui_php_custom_typography',
			array(
				'label' => __('Custom Typography?', 'hopeui'),
				'section' => 'hopeui_php_typography_section',
			)
		));
		$wp_customize->add_control(new WP_Typography(
			$wp_customize,
			'hopeui_php_body_typography',
			array(
				'section' => 'hopeui_php_typography_section', // Add a default or your own section
				'label' => __('Body Font', 'hopeui'),
				'description' => esc_html__('Select Global Body Typography', 'hopeui'),
				'input_attrs' => array(
					'font_count' => 'all',
					'orderby' => 'alpha',
					'size' => array(
						'unit' => 'px',
					)
				),
				'condition' => array('hopeui_php_custom_typography' => true)
			)
		));

		$wp_customize->get_setting('blogname')->transport = 'postMessage';
		$wp_customize->get_setting('blogdescription')->transport = 'postMessage';
		$wp_customize->get_setting('header_textcolor')->transport = 'postMessage';
		$wp_customize->get_setting('background_color')->transport = 'postMessage';
		$wp_customize->get_setting('container_width')->transport = 'postMessage';
	}
}
