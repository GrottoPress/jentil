<?php

/**
 * Search archive content customizer section
 *
 * The sections, settings and controls for our
 * Search archive content section in the customizer.
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

use GrottoPress\Jentil\Setup\Customizer;

/**
 * Search archive content customizer section
 *
 * The sections, settings and controls for our
 * Search archive content section in the customizer.
 *
 * @link            https://jentil.grotttopress.com
 * @package         jentil
 * @subpackage      jentil/includes
 * @since           Jentil 0.1.0
 */
class Search extends Content {
    /**
     * Constructor
     *
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function __construct( Customizer\Customizer $customizer ) {
        $this->name = 'search_content';
        $this->args = array(
            'title' => esc_html__( 'Search Content', 'jentil' ),
            //'priority' => 200,
        );

        parent::__construct( $customizer );
    }
}