<?
$model = $this->getModel();
$total_activity = $model->getGlobalActivity();
$t_c = $model->getGlobalActivity2();
$t_t = $model->getGlobalActivity3();
$t_p = $model->getGlobalActivity4();


?>

<div class="wrapper">
  <div class="" >
    <div class="row statics__ctn" v-cloak>
      <div class="col-sm-12 col-md-12 col-lg-12 col-xl-6 margin-ctn">
        <div class="border-shadow">
          <div class="h100">
            <h2 class="h2">общая активность *</h2>
            <div class="row h100 align-items-center margin__moved">
              <div class="col-sm-12 col-xl-7 col-lg-6 col-md-6  align-items-center">
                <div id="chartdiv"></div>
              </div>
              <div class="col-sm-12 col-xl-5 col-md-6 col-lg-6 sports__legend">
                <div class="row">
                  <div class="col-sm-6  col-6">
                    <span class="sportType running">Бег</span>
                    <p>{{this.run}}<small> км</small></p>
                  </div>
                  <div class="col-sm-6  col-6">
                    <span class="sportType swimming">Плавание</span>
                    <p>{{this.swim}}<small> км</small></p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6  col-6">
                    <span class="sportType bike">Велосипед</span>
                    <p>{{this.bike}}<small> км</small></p>
                  </div>
                  <div class="col-sm-6  col-6">
                    <span class="sportType Skiing">Лыжи</span>
                    <p>{{this.ski}}<small> км</small></p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <span class="sportType jogging">Спортивная ходьба</span>
                    <p>{{this.walk}}<small> км</small></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-12 col-md-12 col-lg-12 col-xl-6 margin-ctn">
        <div class="border-shadow">
          <h2 class="h2">Показатель бизнес единиц *</h2>
          <div class="row  align-items-center">
            <div class="col-sm-12 col-xl-7 col-lg-6 col-md-6  align-items-center">
              <div id="chartdiv2"></div>
            </div>
            <div class="col-sm-12 col-xl-5 col-md-6 col-lg-6 sports__legend">
              <div class="row">
                <div class="col-sm-6  col-6">
                  <span class="sportType running">Полюс Вернинское</span>
                  <p>{{this.s3}}<small> км</small></p>
                </div>
                <div class="col-sm-6  col-6">
                  <span class="sportType bike">Полюс Красноярск</span>
                  <p>{{this.s4}}<small> км</small></p>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6  col-6">
                  <span class="sportType Skiing">Полюс Проект</span>
                  <p>{{this.s7}}<small> км</small></p>
                </div>
                <div class="col-sm-6  col-6">
                  <span class="sportType swimming">УК Полюс</span>
                  <p>{{this.s9}}<small> км</small></p>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6  col-6">
                  <span class="sportType pstroy">Полюс<br>Строй</span>
                  <p>{{this.s8}}<small> км</small></p>
                </div>
                <div class="col-sm-6  col-6">
                  <span class="sportType pmagadan">Полюс<br>Магадан</span>
                  <p>{{this.s6}}<small> км</small></p>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6  col-6">
                  <span class="sportType mfc">МФЦ<br>Полюс</span>
                  <p>{{this.s2}}<small> км</small></p>
                </div>
                <div class="col-sm-6  col-6">
                  <span class="sportType plog">Полюс<br>Логистика</span>
                  <p>{{this.s5}}<small> км</small></p>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6  col-6">
                  <span class="sportType lenz">Лензолото</span>
                  <p>{{this.s1}}<small> км</small></p>
                </div>
                <div class="col-sm-6  col-6">
                  <span class="sportType lenz">Полюс Алдан</span>
                  <p>{{this.s10}}<small> км</small></p>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6  col-6">
                  <span class="sportType lenz">СЛ Золото</span>
                  <p>{{this.s11}}<small> км</small></p>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
    <br>
    <br>
    <div class="stables__ctn">
      <div class="border-shadow">
        <ul class="nav nav-pills table__selector" id="pills-tab" role="tablist">
          <li class="nav-item">
            <a class="nav-link" id="pills-home-tab" data-toggle="pill" href="#pills-lastweek" role="tab" aria-controls="pills-home" aria-selected="true">прошлая неделя</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" id="pills-profile-tab" data-toggle="pill" href="#pills-total" role="tab" aria-controls="pills-profile" aria-selected="false">Суммарно</a>
          </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">

          <div class="tab-pane fade" id="pills-lastweek" role="tabpanel" aria-labelledby="pills-home-tab">
            <table id="sampleTableA" class="table total__table" v-cloak>
              <thead>
                <tr>
                  <th>№</th>
                  <th>Имя</th>
                  <th>БЕ</th>
                  <th @click="sort('Велосипед')" class="text-center tsort">Велосипед</th>
                  <th @click="sort('Бег')" class="text-center tsort">Бег</th>
                  <th @click="sort('Лыжи')" class="text-center tsort">Лыжи</th>
                  <th @click="sort('Плавание')" class="text-center tsort">Плавание</th>
                  <th @click="sort('Ходьба')" class="text-center tsort">Ходьба</th>
                  <th @click="sort('total')" class="text-center tsort">Итого *</th>
                </tr>
              </thead>
              <tr v-for="(table, index)  in sortedTable" :key="index">
                <td>{{index+1+indx}}</td>
                <td>
                  <div class="table__Pic">
                    <img v-if="table.pic" :src="table.pic" alt=""><img  :src="noAvatar" alt="">
                  </div>{{table.user}}
                </td>
                <td>{{table.be}}</td>
                <td class="text-center">{{table.Велосипед}}</td>
                <td class="text-center">{{table.Бег}}</td>
                <td class="text-center">{{table.Лыжи}}</td>
                <td class="text-center">{{table.Плавание}}</td>
                <td class="text-center">{{table.Ходьба}}</td>
                <td class="text-center">{{table.total}}</td>
              </tr>
            </tbody>
          </table>
          <div class="relative">
            <div class="text-center">
              <button @click="showMore" class="btn-new">Загрузить еще</button>
            </div>
            <div class="table__controls">
              <button class="prev__table" @click="prevPage">Previous</button>
              <input type="number" name="" min="1" :max="tableEnd" v-model="currentPage" @keyup="valMin"> / <span>{{tableEnd}}</span>
              <button class="next__table" @click="nextPage">Next</button>
            </div>
          </div>
        </div>
        <div class="tab-pane fade  show active" id="pills-total" role="tabpanel" aria-labelledby="pills-profile-tab">
          <table id="sampleTableA" class="table total__table" v-cloak>
            <thead>
              <tr>
                <th>№</th>
                <th>Имя</th>
                <th>БЕ</th>
                <th @click="sort('Велосипед')" class="text-center tsort">Велосипед</th>
                <th @click="sort('Бег')" class="text-center tsort">Бег</th>
                <th @click="sort('Лыжи')" class="text-center tsort">Лыжи</th>
                <th @click="sort('Плавание')" class="text-center tsort">Плавание</th>
                <th @click="sort('Ходьба')" class="text-center tsort">Ходьба</th>
                <th @click="sort('total')" class="text-center tsort">Итого *</th>
              </tr>
            </thead>
            <tr v-for="(table, index)  in sortedTable" :key="index">
              <td>{{index+1+indx}}</td>
              <td>
                <div class="table__Pic">
                  <img v-if="table.pic" :src="table.pic" alt=""><img  :src="noAvatar" alt="">
                </div>{{table.user}}
              </td>
              <td>{{table.be}}</td>
              <td class="text-center">{{table.Велосипед}}</td>
              <td class="text-center">{{table.Бег}}</td>
              <td class="text-center">{{table.Лыжи}}</td>
              <td class="text-center">{{table.Плавание}}</td>
              <td class="text-center">{{table.Ходьба}}</td>
              <td class="text-center">{{table.total}}</td>
            </tr>
          </tbody>
        </table>
        <div class="relative">
          <div class="text-center">
            <button @click="showMore" class="btn-new">Загрузить еще</button>
          </div>
          <div class="table__controls">
            <button class="prev__table" @click="prevPage">Previous</button>
            <input type="number" name="" min="1" :max="tableEnd" v-model="currentPage" @keyup="valMin"> / <span>{{tableEnd}}</span>
            <button class="next__table" @click="nextPage">Next</button>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

</div>
</div>
<script type="text/javascript">
let eventss = <?=($total_activity);?>;
let events_c = <?=($t_c);?>;
let e_table = <?=($t_t);?>;
let e_tabl2 = <?=($t_p);?>;
</script>
