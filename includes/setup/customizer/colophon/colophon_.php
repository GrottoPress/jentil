<?php

/**
 * Colophon customizer setting
 *
 * Add settings and controls for our colophon
 * options in the customizer.
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup\Customizer\Colophon;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\Jentil\Setup\Customizer;

/**
 * Colophon customizer setting
 *
 * Add settings and controls for our colophon
 * options in the customizer.
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			jentil 0.1.0
 */
class Colophon_ extends Customizer\Setting {
    /**
     * Colophon section
     *
     * @since       Jentil 0.1.0
     * @access      private
     * 
     * @var     \GrottoPress\Jentil\Setup\Customizer\Colophon\Colophon     $colophon       Colophon section instance
     */
    private $colophon;
    
    /**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function __construct( Customizer\Colophon\Colophon $colophon ) {
        $this->colophon = $colophon;
        $this->name = 'colophon';
        $this->args = array(
            'default'    =>  sprintf( esc_html__( 'Copyright &copy; %1$s %2$s. All Rights Reserved.', 'jentil' ),
                '<span itemprop="copyrightYear">{{this_year}}</span>',
                '<a class="blog-name" itemprop="url" href="{{site_url}}">
                    <span itemprop="copyrightHolder">{{site_name}}</span>
                </a>' ),
            'transport'  =>  'postMessage',
        );
        $this->control = array(
            'section'   => $this->colophon->name(),
            'label'     => esc_html__( 'Colophon', 'jentil' ),
            'type'      => 'text',
        );
	}
}