<?php

defined('ABSPATH') or die('No direct script access allowed.');
$current_year = date('Y');

?>
</main>

<footer id="colophon" class="site-footer container site-info secondary-text" role="contentinfo">
  <?php printf('<div class="copyright">'
    . esc_html__('Créé par %s', 'foliobr'), '<a class="link_footer" href="' . esc_url(__(home_url('/'), 'foliobr')) . '">'
    . 'Bernard Rogier' . '</a>'
    . ' © ' . $current_year . '</div>'
    . ' <span class="sep_footer"></span>')
    . wp_nav_menu(array(
      'theme_location' => 'menu-footer',
      'container_id'    => 'menu-footer',
      'menu_class'      => 'menu-footer',
      'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
    )); ?>
</footer>
</div>

<ul class="circles">
  <li></li>
  <li></li>
  <li></li>
  <li></li>
  <li></li>
  <li></li>
  <li></li>
  <li></li>
  <li></li>
  <li></li>
</ul>

<?php wp_footer(); ?>

</body>

</html>