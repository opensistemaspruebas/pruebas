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
        if ($image.offset()) {
          var pos2 = $image.offset().top - $header.height();
        }

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

var googlemap = function ($) {

    var hasMap = $('#mapSection').length;

    function initialize() {

        var mapOptions = {
            center: new google.maps.LatLng(-34.397, 150.644),
            scrollwheel: false,
            zoom: 8,
            draggable: false,
            disableDefaultUI: true,
        };

        var icon = {
            path: 'M12.395 11.708c0-1.993 1.614-3.608 3.604-3.608s3.605 1.616 3.605 3.608-1.614 3.608-3.605 3.608c-1.991 0-3.604-1.615-3.604-3.608zM15.729 2.625c-6.065 0-9.3 3.896-9.3 9.467 0 7.414 9.197 17.176 9.197 17.176 0.149 0.142 0.393 0.142 0.543 0.001 0 0 9.402-9.722 9.402-17.094 0-5.529-3.442-9.55-9.424-9.55h-0.418z',
            fillColor: '#004481',
            fillOpacity: 1,
            anchor: new google.maps.Point(0, 0),
            strokeWeight: 0,
            scale: 1,
        };

        var map = new google.maps.Map(document.getElementById('mapSection'), mapOptions);

        var markers = [];
        var infowindows = [];
        var marker;
        var infowindow;
        var contentString;

        // Markers and infowindows from json array
        $.each(dataEvents, function (index, value) {
            // Create marker
            marker = new google.maps.Marker({
                position: { lat: parseFloat(value.latitude), lng: parseFloat(value.longitude) },
                map: map,
                draggable: false,
                icon: icon,
                zIndex: -20,
                id: value.id,
            });

            // Add to the array
            markers.push(marker);

            // Create infowidow content
            contentString = '<div id="content">' +
                '<h1 id="firstHeading" class="firstHeading">' + value.title + '</h1>' +
                '<div id="bodyContent" class="bodyContent mb-xs">' +
                value.content +
                '</div>' +
                '<div id="distanceContent" class="distanceContent">' +
                value.distance +
                '</div>' +
                '</div>';

            // Create infowindow
            infowindow = new google.maps.InfoWindow({
                content: contentString,
            });

            // Add to the array
            infowindows.push(infowindow);
        });

        // Add events to markers
        $.each(markers, function (index, value) {
            if (document.getElementsByClassName('id-' + markers[index].id).length !== 0) {
                map.setCenter(markers[index].getPosition());
                infowindows[index].open(map, markers[index]);
            }
        });
    }

    if(hasMap){
        google.maps.event.addDomListener(window, 'load', initialize);
    }
};

var landing = function($) {
    'use strict';
	$('.main-page').each(function(){
		var $caption = $(this).find('.data-container');
		var headerHeight = $(this).find('.header-container').height();
		var pheight = $(this).height();
		$caption.css('top', '0');

		$(this).hover(

			function(){
				$caption.stop(1);
				$caption.addClass('data-containerHover');
				$caption.animate({
					top: -headerHeight
				});
			},
			function(){
				$caption.stop(1);
				$caption.animate({
					top: '0'
				});
				$caption.removeClass('data-containerHover');
			}
		)

	}).find('.data-container').click(function(){
		var link = $(this.parentNode).find('a');
		link.attr('target', '_blank');
		if (link.length) {
			location.href = link.attr('href');
		}
	});

};

