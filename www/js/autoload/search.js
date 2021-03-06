$(function() {

  function init() {
    $('#toggleNotRecommended').click(function() {
      $('li.notRecommended').toggleClass('notRecommendedShown notRecommendedHidden');
      return false;
    });

    $('#toggleElision').click(function() {
      $('li.elision').toggleClass('elisionShown elisionHidden');
      return false;
    });

    $('.toggleVariantParadigms').click(function() {
      $(this).siblings('.variantParadigm').stop().slideToggle();
    });

    moveBanner();
  }

  function moveBanner() {
    var placement = $('.banner-section').data('placement');

    switch (placement) {
    case 'default':
      break;

    case 'dynamic':
      var h = $(window).height();
      var pos = null;

      // Move the banner down a few definitions or meanings, but
      // * not lower than 2/3 of the window height;
      // * only if followed by more definitions;
      // * only if there are no images to show.
      var selector =
          '#resultsTab .primaryMeaning:not(:first), ' +
          'h4.etymology, ' +
          '#resultsTab .defWrapper:not(:first)';
      $(selector).slice(0,3).each(function() {
        var top = $(this).offset().top;
        if (top + 100 < 2 * h / 3) {
          pos = $(this);
        }
      });

      if (pos && !$('#gallery').length) {
        $('.banner-section').insertBefore(pos);
      } else {
        $('.banner-section').show();
      }
      break;
    }
  }

  init();

});
