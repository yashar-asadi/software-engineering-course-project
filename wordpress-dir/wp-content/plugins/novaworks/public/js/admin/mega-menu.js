var novamm = novamm || {};

(function ( $, _ ) {
	'use strict';

	var wp = window.wp;

	novamm = {
		init: function () {
			this.$body = $( document.body );
			this.$modal = $( '#novamm-mega-menu' );
			this.itemData = {};
			this.templates = {};

			this.frame = wp.media( {
				library: {
					type: 'image'
				}
			} );

			this.initTemplates();
			this.initActions();
		},

		initTemplates: function () {
			_.each( novaMenuModal, function ( name ) {
				novamm.templates[name] = wp.template( 'novamm-' + name );
			} );
		},

		initActions: function () {
			novamm.$body
				.on( 'click', '.opensettings', this.openModal )
				.on( 'click', '.novamm-modal-backdrop, .novamm-modal-close, .novamm-button-cancel', this.closeModal );

			novamm.$modal
				.on( 'click', '.novamm-menu a', this.switchPanel )
				.on( 'change', '.novamm-mega-width-field select', this.toggleWidthField )
				.on( 'click', '.novamm-column-handle', this.resizeMegaColumn )
				.on( 'click', '.novamm-button-save', this.saveChanges );
		},

		openModal: function ( event ) {
			event.preventDefault();

			novamm.getItemData( this );

			novamm.$modal.show();
			novamm.$body.addClass( 'modal-open' );
			novamm.render();

			return false;
		},

		closeModal: function () {
			novamm.$modal.hide().find( '.novamm-content' ).html( '' );
			novamm.$body.removeClass( 'modal-open' );
			return false;
		},

		switchPanel: function ( e ) {
			e.preventDefault();

			var $el = $( this ),
				panel = $el.data( 'panel' );

			$el.addClass( 'active' ).siblings( '.active' ).removeClass( 'active' );
			novamm.openSettings( panel );
		},

		render: function () {
			// Render menu
			novamm.$modal.find( '.novamm-frame-menu .novamm-menu' ).html( novamm.templates.menu( novamm.itemData ) );

			var $activeMenu = novamm.$modal.find( '.novamm-menu a.active' );

			// Render content
			this.openSettings( $activeMenu.data( 'panel' ) );
		},

		openSettings: function ( panel ) {
			var $content = novamm.$modal.find( '.novamm-frame-content .novamm-content' ),
				$panel = $content.children( '#novamm-panel-' + panel );

			if ( $panel.length ) {
				$panel.addClass( 'active' ).siblings().removeClass( 'active' );
			} else {
				$content.append( novamm.templates[panel]( novamm.itemData ) );
				$content.children( '#novamm-panel-' + panel ).addClass( 'active' ).siblings().removeClass( 'active' );

				if ( 'mega' === panel ) {
					novamm.initMegaColumns();
				}
				if ( 'design' === panel ) {
					novamm.initDesignFields();
				}
				if ( 'settings' === panel ) {
					novamm.initSettingsFields();
				}
				if ( 'icon' === panel ) {
					novamm.initIconFields();
				}
			}

			// Render title
			var title = novamm.$modal.find( '.novamm-frame-menu .novamm-menu a[data-panel=' + panel + ']' ).data( 'title' );
			novamm.$modal.find( '.novamm-frame-title' ).html( novamm.templates.title( {title: title} ) );
		},

		toggleWidthField: function() {
			if ( 'custom' === $( this ).val() ) {
				$( this ).closest( '.setting-field' ).next( '.setting-field' ).show();
			} else {
				$( this ).closest( '.setting-field' ).next( '.setting-field' ).hide();
			}
		},

		resizeMegaColumn: function ( e ) {
			e.preventDefault();

			var $el = $( e.currentTarget ),
				$column = $el.closest( '.novamm-submenu-column' ),
				currentWidth = $column.data( 'width' ),
				widthData = novamm.getWidthData( currentWidth ),
				nextWidth;

			if ( ! widthData ) {
				return;
			}

			if ( $el.hasClass( 'novamm-resizable-w' ) ) {
				nextWidth = widthData.increase ? widthData.increase : widthData;
			} else {
				nextWidth = widthData.decrease ? widthData.decrease : widthData;
			}

			$column[0].style.width = nextWidth.width;
			$column.data( 'width', nextWidth.width );
			$column.find( '.novamm-column-width-label' ).text( nextWidth.label );
			$column.find( '.menu-item-depth-0 .menu-item-width' ).val( nextWidth.width );
		},

		getWidthData: function( width ) {
			var steps = [
				{width: '12.50%', label: '1/8'},
				{width: '20.00%', label: '1/5'},
				{width: '25.00%', label: '1/4'},
				{width: '33.33%', label: '1/3'},
				{width: '37.50%', label: '3/8'},
				{width: '50.00%', label: '1/2'},
				{width: '62.50%', label: '5/8'},
				{width: '66.66%', label: '2/3'},
				{width: '75.00%', label: '3/4'},
				{width: '87.50%', label: '7/8'},
				{width: '100.00%', label: '1/1'}
			];

			var index = _.findIndex( steps, function( data ) { return data.width === width; } );

			if ( index === 'undefined' ) {
				return false;
			}

			var data = {
				index: index,
				width: steps[index].width,
				label: steps[index].label
			};

			if ( index > 0 ) {
				data.decrease = {
					index: index - 1,
					width: steps[index - 1].width,
					label: steps[index - 1].label
				};
			}

			if ( index < steps.length - 1 ) {
				data.increase = {
					index: index + 1,
					width: steps[index + 1].width,
					label: steps[index + 1].label
				};
			}

			return data;
		},

		initMegaColumns: function () {
			var $columns = novamm.$modal.find( '#novamm-panel-mega .novamm-submenu-column' ),
				defaultWidth = '20.00%';

			if ( !$columns.length ) {
				return;
			}

			// Support maximum 5 columns
			if ( $columns.length <= 5 ) {
				defaultWidth = String( ( 100 / $columns.length ).toFixed( 2 ) ) + '%';
			}

			_.each( $columns, function ( column ) {
				var width = column.dataset.width;

				if ( ! parseInt( width ) ) {
					width = defaultWidth;
				}

				var widthData = novamm.getWidthData( width );

				column.style.width = widthData.width;
				column.dataset.width = widthData.width;
				$( column ).find( '.menu-item-depth-0 .menu-item-width' ).val( width );
				$( column ).find( '.novamm-column-width-label' ).text( widthData.label );
			} );
		},

		initDesignFields: function () {
			novamm.$modal.find( '.background-color-picker' ).wpColorPicker();

			// Background image
			novamm.$modal.on( 'click', '.background-image .upload-button', function ( e ) {
				e.preventDefault();

				var $el = $( this );

				// Remove all attached 'select' event
				novamm.frame.off( 'select' );

				// Update inputs when select image
				novamm.frame.on( 'select', function () {
					// Update input value for single image selection
					var url = novamm.frame.state().get( 'selection' ).first().toJSON().url;

					$el.siblings( '.background-image-preview' ).addClass( 'has-image' ).html( '<img src="' + url + '">' );
					$el.siblings( 'input' ).val( url );
					$el.siblings( '.remove-button' ).removeClass( 'hidden' );
				} );

				novamm.frame.open();
			} ).on( 'click', '.background-image .remove-button', function ( e ) {
				e.preventDefault();

				var $el = $( this );

				$el.siblings( '.background-image-preview' ).removeClass( 'has-image' ).html( '' );
				$el.siblings( 'input' ).val( '' );
				$el.addClass( 'hidden' );
			} );

			// Background position
			novamm.$modal.on( 'change', '.background-position select', function () {
				var $el = $( this );

				if ( 'custom' === $el.val() ) {
					$el.next( 'input' ).removeClass( 'hidden' );
				} else {
					$el.next( 'input' ).addClass( 'hidden' );
				}
			} );
		},

		initSettingsFields: function() {
			novamm.$modal.on( 'change', '.item-visible-fields input', function () {
				var $row = $( this ).closest( '.item-visible-fields' ),
					val = $row.find( 'input:checked' ).val();

				if ( 'visible' === val ) {
					$row.next( '.item-link-field' ).show();
				} else {
					$row.next( '.item-link-field' ).hide();
				}
			} );
		},

		initIconFields: function () {
			var $input = novamm.$modal.find( '#novamm-icon-input' ),
				$preview = novamm.$modal.find( '#novamm-selected-icon' ),
				$icons = novamm.$modal.find( '.novamm-icon-selector .icons i' );

			novamm.$modal.on( 'click', '.novamm-icon-selector .icons i', function () {
				var $el = $( this ),
					icon = $el.data( 'icon' );

				$el.addClass( 'active' ).siblings( '.active' ).removeClass( 'active' );

				$input.val( icon );
				$preview.html( '<i class="' + icon + '"></i>' );
			} );

			$preview.on( 'click', 'i', function () {
				$( this ).remove();
				$input.val( '' );
			} );

			novamm.$modal.on( 'keyup', '.novamm-icon-search', function () {
				var term = $( this ).val().toUpperCase();

				if ( !term ) {
					$icons.show();
				} else {
					$icons.hide().filter( function () {
						return $( this ).data( 'icon' ).toUpperCase().indexOf( term ) > -1;
					} ).show();
				}
			} );
		},

		getItemData: function ( menuItem ) {
			var $menuItem = $( menuItem ).closest( 'li.menu-item' ),
				$menuData = $menuItem.find( '.mega-data' ),
				children = $menuItem.childMenuItems(),
				megaData = $menuData.data( 'mega' );

			megaData.content = $menuData.html();

			novamm.itemData = {
				depth   : $menuItem.menuItemDepth(),
				megaData: megaData,
				data    : $menuItem.getItemData(),
				children: [],
				element : $menuItem.get( 0 )
			};

			if ( !_.isEmpty( children ) ) {
				_.each( children, function ( item ) {
					var $item = $( item ),
						$itemData = $item.find( '.mega-data' ),
						depth = $item.menuItemDepth(),
						megaData = $itemData.data( 'mega' );

					megaData.content = $itemData.html();

					novamm.itemData.children.push( {
						depth   : depth,
						subDepth: depth - novamm.itemData.depth - 1,
						data    : $item.getItemData(),
						megaData: megaData,
						element : item
					} );
				} );
			}
		},

		setItemData: function ( item, data ) {
			var $dataHolder = $( item ).find( '.mega-data' );

			if ( _.has( data, 'content' ) ) {
				$dataHolder.html( data.content );
				delete data.content;
			}

			$dataHolder.data( 'mega', data );
		},

		getFieldName: function ( name, id ) {
			name = name.split( '.' );
			name = '[' + name.join( '][' ) + ']';

			return 'menu-item-mega[' + id + ']' + name;
		},

		saveChanges: function () {
			var $inputs = novamm.$modal.find( '.novamm-content :input' ),
				$spinner = novamm.$modal.find( '.novamm-toolbar .spinner' );

			$inputs.each( function() {
				var $input = $( this );

				if ( $input.is( ':checkbox' ) && $input.is( ':not(:checked)' ) ) {
					$input.attr( 'value', '0' ).prop( 'checked', true );
				}
			} );

			var data = $inputs.serialize();

			$inputs.filter( '[value="0"]' ).prop( 'checked', false );

			$spinner.addClass( 'is-active' );
			$.post( ajaxurl, {
				action: 'nova_addons_save_menu_item_data',
				data  : data
			}, function ( res ) {
				if ( !res.success ) {
					return;
				}

				var data = res.data['menu-item-mega'];

				// Update parent menu item
				if ( _.has( data, novamm.itemData.data['menu-item-db-id'] ) ) {
					novamm.setItemData( novamm.itemData.element, data[novamm.itemData.data['menu-item-db-id']] );
				}

				_.each( novamm.itemData.children, function ( menuItem ) {
					if ( !_.has( data, menuItem.data['menu-item-db-id'] ) ) {
						return;
					}

					novamm.setItemData( menuItem.element, data[menuItem.data['menu-item-db-id']] );
				} );

				$spinner.removeClass( 'is-active' );
				novamm.closeModal();
			} );
		}
	};

	$( function () {
		novamm.init();
	} );
})( jQuery, _ );
