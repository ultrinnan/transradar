$(".h_4").mouseover(function(){
	$(".h_4").addClass('hover');
});
$(".h_4").mouseout(function(){
	$(".h_4").removeClass('hover');
});

/* _______________    Минимальная высота контейнера   ______________________________________ */
function setMineMinHeight() {
	var window_h = $(window).height();
	var footer_h = $('.container-fluid.footer > .row').outerHeight();
	var filled_h = $('.container-fluid.filled > .row').outerHeight();
	var cont_h = $('.content_main').height();
	var search_h = $('.content_search').outerHeight();
	var h = window_h - footer_h - filled_h - $('.content').offset().top -12;
	var space = h - cont_h - search_h;
    $('.content').css('min-height', h);
  	$('.content_main').css('margin-top', space/2); //10
    $('.content_main').css('margin-bottom', space/2); //24
	return false
}
setMineMinHeight();
$(window).resize(setMineMinHeight);

/* _______________________конец________________________________________________________________________ */