var googleMaps = function($) {
    'use strict';
    var hasMap = $('#map_canvas').length;
    if (hasMap) {
        google.charts.load('visualization', '1', {'packages':['geochart']});
        google.charts.setOnLoadCallback(drawRegionsMap);
    }

    var chart, dataTable, init_event = null;

    var $mapMessage = $('.map_message');
    var $containerMap = $('.back-map');
    var $selectCountry = $('#select-country');
    var $infoCountry = $('.info-country');

    var optionsChart = {
        legend : 'none',
        tooltip: {
            trigger : 'selection',
            isHtml  : true,
            textStyle: {
                color   : '#BDBDBD',
                fontSize: 11
            }
        },
        defaultColor : '#2A86CA',
        datalessRegionColor : "#BDBDBD",
        backgroundColor: '#F4F4F4',
        colorAxis: {
            colors: ['#2A86CA', '#5BBEFF'],
            minValue : 1,
            maxValue : 2
        },
        width: '100%',
        height: 'auto'
    };

    function drawRegionsMap() {
        chart = new google.visualization.GeoChart(document.getElementById('map_canvas'));
        dataTable = new google.visualization.DataTable();

        dataTable = createTable(dataTable);
        createSelect(dataMap);

        chart.draw(dataTable, optionsChart);
        init_event = google.visualization.events.addListener(chart, 'ready', countryHandler);

        google.visualization.events.addListener(chart, 'regionClick', function() {

          console.log("hago click");


            setTimeout(function () {
                var selection = chart.getSelection();
                if (selection.length > 0) {
                    var option = selection[0].row;
                    $('#select-country option:eq(' + (++option) + ')').prop('selected', true);
                    $selectCountry.selectpicker('refresh');
                    showInfoCountry(selection);
                }
            }, 100);
        });
    }

    function createTable(dataTable) {
        dataTable.addColumn('string', 'Country');
        dataTable.addColumn('number', 'Value');
        dataTable.addColumn({'type': 'string', 'role': 'tooltip', 'p': {'html': true}});
        $.each(dataMap, function(index, value) {
            var html = getHtml(value);
            dataTable.addRow([value.country, 1, html]);
        });
        return dataTable;
    }

    function createSelect(data) {
        $selectCountry.html('<option selected disabled>-- Selecciona --</option>');
        $.each(data, function(index, value) {
            $selectCountry.append($(new Option(value.country, value.id)));
        });
        $selectCountry.selectpicker('refresh');
        $selectCountry.change(changeSelect);
    }

    function getHtml (data) {
        var html = '';
        html += '<span class="map-info-close">&times;</span>';
        html += '<h1>' + data.title + '</h1>';
        html += '<p>' + data.text + '</p>';
        html += '<a class="btn-bbva-aqua" href="'+ data.link +'">'+ data.button +'</a>';
        return html;
    }

    function showInfoCountry(selection) {
        $('.current-country').html($("#select-country option:selected").text());
        $('.link-web').show();
        showWorkshops();
        showMessage(selection);
    }

    function showWorkshops() {
        $infoCountry.find('.workshops').hide();
        $infoCountry.find('.' + $("#select-country").val().toLowerCase()).show();
    }

    function showMessage(selection) {
        $mapMessage.html($('.google-visualization-tooltip > ul').clone());
        for (var i = 0; i < dataTable.getNumberOfRows(); ++i) {
            dataTable.setValue(i, 1, 0);
        }
        dataTable.setValue(selection[0].row, 1, 2);
        var view = new google.visualization.DataView(dataTable);
        chart.draw(view, optionsChart);
        $mapMessage.show();
    }

    function changeSelect() {
        var index = $selectCountry.prop('selectedIndex');
        if (index !== 0) {
            chart.setSelection([{column: null, row: --index}]);
            setTimeout(function () {
                var selection = chart.getSelection();
                if (selection.length > 0) {
                    $mapMessage.removeClass('map-absolute-left');
                    $mapMessage.addClass('map-absolute-right');
                    showInfoCountry(selection);
                }
            }, 100);
        }
    }

    function countryHandler() {
        $.get('http://ipinfo.io', function(response) {
            $selectCountry.selectpicker('val', response.country);
            $selectCountry.selectpicker('refresh');
            changeSelect();
        }, 'jsonp');
        google.visualization.events.removeListener(init_event);
    }

    $containerMap.on('click', function(e){
        $mapMessage.hide();
        var pWidth = $(this).innerWidth();
        var pOffset = $(this).offset();
        var x = e.pageX - pOffset.left;
        if(pWidth / 2 > x) {
            $mapMessage.addClass('map-absolute-right');
            $mapMessage.removeClass('map-absolute-left');
        } else {
            $mapMessage.addClass('map-absolute-left');
            $mapMessage.removeClass('map-absolute-right');
        }
    });

    $mapMessage.on('click', '.map-info-close', function(e) {
        $mapMessage.hide();
    });

    $mapMessage.on('click', function(e) {
        e.stopPropagation();
    });

    google.maps.event.addDomListener(window, 'resize', function() {
        chart.draw(dataTable, optionsChart);
    });
};

