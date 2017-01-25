<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/wp-config.php');
include_once('admin/api_classes.php');

//-----------------------------------------------------------------
if (isset($_POST['action']) && !empty($_POST['action'])) {
	$action = $_POST['action'];
	switch ($action) {
		case 'get_location_list':
			$string = $_POST['string']?$_POST['string']:'';
			$api = new ApiClass;
			$result = $api->get_location_list($string);
			if ($result) {
				echo $result;
			} else echo '<div class="places">нет результатов</div>';
			break;
		case 'search': //main system logic is here
			//https://api.transradar.com/v1/freights
			//Retrieves an ordered list of freights
			$api = new ApiClass;
			$params = array(
				'cursor'=>($start = $_POST['cursor']?$_POST['cursor']:''), //Descriptor specifying a page of results to be retrieved. See Pagination for more information.
				'count'=>($limit = $_POST['count']?$_POST['count']:''), //The number of freights to be retrieved per page, up to a maximum of 50. Default value is 10. See Pagination for more information.
				'sdmn'=>($shipping_date_min = $_POST['sdmn']?$_POST['sdmn']:''), //Shipping date min.
				'sdmx'=>($shipping_date_max = $_POST['sdmx']?$_POST['sdmx']:''), //Shipping date max.
				'sddm'=>($shipping_date_daily_mileage = $_POST['sddm']?$_POST['sddm']:''), //Shipping date daily mileage. If and only if either sddm or sdid parameter is specified, shipping date is calculated. Otherwise shipping date is defined by sdmn and sdmx parameters. Default value is 1000.
				'sdid'=>($shipping_date_idle_days = $_POST['sdid']?$_POST['sdid']:''), //Shipping date idle days. If and only if either sddm or sdid parameter is specified, shipping date is calculated. Otherwise shipping date is defined by sdmn and sdmx parameters. Default value is 7.
				'dmn'=>($distance_min = $_POST['dmn']?$_POST['dmn']:''), //Distance min.
				'dmx'=>($distance_max = $_POST['dmx']), //Distance max.
				'tbt'=>($track_body_types = $_POST['tbt']?$_POST['tbt']:''), //Truck body types. Parameter value is a bit mask.
				'adr'=>($address = $_POST['adr']?$_POST['adr']:''),
				'wmn'=>($weight_min = $_POST['wmn']?$_POST['wmn']:''), //Weight min.
				'wmx'=>($weight_max = $_POST['wmx']?$_POST['wmx']:''), //Weight max.
				'vmn'=>($volume_min = $_POST['vmn']?$_POST['vmn']:''), //Volume min.
				'vmx'=>($volume_max = $_POST['vmx']?$_POST['vmx']:''), //Volume max.
				'rcid'=>($reward_id = $_POST['rcid']?$_POST['rcid']:''), //Reward currency id.
				'ramn'=>($reward_min = $_POST['ramn']?$_POST['ramn']:''), //Reward amount min.
				'ramx'=>($reward_max = $_POST['ramx']?$_POST['ramx']:''), //Reward amount max.
				'exch'=>($exchanges = $_POST['exch']?$_POST['exch']:''), //Exchanges. Parameter value is a bit mask.
				'dcmn'=>($date_created_min = $_POST['dcmn']?$_POST['dcmn']:''), //Date created min.
				'dcmx'=>($date_created_max = $_POST['dcmx']?$_POST['dcmx']:''), //Date created max.
				'soem'=>($search_options_exact_match = $_POST['soem']?$_POST['soem']:''), //Search options exact match. Default value is 1.
				// 'sort'=>$_POST['sort']?$_POST['sort']:'', //Comma-separated list of sort keys. Valid sort keys see in doc:
			);

			$back = $_POST['back'] ? true : false;

			$tlm = $_POST['tlm']?$_POST['tlm']:''; //Truck loading methods of a truck body type specified as id parameter. Parameter value is a bit mask.
			$temp = explode('/', $tlm);
			foreach ($temp as $item) {
				if (!empty($item)) {
					$index = strpos($item, '=');
					$key = substr($item, 0, $index);
					$value = substr($item, $index+1);
					$params[$key] = $value;
				}
			}

			switch ($params['dcmn']) {
				case '1h':
					$params['dcmn'] = date('m/d/Y H:i:s', strtotime('-1 hour'));
					break;
				case '6h':
					$params['dcmn'] = date('m/d/Y H:i:s', strtotime('-6 hour'));
					break;
				case '24h':
					$params['dcmn'] = date('m/d/Y H:i:s', strtotime('-24 hour'));
					break;
				case '3d':
					$params['dcmn'] = date('m/d/Y H:i:s', strtotime('-3 day'));
					break;
				case '7d':
					$params['dcmn'] = date('m/d/Y H:i:s', strtotime('-7 day'));
					break;
				case '2m':
					$params['dcmn'] = date('m/d/Y H:i:s', strtotime('-2 month'));
					break;
				default:
					$params['dcmn'] = '';
					break;
			}
			$params['dcmn'] = urlencode($params['dcmn']);

			if ($back) {
				$params['sort'] = $_POST['sort_to']?$_POST['sort_to']:'';
				if ( $params['sddm'] != '' || $params['sdid'] != '') {
					$params['sdmn'] = $_POST['sdmn'] ? $_POST['sdmn'] : ''; //Shipping date min.
					$params['sdmx'] = $_POST['sdmx'] ? $_POST['sdmx'] : ''; //Shipping date max.
				} else {
					$params['sdmn'] = $_POST['back_sdmn'] ? $_POST['back_sdmn'] : ''; //Shipping date min.
					$params['sdmx'] = $_POST['back_sdmx'] ? $_POST['back_sdmx'] : ''; //Shipping date max.
				}
				
				$params['pfid'] = $_POST['ptid'] ? $_POST['ptid']:''; //Place to id.
				$params['pfra'] = $_POST['ptra'] ? $_POST['ptra']:''; //Place to radius around. Default value is 50.
				$params['pfwc'] = $_POST['ptwc']; //Place to within country. Default value is 1.
				$params['ptid'] = $_POST['pfid'] ? $_POST['pfid']:''; //Place from id.
				$params['ptra'] = $_POST['pfra'] ? $_POST['pfra']:''; //Place from radius around. Default value is 50.
				$params['ptwc'] = $_POST['pfwc']; //Place from within country. Default value is 1.
			} else {
				$params['sort'] = $_POST['sort_from']?$_POST['sort_from']:'';
				
				$params['pfid'] = $_POST['pfid'] ? $_POST['pfid']:''; //Place from id.
				$params['pfra'] = $_POST['pfra'] ? $_POST['pfra']:''; //Place from radius around. Default value is 50.
				$params['pfwc'] = $_POST['pfwc']; //Place from within country. Default value is 1.
				$params['ptid'] = $_POST['ptid'] ? $_POST['ptid']:''; //Place to id.
				$params['ptra'] = $_POST['ptra'] ? $_POST['ptra']:''; //Place to radius around. Default value is 50.
				$params['ptwc'] = $_POST['ptwc']; //Place to within country. Default value is 1.
				
				unset($params['sddm']);
				unset($params['sdid']);
			}

			foreach ($params as $key => $value) {
				if ( $value !='' ) {
					$params_string .= $key.'='.$value.'&';
				}
			}

			$result = $api->request('freights', $params_string, true);

			$result_arr = array();
			$result_arr['freights_count'] = $result['total'];
			$result_arr['freights_cursor'] = $result['body']['next_cursor'];

			if ( $back ) {
				$result_arr['result_html'] = $api->build_result($result['body']['freights'], 'back');
			} else {
				$result_arr['result_html'] = $api->build_result($result['body']['freights']);
			}

			echo json_encode($result_arr, JSON_UNESCAPED_UNICODE);
			
			break;		
		case 'search_back_for_one':
			$params_string = '';
			$result = $api->request('freights', $params_string, true);

			break;
		case 'account': //all functions for accounts
			/*
			Creates a new account. The request can be sent with an empty body. If and only if the request body is empty, account password will be generated automatically and returned in the response body. If the request body is present, sends a verification link to the email address that is used to create the account.
			*/
			break;
		case 'direction':
			$google_key = get_option('google_key');
			if (!$google_key) {
				echo json_encode(esc_url(get_template_directory_uri()).'/images/no_api.png');
			} else {
				// $color = $_POST['color'];
				$from = urlencode($_POST['from']);
				$to = urlencode($_POST['to']);
				echo json_encode('<iframe
				  	width="277"
				  	height="149"
				  	frameborder="0" style="border:0"
				  	src="https://www.google.com/maps/embed/v1/directions?key=' . $google_key . '&origin=place_id:' . $from . '&destination=place_id:' . $to . '&mode=driving" allowfullscreen>
				 </iframe>');
			}

		break;
		case 'get_rates': // get rates for selected currency
			$api = new ApiClass;
			if ($_POST['string']) {
				$result = $api->get_currency_rates($_POST['string']);
				echo json_encode($result);
			}
			break;		
		default:
			# code...
			break;
	}
}

?>