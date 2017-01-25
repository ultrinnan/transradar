$(function name (){
	var i = $('.logo_box > span.shape.active');
	if(i.hasClass('last')){
		i.removeClass('active');
		$('.logo_box > span.shape.first').addClass('active');
	}
	else{
		i.removeClass('active');
		i.next().addClass('active');
	}
	setTimeout (name, 300);
});

$(function countdown (){
	var i = $('.countdown span').text();
	if (i > 0) {
		$('.countdown span').text(i-1);
		setTimeout (countdown, 1000);
	} else {
		$('.countdown span').text('сейчас!');
		var link = $('.countdown').attr('data-url');
		// console.log(link);
		window.location.replace(link);
	}
});


/* _______________    Минимальная высота контейнера с вкладками   ______________________________________ */

function setMineMinHeight() {
	var window_h = $(window).height();
	//header - 48px
	var faq_h = $('.trans').outerHeight();
	
	var cont_h = $('.transition').height();

	if ( window_h < cont_h )  {
	} else {
		var space = window_h - faq_h ;
		$('.transition').css('margin-top', space/2); //10
  	$('.transition').css('margin-bottom', space/2); //24
	}
	return false
}
setMineMinHeight();
$(window).resize(setMineMinHeight);

/* _______________________конец________________________________________________________________________ */