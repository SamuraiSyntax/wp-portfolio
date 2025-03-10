<?php

defined('ABSPATH') or die('No direct script access allowed.');

function front_contact_shortcode($atts, $content = null)
{
  ob_start(); ?>
  <div class="row justify-content-center f-wrap">
    <div class="card gap-1 contact-form" style="flex-direction: column;">
      <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/Contact.svg'); ?>" class="card-image" alt="">
      <h2 class="card-title">
        Restons en Contact
      </h2>
      <div class="card-description">
        Vous avez une idée de projet ou besoin de mes services ? N'hésitez pas à me contacter.
        Je suis disponible pour discuter de vos besoins et vous aider à concrétiser vos idées.
      </div>
      <a class="btn-primary" href="#modalContact" data-modal="#modalContact">
        Contactez moi
      </a>
    </div>
    <div class="card gap-1 contact-form">
      <h3 class="card-title">
        Mes Réseaux
      </h3>
      <div class="card-description">
        <ul class="social-icons">
          <?php $social_networks_data = get_option('social_networks_data');
          // Vérifier si les données ne sont pas vides
          if (!empty($social_networks_data)) {
            // Parcourir chaque réseau social
            foreach ($social_networks_data as $network => $data) {
              // Vérifier si le réseau social doit être affiché
              if (isset($data['display']) && $data['display']) {
                // Déterminer l'image à afficher en fonction du thème
                $image_src = !empty($data['image']) ? $data['image'] : $data['image_light'];

                // Afficher l'image si elle existe, sinon afficher le nom du réseau social avec le lien
                if (!empty($image_src)) {
                  echo '<li class="social-icon"><a class="social-icon-link" href="' . esc_url($data['link']) . '"><img id="github-icon" src="' . esc_url($image_src) . '" alt="' . esc_attr($data['name']) . '"></a></li>';
                } else {
                  echo '<li class="social-icon"><a class="social-icon-link" href="' . esc_url($data['link']) . '">' . esc_html($data['name']) . '</a></li>';
                }
              }
            }
          } ?>
        </ul>
      </div>
    </div>
  </div>
<?php
  $output = ob_get_clean();
  return $output;
}
add_shortcode('front_contact', 'front_contact_shortcode');
