<?php

/**
 * Template part for displaying the header search
 *
 * @package hopeui
 */

namespace HopeUI\Utility;

?>
<form id="header-search-form" method="get" class="search-form search__form" action="<?php echo esc_url(home_url('/')); ?>">
    <div class="form-search">
        <input type="search" name='s' value="<?php get_search_query() ?>" class="search-input ajax_search_input" placeholder="<?php echo esc_attr(get_theme_mod('hopeui_php_search_placeholder',__('Search','hopeui'))); ?>">
        <button type="button" class="search-submit ajax_search_input">
            <i class="fa fa-search" aria-hidden="true"></i>
        </button>
    </div>
</form>