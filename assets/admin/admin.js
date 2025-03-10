(function ($) {
  $(document).ready(function ($) {
    $('#add_section_button').click(function () {
      var index = $('.section_container').length;
      var html = '<div class="section_container">' +
        '<h3>Section ' + (index + 1) + '</h3>' +
        '<label for="section_type_' + index + '">Section Type:</label>' +
        '<select class="section_type" name="sections[' + index + '][type]">' +
        '<option value=""></option>' +
        '<option value="title_description">Title + Description</option>' +
        '<option value="shortcode">Shortcode</option>' +
        '</select>' +
        '<div class="section_content"></div>' +
        '<button class="remove_section_button">Remove Section</button>' +
        '</div>';
      $('#sections_container').append(html);
    });

    $('#sections_container').sortable(); // Ajout de la fonction sortable

    $(document).on('change', '.section_type', function () {
      console.log('.section_type change');
      var sectionIndex = $(this).closest('.section_container').index();
      var sectionType = $(this).val();
      var sectionContent = '';
      console.log('sectionIndex ', sectionIndex);
      console.log('sectionType ', sectionType);
      if (sectionType === 'title_description') {
        sectionContent = '<label for="section_title_' + sectionIndex + '">Title:</label>' +
          '<input type="text" id="section_title_' + sectionIndex + '" name="sections[' + sectionIndex + '][title]" value="">' +
          '<label for="section_description_' + sectionIndex + '">Description:</label>' +
          '<textarea id="section_description_' + sectionIndex + '" name="sections[' + sectionIndex + '][description]" rows="5"></textarea>';
        console.log('sectionContent ', sectionContent);
      } else if (sectionType === 'shortcode') {
        sectionContent = '<label for="section_shortcode_' + sectionIndex + '">Shortcode:</label>' +
          '<input type="text" id="section_shortcode_' + sectionIndex + '" name="sections[' + sectionIndex + '][shortcode]" value="">';
        console.log('sectionContent ', sectionContent);
      }
      $(this).siblings('.section_content').html(sectionContent);
    });

    $(document).on('click', '.remove_section_button', function () {
      $(this).closest('.section_container').remove();
    });

    // Afficher la valeur de progression en temps réel
    $('.progress_competence').on('input, change', function () {
      var value = $(this).val();
      $(this).siblings('.progress-value').text(value + '%');
    });

    // Ouvrir la fenêtre de média WordPress pour choisir une image
    $('.upload-image').on('click', function (e) {
      e.preventDefault();
      var inputField = $(this).siblings('.competence_image');
      var imageFrame = wp.media({
        title: 'Choose Image',
        multiple: false
      });

      imageFrame.on('select', function () {
        var attachment = imageFrame.state().get('selection').first().toJSON();
        inputField.val(attachment.url);
      });

      imageFrame.open();
    });

    $('.upload-image-reseau').on('click', function (e) {
      e.preventDefault();
      var target = $(this).data('target');
      var image = wp.media({
        title: 'Uploader une image',
        multiple: false
      })

      image.on('select', function (e) {
        var uploaded_image = image.state().get('selection').first();
        var image_url = uploaded_image.toJSON().url;
        $(target).val(image_url);
      });

      image.open();
    });
  });
})(jQuery);