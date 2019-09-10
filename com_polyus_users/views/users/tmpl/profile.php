<?
$user = JFactory::getUser();
$model = $this->getModel();

$activity = $model->getActivity($user->email);
$addInfo = $model->getAddInfo($user->email);
$total_activity = $model->getAllActivity();


?>
<div class="wrapper">
  <div class="profile__ctn">
    <div class="row r-row nowrap">
      <div class="profile__ctn-left">
        <div class="profile__ctn-inner">
          <div class="prof__pic relative"><img src="<?=($addInfo->pic != '')?$addInfo->pic:'http://sport.polyus.com/dev/images/users/user__1376629406.png';?>" alt="2">
            <a href="#editProfile" class="edit-pic fancybox"><img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiID8+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgd2lkdGg9IjI1IiBoZWlnaHQ9IjI1Ij4KCTxkZWZzPgoJCTxjbGlwUGF0aCBpZD0iY2xpcF8wIj4KCQkJPHJlY3QgeD0iLTIzOCIgeT0iLTM3NyIgd2lkdGg9IjE0NDAiIGhlaWdodD0iMTg0NCIgY2xpcC1ydWxlPSJldmVub2RkIi8+CgkJPC9jbGlwUGF0aD4KCTwvZGVmcz4KCTxnIGNsaXAtcGF0aD0idXJsKCNjbGlwXzApIj4KCQk8cGF0aCBmaWxsPSJyZ2IoMCwwLDApIiBzdHJva2U9Im5vbmUiIGQ9Ik04LjkxODcyIDIyLjYwMThMMC43NzMwNzcgMjQuOTgzNUMwLjc0NjcyNSAyNC45ODM1IDAuNzI1MDQgMjQuOTg4MSAwLjcwNDcxNiAyNC45OTI1QzAuNjY3NjY4IDI1LjAwMDUgMC42MzUxNDEgMjUuMDA3NSAwLjU4NzEwNCAyNC45ODM1QzAuNDM4MzI1IDI0Ljk4MzUgMC4yODk1NDYgMjQuOTQ2MiAwLjE3Nzk2MiAyNC44MzQ2QzAuMDI5MTgzMyAyNC42ODU4IC0wLjA0NTIwNjEgMjQuNDYyNSAwLjAyOTE4MzMgMjQuMjc2NEwyLjQwOTY0IDE2LjEyNjZMMi40MDk2NCAxNi4wODk0QzIuNDQ2ODQgMTYuMDg5NCAyLjQ0Njg0IDE2LjA1MjIgMi40NDY4NCAxNi4wNTIyQzIuNDg0MDMgMTYuMDE1IDIuNTIxMjMgMTUuOTQwNiAyLjU1ODQyIDE1LjkwMzRMMTcuMjg3NSAxLjEyOTU4QzE4LjkyNDEgLTAuNDcwNTk4IDIxLjg2MjUgLTAuMzU4OTU3IDIzLjYxMDYgMS4zOTAwOEMyNS4zNTg4IDMuMTM5MTIgMjUuNDcwNCA2LjExNjIgMjMuODcxIDcuNzE2MzhMOS4xNDE4OSAyMi40NTI5QzkuMTA0NjkgMjIuNDkwMiA5LjA2NzUgMjIuNTI3NCA4Ljk5MzExIDIyLjU2NDZDOC45OTMxMSAyMi42MDE4IDguOTU1OTEgMjIuNjAxOCA4Ljk1NTkxIDIyLjYwMThMOC45MTg3MiAyMi42MDE4Wk0yMi44Mjk1IDIuMjA4NzhDMjEuNjc2NSAxLjAxNzk0IDE5LjM3MDQgMC42ODMwMjIgMTguMTA1OCAxLjk0ODI4TDE2LjYxOCAzLjQzNjgyTDIxLjYwMjEgOC40MjM0NEwyMy4wODk5IDYuOTM0OUMyNC4zNTQ1IDUuNjY5NjQgMjQuMDE5OCAzLjM5OTYxIDIyLjgyOTUgMi4yMDg3OFpNMTUuODM2OSA0LjIxODMxTDIwLjgyMSA5LjIwNDkyTDguNzY5OTQgMjEuMjk5M0wzLjc0ODY1IDE2LjI3NTVMMTUuODM2OSA0LjIxODMxWk03LjY5MTI5IDIxLjgyMDNMMy4yMjc5MyAxNy4zNTQ3TDEuNDA1MzkgMjMuNjQzOEw3LjY5MTI5IDIxLjgyMDNaIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiLz4KCTwvZz4KCTxkZWZzPgoJCTxjbGlwUGF0aCBpZD0iY2xpcF8xIj4KCQkJPHJlY3QgeD0iLTIzOCIgeT0iLTM3NyIgd2lkdGg9IjE0NDAiIGhlaWdodD0iMTg0NCIgY2xpcC1ydWxlPSJldmVub2RkIi8+CgkJPC9jbGlwUGF0aD4KCTwvZGVmcz4KCTxnIGNsaXAtcGF0aD0idXJsKCNjbGlwXzEpIj4KCQk8cGF0aCBmaWxsPSJub25lIiBzdHJva2U9InJnYigwLDAsMCkiIHN0cm9rZS13aWR0aD0iMSIgc3Ryb2tlLW1pdGVybGltaXQ9IjQiIGQ9Ik04LjkxODcyIDIyLjYwMThMMC43NzMwNzcgMjQuOTgzNUMwLjc0NjcyNSAyNC45ODM1IDAuNzI1MDQgMjQuOTg4MSAwLjcwNDcxNiAyNC45OTI1QzAuNjY3NjY4IDI1LjAwMDUgMC42MzUxNDEgMjUuMDA3NSAwLjU4NzEwNCAyNC45ODM1QzAuNDM4MzI1IDI0Ljk4MzUgMC4yODk1NDYgMjQuOTQ2MiAwLjE3Nzk2MiAyNC44MzQ2QzAuMDI5MTgzMyAyNC42ODU4IC0wLjA0NTIwNjEgMjQuNDYyNSAwLjAyOTE4MzMgMjQuMjc2NEwyLjQwOTY0IDE2LjEyNjZMMi40MDk2NCAxNi4wODk0QzIuNDQ2ODQgMTYuMDg5NCAyLjQ0Njg0IDE2LjA1MjIgMi40NDY4NCAxNi4wNTIyQzIuNDg0MDMgMTYuMDE1IDIuNTIxMjMgMTUuOTQwNiAyLjU1ODQyIDE1LjkwMzRMMTcuMjg3NSAxLjEyOTU4QzE4LjkyNDEgLTAuNDcwNTk4IDIxLjg2MjUgLTAuMzU4OTU3IDIzLjYxMDYgMS4zOTAwOEMyNS4zNTg4IDMuMTM5MTIgMjUuNDcwNCA2LjExNjIgMjMuODcxIDcuNzE2MzhMOS4xNDE4OSAyMi40NTI5QzkuMTA0NjkgMjIuNDkwMiA5LjA2NzUgMjIuNTI3NCA4Ljk5MzExIDIyLjU2NDZDOC45OTMxMSAyMi42MDE4IDguOTU1OTEgMjIuNjAxOCA4Ljk1NTkxIDIyLjYwMThMOC45MTg3MiAyMi42MDE4Wk0yMi44Mjk1IDIuMjA4NzhDMjEuNjc2NSAxLjAxNzk0IDE5LjM3MDQgMC42ODMwMjIgMTguMTA1OCAxLjk0ODI4TDE2LjYxOCAzLjQzNjgyTDIxLjYwMjEgOC40MjM0NEwyMy4wODk5IDYuOTM0OUMyNC4zNTQ1IDUuNjY5NjQgMjQuMDE5OCAzLjM5OTYxIDIyLjgyOTUgMi4yMDg3OFpNMTUuODM2OSA0LjIxODMxTDIwLjgyMSA5LjIwNDkyTDguNzY5OTQgMjEuMjk5M0wzLjc0ODY1IDE2LjI3NTVMMTUuODM2OSA0LjIxODMxWk03LjY5MTI5IDIxLjgyMDNMMy4yMjc5MyAxNy4zNTQ3TDEuNDA1MzkgMjMuNjQzOEw3LjY5MTI5IDIxLjgyMDNaIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiLz4KCTwvZz4KCjwvc3ZnPg=="
              alt=""></a></div>
              <div class="profile--text">
                <div class="text-center"><strong>Привет, <?=$user->name;?>!</strong></div>
                <div class="personal-record text-center">
                  <div class="personal-record--inner"><span class="d-block">ТВОЙ ВКЛАД</span>
                    <p class="nomargin">0</p> <span class="d-block">км</span>
                  </div>
                  <br>
                  <button type="button" class="btn-new btn-logout">Выйти</button>
                </div>
              </div>
            </div>
          </div>

          <div class="flex-fill">
            <div class="row">
              <div class="col-sm-12 col-xl-4 col-lg-5 col-md-12 margin-ctn">
                <div class="border-shadow">
                  <div class="calendar"></div>
                  <div class="d-flex align-items-center">
                    <div class="flex-fill">
                      <a href="#addActivity__ctn" class="btn-new fancybox">добавить активность</a>
                    </div>
                    <div class="flex-fill">
                      <p class="current__activity nomargin text-right"><span>0</span> <small>км</small></p>
                    </div>
                  </div>
                  <input type="hidden" name="calendar" class="calendar__pick">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
    <pre><? print_r(json_encode($activity));print_r($addInfo); print_r(json_encode($activity));?></pre>

    <script type="text/javascript">
    var _total = jQuery('.general__activity p')

    _total[0].childNodes[0].nodeValue = <?=$total_activity;?>;
    _total[1].childNodes[0].nodeValue = <?=$total_activity;?>;
    $ = jQuery;
    let events = <?=json_encode($activity);?>;


    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!
    var yyyy = today.getFullYear();
    if (dd < 10) {
      dd = '0' + dd;
    }
    if (mm < 10) {
      mm = '0' + mm;
    }
    var today = mm + '/' + dd + '/' + yyyy;

    $('.calendar__pick').val(today)

    $(".calendar").datepicker({
      beforeShowDay: function(date) {
        var result = [true, '', null];
        var matching = $.grep(events, function(event) {

          ddate = new Date(event.date)
          ddated = ddate.getDate();
          ddatem = ddate.getMonth() + 1
          ddatey = ddate.getFullYear()

          etoday = ddatem + '/' + ddated + '/' + ddatey;


          console.log(date)
          return etoday.valueOf() == date.valueOf();


        });
        if (matching.length) {
          result = [true, matching[0].type+' eventType', null];
        }
        return result;
      },
      onSelect: function(dateText) {
        var date,
        selectedDate = new Date(dateText),
        i = 0,
        distance = 0

        if(events.length > 0){
          let edate
          events.forEach((v,k)=>{
            if(v.Date.valueOf() === selectedDate.valueOf()){
              distance+= parseFloat(v.distance)
            }
          })
        }
        console.log(event)
        $('.calendar__pick').val(dateText.valueOf())
        this.date = selectedDate

        if (distance > 0) {
          $('.current__activity span').text(distance);
        }else{
          $('.current__activity span').text(0);
        }
      },
      monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь',
      'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'
    ],
    dayNamesMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
    firstDay: 1,
  });
</script>
