<?php

defined('ABSPATH') or die('No direct script access allowed.');


/**
 * Template Name: Single Réalisations
 *
 * @package foliobr
 */

get_header();

$realisationsManager = new RealisationsManager();
while (have_posts()) : the_post();
  $lien_du_projet = get_post_meta(get_the_ID(), 'lien_du_projet', true);
  $annee_realisation = get_post_meta(get_the_ID(), 'annee_realisation', true);
  $role_tenu = get_post_meta(get_the_ID(), 'role_tenu', true);
  $terms_type_projet = get_the_terms(get_the_ID(), 'type_projet');
  $terms_technologie = get_the_terms(get_the_ID(), 'technologie');
  $image_projet = get_post_meta(get_the_ID(), 'image_projet', true);
  echo $realisationsManager->get_realisation_single_archives_html($lien_du_projet, $annee_realisation, $role_tenu, $terms_type_projet, $terms_technologie, $image_projet);
endwhile;

get_footer();
