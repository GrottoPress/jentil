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

namespace GrottoPress\Jentil\Setup\Customizer\Content\Sections;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
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
     * Default
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var     array      $default       Default settings
     */
    protected $default;

    /**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      protected
	 */
	protected function __construct( Setup\Customizer\Content\Content $content ) {
       $this->content = $content;

       parent::__construct( $this->content->get( 'customizer' ) );

       $this->title_positions = array(
            'side' => esc_html__( 'Side', 'jentil' ),
            'top' => esc_html__( 'Top', 'jentil' ),
        );

        $this->image_alignments = array(
            'none' => esc_html__( 'none', 'jentil' ),
            'left' => esc_html__( 'Left', 'jentil' ),
            'right' => esc_html__( 'Right', 'jentil' ),
        );

        $this->pagination_positions = array(
            'none' => esc_html__( 'None', 'jentil' ),
            'top' => esc_html__( 'Top', 'jentil' ),
            'bottom' => esc_html__( 'Bottom', 'jentil' ),
            'top_bottom' => esc_html__( 'Top and bottom', 'jentil' ),
        );

        $this->pagination_types = array(
            'normal' => esc_html__( 'Default', 'jentil' ),
            'infinite_scroll' => esc_html__( 'infinite_scroll', 'jentil' ),
        );

        $this->layouts = array(
            'stack' => esc_html__( 'Stack', 'jentil' ),
            'grid' => esc_html__( 'Grid', 'jentil' ),
        );

        $this->default = array(
            'wrap_class' => 'archive-posts big',
            'wrap_tag' => 'div',
            'layout' => 'stack',
            'number' => ( int ) get_option( 'posts_per_page' ),
            'before_title' => '',
            'before_title_separator' => ' | ',
            'title_words' => -1,
            'title_position' => 'side',
            'after_title' => 'published_date, comments_link',
            'after_title_separator' => ' | ',
            'image' => 'mini-thumb',
            'image_alignment' => 'left',
            'image_margin' => '',
            'text_offset' => 0,
            'excerpt' => 300,
            'more_link' => 'read more',
            'after_content' => 'category, post_tag',
            'after_content_separator' => ' | ',
            'pagination' => '',
            'pagination_maximum' => -1,
            'pagination_position' => 'bottom',
            'pagination_previous_label' => __( '&larr; Previous', 'jentil' ),
            'pagination_next_label' => __( 'Next &rarr;', 'jentil' ),
            'sticky_posts' => 1,
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
            'default',
            'pagination_positions',
            'title_positions',
            'pagination_types',
            'layouts',
            'image_alignments',
        ) );
    }

	/**
     * Get settings
     *
     * @since       Jentil 0.1.0
     * @access      protected
     */
    protected function settings() {
        $settings = array();

        $settings[] = new Setup\Customizer\Content\Settings\Wrap_Class( $this );
        $settings[] = new Setup\Customizer\Content\Settings\Wrap_Tag( $this );
        $settings[] = new Setup\Customizer\Content\Settings\Layout( $this );
        $settings[] = new Setup\Customizer\Content\Settings\Number( $this );
        $settings[] = new Setup\Customizer\Content\Settings\Before_Title( $this );
        $settings[] = new Setup\Customizer\Content\Settings\Before_Title_Separator( $this );
        $settings[] = new Setup\Customizer\Content\Settings\Title_Words( $this );
        $settings[] = new Setup\Customizer\Content\Settings\Title_Position( $this );
        $settings[] = new Setup\Customizer\Content\Settings\After_Title( $this );
        $settings[] = new Setup\Customizer\Content\Settings\After_Title_Separator( $this );
        $settings[] = new Setup\Customizer\Content\Settings\Image( $this );
        $settings[] = new Setup\Customizer\Content\Settings\Image_Alignment( $this );
        $settings[] = new Setup\Customizer\Content\Settings\Image_Margin( $this );
        $settings[] = new Setup\Customizer\Content\Settings\Text_Offset( $this );
        $settings[] = new Setup\Customizer\Content\Settings\Excerpt( $this );
        $settings[] = new Setup\Customizer\Content\Settings\More_Link( $this );
        $settings[] = new Setup\Customizer\Content\Settings\After_Content( $this );
        $settings[] = new Setup\Customizer\Content\Settings\After_Content_Separator( $this );
        $settings[] = new Setup\Customizer\Content\Settings\Pagination( $this );
        $settings[] = new Setup\Customizer\Content\Settings\Pagination_Maximum( $this );
        $settings[] = new Setup\Customizer\Content\Settings\Pagination_Position( $this );
        $settings[] = new Setup\Customizer\Content\Settings\Pagination_Previous_Label( $this );
        $settings[] = new Setup\Customizer\Content\Settings\Pagination_Next_Label( $this );

        return $settings;
    }
}