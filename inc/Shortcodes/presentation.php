<?php

defined('ABSPATH') or die('No direct script access allowed.');

// Shortcode pour afficher la présentation
function front_presentation_shortcode($atts, $content = null)
{
  $titrePresentation = get_option('titre_presentation');
  $descriptionPresentation = get_option('description_presentation');

  ob_start(); ?>
  <?php if (!empty($titrePresentation)) : ?>
    <div id="presentation-container" class="row justify-content-center">
      <div class="card gap-1">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/presentation.svg'); ?>" class="card-image" alt="">
        <h2 class="card-title">
          <?php echo esc_html($titrePresentation); ?>
        </h2>
        <?php if (!empty($descriptionPresentation)) : ?>
          <div class="card-description">
            <?php echo esc_html($descriptionPresentation); ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  <?php endif; ?>
<?php
  $output = ob_get_clean();
  return $output;
}
add_shortcode('front_presentation', 'front_presentation_shortcode');
