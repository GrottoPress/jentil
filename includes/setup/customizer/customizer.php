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

use GrottoPress\MagPack\Utilities\Singleton;
use GrottoPress\Jentil\Utilities\Template\Template;

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
class Customizer extends Singleton {
    /**
     * Customizer sections
     *
     * @since       Jentil 0.1.0
     * @access      private
     * 
     * @var         array         $sections           Sections
     */
    private $sections;

    /**
     * Post types
     *
     * @since       Jentil 0.1.0
     * @access      private
     * 
     * @var     array      $post_types       Post types
     */
    private $post_types;

    /**
     * Taxonomies
     *
     * @since       Jentil 0.1.0
     * @access      private
     * 
     * @var     array      $taxonomies       Taxonomies
     */
    private $taxonomies;

    /**
     * Template instance
     *
     * @since       Jentil 0.1.0
     * @access      private
     * 
     * @var         \GrottoPress\Jentil\Utilities\Template\Template        $template         Template
     */
    private $template;
    
    /**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      protected
	 */
	protected function __construct() {
        $this->post_types = get_post_types( array(
            'public' => true,
            'show_ui' => true,
        ), 'objects' );
        $this->taxonomies = get_taxonomies( array(
            'public' => true,
            'show_ui' => true,
        ), 'objects' );
        $this->template = new Template();

        $this->sections = $this->sections();
	}

    /**
     * Get attributes
     *
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function get( $attribute ) {
        $disallow = array( 'sections' );

        if ( in_array( $attribute, $disallow ) ) {
            return null;
        }

        return $this->$attribute;
    }

    /**
     * Get sections
     *
     * @since       Jentil 0.1.0
     * @access      public
     */
    private function sections() {
        $sections = array();

        $sections[] = new Colophon\Colophon( $this );
        $sections[] = new Layout\Layout( $this );
        $sections[] = new Logo\Logo( $this );
        $sections[] = new Content\Sticky( $this );
        $sections[] = new Content\Author( $this );
        $sections[] = new Content\Date( $this );
        $sections[] = new Content\Search( $this );

        if ( $this->taxonomies ) {
            foreach ( $this->taxonomies as $taxonomy ) {
                $sections[] = new Content\Taxonomy( $this, $taxonomy );
            }
        }

        if ( $this->post_types ) {
            foreach ( $this->post_types as $post_type ) {
                if (
                    $post_type->has_archive
                    || (
                        'post' == $post_type->name
                        && post_type_exists( 'post' )
                    )
                ) {
                    $sections[] = new Content\Post_Type( $this, $post_type );
                }
            }
        }

        return $sections;
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
        if ( empty( $this->sections ) ) {
            return;
        }

        foreach ( $this->sections as $section ) {
            $section->add( $wp_customize );
        }
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
            get_template_directory_uri() . '/assets/javascript/customizer.js',
            array( 'jquery', 'customize-preview' ),
            '',
            true
        );
    }
}