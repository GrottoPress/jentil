<?php

/**
 * Title Position
 *
 * @package GrottoPress\Jentil\Setup\Customizer\Posts\Settings
 * @since 0.1.0
 *
 * @author GrottoPress (https://www.grottopress.com)
 * @author N Atta Kus Adusei (https://twitter.com/akadusei)
 */

declare ( strict_types = 1 );

namespace GrottoPress\Jentil\Setup\Customizer\Posts\Settings;

if ( ! \defined( 'WPINC' ) ) {
    die;
}

use GrottoPress\Jentil\Setup\Customizer\Posts\Section;

/**
 * Title Position
 *
 * @since 0.1.0
 */
final class Title_Position extends Setting {
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

        $mod = $this->mod( 'title_position' );
        
        $this->name = $mod->name();
        
        $this->args['default'] = $mod->default();
        $this->args['sanitize_callback'] = 'sanitize_key';

        $this->control['label'] = \esc_html__( 'Title position', 'jentil' );
        $this->control['description'] = \esc_html__( 'Relative to image', 'jentil' );
        $this->control['type'] = 'select';
        $this->control['choices'] = [
            'side' => \esc_html__( 'Side', 'jentil' ),
            'top' => \esc_html__( 'Top', 'jentil' ),
        ];
    }
}
