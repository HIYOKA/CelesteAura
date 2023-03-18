<?php

/**
 * Template part for displaying the Cast 
 *
 * @package hopeui
 */

namespace HopeUI\Utility;


if (!defined('ABSPATH')) {
    exit;
}
extract($args);
if (empty($tabs) || !is_array($tabs)) {
    return;
}
$class = isset($class) ? $class : '';

$default_active_tab = empty($default_active_tab) ? 0 : $default_active_tab;
$tab_uniqid = 'tab-' . uniqid();

uasort($tabs, function ($a, $b) {
    if (!isset($a['priority'], $b['priority']) || $a['priority'] === $b['priority']) {
        return 0;
    }
    return ($a['priority'] < $b['priority']) ? -1 : 1;
});


?>
<div class="tab-bottom-bordered<?php echo esc_attr($class); ?>">
    <ul class="nav nav-pills nav-tabs" role="tablist">
        <?php foreach ($tabs as $key => $tab) :
            if (!is_numeric($key) && !$default_active_tab) {
                $default_active_tab = $key;
            }
            $is_active =  $key == $default_active_tab ?  esc_attr(' active show') : '';
            $tab_id = $tab_uniqid . $key;
        ?>
            <li class="nav-item mb-0" role="presentation">
                <button data-bs-target="#<?php echo esc_attr($tab_id); ?>" data-bs-toggle="pill" class="nav-link ml-0 <?php echo esc_attr($is_active) ?>">
                    <?php echo wp_kses_post($tab['title']); ?>
                </button>
            </li>
        <?php endforeach; ?>
    </ul>
    <div class="tab-content">
        <?php foreach ($tabs as $key => $tab) :
            $tab_id = $tab_uniqid . $key;
            $is_active =  $key == $default_active_tab ?  esc_attr(' active show') : '';
        ?>
            <div id="<?php echo esc_attr($tab_id); ?>" class="tab-pane fade<?php echo esc_attr($is_active) ?>">
                <?php
                if (isset($tab['callback'])) {
                    call_user_func($tab['callback'], array('post_type' => $key), $tab);
                } elseif (!empty($tab['content'])) {
                    echo wp_kses_post($tab['content']);
                }
                ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>