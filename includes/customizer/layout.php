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
 * @since			Jentil 0.1.0
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
     * Post types
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 * 
	 * @var         array         $post_types       Post types
	 */
    private $post_types;
    
    /**
     * Custom post types
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 * 
	 * @var         array         $custom_post_types       Custom post types
	 */
    private $custom_post_types;
    
    /**
     * Custom taxonomies
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 * 
	 * @var         array         $taxonomies       Custom taxonomies
	 */
    private $taxonomies;
    
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
        $this->layouts = $template->layout()->layouts_ids_names();
        $this->default = 'content-sidebar';
        $this->post_types = get_post_types( array( 'public' => true ), 'objects' );
        $this->custom_post_types = get_post_types( array( 'public' => true, '_builtin' => false ), 'objects' );
        $this->taxonomies = get_taxonomies( array( '_builtin' => false ), 'objects' );
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
                //'priority'  => 200,
            )
        );
    }
    
    /**
     * Add layout settings
     * 
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function add_settings( $wp_customize ) {
        $this->add_author_layout_setting( $wp_customize );
        $this->add_date_layout_setting( $wp_customize );
        $this->add_search_layout_setting( $wp_customize );
        $this->add_404_layout_setting( $wp_customize );
        $this->add_category_layout_setting( $wp_customize );
        $this->add_tag_layout_setting( $wp_customize );
        $this->add_tax_layout_setting( $wp_customize );
        $this->add_single_layout_setting( $wp_customize );
        $this->add_home_layout_setting( $wp_customize );
        $this->add_post_type_layout_setting( $wp_customize );
    }
    
    /**
     * Add home layout setting
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_home_layout_setting( $wp_customize ) {
        $wp_customize->add_setting(
            'post_archive_layout',
            array(
                'default'    =>  $this->default,
                //'transport'  =>  'postMessage',
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
            'error_404_layout',
            array(
                'default'    =>  $this->default,
                //'transport'  =>  'postMessage',
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
                //'transport'  =>  'postMessage',
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
        if ( ! taxonomy_exists( 'category' ) ) {
            return;
        }
        
        $wp_customize->add_setting(
            'category_archive_layout',
            array(
                'default'    =>  $this->default,
                //'transport'  =>  'postMessage',
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
        if ( ! taxonomy_exists( 'post_tag' ) ) {
            return;
        }
        
        $wp_customize->add_setting(
            'tag_archive_layout',
            array(
                'default'    =>  $this->default,
                //'transport'  =>  'postMessage',
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
            'author_archive_layout',
            array(
                'default'    =>  $this->default,
                //'transport'  =>  'postMessage',
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
            'date_archive_layout',
            array(
                'default'    =>  $this->default,
                //'transport'  =>  'postMessage',
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
        foreach ( $this->taxonomies as $tax ) {
            $wp_customize->add_setting(
                sanitize_key( $tax->name ) . '_taxonomy_archive_layout',
                array(
                    'default'    =>  $this->default,
                    //'transport'  =>  'postMessage',
                )
            );
        }
    }
    
    /**
     * Add post type archive layout setting
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_post_type_layout_setting( $wp_customize ) {
        foreach ( $this->custom_post_types as $post_type ) {
            $wp_customize->add_setting(
                sanitize_key( $post_type->name ) . '_post_type_archive_layout',
                array(
                    'default'    =>  $this->default,
                    //'transport'  =>  'postMessage',
                )
            );
        }
    }
    
    /**
     * Add single layout setting
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_single_layout_setting( $wp_customize ) {
        foreach ( $this->post_types as $post_type ) {
           if ( is_post_type_hierarchical( $post_type->name ) ) {
               continue;
           }
           
           $wp_customize->add_setting(
                'single_' . sanitize_key( $post_type->name ) . '_layout',
                array(
                    'default'    =>  $this->default,
                    //'transport'  =>  'postMessage',
                )
            );
       }
    }
    
    /**
     * Add layout controls
     * 
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function add_controls( $wp_customize ) {
        $this->add_404_layout_control( $wp_customize );
        $this->add_author_layout_control( $wp_customize );
        $this->add_date_layout_control( $wp_customize );
        $this->add_search_layout_control( $wp_customize );
        $this->add_category_layout_control( $wp_customize );
        $this->add_tag_layout_control( $wp_customize );
        $this->add_tax_layout_control( $wp_customize );
        $this->add_single_layout_control( $wp_customize );
        $this->add_home_layout_control( $wp_customize );
        $this->add_post_type_layout_control( $wp_customize );
    }
    
    /**
     * Add category layout control
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_category_layout_control( $wp_customize ) {
        $wp_customize->add_control(
            'category_archive_layout',
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
            'tag_archive_layout',
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
        foreach ( $this->taxonomies as $tax ) {
           $wp_customize->add_control(
                sanitize_key( $tax->name ) . '_taxonomy_archive_layout',
                array(
                    'section'   => 'layout',
                    'label'     => sprintf( esc_html__( '%s taxonomy archive', 'jentil' ), $tax->labels->singular_name ),
                    'type'      => 'select',
                    'choices'   => $this->layouts,
                )
            );
        }
    }
    
    /**
     * Add author layout control
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_author_layout_control( $wp_customize ) {
       $wp_customize->add_control(
            'author_archive_layout',
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
            'date_archive_layout',
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
        foreach ( $this->custom_post_types as $post_type ) {
            $wp_customize->add_control(
                sanitize_key( $post_type->name ) . '_post_type_archive_layout',
                array(
                    'section'   => 'layout',
                    'label'     => sprintf( esc_html__( '%s post type archive', 'jentil' ), $post_type->labels->singular_name ),
                    'type'      => 'select',
                    'choices'   => $this->layouts,
                )
            );
        }
    }
    
    /**
     * Add 404 layout control
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_404_layout_control( $wp_customize ) {
       $wp_customize->add_control(
            'error_404_layout',
            array(
                'section'   => 'layout',
                'label'     => esc_html__( 'Error 404', 'jentil' ),
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
            'post_archive_layout',
            array(
                'section'   => 'layout',
                'label'     => esc_html__( 'Post archive', 'jentil' ),
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
                'label'     => esc_html__( 'Search', 'jentil' ),
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
           if ( is_post_type_hierarchical( $post_type->name ) ) {
               continue;
           }
           
           $wp_customize->add_control(
                'single_' . sanitize_key( $post_type->name ) . '_layout',
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