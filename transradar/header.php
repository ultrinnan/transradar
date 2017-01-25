<?php
	include_once('admin/api_classes.php');
	$api = new ApiClass;
	global $path;
	global $popups_text;
	global $site_options;
	$site_options = get_option('site_options');
	$popups_text = get_option('popups_text');
	if (!isset($_COOKIE['currency'])) {
		setcookie("currency", 'USD', time()+60*60*24*30, '/');
		setcookie("currency_id", '1', time()+60*60*24*30, '/');
	}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="utf-8" />
		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<title><?php wp_title('«', true, 'right'); ?> <?php bloginfo('name'); ?></title>
		<!-- <meta name="viewport" content="width=device-width"> -->
		<link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri());?>/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri());?>/js/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
	<?php
		if ($path == 'search') {
	?>
		<link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri());?>/js/jquery-ui-1.11.4.custom/jquery-ui.css">
		<link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri());?>/js/scrolbar/jquery.mCustomScrollbar.css">
	<?php
		}
	?>
		<link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri());?>/css/style.css">
		<?php wp_head(); ?>
 	</head>
	<body>
		    <!-- Fixed navbar -->
    <nav class="navbar-fixed-top">
      <div class="top">
<?php
	if ($path == 'transition') {} else {
?>    
        <div id="navbar" class="">
          	<div class="header clearfix">
				<div class="header_logo"><a href="/"><img src="<?php echo esc_url(get_template_directory_uri());?>/images/temp_logo.png" alt="Trans radar logo"></a>
				</div>
				<div class="header_text">
				  	<? $api->build_header_info();?>
			  	</div>
				<div class="header_buttons">
					<?php if ($path == 'search') {
						$api->build_currencies_menu();						
					} ?>
					<div class="header_button menu">
						МЕНЮ
						<div class="popup menu_box">
							<?php
					            wp_nav_menu( array(
					              // 'theme_location'  => '',
					              'menu'            => 'top_main', 
					              'container'       => 'false', 
					              'container_class' => '',
					              // 'container_id'    => '',
					              'menu_class'      => 'top_main', 
					              // 'menu_id'         => '',
					              'echo'            => true,
					              'fallback_cb'     => '__return_empty_string', //чтобы ничего не выводилось, если меню нет
					              // 'before'          => '',
					              // 'after'           => '',
					              // 'link_before'     => '',
					              // 'link_after'      => '',
					              'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
					              'depth'           => 2,
					              // 'walker'          => '',
					            ) );
							?>
						</div>
					</div>   
					  </div>
					</div>
        </div><!--/.nav-collapse -->
<?php
	}
?>        
      </div>