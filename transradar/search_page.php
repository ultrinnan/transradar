<?php 
/*
Template Name: Search page
*/
global $path;
$path = 'search';
get_header();
$api = new ApiClass;
// var_dump($_POST);
$from_id = $_POST["from_id"]?$_POST["from_id"]:'';
$from_name = $_POST["from_hidden"]?$_POST["from_hidden"]:'';
$is_country = $_POST["is_country"]?$_POST["is_country"]:'';
$to_id = $_POST["to_id"]?$_POST["to_id"]:'';
$to_name = $_POST["to_hidden"]?$_POST["to_hidden"]:'';
$search_back = $_POST["search_back"]?$_POST["search_back"]:'';
if ($search_back=='on') {
	$inactive = '';
	$search_back_class = 'active';
	$checked = 'checked';
	echo '<style>#search_not_active {display:none;}</style>';
	echo '<style>.block_checker {display:none;}</style>';
} else {
	$inactive = 'inactive';
	$search_back_class = '';
	$checked = '';
}
?>
<style>
	body {
		background: #206eb6;
	}
</style>
<!-- __________________________________Всплывающие подсказки__________________________________________________ -->
	<span class="popup new_add_popup" style="width:120px;"><?php echo $popups_text['Новый список избранного']?></span>
	<span class="popup popup_info_razvernut" style="width:105px;" ><center><?php echo $popups_text['Свернуть список']?></center></span>
	<span class="popup2 popup_filter_hover" style="width:120px;"><?php echo $popups_text['Сортировка объявлений'];?></span>
	<span class="popup2 popup_filter_hover_orange" style="width:120px;"><?php echo $popups_text['Сортировка объявлений'];?></span>
	<span class="popup2 popup_filter_hover_green" style="width:120px;"><?php echo $popups_text['Сортировка объявлений'];?></span>
	<span class="popup popup_star_add"><?php echo $popups_text['Добавить в избранное']?> «Мой список 1»</span>
	<span class="popup popup_shlag"><?php echo $popups_text['Радиус поиска']?></span>
	<span class="popup popup_warning">В объявлении изменилась цена 26.02.2016.</span>
	<span class="popup popup_star_del"><?php echo $popups_text['Убрать из избранного']?></span>
	<span class="popup popup_star_down">
		<a href="#">Добавить в "Мой список 2"</a>
		<a href="#">Добавить в "Мой список 3"</a>
		<a href="#">Добавить в "Мой список 4"</a>
		<a href="#">Добавить в "Мой список 5"</a>
		<a href="#">Добавить в "Минск, февраль"</a>
		<a href="#">Добавить в "Камаз, март"</a>
		<a href="#">Добавить в "MAN 90, апрель"</a>
	</span>
	<span class="popup popup_gear_down">
		<a href="#">Переименовать</a>
		<a href="#">Удалить</a>
		<a href="#">Удалить все неактуальные грузы</a>
		<a href="#">Сделать списком по умолчанию</a>
	</span>
