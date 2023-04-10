<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package hopeui
 */

namespace HopeUI\Utility;
?>
<!doctype html>
<html <?php language_attributes(); ?> class="no-js">

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">

  <link rel="profile" href="<?php echo is_ssl() ? 'https:' : 'http:' ?>//gmpg.org/xfn/11">
  <?php wp_head(); ?>
 
</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>
  <?php get_template_part('template-parts/header/header'); ?>
  <?php get_template_part('template-parts/breadcrumb/breadcrumb'); ?>