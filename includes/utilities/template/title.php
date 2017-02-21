<?php

/**
 * Template title
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    jentil 1.0.0
 */

namespace GrottoPress\Jentil\Utilities\Template;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\MagPack;
use GrottoPress\Jentil\Utilities;

/**
 * Template
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			jentil 1.0.0
 */
final class Title extends MagPack\Utilities\Wizard {
    /**
     * Template
	 *
	 * @since       Jentil 0.1.0
	 * @access      protected
	 * 
	 * @var         \GrottoPress\Jentil\Utilities\Template\Template         $template       Template
	 */
    protected $template;
    
    /**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function __construct( Template $template ) {
	    $this->template = $template;
	}

	/**
     * Layout mod
     * 
     * @since		Jentil 0.1.0
     * @access      public
     * 
     * @return      string      Layout mod
     */
    public function mod() {
        $template = $this->template->type();

        $specific = '';

        foreach ( $template as $type ) {
            if ( 'post_type_archive' == $type ) {
                $specific = get_query_var( 'post_type' );
            } elseif ( 'tax' == $type ) {
                $specific = get_query_var( 'taxonomy' );
            } elseif ( 'category' == $type ) {
            	$specific = 'category';
            } elseif ( 'tag' == $type ) {
            	$specific = 'post_tag';
            }

            if ( is_array( $specific ) ) {
                $specific = $specific[0];
            }

            $mod = new Utilities\Mods\Title( $type, $specific );

            if ( $mod->get( 'name' ) ) {
            	return $mod->mod();
            }
        }

        return $mod->get( 'default' );
    }
}