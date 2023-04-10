<?php

/**
 * HopeUI\Utility\Customizer\WP_Customize_Control class
 *
 * @package hopeui
 */

namespace HopeUI\Utility\Customizer\WP_Custom_Control;

use HopeUI\Utility\Customizer\HopeUI_Customize_Control;

/**
 * WP_Image_Radio_Button
 *
 * @version 1.0.0
 */
class WP_Image_Radio_Button extends HopeUI_Customize_Control
{
    /**
     * @var string $type Controls Type
     */
    public $type = 'hopeui_php_image_radio_button';
    public $display_inline = false;


    public function render_content()
    {
?><div class="image_button_control <?php echo $this->display_inline ? esc_attr('show_img_inline','hopeui') : ''; ?>">
            <?php if (!empty($this->label)) { ?>
                <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
            <?php } ?>
            <?php if (!empty($this->description)) { ?>
                <span class="customize-control-description"><?php echo esc_html($this->description); ?></span>
            <?php } ?>

            <div class="radio-buttons">
                <?php foreach ($this->choices as $key => $value) { ?>
                    <label class="radio-button-label">
                        <input type="radio" name="<?php echo esc_attr($this->id); ?>" value="<?php echo esc_attr($key); ?>" <?php $this->link(); ?> <?php checked(esc_attr($key), $this->value()); ?> />
                        <img src="<?php echo esc_url(get_template_directory_uri() . $value['url']); ?>" alt="<?php echo esc_attr($key) ?>">
                        <span><?php isset($value['label']) && printf('%s', esc_html($value['label'])); ?></span>
                    </label>
                <?php    } ?>
            </div>
        </div>
<?php
    }
}
