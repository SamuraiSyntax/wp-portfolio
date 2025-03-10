<?php

defined('ABSPATH') or die('No direct script access allowed.');

class CompetencesManager
{
  public function foliobr_register_post_types_and_taxonomies_competences()
  {
    $labelsCompetences = array(
      'name'               => __('Compétences', 'foliobr'),
      'singular_name'      => __('Compétence', 'foliobr'),
      'menu_name'          => __('Compétences', 'foliobr'),
      'add_new'            => __('Ajouter une compétence', 'foliobr'),
      'add_new_item'       => __('Ajouter une nouvelle compétence', 'foliobr'),
      'edit_item'          => __('Modifier la compétence', 'foliobr'),
      'new_item'           => __('Nouvelle compétence', 'foliobr'),
      'view_item'          => __('Voir la compétence', 'foliobr'),
      'search_items'       => __('Rechercher une compétence', 'foliobr'),
      'not_found'          => __('Aucune compétence trouvée', 'foliobr'),
      'not_found_in_trash' => __('Aucune compétence trouvée dans la corbeille', 'foliobr'),
      'archives'           => __('Archives des compétences', 'foliobr'),
    );

    // Tableau associatif des CPT et leurs arguments
    $post_types = array(
      'competences' => array(
        'label' => $labelsCompetences,
        'menu_icon' => 'dashicons-welcome-learn-more',
        'supports' => array(
          'title',           // Titre
          'editor',          // Éditeur de contenu
          'thumbnail',       // Image mise en avant
          'excerpt',         // Extrait
          'trackbacks',      // Références croisées
          'custom-fields',   // Champs personnalisés
          'revisions',       // Révisions
          'page-attributes', // Attributs de page (pour l'ordre)
          'post-formats'     // Formats de publication
        ),
        'taxonomies' => array('categorie_competence'),
        'has_archive' => true,       // Activer les archives
        'public' => true,
        'show_in_rest' => true,      // Activer l'accès REST API
        'show_in_nav_menus' => true, // Permettre l'ajout au menu
      ),
    );

    // Tableau associatif des taxonomies et leurs arguments
    $taxonomies = array(
      'categorie_competence' => array(
        'label' => __('Catégories de compétence', 'foliobr'),
        'post_type' => 'competences',
        'hierarchical' => true,
      ),
    );

    // Enregistrement des CPT
    foreach ($post_types as $post_type => $args) {
      $default_args = array(
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => $post_type),
        'capability_type'    => 'post',
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => $args['supports'],
        'menu_icon'          => $args['menu_icon'],
        'labels'             => $args['label'],
      );

      $args = wp_parse_args($args, $default_args);

      register_post_type($post_type, $args);

      // Enregistrement des taxonomies liées aux CPT
      if (isset($args['taxonomies']) && is_array($args['taxonomies'])) {
        foreach ($args['taxonomies'] as $taxonomy) {
          register_taxonomy_for_object_type($taxonomy, $post_type);
        }
      }
    }

    // Enregistrement des taxonomies
    foreach ($taxonomies as $taxonomy => $args) {
      $default_args = array(
        'public'            => true,
        'hierarchical'      => $args['hierarchical'],
        'labels'            => $args['label'],
      );

      $args = wp_parse_args($args, $default_args);

      register_taxonomy($taxonomy, $args['post_type'], $args);
    }

    register_meta('post', 'mise_en_avant', array(
      'type' => 'boolean',
      'description' => 'Mise en avant de la compétence',
      'single' => true,
      'show_in_rest' => true,
    ));

