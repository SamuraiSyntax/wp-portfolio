<?php

defined('ABSPATH') or die('No direct script access allowed.');


class Custom_Menu_Walker extends Walker_Nav_Menu
{
  public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
  {
    // Ajoutez ici les classes personnalisées que vous souhaitez pour chaque élément de menu
    $classes = array(
      'menu-item',
      'custom-class', // Classe personnalisée pour chaque élément de menu
    );

    // Ajoutez des classes supplémentaires en fonction du type d'élément de menu
    if (isset($args->walker) && $args->walker->has_children) {
      $classes[] = 'menu-item-has-children';
    }

    // Ajoutez des classes supplémentaires en fonction de la profondeur de l'élément de menu
    if ($depth > 0) {
      $classes[] = 'submenu-item';
    }

    // Ajoutez d'autres classes en fonction des propriétés de l'élément de menu (par exemple, si c'est la page actuelle)
    if (is_array($item->classes) && in_array('current-menu-item', $item->classes)) {
      $classes[] = 'current-menu-item';
    }

    // Générez la sortie de l'élément de menu avec les classes appropriées
    $output .= '<li id="menu-item-' . $item->ID . '" class="' . implode(' ', $classes) . '">';

    // Générez le lien de l'élément de menu avec les classes appropriées
    $attributes = '';
    $attributes .= !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
    $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
    $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';

    // Générez le lien de l'élément de menu avec les classes appropriées
    $permalink = '';
    if ($item->object === 'page') {
      $permalink = get_permalink($item->object_id);
    } else {
      $permalink = !empty(get_permalink($item->ID)) ? esc_url(get_permalink($item->ID)) : '';
    }
    $attributes .= !empty($permalink) ? ' href="' . esc_url($permalink) . '"' : '';
    $attributes .= ' class="menu-link"'; // Ajoutez une classe au lien

    $item_output = '<a' . $attributes . '>'; /* $item_output .=var_dump($item); */
    $item_output .= !empty($item->title) ? esc_html($item->title) : ''; // Insérer le texte du lien en échappant les caractères spéciaux
    $item_output .= '</a>';

    // Générez la sortie de l'élément de menu avec le lien inclus
    $output .= $item_output;
  }
}
