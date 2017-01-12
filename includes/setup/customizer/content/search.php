<?php

/**
 * Search content customizer
 *
 * The sections, settings and controls for our search
 * options in the customizer
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup\Customizer\Content;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

/**
 * Search customizer
 *
 * The sections, settings and controls for our search
 * options in the customizer
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			Jentil 0.1.0
 */
class Search {
    /**
     * Content customizer
     *
     * @since       Jentil 0.1.0
     * @access      private
     * 
     * @var     \GrottoPress\Jentil\Setup\Customizer\Content\Content      $content    Content customizer object
     */
    private $content;

    /**
     * Name as used in setting
     *
     * @since       Jentil 0.1.0
     * @access      private
     * 
     * @var     string      $name       Name
     */
    private $name;

    /**
     * Section name
     *
     * @since       Jentil 0.1.0
     * @access      private
     * 
     * @var     string      $name       Name
     */
    private $section;
    
    /**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function __construct( Content $content ) {
	    $this->content = $content;

        $this->name = 'search';
        $this->section = $this->name . '_content';
	}
    
    /**
     * Add search content section
     * 
     * @see         https://code.tutsplus.com/tutorials/wordpress-theme-customizer-methodology-for-sections-settings-and-controls-part-1--wp-33238
     * 
     * @since       Jentil 0.1.0
	 * @access      public
     */
    public function add_section( $wp_customize ) {
        $wp_customize->add_section(
            $this->section,
            array(
                'title'     => esc_html__( 'Search Content', 'jentil' ),
                //'priority'  => 99,
            )
        );
    }
    