var momentjs = function ($) {

  var today = moment();
  var futureEvent = moment([2016, 11, 11]);
  var diff = moment.preciseDiff(today, futureEvent, true);
  var $timezone = $('#timezone');

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

var navBar = function ($) {

  var $searchContainer = $('.logo-search');
  var $searchIcon = $('.search-icon');
  var $inputSearch = $('.input-search');
  var $navBarNav = $('.navbar-nav');

  $searchIcon.click(onClickedSearch);

  function onClickedSearch() {

      if ($navBarNav.hasClass('hidden')) {
          $inputSearch.toggleClass('hidden');
          $searchContainer.toggleClass('active');
          setTimeout(function() { $navBarNav.toggleClass('hidden'); }, 800);
      } else {
          $navBarNav.toggleClass('hidden');
          $inputSearch.toggleClass('hidden');
          $searchContainer.toggleClass('active');
      }
  }
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

var progressbar = function ($) {

var hasGraphs = $('#impactPage').length;

  function getConfig(max) {
    return {
      strokeWidth: 1,
      easing: 'easeInOut',
      duration: 1400,
      color: '#004481',
      trailColor: '#F4F4F4',
      trailWidth: 1,
      text: {
        style: {
          color: '#121212',
          transform: null,
        },
        autoStyleContainer: false,
      },
      step: (state, bar) => {
        bar.setText('<div class="progressNumber">' + Math.round(bar.value() * max)
        + '</div><div class="progressSuffix ml-xs">MM</div>');
      },
    };
  };

  function getCircleConfig(max, color, trailColor, suffix, subColor, subtext) {
    return {
      strokeWidth: 4,
      easing: 'easeInOut',
      duration: 1400,
      color: color,
      trailColor: trailColor,
      trailWidth: 4,
      text: {
        autoStyleContainer: false,
      },
      step: (state, circle) => {
        circle.setText('<div class="circleNumber">' + Math.round(bar.value() * max)
        + '<label>' + suffix + '</label></div>' +
        '<div class="circleSubText ' + subColor + '">' + subtext + '</div>');
      },
    };
  };

if (hasGraphs)
{
  var bar = new ProgressBar.Line('#lineContainer', getConfig(70));
  bar.animate(0.8);

  var bar2 = new ProgressBar.Line('#lineContainer2', getConfig(6));
  bar2.animate(0.75);

  var circle = new ProgressBar.Circle('#circleContainer',
              getCircleConfig(3, '#5bbeff', '#F4F4F4', 'MM', '', 'ADULTOS'));
  circle.animate(0.5);

  var circle2 = new ProgressBar.Circle('#circleContainer2',
                getCircleConfig(7, '#f8cd51', '#F4F4F4', 'MM', '', 'NIÑOS Y JÓVENES'));
  circle2.animate(0.8);

  var circle3 = new ProgressBar.Circle('#circleContainer3',
                getCircleConfig(200, '#02a5a5', '#F4F4F4', 'K', '', 'PYMES'));
  circle3.animate(0.5);

  var circle4 = new ProgressBar.Circle('#circleContainer4',
              getCircleConfig(1000, '#FFFFFF', '#FFFFFF', 'K', 'red', 'MUJERES'));
  circle4.animate(0.8);

  var circle5 = new ProgressBar.Circle('#circleContainer5',
                getCircleConfig(300, '#FFFFFF', '#FFFFFF', 'K', 'yellow', 'ENTORNOS RURALES'));
  circle5.animate(0.6);

  var circle6 = new ProgressBar.Circle('#circleContainer6',
                getCircleConfig(200, '#FFFFFF', '#FFFFFF', 'K', 'blue', 'NIVEL DE EDUCACIÓN PRIMARIA'));
  circle6.animate(0.5);
}

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
    var configWhite = {};

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

    var config2 = {
        startAngle: -Math.PI / 2,
        emptyFill: '#FFFFFF',
        thickness: 10,
        lineCap: 'butt' // "butt" or "round"
    };
    $.extend(configWhite, config2, {
        fill: {
            color: '#FFFFFF'
        }
    });

    $('.blue ' + selectorPercicle).circleProgress(configBlue);
    $('.yellow ' + selectorPercicle).circleProgress(configYellow);
    $('.teel ' + selectorPercicle).circleProgress(configTeel);
    $('.no-circle-red ' + selectorPercicle).circleProgress(configWhite);
    $('.no-circle-yellow ' + selectorPercicle).circleProgress(configWhite);
    $('.no-circle-blue ' + selectorPercicle).circleProgress(configWhite);
};

var publishingFilter = function($) {
    'use strict';

    var selectedTags = [];
    var currentMatches = [];
    var $selectedTag = $('.selected-tag');
    var $availableTag = $('.available-tag');
    var $inputSearch = $('.publishing-filter-search-input');
    var $btnSearch = $('.publishing-filter-search-btn');
    var $btnCloseFilter = $('.close-publishing-filter');
    var $btnFilter = $('.show-publishing-filter');
    var $tagsColumn = $('.tag-container');
    var $authorsColumn = $('.author-container');
    var $geoColumn = $('.geo-container');
    var $tagsCounter = $('.tag-container-counter');
    var $authorsCounter = $('.author-container-counter');
    var $geoCounter = $('.geo-container-counter');

    $availableTag.on('click', selectTag);
    $inputSearch.keypress(onInputKeyPressed);
    $inputSearch.on('input', searchValueUpdated)
    $btnSearch.on('click', searchByTags);
    $btnCloseFilter.on('click', toggleFilter);
    $btnFilter.on('click', toggleFilter);

    //public methods
    function removeTagFromColumn(e) {
        this.remove();
        restoreTag(this);
        removeTagFromArray(selectedTags, $(this).attr('tag-value'));
    }

    function selectTag(e) {
        this.remove();
        var $tag = $(this);
        var tagModel = getTagModel('selected-tag', $tag.attr('from'), 'bbva-icon-close', $tag.attr('tag-value'), $tag.attr('id'));
        var newTag = createTag(tagModel);
        addTagToContainer(newTag, 'selected-tags-container', removeTagFromColumn);
    }

    function onInputKeyPressed(e) {
        if(e.keyCode == 13){
            var tagModel = getTagModel('selected-tag', null, 'bbva-icon-close', this.value, null);
            var newTag = createTag(tagModel);
            addTagToContainer(newTag, 'selected-tags-container', removeTagFromColumn);
            this.value = "";
            removeAllMatchedTags();
        }
    }

    function searchValueUpdated(e) {
        var $this = $(this);
        var value = $this.val();
        if (value.length > 2) {
            var matchedResults = _.filter(data.availableTags, function(obj){
                return obj.text.includes(value);
            });
            refreshTagMatches(matchedResults);
        } else {
            removeAllMatchedTags();
        }
        refreshTagCounters(currentMatches);
    }

    function searchByTags() {
		$('.cards-grid').css('opacity', '1');
        console.log(selectedTags);
    }

    function toggleFilter() {
        var $filterWrapper = $('.publishing-filter-wrapper');

        if ($filterWrapper.hasClass('hidden')) {
            $filterWrapper.removeClass('hidden').addClass('displayed');
            $('.cards-grid').css('opacity', '0.4');
        } else {
            $filterWrapper.removeClass('displayed').addClass('hidden');
            $('.cards-grid').css('opacity', '1');
        }
    }

    //private methods
    function restoreTag(element) {
      var $element = $(element);
      var from = $element.attr('from');
      if (from) {
          var tagValue = $element.attr('tag-value');
          var tagModel = getTagModel('available-tag', from, null, tagValue, $element.attr('id'));
          var newTag = createTag(tagModel);
          addTagToContainer(newTag, from, selectTag);
      }
    }

    function addTagToContainer(tag, targetContainer, clickCallback) {
        var $tag = $(tag);
        $tag.click(clickCallback).appendTo($('.' + targetContainer));
        var tagValue = $tag.attr('tag-value');
        targetContainer === 'selected-tags-container' ? addTagToArray(tagValue) : null;
    }

    function createTag(tag) {
        var newTag = '<div class="tag ' + tag.type + '" from="' + tag.from + '" tag-value="' + tag.text + '" id="' + tag.id + '">';
        newTag += tag.icon ? '<span class="' + tag.icon +'"></span>' : '';
        newTag += '<span>' + tag.text +'</span>' +
              '</div>';
        $(newTag).click(removeTagFromColumn);
        return newTag;
    }

    function getTagModel(type, from, icon, text, id) {
        return {
            type: type + ' wow fadeIn',
            from: from,
            icon: icon,
            text: text,
            id: id
        }
    }

    function removeTagFromArray(_array, tag) {
        var pos = _array.indexOf(tag);
        pos > -1 ? _array.splice(pos, 1) : null;
    }

    function addTagToArray(value) {
        selectedTags.push(value);
    }

    function refreshTagMatches(matchedResults) {
        var l = matchedResults.length;
        for (var i = 0; i < l; i++) {
            var tag = matchedResults[i];
            if (_.where(currentMatches, {'text': tag.text}).length < 1) {
                var tagModel = getTagModel('available-tag', tag.from, null, tag.text, tag.id);
                var newTag = createTag(tagModel);
                addTagToContainer(newTag, tag.from, selectTag);
                currentMatches.push(tag);
            }
        }
        cleanOldMatches(_.difference(currentMatches, matchedResults));
    }

    function removeAllMatchedTags() {
        currentMatches = [];
        $authorsColumn.empty();
        $tagsColumn.empty();
        $geoColumn.empty();
    }

    function cleanOldMatches(oldMatches) {
        var l = oldMatches.length;
        for (var i = 0; i < l; i++) {
            var oldMatch = oldMatches[i];
            $('#' + oldMatch.id).remove();
            for (var m = 0; m < currentMatches.length; m++) {
                if (currentMatches[m].id === oldMatch.id) {
                    currentMatches.splice(m, 1);
                }
            }
        }
    }

    function refreshTagCounters(currentMatches) {
        $authorsCounter.text('0');
        $tagsCounter.text('0');
        $geoCounter.text('0');
        var l = currentMatches.length;
        for (var i = 0; i < l; i++) {
            var $target = $('.' + currentMatches[i].from + '-counter');
            var currentVal = parseInt($target.text());
            $target.text(++currentVal);
        }
    }
};

var scroll = function($) {

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
        offset:       50
    });
    wow.init();
};

