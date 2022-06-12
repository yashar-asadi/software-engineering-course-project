/* Go To Page */

(function($) {

	"use strict";

	var in_customizer = false;

    if ( typeof wp !== 'undefined' ) {
    	if ( typeof wp.customize !== 'undefined' ) {
        	in_customizer =  typeof wp.customize.section !== 'undefined' ? true : false;
        }
    }

    if ( in_customizer ) {

		wp.customize.panel( 'panel_shop', function( section ) {
	        go_to_page( section, 'shop' );
	    } );

	    wp.customize.section( 'blog', function( section ) {
	        go_to_page( section, 'blog' );
	    } );

	    wp.customize.section( 'blog_single', function( section ) {
	        go_to_page( section, 'blog_single' );
	    } );

	    wp.customize.section( 'product', function( section ) {
	        go_to_page( section, 'product' );
	    } );
	}

	function go_to_page( section, page ) {
	    	section.expanded.bind( function( isExpanded ) {
	            if ( isExpanded ) {
	            	var data = {
	            		'action' : 'get_url',
	            		'page'	 : page
	            	};

					jQuery.post( 'admin-ajax.php', data, function(response) {
						wp.customize.previewer.previewUrl.set(response);
					});		
	            }
	        } );
	    }

}(jQuery));