// -- initional search params start --------------
function collect_params() {
	var all, selected, sites_all, sites_selected;
	// calculate sub-categories
	var tlm = '';	//Truck (sub-types) loading methods of a truck body type specified as id parameter. Parameter value is a bit mask.
	var tbt_sum = ''; //Truck body types. Parameter value is a bit mask
	var exch = ''; //Exchanges (sites). Parameter value is a bit mask
	var count = 10; // The number of freights to be retrieved per page, up to a maximum of 50. Default value is 10. See Pagination for more information.
	var pfid = $('input[name=from_id]').val(); // Place from id.
	var pfra = $('input[name=ratio_from]').val(); // Place from radius around. Default value is 50.
	var ptid = $('input[name=to_id]').val(); // Place to id.
	var ptra = $('input[name=ratio_to]').val(); // Place to radius around. Default value is 50.
	var pfwc = $('input[name=search_inside_from]').is(':checked')?'':0; // Place from within country. Default value is 1.
	var ptwc = $('input[name=search_inside_to]').is(':checked')?'':0; // Place to within country. Default value is 1.
	var soem = $('input[name=strict_search_check]').is(':checked')?'':0; // Search options exact match. Default value is 1.
	var ffid = $('input[name=choosed_direct_id]').val();
	var back_sdmn = '';
	var back_sdmx = '';
	var sddm = '';
	var sdid = '';
	var rcid = ''; //Reward currency id.
	var ramn = ''; //Reward amount min.
	var ramx = ''; //Reward amount max.
	var dcmn = '';
	var dcmx = ''; //Date created max.
	var dmn = '';
	var dmx = '';
	var sdmn = '';
	var sdmx = '';
	var wmn = '';
	var wmx = '';
	var vmn = '';
	var vmx = '';
	var sort_fav = '';
	var sort_from = '';
	var sort_to = '';
	var tbt = '';
	var adr = $('input[name=search_danger]').is(':checked')?1:''; //search even danger
	var some_splitted = [];
	// 
	if ($('[name=load_date_from]').val() != '') {
		some_splitted = $('[name=load_date_from]').val().split('.');
		sdmn = some_splitted[1] + '/' + some_splitted[0] + '/' + some_splitted[2]; //Shipping date min.
	}
	if ($('[name=load_date_to]').val() != '') {
		some_splitted = $('[name=load_date_to]').val().split('.');
		sdmx = some_splitted[1] + '/' + some_splitted[0] + '/' + some_splitted[2]; //Shipping date max.
	}
	// 
	if(pfra == 50) pfra = '';
	if(ptra == 50) ptra = '';
	// 
	if ($('#search_back').is(':checked')) {
		if ($('.back_date_button').css('display') == 'block') {
			if ($('[name=back_date_from]').val() != '') {
				some_splitted = $('[name=back_date_from]').val().split('.');
				back_sdmn = some_splitted[1] + '/' + some_splitted[0] + '/' + some_splitted[2]; //Shipping back date min.
			}
			if ($('[name=back_date_to]').val() != '') {
				some_splitted = $('[name=back_date_to]').val().split(".");
				back_sdmx = some_splitted[1] + '/' + some_splitted[0] + '/' + some_splitted[2]; //Shipping back date max.
			}
		} else {
			sddm = $('input[name=probeg]').val(); // Shipping date daily mileage. If and only if either sddm or sdid parameter is specified, shipping date is calculated. Otherwise shipping date is defined by sdmn and sdmx parameters. Default value is 1000.
			sdid = $('input[name=koridor]').val(); // Shipping date idle days. If and only if either sddm or sdid parameter is specified, shipping date is calculated. Otherwise shipping date is defined by sdmn and sdmx parameters. Default value is 7.
		}
	}
	// 
	if ($('#long_from').val() > 0) {
		dmn = $('#long_from').val(); //Distance min.
	}
	// 
	if ($('#long_to').val() != 2000 || $('#long_to').next().text() != '+ км') {
		dmx = $('#long_to').val(); //Distance max.
	}
	// 
	if ($('#weight_from').val() > 0) {
		wmn = $('#weight_from').val(); //Weight min.
	}
	// 
	if ($('#weight_to').val() != 30 || $('#weight_to').next().text() != '+ т') {
		wmx = $('#weight_to').val(); //Weight max.
	}
	// 
	if ($('#volume_from').val() > 0) {
		vmn = $('#volume_from').val(); //Volume min.
	}
	// 
	if ($('#volume_to').val() != 100 || $('#volume_to').next().text() != '+ м') {
		vmx = $('#volume_to').val(); //Volume max.
	}
	// 
	if ($('input[name=date_search_check]').is(':checked')) {
		dcmn = $('.date_search').attr('data-time'); //Date created min.
	}
	// 
	sort_from = $('.filter_pop a.acty_filter');
	if (!sort_from.length) sort_from = '';
	else if(sort_from.hasClass('asc')) sort_from = sort_from.attr('data-sort');
	else sort_from = '-'+sort_from.attr('data-sort');
	// 
	sort_to = $('.filter_pop_orange a.acty_filter');
	if (!sort_to.length) sort_to = '';
	else if(sort_to.hasClass('asc')) sort_to = sort_to.attr('data-sort');
	else sort_to = '-'+sort_to.attr('data-sort');
	// 
	sort_fav = $('.filter_pop_green a.acty_filter');
	if (!sort_fav.length) sort_fav = '';
	else if(sort_fav.hasClass('asc')) sort_fav = sort_fav.attr('data-sort');
	else sort_fav = '-'+sort_fav.attr('data-sort');

	// if ($('.filter_pop_orange a.acty_filter').attr('data-sort')) {
	// 	if ($('.filter_pop_orange a.acty_filter').hasClass('asc')) {
	// 		sort_to = $('.filter_pop_orange a.acty_filter').attr('data-sort');
	// 	} else {
	// 		sort_to = '-' + $('.filter_pop_orange a.acty_filter').attr('data-sort');
	// 	}
	// }
	// if ($('.filter_pop_green a.acty_filter').attr('data-sort')) {
	// 	if ($('.filter_pop_green a.acty_filter').hasClass('asc')) {
	// 		sort_fav = $('.filter_pop_green a.acty_filter').attr('data-sort');
	// 	} else {
	// 		sort_fav = '-' + $('.filter_pop_green a.acty_filter').attr('data-sort');
	// 	}
	// }
	
	$('.body_types_box .sub_body').each(function(){
		var sub_body			= $(this);
		var sub_body_sum		= 0;
		var sub_body_max		= sub_body.find('input');
		var sub_body_selected	= sub_body_max.filter(':checked');
		var id					= sub_body.attr('data-id');
		if(!sub_body_selected.length){
			// set parent check off
			sub_body.prev().removeClass('not-full-select').find('input').prop('checked', false).parent('label').removeClass('active');
		} else if(sub_body_selected.length == sub_body_max.length){
			// set parent check on
			sub_body.prev().removeClass('not-full-select').find('input').prop('checked', true).parent('label').addClass('active');
		} else {
			// set parent check on and class not-full-select
			sub_body.prev().addClass('not-full-select').find('input').prop('checked', true).parent('label').addClass('active');
		}
		// 
		sub_body_selected.each(function(){
			sub_body_sum = sub_body_sum | $(this).attr('data-flag');
		});
		if(sub_body_sum) tlm += 'tlm'+id+'='+sub_body_sum+'/';
	}) 
	all = $('.body_types_box .check_body input');
	selected = all.filter(':checked');
	// calculate categories
	selected.each(function(){
		tbt = tbt | $(this).attr('data-flag');
	});
	// 
	sites_all		= $('.site_search_box .check_site input');
	sites_selected	= sites_all.filter(':checked');
	sites_selected.each(function(){
		exch = exch | $(this).attr('data-flag');
	});
	// set counter
	$('#bodies_selected').text(selected.length > 0?selected.length:all.length);
	$('#sites_selected').text(sites_selected.length > 0?sites_selected.length:sites_all.length);
	// set button text
	$('#check_all_bodies').text(selected.length && selected.length <= all.length?'Убрать выбранное':'Выбрать все');
	$('#check_all_sites').text(sites_selected.length && sites_selected.length <= sites_all.length?'Убрать выбранное':'Выбрать все');
	// 

	var filters = {
		action: 'search',
		cursor: cursor,
		count: count,
		pfid: pfid,
		pfra: pfra,
		pfwc: pfwc,
		ptid: ptid,
		ptra: ptra,
		ptwc: ptwc,
		sdmn: sdmn,
		sdmx: sdmx,
		back_sdmn: back_sdmn,
		back_sdmx: back_sdmx,
		sddm: sddm,
		sdid: sdid,
		dmn: dmn,
		dmx: dmx,
		tbt: tbt,
		tlm: tlm,
		adr: adr,
		wmn: wmn,
		wmx: wmx,
		vmn: vmn,
		vmx: vmx,
		rcid: rcid,
		ramn: ramn,
		ramx: ramx,
		exch: exch,
		dcmn: dcmn,
		dcmx: dcmx,
		soem: soem,
		ffid: ffid,
		sort_from: sort_from,
		sort_to: sort_to,
		sort_fav: sort_fav,
		choosed_direct_id: $('input[name=choosed_direct_id]').val(),
		choosed_direct_addr_from: $('input[name=choosed_direct_addr_from]').val(),
		choosed_direct_addr_to: $('input[name=choosed_direct_addr_to]').val(),
		choosed_direct_date_from: $('input[name=choosed_direct_date_from]').val(),
		choosed_direct_date_to: $('input[name=choosed_direct_date_to]').val(),
		choosed_direct_distance: $('input[name=choosed_direct_distance]').val(),
		to_is_country: $('input[name=to_is_country]').val(),
		from_is_country: $('input[name=from_is_country]').val(),
	};
	return filters;
}
// -- initional search params end ----------------
function details_opener() {
	var elem = $(this).parents('.notice').eq(0),
		window_element = elem.parents('.window_content').eq(0),
		parent = window_element.parent(),
		active = parent.children('.active')
	;
	var map_obj = elem.parent().next().find('.map');
	if (map_obj.text() == 'loading') {
		draw_map(map_obj);
	}
	if (elem.hasClass('closen')) {
		elem.parent().next().slideDown(150, function() {
			elem.parents('.mCustomScrollbar').mCustomScrollbar('scrollTo', window_element, {
				scrollEasing: "easeOut",
				scrollInertia: 500
			});
			parent.css('padding-top', active.length?active.outerHeight(true):'');
		});
		elem.removeClass('closen text-overflow');
	} else {
		elem.addClass('closen text-overflow');
		elem.parent().next().slideUp(150, function(){
			parent.css('padding-top', active.length?active.outerHeight(true):'');
		});
	}
}
// 
function draw_map(map_obj) {
	var from_id = map_obj.attr('data-from_id');
	var to_id = map_obj.attr('data-to_id');

	$.ajax({
		type: "POST",
		url: "/wp-content/themes/transradar/ajax_processor.php",
		data: 'action=direction&from=' + from_id + '&to=' + to_id,
		error: function() {
			alert('При выполнении запроса произошла ошибка');
		},
		success: function(data) {
			// console.log(data);
			if (data != 'error') {
				map_obj.html(data);
			} else {
				alert('При выполнении запроса на сервере произошла ошибка');
			}
		}
	});
}
// 
function redraw_markers(){
	var can_see_main		= $('.toggler-map-main').is(':checked');		// основные
	var can_see_back		= $('.toggler-map-back').is(':checked');		// основные пункты назначения (destination_count)
	var can_see_origin_main = false, can_see_origin_back = false;
	var can_see_destination_main = false, can_see_destination_back = false;
	var locations;
	if(can_see_main) {
		can_see_origin_main			= $('.toggler-map-main-from').is(':checked');	// основные пункты отправления
		can_see_destination_main	= $('.toggler-map-main-to').is(':checked');		// основные пункты назначения (destination_count)
	}
	if(can_see_back) {
		can_see_origin_back			= $('.toggler-map-back-from').is(':checked');	// основные пункты назначения (destination_count)
		can_see_destination_back	= $('.toggler-map-back-to').is(':checked');		// основные пункты назначения (destination_count)
	}
	// set new locations
	if(!map_params['locations']) locations = [];
	else locations = map_params['locations'].map(function(apilocation, i){
		var origin_counts = 0;				// пункты отправления
		var destination_counts = 0; 		// пункты назначения
		var origin_gruz_class = '';
		var destination_gruz_class = '';
		// 
		if(can_see_origin_main && can_see_origin_back && (
			(apilocation.origin_counts[0] && apilocation.origin_counts[1])
			|| apilocation.origin_counts[2]
		)) {
			// show polymorph
			origin_gruz_class = 'label-gruz-origin-main-back';
			origin_counts = apilocation.origin_counts[0] + apilocation.origin_counts[1] + apilocation.origin_counts[2];
		} else if(can_see_origin_main && (apilocation.origin_counts[0] || apilocation.origin_counts[2])) {
			// if there is only origin_count[0] (main)
			origin_gruz_class = 'label-gruz-origin-main';
			origin_counts = apilocation.origin_counts[0] + apilocation.origin_counts[2];
		} else if(can_see_origin_back && (apilocation.origin_counts[1] || apilocation.origin_counts[2])) {
			// if there is only origin_count[1] (back)
			origin_gruz_class = 'label-gruz-origin-back';
			origin_counts = apilocation.origin_counts[1] + apilocation.origin_counts[2];
		}
		// generate class for destination
		if(can_see_destination_main && can_see_destination_back && (
			(apilocation.destination_counts[0] && apilocation.destination_counts[1])
			|| apilocation.destination_counts[2]
		)) {
			// show polymorph
			destination_gruz_class = 'label-gruz-destination-main-back';
			destination_counts = apilocation.destination_counts[0] + apilocation.destination_counts[1] + apilocation.destination_counts[2];
		} else if(can_see_destination_main && (apilocation.destination_counts[0] || apilocation.destination_counts[2])) {
			// if there is only destination_count[0] (main)
			destination_gruz_class = 'label-gruz-destination-main';
			destination_counts = apilocation.destination_counts[0] + apilocation.destination_counts[2];
		} else if(can_see_destination_back && (apilocation.destination_counts[1] || apilocation.destination_counts[2])) {
			// if there is only destination_count[1] (back)
			destination_gruz_class = 'label-gruz-destination-back';
			destination_counts = apilocation.destination_counts[1] + apilocation.destination_counts[2];
		}
		// 
		return {
			position: apilocation.location,
			origin_counts: origin_counts,
			destination_counts: destination_counts,
			origin_gruz_class: origin_gruz_class,
			destination_gruz_class: destination_gruz_class
		};
	});
	// update clusterer markers
	if(markerClusterer) markerClusterer.redraw({
		markers: locations
	}); else {
		// create clusterer only once
		markerClusterer = new MakanoClusterer({
			map: google_map,
			markers: locations,
			onAddMarer: function(){
				
			}
		});
	}
}
// 
function search_gps_freights(){
	var new_params = collect_params();
	// get settings of visible objects
	new_params['action'] = 'get_gps_locations';
	new_params['count'] = '1000';
	// get initial map bounds
	if(map_params['boundsInit']) {
		map_params['boundsInit'] = map_params['boundsInit'].extend(google_map.getBounds().getNorthEast());
		map_params['boundsInit'] = map_params['boundsInit'].extend(google_map.getBounds().getSouthWest());
		var mapBounds_upleft	= map_params['boundsInit'].getNorthEast().toJSON();
		var mapBounds_downright = map_params['boundsInit'].getSouthWest().toJSON();
		new_params['bounds']	= mapBounds_downright.lat+','+mapBounds_downright.lng+'|'+mapBounds_upleft.lat+','+mapBounds_upleft.lng;
	}
	// 
	$.ajax({
		type: "POST",
		url: "/wp-content/themes/transradar/ajax_processor.php",
		dataType: "json", // Тип данных, в которых сервер должен прислать ответ
		data: $.param(new_params),
		error: function() {
			alert('При выполнении запроса произошла ошибка');
		},
		success: function(data) {
			if(!data) return;
			console.log('Send to API (gps): ', data.params, 'List: ', data.list);
			map_params['locations'] = data.list;
			// save zoom and bounds of new search
			map_params['zoomInit'] = google_map.getZoom();
			map_params['boundsInit'] = google_map.getBounds();
			redraw_markers();
		}
	});
}
//--------------- main search functions start ----
function search_freights(e) {
	clearTimeout(search_delay);
	search_delay = setTimeout(function() {
		cursor = '0';
		var new_params = collect_params();
		var parent = $('.main_content .mCSB_container');
		var active = parent.children('.active').css('top', '');
		var is_back_need_change = $('[name=search_back]:checked').length;
		var name_changed;
		parent.children().remove();
		parent.append(active, '<div class="white_text">Загрузка...<br><img src="/wp-content/themes/transradar/img/ajax-loader.gif" alt=""></div>');
		// "active is absent" and change "main filter dates" with back filter "by dates" - trigger only backlist
		if(is_back_need_change && e && e.target) {
			name_changed = $(e.target).attr('name');
			if(
				(
					name_changed == 'load_date_from' ||
					name_changed == 'load_date_to'
				)
				&& $('.back_date_search #label').text() == 'Поиск по дате'
				&& !active.length
			)
			is_back_need_change = false;
		}
		// 
		if(is_back_need_change) {
			$('.back_content .mCSB_container').html('<div class="white_text">Загрузка...<br><img src="/wp-content/themes/transradar/img/ajax-loader.gif" alt=""></div>');
		}
		search_gps_freights();
		$.ajax({
			type: "POST",
			url: "/wp-content/themes/transradar/ajax_processor.php",
			dataType: "json", // Тип данных, в которых сервер должен прислать ответ
			data: $.param(new_params),
			error: function() { alert('При выполнении запроса произошла ошибка'); },
			success: function(data) {
				var fn_renew = function(){
					if (data != 'error') {
						next_cursor = data.freights_cursor;
						// console.log(next_cursor);
						$('.main .window_title .quantity').html(data.freights_count);
						parent.children('.white_text').remove();
						parent.append(data.result_html).css('padding-top', active.length?active.outerHeight(true):'');
						$('.main_content').mCustomScrollbar("update");
						if (next_cursor == '0') {
							if ($('.main_content').find('.white_text').text() != 'Грузов не найдено') {
								$('.main_content').find('.white_text').remove();
							}
						}
					} else {
						alert('При выполнении запроса на сервере произошла ошибка');
					}
				}
				// 
				if(!data) return;
				console.log('Send to API: ', data.params);
				// 
				if(data && data.choosed_is_match_filter < 0) {
					$('.back_content .mCSB_container').html('<div class="white_text">Основной груз не соответствует фильтрам</div>');
					$('.back .window_title .quantity').html(0);
					active.addClass('warning');
				} else if(data.choosed_is_match_filter > 0) {
					active.removeClass('warning');
				} else {
					active.removeClass('warning');
				}
				// set new index of active freight
				if(typeof data.xffi != 'undefined') active.attr('data-last-index', data.xffi + (data.xffi >=0 ?1:0));
				// if "active is NOT selected" || "active selected and matches filters" - update "back list"
				if(is_back_need_change && active.length && !active.hasClass('warning')) {
					search_back_freights(fn_renew);
				} else if (is_back_need_change && !active.length) {
					search_back_freights(fn_renew);
				} else fn_renew();
			}
		});
	}, 1000);
}
// 
function search_back_freights(onafter='') {
	var fn_sendajax = function() {
		cursor = '0';
		var new_params = collect_params();
		new_params['back'] = 'true';
		$('.back_content .mCSB_container').html('<div class="white_text">Загрузка...<br><img src="/wp-content/themes/transradar/img/ajax-loader.gif" alt=""></div>');
		search_gps_freights();
		$.ajax({
			type: "POST",
			url: "/wp-content/themes/transradar/ajax_processor.php",
			dataType: "json", // Тип данных, в которых сервер должен прислать ответ
			data: $.param(new_params),
			error: function() {
				alert('При выполнении запроса произошла ошибка');
			},
			success: function(data) {
				if(!data) return;
				console.log('Send to API (back): ', data.params);
				if(typeof onafter == 'function') onafter();
				if(data != 'error') {
					next_back_cursor = data.freights_cursor
					$('.back .window_title .quantity').html(data.freights_count);
					$('.back_content .mCSB_container').html(data.result_html);
					$('.back_content').mCustomScrollbar('update');
				} else {
					alert('При выполнении запроса на сервере произошла ошибка');
				}
				if(next_back_cursor == '0') {
					if ($('.back_content').find('.white_text').text() != 'Грузов не найдено') {
						$('.back_content').find('.white_text').remove();
					}
				}
			}
		});
	}
	clearTimeout(search_back_delay);
	if(!$('#search_back').is(':checked')) {
		if(typeof onafter == 'function') onafter();
		return;
	}
	search_back_delay = setTimeout(fn_sendajax, 1000);
}
// ----------- search on scroll start ------------
function show_next_results() {
	if (process_state == '0' && next_cursor != '0') {
		process_state = '1';
		cursor = next_cursor;
		var new_params = $.param(collect_params());
		var parent = $('.main_content .mCSB_container');
		var active = parent.children('.active');
		var active_xffi = parseInt(active.attr('data-last-index'));
		parent.children('.white_text').show();
		parent.parents('.mCustomScrollbar').eq(0).mCustomScrollbar('scrollTo', parent.height());
		// 
		$.ajax({
			type: "POST",
			url: "/wp-content/themes/transradar/ajax_processor.php",
			dataType: "json",
			data: new_params,
			error: function() {
				alert('При выполнении запроса произошла ошибка');
			},
			success: function(data) {
				if(data && data.params) console.log('Send to API: ', data.params);
				// renew index of active freight if it == -1
				if(typeof data.xffi != 'undefined' && data.xffi >=0 && active_xffi < 0) 
					active.attr('data-last-index', parent.children('.window_content').length + data.xffi);
				if (data != 'error') {
					next_cursor = data.freights_cursor;
					parent.children('.white_text').remove();
					parent.append(data.result_html);
					$('.main_content').mCustomScrollbar("update");
				} else {
					alert('При выполнении запроса на сервере произошла ошибка');
				}
				process_state = '0';
				if (next_cursor == '0') {
					$('.main_content').find('.white_text').remove();
				}
			}
		});
	} else console.log('in progress...');
}
// 
function show_next_back_results() {
	if (back_process_state == '0' && next_back_cursor != '0') {
		back_process_state = '1';
		cursor = next_back_cursor;
		var new_params = collect_params();
		var parent = $('.back_content .mCSB_container');
		new_params['back'] = 'true';
		parent.children('.white_text').show();
		parent.parents('.mCustomScrollbar').eq(0).mCustomScrollbar('scrollTo', parent.height());
		$.ajax({
			type: "POST",
			url: "/wp-content/themes/transradar/ajax_processor.php",
			dataType: "json",
			data: $.param(new_params),
			error: function() {
				alert('При выполнении запроса произошла ошибка');
			},
			success: function(data) {
				if(data && data.params) console.log('Send to API: ', data.params);
				if (data != 'error') {
					next_back_cursor = data.freights_cursor;
					$('.back_content').find('.white_text').remove();
					$('.back_content').find('.window_content').last().after(data.result_html);
					$('.back_content').mCustomScrollbar("update");
				} else {
					alert('При выполнении запроса на сервере произошла ошибка');
				}
				back_process_state = '0';
				if (next_back_cursor == '0') {
					$('.back_content').find('.white_text').remove();
				}
			}
		});
	} else console.log('in progress...');
}
// Минимальная высота контейнера с картой
function setMineMinHeight() {
	var window_h = $(window).height();
	var footer_h = $('.footer').outerHeight();
	var h = window_h - footer_h - $('.search').offset().top;
	var cont = h - 90;
	var box = window_h - footer_h - $('.filters_main').outerHeight() - $('.body_type_footer clearfix').outerHeight() - $('.site_seach_title').outerHeight() - 150;
	$('.search').css('min-height', h);
	$('.body_types_box').css('max-height', box);

	$('.main_content').css('height', cont);
	$('.back_content').css('height', cont);
	$('.favorite_content').css('height', cont);
	return false;
}
// 
function sizeMap() {
	$('#map,#map_canvas').css('height', $('.search').outerHeight()).css('width', $('.search').outerWidth());
}
// 
function map_initialize() {
	// Создаём карту
	google_map = new google.maps.Map(document.getElementById('map_canvas'), {
		zoom: 4,
		center: new google.maps.LatLng(50, 30),
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		zoomControl: true,
		zoomControlOptions: {
			position: google.maps.ControlPosition.RIGHT_BOTTOM
		},
		mapTypeControl: false,
		scaleControl: true,
		streetViewControl: false,
		rotateControl: true,
		fullscreenControl: false
	});
	// on zoomout - update info 
	// on drag map and zoom >= initial - update info 
	google.maps.event.addListener(google_map, 'click', function(e) {
		console.log('GPS', e.latLng.toJSON());
	});
	google.maps.event.addListener(google_map, 'idle', function() {
		// on move map and map bounds out of initial bounds - update markers and clusters
		// new zoom can have new filters
		if(
			map_params['boundsInit'] &&
			(
				google_map.getZoom() <= 2 ||
				!map_params['boundsInit'].contains(google_map.getBounds().getNorthEast()) ||
				!map_params['boundsInit'].contains(google_map.getBounds().getSouthWest())
			)
		){
			search_gps_freights();
		} else redraw_markers();
	});
}

