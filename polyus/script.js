$ = jQuery;
$(document).ready(function(){
  if(jQuery('#addActivity__ctn').length > 0){
    var _pop = new Vue({
      el:'#addActivity__ctn',
      data:{
        events:[],
        run:0,
        swim:0,
        bike:0,
        walk:0,
        ski:0,
        tTotal:0,
        km:0,
        typeSelect:'Бег'
      },
      methods:{
        onChange: function(){
          if(this.typeSelect == 'Бег'){
            this.km = this.run
          }
          if(this.typeSelect == 'Плавание'){
            this.km = this.swim
          }
          if(this.typeSelect == 'Велосипед'){
            this.km = this.bike
          }
          if(this.typeSelect == 'Ходьба'){
            this.km = this.walk
          }
          if(this.typeSelect == 'Лыжи'){
            this.km = this.ski
          }
        }
      },
      watch:{
        events:function(val){
          this.run = 0
          this.swim = 0
          this.bike = 0
          this.walk = 0
          this.ski = 0
          this.events = val
          const events = this.events
          events.forEach(function(v,k){
            if(v.type == 'Бег'){
              _pop.run+=(parseFloat(v.activity))
            }else{
              _pop.run+= 0
            }
            if(v.type == 'Плавание'){
              _pop.swim+=(parseFloat(v.activity))
            }else{
              _pop.swim+= 0
            }
            if(v.type == 'Велосипед'){
              _pop.bike+=(parseFloat(v.activity))
            }else{
              _pop.bike+= 0
            }
            if(v.type == 'Ходьба'){
              _pop.walk+=(parseFloat(v.activity))
            }else{
              _pop.walk+= 0
            }
            if(v.type == 'Лыжи'){
              _pop.ski+=(parseFloat(v.activity))
            }else{
              _pop.ski+= 0
            }
          })
          _pop.run = +(this.run).toFixed(1)
          _pop.swim = +(this.swim).toFixed(1)
          _pop.bike = +(this.bike).toFixed(1)
          _pop.walk = +(this.walk).toFixed(1)
          _pop.ski = +(this.ski).toFixed(1)
          this.tTotal = (app.c_distance).toFixed(1)
          console.log(this.tTotal)
          this.onChange()
        }
      }
    })
  }
  if(jQuery('#editForm').length > 0){
    var app2 = new Vue({
      el:'#editForm',
      data:{
        userBE:_userBE,
        realPic:''
      },
      mounted: function(){
        this.userBE = _userBE
        console.log(this.userBE)
      },
      methods:{
        changePic: function(){
          this.$refs.file.click();
        },
        onFileChange:function(fieldName, file) {
          let pp = this
          const maxSize = this
          let imageFile = file[0]
          //check if user actually selected a file
          if (file.length>0) {
            let size = imageFile.size / maxSize / maxSize
            if (!imageFile.type.match('image.*')) {
              // check whether the upload is an image
              this.errorDialog = true
              this.errorText = 'Please choose an image file'
            } else if (size>1) {
              // check whether the size is greater than the size limit
              this.errorDialog = true
              this.errorText = 'Your file is too big! Please select an image under 1MB'
            } else {
              // Append file into FormData & turn file into image URL
              let imageURL = URL.createObjectURL(imageFile)
              var reader = new FileReader();
              let base64data;
              reader.readAsDataURL(imageFile);
              reader.onloadend = function() {
                base64data = reader.result;
                $('.profile__pic img').attr('src', base64data)
                app2.realPic = base64data
              }
              // Emit FormData & image URL to the parent component
            }
          }
        }
      },
      watch:{
        realPic:function(val){
          this.realPic = val
          $('.profile__pic img').attr('src', val)
          console.log(val)
        }
      }
    })
  }
  if(jQuery('.profile__ctn').length > 0){
    var app = new Vue({
      el: '.profile__ctn',
      data: {
        personal_total: 0,
        events: events,
        run:0,
        swim:0,
        bike:0,
        walk:0,
        ski:0,
        c_distance:0,
        evnts: [],
      },
      mounted: function(){
        this.doChart()
        this.doCalendar()
      },
      methods:{
        doCalendar: function(){
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
            maxDate: new Date,
            beforeShowDay: function(date) {
              var result = [true, '', null];
              var matching = $.grep(events, function(event) {
                dateValue = event.date;
                modifiedDateValue = dateValue.split("-");
                data2 = modifiedDateValue[2].split(' ')
                date2 = new Date(modifiedDateValue[0] + "/" + modifiedDateValue[1] + "/" + data2[0] +' 00:00:00');
                return date2.valueOf() == date.valueOf();
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
                let _evnt = []
                events.forEach(function(v,k){
                  dateValue = v.date;
                  modifiedDateValue = dateValue.split("-");
                  data2 = modifiedDateValue[2].split(' ')
                  date2 = new Date(modifiedDateValue[0] + "/" + modifiedDateValue[1] + "/" + data2[0] +' 00:00:00');
                  if(date2.valueOf() === selectedDate.valueOf()){
                    console.log()
                    distance+= (parseFloat(v.activity))
                    //console.log(distance)
                    _evnt.push(v)
                  }
                })
                _pop.events = _evnt
              }
              $('.calendar__pick').val(dateText.valueOf())
              date = selectedDate
              if (distance > 0) {
                app.c_distance = +(distance).toFixed(1)
              }else{
                app.c_distance = 0
              }
            },
            monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь',
            'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'
          ],
          dayNamesMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
          firstDay: 1,
        });
      },
      doChart: function(){
        var app = this
        chart = am4core.create("chartdiv", am4charts.PieChart);
        chart.data = this.evnts
        this.events.forEach(function(v,k){
          if(v.type == 'Бег'){
            app.run+=parseFloat(parseFloat(v.activity).toFixed(1))

          }
          if(v.type == 'Плавание'){
            app.swim+=parseFloat(parseFloat(v.activity).toFixed(1))
          }
          if(v.type == 'Велосипед'){
            app.bike+=parseFloat(parseFloat(v.activity).toFixed(1))
          }
          if(v.type == 'Ходьба'){
            app.walk+=parseFloat(parseFloat(v.activity).toFixed(1))
          }
          if(v.type == 'Лыжи'){
            app.ski+=parseFloat(parseFloat(v.activity).toFixed(1))
          }
        })
        this.run = +(this.run).toFixed(1)
        this.swim = +(this.swim).toFixed(1)
        this.bike = +(this.bike).toFixed(1)
        this.walk = +(this.walk).toFixed(1)
        this.ski = +(this.ski).toFixed(1)
        console.log(this.run)
        if(this.run){
          chart.data.push({
            "distance": (this.run).toFixed(0),
            "type": 'Бег',
            "color":"#FCC917"
          })
        }
        if(this.swim){
          chart.data.push({
            "distance": (this.swim).toFixed(0),
            'type':'Плавание',
            "color":"#D95900"
          })
        }
        if(this.bike){
          chart.data.push({
            "distance":(this.bike).toFixed(0),
            'type':'Велосипед',
            "color":"#00877D"
          })
        }
        if(this.walk){
          chart.data.push({
            "distance": (this.walk).toFixed(0),
            'type':'Спортивная ходьба',
            "color":"#6E2636"
          })
        }
        if(this.ski){
          chart.data.push({
            "distance": (this.ski).toFixed(0),
            'type':'Лыжи',
            "color":"#BF1238"
          })
        }
        console.log(chart.data)
        am4core.useTheme(am4themes_animated);
        var pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.slices.template.Align = 'left'
        pieSeries.dataFields.value = "distance";
        pieSeries.dataFields.category = "type";
        chart.innerRadius = 70;
        var label = chart.seriesContainer.createChild(am4core.Label);
        label.html = "<div class='text-center' style='width:100px;line-height: 1;font-weight:bold'>Так<br>держать!</div";
        label.horizontalCenter = "middle";
        label.minWidth = 100
        label.verticalCenter = "middle";
        label.fontWeight = 'bold'
        label.lineHeight = 1
        label.align = "center";
        label.isMeasured = false;
        label.fontSize = 20;
        pieSeries.slices.template.tooltipText = "";
        pieSeries.ticks.template.disabled = true;
        var hs = pieSeries.slices.template.states.getKey("hover");
        hs.properties.scale = 1;
        var as = pieSeries.slices.template.states.getKey("active");
        as.properties.shiftRadius = 0;
        pieSeries.slices.template.strokeWidth = 0;
        pieSeries.slices.template.strokeOpacity = 0;
        pieSeries.slices.template.propertyFields.fill = "color";
        pieSeries.slices.template.propertyFields.stroke = "color";
        pieSeries.labels.template.propertyFields.fill = "color";
        pieSeries.labels.template.fontSize = 14
        pieSeries.labels.template.tooltipDataItem  = "1";
        pieSeries.labels.template.text = "{value.percent.formatNumber('#.0')}%";
        pieSeries.labels.template.resizable = true;
        pieSeries.alignLabels = false;
        chart.responsive.useDefault = false
        chart.responsive.enabled = true;
        chart.responsive.rules.push({
          relevant: function(target) {
            if (target.pixelWidth <= 400) {
              return true;
            }
            return false;
          },
          state: function(target, stateId) {
            if (target instanceof am4charts.Chart) {
              var state = target.states.create(stateId);
              state.properties.paddingTop = 5;
              state.properties.paddingRight = 20;
              state.properties.paddingBottom = 5;
              state.properties.paddingLeft = 20;
              return state;
            }
            return null;
          }
        });
        $('#chartdiv').find('title').prev().remove()
      }
    },
    computed:{
      getTotal: function(){

        let tt = ((this.bike*0.5)+this.run+(this.swim*3)+this.walk+(this.ski*0.5))
        return tt.toFixed(1)
      }
    },
    watch:{
      events:function(val){
        console.log(val)
      },
      c_distance:function(val){
        console.log(val)
      },
    }
  })
}
if(jQuery('.statics__ctn').length > 0){
  var appT = new Vue({
    el:'#pills-total',
    data:{
      table:e_table,
      currentSort:'total',
      currentSortDir:'desc',
      selected: undefined,
      pageSize:10,
      currentPage:1,
      counter: 1,
      noAvatar: 'images/users/user__1376629406.png',
      indx : 0,
      tableEnd:0
    },
    methods:{
      sort:function(s) {
        var _this = $(this);
        $('.total__table th').removeClass('desc')
        $('.total__table th').removeClass('asc')
        if(s === this.currentSort) {
          this.currentSortDir = this.currentSortDir==='asc'?'desc':'asc';
        }
        this.currentSort = s;
        event.target.classList.toggle(this.currentSortDir)
      },
      nextPage:function() {
        if((this.currentPage*this.pageSize) < this.table.length){
          this.currentPage++;
          if(this.pageSize > 10){
            this.indx+=this.pageSize
          }else{
            this.indx+=10
          }
        }
      },
      prevPage:function() {
        if(this.currentPage > 1){
          this.currentPage--;
          if(this.pageSize > 10){
            this.indx-=this.pageSize
            if(this.indx < 1){
              this.indx = 0
            }
          }else{
            this.indx-=10
          }
        }
      },
      valMin:function(val){
        if(this.currentPage < 1){
          this.currentPage = 1
          this.indx = 0
        }else{
          this.indx+=(10*this.currentPage)
        }
        if(this.currentPage == 1){
          this.indx = 0
        }
      },
      showMore:function(){
        this.pageSize += 10
      },
    },
    computed:{
      sortedTable:function() {
        var _this = this
        return this.table.sort(function (a, b) {
          var modifier = 1;
          if (_this.currentSortDir === 'desc') modifier = -1;
          if (a[_this.currentSort] < b[_this.currentSort]) return -1 * modifier;
          if (a[_this.currentSort] > b[_this.currentSort]) return 1 * modifier;
          return 0;
        }).filter(function (row, index) {
          var start = (_this.currentPage - 1) * _this.pageSize;
          var end = _this.currentPage * _this.pageSize;
          _this.tableEnd = Math.ceil(_this.table.length / _this.pageSize);
          if (index >= start && index < end) return true;
        });
      },
    },
    watch:{
      tableEnd:function(val){
        this.tableEnd = val
      }
    }
  })
  var appTp = new Vue({
    el:'#pills-lastweek',
    data:{
      table:e_tabl2,
      currentSort:'total',
      currentSortDir:'desc',
      selected: undefined,
      pageSize:10,
      currentPage:1,
      counter: 1,
      noAvatar: 'images/users/user__1376629406.png',
      indx : 0,
      tableEnd:0
    },
    methods:{
      sort:function(s) {
        var _this = $(this);
        $('.total__table th').removeClass('desc')
        $('.total__table th').removeClass('asc')
        if(s === this.currentSort) {
          this.currentSortDir = this.currentSortDir==='asc'?'desc':'asc';
        }
        this.currentSort = s;
        event.target.classList.toggle(this.currentSortDir)
      },
      nextPage:function() {
        if((this.currentPage*this.pageSize) < this.table.length){
          this.currentPage++;
          if(this.pageSize > 10){
            this.indx+=this.pageSize
          }else{
            this.indx+=10
          }
        }
      },
      prevPage:function() {
        if(this.currentPage > 1){
          this.currentPage--;
          if(this.pageSize > 10){
            this.indx-=this.pageSize
            if(this.indx < 1){
              this.indx = 0
            }
          }else{
            this.indx-=10
          }
        }
      },
      valMin:function(val){
        if(this.currentPage < 1){
          this.currentPage = 1
          this.indx = 0
        }else{
          this.indx+=(10*this.currentPage)
        }
        if(this.currentPage == 1){
          this.indx = 0
        }
      },
      showMore:function(){
        this.pageSize += 10
      },
    },
    computed:{
      sortedTable:function() {
        var _this = this
        return this.table.sort(function (a, b) {
          var modifier = 1;
          if (_this.currentSortDir === 'desc') modifier = -1;
          if (a[_this.currentSort] < b[_this.currentSort]) return -1 * modifier;
          if (a[_this.currentSort] > b[_this.currentSort]) return 1 * modifier;
          return 0;
        }).filter(function (row, index) {
          var start = (_this.currentPage - 1) * _this.pageSize;
          var end = _this.currentPage * _this.pageSize;
          _this.tableEnd = Math.ceil(_this.table.length / _this.pageSize);
          if (index >= start && index < end) return true;
        });
      },
    },
    watch:{
      tableEnd:function(val){
        this.tableEnd = val
      }
    }
  })
  var app3 = new Vue({
    el: '.statics__ctn',
    data:{
      swim: 0,
      run: 0,
      bike: 0,
      walk: 0,
      ski: 0,
      allActivity:eventss,
      s1:0,
      s2:0,
      s3:0,
      s4:0,
      s5:0,
      s6:0,
      s7:0,
      s8:0,
      s9:0,
      s10:0,
      companies: events_c,
    },
    mounted:function(){
      this.doChart()
      this.doChart2()
      var _total = jQuery('.general__activity p')
    },
    methods:{
      doChart:function(){
        const vm = this
        let chart = am4core.create("chartdiv", am4charts.PieChart);
        var _activity = this.allActivity
        console.log(this.allActivity)
        vm.swim = _activity.swim
        vm.run = _activity.run
        vm.bike = _activity.bike
        vm.walk = _activity.walk
        vm.ski = _activity.ski
        chart.data = []
        chart.data.push({
          "distance": _activity.ski,
          'type':'Лыжи',
          "color":"#BF1238"
        })
        chart.data.push({
          "distance": _activity.walk,
          'type':'Спортивная ходьба',
          "color":"#6E2636"
        })
        chart.data.push({
          "distance":_activity.bike,
          'type':'Велосипед',
          "color":"#00877D"
        })
        chart.data.push({
          "distance": _activity.swim,
          'type':'Плавание',
          "color":"#D95900"
        })
        chart.data.push({
          "distance": _activity.run,
          "type": 'Бег',
          "color":"#FCC917"
        })
        var pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.value = "distance";
        chart.innerRadius = 70;
        var label = chart.seriesContainer.createChild(am4core.Label);
        label.html = "<div class='text-center' style='width:100px;line-height: 1;font-weight:bold'>вместе<br>мы<br>сильнее!</div";
        label.horizontalCenter = "middle";
        label.minWidth = 100
        label.verticalCenter = "middle";
        label.fontWeight = 'bold'
        label.lineHeight = 1
        label.align = "center";
        label.isMeasured = false;
        label.fontSize = 20;
        pieSeries.slices.template.tooltipText = "";
        pieSeries.ticks.template.disabled = true;
        var hs = pieSeries.slices.template.states.getKey("hover");
        hs.properties.scale = 1;
        var as = pieSeries.slices.template.states.getKey("active");
        as.properties.shiftRadius = 0;
        pieSeries.slices.template.strokeWidth = 0;
        pieSeries.slices.template.strokeOpacity = 0;
        pieSeries.slices.template.propertyFields.fill = "color";
        pieSeries.slices.template.propertyFields.stroke = "color";
        pieSeries.labels.template.propertyFields.fill = "color";
        pieSeries.labels.template.fontSize = 14
        pieSeries.labels.template.tooltipDataItem  = "1";
        pieSeries.labels.template.text = "{value.percent.formatNumber('#.0')}%";
        pieSeries.labels.template.resizable = true;
        pieSeries.alignLabels = false;
        chart.responsive.useDefault = false
        chart.responsive.enabled = true;
        chart.responsive.rules.push({
          relevant: function(target) {
            if (target.pixelWidth <= 400) {
              return true;
            }
            return false;
          },
          state: function(target, stateId) {
            if (target instanceof am4charts.Chart) {
              var state = target.states.create(stateId);
              state.properties.paddingTop = 5;
              state.properties.paddingRight = 20;
              state.properties.paddingBottom = 5;
              state.properties.paddingLeft = 20;
              return state;
            }
            return null;
          }
        })
        $('#chartdiv').find('title').prev().remove()
      },
      doChart2:function(){
        this.s1 = this.companies.s1
        this.s2 = this.companies.s2
        this.s3 = this.companies.s3
        this.s4 = this.companies.s4
        this.s5 = this.companies.s5
        this.s6 = this.companies.s6
        this.s7 = this.companies.s7
        this.s8 = this.companies.s8
        this.s9 = this.companies.s9
        this.s10 = this.companies.s10
        this.s11 = this.companies.s11
        let chart = am4core.create("chartdiv2", am4charts.PieChart);
        chart.data = []
        chart.data.push({
          "distance": this.s1,
          "color":"#C3185A"
        })
        chart.data.push({
          "distance": this.s2,
          "color":"#2E6395"
        })
        chart.data.push({
          "distance": this.s3,
          "color":"#FCC917"
        })
        chart.data.push({
          "distance": this.s4,
          "color":"#00877D"
        })
        chart.data.push({
          "distance": this.s5,
          "color":"#0099C6"
        })
        chart.data.push({
          "distance": this.s6,
          "color":"#731E74"
        })
        chart.data.push({
          "distance": this.s7,
          "color":"#BE1237"
        })
        chart.data.push({
          "distance": this.s8,
          "color":"#6E2636"
        })
        chart.data.push({
          "distance": this.s9,
          "color":"#D95900"
        })
        chart.data.push({
          "distance": this.s10,
          "color":"#FCC917"
        })
        chart.data.push({
          "distance": this.s11,
          "color":"#595959"
        })
        var pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.value = "distance";
        chart.innerRadius = 70;
        var label = chart.seriesContainer.createChild(am4core.Label);
        label.horizontalCenter = "middle";
        label.minWidth = 100
        label.verticalCenter = "middle";
        label.fontWeight = 'bold'
        label.lineHeight = 1
        label.align = "center";
        label.isMeasured = false;
        label.fontSize = 20;
        pieSeries.slices.template.tooltipText = "";
        pieSeries.ticks.template.disabled = true;
        var hs = pieSeries.slices.template.states.getKey("hover");
        hs.properties.scale = 1;
        var as = pieSeries.slices.template.states.getKey("active");
        as.properties.shiftRadius = 0;
        pieSeries.slices.template.strokeWidth = 0;
        pieSeries.slices.template.strokeOpacity = 0;
        pieSeries.slices.template.propertyFields.fill = "color";
        pieSeries.slices.template.propertyFields.stroke = "color";
        pieSeries.labels.template.propertyFields.fill = "color";
        pieSeries.labels.template.fontSize = 14
        pieSeries.labels.template.tooltipDataItem  = "1";
        pieSeries.labels.template.text = "{value.percent.formatNumber('#.##')}%";
        pieSeries.labels.template.resizable = true;
        pieSeries.alignLabels = false;
        chart.responsive.useDefault = false
        chart.responsive.enabled = true;
        chart.responsive.rules.push({
          relevant: function(target) {
            if (target.pixelWidth <= 400) {
              return true;
            }
            return false;
          },
          state: function(target, stateId) {
            if (target instanceof am4charts.Chart) {
              var state = target.states.create(stateId);
              state.properties.paddingTop = 5;
              state.properties.paddingRight = 20;
              state.properties.paddingBottom = 5;
              state.properties.paddingLeft = 20;
              return state;
            }
            return null;
          }
        })
        $('#chartdiv2').find('title').prev().remove()
      }
    },
    computed:{
      getTotal: function(){
        return ((this.bike*0.5)+this.run+(this.swim*3)+this.walk+(this.ski*0.5))
      },
    },
  })
}
$('.profile_pic').change(function(e, val){
  imageFile = $(this)[0].files[0]
  let imageURL = URL.createObjectURL(imageFile)
  var reader = new FileReader();
  let base64data;
  reader.readAsDataURL(imageFile);
  reader.onloadend = function() {
    base64data = reader.result;
    $('.profile_pic2').val(base64data)
  }
})
$('.fancybox').fancybox()
$('.reg__pic').click(function(e){
  e.preventDefault()
  $('.profile_pic').click()
})
$('.forgotp-tab').click(function(e){
  console.log('forgotp-tab')
  e.preventDefault()
  $('#reg-ctnContent, #reg-ctn').hide()
  $('#forgotp').fadeIn();
})
$('.ui-datepicker-current-day').click()
function setScaledFont() {
  var f = 0.35
  var s = $('.personal-record--inner p').offsetWidth,
  fs = s * f;
  $('.personal-record--inner p').css('font-size', fs + '%')
};
setScaledFont()


  $('.more__news').click(function(e){
    e.preventDefault()
    $('.news__list').fadeIn();

    $(this).fadeOut()
  })

});
