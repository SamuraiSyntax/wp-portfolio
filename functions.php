<?php

defined('ABSPATH') or die('No direct script access allowed.');

require_once(get_template_directory(__FILE__) . '/inc/FolioBRManager.php');

/**
 * Fonction pour enregistrer les styles et les scripts du thème.
 */
function foliobr_enqueue_scripts()
{
  $theme = wp_get_theme();
  global $version;
  $version = $theme->get('Version');

  // Styles
  wp_enqueue_style('tabler-icon', 'https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css');
  wp_enqueue_style('google-font-jura', 'https://fonts.googleapis.com/css2?family=Jura:wght@300..700&display=swap');
  wp_enqueue_style('foliobr-style', get_template_directory_uri() . '/assets/css/style.css', array(), $version);

  // jQuery is a dependency for wp-mediaelement
  wp_enqueue_script('jquery');

  // Lightbox WordPress
  wp_enqueue_script('wp-mediaelement');

  // Get social networks data from options
  $social_networks_data = get_option('social_networks_data', array());

  // Prepare localized data for scripts
  $localized_data = array(
    'themeMoon' => (new IconManagerSVG())->ThemeMoon(),
    'themeSun' => (new IconManagerSVG())->ThemeSun(),
    'archive_link_competences' => esc_url(get_post_type_archive_link('competences')),
  );

  // Loop through social networks data to add image URLs to localized data
  if (is_array($social_networks_data)) {
    foreach ($social_networks_data as $network => $data) {
      if (!empty($data['image_light']) && !empty($data['image_dark'])) {
        $localized_data[$network . 'IconLight'] = $data['image_light'];
        $localized_data[$network . 'IconDark'] = $data['image_dark'];
      }
    }
  }

  // Scripts
  $scripts = array(
    'Init' => array(
      'src' => '/assets/js/Init.js',
      'localize' => array(
        'ajax_object' => $localized_data,
      ),
    ),
  );

  // Enqueue scripts with localized data
  foreach ($scripts as $script => $args) {
    $src = is_array($args) && isset($args['src']) ? $args['src'] : '/assets/js/' . $script . '.js';
    $localize = is_array($args) && isset($args['localize']) ? $args['localize'] : array();

    wp_enqueue_script('foliobr-' . $script, get_template_directory_uri() . $src, array('jquery'), $version, true);

    if (!empty($localize)) {
      wp_localize_script('foliobr-' . $script, 'ajax_object', $localize);
    }

    wp_script_add_data('foliobr-' . $script, 'async', true);
  }
}
add_action('wp_enqueue_scripts', 'foliobr_enqueue_scripts');

function foliobr_admin_enqueue_scripts()
{
  $theme = wp_get_theme();
  $version = $theme->get('Version');

  wp_enqueue_style('tabler-icon', 'https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css');
  wp_enqueue_style('google-font-jura', 'https://fonts.googleapis.com/css2?family=Jura:wght@300..700&display=swap');
  wp_enqueue_style('foliobr-admin-style', get_template_directory_uri() . '/assets/admin/admin.css', array(), $version);
  wp_enqueue_script('foliobr-admin-script', get_template_directory_uri() . '/assets/admin/admin.js', array('jquery'), $version, true);
  wp_enqueue_script('jquery-ui-sortable');
  wp_enqueue_media();

  $competencesManager = new CompetencesManager();
  $competencesManager->init();
}
add_action('admin_enqueue_scripts', 'foliobr_admin_enqueue_scripts');

function foliobr_register_menus()
{
  register_nav_menus(array(
    'menu-header' => __('Navigation Header', 'foliobr'),
    'menu-footer' => __('Navigation Footer', 'foliobr'),
  ));
}
add_action('after_setup_theme', 'foliobr_register_menus');

function add_modal_link_to_menu($items, $args)
{
  // Vérifiez si le menu est celui que vous souhaitez modifier
  if ($args->theme_location == 'menu-header') {
    // Ajoutez votre lien après les éléments de menu
    $items .= '<li><a href="#modalContact" data-modal="#modalContact">Contact</a></li>';
  }
  return $items;
}
add_filter('wp_nav_menu_items', 'add_modal_link_to_menu', 10, 2);

function custom_theme_options_customizer_register($wp_customize)
{
  $realisationsManager = new RealisationsManager();
  $realisationsManager->customizer_realisations_theme_options($wp_customize);

  $competencesManager = new CompetencesManager();
  $competencesManager->customizer_competences_theme_options($wp_customize);
}
add_action('customize_register', 'custom_theme_options_customizer_register');

// Fonction pour ajouter le type MIME SVG aux types de fichiers autorisés
function foliobr_allow_svg_upload($mimes)
{
  $mimes['svg'] = 'image/svg+xml'; // Ajouter le type MIME SVG
  return $mimes;
}
add_filter('upload_mimes', 'foliobr_allow_svg_upload');

// Enregistrement des types de publication et des taxonomies pour les réalisations et les compétences
function foliobr_register_post_types_and_taxonomies()
{
  // Enregistrer les types de publication et les taxonomies pour les réalisations
  $realisationsManager = new RealisationsManager();
  $realisationsManager->foliobr_register_post_types_and_taxonomies_realisations();

  // Enregistrer les types de publication et les taxonomies pour les compétences
  $competencesManager = new CompetencesManager();
  $competencesManager->foliobr_register_post_types_and_taxonomies_competences();
}
add_action('init', 'foliobr_register_post_types_and_taxonomies');

function foliobr_add_realisations_meta_boxes()
{
  $realisationsManager = new RealisationsManager();
  $realisationsManager->add_meta_box_realisations();
}
add_action('add_meta_boxes', 'foliobr_add_realisations_meta_boxes');

function foliobr_save_realisations_meta($post_id)
{
  $realisationsManager = new RealisationsManager();
  $realisationsManager->save_realisations_meta($post_id);
}
add_action('save_post_realisations', 'foliobr_save_realisations_meta');

// Ajouter les meta boxes pour les compétences
function foliobr_add_competences_meta_boxes()
{
  $competencesManager = new CompetencesManager();
  $competencesManager->add_mise_en_avant_competence_meta_box();
  $competencesManager->add_progress_competence_meta_box();
}
add_action('add_meta_boxes', 'foliobr_add_competences_meta_boxes');

// Sauvegarder les métadonnées pour les compétences
function foliobr_save_competences_meta($post_id)
{
  $competencesManager = new CompetencesManager();
  $competencesManager->save_mise_en_avant_competence_meta_field($post_id);
  $competencesManager->save_progress_competence_meta_field($post_id);
}
add_action('save_post_competences', 'foliobr_save_competences_meta');
