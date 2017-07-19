<?php

/**
 * Content customizer sections template
 *
 * The sections, settings and controls for our Content
 * sections in the customizer.
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes/setup
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup\Customizer\Posts;

if ( ! defined( 'WPINC' ) ) {
    die;
}

use GrottoPress\Jentil\Setup;

/**
 * Content customizer sections template
 *
 * The sections, settings and controls for our Content
 * sections in the customizer
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes/setup
 * @since			Jentil 0.1.0
 */
abstract class Section extends Setup\Customizer\Section {
    /**
     * Pagination types
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var     array      $pagination_types       Pagination types
     */
    protected $pagination_types;

    /**
     * Pagination positions
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var     array      $pagination_positions       Pagination positions
     */
    protected $pagination_positions;

    /**
     * Title positions
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var     array      $title_positions       Title positions
     */
    protected $title_positions;

    /**
     * Layouts
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var     array      $layouts       Layouts
     */
    protected $layouts;

    /**
     * Image alignments
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var     array      $image_alignments       Image alignments
     */
    protected $image_alignments;

    /**
     * Mod args
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var     array      $mod_args       Arguments to pass to mod
     */
    protected $mod_args;

    /**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      protected
	 */
	protected function __construct( Posts $posts ) {
       $this->posts = $posts;

       parent::__construct( $this->posts->get( 'customizer' ) );

       $this->title_positions = [
            'side' => esc_html__( 'Side', 'jentil' ),
            'top' => esc_html__( 'Top', 'jentil' ),
        ];

        $this->image_alignments = [
            'none' => esc_html__( 'none', 'jentil' ),
            'left' => esc_html__( 'Left', 'jentil' ),
            'right' => esc_html__( 'Right', 'jentil' ),
        ];

        $this->pagination_positions = [
            'none' => esc_html__( 'None', 'jentil' ),
            'top' => esc_html__( 'Top', 'jentil' ),
            'bottom' => esc_html__( 'Bottom', 'jentil' ),
            'top_bottom' => esc_html__( 'Top and bottom', 'jentil' ),
        ];

        $this->pagination_types = [
            'normal' => esc_html__( 'Default', 'jentil' ),
            'infinite_scroll' => esc_html__( 'infinite_scroll', 'jentil' ),
        ];

        $this->layouts = array(
            'stack' => esc_html__( 'Stack', 'jentil' ),
            'grid' => esc_html__( 'Grid', 'jentil' ),
        );

        $this->args = array(
            'title' => esc_html__( 'Posts', 'jentil' ),
            'panel' => $this->posts->get( 'name' ),
        );

        $this->mod_args = array(
            'context' => '',
            'specific' => '',
            'more_specific' => '',
        );
	}

    /**
     * Allow get
     *
     * Defines the attributes that can be retrieved
     * with our getter.
     *
     * @since       MagPack 0.1.0
     * @access      protected
     *
     * @return      array       Attributes.
     */
    protected function allow_get() {
        return array_merge( parent::allow_get(), array(
            'pagination_positions',
            'title_positions',
            'pagination_types',
            'layouts',
            'image_alignments',
            'mod_args',
        ) );
    }

	/**
     * Get settings
     *
     * @since       Jentil 0.1.0
     * @access      protected
     */
    protected function settings() {
        $settings = [];

        $settings['wrap_class'] = new Settings\Wrap_Class( $this );
        // $settings['wrap_tag'] = new Settings\Wrap_Tag( $this );
        // $settings['layout'] = new Settings\Layout( $this );
        $settings['before_title'] = new Settings\Before_Title( $this );
        $settings['before_title_separator'] = new Settings\Before_Title_Separator( $this );
        $settings['title_words'] = new Settings\Title_Words( $this );
        $settings['title_position'] = new Settings\Title_Position( $this );
        $settings['after_title'] = new Settings\After_Title( $this );
        $settings['after_title_separator'] = new Settings\After_Title_Separator( $this );
        $settings['image'] = new Settings\Image( $this );
        $settings['image_alignment'] = new Settings\Image_Alignment( $this );
        $settings['image_margin'] = new Settings\Image_Margin( $this );
        $settings['text_offset'] = new Settings\Text_Offset( $this );
        $settings['excerpt'] = new Settings\Excerpt( $this );
        $settings['more_link'] = new Settings\More_Link( $this );
        $settings['after_content'] = new Settings\After_Content( $this );
        $settings['after_content_separator'] = new Settings\After_Content_Separator( $this );
        
        return $settings;
    }
}