    /**
     * Add search content settings
     * 
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function add_settings( $wp_customize ) {
        $this->add_class_setting( $wp_customize );
        $this->add_layout_control( $wp_customize );
        $this->add_number_setting( $wp_customize );
        $this->add_before_title_setting( $wp_customize );
        $this->add_title_setting( $wp_customize );
        $this->add_title_position_setting( $wp_customize );
        $this->add_after_title_setting( $wp_customize );
        $this->add_thumbnail_setting( $wp_customize );
        $this->add_thumbnail_alignment_setting( $wp_customize );
        $this->add_text_offset_setting( $wp_customize );
        $this->add_excerpt_setting( $wp_customize );
        $this->add_after_content_setting( $wp_customize );
        $this->add_pagination_setting( $wp_customize );
    }
    
    /**
     * Add wrapper class setting
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_class_setting( $wp_customize ) {
        $wp_customize->add_setting(
            $this->content->template()->content()->class_name( $this->name ),
            array(
                'default'    =>  'archive-posts',
                //'transport'  =>  'postMessage',
            )
        );
    }

    /**
     * Add layout setting
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_layout_setting( $wp_customize ) {
        $wp_customize->add_setting(
            $this->content->template()->content()->layout_name( $this->name ),
            array(
                'default'    =>  'stack',
                //'transport'  =>  'postMessage',
            )
        );
    }

    /**
     * Add number setting
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_number_setting( $wp_customize ) {
        $wp_customize->add_setting(
            $this->content->template()->content()->number_name( $this->name ),
            array(
                'default'    =>  ( int ) get_option( 'posts_per_page' ),
                //'transport'  =>  'postMessage',
            )
        );
    }
    
    /**
     * Add before title setting
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_before_title_setting( $wp_customize ) {
        $wp_customize->add_setting(
            $this->content->template()->content()->before_title_name( $this->name ),
            array(
                'default'    =>  '',
                //'transport'  =>  'postMessage',
            )
        );
    }
    
    /**
     * Add title length setting
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_title_setting( $wp_customize ) {
        $wp_customize->add_setting(
            $this->content->template()->content()->title_words_name( $this->name ),
            array(
                'default'    =>  -1,
                //'transport'  =>  'postMessage',
            )
        );
    }
    
    /**
     * Add title position setting
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_title_position_setting( $wp_customize ) {
        $wp_customize->add_setting(
            $this->content->template()->content()->title_position_name( $this->name ),
            array(
                'default'    =>  'top',
                //'transport'  =>  'postMessage',
            )
        );
    }
    
    /**
     * Add after title setting
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_after_title_setting( $wp_customize ) {
        $wp_customize->add_setting(
            $this->content->template()->content()->after_title_name( $this->name ),
            array(
                'default'    =>  'post_type,published_date',
                //'transport'  =>  'postMessage',
            )
        );
    }
    
    /**
     * Add image size setting
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_thumbnail_setting( $wp_customize ) {
        $wp_customize->add_setting(
            $this->content->template()->content()->thumbnail_name( $this->name ),
            array(
                'default'    =>  'nano-thumb',
                //'transport'  =>  'postMessage',
            )
        );
    }
    
    /**
     * Add image alignment setting
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_thumbnail_alignment_setting( $wp_customize ) {
        $wp_customize->add_setting(
            $this->content->template()->content()->thumbnail_alignment_name( $this->name ),
            array(
                'default'    =>  'left',
                //'transport'  =>  'postMessage',
            )
        );
    }
    
    /**
     * Add text offset setting
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_text_offset_setting( $wp_customize ) {
        $wp_customize->add_setting(
            $this->content->template()->content()->text_offset_name( $this->name ),
            array(
                'default'    =>  0,
                //'transport'  =>  'postMessage',
            )
        );
    }
    
    /**
     * Add excerpt length setting
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_excerpt_setting( $wp_customize ) {
        $wp_customize->add_setting(
            $this->content->template()->content()->excerpt_name( $this->name ),
            array(
                'default'    =>  '200',
                //'transport'  =>  'postMessage',
            )
        );
    }
    
    /**
     * Add after content setting
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_after_content_setting( $wp_customize ) {
        $wp_customize->add_setting(
            $this->content->template()->content()->after_content_name( $this->name ),
            array(
                'default'    =>  'category,post_tag',
                //'transport'  =>  'postMessage',
            )
        );
    }
    
    /**
     * Add pagination setting
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_pagination_setting( $wp_customize ) {
        $wp_customize->add_setting(
            $this->content->template()->content()->pagination_name( $this->name ),
            array(
                'default'    =>  'bottom',
                //'transport'  =>  'postMessage',
            )
        );
    }
    
    /**
     * Add controls
     * 
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function add_controls( $wp_customize ) {
        $this->add_class_control( $wp_customize );
        $this->add_layout_control( $wp_customize );
        $this->add_number_control( $wp_customize );
        $this->add_before_title_control( $wp_customize );
        $this->add_title_control( $wp_customize );
        $this->add_title_position_control( $wp_customize );
        $this->add_after_title_control( $wp_customize );
        $this->add_thumbnail_control( $wp_customize );
        $this->add_thumbnail_alignment_control( $wp_customize );
        $this->add_text_offset_control( $wp_customize );
        $this->add_excerpt_control( $wp_customize );
        $this->add_after_content_control( $wp_customize );
        $this->add_pagination_control( $wp_customize );
    }
    
    /**
     * Add 'class' control
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_class_control( $wp_customize ) {
        $wp_customize->add_control(
            $this->content->template()->content()->class_name( $this->name ),
            array(
                'section'   => $this->section,
                'label'     => esc_html__( 'Wrapper class', 'jentil' ),
                'type'      => 'text',
            )
        );
    }

    /**
     * Add 'layout' control
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_layout_control( $wp_customize ) {
        $wp_customize->add_control(
            $this->content->template()->content()->layout_name( $this->name ),
            array(
                'section'   => $this->section,
                'label'     => esc_html__( 'Layout', 'jentil' ),
                'type'      => 'select',
                'choices'   => $this->content->layouts()
            )
        );
    }

    /**
     * Add 'number' control
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_number_control( $wp_customize ) {
        $wp_customize->add_control(
            $this->content->template()->content()->number_name( $this->name ),
            array(
                'section'   => $this->section,
                'label'     => esc_html__( 'Number', 'jentil' ),
                'type'      => 'number',
            )
        );
    }
    
    /**
     * Add 'before title' control
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_before_title_control( $wp_customize ) {
        $wp_customize->add_control(
            $this->content->template()->content()->before_title_name( $this->name ),
            array(
                'section'   => $this->section,
                'label'     => esc_html__( 'Before title', 'jentil' ),
                'type'      => 'text',
            )
        );
    }
    
    /**
     * Add title control
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_title_control( $wp_customize ) {
        $wp_customize->add_control(
            $this->content->template()->content()->title_words_name( $this->name ),
            array(
                'section'   => $this->section,
                'label'     => esc_html__( 'Title length', 'jentil' ),
                'type'      => 'number',
            )
        );
    }
    
    /**
     * Add title position control
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_title_position_control( $wp_customize ) {
        $wp_customize->add_control(
            $this->content->template()->content()->title_position_name( $this->name ),
            array(
                'section'   => $this->section,
                'label'     => esc_html__( 'Title position', 'jentil' ),
                'type'      => 'select',
                'choices'   => $this->content->title_positions(),
            )
        );
    }
    
    /**
     * Add 'after title' control
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_after_title_control( $wp_customize ) {
        $wp_customize->add_control(
            $this->content->template()->content()->after_title_name( $this->name ),
            array(
                'section'   => $this->section,
                'label'     => esc_html__( 'After title', 'jentil' ),
                'type'      => 'text',
            )
        );
    }
    
    /**
     * Add thumbnail control
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_thumbnail_control( $wp_customize ) {
        $wp_customize->add_control(
            $this->content->template()->content()->thumbnail_name( $this->name ),
            array(
                'section'   => $this->section,
                'label'     => esc_html__( 'Image size', 'jentil' ),
                'type'      => 'text',
            )
        );
    }
    
    /**
     * Add thumbnail alignment control
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_thumbnail_alignment_control( $wp_customize ) {
        $wp_customize->add_control(
            $this->content->template()->content()->thumbnail_alignment_name( $this->name ),
            array(
                'section'   => $this->section,
                'label'     => esc_html__( 'Align image', 'jentil' ),
                'type'      => 'select',
                'choices'   => $this->content->image_alignments(),
            )
        );
    }
    
    /**
     * Add 'text offset' control
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_text_offset_control( $wp_customize ) {
        $wp_customize->add_control(
            $this->content->template()->content()->text_offset_name( $this->name ),
            array(
                'section'   => $this->section,
                'label'     => esc_html__( 'Text offset from image side', 'jentil' ),
                'type'      => 'number',
            )
        );
    }
    
    /**
     * Add excerpt control
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_excerpt_control( $wp_customize ) {
        $wp_customize->add_control(
            $this->content->template()->content()->excerpt_name( $this->name ),
            array(
                'section'   => $this->section,
                'label'     => esc_html__( 'Excerpt length', 'jentil' ),
                'type'      => 'text',
            )
        );
    }
    
    /**
     * Add 'after content' control
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_after_content_control( $wp_customize ) {
        $wp_customize->add_control(
            $this->content->template()->content()->after_content_name( $this->name ),
            array(
                'section'   => $this->section,
                'label'     => esc_html__( 'After content', 'jentil' ),
                'type'      => 'text',
            )
        );
    }
    
    /**
     * Add pagination control
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_pagination_control( $wp_customize ) {
        $wp_customize->add_control(
            $this->content->template()->content()->pagination_name( $this->name ),
            array(
                'section'   => $this->section,
                'label'     => esc_html__( 'Show pagination', 'jentil' ),
                'type'      => 'select',
                'choices'   => $this->content->pagination_positions(),
            )
        );
    }
}