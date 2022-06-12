(function ($, elementor) {

    "use strict";

    window.NovaworksElementTools ={

        debounce: function (threshold, callback) {
            var timeout;

            return function debounced($event) {
                function delayed() {
                    callback.call(this, $event);
                    timeout = null;
                }

                if (timeout) {
                    clearTimeout(timeout);
                }

                timeout = setTimeout(delayed, threshold);
            };
        },

        getObjectNextKey: function (object, key) {
            var keys = Object.keys(object),
                idIndex = keys.indexOf(key),
                nextIndex = idIndex += 1;

            if (nextIndex >= keys.length) {
                //we're at the end, there is no next
                return false;
            }

            var nextKey = keys[nextIndex];

            return nextKey;
        },

        getObjectPrevKey: function (object, key) {
            var keys = Object.keys(object),
                idIndex = keys.indexOf(key),
                prevIndex = idIndex -= 1;

            if (0 > idIndex) {
                //we're at the end, there is no next
                return false;
            }

            var prevKey = keys[prevIndex];

            return prevKey;
        },

        getObjectFirstKey: function (object) {
            return Object.keys(object)[0];
        },

        getObjectLastKey: function (object) {
            return Object.keys(object)[Object.keys(object).length - 1];
        },

        validateEmail: function (email) {
            var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

            return re.test(email);
        },

        makeImageAsLoaded: function (element) {
            var base_src = element.getAttribute('data-src') || element.getAttribute('data-lazy') || element.getAttribute('data-lazy-src') || element.getAttribute('data-lazy-original'),
                base_srcset = element.getAttribute('data-src') || element.getAttribute('data-lazy-srcset'),
                base_sizes = element.getAttribute('data-sizes') || element.getAttribute('data-lazy-sizes');

            if (element.getAttribute('data-lanolazy') == 'true') {
                base_src = base_srcset = base_sizes = '';
            }

            if (base_src) {
                element.src = base_src;
            }
            if (base_srcset) {
                element.srcset = base_srcset;
            }
            if (base_sizes) {
                element.sizes = base_sizes;
            }
            element.setAttribute('data-element-loaded', true);
            if ($(element).hasClass('jetpack-lazy-image')) {
                $(element).addClass('jetpack-lazy-image--handled');
            }
        },

        getCurrentDevice: function () {
            var device = 'desktop',
                _w_width = window.innerWidth;
            if (_w_width > 1700) {
                device = 'desktop';
            }
            else if (_w_width > 1280) {
                device = 'laptop';
            }
            else if (_w_width > 800) {
                device = 'tablet';
            }
            else if (_w_width > 786) {
                device = 'tablet';
            }
            else {
                device = 'mobile';
            }
            return device;
        }
    };

    $(window).on('elementor/frontend/init', function () {
      elementor.hooks.addAction('frontend/element_ready/widget', function ($scope) {
            try {
              if($('.slick-carousel').length > 0) {
                var slick_carousel = $('.slick-carousel');
                slick_carousel.each(function(){
                    nova_slick_slider($(this));
                });
                $(window).on('load', function () {
                    setTimeout(function () {
                        if($( ".slick-carousel" ).hasClass( "nova-slick-centerMode" )) {
                          $('.nova-lazyload-image', $('.slick-carousel')).each(function () {
                              NovaworksElementTools.makeImageAsLoaded(this);
                          });
                        }
                    }, 100)
                });
              }
            }
            catch (e) {
                console.log(e);
            }
        });
        elementor.hooks.addAction('frontend/element_ready/image-gallery.default', function ($scope) {
            $scope.find('br').remove();
        });

        elementor.hooks.addAction('frontend/element_ready/image-carousel.default', function ($scope) {
            var _id = $scope.attr('id') || false;
            if (_id && $('#' + _id + '_dots').length) {
                $scope.find('.elementor-image-carousel').slick('slickSetOption', 'appendDots', $('#' + _id + '_dots'), true);
            }
        }, 500);

        elementor.hooks.addAction('frontend/element_ready/novaworks-tabs.default', function ($scope) {
            var $target = $('.novaworks-tabs', $scope).first(),
                $controlWrapper = $('.novaworks-tabs__control-wrapper', $target).first(),
                $contentWrapper = $('.novaworks-tabs__content-wrapper', $target).first(),
                $controlList = $('> .novaworks-tabs__control', $controlWrapper),
                $contentList = $('> .novaworks-tabs__content', $contentWrapper),
                settings = $target.data('settings') || {},
                toogleEvents = 'mouseenter mouseleave',
                scrollOffset,
                autoSwitchInterval = null,
                curentHash = window.location.hash || false,
                tabsArray = curentHash ? curentHash.replace('#', '').split('&') : false;

            if ('click' === settings['event']) {
                addClickEvent();
            }
            else {
                addMouseEvent();
            }

            if (settings['autoSwitch']) {

                var startIndex = settings['activeIndex'],
                    currentIndex = startIndex,
                    controlListLength = $controlList.length;

                autoSwitchInterval = setInterval(function () {

                    if (currentIndex < controlListLength - 1) {
                        currentIndex++;
                    } else {
                        currentIndex = 0;
                    }

                    switchTab(currentIndex);

                }, +settings['autoSwitchDelay']);
            }

            $controlList.each(function () {
                $(this).attr('data-tab_name', $(this).text().toString().toLowerCase()
                    .replace(/\s+/g, '-')           // Replace spaces with -
                    .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
                    .replace(/\-\-+/g, '-')         // Replace multiple - with single -
                    .replace(/^-+/, '')             // Trim - from start of text
                    .replace(/-+$/, '') + '_' + $scope.attr('data-id'));
            });

            $(window).on('resize.NovaworksTabs orientationchange.NovaworksTabs', function () {
                $contentWrapper.css({'height': 'auto'});
            });

            $(window).on('hashchange', function () {
                var c_hash = window.location.hash.replace('#', '').toLowerCase()
                    .replace(/\s+/g, '-')           // Replace spaces with -
                    .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
                    .replace(/\-\-+/g, '-')         // Replace multiple - with single -
                    .replace(/^-+/, '')             // Trim - from start of text
                    .replace(/-+$/, '');
                if(c_hash !== ''){
                    var $c_item = $('.novaworks-tabs__control[data-tab_name="'+c_hash+'"]');
                    if($c_item.length){
                        var _href = window.location.href.replace(window.location.hash, '');
                        history.pushState(null,null,_href);
                        switchTab($c_item.data('tab') - 1);
                    }
                }
            });

            function addClickEvent() {
                $controlList.on('click.NovaworksTabs', function () {
                    var $this = $(this),
                        tabId = +$this.data('tab') - 1;

                    clearInterval(autoSwitchInterval);
                    switchTab(tabId);
                });
            }

            function addMouseEvent() {
                if ('ontouchend' in window || 'ontouchstart' in window) {
                    $controlList.on('touchstart', function (event) {
                        scrollOffset = $(window).scrollTop();
                    });

                    $controlList.on('touchend', function (event) {
                        var $this = $(this),
                            tabId = +$this.data('tab') - 1;

                        if (scrollOffset !== $(window).scrollTop()) {
                            return false;
                        }

                        clearInterval(autoSwitchInterval);
                        switchTab(tabId);
                    });

                } else {
                    $controlList.on('mouseenter', function (event) {
                        var $this = $(this),
                            tabId = +$this.data('tab') - 1;

                        clearInterval(autoSwitchInterval);
                        switchTab(tabId);
                    });
                }
            }

            function switchTab(curentIndex) {
                var $activeControl = $controlList.eq(curentIndex),
                    $activeContent = $contentList.eq(curentIndex),
                    activeContentHeight = 'auto',
                    timer;

                $contentWrapper.css({'height': $contentWrapper.outerHeight(true)});

                $controlList.removeClass('active-tab');
                $activeControl.addClass('active-tab');

                $('html,body').animate({
                    scrollTop: $target.offset().top - 130
                }, 300);

                $controlWrapper.removeClass('open');

                $contentList.removeClass('active-content');
                activeContentHeight = $activeContent.outerHeight(true);
                activeContentHeight += parseInt($contentWrapper.css('border-top-width')) + parseInt($contentWrapper.css('border-bottom-width'));
                $activeContent.addClass('active-content');

                $contentWrapper.css({'height': activeContentHeight});

                if($('.slick-slider', $activeContent).length > 0){
                    try{
                        $('.slick-slider', $activeContent).slick('setPosition');
                    }catch (e) {

                    }
                }

                if (timer) {
                    clearTimeout(timer);
                }
                timer = setTimeout(function () {
                    $contentWrapper.css({'height': 'auto'});

                }, 500);
            }

            // Hash Watch Handler
            if (tabsArray) {

                $controlList.each(function (index) {
                    var $this = $(this),
                        id = $this.attr('id'),
                        tabIndex = index;

                    tabsArray.forEach(function (itemHash, i) {
                        if (itemHash === id) {
                            switchTab(tabIndex);
                        }
                    });

                });
            }

            $target.on('click', '.novaworks-tabs__control-wrapper-mobile a', function (e) {
                e.preventDefault();

                if ('mobile' == NovaworksElementTools.getCurrentDevice()) {
                    if ($controlWrapper.hasClass('open')) {
                        $controlWrapper.removeClass('open');
                    }
                    else {
                        $controlWrapper.addClass('open');
                    }
                }

            })
        });

        elementor.hooks.addAction('frontend/element_ready/Novaworks-circle-progress.default', function ($scope) {

            var $progress = $scope.find('.circle-progress');

            if (!$progress.length) {
                return;
            }

            var $value = $progress.find('.circle-progress__value'),
                $meter = $progress.find('.circle-progress__meter'),
                percent = parseInt($value.data('value')),
                progress = percent / 100,
                duration = $scope.find('.circle-progress-wrap').data('duration'),
                responsiveSizes = $progress.data('responsive-sizes'),
                desktopSizes = responsiveSizes.desktop,
                tabletSizes = responsiveSizes.tablet,
                mobileSizes = responsiveSizes.mobile,
                currentDeviceMode = NovaworksElementTools.getCurrentDevice(),
                prevDeviceMode = currentDeviceMode,
                isAnimatedCircle = false;

            if ('tablet' === currentDeviceMode) {
                updateSvgSizes(tabletSizes.size, tabletSizes.viewBox, tabletSizes.center, tabletSizes.radius, tabletSizes.valStroke, tabletSizes.bgStroke, tabletSizes.circumference);
            }

            if ('mobile' === currentDeviceMode) {
                updateSvgSizes(mobileSizes.size, mobileSizes.viewBox, mobileSizes.center, mobileSizes.radius, mobileSizes.valStroke, mobileSizes.bgStroke, mobileSizes.circumference);
            }

            elementorFrontend.waypoint($scope, function () {

                // animate counter
                var $number = $scope.find('.circle-counter__number'),
                    data = $number.data();

                var decimalDigits = data.toValue.toString().match(/\.(.*)/);

                if (decimalDigits) {
                    data.rounding = decimalDigits[1].length;
                }

                data.duration = duration;

                $number.numerator(data);

                // animate progress
                var circumference = parseInt($progress.data('circumference')),
                    dashoffset = circumference * (1 - progress);

                $value.css({
                    'transitionDuration': duration + 'ms',
                    'strokeDashoffset': dashoffset
                });

                isAnimatedCircle = true;

            }, {
                offset: 'bottom-in-view'
            });

            $(window).on('resize.NovaworksCircleProgress orientationchange.NovaworksCircleProgress', circleResizeHandler);

            function circleResizeHandler(event) {
                currentDeviceMode = NovaworksElementTools.getCurrentDevice();

                if ('desktop' === currentDeviceMode && 'desktop' !== prevDeviceMode) {
                    updateSvgSizes(desktopSizes.size, desktopSizes.viewBox, desktopSizes.center, desktopSizes.radius, desktopSizes.valStroke, desktopSizes.bgStroke, desktopSizes.circumference);
                    prevDeviceMode = 'desktop';
                }

                if ('tablet' === currentDeviceMode && 'tablet' !== prevDeviceMode) {
                    updateSvgSizes(tabletSizes.size, tabletSizes.viewBox, tabletSizes.center, tabletSizes.radius, tabletSizes.valStroke, tabletSizes.bgStroke, tabletSizes.circumference);
                    prevDeviceMode = 'tablet';
                }

                if ('mobile' === currentDeviceMode && 'mobile' !== prevDeviceMode) {
                    updateSvgSizes(mobileSizes.size, mobileSizes.viewBox, mobileSizes.center, mobileSizes.radius, mobileSizes.valStroke, mobileSizes.bgStroke, mobileSizes.circumference);
                    prevDeviceMode = 'mobile';
                }
            }

            function updateSvgSizes(size, viewBox, center, radius, valStroke, bgStroke, circumference) {
                var dashoffset = circumference * (1 - progress);

                $progress.attr({
                    'width': size,
                    'height': size,
                    'data-radius': radius,
                    'data-circumference': circumference
                });

                $progress[0].setAttribute('viewBox', viewBox);

                $meter.attr({
                    'cx': center,
                    'cy': center,
                    'r': radius,
                    'stroke-width': bgStroke
                });

                if (isAnimatedCircle) {
                    $value.css({
                        'transitionDuration': ''
                    });
                }

                $value.attr({
                    'cx': center,
                    'cy': center,
                    'r': radius,
                    'stroke-width': valStroke
                });

                $value.css({
                    'strokeDasharray': circumference,
                    'strokeDashoffset': isAnimatedCircle ? dashoffset : circumference
                });
            }

        });

    });

}(jQuery, window.elementorFrontend));
