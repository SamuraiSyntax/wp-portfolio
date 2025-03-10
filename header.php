<?php

defined('ABSPATH') or die('No direct script access allowed.');

$contactManager = new ContactManager();
$modalContact = $contactManager->modalContact(); ?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="<?php echo esc_attr(get_bloginfo('description')); ?>">
  <title><?php echo esc_html(wp_get_document_title()); ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?> data-br-theme="dark">
  <div id="page" class="site page">

    <?php get_template_part('template-parts/header/navigation'); ?>

    <main id="content" class="site-content" role="main">
      <div id="loader">
        <div class="loader-icon"></div>
      </div>
      <?php echo $modalContact; ?>