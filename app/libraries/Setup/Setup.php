<?php

/**
 * Setup
 *
 * @package GrottoPress\Jentil\Setup
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setup;

use GrottoPress\Jentil\Jentil;

/**
 * Setup
 *
 * @since 0.1.0
 */
abstract class Setup
{
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
     * @param GrottoPress\Jentil\Jentil $jentil Jentil.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct(Jentil $jentil)
    {
        $this->jentil = $jentil;
    }

    /**
     * Jentil
     *
     * @since 0.1.0
     * @access public
     *
     * @return Jentil Jentil.
     */
    public function jentil(): Jentil
    {
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
