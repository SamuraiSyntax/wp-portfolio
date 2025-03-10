<?php

defined('ABSPATH') or die('No direct script access allowed.');

// Ajouter un menu d'administration "Présentation"
function presentation_menu_page()
{
  add_menu_page(
    'Présentation',      // Titre de la page
    'Présentation',      // Titre du menu
    'manage_options',    // Capacité requise pour accéder à la page
    'presentation_settings', // Identifiant unique de la page
    'presentation_settings_page', // Fonction d'affichage de la page
    'dashicons-admin-settings', // Icône du menu
    20 // Position du menu
  );
}
add_action('admin_menu', 'presentation_menu_page');

// Ajouter les réglages de titre et description à la page de réglages
function presentation_settings_init()
{
  // Enregistrer les réglages
  register_setting('presentation_settings_group', 'titre_presentation');
  register_setting('presentation_settings_group', 'description_presentation');
  register_setting('presentation_settings_group', 'social_networks_data');

  // Ajouter une section pour les réglages de titre et description
  add_settings_section(
    'presentation_settings_section', // Identifiant de la section
    'Titre et Description', // Titre de la section
    'presentation_settings_section_callback', // Fonction de rappel pour la section
    'presentation_settings_page' // Page à laquelle ajouter la section
  );

  // Ajouter les champs de réglages de titre et description
  add_settings_field(
    'titre_presentation_field', // Identifiant du champ
    'Titre', // Libellé du champ
    'titre_presentation_field_callback', // Fonction de rappel pour le champ
    'presentation_settings_page', // Page à laquelle ajouter le champ
    'presentation_settings_section' // Section à laquelle ajouter le champ
  );

  add_settings_field(
    'description_presentation_field', // Identifiant du champ
    'Description', // Libellé du champ
    'description_presentation_field_callback', // Fonction de rappel pour le champ
    'presentation_settings_page', // Page à laquelle ajouter le champ
    'presentation_settings_section' // Section à laquelle ajouter le champ
  );

  // Ajouter les champs de réseaux sociaux
  add_settings_field(
    'social_networks_field', // Identifiant du champ
    'Réseaux Sociaux', // Libellé du champ
    'social_networks_section_callback', // Fonction de rappel pour le champ
    'presentation_settings_page', // Page à laquelle ajouter le champ
    'presentation_settings_section' // Section à laquelle ajouter le champ
  );
}
add_action('admin_init', 'presentation_settings_init');

// Afficher la page de réglages
function presentation_settings_page()
{
?>
  <div class="wrap">
    <h1>Réglages de la Présentation</h1>
    <form method="post" action="options.php">
      <?php settings_fields('presentation_settings_group'); ?>
      <?php do_settings_sections('presentation_settings_page'); ?>
      <?php submit_button('Enregistrer les réglages'); ?>
    </form>
  <?php
}

// Fonction de rappel pour la section de titre et description
function presentation_settings_section_callback()
{
  echo 'Personnalisez le titre et la description de la présentation.';
}

// Fonction de rappel pour le champ de titre
function titre_presentation_field_callback()
{
  $titre_presentation = get_option('titre_presentation');
  echo '<input type="text" name="titre_presentation" value="' . esc_attr($titre_presentation) . '" />';
}

// Fonction de rappel pour le champ de description
function description_presentation_field_callback()
{
  $description_presentation = get_option('description_presentation');
  echo '<textarea name="description_presentation" rows="5">' . esc_textarea($description_presentation) . '</textarea>';
}

function social_networks_section_callback()
{
  $social_networks_data = get_option('social_networks_data');

  // Tableau de données par défaut pour chaque réseau social
  $default_social_networks = array(
    'github' => array(
      'name' => 'Github',
      'link' => '',
      'image_light' => '',
      'image_dark' => '',
      'display' => false,
    ),
    'linkedin' => array(
      'name' => 'LinkedIn',
      'link' => '',
      'image' => '',
      'display' => false,
    ),
    'malt' => array(
      'name' => 'Malt',
      'link' => '',
      'image' => '',
      'display' => false,
    ),
    'lehibou' => array(
      'name' => 'LeHibou',
      'link' => '',
      'image' => '',
      'display' => false,
    ),
    'codeur' => array(
      'name' => 'Codeur',
      'link' => '',
      'image' => '',
      'display' => false,
    ),
    'upwork' => array(
      'name' => 'Upwork',
      'link' => '',
      'image' => '',
      'display' => false,
    ),
    'comeup' => array(
      'name' => 'ComeUp',
      'link' => '',
      'image' => '',
      'display' => false,
    ),
    'cremedelacreme' => array(
      'name' => 'Crème de la Crème',
      'link' => '',
      'image' => '',
      'display' => false,
    ),
    'freelancecom' => array(
      'name' => 'Freelance.com',
      'link' => '',
      'image' => '',
      'display' => false,
    ),
    'fiverr' => array(
      'name' => 'Fiverr',
      'link' => '',
      'image' => '',
      'display' => false,
    ),
    'comet' => array(
      'name' => 'Comet',
      'link' => '',
      'image' => '',
      'display' => false,
    ),
    // Ajoutez d'autres réseaux sociaux ici selon vos besoins
  );

  // Fusionner les données par défaut avec les données sauvegardées
  $social_networks_data = wp_parse_args($social_networks_data, $default_social_networks);

  // Afficher le tableau pour les réseaux sociaux
  echo '<table class="social-networks-table">';
  echo '<tr><th>Nom du Réseau Social</th><th>Lien du Profil</th><th>Image du Profil (Light)</th><th>Image du Profil (Dark)</th><th>Afficher</th></tr>';
  foreach ($social_networks_data as $key => $data) {
    echo '<tr>';
    echo '<td><input type="text" name="social_networks_data[' . esc_attr($key) . '][name]" value="' . esc_attr($data['name']) . '" /></td>';
    echo '<td><input type="text" name="social_networks_data[' . esc_attr($key) . '][link]" value="' . esc_attr($data['link']) . '" /></td>';
    if ($key === 'github') {
      echo '<td><input type="text" name="social_networks_data[' . esc_attr($key) . '][image_light]" value="' . esc_attr($data['image_light']) . '" />';
      echo '<input type="button" class="button button-primary upload-image-reseau" value="Uploader une image (light)" data-target="social_networks_data[' . esc_attr($key) . '][image_light]" /></td>';
      echo '<td><input type="text" name="social_networks_data[' . esc_attr($key) . '][image_dark]" value="' . esc_attr($data['image_dark']) . '" />';
      echo '<input type="button" class="button button-primary upload-image-reseau" value="Uploader une image (dark)" data-target="social_networks_data[' . esc_attr($key) . '][image_dark]" /></td>';
    } else {
      echo '<td><input type="text" name="social_networks_data[' . esc_attr($key) . '][image]" value="' . esc_attr($data['image']) . '" />';
      echo '<input type="button" class="button button-primary upload-image-reseau" value="Uploader une image" data-target="social_networks_data[' . esc_attr($key) . '][image]" /></td>';
      echo '<td></td>'; // Ajout d'une colonne vide pour les autres réseaux sociaux
    }
    echo '<td><input type="checkbox" name="social_networks_data[' . esc_attr($key) . '][display]" ' . (isset($data['display']) && $data['display'] ? 'checked' : '') . ' /></td>';
    echo '</tr>';
  }
  echo '</table>';
}
