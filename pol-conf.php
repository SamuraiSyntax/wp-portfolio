<?php

/**
 * Template Name: Politiques & Confidentialités
 *
 * @package foliobr
 */

defined('ABSPATH') or die('No direct script access allowed.');

get_header(); ?>
<?php while (have_posts()) : the_post(); ?>
  <article id="post-<?php the_ID(); ?>" <?php post_class('section section_pol_conf'); ?>>
    <div class="card">
      <h1 class="card-title"><?php the_title(); ?></h1>
      <div class="card-description">
        <?php the_content(); ?>
      </div>
    </div>
  </article>
<?php endwhile; ?>
<?php get_footer(); ?>