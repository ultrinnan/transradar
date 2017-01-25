<?php
$site_options = get_option('site_options');
?>
		<div class="footer">
		  <div class="block">
				<div class="footer_copy">
		    	TransRadar &copy; 2005 - 2016
				</div>
				<div class="footer_social">
			    	Мы в соц. сетях:
				    <div class="soc_box">
					    <a target="_blank" href="<?php echo $site_options['vkontakte'];?>"><span class="social vk"></span></a>
					    <a target="_blank" href="<?php echo $site_options['odnoklasniki'];?>"><span class="social fb"></span></a>
					    <a target="_blank" href="<?php echo $site_options['facebook'];?>"><span class="social odnoklassniki"></span></a>
					    <a target="_blank" href="<?php echo $site_options['twitter'];?>"><span class="social twitter"></span></a>
				    </div>
				</div>
		  </div>
		</div>
		<?php wp_footer(); ?>
		<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
		<script src="<?php echo esc_url(get_template_directory_uri());?>/js/js.cookie.js"></script>
		<script src="<?php echo esc_url(get_template_directory_uri());?>/js/jquery-ui-1.11.4.custom/jquery-ui.js"></script>
		<script src="<?php echo esc_url(get_template_directory_uri());?>/js/jquery.autocomplete.min.js"></script>
		<script src="<?php echo esc_url(get_template_directory_uri());?>/js/bootstrap.min.js"></script>
		<script src="<?php echo esc_url(get_template_directory_uri());?>/js/scrolbar/jquery.mCustomScrollbar.concat.min.js"></script>
		<script src="<?php echo esc_url(get_template_directory_uri());?>/js/scripts.js"></script>
		<script src="<?php echo esc_url(get_template_directory_uri());?>/js/jquery.validate.js"></script>
		<script src="<?php echo esc_url(get_template_directory_uri());?>/js/messages_ru.js"></script>
		<script src="<?php echo esc_url(get_template_directory_uri());?>/js/fancybox/jquery.fancybox.pack.js?v=2.1.5"></script>
<?php
// $path = $_SERVER['PHP_SELF'];
global $path;
switch ($path) {
	case 'transition':
		echo '<script src="/wp-content/themes/transradar/js/trans_scripts.js"></script>';
		break;
	case 'personal':
		echo '<script src="/wp-content/themes/transradar/js/personal_scripts.js"></script>';
		break;
	case 'page':
		echo '<script src="/wp-content/themes/transradar/js/page_scripts.js"></script>';
		break;
	case 'faq':
		echo '<script src="/wp-content/themes/transradar/js/faq_scripts.js"></script>';
		break;
	case 'index':
		echo '<script src="/wp-content/themes/transradar/js/index_scripts.js"></script>';
		break;
	case 'search':
		echo '<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyALlvMIJjEjvUlmf7wEVPtsjCMmwIwtGYc"></script>';
		echo '<script src="/wp-content/themes/transradar/js/CustomGoogleMapMarker.js"></script>';
		echo '<script src="/wp-content/themes/transradar/js/markerclusterer.js"></script>';
		echo '<script src="/wp-content/themes/transradar/js/search_scripts.js"></script>';
		break;
	default:
		# code...
		break;
}
?>
</body>
</html>