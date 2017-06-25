<?php

/**
 * Logo customizer section
 *
 * Add section, settings and controls for our logo
 * section in the customizer.
 *
 * @link            https://jentil.grotttopress.com
 * @package         jentil
 * @subpackage      jentil/includes
 * @since           Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup\Customizer\Logo;

if ( ! defined( 'WPINC' ) ) {
    die;
}

use GrottoPress\Jentil\Setup;

/**
 * Logo customizer section
 *
 * Add section, settings and controls for our logo
 * section in the customizer.
 *
 * @link            https://jentil.grotttopress.com
 * @package         jentil
 * @subpackage      jentil/includes
 * @since           jentil 0.1.0
 */
final class Logo extends Setup\Customizer\Section {
    /**
     * Constructor
     *
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function __construct( Setup\Customizer\Customizer $customizer ) {
        parent::__construct( $customizer );

        $this->name = '';
        
        $this->args = array(
            'title'     => esc_html__( 'Logo', 'jentil' ),
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

        $settings['logo'] = new Settings\Logo( $this );

        return $settings;
    }
}