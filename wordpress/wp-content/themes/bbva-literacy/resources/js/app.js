var cookies = function($) {
    'use strict';
    var time = 400;
    var cookieName = 'allowCookie';
    var container = $('.cookies');
    var closeBtn = container.find('.close-cookies');
    var isAllowedCookies = Cookies.get(cookieName);

    function allowCookies() {
        container.slideUp(time, function() {
            container.remove();
            Cookies.set(cookieName, true);
        });
    }

    closeBtn.click(allowCookies);

    if (isAllowedCookies) {
        container.remove();
    } else {
        container.show();
    }
};

var dropdowns = function ($) {

  var $dropdown = $('.dropdown-menu li a');

  $dropdown.click(function () {
    var selText = $(this).text();
    $(this).parents('.dropdown').find('.dropdown-toggle').html(selText +
       '<b class="caret mt-md"></b>');
  });
};

var fixedMenu = function($) {
    $(window).scroll(function () {
        var nav = $('.nav-content');
        var content = $('.contents');
        var pos = content.offset().top - nav.height();
        var isScrollDownOfNav = $(this).scrollTop() > pos;

        if (isScrollDownOfNav) {
          nav.addClass('navbar-fixed-top');
        } else {
          nav.removeClass('navbar-fixed-top');
        }

        var $header = $('.header-fixed-top');
        var $image = $('.image-section');
        var pos2 = $image.offset().top - $header.height();
        var isScrollDownOfImage = $(this).scrollTop() > pos2;

        if (!isScrollDownOfImage) {
          $header.addClass('hidden');
        } else {
          $header.removeClass('hidden');
        }
    });
};

var footerMenu = function($) {
    'use strict';
    var footerMenu = $('.footer-bbva .footer-menu-group');
    var launchers = footerMenu.find('.title');

    launchers.click(function() {
        var isPhoneSize = Modernizr.mq('(max-width: ' + xsScreenMax + 'px)');
        if (isPhoneSize) {
            var menuBlock = $(this).next();
            menuBlock.collapse('toggle');
        }
    });
};

var momentjs = function ($) {

  var today = moment();
  var futureEvent = moment([2016, 11, 11]);
  var diff = moment.preciseDiff(today, futureEvent, true);
  var $timezonexs = $('#timezone-xs');
  var $timezone = $('#timezone');

  $timezonexs.find('.days').html(diff.days + '<label>DIAS</label>');
  $timezonexs.find('.hours').html(diff.hours + '<label>HORAS</label>');
  $timezonexs.find('.minutes').html(diff.minutes + '<label>MINUTOS</label>');

  $timezone.find('.days').html(diff.days + '<label>DIAS</label>');
  $timezone.find('.hours').html(diff.hours + '<label>HORAS</label>');
  $timezone.find('.minutes').html(diff.minutes + '<label>MINUTOS</label>');
};

var navPhone = function($) {
    'use strict';

    var webSite = $('html');
    var webSiteContent = webSite.find('body');
    var launcher = webSiteContent.find('.nav-phone-launch');
    var classToOpen = 'nav-phone-open';

    var contents = webSite.find('.contents');
    var footer = webSite.find('.footer-bbva');
    var timeAnimation = 500;
    var classHidden = 'hidden-content';

    function showContent() {
        contents.removeClass(classHidden);
        footer.removeClass(classHidden);
    }
    function hideContent() {
        contents.addClass(classHidden);
        footer.addClass(classHidden);
    }

    launcher.click(function() {
        var isOpenedMenu = webSite.hasClass(classToOpen);

        if (isOpenedMenu) {
            showContent();
            webSite.removeClass(classToOpen);
        } else {
            setTimeout(hideContent, timeAnimation);
            webSite.addClass(classToOpen);
        }
    });
};

