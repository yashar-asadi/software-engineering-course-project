(function ($, elementor) {

    "use strict";

    $(window).on('elementor/frontend/init', function () {
        elementor.hooks.addAction('frontend/element_ready/widget', function ($scope) {
            try {
                //Novaworks.core.initAll($scope);
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
    });

}(jQuery, window.elementorFrontend));
