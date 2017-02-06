<?php

/**
 * Sticky content customizer section
 *
 * The sections, settings and controls for our sticky content
 * section in the customizer.
 *
 * @link            https://jentil.grotttopress.com
 * @package         jentil
 * @subpackage      jentil/includes
 * @since           Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup\Customizer\Content;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\Jentil\Setup;

/**
 * Sticky content customizer section
 *
 * The sections, settings and controls for our sticky content
 * section in the customizer.
 *
 * @link            https://jentil.grotttopress.com
 * @package         jentil
 * @subpackage      jentil/includes
 * @since           Jentil 0.1.0
 */
final class Sticky extends Content {
    /**
     * Constructor
     *
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function __construct( Setup\Customizer\Customizer $customizer ) {
        $this->name = 'sticky_content';
        $this->args = array(
            'title' => esc_html__( 'Sticky Content', 'jentil' ),
            //'priority' => 200,
        );

        parent::__construct( $customizer );
    }

    /**
     * Get settings
     *
     * @since       Jentil 0.1.0
     * @access      protected
     */
    protected function settings() {
        $this->default['number'] = 3;
        $this->default['wrap_class'] = 'sticky-posts big';
        $this->default['pagination_position'] = 'none';

        return parent::settings();
    }
}