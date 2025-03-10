<?php

defined('ABSPATH') or die('No direct script access allowed.');

function custom_sections_meta_box()
{
  add_meta_box(
    'sections_meta_box',
    'Sections',
    'display_custom_sections_meta_box',
    'page',
    'normal',
    'high'
  );
}

function display_custom_sections_meta_box($post)
{
  $sections = get_post_meta($post->ID, 'sections', true);
?>
  <div id="sections_container">
    <?php if (!empty($sections)) :
      foreach ($sections as $index => $section) : ?>
        <div class="section_container">
          <h3>Section <?php echo esc_html($index + 1); ?></h3>
          <label for="section_type_<?php echo esc_attr($index); ?>">Section Type:</label>
          <select class="section_type" name="sections[<?php echo esc_attr($index); ?>][type]">
            <option value=""></option>
            <option value="title_description" <?php selected(isset($section['type']) && $section['type'] === 'title_description'); ?>>Title + Description</option>
            <option value="shortcode" <?php selected(isset($section['type']) && $section['type'] === 'shortcode'); ?>>Shortcode</option>
          </select>
          <div class="section_content">
            <?php if (isset($section['type'])) : ?>
              <?php if ($section['type'] === 'title_description') : ?>
                <label for="section_class_<?php echo esc_attr($index); ?>">.section Class:</label>
                <input type="text" id="section_class_<?php echo esc_attr($index); ?>" name="sections[<?php echo esc_attr($index); ?>][section_class]" value="<?php echo isset($section['section_class']) ? esc_attr($section['section_class']) : ''; ?>">
                <label for="section_title_<?php echo esc_attr($index); ?>">Title:</label>
                <input type="text" id="section_title_<?php echo esc_attr($index); ?>" name="sections[<?php echo esc_attr($index); ?>][title]" value="<?php echo isset($section['title']) ? esc_attr($section['title']) : ''; ?>">
                <label for="section_title_class_<?php echo esc_attr($index); ?>">Title Class:</label>
                <input type="text" id="section_title_class_<?php echo esc_attr($index); ?>" name="sections[<?php echo esc_attr($index); ?>][title_class]" value="<?php echo isset($section['title_class']) ? esc_attr($section['title_class']) : ''; ?>">
                <label for="section_description_<?php echo esc_attr($index); ?>">Description:</label>
                <textarea id="section_description_<?php echo esc_attr($index); ?>" name="sections[<?php echo esc_attr($index); ?>][description]" rows="5"><?php echo isset($section['description']) ? esc_html($section['description']) : ''; ?></textarea>
                <label for="section_description_class_<?php echo esc_attr($index); ?>">Description Class:</label>
                <input type="text" id="section_description_class_<?php echo esc_attr($index); ?>" name="sections[<?php echo esc_attr($index); ?>][description_class]" value="<?php echo isset($section['description_class']) ? esc_attr($section['description_class']) : ''; ?>">
              <?php elseif ($section['type'] === 'shortcode') : ?>
                <label for="section_class_<?php echo esc_attr($index); ?>">.section Class:</label>
                <input type="text" id="section_class_<?php echo esc_attr($index); ?>" name="sections[<?php echo esc_attr($index); ?>][section_class]" value="<?php echo isset($section['section_class']) ? esc_attr($section['section_class']) : ''; ?>">
                <label for="section_shortcode_<?php echo esc_attr($index); ?>">Shortcode:</label>
                <input type="text" id="section_shortcode_<?php echo esc_attr($index); ?>" name="sections[<?php echo esc_attr($index); ?>][shortcode]" value="<?php echo isset($section['shortcode']) ? esc_attr($section['shortcode']) : ''; ?>">
              <?php endif; ?>
            <?php endif; ?>
          </div>
          <button class="remove_section_button components-button is-primary">Remove Section</button>
        </div>
    <?php endforeach;
    endif; ?>
  </div>
  <button id="add_section_button" class="components-button is-primary">Add Section</button>
<?php
}

function save_custom_sections_meta_box($post_id)
{
  if (isset($_POST['sections'])) {
    $cleaned_sections = [];
    foreach ($_POST['sections'] as $index => $section) {
      $cleaned_sections[$index]['type'] = isset($section['type']) ? sanitize_text_field($section['type']) : '';
      if ($cleaned_sections[$index]['type'] === 'title_description') {
        $cleaned_sections[$index]['section_class'] = isset($section['section_class']) ? sanitize_text_field($section['section_class']) : '';
        $cleaned_sections[$index]['title'] = isset($section['title']) ? sanitize_text_field($section['title']) : '';
        $cleaned_sections[$index]['title_class'] = isset($section['title_class']) ? sanitize_text_field($section['title_class']) : ''; // Ajout de la classe pour le titre
        $cleaned_sections[$index]['description'] = isset($section['description']) ? sanitize_textarea_field($section['description']) : '';
        $cleaned_sections[$index]['description_class'] = isset($section['description_class']) ? sanitize_text_field($section['description_class']) : ''; // Ajout de la classe pour la description
        unset($cleaned_sections[$index]['shortcode']);
      } elseif ($cleaned_sections[$index]['type'] === 'shortcode') {
        $cleaned_sections[$index]['section_class'] = isset($section['section_class']) ? sanitize_text_field($section['section_class']) : '';
        $cleaned_sections[$index]['shortcode'] = isset($section['shortcode']) ? sanitize_text_field($section['shortcode']) : '';
        unset($cleaned_sections[$index]['title']);
        unset($cleaned_sections[$index]['title_class']);
        unset($cleaned_sections[$index]['description']);
        unset($cleaned_sections[$index]['description_class']);
      }
    }
    update_post_meta($post_id, 'sections', $cleaned_sections);
  }
}
add_action('add_meta_boxes', 'custom_sections_meta_box');
add_action('save_post', 'save_custom_sections_meta_box');
