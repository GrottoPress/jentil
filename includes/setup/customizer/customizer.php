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

use \GrottoPress\MagPack\Utilities\Singleton as Singleton;

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
class Customizer extends Singleton {
    /**
     * Layout customizer
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 * 
	 * @var         \GrottoPress\Jentil\Setup\Customizer\Layout         $layout       Layout customizer
	 */
    private $layout;
    
    /**
     * Colophon customizer
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 * 
	 * @var         \GrottoPress\Jentil\Setup\Customizer\Colophon         $colophon       Colophon
	 */
    private $colophon;
    
    /**
     * Logo customizer
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 * 
	 * @var         \GrottoPress\Jentil\Setup\Customizer\Logo         $logo           Logo
	 */
    private $logo;
    
    /**
     * Content customizer
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 * 
	 * @var         \GrottoPress\Jentil\Setup\Customizer\Content\Content         $content           Content
	 */
    private $content;
    
    /**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	protected function __construct() {
        $this->layout = new Layout( $this );
        $this->colophon = new Colophon( $this );
        $this->logo = new Logo( $this );
        $this->content = new Content\Content( $this );
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
        $this->colophon->add_settings( $wp_customize );
        $this->logo->add_settings( $wp_customize );
        $this->content->add_settings( $wp_customize );
    }
    
    /**
     * Add controls
     * 
     * @since       Jentil 0.1.0
	 * @access      private
     */
    private function add_controls( $wp_customize ) {
        $this->layout->add_controls( $wp_customize );
        $this->colophon->add_controls( $wp_customize );
        $this->logo->add_controls( $wp_customize );
        $this->content->add_controls( $wp_customize );
    }
    
    /**
     * Add sections
     * 
     * @since       Jentil 0.1.0
	 * @access      private
     */
    private function add_sections( $wp_customize ) {
        $this->layout->add_section( $wp_customize );
        $this->colophon->add_section( $wp_customize );
        $this->content->add_sections( $wp_customize );
    }
    
    /**
     * Enqueue scripts
     * 
     * @action      customize_preview_init
     * 
     * @since       Jentil 0.1.0
	 * @access      public
     */
    public function enqueue_scripts() {
        wp_enqueue_script( 'jentil-customizer',
        get_template_directory_uri() . '/assets/javascript/customizer.js',
            array( 'jquery', 'customize-preview' ),
            '',
            true
        );
    }
}