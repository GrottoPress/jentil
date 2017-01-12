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
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	protected function __construct() {
        $this->sections = $this->sections();
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
        // $sections[] = new Content\Content( $this );

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
        wp_enqueue_script( 'jentil-customizer',
        get_template_directory_uri() . '/assets/javascript/customizer.js',
            array( 'jquery', 'customize-preview' ),
            '',
            true
        );
    }
}