<?php
defined('ABSPATH') or die('No direct script access allowed.');

get_header();

$sections = get_post_meta(get_the_ID(), 'sections', true);

if ($sections) :
  foreach ($sections as $section) :
    $section_class = isset($section['section_class']) ? esc_attr($section['section_class']) : '';
    $section_type = isset($section['type']) ? $section['type'] : ''; ?>

    <section class="section <?php echo $section_class; ?>">
      <?php if ($section_type === 'title_description') :
        $title_class = isset($section['title_class']) ? esc_attr($section['title_class']) : '';
        $description_class = isset($section['description_class']) ? esc_attr($section['description_class']) : '';
        $title = isset($section['title']) ? esc_html($section['title']) : '';
        $description = isset($section['description']) ? esc_html($section['description']) : ''; ?>

        <div class="card gap-1">
          <h1 class="card-title <?php echo $title_class; ?>">
            <?php echo esc_html($title); ?>
          </h1>
          <?php if (!empty($description)) : ?>
            <div class="card-description <?php echo $description_class; ?>">
              <?php echo esc_html($description); ?>
            </div>
          <?php endif; ?>
        </div>

      <?php elseif ($section_type === 'shortcode') :
        $shortcode = isset($section['shortcode']) ? do_shortcode($section['shortcode']) : '';
        echo $shortcode;
      endif; ?>
    </section>

<?php endforeach;
endif;

get_footer();
