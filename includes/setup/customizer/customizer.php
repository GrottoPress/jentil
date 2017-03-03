<?php

/**
 * Customizer
 *
 * The sections, settings and controls for our theme
 * options in the customizer
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup\Customizer;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\MagPack;
use GrottoPress\Jentil\Utilities;

/**
 * Customizer
 *
 * The sections, settings and controls for our theme
 * options in the customizer
 *
 * @see         https://code.tutsplus.com/tutorials/a-guide-to-the-wordpress-theme-customizer-adding-a-new-setting--wp-33180
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			jentil 0.1.0
 */
final class Customizer extends MagPack\Utilities\Singleton {
    /**
     * Customizer panels
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var         array         $panels           Panels
     */
    protected $panels;

    /**
     * Customizer sections
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var         array         $sections           Sections
     */
    protected $sections;

    /**
     * Post types
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var     array      $post_types       Post types
     */
    protected $post_types;

    /**
     * Taxonomies
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var     array      $taxonomies       Taxonomies
     */
    protected $taxonomies;

    /**
     * Template instance
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var         \GrottoPress\Jentil\Utilities\Template\Template        $template         Template
     */
    protected $template;

    /**
     * Constructor
     *
     * @since       Jentil 0.1.0
     * @access      public
     */
    protected function __construct() {}

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
        return array( 'template', 'post_types', 'taxonomies' );
    }

    /**
     * Register theme customizer
     * 
     * @action      customize_register
     * 
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function add( $wp_customize ) {
        $this->template = new Utilities\Template\Template();

        $this->post_types = get_post_types( array(
            'public' => true,
            'show_ui' => true,
        ), 'objects' );

        $this->taxonomies = get_taxonomies( array(
            'public' => true,
            'show_ui' => true,
        ), 'objects' );

        $this->panels = $this->panels();

        if ( $this->panels ) {
            foreach ( $this->panels as $panel ) {
                $panel->add( $wp_customize );
            }
        }

        $this->sections = $this->sections();

        if ( $this->sections ) {
            foreach ( $this->sections as $section ) {
                $section->add( $wp_customize );
            }
        }
    }

    /**
     * Get panels
     *
     * Panels comprise sections which, in turn,
     * comprise settings.
     *
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function panels() {
        $panels = array();

        $panels[] = new Posts\Posts( $this );

        return $panels;
    }

    /**
     * Get sections
     *
     * These sections come under no panel. Each section
     * comprises its settings.
     *
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function sections() {
        $sections = array();

        $sections[] = new Logo\Logo( $this );
        $sections[] = new Title\Title( $this );
        $sections[] = new Layout\Layout( $this );
        $sections[] = new Colophon\Colophon( $this );

        return $sections;
    }
    
    /**
     * Enqueue scripts
     * 
     * @action      customize_preview_init
     * 
     * @since       Jentil 0.1.0
	 * @access      public
     */
    public function enqueue() {
        wp_enqueue_script(
            'jentil-customizer',
            get_template_directory_uri() . '/assets/javascript/customize-preview.js',
            array( 'jquery', 'customize-preview' ),
            '',
            true
        );
    }
}