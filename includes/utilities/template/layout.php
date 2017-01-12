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

/**
 * Template layout
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			jentil 1.0.0
 */
class Layout {
    /**
     * Template
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 * 
	 * @var         \GrottoPress\Jentil\Utilities\Template\Template         $template       Template
	 */
    private $template;
    
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
     * Get Layout
     * 
     * @since		Jentil 0.1.0
     * @access      public
     * 
     * @return      string      The layout type
     */
    public function get() {
        $default = 'content-sidebar';
        
        if ( ! $this->template->get() ) {
			return $default;
		}
		
		$layout = $default;
		
        foreach ( $this->template->get() as $template ) {
			if ( $this->template->is( $template ) ) {
	    		$layout = get_theme_mod( $this->setting_name( $template ), $default );
	    		break;
	    	}
		}
		
		if ( ! in_array( $layout, $this->layouts_ids() ) ) {
		    return $default;
		}
		
        return sanitize_title( $layout );
    }

    /**
     * Get template layout setting name
     * 
     * @since       Jentil 0.1.0
     * @access      private
     * 
     * @return      string          Template layout setting name
     */
    public function setting_name( $template ) {
        return sanitize_key( $template . '_layout' );
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

	    return apply_filters( 'jentil_template_layouts', $layouts );
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
			$layout_ids[] = $layout_id;
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
    			$return[ $layout_id ] = $layout_name;
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
    		$layout_columns[] = $column_slug;
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
    			if ( $this->get() == $layout_id ) {
    				return $column_slug;
    			}
    		}
    	}
    
    	return '';
	}
}