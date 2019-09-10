<?
use Strava\API\OAuth;
$options = [
  'clientId'     => 33747,
  'clientSecret' => '0d3c315484add0dea31e72c8e10b189c5b2f3434',
  'redirectUri'  => 'http://sport.polyus.com/index.php?option=com_polyus_users&view=user&task=user.auth'
];
$oauth = new OAuth($options);

$strava = $oauth->getAuthorizationUrl(['scope' => [ 'read', 'activity:read_all' ]]);

$user = JFactory::getUser();
$model = $this->getModel();
$activity = $model->getActivity($user->email);
$addInfo = $model->getAddInfo($user->email);
$total_activity = $model->getAllActivity();
JHtml::_('behavior.keepalive');
$subdivision;
if($addInfo->subdivision == 'Лензолото'){
	$subdivision = 1;
}
if($addInfo->subdivision == 'МФЦ Полюс'){
	$subdivision = 2;
}
if($addInfo->subdivision == 'Полюс Вернинское'){
	$subdivision = 3;
}
if($addInfo->subdivision == 'Полюс Красноярск'){
	$subdivision = 4;
}
if($addInfo->subdivision == 'Полюс Логистика'){
	$subdivision = 5;
}
if($addInfo->subdivision == 'Полюс Магадан'){
	$subdivision = 6;
}
if($addInfo->subdivision == 'Полюс Проект'){
	$subdivision = 7;
}
if($addInfo->subdivision == 'Полюс Строй'){
	$subdivision = 8;
}
if($addInfo->subdivision == 'УК Полюс'){
	$subdivision = 9;
}
if($addInfo->subdivision == 'Полюс Алдан'){
	$subdivision = 10;
}
if($addInfo->subdivision == 'СЛ Золото'){
	$subdivision = 11;
}
?>
<div class="wrapper">
	<div class="profile__ctn"  v-cloak>
		<div class="row r-row nowrap">
			<div class="profile__ctn-left">
				<div class="profile__ctn-inner">
					<div class="prof__pic relative"><img src="<?=($addInfo->pic != '')?$addInfo->pic:'/images/users/user__1376629406.png';?>" alt="2">
						<a href="#editProfile" class="edit-pic fancybox"><img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiID8+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgd2lkdGg9IjI1IiBoZWlnaHQ9IjI1Ij4KCTxkZWZzPgoJCTxjbGlwUGF0aCBpZD0iY2xpcF8wIj4KCQkJPHJlY3QgeD0iLTIzOCIgeT0iLTM3NyIgd2lkdGg9IjE0NDAiIGhlaWdodD0iMTg0NCIgY2xpcC1ydWxlPSJldmVub2RkIi8+CgkJPC9jbGlwUGF0aD4KCTwvZGVmcz4KCTxnIGNsaXAtcGF0aD0idXJsKCNjbGlwXzApIj4KCQk8cGF0aCBmaWxsPSJyZ2IoMCwwLDApIiBzdHJva2U9Im5vbmUiIGQ9Ik04LjkxODcyIDIyLjYwMThMMC43NzMwNzcgMjQuOTgzNUMwLjc0NjcyNSAyNC45ODM1IDAuNzI1MDQgMjQuOTg4MSAwLjcwNDcxNiAyNC45OTI1QzAuNjY3NjY4IDI1LjAwMDUgMC42MzUxNDEgMjUuMDA3NSAwLjU4NzEwNCAyNC45ODM1QzAuNDM4MzI1IDI0Ljk4MzUgMC4yODk1NDYgMjQuOTQ2MiAwLjE3Nzk2MiAyNC44MzQ2QzAuMDI5MTgzMyAyNC42ODU4IC0wLjA0NTIwNjEgMjQuNDYyNSAwLjAyOTE4MzMgMjQuMjc2NEwyLjQwOTY0IDE2LjEyNjZMMi40MDk2NCAxNi4wODk0QzIuNDQ2ODQgMTYuMDg5NCAyLjQ0Njg0IDE2LjA1MjIgMi40NDY4NCAxNi4wNTIyQzIuNDg0MDMgMTYuMDE1IDIuNTIxMjMgMTUuOTQwNiAyLjU1ODQyIDE1LjkwMzRMMTcuMjg3NSAxLjEyOTU4QzE4LjkyNDEgLTAuNDcwNTk4IDIxLjg2MjUgLTAuMzU4OTU3IDIzLjYxMDYgMS4zOTAwOEMyNS4zNTg4IDMuMTM5MTIgMjUuNDcwNCA2LjExNjIgMjMuODcxIDcuNzE2MzhMOS4xNDE4OSAyMi40NTI5QzkuMTA0NjkgMjIuNDkwMiA5LjA2NzUgMjIuNTI3NCA4Ljk5MzExIDIyLjU2NDZDOC45OTMxMSAyMi42MDE4IDguOTU1OTEgMjIuNjAxOCA4Ljk1NTkxIDIyLjYwMThMOC45MTg3MiAyMi42MDE4Wk0yMi44Mjk1IDIuMjA4NzhDMjEuNjc2NSAxLjAxNzk0IDE5LjM3MDQgMC42ODMwMjIgMTguMTA1OCAxLjk0ODI4TDE2LjYxOCAzLjQzNjgyTDIxLjYwMjEgOC40MjM0NEwyMy4wODk5IDYuOTM0OUMyNC4zNTQ1IDUuNjY5NjQgMjQuMDE5OCAzLjM5OTYxIDIyLjgyOTUgMi4yMDg3OFpNMTUuODM2OSA0LjIxODMxTDIwLjgyMSA5LjIwNDkyTDguNzY5OTQgMjEuMjk5M0wzLjc0ODY1IDE2LjI3NTVMMTUuODM2OSA0LjIxODMxWk03LjY5MTI5IDIxLjgyMDNMMy4yMjc5MyAxNy4zNTQ3TDEuNDA1MzkgMjMuNjQzOEw3LjY5MTI5IDIxLjgyMDNaIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiLz4KCTwvZz4KCTxkZWZzPgoJCTxjbGlwUGF0aCBpZD0iY2xpcF8xIj4KCQkJPHJlY3QgeD0iLTIzOCIgeT0iLTM3NyIgd2lkdGg9IjE0NDAiIGhlaWdodD0iMTg0NCIgY2xpcC1ydWxlPSJldmVub2RkIi8+CgkJPC9jbGlwUGF0aD4KCTwvZGVmcz4KCTxnIGNsaXAtcGF0aD0idXJsKCNjbGlwXzEpIj4KCQk8cGF0aCBmaWxsPSJub25lIiBzdHJva2U9InJnYigwLDAsMCkiIHN0cm9rZS13aWR0aD0iMSIgc3Ryb2tlLW1pdGVybGltaXQ9IjQiIGQ9Ik04LjkxODcyIDIyLjYwMThMMC43NzMwNzcgMjQuOTgzNUMwLjc0NjcyNSAyNC45ODM1IDAuNzI1MDQgMjQuOTg4MSAwLjcwNDcxNiAyNC45OTI1QzAuNjY3NjY4IDI1LjAwMDUgMC42MzUxNDEgMjUuMDA3NSAwLjU4NzEwNCAyNC45ODM1QzAuNDM4MzI1IDI0Ljk4MzUgMC4yODk1NDYgMjQuOTQ2MiAwLjE3Nzk2MiAyNC44MzQ2QzAuMDI5MTgzMyAyNC42ODU4IC0wLjA0NTIwNjEgMjQuNDYyNSAwLjAyOTE4MzMgMjQuMjc2NEwyLjQwOTY0IDE2LjEyNjZMMi40MDk2NCAxNi4wODk0QzIuNDQ2ODQgMTYuMDg5NCAyLjQ0Njg0IDE2LjA1MjIgMi40NDY4NCAxNi4wNTIyQzIuNDg0MDMgMTYuMDE1IDIuNTIxMjMgMTUuOTQwNiAyLjU1ODQyIDE1LjkwMzRMMTcuMjg3NSAxLjEyOTU4QzE4LjkyNDEgLTAuNDcwNTk4IDIxLjg2MjUgLTAuMzU4OTU3IDIzLjYxMDYgMS4zOTAwOEMyNS4zNTg4IDMuMTM5MTIgMjUuNDcwNCA2LjExNjIgMjMuODcxIDcuNzE2MzhMOS4xNDE4OSAyMi40NTI5QzkuMTA0NjkgMjIuNDkwMiA5LjA2NzUgMjIuNTI3NCA4Ljk5MzExIDIyLjU2NDZDOC45OTMxMSAyMi42MDE4IDguOTU1OTEgMjIuNjAxOCA4Ljk1NTkxIDIyLjYwMThMOC45MTg3MiAyMi42MDE4Wk0yMi44Mjk1IDIuMjA4NzhDMjEuNjc2NSAxLjAxNzk0IDE5LjM3MDQgMC42ODMwMjIgMTguMTA1OCAxLjk0ODI4TDE2LjYxOCAzLjQzNjgyTDIxLjYwMjEgOC40MjM0NEwyMy4wODk5IDYuOTM0OUMyNC4zNTQ1IDUuNjY5NjQgMjQuMDE5OCAzLjM5OTYxIDIyLjgyOTUgMi4yMDg3OFpNMTUuODM2OSA0LjIxODMxTDIwLjgyMSA5LjIwNDkyTDguNzY5OTQgMjEuMjk5M0wzLjc0ODY1IDE2LjI3NTVMMTUuODM2OSA0LjIxODMxWk03LjY5MTI5IDIxLjgyMDNMMy4yMjc5MyAxNy4zNTQ3TDEuNDA1MzkgMjMuNjQzOEw3LjY5MTI5IDIxLjgyMDNaIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiLz4KCTwvZz4KCjwvc3ZnPg=="
							alt=""></a>
						</div>
						<form class="profile--text" method="POST" action="<?php echo JRoute::_('index.php?option=com_users&task=user.logout'); ?>">
							<div class="text-center"><strong>Привет, <?=$user->name;?>!</strong></div>
							<div class="personal-record text-center">
								<div class="personal-record--inner">
									<span class="d-block">ТВОЙ ВКЛАД *</span>
									<p class="nomargin">{{getTotal}}</p>
									<span class="d-block">км</span>
								</div>
								<br>
								<div class="btn-logout--ctn">
                  <button type="submit" class="btn-new btn-logout">Выйти</button>
                </div>
								<input type="hidden" name="return" value="/profile" />
								<?php echo JHtml::_('form.token'); ?>
							</div>
						</form>
					</div>
				</div>
				<div class="flex-fill">
					<div class="row align-items-md-baseline align-items-xl-stretch">
						<div class="col-sm-12 col-xl-4 col-lg-5 col-md-12 margin-ctn cal__Ctn">
							<div class="border-shadow">
								<div class="calendar"></div>
								<div class="d-flex align-items-center add__more--act">
									<div class="flex-fill">
										<a href="#addActivity__ctn" class="btn-new fancybox a_btn">добавить активность</a>
									</div>
									<div class="flex-fill">
										<p class="current__activity nomargin text-right"><span>{{c_distance}}</span> <small>км</small></p>
									</div>
								</div>
								<input type="hidden" name="calendar" class="calendar__pick">
							</div>
						</div>
						<!-- chart here -->
						<div class="col-sm-12 col-xl-8 col-lg-7 col-md-12 margin-ctn">
							<div class="border-shadow">
								<h2 class="h2">Твоя активность</h2>
								<div class="row align-items-center">
									<div class="col-sm-12 col-xl-7 col-lg-12 col-md-12">
										<div id="chartdiv"></div>
									</div>
									<div class="col-sm-12 col-xl-5 col-md-12 col-lg-12 sports__legend">
										<div class="row">
											<div class="col-sm-6 col-6">
												<span class="sportType running">Бег</span>
												<p class="running_val">{{run}}<small> км</small></p>
											</div>
											<div class="col-sm-6 col-6">
												<span class="sportType swimming">Плавание</span>
												<p class="swimming_val">{{swim}}<small> км</small></p>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-6 col-6">
												<span class="sportType bike">Велосипед</span>
												<p class="bike_val">{{bike}}<small> км</small></p>
											</div>
											<div class="col-sm-6 col-6">
												<span class="sportType Skiing">Лыжи</span>
												<p class="Skiing_val">{{ski}}<small> км</small></p>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-12">
												<span class="sportType jogging">Спортивная ходьба</span>
												<p class="jogging_val">{{walk}}<small> км</small></p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="" id="editProfile" style="display:none">
		<form id="editForm" method="POST">
			<div class="row">
				<div class="col-sm-4">
					<div>
						<div>
							<div>
								<div class="editProfile__picture">
									<div class="profile__pic" @click="changePic"><img src="<?=($addInfo->pic != '')?$addInfo->pic:'/images/users/user__1376629406.png';?>" alt="2"></div>
								</div>
								<br>
								<div class="text-center"><button type="button" class="btn-new btn__inv" @click="changePic">заменить</button></div>
							</div>
						</div>
						<input type="file" @change="onFileChange( $event.target.name, $event.target.files)" ref="file" name="file" class="picFile" style="display: none;">
						<input type="hidden" name="pic" value="" v-model="realPic">
					</div>
				</div>
				<div class="col-sm-8">
					<p class="editProfile__username"><?=$addInfo->name.' '.$addInfo->lastname;?></p>
					<div class="editProfile__sep"></div>
					<div class="input-ctn row">
						<label for="" class="col-sm-3 col-4 col-form-label">e-mail</label>
						<div class="col-sm-7 col-8"><input type="email" name="email2" value="<?=$addInfo->email;?>"></div>
					</div>
					<div class="input-ctn row">
						<label for="" class="col-sm-3 col-4 col-form-label">телефон</label>
						<div class="col-sm-7 col-8"><input type="tel" name="phone" value="<?=$addInfo->phone;?>"></div>
					</div>
					<div class="input-ctn row">
						<label for="" class="col-sm-3 col-4 col-form-label">БЕ</label>
						<div class="col-sm-7 col-8">
							<select name="subdivision" class="be_type new__select" v-model="userBE">
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
							</select>
						</div>
					</div>
					<div class="input-ctn row ">
						<label for="" class="col-sm-3 col-4 col-form-label">Пароль</label>
						<div class="col-sm-7 col-8">
							<div class="row row-less">
								<div class="col-sm-6"><input type="password" name="old_pass" value="" placeholder="Текущий пароль"></div>
								<div class="col-sm-6"><input type="password" minlength="6" name="new_pass" value="" placeholder="Новый" class=""></div>
							</div>
						</div>
					</div>
					<div class="input-ctn row pass__ctn">
						<label for="" class="col-sm-3 col-4 col-form-label"></label>
						<div class="col-sm-7 col-8">
							<div class="row">
								<div class="col-sm-12"><input type="password" minlength="6" name="repeat_pass" value="" placeholder="Подтвердить" class=""></div>
							</div>
						</div>
					</div>
				</div>
			</div>
      <input type="hidden" name="currentmail" value="<?=$addInfo->email;?>" />
			<input type="hidden" name="option" value="com_polyus_users" />
			<input type="hidden" name="task" value="user.updateUser" />
			<div class="text-center"><button type="submit" class="btn-new">Сохранить</button></div>
		</form>
	</div>
	<div id="addActivity__ctn" style="display:none;">
		<div class="wrapper">
			<form method="POST" class="form-inline ">
				<label for="" class="col-form-label">Вид активности</label>
				<div class="input-ctn row w100 align-items-center">
					<div class="col-sm-6">
						<div class="d-flex act__inputs align-items-center">
							<div class="flex-fill ">
								<select class="new__select" name="type" v-model="typeSelect" @change="onChange()">
									<option value="Бег" selected>Бег</option>
									<option value="Плавание">Плавание</option>
									<option value="Велосипед">Велосипед</option>
									<option value="Ходьба">Ходьба</option>
									<option value="Лыжи">Лыжи</option>
								</select>
							</div>
							<div class="flex-fill align-items-center">
								<input type="text" name="activity" required min="0" v-model="km"><span>км</span>
							</div>
						</div>
					</div>
					<div class="col-sm-6 d-flex">
						<button class="btn-new add__activity">Добавить</button><button class="btn-new delete__activity btn__inv" name="delete_a" value="1">Удалить</button>
					</div>
				</div>
				<input type="hidden" name="date" class="calendar__pick">
				<input type="hidden" name="email2" value="<?=$addInfo->email;?>">
				<input type="hidden" name="subdivision" value="<?=$subdivision;?>">
				<input type="hidden" name="option" value="com_polyus_sport" />
				<input type="hidden" name="task" value="sportactivities.addActivity" />
			</form>
      <br>
      <form method="POST" class="row">
        <div class="col-sm-6">
          <div class="d-flex align-items-center">
            <div class="flex-fill">
              <img src="/images/Strava_logo.svg" alt="">
            </div>
            <div class="flex-fill">
              <button class="btn-new">Подгрузить</button>
            </div>
          </div>
        </div>
        <input type="hidden" name="date" class="calendar__pick">
        <input type="hidden" name="email2" value="<?=$addInfo->email;?>">
        <input type="hidden" name="subdivision" value="<?=$subdivision;?>">
        <input type="hidden" name="option" value="com_polyus_users" />
				<input type="hidden" name="task" value="user.auth" />
      </form>
		</div>
		<div class="wrapper black__bg">
			<p class="title__total">твоя активность: <strong>{{tTotal}}</strong> <span>км</span></p>
			<div class="pop__activity d-flex sports__legend w-100">
				<div class="flex-fill">
					<span class="sportType running">Бег</span>
					<p class="running_val">{{run}}<small> км</small></p>
				</div>
				<div class="flex-fill">
					<span class="sportType swimming">Плавание</span>
					<p class="swimming_val">{{swim}}<small> км</small></p>
				</div>
				<div class="flex-fill">
					<span class="sportType bike">Велосипед</span>
					<p class="bike_val">{{bike}}<small> км</small></p>
				</div>
				<div class="flex-fill">
					<span class="sportType Skiing">Лыжи</span>
					<p class="Skiing_val">{{ski}}<small> км</small></p>
				</div>
				<div class="flex-fill">
					<span class="sportType jogging">Спортивная ходьба</span>
					<p class="jogging_val">{{walk}}<small> км</small></p>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
	let events = <?=json_encode($activity);?>;
	let _userBE = "<?=$addInfo->subdivision;?>"
</script>
