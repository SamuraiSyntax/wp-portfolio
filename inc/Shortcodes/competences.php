<?php

defined('ABSPATH') or die('No direct script access allowed.');

function front_competences_shortcode($atts, $content = null)
{
  // Récupération des options depuis le Customizer
  $titreArchive = get_theme_mod('archive_title_competences', ''); // Titre de la page d'archive des compétences
  $descriptionArchive = get_theme_mod('archive_description_competences', ''); // Description de la page d'archive des compétences
  $linkArchiveText = get_theme_mod('archive_link_competences_text', ''); // Texte du lien vers la page d'archive des compétences
  $archive_link = get_post_type_archive_link('competences');

  // Récupération de deux compétences aléatoires
  $args = array(
    'post_type' => 'competences',
    'posts_per_page' => -1, // Nombre de compétences à afficher
    'orderby' => 'rand',
    'meta_key' => 'mise_en_avant', // Clé de la métadonnée "mise en avant"
    'meta_value' => 'on', // Valeur de la métadonnée "mise en avant" à rechercher
    'meta_compare' => '=', // Comparaison exacte
  );

  // Exécution de la requête WP_Query
  $query = new WP_Query($args);

  $competencesManager = new CompetencesManager();
  $competences_html = $competencesManager->get_competences_html($query);

  $class_section_minia = "competences_minia";
  $meta_image = 'competence_image';

  ob_start(); ?>
  <div id="competences-container" class="row">
    <?php if (!empty($titreArchive)) : ?>
      <div class="card gap-1 card-comp-infos">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/skills.svg'); ?>" class="card-image"
          alt="">
        <h2 class="card-title">
          <?php echo $titreArchive; ?>
        </h2>
        <?php if (!empty($descriptionArchive)) : ?>
          <div class="card-description">
            <?php echo $descriptionArchive; ?>
          </div>
        <?php endif; ?>
        <?php if (!empty($linkArchiveText)) : ?>
          <a class="btn-primary" href="<?php echo esc_url($archive_link); ?>">
            <?php echo esc_html($linkArchiveText); ?>
          </a>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <?php echo $competences_html; ?>
  </div>

  <?php echo miniature_html('competences', $query, $class_section_minia, $meta_image); ?>

<?php
  $output = ob_get_clean();
  return $output;
}
add_shortcode('front_competences', 'front_competences_shortcode');
