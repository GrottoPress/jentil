<?php

/**
 * Test offset (from image aligned side)
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
 * Test offset (from image aligned side)
 *
 * @since 0.1.0
 */
final class Text_Offset extends Setting {
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

        $mod = $this->mod( 'text_offset' );
        
        $this->name = $mod->name();
        
        $this->args['default'] = $mod->default();
        $this->args['sanitize_callback'] = 'absint';

        $this->control['label'] = \esc_html__( 'Text offset', 'jentil' );
        $this->control['description'] = \esc_html__( 'From image align side (px)', 'jentil' );
        $this->control['type'] = 'number';
    }
}
