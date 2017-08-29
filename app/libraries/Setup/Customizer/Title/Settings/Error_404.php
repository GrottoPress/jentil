<?php

/**
 * Error 404
 *
 * @package GrottoPress\Jentil\Setup\Customizer\Title\Settings
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare ( strict_types = 1 );

namespace GrottoPress\Jentil\Setup\Customizer\Title\Settings;

if ( ! \defined( 'WPINC' ) ) {
    die;
}

use GrottoPress\Jentil\Setup\Customizer\Title\Title;

/**
 * Error 404
 *
 * @since 0.1.0
 */
final class Error_404 extends Setting {
    /**
     * Constructor
     *
     * @param GrottoPress\Jentil\Setup\Customizer\Customizer\Title\Title $title Title.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct( Title $title ) {
        parent::__construct( $title );

        $this->mod = $this->title->customizer()->jentil()->utilities()->mods()->title( [
            'context' => '404',
        ] );

        $this->name = $this->mod->name();
        
        $this->args['default'] = $this->mod->default();

        $this->control['label'] = \esc_html__( 'Error 404', 'jentil' );
        $this->control['active_callback'] = function (): bool {
            return $this->title->customizer()->jentil()->utilities()->page()->is( '404' );
        };
    }
}
