(function ($) {
  $(document).ready(() => App.init());

  const App = {
    init() {
      this.initModules();
      this.bindEvents();
      this.loadPreviousTheme();

      $('.wp-lightbox-overlay .scrim').css({
        'background-color': 'rgba(var(--br-bg-color-primary-rgb), .7)',
      });
    },
    initModules() {
      ScrollApp.init();
      MiniaturesApp.init();
      NavigationApp.init();
      CursorApp.init();
      SearchComp.init();
    },
    bindEvents() {
      $('#toggle-site-navigation').on('click', this.toggleSiteNavigation);
      $(document).on('click touch', this.handleCubeClick);
      $('.section_presentation, .section_realisations').each(this.createGradient);
      $(document).on('click', 'a[data-modal], button[data-modal], #modalContact .bg-modal-close', this.openModal);
    },
    loadPreviousTheme() {
      const savedTheme = localStorage.getItem('br-theme');
      if (savedTheme) {
        $('body').attr('data-br-theme', savedTheme);
        NavigationApp.updateThemeIcon(savedTheme);
      }
    },
    toggleSiteNavigation() {
      $('#toggle-site-navigation').toggleClass('open');
      $('#site-navigation-mobile, #masthead').toggleClass('open');
    },
    handleCubeClick(event) {
      const cubeSize = 10;
      const $cube = $('<div class="cube"></div>').css({
        'position': 'fixed',
        'top': event.pageY - cubeSize / 2 + 'px',
        'left': event.pageX - cubeSize / 2 + 'px'
      }).appendTo('body').on('animationend', function () {
        $(this).remove();
      });
    },
    createGradient() {
      const section = $(this);
      const sectionWidth = section.width();
      const sectionHeight = section.height();
      const leftPosition = Math.random() * sectionWidth;
      const topPosition = Math.random() * sectionHeight;
      $('<div class="gradient"></div>').css({
        left: leftPosition + 'px',
        top: topPosition + 'px'
      }).appendTo(section);
    },
    openModal(e) {
      e.preventDefault();
      const targetModal = $(this).data('modal');
      $(targetModal).toggle('active');
    }
  };

  const SearchComp = {
    init: function () {
      $('#btnOpenSearch').click(function () {
        $('.sidebar, .site-content').toggleClass('open');
      });

      $('.custom-select, .custom-select .select-option').click(function (e) {
        e.stopPropagation();
        $(this).closest('.custom-select').toggleClass('open').siblings('.custom-select').removeClass('open');
      });

      $('.custom-select .select-option').click(function (e) {
        e.stopPropagation();
        var $this = $(this);
        var $select = $this.closest('.custom-select');
        var $options = $select.find('.select-option');
        if (!$this.hasClass('selected')) {
          $options.removeClass('selected');
          $this.addClass('selected');
          const selectedOptionText = $this.text();
          $select.find('.selected').text(selectedOptionText);
          $select.removeClass('open');
        }
      });

      $('#submitComp').click(function (e) {
        e.preventDefault();
        var selectedCategory = $('.custom-select:eq(0) .select-option.selected').data('value');
        var selectedOrderby = $('.custom-select:eq(1) .select-option.selected').data('value');
        var selectedOrder = $('.custom-select:eq(2) .select-option.selected').data('value');
        var url = ajax_object.ajax_object.archive_link_competences + '?competence_category=' + selectedCategory + '&orderby=' + selectedOrderby + '&order=' + selectedOrder;
        window.location.href = url;
      });
    },
  }

  const CursorApp = {
    init() {
      const $cursor = $('<div class="small-cursor"></div>');
      $('body').append($cursor);
      $(document).on('mousemove', this.moveCursor);
      this.bindHoverEvents();
      $(document).on('click', this.enlargeCursor);
    },
    moveCursor(e) {
      const $cursor = $('.small-cursor');
      $cursor.css({
        left: e.clientX + 'px',
        top: e.clientY + 'px'
      });
    },
    bindHoverEvents() {
      $('a, button, input, textarea, select, option, .custom-select .select-option, .circles li, .wp-lightbox-container img, .lightbox-image-container').on('mouseenter mouseleave', function () {
        $('.small-cursor').toggleClass('hovered');
      });
    },
    enlargeCursor() {
      $('.small-cursor').addClass('one-point');
      setTimeout(() => {
        $('.small-cursor').removeClass('one-point');
      }, 300);
    }
  };

  const NavigationApp = {
    brLogoId: '#br-logo',
    themeToggleId: '#theme-toggle',
    svgHiddenId: '#text-logo-svg-hidden',
    svgFilledId: '#text-logo-svg-fill',
    githubIconId: '#github-icon',
    init() {
      $('#toggle-site-navigation').on('click', NavigationApp.toggleSiteNavigation);
      NavigationApp.logoHidden();
      NavigationApp.bindEvents();
      NavigationApp.loadPreviousTheme();
    },
    bindEvents() {
      $(NavigationApp.brLogoId).hover(NavigationApp.logoFilled, NavigationApp.logoHidden);
      $(NavigationApp.themeToggleId).on('click', NavigationApp.toggleTheme);
    },
    logoHidden() {
      $(NavigationApp.svgHiddenId).css('visibility', 'hidden');
      $(NavigationApp.svgFilledId).css({
        'fill': 'var(--br-text-color-primary)',
        'font-weight': '700'
      });
    },
    logoFilled() {
      $(NavigationApp.svgHiddenId).css('visibility', 'visible');
      $(NavigationApp.svgFilledId).css({
        'fill': 'var(--br-secondary)',
        'font-weight': '900'
      });
    },
    loadPreviousTheme() {
      const savedTheme = localStorage.getItem('br-theme');
      if (savedTheme) {
        $('body').attr('data-br-theme', savedTheme);
        NavigationApp.updateThemeIcon(savedTheme);
      }
    },
    toggleTheme() {
      const currentTheme = $('body').attr('data-br-theme');
      const newTheme = (currentTheme === 'light') ? 'dark' : 'light';
      $('body').attr('data-br-theme', newTheme);
      localStorage.setItem('br-theme', newTheme);
      NavigationApp.updateThemeIcon(newTheme);
    },
    updateThemeIcon(theme) {
      const themeIcon = $(NavigationApp.themeToggleId);
      themeIcon.html(theme === 'light' ? ajax_object.ajax_object.themeMoon : ajax_object.ajax_object.themeSun);
      NavigationApp.updateGithubIcon(theme); // Appel de la fonction pour mettre à jour l'icône GitHub
    },
    updateGithubIcon(theme) {
      const githubIcon = $(NavigationApp.githubIconId);
      githubIcon.attr('src', theme === 'light' ? ajax_object.ajax_object.githubIconLight : ajax_object.ajax_object.githubIconDark);
    }
  };

  const MiniaturesApp = {
    init() {
      this.activateAndBindMiniatures('.section.section_competences', '#competences-container', '.miniatures.competences_minia', '.card-comp, .card-comp-infos', 'data-comp-index', 'compIndex');
      this.activateAndBindMiniatures('.section.section_realisations', '#realisations-container', '.miniatures.realisations_minia', '.card-real, .card-real-infos', 'data-real-index', 'realIndex');
    },
    activateAndBindMiniatures(section, containerSelector, minias, itemSelector, dataIndexAttr, dataIndexAttrMinia) {
      const scrollContainer = $(containerSelector);

      // Fonction pour activer la miniature correspondante lors du scroll
      function activateMiniatureOnScroll() {
        const scrollLeft = scrollContainer.scrollLeft();
        let visibleItemIndex = 0;

        $(itemSelector).each(function (index) {
          if ($(this).offset().left >= 0 && $(this).offset().left <= scrollContainer.width()) {
            visibleItemIndex = index;
            return false;
          }
        });
        $(section + ' ' + minias + ' a.miniature').removeClass('active');
        $('.miniature[' + dataIndexAttr + '="' + visibleItemIndex + '"]').addClass('active');
      }

      // Activer la miniature correspondante au clic
      $(document).on('click', section + ' ' + minias + ' a.miniature', function (e) {
        e.preventDefault();

        const itemIndex = $(this).data(dataIndexAttrMinia);
        const item = itemIndex === 0 ? $(itemSelector).first() : $(itemSelector).eq(itemIndex);

        $(section + ' ' + minias + ' a.miniature').removeClass('active');
        $(this).addClass('active');

        scrollContainer.animate({
          scrollLeft: item.offset().left - scrollContainer.offset().left + scrollContainer.scrollLeft()
        }, 100);
      });

      // Activer la miniature correspondante lors du scroll
      scrollContainer.on('scroll', activateMiniatureOnScroll);

      // Activer la miniature correspondante au chargement initial de la page
      activateMiniatureOnScroll();
    }
  };

  const ScrollApp = {
    sections: {
      competences: {
        section: $('#content .section_competences'),
        selector: '.miniatures.competences_minia a.miniature',
        index: 'comp-index',
        miniatures: null,
        numberOfMiniatures: null
      },
      realisations: {
        section: $('#content .section_realisations'),
        selector: '.miniatures.realisations_minia a.miniature',
        index: 'real-index',
        miniatures: null,
        numberOfMiniatures: null
      }
    },
    lastVisibleSection: null,
    init() {
      if (Object.values(this.sections).every(section => section.section.length > 0 && $(section.selector).length > 0)) {
        this.lastVisibleSection = this.detectVisibleSection();
        $('#content').on('scroll', this.handleScroll.bind(this));
      }
    },
    handleScroll() {
      const currentVisibleSection = this.detectVisibleSection();
      if (currentVisibleSection !== this.lastVisibleSection) {
        this.updateVisibility(currentVisibleSection);
        this.lastVisibleSection = currentVisibleSection;
      }
    },
    updateVisibility(sectionName) {
      if (!sectionName) return;
      const section = this.sections[sectionName];
      const isSectionVisible = this.isSectionVisibleVertical(section.section);
      const $circlesLi = $('.circles li');
      const maxMiniatureIndex = section.section.find('.miniature').length;
      const miniatures = section.section.find(section.selector).filter(function () {
        const index = $(this).data(section.index);
        return index >= 1 && index <= maxMiniatureIndex;
      });
      section.miniatures = miniatures;
      section.numberOfMiniatures = miniatures.length;
      $circlesLi.each(function (index) {
        const $currentLi = $(this);
        const miniIndex = index % section.numberOfMiniatures + 1;
        const backgroundImage = section.miniatures.eq(miniIndex - 1).css('background-image');
        if (backgroundImage && backgroundImage !== 'none') {
          $currentLi.css({
            'background-image': backgroundImage,
            'background-position': 'center center',
            'background-size': 'cover',
            'background-repeat': 'no-repeat',
            'background-attachment': 'fixed',
            'background-origin': 'border-box',
            'background-clip': 'border-box',
            'background-color': 'transparent',
            'transition': 'all .3s ease-in-out'
          });
        } else {
          $currentLi.css('background-image', '');
        }
      });
    },
    isSectionVisibleVertical(section, margin = null) {
      let containerTop = section.offset().top;
      if (margin !== null) {
        containerTop -= margin;
      }
      const containerBottom = containerTop + section.outerHeight();
      const viewportTop = window.scrollY;
      const viewportBottom = viewportTop + window.innerHeight;
      return containerTop < viewportBottom && containerBottom > viewportTop;
    },
    detectVisibleSection() {
      const scrollTop = window.scrollY;
      const windowHeight = window.innerHeight;
      for (const key in this.sections) {
        const section = this.sections[key];
        const sectionTop = section.section.offset().top;
        if (scrollTop >= sectionTop && scrollTop < sectionTop + windowHeight) {
          return key;
        }
      }
      return null;
    }
  };

  $(window).on('load', function () {
    $('#loader').fadeOut(1000);
  });
})(jQuery);