var animationWowAppear = function($) {
    'use strict';
    var wow = new WOW({
        boxClass:     'wow-appear',
        offset:       0
    });
    wow.init();
};

var dataMap = [
    {
        'id'        : 'ES',
        'country'   : 'España',
        'title'     : 'Bancomer Educación Financiera',
        'text'      : 'Con el fin de mejorar tu conocimiento en finanzas ponemos a tu alcance un sitio en el que encontrarás tips, artículos, vídeos, calculadoras, simuladores y talleres gratuitos presenciales o en línea de ahorro, crédito y muchos más para niños, jóvenes, adultos y PyMEs.',
        'button'    : 'Más información',
        'link'      : '#'
    },
    {
        'id'        : 'PT',
        'country'   : 'Portugal',
        'title'     : 'Bancomer Educación Financiera',
        'text'      : 'Con el fin de mejorar tu conocimiento en finanzas ponemos a tu alcance un sitio en el que encontrarás tips, artículos, vídeos, calculadoras, simuladores y talleres gratuitos presenciales o en línea de ahorro, crédito y muchos más para niños, jóvenes, adultos y PyMEs.',
        'button'    : 'Más información',
        'link'      : '#'
    },
    {
        'id'        : 'MX',
        'country'   : 'México',
        'title'     : 'Bancomer Educación Financiera',
        'text'      : 'Con el fin de mejorar tu conocimiento en finanzas ponemos a tu alcance un sitio en el que encontrarás tips, artículos, vídeos, calculadoras, simuladores y talleres gratuitos presenciales o en línea de ahorro, crédito y muchos más para niños, jóvenes, adultos y PyMEs.',
        'button'    : 'Más información',
        'link'      : '#'
    },
    {
        'id'        : 'TR',
        'country'   : 'Turquía',
        'title'     : 'Bancomer Educación Financiera',
        'text'      : 'Con el fin de mejorar tu conocimiento en finanzas ponemos a tu alcance un sitio en el que encontrarás tips, artículos, vídeos, calculadoras, simuladores y talleres gratuitos presenciales o en línea de ahorro, crédito y muchos más para niños, jóvenes, adultos y PyMEs.',
        'button'    : 'Más información',
        'link'      : '#'
    },
    {
        'id'        : 'US',
        'country'   : 'Estados Unidos',
        'title'     : 'Bancomer Educación Financiera',
        'text'      : 'Con el fin de mejorar tu conocimiento en finanzas ponemos a tu alcance un sitio en el que encontrarás tips, artículos, vídeos, calculadoras, simuladores y talleres gratuitos presenciales o en línea de ahorro, crédito y muchos más para niños, jóvenes, adultos y PyMEs.',
        'button'    : 'Más información',
        'link'      : '#'
    },
    {
        'id'        : 'CO',
        'country'   : 'Colombia',
        'title'     : 'Bancomer Educación Financiera',
        'text'      : 'Con el fin de mejorar tu conocimiento en finanzas ponemos a tu alcance un sitio en el que encontrarás tips, artículos, vídeos, calculadoras, simuladores y talleres gratuitos presenciales o en línea de ahorro, crédito y muchos más para niños, jóvenes, adultos y PyMEs.',
        'button'    : 'Más información',
        'link'      : '#'
    },
    {
        'id'        : 'VE',
        'country'   : 'Venezuela',
        'title'     : 'Bancomer Educación Financiera',
        'text'      : 'Con el fin de mejorar tu conocimiento en finanzas ponemos a tu alcance un sitio en el que encontrarás tips, artículos, vídeos, calculadoras, simuladores y talleres gratuitos presenciales o en línea de ahorro, crédito y muchos más para niños, jóvenes, adultos y PyMEs.',
        'button'    : 'Más información',
        'link'      : '#'
    },
    {
        'id'        : 'PE',
        'country'   : 'Perú',
        'title'     : 'Bancomer Educación Financiera',
        'text'      : 'Con el fin de mejorar tu conocimiento en finanzas ponemos a tu alcance un sitio en el que encontrarás tips, artículos, vídeos, calculadoras, simuladores y talleres gratuitos presenciales o en línea de ahorro, crédito y muchos más para niños, jóvenes, adultos y PyMEs.',
        'button'    : 'Más información',
        'link'      : '#'
    },
    {
        'id'        : 'CL',
        'country'   : 'Chile',
        'title'     : 'Bancomer Educación Financiera',
        'text'      : 'Con el fin de mejorar tu conocimiento en finanzas ponemos a tu alcance un sitio en el que encontrarás tips, artículos, vídeos, calculadoras, simuladores y talleres gratuitos presenciales o en línea de ahorro, crédito y muchos más para niños, jóvenes, adultos y PyMEs.',
        'button'    : 'Más información',
        'link'      : '#'
    },
    {
        'id'        : 'AR',
        'country'   : 'Argentina',
        'title'     : 'Bancomer Educación Financiera',
        'text'      : 'Con el fin de mejorar tu conocimiento en finanzas ponemos a tu alcance un sitio en el que encontrarás tips, artículos, vídeos, calculadoras, simuladores y talleres gratuitos presenciales o en línea de ahorro, crédito y muchos más para niños, jóvenes, adultos y PyMEs.',
        'button'    : 'Más información',
        'link'      : '#'
    },
    {
        'id'        : 'PY',
        'country'   : 'Paraguay',
        'title'     : 'Bancomer Educación Financiera',
        'text'      : 'Con el fin de mejorar tu conocimiento en finanzas ponemos a tu alcance un sitio en el que encontrarás tips, artículos, vídeos, calculadoras, simuladores y talleres gratuitos presenciales o en línea de ahorro, crédito y muchos más para niños, jóvenes, adultos y PyMEs.',
        'button'    : 'Más información',
        'link'      : '#'
    },
    {
        'id'        : 'UY',
        'country'   : 'Uruguay',
        'title'     : 'Bancomer Educación Financiera',
        'text'      : 'Con el fin de mejorar tu conocimiento en finanzas ponemos a tu alcance un sitio en el que encontrarás tips, artículos, vídeos, calculadoras, simuladores y talleres gratuitos presenciales o en línea de ahorro, crédito y muchos más para niños, jóvenes, adultos y PyMEs.',
        'button'    : 'Más información',
        'link'      : '#'
    }
];


