(function ($) {
  $(document).ready(function () {
    var image_projet = object_wp.image_projet;

    if (image_projet) {
      $('.circles li').css({
        'background-image': 'url(' + image_projet + ')',
        'background-position': 'center center',
        'background-size': 'cover',
        'background-repeat': 'no-repeat',
        'background-attachment': 'fixed',
        'background-origin': 'content-box',
        'background-clip': 'content-box',
        'transition': 'all 0.5s ease'
      });
    }
  });
})(jQuery);
