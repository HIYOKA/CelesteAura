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
class WP_Text_Radio_Button extends HopeUI_Customize_Control
{
    /**
     * @var string $type Controls Type
     */
    public $type = 'hopeui_php_text_radio_button';



    public function render_content()
    {
?> <div class="hopeui_style-text-radio-button-control">
            <?php if (!empty($this->label)) { ?>
                <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
            <?php } ?>

            <div class="radio-buttons">
                <?php foreach ($this->choices as $key => $value) { ?>
                    <label class="radio-button-label">
                        <input type="radio" name="<?php echo esc_attr($this->id); ?>" value="<?php echo esc_attr($key); ?>" <?php $this->link(); ?> <?php checked(esc_attr($key), $this->value()); ?> />
                        <span><?php echo esc_html($value); ?></span>
                    </label>
                <?php    } ?>
            </div>
            <?php if (!empty($this->description)) { ?>
                <span class="customize-control-description"><?php echo esc_html($this->description); ?></span>
            <?php } ?>
        </div>
<?php
    }
}
