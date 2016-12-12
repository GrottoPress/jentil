<?php

/**
 * Layout customizer
 *
 * The sections, settings and controls for our layout
 * options in the customizer
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Customizer;

/**
 * Layout customizer
 *
 * The sections, settings and controls for our layout
 * options in the customizer
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			jentil 0.1.0
 */
class Layout {
    /**
     * Layouts
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 * 
	 * @var         array         $layouts       Associative array of layouts ids to layouts names
	 */
    private $layouts;
    
    /**
     * Non-hierarchical post types
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 * 
	 * @var         array         $post_types       Hierarical post types
	 */
    private $post_types;
    
    /**
     * Default layout
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 * 
	 * @var         array         $default       Default layout
	 */
    private $default;
    
    /**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function __construct() {
        $template = new \GrottoPress\Jentil\Template\Template();
        $this->layouts = $template->get_layout()->layouts_ids_names();
        $this->default = 'content-sidebar';
        $this->post_types = get_post_types( array( 'public' => true, 'hierarchical' => false ), 'objects' );
	}
    
    /**
     * Add layout section
     * 
     * @see         https://code.tutsplus.com/tutorials/wordpress-theme-customizer-methodology-for-sections-settings-and-controls-part-1--wp-33238
     * 
     * @since       Jentil 0.1.0
	 * @access      public
     */
    public function add_section( $wp_customize ) {
        $wp_customize->add_section(
            'layout',
            array(
                'title'     => esc_html__( 'Layout', 'jentil' ),
                'priority'  => 200,
            )
        );
    }
    
