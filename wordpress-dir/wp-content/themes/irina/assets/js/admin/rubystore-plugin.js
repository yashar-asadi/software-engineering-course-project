(function($) {

	"use strict";

	/*
	 *   Get hidden field values
	 *---------------------------------------------------*/
	function get_responsive_values_in_input(t) {
		var mv = t.find('.nova-responsive-value').val(),
			counter = 0;
		if (mv != "") {
			var vals = mv.split(";");
			$.each(vals, function(i, vl) {
				if (vl != "") {
					t.find('.nova-responsive-input').each(function() {
						var that        = $(this),
							splitval    = vl.split(":");
						if( that.attr('data-id') == splitval[0] ) {
							var mval = splitval[1].split( that.attr('data-unit') );
							that.val(mval[0]);
							counter++;
						}
					})
				}
			});

			if(counter>1) {
				t.find('.simplify').attr('nova-toggle', 'expand');
				t.find('.nova-responsive-item.optional, .nova-unit-section').show();
			}
			else {
				t.find('.simplify').attr('nova-toggle', 'collapse');
				t.find('.nova-responsive-item.optional, .nova-unit-section').hide();
			}
		}
		else {
			var i=0;      // set default - Values
			t.find(".nova-responsive-input").each(function() {
				var that = $(this),
					d    = that.attr('data-default');
				if(d!=''){
					that.val(d);
					i++;
				}
			});
			if(i<=1) {    // set default - Collapse
				t.find('.simplify').attr('nova-toggle', 'collapse');
				t.find('.nova-responsive-item.optional, .nova-unit-section').hide();
			}
		}
	}
	/*
	 *   Set hidden field values
	 *---------------------------------------------------*/
	function set_responsive_values_in_hidden(t) {
		var new_val = '';
		t.find('.nova-responsive-input').each(function() {
			var that    =   $(this),
				unit    =   that.attr('data-unit'),
				ival    =   that.val();
			if ($.isNumeric(ival)) {
				new_val += that.attr('data-id') + ':' + ival + unit + ';';
			}
		});
		t.find('.nova-responsive-value').val(new_val);
	}

	$(function(){


		$(document)
			.on('vc_param.la_columns', '.nova-responsive-wrapper',  function(e){
				get_responsive_values_in_input($(this));
				set_responsive_values_in_hidden($(this));
			})
			.on('click', '.simplify', function(e){
				var $this   = $(this).closest('.nova-responsive-wrapper'),
					status  = $(this).attr('nova-toggle');
				switch(status) {
					case 'expand':
						$this.find('.simplify').attr('nova-toggle', 'collapse');
						$this.find('.nova-responsive-item.optional, .nova-unit-section').hide();
						break;
					case 'collapse':
						$this.find('.simplify').attr('nova-toggle', 'expand');
						$this.find('.nova-responsive-item.optional, .nova-unit-section').show();
						break;
					default:
						$this.find('.simplify').attr('nova-toggle', 'collapse');
						$this.find('.nova-responsive-item.optional, .nova-unit-section').hide();
						break;
				}
			})
			/* On change - input / select */
			.on('change', '.nova-responsive-input', function(e){
				set_responsive_values_in_hidden($(this).closest('.nova-responsive-wrapper'));
			});

		$('.nova-responsive-wrapper').trigger('vc_param.la_columns');

		$(document).on('click', '.nova-field-fieldset.nova-fieldset-toggle > .nova-title', function() {
			$(this).toggleClass('active');
		});

		$(document).on('click', '[data-trace*="#trace-"] li', function(e){
			e.preventDefault();
			var $li = $(this);
			$li.addClass('selected').siblings().removeClass('selected');
			$( $li.closest('[data-trace]').attr('data-trace') ).val( $li.attr('data-ac-icon') );
		})
	})

}(jQuery));
