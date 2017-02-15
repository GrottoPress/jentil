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

namespace GrottoPress\Jentil\Setup\Customizer\Content\Sections;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\Jentil\Setup;

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
final class Author extends Content {
    /**
     * Constructor
     *
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function __construct( Setup\Customizer\Content\Content $content ) {
        parent::__construct( $content );

        $this->name = 'author_' . $this->content->get( 'name' );
        $this->args = array(
            'title' => esc_html__( 'Author Content', 'jentil' ),
            'panel' => $this->content->get( 'name' ),
        );
    }

    /**
     * Get settings
     *
     * @since       Jentil 0.1.0
     * @access      protected
     */
    protected function settings() {
        $settings = array();

        $settings[] = new Setup\Customizer\Content\Settings\Sticky_Posts( $this );

        return array_merge( $settings, parent::settings() );
    }
}