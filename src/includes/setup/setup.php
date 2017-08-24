<?php

/**
 * Setup
 *
 * @package GrottoPress\Jentil\Setup
 * @since 0.1.0
 *
 * @author GrottoPress (https://www.grottopress.com)
 * @author N Atta Kus Adusei (https://twitter.com/akadusei)
 */

declare ( strict_types = 1 );

namespace GrottoPress\Jentil\Setup;

if ( ! \defined( 'WPINC' ) ) {
    die;
}

use GrottoPress\Jentil\Jentil;

/**
 * Setup
 *
 * @since 0.1.0
 */
abstract class Setup {
    /**
     * Jentil
     *
     * @since 0.1.0
     * @access protected
     * 
     * @var GrottoPress\Jentil\Jentil $jentil Jentil.
     */
    protected $jentil;

    /**
     * Constructor
     * 
     * @var GrottoPress\Jentil\Jentil $jentil Jentil.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct( Jentil $jentil ) {
        $this->jentil = $jentil;
    }

    /**
     * Jentil
     *
     * @since 0.1.0
     * @access public
     *
     * @return GrottoPress\Jentil\Jentil Jentil.
     */
    public function jentil(): Jentil {
        return $this->jentil;
    }

    /**
     * Run setup
     *
     * @since 0.1.0
     * @access public
     */
    abstract public function run();
}