var dataEvents = [
    {
        'id'        : '2014',
        'title'     : 'Bancomer Educación Financiera',
        'content'   : '30 South 14th St, México D.F, AL, 35233',
        'distance'  : '0.8',
        'latitude'  : '-34.397',
        'longitude' : '150.644'
    },
    {
        'id'        : '2015',
        'title'     : 'Bancomer Educación Financiera',
        'content'   : '15 South 20th St, México D.F, AL, 35233',
        'distance'  : '2.8',
        'latitude'  : '-34.197',
        'longitude' : '150.844'
    }
];

jQuery.noConflict();
jQuery(document).ready(function ($) {
        'use strict';
        selectLanguage($);
        fixedMenu($);
        navPhone($);
        footerMenu($);
        animationWow($);
        animationWowAppear($);
        landing($);
        cookies($);
        progresscircle($);
        progressbar($);
        popover($);
        googleMaps($);
        scroll($);
        dropdowns($);
        momentjs($);
        googlemap($);
        publishingFilter($);
		navBar($);
      });

var lgScreenMin = 1200;

var mdScreenMax = lgScreenMin - 1;
var mdScreenMin = 992;

var smScreenMax = mdScreenMin - 1;
var smScreenMin = 768;

var xsScreenMax = smScreenMin - 1;
var xsScreenMin = 480;