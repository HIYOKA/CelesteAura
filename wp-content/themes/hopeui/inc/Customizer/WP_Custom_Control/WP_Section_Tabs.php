<?php

/**
 * HopeUI\Utility\Customizer\WP_Customize_Control class
 *
 * @package hopeui
 */

namespace HopeUI\Utility\Customizer\WP_Custom_Control;

/**
 * WP_Section_Tabs
 *
 * @version 1.0.0
 */
class WP_Section_Tabs extends \WP_Customize_Control
{
    /**
     * @var string $type Controls Type
     */
    public $type = 'hopeui_php_section_tabs';

    public $tabs,$default;

    public function render_content()
    {
        $is_first = true;
?>

        <div class="hopeui_style-section-tabs">
            <?php foreach ($this->tabs as $key => $tab) { ?>
                <label class="hopeui_style-section-tab-item <?php echo $is_first ? esc_attr('checked','hopeui') : '' ?>" data-target="<?php echo esc_attr($key) ?>">
                    <input type="radio" name="<?php echo esc_attr($this->id); ?>" value="<?php echo esc_attr($key); ?>" <?php $this->link(); ?> <?php checked(esc_attr($key), $this->value()); ?> />
                    <span><?php echo esc_html($tab); ?></span>
                </label>
            <?php
                $is_first = false;
            } ?>
        </div>
<?php
    }
    public function to_json()
    {
        parent::to_json();
        $this->json['tabs'] = $this->tabs;
        $this->json['default'] = $this->default;
    }
}
