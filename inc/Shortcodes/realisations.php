<?php

defined('ABSPATH') or die('No direct script access allowed.');

function front_realisations_shortcode($atts, $content = null)
{
  // Récupération des options depuis le Customizer
  $titreArchive = get_theme_mod('archive_title_realisations', ''); // Titre de la page d'archive des compétences
  $descriptionArchive = get_theme_mod('archive_description_realisations', ''); // Description de la page d'archive des compétences
  $linkArchiveText = get_theme_mod('archive_link_realisations_text', ''); // Texte du lien vers la page d'archive des compétences
  $archive_link = get_post_type_archive_link('realisations');

  // Récupération de deux compétences aléatoires
  $args = array(
    'post_type' => 'realisations',
    'posts_per_page' => -1, // Nombre de compétences à afficher
    'orderby' => 'rand', // Tri aléatoire
  );
  $query = new WP_Query($args);

  $class_section_minia = "realisations_minia";
  $meta_image = 'image_projet';

  ob_start(); ?>
  <div id="realisations-container" class="row">
    <div class="card gap-1 card-real-infos">
      <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/projets.svg'); ?>" class="card-image" alt="">
      <?php if (!empty($titreArchive)) : ?>
        <h2 class="card-title">
          <?php echo $titreArchive; ?>
        </h2>
      <?php endif; ?>
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

    <?php while ($query->have_posts()) : $query->the_post(); ?>
      <?php $image_projet = get_post_meta(get_the_ID(), $meta_image, true); ?>
      <a href="<?php the_permalink(); ?>" class="card card-real" aria-label="<?php the_title_attribute(); ?>" style="background-image: url('<?php echo esc_url($image_projet); ?>');">
      </a>
    <?php endwhile;
    wp_reset_postdata(); ?>
  </div>

  <?php echo miniature_html('realisations', $query, $class_section_minia, $meta_image); ?>

<?php $output = ob_get_clean();
  return $output;
}
add_shortcode('front_realisations', 'front_realisations_shortcode');
