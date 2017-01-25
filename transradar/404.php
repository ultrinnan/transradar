<?php 
/*
Template Name: 404
*/
get_header(); ?>
</nav>
<!-- header end -->
<div class="faq">
  <div class="faq_box not_found">
  	<div class="pic">
  		Ошибка
  	</div>

  	<div>
  		<div class="header">К сожалению, запрашиваемая вами страница не найдена.</div>
  		<div class="text">Возможно, она была уделена или вы ввели неправильный адрес.<br>Перейдите на главную страницу или воспользуйтей поиском.</div>
  		<div class="text"><a href="/">Перейти на главную страницу</a></div>
  	</div>
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

	</div>
</div>
<?php get_footer(); ?>
