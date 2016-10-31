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
       '<span class="icon bbva-icon-arrow_bottom"></span>');
  });

  var $contentTabs = $('#select-tab-results');
  $contentTabs.on('change', function () {
      var $socialCurrent = '.' + $(this).val();
      $('#results-tabs li').find($socialCurrent).tab('show');
  });

  $('.results-content-tabs a[data-toggle="tab"]')
      .on('shown.bs.tab', function (e) {
          $contentTabs.selectpicker('val', $(e.target)[0].className);
      });
};

var fixedMenu = function ($) {
    $(window).scroll(function () {
        var $nav = $('.nav-content');
        var $content = $('.contents');
        var pos = $content.offset().top - $nav.height();
        var isScrollDownOfNav = $(this).scrollTop() > pos;

        if (isScrollDownOfNav) {
            $nav.addClass('navbar-fixed-top');
            $content.addClass('fix-navbar-in-top');
        } else {
            $nav.removeClass('navbar-fixed-top');
            $content.removeClass('fix-navbar-in-top');
        }

        var $header = $('.header-fixed-top');
        var $image = $('.image-section');
        var pos2;
        if ($image.offset()) {
            pos2 = $image.offset().top - $header.height();
        }

        var isScrollDownOfImage = $(this).scrollTop() > pos2;

        if (!isScrollDownOfImage) {
            $header.addClass('hidden');
        } else {
            $header.removeClass('hidden');
        }

        enableStickyMenuMobile($);
    });

    function enableStickyMenuMobile($) {
        var $nav = $('.stycky-menu-in-mobile');
        var $content = $('.contents');
        var distanceScrolled = $(window).scrollTop();
        if (distanceScrolled > $nav.height()) {
            $nav.addClass('fixed-top-on-mobile');
            closeAllPopovers();
        } else {
            $nav.removeClass('fixed-top-on-mobile');
            $content.removeClass('fix-navbar-in-top');
        }
    }

    function closeAllPopovers() {
        $('.popover').popover('hide');
    }
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
            path: 'M0,12.8843964 C0,14.7474513 0.484912462,16.7785387 1.39810883,18.9525168 C2.6165542,21.8531782 4.55909161,24.9284809 7.02713408,28.072398 C8.55240231,30.0153616 10.1855184,31.8666903 11.8186921,33.565401 C12.3904451,34.1600977 12.9215696,34.6934376 13.398573,35.1577293 C13.5658531,35.3205515 13.7145284,35.4632107 13.8429116,35.5847433 C13.8880402,35.6274639 13.9274617,35.6645402 13.960965,35.6958516 C14.3823445,36.0941778 14.9962311,36.0957466 15.3813932,35.732905 C15.4516361,35.6682188 15.4913586,35.6313016 15.5368324,35.5887643 C15.6662002,35.4677503 15.8160171,35.3257016 15.9845825,35.1635784 C16.4652566,34.7012748 17.0004707,34.170239 17.5766282,33.5781371 C19.2223999,31.8868212 20.8681199,30.0437437 22.4051738,28.1096779 C24.8856732,24.9884801 26.8396147,21.9355794 28.0683611,19.0557506 C28.9952281,16.8834407 29.4875765,14.8544759 29.4875765,12.9940925 C29.4875765,5.54868695 23.2048877,0 15.0179237,0 L14.4696528,0 C6.16491217,0 0,5.39002078 0,12.8843964 Z M9.48506498,13.20876 C9.48506498,10.2356904 11.8931466,7.82569827 14.863472,7.82569827 C17.8337973,7.82569827 20.241879,10.2356904 20.241879,13.20876 C20.241879,16.1818296 17.8337973,18.5918217 14.863472,18.5918217 C11.8931466,18.5918217 9.48506498,16.1818296 9.48506498,13.20876 Z',
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

    if (hasMap) {
        google.maps.event.addDomListener(window, 'load', initialize);
    }
};

var homeCarouselSwipe = function ($) {
  $('#home-slider.carousel').swipe({
    swipeLeft: function () {
      $(this).carousel('next');
    },

    swipeRight: function () {
      $(this).carousel('prev');
    },

    allowPageScroll: 'vertical',
    excludedElements: 'button, input, select, textarea, .noSwipe',
  });
};

