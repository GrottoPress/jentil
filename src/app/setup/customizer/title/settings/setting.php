<?php

/**
 * Setting
 *
 * @package GrottoPress\Jentil\Setup\Customizer\Title\Settings
 * @since 0.1.0
 *
 * @author GrottoPress (https://www.grottopress.com)
 * @author N Atta Kus Adusei (https://twitter.com/akadusei)
 */

declare ( strict_types = 1 );

namespace GrottoPress\Jentil\Setup\Customizer\Title\Settings;

if ( ! \defined( 'WPINC' ) ) {
    die;
}

use GrottoPress\Jentil\Setup\Customizer\Title\Title;
use GrottoPress\Jentil\Setup\Customizer\Setting as C_Setting;

/**
 * Setting
 *
 * @since 0.1.0
 */
abstract class Setting extends C_Setting {
    /**
     * Title section
     *
     * @since 0.1.0
     * @access protected
     * 
     * @var GrottoPress\Jentil\Setup\Customizer\Title\Title $title Title section.
     */
    protected $title;

    /**
     * Mod
     *
     * @since 0.1.0
     * @access protected
     * 
     * @var GrottoPress\Jentil\Utilities\Mods\Title $mod Mod.
     */
    protected $mod;

    /**
     * Constructor
     * 
     * @var GrottoPress\Jentil\Setup\Customizer\Title\Title $title Title section.
     *
     * @since       Jentil 0.1.0
     * @access      protected
     */
    protected function __construct( Title $title ) {
        $this->title = $title;

        // $this->args['transport'] = 'postMessage';
        $this->arg['sanitize_callback'] = 'wp_kses_data';

        $this->control['section'] = $this->title->name();
        $this->control['label'] = \esc_html__( 'Enter title', 'jentil' );
        $this->control['type'] = 'text';
    }
}