<!-- __________________________________________________________________________________________________________ -->

  		<div class="filters_bg">
				<div class="filters_main">
					<div class="filters_tabs">
						<ul id="myTabs" class="nav nav-tabs" role="tablist"> 
							<li role="presentation" class="active">
								<a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Новый поиск</a><!-- <span class="down_blue click_Toggle">
									<div class="popup">
										<a href="#">Сохранить поиск</a>
										<a href="#">Переименовать</a>
										<a href="#">Удалить</a>
										<a href="#">Отключить оповещения</a>
									</div>
								</span> -->
							</li> 
							<!-- <li role="presentation" class="">
								<a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Новый поиск2</a><span class="down_blue click_Toggle">
									<div class="popup">
										<a href="#">Сохранить поиск</a>
										<a href="#">Переименовать</a>
										<a href="#">Удалить</a>
										<a href="#">Отключить оповещения</a>
									</div>
								</span>
							</li> 
							<li role="presentation" class="more">
								<span class="click_Toggle down_blue_c"><a class="more" href="#profile">Еще</a><span class="down_blue"></span>
									<div class="popup">
										<a href="#">Новый поиск4</a>
										<a href="#">Новый поиск5</a>
										<a href="#">Новый поиск6</a>
										<a href="#">Новый поиск7</a>
									</div>
								</span>
								<div class="add_tab"></div>
							</li>  -->
						</ul> 
					</div>
					
					<div class="right_tab">
						<input id="notify" type="checkbox" name="notify" hidden />
						<label for="notify"><span id="notify_label" class="notify">Оповещения отключены</span></label>
						<div class="popup">
							<?php echo $popups_text['Кнопка оповещения']?>
						</div>
					</div>
					<div id="myTabContent" class="tab-content clearfix">

						<div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab"> 
				  		<form action="">
					  		<div class="from from_box">
					  			<strong>Откуда</strong><br>
									<input type="hidden" class="form_select_id" name="from_id" value="<?php echo $from_id;?>">
									<input type="text" name="from" class="select" id="from" placeholder="Укажите страну или город" autocomplete="off" value="<?php echo $from_name;?>"><span class="from_clear clear_from"></span>
									<div class="from_results">
										<div class="places">нет результатов</div>
									</div>
									<div class="ratio">
				  					<span class="ratio_label"><strong>Радиус</strong></span>
					  				<div class="plus_min clearfix">
					  					<span class="from_clear clear_from"></span>
											<input type="number" value="50" name="ratio_from" class="slider_input"> км
											<input id="search_inside_from" type="checkbox" data-state="1" checked="true" name="search_inside_from" hidden />
      								<label for="search_inside_from">
      									<span id="search_inside_l_from" class="search_back_label active">
      										<div class="popup popup_shlag">
      											<?php echo $popups_text['Радиус поиска']?>
      										</div>
      									</span>
      								</label>
										</div>
										<div class="check_box clearfix">
										</div>
					  			</div>
					  		</div>
					  		
					  		<div class="change_way"></div>
					  		
					  		<div class="to to_box">
					  			<strong>Куда</strong><br>
					  			<input type="hidden" class="form_select_id" name="to_id" value="<?php echo $to_id;?>">
					  			<input type="text" name="to" class="select" id="to" placeholder="Укажите страну или город" autocomplete="off" value="<?php echo $to_name;?>"><span class="from_clear clear_to"></span>
									<div class="to_results">
										<div class="places">нет результатов</div>
									</div>
					  			
					  			<div class="ratio">
				  					<span class="ratio_label"><strong>Радиус</strong></span>
					  				<div class="plus_min clearfix">
					  					<span class="from_clear clear_to"></span>
											<input type="number" value="50" name="ratio_to" class="slider_input" /> км
											<input id="search_inside_to" type="checkbox" data-state="1" checked="true" name="search_inside_to" hidden />
      								<label for="search_inside_to">
      									<span id="search_inside_l_to" class="search_back_label active">
      										<div class="popup popup_shlag">
      											<?php echo $popups_text['Радиус поиска']?>
      										</div>
      									</span>
      								</label>
										</div>
										<div class="check_box clearfix">
										</div>
					  			</div>

					  		</div>

					  		<div class="load_date">
									<label for="load_date">Даты загрузки</label>
									<div class="load_date_button">
										<input class="inline_input" id="load_from_line" value="" placeholder="дд.мм.гг" readonly/>
										<span style="color:#ccc"> - </span>
										<input class="inline_input" id="load_to_line" value="" placeholder="дд.мм.гг" readonly/>
										
										<div class="popup load_popup_from">
											<div class="load_title">Начальная дата загрузки <span class="start_date_cancel">очистить</span></div>
											<div class="load_body clearfix">
												<div class="date_picker" id="date_picker_from"></div>
											</div>								
										</div>	
										<div class="popup load_popup_to">
											<div class="load_title">Конечная дата загрузки <span class="end_date_cancel">очистить</span></div>
											<div class="load_body clearfix">
												<div class="date_picker" id="date_picker_to"></div>
											</div>								
										</div>

									</div>
					  		</div>
					  		<div class="back_date <?php echo $search_back_class;?>">
					  			<!-- <div class="block_checker" title="Для поиска обратных грузов должен быть задан город «Откуда»"></div> -->
					  			<input id="search_back" type="checkbox" name="search_back" <?php echo $checked;?> hidden />
        						<label id="toggle_check" for="search_back" class="<?php echo $search_back_class;?>"><span class="search_back_label">Искать обратный груз?</span></label><br>
	        					<div class="info">
	        						<div class="popup">
	        							<?php echo $popups_text['Искать обратный груз']?>
	        						</div>
	        					</div>
        					<div>
										<div id="search_not_active">Поиск не активирован...</div>
										<div class="back_date_search" id="hide_1">
			              	<span id="label">Поиск по дате</span><span class="caret"></span>
		         					<div class="popup select_sort">
		         						<p id="for_date">Поиск по дате</p>
		         						<p id="for_param">По параметрам</p>
		         					</div>
			              </div>
			              <!-- <div class="back_date_button_fake fake"></div> -->
										<div class="back_date_button" id="hide_2">
											<input class="inline_input" id="back_from_line" value="" placeholder="дд.мм.гг" readonly/>
											<span style="color:#ccc"> - </span>
											<input class="inline_input" id="back_to_line" value="" placeholder="дд.мм.гг" readonly/>
											<div class="popup back_from_popup">
												<div class="load_title">Начальная дата обратной загрузки и доставки <span class="back_start_date_cancel">очистить</span></div>
												<div class="load_body clearfix">
													<div class="date_picker" id="back_date_from"></div>
												</div>
											</div>
											<div class="popup back_to_popup">
												<div class="load_title">Конечная дата обратной загрузки и доставки <span class="back_end_date_cancel">очистить</span></div>
												<div class="load_body clearfix">
													<div class="date_picker" id="back_date_to"></div>
												</div>
											</div>

										</div>
										<div class="params_search">
											<strong>Пробег </strong><input name="probeg" class="probeg" type="number" value="500" placeholder="____"> км/д <span class="days">+<input name="koridor" class="koridor" type="number" value="7" placeholder="__"></span>дней
										</div>
									</div>
					  		</div>

								<div class="tab_lines clearfix"></div>
								<div class="long">							
									<label for="long">Расстояние маршрута</label>
									<div class="clearfix">
										<div class="slider_from"><input type="number" id="long_from" name="long_from" class="slider_input" min="0" max="2000" value="0"><span> км</span></div>
										<div class="slider_mid">
											<div id="slider-long"></div>
										</div>
										<div class="slider_to"><input type="number" id="long_to" name="long_to" class="slider_input" value="2000"><span>+ км</span></div>
									</div>
								</div>

								<div class="weight">
									<label for="weight">Вес груза</label>
									<div class="clearfix">
										<div class="slider_from">
											<input type="number" id="weight_from" name="weight_from" class="slider_input" value="0"> <span>т</span>
										</div>
										<div class="slider_mid">
											<div id="slider-weight"></div>
										</div>
										<div class="slider_to">
											<input type="number" id="weight_to" name="weight_to" class="slider_input" value="30"><span>+ т</span>
										</div>
									</div>
								</div>

								<div class="volume">
									<label for="volume">Объем груза</label>
									<div class="clearfix">
										<div class="slider_from"><input type="number" id="volume_from" name="volume_from" class="slider_input" value="0"> <span>м</span><sup>3</sup></div>
										<div class="slider_mid">
											<div id="slider-volume"></div>
										</div>
										<div class="slider_to"><input type="number" id="volume_to" name="volume_to" class="slider_input" value="100"><span>+ м</span><sup>3</sup></div>
									</div>
								</div>

								<div class="body_type">
									<label for="body_type">Тип кузова</label>
									<div class="body_type_button_fake fake"></div>
									<div class="body_type_button">
										Выбрано <span id="bodies_selected">0</span> из <span id="bodies_total">0</span><span class="caret"></span>
										<div class="popup2 body_box">
											<div class="site_seach_title">Категории грузов</div>
											<div class="body_types_box clearfix">

												<div class="body furgon">
													<div class="img_block">
														<img src="<?php echo esc_url(get_template_directory_uri());?>/images/body_furgon.png" alt="фургон">
													</div>
													<?php $api->build_body_type_list('1');?>
												</div>

												<div class="body opened">
													<div class="img_block">
														<img src="<?php echo esc_url(get_template_directory_uri());?>/images/body_opened.png" alt="открытые">
													</div>
													<?php $api->build_body_type_list('2');?>
												</div>

												<div class="body cisterna">
													<div class="img_block">
														<img src="<?php echo esc_url(get_template_directory_uri());?>/images/body_cisterna.png" alt="цистерна">
													</div>
													<?php $api->build_body_type_list('3');?>
												</div>

												<div class="body special">
													<div class="img_block">
														<img src="<?php echo esc_url(get_template_directory_uri());?>/images/body_special.png" alt="специальные">
													</div>
													<?php $api->build_body_type_list('4');?>
													<!-- <span class="body_more_link">Еще <span class="down_blue"></span></span>
													<div class="body_more">
														<div class="check_body">
															<input id="search_body29" type="checkbox" name="search_body29" hidden />
			        								<label for="search_body29"><span class="check_all">Изотермический</span></label>
														</div>
														<div class="check_body">
															<input id="search_body30" type="checkbox" name="search_body30" hidden />
			        								<label for="search_body30"><span class="check_all">Изотермический</span></label>
														</div>
													</div>
													<span class="body_less_link">Свернуть <span class="up"></span></span> -->
												</div>
											</div>
											
											<div class="body_type_footer clearfix">
												<span class="tab_link" id="check_all_bodies">Выбрать все</span>

												<span class="search_danger">
													<input id="search_danger" type="checkbox" data-state="" name="search_danger" hidden />
			        						<label for="search_danger" id="search_danger_l"><span class="check_all">Искать опасные грузы</span></label>
												</span>
											</div>												
										</div>
									</div>
									<div class="popup">
										<?php echo $popups_text['Тип кузова']?>
									</div>
								</div>
								<div class="site_search">
									<label for="site_search">Поиск по сайтам</label>
									<div class="site_search_button_fake fake"></div>
									<div class="site_search_button">
										Выбрано <span id="sites_selected">0</span> из <span id="sites_total">0</span><span class="caret"></span>
										<div class="popup2 site_search_box">
											<div class="site_seach_title">Выберите актуальные сайты (биржи грузов) для поиска</div>
											<div class="clearfix">
												<?php $api->build_exchange_sites_list();?>
											</div>
											
											<div class="site_search_footer clearfix">
												<span class="tab_link" id="check_all">Выбрать все</span>
											</div>												

										</div>
									</div>
									<div class="popup">
										<?php echo $popups_text['Поиск по сайтам']?>
									</div>
								</div>

								<div class="other_search_pro clearfix">
										<div class="checkers">
											<input id="date_search_check" type="checkbox" data-state="" name="date_search_check" hidden />
	    								<label for="date_search_check"><span id="date_search_check_l" class="check_all">Поиск по дате объявления не позднее чем за</span>
											</label>
	    								<span class="tab_link date_search date_24" data-time="24h">
	    									<div class="popup">
													<a href="#">1 час</a>
													<a href="#">6 часов</a>
													<a href="#">24 часа</a>
													<a href="#">3 дня</a>
													<a href="#">7 дней</a>
													<a href="#">2 месяца</a>
												</div>
											</span>
										</div>
										<div class="checkers">
											<input id="strict_search_check" type="checkbox" checked="true" data-state="" name="strict_search_check" hidden />
	    								<label for="strict_search_check" id="strict_search_check_l" class="active"><span class="check_all">Строгий поиск
	    								<span class="info">
	    									<div class="popup"><?php echo $popups_text['Строгий'];?></div>
	    								<span></span></label>
										</div>
								</div>

				  		</form>
						</div>

						<!-- <div role="tabpanel" class="tab-pane fade" id="profile" aria-labelledby="profile-tab"> 
							<p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit. Keytar helvetica VHS salvia yr, vero magna velit sapiente labore stumptown. Vegan fanny pack odio cillum wes anderson 8-bit, sustainable jean shorts beard ut DIY ethical culpa terry richardson biodiesel. Art party scenester stumptown, tumblr butcher vero sint qui sapiente accusamus tattooed echo park.</p> 
						</div> 
						<div role="tabpanel" class="tab-pane fade" id="dropdown1" aria-labelledby="dropdown1-tab"> 
							<p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR banksy irony. Leggings gentrify squid 8-bit cred pitchfork. Williamsburg banh mi whatever gluten-free, carles pitchfork biodiesel fixie etsy retro mlkshk vice blog. Scenester cred you probably haven't heard of them, vinyl craft beer blog stumptown. Pitchfork sustainable tofu synth chambray yr.</p> 
						</div>  -->
					</div>							
				</div>	  			
		  		<div class="other_box">
			  		<div class="other closen">
			  			Другие настройки <span class="caret_white_up"></span>
			  		</div>
		  		</div>
  		</div>
		</nav>
