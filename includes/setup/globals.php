<?php

/**
 * Globals
 *
 * Set global variables
 *
 * @since			Jentil 0.1.0
 *
 * @package			jentil
 * @subpackage		jentil/includes/setup
 */

namespace GrottoPress\Jentil\Setup;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\MagPack;
use GrottoPress\Jentil\Utilities;

/**
 * Globals
 *
 * Set global variables
 *
 * @package			jentil
 * @subpackage		jentil/includes/setup
 * @author			N Atta Kusi Adusei
 */
final class Globals extends MagPack\Utilities\Wizard {
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
     * Set global template variable
     *
     * This is required, as some functions, templates
     * may call `global $jentil_template`
     *
     * @since       Jentil 0.1.0
     * @access      public
     * 
     * @action      init
     */
    public function template() {
        if (
            isset( $GLOBALS['jentil_template'] )
            && ( $GLOBALS['jentil_template'] instanceof \GrottoPress\Jentil\Utilities\Template\Template )
        ) {
            return;
        }

        $GLOBALS['jentil_template'] = new Utilities\Template\Template();
    }
}