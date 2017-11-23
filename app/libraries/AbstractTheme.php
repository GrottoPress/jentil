<?php

/**
 * Abstract Theme
 *
 * @package GrottoPress\Jentil
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil;

use GrottoPress\Jentil\Utilities\Utilities;
use GrottoPress\Getter\Getter;
use FlorianWolters\Component\Util\Singleton\SingletonTrait;

/**
 * Abstract Theme
 *
 * @since 0.1.0
 */
abstract class AbstractTheme
{
    use SingletonTrait, Getter;

    /**
     * Theme setups
     *
     * @since 0.1.0
     * @access protected
     *
     * @var Setup\AbstractSetup[] $setup Setups.
     */
    protected $setup = [];

    /**
     * Constructor
     *
     * @since 0.1.0
     * @access protected
     */
    protected function __construct()
    {
    }

    /**
     * Setup
     *
     * @since 0.1.0
     * @access protected
     *
     * @return Setup\AbstractSetup[]
     */
    protected function getSetup(): array
    {
        return $this->setup;
    }

    /**
     * Run theme
     *
     * @since 0.1.0
     * @access public
     */
    public function run()
    {
        foreach ($this->setup as $setup) {
            $setup->run();
        }
    }
}
