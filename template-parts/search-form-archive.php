<?php

defined('ABSPATH') or die('No direct script access allowed.');

?>
<form id="archive-filter" action="<?php echo esc_url(home_url('/')); ?>" method="get">
  <label for="type_projet"><?php _e('Filtrer par type de projet :', 'foliobr'); ?></label>
  <select name="type_projet" id="type_projet">
    <option value=""><?php _e('Tous les types', 'foliobr'); ?></option>
    <?php
    $types_projet = get_terms('type_projet');
    foreach ($types_projet as $type_projet) :
    ?>
      <option value="<?php echo esc_attr($type_projet->slug); ?>"><?php echo esc_html($type_projet->name); ?></option>
    <?php endforeach; ?>
  </select>
  <button type="submit" class="btn-submit"><?php _e('Filtrer', 'foliobr'); ?></button>
</form>