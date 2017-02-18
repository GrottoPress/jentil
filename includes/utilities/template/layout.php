<?php

/**
 * Template layout
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
 * Template layout
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			jentil 1.0.0
 */
final class Layout extends MagPack\Utilities\Wizard {
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
        $more_specific = '';

        foreach ( $template as $type ) {
            if ( 'post_type_archive' == $type ) {
                $specific = get_query_var( 'post_type' );
            } elseif ( 'tax' == $type ) {
                $specific = get_query_var( 'taxonomy' );

                if ( is_taxonomy_hierarchical( $specific ) ) {
                	$more_specific = get_query_var( 'term_id' );
                }
            } elseif ( 'category' == $type ) {
            	$specific = 'category';

            	if ( is_taxonomy_hierarchical( $specific ) ) {
            		$more_specific = get_query_var( 'cat' );
            	}
            } elseif ( 'tag' == $type ) {
            	$specific = 'post_tag';

                if ( is_taxonomy_hierarchical( $specific ) ) {
                    $more_specific = get_query_var( 'tag_id' );
                }
            } elseif ( 'singular' == $type ) {
            	global $post;

            	$specific = $post->post_type;

            	if ( 'page' == $post->post_type ) {
            		$more_specific = $post->ID;
            	}
            }

            if ( is_array( $specific ) ) {
                $specific = $specific[0];
            }

            if ( is_array( $more_specific ) ) {
                $more_specific = $more_specific[0];
            }

            $mod = new Utilities\Mods\Layout( $type, $specific, $more_specific );

            if ( $mod->get( 'name' ) ) {
            	return $mod->mod();
            }
        }

        return $mod->get( 'default' );
    }
    
    /**
	 * Layouts
	 * 
	 * @since       Jentil 0.1.0
	 * @access      public
	 * 
	 * @return      string      Layout column type
	 */
	public function layouts() {
	    $layouts = array(
    		'one-column' => array(
    			'content' => esc_html__( 'content', 'jentil' ),
    		),
    		'two-columns' => array(
    			'content-sidebar' => esc_html__( 'content / sidebar', 'jentil' ),
    			'sidebar-content' => esc_html__( 'sidebar / content', 'jentil' ),
    		),
    		'three-columns' => array(
    			'sidebar-content-sidebar' => esc_html__( 'sidebar / content / sidebar', 'jentil' ),
    			'content-sidebar-sidebar' => esc_html__( 'content / sidebar / sidebar', 'jentil' ),
    			'sidebar-sidebar-content' => esc_html__( 'sidebar / sidebar / content', 'jentil' ),
    		),
    	);

	    return ( array ) apply_filters( 'jentil_template_layouts', $layouts );
	}

    /**
	 * Layouts IDS/slugs
	 * 
	 * @since       Jentil 0.1.0
	 * @access      public
	 * 
	 * @return      array          Layout IDs/slugs
	 */
	public function layouts_ids() {
	    $layout_ids = array();
	    
    	foreach ( $this->layouts_ids_names() as $layout_id => $layout_name ) {
			$layout_ids[] = sanitize_title( $layout_id );
		}
    
    	return $layout_ids;
	}
	
	/**
	 * Array of layout ids mapping to names
	 * 
	 * Used to build a dropdown of layouts.
	 * 
	 * @since       Jentil 0.1.0
	 * @access      public
	 * 
	 * @return      array          Layout IDs/slugs
	 */
	public function layouts_ids_names() {
	    $return = array();
	    
    	foreach ( $this->layouts() as $column_type => $layouts ) {
    		foreach ( $layouts as $layout_id => $layout_name ) {
    			$return[ sanitize_title( $layout_id ) ] = sanitize_text_field( $layout_name );
    		}
    	}
    
    	return $return;
	}
	
	/**
	 * Layouts columns
	 * 
	 * @since       Jentil 0.1.0
	 * @access      public
	 * 
	 * @return      array           Layout columns
	 */
	public function layouts_columns() {
	    $layout_columns = array();
	    
    	foreach ( $this->layouts() as $column_slug => $layouts ) {
    		$layout_columns[] = sanitize_title( $column_slug );
    	}
    
    	return $layout_columns;
	}
	
	/**
	 * Get column
	 * 
	 * @since       Jentil 0.1.0
	 * @access      public
	 * 
	 * @return      string      Layout column type
	 */
	public function column() {
	    $layout_ids = array();
	    
    	foreach ( $this->layouts() as $column_slug => $layouts ) {
    		foreach ( $layouts as $layout_id => $layout_name ) {
    			if ( $this->mod() == $layout_id ) {
    				return sanitize_title( $column_slug );
    			}
    		}
    	}
    
    	return '';
	}
}