<?php

/**
 * HopeUI\Utility\Customizer\WP_Customize_Control class
 *
 * @package hopeui
 */

namespace HopeUI\Utility\Customizer\WP_Custom_Control;

use HopeUI\Utility\Customizer\HopeUI_Customize_Control;

/**
 * WP_Input_Text
 *
 * @version 1.0.0
 */
class WP_Input_Text extends HopeUI_Customize_Control
{
    /**
     * @var string $type Controls Type
     */
    public $type = 'hopeui_php_text';

    public function render_content()
    {

?> <div class="hopeui_style-input-text-control">
            <div class="hopeui_style-input-text-control-wrapper">
                <?php if (!empty($this->label)) { ?>
                    <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <?php }
                ?>
                    <input type="text" <?php $this->link();?>>
            </div>

            <?php if (!empty($this->description)) { ?>
                <span class="customize-control-description"><?php echo esc_html($this->description); ?></span>
            <?php } ?>
        </div>
<?php
    }
}
