<?
JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidator');


?>
<div class="main-reg">
  <div class="wrapper d-flex main--reg">
    <div class="reg-header w100">
      <div class="row align-items-center">
        <div class="col-sm-6"><a href="/"><img src="images/logo.svg" /></a></div>
        <div class="col-sm-6 text-right"><img src="images/from-to.svg" alt="" class="from-to"></div>
      </div>
    </div>
    <div class="reg-ctn w100">
      <div class="map-ctn"><img src="/images/reg-map.png" alt="" width="100%"></div>
      <div class="reg-wrapper">
        <img src="/images/bg2.png" alt="" class="bg-blur">
        <ul id="reg-ctn" role="tablist" class="nav nav-tabs nav-nostyle">
          <li class="flex-fill"><a id="login-tab" data-toggle="tab" href="#login" role="tab" aria-controls="home" aria-selected="true" class="nav-link show active"><span>ВОЙТИ</span></a></li>
          <li class="flex-fill text-right"><a id="registration-tab" data-toggle="tab" href="#registration" role="tab" aria-controls="profile" aria-selected="false" class="nav-link"><span>РЕГИСТРАЦИЯ</span></a></li>

        </ul>
        <div id="reg-ctnContent" class="tab-content">
          <div id="login" role="tabpanel" aria-labelledby="login-tab" class="tab-pane fade show active">
            <form class="log-ctn" method="POST">
              <div class="input-ctn"><input type="text" name="username" placeholder="Логин" required></div>
              <div class="input-ctn"><input type="password" name="password" placeholder="Пароль" required></div>
              <div class="input-ctn">
                <div class="d-flex">

                  <div class="flex-fill"><input type="checkbox" value="yes" name="remember" id="checkboxG1" class="css-checkbox"><label for="checkboxG1" class="css-label check-form">Запомнить меня</label></div>
                  <div class="flex-fill text-right"><a href="#" class="forgotp-tab">Забыли пароль?</a></div>
                </div>
              </div>
              <div class="text-center"><button type="submit" name="log-btn" class="form-btn">ВОЙТИ</button></div>
              <input type="hidden" name="option" value="com_users" />
          		<input type="hidden" name="task" value="user.login" />
              <input type="hidden" name="return" value="index.php?option=com_polyus_users&view=users&layout=profile" />
              <?php echo JHtml::_('form.token'); ?>
            </form>
          </div>

          <div id="registration" role="tabpanel" aria-labelledby="registrations-tab" class="tab-pane fade">
            <form class="log-ctn" method="POST">
              <div class="input-ctn"><input type="text" name="name" placeholder="Имя" required></div>
              <div class="input-ctn"><input type="text" name="lastname" placeholder="Фамилия" required></div>
              <div class="input-ctn"><input type="text" name="email" placeholder="E-mail" required></div>
              <div class="input-ctn"><input type="text" name="phone" placeholder="Телефон" required></div>
              <div class="input-ctn"><select name="be" class="be_type new__select" required>
                  <option style="display: none !important;">Бизнес единица</option>
                  <option>Лензолото</option>
                  <option>МФЦ Полюс</option>
                  <option>Полюс Алдан</option>
                  <option>Полюс Вернинское</option>
                  <option>Полюс Красноярск</option>
                  <option>Полюс Логистика</option>
                  <option>Полюс Магадан</option>
                  <option>Полюс Проект</option>
                  <option>Полюс Строй</option>
                  <option>УК Полюс</option>
                  <option>СЛ Золото</option>
                </select></div>
              <div class="input-ctn d-flex align-items-center">
                <div class="flex-fill"><button type="button" class="reg__pic">ФОТО</button>
                <input type="file" name="pic2" class="profile_pic">
                <input type="hidden" name="pic" class="profile_pic2" value=""></div>
                <div class="flex-fill text-right white"><span>В формате JPEG, PNG</span></div>
              </div>
              <div class="text-center"><button type="submit" name="log-btn" class="form-btn">ЗАРЕГИСТРИРОВАТЬСЯ</button></div>
              <div class="input-ctn white text-center terms-reg"><span>Нажимая на «Зарегистрироваться», вы даете <a href="/images/Consent_to_PD_processing_electronic_form.docx" target="_blank" style="font-size: 10px; text-decoration:underline;">согласие на обработку персональных данных</a></span></div>
							<input type="hidden" name="option" value="com_polyus_users" />
          		<input type="hidden" name="task" value="users.reg" />
							<?php echo JHtml::_('form.token'); ?>
						</form>
          </div>
        </div>
				<div id="forgotp" style="display:none;">
					<form class="log-ctn" method="post" action="<?php echo JRoute::_('index.php?option=com_users&task=reset.request'); ?>">
						<p class="white">Новый пароль будет отправлен Вам по E-mail. Далее, его можно будет поменять в личном кабинете.</p>
						<div class="input-ctn w100"><input type="email" name="jform[email]" placeholder="E-mail" required class="w100"></div>
						<div class="text-center"><button type="submit" name="log-btn" class="form-btn">Отправить</button></div>
						<?php echo JHtml::_('form.token'); ?>

					</form>
				</div>
      </div>
    </div>
  </div>
</div>
