<?php

/**
 * More Link Label
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
 * More Link Label
 *
 * @since 0.1.0
 */
final class More_Link extends Setting {
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

        $mod = $this->mod( 'more_link' );
        
        $this->name = $mod->name();
        
        $this->args['default'] = $mod->default();
        $this->args['sanitize_callback'] = 'sanitize_text_field';

        $this->control['label'] = \esc_html__( 'More link label', 'jentil' );
        $this->control['type'] = 'text';
    }
}
