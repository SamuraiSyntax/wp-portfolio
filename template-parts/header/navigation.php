<?php

defined('ABSPATH') or die('No direct script access allowed.');

$iconManagerSVG = new IconManagerSVG();

$logoSVG = $iconManagerSVG->Logo();
$logoHoverSVG = $iconManagerSVG->LogoHover();

$themeMoon = $iconManagerSVG->ThemeMoon();
$themeSun = $iconManagerSVG->ThemeSun(); ?>

<header id="masthead" class="site-header" role="banner">

  <div class="br-header-nav">
    <a id="br-logo" class="site-branding" href="<?php echo esc_url(home_url('/')); ?>" rel="home" aria-label="Bernard Rogier">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="64" height="64">
        <text id="text-logo-svg-hidden" x="32" y="40" text-anchor="middle" font-size="32" font-weight="regular" font-family="Jura" stroke="var(--br-primary)" stroke-width="10" visibility="hidden">BR</text>
        <text id="text-logo-svg-fill" x="32" y="40" text-anchor="middle" font-size="32" font-weight="regular" font-family="Jura">BR</text>
      </svg>
    </a><!-- .site-branding -->

    <div id="toggle-site-navigation">
      <span></span>
      <span></span>
      <span></span>
    </div>

    <nav id="site-navigation" class="main-navigation" role="navigation">
      <?php wp_nav_menu(array(
        'theme_location' => 'menu-header',
        'menu_id' => 'menu-header',
        'menu_class' => 'menu-container', // Ajout de la classe pour le conteneur du menu
        'container' => 'ul', // Utilisation d'un élément <ul> comme conteneur du menu
        'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>', // Définition du format des éléments de menu
        'walker' => new Custom_Menu_Walker() // Utilisation d'un marcheur personnalisé pour ajouter des classes aux éléments de menu
      )); ?>
    </nav><!-- #site-navigation -->

    <!-- Bouton de changement de thème -->
    <a id="theme-toggle" href="#" aria-label="Toggle Theme">
      <?php echo $themeMoon; ?>
    </a><!-- .container -->
  </div>

  <nav id="site-navigation-mobile" class="main-navigation" role="navigation">
    <?php wp_nav_menu(array(
      'theme_location' => 'menu-header',
      'menu_id' => 'menu-header-mobile',
      'menu_class' => 'menu-container', // Ajout de la classe pour le conteneur du menu
      'container' => 'ul', // Utilisation d'un élément <ul> comme conteneur du menu
      'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>', // Définition du format des éléments de menu
      'walker' => new Custom_Menu_Walker() // Utilisation d'un marcheur personnalisé pour ajouter des classes aux éléments de menu
    )); ?>
  </nav><!-- #site-navigation-mobile -->

</header><!-- #masthead -->