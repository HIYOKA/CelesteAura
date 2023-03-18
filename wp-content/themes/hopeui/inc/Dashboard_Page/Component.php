<?php

/**
 * HopeUI\Utility\Dashboard_Page\Component class
 *
 * @package hopeui
 */

namespace HopeUI\Utility\Dashboard_Page;

use HopeUI\Utility\Component_Interface;
use function HopeUI\Utility\hopeui;

class Component implements Component_Interface
{
    /**
     * Gets the unique identifier for the theme component.
     *
     * @return string Component slug.
     */
    public function get_slug(): string
    {
        return 'dashboard-page';
    }

    /**
     * Adds the action and filter hooks to integrate with WordPress.
     */
    public function initialize()
    {
        add_action('admin_menu', array($this, 'hopeui_php_admin_dashboard_page'));
    }

    public function hopeui_php_admin_dashboard_page()
    {
        $dashboard_options = array(
            'title' => 'HopeUI',
            'menu_title' => 'HopeUI',
            'capability' =>  'manage_options',
            'slug' => 'hopeui-dashboard',
            'call_back' => array($this, 'hopeui_php_dashboard_page_render'),
            'position' => 1
        );

        $result = apply_filters('hopeui_php_dashboard_page', false, $dashboard_options);
        if (!$result) {
            add_theme_page(
                $dashboard_options['title'],
                $dashboard_options['menu_title'],
                $dashboard_options['capability'],
                $dashboard_options['slug'],
                $dashboard_options['call_back'],
                $dashboard_options['position']
            );
        }
    }
    public function hopeui_php_dashboard_page_render()
    {

        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.', 'hopeui'));
        }

