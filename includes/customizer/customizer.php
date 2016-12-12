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

namespace GrottoPress\Jentil\Customizer;

/**
 * Customizer
 *
 * The sections, settings and controls for our theme
 * options in the customizer
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			jentil 0.1.0
 */
class Customizer {
    /**
     * Layout customizer
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 * 
	 * @var         \GrottoPress\Jentil\Customizer\Layout         $layout       Layout customizer
	 */
    private $layout;
    
    /**
     * Footer credits customizer
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 * 
	 * @var         \GrottoPress\Jentil\Customizer\Credits         $credits       Footer credits customizer
	 */
    //private $credits;
    
    /**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function __construct() {
        $this->layout = new Layout();
        //$this->credits = new Credits();
	}
    
    /**
     * Register theme customizer
     * 
     * @action      customize_register
     * 
     * @see         https://code.tutsplus.com/tutorials/a-guide-to-the-wordpress-theme-customizer-adding-a-new-setting--wp-33180
     * 
     * @since       Jentil 0.1.0
	 * @access      public
     */
    public function register( $wp_customize ) {
        $this->add_sections( $wp_customize );
        $this->add_settings( $wp_customize );
        $this->add_controls( $wp_customize );
    }
    
    /**
     * Add settings
     * 
     * @since       Jentil 0.1.0
	 * @access      private
     */
    private function add_settings( $wp_customize ) {
        $this->layout->add_settings( $wp_customize );
         //$this->credits->add_settings( $wp_customize );
    }
    
    /**
     * Add controls
     * 
     * @since       Jentil 0.1.0
	 * @access      private
     */
    private function add_controls( $wp_customize ) {
        $this->layout->add_controls( $wp_customize );
        //$this->credits->add_controls( $wp_customize );
    }
    
    /**
     * Add sections
     * 
     * @since       Jentil 0.1.0
	 * @access      private
     */
    private function add_sections( $wp_customize ) {
        $this->layout->add_section( $wp_customize );
        //$this->credits->add_section( $wp_customize );
    }
    
    /**
     * Live preview
     * 
     * @action      customize_preview_init
     * 
     * @since       Jentil 0.1.0
	 * @access      public
     */
    public function live_preview() {
        wp_enqueue_script( 'jentil-customizer',
        get_template_directory_uri() . '/assets/javascript/customizer.js',
            array( 'jquery', 'customize-preview' ),
            '',
            true
        );
    }
}