<?php

/**
 * FolioBR-Manager.php
 */

defined('ABSPATH') or die('No direct script access allowed.');

require_once(get_template_directory(__FILE__) . '/inc/AjaxManager.php');
require_once(get_template_directory(__FILE__) . '/inc/Utils/IconManagerSVG.php');
require_once(get_template_directory(__FILE__) . '/inc/Admin/PagesSections.php');
require_once(get_template_directory(__FILE__) . '/inc/Admin/FrontPresentationManager.php');
require_once(get_template_directory(__FILE__) . '/inc/Menu/MenuManager.php');

require_once(get_template_directory(__FILE__) . '/inc/Contact/ContactManager.php');
require_once(get_template_directory(__FILE__) . '/inc/Competences/CompetencesManager.php');
require_once(get_template_directory(__FILE__) . '/inc/Realisations/RealisationsManager.php');

require_once(get_template_directory(__FILE__) . '/inc/Shortcodes/competences.php');
require_once(get_template_directory(__FILE__) . '/inc/Shortcodes/realisations.php');
require_once(get_template_directory(__FILE__) . '/inc/Shortcodes/presentation.php');
require_once(get_template_directory(__FILE__) . '/inc/Shortcodes/contact.php');

function miniature_html($cpt, $query, $class_section_minia, $meta_image)
{
  // Définir les attributs de data-item-index en fonction du type de miniature
  $data_item_index_attr = '';
  if ($cpt === 'competences') {
    $data_item_index_attr = 'data-comp-index';
  } elseif ($cpt === 'realisations') {
    $data_item_index_attr = 'data-real-index';
  }

  // Récupérer les URL des images mises en avant
  $images = array();
  if ($query->have_posts()) :
    while ($query->have_posts()) : $query->the_post();
      $image_url = get_post_meta(get_the_ID(), $meta_image, true);
      if (!empty($image_url)) {
        $images[] = $image_url;
      }
    endwhile;
  endif;
  wp_reset_postdata();

  ob_start(); ?>
  <div class="miniatures <?php echo esc_attr($class_section_minia); ?>">
    <a href="#" class="miniature" aria-label="Miniature information" <?php echo esc_attr($data_item_index_attr) . '="0"'; ?>>
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-home">
        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
        <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
        <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
        <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
      </svg>
    </a>
    <?php
    // Afficher les miniatures avec les données des images mises en avant
    foreach ($images as $index => $image_url) : ?>
      <a href="#" class="miniature" aria-label="Miniature <?php echo $index + 1; ?>" style="background-image: url('<?php echo esc_url($image_url); ?>');" <?php echo esc_attr($data_item_index_attr) . '="' . ($index + 1) . '"'; ?>></a>
    <?php endforeach; ?>
  </div>
<?php
  return ob_get_clean();
}

function breadcrumb_single_html($archive_page_link, $archive_page_title)
{
  ob_start(); ?>
  <div class="breadcrumb">
    <a class="homeLink" href="<?php echo esc_url(home_url()); ?>">
      Accueil
    </a>
    /
    <a class="archiveLink" href="<?php echo esc_url($archive_page_link); ?>">
      <?php echo esc_html($archive_page_title); ?>
    </a>
    /
    <span class="thisReal">
      <?php echo the_title(); ?>
    </span>
  </div>
<?php return ob_get_clean();
}

function navigation_single_html($cpt)
{
  // Récupérer les publications précédente et suivante
  $prev_post = get_adjacent_post(false, '', false);
  $next_post = get_adjacent_post(false, '', true);

  // Si la publication précédente n'existe pas, afficher la dernière publication
  if (!$prev_post) {
    $prev_post = get_posts(array(
      'post_type' => $cpt,
      'posts_per_page' => 1,
      'order' => 'ASC',
    ));
    $prev_post = $prev_post[0];
  }

  // Si la publication suivante n'existe pas, afficher la première publication
  if (!$next_post) {
    $next_post = get_posts(array(
      'post_type' => $cpt,
      'posts_per_page' => 1,
      'order' => 'DESC',
    ));
    $next_post = $next_post[0];
  }

  $navContainerClass = $cpt === 'realisations' ? 'navReal' : 'navComp';
  ob_start(); ?>
  <div class="<?php echo esc_attr($navContainerClass); ?>">
    <?php if ($prev_post) : ?>
      <a class="previous btn-primary" href="<?php echo get_permalink($prev_post); ?>">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left">
          <path stroke="none" d="M0 0h24v24H0z" fill="none" />
          <path d="M15 6l-6 6l6 6" />
        </svg>
        <?php echo get_the_title($prev_post); ?>
      </a>
    <?php endif; ?>
    <?php if ($next_post) : ?>
      <a class="next btn-primary" href="<?php echo get_permalink($next_post); ?>">
        <?php echo get_the_title($next_post); ?>
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-right">
          <path stroke="none" d="M0 0h24v24H0z" fill="none" />
          <path d="M9 6l6 6l-6 6" />
        </svg>
      </a>
    <?php endif; ?>
  </div>
<?php return ob_get_clean();
}
