<?php
namespace Novaworks_Element\Classes;

if (!defined('WPINC')) {
    die;
}

use Elementor\Modules\Library\Documents\Library_Document;

class Footer_Location extends Library_Document{
    /**
     * Get document properties.
     *
     * Retrieve the document properties.
     *
     * @since 1.0.0
     * @access public
     * @static
     *
     * @return array Document properties.
     */
    public static function get_properties() {
        $properties = parent::get_properties();
        $properties['group'] = 'blocks';

        return $properties;
    }

    /**
     * Get document name.
     *
     * Retrieve the document name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Document name.
     */
    public function get_name() {
        return 'footer';
    }

    /**
     * Get document title.
     *
     * Retrieve the document title.
     *
     * @since 1.0.0
     * @access public
     * @static
     *
     * @return string Document title.
     */
    public static function get_title() {
        return __( 'Footer', 'novaworks' );
    }
}