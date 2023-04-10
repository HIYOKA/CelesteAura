<?php

/**
 * HopeUI\Utility\Customizer\WP_Customize_Control class
 *
 * @package hopeui
 */

namespace HopeUI\Utility\Customizer\WP_Custom_Control;

/**
 * WP_Customize_Color_Control
 *
 * @version 1.0.0
 */
class WP_Customize_Color_Control extends \WP_Customize_Color_Control
{
    public $tab, $condition, $default, $display_inline;

    public function to_json()
    {
        parent::to_json();
        $this->json['tab'] = $this->tab;
        $this->json['condition'] = $this->condition;
    }
}
