<?php
// if (!isset($_COOKIE['truck_body_types'])) {
//   setcookie("truck_body_types", '', time()+60*60*24*30);
// }
// if (!isset($_COOKIE['exchange_sites'])) {
//   setcookie("exchange_sites", '', time()+60*60*24*30);
// }
global $body_types;	

$api_url = get_option('api_url');
if (!empty($api_url)) {
  $truck_body_type_groups = json_decode(file_get_contents($api_url.'truck-body-type-groups'), true);
  foreach ($truck_body_type_groups['truck_body_type_groups'] as $item) {
  	$body_types[$item['name']] = $item['truck_body_types'];
  }
} else {
	echo '<script>alert("cannot retrieve build_truck_body_types from API!")</script>';
}

?>