<?php

/**
 * HopeUI\Utility\Customizer\WP_Customize_Control class
 *
 * @package hopeui
 */

namespace HopeUI\Utility\Customizer\WP_Custom_Control;

use HopeUI\Utility\Customizer\HopeUI_Customize_Control;

/**
 * WP_Highlight_Section
 *
 * @version 1.0.0
 */
class WP_Highlight_Section extends \WP_Customize_Section
{
    /**
     * @var string $type Controls Type
     */
    public $type = 'hopeui_php_highlight_section';
    public $url, $backgroundcolor, $textcolor;


    public function render()
    {

        $bkgrndcolor = !empty($this->backgroundcolor) ? esc_attr($this->backgroundcolor) : '#fff';
        $color = !empty($this->textcolor) ? esc_attr($this->textcolor) : '#555d66';
?>
        <li id="accordion-section-<?php echo esc_attr($this->id); ?>" class="hopeui_style_highlight_section accordion-section control-section control-section-<?php echo esc_attr($this->id); ?> cannot-expand">
            <h3 class="upsell-section-title" <?php echo ' style="color:' . $color . ';border-left-color:' . $bkgrndcolor . ';border-right-color:' . $bkgrndcolor . ';"'; ?>>
                <a href="<?php echo esc_url($this->url); ?>" target="_blank" <?php echo ' style="background-color:' . $bkgrndcolor . ';color:' . $color . ';"'; ?>><?php echo esc_html($this->title); ?></a>
            </h3>
        </li>
<?php
    }
}
