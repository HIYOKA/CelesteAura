<?php

/**
 * HopeUI\Utility\Customizer\WP_Customize_Control class
 *
 * @package hopeui
 */

namespace HopeUI\Utility\Customizer\WP_Custom_Control;

use PO;
use HopeUI\Utility\Customizer\HopeUI_Customize_Control;

use function HopeUI\Utility\hopeui;

/**
 * WP_Twodimensional_Input
 *
 * @version 1.0.0
 */
class WP_Twodimensional_Input extends HopeUI_Customize_Control
{
    /**
     * @var string $type Controls Type
     */
    public $type = 'hopeui_php_twodimension_input';
    public $width,$height,$unit;

    public function enqueue()
    {
        wp_enqueue_script('hopeui_style-select2-js', get_parent_theme_file_uri('assets/js/select2.min.js'), array('jquery'), hopeui()->get_asset_version(get_parent_theme_file_uri('assets/js/select2.min.js')), true);
        wp_enqueue_style('hopeui_style-select2-css', get_parent_theme_file_uri('assets/css/select2.min.css'), array(), hopeui()->get_asset_version(get_parent_theme_file_uri('assets/css/select2.min.css')), 'all');
    }
    public function render_content()
    {
        $unit_value='';

        if($this->value() !== null && !is_array($this->value())){
            $value = json_decode($this->value());
            $unit_value= $value->unit;
        }
?>
        <div class="hopeui_style-twodimension_input">
            <input type="hidden" class="hopeui_style-twodimension-val" <?php $this->link(); ?> />
            <?php if (!empty($this->label)) { ?>
                <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
            <?php }
            ?>
            <div class="hopeui_style-twodimension_input-wrapper">
                <div class=" hopeui_style-number-input-container">
                    <button type="button" class="button-decrement"><span class="dashicons dashicons-minus"></span></button>
                    <div class="number-input">
                        <input type="number" class="number-input-text-box hopeui_style-height" value="<?php echo esc_attr($value->height) ?>" />
                    </div>
                    <button type="button" class="button-increment"><span class="dashicons dashicons-plus-alt2"></span></button>
                </div>
                <div class=" hopeui_style-number-input-container">
                    <button type="button" class="button-decrement"><span class="dashicons dashicons-minus"></span></button>
                    <div class="number-input">
                        <input type="number" class="number-input-text-box hopeui_style-width" value="<?php echo esc_attr($value->width) ?>" />
                    </div>
                    <button type="button" class="button-increment"><span class="dashicons dashicons-plus-alt2"></span></button>
                </div>
                <div class=" hopeui_style-number-input-container">
                    <select id="" class="customize-control-select2 hopeui_style-unit">
                        <?php
                        foreach ($this->unit as $key => $value) {
                            echo '<option value="' . esc_attr($key) . '" ' . selected($key, $unit_value, true)  . '>' . esc_attr($value) . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <?php if (!empty($this->description)) { ?>
                <span class="customize-control-description"><?php echo esc_html($this->description); ?></span>
            <?php } ?>
        </div>
<?php
    }
}
