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
  var $cardIcon = $('.card-icon');

  //Initializes popovers
  $element.popover();

  //This event fires immediately when the show instance method is called
  $element.on('show.bs.popover', function () {
    $cardIcon.css('display', 'none');
  });

  //This event is fired immediately when the hide instance method has been called
  $element.on('hidden.bs.popover', function () {
    $cardIcon.css('display', 'flex');
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
        mobile:       false,
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
      });

var lgScreenMin = 1200;

var mdScreenMax = lgScreenMin - 1;
var mdScreenMin = 992;

var smScreenMax = mdScreenMin - 1;
var smScreenMin = 768;

var xsScreenMax = smScreenMin - 1;
var xsScreenMin = 480;