<?php

/**
 * Abstract Theme Mod
 *
 * @package GrottoPress\Jentil\Utilities\Mods
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\Mods;

use GrottoPress\Getter\Getter;

/**
 * Abstract Theme Mod
 *
 * @since 0.1.0
 */
abstract class AbstractMod
{
    use Getter;

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
     * @access protected
     *
     * @return string Name.
     */
    final protected function getName(): string
    {
        return $this->name;
    }

    /**
     * Default
     *
     * @since 0.1.0
     * @access protected
     *
     * @return mixed Default.
     */
    final protected function getDefault()
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
