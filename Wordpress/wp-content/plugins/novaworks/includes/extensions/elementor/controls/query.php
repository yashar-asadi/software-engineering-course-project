<?php
namespace Novaworks_Element\Controls;

if (!defined('WPINC')) {
    die;
}

use Elementor\Control_Select2;

class Query extends Control_Select2 {

	public function get_type() {
		return 'novaworks_query';
	}

	/**
	 * 'query' can be used for passing query args in the structure and format used by WP_Query.
	 * @return array
	 */
	protected function get_default_settings() {
		return array_merge(
			parent::get_default_settings(), [
				'query' => '',
			]
		);
	}
}