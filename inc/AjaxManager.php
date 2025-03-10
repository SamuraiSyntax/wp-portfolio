<?php

defined('ABSPATH') or die('No direct script access allowed.');

function load_competences_by_ajax()
{
  $categorie = isset($_POST['competence_category']) ? $_POST['competence_category'] : '';
  $orderby = isset($_POST['orderby']) ? $_POST['orderby'] : '';
  $order = isset($_POST['order']) ? $_POST['order'] : '';

  $tax_query = array();
  if ($categorie) {
    $tax_query[] = array(
      'taxonomy' => 'categorie_competence',
      'field'    => 'slug',
      'terms'    => $categorie
    );
  }

  $args = array(
    'post_type' => 'competences',
    'posts_per_page' => -1,
    'orderby' => $orderby,
    'order' => $order,
  );

  $competences_query = new WP_Query($args);
  $competencesManager = new CompetencesManager();
  echo $competencesManager->boucle_cpt_competences($competences_query);
  wp_die();
}
add_action('wp_ajax_load_competences_by_ajax', 'load_competences_by_ajax');
add_action('wp_ajax_nopriv_load_competences_by_ajax', 'load_competences_by_ajax');
