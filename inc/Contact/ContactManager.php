<?php

defined('ABSPATH') or die('No direct script access allowed.');

class ContactManager
{
  public function modalContact()
  {
    ob_start(); ?>
    <div id="modalContact" class="modal">
      <div class="bg-modal-close" data-modal="#modalContact"></div>
      <div class="row justify-content-center">
        <div class="card card-modal-form">
          <h2 class="card-title">
            Parlez moi de votre projet
          </h2>
          <?php echo do_shortcode('[contact-form-7 id="18f5488" title="Formulaire de contact"]'); ?>
          <button class="modal-close" data-modal="#modalContact">Fermer</button>
        </div>
      </div>
    </div>
<?php
    return ob_get_clean();
  }
}
