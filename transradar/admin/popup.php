<?php
get_template_part($_SERVER['DOCUMENT_ROOT'].'/wp-config.php' );

$pop_up_page = 'POP-UPs'; // это часть URL страницы
 
/*
 * Функция, добавляющая страницу в пункт меню Настройки
 */
function popup_options() {
	global $pop_up_page;
	add_menu_page( 'Всплывающие подсказки', 'Подсказки', 'manage_options', $pop_up_page, 'pop_up_page_content', 'dashicons-admin-comments'); 
	//картинки тут - https://developer.wordpress.org/resource/dashicons/#slides
}
add_action('admin_menu', 'popup_options');
 
/**
 * Возвратная функция (Callback) - формирует страницу
 */
function pop_up_page_content(){
	global $pop_up_page;
	global $wpdb;

		// var_dump('<pre>');
	if ($_POST) {
		// var_dump($_POST);
		//some actions after submit
		$popups = $_POST;
		$new_popups = array();

		foreach ($popups as $key => $value) {
			$new_popups[str_replace('_', ' ', $key)] = $value;
			# code...
		}
		// $new_popups['Строгий'] = 'Строгий поиск';
		// var_dump('---');
		// var_dump($new_popups);

		update_option('popups_text', $new_popups);
	}

	$result = get_option('popups_text');
	// var_dump($result);
	// var_dump('</pre>');
	?>
		<div class="wrap">
		<h1>Редактирование всплывающих подсказок</h1>

		<form method="POST" enctype="multipart/form-data">
		
	  <div class="form-group">
	  <?php
foreach ($result as $key => $value) {
?>
	    <label for="<?php echo $key;?>"><?php echo $key;?></label>
	    <textarea rows="3"  class="form-control" name="<?php echo $key;?>"><?php echo $value;?></textarea>
<?php
}
	  ?>

<!-- 
	    <label for="Откуда">Откуда</label>
	    <textarea rows="3"  class="form-control" name="Откуда">Здесь необходимо указать страну или город откуда будет вестись груз
	    </textarea>

	    <label for="Куда">Куда</label>
	    <textarea rows="3"  class="form-control" name="Куда">еще какая-то подсказка
	    </textarea>

	    <label for="Кнопка оповещения">Кнопка оповещения</label>
	    <textarea rows="3"  class="form-control" name="Кнопка оповещения">Нажмите, чтобы включить оповещения о новых грузах по этим параметрам на e-mail
	    </textarea>

	    <label for="Искать обратный груз">Искать обратный груз</label>
	    <textarea rows="3"  class="form-control" name="Искать обратный груз">Если вы хотите найти обратные грузы – укажите с какой даты искать, либо укажите параметры для автоматического поиска (максимальный пробег в сутки и желаемый коридор ожидания после даты разгрузки основного груза
	    </textarea>

	    <label for="Радиус поиска">Радиус поиска</label>
	    <textarea rows="3"  class="form-control" name="Радиус поиска">Поиск внутри страны
	    </textarea>

	    <label for="Тип кузова">Тип кузова</label>
	    <textarea rows="3"  class="form-control" name="Тип кузова">Выберите подходящие типы кузова для поиска грузов
	    </textarea>

	    <label for="Поиск по сайтам">Поиск по сайтам</label>
	    <textarea rows="3"  class="form-control" name="Поиск по сайтам">Выберите актуальные сайты (биржи грузов) для поиска
	    </textarea>

	    <label for="Сортировка объявлений">Сортировка объявлений</label>
	    <textarea rows="3"  class="form-control" name="Сортировка объявлений">Выберите сортировку объявлений
	    </textarea>
	    
	    <label for="Свернуть список">Свернуть список</label>
	    <textarea rows="3"  class="form-control" name="Свернуть список">Свернуть список
	    </textarea>
	    
	    <label for="Развернуть список">Развернуть список</label>
	    <textarea rows="3"  class="form-control" name="Развернуть список">Раскрыть список
	    </textarea>
	    
	    <label for="Новый список избранного">Новый список избранного</label>
	    <textarea rows="3"  class="form-control" name="Новый список избранного">Создать новый список избранных грузов
	    </textarea>
	    
	    <label for="Добавить в избранное">Добавить в избранное</label>
	    <textarea rows="3"  class="form-control" name="Добавить в избранное">Добавить это объявление в список избранных грузов
	    </textarea>

	    <label for="Убрать из избранного">Убрать из избранного</label>
	    <textarea rows="3"  class="form-control" name="Убрать из избранного">Убрать объявление из списка избранных
	    </textarea> -->
	  </div>

			<p class="submit">  
				<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />  
			</p>
		</form>
	</div><?php
}