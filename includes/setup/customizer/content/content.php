<?php

/**
 * Content customizer sections
 *
 * The sections, settings and controls for our Content
 * sections in the customizer.
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

use GrottoPress\Jentil\Setup\Customizer;

/**
 * Content customizer sections
 *
 * The sections, settings and controls for our Content
 * sections in the customizer
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			jentil 0.1.0
 */
class Content extends Customizer\Section {
    /**
     * Context
     *
     * @since       Jentil 0.1.0
     * @access      private
     * 
     * @var     array      $context       Context
     */
    private $context;

    /**
	 * Constructor
     *
     * @var         array          $context      Type of content section to add
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function __construct( Customizer\Customizer $customizer, $context ) {
        $this->context = $context;
        $this->name = sanitize_key( $this->context['name'] . '_content' );
        $this->args = array(
            'title' => sprintf( esc_html__( '%s Content', 'jentil' ), $this->context['title'] ),
            //'priority' => ( int ) $this->context['priority'],
        );

        parent::__construct( $customizer );
	}

    /**
     * Get context
     *
     * @since       Jentil 0.1.0
     * @access      public
     */
    // public function context() {
    //     return $this->context;
    // }

	/**
     * Get settings
     *
     * @since       Jentil 0.1.0
     * @access      protected
     */
    protected function settings() {
        $settings = array();

        if ( 'sticky_posts' != $this->context['name'] ) {
            $settings[] = new Sticky_Posts( $this );
        }

        $settings[] = new Wrap_Class( $this );
        $settings[] = new Layout( $this );
        $settings[] = new Number( $this );
        $settings[] = new Before_Title( $this );
        $settings[] = new Title_Words( $this );
        $settings[] = new Title_Position( $this );
        $settings[] = new After_Title( $this );
        $settings[] = new Image( $this );
        $settings[] = new Image_Alignment( $this );
        $settings[] = new Image_Margin( $this );
        $settings[] = new Text_Offset( $this );
        $settings[] = new Excerpt( $this );
        $settings[] = new After_Content( $this );
        $settings[] = new Pagination_Position( $this );

        return $settings;
    }

	/**
     * Title positions
     * 
     * @since		Jentil 0.1.0
     * @access      public
     * 
     * @return      array          Title positions
     */
    public function title_positions() {
        return array(
            'side' => esc_html__( 'Side', 'jentil' ),
            'top' => esc_html__( 'Top', 'jentil' ),
        );
    }
    
    /**
     * Image alignments
     * 
     * @since		Jentil 0.1.0
     * @access      public
     * 
     * @return      array          Image alignments
     */
    public function image_alignments() {
        return array(
            'none' => esc_html__( 'none', 'jentil' ),
            'left' => esc_html__( 'Left', 'jentil' ),
            'right' => esc_html__( 'Right', 'jentil' ),
        );
    }
    
    /**
     * Pagination positions
     * 
     * @since		Jentil 0.1.0
     * @access      public
     * 
     * @return      array          Pagination positions
     */
    public function pagination_positions() {
        return array(
            'none' => esc_html__( 'None', 'jentil' ),
            'top' => esc_html__( 'Top', 'jentil' ),
            'bottom' => esc_html__( 'Bottom', 'jentil' ),
            'top_bottom' => esc_html__( 'Top and bottom', 'jentil' ),
        );
    }

    /**
     * Layouts
     * 
     * @since		Jentil 0.1.0
     * @access      public
     * 
     * @return      array          Layouts
     */
    public function layouts() {
        return array(
            'stack' => esc_html__( 'Stack', 'jentil' ),
            'grid' => esc_html__( 'Grid', 'jentil' ),
        );
    }
}