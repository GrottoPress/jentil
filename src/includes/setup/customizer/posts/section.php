<?php

/**
 * Section
 *
 * @package GrottoPress\Jentil\Setup\Customizer\Posts
 * @since 0.1.0
 *
 * @author GrottoPress (https://www.grottopress.com)
 * @author N Atta Kus Adusei (https://twitter.com/akadusei)
 */

declare ( strict_types = 1 );

namespace GrottoPress\Jentil\Setup\Customizer\Posts;

if ( ! \defined( 'WPINC' ) ) {
    die;
}

use GrottoPress\Jentil\Setup\Customizer\Section as C_Section;

/**
 * Section
 *
 * @since 0.1.0
 */
abstract class Section extends C_Section {
    /**
     * Constructor
     *
     * @since 0.1.0
     * @access protected
     *
     * @var array $mod_args Mod args.
     */
    protected $mod_args;

     /**
     * Constructor
     *
     * @var GrottoPress\Jentil\Setup\Posts\Posts $posts Posts.
     *
     * @since 0.1.0
     * @access protected
     */
    protected function __construct( Posts $posts ) {
        $this->posts = $posts;

        parent::__construct( $this->posts->customizer() );

        $this->args = [
            'title' => \esc_html__( 'Posts', 'jentil' ),
            'panel' => $this->posts->name(),
        ];

        $this->mod_args = [
            'context' => '',
            'specific' => '',
            'more_specific' => '',
        ];
        
    }

    /**
     * Title positions
     *
     * @since 0.1.0
     * @access public
     *
     * @return array Title positions.
     */
    // public function title_positions(): array {
    //     return [
    //         'side' => \esc_html__( 'Side', 'jentil' ),
    //         'top' => \esc_html__( 'Top', 'jentil' ),
    //     ];
    // }

    /**
     * Image alignments
     *
     * @since 0.1.0
     * @access public
     *
     * @return array Image alignments.
     */
    // public function image_alignments(): array {
    //     return [
    //         'none' => \esc_html__( 'none', 'jentil' ),
    //         'left' => \esc_html__( 'Left', 'jentil' ),
    //         'right' => \esc_html__( 'Right', 'jentil' ),
    //     ];
    // }

    /**
     * Pagination positions
     *
     * @since 0.1.0
     * @access public
     *
     * @return array Pagination positions.
     */
    // public function pagination_positions(): array {
    //     return [
    //         'none' => \esc_html__( 'None', 'jentil' ),
    //         'top' => \esc_html__( 'Top', 'jentil' ),
    //         'bottom' => \esc_html__( 'Bottom', 'jentil' ),
    //         'top_bottom' => \esc_html__( 'Top and bottom', 'jentil' ),
    //     ];
    // }

    /**
     * Layouts
     *
     * @since 0.1.0
     * @access public
     *
     * @return array Layouts.
     */
    // public function layouts(): array {
    //     return [
    //         'stack' => \esc_html__( 'Stack', 'jentil' ),
    //         'grid' => \esc_html__( 'Grid', 'jentil' ),
    //     ];
    // }

    /**
     * Posts
     *
     * @since 0.1.0
     * @access public
     *
     * @return GrottoPress\Jentil\Setup\Customizer\Posts\Posts Posts.
     */
    public function posts(): Posts {
        return $this->posts;
    }

    /**
     * Mod args
     *
     * @since 0.1.0
     * @access public
     *
     * @return array Mod args.
     */
    public function mod_args(): array {
        return $this->mod_args;
    }

    /**
     * Get settings
     *
     * @since       Jentil 0.1.0
     * @access      protected
     */
    protected function settings(): array {
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
