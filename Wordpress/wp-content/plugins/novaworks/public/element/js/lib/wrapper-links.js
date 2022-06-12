;(function( $ ) {
    var $window = $(window);

    $window.on('elementor/frontend/init', function() {
        $('body').on('click.onWrapperLink', '[data-la-element-link]', function() {
            var $wrapper = $(this),
                data     = $wrapper.data('la-element-link'),
                id       = $wrapper.data('id'),
                anchor   = document.createElement('a'),
                anchorReal;

            anchor.id            = 'lastudio-wrapper-link-' + id;
            anchor.href          = data.url;
            anchor.target        = data.is_external ? '_blank' : '_self';
            anchor.rel           = data.nofollow ? 'nofollow noreferer' : '';
            anchor.style.display = 'none';

            document.body.appendChild(anchor);

            anchorReal = document.getElementById(anchor.id);
            anchorReal.click();
            anchorReal.remove();
        });
    });

}( jQuery ));
