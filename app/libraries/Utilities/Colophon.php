<?php

/**
 * Colophon
 *
 * @package GrottoPress\Jentil\Utilities
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities;

use GrottoPress\Jentil\Utilities\Mods\Colophon as ColophonMod;

/**
 * Colophon
 *
 * @since 0.1.0
 */
final class Colophon
{
    /**
     * Utilities
     *
     * @since 0.1.0
     * @access private
     *
     * @var Utilities
     */
    private $utilities;

    /**
     * Constructor
     *
     * @param Utilities $utilities
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct(Utilities $utilities)
    {
        $this->utilities = $utilities;
    }

    /**
     * Get colophon mod
     *
     * @since 0.1.0
     * @access public
     *
     * @return string Colophon mod.
     */
    public function mod(): ColophonMod
    {
        return $this->utilities->mods->colophon;
    }
}
