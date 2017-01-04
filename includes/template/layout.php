<?php

/**
 * Template layout
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    jentil 1.0.0
 */

namespace GrottoPress\Jentil\Template;

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
	 * @var         \GrottoPress\Jentil\Template\Template         $template       Template
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
	 * Layouts IDS/slugs
	 * 
	 * @since       Jentil 0.1.0
	 * @access      public
	 * 
	 * @return      array          Layout IDs/slugs
	 */
	public function layouts_ids() {
	    $layout_ids = array();
	    
    	foreach( $this->layouts_ids_names() as $layout_id => $layout_name ) {
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
	    
    	foreach( $this->layouts() as $column_type => $layouts ) {
    		foreach( $layouts as $layout_id => $layout_name ) {
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
	    
    	foreach( $this->layouts() as $column_slug => $layouts ) {
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
	    
    	foreach( $this->layouts() as $column_slug => $layouts ) {
    		foreach( $layouts as $layout_id => $layout_name ) {
    			if ( $this->get() == $layout_id ) {
    				return $column_slug;
    			}
    		}
    	}
    
    	return '';
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
        
        if ( empty( $this->template->get() ) ) {
			return $default;
		}
		
		$layout = $default;
		
        foreach ( $this->template->get() as $template ) {
			$is_template = 'is_' . $template;
	    	
	    	if ( is_callable( $is_template ) ) {
	    		$template_layout = $template . '_layout';
	    		$layout_template = 'layout_' . $template;
	    		
	    		if ( $is_template() ) {
	    			if ( is_callable( array( $this, $template_layout ) ) ) {
	    				$layout = $this->$template_layout();
	    				break;
	    			} elseif ( is_callable( array( $this, $layout_template ) ) ) {
	    				$layout = $this->$layout_template();
	    				break;
	    			}
	    		}
	    	}
		}
		
		if ( ! in_array( $layout, $this->layouts_ids() ) ) {
		    return $default;
		}
		
        return sanitize_key( $layout );
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
	 * Category layout
	 * 
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function category_layout() {
		if ( ! taxonomy_exists( 'category' ) ) {
            return false;
        }
		
		return get_theme_mod( 'category_archive_layout' );
	}
	
	/**
	 * Tag layout
	 * 
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function tag_layout() {
		if ( ! taxonomy_exists( 'post_tag' ) ) {
            return false;
        }
		
		return get_theme_mod( 'tag_archive_layout' );
	}
	
	/**
	 * Author layout
	 * 
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function author_layout() {
		return get_theme_mod( 'author_archive_layout' );
	}
	
	/**
	 * Date layout
	 * 
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function date_layout() {
		return get_theme_mod( 'date_archive_layout' );
	}
	
	/**
	 * Taxonomy layout
	 * 
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function tax_layout() {
		$tax_slug = get_query_var( 'taxonomy' );
		$tax_slug = is_array( $tax_slug ) ? $tax_slug[0] : $tax_slug;
		$tax = get_taxonomy( $tax_slug );
		
		return get_theme_mod( sanitize_key( $tax->name ) . '_taxonomy_archive_layout' );
	}
	
	/**
	 * Post type archive layout
	 * 
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function post_type_archive_layout() {
		$post_type = get_query_var( 'post_type' );
		$post_type = is_array( $post_type ) ? $post_type[0] : $post_type;
		
		return get_theme_mod( sanitize_key( $post_type ) . '_post_type_archive_layout' );
	}
	
	/**
	 * Singular layout
	 * 
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function singular_layout() {
		global $post;
		
		if ( is_post_type_hierarchical( $post->post_type ) ) {
        	return get_post_meta( $post->ID, 'layout', true );
        } else {
            return get_theme_mod( 'single_' . sanitize_key( $post->post_type ) . '_layout' );
        }
	}
	
	/**
	 * Search layout
	 * 
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function search_layout() {
		return get_theme_mod( 'search_layout' );
	}
	
	/**
	 * Home layout
	 * 
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function home_layout() {
		return get_theme_mod( 'post_archive_layout' );
	}
	
	/**
	 * 404 layout
	 * 
	 * @since       Jentil 0.1.0
	 * @access      private
	 */
	private function layout_404() {
		return get_theme_mod( 'error_404_layout' );
	}
}