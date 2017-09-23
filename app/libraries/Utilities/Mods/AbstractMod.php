<?php

/**
 * Theme Mod
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
 * Theme Mod
 *
 * @since 0.1.0
 */
abstract class AbstractMod
{
    /**
     * Mods
     *
     * @since 0.1.0
     * @access protected
     *
     * @var Mods $mods Mods.
     */
    protected $mods;

    /**
     * Name
     *
     * @since 0.1.0
     * @access protected
     *
     * @var string $name Mod name
     */
    protected $name;

    /**
     * Default
     *
     * @since 0.1.0
     * @access protected
     *
     * @var mixed $default Default value.
     */
    protected $default;

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
        $this->mods = $mods;
    }

    /**
     * Name
     *
     * @since 0.1.0
     * @access public
     *
     * @return string Name.
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * Default
     *
     * @since 0.1.0
     * @access public
     *
     * @return mixed Default.
     */
    public function default()
    {
        return $this->default;
    }

    /**
     * Get mod
     *
     * @since 0.1.0
     * @access public
     *
     * @return mixed Mod.
     */
    public function get()
    {
        if (!$this->name) {
            return false;
        }

        return \get_theme_mod($this->name, $this->default);
    }
}
