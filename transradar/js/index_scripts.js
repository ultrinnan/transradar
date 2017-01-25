$(".h_4").mouseover(function(){
  $(".h_4").addClass('hover');
});
$(".h_4").mouseout(function(){
  $(".h_4").removeClass('hover');
});

$(".various").fancybox({
        maxWidth  : 800,
        maxHeight : 600,
        fitToView : false,
        width   : '70%',
        height    : '70%',
        autoSize  : false,
        closeClick  : false,
        openEffect  : 'none',
        closeEffect : 'none'
      });

/* _______________    Минимальная высота контейнера   ______________________________________ */
function setMineMinHeight() {
  var window_h = $(window).height();
  var footer_h = $('.footer').outerHeight();
  var partners_h = $('.partners').outerHeight();
  var filled_h = $('.filled').outerHeight();
  var cont_h = $('.content_main').height();
  var search_h = $('.content_search').outerHeight();

  var h = window_h - footer_h - filled_h - partners_h;
  // console.log(h);
  var space = (h - cont_h - search_h)/2;
    if ( space < 0) {
      space = 5;
    }
    $('.content_main').css('margin-top', space); //10
    $('.content_main').css('margin-bottom', space); //24
  return false
}
setMineMinHeight();
$(window).resize(setMineMinHeight);

/* _______________________конец________________________________________________________________________ */
