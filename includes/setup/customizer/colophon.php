<?php

/**
 * Colophon customizer
 *
 * The sections, settings and controls for our colophon
 * options in the customizer
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup\Customizer;

/**
 * Colophon customizer
 *
 * The sections, settings and controls for our colophon
 * options in the customizer
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			jentil 0.1.0
 */
class Colophon {
    /**
     * Customizer
     *
     * @since       Jentil 0.1.0
     * @access      private
     * 
     * @var     \GrottoPress\Jentil\Setup\Customizer\Customizer     $customizer       Customizer instance
     */
    private $customizer;

    /**
     * Default layout
	 *
	 * @since       Jentil 0.1.0
	 * @access      private
	 * 
	 * @var         array         $default       Default layout
	 */
    private $default;
    
    /**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function __construct( Customizer $customizer ) {
        $this->customizer = $customizer;

        $this->default = sprintf( esc_html__( '&copy; %1$s %2$s. All Rights Reserved.', 'jentil' ),
            '<span itemprop="copyrightYear">{{this_year}}</span>',
            '<a class="blog-name" itemprop="url" href="{{site_url}}"><span itemprop="copyrightHolder">{{site_name}}</span></a>' );
	}
    
    /**
     * Add colophon section
     * 
     * @see         https://code.tutsplus.com/tutorials/wordpress-theme-customizer-methodology-for-sections-settings-and-controls-part-1--wp-33238
     * 
     * @since       Jentil 0.1.0
	 * @access      public
     */
    public function add_section( $wp_customize ) {
        $wp_customize->add_section(
            'colophon',
            array(
                'title'     => esc_html__( 'Colophon', 'jentil' ),
                //'priority'  => 200,
            )
        );
    }
    
    /**
     * Add colophon settings
     * 
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function add_settings( $wp_customize ) {
        $this->add_colophon_setting( $wp_customize );
    }
    
    /**
     * Add colophon setting
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_colophon_setting( $wp_customize ) {
        $wp_customize->add_setting(
            'colophon',
            array(
                'default'    =>  $this->default,
                'transport'  =>  'postMessage',
            )
        );
    }
    
    /**
     * Add colophon controls
     * 
     * @since       Jentil 0.1.0
     * @access      public
     */
    public function add_controls( $wp_customize ) {
        $this->add_colophon_control( $wp_customize );
    }
    
    /**
     * Add category layout control
     * 
     * @since       Jentil 0.1.0
     * @access      private
     */
    private function add_colophon_control( $wp_customize ) {
        $wp_customize->add_control(
            'colophon',
            array(
                'section'   => 'colophon',
                'label'     => esc_html__( 'Colophon', 'jentil' ),
                'type'      => 'text',
            )
        );
    }
}