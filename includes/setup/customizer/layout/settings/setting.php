<?php

/**
 * Layout customizer setting
 *
 * The template for all layout customizer setting classes.
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup\Customizer\Layout\Settings;

if ( ! defined( 'WPINC' ) ) {
    die;
}

use GrottoPress\Jentil\Setup;
use GrottoPress\Jentil\Utilities;

/**
 * Layout customizer setting
 *
 * The template for all layout customizer setting classes.
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			jentil 0.1.0
 */
abstract class Setting extends Setup\Customizer\Setting {
    /**
     * Layout section
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var     \GrottoPress\Jentil\Setup\Customizer\Layout\Layout     $layout     Layout section instance
     */
    protected $layout;

    /**
     * Mod
     *
     * @since       Jentil 0.1.0
     * @access      protected
     * 
     * @var     \GrottoPress\Jentil\Utilities\Mod\Layout     $mod    Layout mod
     */
    protected $mod;

    /**
     * Constructor
     *
     * @since       Jentil 0.1.0
     * @access      protected
     */
    protected function __construct( Setup\Customizer\Layout\Layout $layout ) {
        $this->layout = $layout;

        $this->name = $this->mod->get( 'name' );

        $this->args = [
            'default'           => $this->mod->get( 'default' ),
            'sanitize_callback' => 'sanitize_title',
        ];

        $this->control = [
            'section'   => $this->layout->get( 'name' ),
            'label'     => esc_html__( 'Select layout', 'jentil' ),
            'type'      => 'select',
            'choices'   => Utilities\Template\Template::instance()->get( 'layout' )->layouts_ids_names(),
        ];
    }
}