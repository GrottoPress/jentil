<?php

/**
 * Title Length (number of words)
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
 * Title Length (number of words)
 *
 * @since 0.1.0
 */
final class Title_Words extends Setting {
    /**
     * Constructor
     *
     * @var GrottoPress\Jentil\Setup\Customizer\Posts\Section $section Section.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct( Section $section ) {
        parent::__construct( $section );

        $mod = $this->mod( 'title_words' );
        
        $this->name = $mod->get( 'name' );
        
        $this->args['default'] = $mod->get( 'default' );
        $this->args['sanitize_callback'] = function ( $value ): int {
            return \intval( $value );
        };

        $this->control['label'] = \esc_html__( 'Title length', 'jentil' );
        $this->control['description'] = \esc_html__( 'Number of words', 'jentil' );
        $this->control['type'] = 'number';
    }
}
