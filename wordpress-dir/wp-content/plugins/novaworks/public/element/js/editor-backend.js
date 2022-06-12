( function( $ ) {

    'use strict';

    $(window).on('load', function () {

        var _html = '';
        _html += '<div class="elementor-panel-footer-sub-menu-item" data-device-mode="laptop"><i class="elementor-icon eicon-device-laptop" aria-hidden="true"></i><span class="elementor-title">'+ LaCustomBPFE.laptop.name +'</span><span class="elementor-description">'+LaCustomBPFE.laptop.text+'</span></div>';
        try{
            $('body').addClass('is-localhost');
            _html += '<div class="elementor-panel-footer-sub-menu-item" data-device-mode="laptop1"><i class="elementor-icon eicon-device-laptop" aria-hidden="true"></i><span class="elementor-title">'+ LaCustomBPFE.laptop1.name +'</span><span class="elementor-description">'+LaCustomBPFE.laptop1.text+'</span></div>';
            _html += '<div class="elementor-panel-footer-sub-menu-item" data-device-mode="laptop2"><i class="elementor-icon eicon-device-laptop" aria-hidden="true"></i><span class="elementor-title">'+ LaCustomBPFE.laptop2.name +'</span><span class="elementor-description">'+LaCustomBPFE.laptop2.text+'</span></div>';
        }
        catch (e) {}
        _html += '<div class="elementor-panel-footer-sub-menu-item" data-device-mode="tablet"><i class="elementor-icon eicon-device-tablet" aria-hidden="true"></i><span class="elementor-title">'+LaCustomBPFE.tablet.name+'</span><span class="elementor-description">'+LaCustomBPFE.tablet.text+'</span></div>';
        _html += '<div class="elementor-panel-footer-sub-menu-item" data-device-mode="tabletportrait"><i class="elementor-icon eicon-device-tabletportrait" aria-hidden="true"></i><span class="elementor-title">'+LaCustomBPFE.tabletportrait.name+'</span><span class="elementor-description">'+LaCustomBPFE.tabletportrait.text+'</span></div>';

        $('#elementor-panel-footer-responsive .elementor-panel-footer-sub-menu-wrapper .elementor-panel-footer-sub-menu-item[data-device-mode="tablet"]').replaceWith(_html);

    });

    $(document).on('Novaworks/Elementor/TemplateLibraryActiveTab', function (e, data) {
        if(data == 'templates/novaworks'){
            $('#elementor-template-library-templates').html('hello !!!');
        }
    });

    var NovaworksElementEditor = {

        activeSection: null,

        editedElement: null,

        init: function() {
            elementor.channels.editor.on( 'section:activated', NovaworksElementEditor.onAnimatedBoxSectionActivated );

            window.elementor.on( 'preview:loaded', function() {
                elementor.$preview[0].contentWindow.NovaworksElementEditor = NovaworksElementEditor;

                NovaworksElementEditor.onPreviewLoaded();
            });

            if(typeof window.elementorPro === "undefined"){
                elementor.hooks.addFilter('editor/style/styleText', NovaworksElementEditor.addCustomCss);
                // elementor.settings.page.model.on('change', NovaworksElementEditor.addPageCustomCss);
                // elementor.on('preview:loaded', NovaworksElementEditor.addPageCustomCss);
            }
            NovaworksElementEditor.onFixPreview();
        },

        onFixPreview: function (){
            if(elementor.getPreferences('novaworks_fix_small_browser') == 'yes'){
                $('body').addClass('fix-small-browser');
            }
            else{
                $('body').removeClass('fix-small-browser');
            }
            elementor.settings.editorPreferences.addChangeCallback('novaworks_fix_small_browser', function(val){
                if(val == 'yes'){
                    $('body').addClass('fix-small-browser');
                }
                else{
                    $('body').removeClass('fix-small-browser');
                }
            });
        },

        onAnimatedBoxSectionActivated: function( sectionName, editor ) {
            var editedElement = editor.getOption( 'editedElementView' ),
                prevEditedElement = window.NovaworksElementEditor.editedElement;

            if ( prevEditedElement && 'novaworks-animated-box' === prevEditedElement.model.get( 'widgetType' ) ) {

                prevEditedElement.$el.find( '.novaworks-animated-box' ).removeClass( 'flipped' );
                prevEditedElement.$el.find( '.novaworks-animated-box' ).removeClass( 'flipped-stop' );

                window.NovaworksElementEditor.editedElement = null;
            }

            if ( 'novaworks-animated-box' !== editedElement.model.get( 'widgetType' ) ) {
                return;
            }

            window.NovaworksElementEditor.editedElement = editedElement;
            window.NovaworksElementEditor.activeSection = sectionName;

            var isBackSide = -1 !== [ 'section_back_content', 'section_action_button_style' ].indexOf( sectionName );

            if ( isBackSide ) {
                editedElement.$el.find( '.novaworks-animated-box' ).addClass( 'flipped' );
                editedElement.$el.find( '.novaworks-animated-box' ).addClass( 'flipped-stop' );
            } else {
                editedElement.$el.find( '.novaworks-animated-box' ).removeClass( 'flipped' );
                editedElement.$el.find( '.novaworks-animated-box' ).removeClass( 'flipped-stop' );
            }
        },

        onPreviewLoaded: function() {
            var elementorFrontend = $('#elementor-preview-iframe')[0].contentWindow.elementorFrontend;

            elementorFrontend.hooks.addAction( 'frontend/element_ready/novaworks-dropbar.default', function( $scope ){
                $scope.find( '.novaworks-dropbar-edit-link' ).on( 'click', function( event ) {
                    window.open( $( this ).attr( 'href' ) );
                } );
            } );

            function makeImageAsLoaded( element ){
                var base_src = element.getAttribute('data-src') || element.getAttribute('data-lazy') || element.getAttribute('data-lazy-src') || element.getAttribute('data-lazy-original'),
                    base_srcset = element.getAttribute('data-src') || element.getAttribute('data-lazy-srcset'),
                    base_sizes = element.getAttribute('data-sizes') || element.getAttribute('data-lazy-sizes');

                if(element.getAttribute('datanolazy') == 'true'){
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
                if (element.getAttribute('data-background-image')) {
                    element.style.backgroundImage = 'url("' + element.getAttribute('data-background-image') + '")';
                }
                element.setAttribute('data-element-loaded', true);
                if($(element).hasClass('jetpack-lazy-image')){
                    $(element).addClass('jetpack-lazy-image--handled');
                }
            }

            elementorFrontend.hooks.addAction( 'frontend/element_ready/widget', function( $scope ) {
                $('.nova-lazyload-image', $scope).each(function () {
                    makeImageAsLoaded(this);
                });
            } );
        },

        addPageCustomCss: function () {
            var customCSS = elementor.settings.page.model.get('custom_css');

            if (customCSS) {
                customCSS = customCSS.replace(/selector/g, '.elementor-page-' + elementor.config.document.id);
                elementor.settings.page.getControlsCSS().elements.$stylesheetElement.append(customCSS);
            }
        },

        addCustomCss: function (css, context) {

            if (!context) {
                return;
            }

            var model = context.model,
                customCSS = model.get('settings').get('custom_css');
            var selector = '.elementor-element.elementor-element-' + model.get('id');

            if ('document' === model.get('elType')) {
                selector = elementor.config.document.settings.cssWrapperSelector;
            }

            if (customCSS) {
                css += customCSS.replace(/selector/g, selector);
            }

            return css;
        }
    };

    $( window ).on( 'elementor:init', NovaworksElementEditor.init );

    window.NovaworksElementEditor = NovaworksElementEditor;

}( jQuery ) );


( function( $ ) {

    $( window ).on( 'load', function() {

        draggablePanel(); // load function draggable panel

        loadFepSettings(); // load the setting FEP and action function

        $('#elementor-vertical-mode-switcher-preview-input').on('click', function(e) {
            $('#elementor-panel').toggleClass('active');
        });

        $('#elementor-mode-switcher').click(function() {
            $('#elementor-panel').css('left', '').removeClass('active');
            $('#elementor-vertical-mode-switcher-preview-input').prop('checked', false);
        });

        $('#elementor-panel-header-menu-button, #elementor-panel-header-add-button').on('click', function (e) {
            $('#elementor-panel').removeClass('active');
            $('#elementor-vertical-mode-switcher-preview-input').prop('checked', false);
        });
    });

    function draggablePanel() {
        $("#elementor-panel").draggable({
            snap: "#elementor-preview",
            opacity: 0.9,
            cancel: ".not-draggable",
            addClasses: false,
            containment: "window",
            snapMode: "inner",
            snapTolerance: 25,
            start: function () {

            },
            stop: function (event, ui) {
                if(ui.position.left == 0){
                    $('#elementor-preview').css('left', '');
                }
                else{
                    $('#elementor-preview').css('left', '0');
                }
            }
        });
    }
    function loadFepSettings() {
        if ( !$( "#novaworks-elementor-collapse-vertical-panel" ).hasClass( "novaworks-elementor-collapse-vertical-panell-wrapper" ) ) {
            $("#elementor-panel-header #elementor-panel-header-menu-button").after('<div id="novaworks-elementor-collapse-vertical-panel" class="novaworks-elementor-collapse-vertical-panel-wrapper"><input type="checkbox" id="elementor-vertical-mode-switcher-preview-input"><i class="dlicon arrows-1_minimal-down"></i></div>');
        }
        $("#elementor-panel" ).draggable( "enable" );
        $('#elementor-panel-footer,#elementor-panel-content-wrapper').addClass('not-draggable');
    }

} )( jQuery );

(function( $ ) {

    'use strict';

    var NovaworksTabsEditor = {

        modal: false,

        init: function() {
            window.elementor.on( 'preview:loaded', NovaworksTabsEditor.onPreviewLoaded );
        },

        onPreviewLoaded: function() {
            var $previewContents = window.elementor.$previewContents,
                elementorFrontend = $('#elementor-preview-iframe')[0].contentWindow.elementorFrontend;

            elementorFrontend.hooks.addAction( 'frontend/element_ready/novaworks-tabs.default', function( $scope ){
                $scope.find( '.novaworks-tabs__edit-cover' ).on( 'click', NovaworksTabsEditor.showTemplatesModal );
                $scope.find( '.novaworks-tabs-new-template-link' ).on( 'click', function( event ) {
                    window.location.href = $( this ).attr( 'href' );
                } );
            } );

            elementorFrontend.hooks.addAction( 'frontend/element_ready/novaworks-accordion.default', function( $scope ){
                $scope.find( '.novaworks-toggle__edit-cover' ).on( 'click', NovaworksTabsEditor.showTemplatesModal );
                $scope.find( '.novaworks-toogle-new-template-link' ).on( 'click', function( event ) {
                    window.location.href = $( this ).attr( 'href' );
                } );
            } );

            elementorFrontend.hooks.addAction( 'frontend/element_ready/novaworks-switcher.default', function( $scope ){
                $scope.find( '.novaworks-switcher__edit-cover' ).on( 'click', NovaworksTabsEditor.showTemplatesModal );
                $scope.find( '.novaworks-switcher-new-template-link' ).on( 'click', function( event ) {
                    window.location.href = $( this ).attr( 'href' );
                } );
            } );

            NovaworksTabsEditor.getModal().on( 'hide', function() {
                window.elementor.reloadPreview();
            });
        },

        showTemplatesModal: function() {
            var editLink = $( this ).data( 'template-edit-link' );

            NovaworksTabsEditor.showModal( editLink );
        },

        showModal: function( link ) {
            var $iframe,
                $loader;

            NovaworksTabsEditor.getModal().show();

            $( '#novaworks-tabs-template-edit-modal .dialog-message').html( '<iframe src="' + link + '" id="novaworks-tabs-edit-frame" width="100%" height="100%"></iframe>' );
            $( '#novaworks-tabs-template-edit-modal .dialog-message').append( '<div id="novaworks-tabs-loading"><div class="elementor-loader-wrapper"><div class="elementor-loader"><div class="elementor-loader-boxes"><div class="elementor-loader-box"></div><div class="elementor-loader-box"></div><div class="elementor-loader-box"></div><div class="elementor-loader-box"></div></div></div><div class="elementor-loading-title">Loading</div></div></div>' );

            $iframe = $( '#novaworks-tabs-edit-frame');
            $loader = $( '#novaworks-tabs-loading');

            $iframe.on( 'load', function() {
                $loader.fadeOut( 300 );
            } );
        },

        getModal: function() {

            if ( ! NovaworksTabsEditor.modal ) {
                this.modal = elementor.dialogsManager.createWidget( 'lightbox', {
                    id: 'novaworks-tabs-template-edit-modal',
                    closeButton: true,
                    hide: {
                        onBackgroundClick: false
                    }
                } );
            }

            return NovaworksTabsEditor.modal;
        }

    };

    $( window ).on( 'elementor:init', NovaworksTabsEditor.init );

})( jQuery );

(function( $ ) {

    'use strict';


    var NovaworksQueryControl = {

        modal: false,

        init: function() {
            window.elementor.on( 'preview:loaded', NovaworksQueryControl.onPreviewLoaded );
        },

        onPreviewLoaded: function() {
            window.elementor.addControlView('novaworks_query', window.elementor.modules.controls.Select2.extend({

                cache: null,

                isTitlesReceived: false,

                getSelect2Placeholder: function getSelect2Placeholder() {
                    return {
                        id: '',
                        text: elementor.translate('All')
                    };
                },

                getSelect2DefaultOptions: function getSelect2DefaultOptions() {
                    var self = this;

                    return jQuery.extend(elementor.modules.controls.Select2.prototype.getSelect2DefaultOptions.apply(this, arguments), {
                        ajax: {
                            transport: function transport(params, success, failure) {
                                var data = {
                                    q: params.data.q,
                                    filter_type: self.model.get('filter_type'),
                                    object_type: self.model.get('object_type'),
                                    include_type: self.model.get('include_type'),
                                    query: self.model.get('query')
                                };

                                return elementor.ajax.addRequest('novaworks_panel_posts_control_filter_autocomplete', {
                                    data: data,
                                    success: success,
                                    error: failure
                                });
                            },
                            data: function data(params) {
                                return {
                                    q: params.term,
                                    page: params.page
                                };
                            },
                            cache: true
                        },
                        escapeMarkup: function escapeMarkup(markup) {
                            return markup;
                        },
                        minimumInputLength: 1
                    });
                },

                getValueTitles: function getValueTitles() {
                    var self = this,
                        ids = this.getControlValue(),
                        filterType = this.model.get('filter_type');

                    if (!ids || !filterType) {
                        return;
                    }

                    if (!_.isArray(ids)) {
                        ids = [ids];
                    }

                    elementorCommon.ajax.loadObjects({
                        action: 'novaworks_query_control_value_titles',
                        ids: ids,
                        data: {
                            filter_type: filterType,
                            object_type: self.model.get('object_type'),
                            include_type: self.model.get('include_type'),
                            unique_id: '' + self.cid + filterType
                        },
                        before: function before() {
                            self.addControlSpinner();
                        },
                        success: function success(data) {
                            self.isTitlesReceived = true;

                            self.model.set('options', data);

                            self.render();
                        }
                    });

                    var self = this,
                        ids = this.getControlValue(),
                        filterType = this.model.get('filter_type');

                    if (!ids || !filterType) {
                        return;
                    }

                    if (!_.isArray(ids)) {
                        ids = [ids];
                    }
                },

                addControlSpinner: function addControlSpinner() {
                    this.ui.select.prop('disabled', true);
                    this.$el.find('.elementor-control-title').after('<span class="elementor-control-spinner">&nbsp;<i class="fa fa-spinner fa-spin"></i>&nbsp;</span>');
                },

                onReady: function onReady() {
                    // Safari takes it's time to get the original select width
                    setTimeout(elementor.modules.controls.Select2.prototype.onReady.bind(this));

                    if (!this.isTitlesReceived) {
                        this.getValueTitles();
                    }
                }
            }));
        }

    };

    $( window ).on( 'elementor:init', NovaworksQueryControl.init );

})( jQuery );
