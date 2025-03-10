<?php

defined('ABSPATH') or die('No direct script access allowed.');

class RealisationsManager
{
  public function foliobr_register_post_types_and_taxonomies_realisations()
  {
    $labelsRealisations = array(
      'name'               => __('Réalisations', 'foliobr'),
      'singular_name'      => __('Réalisation', 'foliobr'),
      'menu_name'          => __('Réalisations', 'foliobr'),
      'add_new'            => __('Ajouter une réalisation', 'foliobr'),
      'add_new_item'       => __('Ajouter une nouvelle réalisation', 'foliobr'),
      'edit_item'          => __('Modifier la réalisation', 'foliobr'),
      'new_item'           => __('Nouvelle réalisation', 'foliobr'),
      'view_item'          => __('Voir la réalisation', 'foliobr'),
      'search_items'       => __('Rechercher une réalisation', 'foliobr'),
      'not_found'          => __('Aucune réalisation trouvée', 'foliobr'),
      'not_found_in_trash' => __('Aucune réalisation trouvée dans la corbeille', 'foliobr'),
      'featured_image'        => __('Image mise en avant', 'foliobr'),
      'set_featured_image'    => __('Définir l’image mise en avant', 'foliobr'),
      'remove_featured_image' => __('Supprimer l’image mise en avant', 'foliobr'),
      'use_featured_image'    => __('Utiliser comme image mise en avant', 'foliobr'),
      'archives'              => __('Archives des réalisations', 'foliobr'),
    );

    // Tableau associatif des CPT et leurs arguments
    $post_types = array(
      'realisations' => array(
        'label' => $labelsRealisations,
        'menu_icon' => 'dashicons-portfolio',
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
        'taxonomies' => array('type_projet', 'technologie'),
        'has_archive' => true,       // Activer les archives
        'public' => true,
        'show_in_rest' => true,      // Activer l'accès REST API
        'show_in_nav_menus' => true, // Permettre l'ajout au menu
      ),
    );

    // Tableau associatif des taxonomies et leurs arguments
    $taxonomies = array(
      'type_projet' => array(
        'label' => __('Types de projet', 'foliobr'),
        'post_type' => 'realisations',
        'hierarchical' => true,
      ),
      'technologie' => array(
        'label' => __('Technologies', 'foliobr'),
        'post_type' => 'realisations',
        'hierarchical' => true,
      ),
      'competences_assign' => array(
        'label' => __('Compétences', 'foliobr'),
        'post_type' => 'realisations',
        'hierarchical' => false,
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

    // Enregistrement des métadonnées de publication
    register_meta('post', 'lien_du_projet', array(
      'type' => 'string',
      'description' => 'Lien du projet',
      'single' => true,
      'show_in_rest' => true,
    ));
    register_meta('post', 'annee_realisation', array(
      'type' => 'integer',
      'description' => 'Année de réalisation',
      'single' => true,
      'show_in_rest' => true,
    ));
    register_meta('post', 'role_tenu', array(
      'type' => 'string',
      'description' => 'Rôle tenu',
      'single' => true,
      'show_in_rest' => true,
    ));
  }

  // Récupérer les options de thème depuis le Customizer
  public function get_realisation_theme_options()
  {
    $theme_options = array(
      'archive_title' => get_theme_mod('archive_title_realisations', ''),
      'archive_description' => get_theme_mod('archive_description_realisations', ''),
      'archive_link' => get_theme_mod('archive_link_realisations_text', ''),
    );
    return $theme_options;
  }

  public function customizer_realisations_theme_options($wp_customize)
  {
    // Section pour les options de thème des réalisations
    $wp_customize->add_section('realisation_theme_options', array(
      'title' => __('Réalisations', 'foliobr'),
      'priority' => 30,
    ));

    // Titre de la page d'archive des réalisations
    $wp_customize->add_setting('archive_title_realisations', array(
      'default' => '',
      'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('archive_title_realisations', array(
      'label' => __('Titre de l\'archive', 'foliobr'),
      'section' => 'realisation_theme_options',
      'type' => 'text',
    ));

    // Description de la page d'archive des réalisations
    $wp_customize->add_setting('archive_description_realisations', array(
      'default' => '',
      'sanitize_callback' => 'wp_kses_post', // Utilisation de wp_kses_post pour autoriser les balises HTML
    ));
    $wp_customize->add_control('archive_description_realisations', array(
      'label' => __('Description de l\'archive', 'foliobr'),
      'section' => 'realisation_theme_options',
      'type' => 'textarea', // Changement du type de contrôle en textarea
    ));

    // Lien vers la page d'archive des réalisations
    $wp_customize->add_setting('archive_link_realisations_text', array(
      'default' => '',
      'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('archive_link_realisations_text', array(
      'label' => __('Lien vers l\'archive', 'foliobr'),
      'section' => 'realisation_theme_options',
      'type' => 'text',
    ));
  }

  public function add_meta_box_realisations()
  {
    add_meta_box(
      'competences_metabox',
      __('Compétences', 'foliobr'),
      array($this, 'foliobr_competences_metabox_callback'),
      'realisations', // Type de publication concerné
      'side',
      'high'
    );
    add_meta_box(
      'realisations_meta_box',
      __('Détails de la réalisation', 'foliobr'),
      array($this, 'foliobr_render_realisations_meta_box'),
      'realisations',
      'side',
      'high'
    );
  }

  public function save_realisations_meta($post_id)
  {
    if (!current_user_can('edit_post', $post_id)) {
      return;
    }

    // Mettre à jour les compétences sélectionnées
    if (isset($_POST['competences']) && is_array($_POST['competences'])) {
      $competences = array_map('intval', $_POST['competences']);
      update_post_meta($post_id, 'competences_assign', $competences);
    } else {
      delete_post_meta($post_id, 'competences_assign');
    }

    // Mettre à jour les métadonnées des réalisations
    $meta_fields = array(
      'lien_du_projet' => 'lien_du_projet_field',
      'annee_realisation' => 'annee_realisation_field',
      'role_tenu' => 'role_tenu_field',
      'image_projet' => 'image_projet_field'
    );

    foreach ($meta_fields as $meta_key => $field_name) {
      if (isset($_POST[$field_name])) {
        update_post_meta($post_id, $meta_key, sanitize_text_field($_POST[$field_name]));
      }
    }
  }

  public function foliobr_competences_metabox_callback($post)
  {
    // Récupérer les compétences associées à cette réalisation
    $competences_selected = get_post_meta($post->ID, 'competences_assign', true);

    // Vérifier si $competences_selected est une chaîne vide, si c'est le cas, initialiser en tant que tableau vide
    if (empty($competences_selected)) {
      $competences_selected = array();
    }

    // Récupérer les compétences disponibles à partir du type de publication compétences
    $args = array(
      'post_type' => 'competences', // Type de publication pour les compétences
      'posts_per_page' => -1, // Récupérer toutes les compétences
    );

    $competences_query = new WP_Query($args);

    // Vérifier si des compétences ont été trouvées
    if ($competences_query->have_posts()) {
      while ($competences_query->have_posts()) {
        $competences_query->the_post();
        $competence_id = get_the_ID();
        $competence_name = get_the_title(); ?>
        <label>
          <input type="checkbox" name="competences[]" value="<?php echo esc_attr($competence_id); ?>" <?php checked(in_array($competence_id, $competences_selected)); ?>>
          <?php echo esc_html($competence_name); ?>
        </label>
        <br>
      <?php }
      // Réinitialiser la requête post
      wp_reset_postdata();
    }
  }

  public function foliobr_render_realisations_meta_box($post)
  {
    // Récupérer les valeurs actuelles des métadonnées
    $meta_fields = array(
      'lien_du_projet' => __('Lien du projet', 'foliobr'),
      'annee_realisation' => __('Année de réalisation', 'foliobr'),
      'role_tenu' => __('Rôle tenu', 'foliobr'),
      'image_projet' => __('Image de présentation du projet', 'foliobr')
    );

    foreach ($meta_fields as $meta_key => $meta_label) {
      $meta_value = get_post_meta($post->ID, $meta_key, true); ?>

      <!-- Affichage des champs pour les métadonnées -->
      <label for="<?php echo esc_attr($meta_key . '_field'); ?>"><?php echo esc_html($meta_label); ?></label>
      <input type="text" id="<?php echo esc_attr($meta_key . '_field'); ?>" name="<?php echo esc_attr($meta_key . '_field'); ?>" value="<?php echo esc_attr($meta_value); ?>" /><br />
    <?php } ?>

    <!-- Bouton d'upload d'image -->
    <button id="upload_image_button" class="button"><?php _e('Upload Image', 'foliobr'); ?></button>
    <script>
      jQuery(document).ready(function($) {
        var custom_uploader;
        $('#upload_image_button').click(function(e) {
          e.preventDefault();
          if (custom_uploader) {
            custom_uploader.open();
            return;
          }
          custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
              text: 'Choose Image'
            },
            multiple: false
          });
          custom_uploader.on('select', function() {
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            $('#image_projet_field').val(attachment.url);
          });
          custom_uploader.open();
        });
      });
    </script>
  <?php
  }

  public function get_realisation_single_archives_html($lien_du_projet, $annee_realisation, $role_tenu, $terms_type_projet, $terms_technologie, $image_projet)
  {
    global $version;

    wp_enqueue_script('foliobr-singleArchive', get_template_directory_uri() . '/assets/js/singleArchive.js', array('jquery'), $version, true);
    wp_localize_script('foliobr-singleArchive', 'object_wp', array(
      'ajaxurl' => admin_url('admin-ajax.php'),
      'image_projet' => $image_projet,
    ));

    // Récupérer le titre et le lien de la page des réalisations
    $archive_page_title = 'Realisations';
    $archive_page_link = get_post_type_archive_link('realisations');

    ob_start(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class('section single-archive-content realisations-single'); ?>>

      <?php echo breadcrumb_single_html($archive_page_link, $archive_page_title); ?>

      <div class="card">
        <h2 class="real-title">
          <?php the_title(); ?>
        </h2>
        <?php if ($annee_realisation) { ?>
          <div class="date-real">
            <?php echo esc_html($annee_realisation); ?>
          </div>
        <?php } ?>
        <div class="row">
          <?php if ($terms_type_projet && !is_wp_error($terms_type_projet)) { ?>
            <div class="type-projets">
              <?php foreach ($terms_type_projet as $term) { ?>
                <div class="type_projet">
                  <?php echo esc_html($term->name); ?>
                </div>
              <?php } ?>
            </div>
          <?php } ?>
          <?php if ($role_tenu) { ?>
            <div class="role-tenu">
              <?php echo esc_html($role_tenu); ?>
            </div>
          <?php } ?>
        </div>
        <div class="card-content">
          <?php the_content(); ?>
        </div>
        <?php if ($terms_technologie && !is_wp_error($terms_technologie)) { ?>
          <div class="projet-cat">
            <?php foreach ($terms_technologie as $term) { ?>
              <div class="techno_projet">
                <?php echo esc_html($term->name); ?>
              </div>
            <?php } ?>
          </div>
        <?php } ?>
        <?php if ($lien_du_projet) { ?>
          <a href="<?php echo esc_html($lien_du_projet); ?>" target="_blank" class="btn-primary">
            <?php the_title(); ?>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-external-link">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M12 6h-6a2 2 0 0 0 -2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-6" />
              <path d="M11 13l9 -9" />
              <path d="M15 4h5v5" />
            </svg>
          </a>
        <?php } ?>
      </div>

      <?php echo navigation_single_html('realisations'); ?>

    </article>
<?php
    return ob_get_clean();
  }
}
