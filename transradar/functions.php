<?php
add_theme_support('menus' );
add_theme_support('post-thumbnails');
add_theme_support('title-tag');
 
//хуки безопасности
require 'admin/security_hooks.php';

//кастомизация под клиента
require 'admin/view_customizations.php';

//страница настроек сайта
require 'admin/site_fields.php';

//страница настроек раздела FAQ
require 'admin/faq.php';

//страница настроек pop-up подсказок
require 'admin/popup.php';

//страница настроек pop-up подсказок
require 'admin/sites.php';

?>