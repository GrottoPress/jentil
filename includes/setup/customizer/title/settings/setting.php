<?php

/**
 * Title customizer setting
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup\Customizer\Title\Settings;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\Jentil\Setup;

/**
 * Title customizer setting
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			jentil 0.1.0
 */
abstract class Setting extends Setup\Customizer\Setting {
    /**
     * Title section
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var     \GrottoPress\Jentil\Setup\Customizer\Title\Title     $title     Title section instance
     */
    protected $title;

    /**
     * Mod
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var     \GrottoPress\Jentil\Utilities\Mod\Title     $mod    Title mod
     */
    protected $mod;

    /**
     * Constructor
     *
     * @since       Jentil 0.1.0
     * @access      protected
     */
    protected function __construct( Setup\Customizer\Title\Title $title ) {
        $this->title = $title;

        $this->name = $this->mod->get( 'name' );

        $this->args = array(
            'default' => $this->mod->get( 'default' ),
            // 'transport' => 'postMessage',
            'sanitize_callback' => 'wp_kses_data',
        );

        $this->control = array(
            'section'   => $this->title->get( 'name' ),
            'label'     => esc_html__( 'Enter title', 'jentil' ),
            'type'      => 'text',
        );
    }
}