var homeStopCarouselOnMobile = function ($) {
  var mobileRegexp = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i;
  if (navigator && navigator.userAgent && mobileRegexp.test(navigator.userAgent)) {
    $('#home-slider.carousel').carousel({ interval: false, });
  }
};

var googleMaps = function($) {
    'use strict';
    var hasMap = $('#map_canvas').length;
    if (hasMap) {
        google.charts.load('visualization', '1', {'packages':['geochart']});
        google.charts.setOnLoadCallback(drawRegionsMap);
        google.maps.event.addDomListener(window, 'resize', function() {
            chart.draw(dataTable, optionsChart);
        });
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
                fontSize: 11,
                fontFamily: 'BentonSans'
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

};

var menuSearch = function($) {
    'use strict';

    var selectedTags = [];
    var currentMatches = [];
    var $availableTag = $('#menu-search .available-tag');
    var $inputSearch = $('.navbar .navbar-search-input');
    var $btnSearch = $('.navbar .publishing-filter-search-btn');
    var $btnCloseFilter = $('.navbar .close-navbar-filter');
    var $btnFilter = $('.show-menu-filter');
    var $tagsColumn = $('#menu-search .tag-container');
    var $authorsColumn = $('#menu-search .author-container');
    var $geoColumn = $('#menu-search .geo-container');
    var $tagsCounter = $('#menu-search .tag-container-counter');
    var $authorsCounter = $('#menu-search .author-container-counter');
    var $geoCounter = $('#menu-search .geo-container-counter');

    $availableTag.on('click', selectTag);
    $inputSearch.keypress(onInputKeyPressed);
    $inputSearch.on('input', searchValueUpdated)
    $btnSearch.on('click', searchByTags);
    $btnCloseFilter.on('click', toggleFilter);
    $btnFilter.on('click', toggleFilter);

    //public methods
    function removeTagFromColumn(e) {
        var $tag = $(this);
        $tag.remove();
        restoreTag(this);
        removeTagFromArray(selectedTags, $(this).attr('tag-value'));
    }

    function selectTag(e) {
        var $tag = $(this);
        $tag.remove();
        var tagModel = getTagModel('animated fadeIn selected-tag', $tag.attr('from'), 'bbva-icon-close', $tag.attr('tag-value'), $tag.attr('id'));
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
        removeAllMatchedTags();
        if (value.length > 2) {
            var matchedResults = _.filter(data.availableTags, function(obj){
                return obj.text.includes(value);
            });
            refreshTagMatches(matchedResults);
            showGeoTags();
        }
        refreshTagCounters(currentMatches);
    }

    function showGeoTags() {
        var allTags = data.availableTags;
        $.each(data.availableTags, function(index, tag) {
            if (tag.from === 'geo-container' && _.where(currentMatches, {'text': tag.text}).length < 1 && _.indexOf(selectedTags, tag.text) < 0) {
                var tagModel = getTagModel('available-tag', tag.from, null, tag.text, tag.id);
                var newTag = createTag(tagModel);
                if ($(".selected-tags-container").find('#'+tag.id).length === 0) {
                    addTagToContainer(newTag, tag.from, selectTag);
                }
                currentMatches.push(tag);
            }
        });
    }

    function searchByTags() {
        console.log(selectedTags);
        if (selectedTags.length > 0) {
            //window.location.href = "index.html";
        }
    }

    function toggleFilter() {
        var $filterWrapper = $('#menu-search.menu-filter-wrapper');

        if ($filterWrapper.hasClass('hidden')) {
            $filterWrapper.removeClass('hidden').addClass('displayed');
        } else {
            $filterWrapper.removeClass('displayed').addClass('hidden');
            emptyData();
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
        $tag.click(clickCallback).appendTo($('#menu-search ' + '.' + targetContainer));
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
            type: type,
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
            if (tag.from !== 'geo-container' && _.where(currentMatches, {'text': tag.text}).length < 1 && _.indexOf(selectedTags, tag.text) < 0) {
                var tagModel = getTagModel('available-tag', tag.from, null, tag.text, tag.id);
                var newTag = createTag(tagModel);
                if ($(".selected-tags-container").find('#'+tag.id).length === 0) {
                    addTagToContainer(newTag, tag.from, selectTag);
                }
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
            $('#menu-search ' + '.available-tags-wrapper ' + '#' + oldMatch.id).remove();
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
            var $target = $('#menu-search ' + '.' + currentMatches[i].from + '-counter');
            var currentVal = parseInt($target.text());
            $target.text(++currentVal);
        }
    }

    function emptyData() {
        removeAllMatchedTags();
        $authorsCounter.text('0');
        $tagsCounter.text('0');
        $geoCounter.text('0');
        $inputSearch.val('');
        selectedTags = [];
    }
};

/*setProgressBarLine('#lineContainer', getConfig(70, 'MM'), 0.8);
setProgressBarLine('#lineContainer2', getConfig(6, 'K'), 0.75);
setProgressBarCircle('#circleContainer', getCircleConfig(3, '#5bbeff', '#F4F4F4', 'MM', '', 'ADULTOS'), 0.5);
setProgressBarCircle('#circleContainer2', getCircleConfig(7, '#f8cd51', '#F4F4F4', 'MM', '', 'NIÑOS Y JÓVENES'), 0.8);
setProgressBarCircle('#circleContainer3', getCircleConfig(200, '#02a5a5', '#F4F4F4', 'K', '', 'PYMES'), 0.5);
setProgressBarCircle('#circleContainer4', getCircleConfig(1000, 'transparent', 'transparent', 'K', 'red', 'MUJERES'), 0.8);
setProgressBarCircle('#circleContainer5', getCircleConfig(300, 'transparent', 'transparent', 'K', 'yellow', 'ENTORNOS RURALES'), 0.6);
setProgressBarCircle('#circleContainer6', getCircleConfig(200, 'transparent', 'transparent', 'K', 'blue', 'NIVEL DE EDUCACIÓN PRIMARIA'), 0.5);*/

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
  var $closeNavbarFilter = $('.close-navbar-filter');
  var $searchFormContainer = $('.search-form-container');
  var $navBarNav = $('.navbar-nav');
  var $searchMenu = $('.navbar-search');
  var $filterWrapper = $('.navbar .menu-filter-wrapper');
  var $inputFilter = $('.navbar .navbar-search-input');
  var $webContent = $('.webpage .contents');
  var $searchLayer = $('.webpage .contents #search-layer');

  $searchIcon.click(onClickedSearch);
  $closeNavbarFilter.click(onClickedSearch);
  $inputFilter.on('input', function() {
      if(this.value.length > 2) {
          $filterWrapper.removeClass('hidden');
          $webContent.css("position", "relative");
          $searchLayer.addClass('search-layer');
      }
  });

  function onClickedSearch() {

      if ($navBarNav.hasClass('hidden')) {
          $searchFormContainer.toggleClass('hidden');
          $searchContainer.toggleClass('active');

          $searchMenu.fadeToggle(750);

          setTimeout(function() {
              $navBarNav.toggleClass('hidden');
          }, 800);
          $webContent.css("position", "inherit");
          $searchLayer.removeClass('search-layer');
      } else {
          $navBarNav.toggleClass('hidden');

          $searchFormContainer.toggleClass('hidden');
          $searchContainer.toggleClass('active');

          //$filterWrapper.removeClass('hidden');
          $searchMenu.fadeToggle(750);
      }
  }
};

var popover = function ($) {

  var $element = $('[data-toggle="popover"]');
  var $cardIcon = $('.icon-publication');
  var $headerFixed = $('.header-fixed-top h1');
  var $buttonFixed = $('#share-fixed-button');
  var $buttonShare = $('#share-button');
  var $twitter = $('.tweets-container');

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

  $twitter.on('click', '.pop-div-twitter', function () {
    var id = $(this).attr('data-popover-id');
    $('[data-popover-id=' + id + ']').toggleClass('hidden');
    $('.share [data-popover-id=' + id + ']').toggleClass('hidden');
  });
};

var publishingFilter = function($) {
    'use strict';

    var selectedTags = [];
    var currentMatches = [];
    var $availableTag = $('#publishing-filter .available-tag');
    var $inputSearch = $('#publishing-filter .publishing-filter-search-input');
    var $btnSearch = $('#publishing-filter .publishing-filter-search-btn');
    var $btnCloseFilter = $('#publishing-filter .close-publishing-filter');
    var $btnFilter = $('.show-publishing-filter');
    var $tagsColumn = $('#publishing-filter .tag-container');
    var $authorsColumn = $('#publishing-filter .author-container');
    var $geoColumn = $('#publishing-filter .geo-container');
    var $tagsCounter = $('#publishing-filter .tag-container-counter');
    var $authorsCounter = $('#publishing-filter .author-container-counter');
    var $geoCounter = $('#publishing-filter .geo-container-counter');
	var $sortItemsContainer = $('.sort-items-container');

    $availableTag.on('click', selectTag);
    $inputSearch.keypress(onInputKeyPressed);
    $inputSearch.on('input', searchValueUpdated)
    $btnSearch.on('click', searchByTags);
    $btnCloseFilter.on('click', toggleFilter);
    $btnFilter.on('click', toggleFilter);

    //public methods
    function removeTagFromColumn(e) {
        var $tag = $(this);
        $tag.remove();
        restoreTag(this);
        removeTagFromArray(selectedTags, $(this).attr('tag-value'));
    }

    function selectTag(e) {
        var $tag = $(this);
        $tag.remove();
        var tagModel = getTagModel('wow fadeIn selected-tag', $tag.attr('from'), 'bbva-icon-close', $tag.attr('tag-value'), $tag.attr('id'));
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
        removeAllMatchedTags();
        if (value.length > 2) {
            var matchedResults = _.filter(data.availableTags, function(obj){
                return obj.text.includes(value);
            });
            refreshTagMatches(matchedResults);
            showGeoTags();
        }
        refreshTagCounters(currentMatches);
    }

    function showGeoTags() {
        var allTags = data.availableTags;
        $.each(data.availableTags, function(index, tag) {
            if (tag.from === 'geo-container' && _.where(currentMatches, {'text': tag.text}).length < 1 && _.indexOf(selectedTags, tag.text) < 0) {
                console.log(tag.from);
                var tagModel = getTagModel('available-tag', tag.from, null, tag.text, tag.id);
                var newTag = createTag(tagModel);
                if ($(".selected-tags-container").find('#'+tag.id).length === 0) {
                    addTagToContainer(newTag, tag.from, selectTag);
                }
                currentMatches.push(tag);
            }
        });
    }

    function searchByTags() {
		$('.cards-grid').css('opacity', '1');
        console.log(selectedTags);
    }

    function toggleFilter() {
        var $filterWrapper = $('#publishing-filter.publishing-filter-wrapper');

        if ($filterWrapper.hasClass('hidden')) {
            $filterWrapper.removeClass('hidden').addClass('displayed');
            $('.cards-grid').css('opacity', '0.4');
			$sortItemsContainer.hide();
			$btnFilter.hide();
        } else {
            $filterWrapper.removeClass('displayed').addClass('hidden');
			$btnFilter.show();
			$sortItemsContainer.show();
            $('.cards-grid').css('opacity', '1');
            emptyData();
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
        $tag.click(clickCallback).appendTo($('#publishing-filter ' + '.' + targetContainer));
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
            type: type,
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
            if (tag.from !== 'geo-container' && _.where(currentMatches, {'text': tag.text}).length < 1 && _.indexOf(selectedTags, tag.text) < 0) {
                var tagModel = getTagModel('available-tag', tag.from, null, tag.text, tag.id);
                var newTag = createTag(tagModel);
                if ($(".selected-tags-container").find('#'+tag.id).length === 0) {
                    addTagToContainer(newTag, tag.from, selectTag);
                }
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
            $('#publishing-filter ' + '.available-tags-wrapper ' + '#' + oldMatch.id).remove();
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
            var $target = $('#publishing-filter ' + '.' + currentMatches[i].from + '-counter');
            var currentVal = parseInt($target.text());
            $target.text(++currentVal);
        }
    }

    function emptyData() {
        removeAllMatchedTags();
        $authorsCounter.text('0');
        $tagsCounter.text('0');
        $geoCounter.text('0');
        $inputSearch.val('');
        selectedTags = [];
    }
};

var publishingFilterMobile = function($) {
    'use strict';

    var searchPage = $('.filter-mobile');

    $('.filter-mobile-button, .close-filter-mobile').click(function() {
        searchPage.toggleClass('closed');
    });

    var selectedTags = [];
    var currentMatches = [];
    var $availableTag = $('#publishing-filter-mobile .available-tag');
    var $inputSearch = $('#publishing-filter-mobile .publishing-filter-search-input');
    var $btnSearch = $('#publishing-filter-mobile .publishing-filter-search-btn');
    var $tagsColumn = $('#publishing-filter-mobile .tag-container');
    var $authorsColumn = $('#publishing-filter-mobile .author-container');
    var $geoColumn = $('#publishing-filter-mobile .geo-container');
    var $tagsCounter = $('#publishing-filter-mobile .tag-container-counter');
    var $authorsCounter = $('#publishing-filter-mobile .author-container-counter');
    var $geoCounter = $('#publishing-filter-mobile .geo-container-counter');

    bindEventsWithHandlers();

    function bindEventsWithHandlers() {
        $availableTag.on('click', selectTag);
        $inputSearch.keypress(onInputKeyPressed);
        $inputSearch.on('input', searchValueUpdated);
        $btnSearch.on('click', searchByTags);
    }

    function removeTagFromColumn() {
        var $tag = $(this);
        $tag.remove();
        restoreTag(this);
        removeTagFromArray(selectedTags, $(this).attr('tag-value'));
    }

    function selectTag() {
        var $tag = $(this);
        $tag.remove();
        var from = $tag.attr('from');
        var tagValue = $tag.attr('tag-value');
        var id = $tag.attr('id');
        var tagModel = getTagModel('wow fadeIn selected-tag', from, 'bbva-icon-close', tagValue, id);
        var newTag = createTag(tagModel);
        addTagToContainer(newTag, 'selected-tags-container', removeTagFromColumn);
    }

    function onInputKeyPressed(e) {
        if (e.keyCode === 13) {
            var tagModel = getTagModel('selected-tag', null, 'bbva-icon-close', this.value, null);
            var newTag = createTag(tagModel);
            addTagToContainer(newTag, 'selected-tags-container', removeTagFromColumn);
            this.value = '';
            removeAllMatchedTags();
        }
    }

    function searchValueUpdated() {
        var $this = $(this);
        var value = $this.val();
        removeAllMatchedTags();
        if (value.length > 2) {
            var matchedResults = _.filter(data.availableTags, function (obj) {
                return obj.text.includes(value);
            });
            refreshTagMatches(matchedResults);
            showGeoTags()
        }

        refreshTagCounters(currentMatches);
    }

    function showGeoTags() {
        var allTags = data.availableTags;
        $.each(data.availableTags, function(index, tag) {
            if (tag.from === 'geo-container' && _.where(currentMatches, {'text': tag.text}).length < 1 && _.indexOf(selectedTags, tag.text) < 0) {
                console.log(tag.from);
                var tagModel = getTagModel('available-tag', tag.from, null, tag.text, tag.id);
                var newTag = createTag(tagModel);
                addTagToContainer(newTag, tag.from, selectTag);
                currentMatches.push(tag);
            }
        });
    }

    function searchByTags() {
        $('.cards-grid').css('opacity', '1');
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
        $tag.click(clickCallback).appendTo($('#publishing-filter-mobile ' + '.' + targetContainer));
        var tagValue = $tag.attr('tag-value');
        if (targetContainer === 'selected-tags-container') {
            addTagToArray(tagValue);
        }
    }

    function createTag(tag) {
        var newTag = '<div class="tag ' + tag.type + '" from="' + tag.from + '" tag-value="' + tag.text + '" id="' + tag.id + '">';
        newTag += tag.icon ? '<span class="' + tag.icon + '"></span>' : '';
        newTag += '<span>' + tag.text + '</span>' + '</div>';
        $(newTag).click(removeTagFromColumn);
        return newTag;
    }

    function getTagModel(type, from, icon, text, id) {
        return {
            type: type,
            from: from,
            icon: icon,
            text: text,
            id: id,
        };
    }

    function removeTagFromArray(_array, tag) {
        var pos = _array.indexOf(tag);
        if (pos > -1) {
            _array.splice(pos, 1);
        }
    }

    function addTagToArray(value) {
        selectedTags.push(value);
    }

    function refreshTagMatches(matchedResults) {
        var l = matchedResults.length;
        for (var i = 0; i < l; i++) {
            var tag = matchedResults[i];
            var notPresentInCurrentMatches = _.where(currentMatches, { text: tag.text }).length < 1;
            var notPresentInSelectedTags = _.indexOf(selectedTags, tag.text) < 0;
            if (tag.from !== 'geo-container' && notPresentInCurrentMatches && notPresentInSelectedTags) {
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
            $('#publishing-filter-mobile ' + '.available-tags-wrapper ' + '#' + oldMatch.id).remove();
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
            var $target = $('#publishing-filter-mobile ' + '.' + currentMatches[i].from + '-counter');
            var currentVal = parseInt($target.text());
            $target.text(++currentVal);
        }
    }

    function emptyData() {
        removeAllMatchedTags();
        $authorsCounter.text('0');
        $tagsCounter.text('0');
        $geoCounter.text('0');
        $inputSearch.val('');
        selectedTags = [];
        $('#publishing-filter-mobile .selected-tags-container').empty();
    }
};

var refreshPage = function($) {
    'use strict';

    var isPhoneSize = null;
    var isDesktopSize = Modernizr.mq('(min-width: ' + xsScreenMax + 'px)');

    $(window).resize(function() {
        isPhoneSize = Modernizr.mq('(max-width: ' + xsScreenMax + 'px)');
        if (isPhoneSize && isDesktopSize) {
            location.reload();
        }
        if (!isPhoneSize && !isDesktopSize) {
            location.reload();
        }
    });
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

var searchMobile = function($) {
    'use strict';

    var searchPage = $('.search-mobile');

    $('.search-mobile-button, .close-search-mobile').click(function() {
        window.scrollTo(0, 0);
        searchPage.toggleClass('closed');
        setTimeout(function () {
            $('.input-search-mobile').focus();
        }, 500);
    });

    var selectedTags = [];
    var currentMatches = [];
    var $availableTag = $('#mobile-filter .available-tag');
    var $inputSearch = $('#mobile-filter .publishing-filter-search-input');
    var $btnSearch = $('#mobile-filter .publishing-filter-search-btn');
    var $tagsColumn = $('#mobile-filter .tag-container');
    var $authorsColumn = $('#mobile-filter .author-container');
    var $geoColumn = $('#mobile-filter .geo-container');
    var $tagsCounter = $('#mobile-filter .tag-container-counter');
    var $authorsCounter = $('#mobile-filter .author-container-counter');
    var $geoCounter = $('#mobile-filter .geo-container-counter');

    bindEventsWithHandlers();

    function bindEventsWithHandlers() {
        $availableTag.on('click', selectTag);
        $inputSearch.keypress(onInputKeyPressed);
        $inputSearch.on('input', searchValueUpdated);
        $btnSearch.on('click', searchByTags);
    }

    function removeTagFromColumn() {
        var $tag = $(this);
        $tag.remove();
        restoreTag(this);
        removeTagFromArray(selectedTags, $(this).attr('tag-value'));
    }

    function selectTag() {
        var $tag = $(this);
        $tag.remove();
        var from = $tag.attr('from');
        var tagValue = $tag.attr('tag-value');
        var id = $tag.attr('id');
        var tagModel = getTagModel('wow fadeIn selected-tag', from, 'bbva-icon-close', tagValue, id);
        var newTag = createTag(tagModel);
        addTagToContainer(newTag, 'selected-tags-container', removeTagFromColumn);
    }

    function onInputKeyPressed(e) {
        if (e.keyCode === 13) {
            var tagModel = getTagModel('selected-tag', null, 'bbva-icon-close', this.value, null);
            var newTag = createTag(tagModel);
            addTagToContainer(newTag, 'selected-tags-container', removeTagFromColumn);
            this.value = '';
            removeAllMatchedTags();
        }
    }

    function searchValueUpdated() {
        var $this = $(this);
        var value = $this.val();
        removeAllMatchedTags();
        if (value.length > 2) {
            var matchedResults = _.filter(data.availableTags, function (obj) {
                return obj.text.includes(value);
            });
            refreshTagMatches(matchedResults);
            showGeoTags();
        }

        refreshTagCounters(currentMatches);
    }

    function showGeoTags() {
        var allTags = data.availableTags;
        $.each(data.availableTags, function(index, tag) {
            if (tag.from === 'geo-container' && _.where(currentMatches, {'text': tag.text}).length < 1 && _.indexOf(selectedTags, tag.text) < 0) {
                console.log(tag.from);
                var tagModel = getTagModel('available-tag', tag.from, null, tag.text, tag.id);
                var newTag = createTag(tagModel);
                addTagToContainer(newTag, tag.from, selectTag);
                currentMatches.push(tag);
            }
        });
    }

    function searchByTags() {
        $('.cards-grid').css('opacity', '1');
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
        $tag.click(clickCallback).appendTo($('#mobile-filter ' + '.' + targetContainer));
        var tagValue = $tag.attr('tag-value');
        if (targetContainer === 'selected-tags-container') {
            addTagToArray(tagValue);
        }
    }

    function createTag(tag) {
        var newTag = '<div class="tag ' + tag.type + '" from="' + tag.from + '" tag-value="' + tag.text + '" id="' + tag.id + '">';
        newTag += tag.icon ? '<span class="' + tag.icon + '"></span>' : '';
        newTag += '<span>' + tag.text + '</span>' + '</div>';
        $(newTag).click(removeTagFromColumn);
        return newTag;
    }

    function getTagModel(type, from, icon, text, id) {
        return {
            type: type,
            from: from,
            icon: icon,
            text: text,
            id: id,
        };
    }

    function removeTagFromArray(_array, tag) {
        var pos = _array.indexOf(tag);
        if (pos > -1) {
            _array.splice(pos, 1);
        }
    }

    function addTagToArray(value) {
        selectedTags.push(value);
    }

    function refreshTagMatches(matchedResults) {
        var l = matchedResults.length;
        for (var i = 0; i < l; i++) {
            var tag = matchedResults[i];
            var notPresentInCurrentMatches = _.where(currentMatches, { text: tag.text }).length < 1;
            var notPresentInSelectedTags = _.indexOf(selectedTags, tag.text) < 0;
            if (tag.from !== 'geo-container' && notPresentInCurrentMatches && notPresentInSelectedTags) {
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
            $('#mobile-filter ' + '.available-tags-wrapper ' + '#' + oldMatch.id).remove();
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
            var $target = $('#mobile-filter ' + '.' + currentMatches[i].from + '-counter');
            var currentVal = parseInt($target.text());
            $target.text(++currentVal);
        }
    }

    function emptyData() {
        removeAllMatchedTags();
        $authorsCounter.text('0');
        $tagsCounter.text('0');
        $geoCounter.text('0');
        $inputSearch.val('');
        selectedTags = [];
        $('#mobile-filter .selected-tags-container').empty();
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

var sortOptions = function ($) {
    'use strict';
    var $sortItemsContainer = $('.sort-items-container');

    $sortItemsContainer.on('click', 'a', function () {
        $sortItemsContainer.find('a').removeClass('selected');
        $(this).addClass('selected');
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

/*
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
];*/


/*var dataEvents = [
    {
        'id'        : '2014',
        'title'     : 'Bancomer Educación Financiera',
        'content'   : '30 South 14th St, <br> México D.F, AL, 35233',
        'distance'  : '0.8 Miles',
        'latitude'  : '-34.397',
        'longitude' : '150.644'
    },
    {
        'id'        : '2015',
        'title'     : 'Bancomer Educación Financiera',
        'content'   : '15 South 20th St, <br> México D.F, AL, 35233',
        'distance'  : '2.8 Miles',
        'latitude'  : '-34.197',
        'longitude' : '150.844'
    }
];*/

jQuery.noConflict();
jQuery(document).ready(function ($) {
    'use strict';
    selectLanguage($);
    fixedMenu($);
    navPhone($);
    footerMenu($);
    animationWow($);
    animationWowAppear($);
    cookies($);
    popover($);
    googleMaps($);
    scroll($);
    dropdowns($);
    momentjs($);
    googlemap($);
    publishingFilter($);
    navBar($);
    menuSearch($);
    sortOptions($);
    searchMobile($);
    refreshPage($);
    homeStopCarouselOnMobile($);
    homeCarouselSwipe($);
    publishingFilterMobile($);
});

var lgScreenMin = 1200;

var mdScreenMax = lgScreenMin - 1;
var mdScreenMin = 992;

var smScreenMax = mdScreenMin - 1;
var smScreenMin = 768;

var xsScreenMax = smScreenMin - 1;
var xsScreenMin = 480;