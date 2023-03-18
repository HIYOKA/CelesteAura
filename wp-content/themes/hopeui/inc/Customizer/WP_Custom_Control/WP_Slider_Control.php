<?php

/**
 * HopeUI\Utility\Customizer\WP_Customize_Control class
 *
 * @package hopeui
 */

namespace HopeUI\Utility\Customizer\WP_Custom_Control;

use HopeUI\Utility\Customizer\HopeUI_Customize_Control;

/**
 * WP_Slider_Control
 *
 * @version 1.0.0
 */
class WP_Slider_Control extends HopeUI_Customize_Control
{
    /**
     * @var string $type Controls Type
     */
    public $type = 'hopeui_php_range_slider';


    public function render_content()
    {
?>
        <div class="slider-custom-control">
            <div class="hopeui_style-slider-header">
                <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <div class="hopeui_style-slider-inputs">
                    <input type="number" id="<?php echo esc_attr($this->id); ?>" name="<?php echo esc_attr($this->id); ?>" value="<?php echo esc_attr($this->value()); ?>" class="customize-control-slider-value" <?php $this->link(); ?> />
                    <span class="unit"><?php echo esc_html($this->input_attrs['unit']); ?></span>
                </div>
            </div>

            <div class="slider" slider-min-value="<?php echo esc_attr($this->input_attrs['min']); ?>" slider-max-value="<?php echo esc_attr($this->input_attrs['max']); ?>" slider-step-value="<?php echo esc_attr($this->input_attrs['step']); ?>"></div>
            <span class="slider-reset dashicons dashicons-image-rotate" slider-reset-value="<?php echo esc_attr($this->value()); ?>"></span>
            <?php if (isset($this->input_attrs['desc'])) {
            ?>
                <p class="hopeui_style-slider-desc"><?php echo esc_html($this->input_attrs['desc']); ?></p>
            <?php
            }
            ?>
        </div>
<?php
    }
}
