<?php

defined('ABSPATH') or die('No direct script access allowed.');

get_header();

while (have_posts()) : the_post(); ?>
  <article id="post-<?php the_ID(); ?>" <?php post_class('section'); ?>>
    <header class="entry-header">
      <h1 class="entry-title"><?php the_title(); ?></h1>
    </header>
    <div class="entry-content">
      <?php the_content(); ?>
    </div>
  </article>
<?php endwhile;

get_footer();
