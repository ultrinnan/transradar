<?php
get_template_part($_SERVER['DOCUMENT_ROOT'].'/wp-config.php' );

$site_options = 'site_options'; // это часть URL страницы, в данном случае не будет зависимости от того, в какой файл вставляем
 
/*
 * Функция, добавляющая страницу в пункт меню Настройки
 */
function site_options() {
	global $site_options;
	add_menu_page( 'Дополнительные настройки сайта', 'Дополнительно', 'manage_options', $site_options, 'site_options_content', 'dashicons-admin-generic'); 
	//картинки тут - https://developer.wordpress.org/resource/dashicons/#slides
}
add_action('admin_menu', 'site_options');
 
/**
 * Возвратная функция (Callback)
 */
function site_options_content(){
		// var_dump('<pre>');
	if ($_POST) {
		// var_dump($_POST);
		// var_dump('---');
		$site_options = array();

		foreach ($_POST as $key => $value) {
			$site_options[$key] = $value;
		}

		update_option('site_options', $site_options);
	}

	$result = get_option('site_options');

	// var_dump($result);
	// var_dump('</pre>');
	?>
		<div class="wrap">
		<h1>Дополнительные настройки сайта</h1>
		
		<form method="POST" enctype="multipart/form-data">

			<div class="form-group">
			  <label for="main_phone">Основной телефон:</label>
			  <input type="text" class="form-control" id="main_phone" name="main_phone" value="<?php echo $result['main_phone']?>">
			</div>
			<div class="form-group">
			  <label for="main_email">Основной e-mail:</label>
			  <input type="email" class="form-control" id="main_email" name="main_email" value="<?php echo $result['main_email']?>">
			</div>
			<div class="form-group">
			  <label for="youtube">Код видео на YouTube: <span style="color: #ccc;">(например: https://youtu.be/<span style="color: #488E1E; text-decoration:underline;">GEQIzWUOn6A</span>)</span></label>
			  <input type="text" class="form-control" id="youtube" name="youtube" value="<?php echo $result['youtube']?>">
			</div>

			<div class="form-group">
				<legend>Информация для Контактов</legend>
			  <label for="office_phone">Офисный телефон:</label>
			  <input type="text" class="form-control" id="office_phone" name="office_phone" value="<?php echo $result['office_phone']?>">
			  <label for="office_email">Офисный e-mail:</label>
			  <input type="email" class="form-control" id="office_email" name="office_email" value="<?php echo $result['office_email']?>">
			  <label for="office_work_time">Режим работы:</label>
			  <input type="text" class="form-control" id="office_work_time" name="office_work_time" value="<?php echo $result['office_work_time']?>">
			</div>
			<div class="form-group">

				<legend>Социальные сети</legend>
			  
			  <label for="vkontakte"><a target="_blank" href="<?php echo $result['vkontakte']?>"><span class="social"><i class="fa fa-vk"></i></span></a> Вконтакте:</label>
			  <input type="text" class="form-control" id="vkontakte" name="vkontakte" value="<?php echo $result['vkontakte']?>">
			  
			  <label for="odnoklasniki"><a target="_blank" href="<?php echo $result['odnoklasniki']?>"><span class="social"><i class="fa fa-odnoklassniki"></i></span></a> Однокласники:</label>
			  <input type="text" class="form-control" id="odnoklasniki" name="odnoklasniki" value="<?php echo $result['odnoklasniki']?>">

			  <label for="facebook"><a target="_blank" href="<?php echo $result['facebook']?>"><span class="social"><i class="fa fa-facebook"></i></span></a> Facebook:</label>
			  <input type="text" class="form-control" id="facebook" name="facebook" value="<?php echo $result['facebook']?>">
			  
			  <label for="twitter"><a target="_blank" href="<?php echo $result['twitter']?>"><span class="social"><i class="fa fa-twitter"></i></span></a> Twitter:</label>
			  <input type="text" class="form-control" id="twitter" name="twitter" value="<?php echo $result['twitter']?>">
			  
			</div>
			
			<p class="submit">  
				<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />  
			</p>
		</form>
	</div>
<?php
}