        wp_enqueue_style('bootstrap', get_template_directory_uri() . "/assets/css/bootstrap.min.css", array(), hopeui()->get_asset_version(get_theme_file_path('assets/css/bootstrap.min.css')));
        wp_enqueue_script('bootstrap', get_template_directory_uri() . "/assets/js/bootstrap.min.js", array(), hopeui()->get_asset_version(get_theme_file_path('assets/js/bootstrap.min.js')));
        wp_enqueue_style('admin-dashboard', get_template_directory_uri() . "/assets/css/admin-dashboad.min.css", array(), hopeui()->get_asset_version(get_theme_file_path('assets/css/admin-dashboad.min.css')));
        wp_enqueue_style('button-style', get_template_directory_uri() . "/assets/css/button.min.css", array(), hopeui()->get_asset_version(get_theme_file_path('assets/css/src/button.min.css')));


?>
        <div class="hopeui_style-dashboard-page ">
            <div class="hopeui_style-dashboard-page-header">
                <div class="hopeui_style-heading">
                    <svg width="75" viewBox="0 0 55 55" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="-0.423828" y="34.5762" width="50" height="7.14286" rx="3.57143" transform="rotate(-45 -0.423828 34.5762)" fill="white"></rect>
                        <rect x="14.7295" y="49.7266" width="50" height="7.14286" rx="3.57143" transform="rotate(-45 14.7295 49.7266)" fill="white"></rect>
                        <rect x="19.7432" y="29.4902" width="28.5714" height="7.14286" rx="3.57143" transform="rotate(45 19.7432 29.4902)" fill="white"></rect>
                        <rect x="19.7783" y="-0.779297" width="50" height="7.14286" rx="3.57143" transform="rotate(45 19.7783 -0.779297)" fill="white"></rect>
                    </svg>
                    <h1><?php _e("HopeUI", 'hopeui') ?></h1>
                </div>
                <p class="hopeui_style-heading-contain"><?php
                echo esc_html__('HopeUI is the ultimate WordPress theme for any small business, blog, or e-commerce shop! It is easy to customize & build your own unique website faster.','hopeui');
                ?>
                </p>
            </div>
            <div class="hopeui_style-dashboard-page-body">
                <div class="container ">
                    <div class="hopeui_style-tab ">
                        <?php
                        $tabs['dashboard'] = array(
                            'title'     => esc_html__('Dashboard', 'hopeui'),
                            'callback'  => array($this, 'hopeui_php_render_dashboard_tab'),
                            'priority'  => 10
                        );
                        $tabs['changelog'] = array(
                            'title'     => esc_html__('ChangeLog', 'hopeui'),
                            'callback'  =>  array($this, 'hopeui_php_render_changelog_tab'),
                            'priority'  => 20,
                        );
                        if (!empty($tabs)) {
                            get_template_part('template-parts/global/tab', '', array('tabs' => apply_filters('hopeui_php_admin_dashboard_page_tabs', $tabs)));
                        }
                        ?>
                    </div>
                    <div class="hopeui_style-support-section text-center">
                        <h3><?php _e('Need Assistance or Advice?', 'hopeui') ?></h3>
                        <p class="hopeui_style-support-desc"> <?php _e('Any queries or need any helping hand regarding the theme? You can apply for a support ticket or can ask for assistance in our friendly Facebook community.', 'hopeui') ?></p>
                        <div class="hopeui_style-group-btn d-flex  justify-content-center">
                            <a href="<?php echo esc_url('https://wordpress.org/support/theme/hopeui/') ?>" class="btn btn-icon btn-primary hopeui_style-button " target="_blank">
                                <?php echo esc_html__('Submit a Support Ticket', 'hopeui') ?>
                            </a>
                            <a href="#" class="btn btn-icon btn-primary hopeui_style-button ">
                                <?php echo esc_html__('Join Our HopeUI Community', 'hopeui') ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }

    public function hopeui_php_render_dashboard_tab()
    {
    ?>
        <div class="hopeui_style-dashboard-tab mt-4">
            <h5 class="text-center"><?php _e('Customizer Shortcuts', 'hopeui') ?></h5>
            <div class="hopeui_style-customizer-options">
                <div class="row">
                    <?php
                    $customizer_shortcuts = $this->hopeui_php_customizer_shortcuts();
                    foreach ($customizer_shortcuts as $customizer_shortcut) { ?>
                        <div class="col-sm-4">
                            <?php $this->hopeui_php_render_card($customizer_shortcut); ?>
                        </div>
                    <?php } ?>
                </div>

            </div>
        </div>
    <?php

    }
    public function hopeui_php_render_card($args = array())
    {
        if (empty($args)) return;
    ?>
        <div class="card hopeui_style-customizer-card">
            <div class="card-body text-center">
                <?php $this->hopeui_php_esc_svg($args['icon'], true); ?>
                <h5 class="card-title"><?php echo esc_html($args['title']) ?></h5>
                <p class="card-text"><?php echo esc_html($args['description']) ?></p>
                <a href="<?php echo esc_url($args['link']) ?>" class="btn btn-icon btn-primary hopeui_style-button ">
                    <?php echo esc_html__('Go To Options', 'hopeui') ?>
                    <span class="btn-inner">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24" fill="white">
                            <path d="M8.7 17.3q-.275-.275-.275-.7 0-.425.275-.7l3.9-3.9-3.9-3.9q-.275-.275-.275-.7 0-.425.275-.7.275-.275.7-.275.425 0 .7.275l4.6 4.6q.15.15.213.325.062.175.062.375t-.062.375q-.063.175-.213.325l-4.6 4.6q-.275.275-.7.275-.425 0-.7-.275Z" />
                        </svg>
                    </span>
                </a>
            </div>
        </div>
    <?php
    }
    public function hopeui_php_render_changelog_tab()
    {
    ?>
        <div class="change-log mt-4">
            <ul class="list-inline changelogo-list">
                <li>
                    <div class="d-flex align-items-center justify-content-between">
                        <h5>Version 1.1.2</h5>
                        <span class="badge bg-primary">2 Jan 2023</span>
                    </div>
                    <ul>
                        <li>[Add] Meta Box Options To Set Individual Page Structure</li>
                        <li>[Add] Theme Admin Dashboard Page</li>
                        <li>[Fixed] Header Descriptions</li>
                        <li>[Update] Preview Screenshot</li>
                    </ul>
                </li>
                <li>
                    <div class="d-flex align-items-center justify-content-between">
                        <h5>Version 1.0.8</h5>
                        <span class="badge bg-primary">02 Nov 2022</span>
                    </div>
                    <ul>
                        <li>[Fixed] Fixed Error On Customizer on Toggle Button Control</li>
                        <li>[Fixed] Menu When No Primary Menu Is Selected Now Pages is Display</li>
                        <li>[Fixed] Mobile Menu Key Navigation JS</li>
                        <li>[Compatible] WooCommerce 7</li>
                    </ul>
                </li>
                <li>
                    <div class="d-flex align-items-center justify-content-between">
                        <h5>Version 1.0</h5>
                        <span class="badge bg-primary">13 Oct 2022</span>
                    </div>
                    <ul>
                        <li>Initial release.</li>
                    </ul>
                </li>
            </ul>
        </div>
<?php
    }
    public function hopeui_php_customizer_shortcuts()
    {
        return array(
            'general' => array(
                'icon' => '<?xml version="1.0"?><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 16 13" fill="none"><g clip-path="url(#clip0_1347_2975)"><path d="M14.3847 3.88666L13.4475 5.29619C13.8995 6.19758 14.1207 7.19701 14.0915 8.20493C14.0622 9.21285 13.7834 10.1978 13.2799 11.0714H2.7199C2.06555 9.93627 1.79441 8.62047 1.94667 7.3191C2.09894 6.01772 2.6665 4.80006 3.56522 3.84661C4.46394 2.89316 5.64597 2.2547 6.93608 2.02586C8.22619 1.79703 9.55571 1.99001 10.7275 2.57619L12.137 1.63905C10.702 0.718829 8.99976 0.306478 7.30267 0.467949C5.60558 0.629421 4.01167 1.35539 2.77589 2.52972C1.54012 3.70406 0.733889 5.25891 0.48616 6.94557C0.238431 8.63223 0.563518 10.3532 1.40942 11.8333C1.54238 12.0636 1.7333 12.2551 1.9632 12.3888C2.1931 12.5225 2.45397 12.5936 2.7199 12.5952H13.2723C13.5408 12.5963 13.8048 12.5264 14.0376 12.3926C14.2704 12.2588 14.4637 12.0659 14.598 11.8333C15.3 10.6173 15.6523 9.23087 15.616 7.8272C15.5797 6.42353 15.1562 5.05719 14.3923 3.87905L14.3847 3.88666Z" fill="#A6AEC6"/><path opacity="0.25" d="M6.92592 9.09812C7.06744 9.2398 7.2355 9.35219 7.42048 9.42888C7.60547 9.50556 7.80376 9.54503 8.00401 9.54503C8.20426 9.54503 8.40255 9.50556 8.58754 9.42888C8.77253 9.35219 8.94059 9.2398 9.08211 9.09812L13.3945 2.62955L6.92592 6.94193C6.78424 7.08345 6.67184 7.25151 6.59516 7.43649C6.51847 7.62148 6.479 7.81977 6.479 8.02002C6.479 8.22027 6.51847 8.41856 6.59516 8.60355C6.67184 8.78854 6.78424 8.9566 6.92592 9.09812Z" fill="#A6AEC6"/></g><defs><clipPath id="clip0_1347_2975"><rect width="16" height="12.5714" fill="white" transform="translate(0 0.214294)"/></clipPath></defs></svg>',
                'title' => __('General Option', 'hopeui'),
                'description' => __("Set the theme global colors, Back To Top, Body Layouts", 'hopeui'),
                'link' => admin_url('/customize.php?autofocus[panel]=generals')
            ),
            'colors' => array(
                'icon' => '<?xml version="1.0"?><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 14 17" fill="none"><path opacity="0.25" d="M3.28125 6.38633C2.2925 7.32107 1.75 8.55896 1.75 9.87265C1.75 12.6011 4.10375 14.8158 7 14.8158V2.86633L3.28125 6.38633Z" fill="#fff"/><path d="M11.9437 5.18211L7 0.5L2.05625 5.18211C0.7875 6.38632 0 8.04526 0 9.87263C0 13.5358 3.1325 16.5 7 16.5C10.8675 16.5 14 13.5358 14 9.87263C14 8.04526 13.2125 6.38632 11.9437 5.18211ZM1.75 9.87263C1.75 8.55895 2.2925 7.32105 3.28125 6.38632L7 2.86632V14.8158C4.10375 14.8158 1.75 12.6011 1.75 9.87263Z" fill="#A6AEC6"/></svg>',
                'title' => __('Color Option', 'hopeui'),
                'description' => __("Set the theme Global Colors like Primary ,Secondary Color.", 'hopeui'),
                'link' => admin_url('/customize.php?autofocus[section]=colors')
            ),
            'hopeui_php_typography_section' => array(
                'icon' => '<?xml version="1.0"?><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 17 17" fill="none"><path opacity="0.25" d="M2.20345 13.8333H15.5368C16.2701 13.8333 16.8701 14.4333 16.8701 15.1666C16.8701 15.9 16.2701 16.5 15.5368 16.5H2.20345C1.47012 16.5 0.870117 15.9 0.870117 15.1666C0.870117 14.4333 1.47012 13.8333 2.20345 13.8333Z" fill="white"/><path d="M7.95694 3.12L4.91028 10.8867C4.73028 11.34 5.06361 11.8333 5.55695 11.8333C5.84361 11.8333 6.10361 11.6533 6.21028 11.38L6.78361 9.83333H10.9503L11.5303 11.38C11.6303 11.6533 11.8903 11.8333 12.1836 11.8333C12.6703 11.8333 13.0103 11.34 12.8303 10.8867L9.78361 3.12C9.63028 2.74667 9.27028 2.5 8.87028 2.5C8.47028 2.5 8.10361 2.74667 7.95694 3.12ZM7.28361 8.5L8.87028 4.28L10.4569 8.5H7.28361Z" fill="#A6AEC6"/><defs><clipPath id="clip0_1347_3012"><rect width="16" height="16" fill="white" transform="translate(0.870117 0.5)"/></clipPath></defs></svg>',
                'title' => __('Typography Option', 'hopeui'),
                'description' => __("Set the theme Global Typography with Google fonts.", 'hopeui'),
                'link' => admin_url('/customize.php?autofocus[section]=hopeui_php_typography_section')
            ),
            'breadcrumb' => array(
                'icon' => '<?xml version="1.0"?><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 18 18" fill="none"><path d="M18 9.00001L14.8312 12.15L14.0438 11.3625L16.4062 8.98126L14.025 6.60001L14.8125 5.81251L18 9.00001ZM14.25 9.00001L11.0812 12.15L10.2938 11.3625L12.6562 8.98126L10.275 6.60001L11.0625 5.81251L14.25 9.00001ZM7.725 11.3625L6.9375 12.1688L3.75 8.98126L6.91875 5.81251L7.725 6.61876L5.3625 9.00001L7.725 11.3625ZM3.975 11.3625L3.1875 12.1688L0 8.98126L3.16875 5.81251L3.975 6.61876L1.6125 9.00001L3.975 11.3625Z" fill="#A6AEC6"/></svg>',
                'title' => __('Breadcrumb Option', 'hopeui'),
                'description' => __("Set the theme Breadcrumb Structure and its Style", 'hopeui'),
                'link' => admin_url('/customize.php?autofocus[section]=breadcrumb')
            ),
            'header' => array(
                'icon' => '<?xml version="1.0"?><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 15 15" fill="none"><path d="M12.4444 0.388916H2.4888C1.92301 0.388916 1.38039 0.613677 0.980308 1.01375C0.58023 1.41383 0.355469 1.95645 0.355469 2.52225V12.4778C0.355469 13.0436 0.58023 13.5862 0.980308 13.9863C1.38039 14.3864 1.92301 14.6111 2.4888 14.6111H12.4444C13.0102 14.6111 13.5528 14.3864 13.9529 13.9863C14.3529 13.5862 14.5777 13.0436 14.5777 12.4778V2.52225C14.5777 1.95645 14.3529 1.41383 13.9529 1.01375C13.5528 0.613677 13.0102 0.388916 12.4444 0.388916ZM1.77769 2.52225C1.77769 2.33365 1.85261 2.15278 1.98597 2.01942C2.11933 1.88606 2.3002 1.81114 2.4888 1.81114H12.4444C12.633 1.81114 12.8138 1.88606 12.9472 2.01942C13.0805 2.15278 13.1555 2.33365 13.1555 2.52225V3.23336H1.77769V2.52225ZM13.1555 12.4778C13.1555 12.6664 13.0805 12.8473 12.9472 12.9806C12.8138 13.114 12.633 13.1889 12.4444 13.1889H2.4888C2.3002 13.1889 2.11933 13.114 1.98597 12.9806C1.85261 12.8473 1.77769 12.6664 1.77769 12.4778V4.65558H13.1555V12.4778Z" fill="#A6AEC6"/><path opacity="0.25" d="M2.48863 1.10004H12.4442C12.8214 1.10004 13.1831 1.24988 13.4498 1.5166C13.7166 1.78331 13.8664 2.14506 13.8664 2.52226V3.94448H1.06641V2.52226C1.06641 2.14506 1.21625 1.78331 1.48297 1.5166C1.74968 1.24988 2.11143 1.10004 2.48863 1.10004Z" fill="#A6AEC6"/></svg>',
                'title' => __('Header Option', 'hopeui'),
                'description' => __("Set the theme header container, Position, and Style", 'hopeui'),
                'link' => admin_url('/customize.php?autofocus[panel]=header')
            ),
            'footer' => array(
                'icon' => '<?xml version="1.0"?><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 15 15" fill="none"><path opacity="0.25" d="M12.4445 13.9001L2.48892 13.9001C2.11172 13.9001 1.74998 13.7503 1.48326 13.4836C1.21654 13.2169 1.0667 12.8551 1.0667 12.4779V11.0557L13.8667 11.0557V12.4779C13.8667 12.8551 13.7169 13.2169 13.4501 13.4836C13.1834 13.7503 12.8217 13.9001 12.4445 13.9001Z" fill="#A6AEC6"/><path d="M2.4888 14.6111H12.4444C13.0102 14.6111 13.5528 14.3864 13.9529 13.9863C14.3529 13.5862 14.5777 13.0436 14.5777 12.4778V2.52225C14.5777 1.95645 14.3529 1.41383 13.9529 1.01375C13.5528 0.613677 13.0102 0.388916 12.4444 0.388916H2.4888C1.92301 0.388916 1.38039 0.613677 0.980308 1.01375C0.58023 1.41383 0.355469 1.95645 0.355469 2.52225V12.4778C0.355469 13.0436 0.58023 13.5862 0.980308 13.9863C1.38039 14.3864 1.92301 14.6111 2.4888 14.6111ZM13.1555 12.4778C13.1555 12.6664 13.0805 12.8473 12.9472 12.9806C12.8138 13.114 12.633 13.1889 12.4444 13.1889H2.4888C2.3002 13.1889 2.11933 13.114 1.98597 12.9806C1.85261 12.8473 1.77769 12.6664 1.77769 12.4778V11.7667H13.1555V12.4778ZM1.77769 2.52225C1.77769 2.33365 1.85261 2.15278 1.98597 2.01942C2.11933 1.88606 2.3002 1.81114 2.4888 1.81114H12.4444C12.633 1.81114 12.8138 1.88606 12.9472 2.01942C13.0805 2.15278 13.1555 2.33365 13.1555 2.52225V10.3445H1.77769V2.52225Z" fill="#A6AEC6"/></svg>',
                'title' => __('Footer Option', 'hopeui'),
                'description' => __("Set the theme footer structure, alignments, and also copyright.", 'hopeui'),
                'link' => admin_url('/customize.php?autofocus[panel]=footer')
            ),

        );
    }

    public function hopeui_php_esc_svg($html, $echo = true)
    {
        $svg_args = array(
            'svg'   => array(
                'class'           => true,
                'aria-hidden'     => true,
                'aria-labelledby' => true,
                'role'            => true,
                'xmlns'           => true,
                'width'           => true,
                'height'          => true,
                'viewbox'         => true // <= Must be lower case!
            ),
            'g'     => array('fill' => true),
            'title' => array('title' => true),
            'path'  => array(
                'd'               => true,
                'fill'            => true
            )
        );

        if ($echo) {
            echo wp_kses($html, $svg_args);
        } else {
            return wp_kses($html, $svg_args);
        }
    }
}
