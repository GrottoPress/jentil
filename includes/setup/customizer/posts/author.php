<?php

/**
 * Author archive content customizer section
 *
 * The sections, settings and controls for our Author archive content
 * section in the customizer.
 *
 * @link            https://jentil.grotttopress.com
 * @package         jentil
 * @subpackage      jentil/includes
 * @since           Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup\Customizer\Posts;

if ( ! defined( 'WPINC' ) ) {
    die;
}

use GrottoPress\Jentil\Utilities;

/**
 * Author archive content customizer section
 *
 * The sections, settings and controls for our Author archive content
 * section in the customizer.
 *
 * @link            https://jentil.grotttopress.com
 * @package         jentil
 * @subpackage      jentil/includes
 * @since           Jentil 0.1.0
 */
final class Author extends Section {
    /**
     * Constructor
     *
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function __construct( Posts $posts ) {
        parent::__construct( $posts );

        $this->name = 'author_posts';
        
        $this->mod_args['context'] = 'author';

        $this->args['title'] = esc_html__( 'Author Archives', 'jentil' );
        $this->args['active_callback'] = function () {
            return Utilities\Template\Template::instance()->is( 'author' );
        };
    }

    /**
     * Get settings
     *
     * @since       Jentil 0.1.0
     * @access      protected
     */
    protected function settings() {
        $settings = [];

        $settings['sticky_posts'] = new Settings\Sticky_Posts( $this );
        $settings['number'] = new Settings\Number( $this );

        $settings = array_merge( $settings, parent::settings() );

        $settings['pagination'] = new Settings\Pagination( $this );
        $settings['pagination_maximum'] = new Settings\Pagination_Maximum( $this );
        $settings['pagination_position'] = new Settings\Pagination_Position( $this );
        $settings['pagination_previous_label'] = new Settings\Pagination_Previous_Label( $this );
        $settings['pagination_next_label'] = new Settings\Pagination_Next_Label( $this );

        return $settings;
    }
}