<?php 
/*
Template Name: Personal
*/
global $path;
$path = 'personal';
get_header(); ?>
</nav>
<!-- header end -->
<!-- <div class="container-fluid"> -->
  <!-- <div class="row"> -->
  	<div class="personal">
			<div class="right_tab">
				<span class="">Andreik55@gmail.com</span>
				<!-- <span class="sign_out">Выйти</span> -->
			</div>
			<div id="myTabContent" class="tab-content clearfix">
				<div role="tabpanel" class="tab-pane fade active in" id="first" aria-labelledby="first-tab">
				<?php
					if (isset($_POST['verification']) && empty($_POST['verification'])) {
						echo 'verification goes here';
					} else {
						echo 'not verified';
					}
					if (isset($_COOKIE['logged']) && $_COOKIE['logged']=='true') {
					  ?>
					  <form>
							<div class="clearfix">
								<div class="pers_inputs_box">
									<label for="name">Имя:<span class="required">*</span></label><br>
									<input type="text" class="pers_input" name="name" value="Андрей"/>
								</div>
								<div class="pers_inputs_box" style="margin: 0 118px 11px;">
									<label for="surname">Фамилия:</label><br>
									<input type="text" class="pers_input" name="surname" value="Иванов"/>
								</div>
							</div>
							<div class="clearfix">
								<div class="pers_inputs_box">
									<label for="email">E-mail:<span class="required">*</span></label><br>
									<input type="email" class="pers_input" name="email" value="Andrei55@gmail.com"/>
								</div>
								<div class="pers_inputs_box" style="margin: 0 118px 11px;">
									<label for="email">Контактный телефон:</label><br>
									<input type="text" class="pers_input" name="phone" value=""/>
								</div>
							</div>
							<div class="clearfix">
								<div class="pers_inputs_box">
									<label for="old_pass">Текущий пароль:</label><br>
									<input type="password" class="pers_input" name="old_pass" placeholder="********"/>
								</div>
								<div class="pers_inputs_box" style="margin: 0 118px 11px;">
									<label for="pass">Новый пароль:</label><br>
									<input type="password" class="pers_input" name="pass" placeholder="********"/>										
								</div>
								<div class="pers_inputs_box">
									<label for="pass_conf">Повторите пароль:</label><br>
									<input type="password" class="pers_input" name="pass_conf" placeholder="********"/>
								</div>
							</div>
							
							<div class="submit_block">
								<input type="submit" class="pers_button" name="sign_up" value="СОХРАНИТЬ"/>	
								<span class="cancel">Отмена</span>
							
							</div>
							<div class="del_acc">
								Удалить аккаунт
							</div>			
						</form>
					  <?php
					} else echo '<h1>Вы не зарегистрированы</h1><h3>Для регистрации нажмите "ВХОД/РЕГИСТРАЦИЯ" в верхнем меню</h3>';
				?>
					
				</div> 
			</div>							
		</div>	
	  
	<!-- </div> -->
<!-- </div> -->
<?php get_footer(); ?>
