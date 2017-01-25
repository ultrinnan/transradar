$(function($) {
  $('.faq_item').click(function() {
    if($(this).hasClass('closed')) {
      $(this).removeClass('closed');
    }
    else {
      $(this).addClass('closed');
      return false;
    }
  });
});

/* _______________    Минимальная высота контейнера с вкладками   ______________________________________ */
function setMineMinHeight() {
	var window_h = $(window).height();
	var footer_h = $('.footer').outerHeight();
	var h = window_h - footer_h - $('.left_tabs_cont').offset().top -60; //626 576
    $('.left_tabs_cont').css('min-height', h);
	return false
}
setMineMinHeight();
$(window).resize(setMineMinHeight);

/* _______________________конец________________________________________________________________________ */