<?php

/**
 * Logo Section
 *
 * @package GrottoPress\Jentil\Setup\Customizer\Logo
 * @since 0.1.0
 *
 * @author GrottoPress (https://www.grottopress.com)
 * @author N Atta Kus Adusei (https://twitter.com/akadusei)
 */

declare ( strict_types = 1 );

namespace GrottoPress\Jentil\Setup\Customizer\Logo;

if ( ! \defined( 'WPINC' ) ) {
    die;
}

use GrottoPress\Jentil\Setup\Customizer\Section;
use GrottoPress\Jentil\Setup\Customizer\Customizer;

/**
 * Logo Section
 *
 * @since 0.1.0
 */
final class Logo extends Section {
    /**
     * Constructor
     *
     * @var GrottoPress\Jentil\Setup\Customizer\Customizer $customizer Customizer.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct( Customizer $customizer ) {
        parent::__construct( $customizer );

        $this->name = '';
        
        $this->args = [
            'title' => \esc_html__( 'Logo', 'jentil' ),
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

        $settings['logo'] = new Settings\Logo( $this );

        return $settings;
    }
}
