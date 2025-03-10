<?php

/**
 * Template Name: Contactez moi
 * Template Post Type: page, post
 */

defined('ABSPATH') or die('No direct script access allowed.');

get_header(); ?>

<main id="content" role="main">

  <?php if (have_posts()) : ?>

    <div id="fullpage" class="contact-content"> <!-- Ajoutez l'ID fullpage -->

      <?php while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('section'); ?>> <!-- Ajoutez la classe section -->
          <header class="entry-header">
            <h2 class="entry-title"><a href="<?php echo esc_url(get_permalink(get_page_by_path('contactez-moi'))); ?>"><?php the_title(); ?></a></h2>
          </header>
          <div class="entry-content">
            <?php the_content(); ?>
          </div>
        </article>
      <?php endwhile; ?>

    </div>

  <?php else : ?>
    <p><?php _e('Aucune contact trouvée.', 'foliobr'); ?></p>
  <?php endif; ?>

</main><!-- #content -->

<?php get_footer(); ?>