<!-- header end		 -->

		<div class="search" >
			<div id="map_canvas"></div>
			<div class="map_mask"></div>

<!-- 			<div class="map_legend">
				<div class="goods_from">
					<div class="quant">
						141
						<span class="arrow"></span>
					</div>
					Количество грузов из этого сегмента
				</div>
				<div class="goods_to">
					<div class="quant">
						141
						<span class="arrow orange"></span>
					</div>
					Количество грузов в этот сегмент
				</div>
			</div> -->
		
		<span>
  		<div class="windows">
	  		<div class="window main">
	  			<div class="window_title clearfix">Основные грузы 
	  				<div class="quantity">0</div>
	  				<div class="minimize" id="main_min"></div>
	  				<div class="filter">
			        	<div class="popup filter_pop" style="display: none;width: 146px !important;">
							<a href="#" id="href_filter1" data-sort="s">по дате загрузки<span class="bt_filter_in"></span></a>
							<a href="#" id="href_filter4" data-sort="d">по расстоянию маршрута<span class="bt_filter_in"></span></a>
							<a href="#" id="href_filter2" data-sort="w">по весу груза<span class="bt_filter_in"></span></a>
							<a href="#" id="href_filter3" data-sort="v">по объему груза<span class="bt_filter_in"></span></a>
							<a href="#" id="href_filter5" data-sort="r">по стоимости<span class="bt_filter_in"></span></a>
							<a href="#" id="href_filter7" data-sort="rm">по стоимости за км<span class="bt_filter_in"></span></a>
							<a href="#" id="href_filter6" data-sort="c" class="acty_filter">по дате создания<span class="bt_filter_in"></span></a>
			        	</div>
			       	</div>
	  			</div>
	  			<div class="main_content">
	  				<div class="white_text">Загрузка...<br>
	  				<img src="/wp-content/themes/transradar/img/ajax-loader.gif" alt=""></div>
	  			</div>
	  		</div>

	  		<div class="window back <?php echo $inactive;?>">
	  			<div class="window_title clearfix">Обратные грузы 
	  				<div class="quantity">0</div>
	  				<div class="minimize orange" id="back_min"></div>
	  				<div class="filter orange">
			        	<div class="popup filter_pop_orange" style="display: none;width: 146px !important;">
			         		<a href="#" id="href_filter_o1" data-sort="s">по дате загрузки<span class="bt_filter_in_orange"></span></a>
			         		<a href="#" id="href_filter_o4" data-sort="d">по расстоянию маршрута<span class="bt_filter_in_orange"></span></a>
			         		<a href="#" id="href_filter_o2" data-sort="w">по весу груза<span class="bt_filter_in_orange"></span></a>
			         		<a href="#" id="href_filter_o3" data-sort="v">по объему груза<span class="bt_filter_in_orange"></span></a>
			         		<a href="#" id="href_filter_o5" data-sort="r">по стоимости<span class="bt_filter_in_orange"></span></a>
			         		<a href="#" id="href_filter_o7" data-sort="rm">по стоимости за км<span class="bt_filter_in_orange"></span></a>
			         		<a href="#" id="href_filter_o6" data-sort="c" class="acty_filter">по дате создания<span class="bt_filter_in_orange"></span></a>
			        	</div>
			       	</div>
	  			</div>
	  			<div class="back_content">
	  				<div class="white_text">
		  				Загрузка...<br>
		  				<img src="<?php echo esc_url(get_template_directory_uri());?>/img/ajax-loader.gif" alt="">
	  				</div>
	  			</div>
	  		</div>

	  		<!-- <div class="window favorite">
	  			<div class="window_title clearfix">Избранное 
	  				<div class="quantity">99</div>
	  				<div class="minimize max" id="fav_min"></div>
	  				<div class="filter green">
			        <div class="popup filter_pop_green" style="display: none;width: 146px !important;">
			         <a href="#" id="href_filter_g1" data-sort="s">по дате загрузки<span class="bt_filter_in_green"></span></a>
			         <a href="#" id="href_filter_g4" data-sort="d">по расстоянию маршрута<span class="bt_filter_in_green"></span></a>
			         <a href="#" id="href_filter_g2" data-sort="w">по весу груза<span class="bt_filter_in_green"></span></a>
			         <a href="#" id="href_filter_g3" data-sort="v">по объему груза<span class="bt_filter_in_green"></span></a>
			         <a href="#" id="href_filter_g5" data-sort="r">по стоимости<span class="bt_filter_in_green"></span></a>
			         <a href="#" id="href_filter_g7" data-sort="rm">по стоимости за км<span class="bt_filter_in_green"></span></a>
			         <a href="#" id="href_filter_g6" data-sort="c" class="acty_filter">по дате создания<span class="bt_filter_in_green"></span></a>
			        </div>
			       </div>
	  				<div class="add_fav"></div>
	  				
	  			</div>
	  			<div class="favorite_content">
	  				<div class="window_content" >
	  					<div class="list">
	  						<div class="list_header clearfix accordion-item open">
	  							<span class="cursor_green"></span>Moй список 1
	  							<div class="quantity">128</div>
	  							<div class="gear gear_down click_Toggle"></div>
	  						</div>
							<span class="accordeon_type" style="display: inline-block;">
	  						<div class="list_block">
							<div>
			  					<div class="row1 clearfix">
			  						<div class="date">25.02.2016 <span class="warn"></span></div>
			  						<div class="distance">
			  							1200 км
			  							<span class="star star_del"></span>
			  						</div>
			  					</div>
			  					<div class="row2 clearfix">
			  						<div class="direction">
			  							<span class="win_from">Москва</span>
			  							<span class="arrow"></span>
			  							<span class="win_to">Красногорск</span>
			  						</div>
			  						<div class="price">22000 руб</div>
			  						<div class=""></div>
			  						<div class=" distance nostar"> 460 руб/км</div>
			  					</div>
			  					<div class="row3 clearfix">
			  						<div class="goods distance">25Т &#9679; 72м<sup><small>3</small></sup> &#9679; Электротовары...</div>
			  					</div>
			  					<div class="row4 clearfix">
			  						<div class="type distance">Тент, верхняя загрузка</div>
			  					</div>
			  					<div class="row5 clearfix">
			  						<div class="notice">
			  							<span class="title">Примечание: </span>
			  							<span class="notice_text">Товар необходимо доставить в том виде, в котором был загружен на базе. Предметы хрупкие. Тендер.</span>
			  							<span class="notice_text_short"></span>
			  						</div>
			  					</div>
								<span>
			  					<div class="map">
			  						<img src="<?php echo esc_url(get_template_directory_uri());?>/images/minimapg.png" alt="map">
			  					</div>
								</span>
									<div class="row6 clearfix">
			  						<span class="smalllogo"><img src="http://trans.markline.agency/wp-content/themes/transradar/images/smalllogo.png"></span>
			  						<span class="time">2 мин назад</span>
			  						<span class="button">Перейти</span>
			  					</div>
								</div>
	  						</div>
							

								<div class="list_block">
								<div>
			  					<div class="row1 clearfix">
			  						<div class="date">
			  							25.02.2016
			  						</div>
			  						<div class="distance">
			  							1200 км
				  						<span class="star star_del"></span>
				  					</div>
			  					</div>
			  					<div class="row2 clearfix">
			  						<div class="direction">
			  							<span class="win_from">Москва</span>
			  							<span class="arrow"></span>
			  							<span class="win_to">Красногорск</span>
			  						</div>
			  						<div class="price">22000 руб</div>
			  						<div class=""></div>
			  						<div class=" distance nostar"> 460 руб/км</div>
			  					</div>
			  					<div class="row3 clearfix">
			  						<div class="goods distance">25Т &#9679; 72м<sup><small>3</small></sup> &#9679; Электротовары...</div>
			  					</div>
			  					<div class="row4 clearfix">
			  						<div class="type distance">Тент, верхняя загрузка</div>
			  					</div>
									<div class="row5 clearfix">
				  						<div class="notice">
				  							<span class="title">Примечание: </span>
				  							<span class="notice_text">Товар необходимо доставить в том виде, в котором был загружен на базе. Предметы хрупкие. Тендер.</span>
				  							<span class="notice_text_short"></span>
				  						</div>
				  					</div>
									<span>
				  					<div class="map">
				  						<img src="<?php echo esc_url(get_template_directory_uri());?>/images/minimapg.png" alt="map">
				  					</div>
									</span>
			  					<div class="row6 clearfix">
			  						<span class="smalllogo"><img src="http://trans.markline.agency/wp-content/themes/transradar/images/smalllogo.png"></span>
			  						<span class="time">2 мин назад</span>
			  						<span class="button">Перейти</span>
			  					</div>
							</div>
								</span>
	  						</div>
		  				</div>

						</div>
	  					
						</div>
	  		</div> -->
  		</div>
		</div>
</div>
</span>
</div>

<?php get_footer(); ?>