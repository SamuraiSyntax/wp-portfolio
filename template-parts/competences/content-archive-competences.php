<?php // content-archive-competences.php

defined('ABSPATH') or die('No direct script access allowed.');

$competencesManager = new CompetencesManager();
$term_name = $competencesManager->get_the_terms_by_id(get_the_ID(), 'categorie_competence');
$progress_competence = get_post_meta(get_the_ID(), 'progress_competence', true);
$competence_image_url = get_post_meta(get_the_ID(), 'competence_image', true);
?>

<aside class="sidebar">
  <h2>Trier les compétences</h2>
  <form id="competence-filter-form" action="" method="get">
    <label for="orderby">Trier par :</label>
    <select name="orderby" id="orderby">
      <option value="title">Titre</option>
      <option value="date">Date</option>
      <!-- Ajoutez d'autres options de tri si nécessaire -->
    </select>
    <label for="order">Ordre :</label>
    <select name="order" id="order">
      <option value="asc">Croissant</option>
      <option value="desc">Décroissant</option>
    </select>
    <label for="competence_category">Catégorie :</label>
    <select name="competence_category" id="competence_category">
      <option value="">Toutes les catégories</option>
      <?php foreach ($competence_categories as $category) : ?>
        <option value="<?php echo esc_attr($category->slug); ?>"><?php echo esc_html($category->name); ?></option>
      <?php endforeach; ?>
    </select>
  </form>
</aside>

<?php 
if ($competences_query->have_posts()) :
  ob_start();
  while ($competences_query->have_posts()) : $competences_query->the_post();
    echo $competencesManager->get_competences_archives_html($competence_image_url, $progress_competence, $term_name);
  endwhile;
  wp_reset_postdata();
  echo ob_get_clean();
else :
  echo '<p>' . __('Aucune compétence trouvée.', 'foliobr') . '</p>';
endif;
