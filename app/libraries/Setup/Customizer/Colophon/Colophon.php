<?php

/**
 * Colophon Section
 *
 * @package GrottoPress\Jentil\Setup\Customizer\Colophon
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare ( strict_types = 1 );

namespace GrottoPress\Jentil\Setup\Customizer\Colophon;

if ( ! \defined( 'WPINC' ) ) {
    die;
}

use GrottoPress\Jentil\Setup\Customizer\Customizer;
use GrottoPress\Jentil\Setup\Customizer\Section;

/**
 * Colophon Section
 *
 * @since 0.1.0
 */
final class Colophon extends Section {
    /**
     * Constructor
     *
     * @param GrottoPress\Jentil\Setup\Customizer\Customizer $customizer Customizer.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct( Customizer $customizer ) {
        parent::__construct( $customizer );

        $this->name = 'colophon';
        
        $this->args = [
            'title'     => \esc_html__( 'Colophon', 'jentil' ),
        ];
    }

    /**
     * Get settings
     *
     * @since 0.1.0
     * @access protected
     *
     * @return array Settings.
     */
    protected function settings(): array {
        $settings = [];

        $settings['colophon'] = new Settings\Colophon( $this );

        return $settings;
    }
}
