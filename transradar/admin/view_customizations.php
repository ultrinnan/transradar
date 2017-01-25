<?php
//применяем стили к редактору
function theme_add_editor_styles() {
  add_editor_style( 'css/admin_styles.css' );
}
add_action( 'current_screen', 'theme_add_editor_styles' );
//применяем стили к редактору

//удаляем ненужные пункты меню и виджеты - start
add_action( 'admin_menu', 'remove_menu_items' );
 
function remove_menu_items() {
    // тут мы указываем ярлык пункты который удаляем.
   //  remove_menu_page( 'index.php' );                  // Консоль
    remove_menu_page( 'edit.php' );                   // Записи
    remove_menu_page( 'post-new.php' );                   // Записи
    // remove_menu_page( 'upload.php' );                 // Медиафайлы
    // remove_menu_page( 'edit.php?post_type=page' );    // Страницы
    remove_menu_page( 'edit-comments.php' );          // Комментарии
    // remove_menu_page( 'themes.php' );                 // Внешний вид
    // remove_menu_page( 'plugins.php' );                // Плагины
    // remove_menu_page( 'users.php' );                  // Пользователи
    // remove_menu_page( 'tools.php' );                  // Инструменты
    // remove_menu_page( 'options-general.php' );        // Настройки
    }
add_action( 'admin_menu', 'remove_sub_menu_items' );
 
function remove_sub_menu_items() {
  // Первый параметр это ярлык основного элемента меню
  // Второй параметр это ярлык дочернего элемента данного пункта
  // remove_submenu_page( 'options-general.php', 'options-discussion.php' );
  // remove_submenu_page( 'options-general.php', 'options-writing.php' );
}

function admin_bar_render() {
  global $wp_admin_bar;
  // $wp_admin_bar->remove_menu('post');
  // $wp_admin_bar->remove_menu('my-account'); // ссылка на меню профиля (при отключенных граватарах)
  // $wp_admin_bar->remove_menu('my-account-with-avatar'); // ссылка на меню профиля (граватары включены)
  // $wp_admin_bar->remove_menu('my-blogs'); // ссылка на меню "мои сайты"
  // $wp_admin_bar->remove_menu('get-shortlink'); // меню "короткая ссылка" для текущей записи
  // $wp_admin_bar->remove_menu('edit'); // меню "редактировать запись"
  $wp_admin_bar->remove_menu('new-content'); // все меню "новый материал"
  // $wp_admin_bar->remove_menu('new-post'); // меню "новый материал - запись"
  // $wp_admin_bar->remove_menu('new-page'); // меню "новый материал - страница"
  $wp_admin_bar->remove_menu('comments'); // меню "комментарии"
  // $wp_admin_bar->remove_menu('appearance'); // меню "внешний вид"
  // $wp_admin_bar->remove_menu('updates'); // меню "обновления"
}

add_action( 'wp_before_admin_bar_render', 'admin_bar_render' );
// Как видно из кода, чтобы удалить определенные меню из панели достаточно знать их обозначения. Полный список этих меню можно найти в файле "wp-includes/admin-bar.php", а вот некоторые из них:

/* Удаление виджетов из Консоли WordPress */
function clear_dash(){
  global $wp_meta_boxes;
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['bbp-dashboard-right-now']);
}
remove_action( 'welcome_panel', 'wp_welcome_panel' );
add_action('wp_dashboard_setup', 'clear_dash' );
//а свои виджеты пишем в кастомизаторе
//удаляем ненужные пункты меню и виджеты - end

//логотип в админке и при старте, наш копирайт - start
function admin_logo() {
   echo '
    <style type="text/css">
    	.wp-admin #wpadminbar #wp-admin-bar-site-name>.ab-item:before { 
		    content: "";
        background: white url(http://trans.markline.agency/wp-content/themes/transradar/images/temp_logo.png) no-repeat 0px 0px !important;
        width: 174px;
        height: 37px;
        position: relative;
        padding: 0;
        margin: -2px -81px 1px -7px;
		  }
      #wpadminbar {
        border-bottom: 1px solid #184976;
        height: 38px;
      }
      #wpadminbar #wp-admin-bar-site-name>a.ab-item {
        height: 38px;
      }

    	/* wide WP logo */
    	#wpadminbar #wp-admin-bar-wp-logo>.ab-item {
    		display: none;
			}

      #wpadminbar, #adminmenu, #adminmenu .wp-submenu, #adminmenuback, #adminmenuwrap {
        background: #206eb6;
      }
      #footer-thankyou {
        font-style: normal;
      }
      #wpfooter {
        background-color: #184976;
        color: #6182a1;
      }
    </style>

    <script>
      window.onload = function() {
        document.getElementById("footer-thankyou").innerHTML = "Разработка сайта: <a target=\"_blank\" href=\"http://markline.agency\">MARKLINE</a>";        
      }
    </script>';
}
add_action('admin_head', 'admin_logo');

