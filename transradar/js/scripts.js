// 
function calculate_currency(id, name) {
	$.ajax({
		type: "POST",
		url: "/wp-content/themes/transradar/ajax_processor.php",
		dataType: "json", // Тип данных, в которых сервер должен прислать ответ
		data: "action=get_rates&string=" + id,
		error: function() { alert('При выполнении запроса произошла ошибка'); },
		success: function(data) {
			// console.log('here - '+data);
			if (data == 'error') { alert('При выполнении запроса на сервере произошла ошибка'); return; }
			var rates = data;
			$('.price').each(function(){
				var item = $(this);
				// console.log(item);
				var reward = item.find('.reward_amount').attr('data-initial');
				var reward_id = item.find('.reward_amount').attr('data-id');
				var milage = item.parents('.window_content').find('.milage').text();
				if (reward_id != id) {
					for (var j = 0; j < rates.length; j++) {
						if (reward_id == rates[j].currency_id) {
							reward = Math.round(reward / rates[j].rate);
						}
					}
					item.find('.reward_amount').text(new Intl.NumberFormat('en-EN').format(reward));
					var milage_reward = (reward / milage).toFixed(2);
				} else {
					item.find('.reward_amount').text(new Intl.NumberFormat('en-EN').format(item.find('.reward_amount').attr('data-initial')));
					var milage_reward = (item.find('.reward_amount').attr('data-initial') / milage).toFixed(2);
				}
				item.find('.cur_name').text(name).attr('title', name);
				item.next().find('.distance .cur_name').text(name + '/км').attr('title', name + '/км');
				item.next().find('.reward_milage').text(milage_reward);
			});
		}
	});
}
// 
function set_selected_val(name) {
	if ($('.' + name + '_results .places').text() != 'нет результатов') {
		var id = $('.' + name + '_results .places.selected').attr('data-id');
		var country = $('.' + name + '_results .places.selected').attr('data-country');
		var value = $('.' + name + '_results .places.selected').text();
		$('input[name=' + name + '_id]').val(id);
		$('input[name=' + name + ']').val(value);
		$('input[name=is_country]').val(country);
		$('input[name=' + name + '_hidden]').val(value);
	}
	$('.' + name + '_results').hide();
}
// 
function click_Toggle_function(body_close, object_click) {
	object_click.on('click', function() {
		if ($(this).hasClass('show-popup-top')) {
			$(this).removeClass('show-popup-top');
			if ($(this).next() == object_click) { $(this).next().css('display', 'none'); }
			$('.popup2:visible').hide();
			$('.popup:visible').hide();
		} else {
			body_close.css('display', 'none');
			object_click.removeClass('show-popup-top');
			$(this).addClass('show-popup-top');
			if ($(this).next() == object_click) { $(this).next().css('display', 'none'); }
			$('.popup2:visible').hide();
			$('.popup:visible').hide();
			return false;
		}
	});
}
// Функция всплывающих подсказок
/* для объявления всплывающей подсказки, добавить в шапку ХТМЛ блок подсказки (дсплей нон),
в JS 
$(Объект наведения).mouseenter(function(){
	obj = $(this);
	subj = $(Всплывающий блок);
	popup();
	return false
}); */
function popup() {
	function parametr_popup(obj, subj) {
		var height_i = obj.innerHeight();
		var width_i = obj.innerWidth() / 2;
		var height_n = subj.innerHeight();
		var width_n = subj.innerWidth() / 2;
		var offset = obj.offset();
		subj.css("top", (offset.top - height_i - height_n + 8));
		subj.css("left", (offset.left - width_n + width_i));
		subj.css('cursor', 'pointer');
		obj.css('cursor', 'pointer');
		subj.show();
		obj.mouseout(function(e){
			subj.hide();
			e.stopPropagation();
			return false;
		});
	};
	parametr_popup(obj, subj);
};
// 
function popup_click() {
	function parametr_popup(obj, subj) {
		var height_i = obj.innerHeight();
		var width_i = obj.innerWidth() / 2;
		var height_n = subj.innerHeight();
		var width_n = subj.innerWidth() / 2;
		var offset = obj.offset();
		subj.css("top", (offset.top + height_i + 10));
		subj.css("left", (offset.left - width_n + width_i));
		subj.css('cursor', 'pointer');
		obj.css('cursor', 'pointer');
		subj.show();
	};
	parametr_popup(obj, subj);
	subj.hide();
};
// 
var obj, subj;
$(function() {
	var d = $(document);
	var fromTimeout = 0, toTimeout;
	// фунция поп-ап.клик 
	click_Toggle_function($('.popup'), $('.click_Toggle'));
	// 
	$('.menu_box li').html(function(indx, oldHtml) {
		return '<span style="color: #333; font-weight: normal;">' + oldHtml + '</span>';
	});
	//----------- country/city search -----------
	$('[data-toggle="popover"]').popover();
	$('.main_form input').on('keypress', function(e) {
		return e.which !== 13;
	});
	// 
	$('#from').on('keyup', function(event) {
		if (event.which !== 37 && event.which !== 38 && event.which !== 39 && event.which !== 40 && (event.which < 33 || event.which > 36)) {
			clearTimeout(fromTimeout);
			var string = $(this).val();
			fromTimeout = setTimeout(function() {
				var len = string.length;
				if (len >= 0) {
					if (len == 0) {
						$('input[name=from_id]').val('');
						$('input[name=from]').val('');
						$('input[name=from_hidden]').val('');
						$('.from_results').hide();
						$('.from_results').text('');
						search_freights();
						return false;
					}
					$.ajax({
						type: 'POST',
						url: '/wp-content/themes/transradar/ajax_processor.php',
						// dataType: 'json',  // Тип данных, в которых сервер должен прислать ответ
						data: 'action=get_location_list&string=' + string,
						error: function() {
							alert('При выполнении запроса произошла ошибка');
						},
						success: function(data) {
							// console.log(data);
							if (data != 'error') {
								$('.from_results').html(data);
								$('.from_results .places').first().addClass('selected');
								if ($('#from').is(':focus')) {
									$('.from_results').show();
									$('.from_results .places').click(function() {
										$('.from_results .places').removeClass('selected');
										$(this).addClass('selected');
										var id = $(this).attr('data-id');
										var country = $(this).attr('data-country');
										var is_country = $(this).attr('data-is-country');
										var value = $(this).text();
										if (value != 'нет результатов') {
											$('input[name=from_id]').val(id);
											$('input[name=from_is_country]').val(is_country);
											$('input[name=from]').val(value);
											$('input[name=from_hidden]').val(value);
											$('.from_results').hide();
											// back_searcher_check();
											if (typeof search_freights !== 'undefined' && $.isFunction(search_freights)) {
												search_freights();
											}
										} else {
											$('input[name=from_id]').val('');
											$('input[name=from]').val('');
											$('input[name=from_hidden]').val('');
											// back_searcher_check();
										}
									});
								} else {
									set_selected_val('from');
									// back_searcher_check();
									if (typeof search_freights !== 'undefined' && $.isFunction(search_freights)) {
										search_freights();
									}
								}
							} else {
								alert('При выполнении запроса на сервере произошла ошибка');
							}
						}
					});
				} else {
					$('.from_results').hide();
				}
			}, 400);
		}
	});
	// 
	$('#to').on('keyup', function(event) {
		if (event.which !== 37 && event.which !== 38 && event.which !== 39 && event.which !== 40 && (event.which < 33 || event.which > 36)) {
			clearTimeout(toTimeout);
			var string = $(this).val();
			toTimeout = setTimeout(function() {
				var len = string.length;
				if (len >= 0) {
					if (len == 0) {
						$('input[name=to_id]').val('');
						$('input[name=to]').val('');
						$('input[name=to_hidden]').val('');
						$('.to_results').hide();
						$('.to_results').text('');
						search_freights();
						return false;
					}
					$.ajax({
						type: 'POST',
						url: '/wp-content/themes/transradar/ajax_processor.php',
						// dataType: 'json',  // Тип данных, в которых сервер должен прислать ответ
						data: 'action=get_location_list&string=' + string,
						error: function() {
							alert('При выполнении запроса произошла ошибка');
						},
						success: function(data) {
							// console.log(data);
							if (data != 'error') {
								$('.to_results').html(data);
								$('.to_results .places').first().addClass('selected');
								if ($('#to').is(':focus')) {
									$('.to_results').show();
									$('.to_results .places').click(function() {
										$('.to_results .places').removeClass('selected');
										$(this).addClass('selected');
										var id = $(this).attr('data-id');
										var is_country = $(this).attr('data-is-country');
										var value = $(this).text();
										if (value != 'нет результатов') {
											$('input[name=to_id]').val(id);
											$('input[name=to_is_country]').val(is_country);
											$('input[name=to]').val(value);
											$('input[name=to_hidden]').val(value);
											$('.to_results').hide();
											if (typeof search_freights !== 'undefined' && $.isFunction(search_freights)) {
												search_freights();
											}
										} else {
											$('input[name=to_id]').val('');
											$('input[name=to]').val('');
											$('input[name=to_hidden]').val('');
										}
									});
								} else {
									var id = $('.to_results .places.selected').attr('data-id');
									var value = $('.to_results .places.selected').text();
									$('input[name=to_id]').val(id);
									$('input[name=to]').val(value);
									$('input[name=to_hidden]').val(value);
									if (typeof search_freights !== 'undefined' && $.isFunction(search_freights)) {
										search_freights();
									}
								}
							} else {
								alert('При выполнении запроса на сервере произошла ошибка');
							}
						}
					});
				} else {
					$('.to_results').hide();
				}
			}, 400);
		}
	});
	// 
	$('#from, #to, .form_submit').on('focus', function() {
		set_selected_val('from');
		set_selected_val('to');
	});
	// 
	$('.clear_from').on('click', function() {
		$('input[name=from_id]').val('');
		$('input[name=from]').val('');
		$('#search_back').prop('checked', false);
		// $(this).removeClass('active');

		$('.from_results').html('<div class="places">нет результатов</div>');
		// back_searcher_check();
		if (typeof search_freights !== 'undefined' && $.isFunction(search_freights)) {
			search_freights();
		}
	});
	// 
	$('.clear_to').on('click', function() {
		$('input[name=to_id]').val('');
		$('input[name=to]').val('');
		$('.to_results').html('<div class="places">нет результатов</div>');
		if (typeof search_freights !== 'undefined' && $.isFunction(search_freights)) {
			search_freights();
		}
	});
	//--------------- hovers --------------------
	$('.info').on({
		mouseenter: function() {
			$(this).children('.popup').show();
		},mouseout: function() {
			$(this).children('.popup').hide();
		}
	});
	//--------------- clicks --------------------
	$('.curr_box > a').on('click', function() {
		var name = $(this).text();
		var id = $(this).attr('data-id');
		Cookies.set('currency', name, { expires: 30, path: '/' });
		Cookies.set('currency_id', id, { expires: 30, path: '/' });
		calculate_currency(id, name);
		$('.currency').attr('data-content', name);
		// $('head').append('<style>.currency::before { content: "'+name+'";}</style>');
	});
	// 
	$('.currency').on('click', function() {
		$('.popup,.popup2').not('.curr_box').hide()
		$('.curr_box').toggle();
		return false;
	});
	// $('.currency > span')..on('click', function() {
	//   $('.curr_box').show();
	//   $('.menu_box').hide();
	// });
	// 
	$('.menu').on('click', function() {
		$('.popup,.popup2').not('.menu_box').hide()
		$('.menu_box').toggle();
		return false;
	});
	// 
	$('.not_logged').on('click', function() {
		$('.reg').toggle();
	});
	// 
	$('.logged').on('click', function() {
		$(this).children('.popup').show();
		return false;
	});
	// 
	$('.sign_close').on('click', function() {
		$('.reg').toggle();
	});
	// 
	$('#sign_in_link').on('click', function() {
		$('.login_box').show();
		$('.reg_box').hide();
	});
	// 
	$('#reg_link').on('click', function() {
		$('.login_box').hide();
		$('.reg_box').show();
	});
	// 
	$('#forgot').on('click', function() {
		$('.login_box').toggle();
		$('.remind_box').toggle();
	});
	// 
	$('#remind').on('click', function() {
		$('.remind_box').toggle();
		$('.confirm_box').toggle();
	});
	// 
	$('#conf_close').on('click', function() {
		$('.reg').toggle();
		$('.confirm_box').toggle();
		$('.login_box').show();
	});
	// 
	$('#remember_l').on('click', function() {
		if ($(this).hasClass('active')) {
			$(this).removeClass('active');
			$('#remember').prop('checked', false);
		} else {
			$(this).addClass('active');
			$('#remember').prop('checked', true);
		}
	});
	// 
	$('.check_for').on('click', function() {
		if ($(this).hasClass('active')) {
			$(this).removeClass('active');
			$(this).parent().css('background', '#FF9100');
		} else {
			$(this).addClass('active');
			$(this).parent().css('background', '#206EB6');
			return false;
		}
	});	
	d.on('keydown', function(e) {
		switch (e.which) {
			case 38: // up
				if ($('#from').is(':focus') && $('.from_results').is(':visible')) {
					var item = $('.from_results .places.selected');
					if (item.prev().hasClass('places')) {
						item.removeClass('selected').prev().addClass('selected');
					} else {
						item.removeClass('selected');
						$('.from_results .places').last().addClass('selected');
					}
				} else if ($('#to').is(':focus') && $('.to_results').is(':visible')) {
					var item = $('.to_results .places.selected');
					if (item.prev().hasClass('places')) {
						item.removeClass('selected').prev().addClass('selected');
					} else {
						item.removeClass('selected');
						$('.to_results .places').last().addClass('selected');
					}
				}
				break;
			case 40: // down
				if ($('#from').is(':focus') && $('.from_results').is(':visible')) {
					var item = $('.from_results .places.selected');
					if (item.next().hasClass('places')) {
						item.removeClass('selected').next().addClass('selected');
					} else {
						item.removeClass('selected');
						$('.from_results .places').first().addClass('selected');
					}
				} else if ($('#to').is(':focus') && $('.to_results').is(':visible')) {
					var item = $('.to_results .places.selected');
					if (item.next().hasClass('places')) {
						item.removeClass('selected').next().addClass('selected');
					} else {
						item.removeClass('selected');
						$('.to_results .places').first().addClass('selected');
					}
				}
				break;
			case 9: //tab
				$('.popup, .popup2').hide();

				if ($('#from').is(':focus') && $('.from_results').is(':visible')) {
					set_selected_val('from');
					$('#to').focus();
					// back_searcher_check();
					if (typeof search_freights !== 'undefined' && $.isFunction(search_freights)) {
						search_freights();
					}
				}
				if ($('#to').is(':focus') && $('.to_results').is(':visible')) {
					set_selected_val('to');
					$('.form_submit').focus();
					// back_searcher_check();
					if (typeof search_freights !== 'undefined' && $.isFunction(search_freights)) {
						search_freights();
					}
				}
				if ($('.form_submit').is(':focus')) {
					// back_searcher_check();
					$('.main_form').submit();
				}
				break;
			case 13:
				if ($('#from').is(':focus') && $('.from_results').is(':visible')) {
					set_selected_val('from');
					$('#to').focus();
					// back_searcher_check();
					if (typeof search_freights !== 'undefined' && $.isFunction(search_freights)) {
						search_freights();
					}
				}
				if ($('#to').is(':focus') && $('.to_results').is(':visible')) {
					set_selected_val('to');
					$('.form_submit').focus();
					// back_searcher_check();
					if (typeof search_freights !== 'undefined' && $.isFunction(search_freights)) {
						search_freights();
					}
				}
				if ($('.form_submit').is(':focus')) {
					// back_searcher_check();
					$('.main_form').submit();
				}
				break;

			default:
				// back_searcher_check();
				return; // exit this handler for other keys
		}
		e.preventDefault(); // prevent the default action (scroll / move caret)
	});
	// От Павла 
	// закрытие всех попапов по клику вне попапа
	d.on('click', function(e) {
		// 
		var target = $(e.target), exclude = target.parents('.popup,.popup2');
		// if(target.hasClass('filter')) exclude.add($(e.target).children('.popup,.popup2'));
		// 
		$('.popup,.popup2').not(exclude).hide();
		if(!exclude.length){
			$('.fake').hide();
			$('.from_results').hide();
			$('.to_results').hide();
			// $('#popup_select_sort').hide();
			$('.active_input').removeClass('active_input');
			// e.stopPropagation();
		}
		// 
		if (!$(e.target).children('.show-popup-top > .popup').length) {
			$('span').removeClass('show-popup-top');
			$('div').removeClass('show-popup-top');
			$('p').removeClass('show-popup-top');
			// e.stopPropagation();
		}
	});
});