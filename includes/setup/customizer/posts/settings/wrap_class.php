<?php

/**
 * Content class setting
 *
 * Add setting and control for our content class
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
 * Content class setting
 *
 * Add setting and control for our content class
 * setting in the customizer.
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			Jentil 0.1.0
 */
final class Wrap_Class extends Setting {
    /**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function __construct( $content ) {
        parent::__construct( $content );
        
        $this->mod = $this->mod( 'wrap_class' );
        
        $this->name = $this->mod->get( 'name' );
        
        $this->args['default'] = $this->mod->get( 'default' );
        $this->args['sanitize_callback'] = 'sanitize_text_field';

        $this->control['label'] = esc_html__( 'Wrapper class', 'jentil' );
        $this->control['description'] = esc_html__( 'Comma- or space-separated', 'jentil' );
        $this->control['type'] = 'text';
	}
}