function login_logo(){
   echo '
   <style type="text/css">
        .login h1 a { 
   				background: url('. get_template_directory_uri() .'/images/logo_dark.png) no-repeat 0 0 !important;
   				width: 161px;
    			height: 32px;
   			}
    </style>';
}
add_action('login_head', 'login_logo');

/* Ставим ссылку с логотипа на сайт, а не на wordpress.org */
add_filter( 'login_headerurl', create_function('', 'return get_home_url();') );
 
/* убираем title в логотипе "сайт работает на wordpress" */
add_filter( 'login_headertitle', create_function('', 'return false;') );   
//логотип в админке - end

//русификация дат - start ------------------------------------------------------------------------
function russian_date_forms($the_date = '') {
  if ( substr_count($the_date , '---') > 0 ) {
    return str_replace('---', '', $the_date);
  }
  // массив замен для русской локализации движка и для английской
  $replacements = array(
    "Январь" => "января", // "Jan" => "января"
    "Февраль" => "февраля", // "Feb" => "февраля"
    "Март" => "марта", // "Mar" => "марта"
    "Апрель" => "апреля", // "Apr" => "апреля"
    "Май" => "мая", // "May" => "мая"
    "Июнь" => "июня", // "Jun" => "июня"
    "Июль" => "июля", // "Jul" => "июля"
    "Август" => "августа", // "Aug" => "августа"
    "Сентябрь" => "сентября", // "Sep" => "сентября"
    "Октябрь" => "октября", // "Oct" => "октября"
    "Ноябрь" => "ноября", // "Nov" => "ноября"
    "Декабрь" => "декабря" // "Dec" => "декабря"
  );
  return strtr($the_date, $replacements);
}
 
// если хотите, вы можете применить только некоторые из фильтров
add_filter('the_time', 'russian_date_forms');
add_filter('get_the_time', 'russian_date_forms');
add_filter('the_date', 'russian_date_forms');
add_filter('get_the_date', 'russian_date_forms');
add_filter('the_modified_time', 'russian_date_forms');
add_filter('get_the_modified_date', 'russian_date_forms');
add_filter('get_post_time', 'russian_date_forms');
add_filter('get_comment_date', 'russian_date_forms');
//русификация дат - end ------------------------------------------------------------------------

// наши виджеты в админке start --------------------------------------
function dashboard_widget_1(){
  // Показать то, что вы хотите показать
  echo "в этом месте могла бы быть ваша реклама :)";
}
function dashboard_widget_2(){
  // Показать то, что вы хотите показать
  echo "<a target=\"_blank\" href=\"http://markline.agency\"><img src=\"http://markline.agency/i/logo.gif\"></a>";
}
function api_url(){
  // https://dev.api.transradar.com/v1/
  if (isset($_POST['clear_url'])) {
    update_option('api_url', null); 
  }
  if (isset($_POST['api_url']) && !empty($_POST['api_url']) ) {
    if (filter_var($_POST['api_url'], FILTER_VALIDATE_URL)) {
      update_option('api_url', $_POST['api_url']);
    } else {
      echo '<div><b>Проверьте правильность ссылки!</b></div>';
    }
  }
  $api_url = get_option('api_url');
  if (!$api_url) {
    echo 'Введите путь к API:<br><form method="POST"><input name="api_url"><input type="submit" value="Сохранить путь"></form>';
  } else {
    echo 'Текущий путь: <b>'.$api_url.'</b><form method="POST"><input type="submit" name="clear_url" value="очистить"></form>';
    // update_option('api_url', null);   
  }
}
function google_key(){
  // https://dev.api.transradar.com/v1/
  if (isset($_POST['clear_key'])) {
    update_option('google_key', null); 
  }
  if (isset($_POST['google_key']) && !empty($_POST['google_key']) ) {
      update_option('google_key', $_POST['google_key']);
  }
  $google_key = get_option('google_key');
  if (!$google_key) {
    echo 'Введите ключ к Google API:<br><form method="POST"><input name="google_key"><input type="submit" value="Сохранить ключ"></form>';
  } else {
    echo 'Текущий ключ: <b>'.$google_key.'</b><form method="POST"><input type="submit" name="clear_key" value="очистить"></form>';
    // update_option('api_url', null);   
  }
}

