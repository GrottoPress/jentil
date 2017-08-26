<?php

/**
 * Error 404 Layout Setting
 *
 * @package GrottoPress\Jentil\Setup\Customizer\Layout\Settings
 * @since 0.1.0
 *
 * @author GrottoPress (https://www.grottopress.com)
 * @author N Atta Kus Adusei (https://twitter.com/akadusei)
 */

declare ( strict_types = 1 );

namespace GrottoPress\Jentil\Setup\Customizer\Layout\Settings;

if ( ! \defined( 'WPINC' ) ) {
    die;
}

use GrottoPress\Jentil\Setup\Customizer\Layout\Layout;

/**
 * Error 404 Layout Setting
 *
 * @since 0.1.0
 */
final class Error_404 extends Setting {
    /**
     * Constructor
     *
     * @var GrottoPress\Jentil\Setup\Customizer\Layout\Layout $layout Layout section.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct( Layout $layout ) {
        parent::__construct( $layout );
        
        $this->mod = $this->layout->customizer()->jentil()->utilities()->mods()->layout( [
            'context' => '404',
        ] );

        $this->name = $this->mod->name();

        $this->args[ 'default' ] = $this->mod->default();

        $this->control['label'] = \esc_html__( 'Error 404', 'jentil' );
        $this->control['active_callback'] = function (): bool {
            return $this->layout->customizer()->jentil()->utilities()->page()->is( '404' );
        };
    }
}
