var app = new Vue({
  el: '#app',
  data: {
    icn: 'burger.svg',
    user_reg: 8750,
    user_fed: 17500,
    month_reg: 6,
    month_fed: 6,
    user_reg_sel: 2,
    user_fed_sel: 2,
    user_reg_disc:0,
    user_fed_disc:0,
    typePrice: '',
    typePrice_fed: '',
    contact_name:null,
    contact_email:null,
    contact_phone:null,
    contact_txt: null,
    product_v: 1,
    name_reg:null,
    inn_reg:null,
    contact_reg:null,
    mail_reg:null,
    phone_reg:null,
    voucher_type: null,
    service_type: null,
    contact_name_p:null,
    contact_email_p:null,
    contact_phone_p:null
  },
  methods:{
    onSubmitContact: function(event){
      vm = this
      axios.post('/mailer.php', {
        name: vm.contact_name,
        email: vm.contact_email,
        phone: vm.contact_phone,
        text: vm.contact_txt,
        contact: 'general'
      })
      .then(function (response) {

        if(response.data == 'sent'){
          $('.popup__contact').fadeIn('300')
          event.target.reset()
        }
      })
      .catch(function (error) {
        //console.log(vm.contact_name);
      });
    },
    close__pop: function(sel){
      $('.'+sel).fadeOut('300')

    },
    close__pop2: function(){
      $(".invoice__ctn.active").fadeOut('300');
      $('.invoice__ctn').removeClass('active')
    },
    toggleMute: function(){
      const video = document.getElementById('Bgvideo');
      video.muted = !video.muted;
    },
    formatPrice: function(value) {
      let val = value
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")
    },
    employee_panel: function(val){
      if(val == 1){
        this.user_reg = 8750
        this.user_fed = 17500
      }
    },
    showMore: function(val, btn){
      $(val).fadeIn()
      $(btn).hide()
    },
    showMenu: function(){
      $('.menu__mob--ctn').toggleClass('active')
      $('.menu__mob--ctn').fadeToggle('200', function(){
        if(!$('.menu__mob--ctn').hasClass('active')){
          $('.submenu__ctn--mob').removeClass('active')
        }
      })
      if($('.menu__mob--ctn').hasClass('active')){
        this.icn = 'close-mob.svg'
        $('body').addClass('noscroll')
      }else{
        this.icn = 'burger.svg'
        $('body').removeClass('noscroll')
      }
    },
    showMobInner: function(){
      $('.submenu__ctn--mob').toggleClass('active')
    },
    changePrice: function(userqt, discount){
      $('.price__selector--reg button').removeClass('active')
      $('.price__selector--reg input').removeClass('active')
      this.user_reg_sel = userqt
      this.user_reg_disc = discount
    },
    changePriceFed: function(userqt, discount){
      $('.price__selector--fed button').removeClass('active')
      $('.price__selector--fed input').removeClass('active')
      this.user_fed_sel = userqt
      this.user_fed_disc = discount
    },
    changeMonthFed: function(month){
      $('.prices__usr--fed button').removeClass('active')
      this.month_fed = month
    },
    changeMonth: function(month){
      $('.prices__usr--reg button').removeClass('active')
      this.month_reg = month
    },
    removeActive: function(sel){
      $('.'+sel+' button').removeClass('active')
    },
    onlyNumbers: function() {
      this.typePrice = this.typePrice.replace(/[^0-9]/g,'');
      this.typePrice_fed = this.typePrice_fed.replace(/[^0-9]/g,'');
    },
    checkVal: function(val){
      this.user_reg_sel = val
      if(val < 10){
        this.user_reg_disc = 0
      }
      if(val > 9 && val < 20){
        this.user_reg_disc = 10
      }
      if(val > 19){
        this.user_reg_disc = 20
      }
    },
    checkVal2: function(val){
      this.user_fed_sel = val
      if(val < 10){
        this.user_fed_disc = 0
      }
      if(val > 9 && val < 20){
        this.user_fed_disc = 10
      }
      if(val > 19){
        this.user_fed_disc = 20
      }

    },
    productVersion: function(val){
      this.product_v = val
      $('.product_v--sel button').removeClass('active')
      if(val == 1){
        this.user_reg = 8750
        this.user_fed = 17500
      }
      if(val == 2){
        this.user_reg = 17500
        this.user_fed = 35000
      }
    },
    doInvoiceReg: function(type, st){
      this.voucher_type = type
      this.service_type = st
      if(this.product_v == 1){
        $('.invoice__ctn').fadeIn('300', function(){
          $('.invoice__ctn').addClass('active')
        })
        $('.before__send').show()
        $('.after__send').hide()
      }
      if(this.product_v == 2){
        $('.personal__ctn').fadeIn('300')
        $('.personal__ctn .before__send').show()
        $('.personal__ctn .after__send').hide()
      }

    },
    sendPersonal: function(event){
      vm = this
      $('.form__invoice button').attr('disabled', true)
      axios.post('/mailer.php', {
        name: vm.contact_name_p,
        email: vm.contact_email_p,
        phone: vm.contact_phone_p,
        contact: 'personal'
      })
      .then(function (response) {

        if(response.data == 'sent'){

          event.target.reset()
          $('.form__invoice button').attr('disabled', false)
          $('.personal__ctn .before__send').hide()
          $('.personal__ctn .after__send').show()
        }
      })
      .catch(function (error) {
        //console.log(vm.contact_name);
      });
    },
    onSubmitInvoice: function(event){
      var event = event
      //console.log(this.voucher_type)
      var vm = this
      $('.form__invoice button').attr('disabled', true)

      if(this.voucher_type == 1){
        axios.post('/voucher.php', {
          name: vm.name_reg,
          email: vm.mail_reg,
          phone: vm.phone_reg,
          inn: vm.inn_reg,
          service: 'Услуга доступа к общей версии интерактивной панели «'+vm.service_type+'»',
          qt: vm.user_reg_sel,
          month: vm.month_reg,
          ppu: vm.priceUser,
          total_price: vm.priceTotal,
          cnt_name: vm.contact_reg,
          type: '«'+vm.service_type+'»'
        })
        .then(function (response) {

          if(response.data == 'nothing'){
            alert('Ошибка! Юридическое лицо не найдено. Проверьте пожалуйста введенные Вами реквизиты.')
          }
          if(response.data == 'sent'){
            event.target.reset()
            $('.form__invoice button').attr('disabled', false)
            $('.before__send').hide()
            $('.after__send').show()
          }
        })
        .catch(function (error) {
          //console.log(error);
        });
      }
      if(this.voucher_type == 2){
        axios.post('/voucher.php', {
          name: vm.name_reg,
          email: vm.mail_reg,
          phone: vm.phone_reg,
          inn: vm.inn_reg,
          service: 'Услуга доступа к общей версии интерактивной панели «'+vm.service_type+'»',
          qt: vm.user_fed_sel,
          month: vm.month_fed,
          ppu: vm.priceUserFed,
          total_price: vm.priceTotalFed,
          cnt_name: vm.contact_reg,
          type: '«'+vm.service_type+'»'
        })
        .then(function (response) {

          if(response.data == 'nothing'){
            alert('Ошибка! Юридическое лицо не найдено. Проверьте пожалуйста введенные Вами реквизиты.')
          }
          if(response.data == 'sent'){
            event.target.reset()
            $('.before__send').hide()
            $('.after__send').show()
          }
        })
        .catch(function (error) {
          //console.log(error);
        });
      }



    },
    doInvoiceFed: function(type, st){
      this.voucher_type = type
      this.service_type = st
      if(this.product_v == 1){
        $('.invoice__ctn').fadeIn('300', function(){
          $('.invoice__ctn').addClass('active')
        })
        $('.before__send').show()
        $('.after__send').hide()
      }
      if(this.product_v == 2){
        $('.personal__ctn').fadeIn('300')
        $('.personal__ctn .before__send').show()
        $('.personal__ctn .after__send').hide()
      }
    },
    showSearch: function(){
      $('.search__popup').css('display', 'flex').hide().fadeIn(300);
      $('input[name="q"]').focus()
    }
  },
  computed:{
    priceTotal: function(){
      let total = ((this.user_reg*this.user_reg_sel)*this.month_reg)
      let disc = (this.user_reg_disc)/100
      return total - (total*disc)
    },
    priceTotalFed: function(){
      let total = ((this.user_fed*this.user_fed_sel)*this.month_fed)
      let disc = (this.user_fed_disc)/100
      return total - (total*disc)
    },
    priceUser: function(){
      let disc = (this.user_reg_disc)/100
      let total = this.user_reg

      return total - (total*disc)
    },
    priceUserFed: function(){
      let disc = (this.user_fed_disc)/100
      let total = this.user_fed
      return total - (total*disc)
    }
  },
  watch:{
    user_reg_sel: function(val){

      if(val < 2){
        $('.user__panel--reg .price__btn button, .emp__panel--reg .price__btn button').attr('disabled', true)
      }else{
        $('.user__panel--reg .price__btn button, .emp__panel--reg .price__btn button').attr('disabled', false)
      }
    },
    user_fed_sel: function(val){
      if(val < 2){
        $('.user__panel--fed .price__btn button, .emp__panel--fed .price__btn button').attr('disabled', true)
      }else{
        $('.user__panel--fed .price__btn button, .emp__panel--fed .price__btn button').attr('disabled', false)
      }
    },
    typePrice: function(val){

      this.user_reg_sel = val
      if(val < 10){
        this.user_reg_disc = 0
      }
      if(val > 9 && val < 20){
        this.user_reg_disc = 10
      }
      if(val > 19){
        this.user_reg_disc = 20
      }


    },
    typePrice_fed: function(val){

      this.user_fed_sel = val
      if(val < 10){
        this.user_fed_disc = 0
      }
      if(val > 9 && val < 20){
        this.user_fed_disc = 10
      }
      if(val > 19){
        this.user_fed_disc = 20
      }
    }
  }
})