    /**
     * Add layout setting
     * 
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function add_settings( $wp_customize ) {
        $this->add_home_layout_setting( $wp_customize );
        $this->add_404_layout_setting( $wp_customize );
        $this->add_search_layout_setting( $wp_customize );
        $this->add_category_layout_setting( $wp_customize );
        $this->add_tag_layout_setting( $wp_customize );
        $this->add_author_layout_setting( $wp_customize );
        $this->add_date_layout_setting( $wp_customize );
        $this->add_tax_layout_setting( $wp_customize );
        $this->add_post_type_layout_setting( $wp_customize );
        $this->add_single_layout_setting( $wp_customize );
    }
    
    /**
     * Add home layout setting
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_home_layout_setting( $wp_customize ) {
        $wp_customize->add_setting(
            'home_layout',
            array(
                'default'    =>  $this->default,
                'transport'  =>  'postMessage',
            )
        );
    }
    
    /**
     * Add 404 layout setting
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_404_layout_setting( $wp_customize ) {
        $wp_customize->add_setting(
            'layout_404',
            array(
                'default'    =>  $this->default,
                'transport'  =>  'postMessage',
            )
        );
    }
    
    /**
     * Add search layout setting
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_search_layout_setting( $wp_customize ) {
        $wp_customize->add_setting(
            'search_layout',
            array(
                'default'    =>  $this->default,
                'transport'  =>  'postMessage',
            )
        );
    }
    
    /**
     * Add category layout setting
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_category_layout_setting( $wp_customize ) {
        $wp_customize->add_setting(
            'category_layout',
            array(
                'default'    =>  $this->default,
                'transport'  =>  'postMessage',
            )
        );
    }
    
    /**
     * Add tag layout setting
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_tag_layout_setting( $wp_customize ) {
        $wp_customize->add_setting(
            'tag_layout',
            array(
                'default'    =>  $this->default,
                'transport'  =>  'postMessage',
            )
        );
    }
    
    /**
     * Add author layout setting
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_author_layout_setting( $wp_customize ) {
        $wp_customize->add_setting(
            'author_layout',
            array(
                'default'    =>  $this->default,
                'transport'  =>  'postMessage',
            )
        );
    }
    
    /**
     * Add date layout setting
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_date_layout_setting( $wp_customize ) {
        $wp_customize->add_setting(
            'date_layout',
            array(
                'default'    =>  $this->default,
                'transport'  =>  'postMessage',
            )
        );
    }
    
    /**
     * Add tax layout setting
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_tax_layout_setting( $wp_customize ) {
        $wp_customize->add_setting(
            'taxonomy_layout',
            array(
                'default'    =>  $this->default,
                'transport'  =>  'postMessage',
            )
        );
    }
    
    /**
     * Add post type archive layout setting
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_post_type_layout_setting( $wp_customize ) {
        $wp_customize->add_setting(
            'post_type_layout',
            array(
                'default'    =>  $this->default,
                'transport'  =>  'postMessage',
            )
        );
    }
    
    /**
     * Add single layout setting
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_single_layout_setting( $wp_customize ) {
        foreach ( $this->post_types as $post_type ) {
           $wp_customize->add_setting(
                sanitize_key( $post_type->name ) . '_layout',
                array(
                    'default'    =>  $this->default,
                    'transport'  =>  'postMessage',
                )
            );
       }
    }
    
    /**
     * Add layout control
     * 
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function add_controls( $wp_customize ) {
        $this->add_home_layout_control( $wp_customize );
        $this->add_404_layout_control( $wp_customize );
        $this->add_search_layout_control( $wp_customize );
        $this->add_category_layout_control( $wp_customize );
        $this->add_tag_layout_control( $wp_customize );
        $this->add_author_layout_control( $wp_customize );
        $this->add_date_layout_control( $wp_customize );
        $this->add_tax_layout_control( $wp_customize );
        $this->add_post_type_layout_control( $wp_customize );
        $this->add_single_layout_control( $wp_customize );
    }
    
    /**
     * Add category layout control
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_category_layout_control( $wp_customize ) {
        $wp_customize->add_control(
            'category_layout',
            array(
                'section'   => 'layout',
                'label'     => esc_html__( 'Category archive', 'jentil' ),
                'type'      => 'select',
                'choices'   => $this->layouts,
            )
        );
    }
    
    /**
     * Add tag layout control
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_tag_layout_control( $wp_customize ) {
       $wp_customize->add_control(
            'tag_layout',
            array(
                'section'   => 'layout',
                'label'     => esc_html__( 'Tag archive', 'jentil' ),
                'type'      => 'select',
                'choices'   => $this->layouts,
            )
        );
    }
    
    /**
     * Add taxonomy layout control
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_tax_layout_control( $wp_customize ) {
       $wp_customize->add_control(
            'taxonomy_layout',
            array(
                'section'   => 'layout',
                'label'     => esc_html__( 'Taxonomy archive', 'jentil' ),
                'type'      => 'select',
                'choices'   => $this->layouts,
            )
        );
    }
    
    /**
     * Add author layout control
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_author_layout_control( $wp_customize ) {
       $wp_customize->add_control(
            'author_layout',
            array(
                'section'   => 'layout',
                'label'     => esc_html__( 'Author archive', 'jentil' ),
                'type'      => 'select',
                'choices'   => $this->layouts,
            )
        );
    }
    
    /**
     * Add date layout control
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_date_layout_control( $wp_customize ) {
       $wp_customize->add_control(
            'date_layout',
            array(
                'section'   => 'layout',
                'label'     => esc_html__( 'Date archive', 'jentil' ),
                'type'      => 'select',
                'choices'   => $this->layouts,
            )
        );
    }
    
    /**
     * Add post type archive layout control
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_post_type_layout_control( $wp_customize ) {
       $wp_customize->add_control(
            'post_type_layout',
            array(
                'section'   => 'layout',
                'label'     => esc_html__( 'Post type archive', 'jentil' ),
                'type'      => 'select',
                'choices'   => $this->layouts,
            )
        );
    }
    
    /**
     * Add 404 layout control
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_404_layout_control( $wp_customize ) {
       $wp_customize->add_control(
            'layout_404',
            array(
                'section'   => 'layout',
                'label'     => esc_html__( '404 (Not found)', 'jentil' ),
                'type'      => 'select',
                'choices'   => $this->layouts,
            )
        );
    }
    
    /**
     * Add home layout control
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_home_layout_control( $wp_customize ) {
       $wp_customize->add_control(
            'home_layout',
            array(
                'section'   => 'layout',
                'label'     => esc_html__( 'Home (posts page)', 'jentil' ),
                'type'      => 'select',
                'choices'   => $this->layouts,
            )
        );
    }
    
    /**
     * Add search layout control
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_search_layout_control( $wp_customize ) {
       $wp_customize->add_control(
            'search_layout',
            array(
                'section'   => 'layout',
                'label'     => esc_html__( 'Search page', 'jentil' ),
                'type'      => 'select',
                'choices'   => $this->layouts,
            )
        );
    }
    
    /**
     * Add single layout control
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_single_layout_control( $wp_customize ) {
       foreach ( $this->post_types as $post_type ) {
           $wp_customize->add_control(
                sanitize_key( $post_type->name ) . '_layout',
                array(
                    'section'   => 'layout',
                    'label'     => sprintf( esc_html__( 'Single %s', 'jentil' ), $post_type->labels->name ),
                    'type'      => 'select',
                    'choices'   => $this->layouts,
                )
            );
       }
    }
}