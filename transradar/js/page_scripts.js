$(".page li").html(function(indx, oldHtml){
  return '<span style="color: #333; font-weight: normal;">' + oldHtml + '</span>';
});

/* _______________    Минимальная высота контейнера с вкладками   ______________________________________ */
// function setMineMinHeight() {
// 	var window_h = $(window).height();
// 	var footer_h = $('.container-fluid.footer > .row').outerHeight();
// 	var h = window_h - footer_h - $('.left_tabs_cont').offset().top -60; //626 576
//     $('.left_tabs_cont').css('min-height', h);
// 	return false
// }
// setMineMinHeight();
// $(window).resize(setMineMinHeight);

/* _______________________конец________________________________________________________________________ */