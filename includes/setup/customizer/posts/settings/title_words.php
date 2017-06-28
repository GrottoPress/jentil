<?php

/**
 * Content title length setting
 *
 * Add setting and control for our content title length
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
 * Content title setting
 *
 * Add setting and control for our content title length
 * setting in the customizer.
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			Jentil 0.1.0
 */
final class Title_Words extends Setting {
    /**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function __construct( $content ) {
        parent::__construct( $content );
        
        $this->mod = $this->mod( 'title_words' );
        
        $this->name = $this->mod->get( 'name' );
        
        $this->args['default'] = $this->mod->get( 'default' );
        $this->args['sanitize_callback'] = function ( $value ) {
            return intval( $value );
        };

        $this->control['label'] = esc_html__( 'Title length', 'jentil' );
        $this->control['description'] = esc_html__( 'Number of words', 'jentil' );
        $this->control['type'] = 'number';
	}
}