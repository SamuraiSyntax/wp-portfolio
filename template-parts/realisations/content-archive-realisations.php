<?php

defined('ABSPATH') or die('No direct script access allowed.');

$image_projet = get_post_meta(get_the_ID(), 'image_projet', true); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('section archive-content realisations-list'); ?> style="background-image: url('<?php echo esc_url($image_projet); ?>');">
  <a href="<?php the_permalink(); ?>" class="card gap-1" aria-label="Réalisation">
    <h2 class="card-title">
      <?php the_title(); ?>
    </h2>
    <div class="card-description">
      <?php the_excerpt(); ?>
    </div>
    <?php $terms_type_projet = get_the_terms(get_the_ID(), 'type_projet');
    $terms_technologie = get_the_terms(get_the_ID(), 'technologie');
    if ($terms_type_projet) : ?>
      <div class="card-link"><strong><?php _e('Type de projet:', 'foliobr'); ?></strong>
        <?php if ($terms_type_projet && !is_wp_error($terms_type_projet)) :
          foreach ($terms_type_projet as $term) :
            echo esc_html($term->name) . ', ';
          endforeach;
        endif; ?>
      </div>
    <?php endif;
    if ($terms_technologie) : ?>
      <div class="card-link">
        <strong><?php _e('Technologies:', 'foliobr'); ?></strong>
        <?php if ($terms_technologie && !is_wp_error($terms_technologie)) :
          foreach ($terms_technologie as $term) :
            echo esc_html($term->name) . ', ';
          endforeach;
        endif; ?>
      </div>
    <?php endif; ?>
  </a>
</article>