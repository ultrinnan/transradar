<?php
$sites_page = 'sites_page'; // это часть URL страницы
  
/*
 * Функция, добавляющая страницу в пункт меню Настройки
 */
function sites_page() {
    global $sites_page;
    add_menu_page( 'Биржи', 'Биржи', 'manage_options', $sites_page, 'sites_page_content', 'dashicons-admin-site'); 
    //картинки тут - https://developer.wordpress.org/resource/dashicons/#slides
}
add_action('admin_menu', 'sites_page');
  
/**
 * Возвратная функция (Callback)
 */
function sites_page_content()
{
     
 
    	// var_dump('<pre>');
    if ($_POST) {
 
        $files = $_FILES;
        $form_data = $_POST;
    	
 
        // var_dump($files);
        // var_dump($form_data);
 
        
        $sites = $form_data;
 
        //Каталог, в который мы будем принимать файл:
        @mkdir(dirname(__DIR__).'/images/sites/', 0777);
        $uploaddir = dirname(__DIR__).'/images/sites/';
        // var_dump($uploaddir);
 
        // Копируем файл из каталога для временного хранения файлов:
        foreach ($form_data as $key => $value) {
        	if (isset($files[$key]['name']['logo']) && !empty($files[$key]['name']['logo'])) {
                $uploadfile = $uploaddir.basename($files[$key]['name']['logo']);
                copy($files[$key]['tmp_name']['logo'], $uploadfile);
                $sites[$key]['logo'] = esc_url(get_template_directory_uri()).'/images/sites/'.basename($files[$key]['name']['logo']);
            }
            # code...
        }

        // for ($i=0; $i < count($form_data); $i++) { 
        //     if (isset($files['name'][$i]['image_url']) && !empty($files['name'][$i]['image_url'])) {
        //         $uploadfile = $uploaddir.basename($files['name'][$i]['image_url']);
        //         copy($files['tmp_name'][$i]['image_url'], $uploadfile);
        //         $sites[$i]['image_url'] = esc_url(get_template_directory_uri()).'/images/sites/'.basename($files['name'][$i]['image_url']);
        //     }
        // }
        // var_dump($sites);
 
    	// var_dump('</pre>');
        update_option('sites', $sites);
    }
 
    $sites = get_option('sites');
     // var_dump($sites);
 
    	// var_dump('</pre>');

    $api_url = get_option('api_url');
	  	if (!empty($api_url)) {
		    $get_result = json_decode(file_get_contents($api_url.'exchanges'), true);
		} else echo "не указан URL API!";
 
    ?>
        <div class="wrap">
        <h1>Настройки сайтов-бирж</h1>
 
        <form method="POST" enctype="multipart/form-data">
 
            <div class="tabs_box">
                <table class="table products table-striped table-hover">
                    <tr class="details_row">
                        <td>ID</td>
                        <td>Логотип</td>
                        <td>Название биржи</td>
                        <td>Ссылка</td>
                    </tr>
                     
                    <?php
                        foreach ($get_result['exchanges'] as $item)
                            {
    ?>
                    <tr>
                        <td><?=$item['id'];?></td>
                        <td>
                        <?php
                            if (isset($sites[$item['id']]['logo']) && !empty($sites[$item['id']]['logo']) ) {
                                ?>
                                <div class="logo_ico">
                                    <img src="<?=$sites[$item['id']]['logo'];?>">
                                </div>
                                <div class="trash_ico">
                                    <i class="fa fa-trash-o" aria-hidden="true" title="Удалить логотип"></i>
                                </div>
                                <input type="hidden" name="<?=$item['id'];?>[logo]" value="<?=$sites[$item['id']]['logo'];?>">
                                <?php
                            } else {
                                ?>
                                 <div class="logo_ico">
                                    <img src="<?=$item['logo'];?>">
                                </div>
                                <div class="trash_ico">
                                    <i class="fa fa-trash-o" aria-hidden="true" title="Удалить логотип"></i>
                                </div>
                                <input type="hidden" name="<?=$item['id'];?>[logo]" value="">
                                <?php
                            }
                        ?>
                        </td>
                        <td><input type="hidden" name="<?=$item['id'];?>[name]" value="<?=$item['name'];?>"><?=$item['name'];?></td>
                        <td><a target="_blank" href="<?=$item['url'];?>"><?=$item['url'];?></a></td>
                    </tr>
    <?php
                            }
                    ?>
                </table>
            </div>
 
            <p class="submit">  
                <input type="submit" class="button-primary fixed_save" value="<?php _e('Save Changes') ?>" />
                <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
            </p>
        </form>
<?php
}