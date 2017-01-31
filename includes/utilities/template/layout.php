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
final class Layout {
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
    public function mod( $default = '' ) {
        $default = sanitize_title( $default );
        $layout = ! $default ? 'content-sidebar' : $default;
        
        if ( ! ( $name = $this->mod_name() ) ) {
			return $layout;
		}

		global $post;
		
		if (
			$this->template->is( 'singular' )
			&& is_post_type_hierarchical( $post->post_type )
		) {
			$layout = get_post_meta( $post->ID, $name, true );
		} else {
			$layout = get_theme_mod( $name, $default );
		}
		
		if ( ! in_array( $layout, $this->layouts_ids() ) ) {
		    return $default;
		}
		
        return sanitize_title( $layout );
    }

    /**
     * Get setting name
     * 
     * @since       Jentil 0.1.0
     * @access      private
     * 
     * @return      string          Setting name
     */
    private function mod_name() {
        $name = '';

        if ( $this->template->is( 'singular' ) ) {
        	global $post;

        	if ( is_post_type_hierarchical( $post->post_type ) ) {
        		$name = 'layout';
        	} else {
        		$name = 'single_' . $post->post_type . '_layout';
        	}
        } elseif ( $this->template->is( 'tax' ) ) {
            $name = get_query_var( 'taxonomy' ) . '_taxonomy_layout';
        } elseif ( $this->template->is( 'category' ) ) {
            $name = 'category_taxonomy_layout';
        } elseif ( $this->template->is( 'tag' ) ) {
            $name = 'tag_taxonomy_layout';
        } elseif ( $this->template->is( 'post_type_archive' ) ) {
            $name = get_query_var( 'post_type' ) . '_post_type_layout';
        } elseif ( $this->template->is( 'home' ) ) {
            $name = 'post_post_type_layout';
        } elseif ( $this->template->is( 'date' ) ) {
            $name = 'date_layout';
        } elseif ( $this->template->is( 'search' ) ) {
            $name = 'search_layout';
        } elseif ( $this->template->is( 'author' ) ) {
            $name = 'author_layout';
        } elseif ( $this->template->is( '404' ) ) {
            $name = 'error_404_layout';
        }

        return sanitize_key( $name );
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