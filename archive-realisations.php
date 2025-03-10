<?php

/**
 * Template Name: Archive Réalisations
 *
 * @package foliobr
 */

defined('ABSPATH') or die('No direct script access allowed.');

get_header();

if (have_posts()) :
  while (have_posts()) : the_post();
    get_template_part('template-parts/content', 'archive', array('archive_type' => 'realisations'));
  endwhile;
else :
  echo '<p>' . __('Aucune réalisation trouvée.', 'foliobr') . '</p>';
endif;

get_footer();
