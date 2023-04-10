<?php

/**
 * HopeUI\Utility\Notice\Component class
 *
 * @package hopeui
 */

namespace HopeUI\Utility\Notice;

use HopeUI\Utility\Component_Interface;

class Component implements Component_Interface
{
    /**
     * Gets the unique identifier for the theme component.
     *
     * @return string Component slug.
     */
    public function get_slug(): string
    {
        return 'notice';
    }

    /**
     * Adds the action and filter hooks to integrate with WordPress.
     */
    public function initialize()
    {
        add_action('admin_init', array($this, 'hopeui_php_add_notice'));
    }
    public function hopeui_php_add_notice()
    {

        // $my_theme_notices = new Notices();
        // $my_theme_notices->add('hopeui_admin_notice', __('Thanks for joining our HopeUI Community, you rock!', 'hopeui'), __('We also Introduce our HopeUI Child Theme To Enable Full Site Editing.<br> With This you can also access Our Demo Templates', 'hopeui'), array('type' => 'success'));
        // $my_theme_notices->boot();
        if (isset($_GET['page']) && $_GET['page'] == 'hopeui-dashboard') {
            remove_all_actions('admin_notices');
        }
    }
}
