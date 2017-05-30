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

namespace GrottoPress\Jentil\Setup\Customizer\Posts;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\Jentil\Setup;

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
final class Search extends Section {
    /**
     * Constructor
     *
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function __construct( Posts $posts ) {
        parent::__construct( $posts );

        $this->name = 'search_posts';

        $this->mod_args['context'] = 'search';

        $this->args['title'] = esc_html__( 'Search Results', 'jentil' );
        $this->args['active_callback'] = function () {
            return $this->posts->get( 'customizer' )->get( 'template' )->is( 'search' );
        };
    }

    /**
     * Get settings
     *
     * @since       Jentil 0.1.0
     * @access      protected
     */
    protected function settings() {
        $settings = array();

        $settings[] = new Settings\Number( $this );

        $settings = array_merge( $settings, parent::settings() );

        $settings[] = new Settings\Pagination( $this );
        $settings[] = new Settings\Pagination_Maximum( $this );
        $settings[] = new Settings\Pagination_Position( $this );
        $settings[] = new Settings\Pagination_Previous_Label( $this );
        $settings[] = new Settings\Pagination_Next_Label( $this );

        return $settings;
    }
}