var cursor = '0'; // Descriptor specifying a page of results to be retrieved. See Pagination for more information.
var next_cursor;
var next_back_cursor;
var search_delay = 0;
var search_back = 1;
var search_back_delay = 0;
var process_state = '0';
var back_process_state = '0';
var timeout;
var timeout_hover;
var google_map = '';
var markers = [];
var markers_back = [];
var map_params = {};
var markerClusterer = null;

$(function(){
	// 
	var d = $(document), w = $(window);
	// ------- on change refresh search set start ---------------
	// $('#search_inside_from, #search_inside_to').change(function() {
		// search_freights();
	// });
	// 
	d.on('keyup', 'input[name=probeg], input[name=koridor]', function() {
		search_back_freights();
	});
	// 
	d.on('mousedown', '.slider_mid', function() {
		$('.popup, .popup2').hide();
	});
	//--------------- hovers------------------
	d.on('mouseover', '.nav-tabs>li', function() {
		$(this).children(".down_blue").css('display', 'inline-block');
	});
	d.on('mouseout', '.nav-tabs>li', function() {
		$(this).children(".down_blue").css('display', 'none');
	});
	// 
	d.on('mouseenter', '.notify', function() {
		timeout_hover = setTimeout(function() {
			$(".right_tab .popup").show();
			return false;
		}, 500);
	})
	d.on('mouseout', '.notify', function() {
		clearTimeout(timeout_hover);
		$(".right_tab .popup").hide();
	});
	// 
	d.on('mouseenter', '.body_type_button', function() {
		timeout_hover = setTimeout(function() {
			$(".body_type .popup").show();
			return false;
		}, 500);
	})
	d.on('mouseout', '.body_type_button', function() {
		clearTimeout(timeout_hover);
		$(".body_type .popup").hide();
	});
	// 
	d.on('mouseenter', '.site_search_button', function() {
		timeout_hover = setTimeout(function() {
			$(".site_search .popup").show();
			return false;
		}, 500);
	});
	d.on('mouseout', '.site_search_button', function() {
		clearTimeout(timeout_hover);
		$(".site_search .popup").hide();
	});
	// 
	d.on('mouseenter', '.favorite .star', function() {
		var par = $(this);
		timeout_hover = setTimeout(function() {
			par.children(".favorite star .popup").show();
			return false;
		}, 500);
	});
	d.on('mouseout', '.favorite .star', function() {
		clearTimeout(timeout_hover);
		$(this).children(".favorite .star .popup").hide();
	});
	// 
	d.on('mouseenter', '.star', function() {
		var par = $(this);
		timeout_hover = setTimeout(function() {
			par.children('.star .popup').show();
			return false;
		}, 500);
	})
	d.on('mouseout', '.star', function() {
		clearTimeout(timeout_hover);
		$(this).children('.star .popup').hide();
	});
	// 
	d.on('mouseenter', '.filter', function() {
		var par = $(this);
		timeout_hover = setTimeout(function() {
			par.children('.popup2').show();
			return false;
		}, 500);
	})
	d.on('mouseout', '.filter', function() {
		clearTimeout(timeout_hover);
		$(this).children('.popup2').hide();
	});
	// 
	d.on('mouseenter', '.warn', function() {
		var par = $(this);
		timeout_hover = setTimeout(function() {
			par.children('.popup').show();
			return false;
		}, 500);
	})
	d.on('mouseout', '.warn', function() {
		clearTimeout(timeout_hover);
		$(this).children('.popup').hide();
	});
	// 
	d.on('mouseenter', '#search_inside_l_from', function() {
		var par = $(this);
		timeout_hover = setTimeout(function() {
			par.children('.popup').show();
			return false;
		}, 500);
	});
	d.on('mouseout', '#search_inside_l_from', function() {
		clearTimeout(timeout_hover);
		$(this).children('.popup').hide();
	});
	// 
	d.on('mouseenter', '#search_inside_l_to', function() {
		var par = $(this);
		timeout_hover = setTimeout(function() {
			par.children('.popup').show();
			return false;
		}, 500);
	})
	d.on('mouseout', '#search_inside_l_to', function() {
		clearTimeout(timeout_hover);
		$(this).children('.popup').hide();
	});
	// 
	// d.on('mouseenter', '.filter', function() {
	// 	obj = $(this);
	// 	subj = $('.popup_filter_hover');
	// 	timeout_hover = setTimeout(function() {
	// 		popup();
	// 		return false
	// 	}, 500);
	// })
	// d.on('mouseout', '.filter', function() {
	// 	clearTimeout(timeout_hover);
	// });
	// 
	d.on('mouseenter', '.minimize', function() {
		obj = $(this);
		subj = $('.popup_info_razvernut');
		if ($(this).hasClass('max')) {
			subj.text('Раскрыть список');
		} else { subj.text('Свернуть список'); }
		timeout_hover = setTimeout(function() {
			popup();
		}, 500);
	})
	d.on('mouseout', '.minimize', function() {
		clearTimeout(timeout_hover);
	});
	// 
	d.on('mouseenter', '.list_header .cursor_green', function(e) {
		obj = $(this);
		subj = $('.popup_info_razvernut');
		if (obj.parent().hasClass('open')) {
			subj.text('Свернуть список');
		} else { subj.text('Раскрыть список'); }
		timeout_hover = setTimeout(function() {
			popup();
			return false
		}, 500);
	})
	d.on('mouseout', '.list_header .cursor_green', function() {
		clearTimeout(timeout_hover);
	});
	// 
	d.on('mouseenter', '.add_fav', function(e) {
		obj = $(this);
		subj = $('.new_add_popup');
		timeout_hover = setTimeout(function() {
			popup();
			return false
		}, 500);
	})
	d.on('mouseout', '.add_fav', function() {
		clearTimeout(timeout_hover);
	});
	// 
	d.on('mouseenter', '.star_add', function() {
		obj = $(this);
		subj = $('.popup_star_add');
		timeout_hover = setTimeout(function() {
			popup();
			return false
		}, 500);
	})
	d.on('mouseout', '.star_add', function() {
		clearTimeout(timeout_hover);
	});
	// 
	d.on('mouseenter', '.warn', function() {
		obj = $(this);
		subj = $('.popup_warning');
		timeout_hover = setTimeout(function() {
			popup();
		}, 500);
	})
	// 
	d.on('mouseenter', '.star_del', function() {
		obj = $(this);
		subj = $('.popup_star_del');
		timeout_hover = setTimeout(function() {
			popup();
		}, 500);
	})
	d.on('mouseout', '.star_del', function() {
		clearTimeout(timeout_hover);
	});
	// 
	// d.on('mouseenter', '.filter.orange', function(e) {
	// 	obj = $(this);
	// 	subj = $('.popup_filter_hover_orange');
	// 	timeout_hover = setTimeout(function() {
	// 		popup();
	// 	}, 500);
	// });
	// d.on('mouseout', '.filter.orange', function() {
	// 	clearTimeout(timeout_hover);
	// });
	// 
	// d.on('mouseenter', '.filter.green', function(e) {
	// 	obj = $(this);
	// 	subj = $('.popup_filter_hover_green');
	// 	timeout_hover = setTimeout(function() {
	// 		popup();
	// 	}, 500);
	// });
	// d.on('mouseout', '.filter.green', function() {
	// 	clearTimeout(timeout_hover);
	// });
	//------------------ clicks -----------------------------
	d.on('change', '#toggle_check input', function(e) {
		if(!$(this).is(':checked')) {
			$('#hide_1,#hide_2,.params_search').hide();
			$('#search_not_active').show();
			$('.back').hide('slow');
			$('.window_content.active [data-back-filter]').trigger('click');
			// 
			if($('.toggler-group-back .label-gruz-parent input:checked').length)
				$('.toggler-group-back .label-gruz-parent').trigger('click');
			$('.toggler-group-back input').attr('disabled', 'disabled');
		} else {
			$('#hide_1,#hide_2').show();
			$('#search_not_active').hide();
			$('.back').show('slow');
			// 
			$('.toggler-group-back input').removeAttr('disabled');
			if(!$('.toggler-group-back .label-gruz-parent input:checked').length)
				$('.toggler-group-back .label-gruz-parent').trigger('click');
			// search_back_freights();
		}
	});
	// 
	d.on('click', '.date_search', function(e) {
		if(!$(e.target).hasClass('date_search')) return;
		$(this).children(".popup").toggle();
		return false;
	});
	// 
	d.on('click', '#load_from_line', function(e) {
		$('.popup,.popup2').not('.load_popup_from').hide();
		$('.load_popup_from').toggle();
		$('#load_from_line').addClass('active_input');
		$('#load_to_line').removeClass('active_input');
		return false;
	});
	// 
	d.on('click', '#load_to_line', function(e) {
		$('.popup,.popup2').not('.load_popup_to').hide();
		$('.load_popup_to').toggle();
		$('#load_to_line').addClass('active_input');
		$('#load_from_line').removeClass('active_input');
		return false;
	});
	// 
	d.on('click', '#back_from_line', function(e) {
		$('.popup,.popup2').not('.back_from_popup').hide();
		$('.back_from_popup').toggle();
		$('#back_from_line').addClass('active_input');
		$('#back_to_line').removeClass('active_input');
		return false;
	});
	// 
	d.on('click', '#back_to_line', function(e) {
		$('.popup,.popup2').not('.back_to_popup').hide();
		$('.back_to_popup').toggle();
		$('#back_to_line').addClass('active_input');
		$('#back_from_line').removeClass('active_input');
		return false;
	});
	// 
	d.on('click', '.start_date_cancel', function(e) {
		if(!$(e.target).hasClass('start_date_cancel')) return;
		$('#load_from_line').val('');
		$('.load_popup_from').hide();
		$('.active_input').removeClass('active_input');
		$('#date_picker_to').datepicker("option", "minDate", 0);
		if ($('.params_search').is(':visible')) {
			search_back = 1;
		} else {
			search_back = 0;
		}
		search_freights();
		return false;
	});
	// 
	d.on('click', '.end_date_cancel', function(e) {
		if(!$(e.target).hasClass('end_date_cancel')) return;
		$('#load_to_line').val('');
		$('.load_popup_to').hide();
		$('.active_input').removeClass('active_input');
		$('#date_picker_from').datepicker("option", "maxDate", null);
		if ($('.params_search').is(':visible')) {
			search_back = 1;
		} else {
			search_back = 0;
		}
		search_freights();
		return false;
	});
	// 
	d.on('click', '.back_start_date_cancel', function(e) {
		if(!$(e.target).hasClass('back_start_date_cancel')) return;
		$('#back_from_line').val('');
		$('.back_from_popup').hide();
		$('.active_input').removeClass('active_input');
		$('#back_date_to').datepicker("option", "minDate", 0);
		search_back_freights();
		return false;
	});
	// 
	d.on('click', '.back_end_date_cancel', function(e) {
		if(!$(e.target).hasClass('back_end_date_cancel')) return;
		$('#back_to_line').val('');
		$('.back_to_popup').hide();
		$('.active_input').removeClass('active_input');
		$('#back_date_from').datepicker("option", "maxDate", null);
		search_back_freights();
		return false;
	});
	// 
	d.on('click', '.site_search_button', function(e) {
		$('.popup,.popup2').not('.site_search_box').hide();
		$('.site_search_box').toggle();
		e.stopPropagation();
	});
	// 
	d.on('click', '.body_type_button', function(e) {
		$('.popup,.popup2').not('.body_box').hide();
		$('.body_box').toggle();
		e.stopPropagation();
	});
	// 
	d.on('click', '.sub_body_link', function(e) {
		if(!$(e.target).hasClass('sub_body_link')) return;
		$('.sub_body').toggle();
		if ($(this).hasClass('active')) {
			$(this).removeClass('active');
		} else {
			$(this).addClass('active');
		}
		return false;
	});
	// 
	d.on('click', '.body_more_link', function(e) {
		if(!$(e.target).hasClass('body_more_link')) return;
		$('.body_more').show();
		$('.body_more_link').hide();
		$('.body_less_link').show();
		return false;
	});
	// 
	d.on('click', '.body_less_link', function(e) {
		if(!$(e.target).hasClass('body_less_link')) return;
		$('.body_more').hide();
		$('.body_more_link').show();
		$('.body_less_link').hide();
		return false;
	});
	// 
	d.on('click', '.back_date_button', function(e) {
		if(!$(e.target).hasClass('back_date_button')) return;
		$('.load_date_button .popup').hide();
		$('.popup2').hide();
		// return false;
	});
	// 
	d.on('click', '.load_date_button', function(e) {
		if(!$(e.target).hasClass('load_date_button')) return;
		$('.back_date_button .popup').hide();
		$('.popup2').hide();
		// return false;
	});
	// 
	d.on('click', '#main_min', function(e) {
		var iscollapsed = $(this).toggleClass('max').hasClass('max'),
			main_content = $('.main_content');
		$('.popup,.popup2').hide();
		main_content.slideToggle();
		if(!iscollapsed)
			main_content.find('.active').css('top', '');
		return false;
	});
	// 
	d.on('click', '#back_min', function(e) {
		$('.popup,.popup2').hide();
		$('.back_content').slideToggle();
		$(this).toggleClass('max');
		return false;
	});
	// 
	d.on('click', '#fav_min', function(e) {
		if(!$(e.target).filter('#fav_min')) return;
		$(".favorite_content").slideToggle();
		if ($(this).hasClass('max')) {
			$(this).removeClass('max');
		} else {
			$(this).addClass('max');
		}
		return false;
	});
	// ----------- filters start ------------------
	d.on('click', '.filter.blue', function(e) {
		$('.popup,.popup2').not('.filter.blue .popup').hide();
		$('.filter.blue .popup').toggle();
		return false;
	});
	//
	d.on('click', '.filter.orange', function(e) {
		$('.popup,.popup2').not('.filter.orange .popup').hide();
		$('.filter.orange .popup').toggle();
		return false;
	});
	//
	d.on('click', '.filter_pop>a', function(e) {
		var th = $(this), parent_filter = th.parents('.filter').eq(0);
		process_state = '0';
		next_cursor = '';
		if (th.hasClass('acty_filter asc')) {
			th.removeClass('asc');
		} else if (th.hasClass('acty_filter')) {
			th.addClass('asc');
			$('.popup_filter_hover').text('Сортировка по возрастанию');
			parent_filter.attr('data-supertitle', 'Сортировка по возрастанию');
		} else {
			th.addClass('acty_filter').parent().children().not(th).removeClass('acty_filter asc');
			$('.popup_filter_hover').text('Сортировка ' + th.text());
			parent_filter.attr('data-supertitle', 'Сортировка ' + th.text());
		}
		search_freights();
		// $('.popup').hide();
		// return false; // hide all
	});
	// 
	d.on('click', '.filter_pop_orange>a', function(e) {
		var th = $(this), parent_filter = th.parents('.filter').eq(0);
		process_state = '0';
		next_cursor = '';
		if (th.hasClass('acty_filter asc')) {
			th.removeClass('asc');
		} else if (th.hasClass('acty_filter')) {
			th.addClass('asc');
			$('.popup_filter_hover').text('Сортировка по возрастанию');
			parent_filter.attr('data-supertitle', 'Сортировка по возрастанию');
		} else {
			th.addClass('acty_filter').parent().children().not(th).removeClass('acty_filter asc');
			$('.popup_filter_hover').text('Сортировка ' + th.text());
			parent_filter.attr('data-supertitle', 'Сортировка ' + th.text());
		}
		search_back_freights();
		// $('.popup').hide();
		// return false;
	});
	// 
	d.on('click', '.star_down', function(e) {
		if(!$(e.target).hasClass('star_down')) return;
		obj = $(this);
		subj = $('.popup_star_down');
		popup_click();
		return false;
	});
	// 
	d.on('click', '.gear_down', function(e) {
		if(!$(e.target).hasClass('gear_down')) return;
		obj = $(this);
		subj = $('.popup_gear_down');
		popup_click();
		return false;
	});
	// 
	d.on('click', '.other_box>.other', function(e) {
		$('.other_search_pro').toggle();
		var main_h = $('.main_content').css('height');
		var back_h = $('.back_content').css('height');
		// var fav_h = $('.favorite_content').css('height');
		main_h = parseInt(main_h.replace('px', ''));
		back_h = parseInt(back_h.replace('px', ''));
		// fav_h = fav_h.replace('px', '');
		if ($(this).hasClass('closen')) {
			$(this).removeClass('closen');
			$('.windows').css('margin-top', '');
			$('.main_content').css('height', (main_h + 31) + 'px');
			$('.back_content').css('height', (back_h + 31) + 'px');
			// $('.favorite_content').css('height', (fav_h-31)+'px');
			$('.main_content').mCustomScrollbar('update');
			$('.back_content').mCustomScrollbar('update');
		} else {
			$(this).addClass('closen');
			$('.windows').css('margin-top', '81px');
			$('.main_content').css('height', (main_h - 31) + 'px');
			$('.back_content').css('height', (back_h - 31) + 'px');
			// $('.favorite_content').css('height', (parseInt(fav_h)+31)+'px');
			$('.main_content').mCustomScrollbar("update");
			$('.back_content').mCustomScrollbar("update");
		}
		return false;
	});
	// 
	d.on('click', '.date_search .popup > a', function(e) {
		// console.log($(this).text());
		var date_search = $('.date_search'),
			now = date_search.attr('data-time');
		date_search.removeClass('date_24 date_1 date_6 date_3 date_7 date_2');
		switch ($(this).text()) {
			case '1 час':
				date_search.addClass('date_1').attr('data-time', '1h');
				break;
			case '6 часов':
				date_search.addClass('date_6').attr('data-time', '6h');
				break;
			case '24 часа':
				date_search.addClass('date_24').attr('data-time', '24h');
				break;
			case '3 дня':
				date_search.addClass('date_3').attr('data-time', '3d');
				break;
			case '7 дней':
				date_search.addClass('date_7').attr('data-time', '7d');
				break;
			case '2 месяца':
				date_search.addClass('date_2').attr('data-time', '2m');
				break;
			default:
				return false;
		}
		if ($('#date_search_check').is(':checked')) {
			search_freights();
		}
		$(this).parent('.popup').hide();
	});
	// first
	d.on('click', '#for_date', function(e) {
		if(!$(e.target).filter('#for_date').length) return;
		if(!$('#hide_2:visible').length) {
			$('#hide_1 > span#label').text('Поиск по дате');
			$('#hide_2').show();
			$('.params_search').hide();
			search_back_freights();
		}
	});
	// second
	d.on('click', '#for_param', function(e) {
		if(!$(e.target).filter('#for_param').length) return;
		if(!$('.params_search:visible').length) {
			$('#hide_1 > span#label').text('По параметрам');
			$('#hide_2').hide();
			$('.params_search').show();
			search_back_freights();
		}
	});
	// third
	d.on('click', '.back_date_search', function(e) {
		$('.popup,.popup2').not('.select_sort').hide();
		$('.select_sort').toggle();
		return false;
	});
	// 
	d.on('click', '.change_way', function(e) {
		if(!$(e.target).hasClass('change_way')) return;
		var temp_id = $('input[name=to_id]').val();
		var temp_name = $('input[name=to]').val();
		$('input[name=to_id]').val($('input[name=from_id]').val());
		$('input[name=to]').val($('input[name=from]').val());
		$('input[name=from_id]').val(temp_id);
		$('input[name=from]').val(temp_name);
		search_freights();
		return false;
	});
	// 
	d.on('click', '#check_all_bodies', function(e) {
		if(!$(e.target).filter('#check_all_bodies').length) return;
		var is_any_on = $('.check_body input:checked').length;
		$('.check_body input,.check_body_loading input').each(function(){
			$(this).prop('checked', is_any_on?false:true).parent('label')[is_any_on?'removeClass':'addClass']('active');
		});
		// change sum of choosed
		search_freights();
		return false;
	});
	// 
	d.on('click', '#check_all_sites', function(e) {
		if(!$(e.target).filter('#check_all_sites').length) return;
		var is_any_on = $('.site_search_box input:checked').length;
		$('.site_search_box input').each(function(){
			$(this).prop('checked', is_any_on?false:true).parent('label')[is_any_on?'removeClass':'addClass']('active');
		});
		search_freights();
		return false;
	});
	//деактивируем (перекрываем) карту до первого клика
	d.on('click', '.map_mask', function(e) {
		if(!$(e.target).hasClass('map_mask')) return;
		$('.map_mask').hide();
		return false;
	});
	// toggle map
	d.on('click', '.notice .title', details_opener);
	// turn on another - if not active click "find backward", clear all active, make active
	// turn off - if active click "find backward", clear all active
	d.on('click', '[data-back-filter]', function(e){
		var	togglecheck	= $('#search_back'), 
			active		= $(this).parents('.window_content'),
			parent		= active.parent(),
			date_from	= active.attr('data-date-from'),
			date_to		= active.attr('data-date-to'),
			date_from_input = $('#back_from_line'),
			date_to_input = $('#back_to_line')
		;
		// remove all active classes except current
		parent.children('.active,.warning').not(active.get(0)).removeClass('active warning').css('top', '');
		parent.children('[data-last-index]').each(function(){
			var th = $(this), ind = th.attr('data-last-index');
			th.removeAttr('data-last-index');
			if(ind >= 0) {
				parent.children().eq(ind).before(this);
				th.css('top', '');
			}
			else th.remove();
		});
		active.toggleClass('active');
		// turn on - if not active click "find backward", clear all active, make active
		if(active.hasClass('active')) {
			// turn on "back list"
			active.attr('data-last-index', active.index()+1).css('top', Math.abs(parseInt(parent.css('top'))));
			
			$('input[name=choosed_direct_id]').val(active.attr('data-box-id'));
			$('input[name=choosed_direct_addr_from]').val(active.attr('data-addr-from'));
			$('input[name=choosed_direct_addr_to]').val(active.attr('data-addr-to'));
			$('input[name=choosed_direct_date_from]').val(active.attr('data-date-from'));
			$('input[name=choosed_direct_date_to]').val(active.attr('data-date-to'));
			$('input[name=choosed_direct_distance]').val(active.attr('data-distance'));
			parent.prepend(active);
			// parent.parents('.mCustomScrollbar').eq(0).mCustomScrollbar('scrollTo', 0);
			// 
			if(!togglecheck.is(':checked')) {
				$('#toggle_check').trigger('click');
			} else {
				search_back_freights();
			}
			parent.css('padding-top', active.outerHeight(true));
			// turn off "back list"
		} else {
			$('input[name=choosed_direct_id],input[name=choosed_direct_addr_from],input[name=choosed_direct_addr_to],input[name=choosed_direct_date_from],input[name=choosed_direct_date_to],input[name=choosed_direct_distance]').val("");
			if(!parent.children().length) {
				parent.append('<div class="white_text">Грузов не найдено</div>');
			}
			parent.css('padding-top', '');
			search_back_freights();
		}
		return false;
	});
	//------------- checkboxes changes ----------------------
	d.on('change', '[name=notify]', function(e) {
		if (!$(this).is(':checked')) {
			$(this).removeClass('active');
			$('.notify').removeClass('active').text("Оповещения отключены");
			$('.right_tab .popup').text("Нажмите, чтобы включить оповещения о новых грузах по этим параметрам на e-mail");
		} else {
			$(this).addClass('active');
			$('.notify').addClass('active').text("Оповещения включены");
			$('.right_tab .popup').text("Нажмите, чтобы отключить оповещения о новых грузах по этим параметрам на e-mail");
		}
	});
	// 
	d.on('change', '#form-filter [name], [name=sort_from],[name=sort_to]', function(e){
		var th = $(this);
		th.parent('.type-checkbox').toggleClass('active');
		// "koridor" and "probeg" are changed by keyup
		if(th.attr('name') == 'koridor' || th.attr('name') == 'probeg') {
			return;
		}
		// "search_back" is trigger only backlist
		if(th.attr('name') == 'search_back') {
			if(th.is(':checked')) search_back_freights();
		} else if(
			(	
				th.attr('name') == 'back_date_from' ||
				th.attr('name') == 'back_date_to' 
			) && $('[name=search_back]:checked').length
		) {
			search_back_freights();
		} else {
			search_freights(e);
		}
	});
	d.on('change', '.map-toggler input[type=checkbox]', function(e){
		var th = $(this), is_on = th.is(':checked'), 
			group = th.parents('.toggler-group'),
			parent_input = group.find('.label-gruz-parent input'),
			children_input = group.find('.toggler-group-children input'),
			children_checked_length = children_input.filter(':checked').length;
		if(th.parent('.label-gruz-parent').length){
			// pressed parent - toggle children
			children_input.each(function(){
				this.checked = is_on;
			});
			parent_input.parent().removeClass('checked-part');
		} else {
			// pressed children - calculate and toggle parent
			if(!children_checked_length || children_checked_length == children_input.length) {
				parent_input.prop('checked', is_on).parent().removeClass('checked-part');
			} else {
				parent_input.prop('checked', true).parent().addClass('checked-part');
			}
		}
		redraw_markers();
	});
	//------------- sliders ----------------------
	var number_timer;
	d.on('keyup', 'input[name=ratio_from], input[name=ratio_to]', function(){
		$(this).trigger('change');
	});
	d.on('click', '[data-handler=next],[data-handler=prev]', function(){
		return false;
	});
	d.on('keyup', '.slider_input', function() {
		var th = $(this), item = th.attr('name');
		clearTimeout(number_timer);
		number_timer = setTimeout(function() {
			switch (item) {
				case 'long_from':
					if (parseInt($("#" + item).val()) > parseInt($("#long_to").val())) {
						$("#" + item).val($("#long_to").val());
						$("#slider-long").slider('values', 0, Math.abs($("#long_to").val()));
					} else $("#slider-long").slider('values', 0, Math.abs($('#' + item).val()));
					break;
				case 'long_to':
					if ($('#' + item).val() > 2000) {
						$('#' + item).val(2000);
						$('#' + item).next().text('+ км');
					} else {
						$('#' + item).next().html('&nbsp;км');
					}
					if (parseInt($("#" + item).val()) < parseInt($("#long_from").val())) {
						$("#" + item).val($("#long_from").val());
						$("#slider-long").slider('values', 1, Math.abs($("#long_from").val()));
					} else $("#slider-long").slider('values', 1, Math.abs($('#' + item).val()));
					break;
				case 'weight_from':
					if (parseInt($("#weight_from").val()) > parseInt($("#weight_to").val())) {
						$("#weight_from").val($("#weight_to").val());
						$("#slider-weight").slider('values', 0, Math.abs($("#weight_to").val()));
					} else $("#slider-weight").slider('values', 0, Math.abs($('#' + item).val()));
					break;
				case 'weight_to':
					if ($('#' + item).val() > 30) {
						$('#' + item).val(30);
						$('#' + item).next().text('+ т');
					} else {
						$('#' + item).next().html('&nbsp;т');
					}
					if (parseInt($("#weight_to").val()) < parseInt($("#weight_from").val())) {
						$("#weight_to").val($("#weight_from").val());
						$("#slider-weight").slider('values', 1, Math.abs($("#weight_from").val()));
					} else $("#slider-weight").slider('values', 1, Math.abs($('#' + item).val()));
					break;
				case 'volume_from':
					if (parseInt($("#volume_from").val()) > parseInt($("#volume_to").val())) {
						$("#volume_from").val($("#volume_to").val());
						$("#slider-volume").slider('values', 0, Math.abs($("#volume_to").val()));
					} else $("#slider-volume").slider('values', 0, Math.abs($('#' + item).val()));
					break;
				case 'volume_to':
					if ($('#' + item).val() > 100) {
						$('#' + item).val(100);
						$('#' + item).next().text('+ м');
					} else {
						$('#' + item).next().html('&nbsp;м');
					}
					if (parseInt($("#volume_to").val()) < parseInt($("#volume_from").val())) {
						$("#volume_to").val($("#volume_from").val());
						$("#slider-volume").slider('values', 1, Math.abs($("#volume_from").val()));
					} else $("#slider-volume").slider('values', 1, Math.abs($('#' + item).val()));
					break;
			}
			$('#' + item).val(Math.abs($('#' + item).val())); //убираем минусовое значение
			th.trigger('change');
		}, 1000);
	});
	// 
	$("#slider-long").slider({
		range: true,
		min: 0,
		max: 2000,
		values: [0, 2000],
		slide: function(event, ui) {
			$('#long_to').next().html('&nbsp;км');
			$("#long_to").val(ui.values[1]);
			$("#long_from").val(ui.values[0]).trigger('change');
		},
		stop: function(event, ui) {
			if (ui.values[1] == 2000) {
				$('#long_to').next().text('+ км');
			} else {
				$('#long_to').next().html('&nbsp;км');
			}
			$('#long_to').trigger('change');
			// search_freights();
		}
	});
	// 
	$("#slider-weight").slider({
		range: true,
		min: 0,
		max: 30,
		values: [0, 30],
		slide: function(event, ui) {
			$('#weight_to').next().html('&nbsp;т');
			$("#weight_to").val(ui.values[1]).trigger('change');
			$("#weight_from").val(ui.values[0]);
		},
		stop: function(event, ui) {
			if (ui.values[1] == 30) {
				$('#weight_to').next().text('+ т');
			} else {
				$('#weight_to').next().html('&nbsp;т');
			}
			$('#weight_to').trigger('change');
			// search_freights();
		}
	});
	// 
	$("#slider-volume").slider({
		range: true,
		min: 0,
		max: 100,
		values: [0, 100],
		slide: function(event, ui) {
			$("#volume_from").val(ui.values[0]);
			$('#volume_to').next().html('&nbsp;м');
			$("#volume_to").val(ui.values[1]).trigger('change');
		},
		stop: function(event, ui) {
			if (ui.values[1] == 100) {
				$('#volume_to').next().text('+ м');
			} else {
				$('#volume_to').next().html('&nbsp;м');
			}
			$('#volume_to').trigger('change');
			// search_freights();
		}
	});
	//--------datepickers---------------
	var dateFormat = 'mm/dd/yy',
		from = $('#date_picker_from')
			.datepicker({
				numberOfMonths: 2,
				minDate: 0,
				maxDate: null,
				dateFormat: 'dd.mm.yy',
				showOtherMonths: true,
				selectOtherMonths: true,
				dayNamesMin: ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'],
				monthNamesShort: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
				monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
			})
			.on('change', function() {
				var currentDate = $(this).datepicker('getDate');
				to.datepicker('option', 'minDate', currentDate);
				var d1 = $.datepicker.formatDate('dd.mm.yy', new Date(currentDate), {});
				$('.load_popup_from,.fake').hide();
				$('[name=load_date_from]').val(d1).removeClass('active_input').trigger('change');
			}),
		to = $('#date_picker_to')
			.datepicker({
				numberOfMonths: 2,
				minDate: 0,
				maxDate: null,
				dateFormat: 'dd.mm.yy',
				showOtherMonths: true,
				selectOtherMonths: true,
				dayNamesMin: ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'],
				monthNamesShort: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
				monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
			})
			.on('change', function() {
				var currentDate = $(this).datepicker('getDate');
				from.datepicker('option', 'maxDate', currentDate);
				var d1 = $.datepicker.formatDate('dd.mm.yy', new Date(currentDate), {});
				$('.load_popup_to,.fake').hide();
				$('[name=load_date_to]').val(d1).removeClass('active_input').trigger('change');
			}),
		back_date_from = $('#back_date_from')
			.datepicker({
				numberOfMonths: 2,
				minDate: 0,
				maxDate: null,
				dateFormat: 'dd.mm.yy',
				showOtherMonths: true,
				selectOtherMonths: true,
				dayNamesMin: ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'],
				monthNamesShort: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
				monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
			})
			.on('change', function() {
				var currentDate = $(this).datepicker('getDate');
				back_date_to.datepicker('option', 'minDate', currentDate);
				var d1 = $.datepicker.formatDate('dd.mm.yy', new Date(currentDate), {});
				$('.back_from_popup,.fake').hide();
				$('[name=back_date_from]').val(d1).removeClass('active_input').trigger('change');
			}),
		back_date_to = $('#back_date_to')
			.datepicker({
				numberOfMonths: 2,
				minDate: 0,
				maxDate: null,
				dateFormat: 'dd.mm.yy',
				showOtherMonths: true,
				selectOtherMonths: true,
				dayNamesMin: ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'],
				monthNamesShort: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
				monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
			})
			.on('change', function() {
				var currentDate = $(this).datepicker('getDate');
				back_date_from.datepicker('option', 'maxDate', currentDate);
				var d1 = $.datepicker.formatDate('dd.mm.yy', new Date(currentDate), {});
				$('.back_to_popup,.fake').hide();
				$('[name=back_date_to]').val(d1).removeClass('active_input').trigger('change');
			});
	// 
	$('#sites_total, #sites_selected').text($('.check_site').length);
	$('#bodies_total, #bodies_selected').text($('.check_body').length);
	//----------------- scrollbars ----------------------
	$('.main_content').mCustomScrollbar({
		theme: 'main_scroll',
		alwaysShowScrollbar: 2,
		scrollInertia: 0,
		scrollButtons: { enable: true },
		callbacks: {
			onTotalScroll: function() {
				show_next_results(this);
			},
			whileScrolling: function(){
				var th = $('.main_content .mCSB_container');
				th.children('.active').css('top', -parseInt(th.css('top')));
			}

		}
	});
	$('.back_content').mCustomScrollbar({
		theme: 'back_scroll',
		alwaysShowScrollbar: 2,
		scrollInertia: 0,
		scrollButtons: { enable: true },
		callbacks: {
			onTotalScroll: function() {
				show_next_back_results(this);
			}
		}
	});
	$('.favorite_content').mCustomScrollbar({
		theme: 'favorite_scroll',
		scrollInertia: 0,
		alwaysShowScrollbar: 2,
		scrollButtons: { enable: true },
		callbacks: {
			onTotalScroll: function() {
				show_next_favorite_results(this);
			}
		}
	});
	//--------checkers----------------
	$('#sites_total').text($('.check_site').length);
	$('#sites_selected').text($('.check_site').length);
	$('#bodies_total').text($('.check_body').length);
	$('#bodies_selected').text($('.check_body').length);
	// draw select
	// $('.select-ui').each(function(){
	// 	var select = $(this),
	// 		toggle_button = $('<button class="select-button"></button>'),
	// 		list_container = $('<div class="select-container" style="display: none;"></div>');
	// 	select.hide().children().each(function(){
	// 		var option = $(this);
	// 		list_container.append($('<a href="#" data-value="'+option.val()+'">'+option.text()+'</a>').on('click', function(e){
	// 			e.preventDefault();
	// 			select.val($(this).attr('data-value')).trigger('change');
	// 		}));
	// 	});
	// 	select.after(toggle_button.on('click', function(){
	// 		list_container.toggle();
	// 	}), list_container);
	// })
	// 
	search_freights();
	// 
	// От Павла 
	// Аккордеон избранного 
	var allAccordions = $('.window_content .list .accordeon_type');
	var allAccordionItems = $('.window_content .list .accordion-item');
	d.on('click', '.window_content > .list > .accordion-item', function(e) {
		if ($(this).hasClass('open')) {
			$(this).removeClass('open').next().slideUp("slow");
		} else {
			allAccordions.slideUp("slow");
			allAccordionItems.removeClass('open');
			$(this).addClass('open').next().slideDown("slow");
			return false;
		}
	});
	// 
	setMineMinHeight();
	sizeMap();
	$('#map_canvas').resize(sizeMap);
	//------------google map --------------------
	map_initialize();
	// 
	w.resize(setMineMinHeight).resize(sizeMap);
});