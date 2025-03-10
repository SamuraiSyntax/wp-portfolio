<?php

defined('ABSPATH') or die('No direct script access allowed.');

get_header(); ?>
<?php while (have_posts()) : the_post(); ?>
  <article id="post-<?php the_ID(); ?>" <?php post_class('section taxo-content taxo-list'); ?>>
    <div class="row">
      <div class="card">
        <h1 class="section_title"><?php the_title(); ?></h1>
        <?php the_content(); ?>
      </div>
    </div>
  </article>
<?php endwhile; ?>
<?php get_footer(); ?>