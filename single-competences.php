<?php

defined('ABSPATH') or die('No direct script access allowed.');


/**
 * Template Name: Single Compétences
 *
 * @package foliobr
 */

get_header();

$competencesManager = new CompetencesManager();
while (have_posts()) : the_post();
  $progress_competence = get_post_meta(get_the_ID(), 'progress_competence', true);
  $competence_image_url = get_post_meta(get_the_ID(), 'competence_image', true);
  $term_name = $competencesManager->get_the_terms_by_id(get_the_ID(), 'categorie_competence');
  echo $competencesManager->get_competence_single_archives_html($competence_image_url, $progress_competence, $term_name);
endwhile;

get_footer();