function api_currencies(){
  $api_url = get_option('api_url');
  if (!empty($api_url)) {
    $get_result = json_decode(file_get_contents($api_url.'currencies/'), true);

    $currencies = array();
    foreach ($get_result['currencies'] as $item) {
      $currencies[$item['id']] = $item['code'];
    }
    // var_dump($currencies);

    echo '<ul class="widget_list">';
    foreach ($get_result['currencies'] as $item) {
      echo '<li>'.$item['code'].'<br>';
      foreach ($item['rates'] as $rates) {
        $rate = $rates['rate'];
        if ($rate < (float)1E-4) {
          $rate = sprintf('%.7f', $rate);
        }
        echo '= '.$rate.' '.$currencies[$rates['currency_id']].'<br>';
      }
      echo '</li>';
    }
    echo '</ul>';
    // var_dump('<pre>');
    // var_dump($get_result);
    // var_dump('</pre>');
  } else echo "не указан URL API!";
}
function api_body_type(){
  $api_url = get_option('api_url');
  if (!empty($api_url)) {
    $get_result = json_decode(file_get_contents($api_url.'truck-body-type-groups'), true);
    // var_dump('<pre>');
    // var_dump($get_result);
    // var_dump('</pre>');
    echo '<ul class="widget_list">';
    foreach ($get_result['truck_body_type_groups'] as $item) {
      echo '<li>'.$item['name'].'</li>';
      if (isset($item['truck_body_types'])) {
        echo '<ul class="widget_list2">';
        foreach ($item['truck_body_types'] as $item2) {
          echo '<li>'.$item2['name'].'</li>';
          if (isset($item2['truck_loading_methods'])) {
            echo '<ul class="widget_list3">';
            foreach ($item2['truck_loading_methods'] as $item3) {
              echo '<li>'.$item3['name'].'</li>';
            }
            echo '</ul>';
          }
        }
        echo '</ul>';
      }
    }
    echo '</ul>';
  } else echo "не указан URL API!";
}
function api_site(){
  $api_url = get_option('api_url');
  if (!empty($api_url)) {
    $get_result = json_decode(file_get_contents($api_url.'exchanges'), true);
    // var_dump('<pre>');
    // var_dump($get_result);
    // var_dump('</pre>');
    echo '<ul class="widget_list">';
    foreach ($get_result['exchanges'] as $item) {
      echo '<li>'.$item['name'].'<br>ID:'.$item['id'].'<br><img src="'.$item['logo'].'"><br>сайт :'.$item['url'].'</li>';
    }
    echo '</ul>';
  } else echo "не указан URL API!";
}
function api_query(){
  $api_url = get_option('api_url');
  if (!empty($api_url)) {
    // $get_result = json_decode(file_get_contents($api_url.'queries'), true);
    $get_result = json_decode(file_get_contents($api_url.'truck-body-type-groups'), true);
    var_dump('<pre>');
    // var_dump($get_result);
    var_dump('</pre>');
    // echo '<ul class="widget_list">';
    // foreach ($get_result['truckBodyTypes'] as $item) {
    //   echo '<li>'.$item['name'].'</li>';
    //   echo '<ul class="widget_list2">';
    //   foreach ($item['truck_loading_methods'] as $item2) {
    //     echo '<li>'.$item2['name'].'</li>';
    //   }
    //   echo '</ul>';
    // }
    // echo '</ul>';
  } else echo "не указан URL API!";
}
// Создаем функцию, используя хук действия
function add_dashboard_widgets() {
  wp_add_dashboard_widget('api_url', 'Путь к API TransRadar', 'api_url');
  wp_add_dashboard_widget('google_key', 'Путь к Google API', 'google_key');
  wp_add_dashboard_widget('dashboard_widget_id_1', 'Пример виджета админки1', 'dashboard_widget_1');
  wp_add_dashboard_widget('dashboard_widget_id_2', 'Пример виджета админки2', 'dashboard_widget_2');
  wp_add_dashboard_widget('api_currencies', 'Список валют, доступный в API (с курсом)', 'api_currencies');
  wp_add_dashboard_widget('api_body_type', 'Список кузовов, доступный в API', 'api_body_type');
  wp_add_dashboard_widget('api_site', 'Список бирж, доступный в API', 'api_site');
  wp_add_dashboard_widget('api_query', 'Список запросов, доступный в API (почти все позже)', 'api_query');
}
// Хук в 'wp_dashboard_setup', чтобы зарегистрировать наши функции среди других
add_action('wp_dashboard_setup', 'add_dashboard_widgets' );
// наши виджеты в админке end --------------------------------------

// вставляем CSS и JS для админки start ------------------
function admin_css_and_js() {
  wp_enqueue_style('bootstrap', get_template_directory_uri() .'/css/bootstrap.min.css');
  wp_enqueue_style('fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css');
  wp_enqueue_style('admin_style', get_template_directory_uri() .'/css/admin_styles.css', array('bootstrap'));

  wp_enqueue_script('bootstrap_js', get_template_directory_uri ().'/js/bootstrap.min.js', array('jquery'), true);
  wp_enqueue_script('admin_js', get_template_directory_uri ().'/js/admin_scripts.js', array('bootstrap_js'), true );
}
add_action( 'admin_enqueue_scripts', 'admin_css_and_js' );
// вставляем CSS и JS для админки end ------------------
?>