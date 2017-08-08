<?php

/**
 * Common posts customizer setting
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup\Customizer\Posts\Settings;

if ( ! defined( 'WPINC' ) ) {
    die;
}

use GrottoPress\Jentil\Setup;
use GrottoPress\Jentil\Utilities;

/**
 * Common posts customizer setting
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			Jentil 0.1.0
 */
abstract class Setting extends Setup\Customizer\Setting {
    /**
     * Content section
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var     \GrottoPress\Jentil\Setup\Customizer\Content\Content     $content     Content section instance
     */
    protected $content;

    /**
     * Mod
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var     \GrottoPress\Jentil\Utilities\Mod\Posts     $mod    Posts mod
     */
    protected $mod;
    
    /**
	 * Constructor
     *
     * @var         object      $content        Instance of section of this setting
	 *
	 * @since       Jentil 0.1.0
	 * @access      public
	 */
	public function __construct( Setup\Customizer\Posts\Section $content ) {
        $this->content = $content;
        
        $this->args = [];

        $this->control = [
            'section' => $this->content->get( 'name' ),
        ];
	}

    /**
     * Get mod
     *
     * @var     string      $setting        Setting
     *
     * @since       Jentil 0.1.0
     * @access      protected
     *
     * @return      \GrottoPress\Jentil\Utilities\Mod\Posts     Posts mod
     */
    protected final function mod( $setting ) {
        return Utilities\Mods\Mods::instance()->posts( $setting, $this->content->get( 'mod_args' ) );
    }
}
