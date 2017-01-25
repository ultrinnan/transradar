<?php 
/*
Template Name: FAQ
*/
global $path;
$path = 'faq';
get_header();
?>
</nav>
<!-- header end -->		
		<div class="faq">
		  <div class="faq_box clearfix">
			<?php
				$faq = get_option('FAQ'); // это массив
				// var_dump('<pre>');
				// var_dump($faq);
				// var_dump('</pre>');
			?>
		  <div class="title"><span class="ask"></span>Вопросы и ответы</div>
		  	<div class="left_tabs">
			    <!-- Nav tabs -->
			    <ul class="nav tabs-left">
			    <?php
			    	for ($i=0; $i < count($faq); $i++) {
			    		if ($i == 0) {
			    			$class = 'active';
			    		} else $class = '';
			    	?>
			    		<li class="<?=$class;?>">
			    			<a href="#name_<?=$i;?>" data-toggle="tab">
			    				<span class="tab_image"></span><?=$faq[$i]['main_item_name']?>
			    			</a>
			    		</li>
			      	<?php
			    	}
			    ?>
			    </ul>
				</div>
				<div class="left_tabs_cont">
			    <!-- Tab panes -->
				    <div class="tab-content">
						<?php
					    	for ($i=0; $i < count($faq); $i++) {
					    		if ($i == 0) {
					    			$class = 'active';
					    		} else $class = '';
					    	?>
					    		<div class="tab-pane <?=$class;?>" id="name_<?=$i;?>">
					    			<?php
					    				foreach ($faq[$i]['questions'] as $item) {
					    					?>
						  					<div class="faq_item closed">
						  						<div class="faq_item_header clearfix accordion-item">
						  							<span class="ask"></span>
						  							<?=$item['question']?>
						  						</div>
													<span class="faq_accordeon_type">
														<div class="answer">
															<strong>Ответ:</strong><br>
															<?=$item['answer']?>
														</div>
													</span>
						  					</div>

						  				<!-- 	<div class="pagination_box">
													<ul class="pagination">
												    <li class="disabled">
												      <a href="#" aria-label="Previous">
												        <span aria-hidden="true">предыдущая</span>
												      </a>
												    </li>
												    <li><a href="#">1</a></li>
												    <li class="active"><a href="#">2</a></li>
												    <li><a href="#">3</a></li>
												    <li><a href="#">4</a></li>
												    <li><a href="#">5</a></li>
												    <li>
												      <a href="#" aria-label="Next">
												        <span aria-hidden="true">следующая</span>
												      </a>
												    </li>
												  </ul>
						  					</div> -->
					    					<?php
					    				}
					    			?>
								      	</div>
					      	<?php
					    	}
					    ?>
				    </div>
				</div> 
		  </div>		  
		</div>
<?php get_footer(); ?>