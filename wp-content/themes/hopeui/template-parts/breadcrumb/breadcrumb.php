<?php

/**
 * Template part for displaying the Breadcrumb 
 *
 * @package hopeui
 */

namespace HopeUI\Utility;

$is_breadcrumb = hopeui()->is_hopeui_php_breadcrumb();
if ($is_breadcrumb) hopeui()->hopeui_php_breadcrumb();
