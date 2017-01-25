<?php
class ApiClass {
	// объявление свойства
	private function get_api_url() {
		$api_url = get_option('api_url');
		if (!empty($api_url)) {
			return $api_url;
		}
		return false;
	}
	// 
	protected function get_exchange_info($id) {
		$get_result = $this->request('exchanges/'.$id, '', true);

		if (isset($get_result) && !empty($get_result)) {
			return $get_result['body'];
		}
		return false;
	}
	// 
	public function get_currency_rates($id) {
		$get_result = $this->request('currencies/'.$id, '', true);

		if (isset($get_result) && !empty($get_result)) {
			return $get_result['body']['rates'];
		}
		return false;
	}
	// 
	public function request($method, $params, $get=false) {
		$api_url = $this->get_api_url();
		if(is_string($params)) parse_str($params, $params);

		if( $api_url ) {
			$headers = array();
			if ($get) {
				$url = $api_url.$method.'?'.http_build_query($params);
				// var_dump($url);
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
				curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_POST, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				// curl_setopt($ch,CURLOPT_POST, count($fields));
				// curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
				curl_setopt($ch, CURLINFO_HEADER_OUT, true);
				curl_setopt($ch, CURLOPT_HEADER, true);
				$response = curl_exec($ch);
				// var_dump($response);
				$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
				$header_text = substr($response, 0, $header_size);
				$body = substr($response, $header_size);
				// get headers
				$headers = array();
				foreach (explode(PHP_EOL, $header_text) as $i => $line) {
					if ($i === 0) $headers['http_code'] = $line; 
					else {
						list ($key, $value) = explode(': ', $line);
						if($key) $headers[$key] = $value;
					}
				}

				$total = (!empty($headers['X-Total-Count'])?(int)$headers['X-Total-Count']:0);
				$xffi  = (!empty($headers['X-Forced-Freight-Index'])?(int)$headers['X-Forced-Freight-Index']:'');

				$out = array(
					'url' => $url,
					'params' => $params,
					'headers' => $headers,
					'xffi' => $xffi,
					'total' => $total,
					'body' => json_decode($body, true),
				);
				return $out;
			} else {
				$curl = curl_init();
				curl_setopt($curl, CURLOPT_URL, $api_url.$method);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
				$out = curl_exec($curl);
				curl_close($curl);
				return $out;
			}
		} else return false;
	}
	// 
	public function get_location_list($string) {
		$string_encoded = urlencode($string);
		$get_result = $this->request('places', 'input='.$string_encoded, true);
		// var_dump($get_result);
		if (isset($get_result) && !empty($get_result)) {
			foreach ($get_result['body']['places'] as $item) {
				if (isset($item['id']) && isset($item['description'])) {
					$description = preg_replace('#'.$string.'#iu','<span style="color:#333;font-weight:bold;">\\0</span>', $item['description']);
					$result .= '<div data-id="' . $item['id'] . '" class="places" data-is-country="'.(!empty($item['is_country'])?1:0).'">' . $description . '</div>';
				}
			}
			return $result;
		}
		return false;
	}
	// 
	public function build_currencies_menu() {
		// var_dump($_COOKIE);
		if (isset($_COOKIE['currency']) && isset($_COOKIE['currency_id'])) {
			$class = $_COOKIE['currency'];
		} else {
			$class = 'USD';
		}

		$get_result = $this->request('currencies', '', true);

		if ($get_result) {
			$result = '<div class="header_button currency" data-content="' . $class . '"><div class="popup curr_box">';
			foreach ($get_result['body']['currencies'] as $item) {
				// var_dump($item);
				$result .= '<a href="#" data-id="' . $item['id'] . '">' . $item['code'] . '</a>';
			}
			$result .= '</div></div>';
			echo $result;
		} else {
			echo 'нет данных';
		}
	}
	// 
	public function build_header_info() {
		$exchanges = $this->request('exchanges', '', true);
		$total_freights = $this->request('freights', 'count=0', true);
		if ( $exchanges && $total_freights ) {
			$total_exchanges = count($exchanges['body']['exchanges']);
			$total_freights = $total_freights['total'];
			$total_freights = number_format($total_freights, 0, ',', ' ');
			if ($total_exchanges > 0 && $total_freights > 0) {
				$fr_last = substr($total_freights, -1);
				switch ($fr_last) {
					case 1:
						$fr_word = 'актуальный груз';
						break;
					case 2:
						$fr_word = 'актуальныx груза';
						break;
					case 3:
						$fr_word = 'актуальныx груза';
						break;
					case 4:
						$fr_word = 'актуальныx груза';
						break;
					default:
						$fr_word = 'актуальных грузов';
						break;
				}
				$exch_last = substr($total_exchanges, -1);
				switch ($exch_last) {
					case 1:
						$exch_word = 'сайта';
						break;
					default:
						$exch_word = 'сайтов';
						break;
				}
				echo '<span>'.$total_freights.'</span> '.$fr_word.' с <span>'.$total_exchanges.'</span> '.$exch_word;
			} else echo '<span>500 000</span> актуальных грузов с <span>96</span> сайтов';
		}
		return false;
	}
	// 
	public function build_exchange_sites_list() {
		$get_result = $this->request('exchanges', '', true);
		$sites = get_option('sites');
		if ($get_result) {
			foreach ($get_result['body']['exchanges'] as $item) {
				// var_dump($item);
				$image = $sites[$item['id']]['logo'] ? $sites[$item['id']]['logo'] : $item['logo'];
				$result .= '<div class="check_site">
								<label class="type-checkbox">
									<input type="checkbox" data-flag="'.$item['bit_flag'].'" name="search_site_'.$item['id'].'" hidden />
									<img src="'.$image.'" alt="'.$item['name'].'" title="'.$item['name'].'">
								</label><br>
								<span class="site_url">'.$item['url'].'</span>
							</div>';
			}
			echo $result;
		} else {
			echo 'нет данных';
		}
	}
	// 
	public function build_exchange_sites_banners() {
		$get_result = $this->request('exchanges', '', true);
		$sites = get_option('sites');
		if ($get_result) {
			$result .= '<div class="item active">';
		foreach ($get_result['body']['exchanges'] as $key => $value) {
		if ($key !=0 && ($key % 6 == 0)) {
		  $result .= "</div>";
		  $result .= "<div class='item'>";
		}
		$image = $sites[$value['id']]['logo'] ? $sites[$value['id']]['logo'] : $value['logo'];
		$result .= '<a href="'.$value['url'].'"><img src="'.$image.'" alt="'.$value['name'].'" title="'.$value['name'].'"></a>';
		}
		$result .= '</div>';
			echo $result;
		} else {
			echo 'нет данных';
		}
	}
	// 
	public function build_body_type_list($body_type) {
		$get_result = $this->request('truck-body-type-groups/'.$body_type, '', true);
		if ($get_result) {
			$result = '<div class="body_title">'.$get_result['name'].'</div>';
			foreach ($get_result['body']['truck_body_types'] as $item) {
				if (isset($item['truck_loading_methods'])) {
					$has_sub = 'has_sub';
					$sub_items_arrow = '<span class="sub_body_link"></span>';
					$sub_body_list = '<div class="sub_body" data-id="'.$item['id'].'">';
					foreach ($item['truck_loading_methods'] as $subbody) {
						$sub_body_list .= '
						<div class="check_body_loading">
							<label class="type-checkbox">
								<input type="checkbox" data-flag="'.$subbody['bit_flag'].'" data-id="'.$item['id'].'" name="search_sub_body_'.$subbody['id'].'" hidden />
								<span class="check_all">'.$subbody['name'].'</span>
							</label>
						</div>';
					}
					$sub_body_list .= '</div>';
				} else {
					$has_sub = '';
					$sub_items_arrow = '';
					$sub_body_list = '';
				}
				$result .= '
				<div class="check_body '.$has_sub.'" data-id="'.$item['id'].'">
					<label class="type-checkbox">
						<input type="checkbox" data-flag="'.$item['bit_flag'].'" data-id="'.$item['id'].'" name="search_body'.$item['id'].'" hidden />
						<span class="check_all">'.$item['name'].'</span>
					</label>'.$sub_items_arrow.'
				</div>';
				$result .= $sub_body_list;
			}
			echo $result;
		} else {
			echo 'нет данных';
		}
	}
	// 
	public function build_result($result, $prefix=false) 
	{
		if (!empty($result['body']['freights']) && is_array($result['body']['freights']))
		{
			$result = $result['body']['freights'];
			$cur_name = $_COOKIE['currency'] ? $_COOKIE['currency'] : 'USD';
			$cur_id = $_COOKIE['currency_id'] ? $_COOKIE['currency_id'] : 1;
			$rates = $this->get_currency_rates($cur_id);

			$google_key = get_option('google_key');

			foreach ($result as $item) {
				// var_dump($item);
				$id = $item['id'];
				$shipping_date_min = date('d.m.Y', strtotime($item['shipping_date']['min']));
				$shipping_date_max = date('d.m.Y', strtotime($item['shipping_date']['max']));
				if ( $shipping_date_min == $shipping_date_max ) {
					$shiping_dates = $shipping_date_max;
				} else {
					$shiping_dates = $shipping_date_min.' - '.$shipping_date_max;
				}
				$date_created = $item['date_created'];
				$date_modified = $item['date_modified'];
				$distance = $item['distance'];
				$city_from_title = $item['city_from']['description'];
				$city_from = $item['city_from']['terms'][0]['value'];
				$flag_from = esc_url(get_template_directory_uri()) . '/images/flags/' . $item['city_from']['country_code'] . '.svg';
				
				$city_to_title = $item['city_to']['description'];
				$city_to = $item['city_to']['terms'][0]['value'];
				
				$flag_to = esc_url(get_template_directory_uri()) . '/images/flags/' . $item['city_to']['country_code'] . '.svg';
				
				if ( $item['adr'] ) {
					$goods_adr = 'adr';
					$adr_title = 'ADR';
				} else {
					$goods_adr = '';
					$adr_title = '';
				}

				$reward_currency_id = $item['reward']['currency']['id'];
				$reward_amount = 0;
				$reward_milage = 0;
				if ( $reward_currency_id != $cur_id ) {
					for ($j = 0; $j < count($rates); $j++) {
						if ( $reward_currency_id == $rates[$j]['currency_id'] ) {
							$reward_amount = $item['reward']['amount']/$rates[$j]['rate'];
							break;
						}
					}
					$reward_currency_code = $cur_name;
					if ($distance != '0') {
						$reward_milage = $reward_amount/$distance;
					}
				} else {
					$reward_amount = $item['reward']['amount'];
					$reward_currency_code = $item['reward']['currency']['code'];
					if ($distance != '0') {
						$reward_milage = $reward_amount/$distance;
					}
				}
				$reward_amount = number_format($reward_amount, 0, '.', ',');
				$reward_milage = number_format($reward_milage, 2, '.', ',');
				
				$reward_milage_currency_code = $reward_currency_code . '/км';

				$weight = $item['weight'];
				$volume = $item['volume'];
				$name = $item['name'];
				$name_short = mb_substr($name, 0, 9);
				if ( mb_strlen($name_short) < mb_strlen($name) ) {
					$name_short .= '...';
				} else $name_short = $name;

				if ($prefix =='back') {
					$id_prefix = 'back';
					$sufix = 'orange';
					$pointer_color = 'ffa631';
				} else {
					$id_prefix = 'main';
					$sufix = '';
					$pointer_color = '206eb6';
				}
				
				// $track_block = '';
				$track_info = '';
				// var_dump($item['truck_body_types']);
				foreach ($item['truck_body_types'] as $item2) {
					// var_dump($item2);
					$track_info .= $item2['name'];
					$track_info .= $item2['truck_loading_methods'][0]['name'] ? ', '.$item2['truck_loading_methods'][0]['name'] : '';
					$track_info .= ' | ';
				}
				$track_info = rtrim($track_info, ' | ');

				// $truck_body_types_name = $item['truck_body_types'][0]['name'];
				// $truck_loading_methods_name = $item['truck_body_types'][0]['truck_loading_methods'][0]['name'];
				$description = $item['description'];
				// $description_short = mb_substr($description, 0, 26);
				// if ( mb_strlen($description_short) < mb_strlen($description) ) {
				// 	$description_short .= '...';
				// } else 
				$description_short = $description;

				$city_from_lat = $item['city_from']['location']['lat'];
				$city_from_lng = $item['city_from']['location']['lng'];
				$city_from_id = $item['city_from']['id'];

				$city_to_lat = $item['city_to']['location']['lat'];
				$city_to_lng = $item['city_to']['location']['lng'];
				$city_to_id = $item['city_to']['id'];

				$exchange_id = $item['exchange']['id'];
				$exchange_name = $item['exchange']['name'];
				$date_modified = strtotime($item['date_modified']);
				$date_ago = (time() - $date_modified);
				if ( $date_ago < 3600 ) {
					$date_ago = floor($date_ago/60).' мин';
				} elseif ( $date_ago < 86400 ) {
					$date_ago = floor($date_ago/60/60).' час';
				} else {
					$date_ago = floor($date_ago/60/60/24).' дн';
				}

				$exchange_logo = $this->get_exchange_info($item['exchange']['id']);
				$sites = get_option('sites');
				$exchange_logo = $sites[$item['exchange']['id']]['logo'] ? $sites[$item['exchange']['id']]['logo'] : $exchange_logo['logo'];

				$source_url = $item['source_url'];

							// <span class="star star_add"></span><span class="star_down"></span>
				ob_start(); ?>
					<div class="window_content" id="<?= $id_prefix ?>_box_<?= $id ?>"
						data-box-id="<?= $id ?>"
						data-date-from="<?= $shipping_date_min ?>"
						data-date-to="<?= $shipping_date_max ?>"
						data-addr-from="<?= $city_from_id ?>"
						data-addr-to="<?= $city_to_id ?>"
						data-distance="<?= $distance ?>"
						>
						<div class="whitely">
							<div class="row1 clearfix">
								<div class="date <?= $sufix ?>"><?= $shiping_dates ?></div>
								<div class="distance <?= $sufix ?>">
									<span class="milage"><?= $distance ?></span> км
								</div>
							</div>
							<div class="row2 clearfix">
								<div class="direction">
									<span class="win_from text-overflow" title="<?= $city_from_title ?>" style="background: url(<?= $flag_from ?>) no-repeat left top; background-size: 17px 12px;"><?= $city_from ?></span>
									<span class="arrow <?= $sufix ?>"></span>
									<span class="win_to text-overflow" title="<?= $city_to_title ?>" style="background: url(<?= $flag_to ?>) no-repeat left top; background-size: 17px 12px;"><?= $city_to ?></span>
								</div>
								<?php if($reward_amount) { ?>
								<div class="price text-overflow <?= $sufix ?>">
									<span data-id="<?= $reward_currency_id ?>" data-initial="<?= $item['reward']['amount'] ?>" class="reward_amount"><?= $reward_amount ?></span>
									<span class="cur_name"><?= $reward_currency_code ?></span>
								</div>
								<?php } ?>
								<?php if($reward_milage) { ?>
								<div style="position:relative;">
									<div class="distance nostar text-overflow">
										<span class="reward_milage"><?= $reward_milage ?></span>
										<span class="cur_name" title="<?= $reward_milage_currency_code ?>"><?= $reward_milage_currency_code ?></span>
									</div>
								</div>
								<?php } ?>
							</div>
							<div class="row3 clearfix">
								<div class="goods <?= $sufix ?> <?= $goods_adr ?> distance text-overflow" title="<?= $adr_title ?>"><?= $weight ?>т &#9679; <?= $volume ?>м<sup><small>3</small></sup>
									&#9679; <span title="<?= $name ?>"><?= $name_short ?></span>
								</div>
							</div>
							<div class="row4 clearfix">
								<div class="type <?= $sufix ?> distance"><?= $track_info ?></div>
							</div>
							<div class="row5 clearfix">
								<div class="notice closen text-overflow">
									<span class="title">Примечание: </span>
									<span class="notice_text"><?= $description ?></span>
								</div>
								<button class="icon-sprite-back" data-back-filter="" data-title="Подобрать обратный груз" data-active-title="Отменить подбор" data-warning-title="Карточка более не соответствует выбранным параметрам фильтра"></button>
							</div>
							<div class="hiden">
								<div class="map" id="map_<?= $id ?>" data-from_id="<?= $city_from_id ?>" data-to_id="<?= $city_to_id ?>">loading</div>
							</div>
							<div class="row6 clearfix">
								<span class="smalllogo"><img src="<?= $exchange_logo ?>" title="<?= $exchange_name ?>"></span>
								<span class="time"><?= $date_ago ?> назад</span>
								<a target="_blank" href="/transition?url=<?= urlencode($source_url) ?>&shiping_dates=<?= $shiping_dates ?>&distance=<?= $distance ?>&flag_from=<?= urlencode($flag_from) ?>&flag_to=<?= urlencode($flag_to) ?>&city_from=<?= $city_from ?>&city_to=<?= $city_to ?>&city_from_title=<?= $city_from_title ?>&city_to_title=<?= $city_to_title ?>&reward_amount=<?= $item['reward']['amount'] ?>&reward_currency_id=<?= $reward_currency_id ?>&goods_adr=<?= $goods_adr ?>&adr_title=<?= $adr_title ?>&weight=<?= $weight ?>&volume=<?= $volume ?>&full_name=<?= $name ?>&name_short=<?= $name_short ?>&track_info=<?= $track_info ?>&site_logo=<?= urlencode($exchange_logo) ?>"><span class="button <?= $sufix ?>">Перейти</span></a>
							</div>
						</div>
					</div>
			<?php $result_html .= ob_get_contents(); ob_clean();
			}
			$result_html .='<div class="white_text" style="display: none;">Загрузка...<br><img src="/wp-content/themes/transradar/img/ajax-loader.gif" alt=""></div>';

			return $result_html;
		}
		if(empty($result['params']['ffid']))
			return '<div class="white_text">Грузов не найдено</div>';
	}


}

?>