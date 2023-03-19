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

class WP_Toggle_Button extends HopeUI_Customize_Control
{
    /**
     * @var string $type Controls Type
     */
    public $type = 'hopeui_php_toggle_button';
    /**
     * @var array $button_label Controls Type
     */
    public $button_label;


    public function render_content()
    {
        if ($this->button_label == null) {
            $this->button_label = array(
                'on' => __('On', 'hopeui'),
                'off' => __('Off', 'hopeui')
            );
        }
?> <div class="toggle_button_button_control">
            <div class="radio-buttons">
                <?php if (!empty($this->label)) { ?>
                    <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <?php }
                ?>
                <label class="btn btn-sm btn-toggle <?php $this->value() ? esc_attr_e('active', 'hopeui') : ''; ?>" data-toggle="button" aria-pressed="true" autocomplete="off" data-true-label="<?php echo esc_html($this->button_label['on'],'hopeui') ?>" data-false-label="<?php echo esc_html($this->button_label['off'],'hopeui') ?>">
                    <input type="checkbox" <?php $this->link(); ?>>
                    <div class="handle"></div>
                </label>
            </div>

            <?php if (!empty($this->description)) { ?>
                <span class="customize-control-description"><?php echo esc_html($this->description); ?></span>
            <?php } ?>
        </div>
<?php
    }
}
