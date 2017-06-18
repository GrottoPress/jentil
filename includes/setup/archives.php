<?php

/**
 * Archive Setup
 *
 * @link            https://jentil.grotttopress.com
 * @package		    jentil
 * @subpackage 	    jentil/includes
 * @since		    Jentil 0.1.0
 */

namespace GrottoPress\Jentil\Setup;

if ( ! defined( 'WPINC' ) ) {
    wp_die( esc_html__( 'Do not load this file directly!', 'jentil' ) );
}

use GrottoPress\MagPack;

/**
 * Archive Setup
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @subpackage 	    jentil/includes
 * @since			jentil 0.1.0
 */
final class Archives extends MagPack\Utilities\Singleton {
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
	 * @since       MagPack 0.1.0
	 * @access      public
	 */
	protected function __construct( Jentil $jentil ) {
        $this->jentil = $jentil;
    }

    /**
     * Description
     *
     * @since       Jentil 0.1.0
     * @access      public
     *
     * @action      jentil_before_content
     */
    public function description() {
        global $jentil_template;

        if ( ! ( $description = $jentil_template->description() ) ) {
            return;
        }

        echo '<div class="archive-description p entry-summary" itemprop="description">'
            . $description
        . '</div>';
    }
}