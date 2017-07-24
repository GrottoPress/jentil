<?php

/**
 * Logo
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup;

if ( ! defined( 'WPINC' ) ) {
    die;
}

use GrottoPress\MagPack;
use GrottoPress\Jentil\Utilities;

/**
 * Logo
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			jentil 0.1.0
 */
final class Logo {
    /**
     * Import traits
     *
     * @since       Jentil 0.1.0
     */
    use MagPack\Utilities\Wizard;

    /**
     * Jentil
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var         \GrottoPress\Jentil\Setup\Jentil         $jentil       Jentil
     */
    protected $jentil;

    /**
	 * Constructor
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function __construct( Jentil $jentil ) {
        $this->jentil = $jentil;
    }

    /**
     * Add theme support for custom logo.
     * 
     * @see         https://codex.wordpress.org/Theme_Logo
     * 
     * @since       Jentil 0.1.0
     * @since       WordPress 4.5
     * @access      public
     * 
     * @action      after_setup_theme
     */
    public function enable() {
        add_theme_support( 'custom-logo', Utilities\Logo::instance()->size() );
    }

    /**
     * Render logo
     *
     * @since       Jentil 0.1.0
	 * @access      public
	 *
	 * @action      jentil_inside_header
     */
    public function render() {
    	if ( function_exists( 'get_custom_logo' ) ) {
            echo get_custom_logo();
        } elseif ( ( $mod = Utilities\Logo::instance()->mod() ) ) {
            echo sprintf( '<a href=\'%1$s\' class=\'custom-logo-link\' rel=\'home\' itemprop=\'url\'>%2$s</a>',
                home_url( '/' ),
                wp_get_attachment_image( $mod, 'full', false, [
                    'class'    => 'custom-logo',
                    'itemprop' => 'logo',
                ] )
            );
        } elseif ( is_customize_preview() ) {
            echo '<a href="' . home_url( '/' ) . '" class="custom-logo-link js-logo-link" style="display:none;"><img class="custom-logo" itemprop="logo" /></a>';
        }
    }
}