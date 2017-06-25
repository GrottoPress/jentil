<?php

/**
 * Content 'text offset' setting
 *
 * Add setting and control for our content 'text offset'
 * setting in the customizer.
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup\Customizer\Posts\Settings;

if ( ! defined( 'WPINC' ) ) {
    die;
}

use GrottoPress\Jentil\Setup;

/**
 * Content 'text offset' setting
 *
 * Add setting and control for our content 'text offset'
 * setting in the customizer.
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			Jentil 0.1.0
 */
final class Text_Offset extends Setting {
    /**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function __construct( $content ) {
        parent::__construct( $content );
        
        $this->mod = $this->mod( 'text_offset' );
        
        $this->name = $this->mod->get( 'name' );
        
        $this->args['default'] = $this->mod->get( 'default' );
        $this->args['sanitize_callback'] = 'absint';

        $this->control['label'] = esc_html__( 'Text offset', 'jentil' );
        $this->control['description'] = esc_html__( 'From image align side (px)', 'jentil' );
        $this->control['type'] = 'number';
	}
}