var popover = function ($) {

  var $element = $('[data-toggle="popover"]');
  var $cardIcon = $('.icon-publication');
  var $headerFixed = $('.header-fixed-top h1');
  var $buttonFixed = $('#share-fixed-button');
  var $buttonShare = $('#share-button');

  //Initializes popovers
  $element.popover();

  //This event fires immediately when the show instance method is called
  $element.on('show.bs.popover', function () {
    $cardIcon.css('display', 'none');
    $headerFixed.css('opacity', '0.1');
    if ($buttonFixed.hasClass('icon bbva-icon-share')) {
      $buttonFixed.removeClass('icon bbva-icon-share');
      $buttonFixed.addClass('icon bbva-icon-close');
    }

    if ($buttonShare.hasClass('icon bbva-icon-share')) {
      $buttonShare.removeClass('icon bbva-icon-share');
      $buttonShare.addClass('icon bbva-icon-close');
    }
  });

  //This event is fired immediately when the hide instance method has been called
  $element.on('hidden.bs.popover', function () {
    $cardIcon.css('display', 'flex');
    $headerFixed.css('opacity', 'initial');
    if ($buttonFixed.hasClass('icon bbva-icon-close')) {
      $buttonFixed.removeClass('icon bbva-icon-close');
      $buttonFixed.addClass('icon bbva-icon-share');
    }

    if ($buttonShare.hasClass('icon bbva-icon-close')) {
      $buttonShare.removeClass('icon bbva-icon-close');
      $buttonShare.addClass('icon bbva-icon-share');
    }
  });
};

var progresscircle = function($) {
    'use strict';

    var selectorPercicle = '.procircle';
    var config = {
        startAngle: -Math.PI / 2,
        emptyFill: '#f3f1f3',
        thickness: 10,
        lineCap: 'butt' // "butt" or "round"
    };
    var configBlue = {};
    var configYellow = {};
    var configTeel = {};

    $.extend(configBlue, config, {
        fill: {
            color: '#5bbeff'
        }
    });
    $.extend(configYellow, config, {
        fill: {
            color: '#f8cd51'
        }
    });
    $.extend(configTeel, config, {
        fill: {
            color: '#14afb0'
        }
    });

    $('.blue ' + selectorPercicle).circleProgress(configBlue);
    $('.yellow ' + selectorPercicle).circleProgress(configYellow);
    $('.teel ' + selectorPercicle).circleProgress(configTeel);
};

var scroll = function($) {
  $(document).ready(function(){

      var getMax = function(){
          return $(document).height() - $(window).height();
      }

      var getValue = function(){
          return $(window).scrollTop();
      }

      if('max' in document.createElement('progress')){
          // Browser supports progress element
          var progressBar = $('progress');

          // Set the Max attr for the first time
          progressBar.attr({ max: getMax() });

          $(document).on('scroll', function(){
              // On scroll only Value attr needs to be calculated
              progressBar.attr({ value: getValue() });
          });

          $(window).resize(function(){
              // On resize, both Max/Value attr needs to be calculated
              progressBar.attr({ max: getMax(), value: getValue() });
          });
      }
      else {
          var progressBar = $('.progress-bar'),
              max = getMax(),
              value, width;

          var getWidth = function(){
              // Calculate width in percentage
              value = getValue();
              width = (value/max) * 100;
              width = width + '%';
              return width;
          }

          var setWidth = function(){
              progressBar.css({ width: getWidth() });
          }

          $(document).on('scroll', setWidth);
          $(window).on('resize', function(){
              // Need to reset the Max attr
              max = getMax();
              setWidth();
          });
      }
  });

};

var selectLanguage = function($) {
    'use strict';
    $('.selectpicker')
        .selectpicker({
            width: '160px',
            style: null
        });
    $('.selectpicker-form').selectpicker({
        style: null
    });

    var menuMobile = $('.languages-menu');

    menuMobile.on('click', 'a', function() {
        menuMobile.find('a').removeClass('active');
        $(this).addClass('active');
    });
};

var animationWow = function($) {
    'use strict';
    var wow = new WOW({
        boxClass:     'wow',
        offset:       50,
    });
    wow.init();
};

jQuery.noConflict();
jQuery(document).ready(function ($) {
        'use strict';
        selectLanguage($);
        fixedMenu($);
        navPhone($);
        footerMenu($);
        animationWow($);
        cookies($);
        progresscircle($);
        popover($);
        scroll($);
        dropdowns($);
        momentjs($);
      });

var lgScreenMin = 1200;

var mdScreenMax = lgScreenMin - 1;
var mdScreenMin = 992;

var smScreenMax = mdScreenMin - 1;
var smScreenMin = 768;

var xsScreenMax = smScreenMin - 1;
var xsScreenMin = 480;