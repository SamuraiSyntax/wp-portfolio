<?php

/**
 * Template Name: Archive Compétences
 *
 * @package foliobr
 */

defined('ABSPATH') or die('No direct script access allowed.');

get_header();

$competence_categories = get_terms(array(
  'taxonomy' => 'categorie_competence',
  'hide_empty' => false,
));

$current_orderby = isset($_GET['orderby']) ? $_GET['orderby'] : 'progress_competence';
$current_order = isset($_GET['order']) ? $_GET['order'] : 'desc';

$progress_competence = isset($_GET['progress_competence']) ? $_GET['progress_competence'] : '';
$current_category = isset($_GET['competence_category']) ? $_GET['competence_category'] : '';

?>
<button id="btnOpenSearch" class="btn-primary">
  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-search">
    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
    <path d="M21 21l-6 -6" />
  </svg>
</button>

<aside class="sidebar">
  <form id="competence-filter-form" action="<?php echo esc_url(get_permalink()); ?>" method="get">
    <h2>Trier les compétences</h2>
    <label for="competence_category">Catégorie :</label>
    <div class="custom-select" id="competence-category-select">
      <div class="select-option <?php echo ($current_category === '') ? 'selected' : ''; ?>" data-value="">Toutes les catégories</div>
      <?php foreach ($competence_categories as $category) : ?>
        <div class="select-option <?php echo ($current_category === $category->slug) ? 'selected' : ''; ?>" data-value="<?php echo esc_attr($category->slug); ?>"><?php echo esc_html($category->name); ?></div>
      <?php endforeach; ?>
    </div>
    <label for="orderby">Trier par :</label>
    <div class="custom-select" id="orderby-select">
      <div class="select-option <?php echo ($current_orderby === 'progress_competence') ? 'selected' : ''; ?>" data-value="progress_competence">Progression</div>
      <div class="select-option <?php echo ($current_orderby === 'date') ? 'selected' : ''; ?>" data-value="date">Date</div>
    </div>
    <label for="order">Ordre :</label>
    <div class="custom-select" id="order-select">
      <div class="select-option <?php echo ($current_order === 'desc') ? 'selected' : ''; ?>" data-value="desc">Décroissant</div>
      <div class="select-option <?php echo ($current_order === 'asc') ? 'selected' : ''; ?>" data-value="asc">Croissant</div>
    </div>
    <a id="submitComp" class="btn-primary" href="#" aria-label="Trier les compétences">Trier</a>
  </form>
</aside>

<div id="competences-list" class="list-items-archive">
  <?php $args = array(
    'post_type' => 'competences',
    'posts_per_page' => -1,
    'orderby' => $current_orderby,
    'order' => $current_order,
  );

  // Ajoutez la prise en charge du tri par 'progress_competence'
  if ($current_orderby === 'progress_competence') {
    $args['meta_key'] = 'progress_competence';
    $args['orderby'] = 'meta_value_num';
  }

  // Vérifiez si une catégorie est sélectionnée
  if ($current_category && !empty($current_category)) {
    $args['tax_query'] = array(
      array(
        'taxonomy' => 'categorie_competence', // Remplacez par le nom de votre taxonomie
        'field' => 'slug',
        'terms' => $current_category,
      ),
    );
  }

  $competencesManager = new CompetencesManager();
  echo $competencesManager->boucle_cpt_competences($args); ?>
</div>

<?php get_footer(); ?>