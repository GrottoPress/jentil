<?php

/**
 * Logo
 *
 * @package GrottoPress\Jentil\Utilities\Mods
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\Mods;

/**
 * Logo
 *
 * @since 0.1.0
 */
final class Logo extends Mod
{
    /**
     * Constructor
     *
     * @param Mods $mods
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct(Mods $mods)
    {
        $this->name = 'logo';
        $this->default = '';

        parent::__construct($mods);
    }

    /**
     * Get mod
     *
     * @since 0.1.0
     * @access public
     *
     * @return int Logo mod.
     */
    public function get(): int
    {
        return \absint(parent::get());
    }
}