$(document).ready(function(){

  $('.more__info--about').click(function(e){
    e.preventDefault();
    $(this).hide();

    $('.more__info-show').fadeIn('300')
  })
  $('.phone').mask('+7 (000) 000-00-00');
  $(document).on('click', function (e) {
    if ($(e.target).closest(".popup__contact").length === 0) {
      $(".popup__contact").fadeOut('300');
    }
    if ($(e.target).closest(".invoice__ctn.active > div > div").length === 0) {
      $(".invoice__ctn.active").fadeOut('300');
      $('.invoice__ctn').removeClass('active')
    }

  });

  var mt = 150

  $('.main__linkto a').click(function(e){
    e.preventDefault();
    const link_to = $(e.currentTarget).attr('href')



    $("html, body").animate({ scrollTop: $(link_to).offset().top - mt }, 300);
  });
  if($('.video__block').length > 0){
    $('.submenu__ctn a.redirect').click(function(e){
      e.preventDefault();
      const link_to = $(e.currentTarget).attr('href').split('/');
      $("html, body").animate({ scrollTop: $(link_to[1]).offset().top - mt }, 300);
    });
    $('.root-item').click(function(e){
      e.preventDefault();
      const link_to = $(e.currentTarget).attr('href').split('/');
      $("html, body").animate({ scrollTop: $(link_to[1]).offset().top - 90 }, 300);
    });
    $('.submenu__ctn--mob a.redirect').click(function(e){
      e.preventDefault();
      const link_to = $(e.currentTarget).attr('href').split('/');
      $("html, body").animate({ scrollTop: $(link_to[1]).offset().top - mt }, 300);
      $('.menu__mob--ctn').toggleClass('active')
      $('.menu__mob--ctn').fadeToggle('200', function(){
        if(!$('.menu__mob--ctn').hasClass('active')){
          $('.submenu__ctn--mob').removeClass('active')
        }
      })
      if($('.menu__mob--ctn').hasClass('active')){
        app.icn = 'close-mob.svg'
        $('body').addClass('noscroll')
      }else{
        app.icn = 'burger.svg'
        $('body').removeClass('noscroll')
      }

    });


    $('.submenu__ctn li:first-child ul > li:first-child > a').click(function(e){
      const link_to = '#user__panel'
      $("html, body").animate({ scrollTop: $(link_to).offset().top - mt }, 300);
    })

    $('.submenu__ctn li:first-child ul > li:nth-child(2) > a').click(function(e){
      const link_to = '#employee__panel'
      $("html, body").animate({ scrollTop: $(link_to).offset().top - mt }, 300);
    })
  }

  $('.show__more--btn-hr').click(function(e){
    $(this).hide()
    e.preventDefault();
    $('.show__more--hr').slideDown('300')
  })

  var controller = new ScrollMagic.Controller();

  controller.scrollPos(function () {
    if(window.innerWidth >= 1024){
      return window.pageYOffset;
    } else {
      return 0;
    }
  });

  // build scene
  var scene = new ScrollMagic.Scene({triggerElement: "#trigger1", duration: 0,triggerHook:'0'})
  .setPin("#menu__pin")
  .on("update", function(e){

    if(e.target.controller().info("scrollDirection") == 'REVERSE'){
      scene.offset('-90')
      $('.header').addClass('fixed__head')
    }else{
      scene.offset('0')
      $('.header').removeClass('fixed__head')
    }

  })
  .on('enter', function(e){
    $('.header').removeClass('fixed__head')
  })
  .on('leave', function(e){
    $('.header').removeClass('fixed__head')
  })
  .addTo(controller);

  var vw = 0;

  vw = $('body').width()
  //console.log(vw)
  if(vw < 1024){


    $("#pills-tab li:first-child").on('click', function (e) {
      $('#pills-tab').animate({
        scrollLeft: 0
      }, 500);
    })
    $("#pills-tab li:nth-child(2)").on('click', function (e) {
      sl = $(this).width() + 20
      $('#pills-tab').animate({
        scrollLeft: sl
      }, 500);
    })
    $("#pills-tab li:nth-child(3)").on('click', function (e) {
      sl = $(this).width()
      $('#pills-tab').animate({
        scrollLeft: '+='+sl
      }, 500);
    })
  }

  var hw = $('.nav__2').outerWidth()
  $('.header').css('max-width',hw)

  $(window).resize(function(){

    vw = $('body').width()
    //console.log(vw)
    if(vw < 1024){

    }else{
      var hw = $('.nav__2').outerWidth()
      $('.header').css('max-width',hw)
      scene.refresh();
      $("#pills-tab li:first-child").on('click', function (e) {
        $('#pills-tab').animate({
          scrollLeft: 0
        }, 500);
      })
      $("#pills-tab li:nth-child(2)").on('click', function (e) {
        sl = $(this).width() + 20
        $('#pills-tab').animate({
          scrollLeft: sl
        }, 500);
      })
      $("#pills-tab li:nth-child(3)").on('click', function (e) {
        sl = $(this).width()
        $('#pills-tab').animate({
          scrollLeft: '+='+sl
        }, 500);
      })

    }
  })

  if($('#bx-panel').length > 0){
    controller.destroy()
  }

})