    // Enregistrement du champ de métadonnées pour la progression de compétence
    register_meta('post', 'progress_competence', array(
      'type' => 'integer',
      'description' => 'Progression de la compétence',
      'single' => true,
      'show_in_rest' => true,
    ));
  }

  // Fonction pour ajouter les colonnes personnalisées
  public function add_custom_columns($columns)
  {
    $new_columns = array(
      'cb' => $columns['cb'],
      'title' => __('Title'),
      'competence_image' => __('Image de la compétence'),
      'progress_competence' => __('Progression de la compétence'),
      'date' => __('Date'),
      'modified' => __('Last Modified'),
    );

    return $new_columns;
  }

  // Fonction pour afficher le contenu des colonnes personnalisées
  public function render_custom_columns($column_name, $post_id)
  {
    switch ($column_name) {
      case 'progress_competence':
        $progress_competence = get_post_meta($post_id, 'progress_competence', true);
        echo esc_html($progress_competence) . '%';
        break;

      case 'competence_image':
        $image_url = get_post_meta($post_id, 'competence_image', true);
        if (!empty($image_url)) {
          echo '<img src="' . esc_url($image_url) . '" alt="Image de la compétence" style="max-width: 100px; height: auto;">';
        } else {
          echo '-';
        }
        break;

      default:
        break;
    }
  }

  // Fonction pour rendre les colonnes triables
  public function make_columns_sortable($columns)
  {
    $columns['progress_competence'] = 'progress_competence'; // Le nom de la colonne doit être identique à celui utilisé dans la fonction add_custom_columns
    return $columns;
  }

  // Fonction pour trier les colonnes en fonction de la progression de la compétence
  public function custom_column_orderby($query)
  {
    if (!is_admin()) {
      return;
    }

    $orderby = $query->get('orderby');

    if ('progress_competence' == $orderby) {
      $query->set('meta_key', 'progress_competence');
      $query->set('orderby', 'meta_value_num');
    }
  }

  // Initialisation de la classe
  public function init()
  {
    // Enregistrement des colonnes personnalisées
    add_filter('manage_competences_posts_columns', array($this, 'add_custom_columns'));

    // Affichage du contenu des colonnes personnalisées
    add_action('manage_competences_posts_custom_column', array($this, 'render_custom_columns'), 10, 2);

    // Rendre les colonnes triables
    add_filter('manage_edit-competences_sortable_columns', array($this, 'make_columns_sortable'));

    // Personnaliser le tri pour la colonne "progress_competence"
    add_action('pre_get_posts', array($this, 'custom_column_orderby'));
  }

  public function add_mise_en_avant_competence_meta_box()
  {
    add_meta_box(
      'mise_en_avant_competence_meta_box', // ID unique du meta box
      __('Mise en avant de la compétence', 'foliobr'), // Titre du meta box
      array($this, 'render_mise_en_avant_competence_meta_field'), // Fonction pour afficher le champ
      'competences', // Type de contenu où afficher le meta box
      'normal', // Contexte (normal, side, advanced)
      'high' // Priorité (high, core, default, low)
    );
  }

  public function render_mise_en_avant_competence_meta_field()
  {
    global $post;
    // Récupérer la valeur actuelle du champ de métadonnées
    $mise_en_avant = get_post_meta($post->ID, 'mise_en_avant', true); ?>
    <label for="mise_en_avant"><?php _e('Mise en avant de la compétence :', 'foliobr'); ?></label>
    <input type="checkbox" id="mise_en_avant" name="mise_en_avant" <?php checked($mise_en_avant, 'on'); ?>>
    <p><?php _e('Cochez cette case pour mettre en avant cette compétence.', 'foliobr'); ?></p>
  <?php
  }

  public function save_mise_en_avant_competence_meta_field($post_id)
  {
    // Vérifier les autorisations
    if (!current_user_can('edit_post', $post_id)) {
      return;
    }

    // Vérifier si la case est cochée
    $mise_en_avant = isset($_POST['mise_en_avant']) ? 'on' : 'off';

    // Enregistrer la valeur du champ
    update_post_meta($post_id, 'mise_en_avant', $mise_en_avant);
  }

  public function add_progress_competence_meta_box()
  {
    add_meta_box(
      'progress_competence_meta_box', // ID unique du meta box
      __('Progression de la compétence', 'foliobr'), // Titre du meta box
      array($this, 'render_progress_competence_meta_field'), // Fonction pour afficher le champ
      'competences', // Type de contenu où afficher le meta box
      'normal', // Contexte (normal, side, advanced)
      'high' // Priorité (high, core, default, low)
    );
  }

  public function render_progress_competence_meta_field()
  {
    global $post;
    // Récupérer la valeur actuelle du champ de métadonnées
    $progress_competence = get_post_meta($post->ID, 'progress_competence', true);
    $image_url = get_post_meta($post->ID, 'competence_image', true); ?>
    <label for="progress_competence"><?php _e('Progression de la compétence :', 'foliobr'); ?></label>
    <span id="progress_competence_value"><?php echo esc_attr($progress_competence); ?></span>
    <input type="range" id="progress_competence" name="progress_competence" value="<?php echo esc_attr($progress_competence); ?>" min="0" max="100" step="1">
    <label for="competence_image"><?php _e('Image de la compétence :', 'foliobr'); ?></label>
    <input type="text" id="competence_image" name="competence_image" value="<?php echo esc_attr($image_url); ?>" style="width: 100%;">
    <?php if (!empty($image_url)) : ?>
      <img src="<?php echo esc_url($image_url); ?>" alt="Image de la compétence" style="width: 100px; height: auto; margin-top: 10px;">
    <?php endif; ?>
    <button id="upload_image_button_competence" class="button"><?php _e('Upload Image', 'foliobr'); ?></button>
    <script>
      jQuery(document).ready(function($) {
        // Initialiser la valeur visible avec la valeur actuelle du slider
        $('#progress_competence_value').text($('#progress_competence').val());

        var custom_uploader_competence;
        $('#upload_image_button_competence').click(function(e) {
          e.preventDefault();
          if (custom_uploader_competence) {
            custom_uploader_competence.open();
            return;
          }
          custom_uploader_competence = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
              text: 'Choose Image'
            },
            multiple: false
          });
          custom_uploader_competence.on('select', function() {
            var attachment = custom_uploader_competence.state().get('selection').first().toJSON();
            $('#competence_image').val(attachment.url);
          });
          custom_uploader_competence.open();
        });

        // Utiliser l'événement input pour mettre à jour la valeur visible en temps réel
        $('#progress_competence').on('input', function() {
          var newValue = $(this).val();
          $('#progress_competence_value').text(newValue);
        });
      });
    </script>
  <?php
  }

  public function save_progress_competence_meta_field($post_id)
  {
    // Vérifier les autorisations
    if (!current_user_can('edit_post', $post_id)) {
      return;
    }

    // Vérifier si la valeur est définie
    if (isset($_POST['progress_competence'])) {
      // Nettoyer la valeur et enregistrer la métadonnée
      $progress_competence = sanitize_text_field($_POST['progress_competence']);
      update_post_meta($post_id, 'progress_competence', $progress_competence);
    }

    // Enregistrer l'URL de l'image
    if (isset($_POST['competence_image'])) {
      $image_url = sanitize_text_field($_POST['competence_image']);
      update_post_meta($post_id, 'competence_image', $image_url);
    }
  }

  public function get_competences_theme_options()
  {
    $theme_options = array(
      'archive_title' => get_theme_mod('archive_title_competences', ''),
      'archive_description' => get_theme_mod('archive_description_competences', ''),
      'archive_link' => get_theme_mod('archive_link_competences_text', ''),
    );
    return $theme_options;
  }

  public function get_the_terms_by_id($post_id, $taxonomy)
  {
    $terms = get_the_terms($post_id, $taxonomy);
    $term_names = array();

    if ($terms && !is_wp_error($terms)) {
      foreach ($terms as $term) {
        $term_names[] = $term->name;
      }
      return implode(', ', $term_names);
    }

    return '';
  }

  public function customizer_competences_theme_options($wp_customize)
  {
    // Section pour les options de thème des compétences
    $wp_customize->add_section('competences_theme_options', array(
      'title' => __('Compétences', 'foliobr'),
      'priority' => 30,
    ));

    // Titre de la page d'archive des compétences
    $wp_customize->add_setting('archive_title_competences', array(
      'default' => '',
      'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('archive_title_competences', array(
      'label' => __('Titre de l\'archive', 'foliobr'),
      'section' => 'competences_theme_options',
      'type' => 'text',
    ));

    // Description de la page d'archive des compétences
    $wp_customize->add_setting('archive_description_competences', array(
      'default' => '',
      'sanitize_callback' => 'wp_kses_post', // Utilisation de wp_kses_post pour autoriser les balises HTML
    ));
    $wp_customize->add_control('archive_description_competences', array(
      'label' => __('Description de l\'archive', 'foliobr'),
      'section' => 'competences_theme_options',
      'type' => 'textarea', // Changement du type de contrôle en textarea
    ));

    // Lien vers la page d'archive des compétences
    $wp_customize->add_setting('archive_link_competences_text', array(
      'default' => '',
      'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('archive_link_competences_text', array(
      'label' => __('Lien vers l\'archive', 'foliobr'),
      'section' => 'competences_theme_options',
      'type' => 'text',
    ));
  }

  public function boucle_cpt_competences($args)
  {
    ob_start(); ?>
    <?php $competences_query = new WP_Query($args);
    if ($competences_query->have_posts()) :
      while ($competences_query->have_posts()) : $competences_query->the_post();
        $progress_competence = get_post_meta(get_the_ID(), 'progress_competence', true);
        $competence_image_url = get_post_meta(get_the_ID(), 'competence_image', true);
        $term_name = $this->get_the_terms_by_id(get_the_ID(), 'categorie_competence');
        echo $this->get_competence_archives_html($competence_image_url, $progress_competence, $term_name);
      endwhile;
      wp_reset_postdata(); ?>
    <?php else : ?>
      <p>Aucune compétence trouvée.</p>
    <?php endif;
    return ob_get_clean();
  }

  public function get_competence_archives_html($competence_image_url, $progress_competence, $term_name)
  {
    ob_start(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class('section archive-content competences-list'); ?>>
      <a class="card" href="<?php the_permalink(); ?>">
        <h2 class="card-title">
          <?php the_title(); ?>
        </h2>
        <img src="<?php echo esc_url($competence_image_url); ?>" class="card-image" alt="">
        <div class="card-description">
          <?php echo wp_trim_words(get_the_content(), 20); ?>
        </div>
        <div class="card-description">
          <?php echo esc_html($term_name); ?>
        </div>
        <div class="progress-container">
          <progress value="<?php echo $progress_competence; ?>" max="100" class="progress-bar"></progress>
          <span class="progress-value"><?php echo $progress_competence; ?>%</span>
        </div>
      </a>
    </article>
  <?php
    return ob_get_clean();
  }

  public function get_competence_single_archives_html($competence_image_url, $progress_competence, $term_name)
  {
    // Récupérer le titre et le lien de la page des réalisations
    $archive_page_title = 'Compétences';
    $archive_page_link = get_post_type_archive_link('competences');

    ob_start(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class('section single-archive-content competences-single'); ?>>

      <?php echo breadcrumb_single_html($archive_page_link, $archive_page_title); ?>

      <div class="card">
        <h2 class="comp-title">
          <?php the_title(); ?>
        </h2>
        <img src="<?php echo esc_url($competence_image_url); ?>" class="card-image" alt="">
        <div class="card-content">
          <?php the_content(); ?>
        </div>
        <div class="card-description">
          <?php echo esc_html($term_name); ?>
        </div>
        <div class="progress-container">
          <progress value="<?php echo $progress_competence; ?>" max="100" class="progress-bar"></progress>
          <span class="progress-value"><?php echo $progress_competence; ?>%</span>
        </div>
      </div>

      <?php echo navigation_single_html('competences'); ?>

    </article>
    <?php
    return ob_get_clean();
  }

  public function get_competences_html($query)
  {
    // Construction du HTML des compétences
    ob_start();
    if ($query->have_posts()) :
      while ($query->have_posts()) : $query->the_post();
        // Récupérer l'URL de l'image de la compétence
        $image_url = get_post_meta(get_the_ID(), 'competence_image', true);
        $progress_competence = get_post_meta(get_the_ID(), 'progress_competence', true); ?>
        <a href="<?php the_permalink(); ?>" class="card card-comp" aria-label="<?php the_title_attribute(); ?>">
          <?php if (!empty($image_url)) : ?>
            <img src="<?php echo esc_url($image_url); ?>" class="card-image" alt="">
          <?php endif; ?>
          <div class="progress-container">
            <progress value="<?php echo $progress_competence; ?>" max="100" class="progress-bar"></progress>
            <span class="progress-value"><?php echo $progress_competence; ?>%</span>
          </div>
        </a>
<?php endwhile;
    else :
      echo '<p>Aucune compétence trouvée.</p>';
    endif;
    return ob_get_clean();
  }
}
