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

namespace GrottoPress\Jentil\Setup\Customizer\Posts;

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
final class Sticky extends Section {
    /**
     * Constructor
     *
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function __construct( Setup\Customizer\Customizer $customizer ) {
        parent::__construct( $customizer );

        $this->name = 'sticky_posts';

        $this->args['title'] = esc_html__( 'Sticky Posts', 'jentil' );
        $this->args['active_callback'] = function () {
            return ( ! $this->customizer->get( 'template' )->is( 'search' )
                && ! $this->customizer->get( 'template' )->is( 'singular' ) );
        };

        $this->default['number'] = 3;
        $this->default['wrap_class'] = 'sticky-posts big';
        $this->default['pagination_position'] = 'none';
    }
}