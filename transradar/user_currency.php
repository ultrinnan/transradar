<?php
if (!isset($_COOKIE['currency'])) {
  setcookie("currency", 'USD', time()+60*60*24*30);
}
	
function build_currencies_menu() {
	$get_result = json_decode(file_get_contents('https://dev.api.transradar.com/v1/currencies/'), true);
	$current_list = $get_result['currencies'];
	// var_dump($current_list);
	if (isset($_COOKIE['currency'])) {
		$class = $_COOKIE['currency'];
	} else {
		$class = 'USD';
	}

	if ($current_list) {
		echo '<div class="header_button currency '.$class.'"><div class="popup curr_box">';
		foreach ($current_list as $item) {
			echo '<a href="#">'.$item['code'].'</a>';
		}
		echo '</div></div>';
	} else {
		echo '<script>alert("cannot retrieve currencies from API!")</script>';
	}
}

?>