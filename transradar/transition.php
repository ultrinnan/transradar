<?php 
/*
Template Name: transition
*/
global $path;
$path = 'transition';
get_header(); 

if ($_GET) {
	$url = $_GET['url'] ? $_GET['url'] : 'http://' . $_SERVER['SERVER_NAME'];
	$shiping_dates = $_GET['shiping_dates'] ? $_GET['shiping_dates'] : ''; 
	$distance = $_GET['distance'] ? $_GET['distance'] : ''; 
	$flag_from = $_GET['flag_from'] ? $_GET['flag_from'] : ''; 
	$flag_to = $_GET['flag_to'] ? $_GET['flag_to'] : '';
	$city_from = $_GET['city_from'] ? $_GET['city_from'] : ''; 
	$city_to = $_GET['city_to'] ? $_GET['city_to'] : ''; 
	$city_from_title = $_GET['city_from_title'] ? $_GET['city_from_title'] : ''; 
	$city_to_title = $_GET['city_to_title'] ? $_GET['city_to_title'] : ''; 
	
	$reward_amount = $_GET['reward_amount'] ? $_GET['reward_amount'] : ''; 
	$reward_currency_id = $_GET['reward_currency_id'] ? $_GET['reward_currency_id'] : ''; 
	$reward_milage = $_GET['reward_milage'] ? $_GET['reward_milage'] : ''; 
	
	$goods_adr = $_GET['goods_adr'] ? $_GET['goods_adr'] : ''; 
	$adr_title = $_GET['adr_title'] ? $_GET['adr_title'] : ''; 
	$weight = $_GET['weight'] ? $_GET['weight'] : ''; 
	$volume = $_GET['volume'] ? $_GET['volume'] : ''; 
	$full_name = $_GET['full_name'] ? $_GET['full_name'] : ''; 
	$name_short = $_GET['name_short'] ? $_GET['name_short'] : ''; 
	$track_info = $_GET['track_info'] ? $_GET['track_info'] : '';
	$site_logo = $_GET['site_logo'] ? $_GET['site_logo'] : '';

	$cur_name = $_COOKIE['currency'] ? $_COOKIE['currency'] : 'USD';
	$cur_id = $_COOKIE['currency_id'] ? $_COOKIE['currency_id'] : 1;
	$api = new ApiClass;
	$rates = $api->get_currency_rates($cur_id);

	if ( $reward_currency_id != $cur_id ) {
        for ($j = 0; $j < count($rates); $j++) {
            if ( $reward_currency_id == $rates[$j]['currency_id'] ) {
                $reward_amount = $reward_amount/$rates[$j]['rate'];
            }
        }
    }
		$reward_milage = round($reward_amount/$distance, 2);
        $reward_currency_code = $cur_name;
		$reward_amount = number_format($reward_amount, 0, '.', ',');

} else {
	//some action, maybe redirection to main page
}

?>
</nav>
<!-- header end -->
<div class="trans">
  <div class="faq_box page transition">
	  <div class="header">
	  	Спасибо!
	  </div>
		<div class="countdown" data-url="<?=$url;?>">
			Вы будете перенаправлены на сайт через <span>4</span> секунд
		</div>
	  <div class="trans_boxes clearfix">
	  	<div class="trans_box">
	  		<div class="logo_box">
	  			<img src="<?php echo esc_url(get_template_directory_uri());?>/images/logo_dark.png" alt="transradar logo dark">
	  		</div>
	  		Вы выбрали нужный груз
	  	</div>
	  	<div class="trans_box animation">
	  		<div class="logo_box">
	  			<span class="shape first active"></span>
	  			<span class="shape"></span>
	  			<span class="shape"></span>
	  			<span class="shape last"></span>
	  		</div>
	  		Идет переадресация<br>на сайт timocom.ru
	  	</div>
	  	<div class="trans_box">
	  		<div class="logo_box">
	  			<img src="<?=$site_logo;?>" alt="partners logo">
	  		</div>
	  		Теперь узнайте контакты<br>и завершите сделку
	  	</div>
	  </div>

	  <div class="cargo_info">
	  	<div class="header">
	  		<span class="info_static"></span> Информация о грузе
	  	</div>
	  	<div class="box">

			<div class="row1 clearfix">
				<div class="date "><?=$shiping_dates;?></div>
				<div class="distance ">
					<span class="milage"><?=$distance;?></span> км
				</div>
			</div>
			<div class="row2 clearfix">
				<div class="direction">
					<span class="win_from" title="<?=$city_from_title;?>" style="background: url(<?=$flag_from ;?>) no-repeat left top; background-size: 17px 12px;"><?=$city_from;?></span>
					<span class="arrow "></span>
					<span class="win_to" title="<?=$city_to_title;?>" style="background: url(<?=$flag_to ;?>) no-repeat left top; background-size: 17px 12px;"><?=$city_to;?></span>
				</div>
				<div class="price ">
					<span class="reward_amount"><?=$reward_amount ;?></span> 
					<span class="cur_name"><?=$reward_currency_code ;?></span>
				</div>
				<div style="position:relative;">
					<div class="distance nostar">
						~<span class="reward_milage"><?=$reward_milage;?></span> <span class="cur_name"><?=$reward_currency_code ;?></span>/км
					</div>
				</div>
			</div>
			<div class="row3 clearfix">
				<div class="goods  <?=$goods_adr ;?> distance" title="<?=$adr_title ;?>"><?=$weight;?>Т &#9679; <?=$volume;?>м<sup><small>3</small></sup> &#9679; <span title="<?=$name ;?>"><?=$name_short;?></span>
				</div>
			</div>
			<div class="row4 clearfix">
				<div class="type  distance"><?=$track_info;?></div>
			</div>
	  	</div>
	  </div>
		
		<!-- <div class="dont_show">
			<input id="dont_show" type="checkbox" name="dont_show" hidden />
			<label for="dont_show"><span class="search_back_label">Больше не показывать эту страницу, сразу переходить на сайт биржи</span></label>
		</div> -->
	</div>
</div>

		<script src="<?php echo esc_url(get_template_directory_uri());?>/js/jquery-2.2.0.min.js"></script>
		<script src="<?php echo esc_url(get_template_directory_uri());?>/js/jquery-ui-1.11.4.custom/jquery-ui.js"></script>
		<script src="<?php echo esc_url(get_template_directory_uri());?>/js/jquery.autocomplete.min.js"></script>
		<script src="<?php echo esc_url(get_template_directory_uri());?>/js/bootstrap.min.js"></script>
		<script src="<?php echo esc_url(get_template_directory_uri());?>/js/scrolbar/jquery.mCustomScrollbar.concat.min.js"></script>
		<script src="<?php echo esc_url(get_template_directory_uri());?>/js/scripts.js"></script>
		<script src="<?php echo esc_url(get_template_directory_uri());?>/js/jquery.validate.js"></script>
		<script src="<?php echo esc_url(get_template_directory_uri());?>/js/messages_ru.js"></script>
		<script src="<?php echo esc_url(get_template_directory_uri());?>/js/trans_scripts.js"></script>
</body>
</html>
