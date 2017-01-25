<?php
get_template_part($_SERVER['DOCUMENT_ROOT'].'/wp-config.php' );

$faq_page = 'FAQ'; // это часть URL страницы, рекомендую использовать строковое значение, т.к. в данном случае не будет зависимости от того, в какой файл вы всё это вставите
 
/*
 * Функция, добавляющая страницу в пункт меню Настройки
 */
// function true_options() {
function faq_options() {
	global $faq_page;
	add_menu_page( 'FAQ - Вопросы и ответы', 'FAQ', 'manage_options', $faq_page, 'faq_page_content', 'dashicons-editor-help'); 
	//картинки тут - https://developer.wordpress.org/resource/dashicons/#slides
}
add_action('admin_menu', 'faq_options');
 
/**
 * Возвратная функция (Callback)
 */
function faq_page_content(){
	global $faq_page;
	global $wpdb;

		// var_dump('<pre>');
	if ($_POST) {
		
		// var_dump($_POST);
		// var_dump($_FILES);
		// var_dump('---');
		$chapters = array();

		if ( isset($_POST['main_item_name']) && !empty($_POST['main_item_name']) && isset($_POST['question']) && !empty($_POST['question']) && isset($_POST['answer']) && !empty($_POST['answer']) ) {

			$questions = array();
			$answers = array();
			
			foreach ($_POST['question'] as $key => $value) {
				$questions[] = $value;
			}
			foreach ($_POST['answer'] as $key => $value) {
				$answers[] = $value;
			}

			$quiz = array();
			for ($j=0; $j < count($questions) ; $j++) { 
				$quiz[$j]['question'] = $questions[$j];
				$quiz[$j]['answer'] = $answers[$j];
			}
			$temp = array();
			foreach ($quiz as $item) {
				$temp2 = array();
				for ($i=0; $i < count($item['question']); $i++) { 
					$temp2[] = [
					'question' => $item['question'][$i],
					'answer' => $item['answer'][$i]
					];
				}
				$temp[] = $temp2;
			}

			for ($i=0; $i < count($_POST['main_item_name']); $i++) { 
				$chapters[] = [
				'main_item_name' => $_POST['main_item_name'][$i],
				'questions' => $temp[$i]
				];
			}
		update_option('FAQ', $chapters);
		}
	}

	$result = get_option('FAQ');

	// var_dump($result);
	// var_dump('</pre>');
	$total_count = count($result);

	?>
		<div class="wrap">
		<h1>FAQ - Вопросы и ответы</h1>
		<?php
		wp_enqueue_media(); 
		if( function_exists( 'image_uploader_field' ) ) {
				image_uploader_field('uploader_custom', get_option('uploader_custom'));
			}
		?>
		<!-- hiden prototype start -->
		<div class="prototype">
			<div class="main_item">
				<input type="text" class="main_item_name" name="main_item_name[]" value="" placeholder="Введите название раздела">
				<input type="hidden" name="counter" value="<?php echo $total_count;?>">
				<span class="toggler">
					<i class="fa fa-caret-square-o-up" aria-hidden="true" title="свернуть"></i>
					<i class="fa fa-caret-square-o-down" aria-hidden="true" title="развернуть"></i>
				</span>
				<i class="fa fa-minus-circle" aria-hidden="true" title="удалить раздел"></i>

				<div class="items_box">
					<div class="item_box">
						<input type="text" name="question[]" class="faq_input" value="" placeholder="Введите вопрос">
							<i class="fa fa-minus-circle" aria-hidden="true" title="удалить вопрос-ответ"></i><br>
						<textarea name="answer[]" class="faq_textarea" rows="4" placeholder="Введите ответ"></textarea>
					</div>
					<button type="button" class="btn btn-primary add_question">Добавить новый вопрос-ответ</button>
				</div>
			</div>
		</div>
		<!-- hiden prototype end -->
		<form method="POST" enctype="multipart/form-data">
		<?php
			$counter = 0;
			if (!empty($result)) {
				foreach ($result as $faq) {
				?>
					<div class="main_item">
						<input type="text" class="main_item_name" name="main_item_name[<?php echo $counter;?>]" value="<?php echo $faq["main_item_name"];?>" placeholder="Введите название раздела">
						<span class="toggler">
							<i class="fa fa-caret-square-o-up" aria-hidden="true" title="свернуть"></i>
							<i class="fa fa-caret-square-o-down" aria-hidden="true" title="развернуть"></i>
						</span>
						<i class="fa fa-minus-circle" aria-hidden="true" title="удалить раздел"></i>
						<div class="items_box">
<?php
					if (!empty($faq['questions'])) foreach ($faq['questions'] as $q_a) {
?>						
							<div class="item_box">
								<input type="text" name="question[<?php echo $counter;?>][]" class="faq_input" value="<?php echo $q_a['question'];?>" placeholder="Введите вопрос">
									<i class="fa fa-minus-circle" aria-hidden="true" title="удалить вопрос-ответ"></i><br>
								<textarea name="answer[<?php echo $counter;?>][]" class="faq_textarea" rows="4" placeholder="Введите ответ"><?php echo $q_a['answer'];?></textarea>
							</div>
<?php						
					}
?>					
							<button type="button" class="btn btn-primary add_question">Добавить новый вопрос-ответ</button>
						</div>
					</div>
<?php
			$counter++;		
				}
			} else {
				add_option( 'FAQ', '');
				echo '<script>alert("Отсутствующие таблицы были созданы, можно работать")</script>';
			}
		?>
			<button type="button" class="btn btn-primary add_section">Добавить новый раздел</button>
			<p class="submit">  
				<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />  
			</p>
		</form>
	</div><?php
}