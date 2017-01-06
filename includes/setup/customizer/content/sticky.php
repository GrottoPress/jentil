<?php

/**
 * Sticky content customizer
 *
 * The sections, settings and controls for our sticky
 * options in the customizer
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup\Customizer\Content;

/**
 * Sticky customizer
 *
 * The sections, settings and controls for our sticky
 * options in the customizer
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			Jentil 0.1.0
 */
class Sticky {
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
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function __construct( Content $content ) {
	    $this->content = $content;
	}
    
    /**
     * Add sticky content section
     * 
     * @see         https://code.tutsplus.com/tutorials/wordpress-theme-customizer-methodology-for-sections-settings-and-controls-part-1--wp-33238
     * 
     * @since       Jentil 0.1.0
	 * @access      public
     */
    public function add_section( $wp_customize ) {
        $wp_customize->add_section(
            'sticky_content',
            array(
                'title'     => esc_html__( 'Sticky Content', 'jentil' ),
                //'priority'  => 99,
            )
        );
    }
    
    /**
     * Add sticky content settings
     * 
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function add_settings( $wp_customize ) {
        $this->add_class_setting( $wp_customize );
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
            'sticky_class',
            array(
                'default'    =>  'sticky-posts big',
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
            'sticky_before_title',
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
            'sticky_title',
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
            'sticky_title_position',
            array(
                'default'    =>  'side',
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
            'sticky_after_title',
            array(
                'default'    =>  'published_date,comments_link',
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
            'sticky_thumbnail',
            array(
                'default'    =>  'post-thumbnail',
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
            'sticky_thumbnail_alignment',
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
            'sticky_text_offset',
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
            'sticky_excerpt',
            array(
                'default'    =>  '300',
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
            'sticky_after_content',
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
            'sticky_pagination',
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
            'sticky_class',
            array(
                'section'   => 'sticky_content',
                'label'     => esc_html__( 'Wrapper class', 'jentil' ),
                'type'      => 'text',
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
            'sticky_before_title',
            array(
                'section'   => 'sticky_content',
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
            'sticky_title',
            array(
                'section'   => 'sticky_content',
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
            'sticky_title_position',
            array(
                'section'   => 'sticky_content',
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
            'sticky_after_title',
            array(
                'section'   => 'sticky_content',
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
            'sticky_thumbnail',
            array(
                'section'   => 'sticky_content',
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
            'sticky_thumbnail_alignment',
            array(
                'section'   => 'sticky_content',
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
            'sticky_text_offset',
            array(
                'section'   => 'sticky_content',
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
            'sticky_excerpt',
            array(
                'section'   => 'sticky_content',
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
            'sticky_after_content',
            array(
                'section'   => 'sticky_content',
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
            'sticky_pagination',
            array(
                'section'   => 'sticky_content',
                'label'     => esc_html__( 'Show pagination', 'jentil' ),
                'type'      => 'select',
                'choices'   => $this->content->pagination_positions(),
            )
        );
    }
}