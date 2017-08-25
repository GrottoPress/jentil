<?php

/**
 * Image Alignment
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
 * Image Alignment
 *
 * @since 0.1.0
 */
final class Image_Alignment extends Setting {
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

        $mod = $this->mod( 'image_alignment' );

        $this->name = $mod->name();
        
        $this->args['default'] = $mod->default();
        $this->args['sanitize_callback'] = 'sanitize_title';

        $this->control['label'] = \esc_html__( 'Image alignment', 'jentil' );
        $this->control['type'] = 'select';
        $this->control['choices'] = [
            'none' => \esc_html__( 'none', 'jentil' ),
            'left' => \esc_html__( 'Left', 'jentil' ),
            'right' => \esc_html__( 'Right', 'jentil' ),
        ];
    }
}
