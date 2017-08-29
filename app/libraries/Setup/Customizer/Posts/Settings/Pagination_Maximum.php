<?php

/**
 * Maximum Pages
 *
 * @package GrottoPress\Jentil\Setup\Customizer\Posts\Settings
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare ( strict_types = 1 );

namespace GrottoPress\Jentil\Setup\Customizer\Posts\Settings;

if ( ! \defined( 'WPINC' ) ) {
    die;
}

use GrottoPress\Jentil\Setup\Customizer\Posts\Section;

/**
 * Maximum Pages
 *
 * @since 0.1.0
 */
final class Pagination_Maximum extends Setting {
    /**
     * Constructor
     *
     * @param GrottoPress\Jentil\Setup\Customizer\Posts\Section $section Section.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct( Section $section ) {
        parent::__construct( $section );

        $mod = $this->mod( 'pagination_maximum' );

        $this->name = $mod->name();
        
        $this->args['default'] = $mod->default();
        $this->args['sanitize_callback'] = function ( $value ): int {
            return \intval( $value );
        };

        $this->control['label'] = \esc_html__( 'Maximum pagination', 'jentil' );
        $this->control['type'] = 'number';
    }
}
