<?php
global $path;
$path = 'index';
get_header(); 
$api = new ApiClass;
?>
</nav>
<!-- header end -->
<div class="content">
  <div class="content_main">
    <div class="h_1">Trans Radar</div>
    <div class="h_2">Находите, сравнивайте и выбирайте грузы<br>
    с разных сайтов</div>
    <div class="h_3">БЕСПЛАТНО!</div>
    <div class="h_4">
    	<a class="cam_link various fancybox.iframe" href="https://www.youtube.com/embed/<?php echo $site_options['youtube']?>?autoplay=1">Как это работает</a>&nbsp;<a href="https://www.youtube.com/embed/<?php echo $site_options['youtube']?>?autoplay=1"><span class="cam"></span></a>
    </div>
  </div>		  
  <div class="content_search">
  	<div class="search_form">
	  	<div class="search_tab">
	  		Начните поиск прямо сейчас
	  	</div>
	  	<div class="search_box clearfix">
	  		<form class="main_form" action="search" method="POST">
		  		<div class="form_block from_box">
		  			<span class="form_label">Откуда</span><br>
		  			<input type="hidden" class="form_select_id" name="from_id">
		  			<input type="hidden" name="from_hidden">
		  			<input type="hidden" name="is_country">
		  			<input type="text" name="from" class="form_select" id="from" placeholder="Любая страна или город" autocomplete="off"><span class="from_clear clear_from"></span>
		  			<div class="from_results">
		  				<div class="places">нет результатов</div>
		  			</div>
		  		</div>
		  		<div class="form_block to_box">
		  			<span class="form_label">Куда</span><br>
		  			<input type="hidden" class="form_select_id" name="to_id">
		  			<input type="hidden" name="to_hidden">
		  			<input type="text" name="to" class="form_select" id="to" placeholder="Любая страна или город" autocomplete="off"><span class="from_clear clear_to"></span>
		  			<div class="to_results">
		  				<div class="places">нет результатов</div>
		  			</div>
		  		</div>
		  		<div class="form_block_submit">
		  			<!-- <div class="block_checker" title="Для поиска обратных грузов должен быть задан город «Откуда»"></div> -->
		  			<input id="search_back" type="checkbox" name="search_back" hidden />
  					<label for="search_back"><span class="search_back_label">искать обратный груз</span></label><br>
		  			<button class="btn btn-primary form_submit">НАЙТИ</button>
		  		</div>
	  		</form>
	  	</div>
	  	<div class="form_text">
	  		Находите лучшие грузы среди сотен тысяч объявлений наших партнеров
	  	</div>
  	</div>
  </div>
</div>

<div id="myCarousel" class="partners carousel slide" data-ride="carousel">
	<div class="block carousel-inner" role="listbox">
	  <? $api->build_exchange_sites_banners();?>
	</div>
</div>


<div class="filled">
  <div class="slogan">
    Мы анализируем все топовые биржи в интернете по грузо-перевозкам,<br>
    и предоставляем на нашем ресурсе
  </div>
</div>
<?php get_footer(); ?>