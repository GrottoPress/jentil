<?php

/**
 * Settings
 *
 * @package GrottoPress\Jentil\Setup\Customizer\Posts\Settings
 * @since 0.1.0
 *
 * @author GrottoPress (https://www.grottopress.com)
 * @author N Atta Kus Adusei (https://twitter.com/akadusei)
 */

declare ( strict_types = 1 );

namespace GrottoPress\Jentil\Setup\Customizer\Posts\Settings;

if ( ! \defined( 'WPINC' ) ) {
    die;
}

use GrottoPress\Jentil\Setup\Customizer\Setting as C_Setting;
use GrottoPress\Jentil\Setup\Customizer\Posts\Section;
use GrottoPress\Jentil\Utilities\Mods\Posts as Mod;

/**
 * Settings
 *
 * @since 0.1.0
 */
abstract class Setting extends C_Setting {
    /**
     * Section
     *
     * @since 0.1.0
     * @access protected
     * 
     * @var \GrottoPress\Jentil\Setup\Customizer\Posts\Section $section Section.
     */
    protected $section;

    /**
     * Mod
     *
     * @since 0.1.0
     * @access protected
     * 
     * @var \GrottoPress\Jentil\Utilities\Mods\Posts $mod Mod.
     */
    // protected $mod;
    
    /**
     * Constructor
     *
     * @var GrottoPress\Jentil\Setup\Customizer\Posts\Section $section Section.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct( Section $section ) {
        $this->section = $section;

        $this->control['section'] = $this->section->name();
    }

    /**
     * Get mod
     *
     * @var string $setting Mod setting.
     *
     * @since 0.1.0
     * @access protected
     *
     * @return GrottoPress\Jentil\Utilities\Mods\Posts Posts mod.
     */
    final protected function mod( string $setting ): Mod {
        return $this->section->posts()->customizer()->jentil()->utilities()->mods()->posts( $setting, $this->section->mod_args() );
    }
}
