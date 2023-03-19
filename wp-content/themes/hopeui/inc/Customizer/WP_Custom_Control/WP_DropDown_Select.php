<?php

/**
 * HopeUI\Utility\Customizer\WP_Customize_Control class
 *
 * @package hopeui
 */

namespace HopeUI\Utility\Customizer\WP_Custom_Control;

use HopeUI\Utility\Customizer\HopeUI_Customize_Control;

use function HopeUI\Utility\hopeui;

/**
 * WP_Section_Tabs
 *
 * @version 1.0.0
 */
class WP_DropDown_Select extends HopeUI_Customize_Control
{
    /**
     * The type of control being rendered
     */
    public $type = 'hopeui_php_dropdown_select2', $display_block = false;
    /**
     * The type of Select2 Dropwdown to display. Can be either a single select dropdown or a multi-select dropdown. Either false for true. Default = false
     */
    private $multiselect = false;
    /**
     * The Placeholder value to display. Select2 requires a Placeholder value to be set when using the clearall option. Default = 'Please select...'
     */
    private $placeholder = 'Please select...';

    /**
     * Constructor
     */
    public function __construct($manager, $id, $args = array(), $options = array())
    {
        parent::__construct($manager, $id, $args);
        // Check if this is a multi-select field
        if (isset($this->input_attrs['multiselect']) && $this->input_attrs['multiselect']) {
            $this->multiselect = true;
        }
        // Check if a placeholder string has been specified
        if (isset($this->input_attrs['placeholder']) && $this->input_attrs['placeholder']) {
            $this->placeholder = $this->input_attrs['placeholder'];
        }
    }
    /**
     * Enqueue our scripts and styles
     */
    public function enqueue()
    {
        wp_enqueue_script('hopeui_style-select2-js', get_parent_theme_file_uri('assets/js/select2.min.js'), array('jquery'), hopeui()->get_asset_version(get_parent_theme_file_uri('assets/js/select2.min.js')), true);
        wp_enqueue_style('hopeui_style-select2-css', get_parent_theme_file_uri('assets/css/select2.min.css'), array(), hopeui()->get_asset_version(get_parent_theme_file_uri('assets/css/select2.min.css')), 'all');
    }
    /**
     * Render the control in the customizer
     */
    public function render_content()
    {
        $defaultValue = $this->value();
        if ($this->multiselect) {
            $defaultValue = explode(',', $this->value());
        }
?>
        <div class="dropdown_select2_control <?php echo $this->display_block ? esc_attr('display-block') : ''; ?>">
            <div class="dropdowm_header">

                <?php if (!empty($this->label)) { ?>
                    <label for="<?php echo esc_attr($this->id); ?>" class="customize-control-title">
                        <?php echo esc_html($this->label); ?>
                    </label>
                <?php } ?>

                <input type="hidden" id="<?php echo esc_attr($this->id); ?>" class="customize-control-dropdown-select2" value="<?php echo esc_attr($this->value()); ?>" name="<?php echo esc_attr($this->id); ?>" <?php $this->link(); ?> />
                <select name="select2-list-<?php $this->multiselect ? sprintf('%s', esc_attr('multi[]'))  : sprintf('%s', esc_attr('single')); ?>" class="customize-control-select2" data-placeholder="<?php echo esc_attr($this->placeholder); ?>" <?php $this->multiselect && sprintf('%s',esc_attr('multiple="multiple" ')); ?>>
                    <?php
                    if (!$this->multiselect) {
                        echo '<option></option>';
                    }
                    foreach ($this->choices as $key => $value) {
                        if (is_array($value)) {
                            echo '<optgroup label="' . esc_attr($key) . '">';
                            foreach ($value as $optgroupkey => $optgroupvalue) {
                                if ($this->multiselect) {
                                    echo '<option value="' . esc_attr($optgroupkey) . '" ' . (in_array(esc_attr($optgroupkey), $defaultValue) ? 'selected="selected"' : '') . '>' . esc_attr($optgroupvalue) . '</option>';
                                } else {
                                    echo '<option value="' . esc_attr($optgroupkey) . '" ' . selected(esc_attr($optgroupkey), $defaultValue, false)  . '>' . esc_attr($optgroupvalue) . '</option>';
                                }
                            }
                            echo '</optgroup>';
                        } else {
                            if ($this->multiselect) {
                                echo '<option value="' . esc_attr($key) . '" ' . (in_array(esc_attr($key), $defaultValue) ? 'selected="selected"' : '') . '>' . esc_attr($value) . '</option>';
                            } else {
                                echo '<option value="' . esc_attr($key) . '" ' . selected(esc_attr($key), $defaultValue, false)  . '>' . esc_attr($value) . '</option>';
                            }
                        }
                    }
                    ?>
                </select>
            </div>

            <?php if (!empty($this->description)) { ?>
                <span class="customize-control-description"><?php echo esc_html($this->description); ?></span>
            <?php } ?>
        </div>
<?php
    }
}
