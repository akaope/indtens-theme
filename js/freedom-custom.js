jQuery(document).ready(function() {
    jQuery('#scroll-up').hide();
    jQuery(function() {
        jQuery(window).scroll(function() {
            if (jQuery(this).scrollTop() > 1000) {
                jQuery('#scroll-up').fadeIn();
            } else {
                jQuery('#scroll-up').fadeOut();
            }
        });
        jQuery('a#scroll-up').click(function() {
            jQuery('body,html').animate({
                scrollTop: 0
            }, 800);
            return false;
        });
    });
});

jQuery(document).ready(function() {
    jQuery('.better-responsive-menu #indtens-navigation .menu-item-has-children').append('<span class="sub-toggle"> <i class="fa fa-caret-down"></i> </span>');
    jQuery('.better-responsive-menu #indtens-navigation .sub-toggle').click(function() {
        jQuery(this).parent('.menu-item-has-children').children('ul.sub-menu').first().slideToggle('1000');
        jQuery(this).children('.fa-caret-right').first().toggleClass('fa-caret-down');
        jQuery(this).toggleClass('active');
    });

    jQuery('.better-responsive-menu #indtens-navigation .menu-toggle').click(function() {
      jQuery('.better-responsive-menu #indtens-navigation .menu-primary-container > ul,.main-navigation .menu > ul').slideToggle('slow');
    });

});


jQuery(document).ready(function() {

  jQuery(window).scroll(function () {
    //   console.log(jQuery(window).scrollTop())
    if (jQuery(window).scrollTop() > 60) {
      jQuery('#indtens-navigation').addClass('navbar-fixed');
      jQuery('#main').css('margin-top','50px');
    }
    if (jQuery(window).scrollTop() < 60) {
      jQuery('#indtens-navigation').removeClass('navbar-fixed');
      jQuery('#main').css('margin-top','0px');
    }
  });
});
